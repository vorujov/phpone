<?php 
use Core\App;
use Core\Config;

// Language slug
$langs = [];
foreach (Config::get("i18n.langs") as $l) {
    if (!in_array($l["code"], $langs)) {
        $langs[] = $l["code"];
    }

    if (!in_array($l["shortcode"], $langs)) {
        $langs[] = $l["shortcode"];
    }
}
$langslug = $langs ? "[".implode("|", $langs).":lang]" : "";

// Index 
App::addRoute("GET|POST", "/", "Index");
App::addRoute("GET|POST", "/".$langslug."?/?", "Index");
