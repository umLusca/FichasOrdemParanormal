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
                                        <label class="fs-4 fw-bold" for="origem">Origem</label>
                                        <select class="form-select bg-black text-light border-light" id="origem" name="origem">
                                            <option value="0" selected>Desconhecido</option>
                                            <option value="1">Acadêmico</option>
                                            <option value="2">Agente de Saúde</option>
                                            <option value="3">Amnésico</option>
                                            <option value="4">Artista</option>
                                            <option value="5">Atleta</option>
                                            <option value="25">Chef</option>
                                            <option value="6">Criminoso</option>
                                            <option value="7">Cultista Arrependido</option>
                                            <option value="8">Desgarrado</option>
                                            <option value="9">Engenheiro</option>
                                            <option value="10">Executivo</option>
                                            <option value="11">Investigador</option>
                                            <option value="12">Lutador</option>
                                            <option value="13">Magnata</option>
                                            <option value="14">Mercenário</option>
                                            <option value="15">Militar</option>
                                            <option value="16">Operário</option>
                                            <option value="17">Policial</option>
                                            <option value="18">Religioso</option>
                                            <option value="19">Servidor Público</option>
                                            <option value="20">Teórico da Conspiração</option>
                                            <option value="21">T.I.</option>
                                            <option value="22">Trabalhador Rural</option>
                                            <option value="23">Trambiqueiro</option>
                                            <option value="24">Universitário</option>
                                            <option value="26">Vítima</option>
                                        </select>
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
                                                <label class="fs-4 fw-bold" for="classe">Classe</label>
                                                <select class="form-select bg-black text-light border-light" id="classe" name="classe" required>
                                                    <option value="0" selected>Desconhecido</option>
                                                    <option value="1">Combatente</option>
                                                    <option value="2">Especialista</option>
                                                    <option value="3">Ocultista</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Selecione a Classe do seu Personagem.
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label class="fs-4 fw-bold" for="trilha">Trilha (Necessário 10% NEX)</label>
                                                <select class="form-select bg-black text-light border-light" id="trilha" name="trilha">
                                                    <option value="0" class="">Nenhuma</option>
                                                    <option value="1" class="trilha trilha-combatente" style="display: none;">Aniquilador</option>
                                                    <option value="2" class="trilha trilha-combatente" style="display: none;">Comandante de Campo</option>
                                                    <option value="3" class="trilha trilha-combatente" style="display: none;">Guerreiro</option>
                                                    <option value="4" class="trilha trilha-combatente" style="display: none;">Operações Especiais</option>
                                                    <option value="5" class="trilha trilha-combatente" style="display: none;">Tropa de Choque</option>
                                                    <option value="1" class="trilha trilha-especialista" style="display: none;">Atirador de Elite</option>
                                                    <option value="2" class="trilha trilha-especialista" style="display: none;">Infiltrador</option>
                                                    <option value="3" class="trilha trilha-especialista" style="display: none;">Médico de Campo</option>
                                                    <option value="4" class="trilha trilha-especialista" style="display: none;">Negociador</option>
                                                    <option value="5" class="trilha trilha-especialista" style="display: none;">Técnico</option>
                                                    <option value="1" class="trilha trilha-ocultista" style="display: none;">Conduíte</option>
                                                    <option value="2" class="trilha trilha-ocultista" style="display: none;">Flagelador</option>
                                                    <option value="3" class="trilha trilha-ocultista" style="display: none;">Graduado</option>
                                                    <option value="4" class="trilha trilha-ocultista" style="display: none;">Intuitivo</option>
                                                    <option value="5" class="trilha trilha-ocultista" style="display: none;">Lâmina Paranormal</option>
                                                </select>
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
                                            <label for="pv" class="fs-4 fw-bold">Vida Maxima (PV)</label><span>(Deixe 1 para calcular automaticamente)</span>
                                            <input class="form-control bg-black text-light border-light" id="pv" type="number" min="1" max="999" value="1" name="pv" required/>
                                            <label class="fs-4 fw-bold" for="san">Sanidade Maxima (SAN)</label><span>(Deixe 1 para calcular automaticamente)</span>
                                            <input class="form-control bg-black text-light border-light" id="san" type="number" min="1" max="999" value="1" name="san" required/>
                                            <label for="pe" class="fs-4 fw-bold">Pontos de Esforço (PE)</label><span>(Deixe 1 para calcular automaticamente)</span>
                                            <input id="pe" class="form-control bg-black text-light border-light" type="number" min="1" max="999" value="1" name="pe" required/>
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