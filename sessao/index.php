<?php

require_once "./../config/includes.php";
$con = con();

if (!isset($_SESSION["UserID"])) {
	header("Location: /");
	exit;
}
$userid = $_SESSION["UserID"];

if (isset($_POST["status"])) {
	$success = true;
	$msg = '';
	switch ($_POST["status"]) {
		case 'criarmissao':
			if (!empty($_POST["title"])) {
				$title = cleanstring($_POST["title"]);
				if (strlen($title) < 5) {
					$success = false;
					$msg = "Seu titulo precisa conter no minimo 5 caracteres.";
				}
			} else {
				$success = false;
				$msg = "Sua missão precisa de um titulo";
			}
			if (!empty($_POST["desc"])) {
				$desc = cleanstring($_POST["desc"]);
				if (strlen($desc) < 50) {
					$success = false;
					$msg = "Sua introdução precisa conter no minimo 50 caracteres.(Atual: " . strlen($desc) . ")";
				}
			} else {
				$success = false;
				$msg = "Sua missão precisa de uma descrição";
			}
			if ($success) {
				$q = $con->prepare("INSERT INTO `missoes` (`nome`, `descricao`, `mestre`,`token`) VALUES (?, ?, ?, md5(UUID_SHORT()));");
				$q->bind_param("ssi", $title, $desc, $_SESSION["UserID"]);
				$q->execute();
				if ($con->affected_rows) {
					$msg = "Sucesso ao criar missão.";
				} else {
					$success = false;
					$msg = "Falha ao criar missão.";
				}
			}
			$data["success"] = $success;
			$data["msg"] = $msg;
			echo json_encode($data);
			exit;
			break;
		case 'player':
			$idficha = intval($_POST["id_ficha"]);
			$view = intval($_POST["view"]);
			$con->query("UPDATE `fichas_personagem` SET `public` = '" . $view . "' WHERE `id` = '" . $idficha . "' AND `usuario` = '" . $userid . "';");
			break;
		case 'deleteficha':
			$con->query("DELETE FROM `fichas_personagem` WHERE `id` = '" . intval($_POST["id"]) . "' AND `usuario` = '$userid';");
			break;
		case 'deletemissao':
			$con->query("DELETE FROM `missoes` WHERE `id` = '" . intval($_POST["id"]) . "' AND `mestre` = '$userid';");
			break;
		case 'editmis':
			if (!empty($_POST["title"])) {
				$title = cleanstring($_POST["title"]);
				if (strlen($title) < 5) {
					$success = false;
					$msg = "Seu titulo precisa conter no minimo 5 caracteres.";
				}
			} else {
				$success = false;
				$msg = "Sua missão precisa de um titulo";
			}
			if (!empty($_POST["desc"])) {
				$desc = cleanstring($_POST["desc"]);
				if (strlen($desc) < 50) {
					$success = false;
					$msg = "Sua introdução precisa conter no minimo 50 caracteres.(Atual: " . strlen($desc) . ")";
				}
			} else {
				$success = false;
				$msg = "Sua missão precisa de uma descrição";
			}
			if ($success === true) {
				$id = intval($_POST["id"]);
				$q = $con->prepare("UPDATE `missoes` SET `nome` = ?, `descricao` = ? WHERE `id` = ?");
				$q->bind_param("ssi", $title, $desc, $id);
				$q->execute();
				$success = $con->affected_rows;
				$msg = $con->affected_rows ? "Sucesso" : "Falha";
			}
			$data["success"] = $success;
			$data["msg"] = $msg;
			echo json_encode($data);
			exit;
			break;
		case 'acc':
			$idm = intval($_POST["idm"]);
			$idf = intval($_POST["idf"]);
			$acc = $con->query("UPDATE `ligacoes` SET `id_ficha` = '" . $idf . "' WHERE `id` = '" . $idm . "' AND `id_usuario` = '" . $userid . "';");
			break;
		case 'rcc':
			$idm = intval($_POST["idm"]);
			$acc = $con->query("DELETE FROM `ligacoes` WHERE `ligacoes`.`id` = '$idm' AND `id_usuario` = '$userid';");
			break;
		case 'desp':
			$p = intval($_POST["p"]);
			$con->query("DELETE FROM `ligacoes` WHERE `id_usuario`='$userid' AND `id_ficha`='" . $p . "';");
			break;
	}
}
?>
<!DOCTYPE html>
<html lang="br">
<head>
	<?php require_once "./../includes/head.html"; ?>
    <title>Sessões - FichasOP</title>
