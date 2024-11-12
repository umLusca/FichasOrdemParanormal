<?php

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
                                      Continue e crie sua conta junto da components clicando abaixo.
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
