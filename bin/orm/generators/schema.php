<?php 
/**
 * Generate database schema (reverse engineering)
 *
 * @author Vusal Orujov <vusal@orujov.info>
 */

include __DIR__ .'/../bootstrap.php';

$_SERVER['argv'] = [
    'propel',
    'database:reverse',
    '--config-dir=' . __DIR__ . '/../output',
    '--output-dir=' . __DIR__ . '/../output',
    '--namespace=Models'
];
include APP_PATH . "/vendor/propel/propel/bin/propel";
