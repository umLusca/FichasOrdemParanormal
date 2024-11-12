<?php
if (checksession($session_id)) {
	$user = checksession($session_id);
	if (isset($_DATA["dados"]["dices"]) && is_array($_DATA["dados"]["dices"])) {
		foreach ($_DATA["dados"]["dices"] as $dice) {
			$stmt = autoPrepare($dice, ["token", "token_pai", "owner"], "dados_customizados", $con);
			$stmt["values"][] = $dice["token"];
			$stmt["values"][] = $user;
			$r = $con->prepare("UPDATE dados_customizados SET {$stmt["query"]} WHERE token = ? AND owner = ?");
			$r->execute($stmt["values"]);

		}
		$return["success"] = true;
	} else {
		$return["msg"] = "Objeto não compatível";
		$return["success"] = false;

	}
} else {
	$return["msg"] = "Sua sessão encerrou.";
	$return["success"] = false;
}