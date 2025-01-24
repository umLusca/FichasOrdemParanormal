<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\CellIterator;

function checkPassword($pwd, &$errors): bool
{
	$errors_init = $errors;
	if (strlen($pwd) < 8) {
		$errors[] = "A senha precisa ter pelo menos 8 caracteres!";
	}
	if (!preg_match("#[0-9]+#", $pwd)) {
		$errors[] = "A senha precisa ter algum número";
	}
	if (!preg_match("#[a-zA-Z]+#", $pwd)) {
		$errors[] = "A senha precisa ter alguma letra";
	}
	return ($errors == $errors_init);
}


function readSpreadsheet(string $filePath): false|array
{
	try {
		// Carregar a planilha
		$spreadsheet = IOFactory::load($filePath);

		// Obter a planilha ativa (a primeira, por padrão)
		$worksheet = $spreadsheet->getActiveSheet();

		// Ler os dados
		$data = [];
		foreach ($worksheet->getRowIterator() as $row) {
			if ($row->isEmpty(CellIterator::TREAT_EMPTY_STRING_AS_EMPTY_CELL | CellIterator::TREAT_NULL_VALUE_AS_EMPTY_CELL)) { // Ignore empty rows
				continue;
			}

			$cellData = [];
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); // Isto percorre todas as células, mesmo vazias

			foreach ($cellIterator as $cell) {

				$cellData[] = $cell->getValue();
			}
			$data[] = $cellData;
		}

		return $data;
	} catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
		return false;
	}
}

function rearrangeFiles($vector): array
{

	$result = array();

	foreach ($vector as $key1 => $value1) foreach ($value1 as $key2 => $value2) $result[$key2][$key1] = $value2;

	return $result;

}

