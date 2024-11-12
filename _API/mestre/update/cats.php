<?php


switch ($conj[2]) {
	default:
		$data = array(
			"success" => false,
			"msg" => "Query não encontrado!"
		);
		break;
	case 'nota':
		if (VerificarMestre($token) || $_SESSION["UserAdmin"]) {
			$a = count($_POST["titulo"]);

			for ($i = 0; $i < $a; $i++) {
				$tit = $_POST['titulo'][$i];
				if (empty($_POST["titulo"]) || strlen($tit) > 30 || !preg_match("/^[áàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑa-zA-Z-' 0-9]*$/", $tit)) {
					$tit = "Título";
				}

				$des = cleanstring($_POST["nota"][$i]);
				$nota = (int)$_POST["id"][$i];

				$y = $con->prepare("UPDATE `notes` SET `nome` = ?, `notas` = ? WHERE `id`= ? AND `missao` in (SELECT id FROM missoes where token = ?);");
				$y->bind_param("ssis", $tit, $des, $nota, $token);
				$y->execute();

			}

		}
		break;
	case "iniciativa":
		foreach ($_POST["init"] as $i => $init) {
			$z = $con->prepare("UPDATE iniciativas SET `nome`= ?,`iniciativa`= ?,`prioridade`= ?,`dano`= ? WHERE iniciativas.id = ?");
			$p = $i + 1;
			$z->bind_param("siiii", $init["n"], $init["i"], $init["p"], $init["d"], $init["id"]);
			$z->execute();
		}
		break;
	case 'fichasnpc':
		$nome = cleanstring($_POST["nome"]);
		$categoria = minmax($_POST["monstro"], 0, 1);
		$pv = minmax($_POST["pv"], 0, 999999999);
		$san = minmax($_POST["san"], 0, 999999999);
		$pe = minmax($_POST["pe"], 0, 999999999);
		$for = minmax($_POST["forca"], -10, 10);
		$agi = minmax($_POST["agilidade"], -10, 10);
		$int = minmax($_POST["intelecto"], -10, 10);
		$pre = minmax($_POST["presenca"], -10, 10);
		$vig = minmax($_POST["vigor"], -10, 10);
		$passiva = minmax($_POST["passiva"]);
		$esquiva = minmax($_POST["esquiva"]);
		$morte = minmax($_POST["morte"]);
		$sangue = minmax($_POST["sangue"]);
		$energia = minmax($_POST["energia"]);
		$conhecimento = minmax($_POST["conhecimento"]);
		$fisica = minmax($_POST["fisica"]);
		$balistica = minmax($_POST["balistica"]);
		$mental = minmax($_POST["mental"]);
		$acro = minmax($_POST["acrobacia"]);
		$ades = minmax($_POST["adestramento"]);
		$arte = minmax($_POST["artes"]);
		$atle = minmax($_POST["atletismo"]);
		$atua = minmax($_POST["atualidades"]);
		$cien = minmax($_POST["ciencia"]);
		$crim = minmax($_POST["crime"]);
		$dipl = minmax($_POST["diplomacia"]);
		$enga = minmax($_POST["enganacao"]);
		$fort = minmax($_POST["fortitude"]);
		$furt = minmax($_POST["furtividade"]);
		$inic = minmax($_POST["iniciativa"]);
		$inti = minmax($_POST["intimidacao"]);
		$intu = minmax($_POST["intuicao"]);
		$inve = minmax($_POST["investigacao"]);
		$luta = minmax($_POST["luta"]);
		$medi = minmax($_POST["medicina"]);
		$ocul = minmax($_POST["ocultismo"]);
		$perc = minmax($_POST["percepcao"]);
		$pilo = minmax($_POST["pilotagem"]);
		$pont = minmax($_POST["pontaria"]);
		$prof = minmax($_POST["profissao"]);
		$refl = minmax($_POST["reflexos"]);
		$reli = minmax($_POST["religiao"]);
		$sobr = minmax($_POST["sobrevivencia"]);
		$tati = minmax($_POST["tatica"]);
		$tecn = minmax($_POST["tecnologia"]);
		$vont = minmax($_POST["vontade"]);
		$ata = cleanstring($_POST["ataques"], 5000);
		$habs = cleanstring($_POST["habilidades"], 5000);
		$dets = cleanstring($_POST["detalhes"], 5000);
		if (strlen($nome) > 30) {
			$nome = "NPC";
		}
		$fid = (int)$_POST['efni'];
		$t = $con->prepare("UPDATE `fichas_npc` SET `nome` = ?, `categoria` = ? ,`pv` = ? ,`pva` = ? ,`san` = ? ,`sana` = ? ,`pe` = ? ,`pea` = ? ,`forca` = ? ,`agilidade` = ? ,
                         `inteligencia` = ? ,`presenca` = ? ,`vigor` = ? ,`passiva` = ? ,`esquiva` = ? ,`morte` = ? ,`sangue` = ? ,`energia` = ? ,`conhecimento` = ? ,
                         `balistica` = ? ,`fisica` = ? ,`mental` = ? ,`acrobacia` = ? ,`adestramento` = ? ,`artes` = ? ,`atletismo` = ? ,`atualidade` = ? ,`ciencia` = ? ,`crime` = ? ,
                         `diplomacia` = ? ,`enganacao` = ? ,`fortitude` = ? ,`furtividade` = ? ,`iniciativa` = ? ,`intimidacao` = ? ,`intuicao` = ? ,`investigacao` = ? ,`luta` = ? ,`medicina` = ? ,
                         `ocultismo` = ? ,`percepcao` = ? ,`pilotagem` = ? ,`pontaria` = ? ,`profissao` = ? ,`reflexos` = ? ,`religiao` = ? ,`sobrevivencia` = ? ,`tatica` = ? ,`tecnologia` = ? ,
                         `vontade` = ? , `ataques` = ? ,`habilidades` = ? ,`detalhes` = ? WHERE `id` = ? AND `missao` in (SELECT id FROM missoes WHERE mestre = ? and token = ?) ;");
		$t->bind_param('siiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiisssiis', $nome, $categoria, $pv, $pv, $san, $san, $pe, $pe, $for, $agi, $int, $pre, $vig, $passiva, $esquiva, $morte, $sangue, $energia, $conhecimento, $balistica, $fisica, $mental, $acro, $ades, $arte, $atle, $atua, $cien, $crim, $dipl, $enga, $fort, $furt, $inic, $inti, $intu, $inve, $luta, $medi, $ocul, $perc, $pilo, $pont, $prof, $refl, $reli, $sobr, $tati, $tecn, $vont, $ata, $habs, $dets, $fid, $_SESSION["UserID"], $token);
		$t->execute();
		break;
}