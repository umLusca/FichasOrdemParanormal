<?php
$portrait = "public";
require_once "./../../../../config/includes.php";
require_once "./../../ficha/aconfig_ficha.php";
if ($dados_missao["id"] != 5887) {
	header("Location: ./..");
}
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
            width: 1000px;
            height: 1000px;
            margin: -5% -5%;
        }

        .personagem {
            position: absolute;
            height: 69.5%;
            width: 69.5%;
            margin: 24.75%;
            border-radius: 0% 0% 100% 100%;
        }

        .fundo {
            position: absolute;
            width: 75%;
            height: 75%;
            margin: 22%;
        }

        .marca {
            position: absolute;
            width: 135%;
            height: 135%;
            margin: 8%;
            opacity: 75%;
        }

        .vida {
            position: absolute;
            margin-top: 58%;
            margin-left: 91%;
            border: 20px solid black;
        }

        .san {
            position: absolute;
            margin-top: 75%;
            margin-left: 73.5%;
            border: 20px solid black;
        }

        .pef {
            position: absolute;
            height: 30%;
            width: 30%;
            margin-top: 70%;
            margin-left: 71%;
        }

        .pea {
            position: absolute;
            font-size: 150px;
            text-align: center;
            margin: 71% 75%;
            width: 23%;
            height: 23%;
            font-weight: bolder;
            text-shadow: 0px 0px 20px;
        }

        .pva {
            position: absolute;
            margin-top: 60%;
            margin-left: 93%;
            width: 128%;
            height: 15%;
            font-weight: bolder;
            text-shadow: 0px 0px 20px;
        }

        .nome {
            position: absolute;
            margin-top: 44%;
            margin-left: 94%;
            width: 128%;
            height: 15%;
            font-weight: bolder;
            text-shadow: 0px 0px 20px;
        }

        .sana {
            position: absolute;
            margin-top: 77%;
            margin-left: 93.5%;
            width: 128%;
            height: 15%;
            font-weight: bolder;
            text-shadow: 0px 0px 20px;
        }

        .dado {
            position: absolute;
            margin-top: 40%;
            margin-left: 45%;
            width: 300px;
            height: 300px;
        }

        .show {
            animation: show 3s linear forwards;
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

        .breath {
            animation: breath 4s infinite;
        }

        @keyframes breath {
            0% {
                height: 69.5%;
                top: 0;
            }
            35% {
                height: 71.5%;
                top: -2%;
                transform: rotate(0.5deg)
            }
            60% {
                height: 70.5%;
                top: -1%;
                transform: rotate(0deg)
            }
            100% {
                height: 69.5%;
                top: 0;
            }
        }
        @keyframes dado {

            0% {
                opacity: 0;
            }
            10% {
                opacity: 100%;
            }
            80% {
                opacity: 100%;
                font-size: 200px;
            }
            100% {
                font-size: 0px;
                opacity: 0;
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

        .pri.morto {
            animation: morto 2s linear forwards;
        }

        .sec.morto {
            animation: sec 2s linear forwards;
        }

        #portrait {
            margin: 5%;
        }
        .show-resultado{
            animation: dado 2.7s linear;
            font-size: 200px;
            color: #ffffff;
        }
    </style>
</head>
<body class="bg-transparent">
<main id="portrait">

</main>
<?php
require_once RootDir . "includes/scripts.php";
?>
<script>
    $(document).ready(function () {
        $('.progress-bar').each(function () {
            var $this = $(this);
            var percent = $this.attr('percent');
            $this.css("width", percent + '%');
            $({animatedValue: 0}).animate({animatedValue: percent}, {
                duration: 2000,
                step: function () {
                    $this.attr('percent', Math.floor(this.animatedValue) + '%');
                },
                complete: function () {
                    $this.attr('percent', Math.floor(this.animatedValue) + '%');
                }
            });
        });

        /*
			var interval = 5000;   //number of mili seconds between each call
			var refresh = function() {
				$('#detalhes').load(' #detalhes>*');
				setTimeout(function() {
					refresh();
				}, interval);
			}
			refresh();
		*/
    });
    socket = io('https://portrait.fichasop.com', {
        reconnectionDelay: 5000,
        transports: ['websocket', 'polling', 'flashsocket']
    });
    socket.on('connect', function () {
        console.log("Conectado.")
    });
    socket.emit('create', '<?=$fichat?>');
    socket.on('<?=$fichat?>', function (msg) {
        if (msg.dado) {
            valordado = msg.dado.result;
            subtimer();
        }
        if (msg.vida) {
            pv = msg.vida.pv;
            pva = msg.vida.pva;
            san = msg.vida.san;
            sana = msg.vida.sana;
            pea = msg.vida.pea;
            mor = msg.vida.mor
            tick();
        }
        console.log(msg);
    });
</script>
<script src="https://unpkg.com/babel-standalone@6/babel.min.js" data-cfasync="false"></script>
<script src="https://unpkg.com/react@18/umd/react.development.js" crossorigin data-cfasync="false"></script>
<script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js" crossorigin data-cfasync="false"></script>
<script type="text/babel">
    const portrait = ReactDOM.createRoot(
        document.getElementById('portrait')
    );
    let pv = <?=$pv?>;
    let pva = <?=$pva?>;
    let san = <?=$san?>;
    let sana = <?=$sana?>;
    let pea = <?=$pea?>;
    let mor = <?=$morrendo?>;
    let foto = "<?=$morrendo ? $urlphotomor : ($enlouquecendo ? $urlphotoenl : ($ppv < 50 ? ($urlphotofer ?: $urlphoto) : $urlphoto));?>";
    let marca = "https://fichasop.com/assets/img/Espiral.webp";
    let morto = '<?=$morrendo ? ' morto' : ''?>';
    let elemento = '<?=$elemento?>';
    let dado;
    let valordado = '';
    let nome = '<?=$nome?>';
    let dadourl=<img />;
    function roll(){
        tick()
    }
    function subtimer() {
        clearTimeout(time);
        time = setTimeout(show, timer);
    }
    function show() {
        dadourl=(<img className="fundo" src='/assets/img/nevergonnagiveup.gif'/>);
        setTimeout(hide, 6510);
        setTimeout(dadores, 3810)
        tick();
    }
    function dadores(){
        console.log("AGORA");
        dado = 'show-resultado';
        tick();
    }
    function hide() {
        dadourl = '';
        dado ='';
        tick();
    }

    const timer = 3000;
    let time;



    function updtsaude() {
        if (mor === 1) {
            morto = ' morto';
        } else {
            morto = '';
        }
        if (pva === 0) {
            foto = "<?=$urlphotomor?>"
        } else {
            if (sana <= 0) {
                foto = "<?=$urlphotoenl?>";
            } else {
                if (percent(pva, pv) < 50) {
                    foto = "<?=$urlphotofer?>";
                } else {
                    foto = "<?=$urlphoto?>";
                }
            }
        }
    }

    function percent(max, min = 0) {
        if ((max === 0 && min === 0) || max === 0) {
            return 0;
        }
        var p = (max / min) * 100;
        if (p > 100) {
            return 100;
        } else {
            return p;
        }
    }

    function tick() {
        updtsaude()
        const element = (

            <div className="portrait">
                <div>
					<?php //<span className="nome text-center text-white fs-0 font9">{nome}</span>
					?>
                    <div style={{width: 275 + '%', position: 'absolute', height: 1 + 'px'}}></div>
                    <div className="vida progress h-auto bg-danger-dark border-dark" style={{width: 132.5 + '%'}}>
                        <div className="progress-bar bg-danger-a text-end" id="progresssan" role="progressbar"
                             style={{height: 150 + 'px', width: percent(pva, pv) + '%'}}></div>
                        <img className={"position-absolute start-50 top-50 translate-middle sec" + morto}
                             style={{width: "120%"}} src='/assets/img/vida.webp'/>
                    </div>
                    <span className="pva text-center text-white fs-0">{pva}/{pv}</span>
                    <div className="san progress h-auto bg-primary-dark border-dark" style={{width: 150 + '%'}}>
                        <div className="progress-bar bg-primary-a text-end" id="progresssan" role="progressbar"
                             style={{height: 150 + 'px', width: percent(sana, san) + '%'}}></div>
                        <img className={"position-absolute start-50 top-50 translate-middle sec" + morto}
                             style={{width: "120%"}} src='/assets/img/sanidade.webp'/>
                    </div>
                    <span className="sana text-center text-white fs-0">{sana}/{san}</span>
                    <img className="fundo" src='/assets/img/fundo1.webp'/>
                    <img className={"marca start-50 top-50 translate-middle pri" + morto} src={marca}/>
                    <img className={"breath personagem pri" + morto} src={foto}/>
                    <img className="pef " src='/assets/img/fundo2.webp'/>
                    <div className="pea">
                        <span className="text-warning font8">{pea}</span>
                    </div>
                    {dadourl}
                    <div className={"dado " + dado}><span className="position-absolute top-50 start-50 translate-middle">{valordado}</span></div>
                </div>
            </div>);
        portrait.render(element);
    }

    tick();
</script>
</body>
</html>