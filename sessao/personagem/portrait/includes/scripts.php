<script>
    /*
    $(document).ready(function () {
        $('.progress-bar').each(function(){
            var $this = $(this);
            var percent = $this.attr('percent');
            $this.css("width",percent+'%');
            $({animatedValue: 0}).animate({animatedValue: percent},{
                duration: 2000,
                step: function(){
                    $this.attr('percent', Math.floor(this.animatedValue) + '%');
                },
                complete: function(){
                    $this.attr('percent', Math.floor(this.animatedValue) + '%');
                }
            });
        });
    });
    */
    socket = io('https://portrait.fichasop.com', {
        reconnectionDelay: 5000,
        transports: ['websocket', 'polling', 'flashsocket']
    });
    socket.on('connect', function () {
        console.log("Conectado.");
    });
    socket.on('disconnect', function () {
        console.log("Desconectado.");
    });
    socket.emit('create', '<?=$missao_token?:$fichat?>');
    socket.on('<?=$missao_token?:$fichat?>', function(msg) {
        if(msg.ficha == '<?=$fichat?>') {
            if (msg.dado) {
                valordado = msg.dado.resultado;
                subtimer();
            }
            if (msg.vida) {
                combate = msg.vida.combate;
                pv = msg.vida.pv;
                pva = msg.vida.pva;
                san = msg.vida.san;
                sana = msg.vida.sana;
                pea = msg.vida.pea;
                mor = msg.vida.mor
                tick();
            }
            console.log(msg);
        }
    });

    $.

</script>
<script src="https://unpkg.com/babel-standalone@6/babel.min.js" data-cfasync="false"></script>
<script crossorigin src="https://unpkg.com/react@18/umd/react.production.min.js" data-cfasync="false"></script>
<script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" data-cfasync="false"></script>