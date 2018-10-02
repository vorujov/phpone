<?php 
require_once APP_PATH . "/core/Autoloader.php";

// instantiate the loader
$loader = new Core\Autoloader;

// register the autoloader
$loader->register();

// register namespaces to autoload
$loader->addNamespace('Core', APP_PATH . "/core");
$loader->addNamespace('Utilities', APP_PATH . "/utilities");
$loader->addNamespace('Controllers', APP_PATH . "/controllers");
$loader->addNamespace('Models', APP_PATH . "/models");

require_once APP_PATH . "/vendor/autoload.php";
