<?php
$con = con();
if (isset($espiral) and $espiral){
	$edit = true;
} else {
	$edit = false;
}
//Importante para evitar futuros ERROS!
$missao = 0;
$userid = $_SESSION["UserID"];

//Importante para evitar XSS INJECTIOn e um bucado de coisa
$id = intval($_GET["id"] ?: 0);

if(isset($_GET["id"])) {
	$qs = $con->query("SELECT * FROM `fichas_personagem` WHERE `id` = '$id'");
	if ($qs->num_rows) {
		$rqs = mysqli_fetch_array($qs);
		$fichat = $rqs["token"];
		header("Location: ./?token=".$fichat);
	} else {
		header("Location: ./..");
		exit;
	}
} else {
	$fichat = test_input($_GET["token"] ?: 0);
	if (empty($fichat)){
		header("Location: ./..");
	}
	$sq = $con->prepare("SELECT * FROM `fichas_personagem` WHERE `token` = ? ;");
	$sq->bind_param("s",$fichat);
	$sq->execute();
	$rqs = mysqli_fetch_array($sq->get_result());
	$id = $rqs["id"];
}


//Pega dados como ‘id’ do usuario e missao
$lig = $con->query("SELECT * FROM `ligacoes` WHERE `id_ficha` = '$id' limit 1;");
if ($lig->num_rows) {
	$ligacoes = mysqli_fetch_array($lig);
	$qm = $con->query("SELECT * FROM `missoes` WHERE `id` = '" . $ligacoes["id_missao"] . "'");
	if ($qm->num_rows == 1) {
		//Põe dados da missao em uma variavel
		$dados_missao = mysqli_fetch_array($qm);
	}
}



error_reporting(E_ALL);
if ((isset($_SESSION["UserAdmin"]) && $_SESSION["UserAdmin"])){
	$edit = true;
} else if ((isset($dados_missao) and $dados_missao["mestre"] == $userid)) {
	$edit = true;
} else if (VerificarID($id)){
	$edit = true;
} else IF (isset($portrait) AND $portrait == "public") {
	$edit = true;
} else IF (!$rqs["public"]) {
	header("Location: ./..");
	exit;
}




//Pega todos os dados da ficha: Principal

