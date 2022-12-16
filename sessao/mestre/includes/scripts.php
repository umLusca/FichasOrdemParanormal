<script type="text/babel">
    let typingTimer;                //timer identifier
    const doneTypingInterval = 2500;  //time in ms, 5 seconds for example
    const $note = $('#notes .note');
    const editnpcmodal = new bootstrap.Modal('#editnpc')
    const players = [
		<?php
		foreach ($jogadores as $i => $token) {
			echo "{
                nome:'" . $token["nome"] . "',
                token:'" . $token["token"] . "',
                foto:'" . $token["foto"] . "'
                },
                ";
		}
		?>
    ]

    var socket = io('https://portrait.fichasop.com', {
        reconnectionDelay: 5000,
        transports: ['websocket', 'polling', 'flashsocket']
    });
    function copynpc(id){
        confirmar("Deseja duplicar essa ficha", '').then((s)=>{
            if (s)
            $.ajax({
                url:"",
                data:{status:"copy_npc",npc:id},
                method:"POST",
                success:()=>{
                    window.location.reload();
                }
            })
        })
    }
    
    function editnpc(id,category = 0) {
        $.post({
            url: ' ?token=<?=$missao_token?>',
            data: {status: 'npc', ficha: id},
            dataType: 'json',
            success: (data) => {
                $('#enome').val(data.nome);
                $('#epv').val(data.pv);
                $('#esan').val(data.san);
                $('#epe').val(data.pe);
                $('#editarmonstro').prop("checked",(category === "1"));
                $('#editattr .for').val(data.forca);
                $('#editattr .agi').val(data.agilidade);
                $('#editattr .int').val(data.inteligencia);
                $('#editattr .pre').val(data.presenca);
                $('#editattr .vig').val(data.vigor);
                $('#eacrobacia').val(data.acrobacia);
                $('#eadestramento').val(data.adestramento);
                $('#eartes').val(data.artes);
                $('#eatletismo').val(data.atletismo);
                $('#eatualidades').val(data.atualidade);
                $('#eciencia').val(data.ciencia);
                $('#ecrime').val(data.crime);
                $('#ediplomacia').val(data.diplomacia);
                $('#eenganacao').val(data.enganacao);
                $('#efortitude').val(data.fortitude);
                $('#efurtividade').val(data.furtividade);
                $('#einiciativ').val(data.iniciativa);
                $('#eintimidacao').val(data.intimidacao);
                $('#eintuicao').val(data.intuicao);
                $('#einvestigacao').val(data.investigacao);
                $('#eluta').val(data.luta);
                $('#emedicina').val(data.medicina);
                $('#eocultismo').val(data.ocultismo);
                $('#epercepcao').val(data.percepcao);
                $('#epilotagem').val(data.pilotagem);
                $('#epontaria').val(data.pontaria);
                $('#eprofissao').val(data.profissao);
                $('#ereflexos').val(data.reflexos);
                $('#ereligiao').val(data.religiao);
                $('#esobrevivencia').val(data.sobrevivencia);
                $('#etatica').val(data.tatica);
                $('#etecnologia').val(data.tecnologia);
                $('#evontade').val(data.vontade);
                $('#epassiva').val(data.passiva);
                $('#eesquiva').val(data.esquiva);
                $('#emorte').val(data.morte);
                $('#esangue').val(data.sangue);
                $('#eenergia').val(data.energia);
                $('#econhecimento').val(data.conhecimento);
                $('#efisica').val(data.fisica);
                $('#ebalistica').val(data.balistica);
                $('#emental').val(data.mental);
                $('#efni').val(data.id);
                $('#eataque').val(data.ataques);
                $('#ehabilidades').val(data.habilidades);
                $('#edetalhes').val(data.detalhes);
                editnpcmodal.toggle();
                console.log(data)

            }
        })
    }

    function updt(type, valor, ficha) {
        let atual = type + 'a';
        let total = type;
        let $el = (type) => $(`#npc${ficha} .${total}bar *[aria-label=${type}]`);
        let diff = (val1, type, val2) => {
            return eval(val1 + type + val2) ? val2 : val1;
        }
        
        $el(atual).html(diff($el(atual).html(), ">", parseInt($el(total).html()) + 20));
        $el(atual).html(diff($el(atual).html(), "<", 0));

        $el(atual).html(parseInt($el(atual).html()) + valor);
        $("#npc"+ficha+ " ."+type+ "bar .progress-bar").width(percent($el(atual).html(), $el(total).html()) + '%');
        
        let Data = {};
        $("#npc"+ficha+ " .status").each((i,e)=>{
            Data[$(e).attr("aria-label")] = parseInt($(e).html());
        })
        $.ajax({
            url: '?token=<?=$missao_token?>',
            method: "POST",
            data: {status: 'us_npc', data: Data, ficha: ficha},
        })
    }

    function adicionariniciativa() {
        $.post({
            data: {status: 'criariniciativa'},
            url: '?token=<?=$missao_token?>',
            dataType: ""
        }).done(function () {
            location.reload();
        })
    }

    function submitiniciativa() {
        $.post({
            url: '?token=<?=$missao_token?>',
            dataType: '',
            data: $('#iniciativa :input').serialize(),
            success: function (data) {
            }
        });
    }

    function deletariniciativa(iniciativa_id) {
        $.post({
            data: {status: 'deleteini', iniciativa_id: iniciativa_id},
            url: '?token=<?=$missao_token?>',
        }).done(function () {
            location.reload();
        })
    }

    function deletnpc(id) {
        confirmar("tem certeza?","Ao apagar essa ficha, não será possível desfazer").then((s)=>{
            if (s) {
                $.post({
                    data: {status: 'deletenpc', npc: id},
                    url: '?token=<?=$missao_token?>',
                }).done(function () {
                    location.reload();
                })
            }
        })
    }

    function updateIndex(e, ui) {
        $('td.index', ui.item.parent()).each(function (i) {
            $(this).html(i + 1);
        });
        $('input.hidden', ui.item.parent()).each(function (i) {
            $(this).val(i + 1);
        });
        submitiniciativa();
    };

    function doneTyping() {
        sync = $("#noteform").serialize();
        $.post({
            url: "",
            data: sync,
        }).done(function () {

            $("#syncnotes").attr("class", "text-success").children("i")
                .find('[data-fa-i2svg]')
                .removeClass('fa-arrow-rotate-right fa-spin')
                .addClass("fa-regular fa-cloud-check");
        }).fail(function () {
            $("#syncnotes").attr("class", "text-danger").children("i")
                .find('[data-fa-i2svg]')
                .removeClass('fa-arrow-rotate-right fa-spin')
                .addClass("fa-regular fa-cloud-xmark");

        })
    }

    function addnote() {
        $.post({
            data: {status: 'addnote'},
            url: "",
        }).done(function (data) {
            location.reload();
        });
    }

    function deletenote(id) {
        $.post({
            data: {status: 'deletenote', note: id},
            url: "",
        }).done(function (data) {
            location.reload();
        });
    }

    function desvincular(p) {
        let text = "DESEJA DESVINCULAR ESSA FICHA?\nNÃO SERÁ POSSIVEL REVERTER!";
        if (confirm(text) === true) {
            $.post({
                data: {status: "desp", p: p},
                url: " ",
            }).done(function (data) {
                console.log(data);
            });
        }
    }

    function toggleCombate(t) {
        let checked = $(t).attr("aria-checked");
        console.log(checked);
        if (checked === "true") {
            $(t).attr("aria-checked", "false");
            $(t).addClass("btn-outline-warning").removeClass("btn-warning");
            $(t).find(".fa-slash").show()
        } else {
            $(t).attr("aria-checked", "true");
            $(t).addClass("btn-warning").removeClass("btn-outline-warning");
            $(t).find(".fa-slash").hide()
        }
        $(t).blur();
    }


    $(document).ready(function () {

        socket.on('connect', function () {
            console.log("Conectado.")
        });
        socket.on('disconnect', function () {
            console.log("Desconectado.")
        });
        socket.emit('create', '<?=$missao_token?>');
        socket.on('<?=$missao_token?>', function (msg) {
            console.log(msg);
            let index = players.findIndex(function (player) {
                return player.token === msg.ficha;
            });

            if (msg.auth) {
                let index = players.findIndex(function (player) {
                    return player.token === msg.auth;
                });
                if (index => 0) {
                    socket.emit('<?=$missao_token?>', {authr: true, uid: msg.uid})
                } else {
                    socket.emit('<?=$missao_token?>', {authr: false, uid: msg.uid})
                }
            }
            if (index => 0) {
                if (msg.dado) {
                    if (players[index]) {
                        msg.foto = players[index]["foto"];
                        msg.nome = players[index]["nome"];
                    } else {
                        if (msg.foto == null || msg.foto == '') {
                            msg.foto = '/assets/img/Man.webp';
                            msg.nome = 'Mestre';
                        }
                    }
                    dadojogador(msg);
                    console.log(msg);
                    console.log("s");
                }
            }
        });

        $("form:not([ajax])").not("#adicionar").submit(function (event) {
            $(this).addClass('was-validated');

            if (!$(this).isValid()) {
                event.preventDefault()
                event.stopPropagation()
            } else {
                event.preventDefault();
                $.post({
                    url: '?token=<?=$missao_token?>',
                    data: $(this).serialize(),
                }).done(function () {
                    location.reload();
                })
            }
        })// Enviar qualquer formulario via jquery
        $('#adicionar').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            $.post({
                url: "",
                data: form.serialize() + "&status=addplayer",
                dataType: "JSON",
                beforeSend: function () {
                    $("#adicionar input, #adicionar button").attr('disabled', true);
                    $("#adicionar .return").html("<div class='alert alert-warning m-2'><i class='fat fa-spinner fa-spin'></i> Aguarde enquanto verificamos os dados...</div>");
                },
                success: (data) => {
                    console.log(data);
                    if (data.msg) {
                        if (!data.success) {
                            $("#adicionar .return").html('<div class="alert alert-danger m-2">' + data.msg + "</div>");
                            $("#adicionar input, #adicionar button").attr('disabled', false);
                        } else {
                            if (data.type == 1) {
                                $("#adicionar .return").html('<div class="alert alert-success m-2">' + data.msg + '</div>');
                                setTimeout(function () {
                                    $("#adicionar input, #adicionar button").attr('disabled', false);
                                }, 200)
                            } else {
                                $("#adicionar .return").html('<div class="alert alert-success m-2">' + data.msg + ' <a href="https://fichasop.com/?convite=1&email=' + data.email + '">https://fichasop.com/?convite=1&email=' + data.email + '</a></div>');
                                setTimeout(function () {
                                    $("#adicionar input, #adicionar button").attr('disabled', false);
                                }, 200)
                            }
                        }
                    }
                },
                error: () => {
                    $("#adicionar input, #adicionar button").attr('disabled', false);
                    $("#adicionar .return").html("<div class='alert alert-danger m-2'>Houve um erro ao fazer a solicitação, contate um administrador!</div>");
                }
            })
        });

        $note.on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        $note.on('keydown', function () {
            clearTimeout(typingTimer);
            $("#syncnotes").attr("class", "text-warning").children("i")
                .find('[data-fa-i2svg]')
                .addClass('fa-arrow-rotate-right fa-spin')
                .removeClass('fa-regular fa-cloud-x fa-cloud')
        });
        $(".iniciativa").dblclick(function () {
            $(this).children("input").attr('readonly', false).toggleClass('border-0').delay(200).focus();
        })
        $(".iniciativa input").focusout(function () {
            let attr = $(this).attr('readonly');
            if (typeof attr !== 'undefined' && attr !== false) {
                $(this).attr('readonly', true)
            } else {
                $(this).attr('readonly', true).toggleClass('border-0')
                submitiniciativa();
            }
        })
        $(".up,.down").click(function () {
            const item = $(this).parents("tr:first");
            const ui = {item};

            if ($(this).is(".up")) {
                item.insertBefore(item.prev());
            } else {
                item.insertAfter(item.next());
            }
            updateIndex('', ui);
        });

        function refreshstatus() {
            $(".principal").each(function () {
                let $this = $("#" + $(this).attr("id"));
                $($this).load('?token=<?=$missao_token?> #' + $(this).attr("id") + '>*')
            })
            setTimeout(refreshstatus, 5000);
        }

        setTimeout(refreshstatus, 1000);
    });
</script>