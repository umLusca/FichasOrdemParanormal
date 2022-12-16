<?php
require_once "./config/includes.php";
$c = con();
$a = $con->query("SELECT * FROM fichas_personagem WHERE id = 1");

$ra = mysqli_fetch_assoc($a);


function duplicate_row($row_infos, array $updates = null, array $excludes = null){
	$query_columns = "";
	$query_values = "";
	$bind_types = "";
	$bind_values = [];
	
	
	
	foreach ($row_infos as $item => $valor) {
		$i++;
		$continue = false;
		if (isset($updates[$item], $row_infos[$item])) {
			$valor = $updates[$item];
		}
		if (isset($excludes) && in_array($item, $excludes, true)) {
			$continue = true;
		}else {
			switch (gettype($valor)) {
				case "string":
					$bind_types .= "s";
					break;
				case "boolean":
				case "integer":
					$bind_types .= "i";
					break;
				case "NULL":
					$continue = true;
					break;
			}
		}
		
		if(!$continue) {
			$bind_values[] = $valor;
			$query_columns .= $item;
			$query_values .= "?";
			
			if ($i < count($row_infos)) {
				$query_values .= ", ";
				$query_columns .= ", ";
				
			}
		} else if ($i === count($row_infos)) {
			$query_values = substr($query_values,0,-2);
			$query_columns = substr($query_columns,0,-2);
		}
	}
	return array(
		"bind_types" => $bind_types,
		"query_columns" => $query_columns,
		"query_values" => $query_values,
		"bind_values" => $bind_values
	);
}



$gg = duplicate_row($ra,array("token"=>"dgfsdgsdfgsdg"),array("id"));

header("Content-Type: application/json");
var_dump($gg);
//echo json_encode($gg,JSON_PRETTY_PRINT);

$f = $con->prepare("INSERT INTO fichas_personagem({$gg["query_columns"]}) VALUES ({$gg["query_values"]})");
$f->bind_param($gg["bind_types"],...$gg["bind_values"]);
$f->execute();


?>