if (isset($rqs)) {

	$nu = $con->query("SELECT * FROM `usuarios` WHERE `usuarios`.`id` = " . ($rqs["usuario"] ?: 0));
	$rnu = mysqli_fetch_array($nu);
	$usuario = $rnu["nome"];
	$marca = $rnu["marca"];
	$nome = $rqs["nome"];
	$elemento = $rqs["afinidade"];
	$nex = $rqs["nex"];
	$pex = $rqs["pex"];
	$pp = $rqs["pp"];
	$deslocamento = $rqs["deslocamento"];
	$idade = $rqs["idade"] ?: "Desconhecida.";
	$local = $rqs["local"];
	$historia = $rqs["historia"];
	$encontro = $rqs["encontro"];
	$aparencia = $rqs["aparencia"];
	$medos = $rqs["medos"];
	$pesadelo = $rqs["pior_pesadelo"];
	$frases = $rqs["frases"];
	$favoritos = $rqs["favoritos"];
	$anotacao = $rqs["anotacoes"];
	$urlphoto = $rqs["foto"];
	if (intval($rqs["foto"]) > 0) {
		switch (intval($rqs["foto"])) {
			default:
				$urlphoto = $rqs["foto"];
				break;
			case 1:
				$urlphoto = 'https://fichasop.com/assets/img/Man.png';
				break;
			case 2:
				$urlphoto = 'https://fichasop.com/assets/img/Woman.png';
				break;
			case 3:
				$urlphoto = 'https://fichasop.com/assets/img/Mauro%20-%20up%20.png';
				break;
			case 4:
				$urlphoto = 'https://fichasop.com/assets/img/Maya%20-%20Upscale.png';
				break;
			case 5:
				$urlphoto = 'https://fichasop.com/assets/img/Bruna%20-%20Upscale.png';
				break;
			case 6:
				$urlphoto = 'https://fichasop.com/assets/img/Leandro%20-%20Upscale.png';
				break;
			case 7:
				$urlphoto = 'https://fichasop.com/assets/img/Jaime%20-%20Upscale.png';
				break;
			case 8:
				$urlphoto = 'https://fichasop.com/assets/img/Aniela%20-%20Upscale.png';
				break;
		}
	}
	$urlphotomor = $rqs["foto_morrendo"] ?: $urlphoto;
	$urlphotoenl = $rqs["foto_enlouquecendo"]?: $urlphoto;
	$urlphotofer = $rqs["foto_ferido"] ?: $urlphoto;
	$urlphotoalt = $rqs["foto_alternativa"];

	$forca = $rqs["forca"];
	$agilidade = $rqs["agilidade"];
	$intelecto = $rqs["inteligencia"];
	$presenca = $rqs["presenca"];
	$vigor = $rqs["vigor"];


	$pv = $rqs["pv"];
	$pva = $rqs["pva"];
	$san = $rqs["san"];
	$sana = $rqs["sana"];
	$pe = $rqs["pe"];
	$pea = $rqs["pea"];
	$ppv = TirarPorcento($pva, $pv);
	$psan = TirarPorcento($sana, $san);
	$ppe = TirarPorcento($pea, $pe);
	$morrendo = $rqs["morrendo"];
	$enlouquecendo = $rqs["enlouquecendo"];


	$passiva = $rqs["passiva"];
	$bloqueio = $rqs["bloqueio"];
	$esquiva = $rqs["esquiva"];


	$fisica = $rqs["fisica"];
	$balistica = $rqs["balistica"];
	$insanidade = $rqs["mental"];

	$sangue = $rqs["sangue"];
	$conhecimento = $rqs["conhecimento"];
	$energia = $rqs["energia"];
	$morte = $rqs["morte"];

	$corte = $rqs["corte"];
	$impacto = $rqs["impacto"];
	$perfuracao = $rqs["perfuracao"];
	$eletricidade = $rqs["eletricidade"];
	$fogo = $rqs["fogo"];
	$frio = $rqs["frio"];
	$quimica = $rqs["quimico"];


	$acrobacias = $rqs["acrobacias"];
	$adestramento = $rqs["adestramento"];
	$artes = $rqs["artes"];
	$atletismo = $rqs["atletismo"];
	$atualidades = $rqs["atualidades"];
	$ciencia = $rqs["ciencia"];
	$crime = $rqs["crime"];
	$diplomacia = $rqs["diplomacia"];
	$enganacao = $rqs["enganacao"];
	$fortitude = $rqs["fortitude"];
	$furtividade = $rqs["furtividade"];
	$iniciativa = $rqs["iniciativa"];
	$intimidacao = $rqs["intimidacao"];
	$intuicao = $rqs["intuicao"];
	$investigacao = $rqs["investigacao"];
	$luta = $rqs["luta"];
	$medicina = $rqs["medicina"];
	$ocultismo = $rqs["ocultismo"];
	$percepcao = $rqs["percepcao"];
	$pilotagem = $rqs["pilotagem"];
	$pontaria = $rqs["pontaria"];
	$prestidigitacao = $rqs["prestidigitacao"];//
	$profissao = $rqs["profissao"];
	$reflexos = $rqs["reflexos"];
	$religiao = $rqs["religiao"];
	$sobrevivencia = $rqs["sobrevivencia"];
	$tatica = $rqs["tatica"];
	$tecnologia = $rqs["tecnologia"];
	$vontade = $rqs["vontade"];

	switch ($rqs["origem"]) {
		default:
			$origem = "Não indentificada";
			break;
		case 1:
			$origem = "Acadêmico.";
			break;
		case 2:
			$origem = "Agente de Saúde.";
			break;
		case 3:
			$origem = "Amnésico.";
			break;
		case 4:
			$origem = "Artista.";
			break;
		case 5:
			$origem = "Atleta.";
			break;
		case 6:
			$origem = "Criminoso.";
			break;
		case 7:
			$origem = "Cultista Arrependido.";
			break;
		case 8:
			$origem = "Desgarrado.";
			break;
		case 9:
			$origem = "Engenheiro.";
			break;
		case 10:
			$origem = "Executivo.";
			break;
		case 11:
			$origem = "Investigador(a).";
			break;
		case 12:
			$origem = "Lutador.";
			break;
		case 13:
			$origem = "Magnata";
			break;
		case 14:
			$origem = "Mercenário.";
			break;
		case 15:
			$origem = "Militar.";
			break;
		case 16:
			$origem = "Operário.";
			break;
		case 17:
			$origem = "Policial.";
			break;
		case 18:
			$origem = "Religioso.";
			break;
		case 19:
			$origem = "Servidor Público.";
			break;
		case 20:
			$origem = "Teórico da Conspiração.";
			break;
		case 21:
			$origem = "Técnico de Informatica.";
			break;
		case 22:
			$origem = "Trabalhador Rural.";
			break;
		case 23:
			$origem = "Trambiqueiro.";
			break;
		case 24:
			$origem = "Universitário.";
			break;
		case 25:
			$origem = "Chef.";
			break;
		case 26:
			$origem = "Vítima.";
			break;
	}
	switch ($rqs["classe"]) {
		default:
			$classe = "Não indentificado.";
			$trilha = "Não indentificada.";
			break;
		case 1:
			$classe = "Combatente";
			switch ($rqs["trilha"]) {
				default:
					$trilha = "Não indentificada.";
					break;
				case 1:
					$trilha = "Aniquilador";
					break;
				case 2:
					$trilha = "Comandante de Campo";
					break;
				case 3:
					$trilha = "Guerreiro";
					break;
				case 4:
					$trilha = "Operações Especiais";
					break;
				case 5:
					$trilha = "Tropa de Choque";
					break;
			}
			break;
		case 2:
			$classe = "Especialista";
			switch ($rqs["trilha"]) {
				default:
					$trilha = "Não indentificada.";
					break;
				case 1:
					$trilha = "Atirador de Elite";
					break;
				case 2:
					$trilha = "Infiltrador";
					break;
				case 3:
					$trilha = "Médico de Campo";
					break;
				case 4:
					$trilha = "Negociador";
					break;
				case 5:
					$trilha = "Técnico";
					break;
			}
			break;
		case 3:
			$classe = "Ocultista";
			switch ($rqs["trilha"]) {
				default:
					$trilha = "Não indentificada.";
					break;

				case 1:
					$trilha = "Conduíte";
					break;
				case 2:
					$trilha = "Flagelador";
					break;
				case 3:
					$trilha = "Graduado";
					break;
				case 4:
					$trilha = "Intuitivo";
					break;
				case 5:
					$trilha = "Lâmina Paranormal";
					break;
			}
			break;
	}
	switch ($rqs["patente"]) {
		default:
			$patente = "Não indentificada.";
			break;
		case 1:
			$patente = "Recruta.";
			break;
		case 2:
			$patente = "Operador.";
			break;
		case 3:
			$patente = "Agente Especial.";
			break;
		case 4:
			$patente = "Oficial de Operações.";
			break;
		case 5:
			$patente = "Agente de Elite.";
			break;
	}
} else {
	header("Location: ./..");
}
//pega todos os dados da ficha: Rituais
//pega todos os dados da ficha: Armas
$rs = [];
$s[1] = $con->query("Select * From `armas` where `id_ficha` = '$id';");
foreach($s[1] as $r):
	$rs[1][] = $r;
