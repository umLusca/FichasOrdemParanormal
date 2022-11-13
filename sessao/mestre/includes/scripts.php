<script src="/assets/js/ckeditor/ckeditor.js"></script>
<script src="/assets/js/ckeditor/adapters/jquery.js"></script>
<script>
    var typingTimer;                //timer identifier
    var doneTypingInterval = 2500;  //time in ms, 5 seconds for example
    var $note = $('#notes .note');
    const editnpcmodal = new bootstrap.Modal('#editnpc')
    function editnpc(id){
        console.log("test");
        $.post({
            url: ' ?token=<?=$missao_token?>',
            data: {status: 'npc', ficha: id},
            dataType: 'json'
        }).done(function(data){
            $('#enome').val(data.nome);
            $('#epv').val(data.pv);
            $('#esan').val(data.san);
            $('#epe').val(data.pe);
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
        })
    }
    function updtvida(valor, ficha) {
        $.post({
            url: '?token=<?=$missao_token?>',
            data: {status: 'upv', ficha: ficha, value: valor},
        }).done(function (data) {
            $("#npc"+ficha+" .pvbar").load(location.href + " #npc"+ficha+" .pvbar>*");
        })
    }//Atualizar vida npc
    function updtsan(valor, ficha) {
        $.post({
            url: '?token=<?=$missao_token?>',
            data: {status: 'usan', ficha: ficha, value: valor},
        }).done(function (data) {
            $("#npc"+ficha+" .sanbar").load(location.href + " #npc"+ficha+" .sanbar>*");
        })
    }//Atualizar Sanidade npc
    function updtpe(valor, ficha) {
        $.post({
            url: '?token=<?=$missao_token?>',
            data: {status: 'upe', value: valor, ficha: ficha},
        }).done(function () {
            $("#npc"+ficha+" .pebar").load(location.href + " #npc"+ficha+" .pebar>*");
        })
    }
    function adicionariniciativa() {
        $.post({
            data: {status: 'criariniciativa'},
            url: '?token=<?=$missao_token?>',
            dataType: ""
        }).done(function (data) {
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
        let text = "DESEJA DELETAR ESSA FICHA?\nNÃO SERÁ POSSIVEL REVERTER!";
        if (confirm(text) === true) {
        $.post({
            data: {status: 'deletenpc', npc: id},
            url: '?token=<?=$missao_token?>',
        }).done(function () {
            location.reload();
        })
        }
    }
    updateIndex = function (e, ui) {
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
    function desvincular(p){
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
    function UmPorUm(data){
        var retorno = '';
        const dado = data.dado;
        retorno += '<span>'+dado.nome+': '+ dado.print +'='+ dado.resultado +' </span><br><span class="text-secondary">'
        for (let i = 0 ; i < (Object.keys(dado).length - 4); i++){

            retorno += ''+ dado[i]["dado"] +': ';

            for(let x = 0; x < dado[i]["rolagens"]; x++){

                retorno += dado[i]["resultados"][x];

                if (x !== (dado[i]["rolagens"]-1)) {
                    retorno += ', ';
                }
            }
            if (i !== (Object.keys(dado).length - 4)) {
                retorno += ' |<br>';
            }
        }
        retorno += '</span>';
        return retorno;
    }
    function dadojogador(data){
        if(data.foto == ''){
            data.foto = '/assets/img/Man.webp';
        }
        $("#dados_recentes").prepend(
            '<div class="row align-self-start g-1 m-1">' +
                '<div class="col-auto text-center">' +
                    '<div class="d-flex flex-column">' +
                        '<div>' +
                            '<img alt="Foto perfil" src="'+ data.foto +'" id="fotopersonagem" height="50" width="50" class="rounded-circle border border-1 border-white">' +
                        '</div>' +
                        '<div class="text-truncate">'+data.nome+'</div>' +
                    '</div>' +
                '</div>' +
                '<div class="col text-start">'+ UmPorUm(data)+ '</div>' +
            '</div>' +
            '</div><hr>');
    }
    $(document).ready(function () {

        const players = [
		    <?php
		    foreach($jogadores as $i => $token) {
			    echo "{
                nome:'".$token["nome"]."',
                token:'".$token["token"]."',
                foto:'".$token["foto"]."'
                },
                ";
		    }
		    ?>
        ]
        socket = io('https://portrait.fichasop.com', {
            reconnectionDelay: 5000,
            transports: ['websocket', 'polling', 'flashsocket']
        });
        socket.on('connect', function () {
            console.log("Conectado.")
        });
        socket.on('disconnect', function () {
            console.log("Desconectado.")
        });
        socket.emit('create', '<?=$missao_token?>');
        socket.on('<?=$missao_token?>', function(msg) {
            console.log(msg);
            let index = players.findIndex(function (player) {
                return player.token === msg.ficha;
            });

            if(msg.auth){
                let index = players.findIndex(function (player) {
                    return player.token === msg.auth;
                });
                if(index => 0){
                    socket.emit('<?=$missao_token?>',{authr: true,uid:msg.uid})
                } else {
                    socket.emit('<?=$missao_token?>',{authr: false,uid:msg.uid})
                }
            }
            if(index => 0){
                if(msg.dado) {
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

        $("form").not("#formadd").submit(function (event) {
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
        $('#formadd').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            $.post({
                beforeSend: function () {
                    $("#formadd input, #formadd button").attr('disabled', true);
                    $("#msgadd").html("<div class='alert alert-warning'>Aguarde enquanto verificamos os dados...</div>");
                },
                url: "",
                data: form.serialize(),
                dataType: "JSON",
            }).done(function (data) {
                console.log(data);
                if (data.msg) {
                    if (!data.success) {
                        $("#msgadd").html('<div class="alert alert-danger">' + data.msg + "</div>");
                        $("#formadd input, #formadd button").attr('disabled', false);
                    } else {
                        if (data.type == 1) {
                            $("#msgadd").html('<div class="alert alert-success">' + data.msg + '</div>');
                            setTimeout(function () {
                                $("#formadd input, #formadd button").attr('disabled', false);
                            }, 200)
                        } else {
                            $("#msgadd").html('<div class="alert alert-success">' + data.msg + ' <a href="https://fichasop.com/?convite=1&email=' + data.email + '">https://fichasop.com/?convite=1&email=' + data.email + '</a></div>');
                            setTimeout(function () {
                                $("#formadd input, #formadd button").attr('disabled', false);
                            }, 200)
                        }
                    }
                }
            }).fail(function () {
                $("#formadd input, #formadd button").attr('disabled', false);
                $("#msgadd").html("<div class='alert alert-danger'>Houve um erro ao fazer a solicitação, contate um administrador!</div>");
            });
        });
        $('#rolardadosbutton').on('click', function (){
            let dado = $("#rolardadosinput").val();
            $('#returncusdados').html("");
            let pattern = /^[d0-9+-]+\S$/g;
            let result = dado.match(pattern);
            if(result) {
                $.post({
                    url: '',
                    data: {status: 'roll', dado: dado},
                    dataType: 'JSON'
                }).done(function (data) {
                    if (data.success) {
                        mostrarresultado(data);
                    } else {
                        $('#returncusdados').html("<div class='alert alert-danger'>" + data.msg + "</div>");
                    }
                }).fail(function () {
                    $('#returncusdados').html("<div class='alert alert-danger'>Houve um erro, contate um administrador.</div>");
                })
            } else {
                $('#returncusdados').html("<div class='alert alert-danger'>Este dado não é válido.</div>");
            }
        })
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
                $this = $("#"+$(this).attr("id"));
                $($this).load('?token=<?=$missao_token?> #'+$(this).attr("id")+ '>*')
            })
            setTimeout(refreshstatus, 5000);
        }
        setTimeout(refreshstatus, 1000);
    });
</script>