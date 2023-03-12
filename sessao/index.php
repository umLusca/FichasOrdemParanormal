<?php

require_once "./../config/includes.php";

if (!isset($_SESSION["UserID"])) {
	header("Location: /");
	exit;
}
$userid = $_SESSION["UserID"];

if (isset($_POST["status"])) {
	$success = true;
	$msg = '';
	switch ($_POST["status"]) {
		case "duplicate":
			$token = cleanstring($_POST["token"]);
			$a = $con->prepare("SELECT * FROM u436203203_bd.fichas_personagem WHERE token = ? AND usuario = ?");
			$a->bind_param("si", $token, $_SESSION["UserID"]);
			$a->execute();
			$ra = mysqli_fetch_assoc($a->get_result());
			
			$stmt = duplicate_row($ra, array("nome" => $ra["nome"] . " - Cópia", "token" => uniqid("ficha_", true)), array("id"));
			
			$b = $con->prepare("INSERT INTO u436203203_bd.fichas_personagem ({$stmt["query_columns"]}) VALUES ({$stmt["query_values"]})");
			$b->bind_param($stmt["bind_types"], ...$stmt["bind_values"]);
			$b->execute();
			
			break;
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
				$id = cleanstring($_POST["id"]);
				$q = $con->prepare("UPDATE `missoes` SET `nome` = ?, `descricao` = ? WHERE `token` = ? AND mestre = ?");
				$q->bind_param("sssi", $title, $desc, $id, $_SESSION["UserID"]);
				$q->execute();
				$success = $con->affected_rows;
				$msg = $con->affected_rows ? "Sucesso" : "Falha";
			}
			$data["success"] = $success;
			$data["msg"] = $msg;
			echo json_encode($data);
			exit;
			break;
		case 'player':
			
			$token = cleanstring($_POST["token"]);
			$view = intval($_POST["view"]);
			
			$b = $con->prepare("UPDATE `fichas_personagem` SET `public` = ? WHERE `token` = ? AND `usuario` = ? ;");
			$b->bind_param("isi", $view, $token, $_SESSION["UserID"]);
			$b->execute();
			
			break;
		case 'deleteficha':
			$token = cleanstring($_POST["token"]);
			$b = $con->prepare("DELETE FROM fichas_personagem WHERE token = ? AND usuario = ? ;");
			$b->bind_param("si", $token, $_SESSION["UserID"]);
			$b->execute();
			break;
		case 'deletemissao':
			
			$con->query("DELETE FROM `missoes` WHERE `token` = '" . cleanstring($_POST["tk"]) . "' AND `mestre` = '$userid';");
			break;
		case 'acc':
			$token = cleanstring($_POST["token"]);
			$idt = cleanstring($_POST["idt"]);
			$b = $con->prepare("UPDATE `ligacoes` SET `id_ficha` = (SELECT id from fichas_personagem where token = ?) WHERE `token` = ? AND `id_usuario` = ? ;");
			$b->bind_param("ssi", $token, $idt, $_SESSION["UserID"]);
			$b->execute();
			break;
		case 'rcc':
			$idt = cleanstring($_POST["idt"]);
			$a = $con->prepare("DELETE FROM ligacoes WHERE token = ? and id_usuario = ? ;");
			$a->bind_param("si", $idt, $_SESSION["UserID"]);
			$a->execute();
			break;
		case 'desp':
			$token = cleanstring($_POST["token"]);
			$b = $con->prepare("DELETE FROM `ligacoes` WHERE `id_usuario`= ? AND `id_ficha` in (SELECT id FROM fichas_personagem WHERE token = ? );");
			$b->bind_param("is", $_SESSION["UserID"], $token);
			$b->execute();
			break;
	}
}
$a = $con->query("Select * from `missoes` WHERE `mestre` = '" . $_SESSION["UserID"] . "';");
$b = $con->query("Select * from `fichas_personagem` WHERE `usuario` = '" . $_SESSION["UserID"] . "';");

