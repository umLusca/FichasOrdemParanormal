<?php

if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {
	switch ($conj[2]) {
		default:
			$data = array(
				"success" => false,
				"msg" => "Query não encontrado!"
			);
			break;
		case "habtab":
			//todo finalizar
			$nome = cleanstring($_POST["name"], 30);
			$token = cleanstring($_POST["token"], 36);
			$f = $con->prepare("UPDATE habilidades_tab SET nome = ? WHERE token = ?");
			$f->execute([$nome, $token]);
			break;
		case 'proficiencia':
			if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {
				for ($i = 0; $i < count($_POST['did']); $i++):
					$pro = cleanstring($_POST["pro"][$i], $Pro_nome);
					$pid = intval($_POST["did"][$i]);
					$q = $con->prepare("UPDATE `proeficiencias` SET `nome` = ? WHERE `id_ficha` in (SELECT id FROM fichas_personagem WHERE token = ?) AND `id` = ?;");
					$q->bind_param("ssi", $pro, $token, $pid);
					$q->execute();
				endfor;
			} else {
				$data["success"] = false;
				$data["msg"] = "Sem permissão";
			}
			break;
		case "habilidade":
			//Todo finalizar habtabs
			if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {
				$tipo = cleanstring($_POST["type"], 3);
				$eid = (int)$_POST["id"];
				$title = cleanstring($_POST["name"], 200);
				$desc = cleanstring($_POST["desc"]);
				switch ($tipo) {
					case "hab":
						$a = $con->prepare("UPDATE habilidades SET nome =?, descricao =? WHERE id = ? AND id_ficha  in (SELECT id FROM fichas_personagem WHERE token = ?)");
						break;
					case "pod":
						$a = $con->prepare("UPDATE poderes SET nome =?, descricao = ? WHERE id = ? AND id_ficha  in (SELECT id FROM fichas_personagem WHERE token = ?)");
						break;
				}
				$a->bind_param("ssis", $title, $desc, $eid, $token);
				$a->execute();
			}else{
				$data["success"] = false;
				$data["msg"] = "Sem permissão";
			}
			break;
		case 'atributos':
			if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {
				$forca = minmax($_POST["forca"], $minimo_atributo, $maximo_atributo);
				$agilidade = minmax($_POST["agilidade"], $minimo_atributo, $maximo_atributo);
				$intelecto = minmax($_POST["intelecto"], $minimo_atributo, $maximo_atributo);
				$presenca = minmax($_POST["presenca"], $minimo_atributo, $maximo_atributo);
				$vigor = minmax($_POST["vigor"], $minimo_atributo, $maximo_atributo);
				$a = $con->prepare("UPDATE fichas_personagem SET forca =?, agilidade = ?, inteligencia =? , presenca =?, vigor = ? WHERE token = ?");
				$a->bind_param("iiiiis", $forca, $agilidade, $intelecto, $presenca, $vigor, $token);
				$a->execute();
			} else {
				$data["success"] = false;
				$data["msg"] = "Sem permissão";
			}
			break;
		case 'detalhes':
			if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {
				$nex = minmax($_POST["nex"], 0, 100);
				$pp = minmax($_POST["pp"], 0, 999999999);//pontos de prestigio
				$origem = cleanstring($_POST["origem"]);
				$trilha = cleanstring($_POST["trilha"]);
				$classe = cleanstring($_POST["classe"]);
				$elemento = cleanstring($_POST["elemento"]);
				$patente = cleanstring($_POST["patente"]);

				$desco = minmax($_POST["deslocamento"], 0, 50);
				$per = minmax($_POST["pr"], 0, 127);
				$idade = minmax($_POST["idade"], 0, 150);
				$local = cleanstring($_POST["local"], $Fich_loca);

				if (Check_Name(cleanstring($_POST["nome"]))) {
					$nome = cleanstring($_POST["nome"]);
				}

				$rr = $con->prepare("UPDATE `fichas_personagem` SET `nome` = ? , `afinidade` = ? , `nex` = ?, `pe_rodada` = ?, `pp` = ? ,
                               `classe` = ? , `trilha` = ? , `origem` = ? , `patente` = ? , `idade` = ?, `deslocamento` = ? ,
                               `local` = ?
                           WHERE `token` = ?;");
				$rr->bind_param("ssiiissssiiss", $nome, $elemento, $nex, $per, $pp, $classe, $trilha, $origem, $patente, $idade, $desco, $local, $token);
				$rr->execute();
				if ($con->affected_rows) {
					$data["status"] = true;
				} else {
					$data["status"] = false;
				}
			} else {
				$data["success"] = false;
				$data["msg"] = "Sem permissão";
			}
			break;
		case 'pericias':

			if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {
				$acr = minmax($_POST["acrobacias"], $minimo_pericia, $maximo_pericia);
				$ade = minmax($_POST["adestramento"], $minimo_pericia, $maximo_pericia);
				$art = minmax($_POST["artes"], $minimo_pericia, $maximo_pericia);
				$atl = minmax($_POST["atletismo"], $minimo_pericia, $maximo_pericia);
				$atu = minmax($_POST["atualidades"], $minimo_pericia, $maximo_pericia);
				$cie = minmax($_POST["ciencia"], $minimo_pericia, $maximo_pericia);
				$cri = minmax($_POST["crime"], $minimo_pericia, $maximo_pericia);
				$dip = minmax($_POST["diplomacia"], $minimo_pericia, $maximo_pericia);
				$eng = minmax($_POST["enganacao"], $minimo_pericia, $maximo_pericia);
				$fort = minmax($_POST["fortitude"], $minimo_pericia, $maximo_pericia);
				$fur = minmax($_POST["furtividade"], $minimo_pericia, $maximo_pericia);
				$inic = minmax($_POST["iniciativa"], $minimo_pericia, $maximo_pericia);
				$inti = minmax($_POST["intimidacao"], $minimo_pericia, $maximo_pericia);
				$intu = minmax($_POST["intuicao"], $minimo_pericia, $maximo_pericia);
				$inv = minmax($_POST["investigacao"], $minimo_pericia, $maximo_pericia);
				$lut = minmax($_POST["luta"], $minimo_pericia, $maximo_pericia);
				$med = minmax($_POST["medicina"], $minimo_pericia, $maximo_pericia);
				$ocu = minmax($_POST["ocultismo"], $minimo_pericia, $maximo_pericia);
				$perc = minmax($_POST["percepcao"], $minimo_pericia, $maximo_pericia);
				$pilo = minmax($_POST["pilotagem"], $minimo_pericia, $maximo_pericia);
				$pont = minmax($_POST["pontaria"], $minimo_pericia, $maximo_pericia);
				$prof = minmax($_POST["profissao"], $minimo_pericia, $maximo_pericia);
				$ref = minmax($_POST["reflexo"], $minimo_pericia, $maximo_pericia);
				$rel = minmax($_POST["religiao"], $minimo_pericia, $maximo_pericia);
				$sob = minmax($_POST["sobrevivencia"], $minimo_pericia, $maximo_pericia);
				$tat = minmax($_POST["tatica"], $minimo_pericia, $maximo_pericia);
				$tec = minmax($_POST["tecnologia"], $minimo_pericia, $maximo_pericia);
				$von = minmax($_POST["vontade"], $minimo_pericia, $maximo_pericia);

				$nprof = cleanstring($_POST["nprofissao"], 20);
				$ncien = cleanstring($_POST["nciencia"], 20);

				$tacr = minmax($_POST["tacrobacias"], 0, 3);
				$tade = minmax($_POST["tadestramento"], 0, 3);
				$tart = minmax($_POST["tartes"], 0, 3);
				$tatl = minmax($_POST["tatletismo"], 0, 3);
				$tatu = minmax($_POST["tatualidades"], 0, 3);
				$tcie = minmax($_POST["tciencia"], 0, 3);
				$tcri = minmax($_POST["tcrime"], 0, 3);
				$tdip = minmax($_POST["tdiplomacia"], 0, 3);
				$teng = minmax($_POST["tenganacao"], 0, 3);
				$tfort = minmax($_POST["tfortitude"], 0, 3);
				$tfur = minmax($_POST["tfurtividade"], 0, 3);
				$tinic = minmax($_POST["tiniciativa"], 0, 3);
				$tinti = minmax($_POST["tintimidacao"], 0, 3);
				$tintu = minmax($_POST["tintuicao"], 0, 3);
				$tinv = minmax($_POST["tinvestigacao"], 0, 3);
				$tlut = minmax($_POST["tluta"], 0, 3);
				$tmed = minmax($_POST["tmedicina"], 0, 3);
				$tocu = minmax($_POST["tocultismo"], 0, 3);
				$tperc = minmax($_POST["tpercepcao"], 0, 3);
				$tpilo = minmax($_POST["tpilotagem"], 0, 3);
				$tpont = minmax($_POST["tpontaria"], 0, 3);
				$tprof = minmax($_POST["tprofissao"], 0, 3);
				$tref = minmax($_POST["treflexo"], 0, 3);
				$trel = minmax($_POST["treligiao"], 0, 3);
				$tsob = minmax($_POST["tsobrevivencia"], 0, 3);
				$ttat = minmax($_POST["ttatica"], 0, 3);
				$ttec = minmax($_POST["ttecnologia"], 0, 3);
				$tvon = minmax($_POST["tvontade"], 0, 3);
				$q = $con->prepare("UPDATE `fichas_personagem` SET
                               `acrobacias` = ?, `adestramento` = ?, `artes` = ?, `atletismo` = ?, `atualidades` = ?,
                               `ciencia` = ?, `crime` = ?, `diplomacia` = ?, `enganacao` = ?, `fortitude` = ?,
                               `furtividade` = ?, `intimidacao` = ?, `iniciativa` = ?, `intuicao` = ?, `investigacao` = ?,
                               `luta` =?, `medicina` =?, `ocultismo` =?, `percepcao` =?, `pilotagem` =?,
                               `pontaria` =?, `profissao`= ?,`reflexos`= ?, `religiao`= ?, `sobrevivencia`= ?,
                               `tatica`= ?, `tecnologia`= ?, `vontade`= ?, tacrobacias = ?,tadestramento = ?,tartes = ?,tatletismo = ?,tatualidades = ?,tciencia = ?,tcrime = ?,tdiplomacia = ?,tenganacao = ?,tfortitude = ?,
                               tfurtividade = ?,tintimidacao = ?,tiniciativa = ?,tintuicao = ?,tinvestigacao = ?,tluta = ?,tmedicina = ?,tocultismo = ?,tpercepcao = ?,tpilotagem = ?,tpontaria = ?,tprofissao = ?,treflexo = ?,treligiao = ? ,tsobrevivencia = ?,ttatica = ?,ttecnologia = ?,tvontade = ?, nprofissao = ?, nciencia = ? WHERE `token` = ?;");
				$q->execute([$acr, $ade, $art, $atl, $atu, $cie, $cri, $dip, $eng, $fort, $fur, $inti, $inic, $intu, $inv, $lut, $med, $ocu, $perc, $pilo, $pont, $prof, $ref, $rel, $sob, $tat, $tec, $von, $tacr, $tade, $tart, $tatl, $tatu, $tcie, $tcri, $tdip, $teng, $tfort, $tfur, $tinti, $tinic, $tintu, $tinv, $tlut, $tmed, $tocu, $tperc, $tpilo, $tpont, $tprof, $tref, $trel, $tsob, $ttat, $ttec, $tvon, $nprof, $ncien, $token]);

			} else {
				$data["success"] = false;
				$data["msg"] = "Sem permissão";
			}
			break;
		case 'ritual':

			if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {
				$did = (int)$_POST["did"];
				$foto = cleanstring($_POST["simbolourl"], $Fich_fotos);
				$ritual = cleanstring($_POST["ritual"], $Ritu_nome);
				$cir = cleanstring($_POST["circulo"], $Ritu_circ);
				$conj = cleanstring($_POST["conjuracao"], $Ritu_conj);
				$ele = cleanstring($_POST["elemento"], $Ritu_elem);
				$efe = cleanstring($_POST["efeito"], $Ritu_efei);
				$dur = cleanstring($_POST["duracao"], $Ritu_dura);
				$alc = cleanstring($_POST["alcance"], $Ritu_alca);
				$res = cleanstring($_POST["resistencia"], $Ritu_resi);
				$alvo = cleanstring($_POST["alvo"], $Ritu_alvo);
				$d1 = cleanstring($_POST["dano1"], $Ritu_dan);
				$d2 = cleanstring($_POST["dano2"], $Ritu_dan);
				$d3 = cleanstring($_POST["dano3"], $Ritu_dan);
				$rr = $con->prepare("UPDATE `rituais` SET `nome` = ?, `foto` = ? , `circulo` = ? , `conjuracao` = ? , `efeito` = ? , `elemento` = ? , `duracao` = ? , `alcance` = ?, `resistencia` = ? , `alvo` = ?, `dano` = ? ,`dano2` = ?, `dano3` = ? WHERE `id_ficha`  in (SELECT id FROM fichas_personagem WHERE token = ?) AND `id` = ? ;");
				$rr->bind_param("ssssssssssssssi", $ritual, $foto, $cir, $conj, $efe, $ele, $dur, $alc, $res, $alvo, $d1, $d2, $d3, $token, $did);
				$rr->execute();
			} else {
				$data["success"] = false;
				$data["msg"] = "Sem permissão";
			}
			break;
		case 'status':
			if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {
				$ra = $con->prepare("SELECT * FROM fichas_personagem WHERE token = ?");
				$ra->bind_param("s", $token);
				$ra->execute();
				$rqs = mysqli_fetch_array($ra->get_result());
				$pva = $rqs["pva"];
				$sana = $rqs["sana"];
				$pea = $rqs["pea"];
				$nex = $rqs["nex"];
				$balas = minmax((int)$_POST["balas"], 0, 50);

				if ($rqs["nex"] == 99) {
					$nex = 100;
				}
				//Saúde

				if (isset($_POST["pv"])) {
					$pv = minmax((int)$_POST["pv"], $minimo_PV, $maximo_PV);
				} else {
					$bpv = minmax((int)$_POST["bpv"], -10, 10);
					$spv = minmax((int)$_POST["skippedpv"], 0, 20);
					$ppv = minmax((int)$_POST["somapv"], -999, 999);
					$pv = minmax(calcularvida($nex, $rqs["classe"], $rqs["vigor"], $rqs["trilha"], $rqs["origem"], $bpv, $spv, $ppv), $minimo_PV, $maximo_PV);
					if ($rqs["pva"] < ($pv + $maximo_PVA)) {
						$pva = $pv;
					}
					$f = $con->prepare("UPDATE fichas_personagem SET bpv = ?, skippedpv = ?, somapv =? WHERE token =?");
					$f->bind_param("iiis", $bpv, $spv, $ppv, $token);
					$f->execute();
					unset($f);
				}
				if (isset($_POST["pe"])) {
					$pe = minmax((int)$_POST["pe"], $minimo_PE, $maximo_PE);
				} else {
					$bpe = minmax((int)$_POST["bpe"], -10, 10);
					$spe = minmax((int)$_POST["skippedpe"], 0, 20);
					$ppe = minmax((int)$_POST["somape"], -999, 999);
					$pe = minmax(calcularpe($nex, $rqs["classe"], $rqs["presenca"], $rqs["trilha"], $rqs["origem"], $bpe, $spe, $ppe), $minimo_PE, $maximo_PE);
					if ($rqs["pea"] < ($pe + $maximo_PEA)) {
						$pea = $pe;
					}
					$f = $con->prepare("UPDATE fichas_personagem SET bpe = ?, skippedpe = ?, somape =? WHERE token =?");
					$f->bind_param("iiis", $bpe, $spe, $ppe, $token);
					$f->execute();
					unset($f);
				}
				if (isset($_POST["san"])) {
					$san = minmax((int)$_POST["san"], $minimo_SAN, $maximo_SAN);
				} else {
					$bsan = minmax((int)$_POST["bsan"], -10, 10);
					$ssan = minmax((int)$_POST["skippedsan"], 0, 20);
					$psan = minmax((int)$_POST["somasan"], -999, 999);

					$san = minmax(calcularsan($nex, $rqs["classe"], $rqs["trilha"], $rqs["origem"], $bsan, $ssan, $psan), $minimo_SAN, $maximo_SAN);

					if ($rqs["pva"] < ($san + $maximo_SAN)) {
						$sana = $san;
					}
					$f = $con->prepare("UPDATE fichas_personagem SET bsan = ?, skippedsan = ?, somasan =? WHERE token =?");
					$f->bind_param("iiis", $bsan, $ssan, $psan, $token);
					$f->execute();
					unset($f);

				}


				//Defesas
				$pa = minmax((int)$_POST["passiva"]);
				$es = minmax((int)$_POST["esquiva"]);
				$bl = minmax((int)$_POST["bloqueio"]);
				//Resistencias
				$fisi = minmax((int)$_POST["fisica"], $minimo_resistencia, $maximo_resistencia);
				$bali = minmax((int)$_POST["balistica"], $minimo_resistencia, $maximo_resistencia);
				$fogo = minmax((int)$_POST["fogo"], $minimo_resistencia, $maximo_resistencia);


				$mort = minmax((int)$_POST["morte"], $minimo_resistencia, $maximo_resistencia);
				$sang = minmax((int)$_POST["sangue"], $minimo_resistencia, $maximo_resistencia);
				$conh = minmax((int)$_POST["conhecimento"], $minimo_resistencia, $maximo_resistencia);
				$ener = minmax((int)$_POST["energia"], $minimo_resistencia, $maximo_resistencia);
				$ment = minmax((int)$_POST["mental"], $minimo_resistencia, $maximo_resistencia);


				$cort = minmax((int)$_POST["corte"], $minimo_resistencia, $maximo_resistencia);
				$impa = minmax((int)$_POST["impacto"], $minimo_resistencia, $maximo_resistencia);
				$elet = minmax((int)$_POST["eletricidade"], $minimo_resistencia, $maximo_resistencia);
				$frio = minmax((int)$_POST["frio"], $minimo_resistencia, $maximo_resistencia);
				$perf = minmax((int)$_POST["perfuracao"], $minimo_resistencia, $maximo_resistencia);
				$quim = minmax((int)$_POST["quimico"], $minimo_resistencia, $maximo_resistencia);

				$b = $con->prepare("UPDATE `fichas_personagem` SET `balas` = ?,
                               `passiva`= ?, `esquiva` = ?, bloqueio = ?,`mental` = ?,`fisica`= ?,`balistica` = ?,
                               `fogo`= ?,`morte`= ?, `sangue` = ?,`conhecimento`= ?,`energia` = ?,
                               `perfuracao` = ?,`eletricidade`= ?, `frio` = ?,`impacto` = ?,`corte` = ?,
                               `pea` = ?, `pe` = ?,`san` = ?, `sana` = ?, `quimico` = ?, `pv` = ?, `pva` = ?
                          		WHERE `id`  in (SELECT id FROM fichas_personagem WHERE token = ?);");
				$b->bind_param("iiiiiiiiiiiiiiiiiiiiiiiis", $balas, $pa, $es, $bl, $ment, $fisi, $bali, $fogo, $mort, $sang, $conh, $ener, $perf, $elet, $frio, $impa, $cort, $pea, $pe, $san, $sana, $quim, $pv, $pva, $token);
				$data["success"] = $b->execute();

			} else {
				$data["success"] = false;
				$data["msg"] = "Sem permissão";
			}

			break;
		case 'itemquantidade':
			if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {

				$a = cleanstring($_POST["action"]);
				$i = (int)$_POST["item"];
				if ($a === "plus") {
					$f = $con->prepare("UPDATE inventario SET `quantidade` = quantidade + 1 WHERE id_ficha in (SELECT id from fichas_personagem WHERE token = ?) and id =? and quantidade < 30");
				} else {
					$f = $con->prepare("UPDATE inventario SET `quantidade` = quantidade - 1 WHERE id_ficha in (SELECT id from fichas_personagem WHERE token = ?) and id =? and quantidade > 0");
				}
				$f->bind_param("si", $token, $i);
				$f->execute();
			} else {
				$data["success"] = false;
				$data["msg"] = "Sem Permissão";
			}
			break;
		case 'item':
			if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {
				$iid = (int)$_POST["did"];
				$nome = cleanstring($_POST["nome"], $limite_nome_inv);
				$desc = cleanstring($_POST["descricao"], $Inv_desc);
				$foto = cleanstring($_POST["foto"], $urllimit);
				$peso = minmax($_POST["peso"], $minimo_peso, $maximo_peso, $inv_float);
				$pres = minmax($_POST["prestigio"], 0, 10);
				$rr = $con->prepare("UPDATE `inventario` SET `nome` = ? , `descricao` = ?, `espaco` = ?, `prestigio` = ?, foto = ? WHERE `inventario`.`id` = ? AND `id_ficha` in (SELECT id FROM fichas_personagem WHERE token = ?);");
				$data["success"] = $rr->execute([$nome, $desc, $peso, $pres, $foto, $iid, $token]);
			} else {
				$data["success"] = false;
				$data["msg"] = "Sem permissão";
			}
			break;
		case 'arma':
			if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {


				$aid = (int)$_POST["did"];

				$n = cleanstring($_POST["nome"], $limite_nome_inv);
				$f = cleanstring($_POST["foto"], 300);
				$desc = cleanstring($_POST["desc"], $Inv_desc);
				$peso = minmax($_POST["peso"], $minimo_peso, $maximo_peso, $inv_float);
				$pres = minmax($_POST["prestigio"], $minimo_peso, $maximo_peso);


				$t = cleanstring($_POST["tipo"], $Arma_tipo);
				$at = cleanstring($_POST["ataque"], $Arma_ataq);
				$al = cleanstring($_POST["alcance"], $Arma_alca);
				$d = cleanstring($_POST["dano"], $Arma_dano);
				$c = cleanstring($_POST["critico"], $Arma_crit);
				$m = minmax($_POST["margem"], 1, 20);
				$r = cleanstring($_POST["recarga"], $Arma_reca);
				$e = cleanstring($_POST["especial"], $Arma_espe);

				$b = $con->prepare("UPDATE inventario SET nome = ?, foto = ?, descricao = ?, quantidade = 1, espaco = ?, prestigio = ? WHERE id in (SELECT item_id FROM armas WHERE id = ?) AND id_ficha in (SELECT id FRom fichas_personagem where token = ?);");
				$b->execute([$n, $f, $desc, $peso, $pres, $aid, $token]);

				$a = $con->prepare("UPDATE armas JOIN inventario i on armas.item_id = i.id SET tipo = ? , ataque = ? , alcance = ? , dano = ? , margem = ?, critico = ? , recarga = ? , especial = ? WHERE  armas.id = ? AND i.id_ficha in (select id from fichas_personagem where token = ?);;");
				$a->execute([$t, $at, $al, $d, $m, $c, $r, $e, $aid, $token]);


				$data["success"] = $rr->execute();
			} else {
				$data["success"] = false;
				$data["msg"] = "Sem permissão";
			}
			break;
		case 'foto':
			if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {
				if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp|gif)$/', cleanstring($_POST["fotourl"]))) {
					$urlphoto = cleanstring($_POST["fotourl"], $Fich_fotos);
					if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp|gif)$/', cleanstring($_POST["fotomor"]))) {
						$fotomor = cleanstring($_POST["fotomor"], $Fich_fotos);
					} else {
						$fotomor = $urlphoto;
					}
					if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp|gif)$/', cleanstring($_POST["fotofer"]))) {
						$fotofer = cleanstring($_POST["fotofer"], $Fich_fotos);
					} else {
						$fotofer = $urlphoto;
					}
					if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp|gif)$/', cleanstring($_POST["fotoenl"]))) {
						$fotoenl = cleanstring($_POST["fotoenl"], $Fich_fotos);
					} else {
						$fotoenl = $urlphoto;
					}
					if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp|gif)$/', cleanstring($_POST["fotoef"]))) {
						$fotoef = cleanstring($_POST["fotoef"], $Fich_fotos);
					} else {
						$fotoef = $urlphoto;
					}
				} else {
					$fotoef = $fotomor = $fotoenl = $fotofer = $urlphoto = 'https://fichasop.com/assets/img/Man.webp';
				}


				$rr = $con->prepare("UPDATE `fichas_personagem` SET `foto` = ? , `foto_morrendo` = ?, `foto_enlouquecendo` = ?, `foto_ferido` = ?, `foto_ferenl` = ? WHERE token = ?;");
				$rr->bind_param("ssssss", $urlphoto, $fotomor, $fotoenl, $fotofer, $fotoef, $token);
				$rr->execute();
			} else {
				$data["success"] = false;
				$data["msg"] = "Sem permissão";
			}
			break;
		case 'peso':
			if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {
				$did = minmax($_POST["peso"], 1);
				$y = $con->prepare("UPDATE fichas_personagem SET peso_inv = ? WHERE id in (SELECT id FROM fichas_personagem WHERE token = ?);");
				$y->bind_param("is", $did, $token);
				$y->execute();
			} else {
				$data["success"] = false;
				$data["msg"] = "Sem permissão";
			}
			break;
	}
}