endforeach;
$s[2] = $con->query("SELECT * FROM `habilidades` WHERE `id_ficha` = '" . $id . "';");
$s[3] = $con->query("SELECT * FROM `proeficiencias` WHERE `id_ficha` = '" . $id . "';");
$s[4] = $con->query("Select * From `inventario` where `id_ficha` = '$id';");
foreach($s[4] as $r):
	$rs[4][] = $r;
endforeach;
$s[6] = $con->query("Select * From `rituais` where `id_ficha` = '$id';");
foreach($s[6] as $r):
	$rs[6][] = $r;
endforeach;
$s[7] = $con->query("SELECT * FROM `poderes` WHERE `id_ficha` = '" . $id . "';");
$s[5] = $con->query("Select SUM(espaco) AS pesototal From `inventario` where `id_ficha` = '$id';");


$m = $con->query("SELECT * FROM `dados_ficha` WHERE `id_ficha` = '" . $id . "';");
$ddinv = mysqli_fetch_array($s[5]);



$espacosusados = $ddinv["pesototal"] ?: 0;
$invmax = pesoinv($rqs["forca"],$rqs["inteligencia"],$rqs["classe"],$rqs["trilha"],$rqs["origem"]);

$missao_token = isset($dados_missao["token"])?$dados_missao["token"]:false;
//Pega todos os dados da ficha:...



$minpva = -20;
$minsana = 0;
$minpea = 0;
$minpv = 1;
$minsan =  1;
$minpe = 1;
$maxpv = 20;
$maxsan =  20;
$maxpe = 20;

//Config de limites gerais:

$Inv_nome = $Arma_nome = 50;
$Arma_tipo = 25;
$Arma_ataq = 50;
$Arma_alca = 30;
$Arma_dano = 30;
$Arma_crit = 30;
$Arma_reca = 50;
$Arma_espe = 30;
$Dado_nome = 50;
$Dado_dado = 50;
$Inv_desc = 300;
$Hab_nome = 50;
$Hab_desc = 5000;
$Pro_nome = 100;
$Ritu_nome = 50;
$Ritu_elem = 50;
$Ritu_circ = 30;
$Ritu_conj = 30;
$Ritu_alca = 50;
$Ritu_alvo = 50;
$Ritu_dura = 15;
$Ritu_resi = 100;
$Ritu_dan1 = 50;
$Ritu_dan2 = 50;
$Ritu_efei = 5000;
$fich_nome = 50;
$Fich_fotos = 500;
$Fich_loca = 100;
$Fich_hist = 5000;
$Fich_prim = 1000;
$Fich_apar = 1000;
$Fich_medo = 1000;
$Fich_pesa = 1000;
$Fich_fras = 1000;
$Fich_favo = 1000;
$Fich_note = 5000;

if ($edit) {
	require_once RootDir."/sessao/personagem/ficha/atualizar.php";
}


?>