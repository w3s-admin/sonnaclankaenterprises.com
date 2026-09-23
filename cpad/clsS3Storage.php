<?php

require_once __DIR__ . '/bootstrap.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

/**
 * Thin wrapper around the AWS SDK S3 client. All credentials/config come
 * from environment variables (.env locally, real env vars in production) -
 * never hardcoded here. See .env.example for the required keys.
 *
 * Every key uploaded through this class is namespaced under
 * AWS_STORAGE_FOLDER/<subfolder>/... so this bucket can safely be shared
 * across multiple projects without collisions.
 */
class S3Storage {

    private static $client = null;

    public static function isConfigured() {
        return getenv('AWS_ACCESS_KEY_ID') && getenv('AWS_SECRET_ACCESS_KEY') && getenv('AWS_BUCKET');
    }

    private static function client() {
        if (self::$client === null) {
            self::$client = new S3Client([
                'version'                 => 'latest',
                'region'                  => getenv('AWS_DEFAULT_REGION') ?: 'ap-southeast-1',
                'use_path_style_endpoint' => filter_var(getenv('AWS_USE_PATH_STYLE_ENDPOINT'), FILTER_VALIDATE_BOOLEAN),
                'credentials'             => [
                    'key'    => getenv('AWS_ACCESS_KEY_ID'),
                    'secret' => getenv('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);
        }
        return self::$client;
    }

    /**
     * Uploads a local file to S3 under <project folder>/<subfolder>/<filename>
     * and returns the public URL on success, or null on failure (never
     * throws - callers already have local-upload error handling to fall
     * back on).
     *
     * @param string $localPath   Path to the file already on local disk
     * @param string $subfolder   e.g. 'vehicles', 'reviews', 'avatars', 'documents'
     * @param string $filename    Destination filename (should already be
     *                            sanitized/unique - see HTTP_Upload.php)
     * @param string $contentType MIME type, e.g. 'image/jpeg'
     */
    public static function upload($localPath, $subfolder, $filename, $contentType = null) {
        if (!self::isConfigured() || !is_file($localPath)) {
            return null;
        }

        $project = trim(getenv('AWS_STORAGE_FOLDER') ?: 'default', '/');
        $key = $project . '/' . trim($subfolder, '/') . '/' . ltrim($filename, '/');

        try {
            $args = [
                'Bucket'     => getenv('AWS_BUCKET'),
                'Key'        => $key,
                'SourceFile' => $localPath,
            ];
            if ($contentType) {
                $args['ContentType'] = $contentType;
            }
            self::client()->putObject($args);
            return self::buildUrl($key);
        } catch (S3Exception $e) {
            error_log('S3 upload failed for ' . $key . ': ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Uploads like upload(), but returns the result pre-split into a
     * ['path' => ..., 'name' => ...] pair matching this app's existing
     * mpath/tpath + image_name DB columns (path ends in "/", name is just
     * the filename) - so a caller that already does
     * `$row['mpath'] . $row['image_name']` to build a URL needs zero
     * changes to work with S3-backed rows too. Returns null on failure.
     */
    public static function uploadSplit($localPath, $subfolder, $filename, $contentType = null) {
        $url = self::upload($localPath, $subfolder, $filename, $contentType);
        if ($url === null) {
            return null;
        }
        $project = trim(getenv('AWS_STORAGE_FOLDER') ?: 'default', '/');
        return [
            'path' => 's3-image.php?key=' . $project . '/' . trim($subfolder, '/') . '/',
            'name' => $filename,
        ];
    }

    /**
     * Deletes an object given its full public URL (as returned by upload()),
     * silently doing nothing if it isn't actually an S3 URL from this bucket.
     */
    public static function deleteByUrl($url) {
        if (!self::isConfigured() || empty($url)) {
            return false;
        }
        $key = self::keyFromUrl($url);
        if ($key === null) {
            return false;
        }
        try {
            self::client()->deleteObject([
                'Bucket' => getenv('AWS_BUCKET'),
                'Key'    => $key,
            ]);
            return true;
        } catch (S3Exception $e) {
            error_log('S3 delete failed for ' . $key . ': ' . $e->getMessage());
            return false;
        }
    }

    /**
     * The bucket has Block Public Access enabled (a deliberate account-level
     * security setting on this shared bucket) and ACLs disabled, so objects
     * are NOT directly reachable over HTTP - every "URL" this class hands
     * out instead points at s3-image.php, which fetches the object
     * server-side (using these same credentials, which do have read access)
     * and streams it out. Swap this for a direct S3/CloudFront URL later if
     * the bucket's public-access settings ever change.
     */
    private static function buildUrl($key) {
        return 's3-image.php?key=' . $key;
    }

    /**
     * Streams an object's bytes + content-type straight from S3. Used by
     * s3-image.php; not for large files (loads fully into memory - fine for
     * the images/documents this app handles).
     */
    public static function getObject($key) {
        if (!self::isConfigured()) {
            return null;
        }
        try {
            $result = self::client()->getObject([
                'Bucket' => getenv('AWS_BUCKET'),
                'Key'    => $key,
            ]);
            return [
                'body'         => (string) $result['Body'],
                'content_type' => $result['ContentType'] ?? 'application/octet-stream',
            ];
        } catch (S3Exception $e) {
            return null;
        }
    }

    /**
     * Pulls the S3 key back out of a URL previously returned by upload()
     * (an "s3-image.php?key=..." link - see buildUrl()).
     */
    private static function keyFromUrl($url) {
        $marker = 's3-image.php?key=';
        $pos = strpos($url, $marker);
        if ($pos === false) {
            return null;
        }
        $key = substr($url, $pos + strlen($marker));
        // Strip anything after the key (e.g. a stray query fragment) and
        // reject an empty/traversal-looking key defensively.
        $key = strtok($key, '&');
        if ($key === false || $key === '' || strpos($key, '..') !== false) {
            return null;
        }
        return $key;
    }

}
