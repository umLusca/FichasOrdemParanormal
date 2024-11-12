<?php

$ok = true;

if (!empty($session_id)) {
	$userid = checksession($session_id);
	if (!$userid) {
		$ok = false;
		$return["status"] = 403;
		$return["msg"] = 'Sua sessão encerrou, entre novamente.';
		$return["refresh"] = true;
	}
	if ($ok) {
		$c = con_pdo();
		$q = $c->prepare("SELECT * FROM `usuarios` WHERE `id` = ?;");
		$q->execute([$userid]);
		if ($q->rowCount()) {
			$user = $q->fetch(2);
			$return["status"] = 200;
			
			$return["conta"] = [
				"nome" => $user["nome"],
				"email" => $user["email"],
				"login" => $user["login"],
				"marca" => $user["marca"],
			];
		} else {
			$return["status"] = 404;
			$return["msg"] = 'Sua sessão é inválida, entre novamente.';
		}
	}
} else {
	$login = cleanstring($_POST["login"]);
	$passw = cleanstring($_POST["senha"]);
	
	if (empty($login)) {
		$ok = false;
		$return["status"] = 401;
		$return["msg"] = "Preencha o campo login";
	}
	if (empty($passw)) {
		$ok = false;
		$return["status"] = 401;
		$return["msg"] = "Preencha o campo senha";
	}
	
	if ($ok) {
		$c = con_pdo();
		$qu = $c->prepare("SELECT * FROM `usuarios` WHERE login = :login OR email = :login;");
		$qu->execute([":login" => $login]);
		if (!$qu->rowCount()) {
			$ok = false;
			$return["status"] = 401;
			$return["msg"] = "Usuário não encontrado";
		}
		
	}
	if ($ok) {
		$user = $qu->fetch(2);
		if (!PassCheck($passw, $user["senha"])) {
			$ok = false;
			$return["status"] = 401;
			$return["msg"] = "Senha incorreta.";
		}
	}
	if ($ok) {
		$token = remember_me($user["id"], 7, generateRandomString(3));
		logar($user["id"]);
		$return["status"] = 200;
		$return["success"] = true;
		$return["msg"] = "Entrou com sucesso!";
		$return["redirect"] = "/painel";
		
	}
}
