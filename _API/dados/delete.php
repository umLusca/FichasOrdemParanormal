<?php

$token = cleanstring($_DATA["token"]);
$user = checksession($session_id);
if ($user) {
	if (isset($_DATA["dados"]["dices"]) && is_array($_DATA["dados"]["dices"])) {
		$return["success"] = false;
		foreach ($_DATA["dados"]["dices"] as $dice) {
			$r = $con->prepare("DELETE FROM dados_customizados WHERE owner = ? and token = ?");
			$r->execute([$user, $dice["token"]]);
			if ($r->affected_rows) $return["success"] = true;
		}

	}
} else {
	$return["success"] = false;
	$return["msg"] = "Sem permissão.";
}