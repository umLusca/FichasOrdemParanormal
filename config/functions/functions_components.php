<?php
function pill($nome, $valor, $ah = true): string
{
return (!empty($valor)) || !$ah ? "<div class='col-auto'><div class='border border-secondary p-1 rounded'><span class=''>{$nome}: {$valor}</span></div></div>" : "";
}

function pillbutton($nome,$valor,$ah,$onclick):string
{
return (!empty($valor)) || !$ah ? "<div class='col-auto'><button class='btn btn-sm btn-outline-secondary border-dashed' role='button' onclick=\"{$onclick}\">{$nome}: {$valor}</button></div>" : "";
}
