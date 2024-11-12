//Scripts essenciais (JAVASCRIPT PURO + JQUERY + FUNCOES)


function updateTooltips() {
    $('*[data-bs-toggle="tooltip"]').each((i, e) => {
        $(e).data('tooltip', new bootstrap.Tooltip(e));
    })
}
function copy(text, el = undefined) {
    navigator.clipboard.writeText(text);
    if (el) {
        $(el).data('tooltip').setContent({'.tooltip-inner': 'Copiado'})
    }
}

function confirmar(title, text) {
    $('#confirmar .title').html(title);
    $('#confirmar .desc').html(text);
    const modalConfirm = new bootstrap.Modal('#confirmar', {})
    modalConfirm.show();
    return new Promise((resolve) => {
        $('#confirmar .confirm').on('click', function () {
            resolve(true);
            modalConfirm.hide();
        })
        $('#confirmar .cancel').on('click', function () {
            resolve(false);
            modalConfirm.hide();
        })
        $('#confirmar').on('hide.bs.modal', () => {
            resolve(false);
        })
    });
}

$.fn.animateRotate = function (startAngle, endAngle, duration, easing, complete) {
    return this.each(function () {
        var elem = $(this);

        $({deg: startAngle}).animate({deg: endAngle}, {
            duration: duration,
            easing: easing,
            step: function (now) {
                elem.css({
                    '-moz-transform': 'rotate(' + now + 'deg)',
                    '-webkit-transform': 'rotate(' + now + 'deg)',
                    '-o-transform': 'rotate(' + now + 'deg)',
                    '-ms-transform': 'rotate(' + now + 'deg)',
                    'transform': 'rotate(' + now + 'deg)'
                });
            },
            complete: complete || $.noop
        });
    });
};
$.fn.getFormObject = function () {
    return $(this).serializeArray().reduce(function (obj, item) {
        const name = item.name.replace("[]", "");
        if (typeof obj[name] !== "undefined") {
            if (!Array.isArray(obj[name])) {
                obj[name] = [obj[name], item.value];
            } else {
                obj[name].push(item.value);
            }
        } else {
            obj[name] = item.value;
        }
        return obj;
    }, {});
}




$("form[ajax]").on("submit", (e) => {
    e.preventDefault();
    e.stopPropagation();

    if ($(e.target).is("[novalidate]") === true) $(e.target).addClass("was-validated");
    if (!window.sendingPost && e.target.checkValidity()) {
        window.sendingPost = true;
        let $this = e.currentTarget;
        //Crie um div com display none no formulário, ele vai ter o retorno
        $(".return").slideUp().text("").removeClass("alert-danger alert-info alert-success");

        let data = $($this).getFormObject();
        for (const [key, value] of Object.entries($($this).data())) {
            if (value && typeof value === 'string' && value.indexOf('$carrinho') > -1) {
                let [, token] = value.split(".");
                data["token"] = token

                data[key] = localStorage.getItem("carrinho");
            } else {
                data[key] = value;
            }
        }

        //por padrão é o do formulário.
        data["query"] = $(e.currentTarget).attr("action");
        if (e.originalEvent) {

            //Ele poderá ser substituido pelo o do botão, caso exista.
            let buttonAction = $(e.originalEvent.submitter).attr("formaction");
            if (typeof buttonAction === "string" && buttonAction.length >= 2) {
                data["query"] = buttonAction;
            }
        }
        $($this).find(".return").addClass("alert-info").removeClass("alert-danger").text("Aguarde...").slideDown();

        let ajax = () => {
            $.ajax({
                method: "POST",
                url: data["query"],
                data: data,
                dataType: "json",
                success: (d) => {
                    if (data.callback) {
                        if (window[data.callback]) window[data.callback](d)
                    }
                    if (d.status) {
                        $($this).find(".return").addClass("alert-success").removeClass("alert-danger alert-info");
                        if (data.refresh || d.refresh) {
                            setTimeout(
                                () => {
                                    window.location.reload()
                                }, 500);
                        }
                        if (data.redirect || data.redirect === "") {
                            let redi = "";
                            if (d.redirect) {
                                redi = d.redirect;
                            }
                            window.location.href = data.redirect + redi;
                        }
                    } else {
                        $($this).find(".return").addClass("alert-danger").removeClass("alert-success alert-info");

                    }
                    $($this).find(".return").html(d.msg).slideDown()
                },
                error: (err) => {
                    if (err.responseJSON && err.responseJSON.msg) {
                        $($this).find(".return").addClass("alert-danger").removeClass("alert-success alert-info").text(err.responseJSON.msg).slideDown();
                    } else {
                        $($this).find(".return").addClass("alert-danger").removeClass("alert-success alert-info").text("Houve um erro ao comunicar com o servidor...").slideDown();
                    }
                },

                complete: () => {
                    window.sendingPost = false;
                }

            });
        }
        try {
            grecaptcha.execute(window.gsitekey, {action: data["query"]}).then((token) => {
                data["gtoken"] = token;
                ajax();
            });
        } catch (e) {
            ajax();

        }


    }


})
    .on("hidden.bs.modal", (e) => {
        $(e.currentTarget).trigger("reset").removeClass("was-validated").find(".return").hide();
    })
    .on("keydown", (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();  // Prevenir o envio padrão

            $(e.currentTarget).trigger("submit");
        }
    })


//Faz com que os checkboxes retornem 1 ou 0 como valor.
$("input[type=checkbox]").each((i, e) => {
    if (!$(e).attr("value") || $(e).attr("value") === "1") {
        $(e).attr("value", 1).before($('<input/>').prop("disabled", $(e).is(":checked")).prop('type', 'hidden').prop('value', 0).prop('name', $(e).prop('name')))
    }
})
//Desativa o checkbox oculto caso seja 1
//Previne ação do usuário, caso ele tenha a classe disabled
$(document).on("change", "input[type=checkbox]", (e) => {
    console.log(e);
    if ($(e.currentTarget).hasClass("disabled")) {
        $(e.currentTarget).prop("checked", !$(e.currentTarget).is(":checked"));
    }
    $("input[type=hidden][name='" + $(e.currentTarget).prop('name') + "']").attr('disabled', !!$(e.currentTarget).is(':checked'))

})

// Faz com que os checkboxes desativados, tenham apenas a impressão de desativados
//para que seus valores continuem sendo enviados no formulário em caso de ativo.
$("input[type=checkbox][disabled]").each((i, e) => {
    $(e).addClass("disabled").prop("disabled", false);
})
//E para evitar ação do usuário, ele apenas valida se tem a classe antes de qualquer coisa...





