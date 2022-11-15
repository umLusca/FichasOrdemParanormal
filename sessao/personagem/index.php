<?php
header("X-Robots-Tag: none");
require_once "./../../config/includes.php";
require_once "./ficha/aconfig_ficha.php";

?>
<!DOCTYPE html>
<html lang="br">
    <head>
        <?php require_once './../../includes/head.html';?>
        <meta charset="UTF-8">
        <title><?= $nome?: "Desconhecido"; ?> - FichasOP</title>
        <?php require_once "./../../includes/scripts.php";?>
    </head>
    <body class="bg-black text-light">
        <?php if (!isset($_GET["popout"])) {
            include_once "./../../includes/top.php";
            }?>
        <main>
            <div class="container-fluid">
                <div class="row g-2 m-md-2 row-cols-1 row-cols-md-2">
                    <?php
                    if (!isset($_GET["popout"])) {
                        include_once "./ficha/card_detalhes.php";
                    } else if ($_GET["popout"] == 'dados') {
                        include_once "./ficha/card_detalhes.php";
                    }

                    if (!isset($_GET["popout"])) {
                        include_once "./ficha/card_principal.php";
                    } else if ($_GET["popout"] == 'principal') {
                        include_once "./ficha/card_principal.php";
                    }

                    if (!isset($_GET["popout"])) {
                        include_once "./ficha/card_atributos.php";
                    } else if ($_GET["popout"] == 'atributos'){
                        include_once "./ficha/card_atributos.php";
                    }

                    if (!isset($_GET["popout"])) {
                        include_once "./ficha/card_pericias.php";
                    } else if ($_GET["popout"] == 'pericias'){
                        include_once "./ficha/card_pericias.php";
                    }

                    if (!isset($_GET["popout"])) {
                        include_once "./ficha/card_habilidades.php";
                    } else if ($_GET["popout"] == 'habilidades'){
                        include_once "./ficha/card_habilidades.php";
                    }

                    if (!isset($_GET["popout"])) {
                        include_once "./ficha/card_proeficiencias.php";
                    } else if ($_GET["popout"] == 'proeficiencias'){
                        include_once "./ficha/card_proeficiencias.php";
                    }

                    if (!isset($_GET["popout"])) {
                        include_once "./../include_geral/card_dice.php";
                    } else if ($_GET["popout"] == 'rolar'){
                        include_once "./../include_geral/card_dice.php";
                    }

                    if (!isset($_GET["popout"])) {
                        include_once "./ficha/card_personagem.php";
                    } else if ($_GET["popout"] == 'personagem'){
                        include_once "./ficha/card_personagem.php";
                    }
                ?>
                    </div>
                        <div class="row g-2 mx-md-2 mt-1 row-cols-1">
                    <?php
                    if (!isset($_GET["popout"])) {
                        include_once "./ficha/card_inventario.php";
                    } else if ($_GET["popout"] == 'inventario'){
                        include_once "./ficha/card_inventario.php";
                    }

                    if (!isset($_GET["popout"])) {
                        include_once "./ficha/card_rituais.php";
                    } else if ($_GET["popout"] == 'rituais'){
                        include_once "./ficha/card_rituais.php";
                    }
                    ?>
                </div>
            </div>
        </main>
        <div id="modalsaki">
            <?php if ($edit) {
                require_once "./ficha/modal_detalhes.php";
                require_once "./ficha/modal_principal.php";
                require_once "./ficha/modal_foto.php";
                require_once "./ficha/modal_personagem.php";
                require_once "./ficha/modal_habilidades.php";
                require_once "./ficha/modal_atributos.php";
                require_once "./ficha/modal_pericias.php";
                require_once "./ficha/modal_inventario.php";
                require_once "./ficha/modal_proeficiencias.php";
                require_once "./ficha/modal_rituais.php";
                require_once "./../include_geral/modal_dice.php";
                require_once "./../include_geral/modal_deletar.php";
            } ?>
        </div>
        <?php require_once "./../../includes/scripts.php";?>
        <?php require_once "./ficha/scripts.php"; ?>
        <?php require_once "./../include_geral/scripts.php";?>
        <?php if (!isset($_GET["popout"])) {
            require_once "./../../includes/top.php";
        }?>
    </body>
</html>