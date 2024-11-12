<?php


$token = cleanstring($_DATA["token"]);
if (checksession($session_id)) {
	$user = checksession($session_id);
	if (VerificarPermissaoFicha($token, $user)) {
		$a = $con->prepare("SELECT * FROM `fichas_personagem` WHERE `token`= ?");
		$a->bind_param("s", $token);
		$a->execute();
		$a = $a->get_result();
		if ($a->num_rows) {# Encontrou a components
			$ficha = mysqli_fetch_assoc($a);
			if (isset($_DATA["dados"]) && !empty($_DATA["dados"] && is_array($_DATA["dados"]))) {
				$return["success"] = false;
				// rituais|poderes|proficiencias|habilidade|armas|dados
				if (isset($_DATA["dados"]["armas"]) && is_array($_DATA["dados"]["armas"])) {
					foreach ($_DATA["dados"]["armas"] as $i => $arma) {
						if (isset($arma["nome"]) && !empty($arma["nome"])) {
							$nome = cleanstring($arma["nome"], 50);
							$foto = cleanstring($arma["foto"], 300);
							$desc = cleanstring($arma["descricao"], 500);
							$peso = minmax($arma["espaco"], -10, 30);
							$cate = minmax($arma["prestigio"], -10, 30);

							$i = $con->prepare("INSERT INTO inventario(id_ficha, foto, nome, descricao, espaco, prestigio) VALUES ( ? , ? , ? , ? , ? , ?)");
							if ($i->execute([$ficha["id"], $foto, $nome, $desc, $peso, $cate])) {
								$tipo = cleanstring($arma["tipo"], 30);
								$ataque = cleanstring($arma["ataque"], 30);
								$alcance = cleanstring($arma["alcance"], 30);
								$dano = cleanstring($arma["dano"], 30);
								$critico = cleanstring($arma["critico"], 30);
								$recarga = cleanstring($arma["recarga"], 30);
								$especial = cleanstring($arma["especial"], 30);
								$margem = minmax($arma["margem"], 1, 20);
								$iid = $con->insert_id;
								$a = $con->prepare("INSERT INTO armas (item_id, tipo, ataque, alcance, dano, critico, margem, recarga, especial) VALUES (?,?,?,?,?,?,?,?,?);");
								if ($a->execute([$iid, $tipo, $ataque, $alcance, $dano, $critico, $margem, $recarga, $especial])) {
									$r = $con->prepare("Select *,armas.id as id,i.foto as foto From armas left join inventario i on i.id = armas.item_id where armas.id = ? ;");
									$r->execute([$con->insert_id]);
									$r = mysqli_fetch_assoc($r->get_result());
									$return["dados"]["armas"][] = $r;


									$return["success"] = true;
								}
							}
						}
					}
				}
				if (isset($_DATA["dados"]["habilidades"]) && is_array($_DATA["dados"]["habilidades"])) {
					foreach ($_DATA["dados"]["habilidades"] as $i => $hab) {
						if (isset($hab["nome"]) && !empty($hab["nome"])) {
							$nome = cleanstring($hab["nome"], 50);
							$desc = cleanstring($hab["descricao"], 3000);
							$h = $con->prepare("INSERT INTO habilidades(id_ficha, nome, descricao) VALUES (?,?,?);");
							if ($h->execute([$ficha["id"], $nome, $desc])) {
								$r = $con->prepare("SELECT * FROM habilidades WHERE id = ?");
								$r->execute([$con->insert_id]);
								$r = mysqli_fetch_assoc($r->get_result());
								$return["dados"]["habilidades"][] = $r;


								$return["success"] = true;
							}
						}
					}
				}
				if (isset($_DATA["dados"]["poderes"]) && is_array($_DATA["dados"]["poderes"])) {
					foreach ($_DATA["dados"]["poderes"] as $i => $poder) {
						if (isset($poder["nome"]) and !empty($poder["nome"])) {
							$nome = cleanstring($poder["nome"], 50);
							$desc = cleanstring($poder["descricao"], 3000);
							$p = $con->prepare("INSERT INTO poderes(id_ficha, nome, descricao) VALUES (?,?,?);");
							if ($p->execute([$ficha["id"], $nome, $desc])) {
								$r = $con->prepare("SELECT * FROM poderes WHERE id = ?");
								$r->execute([$con->insert_id]);
								$r = mysqli_fetch_assoc($r->get_result());
								$return["dados"]["poderes"][$i] = $r;

								$return["success"] = true;
							}
						}
					}
				}
				if (isset($_DATA["dados"]["itens"]) && is_array($_DATA["dados"]["itens"])) {
					foreach ($_DATA["dados"]["itens"] as $i => $item) {
						if (isset($item["nome"]) && !empty($item["nome"])) {
							$nome = cleanstring($item["nome"], 50);
							$foto = cleanstring($item["foto"], 300);
							$desc = cleanstring($item["descricao"], 3000);
							$cate = minmax($item["prestigio"], -10, 30);
							$peso = minmax($item["espaco"], -10, 30);
							$quantidade = minmax($item["quantidade"], 0, 30);
							$i = $con->prepare("INSERT INTO inventario(id_ficha, foto, nome, descricao, quantidade, espaco, prestigio) VALUES (?,?,?,?,?,?,?)");
							if ($i->execute([$ficha["id"], $foto, $nome, $desc, $quantidade, $peso, $cate])) {
								$r = $con->prepare("SELECT * FROM inventario WHERE id = ?");
								$r->execute([$con->insert_id]);
								$r = mysqli_fetch_assoc($r->get_result());
								$return["dados"]["itens"][] = $r;

								$return["success"] = true;
							}
						}
					}
				}
				if (isset($_DATA["dados"]["proficiencias"]) && is_array($_DATA["dados"]["proficiencias"])) {
					foreach ($_DATA["dados"]["proficiencias"] as $i => $proficiencia) {
						if (isset($proficiencia["nome"]) && !empty($proficiencia["nome"])) {

							$nome = cleanstring($proficiencia["nome"], 50);
							$p = $con->prepare("INSERT INTO proeficiencias(id_ficha, nome) VALUES (?,?)");

							if ($p->execute([$ficha["id"], $nome])) {
								$r = $con->prepare("SELECT * FROM proeficiencias WHERE id = ?");
								$r->execute([$con->insert_id]);
								$r = mysqli_fetch_assoc($r->get_result());
								$return["dados"]["proficiencias"][$i] = $r;

								$return["success"] = true;
							}
						}
					}
				}
				if (isset($_DATA["dados"]["rituais"]) && is_array($_DATA["dados"]["rituais"])) {
					foreach ($_DATA["dados"]["rituais"] as $i => $ritual) {
						if (isset($ritual["nome"]) && !empty($ritual["nome"])) {
							$nome = cleanstring($ritual["nome"], 50);
							$foto = cleanstring($ritual["foto"], 300);
							$circ = cleanstring($ritual["circulo"], 15);
							$elem = cleanstring($ritual["elemento"], 50);
							$exec = cleanstring($ritual["conjuracao"], 30);
							$alca = cleanstring($ritual["alcance"], 30);
							$alvo = cleanstring($ritual["alvo"], 30);
							$dura = cleanstring($ritual["duracao"], 30);
							$resi = cleanstring($ritual["resistencia"], 50);
							$efei = cleanstring($ritual["efeito"], 3000);
							$dano = cleanstring($ritual["dano"], 50);
							$dano2 = cleanstring($ritual["dano2"], 50);
							$dano3 = cleanstring($ritual["dano3"], 50);

							$r = $con->prepare("INSERT INTO rituais(id_ficha, foto, nome, circulo, elemento, conjuracao, alcance, alvo, duracao, resistencia, efeito, dano, dano2, dano3) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
							if ($r->execute([$ficha["id"], $foto, $nome, $circ, $elem, $exec, $alca, $alvo, $dura, $resi, $efei, $dano, $dano2, $dano3])) {

								$r = $con->prepare("SELECT * FROM rituais WHERE id = ?");
								$r->execute([$con->insert_id]);
								$r = mysqli_fetch_assoc($r->get_result());
								$return["dados"]["rituais"][$i] = $r;

								$return["success"] = true;
							}
						}
					}
				}
			} else {
				$return["msg"] = "Nenhum dado a ser alterado..";
				$return["success"] = false;
			}
		} else {
			$return["success"] = false;
			$return["msg"] = 'Falha ao encontrar components.';
		}
	} else {
		$return["success"] = false;
		$return["msg"] = 'Sem permissão.';
	}
} else {
	$return["success"] = false;
	$return["msg"] = 'Sua sessão encerrou.';
}




switch ($conj[2]) {
	default:
		$data = array(
			"success" => false,
			"msg" => "Query não encontrado!"
		);
		break;
	case 'habtab':
		//finalizar
		$name = cleanstring($_POST["name"], 30);
		$t = $con->prepare("INSERT INTO habilidades_tab(token,nome,id_ficha) VALUES (uuid(),?,(SELECT id From fichas_personagem WHERE token = ?));");
		$t->execute([$name, $token]);

		//OK
		break;
	case 'habilidade':
		if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {
			$habname = cleanstring($_POST["hab"], $Hab_nome);
			$habdesc = cleanstring($_POST["desc"], $Hab_desc);
			if (isset($_POST["poder"]) && ($_POST["poder"] == 1 || $_POST["poder"] == "on")) {
				$a = $con->prepare("INSERT INTO `poderes` (`id_ficha`, `nome`, `descricao`) VALUES ( (SELECT id FROM fichas_personagem WHERE token = ? ) , ? ,  ?);");

			}else {
				$a = $con->prepare("INSERT INTO `habilidades` (`id_ficha`, `nome`, `descricao`) VALUES ( (SELECT id FROM fichas_personagem WHERE token = ? ) , ? ,  ?);");

			}
			$a->execute([$token, $habname, $habdesc]);
		} else {
			$data["success"] = false;
			$data["msg"] = "Sem permissão";
		}
		break;
	case 'proficiencia':
		if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {
			$pronome = cleanstring($_POST["pro"], $Pro_nome);
			$t = $con->prepare("INSERT INTO `proeficiencias`(`id_ficha`,`nome`) VALUES ((SELECT id FROM fichas_personagem WHERE token = ?),?);");
			$t->bind_param("ss", $token, $pronome);
			$t->execute();
		} else {
			$data["success"] = false;
			$data["msg"] = "Sem permissão";
		}
		break;
	case 'ritual':
		$foto = cleanstring($_POST["simbolourl"]);

		$ritual = cleanstring($_POST["ritual"], $Ritu_nome);
		$cir = cleanstring($_POST["circulo"], $Ritu_circ);
		$conj = cleanstring($_POST["conjuracao"], $Ritu_conj);
		$ele = cleanstring($_POST["elemento"], $Ritu_elem);
		$efe = cleanstring($_POST["efeito"], $Ritu_efei);
		$dur = cleanstring($_POST["duracao"], $Ritu_dura);
		$alc = cleanstring($_POST["alcance"], $Ritu_alca);
		$alv = cleanstring($_POST["alvo"], $Ritu_alvo);
		$res = cleanstring($_POST["resistencia"], $Ritu_resi);
		$d1 = cleanstring($_POST["dano1"], $Ritu_dan);
		$d2 = cleanstring($_POST["dano2"], $Ritu_dan);
		$d3 = cleanstring($_POST["dano3"], $Ritu_dan);
		$rr = $con->prepare("INSERT INTO `rituais`( `id_ficha`,`foto`,`nome`,`circulo`, `conjuracao`,`efeito`,`elemento`,`duracao`,`alcance`, `resistencia`, `alvo`,`dano`,`dano2`,`dano3`) VALUES ( (SELECT id FROM fichas_personagem WHERE token = ?) ,? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ?)");
		$rr->bind_param("ssssssssssssss", $token, $foto, $ritual, $cir, $conj, $efe, $ele, $dur, $alc, $res, $alv, $d1, $d2, $d3);
		$rr->execute();
		break;
	case 'item':
		$nome = cleanstring($_POST["nome"], $limite_nome_inv);
		$desc = cleanstring($_POST["descricao"], $Inv_desc);
		$foto = cleanstring($_POST["foto"], $urllimit);
		$peso = minmax($_POST["peso"], $minimo_peso, $maximo_peso, $inv_float);
		$pres = minmax($_POST["prestigio"], $minimo_peso, $maximo_peso, $inv_float);

		$rr = $con->prepare("INSERT INTO `inventario`(`id_ficha`,`foto`,`nome`,`descricao`,`espaco`,`prestigio`) VALUES ( (SELECT id FROM fichas_personagem WHERE token = ?),? , ? , ? , ? , ?)");
		$rr->execute([$token, $foto, $nome, $desc, $peso, $pres]);
		break;
	case 'arma':
		$n = cleanstring($_POST["nome"], $limite_nome_inv);
		$foto = cleanstring($_POST["foto"], $Inv_desc);
		$desc = cleanstring($_POST["desc"], $Inv_desc);
		$peso = minmax($_POST["peso"], $minimo_peso, $maximo_peso, $inv_float);
		$pres = minmax($_POST["prestigio"], 0, 10);//Categorias

		$t = cleanstring($_POST["tipo"], $Arma_tipo);
		$at = cleanstring($_POST["ataque"], $Arma_crit);
		$al = cleanstring($_POST["alcance"], $Arma_alca);
		$d = cleanstring($_POST["dano"], $Arma_dano);
		$c = cleanstring($_POST["critico"], $Arma_crit);
		$m = minmax($_POST["margem"], 1, 20);
		$r = cleanstring($_POST["recarga"], $Arma_reca);
		$e = cleanstring($_POST["especial"], $Arma_espe);

		$p = $con->prepare("INSERT INTO `inventario`(`id_ficha`,`foto`,`nome`,`descricao`,`prestigio`,`espaco`,`id`) VALUES ((SELECT id FROM fichas_personagem WHERE token = ? ),?, ?, ?, ?, ?, '');");
		if ($p->execute([$token, $foto, $n, $desc, $pres, $peso])) {
			$item_id = $con->insert_id;

			$rr = $con->prepare("INSERT INTO `armas`(`item_id`,`tipo`,`ataque`,`alcance`,`dano`,`critico`, `margem`,`recarga`,`especial`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);");
			$rr->execute([$item_id, $t, $at, $al, $d, $c, $m, $r, $e]);
			$data["msg"] = "Sucesso ao adicionar itens";

		}
		break;
}