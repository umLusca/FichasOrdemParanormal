<?php
require_once "./../../../../config/includes.php";
require_once RootDir."/sessao/personagem/ficha/aconfig_ficha.php";
?>
<!DOCTYPE html>
<html lang="br">
    <head>
        <?php require_once RootDir.'/includes/head.html';?>
        <meta charset="UTF-8">
        <title><?=$nome?> - Portrait FichasOP</title>
        <?php require_once RootDir."/includes/scripts.php";?>
        <style>
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
                border-radius: 0 0 50% 50%;
            }

            .fundo {
                position: absolute;
                width: 1000px;
                height: 1000px;
            }

            .marca {
                position: absolute;
                width: 100%;
                height: 100%;
                margin-top: -16%;
                opacity: 75%;
            }

            .pef{
                position: absolute;
                height: 50%;
                width:  50%;
                margin-top: 55%;
                margin-left: -7%;
            }
            .pea{
                position: absolute;
                font-size: 150px;
                text-align: center;
                margin-top: 66%;
                margin-left: 3.5%;
                width: 28%;
                height: 28%;
                font-weight: bolder;
                text-shadow: 0px 0px 20px;
            }
            .pva{
                position: absolute;
                margin-top: 16%;
                margin-left: 70%;
                width: 75%;
                height: 27%;
                transform: rotate(-10deg);
                text-shadow: 0px 0px 20px;
            }
            .nome{
                position: absolute;
                margin-top: 25%;
                margin-left: 80%;
                width: 53%;
                height: 34%;
                line-height: 0.8;
                font-weight: lighter;
                text-shadow: 0 0 20px;
                transform: rotate(-10deg);
                color: #e4ffc8;
            }
            .sana{
                position: absolute;
                margin-top: 36%;
                margin-left: 73%;
                width: 77%;
                height: 25%;
                transform: rotate(-10deg);
                text-shadow: 0px 0px 20px;
            }


            .dado{
                position: absolute;
                margin-top: 110%;
                margin-left: 100%;
                font-weight: bolder;
            }

            .show {
                animation: show 3s linear forwards;
            }

            @keyframes show {
                0% { top: 0%; }
                25% { top: -50%; }
                75% { top: -50%; }
                100% { top: 0%; }
            }

            .fs-0 {
                font-size: 200px;
            }
            .cor-dado {
                color: #691119;
            }
            .cor-resultado {
                color: #ffd600;
            }

            @keyframes morto {
                from { filter: brightness(100%); }
                to { filter: brightness(0%); }
            }

            @keyframes sec {
                from { filter: brightness(100%); }
                to { filter: brightness(30%); }
            }

            .pri.morto{
                animation: morto 2s linear forwards;
            }

            .sec.morto{
                animation: sec 2s linear forwards;
            }
            #portrait {
                margin: 5%;
            }

        </style>
    </head>
    <body class="bg-transparent">
    <main id="portrait"></main>
        <?php
        require_once RootDir."includes/scripts.php";
        require_once "./../includes/scripts.php";
        ?>

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
        let foto = "<?=$morrendo?$urlphotomor:($enlouquecendo?$urlphotoenl:($ppv<50?($urlphotofer?:$urlphoto):$urlphoto));?>";
        let marca = "<?=$marca?:"https://fichasop.com/assets/img/marca_mount.webp"?>";
        let morto = '<?=$morrendo?' morto':''?>';
        let elemento = '<?=$elemento?>';
        let dado = '';
        let valordado = '';
        let nome = '<?php $y=''; $x = explode(' ',$nome); foreach($x as $nome): $y .=$nome.'\n';endforeach; echo $y;?>';
        let combate = false;

        const timer = 3000;
        let time;

        function subtimer (){
            clearTimeout(time);
            time = setTimeout(show, timer);
        }

        function hide() {
            dado = '';
            tick();
        }
        function show(){
            dado = 'show';
            setTimeout(hide,3000);
            tick();
        }
        function updtsaude(){
            if (mor === 1){
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

        function percent(max,min = 0){
            if((max === 0 && min === 0) || max === 0){
                return 0;
            }
            var p = (max / min) * 100;
            if (p > 100){
                return 100;
            } else {
                return p;
            }
        }


        function tick() {
            updtsaude()
            let modo
            if (combate){
                modo = <div><span className="pva text-center text-danger fs-0 font6">{pva}/{pv}</span><span className="sana text-center text-primary fs-0 font6">{sana}/{san}</span></div>;
            } else {
                modo = <div className="nome text-center fs-0 font7">{nome}</div>;
                }
            const element =(
                <div className="portrait">
                    <div className={"dado fa-10x " + dado}>
                        <i className="fa-regular fa-2x cor-dado fa-dice-d20"></i>
                        <span className="cor-resultado position-absolute top-50 start-50 translate-middle resultadodado">{valordado}</span>
                    </div>
                    <div>
                        <div style={{width: 275 + '%',position: 'absolute',height: 1 + 'px'}}></div>
                        <img className="fundo" src='/assets/img/fundo3.webp' />
                        <img className={"marca start-50 top-50 translate-middle pri" + morto} src={marca} />
                        <img className={"personagem pri" + morto} src={foto} />
                        <img className="pef " src='/assets/img/fundo2.webp' />
                        <div className="pea">
                            <span className="text-warning font8">{pea}</span>
                        </div>
                        {modo}
                    </div>
                </div>);
            portrait.render(element);
        }
        tick();
    </script>
    </body>
</html>