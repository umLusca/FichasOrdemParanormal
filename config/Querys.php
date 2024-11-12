<?php

if (!$con)$con = con();
if (!empty($_POST["query"])) {
	header("Content-Type: application/json");
	
	$token = cleanstring($_GET["token"] ?: $_POST["token"]);
	$conj = explode("_", cleanstring($_POST["query"]));
	$data = array(
		"success" => false,
		"msg" => "Não encontrado",
		"Query" => $conj
	);
	switch (cleanstring($_POST["query"])) {

		case 'mestre_sync_fichasnpc':
			$ficha_id = (int)$_POST["components"];
			$data = $_POST["data"];
			if ($data["pva"] >= $data["pv"] + 20) $data["pva"] = $data["pv"] + 20;
			if ($data["pva"] < 0) $data["pva"] = 0;
			
			if ($data["sana"] >= $data["san"] + 20) $data["sana"] = $data["san"] + 20;
			if ($data["sana"] < 0) $data["sana"] = 0;
			
			if ($data["pea"] >= $data["pe"] + 20) $data["pea"] = $data["pe"] + 20;
			if ($data["pea"] < 0) $data["pea"] = 0;
			
			$st = get_stmt($data, array("id", "missao"), "fichas_npc", $con);
			$st["bind"] .= "isi";
			$st["values"][] = $ficha_id;
			$st["values"][] = $token;
			$st["values"][] = $_SESSION["UserID"];
			$_a = $con->prepare("UPDATE fichas_npc SET {$st["query"]} WHERE id =? AND missao in (SELECT id from missoes WHERE token = ? AND mestre = ?)");
			$_a->execute($st["values"]);
			
			break;
		case "mestre_duplicar_fichanpc":
			$npc = (int)($_POST["npc"]);
			$a = $con->prepare("SELECT * FROM fichas_npc WHERE id = ? AND missao in (SELECT id from missoes WHERE token = ? AND mestre = ?);");
			$a->bind_param("isi", $npc, $token, $_SESSION["UserID"]);
			$a->execute();
			$ra = mysqli_fetch_assoc($a->get_result());
			$stmt = duplicate_row($ra, null, array("id"));
			$b = $con->prepare("INSERT INTO fichas_npc ({$stmt["query_columns"]}) VALUES ({$stmt["query_values"]})");
			$b->bind_param($stmt["bind_types"], ...$stmt["bind_values"]);
			$b->execute();
			break;
		case 'add_dado_customizado':
			$nome = cleanstring($_POST["nome"]);
			$dado = cleanstring($_POST["dado"]);
			$dano = ($_POST["dano"] === 'on' or $_POST["dano"] == 1) ? 1 : 0;
			$global = ($_POST["global"] === 'on' or $_POST["global"] == 1) ? 1 : 0;
			if (empty($nome)) {
				$nome = $dado;
			}
			$foto = minmax((int)$_POST["icone"], 0, 13);
			if ($global) unset($token);
			$y = $con->prepare("INSERT INTO `dados_customizados`(`nome`,`owner`,`foto`,`dado`,`dano`,`token_pai`,token) VALUES ( ? , ? , ? , ? , ? , ?, uuid_short() );");
			$y->bind_param("siisis", $nome, $_SESSION["UserID"], $foto, $dado, $dano, $token);
			$y->execute();
			break;
		case 'edit_dado_customizado':
			$nome = cleanstring($_POST["nome"]);
			$dado = cleanstring($_POST["dado"]);
			$dano = cleanstring(($_POST["dano"] == 'on' or $_POST["dano"] == 1) ? 1 : 0);
			$foto = minmax((int)$_POST["icone"], 0, 13);
			$token_dado = (int)$_POST["dadotoken"];
			if (empty($nome)) {
				$dado = $nome;
			}
			$y = $con->prepare("UPDATE `dados_customizados` SET `nome` = ?, `dado` = ?, `foto` = ?, `dano` = ? where `owner` = ? AND `token` = ?");
			$y->bind_param("ssiiis", $nome, $dado, $foto, $dano, $_SESSION["UserID"], $token_dado);
			$y->execute();
			break;
		case 'delete_dado_customizado':
			$token_dado = (int)$_POST["dadotoken"];
			$y = $con->prepare("DELETE FROM `dados_customizados` WHERE `owner` = ? AND `token` = ?;");
			$y->bind_param("is", $_SESSION["UserID"], $token_dado);
			$y->execute();
			
			break;
		case 'rolar_dado':
			$dano = minmax((int)$_POST["dano"], 0, 1);
			$margem = (int)$_POST["margem"];
			$dado = cleanstring($_POST["dado"], 50);
			$atributos = false;
			if (!empty($token)) {
				$ret = [];
				
				$b = $con->prepare("SELECT * FROM fichas_personagem WHERE token = ?");
				$b->bind_param("s", $token);
				$b->execute();
				$b = $b->get_result();
				
				if ($b->num_rows) {
					$ficha = mysqli_fetch_assoc($b);
					$atributos = true;
					$dc = array(
						"FOR" => $ficha["forca"],
						"AGI" => $ficha["agilidade"],
						"INT" => $ficha["inteligencia"],
						"PRE" => $ficha["presenca"],
						"VIG" => $ficha["vigor"],
						"ACRO" => $ficha["acrobacias"],
						"ADES" => $ficha["adestramento"],
						"ARTE" => $ficha["artes"],
						"ATLE" => $ficha["atletismo"],
						"ATUA" => $ficha["atualidades"],
						"CIEN" => $ficha["ciencia"],
						"CRIM" => $ficha["crime"],
						"DIPL" => $ficha["diplomacia"],
						"ENGA" => $ficha["enganacao"],
						"FORT" => $ficha["fortitude"],
						"FURT" => $ficha["furtividade"],
						"INIT" => $ficha["iniciativa"],
						"INTI" => $ficha["intimidacao"],
						"INTU" => $ficha["intuicao"],
						"INVE" => $ficha["investigacao"],
						"LUTA" => $ficha["luta"],
						"MEDI" => $ficha["medicina"],
						"OCUL" => $ficha["ocultismo"],
						"PERC" => $ficha["percepcao"],
						"PILO" => $ficha["pilotagem"],
						"PONT" => $ficha["pontaria"],
						"PROF" => $ficha["profissao"],
						"REFL" => $ficha["reflexos"],
						"SOBR" => $ficha["sobrevivencia"],
						"TATi" => $ficha["tatica"],
						"TECN" => $ficha["tecnologia"],
						"VONT" => $ficha["vontade"],
					);
					$dado = DadoDinamico(cleanstring($_POST["dado"], 50), $dc);
					
					
					$cm = $con->prepare("SELECT * FROM ligacoes WHERE id_ficha = ?");
					$cm->bind_param("s", $ficha["id"]);
					$cm->execute();
					$cm = $cm->get_result();
				} else {
					$a = $con->prepare("SELECT * FROM missoes WHERE token = ?");
					$a->bind_param("s", $token);
					$a->execute();
					$a = $a->get_result();
				}
			}
			
			if (ClearRolar($dado, false, $atributos)) {
				$data["dado"] = RolarMkII($dado, $dano, $margem);
				$data["success"] = true;
				if (isset($cm) && $cm->num_rows) {
					$dadosligacao = mysqli_fetch_array($cm);
					$ret["dado"] = $data["dado"];
					$ret["dado"]["nome"] = cleanstring($_POST["nome"]);
					$ret["nome"] = $ficha["nome"];
					$ret["components"] = $ficha["token"];
					$ret["foto"] = $ficha["foto"];
					
					
					$_a = $con->prepare("INSERT INTO dados_rolados_mestre (dados,data,missao,token) VALUES (?,NOW(),?,?)");
					$_a->bind_param("sis", json_encode($ret), $dadosligacao["id_missao"], $token);
					$_a->execute();
				}
				if (isset($a) && $a->num_rows) {
					$missao = mysqli_fetch_array($a);
					
					$ret["dado"]["nome"] = cleanstring($_POST["nome"]);
					$ret["dado"] = $data["dado"];
					$ret["nome"] = "Mestre";
					$ret["foto"] = "https://fichasop.com/assets/img/desconhecido.webp";
					
					$_a = $con->prepare("INSERT INTO dados_rolados_mestre (dados,data,missao) VALUES (?,NOW(),?)");
					$_a->bind_param("si", json_encode($ret), $missao["id"]);
					$_a->execute();
					
				}
			} else {
				$data = ClearRolar($dado, true, $atributos);
				$data["success"] = false;
				$data["dado"] = $dado;
			}
			
			
			break;
		case 'ficha_sync_status':
			if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {
				$ra = $con->prepare("SELECT * FROM fichas_personagem WHERE token = ?");
				$ra->bind_param("s", $token);
				$ra->execute();
				$rqs = mysqli_fetch_array($ra->get_result());
				$mor = $_POST["mor"] === "true";
				$com = $_POST["com"] === "true";
				
				$pv = minmax(($_POST["pv"]), $minimo_PV, $maximo_PV);
				$pva = minmax(($_POST["pva"]), $minimo_PVA, $maximo_PV + $maximo_PVA);
				$san = minmax(($_POST["san"]), $minimo_SAN, $maximo_SAN);
				$sana = minmax(($_POST["sana"]), $minimo_SANA, $maximo_SAN + $maximo_SANA);
				$pe = minmax(($_POST["pe"]), $minimo_PE, $maximo_PE);
				$pea = minmax(($_POST["pea"]), $minimo_PEA, $maximo_PE + $maximo_PEA);
				
				$ba = minmax(($_POST["bala"]), 0, 30);
				$bau = minmax(($_POST["balaa"]), 0, 30);
				
				$data = [];
				if (isset($_POST["ocult"])) {
					$opv = $_POST["ocult"]["pv"] === "true";
					$osan = $_POST["ocult"]["san"] === "true";
					$ope = $_POST["ocult"]["pe"] === "true";
				}
				if ($pv == 1) {
					$pv = calcularvida($rqs["nex"], $rqs["classe"], $rqs["vigor"], $rqs["trilha"], $rqs["origem"], $rqs["bpv"], $rqs["skippedpv"], $rqs["somapv"]);
				}
				if ($san == 1) {
					$san = calcularsan($rqs["nex"], $rqs["classe"], $rqs["trilha"], $rqs["origem"], $rqs["bsan"], $rqs["skippedsan"], $rqs["somasan"]);
				}
				if ($pe == 1) {
					$pe = calcularpe($rqs["nex"], $rqs["classe"], $rqs["presenca"], $rqs["trilha"], $rqs["origem"], $rqs["bpe"], $rqs["skippedpe"], $rqs["somape"]);
				}
				if ($pva > ($pv + $maximo_PVA)) {
					$pva = $pv + $maximo_PVA;
				}
				if ($sana > ($san + $maximo_SANA)) {
					$sana = $san + $maximo_SANA;
				}
				if ($pea > ($pe + $maximo_PEA)) {
					$pea = $pe + $maximo_PEA;
				}
				if ($pva < $minimo_PVA) {
					$pva = $minimo_PVA;
				}
				if ($sana < $minimo_SANA) {
					$sana = $minimo_SANA;
				}
				if ($pea < $minimo_PEA) {
					$pea = $minimo_PEA;
				}
				$fg = $con->prepare("UPDATE `fichas_personagem` SET `balas` = ?, `balasusadas`= ?, `opv` = ?,`combate` = ?, ope = ?, osan = ?, `morrendo`= ? , `pv` = ?, `pva` = ?, `san` = ?, `sana` = ?, `pe` = ?, `pea` = ? where `id` in (SELECT id FROM fichas_personagem WHERE token = ?)");
				$fg->bind_param("iiiiiiiiiiiiis", $ba, $bau, $opv, $com, $ope, $osan, $mor, $pv, $pva, $san, $sana, $pe, $pea, $token);
				$fg->execute();
				$data['pv'] = $pv;
				$data['pva'] = $pva;
				$data['san'] = $san;
				$data['sana'] = $sana;
				$data['pe'] = $pe;
				$data['pea'] = $pea;
				$data['mor'] = $mor;
			} else {
				$data["success"] = false;
				$data["msg"] = "Sem permissão";
			}
			break;
		case "ficha_sync_nota":
			if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {
				$t = cleanstring($_POST["type"]);
				$tt = cleanstring($_POST["text"], 10000);
				switch ($t) {
					default:
						$data["success"] = false;
						$data["msg"] = "Não encontrado onde";
						break;
					case "historia":
						$q = $con->prepare("UPDATE fichas_personagem SET historia = ? WHERE token=?");
						break;
					case "aparencia":
						$q = $con->prepare("UPDATE fichas_personagem SET aparencia = ? WHERE token=?");
						break;
					case "encontro":
						$q = $con->prepare("UPDATE fichas_personagem SET encontro = ? WHERE token=?");
						break;
					case "medos":
						$q = $con->prepare("UPDATE fichas_personagem SET medos = ? WHERE token=?");
						break;
					case "favoritos":
						$q = $con->prepare("UPDATE fichas_personagem SET favoritos = ? WHERE token=?");
						break;
					case "frases":
						$q = $con->prepare("UPDATE fichas_personagem SET frases = ? WHERE token=?");
						break;
					case "pesadelo":
						$q = $con->prepare("UPDATE fichas_personagem SET pior_pesadelo = ? WHERE token=?");
						break;
					case "notas":
						$q = $con->prepare("UPDATE fichas_personagem SET anotacoes = ? WHERE token=?");
						break;
				}
				$q->bind_param("ss", $tt, $token);
				if ($q->execute()) {
					$data["success"] = true;
					$data["msg"] = "Atualizado";
				} else {
					$data["success"] = false;
					$data["msg"] = "não atualizou";
				}
			} else {
				$data["success"] = false;
				$data["msg"] = "Sem permissão";
			}
			break;
		case "sync_portrait":
			if (isset($_POST["token"]) && !empty($_POST["token"])) {
				$t = cleanstring($_POST["token"]);
				
				$f = $con->prepare("SELECT * FROM fichas_personagem WHERE token = ?");
				$f->bind_param("s", $t);
				$f->execute();
				$f = $f->get_result();
				
				
				if ($f->num_rows) {
					$f = mysqli_fetch_assoc($f);
					
					$g = $con->prepare("SELECT * FROM missoes WHERE id in (SELECT id_missao FROM ligacoes WHERE id_ficha = ?)");
					$g->bind_param("i", $f["id"]);
					$g->execute();
					$g = $g->get_result();
					$combate = $f["combate"];
					if ($g->num_rows) {
						$g = mysqli_fetch_assoc($g);
						$combate = $g["combate"];
						$d = $con->prepare("SELECT * FROM dados_rolados_mestre WHERE missao = ? AND token = ? order by data desc limit 1;");
						$d->bind_param("is", $g["id"], $token);
						$d->execute();
						$d = $d->get_result();
						if ($d->num_rows) {
							
							$raw = mysqli_fetch_assoc($d);
							$dado = json_decode($raw["dados"], true);
							$data["dado"] = array(
								"resultado" => $dado["dado"]["resultado"],
								"data" => $raw["data"],
								"d" => $dado
							
							);
							
						}
						
						
					}
					$data["data"] = array(
						"pv" => $f["pv"],
						"pva" => $f["pva"],
						"san" => $f["san"],
						"sana" => $f["sana"],
						"pea" => $f["pea"],
						"pe" => $f["pe"],
						"mor" => $f["morrendo"],
						"opv" => $f["opv"],
						"ope" => $f["ope"],
						"osan" => $f["osan"],
						"combate" => $combate,
					);
					
					
					$data["success"] = true;
				} else {
					$data["success"] = false;
					$data["msg"] = "não encontrado no bd";
				}
			} else {
				$data["success"] = false;
				$data["msg"] = "não encontrado";
			}
			
			break;
		case "mestre_toggle_combate":
			$c = cleanstring($_POST["combate"]);
			if ($c === "true") {
				$c = 1;
			}
			if(VerificarMestre($token)||$_SESSION["UserAdmin"]){
				
				$f = $con->prepare("UPDATE missoes SET combate = ? WHERE token = ?");
				$f->bind_param("is", $c, $token);
				$f->execute();
				$data["success"] = (bool)$f->affected_rows;
				$data["msg"] = (bool)$f->affected_rows;
				
			}
			
			
			break;
		default:
			switch (count($conj)) {
				default:
					$data = array(
						"success" => false,
						"msg" => "Query não encontrado!"
					);
					break;
				case 2:
					switch ($conj[0]) {
						default:
							$data = array(
								"success" => false,
								"msg" => "Query não encontrado!"
							);
							break;
						case "conta":
							switch ($conj[1]) {
								case "update":
									$con = con();
									if (isset($_POST["asenha"]) && !empty($_POST["asenha"])) {
										$senha = cleanstring($_POST["asenha"]);
									}
									if (isset($_SESSION["UserID"])) {
										$u = mysqli_fetch_array($con->query("SELECT * FROM usuarios WHERE id = {$_SESSION["UserID"]}"));
										if ($u["senha"] === cryptthis($senha) || PassCheck($senha, $u["senha"])) {
											if (!PassCheck($senha, $u["senha"])) {
												$_a = $con->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
												$nn = PassCheck($senha);
												$_a->bind_param("ss", $nn, $_SESSION["UserID"]);
												$_a->execute();
											}
											$data["success"] = true;
											$data["msg"] = "Nada alterado";
											if (isset($_POST["nsenha"], $_POST["csenha"]) && !empty($_POST["nsenha"]) && !empty($_POST["csenha"])) {
												$nsenha = cleanstring($_POST["nsenha"]);
												$csenha = cleanstring($_POST["csenha"]);
												if (Check_Pass($nsenha, $csenha)) {
													$a = $con->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
													$nsenha = PassCheck($nsenha);
													$a->bind_param("si", $nsenha, $_SESSION["UserID"]);
													$a->execute();
													if ($con->affected_rows) {
														$data["success"] = true;
														$data["msg"] .= "Sucesso ao alterar senha;";
													} else {
														$data["success"] = false;
														$data["msg"] = "Erro no banco de dados.";
													}
												} else {
													$data["success"] = false;
													$data["msg"] = Check_Pass($nsenha, $csenha, 1)["msg"];
												}
											} else {
												if (isset($_POST["nsenha"]) && !empty($_POST["nsenha"])) {
													$data["success"] = false;
													$data["msg"] = "Preencha os campo das senhas;";
												}
											}
											if (isset($_POST["email"]) && !empty($_POST["email"])) {
												$email = cleanstring($_POST["email"]);
												if (Check_Email($email)) {
													$a = $con->prepare("SELECT * FROM usuarios WHERE email = ? ;");
													$a->bind_param("s", $email);
													$a->execute();
													$a = $a->get_result();
													if ($a->num_rows) {
														$ra = mysqli_fetch_array($a);
														if (!$ra["status"]) {
															$con->query("DELETE FROM usuarios WHERE id = {$ra["id"]};");
															$b = $con->prepare("UPDATE usuarios SET email = ? WHERE id = ? ;");
															$b->bind_param("si", $email, $_SESSION["UserID"]);
															$b->execute();
															if ($con->affected_rows) {
																$_SESSION["UserEmail"] = $email;
																$data["success"] = true;
																$data["msg"] .= "Alterado Email;";
															} else {
																$data["success"] = false;
																$data["msg"] .= "Falha ao alterar email, erro na database;";
															}
														} else {
															$data["success"] = false;
															$data["msg"] .= "Este email ja está em uso;";
														}
													} else {
														$c = $con->prepare("UPDATE usuarios SET email = ? WHERE id = ?");
														$c->bind_param("si", $email, $_SESSION["UserID"]);
														$c->execute();
														
														if ($con->affected_rows) {
															$_SESSION["UserEmail"] = $email;
															$data["success"] = true;
															$data["msg"] .= "Alterado Email;";
														} else {
															$data["success"] = false;
															$data["msg"] .= "Falha ao alterar, erro na database.";
														}
													}
												} else {
													$data["success"] = false;
													$data["msg"] .= "Este email não é válido";
												}
											}
											if (isset($_POST["username"]) && !empty($_POST["username"])) {
												$username = cleanstring($_POST["username"]);
												if (Check_Login($username)) {
													$a = $con->prepare("SELECT * FROM usuarios WHERE login = ? ;");
													$a->bind_param("s", $username);
													$a->execute();
													$a = $a->get_result();
													if (!$a->num_rows) {
														$b = $con->prepare("UPDATE usuarios SET login = ? WHERE id = ? ;");
														$b->bind_param("si", $username, $_SESSION["UserID"]);
														$b->execute();
														if ($con->affected_rows) {
															$_SESSION["UserLogin"] = $username;
															$data["success"] = true;
															$data["msg"] .= "Alterado Username;";
														} else {
															$data["success"] = false;
															$data["msg"] .= "Falha ao alterar username, erro na database;";
														}
													} else {
														$data["success"] = false;
														$data["msg"] .= "Este username ja está em uso;";
													}
												} else {
													$data["success"] = false;
													$data["msg"] .= "Este username não é válido;";
												}
											}
											if (isset($_POST["nome"]) && !empty($_POST["nome"])) {
												$nome = cleanstring($_POST["nome"]);
												if (Check_Name($nome)) {
													$b = $con->prepare("UPDATE usuarios SET nome = ? WHERE id = ? ;");
													$b->bind_param("si", $nome, $_SESSION["UserID"]);
													$b->execute();
													if ($con->affected_rows) {
														$_SESSION["UserName"] = $nome;
														$data["success"] = true;
														$data["msg"] .= "Alterado Nome;";
													} else {
														$data["success"] = false;
														$data["msg"] .= "Falha ao alterar nome, erro na database;";
													}
												} else {
													$data["success"] = false;
													$data["msg"] .= "Este Nome não é válido;";
												}
											}
											
											
										} else {
											$data["success"] = false;
											$data["msg"] = "Sua senha atual está incorreta;";
										}
									} else {
										$data["success"] = false;
										$data["msg"] = "Sua sessão encerrou;";
									}
									break;
								case "login":
									$data["success"] = true;
									if (!empty($_POST["login"])) {
										$login = cleanstring($_POST["login"]);
									} else {
										$data["success"] = false;
										$data["msg"] = "Preencha todos os campos!";
									}
									if (!empty($_POST["senha"])) {
										$pass = cleanstring($_POST["senha"]);
									} else {
										$data["success"] = false;
										$data["msg"] = "Preencha todos os campos!";
									}
									if ($data["success"]) {
										$q = $con->prepare("select * from `usuarios` WHERE `login` = ? OR `email` = ?");
										$q->bind_param("ss", $login, $login);
										$q->execute();
										$rq = $q->get_result();
										if ($rq->num_rows) { //Verifica se existe essa conta e se a senha coincide com ela
											$dados = mysqli_fetch_array($rq);
											if ($dados["senha"] === cryptthis($pass)) {
												logar($dados["id"]);
												if (isset($_POST["lembrar"]) && ($_POST["lembrar"] === 'on' || $_POST["lembrar"] === 1)) {
													remember_me($dados["id"], 7, "WEB");
												}// Quando a opção lembrar-me está marcada
												$data["msg"] = "Sucesso ao fazer login!";
												$data["success"] = true;
												
												$newhash = PassCheck($pass);
												$a = $con->prepare("UPDATE usuarios SET senha = ? WHERE login = ?");
												$a->bind_param("ss", $newhash, $dados["login"]);
												$a->execute();
												
												
											} else if (PassCheck($pass, $dados["senha"])) {
												logar($dados["id"]);
												if (isset($_POST["lembrar"]) && ($_POST["lembrar"] === 'on' || $_POST["lembrar"] === 1)) {
													remember_me($dados["id"], 7, "WEB");
												}// Quando a opção lembrar-me está marcada
												$data["msg"] = "Sucesso ao entrar!";
												$data["success"] = true;
												
											} else {
												$data["msg"] = "Usuario/Senha Incorreto!";
												$data["success"] = false;
											}
										} else {
											$data["msg"] = "Nenhuma conta encontrada!";
											$data["success"] = false;
										}
										
									} // Verificação dos dados
									++$_SESSION["timeout"];
									$data["tentativas"] = 5 - $_SESSION["timeout"];
									break;
								case "cadastro":
									$data["success"] = true;
									if (!empty($_POST["nome"])) {
										$nome = cleanstring($_POST["nome"], 50);
										if (!Check_Name($nome)) {
											$data["msg"] = "Apenas Letras e Espaços são permitidos no nome!";
											$data["success"] = false;
										}
									} else {
										$data["success"] = false;
										$data["msg"] = "Preencha todos os campos!";
									}
									
									if (!empty($_POST["login"])) {
										$login = $_POST["login"];
										if (!Check_Login($login)) {
											$data["success"] = false;
											$data["msg"] = "O Username tem que ter Apenas letras, números e \"_\"";
										}
										if (strlen($login) > 16) {
											$data["success"] = false;
											$data["msg"] = "O username não pode ter mais de 16 caracteres.";
										}
									} else {
										$data["success"] = false;
										$data["msg"] = "Preencha todos os campos!";
									}
									
									if (!empty($_POST["email"])) {
										$email = cleanstring($_POST["email"]);
										if (!Check_Email($email)) {
											$data["msg"] = "Email inserido não é valido.";
											$data["success"] = false;
										}
									} else {
										$data["success"] = false;
										$data["msg"] = "Preencha todos os campos!";
									}
									
									if (!empty($_POST["senha"] || $_POST["csenha"])) {
										if (Check_Pass($_POST["senha"], $_POST["csenha"])) {
											$senha = PassCheck(cleanstring($_POST["senha"]));
										} else {
											$er = Check_Pass($_POST["senha"], $_POST["csenha"], true);
											$data["success"] = $er["success"];
											$data["msg"] = $er["msg"];
										}
									} else {
										$data["success"] = false;
										$data["msg"] = "Preencha todos os campos!";
									}
									
									
									$a = $con->prepare("SELECT * FROM `usuarios` WHERE `login` = ?");
									$a->bind_param("s", $login);
									$a->execute();
									$a = $a->get_result();
									
									if ($a->num_rows && $data["success"]) {
										$data["success"] = false;
										$data["msg"] = "Username já existente.";
									}
									if ($data["success"]) {
										$a = $con->prepare("SELECT * FROM `usuarios` WHERE `email` = ? AND `status` = 1");
										$a->bind_param("s", $email);
										$a->execute();
										$a = $a->get_result();
										
										
										$ab = $con->prepare("SELECT * FROM `usuarios` WHERE `email` = ? AND `status` = 0");
										$ab->bind_param("s", $email);
										$ab->execute();
										$ab = $ab->get_result();
										
										
										if (!$a->num_rows) {
											if (!$ab->num_rows) {
												$b = $con->query("SELECT * FROM `usuarios` WHERE `login` = '" . $login . "';");
												if (!$b->num_rows) {
													$q = $con->prepare("INSERT INTO `usuarios`(`nome`,`login`,`senha`,`email`,`id`) VALUES (?,?,?,?,'')");
													$q->bind_param("ssss", $nome, $login, $senha, $email);
													$q->execute();
													if ($con->affected_rows > 0) {
														$data["success"] = true;
														$data["msg"] = "Sucesso ao criar conta!";
														if (logar($con->insert_id)) $data["msg"] .= ' (Logado Automaticamente)';
													} else {
														$data["success"] = false;
														$data["msg"] = "Falha ao criar conta!" . $q->affected_rows . $con->affected_rows;
													}
												} else {
													$data["success"] = false;
													$data["msg"] = "Username já usado!";
												}
											} else {
												$q = $con->prepare("UPDATE `usuarios` SET `nome` = ? ,`login` = ?,`senha` = ? , `status` = 1 WHERE `email` = ? ");
												$q->bind_param("ssss", $nome, $login, $senha, $email);
												$q->execute();
												if ($con->affected_rows) {
													$f = $con->prepare("SELECT id from usuarios WHERE login = ?");
													$f->execute([$login]);
													if (logar(mysqli_fetch_assoc($f->get_result())["id"])) $data["msg"] .= ' (Logado Automaticamente)';
													
													$data["success"] = true;
													$data["msg"] = "Sucesso ao criar conta!";
												} else {
													$data["success"] = false;
													$data["msg"] = "Falha ao criar conta!";
												}
											}
										} else {
											$data["success"] = false;
											$data["msg"] = "Email já usado!";
										}
									}
									
									break;
								case 'recuperar':
									if (!empty($_POST["email"])) {
										$email = cleanstring($_POST["email"]);
										if (Check_Email($email)) {
											$s = $con->query("SELECT * FROM `usuarios` WHERE `email` = '" . $email . "'");
											if ($s->num_rows > 0) {
												$ds = mysqli_fetch_array($s);
												$hash = md5(md5($email) . md5($ds["nome"]) . strtotime(date('m/d/Y h:i:s')));
												
												$k = $con->query("INSERT INTO `recuperar_senha` (`id_usuario`,`hash`,`email`,`data`) VALUES ('" . $ds["id"] . "','" . $hash . "','" . $email . "',NOW())");
												if ($k) {
													$link = "https://fichasop.com/conta/recuperar?recovery=" . $hash;
													$emailmsg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html>
           <head>
            <!-- Compiled with Bootstrap Email version: 1.2.0 -->
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta http-equiv="x-ua-compatible" content="ie=edge">
            <meta name="x-apple-disable-message-reformatting">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
            <style type="text/css">
              body,table,td{font-family:Helvetica,Arial,sans-serif !important}.ExternalClass{width:100%}.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:150%}a{text-decoration:none}*{color:inherit}a[x-apple-data-detectors],u+#body a,#MessageViewBody a{color:inherit;text-decoration:none;font-size:inherit;font-family:inherit;font-weight:inherit;line-height:inherit}img{-ms-interpolation-mode:bicubic}table:not([class^=s-]){font-family:Helvetica,Arial,sans-serif;mso-table-lspace:0pt;mso-table-rspace:0pt;border-spacing:0px;border-collapse:collapse}table:not([class^=s-]) td{border-spacing:0px;border-collapse:collapse}@media screen and (max-width: 600px){.w-full,.w-full>tbody>tr>td{width:100% !important}.w-24,.w-24>tbody>tr>td{width:96px !important}.p-lg-10:not(table),.p-lg-10:not(.btn)>tbody>tr>td,.p-lg-10.btn td a{padding:0 !important}.p-3:not(table),.p-3:not(.btn)>tbody>tr>td,.p-3.btn td a{padding:12px !important}.p-6:not(table),.p-6:not(.btn)>tbody>tr>td,.p-6.btn td a{padding:24px !important}*[class*=s-lg-]>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-4>tbody>tr>td{font-size:16px !important;line-height:16px !important;height:16px !important}.s-6>tbody>tr>td{font-size:24px !important;line-height:24px !important;height:24px !important}.s-10>tbody>tr>td{font-size:40px !important;line-height:40px !important;height:40px !important}}
            </style>
          </head>
          <body class="bg-black" style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; margin: 0; padding: 0; border-width: 0;" bgcolor="#000000">
            <table class="bg-black body" valign="top" role="presentation" border="0" cellpadding="0" cellspacing="0" style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; margin: 0; padding: 0; border-width: 0;" bgcolor="#000000">
              <tbody>
                <tr>
                  <td valign="top" style="line-height: 24px; font-size: 16px; margin: 0;" align="left" bgcolor="#000000">
                    <table class="container" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                      <tbody>
                        <tr>
                          <td align="center" style="line-height: 24px; font-size: 16px; margin: 0; padding: 0 16px;">
                            <!--[if (gte mso 9)|(IE)]>
                              <table align="center" role="presentation">
                                <tbody>
                                  <tr>
                                    <td width="600">
                            <![endif]-->
                            <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 600px; margin: 0 auto;">
                              <tbody>
                                <tr>
                                  <td style="line-height: 24px; font-size: 16px; margin: 0;" align="left">
                                    <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                      <tbody>
                                        <tr>
                                          <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;" align="left" width="100%" height="40">
                                            &#160;
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <table class="ax-center" role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                      <tbody>
                                        <tr>
                                          <td style="line-height: 24px; font-size: 16px; margin: 0;" align="left">
                                            <img class="w-24 rounded" src="https://fichasop.com/assets/img/fichasop.webp" style="height: auto; line-height: 100%; outline: none; text-decoration: none; display: block; border-radius: 4px; width: 96px; border-style: none; border-width: 0;" width="96">
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                      <tbody>
                                        <tr>
                                          <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;" align="left" width="100%" height="40">
                                            &#160;
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <table class="card p-6 p-lg-10 space-y-4 bg-dark text-light" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-radius: 6px; border-collapse: separate !important; width: 100%; overflow: hidden; color: #f7fafc; border: 1px solid #e2e8f0;" bgcolor="#1a202c">
                                      <tbody>
                                        <tr>
                                          <td style="line-height: 24px; font-size: 16px; width: 100%; color: #f7fafc; margin: 0; padding: 40px;" align="left" bgcolor="#1a202c">
                                            <h1 class="h3 fw-700 text-center" style="padding-top: 0; padding-bottom: 0; font-weight: 700 !important; vertical-align: baseline; font-size: 28px; line-height: 33.6px; margin: 0;" align="center">
                                              FichasOP
                                            </h1>
                                            <table class="s-4 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                              <tbody>
                                                <tr>
                                                  <td style="line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="left" width="100%" height="16">
                                                    &#160;
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                            <p class="text-center" style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="center">
                                              Ol&#225;. Uma recupera&#231;&#227;o de senha foi solicitada.
                                              Caso n&#227;o tenha solicitado, Ignore ou contate-nos.
                                            </p>
                                            <table class="s-4 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                              <tbody>
                                                <tr>
                                                  <td style="line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="left" width="100%" height="16">
                                                    &#160;
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                            <table class="btn btn-danger p-3 fw-700 ax-center" role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" style="border-radius: 6px; border-collapse: separate !important; font-weight: 700 !important; margin: 0 auto;">
                                              <tbody>
                                                <tr>
                                                  <td style="line-height: 24px; font-size: 16px; border-radius: 6px; font-weight: 700 !important; margin: 0;" align="center" bgcolor="#dc3545">
                                                    <a href="' . $link . '" style="color: #ffffff; font-size: 16px; font-family: Helvetica, Arial, sans-serif; text-decoration: none; border-radius: 6px; line-height: 20px; display: block; font-weight: 700 !important; white-space: nowrap; background-color: #dc3545; padding: 12px; border: 1px solid #dc3545;">Recuperar Conta</a>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <table class="s-6 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                      <tbody>
                                        <tr>
                                          <td style="line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="left" width="100%" height="24">
                                            &#160;
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <div class="text-muted text-center" style="color: #718096;" align="center">
                                      <span>Obrigado por utilizar o nosso site &lt;3</span><br>
                                      <a href="https://fichasop.com" style="color: #0d6efd;">fichasop.com</a>
                                    </div>
                                    <table class="s-6 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                      <tbody>
                                        <tr>
                                          <td style="line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="left" width="100%" height="24">
                                            &#160;
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                            <!--[if (gte mso 9)|(IE)]>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                            <![endif]-->
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </body>
        </html>';// Link -> Recuperar Senha.
													if (Send_Email('Recuperar Conta', $email, $emailmsg)) {
														$data["success"] = true;
														$data["msg"] = 'Email enviado, Verifique sua caixa de email';
													} else {
														$data["success"] = false;
														$data["msg"] = "Falha ao enviar email, contate um administrador.";
													}
													
													
												}
											} else {
												$data["success"] = false;
												$data["msg"] = 'Nenhuma conta encontrada com esse email...';
											}
											
										} else {
											$data["msg"] = "Email inserido não é valido.";
											$data["success"] = false;
										}
									} else {
										$data["success"] = false;
										$data["msg"] = "Preencha todos os campos!";
									}
									
									break;
							}
							break;

					}
					break;
			}
			break;
	}
	exit(json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));
}



