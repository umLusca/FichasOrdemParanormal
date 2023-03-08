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
        
        .portrait {
            position: relative;
            height: 1000px;
            width: 1500px;
        }

        .fundo {
            position: absolute;
            width: 900px;
            height: 900px;
        }

        .fundo img {
            height: 100%;
            width: 100%;
        }

        .personagem {
            overflow: hidden;
            position: absolute;
            height: 835px;
            width: 832px;
            margin: 2.25%;
        }

        .personagem img {
            position: absolute;
            height: 100%;
            width: 100%;
        }

        .marca {
            overflow: hidden;
            position: absolute;
            height: 835px;
            width: 832px;
            margin: 2.25%;
            border-radius: 0 0 50% 50%;
        }

        .marca img {
            height: 100%;
            width: 100%;
        }
        .status {
            font-size: 200px;
        }
        .pva {
            position: absolute;
            margin-top: 20%;
            margin-left: 50%;
            transform: rotate(-15deg);
        }
        .sana {
            position: absolute;
            margin-top: 33%;
            margin-left: 50%;
            transform: rotate(-15deg);
        }


        .nome {
            position: absolute;
            margin-top: 20%;
            margin-left: 50%;
            line-height: 0.8;
            transform: rotate(-15deg);
            color: #cad1d7;
        }



        .fs-0 {
            font-size: 200px;
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
            margin: 5%;
        }

        .PE {
            background-image: url('/assets/img/fundo2.png');
            background-position: center; /* Center the image */
            background-size: cover; /* Resize the background image to cover the entire container */
            position: absolute;
            margin-top: 40%;
            margin-left: -5%;
            width: 400px;
            height: 400px;
        }

        .PE span {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%) !important;
            font-size: 120px;
            text-shadow: 1px 1px 10px;
            color: rgb(255, 193, 7);
        }
        .teste {
            -webkit-mask-image: url('/assets/img/fundo3.webp');
            mask-image: url('/assets/img/fundo3.webp');
            -webkit-mask-size: 100%;
            mask-size: 100%;
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
        }
        .breath {
            animation: breath 4s infinite;
        }

        .morto .breath {
            animation: breath 4s paused;
        }
        @keyframes breath {

            0% {
                transform: scaleY(100%) translateY(0) rotate(0);
            }
            60% {
                transform: scaleY(102%) translateY(-1%) rotate(-1deg);
            }
            90% {
                transform: scaleY(99.5%) translateY(0.25%) rotate(0.5deg);
            }
        }


        .dado {
            transform: scale(155%) translate(-50%,-50%);
            display: none;
            position: absolute;
            margin-top: 602px;
            margin-left: 602px;
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
        console.log("teste");
        updtsaude()
        const element = (
            <div className="portrait">
                <div>
                    <div className="fundo">
                    </div>
                    <div className="marca">
                    </div>
                    <div className="personagem pri teste">
                        {(marca) ? <img src={marca}/> : ""}
                        <img className="breath" src={foto}/>
                    </div>
                    <div className="PE">
                        <span className="">{pea}</span>
                    </div>
                    <div className="status">
                        {status["combate"] ?
                            (<div>
                                <span className="pva text-danger fs-0 font6">{pva}/{pv}</span>
                                <span className="sana text-primary fs-0 font6">{sana}/{san}</span>
                            </div>)
                            :
                            (<div className="nome fs-0 font7"><i>{nome}</i></div>)}
                    </div>

                    <div className="dado">
                        <span className="resultado"></span>
                    </div>
                </div>
            </div>);
        portrait.render(element);
    }

    tick();
</script>
</body>
</html>