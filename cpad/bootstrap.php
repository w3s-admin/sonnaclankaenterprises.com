<?php
// Loads Composer's autoloader (AWS SDK, phpdotenv) and the .env file, once.
// require_once this from anywhere that needs getenv() to see .env values or
// needs an AWS SDK / other Composer-installed class.
//
// Deliberately tolerant of `vendor/` not existing yet (a fresh clone before
// `composer install` has run): the DB layer (cpad/ControlPadDB.php) still
// works via its getenv() fallback defaults either way, it just won't have
// .env overrides or S3 support until dependencies are installed.

if (!defined('APP_ENV_LOADED')) {
    define('APP_ENV_LOADED', true);

    $__autoload = __DIR__ . '/../vendor/autoload.php';
    if (file_exists($__autoload)) {
        require_once $__autoload;

        if (file_exists(__DIR__ . '/../.env') && class_exists('Dotenv\\Dotenv')) {
            $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
            $loaded = $dotenv->safeLoad();
            // phpdotenv v5 populates $_ENV but not the actual process
            // environment by default, so plain getenv() (used throughout
            // this codebase, e.g. cpad/ControlPadDB.php) wouldn't see it.
            foreach ($loaded as $key => $value) {
                if (getenv($key) === false) {
                    putenv("$key=$value");
                }
            }
        }
    }
    unset($__autoload);
}
