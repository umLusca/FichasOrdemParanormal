<?php

$token = cleanstring($_DATA["token"]);
if (checksession($session_id)) {
	$user = checksession($session_id);
	if (VerificarPermissaoFicha($token, $user)) {

		$a = $con->prepare("SELECT * FROM `fichas_personagem` WHERE `token`= ? AND `usuario` = ?;");
		$a->bind_param("si", $token, $user);
		$a->execute();
		$a = $a->get_result();
		if ($a->num_rows) {# Encontrou a components
			if (isset($_DATA["dados"]) && !empty($_DATA["dados"] && is_array($_DATA["dados"]))) {
				$return["success"] = false;


				if (isset($_DATA["dados"]["habilidades"]) && is_array($_DATA["dados"]["habilidades"])) {
					foreach ($_DATA["dados"]["habilidades"] as $hab) {
						$r = $con->prepare("DELETE FROM habilidades WHERE id = ? AND id_ficha in (SELECT id FROM fichas_personagem WHERE token =?)");
						$r->execute([$hab["id"], $token]);
					}
					$return["success"] = true;
				}
				if (isset($_DATA["dados"]["poderes"]) && is_array($_DATA["dados"]["poderes"])) {
					foreach ($_DATA["dados"]["poderes"] as $poder) {
						$r = $con->prepare("DELETE FROM poderes WHERE id = ? AND id_ficha in (SELECT id from fichas_personagem where token = ?) ");
						$r->execute([$poder["id"], $token]);
					}
					$return["success"] = true;
				}
				if (isset($_DATA["dados"]["itens"]) && is_array($_DATA["dados"]["itens"])) {
					foreach ($_DATA["dados"]["itens"] as $item) {
						$r = $con->prepare("DELETE FROM inventario WHERE id = ? AND id_ficha in (SELECT id from fichas_personagem where token = ?) ");
						$r->execute([$item["id"], $token]);
					}
					$return["success"] = true;
				}

				if (isset($_DATA["dados"]["armas"]) && is_array($_DATA["dados"]["armas"])) {
					foreach ($_DATA["dados"]["armas"] as $arma) {
						$q = $con->prepare("DELETE from inventario WHERE id in (SELECT item_id FROM armas WHERE id = ?) AND id_ficha  in (SELECT id from fichas_personagem where token = ?);");
						$q->execute([$arma["id"], $token]);
						$return["success"] = true;
					}
				}
				if (isset($_DATA["dados"]["rituais"]) && is_array($_DATA["dados"]["rituais"])) {
					foreach ($_DATA["dados"]["rituais"] as $ritual) {
						$r = $con->prepare("DELETE FROM rituais WHERE id = ? AND id_ficha in (SELECT id from fichas_personagem where token = ?) ");
						$r->execute([$ritual["id"], $token]);
					}
					$return["success"] = true;
				}

				if (isset($_DATA["dados"]["proficiencias"]) && is_array($_DATA["dados"]["proficiencias"])) {
					foreach ($_DATA["dados"]["proficiencias"] as $proficiencia) {

						$r = $con->prepare("DELETE FROM proeficiencias WHERE id = ? AND id_ficha in (SELECT id FROM fichas_personagem WHERE token = ?)");
						$r->execute([$proficiencia["id"], $token]);

					}
					$return["success"] = true;
				}
			} else {
				$return["msg"] = "Nenhum dado a ser alterado..";
				$return["success"] = false;
			}
		} else {
			$return["success"] = false;
			$return["msg"] = 'Falha ao encontrar components.';
		}
	} else {
		$return["success"] = false;
		$return["msg"] = 'Sem permissão.';
	}
} else {
	$return["success"] = false;
	$return["msg"] = 'Sua sessão encerrou.';
}