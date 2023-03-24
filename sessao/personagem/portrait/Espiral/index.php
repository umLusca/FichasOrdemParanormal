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
            width: 2500px;
            height: 1000px;
            margin: 5%;
        }

        .fundo {
            position: absolute;
            width: 1000px;
            margin: 1%;
        }

        .personagem {
            position: absolute;
            overflow: hidden;
            height: 930px;
            width: 930px;
            margin: 60px;
            border-radius: 0% 0% 100% 100%;
        }

        .personagem img {
            height: 100%;
            width: 100%;
        }

        .marca {
            position: absolute;
            width: 1000px;
            margin: 1%;
            opacity: 75%;

        }

        .nome {
            position: absolute;
            margin-top: 30%;
            margin-left: 38%;
            width: 62%;
            height: 15%;
            font-size: 170px;
            color: white;
        }

        .morto .nome {
            font-family: Sigilos;
        }

        .breath {
            animation: breath 4s infinite;
        }

        .morto .breath {
            animation: breath 4s paused;
        }

        .morto .pri {
            animation: morto 2s linear forwards;
        }

        .morto .sec {
            animation: sec 2s linear forwards;
        }

        .status {
            position: absolute;
            margin-top: 12%;
            margin-left: 20%;
            border: 20px solid black;
            width: -webkit-fill-available;
        }

        .status .progress {
            position: relative;
            height: 200px;
            margin-left: 23%;
            background-color: var(--bs-dark);
        }

        .status .progress .progress-bar {
            height: 100%;
        }

        .status .PV.progress {
            margin-left: 23%;
        }

        .status .PV.progress .progress-bar {
            background-color: red;
            height: 100%;
        }

        .status div.contain {
            position: relative;
            overflow: hidden;
        }

        .status .progress span {
            position: absolute;
            font-size: 150px;
            color: white;
            transform: translate(-50%,-50%) !important;
            left: 50%;
            top: 50%;
        }

        .status .progress img {
            position: absolute;
            width: 120%;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 50%;
            opacity: 75%;

        }

        .status .SAN.progress {
            margin-left: 23%;
        }

        .status .SAN.progress .progress-bar {
            background-color: blue;
        }

        .PE {
            background-image: url('/assets/img/fundo2.png');
            background-position: center; /* Center the image */
            background-size: cover; /* Resize the background image to cover the entire container */
            position: absolute;
            margin-top: 29%;
            margin-left: -4%;
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

        .dado {
            transform: scale(150%);
            display: none;
            position: absolute;
            margin-top: 10%;
            margin-left: 10%;
            width: 540px;
            height: 540px;
        }

        .active.dado {
            display: unset;
        !important;
            background-image: url('/assets/img/sprite_dados.png');
            animation: anim 6750ms steps(217);
            opacity: 0;
        }

        .dado .resultado {
            text-align: center;
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .active.dado .resultado {
            display: unset;
        !important;
            animation: dado 6750ms linear;
            font-size: 200px;
            opacity: 0%;
            color: #ffffff;
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
<main id="portrait">

</main>
<?php
require_once RootDir . "includes/scripts.php";
require_once "./../includes/scripts.php";
?>
<script type="text/babel">
    marca = "/assets/img/Espiralr.png";


    function mostrarresultado(valor) {
        el = <div className="dado active"><span className="resultado">{resultado}</span></div>;

        setTimeout(() => {
            el = <div/>;
        }, 6750);
    }

    function tick() {
        updtsaude()
        const element = (
            <div className="portrait">
                <span className="nome font5">{nome}</span>
                <div style={{width: 275 + '%', position: 'absolute', height: 1 + 'px'}}></div>
                <div className="status">
                    <div className="contain">
                        <div className="PV progress rounded-0">
                            <div className="progress-bar sec" role="progressbar" style={{
                                width: percent(pva, pv) + '%'
                            }}></div>
                            <img src="/assets/img/vida.webp" className="sec"/>
                            <span>{pva}/{pv}</span>
                        </div>
                    </div>
                    <div className="contain">
                        <div className="SAN progress rounded-0">
                            <div className="progress-bar sec" role="progressbar" style={{
                                width: percent(sana, san) + '%'
                            }}></div>
                            <img src="/assets/img/sanidade.webp" className="sec"/>
                            <span>{sana}/{san}</span>
                        </div>
                    </div>
                </div>
                <img className="fundo" src='/assets/img/fundo1.webp'/>
                {(marca) ? <img className="marca pri" src={marca}/> : ""}
                <div className="personagem pri">
                    <img className="breath" src={foto}/>
                </div>
                <div className="PE">
                    <span>{pea}</span>
                </div>
                {el}
            </div>);
        portrait.render(element);
    }

</script>
</body>
</html>