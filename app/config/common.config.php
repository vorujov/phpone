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

// Random salt to be used in various areas.
// Since this value might be changed manually in the future,
// don't use this salt to encode the data to save them permanently 
// in database (or somewhere else)
define("APP_SALT", "INSERT_RANDOM_STRING_HERE");
