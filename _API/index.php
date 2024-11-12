<?php


array_shift($folders);
$return = [
	'status' => 404,
	'msg'    => 'Requisição não encontrada, contate o suporte'
];

try {

	if (!empty($folders)) {

		$rootDir =  dirname(__FILE__);
		$dir = "";

		for ($i = 0; $i < count($folders); $i++) {
			$folder = mb_strtolower($folders[$i]);
			if (is_dir($rootDir . $dir . DIRECTORY_SEPARATOR . $folder)) {
				$dir = $dir . DIRECTORY_SEPARATOR . $folder;
			} else
				if (file_exists($rootDir . $dir . DIRECTORY_SEPARATOR . $folder . ".php")) {
					$dir = $dir . DIRECTORY_SEPARATOR . $folder . '.php';
					require($rootDir.$dir);
					break;
				}
		}

		if (file_exists($dir . DIRECTORY_SEPARATOR . "index.php")) {
			$dir = $dir . DIRECTORY_SEPARATOR . "index.php";
			if (!empty($dir)) require($rootDir.$dir);
		}
	}
} catch (Exception|Throwable $e) {
	$return['status'] = 500;
	$return["msg"] = $e->getMessage();
	$return["error"] = [
		"code" => $e->getCode(),
		"message" => $e->getMessage(),
		"line" => $e->getLine(),
		"file" => $e->getFile()
		
	];
} finally {
	notFound:
	session_write_close();
	header('Content-Type: application/json');
	http_response_code($return['status']);
	echo json_encode($return, JSON_THROW_ON_ERROR);
	exit($return['status']);

}