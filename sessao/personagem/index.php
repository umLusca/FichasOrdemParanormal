<?php
header("X-Robots-Tag: none");
require_once "./../../config/includes.php";
require_once "./ficha/aconfig_ficha.php";

?>
<!DOCTYPE html>
<html lang="br" data-bs-theme="<?= $_COOKIE["theme"] ?>">
<head>
	<?php require_once './../../includes/head.html'; ?>
    <meta charset="UTF-8">
    <title><?= $fichas["nome"] ?> - FichasOP</title>
	<?php require_once "./../../includes/scripts.php"; ?>
</head>
<body>
<?php if (!isset($_GET["popout"])) {
	include_once "./../../includes/top.php";
} ?>
<main>
    <div class="container-fluid">
        <div class="row m-1 <?= isset($_GET["popout"]) ?: " g-2 m-md-2 row-cols-1 row-cols-md-2" ?>">
			<?php
			if (!isset($_GET["popout"])) {
				include_once "./ficha/informacoes_card.php";
			} else if ($_GET["popout"] == 'dados') {
				include_once "./ficha/informacoes_card.php";
			}
			
			if (!isset($_GET["popout"])) {
				include_once "./ficha/status_card.php";
			} else if ($_GET["popout"] == 'principal') {
				include_once "./ficha/status_card.php";
			}
			
			if (!isset($_GET["popout"])) {
				include_once "./ficha/atributos_card.php";
			} else if ($_GET["popout"] == 'atributos') {
				include_once "./ficha/atributos_card.php";
			}
			
			if (!isset($_GET["popout"])) {
				include_once "./ficha/pericias_card.php";
			} else if ($_GET["popout"] == 'pericias') {
				include_once "./ficha/pericias_card.php";
			}
			
			if (!isset($_GET["popout"])) {
				include_once "./ficha/habilidades_card.php";
			} else if ($_GET["popout"] == 'habilidades') {
				include_once "./ficha/habilidades_card.php";
			}
			
			if (!isset($_GET["popout"])) {
				include_once "./ficha/proficiencias_card.php";
			} else if ($_GET["popout"] == 'proficiencias') {
				include_once "./ficha/proficiencias_card.php";
			}
			
			if (!isset($_GET["popout"])) {
				include_once "./../include_geral/card_dice.php";
			} else if ($_GET["popout"] == 'rolar') {
				include_once "./../include_geral/card_dice.php";
			}
			
			if (!isset($_GET["popout"])) {
				include_once "./ficha/historias_card.php";
			} else if ($_GET["popout"] == 'personagem') {
				include_once "./ficha/historias_card.php";
			}
			?>
        </div>
        <div class="row g-2 mx-md-2 mt-1 row-cols-1">
			<?php
			if (!isset($_GET["popout"])) {
				include_once "./ficha/inventario_card.php";
			} else if ($_GET["popout"] == 'inventario') {
				include_once "./ficha/inventario_card.php";
			}
			
			if (!isset($_GET["popout"])) {
				include_once "./ficha/rituais_card.php";
			} else if ($_GET["popout"] === 'rituais') {
				include_once "./ficha/rituais_card.php";
			}
			?>
        </div>
    </div>
</main>
<div id="modalsaki">
	<?php if ($edit) {
		require_once "./ficha/inventario_modal.php";
		require_once "./ficha/helper_modals.php";
		require_once "./ficha/proficiencias_modal.php";
		require_once "./ficha/rituais_modal.php";
		require_once "./ficha/informacoes_modal.php";
		require_once "./ficha/status_modal.php";
		require_once "./ficha/habilidades_modal.php";
		require_once "./ficha/atributos_modal.php";
		require_once "./../include_geral/modal_dice.php";
		require_once "./../include_geral/modal_deletar.php";
		require_once "./ficha/pericias_modal.php";
	} ?>
</div>
<?php require_once "./../../includes/scripts.php"; ?>
<?php require_once "./ficha/scripts.php"; ?>
<?php require_once "./../include_geral/scripts.php"; ?>
<?php if (!isset($_GET["popout"])) {
	require_once "./../../includes/top.php";
} ?>
</body>
</html>