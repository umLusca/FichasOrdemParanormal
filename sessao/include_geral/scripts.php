<script>
    const modaleditardado = new bootstrap.Modal('#editardado')
    var i = 0, timeOut = 0;

    function editdado(id,dado,nome,foto) {
        $('#edicone').val(foto);
        $('#eddado').val(dado);
        $('#ednome').val(nome);
        $('#edidd').val(id);
        modaleditardado.toggle();
    }
    function mostrarresultado(data){
            var retorno = '';
            retorno += '<h3>'+data.nome+': '+ data.print +'='+ data.resultado +' </h3><span class="text-secondary">';
            for (let i = 0 ; i < (Object.keys(data).length - 4); i++){

                retorno += ''+ data[i]["dado"] +': ';

                for(let x = 0; x < data[i]["rolagens"]; x++){

                    retorno += data[i]["resultados"][x];

                    if (x !== (data[i]["rolagens"]-1)) {
                        retorno += ', ';

                    }
                }
                if (i !== (Object.keys(data).length - 4)) {
                    retorno += '<br>';
                }
            }
            retorno += '</span>';

        $("#resultado").html(retorno);
        new bootstrap.Toast($('#Toastdados')).show();
        $("main button").attr("disabled", false)
    }
    function rolar(dado, dano = 0, nome = "Teste") {
        if (dano && nome == "teste"){
            nome = "Dano";
        }
        let ficha = '<?=$fichat?:''?>'
        $("main button").attr("disabled", true)
        $.post({
            url: '',
            data: {status: 'roll', dado: dado, dano: dano},
            dataType: 'JSON'
        }).done(function (data) {
            dado = {}
            dado.dado = data;
            dado.dado.nome = nome;
            dado.ficha = ficha;
            mostrarresultado(data);
            socket.emit('<?=$missao_token?:$fichat?>', dado);
            console.log(dado);
            return true;
        }).fail(function () {
            new bootstrap.Toast($('#Toastdados')).show();
            $('#resultado,#dado1,#dado2,#dado3,#valores1,#valores2,#valores3').html('');
            $('#valordados1,#valordados2,#valordados3').hide();
            $('#resultado').html('FALHA AO RODAR DADO, VERIFICAR SE ESTÀ CORRETO!');
            $('main button').attr('disabled', false);
            return false;
        })
    }// Mostrar resultado dados
    $(document).ready(function () {


        $("#ded").click(function(){
            $("#eds").val("deld");
            $("#formeditdado").submit();
        })
        $("#sed").click(function(){
            $("#eds").val("editd");
            $("#formeditdado").submit();
        })
        
        $('#dados .dado').on('mousedown touchstart', function(e) {
            $(this).addClass('active');
            let id = $(this).attr("aria-id");
            let dado = $(this).attr("aria-dado");
            let nome = $(this).attr("aria-nome");
            let foto = $(this).attr("aria-foto");
            timeOut = setInterval(function() {
                clearInterval(timeOut);
                editdado(id,dado,nome,foto);
            }, 500);
        }).bind('mouseup mouseleave touchend', function() {
            $(this).removeClass('active');
            clearInterval(timeOut);
        });
        
        
        $('#rolardadosbutton').on('click', function (){
            let dado = $("#rolardadosinput").val();
            $('#returncusdados').html("");
            let pattern = /^[AdDEFGINOPRTV\d/+-]+\S$/g;
            let result = dado.match(pattern);
            if(result) {
                rolar(dado);
            } else {
                console.log(data);
                $('#returncusdados').html("<div class='alert alert-danger'>Este dado não é válido.</div>");
            }
        })
    })
</script>