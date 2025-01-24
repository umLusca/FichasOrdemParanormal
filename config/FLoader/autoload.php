<?php
$directory = dir(__FILE__).DIRECTORY_SEPARATOR;
$_loadedFunctions = [];


if (is_dir($directory)) {
	$scan = scandir($directory);
	foreach ($scan as $file) {
		$filepath = realpath($directory . $file);
		if (file_exists($filepath) && str_starts_with($file, "_") && str_ends_with($file, ".php")) {
			$functionName = substr($file, 1,-4);
			$_functionsNames[] = (string)$functionName;
			$_detectedFunctions[$functionName] = (string)$filepath;
			
		}
	}
}

foreach ($_detectedFunctions as $name => $filepath) {
	if (file_exists($filepath)) {
		$_loadedFunctions[] = (string)$name;
		include_once($filepath);
	}
}