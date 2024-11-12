<?php


if (!isset($_SESSION["UserID"])) {
	header("Location: /");
	exit;
}
$userid = $_SESSION["UserID"];
$con = con();
if (isset($_POST["status"])) {
	$success = true;
	$msg = '';
	switch ($_POST["status"]) {
		case "duplicate":
			$token = cleanstring($_POST["token"]);
			$a = $con->prepare("SELECT * FROM fichas_personagem WHERE token = ? AND usuario = ?");
			$a->bind_param("si", $token, $_SESSION["UserID"]);
			$a->execute();
			$ra = mysqli_fetch_assoc($a->get_result());
			
			$stmt = duplicate_row($ra, array("nome" => $ra["nome"] . " - Cópia", "token" => uniqid("ficha_", true)), array("id"));
			
			$b = $con->prepare("INSERT INTO fichas_personagem ({$stmt["query_columns"]}) VALUES ({$stmt["query_values"]})");
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
	<?php require_once ROOT . "/_COMPONENTS/head.html"; ?>
    <title>Sessões - FichasOP</title>
</head>
<body>

<?php require_once ROOT . "/_COMPONENTS/top.php"; ?>

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
                                                       href='/ficha/<?= $p["token"]; ?>'>Aceitar
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
                                        <a class="btn btn-outline-danger" href="/mestre/<?= $m["token"] ?>">Acessar
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
                    <list_fichas class="row g-3 row-cols-1 row-cols-lg-2">
			
						
						<?php foreach ($b as $f) {
							$mq = $con->query("SELECT * FROM missoes WHERE id in (SELECT id_missao FROM ligacoes WHERE id_ficha = '" . $f["id"] . "')");
							if ($mq->num_rows) $m = mysqli_fetch_array($mq);
							?>

						<?php } ?>
                        <div class="col">
                            <div class="card border-dashed border-primary">
                                <div class="card-header text-primary"><span class="fs-4 font10">Criar Personagem</span>
                                </div>
                                <div class="card-body overflow-auto" style="height: 150px;">
                                    <p class="m-1 font7">Crie seu personagem e comece sua aventura!</p>
                                </div>

                                <div class="card-footer d-grid">
                                    <a class="btn btn-outline-secondary border-secondary border-dashed" href="/ficha/criar">Criar personagem</a>
                                </div>
                            </div>
                        </div>
                    </list_fichas>
                </div>
            </div>
        </div>
    </div>
</main>
<div id="modals">
</div>
<?php require_once ROOT . "/_COMPONENTS/scripts.php"; ?>

<script>
    $(document).ready(function () {
        $.ajax({
            method: "POST",
            url:"/API/ficha/get",
            success:(d)=>{
                console.log(d);
                if (d.total){
                    d.dados.forEach(ficha => {
                        $("list_fichas").prepend(`
                            <div class="col">
                                <div class="card h-100 border-primary">
                                    <div class="card-header text-primary"><span
                                                class="fs-4 font10">${ficha.nome}</span>
                                        <div class="float-end d-inline">
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                    title="Desvincular Ficha da missão" onclick="desvincular('${ficha.token}')">
                                                <i class="fal fa-chain"></i>
                                            </button>
                                            <a class="btn btn-sm btn-outline-info"
                                               href="/ficha/${ficha.token}/portrait/"><i
                                                        class="fal fa-user"></i></a>
                                            <a class="btn btn-sm btn-outline-info"
                                               href="/ficha/${ficha.token}/impresso/"><i
                                                        class="fal fa-print"></i></a>
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#configplayer"
                                                    onclick="configplayer('${ficha.nome}')"><i
                                                        class="fal fa-gear"></i></button>
                                            <button type="button" class="btn btn-sm"
                                                    title="Ficha está atualmente ${ficha.token ? "Visivel" : "Invisivel" }">
                                                <i class="fal fa-eye${ficha.public ? " text-success" : "-slash text-danger"}"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body" style="height: 150px;">
                                        <div class="row justify-content-between">
                                            <div class="d-none d-sm-inline   col-auto align-self-center p-0">
                                                <img src="${ficha.foto}" class="border rounded-circle" style="aspect-ratio: 1/1; height: 115px" alt="">
                                            </div>
                                            <div class="col align-self-center">
                                                <div class="row g-0 p-0 row-cols-2 justify-content-center">

                                                    <div class="">
                                                        <div class="position-relative border">
                                                            <span class="text-muted bg-body overname position-absolute translate-middle-y text-center font10">Classe:</span>
                                                            <div class="pt-4 px-2 text-truncate ">${ficha.foto}</div>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <div class="position-relative border">
                                                            <span class="text-muted bg-body overname position-absolute translate-middle-y text-center font10">Trilha:</span>
                                                            <div class="pt-4 px-2 text-truncate ">${ficha.trilha}</div>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <div class="position-relative border">
                                                            <span class="text-muted bg-body overname position-absolute translate-middle-y text-center font10">Origem:</span>
                                                            <div class="pt-4 px-2 text-truncate ">${ficha.origem}</div>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <div class="position-relative border">
                                                            <span class="text-muted bg-body overname position-absolute translate-middle-y text-center font10">Missão:</span>
                                                            <div class="pt-4 px-2 text-truncate">${ficha.missao ?ficha.missao : "Nenhuma"}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-grid">
                                        <a class="btn btn-outline-primary" href='/ficha/${ficha.token}'>Abrir</a>
                                    </div>
                                </div>
                            </div>
                `);
                    
                    })
                }
            }
        })
    });
</script>
</body>
</html>
