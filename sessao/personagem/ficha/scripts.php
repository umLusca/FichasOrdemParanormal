<script>
	<?php if ($edit){?>
    let changingtimer, morrendo, combate;                //timer identifier
    const donetimer = 1500;

    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    function editupdatefoto(SRC, EL) {
        console.log(SRC, EL)
        $(EL).prop("src", SRC);

    }

    function item(action, id) {
        let x = 0
        if (action === "plus") {
            x = 1
        } else {
            x = -1
        }
        $("#itens tr[data-fop-item=" + id + "] .quantidade").text(parseInt($("#itens tr[data-fop-item=" + id + "] .quantidade").text()) + x);

        let pesoatual = 0;
        $("#itens tr[data-fop-item]").each((i, e) => {
            pesoatual += parseInt($(e).find(".peso").text()) * parseInt($(e).find(".quantidade").text());
            console.log($(e).find(".quantidade").text())
            $("#editinv trtr[data-fop-item=" + id + "]").find(".quantidade").text($(e).find(".quantidade").text());
        })

        $("#card_inventario .pesoatual").text(pesoatual)
        $.ajax({
            method: "post",
            data: {query: "ficha_update_itemquantidade", action: action, item: id},
            complete: (e) => console.log(e),
        })

    }

    function deletar(id, nome, tipo) {
        confirmar("Tem certeza que deseja apagar " + nome + "?", "Essa ação não poderá ser desfeita.").then((r) => {
            if (r) {
                $.post({
                    url: "?token=<?= $token ?>",
                    data: {iid: id, query: "ficha_delete_switch", type: tipo,},
                    complete: () => {
                        location.reload();
                    },
                });
            }
        })
    }

    function editarhab(id, tipo) {
        $("#habedit input[name=name]").val($("*[data-fop-" + tipo + "=" + id + "]").find("." + tipo + "name").text())
        $("#habedit textarea[name=desc]").val($("*[data-fop-" + tipo + "=" + id + "]").find("." + tipo + "desc").text());
        $("#habedit input[name=type]").val(tipo);
        $("#habedit input[name=id]").val(id);
        $("#habedit").modal("show");
    }//Deletar Arma
    function edit(type, id) {
        switch (type) {
            case "arma":
                let emodal = new bootstrap.Modal($("#editarma"));
                $('#editarma input[name=foto]').val($("#arma" + id + " img").attr("src"));
                $('#editarma img').attr("src", $("#arma" + id + " img").attr("src"));
                $('#editarma input[name=nome]').val($("#arma" + id + " .arma").text());
                $('#editarma input[name=tipo]').val($("#arma" + id + " .tipo").text());
                $('#editarma input[name=ataque]').val($("#arma" + id + " .ataque").attr("data-dado"));
                $('#editarma input[name=alcance]').val($("#arma" + id + " .alcance").text());
                $('#editarma input[name=dano]').val($("#arma" + id + " .dano").attr("data-dado"));
                $('#editarma input[name=critico]').val($("#arma" + id + " .critico").attr("data-dado"));
                $('#editarma input[name=margem]').val($("#arma" + id + " .critico").attr("data-margem"));
                $('#editarma input[name=recarga]').val($("#arma" + id + " .recarga").text());
                $('#editarma input[name=especial]').val($("#arma" + id + " .especial").text());
                $('#editarma input[name=did]').val(id);
                emodal.show();
                break;
            case "item":
                $('#edititem input[name=foto]').val($("#item" + id + " *[data-fop-info=foto]").attr("src"));
                $('#edititem img').attr("src", $("#item" + id + " *[data-fop-info=foto]").attr("src"));
                $('#edititem input[name=nome]').val($("#item" + id + " *[data-fop-info=nome]").text());
                $('#edititem input[name=peso]').val($("#item" + id + " *[data-fop-info=espaco]").text());
                $('#edititem input[name=prestigio]').val($("#item" + id + " *[data-fop-info=prestigio]").text());
                $('#edititem textarea[name=descricao]').val(striphtml($("#item" + id + " *[data-fop-info=descricao]")[0]));
                $('#edititem input[name=did]').val(id);
                $("#edititem").modal("show");
                break;
        }
    }// Editar Arma
    function cleanedit() {
        $('#deletarid,#deletarnome,#deletarstatus, #enome,#etipo,#eataque,#ealcance,#edano,#ecritico,#erecarga,#eespecial,#editarmaid,#enom,#edes,#epes,#epre,#edititid,#anom,#ades,#apes,#apre,#additemid').val('');
    }// Limpar modal edições
    function percent(max, min = 0) {
        if ((max === 0 && min === 0) || max === 0) {
            return 0;
        }
        const p = (max / min) * 100;
        if (p > 100) {
            return 100;
        } else {
            return p;
        }
    }

    function subtimer() {
        clearTimeout(changingtimer);
        changingtimer = setTimeout(subsaude, donetimer);
    }

    function updtsaude(valor, type) {
        let atual = type + 'a';
        let total = type;
        let $el = (type) => $(`#saude input[name=${type}]`)
        let diff = (val1, type, val2) => {
            return eval(val1 + type + val2) ? val2 : val1;
        }
        $el(atual).val(parseInt($el(atual).val()) + valor);


        $el(atual).val(diff($el(atual).val(), ">", (type === "pv") ? parseInt($el(total).val()) + <?=$maximo_PVA?> : parseInt($el(total).val())));
        $el(atual).val(diff($el(atual).val(), "<", (type === "pv") ? <?=$minimo_PVA?> : 0));
        $("#barra" + atual).width(percent($el(atual).val(), $el(total).val()) + '%');

        subtimer();
    }

    function subsaude() {
        let data = $('#saude :input').serializeObject();
        morrendo = $('#morrendo').is(":checked");
        combate = $('#combate').is(":checked");
        let oc = {
            pv: $('#opv').is(":checked"),
            pe: $('#ope').is(":checked"),
            san: $('#osan').is(":checked")
        }
        data["query"] = "ficha_sync_status";
        data["mor"] = morrendo;
        data["com"] = combate;
        data["ocult"] = oc;
        console.log(data);
        $.post({
            url: '?token=<?=$token?>',
            dataType: 'json',
            data: data,
            complete: (d) => {
                console.log(d)
            },
        }).done(function (data) {
            const msg = {};
            msg["vida"] = data;
            msg["vida"]["combate"] = combate;
            msg["ficha"] = '<?=$token?>';
            console.log(msg.vida.pv);
            $('#saude .pv').val(msg.vida.pv);
            $('#saude .san').val(msg.vida.san);
            $('#saude .pe').val(msg.vida.pe);
            console.log($('#saude .pe').val());
            updatefoto()
        });
    }

    function editritual(i, id) {
        let editritual_modal = new bootstrap.Modal($("#editritual"));
        editritual_modal.show();
        $("#editritual .url").val($("#but-ritual-" + i + " .foto").prop("src"));
        $("#editritual .foto").prop("src", $("#but-ritual-" + i + " .foto").prop("src"));
        $("#editritual .ritual").val($("#but-ritual-" + i + " .nome").text());
        $("#editritual .elemento").val($("#but-ritual-" + i + " .elemento").text());
        $("#editritual .circulo").val($("#but-ritual-" + i + " .circulo").text());
        $("#editritual .conjuracao").val($("#but-ritual-" + i + " .conjuracao").text());
        $("#editritual .alcance").val($("#but-ritual-" + i + " .alcance").text());
        $("#editritual .alvo").val($("#but-ritual-" + i + " .alvo").text());
        $("#editritual .duracao").val($("#but-ritual-" + i + " .duracao").text());
        $("#editritual .resistencia").val($("#but-ritual-" + i + " .resistencia").text());
        $("#editritual .desc").val(striphtml($("#but-ritual-" + i + " .desc")[0]));
        $("#editritual .normal").val($("#but-ritual-" + i + " .normal").attr("data-dado"));
        $("#editritual .discente").val($("#but-ritual-" + i + " .discente").attr("data-dado"));
        $("#editritual .verdadeiro").val($("#but-ritual-" + i + " .verdadeiro").attr("data-dado"));
        $("#editritual .did").val(id);
        console.log($("#but-ritual-" + i + " .verdadeiro"));
    }


    function updatefoto() {
        let pv = parseInt($('#saude .pv').val());
        let pva = parseInt($('#saude .pva').val());
        let san = parseInt($('#saude .san').val());
        let sana = parseInt($('#saude .sana').val());

        if (pva <= 0) {
            $("#fotopersonagem").attr("src", "<?=$urlphotomor;?>");
            console.log("morrendo")
        } else if (sana <= 0) {
            if (percent(pva, pv) < 50) {
                console.log("enlouquecendo + ferido")
                $("#fotopersonagem").attr("src", "<?=$urlphotoef;?>");
            } else {
                console.log("enlouquecendo")
                $("#fotopersonagem").attr("src", "<?=$urlphotoenl;?>");
            }
        } else if (percent(pva, pv) < 50) {
            console.log("ferido")
            $("#fotopersonagem").attr("src", "<?=$urlphotofer;?>");
        } else {
            console.log("normal")
            $("#fotopersonagem").attr("src", "<?=$urlphoto;?>");
        }
    }

    let typingTimer;                //timer identifier
    const doneTypingInterval = 2500;  //time in ms, 5 seconds for example

    $(document).ready(function () {


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
                        console.log(d)
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
            console.log("teste")
            clearTimeout(typingTimer);
            $("#card_personagem *[data-fop-icon]").attr("class", "text-warning").children().prop("class", 'fal fa-arrow-rotate-right fa-spin');
        });


        $("#editprincipal .changecalc").on("change", (e) => {
            let v = $(e.currentTarget).is(":checked");
            let t = $(e.currentTarget).attr("data-fop-type");
            console.log(t)
            if (v) {
                $(`#editprincipal input[name=${t}]`).attr("disabled", true).parent().slideUp();
                $(`#editprincipal input[name=b${t}]`).attr("disabled", false).parent().slideDown();
                $(`#editprincipal input[name=skipped${t}]`).attr("disabled", false).parent().slideDown();
                $(`#editprincipal input[name=soma${t}]`).attr("disabled", false).parent().slideDown();
            } else {
                $(`#editprincipal input[name=${t}]`).attr("disabled", false).parent().slideDown();
                $(`#editprincipal input[name=b${t}]`).attr("disabled", true).parent().slideUp();
                $(`#editprincipal input[name=skipped${t}]`).attr("disabled", true).parent().slideUp();
                $(`#editprincipal input[name=soma${t}]`).attr("disabled", true).parent().slideUp();

            }
            console.log(v);
        })

        $('#butmor input').change(function () {
            subtimer();
        })

        $("#editritual input.url").on("input", () => {
            $this = $("#editritual input.url");

            let src = $this.val().trim();
            if (!src.match("^https?://(?:[a-z\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpg|png|jpeg|webp)$") || src == "") {
                $this.addClass("is-invalid").addClass("is-valid");
                $("#editritual .return").html("Precisa ser HTTPS, e Terminar com com extensão de imagem(jpg,png,...)!");
                $('#editritual img.foto').prop("src", "https://fichasop.com/assets/img/desconhecido.webp");
                return false;
            } else {
                $this.addClass("is-valid").removeClass("is-invalid");
                $("#editritual .return").html("");
                $('#editritual img.foto').prop("src", src);
            }


        })

        $('#editritual select.rituais').change(() => {
            let $foto;
            console.log($('#editritual select.rituais').val())
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
        $('#addritual .selectosimbolo').change(function () {
            console.log("ok")
            let $foto = $('#addritual .selectosimbolo').val()

            if ($foto === "Customizada") {
                $("#simbolourl input").attr("readonly", false)
            } else {
                $("#simbolourl input").attr("readonly", true);
                switch ($foto) {
                    default:
                        $foto = 'https://fichasop.com/assets/img/desconhecido.webp';
                        break;
                    case '3':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Amaldicoar_Tecnologia.webp';
                        break;
                    case '4':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Assombracao_Forcada.webp';
                        break;
                    case '5':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Camuflagem.webp';
                        break;
                    case '6':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Cicatrizacao_Acelerada.webp';
                        break;
                    case '7':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Coincidencia_Forcada.webp';
                        break;
                    case '8':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Compreensao_Paranormal.webp';
                        break;
                    case '9':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Comunicacao_com_Espiritos.webp';
                        break;
                    case '10':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_da_Dama_de_Sangue.webp';
                        break;
                    case '11':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_decadenzia.webp';
                        break;
                    case '12':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Derreter_Criaturas_De_Sangue.webp';
                        break;
                    case '13':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Descarnar.webp';
                        break;
                    case '14':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Destruicao.webp';
                        break;
                    case '15':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Dissipar_Espiritos.webp';
                        break;
                    case '16':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Invocar_Nevoa.webp';
                        break;
                    case '17':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Leitura_Psiquica.webp';
                        break;
                    case '18':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_odio_Incontrolavel.webp';
                        break;
                    case '19':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Papel_Graduacao.webp';
                        break;
                    case '20':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Paralisia_Anormal.webp';
                        break;
                    case '21':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Passagem_de_Conhecimento.webp';
                        break;
                    case '22':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Pavor_Anormal.webp';
                        break;
                    case '23':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Reacao.webp';
                        break;
                    case '24':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Ritual_Espelho.webp';
                        break;
                    case '25':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Sentir_Atraves_dois_em_um.webp';
                        break;
                    case '26':
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Sugada_Mortal.webp';
                        break;
                    case '27':
                        $foto = 'https://fichasop.com/assets/img/simbolo_transcender.webp';
                        break;
                }
                $("#addritual #simbolourl input").val($foto)
                updateritualfoto($("#addritual #simbolourl input"));
            }
        })
		
		
		<?php if(isset($dados_missao) and $dados_missao["id"] == 5887){?>
        $('#portrait').prop('checked', true);
        socket.emit('create', '<?=$missao_token ?: $token?>');
        socket.emit('auth', '<?=$missao_token ?: $token?>');
		<?php }?>

        $('#portrait').change(function () {
            if ($('#portrait').is(":checked")) {
                socket = io.connect('https://portrait.fichasop.com', {
                    reconnectionDelay: 2500,
                    transports: ['websocket', 'polling', 'flashsocket']
                });
                socket.emit('create', '<?=$missao_token ?: $token?>');
                socket.emit('<?=$missao_token ?: $token?>', {auth: '<?=$token?>'});
            } else {
                socket.disconnect();
            }
        })


        $("form:not([ajax])").submit(function (event) {
            console.log("AJAX")
            $(this).addClass('was-validated');
            if (!$(this).isValid()) {
                event.preventDefault()
                event.stopPropagation()
            } else {
                event.preventDefault();
                $.post({
                    url: '?token=<?=$token?>',
                    data: $(this).serialize(),
                    complete: (d) => {
                        console.log(d)
                    },
                }).done(function (data) {
                    location.reload();
                })
            }
        })// Enviar qualquer formulario via jquery


        $("#saude .dblclick input").dblclick(function () {
            $(this).attr('readonly', false).toggleClass('border-0');
        }).focusout(function () {
            let attr = $(this).attr('readonly');
            if (typeof attr !== 'undefined' && attr !== false) {
                $(this).attr('readonly', true)
            } else {
                $(this).attr('readonly', true).toggleClass('border-0')
            }
            updtsaude();
        })

        $("button, input:checkbox").on("click", function () {
            $(this).blur();
        })


        $('#editfoto .foto-perfil').on('input', function () {
            console.log("escrito")
            var src = $(this).val();
            if (!src.match("^https?://(?:[a-z\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpg|png|jpeg|webp|gif)$") || src == "") {
                $("#editfoto .return").html("<div class='alert alert-danger m-2'><i class='fat fa-x'></i> Precisa iniciar com HTTPS e terminar com .PNG|.WEBP|.JPG|.GIF!</div>");
                $('#editfoto .preview img').prop("src", '').parent().hide();
                return false;
            } else {
                $("#editfoto .return").html("");
                $('#editfoto .preview img').prop("src", src).parent().show();
            }

        })

        $('#editfoto .selector').change(function () {
            console.log($(this).val())
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


        $('.teedfa').on('input', function () {
            thisid = $(this).attr("id");
            var src = $('#' + thisid + ' input.simbolourl').val();
            if (!src.match("^https?://(?:[a-z\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpg|png|jpeg|webp)$") || src == "") {
                $('#' + thisid + ' div.warningsimbolo').html("Precisa ser HTTPS, e Terminar com com extensão de imagem(jpg,png,...)!");
                $('#' + thisid + ' div.prevsimbolo').html(' <img src="/assets/img/desconhecido.webp" width="200" height="200" alt="Ritual">');
                return false;
            } else {
                $('#' + thisid + ' div.warningsimbolo').html("");
                $('#' + thisid + ' div.prevsimbolo').html('<img src="' + src + '" width="200" height="200" alt="Ritual">');
            }

        })

        $('#addarmainvswitch').on('click', function () {
            if ($(this).is(":checked")) {
                $('#addarma .addinv input, #addarma textarea').attr('disabled', false);
            } else {
                $('#addarma .addinv input, #addarma textarea').attr('disabled', true);
            }
        }) //Ativar/Desativar Inventario em adicionar arma

        $('#card_principal .popout').on('click', function () {
            window.open("/sessao/personagem?popout=principal&token=<?=$token?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_dados .popout').on('click', function () {
            window.open("/sessao/personagem?popout=dados&token=<?=$token?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_atributos .popout').on('click', function () {
            window.open("/sessao/personagem?popout=atributos&token=<?=$token?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_inventario .popout').on('click', function () {
            window.open("/sessao/personagem?popout=inventario&token=<?=$token?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_pericias .popout').on('click', function () {
            window.open("/sessao/personagem?popout=pericias&token=<?=$token?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_habilidades .popout').on('click', function () {
            window.open("/sessao/personagem?popout=habilidades&token=<?=$token?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_proficiencias .popout').on('click', function () {
            window.open("/sessao/personagem?popout=proficiencias&token=<?=$token?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_rituais .popout').on('click', function () {
            window.open("/sessao/personagem?popout=rituais&token=<?=$token?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_rolar .popout').on('click', function () {
            window.open("/sessao/personagem?popout=rolar&token=<?=$token?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#pe input[type=checkbox]').change(function () {
            var checkboxes = $('#pe input:checkbox:checked').length;
            $.post({
                url: '?token=<?=$token?>',
                data: {status: 'pe', value: checkboxes},
            }).done(function () {
                $("#peatual").load("index.php?token=<?=$token?> #peatual");
            })
        });
        $("#verp").click(function () {
            $("#pericias .destreinado").toggle();
            $(this).children("i").children().addClass("fa-regular").toggleClass("fa-eye fa-eye-slash");
        });
        $("#vera").click(function () {
            $('#card_inventario .trocavision').toggle();
            $(this).children("i").children().addClass("fa-regular").toggleClass("fa-eye fa-eye-slash");
        });
    })
    ;
	<?php } else {?>
    $(document).ready(function () {
        $("#verp").click(function () {
            $("#pericias .destreinado").toggle();
            $(this).children("i").children().addClass("fa-regular").toggleClass("fa-eye fa-eye-slash");
        });
        $("#vera").click(function () {
            $('#card_inventario .trocavision').toggle();
            $(this).children("i").children().addClass("fa-regular").toggleClass("fa-eye fa-eye-slash");
        });
    });
	<?php
	}?>
</script>