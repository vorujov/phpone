<?php 
/**
 * Common configurations
 */

// Application version name
define("APP_VERSION", "1.0.0"); 

// Used for cache control
define("CACHE_CONTROL", base64_encode(str_replace(".", "", APP_VERSION))); 

// Default timezone
date_default_timezone_set("UTC"); 

// Default multibyte encoding
mb_internal_encoding("UTF-8"); 
