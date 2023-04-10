<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Accept');
header('Access-Control-Allow-Origin: *');
error_reporting(E_ERROR | E_PARSE);
ini_set('display_startup_errors', false);
ini_set('display_errors', false);
const RootDir = "/home/u436203203/domains/fichasop.com/public_html/";
$app = true;
require_once "/home/u436203203/domains/fichasop.com/public_html/config/includes.php";


$con = con();

$_DATA = $_DATA ?: [];
if (!empty(file_get_contents('php://input'))) {
	$body = json_decode(file_get_contents('php://input'), true);
	if (!empty($body)) {
		$_DATA += $body;
	}
}


$_QUERY = $_DATA["query"];
$return = array("success" => false, "msg" => "");
//NEW API


$userid = $_SESSION["UserID"] ?? check_session($_DATA["sessid"]);

switch (cleanstring($_DATA["query"])) {
	default:
		switch (count($conj)) {
			default:
				$return = array("success" => false, "msg" => "Query não encontrado!");
				break;
			case 3:
				switch ($conj[0]) {
					default:
						$return = array("success" => false, "msg" => "Query não encontrado!");
						break;
					case "conta":
						switch ($conj[1]) {
							default:
								$return = array("success" => false, "msg" => "Query não encontrado!");
								break;
							case "update":
								switch ($conj[2]) {
									case "marca"://OK
										if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp)$/', cleanstring($_DATA["urlmarca"]))) {
											$marca = cleanstring($_DATA["urlmarca"]);
											$q = $con->prepare("SELECT * FROM `usuarios` WHERE `id` = ? ;");
											$q->bind_param("s", $userid);
											$q->execute();
											$rq = mysqli_fetch_array($q->get_result());
											if ($marca !== $rq["marca"]) {
												$a = $con->prepare("UPDATE `usuarios` SET `marca` = ? WHERE `id` = ? ;");
												$a->bind_param("si", $marca, $userid);
												$a->execute();
												if ($con->affected_rows) {
													$return["success"] = true;
													$return["msg"] = "Marca alterada.";
													
													$_SESSION["UserMarca"] = cleanstring($_DATA["urlmarca"]);
												} else {
													$return["msg"] = "Falha ao alterar marca.";
												}
											} else {
												$return["msg"] = "A marca é igual a anterior.";
											}
										} else {
											$return["msg"] = "O link não é válido";
										}
										break; //OK
								}
								break;
						}
						break;
					case "mestre":
						switch ($conj[1]) {
							default:
								$return = array(
									"success" => false,
									"msg" => "Query não encontrado!"
								);
								break;
							case "add":
								switch ($conj[2]) {
									default:
										$return = array(
											"success" => false,
											"msg" => "Query não encontrado!"
										);
										break;
									case 'nota':
										$y = $con->prepare("INSERT INTO `notes`(`id`,`nome`,`notas`,`missao`) VALUES ('','Título','È Recomendado usar notas externas!',(SELECT id from missoes WHERE token = ? AND mestre = ?));");
										$y->bind_param("si", $token, $userid);
										$y->execute();
										break;
									case 'iniciativa':
										$f = $con->prepare("INSERT INTO `iniciativas` (`id_missao`) VALUES ((SELECT id FROM missoes where token = ? AND mestre = ?));");
										$f->bind_param("si", $token, $userid);
										$f->execute();
										break;
									case 'fichasnpc':
										$nome = cleanstring($_DATA["nome"]);
										$pv = minmax($_DATA["pv"], 1, 999999999);
										$categoria = minmax($_DATA["monstro"], 0, 1);
										$san = minmax($_DATA["san"], 0, 999999999);
										$pe = minmax($_DATA["pe"], 0, 999999999);
										$for = minmax($_DATA["forca"], -10, 10);
										$agi = minmax($_DATA["agilidade"], -10, 10);
										$int = minmax($_DATA["intelecto"], -10, 10);
										$pre = minmax($_DATA["presenca"], -10, 10);
										$vig = minmax($_DATA["vigor"], -10, 10);
										$passiva = minmax($_DATA["passiva"]);
										$esquiva = minmax($_DATA["esquiva"]);
										$morte = minmax($_DATA["morte"]);
										$sangue = minmax($_DATA["sangue"]);
										$energia = minmax($_DATA["energia"]);
										$conhecimento = minmax($_DATA["conhecimento"]);
										$fisica = minmax($_DATA["fisica"]);
										$balistica = minmax($_DATA["balistica"]);
										$mental = minmax($_DATA["mental"]);
										
										$acro = minmax($_DATA["acrobacia"]);
										$ades = minmax($_DATA["adestramento"]);
										$arte = minmax($_DATA["artes"]);
										$atle = minmax($_DATA["atletismo"]);
										$atua = minmax($_DATA["atualidades"]);
										$cien = minmax($_DATA["ciencia"]);
										$crim = minmax($_DATA["crime"]);
										$dipl = minmax($_DATA["diplomacia"]);
										$enga = minmax($_DATA["enganacao"]);
										$fort = minmax($_DATA["fortitude"]);
										$furt = minmax($_DATA["furtividade"]);
										$inic = minmax($_DATA["iniciativa"]);
										$inti = minmax($_DATA["intimidacao"]);
										$intu = minmax($_DATA["intuicao"]);
										$inve = minmax($_DATA["investigacao"]);
										$luta = minmax($_DATA["luta"]);
										$medi = minmax($_DATA["medicina"]);
										$ocul = minmax($_DATA["ocultismo"]);
										$perc = minmax($_DATA["percepcao"]);
										$pilo = minmax($_DATA["pilotagem"]);
										$pont = minmax($_DATA["pontaria"]);
										//$pres = minmax($_DATA["prestidigitacao"]);
										$prof = minmax($_DATA["profissao"]);
										$refl = minmax($_DATA["reflexos"]);
										$reli = minmax($_DATA["religiao"]);
										$sobr = minmax($_DATA["sobrevivencia"]);
										$tati = minmax($_DATA["tatica"]);
										$tecn = minmax($_DATA["tecnologia"]);
										$vont = minmax($_DATA["vontade"]);
										$ataq = cleanstring($_DATA["ataques"], 5000);
										$habs = cleanstring($_DATA["habilidades"], 5000);
										$deta = cleanstring($_DATA["detalhes"], 5000);
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
										$t->bind_param('sisiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiisss', $token, $userid, $nome, $categoria, $pv, $pv, $san, $san, $pe, $pe, $for, $agi, $int, $pre, $vig, $passiva, $esquiva, $morte, $sangue, $energia, $conhecimento, $balistica, $fisica, $mental, $acro, $ades, $arte, $atle, $atua, $cien, $crim, $dipl, $enga, $fort, $furt, $inic, $inti, $intu, $inve, $luta, $medi, $ocul, $perc, $pilo, $pont, $prof, $refl, $reli, $sobr, $tati, $tecn, $vont, $ataq, $habs, $deta);
										$t->execute();
										break;
									case 'player':
										$type = 1;
										$return["success"] = true;
										if (!empty($_DATA["user"])) {
											$email = cleanstring($_DATA["user"]);
										} else {
											$return["success"] = false;
											$return["msg"] = "Preencha o campo!";
										}
										
										if ($return["success"]) {
											$z = $con->prepare("SELECT * FROM `usuarios` WHERE `email`= ? OR login = ?;"); // verifica se a conta existe
											$z->bind_param("ss", $email, $email);
											$z->execute();
											$z = $z->get_result();
											if ($z->num_rows) { //Conta EXISTE!
												$user = mysqli_fetch_assoc($z);
												
												$x = $con->prepare("SELECT * FROM ligacoes WHERE id_usuario in (SELECT id from usuarios where email = ? OR login=?) AND id_missao in (SELECT id from missoes WHERE token = ? AND mestre =?) and id_ficha is null");
												$x->bind_param("sssi", $email, $email, $token, $userid);
												$x->execute();
												$x = $x->get_result();
												if (!$x->num_rows) { // Não existe convite PENDENTE.
													$y = $con->prepare("INSERT INTO `ligacoes`(token,id_missao,id_usuario) VALUES (UUID(),(SELECT id FROM missoes WHERE token = ? AND mestre = ?),?);");
													$y->bind_param("sii", $token, $userid, $user["id"]);
													$y->execute();
												}
												if ($user["status"]) {
													$return["msg"] = "Jogador convidado! (Conta Existente)";
												} else {
													$return["msg"] = "Jogador convidado! (Conta Inexistente)";
												}
												
											} else { // CONTA Não EXISTE
												$type = 2;
												
												if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
													$x = $con->prepare("INSERT INTO usuarios(status,email) VALUES (0,?)");
													$x->bind_param("s", $email);
													$x->execute();
													$xid = $con->insert_id;
													
													$y = $con->prepare("INSERT INTO ligacoes(token, id_missao, id_usuario) VALUES (uuid(),(SELECT id FROM missoes WHERE missoes.token =? and mestre = ?),?)");
													$y->bind_param("sii", $token, $userid, $xid);
													$y->execute();
													
													$return["msg"] = "Jogador convidado! (Conta Inexistente)";
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
      body,table,td{font-family:Helvetica,Arial,sans-serif !important}.ExternalClass{width:100%}.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:150%}a{text-decoration:none}*{color:inherit}a[x-apple-return-detectors],u+#body a,#MessageViewBody a{color:inherit;text-decoration:none;font-size:inherit;font-family:inherit;font-weight:inherit;line-height:inherit}img{-ms-interpolation-mode:bicubic}table:not([class^=s-]){font-family:Helvetica,Arial,sans-serif;mso-table-lspace:0pt;mso-table-rspace:0pt;border-spacing:0px;border-collapse:collapse}table:not([class^=s-]) td{border-spacing:0px;border-collapse:collapse}@media screen and (max-width: 600px){.w-full,.w-full>tbody>tr>td{width:100% !important}.w-24,.w-24>tbody>tr>td{width:96px !important}.p-lg-10:not(table),.p-lg-10:not(.btn)>tbody>tr>td,.p-lg-10.btn td a{padding:0 !important}.p-3:not(table),.p-3:not(.btn)>tbody>tr>td,.p-3.btn td a{padding:12px !important}.p-6:not(table),.p-6:not(.btn)>tbody>tr>td,.p-6.btn td a{padding:24px !important}*[class*=s-lg-]>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-4>tbody>tr>td{font-size:16px !important;line-height:16px !important;height:16px !important}.s-6>tbody>tr>td{font-size:24px !important;line-height:24px !important;height:24px !important}.s-10>tbody>tr>td{font-size:40px !important;line-height:40px !important;height:40px !important}}
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
													($return["success"] && Send_Email($subject, $email, $emailmsg)) ? $return["msg"] .= ' (Email enviado com sucesso.)' : $return["msg"] .= '(Email não enviado.)';
													
												} else {
													
													$return["msg"] = "Nenhuma conta encontrada, tente usando um Email.";
													$return["success"] = false;
												}
											}
										}
										$return["email"] = $email;
										$return["type"] = $type;
										break;
								}
								break;
							case "update":
								switch ($conj[2]) {
									default:
										$return = array(
											"success" => false,
											"msg" => "Query não encontrado!"
										);
										break;
									case 'nota':
										$a = count($_DATA["titulo"]);
										$b = 0;
										while ($b < $a) {
											if (!empty($_DATA["titulo"])) {
												$tit = $_DATA["titulo"][$b];
												if (!preg_match("/^[áàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑa-zA-Z-' 0-9]*$/", $tit)) {
													$tit = "Títulob";
												}
											} else {
												$tit = "Títuloa";
											}
											if (strlen($tit) > 30) {
												$tit = "Títuloasc";
											}
											$des = cleanstring($_DATA["nota"][$b]);
											$nota = intval($_DATA["id"][$b]);
											$y = $con->prepare("UPDATE `notes` SET `nome` = ?, `notas` = ? WHERE `id`= ? AND `missao` in (SELECT id FROM missoes where token = ? and mestre = ?);");
											$y->bind_param("ssiss", $tit, $des, $nota, $token, $userid);
											$y->execute();
											$b++;
										}
										break;
									case "iniciativa":
										foreach ($_DATA["init"] as $i => $init) {
											$z = $con->prepare("UPDATE iniciativas SET `nome`= ?,`iniciativa`= ?,`prioridade`= ?,`dano`= ? WHERE iniciativas.id = ?");
											$p = $i + 1;
											$z->bind_param("siiii", $init["n"], $init["i"], $init["p"], $init["d"], $init["id"]);
											$z->execute();
										}
										break;
									case 'fichasnpc':
										$nome = cleanstring($_DATA["nome"]);
										$categoria = minmax($_DATA["monstro"], 0, 1);
										$pv = minmax($_DATA["pv"], 0, 999999999);
										$san = minmax($_DATA["san"], 0, 999999999);
										$pe = minmax($_DATA["pe"], 0, 999999999);
										$for = minmax($_DATA["forca"], -10, 10);
										$agi = minmax($_DATA["agilidade"], -10, 10);
										$int = minmax($_DATA["intelecto"], -10, 10);
										$pre = minmax($_DATA["presenca"], -10, 10);
										$vig = minmax($_DATA["vigor"], -10, 10);
										$passiva = minmax($_DATA["passiva"]);
										$esquiva = minmax($_DATA["esquiva"]);
										$morte = minmax($_DATA["morte"]);
										$sangue = minmax($_DATA["sangue"]);
										$energia = minmax($_DATA["energia"]);
										$conhecimento = minmax($_DATA["conhecimento"]);
										$fisica = minmax($_DATA["fisica"]);
										$balistica = minmax($_DATA["balistica"]);
										$mental = minmax($_DATA["mental"]);
										$acro = minmax($_DATA["acrobacia"]);
										$ades = minmax($_DATA["adestramento"]);
										$arte = minmax($_DATA["artes"]);
										$atle = minmax($_DATA["atletismo"]);
										$atua = minmax($_DATA["atualidades"]);
										$cien = minmax($_DATA["ciencia"]);
										$crim = minmax($_DATA["crime"]);
										$dipl = minmax($_DATA["diplomacia"]);
										$enga = minmax($_DATA["enganacao"]);
										$fort = minmax($_DATA["fortitude"]);
										$furt = minmax($_DATA["furtividade"]);
										$inic = minmax($_DATA["iniciativa"]);
										$inti = minmax($_DATA["intimidacao"]);
										$intu = minmax($_DATA["intuicao"]);
										$inve = minmax($_DATA["investigacao"]);
										$luta = minmax($_DATA["luta"]);
										$medi = minmax($_DATA["medicina"]);
										$ocul = minmax($_DATA["ocultismo"]);
										$perc = minmax($_DATA["percepcao"]);
										$pilo = minmax($_DATA["pilotagem"]);
										$pont = minmax($_DATA["pontaria"]);
										$prof = minmax($_DATA["profissao"]);
										$refl = minmax($_DATA["reflexos"]);
										$reli = minmax($_DATA["religiao"]);
										$sobr = minmax($_DATA["sobrevivencia"]);
										$tati = minmax($_DATA["tatica"]);
										$tecn = minmax($_DATA["tecnologia"]);
										$vont = minmax($_DATA["vontade"]);
										$ata = cleanstring($_DATA["ataques"], 5000);
										$habs = cleanstring($_DATA["habilidades"], 5000);
										$dets = cleanstring($_DATA["detalhes"], 5000);
										if (strlen($nome) > 30) {
											$nome = "NPC";
										}
										$fid = (int)$_DATA['efni'];
										$t = $con->prepare("UPDATE `fichas_npc` SET `nome` = ?, `categoria` = ? ,`pv` = ? ,`pva` = ? ,`san` = ? ,`sana` = ? ,`pe` = ? ,`pea` = ? ,`forca` = ? ,`agilidade` = ? ,
                         `inteligencia` = ? ,`presenca` = ? ,`vigor` = ? ,`passiva` = ? ,`esquiva` = ? ,`morte` = ? ,`sangue` = ? ,`energia` = ? ,`conhecimento` = ? ,
                         `balistica` = ? ,`fisica` = ? ,`mental` = ? ,`acrobacia` = ? ,`adestramento` = ? ,`artes` = ? ,`atletismo` = ? ,`atualidade` = ? ,`ciencia` = ? ,`crime` = ? ,
                         `diplomacia` = ? ,`enganacao` = ? ,`fortitude` = ? ,`furtividade` = ? ,`iniciativa` = ? ,`intimidacao` = ? ,`intuicao` = ? ,`investigacao` = ? ,`luta` = ? ,`medicina` = ? ,
                         `ocultismo` = ? ,`percepcao` = ? ,`pilotagem` = ? ,`pontaria` = ? ,`profissao` = ? ,`reflexos` = ? ,`religiao` = ? ,`sobrevivencia` = ? ,`tatica` = ? ,`tecnologia` = ? ,
                         `vontade` = ? , `ataques` = ? ,`habilidades` = ? ,`detalhes` = ? WHERE `id` = ? AND `missao` in (SELECT id FROM missoes WHERE mestre = ? and token = ?) ;");
										$t->bind_param('siiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiisssiis', $nome, $categoria, $pv, $pv, $san, $san, $pe, $pe, $for, $agi, $int, $pre, $vig, $passiva, $esquiva, $morte, $sangue, $energia, $conhecimento, $balistica, $fisica, $mental, $acro, $ades, $arte, $atle, $atua, $cien, $crim, $dipl, $enga, $fort, $furt, $inic, $inti, $intu, $inve, $luta, $medi, $ocul, $perc, $pilo, $pont, $prof, $refl, $reli, $sobr, $tati, $tecn, $vont, $ata, $habs, $dets, $fid, $userid, $token);
										$t->execute();
										break;
								}
								break;
							case "delete":
								switch ($conj[2]) {
									default:
										$return = array(
											"success" => false,
											"msg" => "Query não encontrado!"
										);
										break;
									case 'nota':
										$nid = (int)$_DATA["note"];
										$tvar = $con->prepare("DELETE FROM `notes` WHERE `id` = ? AND `missao` in (SELECT id FROM missoes WHERE token =? AND mestre = ?)");
										$tvar->bind_param("isi", $nid, $token, $userid);
										$tvar->execute();
										break;
									case 'iniciativa':
										$initid = (int)$_DATA["iniciativa_id"];
										$f = $con->prepare("DELETE FROM `iniciativas` WHERE  `id`= ? AND `id_missao` in (SELECT id FROM missoes WHERE token = ? AND mestre = ?);");
										$f->bind_param("isi", $initid, $token, $userid);
										$f->execute();
										break;
									case 'fichanpc':
										$npc = (int)$_DATA["npc"];
										$f = $con->prepare("DELETE FROM `fichas_npc` WHERE `id` = ? AND missao in (SELECT id FROM missoes WHERE mestre = ? AND token = ?)");
										$f->bind_param("iis", $npc, $userid, $token);
										$f->execute();
										break;
									case 'player':
										$p = (int)$_DATA["p"];
										
										$f = $con->prepare("DELETE FROM `ligacoes` WHERE `id_ficha`=? AND `id_missao`in(SELECT id from missoes WHERE missoes.token =? AND mestre = ?);");
										$f->bind_param("isi", $p, $token, $userid);
										$f->execute();
										
										break;
								}
								break;
							case "get":
								switch ($conj[2]) {
									default:
										$return = array(
											"success" => false,
											"msg" => "Query não encontrado!"
										);
										break;
									case 'npc':
										$npc = (int)$_DATA["ficha"];
										
										$ss = $con->prepare('SELECT * FROM fichas_npc WHERE id = ? AND missao in (SELECT id FROM missoes where token = ? AND mestre = ?);');
										$ss->bind_param("isi", $npc, $token, $userid);
										$ss->execute();
										$return = mysqli_fetch_array($ss->get_result());
										break;
								}
								break;
						}
						break;
					case "ficha":
						switch ($conj[1]) {
							default:
								$return = array(
									"success" => false,
									"msg" => "Query não encontrado!"
								);
								break;
							case "update":
								if (VerificarPermissaoFicha($token, $userid)) {
									switch ($conj[2]) {
										default:
											$return = array(
												"success" => false,
												"msg" => "Query não encontrado!"
											);
											break;
										case 'proficiencia':
											if (VerificarPermissaoFicha($token, $userid)) {
												for ($i = 0; $i < count($_DATA['did']); $i++):
													$pro = cleanstring($_DATA["pro"][$i], $Pro_nome);
													$pid = intval($_DATA["did"][$i]);
													$q = $con->prepare("UPDATE `proeficiencias` SET `nome` = ? WHERE `id_ficha` in (SELECT id FROM fichas_personagem WHERE token = ?) AND `id` = ?;");
													$q->bind_param("ssi", $pro, $token, $pid);
													$q->execute();
												endfor;
											} else {
												$return["success"] = false;
												$return["msg"] = "Sem permissão";
											}
											break;
										case "habilidade":
											if (VerificarPermissaoFicha($token, $userid)) {
												$tipo = cleanstring($_DATA["type"], 3);
												$eid = (int)$_DATA["id"];
												$title = cleanstring($_DATA["name"], 200);
												$desc = cleanstring($_DATA["desc"]);
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
												$return["success"] = false;
												$return["msg"] = "Sem permissão";
											}
											break;
										case 'atributos':
											if (VerificarPermissaoFicha($token, $userid)) {
												$forca = minmax($_DATA["forca"], $minimo_atributo, $maximo_atributo);
												$agilidade = minmax($_DATA["agilidade"], $minimo_atributo, $maximo_atributo);
												$intelecto = minmax($_DATA["intelecto"], $minimo_atributo, $maximo_atributo);
												$presenca = minmax($_DATA["presenca"], $minimo_atributo, $maximo_atributo);
												$vigor = minmax($_DATA["vigor"], $minimo_atributo, $maximo_atributo);
												$a = $con->prepare("UPDATE fichas_personagem SET forca =?, agilidade = ?, inteligencia =? , presenca =?, vigor = ? WHERE token = ?");
												$a->bind_param("iiiiis", $forca, $agilidade, $intelecto, $presenca, $vigor, $token);
												$a->execute();
											} else {
												$return["success"] = false;
												$return["msg"] = "Sem permissão";
											}
											break;
										case 'detalhes':
											if (VerificarPermissaoFicha($token, $userid)) {
												$nex = minmax($_DATA["nex"], 0, 100);
												$pp = minmax($_DATA["pp"], 0, 999999999);//pontos de prestigio
												$origem = cleanstring($_DATA["origem"]);
												$trilha = cleanstring($_DATA["trilha"]);
												$classe = cleanstring($_DATA["classe"]);
												$elemento = cleanstring($_DATA["elemento"]);
												$patente = cleanstring($_DATA["patente"]);
												
												$desco = minmax($_DATA["deslocamento"], 0, 50);
												$per = minmax($_DATA["pr"], 0, 127);
												$idade = minmax($_DATA["idade"], 0, 150);
												$local = cleanstring($_DATA["local"], $Fich_loca);
												
												if (Check_Name(cleanstring($_DATA["nome"]))) {
													$nome = cleanstring($_DATA["nome"]);
												}
												
												$rr = $con->prepare("UPDATE `fichas_personagem` SET `nome` = ? , `afinidade` = ? , `nex` = ?, `pe_rodada` = ?, `pp` = ? ,
                               `classe` = ? , `trilha` = ? , `origem` = ? , `patente` = ? , `idade` = ?, `deslocamento` = ? ,
                               `local` = ?
                           WHERE `token` = ?;");
												$rr->bind_param("ssiiissssiiss", $nome, $elemento, $nex, $per, $pp, $classe, $trilha, $origem, $patente, $idade, $desco, $local, $token);
												$rr->execute();
												if ($con->affected_rows) {
													$return["status"] = true;
												} else {
													$return["status"] = false;
												}
											} else {
												$return["success"] = false;
												$return["msg"] = "Sem permissão";
											}
											break;
										case 'pericias':
											
											if (VerificarPermissaoFicha($token, $userid)) {
												$acr = minmax($_DATA["acrobacias"], $minimo_pericia, $maximo_pericia);
												$ade = minmax($_DATA["adestramento"], $minimo_pericia, $maximo_pericia);
												$art = minmax($_DATA["artes"], $minimo_pericia, $maximo_pericia);
												$atl = minmax($_DATA["atletismo"], $minimo_pericia, $maximo_pericia);
												$atu = minmax($_DATA["atualidades"], $minimo_pericia, $maximo_pericia);
												$cie = minmax($_DATA["ciencia"], $minimo_pericia, $maximo_pericia);
												$cri = minmax($_DATA["crime"], $minimo_pericia, $maximo_pericia);
												$dip = minmax($_DATA["diplomacia"], $minimo_pericia, $maximo_pericia);
												$eng = minmax($_DATA["enganacao"], $minimo_pericia, $maximo_pericia);
												$fort = minmax($_DATA["fortitude"], $minimo_pericia, $maximo_pericia);
												$fur = minmax($_DATA["furtividade"], $minimo_pericia, $maximo_pericia);
												$inic = minmax($_DATA["iniciativa"], $minimo_pericia, $maximo_pericia);
												$inti = minmax($_DATA["intimidacao"], $minimo_pericia, $maximo_pericia);
												$intu = minmax($_DATA["intuicao"], $minimo_pericia, $maximo_pericia);
												$inv = minmax($_DATA["investigacao"], $minimo_pericia, $maximo_pericia);
												$lut = minmax($_DATA["luta"], $minimo_pericia, $maximo_pericia);
												$med = minmax($_DATA["medicina"], $minimo_pericia, $maximo_pericia);
												$ocu = minmax($_DATA["ocultismo"], $minimo_pericia, $maximo_pericia);
												$perc = minmax($_DATA["percepcao"], $minimo_pericia, $maximo_pericia);
												$pilo = minmax($_DATA["pilotagem"], $minimo_pericia, $maximo_pericia);
												$pont = minmax($_DATA["pontaria"], $minimo_pericia, $maximo_pericia);
												$prof = minmax($_DATA["profissao"], $minimo_pericia, $maximo_pericia);
												$ref = minmax($_DATA["reflexo"], $minimo_pericia, $maximo_pericia);
												$rel = minmax($_DATA["religiao"], $minimo_pericia, $maximo_pericia);
												$sob = minmax($_DATA["sobrevivencia"], $minimo_pericia, $maximo_pericia);
												$tat = minmax($_DATA["tatica"], $minimo_pericia, $maximo_pericia);
												$tec = minmax($_DATA["tecnologia"], $minimo_pericia, $maximo_pericia);
												$von = minmax($_DATA["vontade"], $minimo_pericia, $maximo_pericia);
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
												$return["success"] = false;
												$return["msg"] = "Sem permissão";
											}
											break;
										case 'ritual':
											
											if (VerificarPermissaoFicha($token, $userid)) {
												$did = (int)$_DATA["did"];
												$foto = cleanstring($_DATA["simbolourl"], $Fich_fotos);
												$ritual = cleanstring($_DATA["ritual"], $Ritu_nome);
												$cir = cleanstring($_DATA["circulo"], $Ritu_circ);
												$conj = cleanstring($_DATA["conjuracao"], $Ritu_conj);
												$ele = cleanstring($_DATA["elemento"], $Ritu_elem);
												$efe = cleanstring($_DATA["efeito"], $Ritu_efei);
												$dur = cleanstring($_DATA["duracao"], $Ritu_dura);
												$alc = cleanstring($_DATA["alcance"], $Ritu_alca);
												$res = cleanstring($_DATA["resistencia"], $Ritu_resi);
												$alvo = cleanstring($_DATA["alvo"], $Ritu_alvo);
												$d1 = cleanstring($_DATA["dano1"], $Ritu_dan);
												$d2 = cleanstring($_DATA["dano2"], $Ritu_dan);
												$d3 = cleanstring($_DATA["dano3"], $Ritu_dan);
												$rr = $con->prepare("UPDATE `rituais` SET `nome` = ?, `foto` = ? , `circulo` = ? , `conjuracao` = ? , `efeito` = ? , `elemento` = ? , `duracao` = ? , `alcance` = ?, `resistencia` = ? , `alvo` = ?, `dano` = ? ,`dano2` = ?, `dano3` = ? WHERE `id_ficha`  in (SELECT id FROM fichas_personagem WHERE token = ?) AND `id` = ? ;");
												$rr->bind_param("ssssssssssssssi", $ritual, $foto, $cir, $conj, $efe, $ele, $dur, $alc, $res, $alvo, $d1, $d2, $d3, $token, $did);
												$rr->execute();
											} else {
												$return["success"] = false;
												$return["msg"] = "Sem permissão";
											}
											break;
										case 'status':
											if (VerificarPermissaoFicha($token, $userid)) {
												$ra = $con->prepare("SELECT * FROM fichas_personagem WHERE token = ?");
												$ra->bind_param("s", $token);
												$ra->execute();
												$rqs = mysqli_fetch_array($ra->get_result());
												$pva = $rqs["pva"];
												$sana = $rqs["sana"];
												$pea = $rqs["pea"];
												$nex = $rqs["nex"];
												$balas = minmax((int)$_DATA["balas"], 0, 30);
												
												if ($rqs["nex"] == 99) {
													$nex = 100;
												}
												//Saúde
												
												if (isset($_DATA["pv"])) {
													$pv = minmax((int)$_DATA["pv"], $minimo_PV, $maximo_PV);
												} else {
													$bpv = minmax((int)$_DATA["bpv"], -10, 10);
													$spv = minmax((int)$_DATA["skippedpv"], 0, 20);
													$ppv = minmax((int)$_DATA["somapv"], -999, 999);
													$pv = minmax(calcularvida($nex, $rqs["classe"], $rqs["vigor"], $rqs["trilha"], $rqs["origem"], $bpv, $spv, $ppv), $minimo_PV, $maximo_PV);
													if ($rqs["pva"] < ($pv + $maximo_PVA)) {
														$pva = $pv;
													}
													$f = $con->prepare("UPDATE fichas_personagem SET bpv = ?, skippedpv = ?, somapv =? WHERE token =?");
													$f->bind_param("iiis", $bpv, $spv, $ppv, $token);
													$f->execute();
													unset($f);
												}
												if (isset($_DATA["pe"])) {
													$pe = minmax((int)$_DATA["pe"], $minimo_PE, $maximo_PE);
												} else {
													$bpe = minmax((int)$_DATA["bpe"], -10, 10);
													$spe = minmax((int)$_DATA["skippedpe"], 0, 20);
													$ppe = minmax((int)$_DATA["somape"], -999, 999);
													$pe = minmax(calcularpe($nex, $rqs["classe"], $rqs["presenca"], $rqs["trilha"], $rqs["origem"], $bpe, $spe, $ppe), $minimo_PE, $maximo_PE);
													if ($rqs["pea"] < ($pe + $maximo_PEA)) {
														$pea = $pe;
													}
													$f = $con->prepare("UPDATE fichas_personagem SET bpe = ?, skippedpe = ?, somape =? WHERE token =?");
													$f->bind_param("iiis", $bpe, $spe, $ppe, $token);
													$f->execute();
													unset($f);
												}
												if (isset($_DATA["san"])) {
													$san = minmax((int)$_DATA["san"], $minimo_SAN, $maximo_SAN);
												} else {
													$bsan = minmax((int)$_DATA["bsan"], -10, 10);
													$ssan = minmax((int)$_DATA["skippedsan"], 0, 20);
													$psan = minmax((int)$_DATA["somasan"], -999, 999);
													
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
												$pa = minmax((int)$_DATA["passiva"]);
												$es = minmax((int)$_DATA["esquiva"]);
												$bl = minmax((int)$_DATA["bloqueio"]);
												//Resistencias
												$fisi = minmax((int)$_DATA["fisica"], $minimo_resistencia, $maximo_resistencia);
												$bali = minmax((int)$_DATA["balistica"], $minimo_resistencia, $maximo_resistencia);
												$fogo = minmax((int)$_DATA["fogo"], $minimo_resistencia, $maximo_resistencia);
												
												
												$mort = minmax((int)$_DATA["morte"], $minimo_resistencia, $maximo_resistencia);
												$sang = minmax((int)$_DATA["sangue"], $minimo_resistencia, $maximo_resistencia);
												$conh = minmax((int)$_DATA["conhecimento"], $minimo_resistencia, $maximo_resistencia);
												$ener = minmax((int)$_DATA["energia"], $minimo_resistencia, $maximo_resistencia);
												$ment = minmax((int)$_DATA["mental"], $minimo_resistencia, $maximo_resistencia);
												
												
												$cort = minmax((int)$_DATA["corte"], $minimo_resistencia, $maximo_resistencia);
												$impa = minmax((int)$_DATA["impacto"], $minimo_resistencia, $maximo_resistencia);
												$elet = minmax((int)$_DATA["eletricidade"], $minimo_resistencia, $maximo_resistencia);
												$frio = minmax((int)$_DATA["frio"], $minimo_resistencia, $maximo_resistencia);
												$perf = minmax((int)$_DATA["perfuracao"], $minimo_resistencia, $maximo_resistencia);
												$quim = minmax((int)$_DATA["quimico"], $minimo_resistencia, $maximo_resistencia);
												
												$b = $con->prepare("UPDATE `fichas_personagem` SET `balas` = ?,
                               `passiva`= ?, `esquiva` = ?, bloqueio = ?,`mental` = ?,`fisica`= ?,`balistica` = ?,
                               `fogo`= ?,`morte`= ?, `sangue` = ?,`conhecimento`= ?,`energia` = ?,
                               `perfuracao` = ?,`eletricidade`= ?, `frio` = ?,`impacto` = ?,`corte` = ?,
                               `pea` = ?, `pe` = ?,`san` = ?, `sana` = ?, `quimico` = ?, `pv` = ?, `pva` = ?
                          		WHERE `id`  in (SELECT id FROM fichas_personagem WHERE token = ?);");
												$b->bind_param("iiiiiiiiiiiiiiiiiiiiiiiis", $balas, $pa, $es, $bl, $ment, $fisi, $bali, $fogo, $mort, $sang, $conh, $ener, $perf, $elet, $frio, $impa, $cort, $pea, $pe, $san, $sana, $quim, $pv, $pva, $token);
												$return["success"] = $b->execute();
												
											} else {
												$return["success"] = false;
												$return["msg"] = "Sem permissão";
											}
											
											break;
										case 'itemquantidade':
											if (VerificarPermissaoFicha($token, $userid)) {
												
												$a = cleanstring($_DATA["action"]);
												$i = (int)$_DATA["item"];
												if ($a === "plus") {
													$f = $con->prepare("UPDATE inventario SET `quantidade` = quantidade + 1 WHERE id_ficha in (SELECT id from fichas_personagem WHERE token = ?) and id =? and quantidade < 30");
												} else {
													$f = $con->prepare("UPDATE inventario SET `quantidade` = quantidade - 1 WHERE id_ficha in (SELECT id from fichas_personagem WHERE token = ?) and id =? and quantidade > 0");
												}
												$f->bind_param("si", $token, $i);
												$f->execute();
											} else {
												$return["success"] = false;
												$return["msg"] = "Sem Permissão";
											}
											break;
										case 'item':
											if (VerificarPermissaoFicha($token, $userid)) {
												$iid = (int)$_DATA["did"];
												$nome = cleanstring($_DATA["nome"], $limite_nome_inv);
												$desc = cleanstring($_DATA["descricao"], $Inv_desc);
												$peso = minmax($_DATA["peso"], $minimo_peso, $maximo_peso, $inv_float);
												$pres = minmax($_DATA["prestigio"], 0, 10);
												$rr = $con->prepare("UPDATE `inventario` SET `nome` = ? , `descricao` = ?, `espaco` = ?, `prestigio` = ? WHERE `inventario`.`id` = ? AND `id_ficha` in (SELECT id FROM fichas_personagem WHERE token = ?);");
												$rr->bind_param("ssdiis", $nome, $desc, $peso, $pres, $iid, $token);
												$return["success"] = $rr->execute();
											} else {
												$return["success"] = false;
												$return["msg"] = "Sem permissão";
											}
											break;
										case 'arma':
											if (VerificarPermissaoFicha($token, $userid)) {
												$aid = (int)$_DATA["did"];
												$n = cleanstring($_DATA["nome"], $limite_nome_inv);
												$f = cleanstring($_DATA["foto"], 300);
												$t = cleanstring($_DATA["tipo"], $Arma_tipo);
												$at = cleanstring($_DATA["ataque"], $Arma_ataq);
												$al = cleanstring($_DATA["alcance"], $Arma_alca);
												$d = cleanstring($_DATA["dano"], $Arma_dano);
												$c = cleanstring($_DATA["critico"], $Arma_crit);
												$m = minmax($_DATA["margem"], 1, 20);
												$r = cleanstring($_DATA["recarga"], $Arma_reca);
												$e = cleanstring($_DATA["especial"], $Arma_espe);
												$rr = $con->prepare("UPDATE `armas` SET `arma` = ?, `foto` = ? , `tipo` = ?, `ataque` = ?, `alcance` = ?, `dano` = ?, `critico` = ?, `margem` = ?, `recarga` = ?, `especial` = ? WHERE `armas`.`id` = ? AND `id_ficha` in (SELECT id FROM fichas_personagem WHERE token = ?);");
												$rr->bind_param("sssssssissis", $n, $f, $t, $at, $al, $d, $c, $m, $r, $e, $aid, $token);
												$return["success"] = $rr->execute();
											} else {
												$return["success"] = false;
												$return["msg"] = "Sem permissão";
											}
											break;
										case 'foto':
											if (VerificarPermissaoFicha($token, $userid)) {
												if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp|gif)$/', cleanstring($_DATA["fotourl"]))) {
													$urlphoto = cleanstring($_DATA["fotourl"], $Fich_fotos);
													if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp|gif)$/', cleanstring($_DATA["fotomor"]))) {
														$fotomor = cleanstring($_DATA["fotomor"], $Fich_fotos);
													} else {
														$fotomor = $urlphoto;
													}
													if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp|gif)$/', cleanstring($_DATA["fotofer"]))) {
														$fotofer = cleanstring($_DATA["fotofer"], $Fich_fotos);
													} else {
														$fotofer = $urlphoto;
													}
													if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp|gif)$/', cleanstring($_DATA["fotoenl"]))) {
														$fotoenl = cleanstring($_DATA["fotoenl"], $Fich_fotos);
													} else {
														$fotoenl = $urlphoto;
													}
													if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp|gif)$/', cleanstring($_DATA["fotoef"]))) {
														$fotoef = cleanstring($_DATA["fotoef"], $Fich_fotos);
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
												$return["success"] = false;
												$return["msg"] = "Sem permissão";
											}
											break;
										case 'peso':
											if (VerificarPermissaoFicha($token, $userid)) {
												$did = minmax($_DATA["peso"], 1);
												$y = $con->prepare("UPDATE fichas_personagem SET peso_inv = ? WHERE id in (SELECT id FROM fichas_personagem WHERE token = ?);");
												$y->bind_param("is", $did, $token);
												$y->execute();
											} else {
												$return["success"] = false;
												$return["msg"] = "Sem permissão";
											}
											break;
									}
								}
								break;
							case "delete":
								if (VerificarPermissaoFicha($token, $userid)) {
									switch ($conj[2]) {
										default:
											$return = array(
												"success" => false,
												"msg" => "Query não encontrado!"
											);
											break;
										case "switch":
											$type = cleanstring($_DATA["type"]);
											$iid = (int)$_DATA["iid"];
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
											break;
									}
								} else {
									$return["success"] = false;
									$return["msg"] = "Sem permissão";
								}
								break;
							case "add":
								switch ($conj[2]) {
									default:
										$return = array(
											"success" => false,
											"msg" => "Query não encontrado!"
										);
										break;
									case 'habilidade':
										if (VerificarPermissaoFicha($token, $userid)) {
											$habname = cleanstring($_DATA["hab"], $Hab_nome);
											$habdesc = cleanstring($_DATA["desc"], $Hab_desc);
											if (isset($_DATA["poder"]) && ($_DATA["poder"] == 1 || $_DATA["poder"] == "on")) {
												$a = $con->prepare("INSERT INTO `poderes` (`id_ficha`, `nome`, `descricao`) VALUES ( (SELECT id FROM fichas_personagem WHERE token = ? ), ? , ? );");
											} else {
												$a = $con->prepare("INSERT INTO `habilidades` (`id_ficha`, `nome`, `descricao`) VALUES ( (SELECT id FROM fichas_personagem WHERE token = ? ) , ? , ? );");
											}
											$a->bind_param("sss", $token, $habname, $habdesc);
											$a->execute();
										} else {
											$return["success"] = false;
											$return["msg"] = "Sem permissão";
										}
										break;
									case 'proficiencia':
										if (VerificarPermissaoFicha($token, $userid)) {
											$pronome = cleanstring($_DATA["pro"], $Pro_nome);
											$t = $con->prepare("INSERT INTO `proeficiencias`(`id_ficha`,`nome`) VALUES ((SELECT id FROM fichas_personagem WHERE token = ?),?);");
											$t->bind_param("ss", $token, $pronome);
											$t->execute();
										} else {
											$return["success"] = false;
											$return["msg"] = "Sem permissão";
										}
										break;
									case 'ritual':
										$foto = cleanstring($_DATA["simbolourl"]);
										
										$ritual = cleanstring($_DATA["ritual"], $Ritu_nome);
										$cir = cleanstring($_DATA["circulo"], $Ritu_circ);
										$conj = cleanstring($_DATA["conjuracao"], $Ritu_conj);
										$ele = cleanstring($_DATA["elemento"], $Ritu_elem);
										$efe = cleanstring($_DATA["efeito"], $Ritu_efei);
										$dur = cleanstring($_DATA["duracao"], $Ritu_dura);
										$alc = cleanstring($_DATA["alcance"], $Ritu_alca);
										$alv = cleanstring($_DATA["alvo"], $Ritu_alvo);
										$res = cleanstring($_DATA["resistencia"], $Ritu_resi);
										$d1 = cleanstring($_DATA["dano1"], $Ritu_dan);
										$d2 = cleanstring($_DATA["dano2"], $Ritu_dan);
										$d3 = cleanstring($_DATA["dano3"], $Ritu_dan);
										$rr = $con->prepare("INSERT INTO `rituais`( `id_ficha`,`foto`,`nome`,`circulo`, `conjuracao`,`efeito`,`elemento`,`duracao`,`alcance`, `resistencia`, `alvo`,`dano`,`dano2`,`dano3`) VALUES ( (SELECT id FROM fichas_personagem WHERE token = ?) ,? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ?)");
										$rr->bind_param("ssssssssssssss", $token, $foto, $ritual, $cir, $conj, $efe, $ele, $dur, $alc, $res, $alv, $d1, $d2, $d3);
										$rr->execute();
										break;
									case 'item':
										$nome = cleanstring($_DATA["nome"], $limite_nome_inv);
										$desc = cleanstring($_DATA["descricao"], $Inv_desc);
										$peso = minmax($_DATA["peso"], $minimo_peso, $maximo_peso, $inv_float);
										$quantidade = minmax($_DATA["quantidade"], 0, $maximo_peso);
										$pres = minmax($_DATA["prestigio"], 0, 10);
										$rr = $con->prepare("INSERT INTO `inventario`(`id_ficha`,`nome`,`descricao`,`espaco`,`prestigio`,`quantidade`) VALUES ( (SELECT id FROM fichas_personagem WHERE token = ?) , ? , ? , ? , ?, ?)");
										$rr->bind_param("sssiii", $token, $nome, $desc, $peso, $pres, $quantidade);
										$rr->execute();
										break;
									case 'arma':
										$n = cleanstring($_DATA["nome"], $limite_nome_inv);
										$t = cleanstring($_DATA["tipo"], $Arma_tipo);
										$at = cleanstring($_DATA["ataque"], $Arma_crit);
										$al = cleanstring($_DATA["alcance"], $Arma_alca);
										$d = cleanstring($_DATA["dano"], $Arma_dano);
										$c = cleanstring($_DATA["critico"], $Arma_crit);
										$m = minmax($_DATA["margem"], 1, 20);
										$r = cleanstring($_DATA["recarga"], $Arma_reca);
										$e = cleanstring($_DATA["especial"], $Arma_espe);
										$desc = cleanstring($_DATA["desc"], $Inv_desc);
										$foto = cleanstring($_DATA["foto"], $Inv_desc);
										$peso = minmax($_DATA["peso"], $minimo_peso, $maximo_peso, $inv_float);
										$pres = minmax($_DATA["prestigio"], 0, 10);//Categorias
										$rr = $con->prepare("INSERT INTO `armas`(`id_ficha`,`foto`,`arma`,`tipo`,`ataque`,`alcance`,`dano`,`critico`, `margem`,`recarga`,`especial`) VALUES ((SELECT id FROM fichas_personagem WHERE token = ?), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
										$rr->bind_param("ssssssssiss", $token, $foto, $n, $t, $at, $al, $d, $c, $m, $r, $e);
										$rr->execute();
										if ($_DATA["invtoo"] === 'on' || $_DATA["invtoo"] === true) {
											$p = $con->prepare("INSERT INTO `inventario`(`id_ficha`,`nome`,`descricao`,`prestigio`,`espaco`,`id`) VALUES ((SELECT id FROM fichas_personagem WHERE token = ? ), ?, ?, ?, ?, '');");
											$p->bind_param("sssid", $token, $n, $desc, $pres, $peso);
											$p->execute();
										}
										if ($con->affected_rows) {
											$return["msg"] = "Sucesso ao adicionar itens";
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
	case "test":
		//asdasdasd
		
		break;
}


$token = cleanstring($_GET["token"] ?: $_DATA["token"]);
$conj = explode("_", cleanstring($_DATA["query"]));

//NEW API END//


if (isset($_QUERY)) {
	switch ($_QUERY) {
		default:goto notFound;
		case 'set_marca':
			$sid = cleanstring($_DATA["sessid"] ?: session_id());
			preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp)$/', cleanstring($_DATA["urlmarca"]), $marca);
			if ($marca) {
				$marca = cleanstring($_DATA["urlmarca"]);
				$q = $con->prepare("SELECT * FROM `usuarios` WHERE `id` in (SELECT user from auth WHERE token = ?);");
				$q->bind_param("s", $sid);
				$q->execute();
				$q = $q->get_result();
				if ($q->num_rows) {
					$rq = mysqli_fetch_array($q);
					if ($marca != $rq["marca"]) {
						$a = $con->prepare("UPDATE `usuarios` SET `marca` = ? WHERE `id` in (SELECT user from auth WHERE token = ?);");
						$a->bind_param("si", $marca, $sid);
						$a->execute();
						$return["success"] = (bool)$con->affected_rows;
						if ($return["success"]) {
							$_SESSION["UserMarca"] = cleanstring($_DATA["urlmarca"]);
							$return["msg"] = "Marca alterada com Sucesso";
						}
					}
				} else {
					$return["success"] = true;
					$return["msg"] = "Sua marca é igual a anterior, nada alterado.";
				}
				$return["msg"] = $return["msg"];
			} else {
				$return["success"] = false;
				$return["msg"] = "O link não é válido...";
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
				
				$u = $con->prepare("SELECT * FROM `usuarios` WHERE `id`  in (SELECT id FROM usuarios WHERE `login` = ?);;");
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
					$return["ficha"] = $ficha;
				} else {
					$return["success"] = false;
					$return["msg"] = "Ficha não encontrada...";
				}
			} else {
				$return["success"] = false;
				$return["msg"] = "Sua sessão encerrou.";
			}
			break; // APP / OBSOLETO
		
		
		
		case 'get_fichas':
			$sid = cleanstring($_DATA["sessid"] ?: session_id());
			if (check_session($sid)) {
				$user = check_session($sid);
				$a = $con->prepare("SELECT * FROM `fichas_personagem` WHERE `usuario` in (SELECT id FROM usuarios WHERE `login` = ?);");
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
					unset($output[$i]["id"], $output[$i]["usuario"],);
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
				$return["fichas"] = $output;
				if (!$a->num_rows) {
					$return["success"] = false;
					$return["msg"] = "Nenhuma ficha encontrada.";
				}
			} else {
				$return["success"] = false;
				$return["msg"] = "Sua sessão encerrou.";
			}
			break; // APP
		
		case 'update_ficha':
			$token = cleanstring($_DATA["token"]);
			$sid = cleanstring($_DATA["sessid"] ?: session_id());
			$return["POST"] = $_DATA;
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
						$return["success"] = true;
						
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
				$return["msg"] = 'Sua conta não está mais ativa.';
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
				$return["dado"] = RolarMkII($dado, $dano, $margem);
			} else {
				$return["success"] = false;
				$return["msg"] = ClearRolar($dado, true);
			}
			break; // APP
		case "create_ficha":
			$sid = cleanstring($_DATA["sessid"]);
			if (check_session($sid)) {
				$user = check_session($sid);
				if (!empty($_DATA["nome"])) {
					$nome = cleanstring($_DATA["nome"]);
					if (!preg_match('/^[a-zA-Z áéíóúãõàèìòùÁÉÍÓÚÃÕÀÈÌÒÙçÇ]*$/', $nome)) {
						$return["msg"] = "Apenas Letras e Espaços são permitidos no nome!";
						$return["success"] = false;
					}
				} else {
					$return["success"] = false;
					$return["msg"] = "Preencha o nome do seu personagem!";
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
				if ($return["success"]) {
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
						$return["success"] = $qp->execute();
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
						$return["msg"] = $return["success"] ? "Personagem Criado com sucesso!" : "Houve uma falha ao adicionar personagem na database, contate um administrador!";
					} else {
						$return["success"] = false;
						$return["msg"] = 'Já Existe um Personagem seu com esse mesmo nome!(Provavelmente houve duplicação ao salvar, então só ir para pagina do seu personagem.)';
					}
				}
			} else {
				$return["success"] = false;
				$return["msg"] = "Sua sessão, faça login novamente.";
			}
			break; //APP
		
		case "account_create":
		case 'create_account':
			break; //APP
		case 'login':
			break; // APP
		
		case "account_recovery":
		case 'recovery_account':
			break; // Não usado
		case "account_get":
		case "account_login":
		case 'account_check':
		case 'check_session':
		case 'get_account':
		case 'checksession':
			break;
		case 'deslogar':
			break; // APP
	}
} else {
	notFound:
	$return["success"] = false;
	$return["msg"] = "Nenhuma query encontrada.";
}
$return["return"] = $_DATA;
echo json_encode($return, JSON_PRETTY_PRINT);
//http_response_code($return["success"]?200:404);