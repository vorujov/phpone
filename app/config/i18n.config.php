<?php 
/**
 * Internationalization related configurations.
 * Used to define available languages, default language etc.
 */

use \Core\Config;

// Available languages
$langs = [];

// English
$langs[] = [
    "code" => "en-US",
    "shortcode" => "en",
    "name" => "English",
    "localname" => "English"
];

Config::set("i18n.langs", $langs);
Config::set("i18n.default", "en-US");
