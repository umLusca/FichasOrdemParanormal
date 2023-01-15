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
		        <img src='/assets/img/Atributes".($_SESSION["theme"]==="dark"?"":"_light").".webp' height='512' width='516' alt='Atributos'>
	        </div>";
	} else {
		$return ="
            <div class='containera mx-auto'>
                <input required class='atributos for atributos-input hex font2' type='number' min='$min' max='$max' value='$for' name='forca'     title='Força'/>
                <input required class='atributos agi atributos-input hex font2' type='number' min='$min' max='$max' value='$agi' name='agilidade' title='Agilidade'/>
                <input required class='atributos int atributos-input hex font2' type='number' min='$min' max='$max' value='$int' name='intelecto' title='Intelecto'/>
                <input required class='atributos pre atributos-input hex font2' type='number' min='$min' max='$max' value='$pre' name='presenca'  title='Presença'/>
                <input required class='atributos vig atributos-input hex font2' type='number' min='$min' max='$max' value='$vig' name='vigor'     title='Vigor'/>
                <img src='/assets/img/Atributes".($_SESSION["theme"]==="dark"?"":"_light").".webp' height='512' width='516' alt='Atributos'>
            </div>";
	}
	return $return;
}

function Super_options($tipo,$selecionado = null): string
{
    switch($tipo) {
        case "classes":
            $conjunto = ["Mundano","Combatente","Especialista","Ocultista"];
            break;
        case "trilhas":
            $conjunto = ["Nenhuma","Aniquilador","Comandante de Campo","Guerreiro","Operações Especiais","Tropa de Choque","Atirador de Elite","Infiltrador","Médico de Campo","Negociador","Técnico","Conduíte","Flagelador","Graduado","Intuitivo","Lâmina Paranormal"];
            break;
        case "origens":
            $conjunto = ["Acadêmico","Agente de Saúde","Amnésico","Artista","Atleta","Chef","Criminoso","Cultista Arrependido","Desgarrado","Engenheiro","Executivo","Investigador","Lutador","Magnata","Mercenário","Militar","Operário","Policial","Religioso","Servidor Público","Teórico da Conspiração","TI","Trabalhador Rural","Trambiqueiro","Universitário","Vítima"];
            break;
        case "patentes":
            $conjunto = ["Recruta","Operador","Agente Especial","Oficial de Operações", "Agente de Elite"];
            break;
        case "elementos":
            $conjunto = ["Medo","Sangue","Energia","Conhecimento", "Morte"];
            break;
    }
    $return = "";
    foreach ($conjunto as $item => $option){

        $return .= "<option "  .(($option == $selecionado)?"selected":"").  ">$option</option>";
    }
    return $return;
}

