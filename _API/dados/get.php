<?php
$token = cleanstring($_DATA["token"]);
$user = checksession($session_id);

$d = $con->prepare("SELECT * FROM dados_customizados WHERE token_pai = ? OR owner = ?");
$d->execute([$token, $user]);
$d = $d->get_result();
if ($d->num_rows) {
	$dados = [];
	foreach ($d as $dado) {
		unset($dado["owner"]);
		$dados[] = $dado;
	}
	$return["dados"]["dices"] = $dados;
	$return["msg"] = "Total: " . $d->num_rows;
	$return["success"] = true;
} else {
	$return["success"] = true;
	$return["dados"]["dices"] = [];
	$return["msg"] = "Nenhum dado encontrado.";
}