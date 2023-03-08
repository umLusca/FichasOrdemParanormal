<?php
header("X-Robots-Tag: none");
require_once "./../../../config/includes.php";
$con = con();
if (!isset($_SESSION['UserID'])) {
    proibido();
}
$id = cleanstring($_GET["convite"]);
?>
<!DOCTYPE html>
<html lang="br">
<head>
	<?php require_once "./../../../includes/head.html"; ?>
    <title>Criar Personagem - FichasOP</title>
</head>
<body class="">
<?php require_once "./../../../includes/top.php"; ?>
<main class="container my-3" id="tudo">
    <form class="card needs-validation" novalidate autocomplete="off" id="criar">
        <div class="card-header font6">
            <span class="fs-4">Criar um Novo Personagem</span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-xl-6">
                    <div class="text-center">
                        <h4>Detalhes Principais</h4>
                    </div>
                    <div class="m-2">
                        <label class="form-floating">
                            <select class="form-select" id="foto" name="foto">
                                <option value="1">Desconhecido - Masculino</option>
                                <option value="2">Desconhecido - Feminino</option>
                                <option value="3">Mauro Nunes</option>
                                <option value="4">Maya Shiruze</option>
                                <option value="5">Bruna Sampaio</option>
                                <option value="6">Leandro Weiss</option>
                                <option value="7">Jaime Orthuga</option>
                                <option value="8">Aniela Ukryty</option>
                                <option value="9">Customizada</option>
                            </select>
                            <label>Estilo de foto.</label>
                        </label>
                    </div>
                    <div class="m-2" id="divfotourl" style="display: none;">
                        <div class="row">
                            <div class="col">
                                <label class="form-floating">
                                    <input id="fotourl" class="form-control" name="fotourl" type="url" required disabled/>
                                    <label>Link da imagem</label>
                                    <span class="invalid-feedback">A Imagem precisa ser valida</span>
                                    <span id="warning"></span>
                                </label>
                            </div>
                            <div id="prev" class="col-auto d-flex align-items-center"></div>
                        </div>
                    </div>
                    <div class="row mx-1 g-2">
                        <div class="col-12 col-md-6 col-lg-4 col-xl-6">
                            <label class="form-floating">
                                <input class="form-control" name="nome" required="required"/>
                                <label for="nome">Nome do Personagem</label>
                                <span class="invalid-feedback">
                        Coloque o Nome do seu personagem.(Apenas letras e espaços).
                    </span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 col-lg-1 col-xl-3">
                            <label class="form-floating">

                                <input class="form-control" type="number" min="0" max="150" name="idade" value="0" required/>
                                <label>Idade</label>
                                <span class="invalid-feedback">
                        Coloque a idade do seu personagem.
                        Coloque 0 Para Desconhecido.
                    </span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 col-lg-1 col-xl-3">
                            <label class="form-floating">
                                <input class="form-control" type="number" value='5' min="0" max="99" name="nex" required/>
                                <label>NEX</label>
                            </label>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 col-xl-6">
                            <label class="form-floating">
                                <input class="form-control" name="local" maxlength="100"/>
                                <label>Local de Nascimento (Opcional)</label>
                            </label>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 col-xl-6">
                            <label class="form-floating">
                                <input type="text" class="form-control" maxlength="50" list="origens" name="origem" required>
                                <label>Origem</label>
                                <span class="invalid-feedback">Esse campo é obrigatório</span>
                            </label>
                            <datalist id="origens">
			                    <?= Super_options("origens") ?>
                            </datalist>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 col-xl-6">
                            <label class="form-floating">
                                <input type="text" class="form-control" maxlength="50" list="classes" name="classe" required>
                                <label>Classe</label>
                                <span class="invalid-feedback">Preencha a classe do seu personagem</span>
                            </label>
                            <datalist id="classes">
								<?= Super_options("classes") ?>
                            </datalist>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 col-xl-6">
                            <label class="form-floating">
                                <input type="text" class="form-control" maxlength="50" list="trilhas" name="trilha" required>
                                <label>Trilha</label>
                                <span class="invalid-feedback">Preencha a trilha do seu personagem</span>
                            </label>
                            <datalist id="trilhas">
								<?= Super_options("trilhas") ?>
                            </datalist>
                        </div>
                        <div class="col-12 col-lg-4 col-xl-12">
                            <label class="form-floating">
                                <input type="text" class="form-control" maxlength="50" list="patentes" name="patente">
                                <label>Patente</label>
                            </label>
                            <datalist id="patentes">
								<?= Super_options("patentes") ?>
                            </datalist>
                        </div>
                        <div class="col-12">
                            <label class="form-floating">
                                <textarea class="form-control" name="historia"></textarea>
                                <label>Resumo da História de como entrou para Ordem (Opcional)</label>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-6">
                    <div class="text-center">
                        <h4>Atributos</h4>
                    </div>
                    <i class="text-info"><i class="fa-regular fa-circle-info"></i> Clique nos circulos</i>
                    <div class="containera" id="atributos" title="Atributos, clique para editar">
						<?= atributos(1, 1, 1, 1, 1, 1, 1) ?>
                    </div>
                    <div class="text-center mt-2">
                        <h4>Saúde</h4>
                    </div>
                    <i class="text-info"><i class="fa-regular fa-circle-info"></i> Deixe 1 para cálculo automatico</i>
                    <div class="m-2 row g-2">
                        <div class="col-12 col-md-4 col-xl-4">
                            <label class="form-floating">
                                <input class="form-control" type="number" min="1" max="999" value="1" name="pv" required/>
                                <label>Vida Maxima</label>
                            </label>
                        </div>
                        <div class="mcol-12 col-md-4 col-xl-4">
                            <label class="form-floating">
                                <input class="form-control" type="number" min="0" max="999" value="1" name="san" required/>
                                <label>Sanidade Maxima</label>
                            </label>
                        </div>
                        <div class="col-12 col-md-4 col-xl-4">
                            <label class="form-floating">
                                <input class="form-control" type="number" min="0" max="999" value="1" name="pe" required/>
                                <label>Pontos de Esforço</label>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success w-100" id="submit">Enviar e Criar Personagem</button>
        </div>
        <input type="hidden" value="<?= $id ?>" name="convite">
    </form>
