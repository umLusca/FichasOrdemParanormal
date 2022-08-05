<?php
require_once "./config/includes.php";
header("X-Robots-Tag: all");
if(isset($_POST["status"])) {

if($_POST["status"] == 'roll'){
		$dado = DadoDinamico(test_input($_POST["dado"], 50));
		$dano = intval(minmax($_POST["dano"], 0, 1));
		if (ClearRolar($dado)) {
			$data["success"] = true;
			$data = Rolar($dado, $dano);
		} else {
			$data = ClearRolar($dado, true);
		}
		$data["dado"] = $dado;
		echo json_encode($data);
		exit;
	}
}

?>
<!doctype html>

<html lang="br">
<head>
    <!-- Required meta tags -->
    <title>Fichas Ordem Paranormal</title>
    <link rel="stylesheet" href="/assets/css/carousel.css">
    <?php require_once './includes/head.html'; ?>
</head>
<body class="bg-black text-light">
<?php require_once RootDir."includes/top.php"; ?>
<main>
    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing my-5">
        <!-- Three columns of text below the carousel -->
        <div class="row">
            <div class="col-lg-4">

                <img src="/assets/img/Leandro - Upscale.png" width="150" height="150"
                     class="rounded-circle mx-3 border border-1 border-white">

                <h2>Comece criando sua conta</h2>
                <p>Crie suas fichas, mestre as suas missões tudo isso de forma GRATIS!</p>
                <button class="btn btn-outline-success font1" data-bs-toggle="modal" data-bs-target="#cadastrar">Criar conta</button>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
                <h3 class="text-info ">Clique abaixo para testar!</h3>
                <div class="container-fluid p-0 mb-2">
                    <div class="containera mx-auto text-white" style="zoom: 75%;" id="atr">
                        <button class="atributos p-0 for btn rounded-circle text-white font4" onclick='rolar("1d20")' >1</button>
                        <button class="atributos p-0 agi btn rounded-circle text-white font4" onclick='rolar("2d20")' >2</button>
                        <button class="atributos p-0 int btn rounded-circle text-white font4" onclick='rolar("3d20")' >3</button>
                        <button class="atributos p-0 pre btn rounded-circle text-white font4" onclick='rolar("4d20")' >4</button>
                        <button class="atributos p-0 vig btn rounded-circle text-white font4" onclick='rolar("5d20")' >5</button>
                        <img src="/assets/img/Atributos.png" alt="Atributos">
                    </div>
                </div>
            </div><!-- /.col-lg-4 -->

            <div class="col-lg-4">
                    <img src="/assets/img/foto.webp" width="150" height="150"
                         class="bg-dark rounded-circle mx-3 border border-1 border-white">
                    <h2>Comunidade</h2>
                <p>Entre no nosso discord e entre na nossa comunidade de ordem: <a href="https://discord.gg/gHaAxqC2Hw">https://discord.gg/gHaAxqC2Hw</a></p>
            </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->

        <!-- START THE FEATURETTES -->
        <hr class="featurette-divider">

        <div class="row featurette">
            <div class="col-md-7">
                <h2 class="featurette-heading">UI Limpa e minimalista</h2>
                <p class="lead">Tudo isso para você se sentir o mais confortavel.</p>
            </div>
            <div class="col-md-5">
                <img src="/assets/img/pericias.webp" width="500" height="500"
                     class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto">
            </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
            <div class="col-md-7 order-md-2">
                <h2 class="featurette-heading">Não tem como errar</h2>
                <p class="lead">tudo é bem autoexplicativo e pensado em ajudar-lhe a usar.</p>
            </div>
            <div class="col-md-5 order-md-1">
                <img src="/assets/img/principal.webp" width="500" height="500"
                     class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto">
            </div>
        </div>
        <hr class="featurette-divider">
        <div class="row featurette">
            <div class="col-md-7">
                <h2 class="featurette-heading">E por fim...</h2>
                <p class="lead">Não tem como deixar o principal de lado, sistema de rolar dados completissimo para você.</p>
            </div>
            <div class="col-md-5">
                <video src="/assets/img/rolar.webm" width="500" height="500" playsinline autoplay
                       muted loop
                       class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto">

            </div>
        </div>
        <hr class="featurette-divider">
        <div class="featurette justify-content-center">
            <widgetbot
                    server="949132238149271552"
                    channel="958092230634139718"
                    height="500"
                    class="col-12"

            ></widgetbot>

        </div>


    </div>
</main>

<footer class="container-fluid fixed-bottom text-white border-light border-top">
    <div class="clearfix">
        <div class="float-start text-start">
            <a href="https://getbootstrap.com/" class="text-decoration-none">
                <img src="assets/img/bootstrap-logo.svg" height="25" width="32" alt="..."/>Bootstrap.
            </a>
        </div>
    </div>
</footer>
<?php require_once RootDir."sessao/include_geral/modal_dice.php"; ?>


<script src="https://cdn.jsdelivr.net/npm/@widgetbot/html-embed"></script>
<?php require_once RootDir."includes/scripts.php"; ?>
<?php require_once RootDir."sessao/include_geral/scripts.php"; ?>
</body>
</html>