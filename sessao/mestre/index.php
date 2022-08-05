<?php
require_once "./../../config/includes.php";
$con = con();
$uid = $_SESSION["UserID"];
function proibido() {
	header("Location: ./..");
    exit;
}

if (!empty($_GET["token"])) {
	$token = test_input($_GET["token"]);
} else {
	$token = null;
};
if ($_SESSION["UserAdmin"]) {
	if(!empty($_GET["id"])){$id = intval($_GET["id"]);} else {$id = null;}
} else {
    $id = 0;
}

if (VerificarMestre($token) || VerificarMestre($id) || $_SESSION["UserAdmin"]) {
    $mi = $con->prepare("SELECT * FROM `missoes` WHERE `token` = ? OR `id` = ?;");
    $mi->bind_param("si", $token,$id);
    $mi->execute();
    $rmi = $mi->get_result();
    if ($rmi->num_rows) {
	    $missao = mysqli_fetch_array($rmi);
	    $mt = $missao["token"];
	    $id = $missao["id"];
    } else {
        proibido();
    }
} else {
    proibido();
}



$q = $con->query("Select * FROM `ligacoes` WHERE id_missao = '" . $id . "';");
$nt = $con->query("SELECT * FROM `notes` WHERE `missao` = '$id';");
$a = $con->query("SELECT * FROM `iniciativas` WHERE `id_missao` = '" . $id . "' ORDER BY prioridade");

$jogadores = $con->query("SELECT * FROM fichas_personagem where id in (SELECT id_ficha FROM ligacoes WHERE id_missao = '".$id."');");

require_once './includes/atualizar.php';
$m = $con->query("SELECT * FROM `dados_mestre` WHERE `id_missao` = '".$id."';");
$fichanpcs = $con->query("SELECT * FROM `fichas_npc` WHERE `missao` = '$id' AND `categoria` = 0;");
$fichasmonstro = $con->query("SELECT * FROM `fichas_npc` WHERE `missao` = '$id' AND `categoria` = 1;");

$missao_token = $token;
?>
<!DOCTYPE html>
<html lang="br">
    <head>
        <?php require_once "./../../includes/head.html"; ?>
        <title>Mestre - FichasOP</title>
    </head>
    <body class="bg-black text-white">
    <main class="container-fluid mt-5">
        <div class="row g-2">
            <?php
            require_once "./includes/card_jogadores.php";
            require_once "./includes/card_iniciativas.php";
            require_once "./includes/card_notas.php";
            require_once "./../include_geral/card_dice.php";
            require_once "./includes/card_npc.php";
            require_once "./includes/card_dadosjogadores.php";
            ?>
        </div>
    </main>
    <div>
    <?php
    require_once "./../include_geral/modal_dice.php";
    require_once "./includes/modal_jogadores.php";
    require_once "./includes/modal_npc.php";
    ?>
    </div>



    <?php require_once "./../../includes/scripts.php"; ?>
    <?php require_once "./../../includes/top.php";?>
    <?php require_once "./../include_geral/scripts.php";?>
    <?php require_once "./includes/scripts.php"; ?>
    </body>
</html>