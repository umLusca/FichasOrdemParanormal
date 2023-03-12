<?php
require_once "./../../../../config/includes.php";
require_once RootDir . "/sessao/personagem/ficha/aconfig_ficha.php";
?>
<!DOCTYPE html>
<html lang="br">
<head>
	<?php require_once RootDir . '/includes/head.html'; ?>
    <meta charset="UTF-8">
    <title><?= $nome ?> - Portrait FichasOP</title>
	<?php require_once RootDir . "/includes/scripts.php"; ?>
    <style>
        * {
            --primary-color: #<?=$_GET["cor"]?:"999999"?>;
        }

        .portrait {
            position: relative;
            width: 1000px;
            height: 1000px;
        }

        .personagem {
            position: absolute;
            height: 100%;
            width: 100%;
            margin: -10% 2%;
            filter: drop-shadow(0px 12px 7px var(--primary-color)) drop-shadow(0px -12px 7px var(--primary-color)) drop-shadow(12px 0px 7px var(--primary-color)) drop-shadow(-12px 0px 7px var(--primary-color));
        }

        .marca {
            position: absolute;
            width: 100%;
            height: 100%;
            margin: -10% 2%;
            opacity: 75%;
        }

        .pva {
            position: absolute;
            margin-top: 16%;
            margin-left: 80%;
            width: 75%;
            height: 27%;
            transform: rotate(-10deg);
            text-shadow: 0px 0px 20px;
        }
        .sana {
            position: absolute;
            margin-top: 36%;
            margin-left: 83%;
            width: 77%;
            height: 25%;
            transform: rotate(-10deg);
            text-shadow: 0px 0px 20px;
        }
        .pea {
            position: absolute;
            margin-top: 55%;
            margin-left: 90%;
            width: 77%;
            height: 25%;
            transform: rotate(-10deg);
            text-shadow: 0px 0px 20px;
        }

        .nome {
            position: absolute;
            margin-top: 25%;
            margin-left: 90%;
            width: 53%;
            height: 34%;
            line-height: 0.8;
            font-weight: lighter;
            transform: rotate(-10deg);
            color: var(--primary-color);
            text-shadow: 0 0 20px var(--primary-color);
        }



        @keyframes show {
            0% {
                top: 0%;
            }
            25% {
                top: -50%;
            }
            75% {
                top: -50%;
            }
            100% {
                top: 0%;
            }
        }

        .fs-0 {
            font-size: 300px;
        }

        .cor-dado {
            color: #691119;
        }

        .cor-resultado {
            color: #ffd600;
        }

        @keyframes morto {
            from {
                filter: brightness(100%);
            }
            to {
                filter: brightness(0%);
            }
        }

        @keyframes sec {
            from {
                filter: brightness(100%);
            }
            to {
                filter: brightness(30%);
            }
        }

       .morto .pri {
            animation: morto 2s linear forwards;
        }

       .morto .sec {
            animation: sec 2s linear forwards;
        }

        #portrait {
            margin: 10%;
        }


        .dado {
            transform: scale(170%) translate(-50%,-50%);
            display: none;
            position: absolute;
            margin-top: 602px;
            margin-left: 700px;
            width: 540px;
            height: 540px;
        }
        .dado .resultado {
            text-align: center;
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .active.dado {
            display: unset;
        !important;
            background-image: url('/assets/img/sprite_dados.png');
            animation: anim 6750ms steps(217);
            opacity: 0%;
        }
        .active.dado .resultado {
            display: unset;
        !important;
            animation: dado 6750ms linear;
            font-size: 200px;
            opacity: 0%;
            color: #ffffff;
        }
        @keyframes sprite {
            from {
                background-position: 0;
            }
            to {
                background-position: -23296px;
            }
        }
        @keyframes dado {

            0%, 60% {
                opacity: 0%;
            }

            70%, 90% {
                opacity: 100%;
                font-size: 200px;
            }
            100% {
                font-size: 0;
                opacity: 0%;
            }
        }
        @keyframes anim {
            0% {
                background-position: 0;
                opacity: 0%;
            }
            25% {
                opacity: 100%;
            }
            100% {
                opacity: 100%;
                background-position: -117180px;
            }
        }

    </style>
</head>
<body class="bg-transparent">
<main id="portrait"></main>
<?php
require_once RootDir . "includes/scripts.php";
require_once "./../includes/scripts.php";
?>

<script type="text/babel">
   function hide() {
        dado = '';
        tick();
    }

    function show() {
        dado = 'show';
        setTimeout(hide, 3000);
        tick();
    }


    function tick() {
        updtsaude()
        const element = (
                <div className="portrait">
                    <div>
                        <div style={{width: 275 + '%', position: 'absolute', height: 1 + 'px'}}></div>
                        {
                            (marca) ?
                                <img className={"marca start-50 top-50 translate-middle pri"} src={marca}/> : ""
                        }
                        <img className={"personagem pri"} src={foto}/>
                        {
                            status["combate"] ?
                                <div>
                                    <span className="pva text-center text-danger fs-0 desconjuras">{pva}/{pv}</span>
                                    <span className="sana text-center text-primary fs-0 desconjuras">{sana}/{san}</span>
                                    <span className="pea text-center text-warning fs-0 desconjuras">{pea}/{pe}</span>
                                </div>
                                :
                                <div className="nome text-center fs-0 desconjuras">
                                    <span>{nome}</span>
                                </div>
                        }

                        <div className="dado">
                            <span className="resultado"></span>
                        </div>
                    </div>
                </div>);
        portrait.render(element);
    }

</script>
</body>
</html>