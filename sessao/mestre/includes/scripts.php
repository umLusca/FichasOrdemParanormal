<script type="text/babel">
    const token = '<?=$token?>';
    <?php require_once "dadosjogados_script.js";?>
    <?php require_once "iniciativas_script.js";?>
    <?php require_once "jogadores_script.js";?>
    <?php require_once "notas_script.js";?>
    <?php require_once "npc_scripts.js";?>
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