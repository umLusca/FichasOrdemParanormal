<?php
if (isset($_FILES["file"])) {
	$file_size = $_FILES['file']['size'];
	if (($file_size !== 0 && $file_size < 1024 * 1024)) {
		$url = save_image($_FILES["file"], $type);
		if ($url) {
			$return["url"] = $url;
			$return["success"] = true;
			$return["msg"] = "Sucesso!";
		} else {
			$return["url"] = "";
			$return["success"] = false;
			$return["msg"] = "Falha!";
		}
	} else {
		$return["url"] = "";
		$return["success"] = false;
		$return["msg"] = "Arquivo grande (>1MB)";
	}
} else {
	$return["url"] = "";
	$return["success"] = false;
	$return["msg"] = "Arquivo não encontrado.";
}