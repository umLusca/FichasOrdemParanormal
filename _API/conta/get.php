<?php

if (!empty($session_id)) {
	if (checksession($session_id)) {
		$user = checksession($session_id);
		$q = $con->prepare("SELECT * FROM `usuarios` WHERE `id`  = ?;");
		$q->bind_param("i", $user);
		$q->execute();

		$q = $q->get_result();
		if ($q->num_rows) {
			$tv = mysqli_fetch_array($q);
			$return["success"] = true;
			$conta["nome"] = $tv["nome"];
			$conta["email"] = $tv["email"];
			$conta["login"] = $tv["login"];
			$conta["marca"] = $tv["marca"];
			$return["conta"] = $conta;
		} else {
			$return["success"] = false;
			$return["msg"] = 'Essa conta não existe.';
		}
	} else {
		$return["success"] = false;
		$return["msg"] = 'Sua conta já foi encerrada.';
	}
} else if (!empty($_DATA["login"])) {
	$login = cleanstring($_DATA["login"]);
	if (!empty($_DATA["senha"])) {
		$senha = cleanstring($_DATA["senha"]);
		$qu = $con->prepare("SELECT * FROM `usuarios` WHERE (usuarios.login = ?) OR (usuarios.email = ?);");
		$qu->bind_param("ss", $login, $login);
		$qu->execute();
		$qu = $qu->get_result();
		if ($qu->num_rows) {
			$rq = mysqli_fetch_assoc($qu);
			$token = remember_me($rq["id"], 7, generateRandomString(3));
			if (cryptthis($senha) === $rq["senha"] || PassCheck($senha, $rq["senha"])) {
				logar($rq["id"]);
				$return["success"] = true;
				$return["msg"] = "Sucesso ao fazer login!";

				$conta["nome"] = $rq["nome"];
				$conta["email"] = $rq["email"];
				$conta["login"] = $rq["login"];
				$conta["marca"] = $rq["marca"];
				$return["conta"] = $conta;

				$return["conta"]["token"] = $token;
				if (cryptthis($senha) === $rq["senha"]) {
					$f = $con->prepare("UPDATE usuarios SET senha = ? WHERE usuarios.login = ?");
					$nsenha = PassCheck($senha);
					$f->bind_param("ss", $nsenha, $login);
					$f->execute();

				}
			} else {
				$return["success"] = false;
				if (Check_Email($login)) {
					$return["msg"] = "Email e/ou senha incorretos.";
				} else {
					$return["msg"] = "Username e/ou senha incorretos.";
				}
			}
		} else {
			$return["success"] = false;
			if (Check_Email($login)) {
				$return["msg"] = "Email e/ou senha incorretos.";
			} else {
				$return["msg"] = "Username e/ou senha incorretos.";
			}
		}
	} else {
		$return["success"] = false;
		$return["msg"] = "Preencha sua senha.";
	}
} else {
	$return["success"] = false;
	$return["msg"] = "Preencha seu username/email.";
}