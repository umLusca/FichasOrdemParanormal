<?php
$con = con();
//Importante para evitar futuros ERROS!
$missao = 0;

//Importante para evitar XSS INJECTIOn e um bucado de coisa
$id = (int)($_GET["id"] ?: 0);
if(isset($_GET["id"])) {
	$qs = $con->query("SELECT * FROM `fichas_personagem` WHERE `id` = '$id'");
	if ($qs->num_rows) {
		$ficha = mysqli_fetch_array($qs);
		$token = $ficha["token"];
		header("Location: ./?token=".$token);
	} else {
		header("Location: ./..");
		exit;
	}
} else {
	$token = cleanstring($_GET["token"] ?: 0);
	if (empty($token)){
		header("Location: ./..");
	}
	$sq = $con->prepare("SELECT fichas_personagem.*, u.nome as usuario, u.marca as marca FROM `fichas_personagem` inner join usuarios u on fichas_personagem.usuario = u.id WHERE fichas_personagem.`token` = ? ;");
	$sq->bind_param("s",$token);
	$sq->execute();
	$ficha = mysqli_fetch_array($sq->get_result());
	$id = $ficha["id"];
}


//Pega dados como ‘id’ do usuario e missao
$lig = $con->query("SELECT * FROM `ligacoes` WHERE `id_ficha` = '$id' limit 1;");
if ($lig->num_rows) {
	$ligacoes = mysqli_fetch_array($lig);
	$qm = $con->query("SELECT * FROM `missoes` WHERE `id` = '" . $ligacoes["id_missao"] . "'");
	if ($qm->num_rows) {
		//Põe dados da missao em uma variavel
		$dados_missao = mysqli_fetch_array($qm);
	}
}



if ((isset($_SESSION["UserAdmin"]) && $_SESSION["UserAdmin"])){
	$edit = true;
} else if (VerificarPermissaoFicha($token,$_SESSION["UserID"])){
	$edit = true;
} else IF (!$ficha["public"]) {
	header("Location: ./..");
	exit;
}



//Pega todos os dados da ficha: Principal

