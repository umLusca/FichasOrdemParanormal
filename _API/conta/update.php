<?php
if (checksession($session_id)) {
	if (isset($_DATA["asenha"]) && !empty($_DATA["asenha"])) {
		$senha = cleanstring($_DATA["asenha"]);
		$user = checksession($session_id);

		$u = $con->prepare("SELECT * FROM usuarios WHERE id = ?");
		$u->bind_param("i", $user);
		$u->execute();
		$u = mysqli_fetch_assoc($u->get_result());
		if ($u["senha"] === cryptthis($senha) || PassCheck($senha, $u["senha"])) {
			if (!PassCheck($senha, $u["senha"])) {
				$_a = $con->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
				$nn = PassCheck($senha);
				$_a->bind_param("si", $nn, $user);
				$_a->execute();
			} //Atualiza para nova criptografia

			if (isset($_DATA["nsenha"], $_DATA["csenha"]) && !empty($_DATA["nsenha"]) && !empty($_DATA["csenha"])) {
				$nsenha = cleanstring($_DATA["nsenha"]);
				$csenha = cleanstring($_DATA["csenha"]);

				if (Check_Pass($nsenha, $csenha)) {
					$a = $con->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
					$nsenha = PassCheck($nsenha);
					$a->bind_param("si", $nsenha, $user);
					$a->execute();
					if ($con->affected_rows) {
						$return["success"] = true;
						$return["msg"] .= "Sua senha foi atualizada.";
					} else {
						$return["success"] = false;
						$return["msg"] = "Erro no banco de dados.";
					}
				} else {
					$return["success"] = false;
					$return["msg"] = Check_Pass($nsenha, $csenha, 1)["msg"];
				}
			} else if ((isset($_DATA["nsenha"]) && !empty($_DATA["nsenha"])) || (isset($_DATA["csenha"]) && !empty($_DATA["csenha"]))) {
				$return["success"] = false;
				$return["msg"] = "Preencha os campo das senhas.";
			}

			if (isset($_DATA["email"]) && !empty($_DATA["email"])) {
				$email = cleanstring($_DATA["email"]);
				if (Check_Email($email)) {
					$a = $con->prepare("SELECT * FROM usuarios WHERE email = ? ;");
					$a->bind_param("s", $email);
					$a->execute();
					$a = $a->get_result();
					if ($a->num_rows) {
						$ra = mysqli_fetch_array($a);

						if (!$ra["status"]) {
							$con->query("DELETE FROM usuarios WHERE id = {$ra["id"]};");
							$b = $con->prepare("UPDATE usuarios SET email = ? WHERE id = ? ;");
							$b->bind_param("si", $email, $user);
							$b->execute();
							if ($con->affected_rows) {
								$_SESSION["UserEmail"] = $email;
								$return["success"] = true;
								$return["msg"] = "Email atualizado.";
							} else {
								$return["success"] = false;
								$return["msg"] = "Erro no banco de dados.";
							}
						} else {
							$return["success"] = false;
							$return["msg"] = "Email já em uso.";
						}
					} else {
						$c = $con->prepare("UPDATE usuarios SET email = ? WHERE id = ?");
						$c->bind_param("si", $email, $user);
						$c->execute();
						if ($con->affected_rows) {
							$_SESSION["UserEmail"] = $email;
							$return["success"] = true;
							$return["msg"] = "Email Atualizado.";
						} else {
							$return["success"] = false;
							$return["msg"] = "Erro no banco de dados.";
						}
					}
				} else {
					$return["success"] = false;
					$return["msg"] = "Este email não é válido";
				}
			}
			if (isset($_DATA["username"]) && !empty($_DATA["username"])) {
				$username = cleanstring($_DATA["username"]);
				if (Check_Login($username)) {
					$a = $con->prepare("SELECT * FROM usuarios WHERE login = ? ;");
					$a->bind_param("s", $username);
					$a->execute();
					$a = $a->get_result();
					if (!$a->num_rows) {
						$b = $con->prepare("UPDATE usuarios SET login = ? WHERE id = ? ;");
						$b->bind_param("si", $username, $user);
						$b->execute();
						if ($con->affected_rows) {
							$_SESSION["UserLogin"] = $username;
							$return["success"] = true;
							$return["msg"] .= "Alterado Username;";
						} else {
							$return["success"] = false;
							$return["msg"] .= "Falha ao alterar username, erro na database;";
						}
					} else {
						$return["success"] = false;
						$return["msg"] .= "Este username ja está em uso;";
					}
				} else {
					$return["success"] = false;
					$return["msg"] .= "Este username não é válido;";
				}
			}
			if (isset($_DATA["nome"]) && !empty($_DATA["nome"])) {
				$nome = cleanstring($_DATA["nome"]);
				if (Check_Name($nome)) {
					$b = $con->prepare("UPDATE usuarios SET nome = ? WHERE id = ? ;");
					$b->bind_param("si", $nome, $user);
					$b->execute();
					if ($con->affected_rows) {
						$_SESSION["UserName"] = $nome;
						$return["success"] = true;
						$return["msg"] .= "Alterado Nome;";
					} else {
						$return["success"] = false;
						$return["msg"] .= "Falha ao alterar nome, erro na database;";
					}
				} else {
					$return["success"] = false;
					$return["msg"] .= "Este Nome não é válido;";
				}
			}


		} else {
			$return["success"] = false;
			$return["msg"] = "Sua senha atual está incorreta.";
		}
	} else {
		$return["success"] = false;
		$return["msg"] = "Preencha sua senha.";
	}
} else {
	$return["success"] = false;
	$return["msg"] = "Sua sessão encerrou.";
}

$userid = checksession($session_id);
if ($userid) {
	if (!empty($_DATA["marca"])) {
		$marca = cleanstring($_DATA["marca"], 255);
		$q = $con->query("SELECT * FROM `usuarios` WHERE `id` = '" . $_SESSION["UserID"] . "';");
		$rq = mysqli_fetch_array($q);
		if ($marca != $rq["marca"]) {
			$a = $con->prepare("UPDATE `usuarios` SET `marca` = ? WHERE `id` = ? ;");
			$a->bind_param("si", $marca, $userid);
			$a->execute();
			$return["success"] = (bool)$con->affected_rows;
			if ($return["success"]) {
				$_SESSION["UserMarca"] = cleanstring($_POST["urlmarca"]);
				$return["marca"] = $marca;
				$return["success"] = true;
				$return["msg"] = "Marca alterada com Sucesso";
			} else {
				$return["success"] = true;
				$return["msg"] = "Não atualizado";
			}
		} else {
			$return["success"] = false;
			$return["msg"] = "Sua marca é igual a anterior, nada alterado.";
		}
	} else {
		$return["success"] = false;
		$return["msg"] = "O link não é válido...";
	}

} else {
	$return["success"] = false;
	$return["msg"] = "Sua sessão encerrou.";
}