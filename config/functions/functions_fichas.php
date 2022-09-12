<?php


//yep
function atributos($for,$agi,$int,$vig,$pre,$enabled=1,$input=0, $min = -10,$max = 10): string
{
	if (!$input){
		$return = "
            <div class='containera mx-auto'>
		        <button class='atributos for hex btn font2' " . ($enabled ? 'onclick=\'rolar("' . ValorParaRolarDado($for) . 'd20", 0,"Força");    \'' : 'disabled') . "><span>".$for."</span></button>
		        <button class='atributos agi hex btn font2' " . ($enabled ? 'onclick=\'rolar("' . ValorParaRolarDado($agi) . 'd20", 0,"Agilidade");\'' : 'disabled') . "><span>".$agi."</span></button>
		        <button class='atributos int hex btn font2' " . ($enabled ? 'onclick=\'rolar("' . ValorParaRolarDado($int) . 'd20", 0,"Intelecto");\'' : 'disabled') . "><span>".$int."</span></button>
		        <button class='atributos pre hex btn font2' " . ($enabled ? 'onclick=\'rolar("' . ValorParaRolarDado($pre) . 'd20", 0,"Presença"); \'' : 'disabled') . "><span>".$pre."</span></button>
		        <button class='atributos vig hex btn font2' " . ($enabled ? 'onclick=\'rolar("' . ValorParaRolarDado($vig) . 'd20", 0,"Vigor");    \'' : 'disabled') . "><span>".$vig."</span></button>
		        <img src='/assets/img/Atributes.webp' height='512' width='516' alt='Atributos'>
	        </div>";
	} else {
		$return ="
            <div class='containera mx-auto'>
                <input required class='atributos for atributos-input hex font2' type='number' min='$min' max='$max' value='$for' name='forca'     title='Força'/>
                <input required class='atributos agi atributos-input hex font2' type='number' min='$min' max='$max' value='$agi' name='agilidade' title='Agilidade'/>
                <input required class='atributos int atributos-input hex font2' type='number' min='$min' max='$max' value='$int' name='intelecto' title='Intelecto'/>
                <input required class='atributos pre atributos-input hex font2' type='number' min='$min' max='$max' value='$pre' name='presenca'  title='Presença'/>
                <input required class='atributos vig atributos-input hex font2' type='number' min='$min' max='$max' value='$vig' name='vigor'     title='Vigor'/>
                <img src='/assets/img/Atributes.webp' height='512' width='516' alt='Atributos'>
            </div>";
	}
	return $return;
}



//Calculo bases
function calcularvida($nex, $classe, $vigor, $trilha = 0 , $origem = 0 , $extra = 0): int
{
	switch ($origem){
		case 8:
			$extra += 1;
			break;
	}


	switch ($classe) {
		default:
			switch ($trilha){
				case 5:
					$extra += 1;
					break;
			}
			$pv = (20 + $vigor + $extra) + ((4 + $vigor + $extra) * (floor(($nex / 5)) - 1));
			break;
		case 2:
			$pv = (16 + $vigor + $extra) + ((3 + $vigor + $extra) * (floor(($nex / 5)) - 1));
			break;
		case 3:
			$pv = (12 + $vigor + $extra) + ((2 + $vigor + $extra) * (floor(($nex / 5)) - 1));
			break;
	}
	return $pv;
}
function calcularpe($nex, $classe, $presenca, $trilha = 0 , $origem = 0 , $extra = 0): int
{
	switch ($classe) {
		default:
			$pe = (2 + $presenca + $extra) + ((2 + $presenca + $extra) * (floor(($nex / 5) - 1)));
			break;
		case 2:
			$pe = (3 + $presenca + $extra) + ((3 + $presenca + $extra) * (floor(($nex / 5) - 1)));
			break;
		case 3:
			$pe = (4 + $presenca + $extra) + ((4 + $presenca + $extra) * (floor(($nex / 5) - 1)));
			break;
	}
	return $pe;
}
function calcularsan($nex, $classe, $trilha = 0 , $origem = 0 , $extra = 0, $extra_type = 0): int
{
	// Type 1: Start only;
	// Type 2: Start and nex;
	// Type 3: Nex Only
	$esp = 1;
	switch ($origem){
		case 7:
			$esp = 2;
			break;
		case 26:
			$extra += 1;
			break;

	}
	switch ($classe) {
		default:
			$san = ((12/ $esp) + $extra) + ((3 + $extra) * (floor(($nex / 5)) - 1));
			break;
		case 2:
			$san = ((16/ $esp) + $extra) + ((4 + $extra) * (floor(($nex / 5)) - 1));
			break;
		case 3:
			$san = ((20/ $esp) + $extra) + ((5 + $extra) * (floor(($nex / 5)) - 1));
			break;
	}
	return $san;
}
function pesoinv($for, $int, $classe = 0,$trilha = 0,$origem = 0){

	if($classe == 2 AND $trilha == 5){
		$max = $for + $int;
	} else {
		$max = $for;
	}

	if($max == 0){
		return 2;
	} else {
		return ($max*5);
	}
}


