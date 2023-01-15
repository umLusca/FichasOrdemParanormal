<script type="text/babel">
    <?php require_once "dadosjogados_script.js";?>
    <?php require_once "iniciativas_script.js";?>
    <?php require_once "jogadores_script.js";?>
    <?php require_once "notas_script.js";?>
    const editnpcmodal = new bootstrap.Modal('#editnpc')
    const players = [
		<?php
		foreach ($q["personagens"] as $i => $token) {
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
        confirmar("Deseja duplicar essa ficha?", '').then((s)=>{
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
            console.log("aaa")

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

    });
</script>