function removerAcentos($string)
{
	if (!preg_match('/[\x80-\xff]/', $string)) return $string;

	$chars = array(
		// Decompositions for Latin-1 Supplement
		chr(195) . chr(128) => 'A',
		chr(195) . chr(129) => 'A',
		chr(195) . chr(130) => 'A',
		chr(195) . chr(131) => 'A',
		chr(195) . chr(132) => 'A',
		chr(195) . chr(133) => 'A',
		chr(195) . chr(135) => 'C',
		chr(195) . chr(136) => 'E',
		chr(195) . chr(137) => 'E',
		chr(195) . chr(138) => 'E',
		chr(195) . chr(139) => 'E',
		chr(195) . chr(140) => 'I',
		chr(195) . chr(141) => 'I',
		chr(195) . chr(142) => 'I',
		chr(195) . chr(143) => 'I',
		chr(195) . chr(145) => 'N',
		chr(195) . chr(146) => 'O',
		chr(195) . chr(147) => 'O',
		chr(195) . chr(148) => 'O',
		chr(195) . chr(149) => 'O',
		chr(195) . chr(150) => 'O',
		chr(195) . chr(153) => 'U',
		chr(195) . chr(154) => 'U',
		chr(195) . chr(155) => 'U',
		chr(195) . chr(156) => 'U',
		chr(195) . chr(157) => 'Y',
		chr(195) . chr(159) => 's',
		chr(195) . chr(160) => 'a',
		chr(195) . chr(161) => 'a',
		chr(195) . chr(162) => 'a',
		chr(195) . chr(163) => 'a',
		chr(195) . chr(164) => 'a',
		chr(195) . chr(165) => 'a',
		chr(195) . chr(167) => 'c',
		chr(195) . chr(168) => 'e',
		chr(195) . chr(169) => 'e',
		chr(195) . chr(170) => 'e',
		chr(195) . chr(171) => 'e',
		chr(195) . chr(172) => 'i',
		chr(195) . chr(173) => 'i',
		chr(195) . chr(174) => 'i',
		chr(195) . chr(175) => 'i',
		chr(195) . chr(177) => 'n',
		chr(195) . chr(178) => 'o',
		chr(195) . chr(179) => 'o',
		chr(195) . chr(180) => 'o',
		chr(195) . chr(181) => 'o',
		chr(195) . chr(182) => 'o',
		chr(195) . chr(182) => 'o',
		chr(195) . chr(185) => 'u',
		chr(195) . chr(186) => 'u',
		chr(195) . chr(187) => 'u',
		chr(195) . chr(188) => 'u',
		chr(195) . chr(189) => 'y',
		chr(195) . chr(191) => 'y',
		// Decompositions for Latin Extended-A
		chr(196) . chr(128) => 'A',
		chr(196) . chr(129) => 'a',
		chr(196) . chr(130) => 'A',
		chr(196) . chr(131) => 'a',
		chr(196) . chr(132) => 'A',
		chr(196) . chr(133) => 'a',
		chr(196) . chr(134) => 'C',
		chr(196) . chr(135) => 'c',
		chr(196) . chr(136) => 'C',
		chr(196) . chr(137) => 'c',
		chr(196) . chr(138) => 'C',
		chr(196) . chr(139) => 'c',
		chr(196) . chr(140) => 'C',
		chr(196) . chr(141) => 'c',
		chr(196) . chr(142) => 'D',
		chr(196) . chr(143) => 'd',
		chr(196) . chr(144) => 'D',
		chr(196) . chr(145) => 'd',
		chr(196) . chr(146) => 'E',
		chr(196) . chr(147) => 'e',
		chr(196) . chr(148) => 'E',
		chr(196) . chr(149) => 'e',
		chr(196) . chr(150) => 'E',
		chr(196) . chr(151) => 'e',
		chr(196) . chr(152) => 'E',
		chr(196) . chr(153) => 'e',
		chr(196) . chr(154) => 'E',
		chr(196) . chr(155) => 'e',
		chr(196) . chr(156) => 'G',
		chr(196) . chr(157) => 'g',
		chr(196) . chr(158) => 'G',
		chr(196) . chr(159) => 'g',
		chr(196) . chr(160) => 'G',
		chr(196) . chr(161) => 'g',
		chr(196) . chr(162) => 'G',
		chr(196) . chr(163) => 'g',
		chr(196) . chr(164) => 'H',
		chr(196) . chr(165) => 'h',
		chr(196) . chr(166) => 'H',
		chr(196) . chr(167) => 'h',
		chr(196) . chr(168) => 'I',
		chr(196) . chr(169) => 'i',
		chr(196) . chr(170) => 'I',
		chr(196) . chr(171) => 'i',
		chr(196) . chr(172) => 'I',
		chr(196) . chr(173) => 'i',
		chr(196) . chr(174) => 'I',
		chr(196) . chr(175) => 'i',
		chr(196) . chr(176) => 'I',
		chr(196) . chr(177) => 'i',
		chr(196) . chr(178) => 'IJ',
		chr(196) . chr(179) => 'ij',
		chr(196) . chr(180) => 'J',
		chr(196) . chr(181) => 'j',
		chr(196) . chr(182) => 'K',
		chr(196) . chr(183) => 'k',
		chr(196) . chr(184) => 'k',
		chr(196) . chr(185) => 'L',
		chr(196) . chr(186) => 'l',
		chr(196) . chr(187) => 'L',
		chr(196) . chr(188) => 'l',
		chr(196) . chr(189) => 'L',
		chr(196) . chr(190) => 'l',
		chr(196) . chr(191) => 'L',
		chr(197) . chr(128) => 'l',
		chr(197) . chr(129) => 'L',
		chr(197) . chr(130) => 'l',
		chr(197) . chr(131) => 'N',
		chr(197) . chr(132) => 'n',
		chr(197) . chr(133) => 'N',
		chr(197) . chr(134) => 'n',
		chr(197) . chr(135) => 'N',
		chr(197) . chr(136) => 'n',
		chr(197) . chr(137) => 'N',
		chr(197) . chr(138) => 'n',
		chr(197) . chr(139) => 'N',
		chr(197) . chr(140) => 'O',
		chr(197) . chr(141) => 'o',
		chr(197) . chr(142) => 'O',
		chr(197) . chr(143) => 'o',
		chr(197) . chr(144) => 'O',
		chr(197) . chr(145) => 'o',
		chr(197) . chr(146) => 'OE',
		chr(197) . chr(147) => 'oe',
		chr(197) . chr(148) => 'R',
		chr(197) . chr(149) => 'r',
		chr(197) . chr(150) => 'R',
		chr(197) . chr(151) => 'r',
		chr(197) . chr(152) => 'R',
		chr(197) . chr(153) => 'r',
		chr(197) . chr(154) => 'S',
		chr(197) . chr(155) => 's',
		chr(197) . chr(156) => 'S',
		chr(197) . chr(157) => 's',
		chr(197) . chr(158) => 'S',
		chr(197) . chr(159) => 's',
		chr(197) . chr(160) => 'S',
		chr(197) . chr(161) => 's',
		chr(197) . chr(162) => 'T',
		chr(197) . chr(163) => 't',
		chr(197) . chr(164) => 'T',
		chr(197) . chr(165) => 't',
		chr(197) . chr(166) => 'T',
		chr(197) . chr(167) => 't',
		chr(197) . chr(168) => 'U',
		chr(197) . chr(169) => 'u',
		chr(197) . chr(170) => 'U',
		chr(197) . chr(171) => 'u',
		chr(197) . chr(172) => 'U',
		chr(197) . chr(173) => 'u',
		chr(197) . chr(174) => 'U',
		chr(197) . chr(175) => 'u',
		chr(197) . chr(176) => 'U',
		chr(197) . chr(177) => 'u',
		chr(197) . chr(178) => 'U',
		chr(197) . chr(179) => 'u',
		chr(197) . chr(180) => 'W',
		chr(197) . chr(181) => 'w',
		chr(197) . chr(182) => 'Y',
		chr(197) . chr(183) => 'y',
		chr(197) . chr(184) => 'Y',
		chr(197) . chr(185) => 'Z',
		chr(197) . chr(186) => 'z',
		chr(197) . chr(187) => 'Z',
		chr(197) . chr(188) => 'z',
		chr(197) . chr(189) => 'Z',
		chr(197) . chr(190) => 'z',
		chr(197) . chr(191) => 's');
	$string = strtr($string, $chars);

	return $string;
}

