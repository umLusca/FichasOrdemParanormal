<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" type="text/javascript" data-cfasync="false"></script>
<script src="https://cdn.socket.io/4.5.1/socket.io.min.js" data-cfasync="false"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="https://unpkg.com/babel-standalone@6/babel.min.js" data-cfasync="false"></script>
<script crossorigin src="https://unpkg.com/react@18/umd/react.production.min.js" data-cfasync="false"></script>
<script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" data-cfasync="false"></script>

<div class="modal fade" id="confirmar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-3 shadow">
            <div class="modal-body p-4 text-center">
                <h5 class="mb-0 title"></h5>
                <p class="mb-0 desc"></p>
            </div>
            <div class="modal-footer flex-nowrap p-0">
                <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 cancel" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-start confirm">
                    <strong>Confirmar</strong></button>
            </div>
        </div>
    </div>
</div>
<script>
</script>
<script type="text/babel">

    function getCookie(key) {
        let value = ''
        document.cookie.split(';').forEach((e) => {
            if (e.includes(key)) {
                value = e.split('=')[1]
            }
        })
        return value
    }function setCookie(name,value,days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }

    function confirmar(title, text) {
        $("#confirmar .title").html(title);
        $("#confirmar .desc").html(text);
        let modalconfirm = new bootstrap.Modal(document.getElementById('confirmar'))
        modalconfirm.show();
        return new Promise((resolve, reject) => {
            $("#confirmar .confirm").on("click", function () {
                resolve(true);
                modalconfirm.hide();
            })
            $("#confirmar .cancel").on("click", function () {
                resolve(false);
                modalconfirm.hide();
            })
        });
    }

    function uploadFile(PREFIX_, element = null, token, Upload_name = "file", callback = null) {
        const FILE = element.files[0];

        let progressbar = $("*[id^=" + PREFIX_ + "].progress-bar");
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
            dataType: "json",
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
                if (d["data"]["url"]) {
                    inputurl.val(d["data"]["url"]);
                } else {
                    returndiv.html("Falha. Limite estourado.");
                    progressbar.addClass("bg-danger").removeClass("bg-primary,bg-success,bg-warning");
                }
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
        $("#sitethemeselect").on("change",()=>{
            let theme = $("#sitethemeselect").val();
            console.log(getCookie("theme"));
            console.log(theme)
            setTheme(theme);
            setCookie("theme",theme,365)
            console.log(getCookie("theme"));
        })
        
        
        /*!
 * Color mode toggler for Bootstrap's docs (https://getbootstrap.com/)
 * Copyright 2011-2022 The Bootstrap Authors
 * Licensed under the Creative Commons Attribution 3.0 Unported License.
 * Changed by Lucas (https://github.com/LucasMeGames)
 */

        const storedTheme = getCookie("theme");
        const getPreferredTheme = () => {
            if (storedTheme) {
                return storedTheme
            }

            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
        }
        const setTheme = function (theme) {
            switch (theme){
                default:
                    if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        $(document.documentElement).attr("data-bs-theme", "dark")
                    } else {
                        $(document.documentElement).attr("data-bs-theme", "light")
                    }
                    break;
                case "dark":
                    $(document.documentElement).attr("data-bs-theme", "dark")
                    break;
                case "light":
                    $(document.documentElement).attr("data-bs-theme", "light")
                    break;
            }
        }
        setTheme(getPreferredTheme())
        
        $(window.matchMedia('(prefers-color-scheme: dark)')).on("change",()=>{
            if (storedTheme !== 'light' || storedTheme !== 'dark') {
                setTheme(getPreferredTheme())
            }
        })
        
     


        $.fn.isValid = function () {
            return this[0].checkValidity()
        } // Função para checar validade de formularios

        $('.modal').on('show.bs.modal', function () {
            $('.modal').not($(this)).each(function () {
                $(this).modal('hide');
            });
        });
		<?php if (!isset($_SESSION["UserID"])) {?>

        let recup = false;
        let login = false;
        let regis = false;
        $('#passr').submit(function (e) {
            e.preventDefault();
            const form = $(this);
            console.log("t3este")
            if (!recup)
                $.post({
                    url: "",
                    data: form.serialize(),
                    dataType: "JSON",
                    beforeSend: function () {
                        $("#passr .return").html("<div class='alert alert-warning'><i class='fal fa-spin fa-spinner'></i> Aguarde...</div>");
                        $("#passr input[name=email]").attr("readonly", true);
                        $("#passr .btn").attr("disabled", true);
                        recup = true;
                    },
                    success: (data) => {
                        console.log(data);
                        if (data.msg) {
                            if (!data.success) {
                                $("#passr .btn").attr("disabled", false);
                                $("#passr .return").html("<div class='alert alert-danger'><i class='fal fa-x'></i> " + data.msg + "</div>");
                                $("#passr input[name=email]").attr("readonly", false);
                                recup = false;
                            } else {
                                $("#passr .return").html("<div class='alert alert-success'><i class='fal fa-check'></i> " + data.msg + "</div>");
                            }
                        }

                    },
                    error: function () {
                        $("#passr .btn").attr("disabled", false);
                        $("#passr .return").html("<div class='alert alert-danger'><i class='fal fa-x'></i> Falha ao conectar com o banco de dados. Contate um administrador!</div>");
                        $("#passr input[name=email]").attr("readonly", false);
                        recup = false;
                    }
                })
        });
        $('#cadastrar').submit(function (e) {
            e.preventDefault();
            const form = $(this);
            if (!regis)
                $.post({
                    beforeSend: function () {
                        $("#cadastrar .btn").attr("disabled", true);
                        $("#cadastrar .return").html("<div class='alert alert-warning'><i class='fal fa-spin fa-spinner'></i> Aguarde enquanto criamos sua conta...</div>");
                        regis = true;
                    },
                    url: "",
                    data: form.serialize() + "&status=cadastro",
                    dataType: "JSON",
                    success: (data) => {
                        if (!data.success) {
                            $("#cadastrar .btn").attr("disabled", false);
                            $("#cadastrar .return").html('<div class="alert alert-danger"><i class="fal fa-x"></i> ' + data.msg + "</div>");
                        } else {
                            regis = false;
                            $("#cadastrar .return").html('<div class="alert alert-success"><i class="fal fa-check"></i> ' + data.msg + '</div>');
                            window.location.href = "./";
                        }
                    },
                    error: function () {
                        regis = false;
                        $("#cadastrar .btn").attr("disabled", false);
                        $("#cadastrar .return").html("<div class='alert alert-danger'><i class='fal fa-x'></i> Houve um erro ao fazer a solicitação, contate um administrador!</div>");
                    },
                }).done(function (data) {

                });
        });
        $('#login').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            console.log("OMAIGOD")
            if (!login)
                $.post({
                    beforeSend: function () {
                        login = true;
                        $("#login .btn").attr("disabled", true);
                        $("#login .return").html("<div class='alert alert-warning'><i class='fal fa-spin fa-spinner'></i> Aguarde enquanto fazemos um rolamento no login...</div>");
                    },
                    url: "/",
                    data: form.serialize() + "&status=login",
                    dataType: "JSON",
                    success: (data) => {
                        if (!data.success) {
                            $("#login .btn").attr("disabled", false);
                            $("#login .return").html("<div class='alert alert-danger'><i class='fal fa-x'></i> " + data.msg + "</div>");
                            login = false;
                        } else {
                            $("#login .return").html('<div class="alert alert-success"><i class="fal fa-check"></i> ' + data.msg + '</div>');
                            window.location.href = "/sessao";
                        }
                    },
                    error: () => {
                        login = false;
                        $("#login .btn").attr("disabled", false);
                        $("#login .return").html("<div class='alert alert-danger'>Houve um erro ao fazer a solicitação, contate um administrador!</div>");
                    },
                })
        });
		<?php
		}
		if (isset($_GET["convite"]) && $_GET["convite"] == 1 && !isset($_SESSION["UserID"])){ ?>

        const modalperfil = new bootstrap.Modal(document.getElementById('cadastrar'), {
            keyboard: false
        });
        modalperfil.show()
		<?php
		} else {?>

        let up;
        let enviando = false;

        $('#btnaddmarca').on('click', function () {
            const url = $('#addfotomarca input').val();
            console.log("afas")
            if (url.match("^https?://(?:[a-z\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpg|png|jpeg|webp)$") || url == "") {
                if (!up) {
                    $.post({
                        url: '',
                        data: {status: 'addmarca', urlmarca: url},
                        dataType: "JSON"
                    }).done(function (data) {
                        console.log(data)
                        if (data.msg) {
                            if (!data.success) {
                                $("#addfotomarca .return").html('<div class="alert alert-danger">' + data.msg + "</div>");
                            } else {
                                up = true;
                                $("#addfotomarca .return").html('<div class="alert alert-success">' + data.msg + '</div>');
                            }
                        }
                    }).fail(function (d) {
                        console.log(d);
                        $("#perfil .return").html(`<div class="alert alert-success m-2">Houve uma falha ao fazer a alteração.
								<span class="float-end" role="button" onclick="copiar(\`${d.responseText}\`)"><i class="fas fa-copy" aria-hidden="true"></i></span>
									</div>`);
                    })
                }
            } else {

            }
        })

        $('#addfotomarca input').on('input', function () {
            var src = jQuery(this).val();
            if (!src.match("^https?://(?:[a-z\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpg|png|jpeg|webp)$") || src == "") {
                $("#addfotomarca .warning").html("Precisa ser HTTPS, e Terminar com com extensão de imagem(.jpg, .png ...)!");
                $('#addfotomarca .preview').html('');
                return false;
            } else {
                $("#addfotomarca .warning").html("");
                $('#addfotomarca .preview').html('<img class="" height="250" width="250" src="' + src + '">');
            }

        })

        function copiar(texto) {
            const type = "text/plain";
            const blob = new Blob([texto], {type});
            const data = [new ClipboardItem({[type]: blob})];
            navigator.clipboard.write(data);
        }

        $("#configconta .senha").on("input", () => {
            if ($("#configconta .senha").val().length > 0) {
                $("#configconta .csenha").prop("required", true);
            } else {
                $("#configconta .csenha").prop("required", false);
            }
        })
        $("#configconta").on("submit", (e) => {
            e.preventDefault();
            let $this = $("#configconta");
            $this.addClass('was-validated');

            if ($this.isValid() && $("#configconta .senha").val() === $("#configconta .csenha").val()) {
                console.log("true");
                if (!enviando) {
                    $.post({
                        url: '',
                        data: $this.serialize() + "&status=conta",
                        dataType: "json",
                        beforeSend: () => {
                            enviando = true;
                            $("#configconta .warning").html(`<div class="alert alert-warning m-2">Estamos atualizando sua conta, aguarde...</div>`);
                            $("#configconta input:enabled").val("");
                        },
                        success: (d) => {
                            if (d.success && d.msg) {
                                $("#configconta .warning").html(`<div class="alert alert-success m-2">${d.msg}</div>`);
                                window.location.reload();
                            } else {
                                enviando = false;
                                $("#configconta .warning").html(`
									<div class="alert alert-danger m-2">${d.msg}
										<span class="btn float-end" role="button" onclick="copiar(\`${d.msg}\`)">
											<i class="fas fa-copy" aria-hidden="true"></i>
										</span>
									</div>`);
                            }
                        },
                        error: (d) => {
                            $("#configconta .warning").html(`<div class="alert alert-success m-2">Houve uma falha ao fazer a alteração.
								<span class="float-end" role="button" onclick="copiar(\`${d.responseText}\`)"><i class="fas fa-copy" aria-hidden="true"></i></span>
									</div>`);
                            enviando = false;
                        },
                    });
                }
            } else {
                $("#configconta .warning").html(`<div class="alert alert-danger m-2">Confirme se o formulário está preenchido corretamente.</div>`);
                $("#configconta .csenha").addClass("is-invalid")
                console.log("false");
            }

        })


        $("#addmarcadiv input").on("input", () => {
            let $this = $("#addmarcadiv input");
            console.log("teste");
            let src = $this.val().trim();
            if (!src.match("^https?://(?:[a-z\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpg|png|jpeg|webp)$") && src !== "") {
                $this.addClass("is-invalid").addClass("is-valid");
                $("#addmarcadiv .return").html("<div class='alert alert-danger'>Precisa ser HTTPS, e Terminar com extensão de imagem(jpg,png,...)!</div>");
                $('#addmarcadiv img').prop("src", "").hide();
                return false;
            } else {
                $this.addClass("is-valid").removeClass("is-invalid");
                $("#addmarcadiv .return").html("");
                $('#addmarcadiv img').prop("src", src).show();
            }
        })
        $("#addmarcadiv .submit").on("click", () => {
            $.ajax({
                url: "",
                method: "post",
                data: {status: "addmarca", urlmarca: $("#addmarcadiv input").val()},
                dataType: "json",
                beforeSend: () => {
                    $("#addmarcadiv input, #addmarcadiv button").attr("disabled", true);
                },
                success: (d) => {
                    if (d.success) {
                        $("#addmarcadiv .return").html("<div class='alert alert-success'>" + d.msg + "</div>");
                    } else {
                        $("#addmarcadiv .return").html("<div class='alert alert-danger'>" + d.msg + "</div>");
                    }
                },
                complete: (d) => {
                    console.log(d)
                    $("#addmarcadiv input, #addmarcadiv button").attr("disabled", false);
                }
            });
        })


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
