<?php

function proibido()
{
	return header('location: ..');
}

const UploadKeys = ["ef02827bc6403b4028f3ebd4375163c9", "597d795ea0028f95a051c1df0ab85dce", "0f32daed2d725ef44d874f98798422f3", "15d1789295f623f383308ce4fd56e842", "dcb7e42b1a76ff5a1faa70af080fcf4b"];

/**
 * Retorna os parâmetros necessários para fazer um mysqli_prepare();
 * <h2>Exemplo de uso</h2>
 *  $arr = ("coluna"=>"valor" , "coluna2"=>"valor2" );<br/><br/>
 *  $return = get_stmt($arr);<br/><br/>
 *  $q = mysqli_prepare($con,"UPDATE tabela SET <b>{return["query"]}</b>;");<br/>
 *  $q->bind_param(<b>$return["bind"]</b>,...<b>$return["values"]</b>);<br/>
 *  $q->execute();<br/>
 *
 *
 * @param array $array [Obrigatório] <p>
 * Um Array contendo indice e valor, sendo a coluna e valor respectivamente a tabela que será aplicada.<br/>
 * Exemplo:
 * <ul>
 * <li>array(<br/>      "nome" => "Lucas",<br/>       "idade" => 18<br/>);</li>
 * </ul>
 * </p>
 * @param array|null $excludes [Opcional]
 * <p> Um Array contendo colunas que deverão ser excluídas ou não alteráveis no processo.
 *  Exemplo:
 * <ul>
 * <li>array("nome","idade");</li>
 * </ul>
 * Com isso, As colunas <b>Nome</b> e <b>Idade</b> não vão ser alteradas, mesmo que dentro do array principal.
 * </p>
 * @param array|string|null $includes [Opcional]
 * <p>
 * <h2>Caso Array</h2>
 * Fará com que apenas os indices dentro deste array sejam atualizados. Sendo limitado apenas pelo <b>$excludes</b>.<br />
 * Isto é, Caso tenha uma coluna que esteja em ambos, será priorizado a exclusão no processo.
 * Exemplo:
 * <ul>
 * <li>array("nome","idade");</li>
 * </ul>
 * <h2>Caso String</h2>
 * Será o nome da tabela, que será alterado. Fazendo com que o $con Seja obrigatório para poder pegar as colunas dentro da mesma.
 * E fazendo assim, o includes automaticamente. Sendo limitado apenas ao $excludes.
 * </p>
 * @param mysqli|null $con [Opcional|Obrigatório]
 * <p>
 * Obrigatória quando $includes for uma string. Será preciso para conseguir as colunas e apenas permitir a alteração das mesmas.
 * </p>
 * @return array
 * <p>
 *  Retorna um Array com 3 Valores sendo <br />
 *  <var>$return["bind"]</var>: Uma string contendo o tipo de valor dentro de $return["values"]. Exemplo ["bind"] = "ssi".<br/>
 *  <var>$return["values"]</var>: Uma array contendo os valores separados de cada coluna na ordem da $return["query"].
 *  <var>$return["query"]</var>: Uma string que contem cada atualização para alterar no banco de dados.
 * <p>
 */
function get_stmt(array $array, array $excludes = null, array|string $includes = null, mysqli $con = null): array
{
	$bind = "";
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
			continue;
		}
		if ($continue) {
			continue;
		}
		switch (gettype($valor)) {
			default:
				continue 2;
			case "string":
				$bind .= "s";
				break;
			case "boolean":
			case "integer":
				$bind .= "i";
				break;
		}
		$query .= "$item = ?";
		
		if ($i < count($array)) {
			$query .= ", ";
		}
		
		$values[] = $valor;
	}
	return array(
		"bind" => $bind,
		"query" => $query,
		"values" => $values
	);
}

function duplicate_row($row_infos, array $updates = null, array $excludes = null)
{
	$query_columns = "";
	$query_values = "";
	$bind_types = "";
	$bind_values = [];
	
	
	foreach ($row_infos as $item => $valor) {
		$i++;
		$continue = false;
		if (isset($updates[$item], $row_infos[$item])) {
			$valor = $updates[$item];
		}
		if (isset($excludes) && in_array($item, $excludes, true)) {
			$continue = true;
		} else {
			switch (gettype($valor)) {
				case "string":
					$bind_types .= "s";
					break;
				case "boolean":
				case "integer":
					$bind_types .= "i";
					break;
				case "NULL":
					$continue = true;
					break;
			}
		}
		
		if (!$continue) {
			$bind_values[] = $valor;
			$query_columns .= $item;
			$query_values .= "?";
			
			if ($i < count($row_infos)) {
				$query_values .= ", ";
				$query_columns .= ", ";
				
			}
		} else if ($i === count($row_infos)) {
			$query_values = substr($query_values, 0, -2);
			$query_columns = substr($query_columns, 0, -2);
		}
	}
	return array(
		"bind_types" => $bind_types,
		"query_columns" => $query_columns,
		"query_values" => $query_values,
		"bind_values" => $bind_values
	);
}

function Image_Upload($image, $name = null)
{
	foreach (UploadKeys as $chave) {
		$API_KEY = $chave;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.imgbb.com/1/upload?key=' . $API_KEY);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		$extension = pathinfo($image['name'], PATHINFO_EXTENSION);
		$file_name = ($name) ? $name . '.' . $extension : $image['name'];
		$data = array('image' => base64_encode(file_get_contents($image['tmp_name'])), 'name' => $file_name);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			//return 'Error:' . curl_error($ch);
			curl_close($ch);
		} else {
			curl_close($ch);
			$result = json_decode($result, true);
			if ($result["status"] == 200) {
				return $result;
			}
		}
	}
	return $result;
}

