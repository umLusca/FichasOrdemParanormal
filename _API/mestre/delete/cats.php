<?php

switch ($conj[2]) {
	default:
		$data = array(
			"success" => false,
			"msg" => "Query não encontrado!"
		);
		break;
	case 'nota':
		$nid = (int)$_POST["note"];
		$tvar = $con->prepare("DELETE FROM `notes` WHERE `id` = ? AND `missao` in (SELECT id FROM missoes WHERE token =? AND mestre = ?)");
		$tvar->bind_param("isi", $nid, $token, $_SESSION["UserID"]);
		$tvar->execute();
		break;
	case 'iniciativa':
		$initid = (int)$_POST["iniciativa_id"];
		$f = $con->prepare("DELETE FROM `iniciativas` WHERE  `id`= ? AND `id_missao` in (SELECT id FROM missoes WHERE token = ? AND mestre = ?);");
		$f->bind_param("isi", $initid, $token, $_SESSION["UserID"]);
		$f->execute();
		break;
	case 'fichanpc':
		$npc = (int)$_POST["npc"];
		$f = $con->prepare("DELETE FROM `fichas_npc` WHERE `id` = ? AND missao in (SELECT id FROM missoes WHERE mestre = ? AND token = ?)");
		$f->bind_param("iis", $npc, $_SESSION["UserID"], $token);
		$f->execute();
		break;
	case 'player':
		$p = (int)$_POST["p"];

		$f = $con->prepare("DELETE FROM `ligacoes` WHERE `id_ficha`=? AND `id_missao`in(SELECT id from missoes WHERE missoes.token =? AND mestre = ?);");
		$f->bind_param("isi", $p, $token, $_SESSION["UserID"]);
		$f->execute();

		break;
}