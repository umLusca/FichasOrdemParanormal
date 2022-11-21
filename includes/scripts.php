<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" type="text/javascript" data-cfasync="false"></script>
<script src="https://cdn.socket.io/4.5.1/socket.io.min.js" data-cfasync="false"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

<div class="modal fade" id="confirmar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-bg-dark rounded-3 shadow">
            <div class="modal-body p-4 text-center">
                <h5 class="mb-0 title"></h5>
                <p class="mb-0 desc"></p>
            </div>
            <div class="modal-footer flex-nowrap p-0">
                <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 cancel" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-start confirm"><strong>Confirmar</strong></button>
            </div>
        </div>
    </div>
</div>
<script>

    function confirmar(title,text) {
        $("#confirmar .title").html(title);
        $("#confirmar .desc").html(text);
        let modalconfirm = new bootstrap.Modal(document.getElementById('confirmar'))
        modalconfirm.show();
        return new Promise((resolve,reject) => {
            $("#confirmar .confirm").on("click", function () {
                resolve(true);
                modalconfirm.hide();
            })
            $("#confirmar .cancel").on("click", function (){
                resolve(false);
                modalconfirm.hide();
            })
        });
    }

    function uploadFile(PREFIX_, element = null, token, Upload_name = "file", callback = null) {
        const FILE = element.files[0];

        let progressbar = $("*[id^=" + PREFIX_ +"].progress-bar");
        let returndiv = $("*[id^=" + PREFIX_ + "label]");
        let inputurl = $("input[id^=" + PREFIX_ + "input]");

        let formulario = new FormData();


        formulario.append("type", Upload_name);
        formulario.append("file", FILE);
        formulario.append("token", token);
        formulario.append("status", "upload_foto");
        $.ajax({
            url: "",
            type: "POST",
            data: formulario,
            dataType:"json",
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: () => {
                console.log("Before");
                progressbar.parent().show();
                progressbar.addClass("bg-primary").removeClass("bg-danger,bg-success, bg-warning");
                returndiv.html("Aguarde...");
            },
            xhr: () => {
                const xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", (evt) => {
                    if (evt.lengthComputable) {
                        const percent = (evt.loaded / evt.total) * 100;
                        progressbar.css("width", Math.round(percent) + "%")
                    }
                }, false);
                xhr.addEventListener("error", () => {
                    returndiv.html("Falha. Tente novamente mais tarde.");
                    progressbar.addClass("bg-danger").removeClass("bg-primary,bg-success,bg-warning");
                })
                xhr.addEventListener("load", (e) => {
                    returndiv.html("Sucesso!");
                    progressbar.addClass("bg-success").removeClass("bg-danger,bg-primary,bg-warning");
                })
                xhr.addEventListener("abort", () => {
                    returndiv.html("Envio cancelado!");
                    progressbar.addClass("bg-warning").removeClass("bg-danger,bg-primary");
                })
                return xhr;
            },
            error: () => {
                returndiv.html("Falha. Verifique sua conexão");
                progressbar.addClass("bg-danger").removeClass("bg-primary,bg-success,bg-warning");
            },
            success: (d) => {
                console.log(d)
                inputurl.val(d["data"]["url"]);
            },
            complete: (d) => {
                console.log(d);
                callback();
            },
        })
    }

    function percent(max, min = 0) {
        if ((max === 0 && min === 0) || max === 0) {
            return 0;
        }
        var p = (max / min) * 100;
        if (p > 100) {
            return 100;
        } else {
            return p;
        }
    }
    $(document).ready(function () {

        $.fn.isValid = function () {
            return this[0].checkValidity()
        } // Função para checar validade de formularios

        $('.modal').on('show.bs.modal', function () {
            $('.modal').not($(this)).each(function () {
                $(this).modal('hide');
            });
        });
		<?php if (!isset($_SESSION["UserID"])) {?>


        $('#passrf').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            $.post({
                beforeSend: function () {
                    $("#passrmsg").html("<div class='alert alert-warning'>Aguarde...</div>");
                    $("#footerpassr").hide();
                    $("#remail").attr("readonly", true);
                },
                url: "",
                data: form.serialize(),
                dataType: "JSON",
                error: function () {
                    $("#footerpassr").show();
                    $("#passrmsg").html("<div class='alert alert-danger'>Houve um erro ao fazer a solicitação, contate um administrador!</div>");
                    $("#remail").attr("readonly", false);
                },
            }).done(function (data) {
                console.log(data);
                if (data.msg) {
                    if (!data.success) {
                        $("#footerpassr").show();
                        $("#passrmsg").html('<div class="alert alert-danger">' + data.msg + "</div>");
                        $("#remail").attr("readonly", false);
                    } else {
                        $("#passrmsg").html('<div class="alert alert-success">' + data.msg + '</div>');
                        $("#footerpassr").hide();
                        $("#remail").attr("readonly", true);
                    }
                }

            });
        });
        $('#cadastro').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            //var url = form.attr('action');
            $.post({
                beforeSend: function () {
                    $("#footercadastro").hide();
                    $("#messagecadastro").html("<div class='alert alert-warning'>Aguarde enquanto criamos sua conta...</div>");
                },
                url: "",
                data: form.serialize(),
                dataType: "JSON",
                error: function () {
                    $("#footercadastro").show();
                    $("#messagecadastro").html("<div class='alert alert-danger'>Houve um erro ao fazer a solicitação, contate um administrador!</div>");
                },
            }).done(function (data) {
                if (data.msg) {
                    if (!data.success) {
                        $("#footercadastro").show();
                        $("#messagecadastro").html('<div class="alert alert-danger">' + data.msg + "</div>");
                    } else {
                        $("#messagecadastro").html('<div class="alert alert-success">' + data.msg + '</div>');
                        window.location.href = "./";
                        $("#footercadastro").hide();
                    }
                }

            });
        });
        $('#login').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            $.post({
                beforeSend: function () {
                    $("#footerlogin").hide();
                    $("#messagelogin").html("<div class='alert alert-warning'>Aguarde enquanto fazemos um rolamento no login...</div>");
                },
                url: "",
                data: form.serialize(),
                dataType: "JSON",
                error: function () {
                    $("#footerlogin").show();
                    $("#messagelogin").html("<div class='alert alert-danger'>Houve um erro ao fazer a solicitação, contate um administrador!</div>");
                },
            }).done(function (data) {
                if (data.msg) {
                    if (!data.success) {
                        $("#footerlogin").show();
                        $("#messagelogin").html('<div class="alert alert-danger">' + data.msg + "</div>");
                    } else {
                        $("#messagelogin").html('<div class="alert alert-success">' + data.msg + '</div>');
                        window.location.href = "/sessao";
                        $("#footercadastro").hide();
                        $("#footerlogin").hide();
                    }
                }

            });
        });
		<?php
		}
		if (isset($_GET["convite"]) && $_GET["convite"] == 1 && !isset($_SESSION["UserID"])){ ?>

        var modalperfil = new bootstrap.Modal(document.getElementById('cadastrar'), {
            keyboard: false
        })
        modalperfil.show()
		<?php
		} else {?>


        $('#foto').change(function () {
            let fotovalor = $('#foto').val()
            if (fotovalor == '9') {
                $('#divfotourl').show();
                $("#fotourl,#fotofemor,#fotourenl,#fotourfer").attr("disabled", false)
            } else {
                $('#divfotourl').hide();
                $("#fotourl,#fotomor,#fotoenl,#fotofer,").attr("disabled", true)
            }
        })
		<?php }?>
    })
</script>
<script src="/assets/js/fa.js" data-auto-replace-svg="nest" async defer></script>
