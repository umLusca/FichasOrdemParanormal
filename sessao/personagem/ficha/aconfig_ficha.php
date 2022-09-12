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
	$fichat = cleanstring($_GET["token"] ?: 0);
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



if ((isset($_SESSION["UserAdmin"]) && $_SESSION["UserAdmin"])){
	$edit = true;
} else if ((isset($dados_missao) and $dados_missao["mestre"] == $userid)) {
	$edit = true;
} else if (VerificarID($id)){
	$edit = true;
} else IF (isset($portrait) AND $portrait) {
	$edit = false;
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
	$urlphotomor = $rqs["foto_morrendo"] ?: $urlphoto;
	$urlphotoenl = $rqs["foto_enlouquecendo"]?: $urlphoto;
	$urlphotofer = $rqs["foto_ferido"] ?: $urlphoto;
	$urlphotoef = $rqs["foto_ferenl"] ?: $urlphoto;

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
	$pe_rodada = $rqs["pe_rodada"];


	switch ($rqs["origem"]) {
		default:
			$origem = $rqs["origem"];
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
			$classe = $rqs["classe"];
			$trilha = $rqs["trilha"];
			break;
		case 0:
			$classe = $rqs["classe"];
			$trilha = "Nenhuma";
			break;
		case 1:
			$classe = "Combatente";
			switch ($rqs["trilha"]) {
				default:
					$trilha = $rqs["trilha"];
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
					$trilha = $rqs["trilha"];
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
					$trilha = $rqs["trilha"];
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
			$patente = $rqs["patente"];
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
if ($espacosusados < 0){
	$espacosusados = 0;
}

$invmax = pesoinv($rqs["forca"],$rqs["inteligencia"],$rqs["classe"],$rqs["trilha"],$rqs["origem"]);

$missao_token = isset($dados_missao["token"])?$dados_missao["token"]:false;
//Pega todos os dados da ficha:...


if ($edit) {
	require_once RootDir."/sessao/personagem/ficha/atualizar.php";
}


?>