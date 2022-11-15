<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"  data-cfasync="false"></script>
<script src="https://cdn.socket.io/4.5.1/socket.io.min.js"  data-cfasync="false"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<script>

    $.fn.isValid = function () {
        return this[0].checkValidity()
    } // Função para checar validade de formularios

    $(document).ready(function () {
		<?php if (!isset($_SESSION["UserID"])) {?>

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
