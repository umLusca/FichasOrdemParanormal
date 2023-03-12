<?php
require_once "./config/includes.php";
header("X-Robots-Tag: all");
if (!empty($_FILES)) {
	echo save_image($_FILES["feru"], "");
}

?>
<!doctype html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <!-- Required meta tags -->
    <title>Fichas Ordem Paranormal</title>
	<?php require_once './includes/head.html'; ?>
    <style>
        /*
		Criado por Lucas Pinheiro.
		https://github.com/LucasMeGames
	*/
        *:has(.form-select, .form-control, [list]) {
            position: relative;
        }

        input[list] + div[list] {
            display: none;
            position: absolute;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            border-radius: 0 0 .375rem .375rem;
            z-index: 100;
            border: var(--bs-border-width) var(--bs-border-style) #86b7fe;
            border-top: 0px;
            box-shadow: 0px 3px 0 0.25rem rgb(13 110 253 / 25%); /* backdrop-filter: blur(3px);*/
            background: var(--bs-body-bg);
        }

        input[list] + div[list] option {
            display: block;
            padding: 7px 5px 7px 20px;
            color: var(--bs-body-color); /*color: #101010;text-shadow: black 0 0 3px;*/
            font-size: 1rem;
            cursor: pointer;
        }

        input[list] + div[list] option:not([style*="display: none"]) + option {
            border-top: 1px solid var(--bs-emphasis-color);
        }

        input[list] + div[list] option:hover {
            background: rgba(104, 123, 143, 0.2);
        }

        .form-control[list]:has(+ div[list][style*=block]), .form-select[list]:has(+ div[list][style*=block]) {
            border-radius: .375rem .375rem 0 0;
            border-bottom: 0px;
        }

        label:has(div[list]) {
            position: relative;
        }
        div[list]{

        }



        /* Firefox */
        *  {
            scrollbar-width: thin;
            scrollbar-color: var(--bs-emphasis-color) #00000000;
        }

        /* Chrome, Edge and Safari */
        div[list]::-webkit-scrollbar {
            width: 5px;
        }
        div[list]::-webkit-scrollbar-track {
            background-color: #00000000;
        }

        div[list]::-webkit-scrollbar-track:hover {
            background-color: #00000000;
        }

        div[list]::-webkit-scrollbar-track:active {
            background-color: #00000000;
        }

        div[list]::-webkit-scrollbar-thumb {
            border-radius: 5px;
            background-color: var(--bs-secondary-color);
        }

        div[list]::-webkit-scrollbar-thumb:hover {
            background-color: var(--bs-tertiary-color);
        }

        div[list]::-webkit-scrollbar-thumb:active {
            background-color: var(--bs-emphasis-color);
        }

    </style>
</head>
<body class="">
<?php require_once RootDir . "includes/top.php"; ?>
<main class="first container m-5">
    <div>
        <input class="form-control" data-1l="datalist" list="teste"/>
    </div>
    <datalist id="teste">
        <option>A</option>
        <option>B</option>
        <option>C</option>
        <option>D</option>
    </datalist>
</main>
<?php require_once RootDir . "sessao/include_geral/modal_dice.php"; ?>
<?php require_once RootDir . "includes/scripts.php"; ?>
<?php require_once RootDir . "sessao/include_geral/scripts.php"; ?>
<script>

    function test() {
        $("input[data-1l=datalist][list]").each((i, e) => {
            console.log("datalist")
            let list_id = $(e).attr("list");
            
            $("<div />").attr("list",list_id).html($("datalist#" + list_id + " option")).insertAfter(e.currentTarget);
            /*
            let arr = "<div>";
            $("datalist#" + list_id + " option").each((ip, ep) => {
                arr += "<span>" + ep.textContent + "</span>";
            })
            arr += "</div>"
           
             */
            $(e).attr("list", list_id + i)
            //$(arr).insertAfter(e).attr("list", list_id + i);
        })
/*
        $("select[data-1l=select]").each((i, e) => {
            let list_id = $(e).attr("id") ? $(e).attr("id") + i : "list" + i;
            $(e).attr("disabled", true).hide();

            let arr = "<div>";
            $(e).children("option").each((ip, ep) => {
                arr += "<span value='"+($(ep).attr("value")??'')+"'>"+($(ep).attr("value")?$(ep).attr("value")+" - ":'')+ ep.textContent + "</span>";
            })
            arr += "</div>"
            $(e).attr("list", list_id);
            $(arr).insertAfter($("<input readonly list='"+list_id+"' />").insertAfter(e).attr("id", $(e).attr("id")).attr("class", $(e).attr("class"))).attr("list", list_id);
        })
        */
    }
    $(() => {

        //test()

/*
        $(document).on("keydown", 'input[list]', function (event) { //Evita enviar formulário
            if (event.key === "Enter") {
                event.preventDefault();
                return false;
            }
        });
        $(document).on('blur', 'input[list]', function (event) { //Encolhe menu
            event.preventDefault();
            const list = $(this).attr('list');
            setTimeout(function () {
                $('div[list=' + list + ']').slideUp(100);
            }, 100);
        });
        $(document).on('click', 'input[list]', function (event) { //Aparece Menu
            event.preventDefault();
            const str = $(this).val();
            const list = $(this).attr('list');
            let found = false;
            $('input.form-control+div[list=' + list + '] option').each((i, e) => {
                if ($(e).html().toLowerCase().indexOf(str.toLowerCase()) < 0) {
                    $(e).hide();
                } else {
                    found = true;
                }
            });
            console.log(found)
            if (found) {
                $('div[list=' + list + ']').slideToggle(200);
            } else {
                $('div[list=' + list + ']').slideUp(200);
            }
            $(this).focus();
        });
        $(document).on('click', 'div[list] option', function (event) { // Escolhe opção (click)
            event.preventDefault();
            const list = $(this).parent().attr('list');
            const item = $(this).html();
            if ($(this).attr("value")) {
                $('input[list=' + list + ']').val($(this).attr("value"));
            } else {
                $('input[list=' + list + ']').val(item);
            }
            $('div[list=' + list + ']').slideUp(100);
        });
        $(document).on('keyup', 'input[list]', function (event) { //Atualiza opções
            let str;
            event.preventDefault();
            event.stopPropagation();
            const list = $(this).attr('list');
            const divList = $('div[list=' + list + ']');

            switch (event.key) {
                case "Escape":
                    $(divList).slideUp(200);
                    $(this).focus();
                    break;
                case "Enter":
                    if ($('input.form-control+div[list=' + list + '] option:visible').length > 1) { //Escolhe a primeira opção
                        if ($('input[list=' + list + ']').is(":visible")) {
                            let first = $('div[list=' + list + '] option:visible')[0];
                            let value = $(first).attr("value") ? $(first).attr("value") : $(first).text();
                            $('input[list=' + list + ']').val(value);
                            $('div[list=' + list + ']').slideUp(100);
                        }
                    }
                    return false;
                    break;
                case "Tab":
                    $('div[list]').slideUp();
                    break;
                default:
                    str = $(this).val();

                    let found = false;


                    $('input.form-control+div[list=' + list + '] option').each(function () {
                        if ($(this).html().toLowerCase().indexOf(str.toLowerCase()) < 0) {
                            $(this).slideUp(200);
                        } else {
                            $(this).slideDown(200);
                            found = true;
                        }
                    });
                    if (found) {
                        console.log("found")
                        $('input.form-control+div[list=' + list + ']').slideDown();
                    } else {
                        console.log("not found")
                        $('input.form-control+div[list=' + list + ']').slideUp(0);
                    }
                    break;
            }
        })
        */
        
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
