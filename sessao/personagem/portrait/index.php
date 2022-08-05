<?php
require_once "./../../../config/includes.php";
require_once "./../ficha/aconfig_ficha.php";

?>
<!DOCTYPE html>
<html lang="br">
    <head>
        <?php require_once './../../../includes/head.html';?>
        <meta charset="UTF-8">
        <title><?=$nome?> - Portrait FichasOP</title>
        <?php require_once "./../../../includes/scripts.php";?>
    </head>
    <body class="bg-black text-light">
    <main class="container-flex mx-0 py-5 justify-content-center">
        <div class="row m-3">
            <div class="col my-2 justify-content-center">
                <div class="card h-100 bg-black border-light">
                    <div class="card-header">
                        <h3>OSNF</h3>
                    </div>
                    <div class="card-body">
                        <span>Um portrait largo, e bem bonito, possuí barras de vida e sanidade. Recomendado para sessões com poucos jogadores.</span><br>
                        <span>Resolução Recomendada: 2800x1200</span>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-sm btn-outline-primary" href="./osnf?token=<?=$fichat?>">Abrir Portrait OSNF</a>
                    </div>
                </div>
            </div>
            <div class="col my-2 justify-content-center">
                <div class="card h-100 bg-black border-light">
                    <div class="card-header">
                        <h3>Calamidade/OSNI</h3>
                    </div>
                    <div class="card-body">
                        <span>Portrait compactado e minimalista, é bom para ser algo mais direto.</span><br>
                        <span>Resolução Recomendada: 1750x1100</span>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-sm btn-outline-primary" href="./calamidade?token=<?=$fichat?>">Abrir Portrait OSNI</a>
                    </div>
                </div>
            </div>
            <?php if($dados_missao["id"] == 5887 OR $_SESSION["UserAdmin"]){?>
            <div class="col my-2 justify-content-center">
                <div class="card h-100 bg-black border-light">
                    <div class="card-header">
                        <h3>Espiral</h3>
                    </div>
                    <div class="card-body">
                        <span>Você sabe... (não vazar antes da live :D)</span><br>
                        <span>2750x1200</span>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-sm btn-outline-primary" href="./Espiral?token=<?=$fichat?>">Abrir Portrait Espiral</a>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>
    </main>
    <?php require_once RootDir."includes/top.php";?>
    <?php require_once RootDir."includes/scripts.php"; ?>
    <script>
            $(document).ready(function () {
            });
    </script>
    </body>
</html>