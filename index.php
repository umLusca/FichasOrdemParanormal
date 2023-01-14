<?php


require_once "./config/includes.php";
header("X-Robots-Tag: all");
if (isset($_POST["status"])) {

    if ($_POST["status"] == 'roll') {
        $dado = cleanstring($_POST["dado"], 50);
        $dano = intval(minmax($_POST["dano"], 0, 1));
        if (ClearRolar($dado)) {
            $data["success"] = true;
            $data = RolarMkII($dado, $dano);
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
<!--
kkRick#7849
Deixe o feijão de molho de véspera. No dia seguinte cozinhe-o juntamente com o caldo de carne e 2,5 litros de água fria.

Tampe a panela e deixe cozinhar em fogo baixo por aproximadamente 1 hora.

Em outra panela doure o paio, a cebola e o alho, no óleo. Junte o coento e o arroz e refogue bem. Acrescente o feijão já cozido, juntamente com o caldo. Misture bem, tampe a panela e deixe cozinhar até que o arroz fique cozido, úmido e com consistência cremosa.

Cubra o arroz com as fatias de queijo. Tampe a panela novamente e deixe que o vapor derreta o queijo.

Sirva acompanhado de carne-de-sol frita ou assada.
-->
<html lang="pt-BR" data-bs-theme="<?=$_SESSION["theme"]?>">
<head>
	<!-- Required meta tags -->
	<title>Fichas Ordem Paranormal</title>
    <?php require_once './includes/head.html'; ?>
</head>
<body class="">
<style>
    body {
        padding-top: 3rem;
        padding-bottom: 3rem;
        background-image: url("https://beta.fichasop.com/assets/img/background2.webp");
    }

    /* Carousel base class */
    .carousel {
        margin-bottom: 4rem;
    }

    /* Since positioning the image, we need to help out the caption */
    .carousel-caption {
        bottom: 3rem;
        z-index: 10;
    }

    /* Declare heights because of positioning of img element */
    .carousel-item {
        height: 32rem;
    }

    .carousel-item > img {
        position: absolute;
        top: 0;
        left: 0;
        min-width: 100%;
        height: 32rem;
    }


    /* MARKETING CONTENT
	-------------------------------------------------- */

    /* Center align the text within the three columns below the carousel */
    .marketing .col-lg-4 {
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .marketing h2 {
        font-weight: 400;
    }

    /* rtl:begin:ignore */
    .marketing .col-lg-4 p {
        margin-right: .75rem;
        margin-left: .75rem;
    }

    /* rtl:end:ignore */


    /* Featurettes
	------------------------- */

    .featurette-divider {
        margin: 5rem 0; /* Space out the Bootstrap <hr> more */
    }

    /* Thin out the marketing headings */
    .featurette-heading {
        font-weight: 300;
        line-height: 1;
        /* rtl:remove */
        letter-spacing: -.05rem;
    }


    /* RESPONSIVE CSS
	-------------------------------------------------- */

    @media (min-width: 40em) {
        /* Bump up size of carousel content */
        .carousel-caption p {
            margin-bottom: 1.25rem;
            font-size: 1.25rem;
            line-height: 1.4;
        }

        .featurette-heading {
            font-size: 50px;
        }
    }

    @media (min-width: 62em) {
        .featurette-heading {
            margin-top: 7rem;
        }
    }
    
    :root {
        --bs-body-color: #fff;
    }
</style>
<?php require_once RootDir . "includes/top.php"; ?>
<main>
	<div class="container-fluid marketing my-5">
		<div class="row">
			<div class="col-lg-4 order-1 order-lg-0">
				<div id="painel" class="carousel slide m-0" data-bs-ride="carousel">
					<div class="carousel-inner">
						<div class="carousel-item active" data-bs-interval="5000">
							<div class="d-flex m-3 justify-content-center">
							<div class="text-center align-self-center">
								<img src="/assets/img/Leandro - home.webp" width="150" height="150" class="rounded-circle mx-3 border border-1 border-white">
								<h2>Comece criando sua conta</h2>
								<p>Crie suas fichas, mestre as suas missões tudo isso de forma GRATIS!</p>
								<button class="btn btn-outline-success font1" data-bs-toggle="modal" data-bs-target="#cadastrar">
									Criar conta
								</button>
							</div>
							</div>
						</div>
						<div class="carousel-item" data-bs-interval="10000">
							<div class="row row-cols-1 m-3">
								<div class="col">
									<img src="assets/img/espiral_logo.webp" class="w-100" alt="...">
								</div>
								<div class="col text-start">
									<h4>Espiral</h4>
									<span>Site utilizado em <a class="link-danger" href="https://www.youtube.com/c/MestrePedroK">Espiral</a>, por uns dos autores dos livros e jogadores de ordem paranormal:</span>
									<ul>
										<li><a class="link-secondary" href="https://twitter.com/mestrepedrok">MestrePedrok</a></li>
										<li><a class="link-secondary" href="https://twitter.com/silandcrafts">Sil</a></li>
										<li><a class="link-secondary" href="https://twitter.com/CtrlAltDella">Felipe Della Corte</a></li>
										<li><a class="link-secondary" href="https://twitter.com/bastet_min">Bastet</a></li>
										<li><a class="link-secondary" href="https://twitter.com/iamKalera">Kalera</a></li>
										<li><a class="link-secondary" href="https://twitter.com/MongeHan">Monge Han</a></li>
										<li><a class="link-secondary" href="https://twitter.com/jooanadart">Jooana d'Art</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="carousel-item" data-bs-interval="5000">
							<div class="text-center m-3">
								<img src="/assets/img/foto.webp" width="150" height="150"
									 class="rounded-circle mx-3 border border-1 border-white">
								<h2>Comunidade</h2>
								<p>Entre no nosso discord e entre na nossa comunidade de ordem</p>
								<a class="btn btn-outline-primary font1" href="https://discord.gg/gHaAxqC2Hw">Discord</a>
							</div>
						</div>

						<button class="carousel-control-prev" type="button" data-bs-target="#painel" data-bs-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Previous</span>
						</button>
						<button class="carousel-control-next" type="button" data-bs-target="#painel" data-bs-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Next</span>
						</button>
					</div>
				</div>
			</div>
			<div class="col-lg-4 order-0 order-lg-1">
                <div class="card bg-transparent border-dashed border-danger text-center m-2 mx-auto" style="max-width: 400px">
                    <h3 class="card-title">Baixe nosso aplicativo!</h3>
                    <a href='https://play.google.com/store/apps/details?id=com.fichasop.app&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1'>
                        <img style="width: 200px" alt='Disponível no Google Play' src='https://play.google.com/intl/en_us/badges/static/images/badges/pt-br_badge_web_generic.png'/>
                    </a>
                </div>

				<h3 class="text-info ">Clique abaixo para testar!</h3>
				<div class="container-fluid p-0 mb-2">
					<div class="containera mx-auto text-white">
                        <?= atributos(1, 2, 3, 4, 5) ?>
					</div>
				</div>
			</div><!-- /.col-lg-4 -->

			<div class="col-lg-4 order-3">
				<div id="painel2" class="carousel slide m-0" data-bs-ride="carousel">
					<div class="carousel-inner">
						<div class="carousel-item active">
							<div class="d-flex h-100">
								<img src="/assets/img/img-1.png" class="img-fluid align-self-center">
							</div>
						</div>
						<div class="carousel-item">
							<div class="d-flex h-100">
								<video src="/assets/video/video_atributos.webm" preload="none" playsinline autoplay muted loop class="align-self-center img-fluid">
							</div>
						</div>

						<div class="carousel-item">
							<div class="d-flex h-100">
								<img src="/assets/img/img-2.png" class="img-fluid align-self-center">
							</div>
						</div>

						<div class="carousel-item">
							<div class="d-flex h-100">
								<img src="/assets/img/img-3.png" class="img-fluid align-self-center">
							</div>
						</div>

						<div class="carousel-item">
							<div class="d-flex h-100">
								<img src="/assets/img/img-4.png" class="img-fluid align-self-center">
							</div>
						</div>

						<div class="carousel-item">
							<div class="d-flex h-100">
								<img src="/assets/img/img-5.png" class="img-fluid align-self-center">
							</div>
						</div>
						<button class="carousel-control-prev" type="button" data-bs-target="#painel2" data-bs-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Previous</span>
						</button>
						<button class="carousel-control-next" type="button" data-bs-target="#painel2" data-bs-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Next</span>
						</button>
					</div>
				</div>
			</div>
		</div><!-- /.row -->
		<!--
                <hr class="featurette-divider">
                <div class="row featurette">
                    <div class="col-md-7">
                        <h2 class="featurette-heading">UI Limpa e minimalista</h2>
                        <p class="lead">Tudo isso para você se sentir o mais confortavel.</p>
                    </div>
                    <div class="col-md-5">
                        <img src="/assets/img/pericias.webp" width="500" height="500" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto">
                    </div>
                </div>
                <hr class="featurette-divider">
                <div class="row featurette">
                    <div class="col-md-7 order-md-2">
                        <h2 class="featurette-heading">Não tem como errar</h2>
                        <p class="lead">tudo é bem autoexplicativo e pensado em ajudar-lhe a usar.</p>
                    </div>
                    <div class="col-md-5 order-md-1">
                        <img src="/assets/img/principal.webp" width="500" height="500" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto">
                    </div>
                </div>
                <hr class="featurette-divider">
                <div class="row featurette">
                    <div class="col-md-7">
                        <h2 class="featurette-heading">E por fim...</h2>
                        <p class="lead">Não tem como deixar o principal de lado, sistema de rolar dados completissimo para
                            você.</p>
                    </div>
                    <div class="col-md-5">
        				<video src="/assets/video/video_atributos.webm" preload="none" width="500" height="500" playsinline autoplay muted loop class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto">

                    </div>
                </div>
                <hr class="featurette-divider">
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
        </footer>-->
<?php require_once RootDir . "sessao/include_geral/modal_dice.php"; ?>
<?php require_once RootDir . "includes/scripts.php"; ?>
<?php require_once RootDir . "sessao/include_geral/scripts.php"; ?>
</body>
</html>