if (isset($ficha)) {

	$nome = $ficha["nome"];
	$elemento = $ficha["afinidade"];
    $classe = $ficha["classe"];
	$origem = $ficha["origem"];
	$nex = $ficha["nex"];
	$pp = $ficha["pp"];
	$deslocamento = $ficha["deslocamento"];
	$idade = $ficha["idade"];
	$patente = $ficha["patente"];
	$local = $ficha["local"];
	$historia = $ficha["historia"];
	$encontro = $ficha["encontro"];
	$aparencia = $ficha["aparencia"];
	$medos = $ficha["medos"];
	$pesadelo = $ficha["pior_pesadelo"];
	$frases = $ficha["frases"];
	$favoritos = $ficha["favoritos"];
	$anotacao = $ficha["anotacoes"];
	$urlphoto = $ficha["foto"];
	$urlphotomor = $ficha["foto_morrendo"] ?: $urlphoto;
	$urlphotoenl = $ficha["foto_enlouquecendo"]?: $urlphoto;
	$urlphotofer = $ficha["foto_ferido"] ?: $urlphoto;
	$urlphotoef = $ficha["foto_ferenl"] ?: $urlphoto;

	$forca = $ficha["forca"];
	$agilidade = $ficha["agilidade"];
	$intelecto = $ficha["inteligencia"];
	$presenca = $ficha["presenca"];
	$vigor = $ficha["vigor"];


	$pv = $ficha["pv"];
	$pva = $ficha["pva"];
	$san = $ficha["san"];
	$sana = $ficha["sana"];
	$pe = $ficha["pe"];
	$pea = $ficha["pea"];
	$ppv = TirarPorcento($pva, $pv);
	$psan = TirarPorcento($sana, $san);
	$ppe = TirarPorcento($pea, $pe);
	$morrendo = $ficha["morrendo"];
	$enlouquecendo = $ficha["enlouquecendo"];


	$passiva = $ficha["passiva"];
	$bloqueio = $ficha["bloqueio"];
	$esquiva = $ficha["esquiva"];


	$fisica = $ficha["fisica"];
	$balistica = $ficha["balistica"];
	$insanidade = $ficha["mental"];

	$sangue = $ficha["sangue"];
	$conhecimento = $ficha["conhecimento"];
	$energia = $ficha["energia"];
	$morte = $ficha["morte"];

	$corte = $ficha["corte"];
	$impacto = $ficha["impacto"];
	$perfuracao = $ficha["perfuracao"];
	$eletricidade = $ficha["eletricidade"];
	$fogo = $ficha["fogo"];
	$frio = $ficha["frio"];
	$quimica = $ficha["quimico"];


	$acrobacias = $ficha["acrobacias"];
	$adestramento = $ficha["adestramento"];
	$artes = $ficha["artes"];
	$atletismo = $ficha["atletismo"];
	$atualidades = $ficha["atualidades"];
	$ciencia = $ficha["ciencia"];
	$crime = $ficha["crime"];
	$diplomacia = $ficha["diplomacia"];
	$enganacao = $ficha["enganacao"];
	$fortitude = $ficha["fortitude"];
	$furtividade = $ficha["furtividade"];
	$iniciativa = $ficha["iniciativa"];
	$intimidacao = $ficha["intimidacao"];
	$intuicao = $ficha["intuicao"];
	$investigacao = $ficha["investigacao"];
	$luta = $ficha["luta"];
	$medicina = $ficha["medicina"];
	$ocultismo = $ficha["ocultismo"];
	$percepcao = $ficha["percepcao"];
	$pilotagem = $ficha["pilotagem"];
	$pontaria = $ficha["pontaria"];
	$prestidigitacao = $ficha["prestidigitacao"];//
	$profissao = $ficha["profissao"];
	$reflexos = $ficha["reflexos"];
	$religiao = $ficha["religiao"];
	$sobrevivencia = $ficha["sobrevivencia"];
	$tatica = $ficha["tatica"];
	$tecnologia = $ficha["tecnologia"];
	$vontade = $ficha["vontade"];
	$pe_rodada = $ficha["pe_rodada"];


	$dc = array(
		"FOR" =>  $ficha["forca"],
		"AGI" =>  $ficha["agilidade"],
		"INT" =>  $ficha["inteligencia"],
		"PRE" =>  $ficha["presenca"],
		"VIG" =>  $ficha["vigor"],
		"ACRO" =>  $ficha["acrobacias"],
		"ADES" =>  $ficha["adestramento"],
		"ARTE" =>  $ficha["artes"],
		"ATLE" =>  $ficha["atletismo"],
		"ATUA" =>  $ficha["atualidades"],
		"CIEN" =>  $ficha["ciencia"],
		"CRIM" =>  $ficha["crime"],
		"DIPL" =>  $ficha["diplomacia"],
		"ENGA" =>  $ficha["enganacao"],
		"FORT" =>  $ficha["fortitude"],
		"FURT" =>  $ficha["furtividade"],
		"INIT" =>  $ficha["iniciativa"],
		"INTI" =>  $ficha["intimidacao"],
		"INTU" =>  $ficha["intuicao"],
		"INVE" =>  $ficha["investigacao"],
		"LUTA" =>  $ficha["luta"],
		"MEDI" =>  $ficha["medicina"],
		"OCUL" =>  $ficha["ocultismo"],
		"PERC" =>  $ficha["percepcao"],
		"PILO" =>  $ficha["pilotagem"],
		"PONT" =>  $ficha["pontaria"],
		"PROF" =>  $ficha["profissao"],
		"RELI" =>  $ficha["religiao"],
		"REFL" =>  $ficha["reflexos"],
		"SOBR" =>  $ficha["sobrevivencia"],
		"TATi" =>  $ficha["tatica"],
		"TECN" =>  $ficha["tecnologia"],
		"VONT" =>  $ficha["vontade"],
	);

} else {
	header("Location: ./..");
}

$rs = [];
$s[1] = $con->query("Select * From `armas` where `id_ficha` = '$id';");
$s[8] = $con->query("Select *,armas.id as id,i.foto as foto From armas left join inventario i on i.id = armas.item_id where i.id_ficha = '$id' ;");

$s[2] = $con->query("SELECT * FROM `habilidades` WHERE `id_ficha` = '" . $id . "';");
$s[3] = $con->query("SELECT * FROM `proeficiencias` WHERE `id_ficha` = '" . $id . "';");
$s[4] = $con->query("SELECT i.* FROM inventario i LEFT JOIN armas a ON a.item_id = i.id WHERE a.item_id is null AND i.id_ficha = '$id';");
foreach($s[4] as $r):
	$rs[4][] = $r;
endforeach;
$s[6] = $con->query("Select * From `rituais` where `id_ficha` = '$id';");
foreach($s[6] as $r):
	$rs[6][] = $r;
endforeach;
$s[7] = $con->query("SELECT * FROM `poderes` WHERE `id_ficha` = '" . $id . "';");
$s[5] = $con->query("Select SUM(espaco*quantidade) AS pesototal From `inventario` where `id_ficha` = '$id';");


$m = $con->query("SELECT * FROM `dados_ficha` WHERE `id_ficha` = '" . $id . "';");
$ddinv = mysqli_fetch_array($s[5]);



$espacosusados = $ddinv["pesototal"] ?: 0;
if ($espacosusados < 0){
	$espacosusados = 0;
}
if($ficha["peso_inv"] > 1){
    $invmax = $ficha["peso_inv"];
} else {
    $invmax = pesoinv($ficha["forca"], $ficha["inteligencia"], $ficha["classe"], $ficha["trilha"], $ficha["origem"]);
}

$missao_token = $dados_missao["token"] ?? false;
//Pega todos os dados da ficha:...


if ($edit) {
	require_once RootDir."/sessao/personagem/ficha/atualizar.php";
}


?>