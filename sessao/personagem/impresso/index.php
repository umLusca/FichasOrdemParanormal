<?php
require_once("./../../../config/includes.php");
require_once "./../ficha/aconfig_ficha.php";
?>
<html lang="br">
<!DOCTYPE html>
<head>
    <?php require_once './../../../includes/head.html'; ?>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <title><?php echo $nome ?: "Desconhecido"; ?> - Ficha</title>
    <style>
        @font-face {
            font-family: 'daisywheelregular';
            src: url('../../../assets/css/daisywhl-webfont.woff2') format('woff2'),
            url('../../../assets/css/daisywhl-webfont.woff') format('woff');

        }

        .image-container {
            width: 695px;
            height: 982px;
            overflow: hidden;
            position: sticky;
        }

        .image-container img {
            width: 695px;
            height: 982px;
        }

        .nome {
            position: absolute;
            text-align: left;
            width: 310px;
            margin: 5% 0 0 10%;
            font-size: 30px;
        }
        .jogador {
            position: absolute;
            text-align: left;
            font-size: 15px;
            width: 165px;
            margin: 14.5% 19%;
        }

        .origem {
            position: absolute;
            text-align: left;
            font-size: 15px;
            width: 172px;
            margin: 17.25% 15.25%;
        }

        .nex {
            position: absolute;
            text-align: center;
            margin-top: 6%;
            margin-left: 58%;
            font-size: 30px;
            width: 70px;
        }

        .classe {
            position: absolute;
            text-align: left;
            font-size: 15px;
            width: 165px;
            margin: 20.5% 15.25%;
        }

        .patente {
            position: absolute;
            text-align: left;
            font-size: 15px;
            width: 172px;
            margin: 23.25% 16%;
        }

        .pex {
            position: absolute;
            text-align: left;
            font-size: 15px;
            width: 100px;
            margin: 15.25% 56%;
        }


        /*ATRIBUTOS*/
        .attr {
            margin: 21% 33%;
            width: 266px;
            height: 277px;
            position: absolute;
            text-align: center;
            font-weight: bolder;
            font-size: 35px;
        }

        .agi {
            position: absolute;
            width: 72px;
            height: 48px;
            margin: 8% -14%;
        }

        .for {
            position: absolute;
            width: 72px;
            height: 48px;
            margin: 35% 0 0 -48%;
        }

        .int {
            position: absolute;
            width: 72px;
            height: 48px;
            margin: 35% 0 0 20%;
        }

        .pre {
            position: absolute;
            width: 72px;
            height: 48px;
            margin: 79% 0 0 -38%;
        }

        .vig {
            position: absolute;
            width: 72px;
            height: 48px;
            margin: 79% 8%;
        }

        .PV {
            position: absolute;
            text-align: center;
            margin: 52.5% 23.75%;
            font-size: 25px;
            width: 56px;
        }

        .SAN {
            position: absolute;
            text-align: center;
            margin: 64.5% 42.75%;
            font-size: 25px;
            width: 56px;
        }

        .PE {
            position: absolute;
            text-align: center;
            margin: 52.5% 72.75%;
            font-size: 25px;
            width: 56px;
        }

        .passiva {
            position: absolute;
            text-align: center;
            margin: 30% 77.5%;
            font-size: 30px;
            width: 45px;
        }

        .esquiva {
            position: absolute;
            text-align: center;
            margin: 40.5% 77%;
            font-size: 15px;
            width: 35px;
        }

        .bloqueio {
            position: absolute;
            text-align: center;
            margin: 46.75% 77%;
            font-size: 15px;
            width: 35px;
        }
        .deslocamento {
            position: absolute;
            text-align: center;
            margin: 67% 65%;
            font-size: 20px;
            width: 33px;
        }
        .corte {
            position: absolute;
            text-align: center;
            font-size: 18px;
            width: 33px;
            margin: 31.25% 13%;
        }
        .impacto {
            position: absolute;
            text-align: center;
            font-size: 18px;
            width: 33px;
            margin: 31.25% 18%;
        }
        .perfuracao {
            position: absolute;
            text-align: center;
            font-size: 18px;
            width: 33px;
            margin: 31.25% 23%;
        }
        .balistico {
            position: absolute;
            text-align: center;
            font-size: 18px;
            width: 33px;
            margin: 37% 13.25%;
        }
        .mental {
            position: absolute;
            text-align: center;
            font-size: 18px;
            width: 51px;
            margin: 37% 20%;
        }
        .morte {
            position: absolute;
            text-align: center;
            font-size: 18px;
            width: 30px;
            margin: 45.75% 11.75%;
        }
        .sangue {
            position: absolute;
            text-align: center;
            font-size: 18px;
            width: 30px;
            margin: 45.75% 16.75%;
        }
        .energia {
            position: absolute;
            text-align: center;
            font-size: 18px;
            width: 30px;
            margin: 45.75% 21.75%;
        }
        .conhecimento {
            position: absolute;
            text-align: center;
            font-size: 18px;
            width: 30px;
            margin: 45.75% 26.75%;
        }


        .acrobacia {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 81.5% 22.1%;
        }
        .adestramento {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 81.5% 72.5%;
        }
        .artes {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 84.5% 72.5%;
        }
        .atletismo {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 81.25% 38%;
        }

        .atualidade {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 81.5% 56.25%;
        }

        .ciencia {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 84.5% 56.25%;
        }
        .crime {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 84.5% 22.1%;
        }

        .diplomacia {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 87.5% 72.5%;
        }

        .enganacao {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 90.5% 72.5%;
        }

        .fortitude {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 81.5% 89.8%;
        }

        .furtividade {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 87.5% 22.1%;
        }

        .intimidacao {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 93.5% 72.5%;
        }

        .intuicao {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 87.5% 56.25%;
        }

        .investigacao {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 90.5% 56.25%;
        }
        .iniciativa {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 90.5% 22.1%;
        }

        .luta {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 84.25% 38%;
        }

        .medicina {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 93.5% 56.25%;
        }

        .ocultismo {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 96.5% 56.25%;
        }

        .percepcao {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 96.5% 72.5%;
        }

        .pilotagem {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 93.5% 22.1%;
        }

        .pontaria {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 96.5% 22.1%;
        }


        .profissao {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 99.5% 56.25%;
        }

        .reflexos {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 99.5% 22.1%;
        }

        .religiao {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 99.7% 72.5%;
        }
        .sobrevivencia {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 102.5% 56.25%;
        }

        .tatica {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 105.75% 56.25%;
        }

        .tecnologia {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 108.75% 56.25%;
        }

        .vontade {
            position: absolute;
            text-align: center;
            width: 19px;
            margin: 102.7% 72.5%;
        }

        /*Armas*/
        .Slot1 {
            position: absolute;
            margin-top: 118.75%;
        }

        .Slot2 {
            position: absolute;
            margin-top: 121.25%;
        }

        .Slot3 {
            position: absolute;
            margin-top: 123.75%;
        }

        .Slot4 {
            position: absolute;
            margin-top: 126.25%;
        }
        .Slot5 {
            position: absolute;
            margin-top: 128.75%;
        }

        .Slot6 {
            position: absolute;
            margin-top: 131.25%;
        }

        .Arma {
            text-align: left;
            font-size: 12px;
            margin-left: 12.2%;
            width: 15.75%;
        }

        .Tipo {
            margin-left: 28.5%;
            font-size: 12px;
            width: 10%;
        }

        .Ataque {
            text-align: center;
            margin-left: 39%;
            font-size: 12px;
            width: 9%;
        }

        .Alcance {
            margin-left: 48.5%;
            font-size: 12px;
            width: 10%;
        }

        .Dano {
            margin-left: 59%;
            font-size: 12px;
            width: 8%;
        }

        .Critico {
            margin-left: 68%;
            font-size: 12px;
            width: 7.25%;
        }

        .Especial {
            margin-left: 76%;
            font-size: 12px;
            width: 15%;
        }

        .Proeficiencias {
            position: absolute;
            text-align: left;
            width: 34%;
            margin: 64.75% 8%;
            font-size: 14px;
        }

        .Habilidades {
            position: absolute;
            text-align: left;
            width: 79.5%;
            margin: 85% 8%;
            font-size: 14px;
        }

        .Inventario {
            font-size: 15px;
            font-weight: lighter;

        }

        .Inv1 {
            position: absolute;
            margin-top: 17%;
        }

        .Inv2 {
            position: absolute;
            margin-top: 18.75%;
        }

        .Inv3 {
            position: absolute;
            margin-top: 20.5%;
        }

        .Inv4 {
            position: absolute;
            margin-top: 22.25%;
        }

        .Inv5 {
            position: absolute;
            margin-top: 24%;
        }

        .Inv6 {
            position: absolute;
            margin-top: 25.75%;
        }

        .Inv7 {
            position: absolute;
            margin-top: 27.5%;
        }

        .Inv8 {
            position: absolute;
            margin-top: 29.25%;
        }

        .Inv9 {
            position: absolute;
            margin-top: 31%;
        }

        .Inv10 {
            position: absolute;
            margin-top: 32.75%;
        }

        .Inv11 {
            position: absolute;
            margin-top: 34.5%;
        }
        .Inv12 {
            position: absolute;
            margin-top: 36.25%;
        }
        .Inv13 {
            position: absolute;
            margin-top: 38%;
        }
        .Inv14 {
            position: absolute;
            margin-top: 39.75%;
        }
        .Inv15 {
            position: absolute;
            margin-top: 41.5%;
        }
        .Inv16 {
            position: absolute;
            margin-top: 43.25%;
        }
        .Inv17 {
            position: absolute;
            margin-top: 45%;
        }
        .Inv18 {
            position: absolute;
            margin-top: 46.75%;
        }
        .Inv19 {
            position: absolute;
            margin-top: 48.5%;
        }
        .Inv20 {
            position: absolute;
            margin-top: 48.5%;
        }
        .Inv21 {
            position: absolute;
            margin-top: 50.25%;
        }
        .Inv22 {
            position: absolute;
            margin-top: 52%;
        }
        .Inv23 {
            position: absolute;
            margin-top: 53.75%;
        }
        .Inv24 {
            position: absolute;
            margin-top: 55.5%;
        }
        .Item {
            margin-left: 8%;
            text-align: left;
            width: 14.5%;
        }

        .Detalhes {
            margin-left: 23.25%;
            width: 37%;
            text-align: left;
        }

        .Espacos {
            margin-left: 62%;
            text-align: center;
            width: 5.5%;
        }

        .Prestigio {
            margin-left: 76%;
            text-align: center;
            width: 9%;
        }

        .Espaco {
            position: absolute;
            text-align: right;
            width: 25%;
            margin: 39.9% 0 0 58%;
            font-size: 85px;
        }
        @media print
        {
            .page-break  { display:block; page-break-before:always; }

        }
    </style>
