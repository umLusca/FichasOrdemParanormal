<?php
require_once("./../../../config/includes.php");
require_once "./../ficha/aconfig_ficha.php";
?>
<html lang="br">
<!DOCTYPE html>
<head>
	<?php require_once './../../../includes/head.html'; ?>
    <meta charset="UTF-8">
    <title><?php echo $nome ?: "Desconhecido"; ?> - Ficha</title>
    <style>

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
            text-align: center;
            width: 200px;
            margin: 5.75% 0 0 12%;
            font-size: 20px;
        }

        .jogador {
            position: absolute;
            text-align: left;
            font-size: 15px;
            width: 95px;
            margin: 6.5% 42.25%;
        }
        .nex {
            position: absolute;
            text-align: left;
            margin: 75% 18%;
            font-size: 30px;
            width: 45px;
        }

        .origem {
            position: absolute;
            text-align: left;
            font-size: 18px;
            width: 230px;
            margin: 62% 23.5%;
        }


        .classe {
            position: absolute;
            text-align: left;
            font-size: 13.9px;
            width: 236px;
            margin: 70% 22%;
        }

        .patente {
            position: absolute;
            text-align: left;
            font-size: 15px;
            width: 172px;
            margin: 23.25% 16%;
        }

        .pex {/**/
            position: absolute;
            text-align: left;
            font-size: 15px;
            width: 100px;
            margin: 15.25% 56%;
            display:none;
        }


        /*ATRIBUTOS*/
        .attr {
            margin: 16% 15%;
            width: 277px;
            height: 277px;
            position: absolute;
            text-align: center;
            font-weight: bolder;
            font-size: 35px;
        }

        .agi {
            position: absolute;
            width: 74px;
            height: 48px;
            margin: 4% -14%;
        }

        .for {
            position: absolute;
            width: 72px;
            height: 48px;
            margin: 29% 0 0 -48%;
        }

        .int {
            position: absolute;
            width: 72px;
            height: 48px;
            margin: 29% 0 0 20%;
        }

        .pre {
            position: absolute;
            width: 72px;
            height: 48px;
            margin: 72% 0 0 -38%;
        }

        .vig {
            position: absolute;
            width: 72px;
            height: 48px;
            margin: 72% 11%;
        }

        .PV {
            position: absolute;
            text-align: center;
            margin: 84% 14%;
            font-size: 25px;
            width: 55px;
        }

        .SAN {
            position: absolute;
            text-align: center;
            margin: 97% 41.5%;
            font-size: 26px;
            width: 54px;
        }

        .PE {
            position: absolute;
            text-align: center;
            margin: 84% 36%;
            font-size: 25px;
            width: 56px;
        }

        .SAN {
            position: absolute;
            text-align: center;
            margin: 97% 41.5%;
            font-size: 26px;
            width: 54px;
        }

        .passiva {
            position: absolute;
            text-align: center;
            margin: 97% 14%;
            font-size: 25px;
            width: 50px;
        }

        .esquiva {/**/
            position: absolute;
            text-align: center;
            margin: 40.5% 77%;
            font-size: 15px;
            width: 35px;
            display:none;
        }

        .bloqueio {/**/
            position: absolute;
            text-align: center;
            margin: 46.75% 77%;
            font-size: 15px;
            width: 35px;
            display:none;
        }

        .deslocamento {/**/
            position: absolute;
            text-align: center;
            margin: 67% 65%;
            font-size: 20px;
            width: 33px;
            display:none;
        }

        .corte {/**/
            position: absolute;
            text-align: center;
            font-size: 18px;
            width: 33px;
            margin: 31.25% 13%;
            display:none;
        }

        .impacto {/**/
            position: absolute;
            text-align: center;
            font-size: 18px;
            width: 33px;
            margin: 31.25% 18%;
            display:none;
        }

        .perfuracao {/**/
            position: absolute;
            text-align: center;
            font-size: 18px;
            width: 33px;
            margin: 31.25% 23%;
            display:none;
        }

        .balistico {/**/
            position: absolute;
            text-align: center;
            font-size: 18px;
            width: 33px;
            margin: 37% 13.25%;
            display:none;
        }

        .mental {/**/
            position: absolute;
            text-align: center;
            font-size: 18px;
            width: 51px;
            margin: 37% 20%;
            display:none;
        }

        .morte {/**/
            position: absolute;
            text-align: center;
            font-size: 18px;
            width: 30px;
            margin: 45.75% 11.75%;
            display:none;
        }

        .sangue {/**/
            position: absolute;
            text-align: center;
            font-size: 18px;
            width: 30px;
            margin: 45.75% 16.75%;
            display:none;
        }

        .energia {/**/
            position: absolute;
            text-align: center;
            font-size: 18px;
            width: 30px;
            margin: 45.75% 21.75%;
            display:none;
        }

        .conhecimento {/**/
            position: absolute;
            text-align: center;
            font-size: 18px;
            width: 30px;
            margin: 45.75% 26.75%;
            display:none;
        }


        .pericias {
            position: absolute;
            text-align: center;
            width: 28px !important;
            margin: 27.3% 81.53%;
            height: 59%;
        }

        .pericia {
            position: absolute;
            width: 100%;
            margin-left: -50%;
        }

        .acrobacia {
            margin-top: -8%;
        }

        .adestramento {
            margin-top: 66%;
        }

        .artes {
            margin-top: 140%;
        }

        .atletismo {
            margin-top: 214%;
        }

        .atualidade {
            margin-top: 288%;
        }

        .ciencia {
            margin-top: 362%;
        }

        .crime {
            margin-top: 436%;
        }

        .diplomacia {
            margin-top: 510%;
        }

        .enganacao {
            margin-top: 584%;
        }

        .fortitude {
            margin-top: 658%;
        }

        .furtividade {
            margin-top: 732%;
        }

        .intimidacao {
            margin-top: 806%;
        }

        .intuicao {
            margin-top: 880%;
        }

        .investigacao {
            margin-top: 954%;
        }

        .iniciativa {
            margin-top: 1028%;
        }

        .luta {
            margin-top: 1102%;
        }

        .medicina {
            margin-top: 1176%;
        }

        .ocultismo {
            margin-top: 1250%;
        }

        .percepcao {
            margin-top: 1324%;
        }

        .pilotagem {
            margin-top: 1398%;
        }

        .pontaria {
            margin-top: 1472%;
        }


        .profissao {
            margin-top: 1546%;
        }

        .reflexos {
            margin-top: 1620%;
        }

        .religiao {
            margin-top: 1694%;
        }

        .sobrevivencia {
            margin-top: 1768%;
        }

        .tatica {
            margin-top: 1842%;
        }

        .tecnologia {
            margin-top: 1916%;
        }

        .vontade {
            margin-top: 1990%;
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

        @media print {
            .page-break {
                display: block;
                page-break-before: always;
            }
        }



    </style>
</head>
<body>
<!------------HTML----------------------->
<div class="container-fluid">
    <div class="image-container">
        <div class="dados">
            <div class="nome font6"><?= $nome ?></div>
            <div class="jogador font6"><?= $usuario ?></div>
            <span class="nex font6"><?= $nex ?></span>
            <span class="nex pex font6"><?= $pex ?></span>
            <span class="origem font6"><?= $origem ?></span>
            <span class="classe font6"><?= $classe ?></span>
            <span class="patente font6"><?= $patente ?></span>
        </div>
        <div class="attr font1">
            <span class="for"><?= $forca ?></span>
            <span class="agi"><?= $agilidade ?></span>
            <span class="int"><?= $intelecto ?></span>
            <span class="vig"><?= $vigor ?></span>
            <span class="pre"><?= $presenca ?></span>
        </div>
        <div class="Saude font4">
            <span class="PV"><?= $pv ?></span>
            <span class="PE"><?= $pe ?></span>
            <span class="SAN"><?= $san ?></span>
            <span class="passiva"><?= $passiva ?></span>
            <span class="bloqueio"><?= $fortitude ?></span>
            <span class="esquiva"><?= $esquiva ?></span>
            <span class="deslocamento"><?= $deslocamento ?></span>
            <span class="corte"><?= $corte ?></span>
            <span class="impacto"><?= $impacto ?></span>
            <span class="perfuracao"><?= $perfuracao ?></span>
            <span class="balistico"><?= $balistica ?></span>
            <span class="mental"><?= $insanidade ?></span>
            <span class="morte"><?= $morte ?></span>
            <span class="sangue"><?= $sangue ?></span>
            <span class="energia"><?= $energia ?></span>
            <span class="conhecimento"><?= $conhecimento ?></span>
        </div>
        <div class="pericias">
            <span class="pericia acrobacia"><?= $acrobacias ?></span>
            <span class="pericia adestramento"><?= $adestramento ?></span>
            <span class="pericia artes"><?= $artes ?></span>
            <span class="pericia atletismo"><?= $atletismo ?></span>
            <span class="pericia atualidade"><?= $atualidades ?></span>
            <span class="pericia ciencia"><?= $ciencia ?></span>
            <span class="pericia crime"><?= $crime ?></span>
            <span class="pericia diplomacia"><?= $diplomacia ?></span>
            <span class="pericia enganacao"><?= $enganacao ?></span>
            <span class="pericia fortitude"><?= $fortitude ?></span>
            <span class="pericia furtividade"><?= $furtividade ?></span>
            <span class="pericia intimidacao"><?= $intimidacao ?></span>
            <span class="pericia intuicao"><?= $intuicao ?></span>
            <span class="pericia investigacao"><?= $investigacao ?></span>
            <span class="pericia iniciativa"><?= $iniciativa ?></span>
            <span class="pericia luta"><?= $luta ?></span>
            <span class="pericia medicina"><?= $medicina ?></span>
            <span class="pericia ocultismo"><?= $ocultismo ?></span>
            <span class="pericia percepcao"><?= $percepcao ?></span>
            <span class="pericia pilotagem"><?= $pilotagem ?></span>
            <span class="pericia pontaria"><?= $pontaria ?></span>
            <span class="pericia profissao"><?= $profissao ?></span>
            <span class="pericia reflexos"><?= $reflexos ?></span>
            <span class="pericia religiao"><?= $religiao ?></span>
            <span class="pericia sobrevivencia"><?= $sobrevivencia ?></span>
            <span class="pericia tatica"><?= $tatica ?></span>
            <span class="pericia tecnologia"><?= $tecnologia ?></span>
            <span class="pericia vontade"><?= $vontade ?></span>
        </div>
        <div class="Armas">
			<?php
			if ($s[1]->num_rows) {
				for ($i = 0; (($i < count($rs[1])) && ($i < 6)); $i++): ?>
                    <span class="Slot<?= $i + 1 ?> Arma"><?= $rs[1][$i]["arma"] ?></span>
                    <span class="Slot<?= $i + 1 ?> Tipo"><?= $rs[1][$i]["tipo"] ?></span>
                    <span class="Slot<?= $i + 1 ?> Ataque"><?= $rs[1][$i]["ataque"] ?></span>
                    <span class="Slot<?= $i + 1 ?> Alcance"><?= $rs[1][$i]["alcance"] ?></span>
                    <span class="Slot<?= $i + 1 ?> Dano"><?= $rs[1][$i]["dano"] ?></span>
                    <span class="Slot<?= $i + 1 ?> Critico"><?= $rs[1][$i]["margem"] ?>/<?= $rs[1][$i]["critico"] ?></span>
                    <span class="Slot<?= $i + 1 ?> Especial"><?= $rs[1][$i]["especial"] ?></span>
				<?php endfor;
			} ?>
        </div>
        <img alt="Ficha frontal" src="/assets/img/print_frente.webp"/>
    </div>
    <div class="page-break"></div>
    <div class="image-container">
        <div class="Inventario">
			<?php
			if ($s[4]->num_rows > 0) {
				for ($i = 0; ($i < count($rs[4]) && $i <= 17); $i++):?>
                    <div class="Inv<?= $i + 1 ?> Item text-truncate"><?= $rs[4][$i]["nome"] ?></div>
                    <div class="Inv<?= $i + 1 ?> Detalhes text-truncate"><?= $rs[4][$i]["descricao"] ?></div>
                    <div class="Inv<?= $i + 1 ?> Espacos text-truncate"><?= $rs[4][$i]["espaco"] ?></div>
                    <div class="Inv<?= $i + 1 ?> Prestigio text-truncate"><?= $rs[4][$i]["prestigio"] ?></div>
				<?php endfor;
			} ?>
        </div>
        <div>
            <span class="Proeficiencias">
                <?php foreach ($s[3] as $r): ?>
	                <?= $r["nome"] ?><br>
                <?php endforeach; ?>
            </span>
        </div>
        <div class="Habilidades">
			<?php foreach ($s[2] as $r): ?>
                <span><span class="fw-bold"><?= $r["nome"] ?></span> <?= $r["descricao"] ?></span><br>
			<?php endforeach; ?><br>
			<?php foreach ($s[7] as $r): ?>
                <span><span class="fw-bold"><?= $r["nome"] ?></span> <?= $r["descricao"] ?></span><br>
			<?php endforeach; ?>
        </div>
        <img alt="Ficha frontal" src="/assets/img/Print2.webp"/>
    </div>
</div>

</body>
</html>