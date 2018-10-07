<?php 
/**
 * Generate data models (app/models)
 *
 * @author Vusal Orujov <vusal@orujov.info>
 */

include __DIR__ .'/../bootstrap.php';

$_SERVER['argv'] = [
    'propel',
    'model:build',
    '--config-dir=' . __DIR__ . '/../output',
    '--output-dir=' . __DIR__ . '/../../../app',
    '--schema-dir=' . __DIR__ . '/../output'
];
include APP_PATH . "/vendor/propel/propel/bin/propel";
