<?php
require_once "./../../config/includes.php";
$con = con();
$uid = $_SESSION["UserID"];

if (!empty($_GET["token"])) {
	$token = cleanstring($_GET["token"]);
} else {
	$token = null;
}
if ($_SESSION["UserAdmin"]) {
	if (!empty($_GET["id"])) {
		$id = intval($_GET["id"]);
	} else {
		$id = null;
	}
} else {
	$id = 0;
}

if (VerificarMestre($token) || VerificarMestre($id) || $_SESSION["UserAdmin"]) {
	$mi = $con->prepare("SELECT * FROM `missoes` WHERE `token` = ? OR `id` = ?;");
	$mi->bind_param("si", $token, $id);
	$mi->execute();
	$rmi = $mi->get_result();
	if ($rmi->num_rows) {
		$missao = mysqli_fetch_array($rmi);
		$token = $missao["token"];
		$id = $missao["id"];
	} else {
		proibido();
	}
} else {
	proibido();
}

$q = []; //Querys;
$q["ligacoes"] = $con->query("Select * FROM `ligacoes` WHERE id_missao = '" . $id . "';");
$q["notas"] = $con->query("SELECT * FROM `notes` WHERE `missao` = '$id';");
$q["iniciativas"] = $con->query("SELECT * FROM `iniciativas` WHERE `id_missao` = '" . $id . "' ORDER BY prioridade");
$q["personagens"] = $con->query("SELECT * FROM fichas_personagem where id in (SELECT id_ficha FROM ligacoes WHERE id_missao = '" . $id . "');");

$q["npcs"] = $con->query("SELECT * FROM `fichas_npc` WHERE `missao` = '$id'");
$q["dados_player"] = $con->query("SELECT * FROM dados_rolados_mestre WHERE missao = {$id} ORDER BY `data` desc LIMIT 10;");


$missao_token = $token;
require_once './includes/atualizar.php';
if (isset($_GET["id"])) {
	header("Location: ./?token=" . $token);
}
?>
<!DOCTYPE html>
<html lang="br" data-bs-theme="<?= $_COOKIE["theme"]?:"dark"?>">
<head>
	<?php require_once "./../../includes/head.html"; ?>
    <title>Mestre - FichasOP</title>
</head>
<body class="">
<?php if (!isset($_GET["popout"])) {
	require_once "./../../includes/top.php";
} ?>
<main class="container-fluid my-2">
    <div class="row g-3">
		<?php
		if (!isset($_GET["popout"]) || cleanstring($_GET["popout"]) === "jogadores") {
			require_once "./includes/jogadores_card.php";
		}
		if (!isset($_GET["popout"]) || cleanstring($_GET["popout"]) === "testes") {
			require_once "./includes/dadosjogados_card.php";
		}
		if (!isset($_GET["popout"]) || cleanstring($_GET["popout"]) === "iniciativas") {
			require_once "./includes/iniciativas_card.php";
		}
		if (!isset($_GET["popout"]) || cleanstring($_GET["popout"]) === "dados") {
			require_once "./../include_geral/card_dice.php";
		}
		if (!isset($_GET["popout"]) || cleanstring($_GET["popout"]) === "notas") {
			require_once "./includes/notas_card.php";
		}
		if (!isset($_GET["popout"]) || cleanstring($_GET["popout"]) === "npc") {
			require_once "./includes/npc_card.php";
		}
		
		?>
    </div>
</main>
<div>
	<?php
	require_once "./../include_geral/modal_dice.php";
	require_once "./includes/jogadores_modal.php";
	require_once "./includes/npc_modal.php";
	?>
</div>


<?php require_once "./../../includes/scripts.php"; ?>
<?php require_once "./../include_geral/scripts.php"; ?>
<?php require_once "./includes/scripts.php"; ?>
</body>
</html>