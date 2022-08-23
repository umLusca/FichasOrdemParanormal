<?php

use League\OAuth2\Client\Provider\Google;
use PHPMailer\PHPMailer\OAuth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


if (isset($_POST["status"])) {
    $success = true;
    $msg = '';
    switch ($_POST["status"]) {
	    case 'updtini':
		    $data = [];
		    $c = 0;
		    while ($c != count($_POST["id"])) {
			    $nome = $_POST['nome'][$c];
			    $idi = intval($_POST['id'][$c]);
			    $prioridade = intval($_POST['prioridade'][$c]);
			    $iniciativa = minmax($_POST['iniciativa'][$c], -50, 50);
			    $dano = minmax($_POST['dano'][$c], -999, 999);

			    $z = $con->prepare("UPDATE iniciativas SET `nome`= ?,`iniciativa`= ?,`prioridade`= ?,`dano`= ? WHERE iniciativas.id = ?");
			    $z->bind_param("siiii", $nome, $iniciativa, $prioridade, $dano, $idi);
			    $z->execute();
			    $c++;
		    }
		    $data["missao"] = $id;
		    $data["count"] = count($_POST["iniciativa"]);
		    $data["post"] = $_POST;
		    break;
	    case 'addplayer':
		    $type = 1;
		    $success = true;


		    if (!empty($_POST["email"])) {
			    $email = cleanstring($_POST["email"]);
			    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				    $msg = "Email inserido não é valido.";
				    $success = false;
			    }
		    } else {
			    $success = false;
			    $msg = "Preencha o campo de email!";
		    }


		    if ($success) {
			    $z = $con->prepare("SELECT * FROM `usuarios` WHERE `email`= ? ;"); // verifica se a conta existe
			    $z->bind_param("s", $email);
			    $z->execute();
				$rz = $z->get_result();
			    if ($rz->num_rows) { //Conta EXISTE!
				    $a = mysqli_fetch_array($rz);
				    if (!$qa->num_rows) { // Não EXISTE convite PEDENTE.
					    $aq = $con->query("INSERT INTO `ligacoes`(`id_missao`,`id_usuario`) VALUES ('" . $id . "','" . $a["id"] . "') ");
					    if ($aq) { // CONVITE CRIADO
							if($a["status"]) {
								$msg = "Jogador convidado! (Conta Existente)";
							}else {
								$msg = "Jogador convidado! (Conta Inexistente)";
							}
					    } else { // JÀ EXISTE CONVITE
						    $success = false;
						    $msg = "Falha ao convidar! (Erro na Database)";
					    }
				    } else {
					    $msg = "Jogador convidado! (Conta Existente)";
				    }
			    } else { // CONTA Não EXISTE
				    $aq = $con->query("INSERT INTO `usuarios` (`status`, `email`) VALUES ( 0 , '$email' );"); // cria conta
				    $qa = $con->query("INSERT INTO `ligacoes`(`id_missao`,`id_usuario`,`id_ficha`) VALUES ('" . $id . "','" . $con->insert_id . "',NULL);"); //cria ligações
				    if ($aq) {
					    $msg = "Jogador convidado! (Conta Inexistente)";
				    } else {
					    $success = false;
					    $msg = "Falha ao convidar! (Erro na Database)";
				    }
				    $type = 2;
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

				    $mail = new PHPMailer();
				    $mail->FromName = $fromname;
				    $mail->Subject = $subject;
				    $mail->addAddress($email);
				    $mail->Body = $emailmsg;
				    $mail->SMTPDebug = SMTP::DEBUG_OFF;
				    $mail->Host = 'smtp.gmail.com';
				    $mail->Port = 465;
				    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
				    $mail->SMTPAuth = true;
				    $mail->IsHTML(true);
				    $mail->isSMTP();
				    $mail->AuthType = 'XOAUTH2';
				    $provider = new Google([
					    'clientId' => sscid,
					    'clientSecret' => sscsid,
				    ]);
				    $mail->setOAuth(
					    new OAuth(
						    [
							    'provider' => $provider,
							    'clientId' => sscid,
							    'clientSecret' => sscsid,
							    'refreshToken' => sscrt,
							    'userName' => sscmail,
						    ]
					    )
				    );

				    ($success && !$mail->send()) ? $msg .= ' (Email enviado com sucesso.)' : $msg .= '(Email não enviado.)';


			    }
		    }
            $data["msg"] = $msg;
            $data["success"] = $success;
            $data["email"] = $email;
            $data["type"] = $type;
            echo json_encode($data);
            exit;
            break;
        case 'criariniciativa':
            $con->query("INSERT INTO `iniciativas` (`id_missao`) VALUES ('$id');");
            break;
        case 'deleteini':
            $con->query("DELETE FROM `iniciativas` WHERE `id_missao`='" . $id . "' AND `id`='" . intval($_POST["iniciativa_id"]) . "';");
            break;
        case 'upv':
            $ficha_id = intval($_POST["ficha"]);
            $sq = $con->query("Select * From `fichas_npc` where `missao` = '$id' AND `id` = '$ficha_id';");
            $rs = mysqli_fetch_array($sq);
            $pva = $rs["pva"] + intval($_POST["value"]);
            $ppva = $rs["pv"] + 20;
            if ($pva >= $ppva) {
                $pva = intval($rs["pv"] + 20);
            } elseif ($pva <= 0) {
                $pva = 0;
            }
            $con->query("UPDATE `fichas_npc` SET `pva` = '" . $pva . "' WHERE `missao` = " . $id . " AND `id` = '" . $ficha_id . "';");
            if ($con->affected_rows) {
                $msg = "Vida alterada!";
            } else {
                $success = false;
                $msg = "Vida NÃO alterada!";
            }
            break;
        case 'usan':
            $ficha_id = intval($_POST["ficha"]);
            $sq = $con->query("Select * From `fichas_npc` where `missao` = '$id' AND `id` = '$ficha_id';");
            $rs = mysqli_fetch_array($sq);
            $sana = $rs["sana"] + intval($_POST["value"]);
            $psana = $rs["san"] + 20;
            if ($sana >= $psana) {
                $sana = intval($rs["san"] + 20);
            } elseif ($sana <= 0) {
                $sana = 0;
            }
            $con->query("UPDATE `fichas_npc` SET `sana` = '" . $sana . "' WHERE `missao` = " . $id . " AND `id` = '" . $ficha_id . "';");
            if ($con->affected_rows) {
                $msg = "Sanidade alterada!";
            } else {
                $success = false;
                $msg = "Sanidade NÃO alterada!";
            }
            break;
        case 'upe':
            $ficha_id = intval($_POST["ficha"]);
            $sq = $con->query("Select * From `fichas_npc` where `missao` = '$id' AND `id` = '$ficha_id';");
            $rs = mysqli_fetch_array($sq);
            $pe = $rs["pe"];
            $pea = $rs["pea"] + intval($_POST["value"]);
            $pea = ($pea>$pe)?$pe:(($pea<0)?0:$pea);
            if($pea>$pe){
                $pea=$pe;
            }
            $con->query("UPDATE `fichas_npc` SET `pea` = '" . $pea . "' WHERE `missao` = " . $id . " AND `id` = '" . $ficha_id . "';");
            break;
        case 'pe':
            $npc = intval($_POST["npc"]);
            $sq = $con->query("Select `pe` From `fichas_npc` where `id` = '$npc' AND `missao`='$id';");
            $rs = mysqli_fetch_array($sq);
            $pea = $rs["pe"] - intval($_POST["value"]);
            $con->query("Update `fichas_npc` SET `pea` = '$pea' WHERE `id`='$npc' AND `missao`='$id';");
            break;
        case 'deletenpc':
            $npc = intval($_POST["npc"]);
            $con->query("DELETE FROM `fichas_npc` WHERE `missao` = '$id' AND `id` = '$npc';");
            break;
        case 'addnpc':
            $nome = cleanstring($_POST["nome"]);
            $pv = minmax($_POST["pv"], 1, 999);
            $categoria = minmax($_POST["monstro"], 0, 1);
            $san = minmax($_POST["san"], 0, 999);
            $pe = minmax($_POST["pe"], 0, 999);
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
            $ataq = cleanstring($_POST["ataques"],5000);
            $habs = cleanstring($_POST["habilidades"],5000);
            $deta = cleanstring($_POST["detalhes"],5000);
            if (strlen($nome) > 30) {
                $nome = "NPC";
            }
            $t = $con->prepare("INSERT INTO `fichas_npc`(`missao`,`nome`,`categoria`,`pv`,`pva`,`san`,`sana`,`pe`,`pea`,`forca`,`agilidade`,
                         `inteligencia`,`presenca`,`vigor`,`passiva`,`esquiva`,`morte`,`sangue`,`energia`,`conhecimento`,
                         `balistica`,`fisica`,`mental`,`acrobacia`,`adestramento`,`artes`,`atletismo`,`atualidade`,`ciencia`,`crime`,
                         `diplomacia`,`enganacao`,`fortitude`,`furtividade`,`iniciativa`,`intimidacao`,`intuicao`,`investigacao`,`luta`,`medicina`,
                         `ocultismo`,`percepcao`,`pilotagem`,`pontaria`,`profissao`,`reflexos`,`religiao`,`sobrevivencia`,`tatica`,`tecnologia`,
                         `vontade`,`ataques`,`habilidades`,`detalhes`) VALUES 
                        ( ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? )");
            $t->bind_param('isiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiisss',$id,$nome,$categoria,$pv,$pv,$san,$san,$pe,$pe,$for,$agi,$int,$pre,$vig,$passiva,$esquiva,$morte,$sangue,$energia,$conhecimento,$balistica,$fisica,$mental,$acro,$ades,$arte,$atle,$atua,$cien,$crim,$dipl,$enga,$fort,$furt,$inic,$inti,$intu,$inve,$luta,$medi,$ocul,$perc,$pilo,$pont,$prof,$refl,$reli,$sobr,$tati,$tecn,$vont,$ataq,$habs,$deta);
            $t->execute();
            break;
        case 'editnpc':
            $nome = cleanstring($_POST["nome"]);
	        $categoria = minmax($_POST["monstro"], 0, 1);
            $pv = minmax($_POST["pv"], 0, 999);
            $san = minmax($_POST["san"], 0, 999);
            $pe = minmax($_POST["pe"], 0, 999);
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
            $ata = cleanstring($_POST["ataques"],5000);
            $habs = cleanstring($_POST["habilidades"],5000);
            $dets = cleanstring($_POST["detalhes"],5000);
            if (strlen($nome) > 30) {
                $nome = "NPC";
            }
            $fid = intval($_POST['efni']);
            $t = $con->prepare("UPDATE `fichas_npc` SET `nome` = ?, `categoria` = ? ,`pv` = ? ,`pva` = ? ,`san` = ? ,`sana` = ? ,`pe` = ? ,`pea` = ? ,`forca` = ? ,`agilidade` = ? ,
                         `inteligencia` = ? ,`presenca` = ? ,`vigor` = ? ,`passiva` = ? ,`esquiva` = ? ,`morte` = ? ,`sangue` = ? ,`energia` = ? ,`conhecimento` = ? ,
                         `balistica` = ? ,`fisica` = ? ,`mental` = ? ,`acrobacia` = ? ,`adestramento` = ? ,`artes` = ? ,`atletismo` = ? ,`atualidade` = ? ,`ciencia` = ? ,`crime` = ? ,
                         `diplomacia` = ? ,`enganacao` = ? ,`fortitude` = ? ,`furtividade` = ? ,`iniciativa` = ? ,`intimidacao` = ? ,`intuicao` = ? ,`investigacao` = ? ,`luta` = ? ,`medicina` = ? ,
                         `ocultismo` = ? ,`percepcao` = ? ,`pilotagem` = ? ,`pontaria` = ? ,`profissao` = ? ,`reflexos` = ? ,`religiao` = ? ,`sobrevivencia` = ? ,`tatica` = ? ,`tecnologia` = ? ,
                         `vontade` = ? , `ataques` = ? ,`habilidades` = ? ,`detalhes` = ? WHERE `id` = ? AND `missao` = ? ;");
            $t->bind_param('siiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiisssii',$nome,$categoria,$pv,$pv,$san,$san,$pe,$pe,$for,$agi,$int,$pre,$vig,$passiva,$esquiva,$morte,$sangue,$energia,$conhecimento,$balistica,$fisica,$mental,$acro,$ades,$arte,$atle,$atua,$cien,$crim,$dipl,$enga,$fort,$furt,$inic,$inti,$intu,$inve,$luta,$medi,$ocul,$perc,$pilo,$pont,$prof,$refl,$reli,$sobr,$tati,$tecn,$vont,$ata,$habs,$dets,$fid,$id);
            $t->execute();
            break;
        case 'syncnotes':
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
                $y = $con->query("UPDATE `notes` SET `nome` = '$tit', `notas` = '$des' WHERE `missao` = '$id' AND `id`='$nota';");
                $b++;
            }
            break;
        case 'addnote':
            $y = $con->query("INSERT INTO `notes`(`id`,`nome`,`notas`,`missao`) VALUES ('','Título','È Recomendado usar notas externas!','$id');");
            break;
        case 'addd':
            $nome = cleanstring($_POST["nome"]);
            $dado = cleanstring($_POST["dado"]);
            $dano = intval(($_POST["dano"]=='on' or $_POST["dano"] == 1)?1:0);
            if(empty($nome)){
				$nome = $dado;
            }
            $foto = minmax(intval($_POST["icone"]),0,13);
            $y = $con->prepare("INSERT INTO `dados_mestre`(`nome`,`foto`,`dado`,`dano`,`id_missao`) VALUES ( ? , ? , ? , ? , ? );");
            $y->bind_param("sisii", $nome, $foto, $dado, $dano, $id);
            $y->execute();
            echo $_POST["dano"];
            exit;
            break;
        case 'editd':
            $nome = cleanstring($_POST["nome"]);
            $dado = cleanstring($_POST["dado"]);
            $dano = cleanstring(($_POST["dano"]=='on' or $_POST["dano"] == 1)?1:0);
            $foto = minmax(intval($_POST["icone"]),0,13);
            $did = intval($_POST["did"]);
            if(empty($nome)){
                $dado = $nome;
            }
            $y = $con->prepare("UPDATE `dados_mestre` SET `nome` = ?, `dado` = ?, `foto` = ?, `dano` = ? where `id` = ? AND `id_missao` = ?;");
            $y->bind_param("ssiiii", $nome, $dado, $foto, $dano, $did, $id);
            $y->execute();
            break;
        case 'deld':
            $did = cleanstring($_POST["did"]);
            $y = $con->query("DELETE FROM `dados_mestre` WHERE `id` = '".$did."' AND `id_missao` = '".$id."';");
            break;
        case 'desp':
            $p = intval($_POST["p"]);
            $con->query("DELETE FROM `ligacoes` WHERE `id_missao`='$id' AND `id_ficha`='$p';");
            break;
        case 'deletenote':
            $nid = intval($_POST["note"]);
            $y = $con->query("DELETE FROM `notes` WHERE `id`='$nid' AND `missao`='$id' ");
            break;
	    case 'roll':
		    $dado = DadoDinamico(cleanstring($_POST["dado"], 50));
		    $dano = intval(minmax($_POST["dano"],0,1));
		    if(ClearRolar($dado)) {
			    $data["success"] = true;
			    $data = RolarMkII($dado,$dano);
		    } else {
			    $data = ClearRolar($dado,true);
		    }
		    $data["dado"] = $dado;
		    echo json_encode($data);
		    exit;
        case 'npc':
            $ss = $con->query('SELECT * FROM `fichas_npc` WHERE `id` = ' . intval($_POST["ficha"]) . ' AND `missao` = ' . $id . ';');
            $ss = $con->query('SELECT * FROM fichas_npc WHERE id = '.intval($_POST["ficha"]).' AND missao = '.intval($id).';');
			print(json_encode(mysqli_fetch_array(utf8ize($ss))));
            exit;
            break;
    }
}
function utf8ize($d) {
	if (is_array($d)) {
		foreach ($d as $k => $v) {
			$d[$k] = utf8ize($v);
		}
	} else if (is_string ($d)) {
		return utf8_encode($d);
	}
	return $d;
}