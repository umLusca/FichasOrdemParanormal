<?php

switch ($conj[2]) {
	default:
		$data = array(
			"success" => false,
			"msg" => "Query não encontrado!"
		);
		break;
	case "habtab":
		//Todo finalizar isso aki tbm
		if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {
			$id = cleanstring($_POST["id"], 36);

			$a = $con->prepare("DELETE FROM habilidades_tab WHERE token = ? and id_ficha in (SELECT id FROM fichas_personagem WHERE token = ?);");
			$a->execute([$id, $token]);
			$data["success"] = true;
			$data["msg"] = "Deletado" . $id;
		} else {

			$data["success"] = false;
			$data["msg"] = "Sem permissão";
		}
		break;
	case "switch":
		if (VerificarPermissaoFicha($token, $_SESSION["UserID"])) {
			$type = cleanstring($_POST["type"]);
			$iid = (int)$_POST["iid"];
			switch ($type) {
				case "habilidade":
					$q = $con->prepare("DELETE FROM `habilidades` WHERE `id` = ? AND `id_ficha` in (SELECT id FROM fichas_personagem WHERE token = ?);");
					break;
				case "poder":
					$q = $con->prepare("DELETE FROM `poderes` WHERE `id` = ? AND `id_ficha` in (SELECT id FROM fichas_personagem WHERE token = ?);");
					break;
				case "arma":
					$q = $con->prepare("DELETE from inventario WHERE id in (SELECT item_id FROM armas WHERE id = ?) AND id_ficha in (SELECT id from fichas_personagem where token = ?);");

					break;
				case "item":
					$q = $con->prepare("DELETE FROM `inventario` WHERE `id` = ? AND `id_ficha` in (SELECT id FROM fichas_personagem WHERE token = ?);");
					break;
				case "proficiencia":
					$q = $con->prepare("DELETE FROM `proeficiencias` WHERE `id` = ? AND `id_ficha` in (SELECT id FROM fichas_personagem WHERE token = ?)");
					break;
				case "ritual":
					$q = $con->prepare("DELETE FROM `rituais` WHERE `id` = ? AND `id_ficha` in (SELECT id FROM fichas_personagem WHERE token = ?);");
					break;
			}
			$q->execute([$iid, $token]);
		} else {
			$data["success"] = false;
			$data["msg"] = "Sem permissão";
		}
		break;
}