//Calculo bases
function calcularvida($nex, $classe, $vigor, $trilha = 0 , $origem = 0 , $extra = 0): int
{

	switch ($origem){
		case "Desgarrado":
			$extra += 1;
			break;
	}


	switch ($classe) {
        default:
            $pv = 8 + $vigor;
            break;
		case "Combatente":
			switch ($trilha){
				case "Tropa de Choque":
					$extra += 1;
					break;
			}
			$pv = (20 + $vigor + $extra) + ((4 + $vigor + $extra) * (floor(($nex / 5)) - 1));
			break;
		case "Especialista":
			$pv = (16 + $vigor + $extra) + ((3 + $vigor + $extra) * (floor(($nex / 5)) - 1));
			break;
		case "Ocultista":
			$pv = (12 + $vigor + $extra) + ((2 + $vigor + $extra) * (floor(($nex / 5)) - 1));
			break;
	}
	return $pv;
}
function calcularpe($nex, $classe, $presenca, $trilha = 0 , $origem = 0 , $extra = 0): int
{
	switch ($classe) {
        default:
            $pe = 1 + $presenca;
            break;
		case "Combatente":
			$pe = (2 + $presenca + $extra) + ((2 + $presenca + $extra) * (floor(($nex / 5) - 1)));
			break;
		case "Especialista":
			$pe = (3 + $presenca + $extra) + ((3 + $presenca + $extra) * (floor(($nex / 5) - 1)));
			break;
		case "Ocultista":
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
		case "Cultista Arrependido":
			$esp = 2;
			break;
		case "Vítima":
			$extra += 1;
			break;

	}
	switch ($classe) {
        default:
            $san = 8;
            break;
		case "Combatente":
			$san = ((12/ $esp) + $extra) + ((3 + $extra) * (floor(($nex / 5)) - 1));
			break;
        case "Especialista":
			$san = ((16/ $esp) + $extra) + ((4 + $extra) * (floor(($nex / 5)) - 1));
			break;
		case "Ocultista":
			$san = ((20/ $esp) + $extra) + ((5 + $extra) * (floor(($nex / 5)) - 1));
			break;
	}
	return $san;
}
function pesoinv($for, $int, $classe = 0,$trilha = 0,$origem = 0){

	if($classe == "Especialista" AND $trilha == "Técnico"){
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


function is($arr,$arg): bool
{
    return isset($arr[$arg]) && !empty($arr[$arg]);
}
//Verificações gerais
function VerificarID($id): bool
{
	$id = (int)$id;
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


function RolarMkII($dado_bruto, $dano = false, $margem = 20): array
{
	$index=0;
	$resultado = $print = $soma = null;
	$critico = false;
	$somatotal = 0;
	
	
	$saida = [];
	$dado_bruto = str_replace("-", "+-", $dado_bruto);
	$dado_fragmentado = explode('+', $dado_bruto);
	foreach ($dado_fragmentado as $valor_dado) {
		if (!empty($valor_dado)) {
			$separador = explode('d', $valor_dado);

			$quantidade = (int)$separador[0];
			$faces      = (int)$separador[1];
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
					$saida["dados"][$index]["dado"] = "d" . $faces;
					for ($i = 0; $i < $quantidade; $i++):
						$saida["dados"][$index]["rolagens"] = $i +1;
						$saida["dados"][$index]["resultados"][$i] = random_int(1, $faces);
						$resultado += $saida["dados"][$index]["resultados"][$i];
						$print .= (isset($print)?'+':"") . $saida["dados"][$index]["resultados"][$i];
					endfor;
				} else {
					for ($i = 0; $i < $quantidade; $i++):
						$saida["dados"][$index]["resultados"][$i] = random_int(1, $faces);
						if($saida["dados"][$index]["resultados"][$i] >= $margem){
							$critico = true;
						}
					endfor;
					$saida["dados"][$index]["rolagens"] = $quantidade;
					$saida["dados"][$index]["dado"] = "d".$faces;
					$saida["dados"][$index]["melhor"] = max($saida["dados"][$index]["resultados"]);
					$saida["dados"][$index]["pior"] = min($saida["dados"][$index]["resultados"]);
					$resultado += $saida["dados"][$index][$negative?"pior":"melhor"];
					$print .= (isset($print)?"+":'') . $saida["dados"][$index][$negative?"pior":"melhor"];
					$saida["dados"][$index]["resultado"] += $saida["dados"][$index][$negative?"pior":"melhor"];
			}
				$index++;
			} else {
				$somatotal += $quantidade;
				if ($quantidade > 0) {
					$quantidade = (isset($saida["print"])?"+":($negative?"-":"+")) . $quantidade;
				}
				$resultado += $quantidade;
				$print .= $quantidade;
				$soma .= $quantidade;
			}
		}
	}
	$saida["dano"] = (bool)$dano;
	$saida["critico"] = (bool)$critico;
	$saida["margem"] = $margem;
	$saida["soma"] = $somatotal;
	$saida["resultado"] = $resultado;
	$saida["print"] = $print;
	return ($saida);

}
function TirarPorcento($Valor_Atual, $Valor_Maximo)
{
	if(($Valor_Maximo==0 AND $Valor_Atual == 0) OR $Valor_Maximo == 0){return 0;}
	return minmax((($Valor_Atual/$Valor_Maximo) * 100),0,100);
}


function DadoDinamico(string $dado,array $arr = null): string
{
	if (str_contains($dado, "/")) {
	foreach ($arr as $i => $v){
		$dado = str_replace($i,$v,$dado);
	}
		$dado = str_replace("/", '', $dado);
	}
	return $dado;
}





