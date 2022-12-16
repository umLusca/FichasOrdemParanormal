<?php
$con = con();
if (isset($espiral) && $espiral){
	$edit = true;
} else {
	$edit = false;
}
//Importante para evitar futuros ERROS!
$missao = 0;
$userid = $_SESSION["UserID"];

//Importante para evitar XSS INJECTIOn e um bucado de coisa
$id = (int)($_GET["id"] ?: 0);

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
} else if ((isset($dados_missao) && $dados_missao["mestre"] == $userid)) {
	$edit = true;
} else if (VerificarID($id)){
	$edit = true;
} else IF (isset($portrait) && $portrait) {
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
    $classe = $rqs["classe"];
	$origem = $rqs["origem"];
	$nex = $rqs["nex"];
	$pp = $rqs["pp"];
	$deslocamento = $rqs["deslocamento"];
	$idade = $rqs["idade"];
	$patente = $rqs["patente"];
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


	$dc = array(
		"FOR" =>  $rqs["forca"],
		"AGI" =>  $rqs["agilidade"],
		"INT" =>  $rqs["inteligencia"],
		"PRE" =>  $rqs["presenca"],
		"VIG" =>  $rqs["vigor"],
		"ACRO" =>  $rqs["acrobacias"],
		"ADES" =>  $rqs["adestramento"],
		"ARTE" =>  $rqs["artes"],
		"ATLE" =>  $rqs["atletismo"],
		"ATUA" =>  $rqs["atualidades"],
		"CIEN" =>  $rqs["ciencia"],
		"CRIM" =>  $rqs["crime"],
		"DIPL" =>  $rqs["diplomacia"],
		"ENGA" =>  $rqs["enganacao"],
		"FORT" =>  $rqs["fortitude"],
		"FURT" =>  $rqs["furtividade"],
		"INIT" =>  $rqs["iniciativa"],
		"INTI" =>  $rqs["intimidacao"],
		"INTU" =>  $rqs["intuicao"],
		"INVE" =>  $rqs["investigacao"],
		"LUTA" =>  $rqs["luta"],
		"MEDI" =>  $rqs["medicina"],
		"OCUL" =>  $rqs["ocultismo"],
		"PERC" =>  $rqs["percepcao"],
		"PILO" =>  $rqs["pilotagem"],
		"PONT" =>  $rqs["pontaria"],
		"PROF" =>  $rqs["profissao"],
		"REFL" =>  $rqs["reflexos"],
		"SOBR" =>  $rqs["sobrevivencia"],
		"TATi" =>  $rqs["tatica"],
		"TECN" =>  $rqs["tecnologia"],
		"VONT" =>  $rqs["vontade"],
	);

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
if($rqs["peso_inv"] > 1){
    $invmax = $rqs["peso_inv"];
} else {
    $invmax = pesoinv($rqs["forca"], $rqs["inteligencia"], $rqs["classe"], $rqs["trilha"], $rqs["origem"]);
}

$missao_token = $dados_missao["token"] ?? false;
//Pega todos os dados da ficha:...


if ($edit) {
	require_once RootDir."/sessao/personagem/ficha/atualizar.php";
}


?>