$c = $con->query("SELECT L.*, m.nome,m.descricao as m_token FROM ligacoes L INNER JOIN missoes m on L.id_missao = m.id AND L.id_usuario = '" . $_SESSION["UserID"] . "' AND L.id_ficha is null;");

$z = $con->query("SELECT * from fichas_personagem WHERE id not in (SELECT id_ficha from ligacoes WHERE id_ficha is not null) AND usuario = '" . $_SESSION["UserID"] . "';");
?>
<!DOCTYPE html>
<html lang="br" data-bs-theme="<?=$_COOKIE["theme"]?:"auto"?>">
<head>
	<?php require_once "./../includes/head.html"; ?>
    <title>Sessões - FichasOP</title>
</head>
<body>

<?php require_once "./../includes/top.php"; ?>

<main class="container-flex justify-content-center m-4">
    <div class="row row-cols-1 g-3">
		
		<?php if ($c->num_rows) {
			?>
            <div>
                <div class="card border-secondary">
                    <div class="card-header text-center font10"><h3>Convites de Missões</h3></div>
                    <div class="card-body">
                        <div class="row g-3 row-cols-1 row-cols-lg-2">
							<?php foreach ($c as $p) { ?>
                                <div class="col">
                                    <div class="card border-dashed border-info" id="<?= $p["token"] ?>">
                                        <div class="card-header text-info">
                                            <span class="fs-4 font10 title"><?= $p["nome"] ?></span>
                                        </div>
                                        <div class="card-body overflow-auto" style="height: 150px;">
                                            <p class="m-1 font7 desc"><?= $p["descricao"] ?></p>
                                        </div>
                                        <div class="card-footer d-grid">
                                            <button type="button"
                                                    class="border-dashed border-info btn btn-outline-info dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                Convite de missão
                                            </button>

                                            <ul class="dropdown-menu border border-secondary">
                                                <li><a class="dropdown-item"
                                                       href='personagem/criar?convite=<?= $p["token"]; ?>'>Aceitar
                                                        e Criar uma ficha</a></li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
												<?php
												foreach ($z as $ficha) {
													?>
                                                    <li>
                                                        <button class="dropdown-item"
                                                                onclick="aceitarconvite('<?= $p["token"] ?>','<?= $ficha["token"] ?>')">
                                                            Aceitar - <?= $ficha["nome"] ?></button>
                                                    </li>
													<?php
												}
												?>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <button class="dropdown-item"
                                                            onclick="recusarconvite('<?= $p["token"] ?>')">
                                                        Recusar Pedido
                                                    </button>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                </div>
							<?php } ?>

                        </div>
                    </div>
                </div>
            </div>
		<?php } ?>
        <div>
            <div class="card  border-secondary">
                <div class="card-header text-center font10"><h3>Missões/Sessões</h3></div>
                <div class="card-body">
                    <div class="row g-3 row-cols-1 row-cols-lg-2">
						<?php
						foreach ($a as $m) { ?>
                            <div class="col">
                                <div class="card border-danger" id="<?= $m["token"] ?>">
                                    <div class="card-header text-danger"><span
                                                class="fs-4 font10 title"><?= $m["nome"] ?></span>
                                        <button type="button" class="btn btn-sm text-muted float-end"
                                                data-bs-toggle="modal"
                                                data-bs-target="#configmissao"
                                                onclick="configmissao('<?= $m["token"] ?>')">
                                            <i
                                                    class="fa-solid fa-gear"></i></button>

                                    </div>
                                    <div class="card-body overflow-auto" style="height: 150px;">
                                        <p class="m-1 font7 desc"><?= $m["descricao"] ?></p>
                                    </div>

                                    <div class="card-footer d-grid">
                                        <a class="btn btn-outline-danger" href="./mestre/?token=<?= $m["token"] ?>">Acessar
                                            Painel</a>
                                    </div>
                                </div>
                            </div>
						<?php } ?>

                        <div class="col">
                            <div class="card border-dashed border-danger">
                                <div class="card-header text-danger"><span class="fs-4 font10">Criar Missão</span></div>
                                <div class="card-body overflow-auto" style="height: 150px;">
                                    <p class="m-1 font7">Para criar uma missão basta apenas clicar abaixo. Comece com um
                                        título e uma descrição.</p>
                                </div>

                                <div class="card-footer d-grid">
                                    <a class="btn btn-outline-secondary border-secondary border-dashed" data-bs-toggle="modal" data-bs-target="#criarsessao">Criar
                                        missão</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="card border-secondary">
                <div class="card-header text-center font10"><h3>Personagens e Fichas</h3></div>
                <div class="card-body">
                    <div class="row g-3 row-cols-1 row-cols-lg-2">
			
						
						<?php foreach ($b as $f) {
							$mq = $con->query("SELECT * FROM missoes WHERE id in (SELECT id_missao FROM ligacoes WHERE id_ficha = '" . $f["id"] . "')");
							if ($mq->num_rows) $m = mysqli_fetch_array($mq);
							?>

                            <div class="col">
                                <div class="card h-100 border-primary">
                                    <div class="card-header text-primary"><span
                                                class="fs-4 font10"><?= $f["nome"] ?></span>
                                        <div class="float-end d-inline">
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                    title="Desvincular Ficha da missão" onclick="desvincular('<?= $f["token"] ?>')">
                                                <i class="fal fa-chain"></i>
                                            </button>
                                            <a class="btn btn-sm btn-outline-info"
                                               href="personagem/portrait?token=<?= $f["token"]; ?>"><i
                                                        class="fal fa-user"></i></a>
                                            <a class="btn btn-sm btn-outline-info"
                                               href="personagem/impresso?token=<?= $f["token"]; ?>"><i
                                                        class="fal fa-print"></i></a>
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#configplayer"
                                                    onclick="configplayer('<?= $f["token"] ?>')"><i
                                                        class="fal fa-gear"></i></button>
                                            <button type="button" class="btn btn-sm"
                                                    title="Ficha está atualmente <?= $f["public"] ? "Visivel" : "Invisivel" ?>">
                                                <i class="fal fa-eye<?= $f["public"] ? " text-success" : "-slash text-danger" ?>"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body" style="height: 150px;">
                                        <div class="row justify-content-between">
                                            <div class="d-none d-sm-inline   col-auto align-self-center p-0">
                                                <img src="<?= $f["foto"] ?>" class="border rounded-circle" style="aspect-ratio: 1/1; height: 115px">
                                            </div>
                                            <div class="col align-self-center">
                                                <div class="row g-0 p-0 row-cols-2 justify-content-center">

                                                    <div class="">
                                                        <div class="position-relative border">
                                                            <span class="text-muted bg-body overname position-absolute translate-middle-y text-center font10">Classe:</span>
                                                            <div class="pt-4 px-2 text-truncate "><?= $f["classe"] ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <div class="position-relative border">
                                                            <span class="text-muted bg-body overname position-absolute translate-middle-y text-center font10">Trilha:</span>
                                                            <div class="pt-4 px-2 text-truncate "><?= $f["trilha"] ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <div class="position-relative border">
                                                            <span class="text-muted bg-body overname position-absolute translate-middle-y text-center font10">Origem:</span>
                                                            <div class="pt-4 px-2 text-truncate "><?= $f["origem"] ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <div class="position-relative border">
                                                            <span class="text-muted bg-body overname position-absolute translate-middle-y text-center font10">Missão:</span>
                                                            <div class="pt-4 px-2 text-truncate"><?= ($mq->num_rows) ? $m["nome"] : "Nenhuma" ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-grid">
                                        <a class="btn btn-outline-primary"
                                           href='personagem?token=<?= $f["token"]; ?>'>Abrir</a>
                                    </div>
                                </div>
                            </div>
						<?php } ?>
                        <div class="col">
                            <div class="card border-dashed border-primary">
                                <div class="card-header text-primary"><span class="fs-4 font10">Criar Personagem</span>
                                </div>
                                <div class="card-body overflow-auto" style="height: 150px;">
                                    <p class="m-1 font7">Crie seu personagem e comece sua aventura!</p>
                                </div>

                                <div class="card-footer d-grid">
                                    <a class="btn btn-outline-secondary border-secondary border-dashed" href="./personagem/criar">Criar personagem</a>
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
    <form class="modal" id="criarsessao" tabindex="-1" method="post" novalidate>
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-secondary">
                <div class="modal-header">
                    <h4 class="modal-title">Criar uma sessão como mestre</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="m-2 return"></div>
                    <div class="m-2">
                        <label class="form-floating w-100">
                            <input type="text" name="title" class="form-control" placeholder="Título da missão" required/>
                            <label>Titulo da missão</label>
                        </label>
                    </div>
                    <div class="m-2">
                        <label class="form-floating w-100">
                            <textarea type="text" name="desc" class="form-control h-50" required rows="5" placeholder="descrição da missão"></textarea>
                            <label>Introdução da missão</label>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Criar Missão</button>
                    <input type="hidden" name="status" value="criarmissao">
                </div>
            </div>
        </div>
    </form>
    <form class="modal" id="configplayer" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-secondary">
                <div class="modal-header text-center">
                    <h4 class="modal-title">Configurações da ficha</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="view" value="1" role="switch"
                               id="visivel">
                        <label class="form-check-label" for="visivel">Tornar ficha vísivel para todo mundo</label>
                    </div>
                    <input type="hidden" name="status" value="player">
                    <input type="hidden" id="inputidficha" name="token" value="">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="deletficha" onclick="deleteficha()"><i
                                class="fa-regular fa-trash"></i></button>
                    <button type="submit" class="btn btn-sm btn-primary ms-auto"><i class="far fa-floppy-disk"></i>
                        Salvar
                    </button>
                </div>
            </div>
        </div>
    </form>

    <form class="modal" id="configmissao" tabindex="-1" novalidate method="post">
        <div class="modal-dialog">
            <div class="modal-content border-secondary">
                <div class="modal-header">
                    <h3 class="modal-title">Configurações da missão</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="return m-2"></div>
                    <div class="m-2">
                        <label class="form-floating w-100 ">
                            <input name="title" type="text" class="form-control title"
                                   placeholder="titulo missão">
                            <label>Título</label>
                        </label>
                    </div>
                    <div class="m-2">
                        <label class="form-floating w-100">
                                <textarea name="desc" style="min-height: 200px" rows="7"
                                          class="form-control desc"
                                          placeholder="descrição missão"></textarea>
                            <label>Descrição da missão</label>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger me-auto" id="deletmissao" onclick="deletemissao()">
                        <i class="fa-regular fa-trash"></i> Deletar Missão Permanentemente!
                    </button>
                    <button type="submit" class="btn btn-primary">Salvar Configurações</button>
                    <input type="hidden" name="status" value="editmis">
                    <input type="hidden" id="inputidmissao" name="id" value="">
                </div>
            </div>
        </div>
    </form>