function Check_Name($nome): bool
{
	$nome = cleanstring($nome);
	
	return (preg_match('/^[a-zA-Z áéíóúãõàèìòùÁÉÍÓÚÃÕÀÈÌÒÙ]{2,50}$/u', $nome));
	
	
}

function Check_Login($login): bool
{
	$login = cleanstring($login);
	if (empty($login) || strlen($login) < 2 || strlen($login) > 16) {
		return false;
	}
	
	return (preg_match('/^[\w\s-]*$/', $login));
	
}

function Check_Email($email): bool
{
	$email = cleanstring($email, 200);
	return filter_var($email, FILTER_VALIDATE_EMAIL);
	
}

function Check_Pass($senha, $senha2, $debug = false): bool|array
{
	$senha = cleanstring($senha);
	$senha2 = cleanstring($senha2);
	$data = [];
	$success = true;
	if ($senha === $senha2) {
		if (strlen($senha) < 8 || strlen($senha) > 50 || !preg_match("/[A-Za-z\d]/", $senha) || preg_match("/\s/", $senha)) {
			$msg = "A senha precisa ter no mínimo 8 dígitos com letras maiúsculas e minúsculas, e números.";
			$success = false;
		}
	} else {
		$msg = "As senhas não coincidem.";
		$success = false;
	}
	if ($debug) {
		$data["success"] = $success;
		$data["msg"] = $msg;
		return $data;
	}
	
	return $success;
}

/*
function Send_Email($Assunto, $Destinatario, $Mensagem): bool
{
    $headers = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=iso-8859-1' . "\r\n" . 'From: suporte@fichasop.com' . "\r\n" . 'Cc: Admin@fichasop.com' . "\r\n";
    return mail($Destinatario, $Assunto, $Mensagem, $headers);
}
*/
function Convite($Destinatario): string
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
                                            <a href="https://fichasop.com/?convite=1&email=' . $Destinatario . '" style="color: #ffffff; font-size: 16px; font-family: Helvetica, Arial, sans-serif; text-decoration: none; border-radius: 6px; line-height: 20px; display: block; font-weight: 700 !important; white-space: nowrap; background-color: #0d6efd; padding: 12px; border: 1px solid #0d6efd;">Aceitar Convite.</a>
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

function Confirmar_Conta($token): string
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
                                            <a href="https://fichasop.com/conta/confirmar.php/?token=' . $token . '" style="color: #ffffff; font-size: 16px; font-family: Helvetica, Arial, sans-serif; text-decoration: none; border-radius: 6px; line-height: 20px; display: block; font-weight: 700 !important; white-space: nowrap; background-color: #0d6efd; padding: 12px; border: 1px solid #0d6efd;">Confirmar Email.</a>
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
	return $float ? min(max((int)$int, $min), $max) : min(max((float)$int, $min), $max);
}

function cleanstring($data, $limit = 1000): string
{
	return substr(htmlspecialchars(stripslashes(trim($data?:""))), 0, $limit);
}


function logout(int $user = null): void
{
	global $con;
	
	
	if (isset($_COOKIE['remember_me'])) {
		if($user === null) {
			$user = (int)$_SESSION["UserID"];
		}
		
		$token = filter_input(INPUT_COOKIE, 'remember_me');
		$validator = explode(":",$token);
		
		$q = $con->prepare("DELETE FROM user_tokens WHERE user_id = ? AND selector = ? ;");
		$q->execute([$user, $validator[0]]);
		
		unset($_COOKIE['remember_me']);
		setcookie('remember_me', null, -1);
	}
	
	session_unset();
	session_destroy();
}

function remember_me(int $user_id, int $day = 7, string $type = "UKN"): string
{
	$con = con();
	$b = $con->prepare("DELETE FROM user_tokens WHERE user_id = ? AND type = ? ");
	$b->bind_param("is", $user_id, $type);
	$b->execute();
	
	
	$selector = bin2hex(random_bytes(16));
	$validator = bin2hex(random_bytes(32));
	
	$token = $selector . ':' . $validator;
	
	
	$expired_seconds = time() + 60 * 60 * 24 * $day;
	$expiry = date('Y-m-d H:i:s', $expired_seconds);
	
	$hash_validator = password_hash($validator, PASSWORD_DEFAULT);
	
	
	$a = $con->prepare("INSERT INTO `user_tokens` (`selector`, `hashed_validator`, `user_id`,`type`, `expiry`) VALUES ( ? , ? , ? , ? , ? );");
	$a->bind_param("ssiss", $selector, $hash_validator, $user_id, $type, $expiry);
	if ($a->execute()) {
		setcookie('remember_me', $token, $expired_seconds);
		
		return $token;
	}
	
	return "falha";
}

function check_session($token)
{
	global $con;
	$token = cleanstring($token);
	
	if (!empty($token)) {
		[$string, $Secret] = explode(':', $token);
		
		$a = $con->prepare("SELECT id, selector, hashed_validator, user_id, expiry FROM user_tokens WHERE selector = ? AND expiry >= now() LIMIT 1;");
		$a->execute([$string]);
		$a = $a->get_result();
		if ($a->num_rows) {
			$dados = mysqli_fetch_assoc($a);
			
			if (password_verify($Secret, $dados['hashed_validator'])) {
				return $dados["user_id"];
			}
		}
		
	}
	return false;
	
}



function logar(string|int $login): bool
{
	$con = con();
	$q = $con->prepare("select * from `usuarios` WHERE `id` = ? LIMIT 1;");
	$q->execute([$login]);
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
		return true;
	}
	return false;
} //Inicia a sessão