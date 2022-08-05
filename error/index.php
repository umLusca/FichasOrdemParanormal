<?php
header("X-Robots-Tag: none");
$error = $_GET["error"];
switch ($_GET["error"]) {
    case '400':
        $msg = "Requisição invalida.";
        break;
    case '401':
        $msg = "Você não está autorizado para acessar essa pagina.";
        break;
    case '403':
        $msg = "O acesso dessa pagina atualmente está Proibida.";
        break;
    case '404':
        $msg = "A pagina que você está procurando não foi encontrada.";
        break;
    case '503':
        $msg = "Este serviço não está disponivel.";
        break;
    case '003':
        $msg = "Estamos em manutenção, Volte mais tarde.";
        break;
}
?>
<!doctype html>
<html lang="br">
<head>
    <?php
    require_once './../includes/head.html';
    ?>
    <title><?=$error?> - Fichas Ordem Paranormal</title>
</head>
<body class="bg-black text-light">
<main class="mt-5 d-flex justify-content-center text-center">
    <div class="col-lg-4">
        <div class="card bg-black text-white border-light">
            <div class="card-body text-center">
                <h1 class="text-danger">Error - <?= $error?></h1>
                <div class="m-5">
                    <h4><?=$msg?></h4>
                </div>
                <a href="/" class="d-grid btn btn-outline-secondary">Ir para o inicio</a>
            </div>
        </div>
    </div>
</main>
</body>
</html>