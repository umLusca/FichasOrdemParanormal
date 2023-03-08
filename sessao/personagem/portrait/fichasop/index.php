<?php
require_once "./../../../../config/includes.php";
require_once "./../../ficha/aconfig_ficha.php";
?>
<!DOCTYPE html>
<html lang="br">
<head>
	<?php require_once RootDir . 'includes/head.html'; ?>
    <meta charset="UTF-8">
    <title><?= $nome ?> - Portrait FichasOP</title>
	<?php require_once RootDir . "includes/scripts.php"; ?>
    <style>
        .portrait {
            position: relative;
            width: -webkit-fill-content;
            height: 1000px;
        }

        .personagem {
            overflow: hidden;
            position: absolute;
            height: 839px;
            width: 839px;
            margin-left: 36px;
            margin-top: 36px;
        }

        .personagem .foto {
            height: 100%;
            width: 100%;
        }

        .breath {
            a animation: breath 4s infinite;
        }

        .morto .breath {
            animation: breath 4s paused;
        }

        .marca {
            overflow: hidden;
            position: absolute;
            height: 839px;
            width: 839px;
            margin-left: 36px;
            margin-top: 36px;
        }

        .marca .foto {
            height: 100%;
            width: 100%;
        }

        .fundo {
            margin-top: 5px;
            margin-left: 5px;
            position: absolute;
            width: 900px;
            height: 900px;
        }

        .fundo .foto {
            height: 100%;
            width: 100%;
        }


        .status {
            position: absolute;
            margin-top: 195px;
            margin-left: 866px;
            border: 40px solid #040404;
            width: -webkit-fill-available;
            border-image: url('/assets/img/borda_portrait.png') 40 / 40px round;
        }

        .status .progress {
            height: 210px;
            background-color: var(--bs-dark);
        }

        .status .progress span {
            position: absolute;
            font-size: 140px;
            color: white;
            transform: translate(-50%, -50%) !important;
            left: 50%;
            top: 50%;
        }

        .status div.contain {
            position: relative;
            overflow: hidden;
        }

        .status .progress img {
            position: absolute;
            width: 120%;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 50%;
            opacity: 75%;

        }

        .status .progress .progress-bar {
            height: 100%;
        }


        .status .PV.progress .progress-bar {
            background-color: #620000;
        }

        .status .SAN.progress .progress-bar {
            background-color: #000359;
        }

        .status .PE.progress .progress-bar {
            background-color: #e5d100;
        }

        .nome {
            text-align: center;
            position: absolute;
            margin-top: 0;
            margin-left: 866px;
            width: -webkit-fill-available;
            text-shadow: 0px 0px 20px;
        }

        .nome h2 {
            bottom: 0;
            font-size: 150px;
            font-family: initial;
        }

        .show {
            animation: show 3s linear forwards;
        }

        .bg-danger-a {
            background-color: #af0000;
        }

        .bg-danger-dark {
            background-color: #421317;
        }

        .bg-primary-a {
            background-color: #1138de;
        }

        .bg-primary-dark {
            background-color: #14225c;
        }

        .cor-dado {
            color: #691119;
        }

        .cor-resultado {
            color: #ffd600;
        }


        .morto .pri {
            animation: morto 2s linear forwards;
        }

        .morto .sec {
            animation: sec 2s linear forwards;
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

    function tick() {
        updtsaude()
        const element = (
            <div className="portrait">
                    <div className="status">
                        <div className="contain">
                            <div className="PV progress rounded-0">
                                <div className="progress-bar sec" role="progressbar" style={{

                                    width: percent(pva, pv) + '%'
                                }}></div>
                                <span className="sec">{pva}/{pv}</span>
                            </div>
                        </div>
                        <div className="contain">
                            <div className="SAN progress rounded-0">
                                <div className="progress-bar sec" role="progressbar" style={{

                                    width: percent(sana, san) + '%'
                                }}></div>
                                <span className="sec">{sana}/{san}</span>
                            </div>
                        </div>
                        <div className="contain">
                            <div className="PE progress rounded-0">
                                <div className="progress-bar sec" role="progressbar" style={{

                                    width: percent(sana, san) + '%'
                                }}></div>
                                <span className="sec">{sana}/{san}</span>
                            </div>
                        </div>
                    </div>

                    <div className="nome text-nowrap">
                        <h2>{nome}</h2>
                    </div>

                    <div className="fundo">
                        <img className="foto" src='/assets/img/fundo_fichasop.png'/>
                    </div>

                    <div className="marca">
                        {(marca) ? <img className="foto pri" src={marca}/> : ""}
                    </div>
                    <div className="personagem">
                        <img className="foto breath pri" src={foto}/>
                    </div>
                    <div className="dado">
                        <span className="resultado"></span>
                    </div>
            </div>);
        portrait.render(element);
    }

    tick();
</script>
</body>
</html>