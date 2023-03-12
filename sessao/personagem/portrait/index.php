<?php
require_once "./../../../config/includes.php";
require_once "./../ficha/aconfig_ficha.php";

?>
<!DOCTYPE html>
<html lang="br" data-bs-theme="<?=$_COOKIE["theme"]?>">
    <head>
        <?php require_once './../../../includes/head.html';?>
        <meta charset="UTF-8">
        <title><?=$nome?> - Portraits FichasOP</title>
        <?php require_once "./../../../includes/scripts.php";?>
    </head>
    <body class="">
    <main class="container mt-5">
        <div class="mt-2 mx-2 row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-2">
            <div class="col justify-content-center">
                <div class="card h-100 border-primary">
                    <div class="card-header">
                        <h3>Especial FichasOP</h3>
                    </div>
                    <div class="card-body">
                        <p>Feito com muito amor e carinho. Ele não tem largura predeterminada, ele se ajusta de acordo com o tamanho</p><br>
                        <span>Resolução Recomendada: 1000x1500></span>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-sm btn-outline-primary" href="./fichasop?token=<?=$token?>">Abrir Portrait</a>
                    </div>
                </div>
            </div>
            <div class="col justify-content-center">
                <div class="card h-100 border-danger">
                    <div class="card-header">
                        <h3>Espiral</h3>
                    </div>
                    <div class="card-body">
                        <p>Usado durante A Espiral. por <a href="http://twitch.tv/mestrepedrok">MestrePedrok</a></p><br>
                        <span>2750x1300</span>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-sm btn-outline-primary" href="./Espiral?token=<?=$token?>">Abrir Portrait Espiral</a>
                    </div>
                </div>
            </div>
            <div class="col justify-content-center">
                <div class="card h-100 border-danger">
                    <div class="card-header">
                        <h3>PlayRay</h3>
                    </div>
                    <div class="card-body">
                        <p>Portrait Exclusivo para o Arena. Um presente para o <a href="https://www.twitch.tv/playraymon">Playray</a> <3!</p><br>
                        <span>Resolução Recomendada: 2200x1200</span>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-sm btn-outline-primary" href="./PlayRay?token=<?=$token?>">Abrir Portrait Playray</a>
                    </div>
                </div>
            </div>
            <div class="col justify-content-center">
                <div class="card h-100 border-secondary">
                    <div class="card-header">
                        <h3>OSNF Dark</h3>
                    </div>
                    <div class="card-body">
                        <p>Portrait baseado em OSNF, com estilo mais Dark, ou obscuro.</p><br>
                        <span>Resolução Recomendada: 2200x1200</span>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-sm btn-outline-primary" href="./osnf_metal?token=<?=$token?>">Abrir Portrait OSNF</a>
                    </div>
                </div>
            </div>
            <div class="col justify-content-center">
                <div class="card h-100 border-secondary">
                    <div class="card-header">
                        <h3>OSNF Classic</h3>
                    </div>
                    <div class="card-body">
                        <p>Portrait baseado em OSNF, tentando ser o mais fiel com o da temporada</p><br>
                        <span>Resolução Recomendada: 2500x1200</span>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-sm btn-outline-primary" href="./osnf_classic?token=<?=$token?>">Abrir Portrait OSNF</a>
                    </div>
                </div>
            </div>
            <div class="col justify-content-center">
                <div class="card h-100 border-secondary">
                    <div class="card-header">
                        <h3>Desconjuração</h3>
                    </div>
                    <div class="card-body">
                        <p>Portrait baseado em Desconjuração, tentado ser o mais fiel com o da temporada</p><br>
                        <span>Resolução Recomendada: 1900x1200</span>
                        <label class="form-floating">
                            <input class="form-control form-control-color w-100" id="cordesc" type="color" autocomplete="off"/>
                            <label>Selecione a cor</label>
                        </label>
                    </div>
                    <div class="card-footer">
                        <a id="descbtn" class="btn btn-sm btn-outline-primary" href="./desconjuracao?token=<?=$token?>">Abrir Portrait</a>
                    </div>
                </div>
            </div>
            <div class="col justify-content-center">
                <div class="card h-100 border-secondary">
                    <div class="card-header">
                        <h3>Calamidade</h3>
                    </div>
                    <div class="card-body">
                        <p>Portrait compactado e minimalista, é bom para ser algo mais direto.</p><br>
                        <span>Resolução Recomendada: 1800x1200</span>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-sm btn-outline-primary" href="./calamidade?token=<?=$token?>">Abrir Portrait</a>
                    </div>
                </div>
            </div>
            <div class="col justify-content-center">
                <div class="card h-100 border-secondary">
                    <div class="card-header">
                        <h3>OSNI</h3>
                    </div>
                    <div class="card-body">
                        <p>Portrait com efeito de transparência igual ao da temporada</p><br>
                        <span>Resolução Recomendada: 1700x1200</span>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-sm btn-outline-primary" href="./osni?token=<?=$token?>">Abrir Portrait</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require_once RootDir."includes/top.php";?>
    <?php require_once RootDir."includes/scripts.php"; ?>
    <script>

        $("#cordesc").on("change",()=>{
            $("#descbtn").attr("href",`./desconjuracao?token=<?=$token?>&cor=${$("#cordesc").val().substring(1,8)}`)
        })
    </script>
    </body>
</html>