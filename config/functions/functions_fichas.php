<?php


//yep
function atributos($for, $agi, $int, $vig, $pre, $enabled = 1, $input = 0, $min = -10, $max = 10, $theme = "auto"): string
{
	global $minimo_atributo;
	global $maximo_atributo;
	$_theme = $_COOKIE["theme"] ?: "auto";
	if (!$input) {
		$return = "
            <div class='containera mx-auto'>
		        <button class='atributos for hex btn font2' " . ($enabled ? 'onclick=\'rolar({dado:"' . ValorParaRolarDado($for) . 'd20", dano: false,nome: "Força"});    \'' : 'disabled') . "><span class='text-body-emphasis'>" . $for . "</span></button>
		        <button class='atributos agi hex btn font2' " . ($enabled ? 'onclick=\'rolar({dado:"' . ValorParaRolarDado($agi) . 'd20", dano: false,nome: "Agilidade"});\'' : 'disabled') . "><span class='text-body-emphasis'>" . $agi . "</span></button>
		        <button class='atributos int hex btn font2' " . ($enabled ? 'onclick=\'rolar({dado:"' . ValorParaRolarDado($int) . 'd20", dano: false,nome: "Intelecto"});\'' : 'disabled') . "><span class='text-body-emphasis'>" . $int . "</span></button>
		        <button class='atributos pre hex btn font2' " . ($enabled ? 'onclick=\'rolar({dado:"' . ValorParaRolarDado($pre) . 'd20", dano: false,nome: "Presença"}); \'' : 'disabled') . "><span class='text-body-emphasis'>" . $pre . "</span></button>
		        <button class='atributos vig hex btn font2' " . ($enabled ? 'onclick=\'rolar({dado:"' . ValorParaRolarDado($vig) . 'd20", dano: false,nome: "Vigor"});    \'' : 'disabled') . "><span class='text-body-emphasis'>" . $vig . "</span></button>
		       </div>";
	} else {
		$return = "<div class='containera mx-auto'>
                <input required class='atributos for atributos-input hex font2' type='number' min='$minimo_atributo' max='$maximo_atributo' value='$for' name='forca'     title='Força'/>
                <input required class='atributos agi atributos-input hex font2' type='number' min='$minimo_atributo' max='$maximo_atributo' value='$agi' name='agilidade' title='Agilidade'/>
                <input required class='atributos int atributos-input hex font2' type='number' min='$minimo_atributo' max='$maximo_atributo' value='$int' name='intelecto' title='Intelecto'/>
                <input required class='atributos pre atributos-input hex font2' type='number' min='$minimo_atributo' max='$maximo_atributo' value='$pre' name='presenca'  title='Presença'/>
                <input required class='atributos vig atributos-input hex font2' type='number' min='$minimo_atributo' max='$maximo_atributo' value='$vig' name='vigor'     title='Vigor'/>
          </div>";
	}
	return $return;
}

function Super_options($tipo, $selecionado = null): string
{
	switch ($tipo) {
		case "classes":
			$conjunto = ["Mundano", "Combatente", "Especialista", "Ocultista"];
			break;
		case "trilhas":
			$conjunto = ["Nenhuma", "Aniquilador", "Comandante de Campo", "Guerreiro", "Operações Especiais", "Tropa de Choque", "Atirador de Elite", "Infiltrador", "Médico de Campo", "Negociador", "Técnico", "Conduíte", "Flagelador", "Graduado", "Intuitivo", "Lâmina Paranormal"];
			break;
		case "origens":
			$conjunto = ["Acadêmico", "Agente de Saúde", "Amnésico", "Artista", "Atleta", "Chef", "Cientista Forense", "Criminoso", "Cultista Arrependido", "Desgarrado", "Engenheiro", "Executivo", "Escritor", "Investigador", "Jornalista", "Lutador", "Magnata", "Mercenário", "Militar", "Operário", "Policial", "Professor", "Religioso", "Servidor Público", "Teórico da Conspiração", "TI", "Trabalhador Rural", "Trambiqueiro", "Universitário", "Vítima"];
			break;
		case "patentes":
			$conjunto = ["Recruta", "Operador", "Agente Especial", "Oficial de Operações", "Agente de Elite"];
			break;
		case "elementos":
			$conjunto = ["Medo", "Sangue", "Energia", "Conhecimento", "Morte"];
			break;
		case "tema":
			$conjunto = ["dark", "light", "auto"];
			break;
	}
	$return = "";
	foreach ($conjunto as $item => $option) {
		
		$return .= "<option " . (($option == $selecionado) ? "selected" : "") . ">$option</option>";
	}
	return $return;
}

