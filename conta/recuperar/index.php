<?php
require_once "./../../config/includes.php";
$con = con();
$aviso = false;
$msga= $msg = '';
$success = true;
if(isset($_GET["recovery"])){
    $hash = $_GET["recovery"];
    $s = $con->prepare("SELECT * FROM `recuperar_senha` WHERE `hash` = ? ");
    $s->bind_param("s", $hash);
    $s->execute();
    $rs = $s->get_result();
    $rs = mysqli_fetch_array($rs);
    $email = $rs["email"];
    $timestamp = strtotime($rs["data"]);
    $time = $timestamp + (48 * 60 * 60);
    $now = strtotime(date('m/d/Y h:i:s'));
    if ($now > $time) {
        $aviso = true;
        $msga = 'Este link não é mais valido ou está expirado.';
    }
} else {
    header("Location: /");
}
if(isset($_POST["reset"])){
    if (!empty($_POST["senha"] || $_POST["csenha"])) {
        if ($_POST["senha"] === $_POST["csenha"]) {
            $pass = $_POST["senha"];
            if (strlen($pass) < 8 || strlen($pass) > 50) {
                $msg = "Senha deve conter entre 8 e 50 digitos.";
                $success = false;
            }
            if (!preg_match("/[A-Z]/", $pass)) {
                $msg = "Senha precisa conter letras maiúsculas.";
                $success = false;
            }
            if (!preg_match("/[a-z]/", $pass)) {
                $msg = "Senha precisa conter letras minúsculas.";
                $success = false;
            }
            if (preg_match("/\s/", $pass)) {
                $msg = "Senha não pode conter espaços!";
                $success = false;
            }
            $senha = md5(md5($pass));

        } else {
            $msg = "As Senhas não Coincidem";
            $success = false;
        }

    } else {
        $success = false;
        $msg = "Preencha todos os campos!";
    }
    if($success){
        $rs = $con->prepare('UPDATE `usuarios` SET `senha` = ? WHERE `email` = ? ;');
        $rs->bind_param('ss',$senha,$email);
        $rs->execute();
        $rrs = $rs->get_result();
        if($rs->affected_rows){
            $dp = $con->query("DELETE FROM `recuperar_senha` WHERE `email` = '".$email."'");
        } else {
            $success = false;
            $dp = $con->query("SELECT * FROM `usuarios` WHERE `email` = '".$email."'");
            $rdp = mysqli_fetch_array($dp);
            if ($rdp["senha"] = $senha){
                $msg='Sua senha nova não pode ser igual a anterior...';
            } else {
                $msg = 'Falha ao alterar senha. contate um administrador.';
            }
        }
    }
    $data["msg"] = $success?'Sucesso ao alterar sua senha.':$msg;
    $data["success"] = $success;
    echo json_encode($data);
    exit;
}
?>
<!DOCTYPE html>
<html lang="br">
<head>
    <?php require_once "./../../includes/head.html"; ?>
    <title>Recuperar Conta - FichasOP</title>
</head>
<body class="bg-black text-light font7">
<main class="container-flex mx-0 py-5 justify-content-center">
    <div class="row m-3">
        <div class="col-md my-2 justify-content-center">
            <form class="card h-100 bg-black border-light" id="rs">
                <div class="card-body text-center">
                    <div class="card-header">
                        <h3>Recuperar Conta.</h3>
                    </div>
                    <div id="rsmsg"><?php if($aviso)echo '<div class="alert alert-warning"> '.$msga.' </div>';?></div>
                    <div id="rsbody">
                        <?php if (!$aviso){?>
                        <div class="input-group p-3">
                            <label for="rsenha" class="input-group-text bg-black border-light text-light">Nova senha</label>
                            <input id="rsenha" name="senha" type="password" class="form-control bg-black border-light text-light"/>
                        </div>
                        <div class="input-group p-3">
                            <label for="rcsenha" class="input-group-text bg-black border-light text-light">Confirmar nova senha</label>
                            <input id="rcsenha" name="csenha" type="password" class="form-control bg-black border-light text-light"/>
                        </div>
                        <?php }?>
                        <div class="card-footer d-grid" id="rsfooter">
                            <input type="hidden" name="reset" value="1">
                            <?=$aviso?'
                            <a class="btn btn-outline-light" href="/">Inicio</a>':'
                            <button class="btn btn-outline-primary">Salvar</button>'?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
<?php require_once "./../../includes/scripts.php";?>
<?php require_once "./../../includes/top.php";?>
<script>
    $('#rs').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        $.post({
            beforeSend: function () {
                $("#rsfooter").hide();
                $("#rsmsg").html("<div class='alert alert-warning'>Aguarde...</div>");
            },
            url: "",
            data: form.serialize(),
            dataType: "JSON",
            error: function () {
                $("#footerpassr").show();
                $("#passrmsg").html("<div class='alert alert-danger'>Houve um erro ao fazer a solicitação, contate um administrador!</div>");
            },
        }).done(function (data) {
            console.log(data);
            if (data.msg) {
                if (!data.success) {
                    $("#rsfooter").show();
                    $("#rsmsg").html('<div class="alert alert-danger">' + data.msg + "</div>");
                } else {
                    $("#rsmsg").html('<div class="alert alert-success">' + data.msg + '</div>');
                    $("#rsbody").html('<div class="card-footer d-grid"><a class="btn btn-outline-light" href="/">Voltar ao inicio</a></div>');
                }
            }

        });
    });
</script>
</body>
</html>