</head>
<body class="bg-black text-light font6">
<main class="container-flex mx-0 py-5 justify-content-center">
    <div class="row m-3">
        <div class="col-md my-2 justify-content-center">
            <div class="card h-100 bg-black border-light">
                <div class="card-body">
                    <div class="card-header">
                        <h3>Criar sessão</h3>
                    </div>
                    <span>Como mestre, o seu dever é orientar os seus jogadores a cadastrar no site, e ter em mãos os emails de cada um, para poder enviar o convite para missão.</span>
                    <div class="card-footer">
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#criarsessao">Mestrar Uma Nova sessão
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md my-2 justify-content-center">
            <div class="card h-100 bg-black border-light">
                <div class="card-body">
                    <div class="card-header">
                        <h3>Como entrar numa missão?</h3>
                    </div>
                    <span>Peça para o seu mestre criar uma missão, lá ele pode colocar o nome e a Sinopse da missão. Envie o seu Email para o mestre, o mesmo da sua conta que ao adicionar, será automaticamente convidado para missão.</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row m-3 text-center justify-content-center">
        <div class="col">
            <div class="card bg-black border-light">
                <div class="card-body">
                    <div class="card-header">
                        <div class="clearfix">
                            <div class="float-start">
                                <span class="text-info"><i class="fa-regular fa-circle-info"></i></span> <span>As cores definem o status da sua missão</span>:
                                <span class="text-info">Convite</span>|
                                <span class="text-danger">Jogando como Mestre</span>|
                                <span class="text-primary">Jogando como Protagonista</span>|
                            </div>
                        </div>
                        <h3 class="text-center">Missões atuais</h3>
                    </div>
                    <div class="row justify-content-center">
						<?php
						$a = $con->query("Select * from `ligacoes` WHERE `id_usuario` = '" . $_SESSION["UserID"] . "';");
						foreach ($a as $dl) {
							$b = $con->query("SELECT * FROM `missoes` WHERE `missoes`.`id` ='" . $dl["id_missao"] . "';");
							$c = $con->query("SELECT * FROM `fichas_personagem` WHERE `id` ='" . $dl["id_ficha"] . "';");
							$cd = mysqli_fetch_array($c);
							foreach ($b as $dm) {
								?>
                                <div class="col-md-6 my-2">
                                    <div class="card h-100 m-2 bg-black border-<?= $dl["id_ficha"] ? "primary" : "info" ?>">
										<?php if ($dl["id_ficha"] > 0) : ?>
                                            <div class="m-1 mb-3">
                                                <div class="mx-1 start-0 position-absolute">
                                                    <button type="button" class="btn btn-sm text-primary"
                                                            data-bs-toggle="modal" data-bs-target="#configplayer"
                                                            onclick="configplayer(<?= $cd["id"] ?>)"><i
                                                                class="fa-solid fa-gear"></i></button>
                                                    <button type="button" class="btn btn-sm"
                                                            title="Ficha está atualmente <?= $cd["public"] ? "Visivel" : "Invisivel" ?>">
                                                        <i class="fa-solid fa-eye<?= $cd["public"] ? " text-success" : "-slash text-danger" ?>"></i>
                                                    </button>
                                                </div>
                                                <div class=" position-absolute start-50 translate-middle-x">
                                                    <a class="btn btn-sm btn-outline-info"
                                                       href="personagem/portrait?token=<?= $cd["token"]; ?>">Portrait</a>
                                                    <a class="btn btn-sm btn-outline-info"
                                                       href="personagem/impresso?token=<?= $cd["token"]; ?>"><i
                                                                class="fa-regular fa-print"></i></a>
                                                </div>
                                                <button type="button"
                                                        class="btn btn-sm text-danger position-absolute end-0 mx-1 "
                                                        title="Desvincular ficha da missão."
                                                        onclick="desvincular(<?= $cd["id"] ?>)">
                                                    <i class="fa-regular fa-unlink"></i>
                                                </button>
                                            </div>
										<?php endif; ?>
                                        <div class="card-body">
                                            <div class="card-title">
                                                <label for="missao[]"
                                                       class="text-danger fs-4 fw-bold"><?= $dm["nome"]; ?></label>
                                            </div>
                                            <textarea id="missao[]" disabled class="bg-black text-white w-100"
                                                      style="height: 100px;"><?= $dm["descricao"]; ?></textarea>
                                            <div class="card-footer">
												<?php if ($dm["status"]) {
													if ($dl["id_ficha"] > 0) { ?>
                                                        <a class="btn btn-outline-primary"
                                                           href='personagem?token=<?= $cd["token"] ?>'>Continuar
                                                            - <?= $cd["nome"] ?></a>
													<?php } else {
														?>
                                                        <div class="btn-group">
                                                            <button type="button"
                                                                    class="btn btn-outline-info dropdown-toggle"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                Convite de missão
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-dark bg-black border border-light">
                                                                <li><a class="dropdown-item"
                                                                       href='personagem/criar?convite=<?php echo $dl["id"]; ?>'>Aceitar
                                                                        e Criar uma ficha</a></li>
                                                                <li>
                                                                    <hr class="dropdown-divider">
                                                                </li>
																<?php
																$z = $con->query("SELECT * FROM `fichas_personagem` WHERE `usuario` = '" . $_SESSION["UserID"] . "'");
																foreach ($z as $ficha) {
																	$zz = $con->query("SELECT * FROM `ligacoes` WHERE `id_ficha` = '" . $ficha["id"] . "';");
																	if (!$zz->num_rows) {
																		?>
                                                                        <li>
                                                                            <button class="dropdown-item"
                                                                                    onclick="aceitarconvite(<?= $dl["id"] ?>,<?= $ficha["id"] ?>)">
                                                                                Aceitar - <?= $ficha["nome"] ?></button>
                                                                        </li>
																		<?php
																	}
																}
																?>
                                                                <li>
                                                                    <hr class="dropdown-divider">
                                                                </li>
                                                                <li>
                                                                    <button class="dropdown-item"
                                                                            onclick="recusarconvite(<?= $dl["id"] ?>)">
                                                                        Recusar Pedido
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
														<?php
													}
												} else { ?>
                                                    <a class="btn btn-outline-danger" disabled>Bloqueado pelo
                                                        Mestre</a>
												<?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							<?php }
						}
						$a = $con->query("Select * from `missoes` WHERE `mestre` = '" . $_SESSION["UserID"] . "';");
						if ($a->num_rows > 0) {
							while ($dl = mysqli_fetch_assoc($a)) {
								?>
                                <div class="col-md-6 my-2">
                                    <div class="card h-100 m-2 bg-black border-danger">
                                        <div class="text-start">
                                            <button type="button" class="btn btn-sm text-primary" data-bs-toggle="modal"
                                                    data-bs-target="#configmissao"
                                                    onclick="configmissao(<?= $dl["id"] ?>)"><i
                                                        class="fa-solid fa-gear"></i></button>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-title"><label for="missao[]"
                                                                           class="text-danger fs-4 fw-bolder"><?= $dl["nome"]; ?></label>
                                            </div>
                                            <textarea id="missao[]" disabled class="bg-black text-white w-100"
                                                      style="height: 100px;"><?php echo $dl["descricao"]; ?></textarea>
                                            <div class="card-footer">
                                                <a class="btn btn-outline-danger"
                                                   href="./mestre/?token=<?= $dl["token"] ?>">Painel do Mestre
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							<?php }
						} else { ?>
                            <div class="col-md-6 my-2">
                                <div class="card m-2 h-100 bg-black border-light">
                                    <div class="card-body">
                                        <div class="card-title"><h4 class="text-danger">Você não está em nenhuma
                                                missão</h4></div>
                                        <span>Comece entrando ou criando uma logo acima.</span>
                                    </div>
                                </div>
                            </div>
						<?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row m-3 text-center justify-content-center">
        <div class="col">
            <div class="card bg-black border-light">
                <div class="card-body">
                    <div class="card-header">
                        <h3 class="text-center">Historico de Personagens</h3>
                    </div>
                    <div class="row justify-content-center">
						<?php
						$a = $con->query("Select * from `fichas_personagem` WHERE `usuario` = '" . $_SESSION["UserID"] . "';");
						if ($a->num_rows > 0) {
							while ($dl = mysqli_fetch_assoc($a)) {
								?>
                                <div class="col-md-6 my-2">
                                    <div class="card h-100 m-2 bg-black border-primary">
                                        <div class="m-1 mb-3">
                                            <div class="mx-1 start-0 position-absolute">
                                                <button type="button" class="btn btn-sm text-primary"
                                                        data-bs-toggle="modal" data-bs-target="#configplayer"
                                                        onclick="configplayer(<?= $dl["id"] ?>)"><i
                                                            class="fa-solid fa-gear"></i></button>
                                                <button type="button" class="btn btn-sm"
                                                        title="Ficha está atualmente <?= $dl["public"] ? "Visivel" : "Invisivel" ?>">
                                                    <i class="fa-solid fa-eye<?= $dl["public"] ? " text-success" : "-slash text-danger" ?>"></i>
                                                </button>
                                            </div>
                                            <div class=" position-absolute start-50 translate-middle-x">
                                                <a class="btn btn-sm btn-outline-info"
                                                   href="personagem/portrait?token=<?= $dl["token"]; ?>">Portrait</a>
                                                <a class="btn btn-sm btn-outline-info"
                                                   href="personagem/impresso?token=<?= $dl["token"]; ?>"><i
                                                            class="fa-regular fa-print"></i></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-title"><label for="missao[]"
                                                                           class="text-danger fs-4 fw-bold"><?= $dl["nome"]; ?></label>
                                            </div>
                                            <textarea id="missao[]" disabled class="bg-black text-white w-100"
                                                      style="height: 100px;"><?= $dl["historia"]; ?></textarea>
                                            <div class="card-footer">
                                                <a class="btn btn-outline-primary"
                                                   href='personagem?token=<?= $dl["token"]; ?>'>Dar uma olhada
                                                    - <?= $dl["nome"]; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<?php
							}
						}
						?>

                        <div class="col-md-6 my-2">
                            <div class="card h-100 m-2 bg-black border-info">
                                <div class="card-body">
                                    <div class="card-title"><label class="text-danger fs-4 fw-bold">Criar ficha sem
                                            entrar em uma missão</label></div>
                                    <span>Caso queira conhecer o site, pode criar 1 personagem sem ter que entrar em missões.</span>
                                    <div class="card-footer">
                                        <a class="btn btn-outline-success" href='personagem/criar'>Criar um
                                            personagem.</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div id="modals">
    <div class="modal" id="criarsessao" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <form class="modal-content bg-black border-light" id="criarmissao" method="post" novalidate>
                <div class="modal-body">
                    <div class="modal-header border-0 text-center">
                        <h1 class="modal-title" id="exampleModalLabel">Criar uma sessão como mestre</h1>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="my-3" id="msgcriar"></div>
                    <div class="container-fluid">
                        <div class="m-4">
                            <label class="fs-5" for="title">Titulo da missão</label>
                            <input type="text" id="title" name="title" class="form-control bg-black text-light"
                                   required/>
                        </div>
                        <div class="m-4">
                            <label class="fs-5" for="desc">Introdução da missão (Oque aparece para os
                                jogadores.)</label>
                            <textarea type="text" id="desc" name="desc" class="form-control bg-black text-white h-50"
                                      required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary">Criar Missão</button>
                    <input type="hidden" name="status" value="criarmissao">
                </div>
            </form>
        </div>
    </div>


    <form class="modal" id="configplayer" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-black border-light">
                <div class="modal-body">
                    <div class="modal-header border-0 text-center">
                        <h4 class="modal-title">Configurações da ficha</h4>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="container-fluid">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" value="1" role="switch" id="visivel">
                            <label class="form-check-label" for="visivel">Tornar ficha vísivel para todo mundo</label>
                        </div>
                    </div>
                    <input type="hidden" name="status" value="player">
                    <input type="hidden" id="inputidficha" name="id_ficha" value="">





















                                                                <?=($var=="casa")?"asdas":"sdfgsg"?>
































                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteficha()"><i class="fa-regular fa-trash"></i></button>
                        <button type="submit" class="btn btn-sm btn-primary ms-auto"><i class="far fa-floppy-disk"></i>Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <div class="modal" id="configplayer" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content bg-black border-light" id="formconfigplayer" method="post" novalidate>
                <div class="modal-body">
                    <div class="modal-header border-0 text-center">
                        <h4 class="modal-title">Configurações da ficha</h4>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="container-fluid text-center">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="view" value="1" role="switch" id="switchview">
                            <label class="form-check-label" for="switchview">Tornar ficha vísivel para todo mundo</label>
                        </div>
                        <button type="button" class="btn btn-sm btn-danger mt-5" id="deletficha" onclick="deleteficha()">
                            <i class="fa-regular fa-trash"></i> Deletar Ficha Permanentemente!
                        </button>
                    </div>
                    <input type="hidden" name="status" value="player">
                    <input type="hidden" id="inputidficha" name="id_ficha" value="">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Salvar Configurações</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal" id="configmissao" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content bg-black border-light" id="formconfigmissao" method="post" novalidate>
                <div class="modal-body">
                    <div class="modal-header border-0 text-center">
                        <h1 class="modal-title">Configurações da ficha</h1>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="" id="returnconfigmissao"></div>
                    <div class="container-fluid text-center">
                        <label for="enomemissao" class="fs-4 my-2">Nome da missão</label>
                        <input id="enomemissao" name="title" type="text" class="form-control bg-black text-white my-2">
                        <label for="edescmissao" class="fs-4 my-2">Descrição da missão</label>
                        <textarea id="edescmissao" name="desc" class="form-control bg-black text-white my-2"></textarea>
                        <button type="button" class="btn btn-sm btn-danger mt-5" id="deletmissao"
                                onclick="deletemissao()">
                            <i class="fa-regular fa-trash"></i> Deletar Missão Permanentemente!
                        </button>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary">Salvar Configurações</button>
                    <input type="hidden" name="status" value="editmis">
                    <input type="hidden" id="inputidmissao" name="id" value="">
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once "./../includes/scripts.php"; ?>
<?php require_once "./../includes/top.php"; ?>

<script>
	<?php if (isset($_GET["convite"]) && $_GET["convite"] == 1 && !isset($_SESSION["UserID"])){ ?>
    var modalperfil = new bootstrap.Modal(document.getElementById('cadastrar'), {
        keyboard: false
    })
    modalperfil.show()
	<?php }?>
</script>
<script>
    function desvincular(p) {
        let text = "DESEJA DESVINCULAR ESSA FICHA?\nNÃO SERÁ POSSIVEL REVERTER!";
        if (confirm(text) === true) {
            $.post({
                data: {status: "desp", p: p},
                url: "",
            }).done(function () {
                location.reload();
            });
        }
    }

    function aceitarconvite(idm, idf) {
        $.post({
            url: '',
            data: {status: 'acc', idm: idm, idf: idf},
        }).done(function () {
            location.reload();
        })
    }

    function recusarconvite(idm) {
        $.post({
            url: '',
            data: {status: 'rcc', idm: idm},
        }).done(function () {
            location.reload();
        })
    }

    function deleteficha(id) {
        let text = "DESEJA DELETAR A FICHA?\nNÃO SERÁ POSSIVEL REVERTER";
        if (confirm(text) === true) {
            $.post({
                url: '',
                data: {status: "deleteficha", id: id},
            }).done(function (data) {
                console.log(data)
                alert("DELETADO!");
                location.reload();
            })
        } else {
            alert("Você cancelou!");
        }
    }

    function deletemissao(id) {
        let text = "DESEJA DELETAR A MISSÃO?\nNÃO SERÁ POSSIVEL REVERTER";
        if (confirm(text) === true) {
            $.post({
                url: '',
                data: {status: "deletemissao", id: id},
            }).done(function (data) {
                console.log(data)
                alert("DELETADO!");
                location.reload();
            })
        } else {
            alert("Você cancelou!");
        }
    }

    function configplayer(id) {
        $("#inputidficha").val(id);
        $("#deletficha").attr("onclick", 'deleteficha(' + id + ')');
    }

    function configmissao(id) {
        $("#inputidmissao").val(id);
        $("#deletmissao").attr("onclick", 'deletemissao(' + id + ')');
    }

    $(document).ready(function () {
        $('#configplayer').on('submit', function (e) {
            var form = $(this);
            e.preventDefault();
            $.post({
                data: form.serialize(),
            }).done(function (data) {
                location.reload();
            })
        })

        $('#editmissao').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            $.post({
                beforeSend: function () {
                    $("#criarmissao input, #criarmissao textarea, #criarmissao button").attr('disabled', true);
                    $("#msgcriar").html("<div class='alert alert-warning'>Aguarde enquanto verificamos os dados...</div>");
                },
                url: "index.php",
                data: form.serialize(),
                dataType: "JSON",
                error: function (data) {
                    console.log(data)
                    $("#criarmissao input, #criarmissao textarea, #criarmissao button").attr('disabled', false);
                    $("#msgcriar").html("<div class='alert alert-danger'>Houve um erro ao fazer a solicitação, contate um administrador!</div>");
                },
            }).done(function (data) {
                console.log(data);
                if (data.msg) {
                    if (!data.success) {
                        $("#msgcriar").html('<div class="alert alert-danger">' + data.msg + "</div>");
                        $("#criarmissao input, #criarmissao textarea, #criarmissao button").attr('disabled', false);
                    } else {
                        $("#msgcriar").html('<div class="alert alert-success">' + data.msg + '</div>');
                        window.location.href = "./";
                    }
                }

            });
        })

        $('#formconfigmissao').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            $.post({
                beforeSend: function () {
                    $("#formconfigmissao input, #formconfigmissao textarea, #formconfigmissao button").attr('disabled', true);
                    $("#returnconfigmissao").html("<div class='alert alert-warning'>Aguarde enquanto verificamos os dados...</div>");
                },
                url: "index.php",
                data: form.serialize(),
                dataType: "JSON",
                error: function (data) {
                    console.log(data)
                    $("#formconfigmissao input, #formconfigmissao textarea, #formconfigmissao button").attr('disabled', false);
                    $("#returnconfigmissao").html("<div class='alert alert-danger'>Houve um erro ao fazer a solicitação, contate um administrador!</div>");
                },
            }).done(function (data) {
                console.log(data);
                if (data.msg) {
                    if (!data.success) {
                        $("#returnconfigmissao").html('<div class="alert alert-danger">' + data.msg + "</div>");
                        $("#formconfigmissao input, #formconfigmissao textarea, #formconfigmissao button").attr('disabled', false);
                    } else {
                        $("#returnconfigmissao").html('<div class="alert alert-success">' + data.msg + '</div>');
                        window.location.href = "./";
                    }
                }

            });
        });
        $('#criarmissao').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            $.post({
                beforeSend: function () {
                    $("#criarmissao input, #criarmissao textarea, #criarmissao button").attr('disabled', true);
                    $("#msgcriar").html("<div class='alert alert-warning'>Aguarde enquanto verificamos os dados...</div>");
                },
                url: "index.php",
                data: form.serialize(),
                dataType: "JSON",
                error: function (data) {
                    console.log(data)
                    $("#criarmissao input, #criarmissao textarea, #criarmissao button").attr('disabled', false);
                    $("#msgcriar").html("<div class='alert alert-danger'>Houve um erro ao fazer a solicitação, contate um administrador!</div>");
                },
            }).done(function (data) {
                console.log(data);
                if (data.msg) {
                    if (!data.success) {
                        $("#msgcriar").html('<div class="alert alert-danger">' + data.msg + "</div>");
                        $("#criarmissao input, #criarmissao textarea, #criarmissao button").attr('disabled', false);
                    } else {
                        $("#msgcriar").html('<div class="alert alert-success">' + data.msg + '</div>');
                        window.location.href = "./";
                    }
                }

            });
        });
    });
</script>
</body>
</html>
