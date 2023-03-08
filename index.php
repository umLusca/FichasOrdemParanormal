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
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <!-- Required meta tags -->
    <title>Fichas Ordem Paranormal</title>
	<?php require_once './includes/head.html'; ?>
    <style>
        /*
        body {
            padding-top: 3rem;
            padding-bottom: 3rem;
        }
        */

        [data-bs-theme=dark] .first {
            background-image: url("https://fichasop.com/assets/img/background2.webp");
        }

        [data-bs-theme=light] .first {
            background-image: url("/assets/img/bg_conhecimento_1.png");
        }

        [data-bs-theme=light] main {
            color: white;
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

        .fade-in {
            animation: fadeIn ease 5s;
            -webkit-animation: fadeIn ease 5s;
            -moz-animation: fadeIn ease 5s;
            -o-animation: fadeIn ease 5s;
            -ms-animation: fadeIn ease 5s;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @-moz-keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @-webkit-keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @-o-keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @-ms-keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        .hover {
            transition: 0.5s;
        }

        .card {
            min-height: 250px;
        }

        .hover:hover {
            box-shadow: 0 0 20px 0px rgba(162, 0, 255, 0.847);
        }

        .painel {
            background-image: url("assets/img/painel.png");
            background-size: cover;
        }

        .painel > *:hover {

        }

        .portraits {
            background-image: url("assets/img/portraits.png");
            background-size: cover;
            background-position-y: bottom;
        }

        .layer {
            background: transparent;
            height: 100%;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            transition: 0.5s;
        }

        .layer:hover {
            background: rgba(114, 14, 172, 0.6);
        }

        .layer div {
            width: 100%;
            color: #fff;
            position: absolute;
            opacity: 0;
            transition: 0.5s;

        }

        .layer:hover div {
            opacity: 1;
        }

    </style>
</head>
<body class="">
<?php require_once RootDir . "includes/top.php"; ?>
<main style="width: calc(100vw - 5px); height: calc(100vh - 45px)" class="first">
    <div class="container position-relative">
        <h1 class="text-center fade-in fichasop" style="font-size: calc(5vh + 5vw); padding-top: 20vh">
            <span class="font6">F</span><span class="font6">i</span><span class="font6">c</span><span class="font6">h</span class="font6"><span class="font6">a</span><span class="font6">s</span><span class="font6">O</span><span class="font6">P</span>
        </h1>
        <p class="fs-5 text-center mb-0">O SITE DE FICHAS PARA ORDEM PARANORMAL RPG</p>
        <p class="fs-5 text-center">Oque está esperando? Clique abaixo e começe a criar sua ficha!</p>
        <div class="w-100 text-center">
			<?php if (!isset($_SESSION["UserID"])) { ?>
                <button class="m-2 btn btn-danger" data-bs-toggle="modal" data-bs-target="#cadastrar">Criar uma conta
                </button>
			<?php } else { ?>
                <button class="m-2 btn btn-success" data-bs-toggle="modal" data-bs-target="#cadastrar">Ir para Sessões
                </button>
			<?php } ?>
        </div>
    </div>
</main>
<section class="container">
    <div class="text-center mt-3"><h1 class="" style="font-size: calc(4vh+4vw)">O Projeto</h1></div>
    <div class="row my-5 row-cols-1 row-cols-md-3 g-3">
        <div class="col">
            <div class="card hover p-2 h-100">
                <h1 class="text-center card-title text-body-emphasis">Discord</h1>
                <p>Com mais de 16.000 pessoas, contamos com a comunidade mais zica que existe, que nos ajudam com
                    decisões, Updates, e Sugestões.</p>
                <div class="text-center mt-auto">
                    <a class="btn btn-primary" role="button" href="https://discord.gg/5asNxZg3rU"><i class="fab fa-discord"></i> Discord</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card hover p-2 h-100">
                <h1 class="text-center card-title text-body-emphasis">O Site</h1>
                <p>Graças aos nossos Doadores, o site continua de pé até hoje, se você quer apoiar esse projeto que
                    tanto amamos, temos o Apoia.se</p>
                <div class="text-center mt-auto">
                    <a class="btn btn-primary" role="button" href="https://apoia.se/fichasop">
                          <span class="fa-stack">
                            <i class="text-danger fa-solid fa-square fa-stack-2x"></i>
                              <i class="fa-solid fa-a fa-stack-1x fs-5"></i>
                          </span>
                        Apoia.se
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card hover p-2 h-100">
                <h1 class="text-center card-title text-body-emphasis">Mobile</h1>
                <p>Pensando em facilitar a vida de quem procura jogar pelo celular, ou Presencialmente, criamos o
                    aplicativo do Fichasop.</p>
                <div class="text-center mt-auto">
                    <a href='https://play.google.com/store/apps/details?id=com.fichasop.app&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1'>
                        <img style="width: 120px" alt='Disponível no Google Play' src='https://play.google.com/intl/en_us/badges/static/images/badges/pt-br_badge_web_generic.png'/>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <div class="text-center mt-3"><h1 class="" style="font-size: calc(4vh+4vw)">Teste Aqui!</h1></div>
        <p class="text-center">Clique nos números do pentagrama para testar!</p>

    </div>
    <div class="my-5">
        <div class="row g-3">
            <div class="col-lg col-6 order-1 order-lg-0">
                <div class="card h-100 p-2 painel position-relative">
                    <div class="layer">
                        <div class="p-1">
                            <h3 class="text-center" style="font-size: calc(2vh + 2vw)">O Painel de Mestre</h3>
                            <p class="text-info" style="font-size: calc(2vh + 0.5vw)">Consta com ferramentas como:</p>
                            <ul style="font-size: calc(2vh + 0.5vw)">
                                <li>Fichas de NPC/Criaturas</li>
                                <li>Ultimos Testes</li>
                                <li>Iniciativas</li>
                                <li>Anotações</li>
                                <li>e muito mais!</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-auto col-12 order-0 order-lg-1">
                <div class="card h-100">
                    <div class="m-2 position-relative">
						<?= atributos(1, 2, 3, 4, 5) ?>
                    </div>
                </div>

            </div>
            <div class="col-lg col-6 order-2 order-lg-2">
                <div class="card h-100 p-2 portraits position-relative">
                    <div class="layer">
                        <div class="p-1">
                            <h3 class="text-center" style="font-size: calc(2vh + 2vw)">Portraits</h3>
                            <p class="text-info" style="font-size: calc(2vh + 0.5vw)">Para streamar ou para gravar vídeos, como desejar! incluem portraits:</p>
                            <ul style="font-size: calc(2vh + 0.5vw)">
                                <li>1 Especial FichasOP</li>
                                <li>2 Especial Parceiros</li>
                                <li>2 Baseado em ONSF</li>
                                <li>1 Baseando em OPD</li>
                                <li>1 Baseando em OPC</li>
                                <li>1 Baseado em OSNI</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once RootDir . "sessao/include_geral/modal_dice.php"; ?>
<?php require_once RootDir . "includes/scripts.php"; ?>
<?php require_once RootDir . "sessao/include_geral/scripts.php"; ?>
<script>
    $(() => {
        function glitch() {
            let letra = Math.floor(Math.random() * 9);
            $($(".fichasop span")[letra]).removeClass("font6").addClass("sigilos");
            setTimeout(() => {
                $($(".fichasop span")[letra]).removeClass("sigilos").removeClass("sinais").addClass("font6");
            }, 500)
            setTimeout(glitch, 2000)
        }

        function glitch2() {
            let letra2 = Math.floor(Math.random() * 9);
            $($(".fichasop span")[letra2]).removeClass("font6").addClass("sinais");
            setTimeout(() => {
                $($(".fichasop span")[letra2]).removeClass("sigilos").removeClass("sinais").addClass("font6");
            }, 500)
            setTimeout(glitch2, 2000)
        }

        glitch();
        setTimeout(glitch2, 250);
    })
</script>
<?php /*
<main class="container-fluid marketing my-5">
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
                                    <li>
                                        <a class="link-secondary" href="https://twitter.com/mestrepedrok">MestrePedrok</a>
                                    </li>
                                    <li><a class="link-secondary" href="https://twitter.com/silandcrafts">Sil</a></li>
                                    <li><a class="link-secondary" href="https://twitter.com/CtrlAltDella">Felipe Della
                                            Corte</a></li>
                                    <li><a class="link-secondary" href="https://twitter.com/bastet_min">Bastet</a></li>
                                    <li><a class="link-secondary" href="https://twitter.com/iamKalera">Kalera</a></li>
                                    <li><a class="link-secondary" href="https://twitter.com/MongeHan">Monge Han</a></li>
                                    <li><a class="link-secondary" href="https://twitter.com/jooanadart">Jooana d'Art</a>
                                    </li>
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
					<?= atributos(1, 2, 3, 4, 5,1,0,0,0,"dark") ?>
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
</main>
 */ ?>
</body>
</html>
