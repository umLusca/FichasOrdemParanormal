<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_startup_errors', true);
ini_set('display_errors', true);
$app = true;
require_once "./../config/includes.php";
$con = con();

$_DATA = $_POST ?: [];
if (!empty(file_get_contents('php://input'))) {
	$body = json_decode(file_get_contents('php://input'), true);
	if (!empty($body)) {
		$_DATA += $body;
	}
}
$_QUERY = $_DATA["query"];

$return = array("success" => false, "msg" => "", "error" => "000");
/*
 * 000 = Not found
 * 001 = No permission
 * 002 = Invalid input
 * 003 = Failed
 * 004 = session closed


$_QUERY = match ($_QUERY) {
	"account_user_get" => "checksession" || "get_account" || "check_session" || "account_check" || "login" || "account_login" || "conta_login",
	"account_user_create" => "create_account" || "account_create" || "conta_cadastro",
	"account_user_update" =>  "conta_update",
	"account_user_logout" => "deslogar",
	"account_marca_update" => "set_marca" || "conta_update_marca",
	"account_recovery_set" => "recovery_account" || "account_recovery" || "conta_recuperar",
	"ficha_info_get" => "get_ficha",
	"ficha_all_get" => "get_fichas",
	"ficha_info_update" => "update_ficha",
	"etc_roll" => "roll",
	"ficha_info_create" => "create_ficha",
};
*/
function isMobile(): bool
{
	return (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4)));
}

function checksession($token)
{
	$con = con();
	$token = cleanstring($token);
	if (empty($token)) {
		return false;
	}
	
	$e = explode(':', $token);
	$string = $e[0];
	$Secret = $e[1];
	
	
	$a = $con->prepare("SELECT id, selector, hashed_validator, user_id, expiry FROM user_tokens WHERE selector = ? AND expiry >= now() LIMIT 1;");
	$a->bind_param("s", $string);
	$a->execute();
	$tokens = mysqli_fetch_assoc($a->get_result());
	
	if ($token && password_verify($Secret, $tokens['hashed_validator'])) {
		$a = $con->prepare('SELECT usuarios.id, usuarios.login FROM usuarios INNER JOIN user_tokens ON user_id = usuarios.id WHERE selector = ? AND expiry > now() LIMIT 1');
		$a->bind_param("s", $string);
		$a->execute();
		$ra = $a->get_result();
		if ($ra->num_rows) {
			$user = mysqli_fetch_assoc($ra);
			return $user['id'];
		}
	}
	return false;
	
}

function autoPrepare(array $array, array $excludes = null, array|string $includes = null, mysqli $con = null): array
{
	$values = [];
	$query = "";
	
	if (isset($includes, $con) && is_string($includes)) {
		$_d = $con->query("SHOW COLUMNS FROM {$includes} ;");
		$includes = [];
		foreach ($_d as $f) {
			$includes[] = $f["Field"];
		}
	}
	foreach ($array as $item => $valor) {
		$i++;
		if (isset($excludes) && is_array($excludes) && in_array($item, $excludes, true)) {
			$continue = true;
		}
		if (isset($includes) && is_array($includes) && !in_array($item, $includes, true)) {
			$continue = true;
		}
		if ($i === count($array) && $continue) {
			$query = substr($query, 0, -2);
			$continue = false;
			continue;
		}
		if ($continue) {
			$continue = false;
			continue;
		}
		$query .= "$item = ?";
		
		if ($i < count($array)) {
			$query .= ", ";
		}
		
		$values[] = $valor;
	}
	return array(
		"query" => $query,
		"values" => $values
	);
}


if (empty($_QUERY)) {
	goto notFound;
}
[$category, $subcategory, $action] = explode("_", $_QUERY);

$session_id = cleanstring($_DATA["sessid"] ?: "");

