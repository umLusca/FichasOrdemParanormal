<?php

function CheckName($nome): bool
{
	$nome = cleanstring($nome);
	return (preg_match('/^[0-9a-zA-Z áéíóúãõàèìòùÁÉÍÓÚÃÕÀÈÌÒÙ]*$/', $nome));
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
function Check_Pass($senha,$senha2,$debug = false): bool | array
{
	$senha = cleanstring($senha);
	$senha2 = cleanstring($senha2);
	$data = [];
	$success = true;
	if ($senha === $_POST["csenha"]) {
		if (strlen($senha) < 8 || strlen($senha) > 50) {
			$msg = "Senha deve conter entre 8 e 50 digitos.";
			$success = false;
		}
		if (!preg_match("/[A-Z]/", $senha)) {
			$msg = "Senha precisa conter letras maiúsculas.";
			$success = false;
		}
		if (!preg_match("/[a-z]/", $senha)) {
			$msg = "Senha precisa conter letras minúsculas.";
			$success = false;
		}
		if (preg_match("/\s/", $senha)) {
			$msg = "Senha não pode conter espaços!";
			$success = false;
		}
			$senha = cryptthis($senha);
	} else {
		$msg = "As senhas não são iguais.";
		$success = false;
	}
	if($debug){
		$data["success"] = $success;
		$data["msg"] = $msg;
		return $data;
	} else {
		return $success;
	}
}

function Enviar_Email($Assunto, $Destinatario, $Mensagem): bool
{
	$headers  = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=iso-8859-1' . "\r\n" . 'From: suporte@fichasop.com' . "\r\n". 'Cc: Admin@fichasop.com' . "\r\n";
	return mail($Destinatario,$Assunto,$Mensagem,$headers);
}

function Gerar_Convite($Destinatario): string
{
	return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html>
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
                                            <a href="https://fichasop.com/?convite=1&email='.$Destinatario.'" style="color: #ffffff; font-size: 16px; font-family: Helvetica, Arial, sans-serif; text-decoration: none; border-radius: 6px; line-height: 20px; display: block; font-weight: 700 !important; white-space: nowrap; background-color: #0d6efd; padding: 12px; border: 1px solid #0d6efd;">Aceitar Convite.</a>
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
}
function Gerar_Confirmacao($token): string
{
	return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html>
  <head>
    <!-- Compiled with Bootstrap Email version: 1.3.1 --><meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">
      body,table,td{font-family:Helvetica,Arial,sans-serif !important}.ExternalClass{width:100%}.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:150%}a{text-decoration:none}*{color:inherit}a[x-apple-data-detectors],u+#body a,#MessageViewBody a{color:inherit;text-decoration:none;font-size:inherit;font-family:inherit;font-weight:inherit;line-height:inherit}img{-ms-interpolation-mode:bicubic}table:not([class^=s-]){font-family:Helvetica,Arial,sans-serif;mso-table-lspace:0pt;mso-table-rspace:0pt;border-spacing:0px;border-collapse:collapse}table:not([class^=s-]) td{border-spacing:0px;border-collapse:collapse}@media screen and (max-width: 600px){.w-full,.w-full>tbody>tr>td{width:100% !important}.w-24,.w-24>tbody>tr>td{width:96px !important}.p-lg-10:not(table),.p-lg-10:not(.btn)>tbody>tr>td,.p-lg-10.btn td a{padding:0 !important}.p-3:not(table),.p-3:not(.btn)>tbody>tr>td,.p-3.btn td a{padding:12px !important}.p-6:not(table),.p-6:not(.btn)>tbody>tr>td,.p-6.btn td a{padding:24px !important}*[class*=s-lg-]>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-4>tbody>tr>td{font-size:16px !important;line-height:16px !important;height:16px !important}.s-6>tbody>tr>td{font-size:24px !important;line-height:24px !important;height:24px !important}.s-10>tbody>tr>td{font-size:40px !important;line-height:40px !important;height:40px !important}}
    </style>
  </head>
  <body class="" style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; margin: 0; padding: 0; border-width: 0;" bgcolor="#ffffff">
    <table class="body" valign="top" role="presentation" border="0" cellpadding="0" cellspacing="0" style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; margin: 0; padding: 0; border-width: 0;" bgcolor="#ffffff">
      <tbody>
        <tr>
          <td valign="top" style="line-height: 24px; font-size: 16px; margin: 0;" align="left">
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
                                    <img class="w-24" src="https://fichasop.com/assets/img/fichasop.png" style="height: auto; line-height: 100%; outline: none; text-decoration: none; display: block; width: 96px; border-style: none; border-width: 0;" width="96">
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
                                    <h1 class="h3 fw-700" style="padding-top: 0; padding-bottom: 0; font-weight: 700 !important; vertical-align: baseline; font-size: 28px; line-height: 33.6px; margin: 0;" align="left">
                                      Verifica&#231;&#227;o de conta
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
                                    <p class="" style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left">Obrigado por criar sua conta no FichasOP. Seja bem-vindo.</p>
                                    <table class="s-4 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                      <tbody>
                                        <tr>
                                          <td style="line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="left" width="100%" height="16">
                                            &#160;
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <table class="btn btn-primary p-3 fw-700" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-radius: 6px; border-collapse: separate !important; font-weight: 700 !important;">
                                      <tbody>
                                        <tr>
                                          <td style="line-height: 24px; font-size: 16px; border-radius: 6px; font-weight: 700 !important; margin: 0;" align="center" bgcolor="#0d6efd">
                                            <a href="https://fichasop.com/conta/confirmar.php/?token='.$token.'" style="color: #ffffff; font-size: 16px; font-family: Helvetica, Arial, sans-serif; text-decoration: none; border-radius: 6px; line-height: 20px; display: block; font-weight: 700 !important; white-space: nowrap; background-color: #0d6efd; padding: 12px; border: 1px solid #0d6efd;">Confirmar Email.</a>
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
                              Com &lt;3 de FichasOP<br>
                              Tenha uma boa sess&#227;o
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
</html>
';
}


