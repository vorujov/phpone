<?php 
/**
 * Used to extract translation strings from the files
 */

// Path to root directory
define("ROOT_PATH", __DIR__ . "/../..");

// Path to app directory.
define("APP_PATH", ROOT_PATH . "/app");

// Load libraries, configuration files and helpers
require_once APP_PATH . '/autoload.php';
require_once APP_PATH . '/config/config.php';
require_once APP_PATH . '/helpers/helpers.php';

function absPath($path) {
    $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
    $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
    $absolutes = array();

    foreach ($parts as $part) {
        if ('.' == $part) {
            continue;
        } 

        if ('..' == $part) {
            array_pop($absolutes);
        } else {
            $absolutes[] = $part;
        }
    }

    return ($path[0] == DIRECTORY_SEPARATOR ? DIRECTORY_SEPARATOR : "") 
        . implode(DIRECTORY_SEPARATOR, $absolutes);
}

function getDirContents($dir, &$results = array()){
    $files = scandir($dir);

    foreach($files as $key => $value){
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        if(!is_dir($path)) {
            $results[] = $path;
        } else if($value != "." && $value != "..") {
            getDirContents($path, $results);
            //$results[] = $path;
        }
    }

    return $results;
}



$location = false;
if (Core\Config::get("i18n.default")) {
    $default_location = absPath(APP_PATH . "/locale/" .  \Core\Config::get("i18n.default") . "/messages.po");
    echo "Save to default locale file \e[1;36m(" . $default_location . ")\e[0m [Y/N]? ";

    $input = strtoupper(trim(fgets(STDIN)));
    $loop = !in_array($input, ["Y", "N"]);
    while ($loop) {
        echo "Save to default locale file [Y/N]? ";

        $input = strtoupper(trim(fgets(STDIN)));
        $loop = !in_array($input, ["Y", "N"]);
    }
    
    if ($input == "Y") {
        $location = $default_location;
    }
}

if (!$location) {
    echo "Include the location of the output file \e[1;36m(in case of empty input, locales will be saved to messages.po file in the root directory of the app)\e[0m: ";
    
    $location = trim(fgets(STDIN));
    if (!$location) {
        $location = ROOT_PATH . "/messages.po";
    }
}

# Create directory
$dir = dirname($location);

if ($dir && !file_exists($dir)) {
    try {
        mkdir($dir, 0777, true);
    } catch (\Exception $e) {
        echo "Couldn't create directory to save the output file.";
        exit;
    }
}

try {
    file_put_contents($location, "");
} catch (\Exception $e) {
    echo "Couldn't create output file.";
    exit;
}

// Get translation strings
$translations = null;
$files = [];
$dirs = [
    APP_PATH . "/views",
    APP_PATH . "/controllers",
    APP_PATH . "/inc"
];

foreach ($dirs as $dir) {
    $files = array_merge($files, getDirContents($dir));
}

foreach ($files as $file) {
    $strings = Gettext\Translations::fromPhpCodeFile($file);

    if (is_null($translations)) {
        $translations = $strings;
    } else {
        $translations->mergeWith($strings);
    }
}

$translations->toPoFile($location);

echo "Done!\n";
exit;
