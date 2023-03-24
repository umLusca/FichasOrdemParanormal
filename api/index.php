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
$data = [];
$success = true;
$msg = '';
$error = 00;

$_DATA = $_POST?:[];
if (!empty(file_get_contents('php://input'))) {
	$body = json_decode(file_get_contents('php://input'), true);
	if(!empty($body))
	$_DATA += $body;
}
$_QUERY = $_DATA["query"];

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
				$msg = "Sua sessão expirou, faça login novamente.";
			}
			break; //APP
		case "account_recovery":
		case 'recovery_account':
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
			$s = $con->prepare("SELECT * FROM `usuarios` WHERE `email` = ? ;");
			$s->bind_param("s", $email);
			$s->execute();
			$s = $s->get_result();
			if ($s->num_rows) {
				$ds = mysqli_fetch_array($s);
				$hash = md5(md5($email) . strtotime(date('m/d/Y h:i:s')));
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
					$fromname = 'FichasOP';
					$subject = 'Recuperar Conta';
					$headers = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: suporte@fichasop.com' . "\r\n";
					if (mail($email, $subject, $emailmsg, $headers)) {
						$success = true;
						$msg = 'Email enviado, Verifique sua caixa de email';
					} else {
						$success = false;
						$msg = "Falha ao enviar email, contate um administrador.";
					}
					
				} else {
					$success = false;
					$msg = "Falha ao enviar email, contate um administrador.";
				}
			} else {
				$success = false;
				$msg = 'Nenhuma conta encontrada com esse email...';
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
					if ($qu->num_rows && $success) {
						$rq = mysqli_fetch_assoc($qu);
						if (cryptthis($senha) === $rq["senha"]) {
							$msg = "Sucesso ao fazer login!";
							
							$conta = [];
							$conta["token"] = remember_me($rq["id"]);
							$conta["nome"] = $rq["nome"];
							$conta["email"] = $rq["email"];
							$conta["login"] = $rq["login"];
							$conta["elite"] = $rq["elite"];
							$data["conta"] = $conta;
							
							
							$f = $con->prepare("UPDATE usuarios SET senha = ? WHERE usuarios.login = ?");
							$nsenha = PassCheck($senha);
							$f->bind_param("ss", $nsenha, $login);
							$f->execute();
							
							
						} elseif (PassCheck($senha, $rq["senha"])) {
							$msg = "Sucesso ao fazer login!";
							$data["id"] = remember_me($rq["id"]);
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
		case 'checksession':
			$sid = cleanstring($_DATA["sessid"] ?: session_id());
			if (check_session($sid)) {
				$user = check_session($sid);
				$q = $con->prepare("SELECT * FROM `usuarios` WHERE `login`  = ?;");
				$q->bind_param("s", $user);
				$q->execute();
				
				$q = $q->get_result();
				if ($q->num_rows) {
					$tv = mysqli_fetch_array($q);
					$conta["nome"] = $tv["nome"];
					$conta["email"] = $tv["email"];
					$conta["login"] = $tv["login"];
					$conta["elite"] = $tv["elite"];
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