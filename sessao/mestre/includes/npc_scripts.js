
function copynpc(id){
    confirmar("Deseja duplicar essa ficha?", '').then((s)=>{
        if (s)
            $.ajax({
                data:{query:"mestre_duplicar_fichanpc",npc:id},
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
        data: {query: 'mestre_npc', ficha: id},
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


function deletnpc(id) {
    confirmar("tem certeza?","Ao apagar essa ficha, não será possível desfazer").then((s)=>{
        if (s) {
            $.post({
                data: {query: 'mestre_delete_fichanpc', npc: id},
                url: '?token=<?=$missao_token?>',
            }).done(function () {
               location.reload();
            })
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
        data: {query: 'mestre_update_status_fichasnpc', data: Data, ficha: ficha},
    })
}

