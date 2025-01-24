<?php
define("ROOT",dirname(__FILE__).DIRECTORY_SEPARATOR);
ini_set('display_startup_errors', true);
ini_set('display_errors', true);
ini_set("error_reporting", E_ERROR | E_PARSE | E_COMPILE_ERROR | E_STRICT);
ini_set("uploadMaxFilesize", "512K");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Authorization, Origin');
header('Access-Control-Allow-Methods:  POST, PUT, GET');


setlocale(LC_COLLATE, 'pt-BR.utf8');
date_default_timezone_set('America/Manaus');


$url = mb_strtolower($_SERVER['HTTP_HOST']);
[$sub] = explode('.', $url);


require_once ROOT . "/config/config.php";


if (!isset($_SESSION)) session_start();
if (!isset($_SESSION["UserID"]) && isset($_COOKIE["remember_me"])) {
	$token = filter_input(INPUT_COOKIE, 'remember_me')?:"";
	logar(check_session($token));
}

try {

	$curPath = $_SERVER['REDIRECT_URL'];
	$folders = array_values(array_filter(explode("/", $curPath)));


	$file = "";
	$startSession = true;

	$_PATH = $folders;
	switch ($pag = mb_strtolower($folders[0])) {
		default:
			header("X-Robots-Tag: none");
			$file = '/paginas/error/index.php';
			break;
		case "":

			header("X-Robots-Tag: all");
			$file = "/paginas/inicio/index.php";
			break;
		case "painel":
			$file = "/paginas/painel/index.php";
			break;
		case "ficha":
			$token = cleanstring($folders[1]);
			$file = "/paginas/ficha/index.php";
			break;
		case "mestre":
			$token = cleanstring($folders[1]);

			$file = "/paginas/mestre/index.php";
			break;
		case "encerrar":
		case "logout":
			logout();
			header("X-Robots-Tag: none");

			header("Location: /");
			break;
		case "api":
			header("X-Robots-Tag: none");

			header('Content-Type: application/json');
			$startSession = false;
			$file = "/_api/index.php";
			break;
	}

	$startSession && session_start();

	$filepath = ROOT . $file;
	if (!file_exists($filepath) || !include $filepath) {
		require ROOT . '/paginas/error/index.php';
	}
	exit();
} catch (Exception $e) {
	if (empty($_GET["e"])) {
		header('Location: /?e=1');
	}
}
