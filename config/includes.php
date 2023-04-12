<?php

session_start();
require_once "config.php";
$con = con();

if(is_updating){
	header("Location: /error/?error=0314");
}

include_once RootDir."vendor/autoload.php";
require_once RootDir."config/fichas/limites.php";//Limites e Variaveis
require_once RootDir."config/functions/functions_fichas.php";//Functions Relacionadas a Fichas e afins
require_once RootDir."config/functions/functions_sistema.php";//Functions Relacionadas ao Modo de operar e afins
require_once RootDir."config/functions/functions_components.php";//Functions Relacionadas ao Modo de operar e afins

if(!$app){
	require_once RootDir."config/Querys.php";
}

if(!isset($_SESSION["UserID"])){
	$token = filter_input(INPUT_COOKIE, 'remember_me');
	logar(check_session($token));
}

$gclient = new Google_Client();


$clientID = '209829554208-1d5agmucudbmmbu9c5r4pjcggpg1t975.apps.googleusercontent.com';
$secret = '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';


// Set the ClientID
$gclient->setClientId($clientID);
// Set the ClientSecret
$gclient->setClientSecret($secret);
// Set the Redirect URL after successful Login
$gclient->setRedirectUri('https://fichasop.com/conta/google/');

// Adding the Scopr
$gclient->addScope('email');
$gclient->addScope('profile');


