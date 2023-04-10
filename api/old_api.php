<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Accept');
header('Access-Control-Allow-Origin: *');
error_reporting(E_ERROR | E_PARSE);
ini_set('display_startup_errors', true);
ini_set('display_errors', true);
const RootDir = "/home/u436203203/domains/fichasop.com/public_html/";
$app = true;
require_once "/home/u436203203/domains/fichasop.com/public_html/config/includes.php";
$con = con();
$success = true;
$msg = '';
$error = 00;

$_DATA = $_POST ?: [];
if (!empty(file_get_contents('php://input'))) {
	$body = json_decode(file_get_contents('php://input'), true);
	if (!empty($body)) {
		$_DATA += $body;
	}
}
$_QUERY = $_DATA["query"];









//NEW API //

/*

$data = array("success" => false, "msg" => "");

switch (cleanstring($_POST["query"])) {
	default:
		switch (count($conj)) {
			default:
				$data = array("success" => false, "msg" => "Query não encontrado!");
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
					case "account":
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
											logar($dados["login"]);
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
											logar($dados["login"]);
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
									if (Check_Name($nome)){
										if (!empty($_POST["login"])) {
											$login = $_POST["login"];
											if (Check_Login($login)){
												if (strlen($login) < 16){
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
													
												} else {
													$data["success"] = false;
													$data["msg"] = "Seu username precisa ter no mínimo 3 caracteres. (Apenas letras, números, hífens e underlines)";
												}
											} else {
												$data["success"] = false;
												$data["msg"] = "Seu username precisa ter no mínimo 3 caracteres. (Apenas letras, números, hífens e underlines)";
											}
										} else {
											$data["success"] = false;
											$data["msg"] = "Insira um username";
										}
									} else {
										$data["msg"] = "Apenas Letras e Espaços são permitidos no nome!";
										$data["success"] = false;
									}
								} else {
									$data["success"] = false;
									$data["msg"] = "Insira um nome.";
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
													if (logar($login)) $data["msg"] .= ' (Logado Automaticamente)';
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
											if ($q->affected_rows == 1) {
												$data["success"] = true;
												$data["msg"] = "Sucesso ao criar conta!";
												if (logar($login)) $data["msg"] .= ' (Logado Automaticamente)';
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
												if (Send_Email('Recuperar Conta',$email,$emailmsg)) {
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
										
									}else {
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
					case "mestre":
						break;
				}
				break;
			case 3:
				switch ($conj[0]) {
					default:
						$data = array(
							"success" => false,
							"msg" => "Query não encontrado!"
						);
						break;
					case "conta":
						switch ($conj[1]) {
							default:
								$data = array(
									"success" => false,
									"msg" => "Query não encontrado!"
								);
								break;
							case "update":
								switch ($conj[2]) {
									case "marca":
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
													$data["msg"] = "Marca alterada com Sucesso";
												}
											} else {
												$data["success"] = false;
												$data["msg"] = "Sua marca é igual a anterior, nada alterado.";
											}
										} else {
											$data["success"] = false;
											$data["msg"] = "O link não é válido...";
										}
										break;
								}
								break;
						}
						break;
					case "mestre":
						switch ($conj[1]) {
							default:
								$data = array(
									"success" => false,
									"msg" => "Query não encontrado!"
								);
								break;
							case "add":
								switch ($conj[2]) {
									default:
										$data = array(
											"success" => false,
											"msg" => "Query não encontrado!"
										);
										break;
									case 'nota':
										$y = $con->prepare("INSERT INTO `notes`(`id`,`nome`,`notas`,`missao`) VALUES ('','Título','È Recomendado usar notas externas!',(SELECT id from missoes WHERE token = ? AND mestre = ?));");
										$y->bind_param("si", $token, $_SESSION["UserID"]);
										$y->execute();
										break;
										break;
									case 'iniciativa':
										$f = $con->prepare("INSERT INTO `iniciativas` (`id_missao`) VALUES ((SELECT id FROM missoes where token = ? AND mestre = ?));");
										$f->bind_param("si", $token, $_SESSION["UserID"]);
										$f->execute();
										break;
									case 'fichasnpc':
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
										$t->bind_param('sisiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiisss', $token, $_SESSION["UserID"], $nome, $categoria, $pv, $pv, $san, $san, $pe, $pe, $for, $agi, $int, $pre, $vig, $passiva, $esquiva, $morte, $sangue, $energia, $conhecimento, $balistica, $fisica, $mental, $acro, $ades, $arte, $atle, $atua, $cien, $crim, $dipl, $enga, $fort, $furt, $inic, $inti, $intu, $inve, $luta, $medi, $ocul, $perc, $pilo, $pont, $prof, $refl, $reli, $sobr, $tati, $tecn, $vont, $ataq, $habs, $deta);
										$t->execute();
										break;
									case 'player':
										$type = 1;
										$data["success"] = true;
										if (!empty($_POST["user"])) {
											$email = cleanstring($_POST["user"]);
										} else {
											$data["success"] = false;
											$data["msg"] = "Preencha o campo!";
										}
										
										if ($data["success"]) {
											$z = $con->prepare("SELECT * FROM `usuarios` WHERE `email`= ? OR login = ?;"); // verifica se a conta existe
											$z->bind_param("ss", $email, $email);
											$z->execute();
											$z = $z->get_result();
											if ($z->num_rows) { //Conta EXISTE!
												$user = mysqli_fetch_assoc($z);
												
												$x = $con->prepare("SELECT * FROM ligacoes WHERE id_usuario in (SELECT id from usuarios where email = ? OR login=?) AND id_missao in (SELECT id from missoes WHERE token = ? AND mestre =?) and id_ficha is null");
												$x->bind_param("sssi", $email, $email, $token, $_SESSION["UserID"]);
												$x->execute();
												$x = $x->get_result();
												if (!$x->num_rows) { // Não existe convite PENDENTE.
													$y = $con->prepare("INSERT INTO `ligacoes`(token,id_missao,id_usuario) VALUES (UUID(),(SELECT id FROM missoes WHERE token = ? AND mestre = ?),?);");
													$y->bind_param("sii", $token, $_SESSION["UserID"], $user["id"]);
													$y->execute();
												}
												if ($user["status"]) {
													$data["msg"] = "Jogador convidado! (Conta Existente)";
												} else {
													$data["msg"] = "Jogador convidado! (Conta Inexistente)";
												}
												
											} else { // CONTA Não EXISTE
												$type = 2;
												
												if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
													$x = $con->prepare("INSERT INTO usuarios(status,email) VALUES (0,?)");
													$x->bind_param("s", $email);
													$x->execute();
													$xid = $con->insert_id;
													
													$y = $con->prepare("INSERT INTO ligacoes(token, id_missao, id_usuario) VALUES (uuid(),(SELECT id FROM missoes WHERE missoes.token =? and mestre = ?),?)");
													$y->bind_param("sii", $token, $_SESSION["UserID"], $xid);
													$y->execute();
													
													$data["msg"] = "Jogador convidado! (Conta Inexistente)";
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
													($data["success"] && Send_Email($subject, $email, $emailmsg)) ? $data["msg"] .= ' (Email enviado com sucesso.)' : $data["msg"] .= '(Email não enviado.)';
													
												} else {
													
													$data["msg"] = "Nenhuma conta encontrada, tente usando um Email.";
													$data["success"] = false;
												}
											}
										}
										$data["email"] = $email;
										$data["type"] = $type;
										break;
								}
								break;
							case "update":
								switch ($conj[2]) {
									default:
										$data = array(
											"success" => false,
											"msg" => "Query não encontrado!"
										);
										break;
									case 'nota':
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
											$y->bind_param("ssiss", $tit, $des, $nota, $token, $_SESSION["UserID"]);
											$y->execute();
											$b++;
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
								break;
							case "delete":
								switch ($conj[2]) {
									default:
										$data = array(
											"success" => false,
											"msg" => "Query não encontrado!"
										);
										break;
									case 'nota':
										$nid = (int)$_POST["note"];
										$tvar = $con->prepare("DELETE FROM `notes` WHERE `id` = ? AND `missao` in (SELECT id FROM missoes WHERE token =? AND mestre = ?)");
										$tvar->bind_param("isi", $nid, $token, $_SESSION["UserID"]);
										$tvar->execute();
										break;
									case 'iniciativa':
										$initid = (int)$_POST["iniciativa_id"];
										$f = $con->prepare("DELETE FROM `iniciativas` WHERE  `id`= ? AND `id_missao` in (SELECT id FROM missoes WHERE token = ? AND mestre = ?);");
										$f->bind_param("isi", $initid, $token, $_SESSION["UserID"]);
										$f->execute();
										break;
									case 'fichanpc':
										$npc = (int)$_POST["npc"];
										$f = $con->prepare("DELETE FROM `fichas_npc` WHERE `id` = ? AND missao in (SELECT id FROM missoes WHERE mestre = ? AND token = ?)");
										$f->bind_param("iis", $npc, $_SESSION["UserID"], $token);
										$f->execute();
										break;
									case 'player':
										$p = (int)$_POST["p"];
										
										$f = $con->prepare("DELETE FROM `ligacoes` WHERE `id_ficha`=? AND `id_missao`in(SELECT id from missoes WHERE missoes.token =? AND mestre = ?);");
										$f->bind_param("isi", $p, $token, $_SESSION["UserID"]);
										$f->execute();
										
										break;
								}
								break;
							case "get":
								switch ($conj[2]) {
									default:
										$data = array(
											"success" => false,
											"msg" => "Query não encontrado!"
										);
										break;
									case 'npc':
										$npc = (int)$_POST["ficha"];
										
										$ss = $con->prepare('SELECT * FROM fichas_npc WHERE id = ? AND missao in (SELECT id FROM missoes where token = ? AND mestre = ?);');
										$ss->bind_param("isi", $npc, $token, $_SESSION["UserID"]);
										$ss->execute();
										$data = mysqli_fetch_array($ss->get_result());
										break;
								}
								break;
						}
						break;
					case "ficha":
						switch ($conj[1]) {
							default:
								$data = array(
									"success" => false,
									"msg" => "Query não encontrado!"
								);
								break;
							case "update":
								if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {
									switch ($conj[2]) {
										default:
											$data = array(
												"success" => false,
												"msg" => "Query não encontrado!"
											);
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
														$a = $con->prepare("UPDATE poderes SET nome =?, descricao =? WHERE id = ? AND id_ficha  in (SELECT id FROM fichas_personagem WHERE token = ?)");
														break;
												}
												$a->bind_param("ssis", $title, $desc, $eid, $token);
												$a->execute();
											} else {
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
												$q = $con->prepare("UPDATE `fichas_personagem` SET
                               `acrobacias` = ?, `adestramento` = ?, `artes` = ?, `atletismo` = ?, `atualidades` = ?,
                               `ciencia` = ?, `crime` = ?, `diplomacia` = ?, `enganacao` = ?, `fortitude` = ?,
                               `furtividade` = ?, `intimidacao` = ?, `iniciativa` = ?, `intuicao` = ?, `investigacao` = ?,
                               `luta` =?, `medicina` =?, `ocultismo` =?, `percepcao` =?, `pilotagem` =?,
                               `pontaria` =?, `profissao`= ?,`reflexos`= ?, `religiao`= ?, `sobrevivencia`= ?,
                               `tatica`= ?, `tecnologia`= ?, `vontade`= ? WHERE `token` = ?;");
												$q->bind_param("iiiiiiiiiiiiiiiiiiiiiiiiiiiis", $acr, $ade, $art, $atl, $atu, $cie, $cri, $dip, $eng, $fort, $fur, $inti, $inic, $intu, $inv, $lut, $med, $ocu, $perc, $pilo, $pont, $prof, $ref, $rel, $sob, $tat, $tec, $von, $token);
												$q->execute();
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
												$balas = minmax((int)$_POST["balas"], 0, 30);
												
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
												$peso = minmax($_POST["peso"], $minimo_peso, $maximo_peso, $inv_float);
												$pres = minmax($_POST["prestigio"], 0, 10);
												$rr = $con->prepare("UPDATE `inventario` SET `nome` = ? , `descricao` = ?, `espaco` = ?, `prestigio` = ? WHERE `inventario`.`id` = ? AND `id_ficha` in (SELECT id FROM fichas_personagem WHERE token = ?);");
												$rr->bind_param("ssdiis", $nome, $desc, $peso, $pres, $iid, $token);
												$data["success"] = $rr->execute();
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
												$t = cleanstring($_POST["tipo"], $Arma_tipo);
												$at = cleanstring($_POST["ataque"], $Arma_ataq);
												$al = cleanstring($_POST["alcance"], $Arma_alca);
												$d = cleanstring($_POST["dano"], $Arma_dano);
												$c = cleanstring($_POST["critico"], $Arma_crit);
												$m = minmax($_POST["margem"], 1, 20);
												$r = cleanstring($_POST["recarga"], $Arma_reca);
												$e = cleanstring($_POST["especial"], $Arma_espe);
												$rr = $con->prepare("UPDATE `armas` SET `arma` = ?, `foto` = ? , `tipo` = ?, `ataque` = ?, `alcance` = ?, `dano` = ?, `critico` = ?, `margem` = ?, `recarga` = ?, `especial` = ? WHERE `armas`.`id` = ? AND `id_ficha` in (SELECT id FROM fichas_personagem WHERE token = ?);");
												$rr->bind_param("sssssssissis", $n, $f, $t, $at, $al, $d, $c, $m, $r, $e, $aid, $token);
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
								break;
							case "delete":
								switch ($conj[2]) {
									default:
										$data = array(
											"success" => false,
											"msg" => "Query não encontrado!"
										);
										break;
									case "switch":
										if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {
											$type = cleanstring($_POST["type"]);
											$iid = (int)$_POST["iid"];
											switch ($type) {
												case "habilidade":
													$q = $con->prepare("DELETE FROM `habilidades` WHERE `id` = ? AND `id_ficha` in (SELECT id FROM fichas_personagem WHERE token = ?);");
													break;
												case "poder":
													$q = $con->prepare("DELETE FROM `poderes` WHERE `id` = ? AND `id_ficha` in (SELECT id FROM fichas_personagem WHERE token = ?);");
													break;
												case "arma":
													$q = $con->prepare("DELETE FROM `armas` WHERE `id` = ? AND `id_ficha` in (SELECT id FROM fichas_personagem WHERE token = ?);");
													break;
												case "item":
													$q = $con->prepare("DELETE FROM `inventario` WHERE `id` = ? AND `id_ficha` in (SELECT id FROM fichas_personagem WHERE token = ?);");
													break;
												case "proficiencia":
													$q = $con->prepare("DELETE FROM `proeficiencias` WHERE `id` = ? AND `id_ficha` in (SELECT id FROM fichas_personagem WHERE token = ?)");
													break;
												case "ritual":
													$q = $con->prepare("DELETE FROM `rituais` WHERE `id` = ? AND `id_ficha` in (SELECT id FROM fichas_personagem WHERE token = ?);");
													break;
											}
											$q->bind_param("is", $iid, $token);
											$q->execute();
										} else {
											$data["success"] = false;
											$data["msg"] = "Sem permissão";
										}
										break;
								}
								break;
							case "add":
								switch ($conj[2]) {
									default:
										$data = array(
											"success" => false,
											"msg" => "Query não encontrado!"
										);
										break;
									case 'habilidade':
										if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {
											$habname = cleanstring($_POST["hab"], $Hab_nome);
											$habdesc = cleanstring($_POST["desc"], $Hab_desc);
											if (isset($_POST["poder"]) && ($_POST["poder"] == 1 || $_POST["poder"] == "on")) {
												$a = $con->prepare("INSERT INTO `poderes` (`id_ficha`, `nome`, `descricao`) VALUES ( (SELECT id FROM fichas_personagem WHERE token = ? ), ? , ? );");
											} else {
												$a = $con->prepare("INSERT INTO `habilidades` (`id_ficha`, `nome`, `descricao`) VALUES ( (SELECT id FROM fichas_personagem WHERE token = ? ) , ? , ? );");
											}
											$a->bind_param("sss", $token, $habname, $habdesc);
											$a->execute();
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
										$rr->bind_param("ssssssssssssss", $token,  $foto, $ritual, $cir, $conj, $efe, $ele, $dur, $alc, $res, $alv, $d1, $d2, $d3);
										$rr->execute();
										break;
									case 'item':
										$nome = cleanstring($_POST["nome"], $limite_nome_inv);
										$desc = cleanstring($_POST["descricao"], $Inv_desc);
										$peso = minmax($_POST["peso"], $minimo_peso, $maximo_peso, $inv_float);
										$quantidade = minmax($_POST["quantidade"], 0, $maximo_peso);
										$pres = minmax($_POST["prestigio"], 0, 10);
										$rr = $con->prepare("INSERT INTO `inventario`(`id_ficha`,`nome`,`descricao`,`espaco`,`prestigio`,`quantidade`) VALUES ( (SELECT id FROM fichas_personagem WHERE token = ?) , ? , ? , ? , ?, ?)");
										$rr->bind_param("sssiii", $token,$nome, $desc, $peso, $pres, $quantidade);
										$rr->execute();
										break;
									case 'arma':
										$n = cleanstring($_POST["nome"], $limite_nome_inv);
										$t = cleanstring($_POST["tipo"], $Arma_tipo);
										$at = cleanstring($_POST["ataque"], $Arma_crit);
										$al = cleanstring($_POST["alcance"], $Arma_alca);
										$d = cleanstring($_POST["dano"], $Arma_dano);
										$c = cleanstring($_POST["critico"], $Arma_crit);
										$m = minmax($_POST["margem"], 1, 20);
										$r = cleanstring($_POST["recarga"], $Arma_reca);
										$e = cleanstring($_POST["especial"], $Arma_espe);
										$desc = cleanstring($_POST["desc"], $Inv_desc);
										$foto = cleanstring($_POST["foto"], $Inv_desc);
										$peso = minmax($_POST["peso"], $minimo_peso, $maximo_peso, $inv_float);
										$pres = minmax($_POST["prestigio"], 0, 10);//Categorias
										$rr = $con->prepare("INSERT INTO `armas`(`id_ficha`,`foto`,`arma`,`tipo`,`ataque`,`alcance`,`dano`,`critico`, `margem`,`recarga`,`especial`) VALUES ((SELECT id FROM fichas_personagem WHERE token = ?), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
										$rr->bind_param("ssssssssiss", $token,$foto, $n, $t, $at, $al, $d, $c, $m, $r, $e);
										$rr->execute();
										if ($_POST["invtoo"] === 'on' || $_POST["invtoo"] === true) {
											$p = $con->prepare("INSERT INTO `inventario`(`id_ficha`,`nome`,`descricao`,`prestigio`,`espaco`,`id`) VALUES ((SELECT id FROM fichas_personagem WHERE token = ? ), ?, ?, ?, ?, '');");
											$p->bind_param("sssid", $token,$n, $desc, $pres, $peso);
											$p->execute();
										}
										if ($con->affected_rows) {
											$data["msg"] = "Sucesso ao adicionar itens";
										}
										break;
								}
								break;
						}
						break;
				}
				break;
		}
		break;
	case 'mestre_sync_fichasnpc':
		$ficha_id = (int)$_POST["ficha"];
		
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
		$_a->bind_param($st["bind"], ...$st["values"]);
		$_a->execute();
		
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
			$fg->bind_param("iiiiiiiiiiiiis",$ba,$bau, $opv, $com, $ope, $osan, $mor, $pv, $pva, $san, $sana, $pe, $pea, $token);
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
			$c = true;
		}
		$f = $con->prepare("UPDATE missoes SET combate = ? WHERE token = ? AND mestre = ?");
		$f->bind_param("isi", $c, $token, $_SESSION["UserID"]);
		$f->execute();
		$data["success"] = (bool)$f->affected_rows;
		$data["msg"] = (bool)$f->affected_rows;
		
		
		break;
}






$token = cleanstring($_GET["token"] ?: $_POST["token"]);
$conj = explode("_", cleanstring($_POST["query"]));

*/
//NEW API END //



