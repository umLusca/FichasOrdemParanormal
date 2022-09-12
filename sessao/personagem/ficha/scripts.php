<script>
    <?php if ($edit){?>
    function deletar(id,nome,tipo) {
        $('#deletarid').val(id);
        $('#deletarnome').html(nome);
        $('#deletarstatus').val(tipo);
        $('#deletar').modal('show');
    }//Deletar Arma
    function editarma(id) {
        $('#editarmatitle, #enome').val($("#armaid" + id + " .arma").text());
        $('#etipo').val($("#armaid" + id + " .tipo").text());
        $('#eataque').val($("#armaid" + id + " .ataque").text());
        $('#ealcance').val($("#armaid" + id + " .alcance").text());
        $('#edano').val($("#armaid" + id + " .dano").text());
        $('#ecritico').val($("#armaid" + id + " .critico").text());
        $('#emargem').val($("#armaid" + id + " .margem").text());
        $('#erecarga').val($("#armaid" + id + " .recarga").text());
        $('#eespecial').val($("#armaid" + id + " .especial").text());
        $('#editarmaid').val(id);
    }// Editar Arma
    function edititem(id) {
        $('#edititemtitle, #enom').val($("#itemid" + id + " .nome").text());
        $('#edes').val($("#itemid" + id + " .desc").text());
        $('#epes').val($("#itemid" + id + " .espaco").text());
        $('#epre').val($("#itemid" + id + " .prestigio").text());
        $('#edititid').val(id);
    }// Editar Item
    function cleanedit() {
        $('#deletarid,#deletarnome,#deletarstatus, #enome,#etipo,#eataque,#ealcance,#edano,#ecritico,#erecarga,#eespecial,#editarmaid,#enom,#edes,#epes,#epre,#edititid,#anom,#ades,#apes,#apre,#additemid').val('');
    }// Limpar modal edições


    function percent(max,min = 0){
        if((max === 0 && min === 0) || max === 0){
            return 0;
        }
        const p = (max / min) * 100;
        if (p > 100){
            return 100;
        } else {
            return p;
        }
    }


    let changingtimer,x,y;                //timer identifier
    const donetimer = 1500;
    function subtimer (){
        clearTimeout(changingtimer);
        changingtimer = setTimeout(subsaude, donetimer);
    }

    function updtsaude(valor,type) {
        let atual = type + 'a';
        let maxim = type;
        let saude = parseInt($("#saude ."+atual).val()) + valor;
        $("#saude ."+atual).val(saude);
        let per = parseInt($("#saude ."+maxim).val());
        if($('#saude .pva').val() < <?=$minpva?>){
            $('#saude .pva').val(<?=$minpva?>);
        }
        if($('#saude .sana').val() < <?=$minsana?>){
            $('#saude .sana').val(<?=$minsana?>);
        }
        if($('#saude .pea').val() < <?=$minpea?>){
            $('#saude .pea').val(<?=$minpea?>);
        }

        if($('#saude .pva').val() > <?=$pv + $maxpv?>){
            $('#saude .pva').val(<?=$pv + $maxpv?>);
        }
        if($('#saude .sana').val() > <?=$san + $maxsan?>){
            $('#saude .sana').val(<?=$san + $maxsan?>);
        }
        if($('#saude .pea').val() > <?=$pe + $maxpe?>){
            $('#saude .pea').val(<?=$pe + $maxpe?>);
        }

        $("#barra"+atual).css('width', percent(saude,per)+'%');
        subtimer();
    }
    function subsaude() {
        let data = $('#saude :input').serialize();
        if ($('#morrendo').is(":checked")) {
            x = 1;
        } else {
            x = 0;
        }
        data += '&status=usau&mor='+x;
        console.log(data);
        $.post({
            url: '?token=<?=$fichat?>',
            dataType: 'json',
            data: data,
        }).done(function (data){
            console.log(data);
            const msg = {};
            if ($('#combate').is(":checked")) {
                y = true;
            } else {
                y = false;
            }
            msg["vida"] = data;
            msg["vida"]["combate"] = y;
            msg["ficha"] = '<?=$fichat?>';
            console.log(msg.vida.pv);
            $('#saude .pv').val(msg.vida.pv);
            $('#saude .san').val(msg.vida.san);
            $('#saude .pe').val(msg.vida.pe);
            console.log($('#saude .pe').val());
            updatefoto()
            socket.emit('<?=$missao_token?:$fichat?>', msg);
        });
    }
    $('#morrendo,#combate').change(function () {
        subtimer();
    })

    function updatefoto() {
        let pv = parseInt($('#saude .pv').val());
        let pva = parseInt($('#saude .pva').val());
        let san = parseInt($('#saude .san').val());
        let sana = parseInt($('#saude .sana').val());

        if (pva <= 0) {
            $("#fotopersonagem").attr("src", "<?=$urlphotomor;?>");
            console.log("morrendo")
        } else if (sana <= 0) {
            if (percent(pva,pv) < 50) {
                console.log("enlouquecendo + ferido")
                    $("#fotopersonagem").attr("src", "<?=$urlphotoef;?>");
                } else {
                console.log("enlouquecendo")
                    $("#fotopersonagem").attr("src", "<?=$urlphotoenl;?>");
                }
        } else if (percent(pva,pv) < 50) {
            console.log("ferido")
            $("#fotopersonagem").attr("src", "<?=$urlphotofer;?>");
        } else {
            console.log("normal")
            $("#fotopersonagem").attr("src", "<?=$urlphoto;?>");
        }
    }

    $(document).ready(function () {

        $("#form_editar_principal .nex").on('input', function () {
            $("#form_editar_principal .trilha .trilha").hide();
            if($("#form_editar_principal .nex").val() > 9){
                if($('#form_editar_principal .classe').val() == 1) {
                    $("#form_editar_principal .trilha .trilha-combatente").show();
                }else if($('#form_editar_principal .classe').val() == 2) {
                    $("#form_editar_principal .trilha .trilha-especialista").show();
                }else if($('#form_editar_principal .classe').val() == 3) {
                    $("#form_editar_principal .trilha .trilha-ocultista").show();
                }
            } else {
                $("#form_editar_principal .trilha").val(0);
            }
        })

        $("#form_editar_principal .nex").val(<?=$nex?>)
        $("#form_editar_principal .elemento").val(<?=$rqs["afinidade"]?>)
        $("#form_editar_principal .origem").val(<?=$rqs["origem"]?>);
        $("#form_editar_principal .patente").val(<?= $rqs["patente"];?>);
        $("#form_editar_principal .classe").val(<?=$rqs["classe"]?>)

        if ($('#enex').val() > 9){
            if($('#eclasse').val() == 1) {
                $("#etrilha .trilha-combatente").show();
            }else if($('#eclasse').val() == 2) {
                $("#etrilha .trilha-especialista").show();
            }else if($('#eclasse').val() == 3) {
                $("#etrilha .trilha-ocultista").show();
            }
        }

        $("#eclasse").change(function (){
            $("#etrilha .trilha").hide();
            $("#etrilha").val(0);
            if($("#enex").val() > 9){
                if($(this).val() == 1) {
                    $("#etrilha .trilha-combatente").show();
                }else if($(this).val() == 2) {
                    $("#etrilha .trilha-especialista").show();
                }else if($(this).val() == 3) {
                    $("#etrilha .trilha-ocultista").show();
                }
            }
        });

    socket = io.connect('https://portrait.fichasop.com', {
        reconnectionDelay: 2500,
        transports: ['websocket', 'polling', 'flashsocket']
    });
    socket.on("connect", function () {
        console.log("Conectado");
    });
    socket.on("disconnect", function () {
        console.log("Desconectado");
    });
	    <?php if(isset($dados_missao) AND $dados_missao["id"]==5887){?>
        $('#portrait').prop('checked', true);
        socket.emit('create', '<?=$missao_token?:$fichat?>');
        socket.emit('auth', '<?=$missao_token?:$fichat?>');
	    <?php }?>

        $('#portrait').change(function () {
            if ($('#portrait').is(":checked")) {
                socket = io.connect('https://portrait.fichasop.com', {reconnectionDelay: 2500,transports: ['websocket', 'polling', 'flashsocket']});
                socket.emit('create', '<?=$missao_token ?: $fichat?>');
                socket.emit('<?=$missao_token ?: $fichat?>', {auth: '<?=$fichat?>'});
            } else {
                socket.disconnect();
            }
        })

        $.fn.isValid = function () {
            return this[0].checkValidity()
        } // Função para checar validade de formularios

        $("form").submit(function (event) {
            $(this).addClass('was-validated');
            if (!$(this).isValid()) {
                event.preventDefault()
                event.stopPropagation()
            } else {
                event.preventDefault();
                $.post({
                    url: '?token=<?=$fichat?>',
                    data: $(this).serialize(),
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

            $("button, input:checkbox").on("click", function (){
                $(this).blur();
            })


        $('#prev').html('<img class="rounded-circle border border-light" style="max-width: 172px;width: -webkit-fill-available;" src="' + $('#fotourl').val() + '" alt="">');
        $('#fotos .foto-perfil').on('input', function () {
            var src = jQuery(this).val();
            if (!src.match("^https?://(?:[a-z\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpg|png|jpeg|webp)$") || src == "") {
                $("#warning").html("Precisa ser HTTPS, e Terminar com com extensão de imagem(.jpg, .png ...)!");
                $('#prev').html('');
                return false;
            } else {
                $("#warning").html("");
                $('#prev').html('<img class="position-absolute rounded-circle border border-light" style="max-width:100px;" height="100" width="100" src="' + src + '">');
            }

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

        $('#simbolourl').on('input', function () {
            var src = $(this).val();

            if (!src.match("^https?://(?:[a-z\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpg|png|jpeg|webp)$") || src == "") {
                $("#warningsimbolo").html("Precisa ser HTTPS, e Terminar com com extensão de imagem(jpg,png,...)!");
                $('#prevsimbolo').html(' <img src="/assets/img/desconhecido.webp" width="200" height="200" alt="Ritual">');
                return false;
            } else {
                $("#warningsimbolo").html("");
                $('#prevsimbolo').html('<img src="' + src + '" width="200" height="200" alt="Ritual">');
            }

        })

        $('#fotosimbolo').change(function () {
            let fotovalor = $('#fotosimbolo').val()
            if (fotovalor == '2') {
                $('#divfotosimbolourl').show();
                $("#simbolourl").attr("disabled", false)
            } else {
                $('#divfotosimbolourl').hide();
                $("#simbolourl").attr("disabled", true)
            }
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

        }).change(function () {
            thisid = $(this).attr("id");
            let fotovalor = $('#' + thisid + ' select.fotosimbolo').val()
            if (fotovalor == '2') {
                $('#' + thisid + ' .divfotosimbolourl').show();
                $('#' + thisid + ' input').attr("disabled", false)
            } else {
                $('#' + thisid + ' .divfotosimbolourl').hide();
                $('#' + thisid + ' input').attr("disabled", true)
            }
        })

        $('#addarmainvswitch').on('click', function () {
            if ($(this).is(":checked")) {
                $('#addarmainv input[type=text], #addarmainv input[type=number]').attr('disabled', false);
            } else {
                $('#addarmainv input[type=text], #addarmainv input[type=number]').attr('disabled', true);
            }
        }) //Ativar/Desativar Inventario em adicionar arma

        $('#card_principal .popout').on('click', function () {
            window.open("/sessao/personagem?popout=principal&token=<?=$fichat?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_dados .popout').on('click', function () {
            window.open("/sessao/personagem?popout=dados&token=<?=$fichat?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_atributos .popout').on('click', function () {
            window.open("/sessao/personagem?popout=atributos&token=<?=$fichat?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_inventario .popout').on('click', function () {
            window.open("/sessao/personagem?popout=inventario&token=<?=$fichat?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_pericias .popout').on('click', function () {
            window.open("/sessao/personagem?popout=pericias&token=<?=$fichat?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_habilidades .popout').on('click', function () {
            window.open("/sessao/personagem?popout=habilidades&token=<?=$fichat?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_proeficiencias .popout').on('click', function () {
            window.open("/sessao/personagem?popout=proeficiencias&token=<?=$fichat?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_rituais .popout').on('click', function () {
            window.open("/sessao/personagem?popout=rituais&token=<?=$fichat?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#card_rolar .popout').on('click', function () {
            window.open("/sessao/personagem?popout=rolar&token=<?=$fichat?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
        $('#pe input[type=checkbox]').change(function () {
            var checkboxes = $('#pe input:checkbox:checked').length;
            $.post({
                url: '?token=<?=$fichat?>',
                data: {status: 'pe', value: checkboxes},
            }).done(function () {
                $("#peatual").load("index.php?token=<?=$fichat?> #peatual");
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
    });
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