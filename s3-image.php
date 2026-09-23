<?php
// Public image/document proxy: the S3 bucket has Block Public Access
// enabled (see cpad/clsS3Storage.php), so objects aren't reachable directly
// - this fetches them server-side and streams them out instead.

require_once 'cpad/clsCommonBase.php';
require_once 'cpad/clsS3Storage.php';

$key = isset($_GET['key']) ? $_GET['key'] : '';

// Only ever serve keys under this project's own folder, and refuse any
// path-traversal-looking value - this endpoint must not become a way to
// fetch arbitrary objects elsewhere in the (shared) bucket.
$projectFolder = trim(getenv('AWS_STORAGE_FOLDER') ?: '', '/');
if ($key === '' || strpos($key, '..') !== false || $projectFolder === '' || strpos($key, $projectFolder . '/') !== 0) {
    http_response_code(404);
    exit;
}

$object = S3Storage::getObject($key);
if ($object === null) {
    http_response_code(404);
    exit;
}

header('Content-Type: ' . $object['content_type']);
header('Content-Length: ' . strlen($object['body']));
// These are content-addressed-ish (unique filenames per upload, never
// edited in place) so a long, aggressive cache is safe.
header('Cache-Control: public, max-age=604800, immutable');
echo $object['body'];
