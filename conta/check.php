<?php



$con = con();


function logar(string $login): bool
{
    $con = con();
    $q = $con->prepare("select * from `usuarios` WHERE `login` = ?");
    $q->bind_param("s", $login);
    $q->execute();
    $rq = $q->get_result();
    if ($rq->num_rows) {
        $dados = mysqli_fetch_array($rq);
        $_SESSION["UserID"] = $dados["id"];
        $_SESSION["UserLogin"] = $dados["login"];
        $_SESSION["UserName"] = $dados["nome"];
        $_SESSION["UserEmail"] = $dados["email"];
        $_SESSION["UserElite"] = $dados["elite"];
        $_SESSION["UserAdmin"] = $dados["admin"];
        $_SESSION["UserMarca"] = $dados["marca"];
        $_SESSION["CookieSession"] = false;
        return true;
    } else {
        return false;
    }
} //Inicia a sessão

function CheckName($nome): bool
{
    $nome = cleanstring($nome);
    return (preg_match('/^[a-zA-Z áéíóúãõàèìòùÁÉÍÓÚÃÕÀÈÌÒÙ]*$/', $nome));
}
function CheckLogin($login): bool
{
    $login = cleanstring($login);
    return (preg_match('/^[a-zA-Z-\'_\d]*$/', $login));
}
function CheckEmail($email): bool
{
    $email = cleanstring($email);
    return filter_var($email, FILTER_VALIDATE_EMAIL);

}

$data = [];

