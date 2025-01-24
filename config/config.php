<?php

include_once "/home/u436203203/Global/superglobals.php";
if(!defined("dbuser")){
    require_once "local.config.php";
}


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include_once ROOT . "/vendor/autoload.php";
require_once ROOT . "/config/fichas/limites.php";//Limites e Variaveis
require_once ROOT . "/config/functions/functions_fichas.php";//Functions Relacionadas a Fichas e afins
require_once ROOT . "/config/functions/functions_sistema.php";//Functions Relacionadas ao Modo de operar e afins
require_once ROOT . "/config/functions/functions_components.php";//Functions Relacionadas ao Modo de operar e afins


/*

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
*/



if (!defined('RootDir')) {
	define("RootDir", ROOT);
}