if (!empty($category)) {
	switch ($category) {
		default:
			goto notFound;
		case "account":
			switch ($subcategory) {
				default:
					goto notFound;
				case "user";
					switch ($action) {
						default:
							goto notFound;
						case "create":
							if (!empty($_DATA["nome"])) { // ok
								$nome = cleanstring($_DATA["nome"], 50);
								
								if (!empty($_DATA["login"])) {
									$login = $_DATA["login"];
									
									if (!empty($_DATA["email"])) {
										$email = cleanstring($_DATA["email"]);
										
										if (!empty($_DATA["senha"] || $_DATA["csenha"])) {
											$senha = Check_Pass($_DATA["senha"], $_DATA["csenha"]);
											
											if (Check_Name($nome)) {
												if (Check_Login($login) && strlen($login) < 16) {
													if (Check_Email($email)) {
														if (Check_Pass($_DATA["senha"], $_DATA["csenha"])) {
															$a = $con->prepare("SELECT * FROM `usuarios` WHERE `login` = ? or email = ?");
															$a->bind_param("ss", $login, $email);
															$a->execute();
															$a = $a->get_result();
															if (!$a->num_rows) {
																$q = $con->prepare("INSERT INTO `usuarios`(`nome`,`login`,`senha`,`email`,`token`) VALUES (?,?,?,?,uuid());");
																$q->bind_param("ssss", $nome, $login, $senha, $email);
																$q->execute();
																
																$f = mysqli_fetch_assoc($con->query("SELECT * usuarios WHERE id = {$con->insert_id}"));
																if ($con->affected_rows > 0) {
																	logar($login);
																	$return["success"] = true;
																	$return["msg"] = "Conta criada!";
																	
																	$token = remember_me($f["id"], 7, string);
																	$conta["nome"] = $f["nome"];
																	$conta["email"] = $f["email"];
																	$conta["login"] = $f["login"];
																	$conta["token"] = $token;
																	
																} else {
																	$return["success"] = false;
																	$return["msg"] = "Falha ao criar conta!";
																}
															} else {
																$a = mysqli_fetch_assoc($a);
																if ((int)$a["status"]) {
																	$return["success"] = false;
																	$return["msg"] = "Email já cadastrado.";
																} else {
																	$q = $con->prepare("UPDATE `usuarios` SET `nome` = ? ,`login` = ?,`senha` = ? , `status` = 1 WHERE `email` = ? ");
																	$q->bind_param("ssss", $nome, $login, $senha, $email);
																	$q->execute();
																	if ($q->affected_rows) {
																		logar($login);
																		$token = remember_me($a["id"], 7, isMobile() ? "APP" : "WEB");
																		
																		$conta["nome"] = $a["nome"];
																		$conta["email"] = $a["email"];
																		$conta["login"] = $a["login"];
																		$conta["token"] = $token;
																		
																		$return["success"] = true;
																		$return["msg"] = "Conta criada!";
																	} else {
																		$return["success"] = false;
																		$return["msg"] = "Falha ao criar conta!";
																	}
																}
															}
														} else {
															$er = Check_Pass($_DATA["senha"], $_DATA["csenha"], true);
															$return["success"] = false;
															$return["msg"] = $er["msg"];
														}
													} else {
														$return["msg"] = "Email inválido.";
														$return["success"] = false;
													}
												} else {
													$return["success"] = false;
													$return["msg"] = "Seu username só pode ter letras, números e \"_\"";
												}
											} else {
												$return["msg"] = "Seu nome só pode ter letras e espaços.";
												$return["success"] = false;
											}
										} else {
											$return["success"] = false;
											$return["msg"] = "Insira uma senha.";
										}
									} else {
										$return["success"] = false;
										$return["msg"] = "Insira um email.";
									}
								} else {
									$return["success"] = false;
									$return["msg"] = "Insira um username.";
								}
							} else {
								$return["success"] = false;
								$return["msg"] = "Insira um nome.";
							}
							break;
						case "get":
							if (!empty($session_id)) {
								if (checksession($session_id)) {
									$user = checksession($session_id);
									$q = $con->prepare("SELECT * FROM `usuarios` WHERE `id`  = ?;");
									$q->bind_param("i", $user);
									$q->execute();
									
									$q = $q->get_result();
									if ($q->num_rows) {
										$tv = mysqli_fetch_array($q);
										$return["success"] = true;
										$conta["nome"] = $tv["nome"];
										$conta["email"] = $tv["email"];
										$conta["login"] = $tv["login"];
										$return["conta"] = $conta;
									} else {
										$return["success"] = false;
										$return["msg"] = 'Essa conta não existe.';
									}
								} else {
									$return["success"] = false;
									$return["msg"] = 'Sua conta já foi encerrada.';
								}
							} else if (!empty($_DATA["login"])) {
								$login = cleanstring($_DATA["login"]);
								if (!empty($_DATA["senha"])) {
									$senha = cleanstring($_DATA["senha"]);
									$qu = $con->prepare("SELECT * FROM `usuarios` WHERE (usuarios.login = ?) OR (usuarios.email = ?);");
									$qu->bind_param("ss", $login, $login);
									$qu->execute();
									$qu = $qu->get_result();
									if ($qu->num_rows) {
										$rq = mysqli_fetch_assoc($qu);
										$token = remember_me($rq["id"], 7, generateRandomString(3));
										if (cryptthis($senha) === $rq["senha"] || PassCheck($senha, $rq["senha"])) {
											logar($rq["id"]);
											$return["success"] = true;
											$return["msg"] = "Sucesso ao fazer login!";
											
											$conta["nome"] = $rq["nome"];
											$conta["email"] = $rq["email"];
											$conta["login"] = $rq["login"];
											$return["conta"] = $conta;
											
											$return["conta"]["token"] = $token;
											if (cryptthis($senha) === $rq["senha"]) {
												$f = $con->prepare("UPDATE usuarios SET senha = ? WHERE usuarios.login = ?");
												$nsenha = PassCheck($senha);
												$f->bind_param("ss", $nsenha, $login);
												$f->execute();
												
											}
										} else {
											$return["success"] = false;
											if (Check_Email($login)) {
												$return["msg"] = "Email e/ou senha incorretos.";
											} else {
												$return["msg"] = "Username e/ou senha incorretos.";
											}
										}
									} else {
										$return["success"] = false;
										if (Check_Email($login)) {
											$return["msg"] = "Email e/ou senha incorretos.";
										} else {
											$return["msg"] = "Username e/ou senha incorretos.";
										}
									}
								} else {
									$return["success"] = false;
									$return["msg"] = "Preencha sua senha.";
								}
							} else {
								$return["success"] = false;
								$return["msg"] = "Preencha seu username/email.";
							}
							break;
						case "update":
							if (checksession($session_id)) {
								if (isset($_DATA["asenha"]) && !empty($_DATA["asenha"])) {
									$senha = cleanstring($_DATA["asenha"]);
									$user = checksession($session_id);
									
									$u = $con->prepare("SELECT * FROM usuarios WHERE id = ?");
									$u->bind_param("i", $user);
									$u->execute();
									$u = mysqli_fetch_assoc($u->get_result());
									if ($u["senha"] === cryptthis($senha) || PassCheck($senha, $u["senha"])) {
										if (!PassCheck($senha, $u["senha"])) {
											$_a = $con->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
											$nn = PassCheck($senha);
											$_a->bind_param("si", $nn, $user);
											$_a->execute();
										} //Atualiza para nova criptografia
										
										if (isset($_DATA["nsenha"], $_DATA["csenha"]) && !empty($_DATA["nsenha"]) && !empty($_DATA["csenha"])) {
											$nsenha = cleanstring($_DATA["nsenha"]);
											$csenha = cleanstring($_DATA["csenha"]);
											
											if (Check_Pass($nsenha, $csenha)) {
												$a = $con->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
												$nsenha = PassCheck($nsenha);
												$a->bind_param("si", $nsenha, $user);
												$a->execute();
												if ($con->affected_rows) {
													$return["success"] = true;
													$return["msg"] .= "Sua senha foi atualizada.";
												} else {
													$return["success"] = false;
													$return["msg"] = "Erro no banco de dados.";
												}
											} else {
												$return["success"] = false;
												$return["msg"] = Check_Pass($nsenha, $csenha, 1)["msg"];
											}
										} else if ((isset($_DATA["nsenha"]) && !empty($_DATA["nsenha"])) || (isset($_DATA["csenha"]) && !empty($_DATA["csenha"]))) {
											$return["success"] = false;
											$return["msg"] = "Preencha os campo das senhas.";
										}
										
										if (isset($_DATA["email"]) && !empty($_DATA["email"])) {
											$email = cleanstring($_DATA["email"]);
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
														$b->bind_param("si", $email, $user);
														$b->execute();
														if ($con->affected_rows) {
															$_SESSION["UserEmail"] = $email;
															$return["success"] = true;
															$return["msg"] = "Email atualizado.";
														} else {
															$return["success"] = false;
															$return["msg"] = "Erro no banco de dados.";
														}
													} else {
														$return["success"] = false;
														$return["msg"] = "Email já em uso.";
													}
												} else {
													$c = $con->prepare("UPDATE usuarios SET email = ? WHERE id = ?");
													$c->bind_param("si", $email, $user);
													$c->execute();
													if ($con->affected_rows) {
														$_SESSION["UserEmail"] = $email;
														$return["success"] = true;
														$return["msg"] = "Email Atualizado.";
													} else {
														$return["success"] = false;
														$return["msg"] = "Erro no banco de dados.";
													}
												}
											} else {
												$return["success"] = false;
												$return["msg"] = "Este email não é válido";
											}
										}
										if (isset($_DATA["username"]) && !empty($_DATA["username"])) {
											$username = cleanstring($_DATA["username"]);
											if (Check_Login($username)) {
												$a = $con->prepare("SELECT * FROM usuarios WHERE login = ? ;");
												$a->bind_param("s", $username);
												$a->execute();
												$a = $a->get_result();
												if (!$a->num_rows) {
													$b = $con->prepare("UPDATE usuarios SET login = ? WHERE id = ? ;");
													$b->bind_param("si", $username, $user);
													$b->execute();
													if ($con->affected_rows) {
														$_SESSION["UserLogin"] = $username;
														$return["success"] = true;
														$return["msg"] .= "Alterado Username;";
													} else {
														$return["success"] = false;
														$return["msg"] .= "Falha ao alterar username, erro na database;";
													}
												} else {
													$return["success"] = false;
													$return["msg"] .= "Este username ja está em uso;";
												}
											} else {
												$return["success"] = false;
												$return["msg"] .= "Este username não é válido;";
											}
										}
										if (isset($_DATA["nome"]) && !empty($_DATA["nome"])) {
											$nome = cleanstring($_DATA["nome"]);
											if (Check_Name($nome)) {
												$b = $con->prepare("UPDATE usuarios SET nome = ? WHERE id = ? ;");
												$b->bind_param("si", $nome, $user);
												$b->execute();
												if ($con->affected_rows) {
													$_SESSION["UserName"] = $nome;
													$return["success"] = true;
													$return["msg"] .= "Alterado Nome;";
												} else {
													$return["success"] = false;
													$return["msg"] .= "Falha ao alterar nome, erro na database;";
												}
											} else {
												$return["success"] = false;
												$return["msg"] .= "Este Nome não é válido;";
											}
										}
										
										
									} else {
										$return["success"] = false;
										$return["msg"] = "Sua senha atual está incorreta.";
									}
								} else {
									$return["success"] = false;
									$return["msg"] = "Preencha sua senha.";
								}
							} else {
								$return["success"] = false;
								$return["msg"] = "Sua sessão encerrou.";
							}
							break;
						case "logout":
							$user = checksession($session_id);
							$a = $con->prepare("DELETE FROM user_tokens WHERE user_id = ? ;");
							$a->bind_param("i", $user);
							$a->execute();
							break;
					}
					break;
				case "recovery":
					switch ($action) {
						default:
							goto notFound;
						case "set":
							if (!empty($_DATA["email"])) {
								$email = cleanstring($_DATA["email"]);
								if (Check_Email($email)) {
									$s = $con->query("SELECT * FROM `usuarios` WHERE `email` = '" . $email . "'");
									if ($s->num_rows > 0) {
										$ds = mysqli_fetch_array($s);
										
										$hash = md5(md5($email) . md5($ds["nome"]) . strtotime(date('m/d/Y h:i:s')));
										
										$k = $con->prepare("INSERT INTO `recuperar_senha` (`id_usuario`,`hash`,`email`,`return`) VALUES ( ? , ? , ? ,NOW())");
										
										if ($k->execute([$ds["id"], $hash, $email])) {
											$link = "https://fichasop.com/conta/recuperar?recovery=" . $hash;
											
											$emailmsg = emailContent("recuperar", $link);
											if (Send_Email('Recuperar Conta', $email, $emailmsg)) {
												$return["success"] = true;
												$return["msg"] = 'Email enviado! Verifique sua caixa de email.';
											} else {
												$return["success"] = false;
												$return["msg"] = "Falha ao enviar! contate um administrador.";
											}
										} else {
											$return["success"] = false;
											$return["msg"] = "Falha interna no servidor.";
										}
									} else {
										$return["success"] = false;
										$return["msg"] = 'Email não cadastrado.';
									}
									
								} else {
									$return["msg"] = "Email não é válido.";
									$return["success"] = false;
								}
							} else {
								$return["success"] = false;
								$return["msg"] = "Preencha seu email.";
							}
							break;
					}
					break;
				case "marca":
					break;
			}
			break;
		case "fichas":
			switch ($subcategory) {
				default:
					goto notFound;
				case "all":
					switch ($action) {
						default:
							goto notFound;
						case "get": // ok
							if (checksession($session_id)) {
								$user = checksession($session_id);
								$a = $con->prepare("SELECT fichas_personagem.nome, fichas_personagem.token,public, foto, trilha, classe, origem, nex, local, idade, missoes.nome as missao FROM fichas_personagem left join (ligacoes left join missoes on ligacoes.id_missao = missoes.id) on ligacoes.id_ficha = fichas_personagem.id  where fichas_personagem.usuario = ?;");
								$a->bind_param("i", $user);
								$a->execute();
								$a = $a->get_result();
								$output = [];
								foreach ($a as $i => $rf):
									$output[] = $rf;
								endforeach;
								$return["fichas"] = $output;
								$return["success"] = true;
								$return["total"] = $a->num_rows;
								if (!$a->num_rows) {
									$return["success"] = false;
									$return["msg"] = "Nenhuma ficha encontrada.";
								}
							} else {
								$return["success"] = false;
								$return["msg"] = "Sua sessão encerrou.";
							}
							break;
					}
					break;
				
				case "info":
					switch ($action) {
						default:
							goto notFound;
						case "update":
							$token = cleanstring($_DATA["token"]);
							if (checksession($session_id)) {
								$user = checksession($session_id);
								
								if (VerificarPermissaoFicha($token, $user)) {
									
									$a = $con->prepare("SELECT * FROM `fichas_personagem` WHERE `token`= ?");
									$a->bind_param("s", $token);
									$a->execute();
									$a = $a->get_result();
									if ($a->num_rows) {# Encontrou a ficha
										if (isset($_DATA["dados"]) && !empty($_DATA["dados"] && is_array($_DATA["dados"]))) {
											
											$return["success"] = false;
											// rituais|poderes|proficiencias|habilidade|armas|dados
											if (isset($_DATA["dados"]["dices"]) && is_array($_DATA["dados"]["dices"])) {
												foreach ($_DATA["dados"]["dices"] as $dice) {
													$stmt = autoPrepare($dice, ["token", "token_pai", "owner"], "dados_customizados", $con);
													$stmt["values"][] = $dice["token"];
													$stmt["values"][] = $token;
													$r = $con->prepare("UPDATE dados_customizados SET {$stmt["query"]} WHERE token = ? AND token_pai = ?");
													$r->execute($stmt["values"]);
													
												}
												$return["success"] = true;
											}
											if (isset($_DATA["dados"]["armas"]) && is_array($_DATA["dados"]["armas"])) {
												foreach ($_DATA["dados"]["armas"] as $arma) {
													$inv = autoPrepare($arma, ["id", "id_ficha"], "inventario", $con);
													$inv["values"][] = $arma["id"];
													$inv["values"][] = $token;
													$a = $con->prepare("UPDATE inventario SET {$inv["query"]} WHERE id in (SELECT item_id FROM armas WHERE id = ?) and id_ficha in (select id from fichas_personagem where token = ?);");
													$a->execute($inv["values"]);
													
													$stmt = autoPrepare($arma, ["id", "id_ficha"], "armas", $con);
													$stmt["values"][] = $arma["id"];
													$stmt["values"][] = $token;
													$stmt["query"] = str_replace("foto","i.foto",$stmt["query"]);
													$r = $con->prepare("UPDATE armas JOIN inventario i ON armas.item_id = i.id SET {$stmt["query"]} WHERE armas.id = ? AND i.id_ficha in (select id from fichas_personagem where token = ?);");
													$r->execute($stmt["values"]);
													
													
												}
												$return["success"] = true;
											}
											
											if (isset($_DATA["dados"]["habilidades"]) && is_array($_DATA["dados"]["habilidades"])) {
												foreach ($_DATA["dados"]["habilidades"] as $hab) {
													$stmt = autoPrepare($hab, ["id", "id_ficha"], "habilidades", $con);
													$stmt["values"][] = $hab["id"];
													$stmt["values"][] = $token;
													$r = $con->prepare("UPDATE habilidades SET {$stmt["query"]} WHERE id = ? AND id_ficha in (SELECT id from fichas_personagem where token = ?) ");
													$r->execute($stmt["values"]);
												}
												$return["success"] = true;
											}
											if (isset($_DATA["dados"]["itens"]) && is_array($_DATA["dados"]["itens"])) {
												foreach ($_DATA["dados"]["itens"] as $item) {
													$stmt = autoPrepare($item, ["id", "id_ficha"], "inventario", $con);
													$stmt["values"][] = $item["id"];
													$stmt["values"][] = $token;
													$r = $con->prepare("UPDATE inventario SET {$stmt["query"]} WHERE id = ? AND id_ficha in (SELECT id from fichas_personagem where token = ?) ");
													$r->execute($stmt["values"]);
												}
												$return["success"] = true;
											}
											if (isset($_DATA["dados"]["poderes"]) && is_array($_DATA["dados"]["poderes"])) {
												foreach ($_DATA["dados"]["poderes"] as $poder) {
													$stmt = autoPrepare($poder, ["id", "id_ficha"], "poderes", $con);
													$stmt["values"][] = $poder["id"];
													$stmt["values"][] = $token;
													$r = $con->prepare("UPDATE poderes SET {$stmt["query"]} WHERE id = ? AND id_ficha in (SELECT id from fichas_personagem where token = ?) ");
													$r->execute($stmt["values"]);
												}
												$return["success"] = true;
											}
											
											if (isset($_DATA["dados"]["rituais"]) && is_array($_DATA["dados"]["rituais"])) {
												foreach ($_DATA["dados"]["rituais"] as $ritual) {
													$stmt = autoPrepare($ritual, ["id", "id_ficha"], "rituais", $con);
													$stmt["values"][] = $ritual["id"];
													$stmt["values"][] = $token;
													$r = $con->prepare("UPDATE rituais SET {$stmt["query"]} WHERE id = ? AND id_ficha in (SELECT id from fichas_personagem where token = ?) ");
													$r->execute($stmt["values"]);
												}
												$return["success"] = true;
											}
											
											if (isset($_DATA["dados"]["proficiencias"]) && is_array($_DATA["dados"]["proficiencias"])) {
												foreach ($_DATA["dados"]["proficiencias"] as $proficiencia) {
													$stp = autoPrepare($proficiencia, ["id", "id_ficha"], "proeficiencias", $con);
													$stp["values"][] = $proficiencia["id"];
													$stp["values"][] = $token;
													$r = $con->prepare("UPDATE proeficiencias SET {$stp["query"]} WHERE id = ? AND id_ficha in (SELECT id from fichas_personagem where token = ?) ");
													$r->execute($stp["values"]);
													
												}
												$return["success"] = true;
											}
											
											$stmt = autoPrepare($_DATA["dados"], ["id", "token", "usuario"], "fichas_personagem", con());
											$stmt["values"][] = $token;
											if (!empty($stmt["query"])) {
												$a = $con->prepare("UPDATE fichas_personagem SET {$stmt["query"]} WHERE token = ?");
												$a->execute($stmt["values"]);
												$return["success"] = true;
											}
										} else {
											$return["msg"] = "Nenhum dado a ser alterado..";
											$return["success"] = false;
										}
									} else {
										$return["success"] = false;
										$return["msg"] = 'Falha ao encontrar ficha.';
									}
								} else {
									$return = false;
									$return["msg"] = 'Sem permissão.';
								}
							} else {
								$return["success"] = false;
								$return["msg"] = 'Sua sessão encerrou.';
							}
							break;
						
						case "get":
							$token = cleanstring($_DATA["token"]);
							if (empty($_DATA["sessid"])||checksession($session_id)) {
								$user = checksession($session_id);
								if (VerificarPermissaoFicha($token, $user)) {
									$editable = true;
								} else {
									$editable = false;
								}
								$a = $con->prepare("SELECT fichas_personagem.*, u.nome as usuario FROM `fichas_personagem` inner join usuarios u on fichas_personagem.usuario = u.id WHERE fichas_personagem.`token`= ?;");
								$a->execute([$token]);
								$a = $a->get_result();
								if ($a->num_rows) {
									$ficha = mysqli_fetch_assoc($a);
									if ((int)$ficha["public"] === 1 || $editable) {
										$ficha["blockperm"] = !$editable;
										$b = $con->prepare("SELECT * FROM `poderes` WHERE `id_ficha` = ? ;");
										$b->execute([$ficha["id"]]);
										$b = $b->get_result();
										
										$c = $con->prepare("SELECT * FROM `habilidades` WHERE `id_ficha` = ? ;");
										$c->execute([$ficha["id"]]);
										$c = $c->get_result();
										
										$d = $con->prepare("SELECT * FROM `rituais` WHERE `id_ficha` = ? ;");
										$d->execute([$ficha["id"]]);
										$d = $d->get_result();
										
										$e = $con->prepare("SELECT i.* FROM inventario i LEFT JOIN armas a ON a.item_id = i.id WHERE a.item_id is null AND i.id_ficha = ? ;");
										$e->execute([$ficha["id"]]);
										$e = $e->get_result();
										
										$f = $con->prepare("Select *,armas.id as id,i.foto as foto From armas left join inventario i on i.id = armas.item_id where i.id_ficha = ? ;");
										$f->execute([$ficha["id"]]);
										$f = $f->get_result();
										
										$g = $con->prepare("SELECT * FROM `dados_customizados` WHERE `token_pai` = ? ");
										$g->execute([$ficha["token"]]);
										$g = $g->get_result();
										
										$h = $con->prepare("SELECT * FROM `proeficiencias` WHERE `id_ficha` = ?;");
										$h->execute([$ficha["id"]]);
										$h = $h->get_result();
										
										$ficha["habilidades"] = $ficha["poderes"] = $ficha["rituais"] = $ficha["itens"] = $ficha["armas"] = $ficha["dices"] = [];
										foreach ($c as $rf) {
											$ficha["habilidades"][] = $rf;
										}
										foreach ($b as $rf) {
											$ficha["poderes"][] = $rf;
										}
										foreach ($d as $rf) {
											$ficha["rituais"][] = $rf;
										}
										foreach ($e as $rf) {
											$ficha["itens"][] = $rf;
										}
										foreach ($f as $rf) {
											$ficha["armas"][] = $rf;
										}
										foreach ($g as $d) {
											$ficha["dices"][] = $d;
										}
										foreach ($h as $d) {
											$ficha["proficiencias"][] = $d;
										}
										$return["success"] = true;
										$return["ficha"] = $ficha;
										
									} else {
										$return["success"] = false;
										$return["msg"] = "Sem permissão.";
									}
								} else {
									$return["success"] = false;
									$return["msg"] = "Ficha não encontrada.";
								}
								
							} else {
								$return["success"] = false;
								$return["msg"] = "Sua sessão encerrou.";
							}
							break;
						case "delete":
							$token = cleanstring($_DATA["token"]);
							if (checksession($session_id)) {
								$user = checksession($session_id);
								if (VerificarPermissaoFicha($token, $user)) {
									
									$a = $con->prepare("SELECT * FROM `fichas_personagem` WHERE `token`= ? AND `usuario` = ?;");
									$a->bind_param("si", $token, $user);
									$a->execute();
									$a = $a->get_result();
									if ($a->num_rows) {# Encontrou a ficha
										if (isset($_DATA["dados"]) && !empty($_DATA["dados"] && is_array($_DATA["dados"]))) {
											$return["success"] = false;
											
											if (isset($_DATA["dados"]["dices"]) && is_array($_DATA["dados"]["dices"])) {
												foreach ($_DATA["dados"]["dices"] as $dice) {
													$r = $con->prepare("DELETE FROM dados_customizados WHERE token = ? AND token_pai = ?");
													$r->execute([$dice["token"], $token]);
												}
												$return["success"] = true;
											}
											if (isset($_DATA["dados"]["habilidades"]) && is_array($_DATA["dados"]["habilidades"])) {
												foreach ($_DATA["dados"]["habilidades"] as $hab) {
													$r = $con->prepare("DELETE FROM habilidades WHERE id = ? AND id_ficha in (SELECT id FROM fichas_personagem WHERE token =?)");
													$r->execute([$hab["id"], $token]);
												}
												$return["success"] = true;
											}
											if (isset($_DATA["dados"]["poderes"]) && is_array($_DATA["dados"]["poderes"])) {
												foreach ($_DATA["dados"]["poderes"] as $poder) {
													$r = $con->prepare("DELETE FROM poderes WHERE id = ? AND id_ficha in (SELECT id from fichas_personagem where token = ?) ");
													$r->execute([$poder["id"], $token]);
												}
												$return["success"] = true;
											}
											if (isset($_DATA["dados"]["itens"]) && is_array($_DATA["dados"]["itens"])) {
												foreach ($_DATA["dados"]["itens"] as $item) {
													$r = $con->prepare("DELETE FROM inventario WHERE id = ? AND id_ficha in (SELECT id from fichas_personagem where token = ?) ");
													$r->execute([$item["id"], $token]);
												}
												$return["success"] = true;
											}
											
											if (isset($_DATA["dados"]["armas"]) && is_array($_DATA["dados"]["armas"])) {
												foreach ($_DATA["dados"]["armas"] as $arma) {
													$q = $con->prepare("DELETE from inventario WHERE id in (SELECT item_id FROM armas WHERE id = ?) AND id_ficha  in (SELECT id from fichas_personagem where token = ?);");
													$q->execute([$arma["id"], $token]);
													$return["success"] = true;
												}
											}
											if (isset($_DATA["dados"]["rituais"]) && is_array($_DATA["dados"]["rituais"])) {
												foreach ($_DATA["dados"]["rituais"] as $ritual) {
													$r = $con->prepare("DELETE FROM rituais WHERE id = ? AND id_ficha in (SELECT id from fichas_personagem where token = ?) ");
													$r->execute([$ritual["id"], $token]);
												}
												$return["success"] = true;
											}
											
											if (isset($_DATA["dados"]["proficiencias"]) && is_array($_DATA["dados"]["proficiencias"])) {
												foreach ($_DATA["dados"]["proficiencias"] as $proficiencia) {
													
													$r = $con->prepare("DELETE FROM proeficiencias WHERE id = ? AND id_ficha in (SELECT id FROM fichas_personagem WHERE token = ?)");
													$r->execute([$proficiencia["id"], $token]);
													
												}
												$return["success"] = true;
											}
										} else {
											$return["msg"] = "Nenhum dado a ser alterado..";
											$return["success"] = false;
										}
									} else {
										$return["success"] = false;
										$return["msg"] = 'Falha ao encontrar ficha.';
									}
								} else {
									$return["success"] = false;
									$return["msg"] = 'Sem permissão.';
								}
							} else {
								$return["success"] = false;
								$return["msg"] = 'Sua sessão encerrou.';
							}
							break;
					}
					break;
			}
			break;
		case "etc":
			switch ($subcategory) {
				case "foto":
					switch ($action) {
						case "upload":
							if (isset($_FILES["file"])) {
								$file_size = $_FILES['file']['size'];
								if (($file_size !== 0 && $file_size < 1024 * 1024)) {
									$url = save_image($_FILES["file"], $type);
									if ($url) {
										$return["url"] = $url;
										$return["success"] = true;
										$return["msg"] = "Sucesso!";
									} else {
										$return["url"] = "";
										$return["success"] = false;
										$return["msg"] = "Falha!";
									}
								} else {
									$return["url"] = "";
									$return["success"] = false;
									$return["msg"] = "Arquivo grande (>1MB)";
								}
							} else {
								$return["url"] = "";
								$return["success"] = false;
								$return["msg"] = "Arquivo não encontrado.";
							}
							break;
					}
					break;
				case "roll":
					switch ($action) {
						case "submit":
							break;
						case "get":
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
									$ret["ficha"] = $ficha["token"];
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
					}
					$dano = minmax((int)$_DATA["dano"], 0, 1);
					$margem = (int)$_DATA["margem"];
					$dado = cleanstring($_DATA["dado"], 50);
					$atributos = false;
					break;
			}
			break;
	}
} else {
	notFound:
	$return["success"] = false;
	$return["msg"] = "Nenhuma query encontrada.";
}
$return["data"] = $_DATA;

echo json_encode($return, JSON_PRETTY_PRINT);
//http_response_code($data["success"]?200:404);