//Verificações gerais
function VerificarID($id): bool
{
	$id = intval($id);
	if (isset($_SESSION["UserID"])) {
		$userid = $_SESSION["UserID"];
		if ($id > 0) {
			$con = con();
			$q = $con->prepare("Select * FROM `fichas_personagem` WHERE `id` = ? AND `usuario` = ? ;");
			$q->bind_param("ii", $id, $userid);
			$q->execute();
			$rq = $q->get_result();
			$a = $con->prepare("Select * FROM `ligacoes` WHERE `id` = ? AND `id_usuario` = ?");
			$a->bind_param("ii", $id, $userid);
			$a->execute();
			$aq = $a->get_result();
			if ($rq->num_rows > 0 || $aq->num_rows > 0) {
				return true;
			}
		}
	}
	return false;
}
function VerificarMestre($mid): bool
{
	$con = con();
	if (isset($_SESSION["UserID"]) AND isset($mid)){
		$t = $con->prepare("Select * FROM `missoes` WHERE `mestre` = ? AND (`token` = ? OR `id` = ?) ;");
		$t->bind_param('isi', $_SESSION["UserID"], $mid,$mid);
		$t->execute();
		$rt = $t->get_result();
		return $rt->num_rows;
	} else {
		return false;
	}
}
//Functions Gerais
function ValorParaRolarDado($Atributo): int
{
	if($Atributo >= 1) {
		return $Atributo;
	} else if ($Atributo == 0) {
		return $Atributo-2;
	} else {
		return $Atributo -2;
	}
}
function ClearRolar($dado, $Return_Error = false): bool|array
{
	$success = true;
	if (!empty($dado)) {
		if (preg_match('/^[\ddD+-]+\S$/', $dado)) {
			if ($success) {
				$dado = str_replace("-", "+-", $dado);
				$a = explode('+', $dado);
				foreach ($a as $dados):
					if ($success) {
						if (!empty($dados)) {
							$b = explode('d', $dados);
							$b[0] = intval($b[0]);
							if (($b[0] > 50 || $b[0] < -50) and isset($b[1])) {
								$success = false;
								$msg = "Não pode rolar mais de 50 dados de uma vez.";
							}
							if (($b[0] > 9999 || $b[0] < -9999) and !isset($b[1])) {
								$success = false;
								$msg = "Não pode somar mais de 1000 absolutamente.";
							}
							if ($b[1] > 100) {
								$success = false;
								$msg = "Não pode rolar dados com mais de 100 Lados.";
							}
						}
					}
				endforeach;
			}
		} else {
			$success = false;
			$msg = "Preencha o campo de forma devida! ('D' minúsculo, caso isso)";
		}
	} else {
		$success = false;
		$msg = "Preencha o campo!";
	}
	$data["success"] = $success;
	$data["msg"] = $msg;
	if ($Return_Error) {
		return $data;
	} else {
		return $success;
	}
}
function Rolar($dado, $dano = false): array
{
	$result = [];
	$dado = str_replace("-", "+-", $dado);
	$a = explode('+', $dado);
	foreach ($a as $nome => $dados) {
		if (!empty($dados)) {
			$b = explode('d', $dados);
			$b[0] = intval($b[0]);
			if ($b[0] == 0 and isset($b[1])) {
				$b[0] = 1;
			} else
				if ($b[0] < 0 and isset($b[1])) {
					$b[0] = abs($b[0]);
					$negative = true;
				}
			if (!empty($b[1])) {
				$roll = $b[0]; // quantidade de dados que vão ser jogados
				$rice = $b[1]; // quantida de lados dos dados
				if ($dano) {
					while ($result["d" . $nome]["TotalRolls"] != $roll) {
						$result["d" . $nome]["TotalRolls"] += 1;
						$result["d" . $nome]["rolls"][] =
						$result["d" . $nome]["d" . $rice]["d" . $result["d" . $nome]["TotalRolls"]] = random_int(1, $rice);
						$result["result"] += $result["d" . $nome]["d" . $rice]["d" . $result["d" . $nome]["TotalRolls"]];
						$result["print"] .= (isset($result["print"])?'+':"") . $result["d" . $nome]["d" . $rice]["d" . $result["d" . $nome]["TotalRolls"]];
					}
					$result["d" . $nome]["dado"] = "d" . $rice;
				} else {
					while ($result["d".$nome]["TotalRolls"] != $roll) {
						$result["d" . $nome]["TotalRolls"] += 1;
						$result["d" . $nome]["rolls"][] =
						$result["d" . $nome]["d" . $rice]["d" . $result["d" . $nome]["TotalRolls"]] = rand(1, $rice);
					}
					$result["d" . $nome]["dado"] = "d" . $rice;
					$result["d" . $nome]["bestroll"] = max($result["d" . $nome]["d" . $rice]);
					$result["d" . $nome]["worstroll"] = min($result["d" . $nome]["d" . $rice]);

					$result["result"] += $result["d" . $nome][$negative?"worstroll":"bestroll"];
					$result["print"] .= (isset($result["print"])?"+":'') . $result["d" . $nome][$negative?"worstroll":"bestroll"];
					$result["d" . $nome]["result"] += $result["d" . $nome][$negative?"worstroll":"bestroll"];
				}
			} else {
				if ($b[0] > 0) {
					$b[0] = (isset($result["print"])?"+":"-"). $b[0];
				}
				$result["result"] += $b[0];
				$result["print"] .= $b[0];
				$result["soma"] = $b[0];
			}
		}
	}
	return ($result);
}



