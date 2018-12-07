<?php
// Start session
session_start();

/**
 * Define ENVIRONMENT. Affects error reporting
 * Possible values: development | production
 */
define("ENVIRONMENT", "development");

// Domain name. If the server configured correctly, then it will be defined 
// automatically. Set the value manually in case of incorrect configuration.
// The value shouldn't include protocol, trailing slashes or 
// subdirectories. Just the name of the domain. Ex: example.com
define("DOMAIN", $_SERVER["SERVER_NAME"]);

// Check if SSL enabled. 
// Manually set the value of SSL_ENABLED to the true in case of use of fake SSL 
// certificates such as Cloudflare's SSL
$ssl_enabled = isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] && $_SERVER["HTTPS"] != "off";
define("SSL_ENABLED", $ssl_enabled);


// It's not recommended to make any changes 
// in the rest of this file.


// Domain URL
define("DOMAIN_URL",  (SSL_ENABLED ? "https" : "http") . "://" . DOMAIN);

// URL of the application root. 
$app_url = DOMAIN_URL
         . (dirname($_SERVER["SCRIPT_NAME"]) == DIRECTORY_SEPARATOR ? "" : "/")
         . trim(str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"])), "/");
define("APP_URL", $app_url);

// Path to root directory
define("ROOT_PATH", __DIR__);

// Path to app directory.
define("APP_PATH", ROOT_PATH . "/app");

// Set error reporting according to the ENVIRONMENT
error_reporting(E_ALL);
if (ENVIRONMENT == "development") {
    // Display errors in development environment
    ini_set('display_errors', 1);
} else if (ENVIRONMENT == "production") {
    // Hide errors in production environment
    ini_set('display_errors', 0);
} else {
    // Unknown ENVIRONMENT. 
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo 'Service Unavailable: invalid_environment';
    exit;
}

// Load libraries, configuration files and helpers
require_once APP_PATH . '/autoload.php';
require_once APP_PATH . '/config/config.php';
require_once APP_PATH . '/helpers/helpers.php';

// Run the app...
$App = new Core\App;
$App->run();
