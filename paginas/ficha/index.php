<?php

$con = con();
$c = con_pdo();

//Importante para evitar futuros ERROS!
$missao = 0;


//Importante para evitar XSS INJECTIOn e um bucado de coisa
if ($_SESSION["UserAdmin"] && isset($_GET["id"])) {
	$qs = $c->prepare("SELECT * FROM `fichas_personagem` WHERE `id` = ? ;");
	$qs->execute([(int) $_GET["id"]]);
	if ($qs->rowCount()) {
		$ficha = $qs->fetch(2);
		$token = $ficha["token"];
		header("Location: ./" . $token);
	} else {
		header("Location: ./..");
		exit;
	}
	
} else {
	$sq = $c->prepare("SELECT fichas_personagem.*, u.nome as usuario, u.marca as marca FROM `fichas_personagem` inner join usuarios u on fichas_personagem.usuario = u.id WHERE fichas_personagem.`token` = ? ;");
	$sq->execute([$token]);
	if ($sq->rowCount()) {
		$ficha = $sq->fetch(2);
		$id = $ficha["id"];
	} else {
		header("Location: ./..");
		exit;
	}
}

if (empty($token)) {
	header("Location: ./..");
}


$lig = $c->prepare("SELECT m.* FROM ligacoes l INNER JOIN missoes m ON l.id_missao = m.id WHERE l.id_ficha = ? limit 1;");
$lig->execute([$id]);
if ($lig->rowCount()) {
	$dados_missao = $lig->fetch(2);
}


if ($_SESSION["UserAdmin"]) {
	$edit = true;
} else if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {
	$edit = true;
} else if (!$ficha["public"]) {
	header("Location: ./..");
	exit;
}


if (isset($ficha)) {
	$dc = [
		"FOR"  => $ficha["forca"],
		"AGI"  => $ficha["agilidade"],
		"INT"  => $ficha["inteligencia"],
		"PRE"  => $ficha["presenca"],
		"VIG"  => $ficha["vigor"],
		"ACRO" => $ficha["acrobacias"],
		"ADES" => $ficha["adestramento"],
		"ARTE" => $ficha["artes"],
		"ATLE" => $ficha["atletismo"],
		"ATUA" => $ficha["atualidades"],
		"CIEN" => $ficha["ciencia"],
		"CRIM" => $ficha["crime"],
		"DIPL" => $ficha["diplomacia"],
		"ENGA" => $ficha["enganacao"],
		"FORT" => $ficha["fortitude"],
		"FURT" => $ficha["furtividade"],
		"INIT" => $ficha["iniciativa"],
		"INTI" => $ficha["intimidacao"],
		"INTU" => $ficha["intuicao"],
		"INVE" => $ficha["investigacao"],
		"LUTA" => $ficha["luta"],
		"MEDI" => $ficha["medicina"],
		"OCUL" => $ficha["ocultismo"],
		"PERC" => $ficha["percepcao"],
		"PILO" => $ficha["pilotagem"],
		"PONT" => $ficha["pontaria"],
		"PROF" => $ficha["profissao"],
		"RELI" => $ficha["religiao"],
		"REFL" => $ficha["reflexos"],
		"SOBR" => $ficha["sobrevivencia"],
		"TATi" => $ficha["tatica"],
		"TECN" => $ficha["tecnologia"],
		"VONT" => $ficha["vontade"],
	];
} else {
	header("Location: ./..");
}

$rs = [];
$s[1] = $c->query("Select * From `armas` where `id_ficha` = '$id';")->fetchAll(2);
$s[8] = $c->query("Select *,armas.id as id,i.foto as foto From armas left join inventario i on i.id = armas.item_id where i.id_ficha = '$id' ;")->fetchAll(2);

$s[2] = $c->query("SELECT * FROM `habilidades` WHERE `id_ficha` = '" . $id . "';")->fetchAll(2);
$s[3] = $c->query("SELECT * FROM `proeficiencias` WHERE `id_ficha` = '" . $id . "';")->fetchAll(2);
$s[4] = $c->query("SELECT i.* FROM inventario i LEFT JOIN armas a ON a.item_id = i.id WHERE a.item_id is null AND i.id_ficha = '$id';")->fetchAll(2);
foreach ($s[4] as $r):
	$rs[4][] = $r;
