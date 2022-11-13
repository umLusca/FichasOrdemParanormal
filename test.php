<?php

function verificarcpf(string $cpf): bool
{
	$cn = str_split($cpf);
	$cv = [];
	$csv = 0;
	for ($i = 0; $i < 9; $i++) {
		$cv[$i] = $cn[$i] * ($i + 1);
	}
	foreach ($cv as $somando) {
		$csv += $somando;
	}
	$dv1 = ($csv % 11 == 10) ? 0 : ($csv % 11); //Primeiro digito verificador
	$cv = [];
	$cn[9] = $dv1;
	$csv = 0;
	for ($i = 0; $i < 10; $i++) {
		$cv[$i] = $cn[$i] * $i;
	}
	foreach ($cv as $somando) {
		$csv += $somando;
	}
	$dv2 = ($csv % 11 == 10) ? 0 : ($csv % 11); //segundo digito verificador
	$dv = $dv1 . $dv2; // digito verificador
	$cdv = $cn[9] . $cn[10]; // digito verificador do cpf dado
	return ($cdv === $dv);
}


