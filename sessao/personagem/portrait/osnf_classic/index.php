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
            width: 2400px;
            height: 1000px;
            margin: 5%;
        }

        .personagem {
            overflow: hidden;
            position: absolute;
            height: 900px;
            width: 850px;
            margin-left: 2%;
            margin-top: -0.5%;
            border-radius: 0 0 50% 50%;
        }

        .personagem .foto {
            height: 100%;
            width: 100%;
        }

        .marca {
            overflow: hidden;
            position: absolute;
            width: 852px;
            height: 852px;
            margin-left: 1.9%;
            margin-top: 1%;
            opacity: 75%;
            border-radius: 0 0 50% 50%;
        }

        .marca .foto {
            height: 100%;
            width: 100%;
        }

        .fundo {
            margin-top: 1%;
            margin-left: 1%;
            position: absolute;
            height: 900px;
        }

        .background {
            margin-top: 1%;
            margin-left: 1%;
            position: absolute;
            height: 900px;
            width: 2321.39px;
        }

        .fundo .foto, .background .foto {
            height: 100%;
            width: 100%;
        }


        .status {
            position: absolute;
            margin-top: 19.5%;
            margin-left: 21%;
            margin-right: 6.75%;
            width: -webkit-fill-available;
        }

        .status .progress {
            height: 190px;
            margin-left: 23%;
            border: 10px solid #040404;
            opacity: 0.5;
        }
        .status div.contain {
            position: relative;
            overflow: hidden;
        }

        .status .progress span {
            position: absolute;
            font-size: 140px;
            color: white;
            transform: translate(+50%, -50%) !important;
            right: 700px;
            top: 50%;
        }

        .status .progress .progress-bar {
            height: 100%;
        }

        .status .PV.progress {
            margin-left: 21.5%;
        }

        .status .SAN.progress {
            margin-left: 13%;
        }

        .status .PV.progress .progress-bar {
            background-color: red;
        }

        .status .SAN.progress .progress-bar {
            background-color: #000359;
        }


        .PE {
            position: absolute;
            margin-top: 9%;
            margin-left: 85%;
            height: 256px;
            width: 256px;
        }

        .PE span {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%) !important;
            font-size: 150px;
            text-shadow: 1px 1px 10px;
            color: #8a7800;
        }


        .nome {
            text-align: left;
            position: absolute;
            margin-top: 11.9%;
            margin-left: 39%;
            width: 48%;
        }

        .nome h2 {
            bottom: 0;
            font-size: 130px;
            color: black;
            font-family: initial;
        }

        @keyframes sprite {
            from {
                background-position: 0;
            }
            to {
                background-position: -23296px;
            }
        }

        @keyframes show {
            0% {
                left: 0%;
            }
            25% {
                left: 50%;
            }
            75% {
                left: 50%;
            }
            100% {
                left: 0%;
            }
        }

        .fs-0 {
            font-size: 100px;
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
                    <div className="background sec">
                        <img className="foto" src='/assets/img/osnf_classic.png'/>
                    </div>

                    <div className="status">
                        <div className="contain">
                            <div className="PV progress rounded-0 sec">
                                <div className="progress-bar" role="progressbar" style={{
                                    width: percent(pva, pv) + '%'
                                }}></div>
                                <span>{pva}/{pv}</span>
                            </div>
                        </div>
                        <div className="contain">
                            <div className="SAN progress rounded-0 sec">
                                <div className="progress-bar" role="progressbar" style={{
                                    width: percent(sana, san) + '%'
                                }}></div>
                                <span>{sana}/{san}</span>
                            </div>
                        </div>
                    </div>

                    <div className="fundo sec">
                        <img className="foto" src='/assets/img/fundo4.png'/>
                    </div>

                    <div className="nome text-nowrap text-truncate">
                        <h2>{nome.toUpperCase()}</h2>
                    </div>

                    <div className="marca">
                        {(marca) ? <img className="foto pri" src={marca}/> : ""}
                    </div>
                    <div className="personagem">
                        <img className="foto pri" src={foto}/>
                    </div>

                    <div className="PE sec">
                        <span>{pea}</span>
                    </div>
                <div className="dado">
                    <span className="resultado"></span>
                </div>

            </div>);
        portrait.render(element);
    }

</script>
</body>
</html>