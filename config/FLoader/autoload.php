<?php
$directory = ROOT."API/functions/";
$_loadedFunctions = [];
if (is_dir($directory)) {
    $scan = scandir($directory);
    foreach ($scan as $file) {
        $filepath = realpath($directory.$file);
        if (file_exists($filepath) && str_starts_with($file, "_") && str_ends_with($file, ".php")) {
            $_loadedFunctions[] = (string) $file;
            include_once($directory . $file);
        }
    }
}