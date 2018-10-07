<?php 
/**
 * Generate SQl file according to the database schema (schema.xml)
 *
 * @author Vusal Orujov <vusal@orujov.info>
 */

include __DIR__ .'/../bootstrap.php';

$_SERVER['argv'] = [
    'propel',
    'sql:build',
    '--config-dir=' . __DIR__ . '/../output',
    '--schema-dir=' . __DIR__ . '/../output',
    '--output-dir=' . __DIR__ . '/../output',
    '--overwrite'
];
include APP_PATH . "/vendor/propel/propel/bin/propel";