</head>
<body>
<!------------HTML----------------------->
<div class="container-fluid">
    <div class="image-container">
        <div class="dados">
            <div class="nome font4"><?=$nome?></div>
            <div class="jogador font6"><?=$usuario?></div>
            <span class="nex font6"><?=$nex?></span>
            <span class="nex pex font6"><?=$pex?></span>
            <span class="origem font6"><?=$origem?></span>
            <span class="classe font6"><?=$classe?></span>
            <span class="patente font6"><?=$patente?></span>
        </div>
        <div class="attr font1">
            <span class="for"><?=$forca?></span>
            <span class="agi"><?=$agilidade?></span>
            <span class="int"><?=$intelecto?></span>
            <span class="vig"><?=$vigor?></span>
            <span class="pre"><?=$presenca?></span>
        </div>
        <div class="Saude font4">
            <span class="PV"><?=$pv?></span>
            <span class="PE"><?=$pe?></span>
            <span class="SAN"><?=$san?></span>
            <span class="passiva"><?=$passiva?></span>
            <span class="bloqueio"><?=$fortitude?></span>
            <span class="esquiva"><?=$esquiva?></span>
            <span class="deslocamento"><?=$deslocamento?></span>
            <span class="corte"><?=$corte?></span>
            <span class="impacto"><?=$impacto?></span>
            <span class="perfuracao"><?=$perfuracao?></span>
            <span class="balistico"><?=$balistica?></span>
            <span class="mental"><?=$insanidade?></span>
            <span class="morte"><?=$morte?></span>
            <span class="sangue"><?=$sangue?></span>
            <span class="energia"><?=$energia?></span>
            <span class="conhecimento"><?=$conhecimento?></span>
        </div>
        <div class="pericias">
            <span class="pericia acrobacia"><?=$acrobacias?></span>
            <span class="pericia adestramento"><?=$adestramento?></span>
            <span class="pericia artes"><?=$artes?></span>
            <span class="pericia atletismo"><?=$atletismo?></span>
            <span class="pericia atualidade"><?=$atualidades?></span>
            <span class="pericia ciencia"><?=$ciencia?></span>
            <span class="pericia crime"><?=$crime?></span>
            <span class="pericia diplomacia"><?=$diplomacia?></span>
            <span class="pericia enganacao"><?=$enganacao?></span>
            <span class="pericia fortitude"><?=$fortitude?></span>
            <span class="pericia furtividade"><?=$furtividade?></span>
            <span class="pericia intimidacao"><?=$intimidacao?></span>
            <span class="pericia intuicao"><?=$intuicao?></span>
            <span class="pericia investigacao"><?=$investigacao?></span>
            <span class="pericia iniciativa"><?=$iniciativa?></span>
            <span class="pericia luta"><?=$luta?></span>
            <span class="pericia medicina"><?=$medicina?></span>
            <span class="pericia ocultismo"><?=$ocultismo?></span>
            <span class="pericia percepcao"><?=$percepcao?></span>
            <span class="pericia pilotagem"><?=$pilotagem?></span>
            <span class="pericia pontaria"><?=$pontaria?></span>
            <span class="pericia profissao"><?=$profissao?></span>
            <span class="pericia reflexos"><?=$reflexos?></span>
            <span class="pericia religiao"><?=$religiao?></span>
            <span class="pericia sobrevivencia"><?=$sobrevivencia?></span>
            <span class="pericia tatica"><?=$tatica?></span>
            <span class="pericia tecnologia"><?=$tecnologia?></span>
            <span class="pericia vontade"><?=$vontade?></span>
        </div>
        <div class="Armas">
            <?php
            if($s[1]->num_rows){
            for($i = 0;(($i < count($rs[1])) && ($i < 6)); $i++): ?>
                <span class="Slot<?=$i+1?> Arma"><?=$rs[1][$i]["arma"]?></span>
                <span class="Slot<?=$i+1?> Tipo"><?=$rs[1][$i]["tipo"]?></span>
                <span class="Slot<?=$i+1?> Ataque"><?=$rs[1][$i]["ataque"]?></span>
                <span class="Slot<?=$i+1?> Alcance"><?=$rs[1][$i]["alcance"]?></span>
                <span class="Slot<?=$i+1?> Dano"><?=$rs[1][$i]["dano"]?></span>
                <span class="Slot<?=$i+1?> Critico"><?=$rs[1][$i]["margem"]?>/<?=$rs[1][$i]["critico"]?></span>
                <span class="Slot<?=$i+1?> Especial"><?=$rs[1][$i]["especial"]?></span>
            <?php endfor;}?>
        </div>
        <img alt="Ficha frontal" src="../../../assets/img/Print1.png"/>
    </div>
    <div class="page-break"></div>
    <div class="image-container">
        <div class="Inventario">
            <?php
            if($s[4]->num_rows > 0){
            for ($i = 0; ($i < count($rs[4])&& $i<=17); $i++):?>
                <div class="Inv<?=$i+1?> Item text-truncate"><?=$rs[4][$i]["nome"]?></div>
                <div class="Inv<?=$i+1?> Detalhes text-truncate"><?=$rs[4][$i]["descricao"]?></div>
                <div class="Inv<?=$i+1?> Espacos text-truncate"><?=$rs[4][$i]["espaco"]?></div>
                <div class="Inv<?=$i+1?> Prestigio text-truncate"><?=$rs[4][$i]["prestigio"]?></div>
            <?php endfor;}?>
        </div>
        <div>
            <span class="Proeficiencias">
                <?php foreach ($s[3] as $r):?>
                    <?=$r["nome"]?><br>
                <?php endforeach; ?>
            </span>
        </div>
        <div class="Habilidades">
	        <?php foreach ($s[2] as $r):?>
                <span><span class="fw-bold"><?=$r["nome"]?></span> <?=$r["descricao"]?></span><br>
            <?php endforeach; ?><br>
	        <?php foreach ($s[7] as $r):?>
                <span><span class="fw-bold"><?=$r["nome"]?></span> <?=$r["descricao"]?></span><br>
            <?php endforeach; ?>
        </div>
        <img alt="Ficha frontal" src="../../../assets/img/Print2.png"/>
    </div>
</div>

</body>
</html>