function RolarMkII($dado_bruto, $dano = false): array
{
	$index=0;
	$resultado = $print = $soma = null;

	$saida = [];	$dado_bruto = str_replace("-", "+-", $dado_bruto);
	$dado_fragmentado = explode('+', $dado_bruto);
	foreach ($dado_fragmentado as $valor_dado) {
		if (!empty($valor_dado)) {
			$separador = explode('d', $valor_dado);

			$quantidade = intval($separador[0]);
			$faces      = intval($separador[1]);
			if ($quantidade == 0 and $faces) {
				$quantidade = 1;
			}
			if ($quantidade < 0 and $faces) {
				$quantidade = abs($quantidade);
				$negative = true;
			} else {
				$negative = false;
			}
			if ($faces) {
				if ($dano) {
					$saida[$index]["dado"] = "d" . $faces;
					for ($i = 0; $i < $quantidade; $i++):
						$saida[$index]["rolagens"] = $i +1;
						$saida[$index]["resultados"][$i] = rand(1, $faces);
						$resultado += $saida[$index]["resultados"][$i];
						$print .= (isset($print)?'+':"") . $saida[$index]["resultados"][$i];
					endfor;
				} else {
					for ($i = 0; $i < $quantidade; $i++):
						$saida[$index]["resultados"][$i] = rand(1, $faces);
					endfor;
					$saida[$index]["rolagens"] = $quantidade;
					$saida[$index]["dado"] = "d".$faces;
					$saida[$index]["melhor"] = max($saida[$index]["resultados"]);
					$saida[$index]["pior"] = min($saida[$index]["resultados"]);
					$resultado += $saida[$index][$negative?"pior":"melhor"];
					$print .= (isset($print)?"+":'') . $saida[$index][$negative?"pior":"melhor"];
					$saida[$index]["resultado"] += $saida[$index][$negative?"pior":"melhor"];
			}
				$index++;
			} else {
				if ($quantidade > 0) {
					$quantidade = (isset($saida["print"])?"+":($negative?"-":"+")) . $quantidade;
				}
				$resultado += $quantidade;
				$print .= $quantidade;
				$soma .= $quantidade;
			}
		}
	}
	$saida["resultado"] = $resultado;
	$saida["print"] = $print;
	return ($saida);

}

function TirarPorcento($Valor_Atual, $Valor_Maximo)
{
	if(($Valor_Maximo==0 AND $Valor_Atual == 0) OR $Valor_Maximo == 0){return 0;}
	return minmax((($Valor_Atual/$Valor_Maximo) * 100),0,100);
}




function DadoDinamico($dado, $FOR=1, $AGI=1, $INT=1, $PRE=1, $VIG=1,): string
{
	$FOR = minmax($FOR,0,10);
	$AGI = minmax($AGI,0,10);
	$INT = minmax($INT,0,10);
	$PRE = minmax($PRE,0,10);
	$VIG = minmax($VIG,0,10);
	if (str_contains($dado, "/")) {
		$dado = str_replace("FOR", $FOR, $dado);
		$dado = str_replace("AGI", $AGI, $dado);
		$dado = str_replace("INT", $INT, $dado);
		$dado = str_replace("PRE", $PRE, $dado);
		$dado = str_replace("VIG", $VIG, $dado);
		$dado = str_replace("/", '', $dado);

	}
	return $dado;
}





