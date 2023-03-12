<?php
header("X-Robots-Tag: none");
require_once './../config/config.php';
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
	case '0314':
		$msg = "Estamos em atualização....<br> Quando o site voltar, o botão abaixo ficará verde.<br>Não precisa atualizar a pagina";
		break;
}
?>
<!doctype html>
<html lang="br">
<head>
	<?php
	require_once './../includes/head.html';
	?>
    <title><?= $error ?> - Fichas Ordem Paranormal</title>
</head>
<body class="bg-black text-light">
<main class="mt-5 d-flex justify-content-center text-center">
    <div class="col-md-6">
        <div class="card bg-black text-white border-light">
            <div class="card-header justify-content-between d-flex"><h3 class="text-danger">Error - <?= $error ?></h3>
                <h4><i class="fal fa-arrows-rotate fa-spin"></i> <span id="counter"></span></h4></div>
            <div class="card-body text-center">

                <div class="m-2">
                    <p class="fs-5"><?= $msg ?></p>
                </div>
            </div>
            <div class="card-footer">
				<?php if ($error === "0314") { ?>
					<?php if (is_updating) { ?>
                        <button class="d-grid btn btn-outline-secondary w-100" disabled>Ainda não</button>
					<?php } else { ?>
                        <a class="d-grid btn btn-success" href="/">Pronto. Clique aqui</a>
					<?php } ?>
				<?php } else { ?>
                    <a href="/" class="d-grid btn btn-outline-primary">Ir para o inicio</a>
				<?php } ?>
            </div>
        </div>
    </div>
</main>
<?php
require_once './../includes/scripts.php';
?>
<script>
    let timeout;
    let time = 5000;
    let counter = 0

    function test() {
        console.log(counter)
        $("#counter").text(counter)
        if (counter <= 0) {
            counter = time / 1000;
            $.get({
                url: " .card-footer>",
                beforeSend: () => {

                    $(".card-footer").html("<button class='btn btn-outline-secondary disabled w-100' disabled><span class='placeholder placeholder-glow placeholder-wave w-100'></span></button>");

                    $(".card-footer").load(" .card-footer>")
                },
                success: (html) => {
                    $(".card-footer").html(html)
                }
            })
        } else {
            counter--;
        }
        setTimeout(test, 1000);
    }

    $(() => {
        test();
    })


</script>
</body>
</html>