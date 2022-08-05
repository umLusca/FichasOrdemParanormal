
$('#passrf').submit(function (e) {
    e.preventDefault();
    var form = $(this);
    $.post({
        beforeSend: function () {
            $("#footerpassr").hide();
            $("#passrmsg").html("<div class='alert alert-warning'>Aguarde...</div>");
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
                $("#footerpassr").show();
                $("#passrmsg").html('<div class="alert alert-danger">' + data.msg + "</div>");
            } else {
                $("#passrmsg").html('<div class="alert alert-success">' + data.msg + '</div>');
                $("#footerpassr").hide();
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