function getStringLoadScript(string $path): string
{
	return "$path?cacheVersion=" . urlencode(hash_file("XXH32", ROOT . $path));
}

function urlEncodeFull($url): string
{
	$parsedUrl = parse_url($url);

	$encodedScheme = urlencode($parsedUrl['scheme']);
	$encodedHost = urlencode($parsedUrl['host']);

	$encodedPath = implode('/', array_map('urlencode', explode('/', $parsedUrl['path'])));
	if (isset($parsedUrl['query'])) {
		$encodedQuery = '?' . urlencode($parsedUrl['query']);
	} else {
		$encodedQuery = '';
	}

	return "{$encodedScheme}://{$encodedHost}{$encodedPath}{$encodedQuery}";
}

function validarCpf(string $cpf): bool
{
	$cpf = preg_replace('/[^0-9]/', '', $cpf);


	if (strlen($cpf) !== 11) {
		return false;
	}
	if (preg_match('/(\d)\1{10}/', $cpf)) {
		return false;
	}
	$soma = 0;
	for ($i = 0; $i < 9; $i++) {
		$soma += $cpf[$i] * (10 - $i);
	}
	//$soma *= 10;
	$resto = $soma % 11;
	$dv1 = ($resto < 2) ? 0 : (11 - $resto);

	if ($dv1 !== (int)$cpf[9]) {
		return false;
	}

	$soma = 0;
	for ($i = 0; $i < 10; $i++) {
		$soma += ($cpf[$i] * (11 - $i));
	}
	$resto = $soma % 11;
	$dv2 = ($resto < 2) ? 0 : (11 - $resto);

	return $dv2 === (int)$cpf[10];
}

