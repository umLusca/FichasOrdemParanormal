<script>
    const fichaToken = "<?=$token?>"

    let changingtimer, typingTimer, doneTypingInterval = 2500, timeoutId = 0;                //timer identifier
    const donetimer = 1500;

    let $ficha = {};
    $.ajax({
        url: "/api/ficha/get",
        method: "post",
        data: {token: fichaToken},
        success: (d) => {
            console.log(d);
            if (d.status === 200) {
                $.extend($ficha,d.dados);
                $("barra").each((i, e) => {
                    let min = $(e).data("min")
                    let max = $(e).data("max");
                    let val = $(e).data("value");
                    if (typeof min === "string") min = $ficha[min];
                    if (typeof max === "string") max = $ficha[max];
                    if (typeof val === "string") val = $ficha[val];
                    let inputnow = $(e).find("[input-value]");
                    let inputmax = $(e).find("[input-max]");

                    let upd = () => {
                        let now = parseInt(inputnow.val());
                        let max = parseInt(inputmax.val());

                        if (now > max) {
                            //inputnow.val(max); sem limites
                            //now = max
                        }
                        if (now < min) {
                            inputnow.val(min);
                            now = min
                        }

                        $(e).find("[data-barra]").css("width", percent(now, max) + "%");
                    }
                    $(e).find("[input-max]").val(max).on("input keydown keyup", upd)
                    $(e).find("[input-value]").val(val).attr("min", min).on("input keydown keyup", upd);

                    $(e).find("[data-update]").on("click", (e) => {
                        let t = parseInt($(e.currentTarget).data("update"));
                        let now = inputnow.val()
                        inputnow.val(now - (-t)).trigger("input");
                        upd();
                    })


                    upd();
                });

            }
        }
    })


    function calcularPeso(sla) {
        let pesoatual = 0;
        $("#itens tr[data-fop-item]").each((i, e) => { //Calculo Peso
            pesoatual += parseInt($(e).find(".peso").text()) * parseInt($(e).find(".quantidade").text());
            $("#editinv trtr[data-fop-item=" + id + "]").find(".quantidade").text($(e).find(".quantidade").text());
        })

    }

    function checkURL(url) {
        if (typeof url !== "string") {
            return false;
        }
        let turl = url.trim();
        if (!turl.match("^https?://(?:[a-z\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpg|png|jpeg|webp)$") || !turl.length) {
            return false;
        }
        return turl;
    }

    function contador() {
        clearTimeout(changingtimer);
        changingtimer = setTimeout(subsaude, donetimer);
    }


    function subsaude() {
        let data = $('#saude :input').serializeObject();

        $.extend(data, {
            mor: $('#morrendo').is(":checked"),
            com: $('#combate').is(":checked"),
            ocult: {
                pv: $('#opv').is(":checked"),
                pe: $('#ope').is(":checked"),
                san: $('#osan').is(":checked"),
            }
        })
        console.log(data)

        $.post({
            url: '?token=' + fichaToken,
            dataType: 'json',
            data: data,
            complete: (d) => {
                console.log(d)
            },
        }).done(function (data) {
            const msg = {};
            msg["vida"] = data;
            msg["vida"]["combate"] = combate;
            msg["ficha"] = fichaToken;
            $('#saude .pv').val(msg.vida.pv);
            $('#saude .san').val(msg.vida.san);
            $('#saude .pe').val(msg.vida.pe);
            updatefoto()
        });
    }


    function percent(min = 0, max = 100) {
        max = parseInt(max);
        min = parseInt(min)
        if ((min === 0 && max === 0) || min === 0) {
            return 0;
        }
        const p = (min / max) * 100;
        if (p > 100) {
            return 100;
        } else {
            return p;
        }
    }

    function updtsaude(valor, type) {
        updatefoto()
        let atual = type + 'a';
        let total = type;
        let $el = (type) => $(`#saude input[name=${type}]`)
        let diff = (val1, type, val2) => {
            return eval(val1 + type + val2) ? val2 : val1;
        }
        $el(atual).val(parseInt($el(atual).val()) + valor);


        $el(atual).val(diff($el(atual).val(), ">", (type === "pv") ? parseInt($el(total).val()) /* Limite máximo*/ : parseInt($el(total).val())));
        $el(atual).val(diff($el(atual).val(), "<", (type === "pv") ? 0 /* Limite mínimo*/ : 0));
        $("#barra" + atual).width(percent($el(atual).val(), $el(total).val()) + '%');

        contador();
    }


    function updatefoto() {
        let pv = parseInt($('#saude .pv').val());
        let pva = parseInt($('#saude .pva').val());
        let san = parseInt($('#saude .san').val());
        let sana = parseInt($('#saude .sana').val());

        if (pva <= 0) {
            $("#fotopersonagem").attr("src", $ficha["foto_morrendo"]);
        } else if (sana <= 0) {
            if (percent(pva, pv) < 50) {
                $("#fotopersonagem").attr("src", $ficha["foto_ferenl"]);
            } else {
                $("#fotopersonagem").attr("src", $ficha["foto_enlouquecendo"]);
            }
        } else if (percent(pva, pv) < 50) {
            $("#fotopersonagem").attr("src", $ficha["foto_ferido"]);
        } else {
            $("#fotopersonagem").attr("src", $ficha["foto"]);
        }
    }

    const togglebutton = $("button.toggleview");

    $('#portrait').prop('checked', true);


    $(() => {
        updatefoto();


        $('#card_habilidades button.habtab').on('mousedown', function (e) {
            console.log("touchstart")
            timeoutId = setTimeout(() => {
                e.preventDefault();
                if ($(e.currentTarget).hasClass("noteditable")) {
                    alert("Não é editável.")
                } else {
                    $("#habedttab input[name=name]").val($(e.currentTarget).text());
                    $("#habedttab input[name=token]").val($(e.currentTarget).attr("data-fop-token"));
                    $("#habedttab").modal("show");
                }

            }, 300);
        }).on('mouseup mouseleave', function () {
            console.log("not edit")
            clearTimeout(timeoutId);
        });


        $('#card_personagem textarea').on('keyup', function (e) {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                $.post({
                    url: "",
                    data: {
                        query: "ficha_sync_nota",
                        type: $(e.currentTarget).attr("name"),
                        text: $(e.currentTarget).val()
                    },
                    success: (d) => {
                        if (d["success"]) {
                            $("#card_personagem *[data-fop-icon]").attr("class", "text-success").html("<i class='far fa-cloud-check'></i>")
                        } else {
                            $("#card_personagem *[data-fop-icon]").attr("class", "text-danger").html("<i class='far fa-cloud-slash'></i>");
                        }
                    },
                    error: () => {
                        $("#card_personagem *[data-fop-icon]").attr("class", "text-danger").html("<i class='far fa-cloud-slash'></i>");
                    }
                })

            }, doneTypingInterval);
        }).on('keydown', function () {
            clearTimeout(typingTimer);
            $("#card_personagem *[data-fop-icon]").attr("class", "text-warning").children().prop("class", 'fal fa-arrow-rotate-right fa-spin');
        });


        //Fotos ritauis
        $('#editritual select.rituais').change(() => {
            let $foto;
            switch (parseInt($('#editritual select.rituais').val())) {
                default:
                    $foto = '';
                    break;
                case 2:
                    $foto = 'https://fichasop.com/assets/img/desconhecido.webp';
                    break;
                case 3:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_Amaldicoar_Tecnologia.webp';
                    break;
                case 4:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_Assombracao_Forcada.webp';
                    break;
                case 5:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_Camuflagem.webp';
                    break;
                case 6:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_Cicatrizacao_Acelerada.webp';
                    break;
                case 7:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_Coincidencia_Forcada.webp';
                    break;
                case 8:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_Compreensao_Paranormal.webp';
                    break;
                case 9:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_Comunicacao_com_Espiritos.webp';
                    break;
                case 10:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_da_Dama_de_Sangue.webp';
                    break;
                case 11:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_decadenzia.webp';
                    break;
                case 12:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_Derreter_Criaturas_De_Sangue.webp';
                    break;
                case 13:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_Descarnar.webp';
                    break;
                case 14:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_Destruicao.webp';
                    break;
                case 15:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_Dissipar_Espiritos.webp';
                    break;
                case 16:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_Invocar_Nevoa.webp';
                    break;
                case 17:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_Leitura_Psiquica.webp';
                    break;
                case 18:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_odio_Incontrolavel.webp';
                    break;
                case 19:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_Papel_Graduacao.webp';
                    break;
                case 20:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_Paralisia_Anormal.webp';
                    break;
                case 21:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_Passagem_de_Conhecimento.webp';
                    break;
                case 22:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_Pavor_Anormal.webp';
                    break;
                case 23:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_Reacao.webp';
                    break;
                case 24:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_Ritual_Espelho.webp';
                    break;
                case 25:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_Sentir_Atraves_dois_em_um.webp';
                    break;
                case 26:
                    $foto = 'https://fichasop.com/assets/img/Simbolo_Sugada_Mortal.webp';
                    break;
                case 27:
                    $foto = 'https://fichasop.com/assets/img/simbolo_transcender.webp';
                    break;
            }
            $("#editritual input.url").val($foto);

        })

        //Editar Saude
        $(".dblclick input").dblclick((e) =>{
            $(e.target).attr('readonly', false).toggleClass('border-0');
        }).on("focusout",(e) => {
            let attr = $(this).attr('readonly');
            if (typeof attr !== 'undefined' && attr !== false) {
                $(e.target).attr('readonly', true)
            } else {
                $(e.target).attr('readonly', true).toggleClass('border-0')
            }
        })

        $("button, input:checkbox").on("click", function () {
            $(this).blur();
        })


        //Imagens de Personagens Pre Prontas
        $('#editfoto .selector').change(function () {
            let foto;
            switch (parseInt($(this).val())) {
                case 1:
                    foto = 'https://fichasop.com/assets/img/Man.webp';
                    break;
                case 2:
                    foto = 'https://fichasop.com/assets/img/Woman.webp';
                    break;
                case 3:
                    foto = 'https://fichasop.com/assets/img/Mauro.webp';
                    break;
                case 4:
                    foto = 'https://fichasop.com/assets/img/Maya.webp';
                    break;
                case 5:
                    foto = 'https://fichasop.com/assets/img/Bruna.webp';
                    break;
                case 6:
                    foto = 'https://fichasop.com/assets/img/Leandro.webp';
                    break;
                case 7:
                    foto = 'https://fichasop.com/assets/img/Jaime.webp';
                    break;
                case 8:
                    foto = 'https://fichasop.com/assets/img/Aniela.webp';
                    break;
            }

            $("#editfoto .foto-perfil").val(foto)
            $("#editfoto .return").html("");
            $('#editfoto .preview img').prop("src", foto).parent().show();

        })


        togglebutton.on("click", (e) => {
            let order = parseInt(togglebutton.attr("data-fop-status"));
            if (status !== 2) {
                $("#pericias .hiddable").slideDown();
            }
            switch (order) {
                default://Alfabetica
                    $("#pericias .pericia").sortElements((a, b) => {
                        togglebutton.children().attr("class", "fal fa-arrow-down-a-z")
                        return $(a).attr("data-fop-uid").localeCompare($(b).attr("data-fop-uid"), 'br', {sensitivity: 'base'});
                    })
                    togglebutton.attr("data-fop-status", 0)
                    break;
                case 0://Por bonus
                    $("#pericias .pericia").sortElements((a, b) => {
                        togglebutton.children().attr("class", "fal fa-arrow-down-9-1")
                        return (parseInt($(a).attr("data-fop-bonus")) < parseInt($(b).attr("data-fop-bonus")) ? 1 : -1);
                    })
                    togglebutton.attr("data-fop-status", 1)
                    break;
                case 1://Por grau
                    $("#pericias .pericia").sortElements((a, b) => {
                        togglebutton.children().attr("class", "fal fa-arrow-down-big-small");
                        let levela = parseInt($(a).attr("data-fop-level"));
                        let levelb = parseInt($(b).attr("data-fop-level"));

                        let bonusa = parseInt($(a).attr("data-fop-bonus"));
                        let bonusb = parseInt($(b).attr("data-fop-bonus"));


                        console.log(levela, "+", levelb, "-", bonusa, "+", bonusb);


                        if (levela === levelb) {
                            return 0;
                        } else if (levela < levelb) {
                            return 1
                        } else if (levela > levelb) {
                            return -1;
                        }
                    })
                    togglebutton.attr("data-fop-status", 2)
                    break;
                case 2://Por Ocultar
                    togglebutton.children().attr("class", "fal fa-eye-slash");
                    $("#pericias .hiddable").slideUp();
                    togglebutton.attr("data-fop-status", 3)
                    break;
            }
        })
    })
</script>