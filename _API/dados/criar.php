<?php
$nome = cleanstring($_DATA["nome"], 20);
$dado = cleanstring($_DATA["dado"], 50);
$dano = minmax($_DATA["dano"], 0, 1);
$global = minmax($_DATA["global"], 0, 1);
$token = $global ? "" : cleanstring($_DATA["token"], 36);
$user = checksession($session_id);


if ($user) {
	$c = $con->query("SELECT uuid_short()");
	$c = mysqli_fetch_array($c);
	$d = $con->prepare("INSERT INTO dados_customizados (token, owner, nome, dado, foto, dano, token_pai) VALUES (?,?,?,?,5,?,?)");
	if ($d->execute([$c[0], $user, $nome, $dado, $dano, $token])) {
		$return["success"] = true;
		$return["msg"] = "Dado criado.";

		$f = $con->prepare("SELECT * FROM dados_customizados WHERE token = ? ");
		$f->execute([$c[0]]);
		$f = $f->get_result();
		$dados = [];
		foreach ($f as $dado) {
			unset($dado["owner"]);
			$dados[] = $dado;
		}
		$return["dados"]["dices"] = $dados;
		$return["msg"] = "Total: " . $f->num_rows;
		$return["success"] = $f->num_rows ? 1 : 0;


	} else {
		$return["success"] = false;
		$return["msg"] = "Houve uma falha.";
	}
} else {
	$return["success"] = false;
	$return["msg"] = "Sem permissão.";

}
