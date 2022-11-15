<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
require_once "config.php";
$con = con();
if(isset($_POST["tc"])){
	$_SESSION["tc"] = true;
}//todo remove 25/09


require_once RootDir."config/fichas/limites.php";//Limites e Variaveis
require_once RootDir."config/functions/functions_fichas.php";//Functions Relacionadas a Fichas e afins
require_once RootDir."config/functions/functions_sistema.php";//Functions Relacionadas ao Modo de operar e afins

require_once RootDir."conta/check.php";
is_user_logged_in();


