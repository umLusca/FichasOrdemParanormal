<?php

$dado = array("dado" => $_DATA["dado"]);
$token = cleanstring($_DATA["token"]);
$user = checksession($session_id);
if ($user) {
	if (VerificarPermissaoFicha($token, $user)) {
		$f = $con->prepare("SELECT * FROM fichas_personagem WHERE token = ?");
		$f->execute([$token]);
		$ficha = mysqli_fetch_assoc($f->get_result());
		$m = $con->prepare("SELECT * FROM missoes WHERE id in (SELECT id_missao FROM ligacoes WHERE id_ficha = ?)");
		$m->execute([$ficha["id"]]);
		$m = $m->get_result();
		if ($m->num_rows) {
			$missao = mysqli_fetch_assoc($m);
			$dado["components"] = $ficha["token"];
			$dado["foto"] = $ficha["foto"];
			$dado["dado"]["nome"] = cleanstring($_DATA["nome"]);
			$dado["nome"] = $ficha["nome"];
			$d = $con->prepare("INSERT INTO dados_rolados_mestre(dados, missao, token) VALUES (?,?,?)");

			$jsondado = json_encode($dado);
			$d->execute([$jsondado, $missao["id"], $ficha["token"]]);
			$return["success"] = true;
			$return["msg"] = "Salvo";
		} else {
			$return["success"] = true;
			$return["msg"] = "Essa components não tem missão.";
		}

	} else {
		$return["success"] = false;
		$return["msg"] = "Sem permissão.";
	}

} else {
	$return["success"] = false;
	$return["msg"] = "Sua sessão encerrou.";
}