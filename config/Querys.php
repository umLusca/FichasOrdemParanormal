<?php
if (isset($_POST["query"]) && !empty($_POST["query"])) {
	header("Content-Type: application/json");
	$data = array(
		"success" => true,
		"msg" => ""
	);
	switch (cleanstring($_POST["query"])) {
		default:
			$data = array(
				"success" => false,
				"msg" => "Nenhum query encontrada"
			);
			break;
		case "conta_update":
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
					if (isset($_POST["nsenha"], $_POST["csenha"]) && !empty($_POST["nsenha"]) && !empty($_POST["csenha"])) {
						$nsenha = cleanstring($_POST["nsenha"]);
						$csenha = cleanstring($_POST["csenha"]);
						if (Check_Pass($nsenha, $csenha)) {
							$a = $con->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
							$nsenha = PassCheck($nsenha);
							$a->bind_param("si", $nsenha, $_SESSION["UserID"]);
							$a->execute();
							if ($con->affected_rows) {
								$success = true;
								$msg .= "Sucesso ao alterar senha;";
							} else {
								$success = false;
								$msg = "Erro no banco de dados.";
							}
						} else {
							$success = false;
							$msg = Check_Pass($nsenha, $csenha, 1)["msg"];
						}
					} else {
						if (isset($_POST["nsenha"]) && !empty($_POST["nsenha"])) {
							$success = false;
							$msg = "Preencha os campo das senhas;";
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
										$success = true;
										$msg .= "Alterado Email;";
									} else {
										$success = false;
										$msg .= "Falha ao alterar email, erro na database;";
									}
								} else {
									$success = false;
									$msg .= "Este email ja está em uso;";
								}
							} else {
								$c = $con->prepare("UPDATE usuarios SET email = ? WHERE id = ?");
								$c->bind_param("si", $email, $_SESSION["UserID"]);
								$c->execute();
								
								if ($con->affected_rows) {
									$_SESSION["UserEmail"] = $email;
									$success = true;
									$msg .= "Alterado Email;";
								} else {
									$success = false;
									$msg .= "Falha ao alterar, erro na database.";
								}
							}
						} else {
							$success = false;
							$msg .= "Este email não é válido";
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
									$success = true;
									$msg .= "Alterado Username;";
								} else {
									$success = false;
									$msg .= "Falha ao alterar username, erro na database;";
								}
							} else {
								$success = false;
								$msg .= "Este username ja está em uso;";
							}
						} else {
							$success = false;
							$msg .= "Este username não é válido;";
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
								$success = true;
								$msg .= "Alterado Nome;";
							} else {
								$success = false;
								$msg .= "Falha ao alterar nome, erro na database;";
							}
						} else {
							$success = false;
							$msg .= "Este Nome não é válido;";
						}
					}
					
					
				} else {
					$success = false;
					$msg = "Sua senha atual está incorreta;";
				}
			} else {
				$success = false;
				$msg = "Sua sessão encerrou;";
			}
			
			$data["success"] = $success;
			$data["msg"] = $msg;
			
			echo json_encode($data);
			exit;
			break;
		case "conta_login":
			$success = true;
			if (!empty($_POST["login"])) {
				$login = cleanstring($_POST["login"]);
			} else {
				$success = false;
				$msg = "Preencha todos os campos!";
			}
			if (!empty($_POST["senha"])) {
				$pass = cleanstring($_POST["senha"]);
			} else {
				$success = false;
				$msg = "Preencha todos os campos!";
			}
			if ($success) {
				$q = $con->prepare("select * from `usuarios` WHERE `login` = ? OR `email` = ?");
				$q->bind_param("ss", $login, $login);
				$q->execute();
				$rq = $q->get_result();
				if ($rq->num_rows) { //Verifica se existe essa conta e se a senha coincide com ela
					$dados = mysqli_fetch_array($rq);
					if ($dados["senha"] === cryptthis($pass)) {
						logar($dados["login"]);
						if (isset($_POST["lembrar"]) && ($_POST["lembrar"] === 'on' || $_POST["lembrar"] === 1)) {
							remember_me($dados["id"], 7, "WEB");
						}// Quando a opção lembrar-me está marcada
						$msg = "Sucesso ao fazer login!";
						$success = true;
						
						$newhash = PassCheck($pass);
						$a = $con->prepare("UPDATE usuarios SET senha = ? WHERE login = ?");
						$a->bind_param("ss", $newhash, $dados["login"]);
						$a->execute();
						
						
					} else if (PassCheck($pass, $dados["senha"])) {
						logar($dados["login"]);
						if (isset($_POST["lembrar"]) && ($_POST["lembrar"] === 'on' || $_POST["lembrar"] === 1)) {
							remember_me($dados["id"], 7, "WEB");
						}// Quando a opção lembrar-me está marcada
						$msg = "Sucesso ao entrar!";
						$success = true;
						
					} else {
						$msg = "Usuario/Senha Incorreto!";
						$success = false;
					}
				} else {
					$msg = "Nenhuma conta encontrada!";
					$success = false;
				}
				
			} // Verificação dos dados
			$_SESSION["timeout"] += 1;
			$data["tentativas"] = 5 - $_SESSION["timeout"];
			$data["success"] = $success;
			$data["msg"] = $msg;
			break;
		case "conta_cadastro":
			$success = true;
			if (!empty($_POST["nome"])) {
				$nome = cleanstring($_POST["nome"], 50);
				if (!Check_Name($nome)) {
					$msg = "Apenas Letras e Espaços são permitidos no nome!";
					$success = false;
				}
			} else {
				$success = false;
				$msg = "Preencha todos os campos!";
			}
			
			if (!empty($_POST["login"])) {
				$login = $_POST["login"];
				if (!Check_Login($login)) {
					$success = false;
					$msg = "O Username tem que ter Apenas letras, números e \"_\"";
				}
				if (strlen($login) > 16) {
					$success = false;
					$msg = "O username não pode ter mais de 16 caracteres.";
				}
			} else {
				$success = false;
				$msg = "Preencha todos os campos!";
			}
			
			if (!empty($_POST["email"])) {
				$email = cleanstring($_POST["email"]);
				if (!Check_Email($email)) {
					$msg = "Email inserido não é valido.";
					$success = false;
				}
			} else {
				$success = false;
				$msg = "Preencha todos os campos!";
			}
			
			if (!empty($_POST["senha"] || $_POST["csenha"])) {
				if (Check_Pass($_POST["senha"], $_POST["csenha"])) {
					$senha = PassCheck(cleanstring($_POST["senha"]));
				} else {
					$er = Check_Pass($_POST["senha"], $_POST["csenha"], true);
					$success = $er["success"];
					$msg = $er["msg"];
				}
			} else {
				$success = false;
				$msg = "Preencha todos os campos!";
			}
			
			
			$a = $con->prepare("SELECT `id` FROM `usuarios` WHERE `login` = ?");
			$a->bind_param("s", $login);
			$a->execute();
			$a = $a->get_result();
			
			if ($a->num_rows) {
				$success = false;
				$msg = "Username já existente.";
			}
			if ($success) {
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
								$success = true;
								$msg = "Sucesso ao criar conta!";
								if (logar($login)) $msg .= ' (Logado Automaticamente)';
							} else {
								$success = false;
								$msg = "Falha ao criar conta!" . $q->affected_rows . $con->affected_rows;
							}
						} else {
							$success = false;
							$msg = "Username já usado!";
						}
					} else {
						$q = $con->prepare("UPDATE `usuarios` SET `nome` = ? ,`login` = ?,`senha` = ? , `status` = 1 WHERE `email` = ? ");
						$q->bind_param("ssss", $nome, $login, $senha, $email);
						$q->execute();
						if ($q->affected_rows == 1) {
							$success = true;
							$msg = "Sucesso ao criar conta!";
							if (logar($login)) $msg .= ' (Logado Automaticamente)';
						} else {
							$success = false;
							$msg = "Falha ao criar conta!";
						}
					}
				} else {
					$success = false;
					$msg = "Email já usado!";
				}
			}
			$data["success"] = $success;
			$data["msg"] = $msg;
			break;
		case "conta_addmarca":
			$userid = $_SESSION["UserID"];
			if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp)$/', cleanstring($_POST["urlmarca"])) || empty($_POST["urlmarca"])) {
				$marca = cleanstring($_POST["urlmarca"]);
				$q = $con->query("SELECT * FROM `usuarios` WHERE `id` = '" . $_SESSION["UserID"] . "';");
				$rq = mysqli_fetch_array($q);
				if ($marca != $rq["marca"]) {
					$a = $con->prepare("UPDATE `usuarios` SET `marca` = ? WHERE `id` = ? ;");
					$a->bind_param("si", $marca, $userid);
					$a->execute();
					$data["success"] = (bool)$con->affected_rows;
					if ($data["success"]) {
						$_SESSION["UserMarca"] = cleanstring($_POST["urlmarca"]);
						$msg = "Marca alterada com Sucesso";
					}
				} else {
					$success = false;
					$msg = "Sua marca é igual a anterior, nada alterado.";
				}
			} else {
				$success = false;
				$msg = "O link não é válido...";
			}
			$data["success"] = $success;
			$data["msg"] = $msg;
			break;
			
		case 'mestre_add_nota':
			$token = cleanstring($_GET["token"] ? : $_POST["token"]);
			$y = $con->prepare("INSERT INTO `notes`(`id`,`nome`,`notas`,`missao`) VALUES ('','Título','È Recomendado usar notas externas!',(SELECT id from missoes WHERE token = ? AND mestre = ?));");
			$y->bind_param("si",$token,$_SESSION["UserID"]);
			$y->execute();
			break;
		case 'mestre_delete_nota':
			$token = cleanstring($_GET["token"] ? : $_POST["token"]);
			$nid = (int)$_POST["note"];
			$tvar = $con->prepare("DELETE FROM `notes` WHERE `id` = ? AND `missao` in (SELECT id FROM missoes WHERE token =? AND mestre = ?)");
			$tvar->bind_param("isi",$nid,$token,$_SESSION["UserID"]);
			$tvar->execute();
			break;
		case 'mestre_update_nota':
			$token = cleanstring($_GET["token"] ? : $_POST["token"]);
			$a = count($_POST["titulo"]);
			$b = 0;
			while ($b < $a) {
				if (!empty($_POST["titulo"])) {
					$tit = $_POST["titulo"][$b];
					if (!preg_match("/^[áàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑa-zA-Z-' 0-9]*$/", $tit)) {
						$tit = "Títulob";
					}
				} else {
					$tit = "Títuloa";
				}
				if (strlen($tit) > 30) {
					$tit = "Títuloasc";
				}
				$des = cleanstring($_POST["nota"][$b]);
				$nota = intval($_POST["id"][$b]);
				$y = $con->prepare("UPDATE `notes` SET `nome` = ?, `notas` = ? WHERE `id`= ? AND `missao` in (SELECT id FROM missoes where token = ? and mestre = ?);");
				$y->bind_param("ssiss",$tit,$des,$nota,$token,$_SESSION["UserID"]);
				$y->execute();
				$b++;
			}
			break;
		
		case "mestre_update_iniciativa":
			foreach ($_POST["init"] as $i => $init){
				$z = $con->prepare("UPDATE iniciativas SET `nome`= ?,`iniciativa`= ?,`prioridade`= ?,`dano`= ? WHERE iniciativas.id = ?");
				$p = $i+1;
				$z->bind_param("siiii", $init["n"], $init["i"], $init["p"], $init["d"], $init["id"]);
				$z->execute();
				$data["i"][] = $i;
				$data["p"][$i] = $p;
				$data["inits"][] = $init;
				$data["updated"][]=$z->affected_rows;
			}
			$data["missao"] = $id;
			$data["post"] = $_POST;
			break;
		case 'mestre_add_iniciativa':
			$token = cleanstring($_GET["token"] ? : $_POST["token"]);
			$f = $con->prepare("INSERT INTO `iniciativas` (`id_missao`) VALUES ((SELECT id FROM missoes where token = ? AND mestre = ?));");
			$f->bind_param("si",$token,$_SESSION["UserID"]);
			$f->execute();
			break;
		case 'mestre_delete_iniciativa':
			$token = cleanstring($_GET["token"] ? : $_POST["token"]);
			$initid = (int)$_POST["iniciativa_id"];
			$f = $con->prepare("DELETE FROM `iniciativas` WHERE  `id`= ? AND `id_missao` in (SELECT id FROM missoes WHERE token = ? AND mestre = ?);");
			$f->bind_param("isi",$initid, $token,$_SESSION["UserID"]);
			$f->execute();
			$data["ar"] = $con->affected_rows;
			break;
			
			
		case 'add_dado_customizado':
			$nome = cleanstring($_POST["nome"]);
			$dado = cleanstring($_POST["dado"]);
			$dano = ($_POST["dano"] == 'on' or $_POST["dano"] == 1) ? 1 : 0;
			if (empty($nome)) {
				$nome = $dado;
			}
			$foto = minmax(intval($_POST["icone"]), 0, 13);
			$token = cleanstring($_POST["token"]);
			$y = $con->prepare("INSERT INTO `dados_customizados`(`nome`,`foto`,`dado`,`dano`,`token_pai`,token) VALUES ( ? , ? , ? , ? , ?, uuid_short() );");
			$y->bind_param("sisis", $nome, $foto, $dado, $dano, $token);
			$y->execute();
			break;
		case 'edit_dado_customizado':
			$nome = cleanstring($_POST["nome"]);
			$dado = cleanstring($_POST["dado"]);
			$dano = cleanstring(($_POST["dano"] == 'on' or $_POST["dano"] == 1) ? 1 : 0);
			$foto = minmax((int)$_POST["icone"], 0, 13);
			$token_dado = (int)$_POST["token_pai"];
			$token = cleanstring($_GET["token"] ? : $_POST["token"]);
			if (empty($nome)) {
				$dado = $nome;
			}
			$y = $con->prepare("UPDATE `dados_customizados` SET `nome` = ?, `dado` = ?, `foto` = ?, `dano` = ? where `token` = ? AND `token_pai` = ?;");
			$y->bind_param("ssiiis", $nome, $dado, $foto, $dano, $token_dado, $token);
			$y->execute();
			break;
		case 'delete_dado_customizado':
			$token_dado = (int)$_POST["token_pai"];
			$token = cleanstring($_POST["token"]);
			$y = $con->prepare("DELETE FROM `dados_customizados` WHERE `token` = ? AND `token_pai` = ? ;");
			$y->bind_param("is",$token_dado,$token);
			$y->execute();
			
			break;
		
		
		case 'mestre_update_status_fichasnpc':
			$ficha_id = (int)$_POST["ficha"];
			
			$token = cleanstring($_GET["token"] ? : $_POST["token"]);
			$data = $_POST["data"];
			
			if($data["pva"] >= $data["pv"]+20) $data["pva"] = $data["pv"]+20;
			if($data["pva"] < 0) $data["pva"] = 0;
			
			if($data["sana"] >= $data["san"]+20) $data["sana"] = $data["san"]+20;
			if($data["sana"] < 0) $data["sana"] = 0;
			
			if($data["pea"] >= $data["pe"]+20) $data["pea"] = $data["pe"]+20;
			if($data["pea"] < 0) $data["pea"] = 0;
			
			$st = get_stmt($data,array("id","missao"),"fichas_npc",$con);
			$st["bind"] .= "isi";
			$st["values"][] = $ficha_id;
			$st["values"][] = $token;
			$st["values"][] = $_SESSION["UserID"];
			
			$_a = $con->prepare("UPDATE fichas_npc SET {$st["query"]} WHERE id =? AND missao in (SELECT id from missoes WHERE token = ? AND mestre = ?)");
			$_a->bind_param($st["bind"],...$st["values"]);
			$_a->execute();
			
			break;
		case 'mestre_desvincular_player':
			$p = (int)$_POST["p"];
			$token = cleanstring($_GET["token"] ? : $_POST["token"]);
			
			$f = $con->prepare("DELETE FROM `ligacoes` WHERE `id_ficha`=? AND `id_missao`in(SELECT id from missoes WHERE missoes.token =? AND mestre = ?);");
			$f->bind_param("isi",$p,$token,$_SESSION["UserID"]);
			$f->execute();
			
			break;
		case "mestre_duplicar_fichanpc":
			$npc = (int)($_POST["npc"]);
			$token = cleanstring($_GET["token"] ? : $_POST["token"]);
			$a = $con->prepare("SELECT * FROM fichas_npc WHERE id = ? AND missao in (SELECT id from missoes WHERE token = ? AND mestre = ?);");
			$a->bind_param("isi", $npc, $token, $_SESSION["UserID"]);
			$a->execute();
			$ra = mysqli_fetch_assoc($a->get_result());
			$stmt = duplicate_row($ra, null, array("id"));
			$b = $con->prepare("INSERT INTO fichas_npc ({$stmt["query_columns"]}) VALUES ({$stmt["query_values"]})");
			$b->bind_param($stmt["bind_types"], ...$stmt["bind_values"]);
			$b->execute();
			break;
		case 'mestre_delete_fichanpc':
			$npc = (int)$_POST["npc"];
			$token = cleanstring($_GET["token"] ? : $_POST["token"]);
			$f = $con->prepare("DELETE FROM `fichas_npc` WHERE `id` = ? AND missao in (SELECT id FROM missoes WHERE mestre = ? AND token = ?)");
			$f->bind_param("iis",$npc,$_SESSION["UserID"],$token);
			$f->execute();
			$data["af"] = $token;
			break;
		case 'mestre_add_fichasnpc':
			
			$token = cleanstring($_GET["token"] ? : $_POST["token"]);
			$nome = cleanstring($_POST["nome"]);
			$pv = minmax($_POST["pv"], 1, 999999999);
			$categoria = minmax($_POST["monstro"], 0, 1);
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
			//$pres = minmax($_POST["prestidigitacao"]);
			$prof = minmax($_POST["profissao"]);
			$refl = minmax($_POST["reflexos"]);
			$reli = minmax($_POST["religiao"]);
			$sobr = minmax($_POST["sobrevivencia"]);
			$tati = minmax($_POST["tatica"]);
			$tecn = minmax($_POST["tecnologia"]);
			$vont = minmax($_POST["vontade"]);
			$ataq = cleanstring($_POST["ataques"], 5000);
			$habs = cleanstring($_POST["habilidades"], 5000);
			$deta = cleanstring($_POST["detalhes"], 5000);
			if (strlen($nome) > 30) {
				$nome = "NPC";
			}
			$t = $con->prepare("INSERT INTO `fichas_npc`(`missao`,`nome`,`categoria`,`pv`,`pva`,`san`,`sana`,`pe`,`pea`,`forca`,`agilidade`,
                         `inteligencia`,`presenca`,`vigor`,`passiva`,`esquiva`,`morte`,`sangue`,`energia`,`conhecimento`,
                         `balistica`,`fisica`,`mental`,`acrobacia`,`adestramento`,`artes`,`atletismo`,`atualidade`,`ciencia`,`crime`,
                         `diplomacia`,`enganacao`,`fortitude`,`furtividade`,`iniciativa`,`intimidacao`,`intuicao`,`investigacao`,`luta`,`medicina`,
                         `ocultismo`,`percepcao`,`pilotagem`,`pontaria`,`profissao`,`reflexos`,`religiao`,`sobrevivencia`,`tatica`,`tecnologia`,
                         `vontade`,`ataques`,`habilidades`,`detalhes`) VALUES
                        ( (SELECT id FROM missoes where token = ? AND mestre = ?) , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? )");
			$t->bind_param('sisiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiisss',$token,$_SESSION["UserID"] , $nome, $categoria, $pv, $pv, $san, $san, $pe, $pe, $for, $agi, $int, $pre, $vig, $passiva, $esquiva, $morte, $sangue, $energia, $conhecimento, $balistica, $fisica, $mental, $acro, $ades, $arte, $atle, $atua, $cien, $crim, $dipl, $enga, $fort, $furt, $inic, $inti, $intu, $inve, $luta, $medi, $ocul, $perc, $pilo, $pont, $prof, $refl, $reli, $sobr, $tati, $tecn, $vont, $ataq, $habs, $deta);
			$t->execute();
			break;
		case 'mestre_update_fichasnpc':
			$token = cleanstring($_GET["token"] ? : $_POST["token"]);
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
			$t->bind_param('siiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiisssiis', $nome, $categoria, $pv, $pv, $san, $san, $pe, $pe, $for, $agi, $int, $pre, $vig, $passiva, $esquiva, $morte, $sangue, $energia, $conhecimento, $balistica, $fisica, $mental, $acro, $ades, $arte, $atle, $atua, $cien, $crim, $dipl, $enga, $fort, $furt, $inic, $inti, $intu, $inve, $luta, $medi, $ocul, $perc, $pilo, $pont, $prof, $refl, $reli, $sobr, $tati, $tecn, $vont, $ata, $habs, $dets, $fid, $_SESSION["UserID"],$token);
			$t->execute();
			break;
		case 'mestre_add_player':
			$type = 1;
			$success = true;
			if (!empty($_POST["user"])) {
				$email = cleanstring($_POST["user"]);
			} else {
				$success = false;
				$msg = "Preencha o campo!";
			}
			
			$token = cleanstring($_GET["token"] ? : $_POST["token"]);
			
			if ($success) {
				$z = $con->prepare("SELECT * FROM `usuarios` WHERE `email`= ? OR login = ?;"); // verifica se a conta existe
				$z->bind_param("ss", $email,$email);
				$z->execute();
				$z = $z->get_result();
				if ($z->num_rows) { //Conta EXISTE!
					$user = mysqli_fetch_assoc($z);
					
					$x = $con->prepare("SELECT * FROM ligacoes WHERE id_usuario in (SELECT id from usuarios where email = ? OR login=?) AND id_missao in (SELECT id from missoes WHERE token = ? AND mestre =?) and id_ficha is null");
					$x->bind_param("sssi", $email,$email, $token,$_SESSION["UserID"]);
					$x->execute();
					$x = $x->get_result();
					if (!$x->num_rows) { // Não existe convite PENDENTE.
						$y = $con->prepare("INSERT INTO `ligacoes`(token,id_missao,id_usuario) VALUES (UUID(),(SELECT id FROM missoes WHERE token = ? AND mestre = ?),?);");
						$y->bind_param("sii", $token,$_SESSION["UserID"], $user["id"]);
						$y->execute();
					}
					if ($user["status"]) {
						$msg = "Jogador convidado! (Conta Existente)";
					} else {
						$msg = "Jogador convidado! (Conta Inexistente)";
					}
					
				} else { // CONTA Não EXISTE
					$type = 2;
					
					if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
						$x = $con->prepare("INSERT INTO usuarios(status,email) VALUES (0,?)");
						$x->bind_param("s", $email);
						$x->execute();
						$xid = $con->insert_id;
						
						$y = $con->prepare("INSERT INTO ligacoes(token, id_missao, id_usuario) VALUES (uuid(),(SELECT id FROM missoes WHERE missoes.token =? and mestre = ?),?)");
						$y->bind_param("sii", $token,$_SESSION["UserID"], $xid);
						$y->execute();
						
						$msg = "Jogador convidado! (Conta Inexistente)";
						$link = 'https://fichasop.com/?convite=1&email=' . $email;
						
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
                                      Ol&#225;, voc&#234; foi convidado para participar de uma miss&#227;o.
                                      Continue e crie sua conta junto da ficha clicando abaixo.
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
                                    <table class="btn btn-primary p-3 fw-700 ax-center" role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" style="border-radius: 6px; border-collapse: separate !important; font-weight: 700 !important; margin: 0 auto;">
                                      <tbody>
                                        <tr>
                                          <td style="line-height: 24px; font-size: 16px; border-radius: 6px; font-weight: 700 !important; margin: 0;" align="center" bgcolor="#0d6efd">
                                            <a href="' . $link . '" style="color: #ffffff; font-size: 16px; font-family: Helvetica, Arial, sans-serif; text-decoration: none; border-radius: 6px; line-height: 20px; display: block; font-weight: 700 !important; white-space: nowrap; background-color: #0d6efd; padding: 12px; border: 1px solid #0d6efd;">Aceitar Convite.</a>
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
                              <span>Obrigado por utilizar nosso site &lt;3</span><br>
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
</html>';
						$fromname = 'FichasOP';
						$subject = 'Convite - FichasOP';
						($success && Send_Email($subject, $email, $emailmsg)) ? $msg .= ' (Email enviado com sucesso.)' : $msg .= '(Email não enviado.)';
						
					} else {
						
						$msg = "Nenhuma conta encontrada, tente usando um Email.";
						$success = false;
					}
				}
			}
			$data["msg"] = $msg;
			$data["success"] = $success;
			$data["email"] = $email;
			$data["type"] = $type;
			break;
		case 'mestre_npc':
			$token = cleanstring($_GET["token"] ? : $_POST["token"]);
			$npc = (int)$_POST["ficha"];
			
			$ss = $con->prepare('SELECT * FROM fichas_npc WHERE id = ? AND missao in (SELECT id FROM missoes where token = ? AND mestre = ?);');
			$ss->bind_param("isi",$npc,$token,$_SESSION["UserID"]);
			$ss->execute();
			$data = mysqli_fetch_array($ss->get_result());
			break;
			
			
			
			
		case 'rolar_dado':
			$dado = DadoDinamico(cleanstring($_POST["dado"], 50), $dc);
			$dano = minmax((int)$_POST["dano"], 0, 1);
			$margem = (int)$_POST["margem"];
			if (ClearRolar($dado)) {
				$data = RolarMkII($dado, $dano,$margem);
				$data["success"] = true;
			} else {
				$data = ClearRolar($dado, true);
			}
			$data["dado"] = $dado;
	}
	exit(json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));
}



