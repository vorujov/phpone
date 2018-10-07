<?php 
/**
 * Generates database configuration file. 
 * Generated code will be used in \Core\App::db();
 * 
 * @author Vusal Orujov <vusal@orujov.info>
 */

include __DIR__ .'/../bootstrap.php';

$_SERVER['argv'] = [
    'propel',
    'config:convert',
    '--config-dir=' . __DIR__ . '/../output',
    '--output-dir=' . __DIR__ . '/../output',
];
include APP_PATH . "/vendor/propel/propel/bin/propel";