</main>
<?php require_once "./../../../includes/scripts.php"; ?>
<script>
    $(()=>{
        $('#fotourl').on('input', function () {
            var src = jQuery(this).val();

            if (!src.match("^https?://(?:[a-z\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpg|png|jpeg|webp)$") && src != "") {
                $("#warning").html("Precisa ser HTTPS, e Terminar com com extensão de imagem(.jpg, .png ...)!");
                $('#prev').html('');
                return false;
            } else {
                $("#warning").html("");
                $('#prev').html('<img class="rounded-circle border border-light" style="max-width:100px;" src="' + src + '">');
            }

        })
        $('#foto').change(function () {
            let fotovalor = $('#foto').val()
            console.log(fotovalor);
            if (fotovalor == '9') {
                $('#divfotourl').show();
                $("#fotourl").attr("disabled", false)
                console.log("show");
            } else {
                $('#divfotourl').hide();
                $("#fotourl").attr("disabled", true)
                console.log("hide");
            }
        });
        $('#criar').submit(function (event) {
            $("#criar").addClass("was-validated")
            event.preventDefault()
            event.stopPropagation()
            
            if ($("#criar")[0].checkValidity()) {
                $.post({
                    url: "salvar.php",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: (data) => {
                        if (data.msg) {
                            if (data.success) {
                                $('#msg').html('<div class="alert alert-success">' + data.msg + '</div>');
                                $('#modalfooter').html('<a class="btn btn-success" href="./../?id=' + data.id + '" >Abrir Ficha</a><a class="btn btn-success">Fechar</a>');
                                $("#submit input").attr('disabled', true);
                                confirmar("Personagem criado!", "Deseja abrir a ficha?").then(s => {
                                    if(s){
                                        location.href = "/sessao/personagem/?id="+data["id"];
                                    } else {
                                        location.href = "/sessao";
                                    }
                                });
                            } else {
                                alert(data.msg);
                            }
                        }
                    },
                    error: () => {

                        alert("Houve uma falha, verifique sua internet ou contate um administrador!");
                    }
                })
            }
        })

    })
</script>
</body>
</html>