endforeach;
$s[6] = $c->query("Select * From `rituais` where `id_ficha` = '$id';")->fetchAll(2);
foreach ($s[6] as $r):
	$rs[6][] = $r;
endforeach;
$s[7] = $c->query("SELECT * FROM `poderes` WHERE `id_ficha` = '" . $id . "';")->fetchAll(2);
$s[5] = $c->query("Select SUM(espaco*quantidade) AS pesototal From `inventario` where `id_ficha` = '$id';")->fetch(2);


$m = $c->query("SELECT * FROM `dados_ficha` WHERE `id_ficha` = '" . $id . "';")->fetch(2);
$ddinv = $s[5];


$espacosusados = $ddinv["pesototal"] ?: 0;
if ($espacosusados < 0) {
	$espacosusados = 0;
}
if ($ficha["peso_inv"] > 1) {
	$invmax = $ficha["peso_inv"];
} else {
	$invmax = pesoinv($ficha["forca"], $ficha["inteligencia"], $ficha["classe"], $ficha["trilha"], $ficha["origem"]);
}

$missao_token = $dados_missao["token"] ?? false;
//Pega todos os dados da components: ...


?>
<!DOCTYPE html>
<html lang="br" data-bs-theme="<?= $_COOKIE["theme"] ?>">
<head>
	<?php require_once ROOT . '/_COMPONENTS/head.html'; ?>
    <meta charset="UTF-8">
    <title><?= $ficha["nome"] ?> - FichasOP</title>
	<?php require_once ROOT . "/_COMPONENTS/scripts.php"; ?>
</head>
<body>
<?php require_once ROOT . "/_COMPONENTS/top.php"; ?>

<main class="container-fluid m-0 p-0">
    <div class="row g-2 m-0 p-2">
        <div class="col-12 col-md-6">
			<?php include_once ROOT . "paginas/ficha/components/cards/card_info.php"; ?>
        </div>
        <div class="col-12 col-md-6">
			<?php include_once ROOT . "paginas/ficha/components/cards/card_status.php"; ?>
        </div>
        <div class="col-12 col-md-6">
			<?php include_once ROOT . "paginas/ficha/components/cards/card_habilidades.php"; ?>
        </div>
        <div class="col-12 col-md-6">
			<?php include_once ROOT . "paginas/ficha/components/cards/card_proficiencias.php"; ?>
        </div>
        <div class="col-12 col-md-6">
			<?php include_once ROOT . "paginas/ficha/components/cards/card_historias.php"; ?>
        </div>
		<?php
		include_once ROOT . "/paginas/ficha/components/cards/card_inventario.php";
		include_once ROOT . "/paginas/ficha/components/cards/card_rituais.php";
		?>
    </div>
</main>

<div id="modalsaki">
	<?php
		require_once ROOT . "/paginas/ficha/components/modals/modal_inventario.php";
		require_once ROOT . "/paginas/ficha/components/modals/modal_ajuda.php";
		require_once ROOT . "/paginas/ficha/components/modals/modal_proficiencias.php";
		require_once ROOT . "/paginas/ficha/components/modals/modal_rituais.php";
		require_once ROOT . "/paginas/ficha/components/modals/modal_detalhes.php";
		require_once ROOT . "/paginas/ficha/components/modals/status_modal.php";
		require_once ROOT . "/paginas/ficha/components/modals/modal_habilidades.php";
		require_once ROOT . "/paginas/ficha/components/modals/modal_atributos.php";
		require_once ROOT . "/_COMPONENTS/modais/etc_deletar.php";
		require_once ROOT . "/_COMPONENTS/modais/etc_resultado_dado.php";
		require_once ROOT . "/paginas/ficha/components/modals/modal_pericias.php";
	 ?>
</div>
<?php require_once ROOT . "/_COMPONENTS/scripts.php"; ?>
<?php require_once ROOT . "/paginas/ficha/components/scripts.php"; ?>
<?php require_once ROOT . "/_COMPONENTS/scripts_dice.php"; ?>
</body>
</html>