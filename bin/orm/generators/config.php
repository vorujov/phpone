<?php 
/**
 * Generate main ORM configuration file i.e. propel.yml
 *
 * @author Vusal Orujov <vusal@orujov.info>
 */

include __DIR__ .'/../bootstrap.php';

if (!file_exists(__DIR__ . "/../output/propel.yml")) {
    if (!file_exists(__DIR__ . "/../propel.yml.dist")) {
        echo "Couldn't find configuration sample file.";
        exit;
    }

    $content = file_get_contents(__DIR__ . "/../propel.yml.dist");
    echo "Configuration file doesn't exist. Include following information to create one. \n";

    echo "Database host name \e[1;36m[127.0.0.1]\e[0m: ";
    $db_host = trim(fgets(STDIN)) ?: "127.0.0.1";
    $content = str_replace("DB_HOST", $db_host, $content);

    echo "Database name: ";
    $db_name = trim(fgets(STDIN));
    while (!$db_name) {
        echo "Database name: ";
        $db_name = trim(fgets(STDIN));
    }
    $content = str_replace("DB_NAME", $db_name, $content);

    echo "Database user \e[1;36m[root]\e[0m: ";
    $db_user = trim(fgets(STDIN)) ?: "root";
    $content = str_replace("DB_USER", $db_user, $content);

    echo "Database password: ";
    $db_pass = trim(fgets(STDIN));
    $content = str_replace("DB_PASS", $db_pass, $content);

    if (!file_exists(__DIR__ . "/../output/")) {
        mkdir(__DIR__ . "/../output/");
    }

    file_put_contents(__DIR__ . "/../output/propel.yml", $content);
}