function validarUuid(string $uuid): bool
{
	return !(empty($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{4}-[89ab][0-9a-f]{4}-[0-9a-f]{12}$/', $uuid) !== 1));
}

function valueFromReal($string): float|null
{
	if (!empty($string)) {
		$string = str_replace(array("R$", " ", ".", ","), array("", "", "", "."), $string);
		if (!empty($string)) {
			return (float)$string;
		}
	}
	return null;
}

function urlTreat(string $url, array $options = []): false|string
{
	$urlc = parse_url($url);
	if ($urlc["host"]) {
		if (empty($urlc["scheme"])) $urlc["scheme"] = "https";
		if (empty($urlc["host"])) return false;


		foreach ($options as $option => $value) {
			$urlc[$option] = $value;
		}

		$url = "{$urlc['scheme']}://{$urlc['host']}{$urlc['path']}#{$urlc['fragment']}?{$urlc['query']}";
		return urlEncodeFull($url);
	} else {
		return false;
	}
}


function mime_content($filename): false|string
{

	$mime_types = array(

		'txt' => 'text/plain',
		'htm' => 'text/html',
		'html' => 'text/html',
		'php' => 'text/html',
		'css' => 'text/css',
		'js' => 'application/javascript',
		'json' => 'application/json',
		'xml' => 'application/xml',
		'swf' => 'application/x-shockwave-flash',
		'flv' => 'video/x-flv',

		// images
		'png' => 'image/png',
		'jpe' => 'image/jpeg',
		'jpeg' => 'image/jpeg',
		'jpg' => 'image/jpeg',
		'gif' => 'image/gif',
		'bmp' => 'image/bmp',
		'ico' => 'image/vnd.microsoft.icon',
		'tiff' => 'image/tiff',
		'tif' => 'image/tiff',
		'svg' => 'image/svg+xml',
		'svgz' => 'image/svg+xml',

		// archives
		'zip' => 'application/zip',
		'rar' => 'application/x-rar-compressed',
		'exe' => 'application/x-msdownload',
		'msi' => 'application/x-msdownload',
		'cab' => 'application/vnd.ms-cab-compressed',

		// audio/video
		'mp3' => 'audio/mpeg',
		'qt' => 'video/quicktime',
		'mov' => 'video/quicktime',

		// adobe
		'pdf' => 'application/pdf',
		'psd' => 'image/vnd.adobe.photoshop',
		'ai' => 'application/postscript',
		'eps' => 'application/postscript',
		'ps' => 'application/postscript',

		// ms office
		'doc' => 'application/msword',
		'rtf' => 'application/rtf',
		'xls' => 'application/vnd.ms-excel',
		'ppt' => 'application/vnd.ms-powerpoint',

		// open office
		'odt' => 'application/vnd.oasis.opendocument.text',
		'ods' => 'application/vnd.oasis.opendocument.spreadsheet',);

	$filenames = explode('.', $filename);
	$ext = strtolower(array_pop($filenames));
	if (array_key_exists($ext, $mime_types)) {
		return $mime_types[$ext];
	}

	if (function_exists('finfo_open')) {
		$finfo = finfo_open(FILEINFO_MIME);
		$mimetype = finfo_file($finfo, $filename);
		finfo_close($finfo);
		return $mimetype;
	}

	return 'application/octet-stream';
}


function stripString(string $string): string
{
	return preg_replace("/[^A-Za-z0-9 ]/", '', removerAcentos(vartreat($string, "l"))) ?: "";
}

function relativeDate($datetime, $full = false)
{
	$ago = DateTime::createFromFormat("Y-m-d H:i:s", $datetime);
	$now = new DateTime;
	$diff = $now->diff($ago);

	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;


	$string = array(
		'y' => 'ano',
		'm' => 'm',
		'w' => 'semana',
		'd' => 'dia',
		'h' => 'hora',
		'i' => 'minuto',
		's' => 'segundo',);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {


			$v = $diff->$k . ' ' . $v . (($k === 'm') ? ($diff->$k > 1 ? 'eses' : 'ês') : ($diff->$k > 1 ? 's' : ''));

		} else {
			unset($string[$k]);
		}
	}

	if (!$full) $string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) . ' atrás' : 'Agora';
}


function vartreat($string = '', string|false $mb = false): string
{
	if ($string) {
		return $mb ? match ($mb) {
			default => mb_strtolower(trim($string)),
			'upper', 'up', 'u' => mb_strtoupper(trim($string)),
			'w', 'words', 'tittle', "t" => mb_convert_case(trim($string), MB_CASE_TITLE)
		} : trim($string);
	}
	return "";
}

function recur_ksort(&$array): void
{
	foreach ($array as &$value) {
		if (is_array($value)) recur_ksort($value);
	}
	
	if (array_is_list($array)) sort($array, SORT_NATURAL); else ksort($array, SORT_NATURAL);
	
	
}

function postreat(string $string = "", string|false $mb = false): false|string
{
	if ($_POST[$string]) return vartreat($_POST[$string], $mb);
	return false;
}


function getreat(string $string = "", string|false $mb = false): false|string
{
	if ($_GET[$string]) return vartreat($_GET[$string], $mb);
	return false;
}


function abreviarNome(string $name, bool $sobrenome = false): string
{
	$names = explode(" ", $name);
	$names = array_filter($names);
	if (count($names) >= 2) {
		return mb_convert_case(mb_strtolower(implode(' ', [$names[0], $sobrenome ? substr(end($names), 0, 1) . '.' : end($names)])), MB_CASE_TITLE);

	}

	return mb_convert_case(mb_strtolower($names[0]), MB_CASE_TITLE);
}
