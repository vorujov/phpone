<?php 
/**
 * Used to generate data models
 */

// Generate DB schema
passthru("php " . __DIR__ . "/generators/config.php");
passthru("php " . __DIR__ . "/generators/schema.php");
passthru("php " . __DIR__ . "/generators/schema-opt.php");
passthru("php " . __DIR__ . "/generators/dbconfig.php");
passthru("php " . __DIR__ . "/generators/sql.php");
passthru("php " . __DIR__ . "/generators/models.php");
