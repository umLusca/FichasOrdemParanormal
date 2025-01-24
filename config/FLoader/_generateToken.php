<?php

function gerarToken($tamanho, $verify = true): string
{
    $alfanumerico = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
    $numero = "";
    for ($i = 0; $i < $tamanho; $i++) {
        $numero .= $alfanumerico[random_int(0, strlen($alfanumerico) - 1)];
    }
    if ($verify) {
        $c = con();
        $a = $c->query("SELECT * from linkDados WHERE token = '$numero';");
        if ($a->rowCount()) {
            return gerarToken($tamanho);
        }
    }
    return ($numero);

}

function uuid(): string
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return vsprintf('%s%s-%s-4000-8%.3s-%s%s%s0',str_split(dechex( microtime(true) * 1000 ) . bin2hex( random_bytes(8) ),4));
}