if(isset($_POST["status"])){
	switch ($_POST['status']){
		case 'addmarca':
			$userid = $_SESSION["UserID"];
			preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp)$/', cleanstring($_POST["urlmarca"]), $marca);
			if ($marca){
				$marca = cleanstring($_POST["urlmarca"]);
				$q = $con->query("SELECT * FROM `usuarios` WHERE `id` = '".$_SESSION["UserID"]."';");
				$rq = mysqli_fetch_array($q);
				if($marca != $rq["marca"]) {
					$a = $con->prepare("UPDATE `usuarios` SET `marca` = ? WHERE `id` = ? ;");
					$a->bind_param("si", $marca, $userid);
					$a->execute();
					$data["success"] = (bool)$con->affected_rows;
					if ($data["success"]) {
						$_SESSION["UserMarca"] = cleanstring($_POST["urlmarca"]);
						$msg = "Marca alterada com Sucesso";
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


			echo json_encode($data);
			exit;
			break;
	}
}



if (isset($_POST["cadastrar"])) {
    $success = true;
    if (!empty($_POST["nome"])) {
        $nome = cleanstring($_POST["nome"]);
        if (!CheckName($nome)) {
            $msg = "Apenas Letras e Espaços são permitidos no nome!";
            $success = false;
        }
    } else {
        $success = false;
        $msg = "Preencha todos os campos!";
    }


    if (!empty($_POST["login"])) {
        $login = cleanstring($_POST["login"]);
        if(!CheckLogin($login)){
            $success = false;
            $msg = "O username será usado para entrar em sua conta. (Apenas letras e Underlines)";
        }
        if (strlen($login) > 16){
            $success = false;
            $msg = "O username não pode ter mais de 16 caracteres.";
        }
    } else {
        $success = false;
        $msg = "Preencha todos os campos!";
    }

    if (!empty($_POST["email"])) {
        $email = cleanstring($_POST["email"]);
        if (!CheckEmail($email)) {
            $msg = "Email inserido não é valido.";
            $success = false;
        }
    } else {
        $success = false;
        $msg = "Preencha todos os campos!";
    }

    if (!empty($_POST["senha"] || $_POST["csenha"])) {
        if ($_POST["senha"] === $_POST["csenha"]) {
            $pass = cleanstring($_POST["senha"]);
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
        $msg = "Preencha todos os campos!";
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
        if ($a->num_rows == 0) {
            if ($ab->num_rows == 0) {
                $b = $con->query("SELECT * FROM `usuarios` WHERE `login` = '" . $login . "';");
                if ($b->num_rows == 0) {
                    $q = $con->prepare("INSERT INTO `usuarios`(`nome`,`login`,`senha`,`email`,`id`) VALUES (?,?,?,?,'')");
                    $q->bind_param("ssss", $nome, $login, $senha, $email);
                    $q->execute();
                    if ($con->affected_rows > 0) {
                        $success = true;
                        $msg = "Sucesso ao criar conta!";
                        if(logar($login)) $msg .= ' (Logado Automaticamente)';
                    } else {
                        $success = false;
                        $msg = "Falha ao criar conta!".$q->affected_rows.$con->affected_rows;
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
                    if(logar($login))$msg .= ' (Logado Automaticamente)';
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
    echo json_encode($data);
    exit; //Necessario para funcionar no jquery
} //Verificação dos dados

if (isset($_POST["logar"])) {
	$success = true;
	if (!empty($_POST["login"])) {
		$login = cleanstring($_POST["login"]);
	} else {
		$success = false;
		$msg = "Preencha todos os campos!";
	}
	if (!empty($_POST["senha"])) {
		$pass = cleanstring($_POST["senha"]);
		$senha = cryptthis($pass);
	} else {
		$success = false;
		$msg = "Preencha todos os campos!";
	}
	$qu = $con->query("SELECT * FROM `usuarios` WHERE (usuarios.login = '$login') OR (usuarios.email = '$login');");
	if (!$qu->num_rows) {
		$success = false;
		$msg = "Nenhuma conta encontrada...";
	}
	if ($success) {
		$q = $con->prepare("select * from `usuarios` WHERE `login` = ? and `senha` = ? OR `email` = ? AND `senha` = ?;");
		$q->bind_param("ssss", $login, $senha, $login, $senha);
		$q->execute();
		$rq = $q->get_result();
		if ($rq->num_rows == 1) { //Verifica se existe essa conta e se a senha coincide com ela
			$dados = mysqli_fetch_array($rq);
			logar($dados["login"]);
			$msg = "Sucesso ao fazer login!";
			$success = true;
			if (isset($_POST["lembrar"]) && ($_POST["lembrar"] == 'on' || $_POST["lembrar"] == 1)) remember_me($dados["id"]);// Quando a opção lembrar-me está marcada
		} else {
			$msg = "Usuario/Senha incorretos!";
			$success = false;
		}

	} // Verificação dos dados
		$_SESSION["timeout"] += 1;
		$data["tentativas"] = 5 - $_SESSION["timeout"];
		$data["success"] = $success;
		$data["msg"] = $msg.$aaa;
		echo json_encode($data);
		exit;

}

if (isset($_POST["update"])) {
    $success = true;
    switch ($_POST["update"]) {
        default:
            $data["success"] = false;
            $data["msg"] = "Houve uma falha, contate um administrador.";
            break;
        case 'recuperar':
            if (!empty($_POST["email"])) {
                $email = cleanstring($_POST["email"]);
                if (!CheckEmail($email)) {
                    $msg = "Email inserido não é valido.";
                    $success = false;
                }
            } else {
                $success = false;
                $msg = "Preencha todos os campos!";
            }
            if($success){
                $s = $con->query("SELECT * FROM `usuarios` WHERE `email` = '".$email."'");
                if($s->num_rows>0) {
                    $ds = mysqli_fetch_array($s);
                    $hash = md5(md5($email).md5($ds["nome"]).strtotime(date('m/d/Y h:i:s')));

                    $k = $con->query("INSERT INTO `recuperar_senha` (`id_usuario`,`hash`,`email`,`data`) VALUES ('".$ds["id"]."','".$hash."','".$email."',NOW())");
                    if($k) {


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
                        $fromname = 'FichasOP';
                        $subject = 'Recuperar Conta';

	                    $headers  = 'MIME-Version: 1.0' . "\r\n";
	                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	                    $headers .= 'From: suporte@fichasop.com' . "\r\n". 'Cc: Admin@fichasop.com' . "\r\n";


	                    if (mail($email,$subject,$emailmsg,$headers)) {
		                    $success = true;
		                    $msg = 'Email enviado, Verifique sua caixa de email';
	                    } else {
		                    $success = false;
							$msg = "Falha ao enviar email, contate um administrador.";
	                    }

                    }
                } else {
                    $success = false;
                    $msg = 'Nenhuma conta encontrada com esse email...';
                }
            }
            break;
        case 'email':
            if (!empty($_POST["email"])) {
                if ($_POST["email"] === $_POST["conemail"]) {
                    $email = cleanstring($_POST["email"]);
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $msg = "Email inserido não é valido.";
                        $success = false;
                    }
                } else {
                    $success = false;
                    $msg = "Os dois emails não são iguais";
                }
            } else {
                $success = false;
                $msg = "Preencha todos os campos!";
            }
            if ($success) {
                if (isset($_SESSION["UserID"])) {
                    $v = $con->query("SELECT * FROM `usuarios` WHERE `email` = '" . $email . "';");
                    if (!$v->num_rows) {
                        $q = $con->prepare("UPDATE `usuarios` SET `email`= ? WHERE `id`=?");
                        $q->bind_param("si", $email, $_SESSION["UserID"]);
                        $q->execute();
                        if ($con->affected_rows) {
                            $msg = "Alterado com sucesso.";
                            $_SESSION["UserEmail"] = $email;
                        } else {
                            $msg = "Falha ao alterar, atualize a pagina.";
                            $success = false;
                        }
                    } else {
                        $msg = "Email Já existente no banco de dados.";
                        $success = false;
                    }
                } else {
                    $msg = "Sua sessão encerrou, faça login novamente!";
                    $success = false;
                }
            }
            break;
        case 'senha':
            if (!empty($_POST["senha"] || $_POST["consenha"])) {
                if ($_POST["senha"] === $_POST["consenha"]) {
                    $pass = $_POST["senha"];
                    if (strlen($pass) < 8 || strlen($pass) > 50) {
                        $msg = "Senha deve conter entre 8 e 50 digitos. ";
                        $success = false;
                    }
                    if (!preg_match("/[A-Z]/", $pass)) {
                        $msg .= "Senha precisa conter letras maiúsculas. ";
                        $success = false;
                    }
                    if (!preg_match("/[a-z]/", $pass)) {
                        $msg .= "Senha precisa conter letras minúsculas. ";
                        $success = false;
                    }
                    if (preg_match("/\s/", $pass)) {
                        $msg .= "Senha não pode conter espaços! ";
                        $success = false;
                    }
                    $senha = cryptthis($pass);

                } else {
                    $msg = "As Senhas não Coincidem";
                    $success = false;
                }

            } else {
                $success = false;
                $msg = "Preencha todos os campos!";
            }
            if ($success) {
                if (isset($_SESSION["UserID"])) {
                    $q = $con->prepare("UPDATE `usuarios` SET `senha`= ? WHERE `id`=?");
                    $q->bind_param("si", $senha, $_SESSION["UserID"]);
                    $q->execute();
                    if ($con->affected_rows) {
                        $msg = "Alterado com sucesso.";
                    } else {
                        $msg = "Falha ao alterar, atualize a pagina.";
                        $success = false;
                    }
                } else {
                    $msg = "Sua sessão encerrou, faça login novamente!";
                    $success = false;
                }
            }
            break;
        case 'login':
            if (empty($_POST["login"])) {
                $msg = "Preencha todos os campos!";
                $success = false;
            } else {
                $login = cleanstring($_POST["login"]);
                preg_match('/^[a-zA-Z-\'_\d]*$/', $login);
                if (isset($_SESSION["UserID"])) {
                    $v = $con->query("SELECT * FROM `usuarios` WHERE `login` = '" . $login . "';");
                    if (!$v->num_rows) {
                        $q = $con->prepare("UPDATE `usuarios` SET `login`= ? WHERE `id`=?");
                        $q->bind_param("si", $login, $_SESSION["UserID"]);
                        $q->execute();
                        if ($con->affected_rows) {
                            $msg = "Alterado com sucesso.";
                            $_SESSION["UserLogin"] = $login;
                        } else {
                            $msg = "Falha ao alterar, atualize a pagina.";
                            $success = false;
                        }
                    } else {
                        $msg = "Login já existente;" . $v->num_rows;
                        $success = false;
                    }
                } else {
                    $msg = "Sua sessão encerrou, faça login novamente!";
                    $success = false;
                }
            }
            break;
        case 'nome':
            if (empty($_POST["nome"])) {
                $msg = "Preencha todos os campos!";
                $success = false;
            } else {
                $nome = cleanstring($_POST["nome"]);
                if (!preg_match("/^[a-zA-Z-' ]*$/", $nome)) {
                    $msg = "Apenas Letras e Espaços são permitidos no nome!";
                    $success = false;
                } else {
                    if (isset($_SESSION["UserID"])) {
                        $q = $con->prepare("UPDATE `usuarios` SET `nome`= ? WHERE `id`=?");
                        $q->bind_param("si", $nome, $_SESSION["UserID"]);
                        $q->execute();
                        if ($con->affected_rows) {
                            $msg = "Alterado com sucesso.";
                            $_SESSION["UserName"] = $nome;
                        } else {
                            $msg = "Falha ao alterar, atualize a pagina.";
                            $success = false;
                        }
                    } else {
                        $msg = "Sua sessão encerrou, faça login novamente!";
                        $success = false;
                    }
                }
            }
            break;
    }
    $data["msg"] = $msg;
    $data["success"] = $success;
    echo json_encode($data);
    //header("Refresh:3");
    exit;
}
