<?php


if (!empty($_DATA["nome"])) { // ok
	$nome = cleanstring($_DATA["nome"], 50);

	if (!empty($_DATA["login"])) {
		$login = cleanstring($_DATA["login"]);

		if (!empty($_DATA["email"])) {
			$email = cleanstring($_DATA["email"]);

			if (!empty($_DATA["senha"] || $_DATA["csenha"])) {
				$senha = cleanstring($_DATA["senha"]);

				if (Check_Name($nome)) {
					if (Check_Login($login) && strlen($login) < 16) {
						if (Check_Email($email)) {
							if (Check_Pass($_DATA["senha"], $_DATA["csenha"])) {
								$a = $con->prepare("SELECT * FROM `usuarios` WHERE `login` = ? or email = ?");
								$a->bind_param("ss", $login, $email);
								$a->execute();
								$a = $a->get_result();
								if (!$a->num_rows) {
									$q = $con->prepare("INSERT INTO `usuarios`(`nome`,`login`,`senha`,`email`,`token`) VALUES (?,?,?,?,uuid());");
									$hash = PassCheck($senha);
									$q->bind_param("ssss", $nome, $login, $hash, $email);
									$q->execute();
									$id = $q->insert_id;
									if ($con->affected_rows > 0) {
										$f = $con->prepare("SELECT * FROM usuarios WHERE id = ?");
										$f->execute([$id]);

										$f = mysqli_fetch_assoc($f->get_result());
										logar($f["id"]);
										$return["success"] = true;
										$return["msg"] = "Conta criada!";

										$token = remember_me($f["id"], 7, generateRandomString(3));
										$conta["nome"] = $f["nome"];
										$conta["email"] = $f["email"];
										$conta["login"] = $f["login"];
										$conta["token"] = $token;

									} else {
										$return["success"] = false;
										$return["msg"] = "Falha ao criar conta!";
									}
								} else {
									$a = mysqli_fetch_assoc($a);
									if ((int)$a["status"]) {
										$return["success"] = false;
										$return["msg"] = "Email/User já cadastrado.";
										if ($a["email"] === $email) {
											$return["msg"] = "Email já cadastrado.";

										}
										if ($a["login"] === $login) {
											$return["msg"] = "User já cadastrado.";

										}
									} else {
										$q = $con->prepare("UPDATE `usuarios` SET `nome` = ? ,`login` = ?,`senha` = ? , `status` = 1 WHERE `email` = ? ");
										$q->bind_param("ssss", $nome, $login, $senha, $email);
										$q->execute();
										if ($q->affected_rows) {
											logar($login);
											$token = remember_me($a["id"], 7, isMobile() ? "APP" : "WEB");

											$conta["nome"] = $a["nome"];
											$conta["email"] = $a["email"];
											$conta["login"] = $a["login"];
											$conta["token"] = $token;

											$return["success"] = true;
											$return["msg"] = "Conta criada!";
										} else {
											$return["success"] = false;
											$return["msg"] = "Falha ao criar conta!";
										}
									}
								}
							} else {
								$er = Check_Pass($_DATA["senha"], $_DATA["csenha"], true);
								$return["success"] = false;
								$return["msg"] = $er["msg"];
							}
						} else {
							$return["msg"] = "Email inválido.";
							$return["success"] = false;
						}
					} else {
						$return["success"] = false;
						$return["msg"] = "Seu username só pode ter letras, números e \"_\"";
					}
				} else {
					$return["msg"] = "Seu nome só pode ter letras e espaços.";
					$return["success"] = false;
				}
			} else {
				$return["success"] = false;
				$return["msg"] = "Insira uma senha.";
			}
		} else {
			$return["success"] = false;
			$return["msg"] = "Insira um email.";
		}
	} else {
		$return["success"] = false;
		$return["msg"] = "Insira um username.";
	}
} else {
	$return["success"] = false;
	$return["msg"] = "Insira um nome.";
}      if (!empty($_DATA["nome"])) { // ok
	$nome = cleanstring($_DATA["nome"], 50);

	if (!empty($_DATA["login"])) {
		$login = cleanstring($_DATA["login"]);

		if (!empty($_DATA["email"])) {
			$email = cleanstring($_DATA["email"]);

			if (!empty($_DATA["senha"] || $_DATA["csenha"])) {
				$senha = cleanstring($_DATA["senha"]);

				if (Check_Name($nome)) {
					if (Check_Login($login) && strlen($login) < 16) {
						if (Check_Email($email)) {
							if (Check_Pass($_DATA["senha"], $_DATA["csenha"])) {
								$a = $con->prepare("SELECT * FROM `usuarios` WHERE `login` = ? or email = ?");
								$a->bind_param("ss", $login, $email);
								$a->execute();
								$a = $a->get_result();
								if (!$a->num_rows) {
									$q = $con->prepare("INSERT INTO `usuarios`(`nome`,`login`,`senha`,`email`,`token`) VALUES (?,?,?,?,uuid());");
									$hash = PassCheck($senha);
									$q->bind_param("ssss", $nome, $login, $hash, $email);
									$q->execute();
									$id = $q->insert_id;
									if ($con->affected_rows > 0) {
										$f = $con->prepare("SELECT * FROM usuarios WHERE id = ?");
										$f->execute([$id]);

										$f = mysqli_fetch_assoc($f->get_result());
										logar($f["id"]);
										$return["success"] = true;
										$return["msg"] = "Conta criada!";

										$token = remember_me($f["id"], 7, generateRandomString(3));
										$conta["nome"] = $f["nome"];
										$conta["email"] = $f["email"];
										$conta["login"] = $f["login"];
										$conta["token"] = $token;

									} else {
										$return["success"] = false;
										$return["msg"] = "Falha ao criar conta!";
									}
								} else {
									$a = mysqli_fetch_assoc($a);
									if ((int)$a["status"]) {
										$return["success"] = false;
										$return["msg"] = "Email/User já cadastrado.";
										if ($a["email"] === $email) {
											$return["msg"] = "Email já cadastrado.";

										}
										if ($a["login"] === $login) {
											$return["msg"] = "User já cadastrado.";

										}
									} else {
										$q = $con->prepare("UPDATE `usuarios` SET `nome` = ? ,`login` = ?,`senha` = ? , `status` = 1 WHERE `email` = ? ");
										$q->bind_param("ssss", $nome, $login, $senha, $email);
										$q->execute();
										if ($q->affected_rows) {
											logar($login);
											$token = remember_me($a["id"], 7, isMobile() ? "APP" : "WEB");

											$conta["nome"] = $a["nome"];
											$conta["email"] = $a["email"];
											$conta["login"] = $a["login"];
											$conta["token"] = $token;

											$return["success"] = true;
											$return["msg"] = "Conta criada!";
										} else {
											$return["success"] = false;
											$return["msg"] = "Falha ao criar conta!";
										}
									}
								}
							} else {
								$er = Check_Pass($_DATA["senha"], $_DATA["csenha"], true);
								$return["success"] = false;
								$return["msg"] = $er["msg"];
							}
						} else {
							$return["msg"] = "Email inválido.";
							$return["success"] = false;
						}
					} else {
						$return["success"] = false;
						$return["msg"] = "Seu username só pode ter letras, números e \"_\"";
					}
				} else {
					$return["msg"] = "Seu nome só pode ter letras e espaços.";
					$return["success"] = false;
				}
			} else {
				$return["success"] = false;
				$return["msg"] = "Insira uma senha.";
			}
		} else {
			$return["success"] = false;
			$return["msg"] = "Insira um email.";
		}
	} else {
		$return["success"] = false;
		$return["msg"] = "Insira um username.";
	}
} else {
	$return["success"] = false;
	$return["msg"] = "Insira um nome.";
}