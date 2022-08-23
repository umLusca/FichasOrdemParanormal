<?php
require_once "./config/includes.php";
header("X-Robots-Tag: all");
if(isset($_POST["status"])) {

if($_POST["status"] == 'roll'){
		$dado = DadoDinamico(cleanstring($_POST["dado"], 50));
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

<html lang="pt-BR">
<head>
    <!-- Required meta tags -->
    <title>Fichas Ordem Paranormal</title>
    <link rel="stylesheet" href="/assets/css/carousel.css">
    <?php require_once './includes/head.html'; ?>
</head>
<body class="bg-black text-light">
<style>
    body {
        padding-top: 3rem;
        padding-bottom: 3rem;
        color: #5a5a5a;
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

</style>
<?php require_once RootDir."includes/top.php"; ?>
<main>
    <div class="container marketing my-5">
        <div class="row">
            <div class="col-lg-4">
                <img src="/assets/img/Leandro - home.webp" width="150" height="150" class="rounded-circle mx-3 border border-1 border-white">
                <h2>Comece criando sua conta</h2>
                <p>Crie suas fichas, mestre as suas missões tudo isso de forma GRATIS!</p>
                <button class="btn btn-outline-success font1" data-bs-toggle="modal" data-bs-target="#cadastrar">Criar conta</button>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
                <h3 class="text-info ">Clique abaixo para testar!</h3>
                <div class="container-fluid p-0 mb-2">
                    <div class="containera mx-auto text-white">
                        <?=atributos(1,2,3,4,5)?>
                    </div>
                </div>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
                    <img src="/assets/img/foto.webp" width="150" height="150"
                         class="bg-dark rounded-circle mx-3 border border-1 border-white">
                    <h2>Comunidade</h2>
                <p>Entre no nosso discord e entre na nossa comunidade de ordem</p>
                <a class="btn btn-outline-primary font1" href="https://discord.gg/gHaAxqC2Hw">Discord</a>
            </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->
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
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6313203873487938"
                crossorigin="anonymous"></script>
        <ins class="adsbygoogle"
             style="display:block; text-align:center;"
             data-ad-layout="in-article"
             data-ad-format="fluid"
             data-ad-client="ca-pub-6313203873487938"
             data-ad-slot="6594392300"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
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
        </div><script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6313203873487938"
                      crossorigin="anonymous"></script>
        <ins class="adsbygoogle"
             style="display:block; text-align:center;"
             data-ad-layout="in-article"
             data-ad-format="fluid"
             data-ad-client="ca-pub-6313203873487938"
             data-ad-slot="6594392300"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
        <hr class="featurette-divider">
        <div class="row featurette">
            <div class="col-md-7">
                <h2 class="featurette-heading">E por fim...</h2>
                <p class="lead">Não tem como deixar o principal de lado, sistema de rolar dados completissimo para você.</p>
            </div>
            <div class="col-md-5">
                <video src="/assets/video/video_atributos.webm" preload="none" width="500" height="500" playsinline autoplay
                       muted loop
                       class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto">

            </div>
        </div>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6313203873487938"
                crossorigin="anonymous"></script>
        <ins class="adsbygoogle"
             style="display:block; text-align:center;"
             data-ad-layout="in-article"
             data-ad-format="fluid"
             data-ad-client="ca-pub-6313203873487938"
             data-ad-slot="6594392300"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
        <hr class="featurette-divider">
        <amp-ad width="100vw" height="320"
                type="adsense"
                data-ad-client="ca-pub-6313203873487938"
                data-ad-slot="9589588282"
                data-auto-format="mcrspv"
                data-full-width="">
            <div overflow=""></div>
        </amp-ad>
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
<?php require_once RootDir."includes/scripts.php"; ?>
<?php require_once RootDir."sessao/include_geral/scripts.php"; ?>
</body>
</html>