</div>
<?php require_once "./../includes/scripts.php"; ?>

<script>
    function query(query, token, confirmacao = null, texto = "") {
        //todo
        if (confirmacao) {
            confirmar("Tem certeza?", texto).then((s) => {
                if (s) {
                    $.ajax({
                        url: "",
                        method: "POST",
                        data: {
                            status: query,
                            token: token
                        },
                        success: (d) => {
                            console.log(d)
                        },
                        complete:(d)=>{
                            location.reload();
                        }
                    })
                }
            });
        } else {

            $.ajax({
                url: "",
                method: "POST",
                data: {
                    status: query,
                    token: token
                },
                success: (d) => {
                    console.log(d)
                },
                complete:(d)=>{
                    location.reload();
                }
            })
        }
    }


    function desvincular(p) {
        confirmar("Tem certeza?", "Ao Desvincular, não será possível reverter.").then((s) => {
            if (s) {
                $.post({
                    data: {status: "desp", token: p},
                    url: "",
                }).done(function () {
                    location.reload();
                });
            }
        })
    }

    function aceitarconvite(idt, idf) {
        $.post({
            url: '',
            data: {status: 'acc', idt: idt, token: idf},
        }).done(function () {
            location.reload();
        })
    }

    function recusarconvite(idt) {
        $.post({
            url: '',
            data: {status: 'rcc', idt: idt},
        }).done(function () {
            location.reload();
        })
    }

    function deleteficha(id) {
        confirmar("Deseja apagar essa ficha?", "Ao fazer isso não será possível reverter.").then((s) => {

            console.log(s)
            if (s) {
                $.post({
                    url: '',
                    data: {token: id, status: "deleteficha"},
                }).done(function (data) {
                    location.reload();
                })
            }
        })
    }

    function deletemissao(t) {
        confirmar("Deseja apagar essa missão?", "Não será possível desfazer essa ação.").then((s) => {
            console.log(s)
            if (s) {
                $.post({
                    url: '',
                    data: {status: "deletemissao", tk: t},
                }).done(function () {
                    location.reload();
                })
            }
        })
    }

    function configplayer(id) {
        $("#inputidficha").val(id);
        $("#deletficha").attr("onclick", `deleteficha("${id}")`);
    }

    function configmissao(token) {
        $("#inputidmissao").val(token);
        $("#configmissao .title").val($(`#${token} .title`).html());
        $("#configmissao .desc").val($(`#${token} .desc`).html());
        $("#deletmissao").attr("onclick", 'deletemissao("' + token + '")');
    }

    $(document).ready(function () {
        $('#configplayer').on('submit', function (e) {
            e.preventDefault();
            $.post({
                url: '',
                data: $('#configplayer').serialize(),
            }).done(function () {
                location.reload();
            })
        })

        $('#criarsessao').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            $.post({
                beforeSend: function () {
                    $("#criarsessao input, #criarsessao textarea, #criarsessao button").attr('disabled', true);
                    $("#criarsessao .return").html("<div class='alert alert-warning'>Aguarde enquanto verificamos os dados...</div>");
                },
                url: "index.php",
                data: form.serialize(),
                dataType: "JSON",
                error: function (data) {
                    console.log(data)
                    $("#criarsessao input, #criarsessao textarea, #criarsessao button").attr('disabled', false);
                    $("#criarsessao .return").html("<div class='alert alert-danger'>Houve um erro ao fazer a solicitação, contate um administrador!</div>");
                },
            }).done(function (data) {
                console.log(data);
                if (data.msg) {
                    if (!data.success) {
                        $("#criarsessao .return").html('<div class="alert alert-danger">' + data.msg + "</div>");
                        $("#criarsessao input, #criarsessao textarea, #criarsessao button").attr('disabled', false);
                    } else {
                        $("#criarsessao .return").html('<div class="alert alert-success">' + data.msg + '</div>');
                        window.location.href = "./";
                    }
                }

            });
        })

        $('#configmissao').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            $.post({
                beforeSend: function () {
                    $("#configmissao input, #configmissao textarea, #configmissao button").attr('disabled', true);
                    $("#configmissao .return").html("<div class='alert alert-warning'>Aguarde enquanto verificamos os dados...</div>");
                },
                url: "index.php",
                data: form.serialize(),
                dataType: "JSON",
                error: function (data) {
                    console.log(data)
                    $("#configmissao input, #configmissao textarea, #configmissao button").attr('disabled', false);
                    $("#configmissao .return").html("<div class='alert alert-danger'>Houve um erro ao fazer a solicitação, contate um administrador!</div>");
                },
            }).done(function (data) {
                console.log(data);
                if (data.msg) {
                    if (!data.success) {
                        $("#configmissao .return").html('<div class="alert alert-danger">' + data.msg + "</div>");
                        $("#configmissao input, #configmissao textarea, #configmissao button").attr('disabled', false);
                    } else {
                        $("#configmissao .return").html('<div class="alert alert-success">' + data.msg + '</div>');
                        window.location.href = "./";
                    }
                }

            });
        });
    });
</script>
</body>
</html>
