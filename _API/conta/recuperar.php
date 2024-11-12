<?php
if (!empty($_DATA["email"])) {
	$email = cleanstring($_DATA["email"]);
	if (Check_Email($email)) {
		$s = $con->query("SELECT * FROM `usuarios` WHERE `email` = '" . $email . "'");
		if ($s->num_rows > 0) {
			$ds = mysqli_fetch_array($s);

			$hash = md5(md5($email) . md5($ds["nome"]) . strtotime(date('m/d/Y h:i:s')));

			$k = $con->prepare("INSERT INTO `recuperar_senha` (`id_usuario`,`hash`,`email`,`data`) VALUES ( ? , ? , ? ,NOW())");

			if ($k->execute([$ds["id"], $hash, $email])) {
				$link = "https://fichasop.com/conta/recuperar?recovery=" . $hash;

				$emailmsg = emailContent("recuperar", $link);
				if (Send_Email('Recuperar Conta', $email, $emailmsg)) {
					$return["success"] = true;
					$return["msg"] = 'Email enviado! Verifique sua caixa de email.';
				} else {
					$return["success"] = false;
					$return["msg"] = "Falha ao enviar! contate um administrador.";
				}
			} else {
				$return["success"] = false;
				$return["msg"] = "Falha interna no servidor.";
			}
		} else {
			$return["success"] = false;
			$return["msg"] = 'Email não cadastrado.';
		}

	} else {
		$return["msg"] = "Email não é válido.";
		$return["success"] = false;
	}
} else {
	$return["success"] = false;
	$return["msg"] = "Preencha seu email.";
}