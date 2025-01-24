<?php

include_once "/home/u436203203/Global/superglobals.php";
if(!defined("dbuser")){
    require_once "local.config.php";
}


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include_once ROOT . "vendor/autoload.php";
require_once ROOT . "config/fichas/limites.php";//Limites e Variaveis
require_once ROOT . "config/functions/functions_fichas.php";//Functions Relacionadas a Fichas e afins
require_once ROOT . "config/functions/functions_sistema.php";//Functions Relacionadas ao Modo de operar e afins
require_once ROOT . "config/functions/functions_components.php";//Functions Relacionadas ao Modo de operar e afins


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


function TempoDecorrido ($time)
{
	
	$time = time() - $time; // to get the time since that momenty
	$time = ($time<1)? 1 : $time;
	$tokens = array (
		31536000 => 'ano|anos',
		2592000 => 'mês|meses',
		604800 => 'semana|semanas',
		86400 => 'dia|dias',
		3600 => 'hora|horas',
		60 => 'minuto|minutos',
		1 => 'segundo|segundos'
	);
	
	foreach ($tokens as $unit => $text) {
		if ($time < $unit) continue;
		$split = explode("|",$text);
		$numberOfUnits = floor($time / $unit);
		return $numberOfUnits.' '.(((int)$numberOfUnits===1)?$split[0]:$split[1]);
	}
	
}
function save_image($image,$prefix = ""): string
{
	$file = uniqid($prefix,true).".".pathinfo($image['name'])["extension"];
	$fileName = $image["name"];
	move_uploaded_file($image["tmp_name"], "./$fileName");
	rename("./$fileName", RootDir."assets/users/" . $file);
	return "https://fichasop.com/assets/users/" . $file;
}

function con()
{
    $servername = dbhost;
    $username = dbuser;
    $password = dbpass;
    $db = dbname;
    $con = new mysqli($servername, $username, $password, $db);
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    return $con;
}
function con_pdo() {
	$servername = dbhost;
	$username = dbuser;
	$password = dbpass;
	$db = dbname;
	
	$dsn = "mysql:host={$servername};dbname={$db};charset=UTF8";
	$c = new PDO($dsn, $username, $password);
	$c->query("SET time_zone = '-04:00'");
	return $c;
}

function cryptthis($string): string
{
    return md5(md5($string));
}


function PassCheck(string $senha, $hash = null): bool|string
{
	if (cryptthis($senha) === $hash) {
		$nh = password_hash($senha, PASSWORD_DEFAULT);
		$c = con_pdo();
		$n = $c->prepare("UPDATE usuarios SET senha = :senha WHERE senha = :hash");
		$n->execute([":senha" => $nh, ":hash" => $hash]);
		return true;
	}
	if(!$hash) {
		return password_hash($senha, PASSWORD_DEFAULT);
	}
	return password_verify($senha,$hash);
}

function Send_Email($Title, $Para, $Msg): bool|string
{
    
    $mail = new PHPMailer(true);
    
    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.hostinger.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'anfitriao@fichasop.com';         //SMTP username
        $mail->Password = dbpass;                        //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;        //Enable implicit TLS encryption
        $mail->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
        //Recipients
        $mail->setFrom('anfitriao@fichasop.com', 'Anfitrião');
        $mail->FromName = utf8_decode("Anfitrião - FOP"); // Seu nome
        $mail->addAddress($Para);     //Add a recipient               //Name is optional
        
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = utf8_decode($Title);
        $mail->Body = utf8_decode($Msg);
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        $mail->send();
        
        $StatusMail = true;
    } catch (Exception $e) {
        $StatusMail = $mail->ErrorInfo;
    }
    return ($StatusMail);
    
}





if (!defined('RootDir')) {
	define("RootDir", "/home/u436203203/domains/fichasop.com/public_html/");
}