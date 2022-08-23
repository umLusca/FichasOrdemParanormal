<?php
error_reporting(E_ERROR | E_PARSE);
ini_set('display_startup_errors', true);
ini_set('display_errors', true);
session_save_path("/tmp");
session_start();

header('Access-Control-Allow-Origin: https://fichasop.com', false);
require_once "config.php";
$con = con();



require_once RootDir."config/fichas/limites.php";//Limites e Variaveis
require_once RootDir."config/functions/functions_fichas.php";//Functions Relacionadas a Fichas e afins
require_once RootDir."config/functions/functions_sistema.php";//Functions Relacionadas ao Modo de operar e afins
//require_once RootDir.'vendor/autoload.php';
require_once RootDir."conta/check.php";
is_user_logged_in();


