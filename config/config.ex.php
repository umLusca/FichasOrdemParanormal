<?php
//RENAME TO "config.php"
function con()
{
    $servername = "";
    $username = "";
    $password = "";
    $db = "";
    $con = new mysqli($servername, $username, $password, $db);
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    return $con;
}

function cryptthis($string): string
{
    return md5($string); // create your scheme..
}

const RootDir = "/";











$rinom = '';//nome
$riele = '';//elemento
$ricir = '';//circulo
$riexe = '';//execução
$rialc = '';//alcance
$rialv = '';//alvo
$ridur = '';//duração
$rides = '';//descrição