//Calculo bases
function calcularvida($nex, $classe, $vigor, $trilha = "", $origem = "", $extra = 0, $skiplevel = 0, $soma = 0): int
{
	
	if ($origem === "Desgarrado") {
		++$extra;
	}
	
	if ($trilha === "Tropa de Choque") {
		++$extra;
	}
	
	
	$levels = floor(($nex / 5)) - 1;
	$levels = minmax($levels - $skiplevel, 0, 20);
	switch ($classe) {
		default:
			$pv = 8 + $vigor;
			break;
		case "Combatente":
			
			$pv = (20 + $vigor + $extra) + ((4 + $vigor + $extra) * $levels) + $soma;
			break;
		case "Especialista":
			$pv = (16 + $vigor + $extra) + ((3 + $vigor + $extra) * $levels) + $soma;
			break;
		case "Ocultista":
			$pv = (12 + $vigor + $extra) + ((2 + $vigor + $extra) * $levels) + $soma;
			break;
	}
	return $pv;
}

function calcularpe($nex, $classe, $presenca, $trilha = 0, $origem = 0, $extra = 0, $skiplevel = 0, $soma = 0): int
{
	$levels = floor(($nex / 5)) - 1;
	$levels = minmax($levels - $skiplevel, 0, 20);
	switch ($classe) {
		default:
			$pe = 1 + $presenca;
			break;
		case "Combatente":
			$pe = (2 + $presenca + $extra) + ((2 + $presenca + $extra) * $levels) + $soma;
			break;
		case "Especialista":
			$pe = (3 + $presenca + $extra) + ((3 + $presenca + $extra) * $levels) + $soma;
			break;
		case "Ocultista":
			$pe = (4 + $presenca + $extra) + ((4 + $presenca + $extra) * $levels) + $soma;
			break;
	}
	return $pe;
}

function calcularsan($nex, $classe, $trilha = 0, $origem = 0, $extra = 0, $skiplevel = 0, $soma = 0): int
{
	// Type 1: Start only;
	// Type 2: Start and nex;
	// Type 3: Nex Only
	$esp = 1;
	switch ($origem) {
		case "Cultista Arrependido":
			$esp = 2;
			break;
		case "Vítima":
			$extra += 1;
			break;
		
	}
	$levels = floor(($nex / 5)) - 1;
	$levels = minmax($levels - $skiplevel, 0, 20);
	switch ($classe) {
		default:
			$san = 8;
			break;
		case "Combatente":
			$san = ((12 / $esp) + $extra) + ((3 + $extra) * $levels) + $soma;
			break;
		case "Especialista":
			$san = ((16 / $esp) + $extra) + ((4 + $extra) * $levels) + $soma;
			break;
		case "Ocultista":
			$san = ((20 / $esp) + $extra) + ((5 + $extra) * $levels) + $soma;
			break;
	}
	return $san;
}

function pesoinv($for, $int, $classe = 0, $trilha = 0, $origem = 0)
{
	
	if ($trilha === "Técnico") {
		$max = $for + $int;
	} else {
		$max = $for;
	}
	
	if ($max === 0) {
		return 2;
	}
	
	return ($max * 5);
}


function is($arr, $arg): bool
{
	return isset($arr[$arg]) && !empty($arr[$arg]);
}

//Verificações gerais
function VerificarPermissaoFicha(string $token, int|null $user): bool
{
	$token = cleanstring($token);
	global $con;
	if (isset($user, $token) && !empty($user) && !empty($token)) {
		$q = $con->prepare("Select * FROM `fichas_personagem` WHERE `token` = ?;");
		$q->bind_param("s", $token);
		$q->execute();
		$q = $q->get_result();
		if ($q->num_rows) {
			$q = mysqli_fetch_assoc($q);
			
			if ($q["usuario"] === $user) {
				return true;
			}
			
			$a = $con->prepare("Select * FROM `ligacoes` WHERE `id_ficha` = ?;");
			$a->bind_param("i", $q["id"]);
			$a->execute();
			$a = $a->get_result();
			if ($a->num_rows) {
				$a = mysqli_fetch_assoc($a);
				if ($a["id_usuario"] === $user) {
					return true;
				}
				
				$b = $con->prepare("Select * FROM `missoes` WHERE id = ?;");
				$b->bind_param("i", $a["id_missao"]);
				$b->execute();
				$b = $b->get_result();
				if ($b->num_rows) {
					$b = mysqli_fetch_assoc($b);
					if ($b["mestre"] === $user) {
						return true;
					}
				}
				
			}
		}
	}
	return false;
}

function VerificarMestre($mid, $userid = null): bool
{
	global $con;
	if ($userid) {
		$user = $userid;
	} elseif (isset($_SESSION["UserID"])) {
		$user = $_SESSION["UserID"];
	} else {
		return false;
	}
	
	$t = $con->prepare("Select * FROM `missoes` WHERE `mestre` = ? AND (`token` = ? OR `id` = ?) ;");
	$t->execute([$_SESSION["UserID"], $mid, $mid]);
	$rt = $t->get_result();
	return (bool)$rt->num_rows;
}

//Functions Gerais
function ValorParaRolarDado($Atributo): int
{
	if ($Atributo >= 1) {
		return $Atributo;
	}
	return $Atributo - 2;
}

