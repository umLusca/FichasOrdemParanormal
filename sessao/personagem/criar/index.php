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
<html lang="br" data-bs-theme="<?= $_COOKIE["theme"] ?>">
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
                        <span class="fs-4">Detalhes Principais</span><span class="text-info" role="button" data-bs-toggle="modal" data-bs-target="#modal_detalhes"> <i class="fal fa-info-circle"></i></span>
                    </div>
                    <div class="row mx-1 g-2">
                        <div class="col-12 col-md-6 col-lg-4 col-xl-6">
                            <label class="form-floating">
                                <input class="form-control" name="nome" required="required"/>
                                <label for="nome">Nome do Personagem</label>
                                <span class="invalid-feedback">Coloque o Nome do seu personagem.(Apenas letras e espaços).</span>
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
                        <span class="fs-4">Atributos</span>
                        <span class="text-info" role="button" data-bs-toggle="modal" data-bs-target="#modal_atributos"><i class="fal fa-info-circle"></i></span>
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

<!-- Modal -->
<div class="modal fade" id="modal_detalhes" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Sobre os Atributos</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div id="carouselExampleIndicators" class="carousel slide">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <?php if ($_COOKIE["theme"] === "light") { ?>
                            <div class="carousel-item active">
                                <img src="/assets/img/helper_conceito_dark.png" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="/assets/img/helper_origens_dark.png" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="/assets/img/helper_classes_dark.png" class="d-block w-100" alt="...">
                            </div>
                        <?php } else { ?>
                            <div class="carousel-item active">
                                <img src="/assets/img/helper_conceito_light.png" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="/assets/img/helper_origens_light.png" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="/assets/img/helper_classes_light.png" class="d-block w-100" alt="...">
                            </div>

                        <?php } ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_atributos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Sobre os Atributos</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">

                <div class="img-fluid">
                    <?php if ($_COOKIE["theme"] !== "light") { ?>
                        <img src="/assets/img/helper_atributos_dark.png" class="d-block w-100" alt="...">
                    <?php } else { ?>
                        <img src="/assets/img/helper_atributos_light.png" class="d-block w-100" alt="...">
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once "./../../../includes/scripts.php"; ?>
<script>
    $(() => {
        $('.customurl input[name=fotourl]').on('input', function () {
            let $input = $(".customurl input[name=fotourl]")
            let src = $input.val();
            if (!src.match("^https?://(?:[a-z\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpg|png|jpeg|webp)$") && src != "") {
                $('#prev .imgpreview').attr('src', "");
                $input.addClass("is-invalid");
                return false;
            } else {
                $input.removeClass("is-invalid");
                $('#prev .imgpreview').attr('src', src);
            }

        })

        $('#editfoto .selector').change(function () {
            let foto;

            $("#editfoto .foto-perfil").val(foto)
            $("#editfoto .return").html("");
            $('#editfoto .preview img').prop("src", foto).parent().show();

        })
        $('#foto').change(function () {
            let fotovalor = $('#foto').val();
            let foto;
            switch (fotovalor) {
                case "1":
                    foto = 'https://fichasop.com/assets/img/Man.webp';
                    break;
                case "2":
                    foto = 'https://fichasop.com/assets/img/Woman.webp';
                    break;
                case "3":
                    foto = 'https://fichasop.com/assets/img/Mauro.webp';
                    break;
                case "4":
                    foto = 'https://fichasop.com/assets/img/Maya.webp';
                    break;
                case "5":
                    foto = 'https://fichasop.com/assets/img/Bruna.webp';
                    break;
                case "6":
                    foto = 'https://fichasop.com/assets/img/Leandro.webp';
                    break;
                case "7":
                    foto = 'https://fichasop.com/assets/img/Jaime.webp';
                    break;
                case "8":
                    foto = 'https://fichasop.com/assets/img/Aniela.webp';
                    break;
                case "9":
                    $('.customurl').slideDown();
                    foto = "";
                    console.log($('.customurl'))
                    break;

            }
            console.log($('.customurl'))
            if(fotovalor === '9'){
                console.log("teste")
                $('.customurl').slideDown();
                $(".customurl input[name=fotourl]").val(foto).attr("disabled", false);
            } else {
                $('.customurl').slideUp();
                $(".customurl input[name=fotourl]").attr("disabled", true);
                
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
                                    if (s) {
                                        location.href = "/sessao/personagem/?id=" + data["id"];
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