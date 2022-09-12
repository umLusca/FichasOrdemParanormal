<?php
header("X-Robots-Tag: none");
require_once "./../../../config/includes.php";
$con = con();
if (!isset($_SESSION['UserID'])) {
    echo "<script>window.location.href='/'</script>";
}
$id = intval($_GET["convite"]);
?>
<!DOCTYPE html>
<html lang="br">
    <head>
        <?php require_once "./../../../includes/head.html";?>
        <title>Criar Personagem - Fichas OP</title>
    </head>
    <body class="bg-black text-white">
        <main class="container-fluid my-5" id="tudo">
            <div class="card bg-black border-0">
                <div class="card-body">
                    <form class="needs-validation" method="post" novalidate autocomplete="off" id="criar">
                        <div class="card-title text-center font6">
                            <h1>Criar um Novo Personagem</h1>
                        </div>
                        <div class="row">
                            <div class="col-lg p-1 mx-lg-1 my-1 card bg-black border-light">
                                <div class="card-body">
                                    <div class="card-title text-center font6"><h2>Detalhes Principais</h2></div>
                                    <div class="pt-3">
                                        <label for="foto" class="fs-4 fw-bold">Estilo de foto.</label>
                                        <select class="form-select bg-black text-light border-light" id="foto" name="foto">
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
                                    </div>
                                    <div class="pt-3" id="divfotourl" style="display: none;">
                                        <label for="fotourl" class="fs-4 fw-bold">Link da imagem</label>
                                        <div class="row">
                                            <div class="col-8">
                                                <input id="fotourl" class="form-control bg-black text-light border-light"
                                                       name="fotourl" type="url" required disabled/>
                                                <div class="invalid-feedback">A Imagem precisa ser valida</div>
                                            </div>
                                            <div id="prev" class="col-4 d-flex align-items-center"></div>
                                        </div>
                                        <div id="warning"></div>
                                    </div>
                                    <div class="pt-3">
                                        <label class="fs-4 fw-bold" for="nome">Nome do Personagem</label>
                                        <input class="form-control bg-black text-light border-light" id="nome" name="nome" required="required"/>
                                        <div class="invalid-feedback">
                                            Coloque o Nome do seu personagem.(Apenas letras e espaços).
                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <label class="fs-4 fw-bold" for="idade">Idade</label>
                                        <input class="form-control bg-black text-light border-light" type="number" min="0"
                                               max="150" id="idade" name="idade" value="0" required/>
                                        <div class="invalid-feedback">
                                            Coloque a idade do seu personagem.
                                            Coloque 0 Para Desconhecido.
                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <label for="localnascimento" class="fs-4 fw-bold">Local de Nascimento (Opcional)</label>
                                        <input id="localnascimento" class="form-control bg-black text-light border-light" name="local"/>
                                    </div>
                                    <div class="pt-3">
                                        <label class="fs-4 w-100" for="origem">Origem
                                            <input type="text" class="form-control bg-black text-light" maxlength="50" list="origens" name="origem" required>
                                            <datalist id="origens">
                                                <option selected>Desconhecido</option>
                                                <option>Acadêmico</option>
                                                <option>Agente de Saúde</option>
                                                <option>Amnésico</option>
                                                <option>Artista</option>
                                                <option>Atleta</option>
                                                <option>Chef</option>
                                                <option>Criminoso</option>
                                                <option>Cultista Arrependido</option>
                                                <option>Desgarrado</option>
                                                <option>Engenheiro</option>
                                                <option>Executivo</option>
                                                <option>Investigador</option>
                                                <option>Lutador</option>
                                                <option>Magnata</option>
                                                <option>Mercenário</option>
                                                <option>Militar</option>
                                                <option>Operário</option>
                                                <option>Policial</option>
                                                <option>Religioso</option>
                                                <option>Servidor Público</option>
                                                <option>Teórico da Conspiração</option>
                                                <option>T.I.</option>
                                                <option>Trabalhador Rural</option>
                                                <option>Trambiqueiro</option>
                                                <option>Universitário</option>
                                                <option>Vítima</option>
                                            </datalist>
                                        </label>
                                    </div>

                                    <div class="pt-3">
                                        <label for="nex" class="fs-4 fw-bold">Nivel de Exposição Paranormal (NEX)</label>
                                        <input class="form-control bg-black text-light border-light" id="nex" type="number" value='5' min="0" max="99" name="nex" required/>
                                        <div class="invalid-feedback">
                                            Providencie um nivel de exposição paranormal.
                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <div class="row">
                                            <div class="col">
                                                <label class="fs-4 w-100" for="classe">Classe
                                                <input type="text" class="form-control bg-black text-light" maxlength="50" list="classes" name="classe" required>
                                                    <span class="invalid-feedback">
                                                        Preencha a Classe do seu personagem
                                                    </span>
                                                    <datalist id="classes">
                                                        <option selected>Mundano</option>
                                                        <option>Combatente</option>
                                                        <option>Especialista</option>
                                                        <option>Ocultista</option>
                                                    </datalist>
                                                </label>
                                            </div>
                                            <div class="col">
                                                <label class="fs-4 w-100" for="trilha">Trilha
                                                <input type="text" class="form-control bg-black text-light" maxlength="50" list="trilhas" name="trilha" required>
                                                    <span class="invalid-feedback">
                                                        Preencha a Classe do seu personagem
                                                    </span>
                                                    <datalist id="trilhas">
                                                        <option>Nenhuma</option>
                                                        <option>Aniquilador</option>
                                                        <option>Comandante de Campo</option>
                                                        <option>Guerreiro</option>
                                                        <option>Operações Especiais</option>
                                                        <option>Tropa de Choque</option>
                                                        <option>Atirador de Elite</option>
                                                        <option>Infiltrador</option>
                                                        <option>Médico de Campo</option>
                                                        <option>Negociador</option>
                                                        <option>Técnico</option>
                                                        <option>Conduíte</option>
                                                        <option>Flagelador</option>
                                                        <option>Graduado</option>
                                                        <option>Intuitivo</option>
                                                        <option>Lâmina Paranormal</option>
                                                    </datalist>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <label for="patente" class="fs-4 fw-bold">Patente</label>
                                        <select class="form-select bg-black text-light border-light" id="patente" name="patente" required>
                                            <option value="0">Desconhecido</option>
                                            <option value="1">Recruta</option>
                                            <option value="2">Operador</option>
                                            <option value="3">Agente Especial</option>
                                            <option value="4">Oficial de Operações</option>
                                            <option value="5">Agente de Elite</option>
                                        </select>
                                    </div>
                                    <div class="pt-3">
                                        <label class="fs-4 fw-bold" for="historia">Resumo da História de como entrou para Ordem (Opcional)</label>
                                        <textarea class="form-control bg-black text-light border-light" id="historia" name="historia"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg p-1 mx-lg-1 my-1 card bg-black border-light">
                                <div class="card-body p-0">
                                    <div class="card-title text-center font6"><h2>Atributos e Saúde</h2></div>
                                    <div class="container p-0">
                                        <i class="text-info"><i class="fa-regular fa-circle-info"></i> Clique nos circulos</i>
                                        <div class="containera text-white" id="atributos" title="Atributos, clique para editar">
	                                        <?=atributos(1,1,1,1,1,1,1)?>
                                        </div>
                                        <div class="p-2 m-1">
                                            <label class="fs-4 fw-bold w-100">Vida Maxima (PV)<span>(Deixe 1 para calcular automaticamente)</span>
                                                <input class="form-control bg-black text-light border-light" type="number" min="1" max="999" value="1" name="pv" required/>
                                            </label>
                                            <label class="fs-4 fw-bold w-100">Sanidade Maxima (SAN)<span>(Deixe 1 para calcular automaticamente)</span>
                                                <input class="form-control bg-black text-light border-light" type="number" min="0" max="999" value="1" name="san" required/>
                                            </label>

                                            <label class="fs-4 fw-bold w-100">Pontos de Esforço (PE)<span>(Deixe 1 para calcular automaticamente)</span>
                                                <input class="form-control bg-black text-light border-light" type="number" min="0" max="999" value="1" name="pe" required/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success d-grid" id="submit">Enviar e Criar Personagem</button>
                        </div>
                        <input type="hidden" value="<?=$id?>" name="convite">
                    </form>
                </div>
            </div>
        </main>
        <div class="modal fade" id="modal" aria-hidden="true" aria-labelledby="titulomodal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-black border-light text-white">
                    <div class="modal-body">
                        <div class="modal-header border-0">
                            <h5 class="modal-title" id="titulomodal">Criar Personagem</h5>
                        </div>
                        <div id="msg"></div>
                        <div class="modal-footer border-0" id="modalfooter">
                            <button class="btn btn-success" href="./..">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once "./../../../includes/scripts.php";?>
        <?php require_once "./../../../includes/top.php";?>
        <script>
            $("#nex").on('input', function () {
                $("#trilha .trilha").hide();
                $("#trilha").val(0);
                if($("#nex").val() > 9){
                    if($('#classe').val() == 1) {
                        $("#trilha .trilha-combatente").show();
                    }else if($('#classe').val() == 2) {
                        $("#trilha .trilha-especialista").show();
                    }else if($('#classe').val() == 3) {
                        $("#trilha .trilha-ocultista").show();
                    }
                }
            })
            $("#classe").change(function (){
                $("#trilha .trilha").hide();
                $("#trilha").val(0);
                if($("#nex").val() > 9){
                    if($(this).val() == 1) {
                        $("#trilha .trilha-combatente").show();
                    }else if($(this).val() == 2) {
                        $("#trilha .trilha-especialista").show();
                    }else if($(this).val() == 3) {
                        $("#trilha .trilha-ocultista").show();
                    }
                }
            })
            $('#fotourl').on('input', function () {
                var src = jQuery(this).val();

                if (!src.match("^https?://(?:[a-z\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpg|png|jpeg|webp)$") && src != "") {
                    $("#warning").html("Precisa ser HTTPS, e Terminar com com extensão de imagem(.jpg, .png ...)!");
                    $('#prev').html('');
                    return false;
                } else {
                    $("#warning").html("");
                    $('#prev').html('<img class="position-absolute rounded-circle border border-light" style="max-width:100px;" src="' + src + '">');
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
            })

            var formu = document.getElementById('criar');
            var myModal = new bootstrap.Modal(document.getElementById('modal'), {
                keyboard: false
            })
            $('#modalfooter').html('');
            $('#criar').submit(function (event) {
                formu.classList.add('was-validated');
                if (!formu.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                } else {
                    $("#tudo").hide()
                    event.preventDefault();
                    $.post({
                        url: "salvar.php",
                        data: $(this).serialize(),
                        dataType: "JSON",
                    }).done(function (data) {
                        if (data.msg) {
                            if (data.success) {
                                $('#msg').html('<div class="alert alert-success">' + data.msg + '</div>');
                                $('#modalfooter').html('<a class="btn btn-success" href="./../?id=' + data.id + '" >Abrir Ficha</a><a class="btn btn-success">Fechar</a>');
                                $("#submit input").attr('disabled', true);
                            } else {
                                $("#tudo").show();
                                $('#msg').html('<div class="alert alert-danger">' + data.msg + '</div>');
                                $("#submit input").attr('disabled', false)
                            }
                            myModal.show();
                        }
                    }).fail(function () {
                        $("#tudo").show();
                        $('#msg').html('<div class="alert alert-danger">Falha ao criar personagem, contate um administrador!</div>');
                        myModal.show();
                    })
                }
            })

        </script>
    </body>
</html>