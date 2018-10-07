<?php 
/**
 * Make necessary adjustments in the schema file (schema.xml)
 *
 * @author Vusal Orujov <vusal@orujov.info>
 */

include __DIR__ .'/../bootstrap.php';

if (!file_exists(__DIR__ . "/../output/schema.xml")) {
    echo "Couldn't find schema.xml file.";
    exit;
}

$dom = new DOMDocument();
$dom->load(__DIR__ . "/../output/schema.xml");

$dbnode = $dom->firstChild;
$attr = $dom->createAttribute("identifierQuoting");
$attr->value = "true";
$dbnode->appendChild($attr);

foreach($dom->getElementsByTagName('table') as $e){
    if ($e->hasAttribute("namespace")) {
        $e->removeAttribute("namespace");
    }
}

$dom->save(__DIR__ . "/../output/schema.xml");