function minmax($int, $min = 0, $max = 99, $float = 0)
{
	return $float?min(max(intval($int), $min), $max):min(max(floatval($int), $min), $max);
}
function cleanstring($data, $limit = 1000): string
{
	return substr(htmlspecialchars(stripslashes(trim($data))),0,$limit);
}


function getUserIpAddr(){
	if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		//ip from share internet
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		//ip pass from proxy
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

function generate_tokens(): array
{
	$selector = bin2hex(random_bytes(16));
	$validator = bin2hex(random_bytes(32));
	return [$selector, $validator, $selector . ':' . $validator];
}

function parse_token(string $token): ?array
{
	$parts = explode(':', $token);

	if ($parts && count($parts) == 2) {
		return [$parts[0], $parts[1]];
	}
	return null;
}
function find_user_token_by_selector(string $selector): bool|array|null
{
	$con = con();
	$ip = getUserIpAddr();
	$a = $con->prepare("SELECT id, selector, hashed_validator, user_id, expiry FROM user_tokens WHERE selector = ? AND expiry >= now() AND `ip` = ? LIMIT 1;");
	$a->bind_param("ss", $selector, $ip);
	$a->execute();
	$ra = $a->get_result();
	return mysqli_fetch_assoc($ra);
}
function delete_user_token(int $user_id): bool
{
	$con = con();
	$q = $con->prepare("DELETE FROM user_tokens WHERE user_id = ?");
	$q->bind_param("i", $user_id);
	return $q->execute();
}
function find_user_by_token(string $token): bool|array|null
{
	$tokens = parse_token($token);

	if (!$tokens) {
		return null;
	}
	$con = con();
	$a = $con->prepare('SELECT usuarios.id, login
            FROM usuarios
            INNER JOIN user_tokens ON user_id = usuarios.id
            WHERE selector = ? AND
                expiry > now()
            LIMIT 1');
	$a->bind_param("s", $tokens[0]);
	$a->execute();
	$ra = $a->get_result();
	return mysqli_fetch_assoc($ra);
}
function insert_user_token(int $user_id, string $selector, string $hashed_validator, string $expiry): bool
{
	$con = con();
	$ip = getUserIpAddr();
	$q = $con->prepare("INSERT INTO `user_tokens` (`id`, `selector`, `hashed_validator`, `user_id`, `expiry`,`ip`) VALUES ('', ? , ? , ? , ? , ? );");
	$q->bind_param("ssiss", $selector, $hashed_validator, $user_id, $expiry, $ip);
	return $q->execute();
}
function remember_me(int $user_id, int $day = 7): void
{
	[$selector, $validator, $token] = generate_tokens();

	// remove all existing token associated with the user id
	delete_user_token($user_id);

	// set expiration date
	$expired_seconds = time() + 60 * 60 * 24 * $day;

	// insert a token to the database
	$hash_validator = password_hash($validator, PASSWORD_DEFAULT);
	$expiry = date('Y-m-d H:i:s', $expired_seconds);
	if (insert_user_token($user_id, $selector, $hash_validator, $expiry)) {
		setcookie('remember_me', $token, $expired_seconds);
	}
}
function is_user_logged_in(): bool
{
	// check the session
	if (isset($_SESSION['UserLogin'])) {
		return true;
	}

	// check the remember_me in cookie
	$token = filter_input(INPUT_COOKIE, 'remember_me');

	if ($token && token_is_valid($token)) {

		$user = find_user_by_token($token);

		if ($user) {
			return logar($user['login']);
		}
	}
	return false;
}
function token_is_valid($token): bool
{
	$e = explode(':', $token);
	$selector = $e[0];
	$validator = $e[1];

	$tokens = find_user_token_by_selector($selector);
	if (!$tokens) {
		return false;
	}

	return password_verify($validator, $tokens['hashed_validator']);
}
function logout(): void
{
	if (is_user_logged_in()) {

		// delete the user token
		delete_user_token($_SESSION['UserID']);

		// delete session
		unset($_SESSION['username'], $_SESSION['user_id`']);

		// remove the remember_me cookie
		if (isset($_COOKIE['remember_me'])) {
			unset($_COOKIE['remember_me']);
			setcookie('remember_user', null, -1);
		}

		// remove all session data
		session_unset();
		session_destroy();

		// redirect to the login page
	}
}