if (isset($_QUERY)) {
	switch ($_QUERY) {
		default:
			$success = false;
			$msg = "Nenhuma query encontrada.";
			break;
		case 'set_marca':
			$sid = cleanstring($_DATA["sessid"] ?: session_id());
			preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp)$/', cleanstring($_DATA["urlmarca"]), $marca);
			if ($marca) {
				$marca = cleanstring($_DATA["urlmarca"]);
				$q = $con->prepare("SELECT * FROM `usuarios` WHERE `id` = ?;");
				$q->bind_param("s", $sid);
				$q->execute();
				$q = $q->get_result();
				if ($q->num_rows) {
					$rq = mysqli_fetch_array($q);
					if ($marca != $rq["marca"]) {
						$a = $con->prepare("UPDATE `usuarios` SET `marca` = ? WHERE `id` in (SELECT user from auth WHERE token = ?);");
						$a->bind_param("si", $marca, $sid);
						$a->execute();
						$data["success"] = (bool)$con->affected_rows;
						if ($data["success"]) {
							$_SESSION["UserMarca"] = cleanstring($_DATA["urlmarca"]);
							$msg = "Marca alterada com Sucesso";
						}
					}
				} else {
					$success = true;
					$msg = "Sua marca é igual a anterior, nada alterado.";
				}
				$data["msg"] = $msg;
			} else {
				$data["success"] = false;
				$data["msg"] = "O link não é válido...";
			}
			
			
			break; // não usado.
		case 'get_ficha':
			$sid = cleanstring($_DATA["sessid"] ?: session_id());
			$token = cleanstring($_DATA["token"]);
			if (check_session($sid)) {
				$user = check_session($sid);
				$a = $con->prepare("SELECT * FROM `fichas_personagem` WHERE `token`= ? AND `usuario` in (SELECT id FROM usuarios WHERE `login` = ?);");
				$a->bind_param("ss", $token, $user);
				$a->execute();
				$a = $a->get_result();
				
				$b = $con->prepare("SELECT * FROM `poderes` WHERE `id_ficha` in (SELECT id FROM fichas_personagem WHERE `token` = ? AND `usuario`  in (SELECT id FROM usuarios WHERE `login` = ?));");
				$b->bind_param("ss", $token, $user);
				$b->execute();
				$b = $b->get_result();
				
				$c = $con->prepare("SELECT * FROM `habilidades` WHERE `id_ficha` in (SELECT id FROM fichas_personagem WHERE `token` = ? AND `usuario`  in (SELECT id FROM usuarios WHERE `login` = ?));");
				$c->bind_param("ss", $token, $user);
				$c->execute();
				$c = $c->get_result();
				
				$d = $con->prepare("SELECT * FROM `rituais` WHERE `id_ficha` in (SELECT id FROM fichas_personagem WHERE `token` = ? AND `usuario`  in (SELECT id FROM usuarios WHERE `login` = ?));");
				$d->bind_param("ss", $token, $user);
				$d->execute();
				$d = $d->get_result();
				
				$e = $con->prepare("SELECT * FROM `inventario` WHERE `id_ficha` in (SELECT id FROM fichas_personagem WHERE `token` = ? AND `usuario`  in (SELECT id FROM usuarios WHERE `login` = ?));");
				$e->bind_param("ss", $token, $user);
				$e->execute();
				$e = $e->get_result();
				
				$f = $con->prepare("SELECT * FROM `armas` WHERE `id_ficha` in (SELECT id FROM fichas_personagem WHERE `token` = ? AND `usuario`  in (SELECT id FROM usuarios WHERE `login` = ?));");
				$f->bind_param("ss", $token, $user);
				$f->execute();
				$f = $f->get_result();
				
				$g = $con->prepare("SELECT * FROM `dados_ficha` WHERE `id_ficha`  in (SELECT id FROM fichas_personagem WHERE `token` = ? AND `usuario` in (SELECT id FROM usuarios WHERE `login` = ?));;");
				$g->bind_param("ss", $token, $user);
				$g->execute();
				$g = $g->get_result();
				
				$u = $con->prepare("SELECT * FROM `usuarios` WHERE `id` = ?;");
				$u->bind_param("s", $user);
				$u->execute();
				$u = mysqli_fetch_array($u->get_result());
				
				
				if ($a->num_rows) {
					$ficha = mysqli_fetch_assoc($a);
					if ($c->num_rows) {
						foreach ($c as $rf) {
							$ficha["habilidades"][] = $rf;
						}
						$ficha["hsuccess"] = true;
					} else {
						$ficha["hsuccess"] = false;
						$ficha["hmsg"] = "Nenhuma habilidade encontrada.";
					}
					if ($b->num_rows) {
						foreach ($b as $rf) {
							$ficha["poderes"][] = $rf;
						}
						$ficha["psuccess"] = true;
					} else {
						$ficha["psuccess"] = false;
						$ficha["pmsg"] = "Nenhum poder encontrado.";
					}
					if ($d->num_rows) {
						foreach ($d as $rf) {
							$ficha["rituais"][] = $rf;
						}
						$ficha["rsuccess"] = true;
					} else {
						$ficha["rsuccess"] = false;
						$ficha["rmsg"] = "Nenhum ritual encontrado.";
					}
					if ($e->num_rows) {
						foreach ($e as $rf) {
							$ficha["inventario"][] = $rf;
						}
						$ficha["isuccess"] = true;
					} else {
						$ficha["isuccess"] = false;
						$ficha["imsg"] = "Nenhum item encontrado.";
					}
					if ($f->num_rows) {
						foreach ($f as $rf) {
							$ficha["armas"][] = $rf;
						}
						$ficha["asuccess"] = true;
					} else {
						$ficha["asuccess"] = false;
						$ficha["amsg"] = "Nenhuma arma encontrada.";
					}
					if ($g->num_rows) {
						foreach ($g as $d) {
							$ficha["dados"][] = $d;
						}
					}
					$ficha["usuario"] = $u["nome"];
					$data["ficha"] = $ficha;
				} else {
					$success = false;
					$msg = "Ficha não encontrada...";
				}
			} else {
				$success = false;
				$msg = "Sua sessão encerrou.";
			}
			break; // APP / OBSOLETO
		case "account_create":
		case 'create_account':
			if (!empty($_DATA["nome"])) {
				$nome = cleanstring($_DATA["nome"]);
				if (!Check_Name($nome)) {
					$msg = "Apenas Letras e Espaços são permitidos no nome!";
					$success = false;
				}
			} else {
				$success = false;
				$msg = "Está faltando o nome!";
			}
			
			if (!empty($_DATA["login"])) {
				$login = cleanstring($_DATA["login"]);
				if (!Check_Login($login)) {
					$success = false;
					$msg = "O username será usado para entrar em sua conta. (Apenas letras, hífenes, e UnderScores)";
				}
				if (strlen($login) > 16) {
					$success = false;
					$msg = "O username não pode ter mais de 16 caracteres.";
				}
			} else {
				$success = false;
				$msg = "Está faltando o Username";
			}
			
			if (!empty($_DATA["email"])) {
				$email = cleanstring($_DATA["email"]);
				if (!Check_Email($email)) {
					$msg = "Email inserido não é valido.";
					$success = false;
				}
			} else {
				$success = false;
				$msg = "Está faltando o Email!";
			}
			if (!empty($_DATA["senha"] || $_DATA["csenha"])) {
				if ($_DATA["senha"] === $_DATA["csenha"]) {
					$pass = cleanstring($_DATA["senha"]);
					if (strlen($pass) < 8 || strlen($pass) > 50) {
						$msg = "Senha deve conter entre 8 e 50 digitos.";
						$success = false;
					}
					if (!preg_match("/[A-Z]/", $pass)) {
						$msg = "Senha precisa conter letras maiúsculas.";
						$success = false;
					}
					if (!preg_match("/[a-z]/", $pass)) {
						$msg = "Senha precisa conter letras minúsculas.";
						$success = false;
					}
					if (preg_match("/\s/", $pass)) {
						$msg = "Senha não pode conter espaços!";
						$success = false;
					}
					$senha = cryptthis($pass);
					
				} else {
					$msg = "As senhas não são iguais.";
					$success = false;
				}
			} else {
				$success = false;
				$msg = "Está faltando as senhas!";
			}
			
			if ($success) {
				$a = $con->prepare("SELECT * FROM `usuarios` WHERE `email` = ? AND `status` = 1");
				$a->bind_param("s", $email);
				$a->execute();
				$a = $a->get_result();
				$b = $con->prepare("SELECT * FROM `usuarios` WHERE `login` = ?;");
				$b->bind_param("s", $login);
				$b->execute();
				$b = $b->get_result();
				
				$ab = $con->prepare("SELECT * FROM `usuarios` WHERE `email` = ? AND `status` = 0");
				$ab->bind_param("s", $email);
				$ab->execute();
				$ab = $ab->get_result();
				
				if ($a->num_rows == 0) {
					if ($ab->num_rows == 0) {
						if ($b->num_rows == 0) {
							$q = $con->prepare("INSERT INTO `usuarios`(`nome`,`login`,`senha`,`email`) VALUES (?,?,?,?)");
							$q->bind_param("ssss", $nome, $login, $senha, $email);
							$q->execute();
							
							if ($con->affected_rows > 0) {
								$msg = "Sucesso ao criar conta!";
							} else {
								$success = false;
								$msg = "Falha ao criar conta!";
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
							$msg = "Sucesso ao criar conta!";
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
			break; //APP
		case 'get_fichas':
			$sid = cleanstring($_DATA["sessid"] ?: session_id());
			if (check_session($sid)) {
				$user = check_session($sid);
				$a = $con->prepare("SELECT * FROM `fichas_personagem` WHERE `usuario` = ?;");
				$a->bind_param("s", $user);
				$a->execute();
				$a = $a->get_result();
				$output = [];
				foreach ($a as $i => $rf):
					
					$b = $con->prepare("SELECT * FROM `poderes` WHERE `id_ficha` in (SELECT id FROM fichas_personagem WHERE `token` = ?);");
					$b->bind_param("s", $rf["token"]);
					$b->execute();
					$b = $b->get_result();
					$c = $con->prepare("SELECT * FROM `habilidades` WHERE `id_ficha` in (SELECT id FROM fichas_personagem WHERE `token` = ?);");
					$c->bind_param("s", $rf["token"]);
					$c->execute();
					$c = $c->get_result();
					$d = $con->prepare("SELECT * FROM `rituais` WHERE `id_ficha` in (SELECT id FROM fichas_personagem WHERE `token` = ?);");
					$d->bind_param("s", $rf["token"]);
					$d->execute();
					$d = $d->get_result();
					$e = $con->prepare("SELECT * FROM `inventario` WHERE `id_ficha` in (SELECT id FROM fichas_personagem WHERE `token` = ?);");
					$e->bind_param("s", $rf["token"]);
					$e->execute();
					$e = $e->get_result();
					$f = $con->prepare("SELECT * FROM `armas` WHERE `id_ficha` in (SELECT id FROM fichas_personagem WHERE `token` = ?);");
					$f->bind_param("s", $rf["token"]);
					$f->execute();
					$f = $f->get_result();
					$g = $con->prepare("SELECT * FROM `dados_ficha` WHERE `id_ficha`  in (SELECT id FROM fichas_personagem WHERE `token` = ?);;");
					$g->bind_param("s", $rf["token"]);
					$g->execute();
					$g = $g->get_result();
					
					$output[$i] = $rf;
					foreach ($c as $r) {
						$output[$i]["habilidades"][] = $r;
					}
					
					foreach ($b as $r) {
						$output[$i]["poderes"][] = $r;
					}
					
					foreach ($d as $r) {
						$output[$i]["rituais"][] = $r;
					}
					
					foreach ($e as $r) {
						$output[$i]["inventario"][] = $r;
					}
					
					foreach ($f as $r) {
						$output[$i]["armas"][] = $r;
					}
					
					foreach ($g as $d) {
						$output[$i]["dados"][] = $d;
					}
				
				
				endforeach;
				$data["fichas"] = $output;
				if (!$a->num_rows) {
					$success = false;
					$msg = "Nenhuma ficha encontrada.";
				}
			} else {
				$success = false;
				$msg = "Sua sessão encerrou.";
			}
			break; // APP
		case "create_ficha":
			$sid = cleanstring($_DATA["sessid"]);
			if (check_session($sid)) {
				$user = check_session($sid);
				if (!empty($_DATA["nome"])) {
					$nome = cleanstring($_DATA["nome"]);
					if (!preg_match('/^[a-zA-Z áéíóúãõàèìòùÁÉÍÓÚÃÕÀÈÌÒÙçÇ]*$/', $nome)) {
						$msg = "Apenas Letras e Espaços são permitidos no nome!";
						$success = false;
					}
				} else {
					$success = false;
					$msg = "Preencha o nome do seu personagem!";
				}
				$foto = 'https://fichasop.com/assets/img/Man.webp';
				$origem = cleanstring($_DATA["origem"], 50);
				$classe = cleanstring($_DATA["classe"], 50);
				$trilha = cleanstring($_DATA["trilha"], 50);
				$nex = minmax($_DATA["nex"], 0, 100);
				$patente = minmax($_DATA["patente"], 0, 5);
				$idade = minmax($_DATA["idade"], 0, 150);
				$local = cleanstring($_DATA["local"] ?: '');
				$historia = "";
				$forca = (int)$_DATA["forca"];
				$agilidade = (int)$_DATA["agilidade"];
				$intelecto = (int)$_DATA["intelecto"];
				$presenca = (int)$_DATA["presenca"];
				$vigor = (int)$_DATA["vigor"];
				
				$pv = calcularvida($nex, $classe, $vigor, $trilha, $origem);
				
				$san = calcularsan($nex, $classe, $trilha, $origem);
				
				$pe = calcularpe($nex, $classe, $presenca, $trilha, $origem);
				
				
				$sangue = minmax($_DATA["sangue"]);
				$morte = minmax($_DATA["morte"]);
				$conhecimento = minmax($_DATA["conhecimento"]);
				$energia = minmax($_DATA["energia"]);
				$sanidade = minmax($_DATA["sanidade"]);
				$fisico = minmax($_DATA["fisico"]);
				$balistico = minmax($_DATA["balistico"]);
				
				$acrobacia = minmax($_DATA["acrobacia"]);
				$adestramento = minmax($_DATA["adestramento"]);
				$artes = minmax($_DATA["artes"]);
				$atletismo = minmax($_DATA["atletismo"]);
				$atualidades = minmax($_DATA["atualidades"]);
				$ciencia = minmax($_DATA["ciencia"]);
				$crime = minmax($_DATA["crime"]);
				$diplomacia = minmax($_DATA["diplomacia"]);
				$enganacao = minmax($_DATA["enganacao"]);
				$fortitude = minmax($_DATA["fortitude"]);
				$furtividade = minmax($_DATA["furtividade"]);
				$intimidacao = minmax($_DATA["intimidacao"]);
				$intuicao = minmax($_DATA["intuicao"]);
				$investigacao = minmax($_DATA["investigacao"]);
				$iniciativa = minmax($_DATA["iniciativa"]);
				$luta = minmax($_DATA["luta"]);
				$medicina = minmax($_DATA["medicina"]);
				$ocultismo = minmax($_DATA["ocultismo"]);
				$percepcao = minmax($_DATA["percepcao"]);
				$pilotagem = minmax($_DATA["pilotagem"]);
				$pontaria = minmax($_DATA["pontaria"]);
				$profissao = minmax($_DATA["profissao"]);
				$reflexo = minmax($_DATA["reflexo"]);
				$religiao = minmax($_DATA["religiao"]);
				$sobrevivencia = minmax($_DATA["sobrevivencia"]);
				$tatica = minmax($_DATA["tatica"]);
				$tecnologia = minmax($_DATA["tecnologia"]);
				$vontade = minmax($_DATA["vontade"]);
				$passiva = minmax($_DATA["passiva"]);
				$bloqueio = minmax($_DATA["bloqueio"]);
				$esquiva = minmax($_DATA["esquiva"]);
				
				
				switch ($origem) {
					default:
						break;
					case "Acadêmico": //Academico
						$habnam = "Saber é Poder (Origem)";
						$habdes = "Quando faz um teste usando Intelecto, você pode gastar 2 PE para receber +5 nesse teste.";
						$ciencia = $investigacao = 5;
						break;
					case "Agente de Saúde": // Agente de Sáudeo
						$habnam = "Técnicas Medicinais (Origem)";
						$habdes = "Sempre que você cura um personagem, você adiciona seu Intelecto no total de PV curados.";
						$intuicao = $medicina = 5;
						break;
					case "Amnésico":// Amnésico
						$habnam = 'Vislumbres do Passado. (Origem)';
						$habdes = ' Uma vez por missão, você pode fazer um teste de Intelecto (DT 10) para reconhecer pessoas ou lugares familiares, que tenha encontrado antes de perder a memória. Se passar, recebe 1d4 PE temporários e, a critério do mestre, uma informação útil.';
						break;
					case "Artista": // Artista
						$habnam = "Magnum Opus (Origem)";
						$habdes = "Você é famoso por uma de suas obras. Uma vez por missão, pode determinar que um personagem envolvido em uma cena de Interação o reconheça. Você recebe +5 em testes de Diplomacia, Enganação, Intuição e Intimidação contra aquele personagem. A critério do mestre, pode receber esses bônus em outras situações nas quais seria reconhecido.";
						$artes = $enganacao = 5;
						break;
					case "Atleta": // Atleta
						$habnam = "110% (Origem)";
						$habdes = "Quando faz um teste de perícia usando Força ou Agilidade (exceto Luta e Pontaria) você pode gastar 2 PE para receber +5 nesse teste.";
						$atletismo = $acrobacia = 5;
						break;
					case "Chef": // Chef
						$habnam = "Ingrediente Secreto (Origem)";
						$habdes = "Em cenas de interlúdio, você pode gastar uma ação para cozinhar um prato gostoso. Cada membro do grupo (incluindo você) que gastar uma ação para se alimentar recebe o benefício de dois pratos (caso o mesmo benefício seja escolhido duas vezes, seus efeitos se acumulam).";
						$fortitude = $profissao = 5;
						break;
					case "Criminoso": // criminalidades
						$habnam = "O Crime Compensa (Origem)";
						$habdes = "No final de uma missão, escolha um item encontrado na missão. Em sua próxima missão, você pode incluir esse item em seu inventário sem que ele conte em seu limite de itens por patente.";
						$crime = $furtividade = 5;
						break;
					case "Cultista Arrependido": // Cultista Arrependido
						$habnam = "Traços do Outro Lado. (Origem)";
						$habdes = "Você possui um poder paranormal à sua escolha. Porém, começa o jogo com metade da Sanidade normal para sua classe.";
						$religiao = $ocultismo = 5;
						break;
					case "Desgarrado": // Desgarradp
						$habnam = "Calejado. (Origem)";
						$habdes = "Você recebe +1 PV para cada 5% de NEX. (Adicionado Automáticamente!)";
						$fortitude = $sobrevivencia = 5;
						break;
					case "Engenheiro": // Engenheiro
						$habnam = "Ferramentas Favoritas. (Origem)";
						$habdes = "Um item a sua escolha (exceto armas) conta como uma categoria abaixo (por exemplo, um item de categoria II conta como categoria I para você).";
						$profissao = $tecnologia = 5;
						break;
					case "Executivo": //Executivo
						$habnam = "Processo Otimizado. (Origem)";
						$habdes = "Sempre que faz um teste de perícia durante um teste estendido, pode pagar 2 PE para receber +5 nesse teste.";
						$diplomacia = $profissao = 5;
						break;
					case "Investigador": //Inbestigador
						$habnam = "Faro para Pistas. (Origem)";
						$habdes = "Uma vez por cena, quando fizer um teste para procurar pistas, você pode gastar 1 PE para receber +5 nesse teste.";
						$investigacao = $percepcao = 5;
						break;
					case "Lutador": // Lutador
						$habnam = "Mão Pesada. (Origem)";
						$habdes = "Você recebe +2 em rolagens de dano com ataques corpo a corpo.";
						$luta = $reflexo = 5;
						break;
					case "Magnata": // Magnata
						$habnam = "Patrocinador da Ordem. (Origem)";
						$habdes = "Seu limite de crédito é sempre considerado um acima do atual.";
						$diplomacia = $pilotagem = 5;
						break;
					case "Mercenário": // Mercenário
						$habnam = "Posição de Combate (Origem)";
						$habdes = " No primeiro turno de cada cena de ação, você pode gastar 2 PE para receber uma ação de movimento adicional.";
						$iniciativa = $intimidacao = 5;
						break;
					case "Militar": // mlitar
						$habnam = "Para Bellum. (Origem)";
						$habdes = "Você recebe +2 em rolagens de dano com armas de fogo.";
						$tatica = $pontaria = 5;
						break;
					case "Operário": // Operário
						$habnam = "Ferramenta de Trabalho. (Origem)";
						$habdes = "Escolha uma arma simples ou tática que, a critério do mestre, poderia ser usada como ferramenta em sua profissão (como uma marreta para um pedreiro). Você sabe usar a arma escolhida e recebe +1 em testes de ataque, rolagens de dano e margem de ameaça com ela.";
						$fortitude = $profissao = 5;
						break;
					case "Policial": // Policiaçl
						$habnam = "Patrulha (Origem)";
						$habdes = "Você recebe +2 em Defesa.";
						$percepcao = $pontaria = 5;
						break;
					case "Religioso": // Religioso
						$habnam = "Acalentar. (Origem)";
						$habdes = "Você recebe +5 em testes de Religião para acalmar. Além disso, quando acalma uma pessoa, ela recebe um número de pontos de Sanidade igual a 1d6 + a sua Presença.";
						$religiao = $vontade = 5;
						break;
					case "Servidor Público": // Servidor Público
						$habnam = "Espírito Cívico. (Origem)";
						$habdes = "Sempre que faz um teste para ajudar, você pode gastar 1 PE para aumentar o bônus concedido em +2.";
						$intuicao = $vontade = 5;
						break;
					case "Teórico": // Teórico
						$habnam = "Eu Já Sabia. (Origem)";
						$habdes = "Você não se abala com entidades ou anomalias. Afinal, sempre soube que isso tudo existia. Você recebe resistência a dano mental igual ao seu Intelecto.";
						$investigacao = $ocultismo = 5;
						break;
					case "TI": // ti
						$habnam = "Motor de Busca (Origem)";
						$habdes = "A critério do Mestre, sempre que tiver acesso a internet, você pode gastar 2 PE para substituir um teste de perícia qualquer por um teste de Tecnologia.";
						$investigacao = $tecnologia = 5;
						break;
					case "Trabalhador Rural": // trabaiador
						$habnam = "Desbravador. (Origem)";
						$habdes = "Quando faz um teste de Adestramento ou Sobrevivência, você pode gastar 2 PE para receber +5 nesse teste. Além disso, você não sofre penalidade em deslocamento por terreno dif ícil.";
						$adestramento = $sobrevivencia = 5;
						break;
					case "Trambiqueiro": // rambiqueiro
						$habnam = "Impostor. (Origem)";
						$habdes = "Uma vez por cena, você pode gastar 2 PE para substituir um teste de perícia qualquer por um teste de Enganação.";
						$crime = $enganacao = 5;
						break;
					case "Universitário": // Universitário
						$habnam = "Dedicação. (Origem)";
						$habdes = "ocê recebe +1 PE, e mais 1 PE adicional a cada NEX ímpar (15%, 25%...). Além disso, seu limite de PE por turno aumenta em 1 (em NEX 5% seu limite é 2, em NEX 10% é 3 e assim por diante).";
						$investigacao = $atualidades = 5;
						break;
					case "Vítima": // Vítima
						$habnam = "Cicatrizes Psicológicas. (Origem)";
						$habdes = "Você recebe +1 de Sanidade para cada 5% de NEX (Adicionado automaticamente.)";
						$reflexo = $vontade = 5;
						break;
				}
				switch ($classe) {
					default:
						break;
					case "Mundano": //Combatente
						$hcn = "Empenho (Classe)";
						$hcd = "Você pode não ter treinamento especial, mas compensa com dedicação e esforço. Quando faz um teste de perícia, você pode gastar 1 PE para receber +2 nesse teste.";
						$pt[0] = "Armas Simples";
						break;
					case "Combatente": //Combatente
						$hcn = "Ataque Especial (Classe)";
						$hcd = "Quando faz um ataque, você pode gastar 2 PE para receber +5 no teste de ataque ou na rolagem de dano.";
						$pt[0] = "Armas Simples";
						$pt[3] = "Armas de táticas";
						$pt[4] = "Proteções leves";
						break;
					case "Especialista":
						$hcn = "Perito (Classe)";
						$hcd = "Escolha duas perícias nas quais você é treinado (exceto Luta e Pontaria). Quando faz um teste de uma dessas perícias, você pode gastar 2 PE para somar +1d6 no resultado do teste. ";
						$hcn2 = "Eclético (Classe)";
						$hcd2 = "Quando faz um teste de uma perícia, você pode gastar 2 PE para receber os benefícios de ser treinado nesta perícia.";
						$pt[0] = "Armas Simples";
						$pt[2] = "Proteções leves";
						break;
					case "Ocultista":
						$hcn = "Escolhido pelo Outro Lado (Classe)";
						$hcd = "Você pode lançar rituais de 1º círculo.";
						$ocultismo = $vontade = 5;
						$pt[0] = "Armas Simples";
						break;
					
				}
				if ($success) {
					$dadosuser = mysqli_fetch_assoc($con->query("SELECt * from usuarios where login = '$user'"));
					
					$vp = $con->prepare("SELECT * FROM `fichas_personagem` WHERE `usuario` in (Select id from usuarios where login = ?) AND `nome` = ?");
					$vp->bind_param("is", $iduser, $nome);
					$vp->execute();
					$rvp = $vp->get_result();
					if ($rvp->num_rows == 0) {
						$vapo = $con->query("SELECT * FROM `fichas_personagem` WHERE `usuario` in (Select id from usuarios where login = '$user') Limit 1;");
						$vl = $con->query("SELECT * FROM `ligacoes` WHERE `id_usuario`in (Select id from usuarios where login = '$user') AND `id` = '" . $convite . "' AND `id_ficha` is null;");
						$qp = $con->prepare("INSERT INTO `fichas_personagem` (`id`, `token`, `public`, `usuario`, `nome`, `foto`, `origem`, `classe`, `trilha`, `nex`, `patente`, `idade`, `local`, `historia`, `forca`, `agilidade`, `inteligencia`, `presenca`, `vigor`, `pv`, `pva`, `san`, `sana`, `pe`, `pea`, `morrendo`, `enlouquecendo`, `passiva`, `bloqueio`, `esquiva`, `mental`, `sangue`, `morte`, `energia`, `conhecimento`, `fisica`, `balistica`,`acrobacias`,`adestramento`,`artes`,`atualidades`,`atletismo`,`ciencia`,`crime`,`diplomacia`,`enganacao`,`fortitude`,`furtividade`,`iniciativa`,`intimidacao`,`intuicao`,`investigacao`,`luta`,`medicina`,`ocultismo`,`percepcao`,`pilotagem`,`pontaria`,`profissao`,`reflexos`,`religiao`,`sobrevivencia`,`tatica`,`tecnologia`,`vontade`)
                                                                    VALUES ('', UUID() ,'0', ? , ?, ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , 0 , 0 , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? ,? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? );");
						$qp->bind_param("isssssiiissiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii", $dadosuser["id"], $nome, $foto, $origem, $classe, $trilha, $nex, $patente, $idade, $local, $historia, $forca, $agilidade, $intelecto, $presenca, $vigor, $pv, $pv, $san, $san, $pe, $pe, $passiva, $bloqueio, $esquiva, $sanidade, $sangue, $morte, $energia, $conhecimento, $fisico, $balistico, $acrobacia, $adestramento, $artes, $atualidades, $atletismo, $ciencia, $crime, $diplomacia, $enganacao, $fortitude, $furtividade, $iniciativa, $intimidacao, $intuicao, $investigacao, $luta, $medicina, $ocultismo, $percepcao, $pilotagem, $pontaria, $profissao, $reflexo, $religiao, $sobrevivencia, $tatica, $tecnologia, $vontade);
						$success = $qp->execute();
						$id = mysqli_insert_id($con);
						if (!empty($hcn)) {
							$dp = $con->query("INSERT INTO `habilidades`(`id_ficha`,`nome`,`descricao`,`id`) VALUES ('$id','$hcn','$hcd','')");
						}
						if (!empty($hcn2)) {
							$dp = $con->query("INSERT INTO `habilidades`(`id_ficha`,`nome`,`descricao`,`id`) VALUES ('$id','$hcn2','$hcd2','')");
						}
						if (!empty($habnam)) {
							$dp = $con->query("INSERT INTO `habilidades`(`id_ficha`,`nome`,`descricao`,`id`) VALUES ('$id','$habnam','$habdes','')");
						}
						if (isset($pt)) {
							foreach ($pt as $i) {
								if (!empty($i)) {
									$p = $con->query("INSERT INTO `proeficiencias` (`nome`,`id_ficha`) VALUES ('" . $i . "','" . $id . "');");
								}
							}
						}
						$al = $con->query("UPDATE `ligacoes` SET `id_ficha` = '" . $id . "' WHERE `ligacoes`.`id` = '" . $convite . "' AND `ligacoes`.`id_usuario` = '" . $iduser . "' LIMIT 1;");
						$msg = $success ? "Personagem Criado com sucesso!" : "Houve uma falha ao adicionar personagem na database, contate um administrador!";
					} else {
						$success = false;
						$msg = 'Já Existe um Personagem seu com esse mesmo nome!(Provavelmente houve duplicação ao salvar, então só ir para pagina do seu personagem.)';
					}
				}
			} else {
				$success = false;
				$msg = "Sua sessão, faça login novamente.";
			}
			break; //APP
		case "account_recovery":
		case 'recovery_account':
			if (!empty($_DATA["email"])) {
				$email = cleanstring($_DATA["email"]);
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
								$success = true;
								$msg = 'Email enviado! Verifique sua caixa de email.';
							} else {
								$success = false;
								$msg = "Falha ao enviar! contate um administrador.";
							}
						}
					} else {
						$success = false;
						$msg = 'Email não cadastrado.';
					}
					
				} else {
					$msg = "Email não é válido.";
					$success = false;
				}
			} else {
				$success = false;
				$msg = "Preencha seu email.";
			}
			
			break; // Não usado
		case "account_get":
		case 'login':
			if (!empty($_DATA["login"])) {
				$login = cleanstring($_DATA["login"]);
				if (!empty($_DATA["senha"])) {
					$senha = cleanstring($_DATA["senha"]);
					$qu = $con->prepare("SELECT * FROM `usuarios` WHERE (usuarios.login = ?) OR (usuarios.email = ?);");
					$qu->bind_param("ss", $login, $login);
					$qu->execute();
					$qu = $qu->get_result();
					if ($qu->num_rows) {
						$rq = mysqli_fetch_assoc($qu);
						$sessid = remember_me($rq["id"]);
						if (cryptthis($senha) === $rq["senha"]) {
							$sessid = remember_me($rq["id"]);
							$msg = "Sucesso ao fazer login!";
							
							$f = $con->prepare("UPDATE usuarios SET senha = ? WHERE usuarios.login = ?");
							$nsenha = PassCheck($senha);
							$f->bind_param("ss", $nsenha, $login);
							$f->execute();
							
							
							$conta = [];
							$data["id"] = $sessid;
							$conta["token"] = $sessid;
							$conta["nome"] = $rq["nome"];
							$conta["email"] = $rq["email"];
							$conta["login"] = $rq["login"];
							$data["conta"] = $conta;
							
							
						} elseif (PassCheck($senha, $rq["senha"])) {
							$sessid = remember_me($rq["id"]);
							$msg = "Sucesso ao fazer login!";
							
							$conta = [];
							$data["id"] = $sessid;
							$conta["token"] = $sessid;
							$conta["nome"] = $rq["nome"];
							$conta["email"] = $rq["email"];
							$conta["login"] = $rq["login"];
							$data["conta"] = $conta;
							
						} else {
							$success = false;
							$msg = "Email/User/Senha Incorretos...";
						}
					} else {
						$success = false;
						$msg = "Nenhuma conta encontrada...";
					}
				} else {
					$success = false;
					$msg = "User/Email não preenchido";
				}
			} else {
				$success = false;
				$msg = "Senha não preenchida";
			}
			break; // APP
		case 'update_ficha':
			$token = cleanstring($_DATA["token"]);
			$sid = cleanstring($_DATA["sessid"] ?: session_id());
			$data["POST"] = $_DATA;
			if (check_session($sid)) {
				$user = check_session($sid);
				$a = $con->prepare("SELECT * FROM `fichas_personagem` WHERE `token`= ? AND `usuario`  in (SELECT id FROM usuarios WHERE `login` = ?);");
				$a->bind_param("ss", $token, $user);
				$a->execute();
				$a = $a->get_result();
				if ($a->num_rows) {# Encontrou a ficha
					if (isset($_DATA["dados"]) && !empty($_DATA["dados"])) {
						$dados = $_DATA["dados"];
						
						$excludes = ["id", "token", "usuario"];
						
						$stmt = get_stmt($dados, $excludes, "fichas_personagem", con());
						$stmt["bind"] .= "ss";
						$stmt["values"][] = $token;
						$stmt["values"][] = $user;
						
						$a = $con->prepare("UPDATE fichas_personagem SET {$stmt["query"]} WHERE token = ? AND usuario in (SELECT id FROM usuarios WHERE login = ?)");
						$a->bind_param($stmt["bind"], ...$stmt["values"]);
						$a->execute();
						$success = true;
						
					} else {
						$msg = "Nenhum dado a ser alterado..";
						$success = false;
					}
				} else {
					$success = false;
					$msg = 'Falha ao encontrar ficha.';
				}
			} else {
				$success = false;
				$msg = 'Sua conta não está mais ativa.';
			}
			break; // APP
		case 'roll':
			$dado = cleanstring($_DATA["dado"]);
			$dano = (int)minmax($_DATA["dano"], 0, 1);
			$margem = (int)minmax($_DATA["margem"] ?: 20, 1, 20);
			$for = (int)($_DATA["for"]);
			$agi = (int)($_DATA["agi"]);
			$int = (int)($_DATA["int"]);
			$vig = (int)($_DATA["vig"]);
			$pre = (int)($_DATA["pre"]);
			$arr = [
				"FOR" => $for,
				"AGI" => $agi,
				"INT" => $int,
				"VIG" => $vig,
				"PRE" => $pre
			];
			$dado = DadoDinamico(cleanstring($_DATA["dado"], 50), $arr);
			if (ClearRolar($dado)) {
				$data["dado"] = RolarMkII($dado, $dano, $margem);
			} else {
				$success = false;
				$msg = ClearRolar($dado, true);
			}
			break; // APP
		case 'account_check':
		case 'check_session':
		case 'get_account':
		case 'checksession':
			$sid = cleanstring($_DATA["sessid"] ?: session_id());
			if (check_session($sid)) {
				$user = check_session($sid);
				$q = $con->prepare("SELECT * FROM `usuarios` WHERE `id`  = ?;");
				$q->execute([$user]);
				
				$q = $q->get_result();
				if ($q->num_rows) {
					$tv = mysqli_fetch_array($q);
					$conta["nome"] = $tv["nome"];
					$conta["email"] = $tv["email"];
					$conta["login"] = $tv["login"];
					$data["conta"] = $conta;
				} else {
					$success = false;
					$msg = 'Essa conta não existe.';
				}
			} else {
				$success = false;
				$msg = 'Sua conta já foi encerrada.';
			}
			break;
		case 'deslogar':
			$sid = cleanstring($_DATA["sessid"] ?: session_id());
			$a = $con->prepare("DELETE FROM auth WHERE token = ? ;");
			$a->bind_param("s", $sid);
			$a->execute();
			break; // APP
	}
} else {
	$success = false;
	$msg = "Nenhuma query encontrada.";
}
$data["success"] = $success;
$data["msg"] = $msg;
$data["data"] = $_DATA;
echo json_encode($data, JSON_PRETTY_PRINT);
//http_response_code($success?200:404);