function DadoDinamico(string $dado, array $arr = null): string
{
	if (str_contains($dado, "/")) {
		foreach ($arr as $i => $v) {
			$dado = str_replace($i, $v, $dado);
		}
		$dado = str_replace("/", '', $dado);
	}
	return $dado;
}

function ClearRolar($dado, $Return_Error = false, $custom_dado = false): bool|array
{
	$success = true;
	if (!empty($dado)) {
		if ((preg_match('/^[\ddD+-]+\S$/', $dado) && $custom_dado === false) || (preg_match('/^([+-]?((100|\d{1,2}|\/[ADEFGINOPRTV]{3,4}\/)?((d)(100|[1-9]\d?|\/[ADEFGINOPRTV]{3,4}\/))?)|(\d{0,3}|1000))([+-]((100|\d{1,2}|\/[ADEFGINOPRTV]{3,4}\/)?((d)(100|[1-9]\d?|\/[ADEFGINOPRTV]{3,4}\/))?)|([+-]\d{0,3}|1000)?)*$/', $dado) && $custom_dado === true)) {
			
			$dado = str_replace("-", "+-", $dado);
			$a = explode('+', $dado);
			foreach ($a as $dados):
				if ($success && !empty($dados)) {
					$b = explode('d', $dados);
					$b[0] = (int)$b[0];
					if (($b[0] > 100 || $b[0] < -100) && isset($b[1])) {
						$success = false;
						$msg = "Não pode rolar mais de 100 dados de uma vez.";
					}
					if (($b[0] > 99999 || $b[0] < -99999) && !isset($b[1])) {
						$success = false;
						$msg = "Não pode somar mais de 10000 absolutamente.";
					}
					if ($b[1] > 100) {
						$success = false;
						$msg = "Não pode rolar dados com mais de 100 Lados.";
					}
				}
			endforeach;
			
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
	}
	
	return $success;
}

/**
 * @throws Exception
 */
function RolarMkII($dado_bruto, bool $dano = false, $margem = 20): array
{//todo corrigr dando crítico quando dado negativo dá 20 em algum dos dados
	$index = 0;
	$resultado = $print = $soma = null;
	$critico = false;
	$somatotal = 0;
	
	$saida = array(
		"soma" => 0,
		"margem" => $margem,
		"isDano" => $dano,
		"critico" => false,
		"print" => "",
		"resultado" => 0,
	);
	
	$dado_bruto = str_replace("-", "+-", $dado_bruto);
	$dado_fragmentado = explode('+', $dado_bruto);
	foreach ($dado_fragmentado as $valor_dado) {
		if (!empty($valor_dado)) {
			$separador = explode('d', $valor_dado);
			
			$quantidade = (int)$separador[0];
			$faces = (int)$separador[1];
			if ($quantidade === 0 && $faces) {
				$quantidade = 1;
			}
			if ($quantidade <= 0 && $faces) {
				$quantidade = abs($quantidade);
				$negative = true;
			} else {
				$negative = false;
			}
			if ($faces) {
				if ($dano) {
					$saida["dados"][$index]["dado"] = "d" . $faces;
					for ($i = 0; $i < $quantidade; $i++):
						$saida["dados"][$index]["rolagens"] = $i + 1;
						$saida["dados"][$index]["resultados"][$i] = rand(1, $faces);
						$saida["resultado"] += $saida["dados"][$index]["resultados"][$i];
						$saida["print"] .= (!empty($saida["print"]) ? '+' : "") . $saida["dados"][$index]["resultados"][$i];
					endfor;
				} else {
					for ($i = 0; $i < $quantidade; $i++):
						$saida["dados"][$index]["resultados"][$i] = rand(1, $faces);
					endfor;
					$saida["dados"][$index]["rolagens"] = $quantidade;
					$saida["dados"][$index]["dado"] = "d" . $faces;
					$saida["dados"][$index]["melhor"] = max($saida["dados"][$index]["resultados"]);
					$saida["dados"][$index]["pior"] = min($saida["dados"][$index]["resultados"]);
					$saida["resultado"] += $saida["dados"][$index][$negative ? "pior" : "melhor"];
					$saida["critico"] = ($saida["dados"][$index][$negative ? "pior" : "melhor"] >= $margem);
					$saida["print"] .= (!empty($saida["print"]) ? "+" : '') . $saida["dados"][$index][$negative ? "pior" : "melhor"];
					$saida["dados"][$index]["resultado"] += $saida["dados"][$index][$negative ? "pior" : "melhor"];
				}
				$index++;
			} else {
				$saida["soma"] += $quantidade;
				$saida["resultado"] += $quantidade;
				$saida["soma"] += $quantidade;
				$saida["print"] .= (($quantidade <= -1) ? "" : "+") . $quantidade;
			}
		}
	}
	return ($saida);
	
}

function TirarPorcento($Valor_Atual, $Valor_Maximo)
{
	if (($Valor_Maximo == 0 and $Valor_Atual == 0) or $Valor_Maximo == 0) {
		return 0;
	}
	return minmax((($Valor_Atual / $Valor_Maximo) * 100), 0, 100);
}







