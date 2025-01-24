<?php

$directory = ROOT . "API/functions/";
$_detectedFunctions = [];
$_functionsNames = [];
$_loadedFunctions = [];

if (is_dir($directory)) {
    $scan = scandir($directory);
    foreach ($scan as $file) {
        $filepath = realpath($directory . $file);
        if (file_exists($filepath) && str_starts_with($file, "_") && str_ends_with($file, ".php")) {
            $functionName = substr($file, 1);
            $_functionsNames[] = (string)$functionName;
            $_detectedFunctions[$functionName] = (string)$filepath;

        }
    }
}

function _loadFunction($name): bool
{
    global $_detectedFunctions;
    global $_loadedFunctions;
    global $_functionsNames;
    if (in_array($name, $_functionsNames, true) && !in_array($name, $_loadedFunctions, true)) {
        $_loadedFunctions[] = (string)$name;
        include_once $_detectedFunctions[$name];
        return true;
    }
    return false;
}

function _loadAllFunctions(): void
{
    global $_detectedFunctions;
    global $_loadedFunctions;
    foreach ($_detectedFunctions as $name => $filepath) {
        if (file_exists($filepath)) {
            $_loadedFunctions[] = (string)$name;
            include_once($filepath);
        }
    }
}