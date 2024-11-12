function submitIniciativa(){
    $.post({
        url: '?token=<?=$missao_token?>',
        dataType: '',
        data: $('#iniciativa :input').serialize()+"&query=mestre_update_iniciativa",
    });
}

$(() => {

    $("#iniciativa *[data-fop-initfunction]").click(function () {
        const item = $(this).parents("tr:first");

        switch ($(this).data("fop-initfunction")) {
            case "add":
                $.post({
                    data: {query: 'mestre_add_iniciativa'},
                    url: '?token=<?=$missao_token?>',
                }).done(function () {
                    location.reload();
                })
                break;
            case "up":
                item.insertBefore(item.prev());
                break;
            case "down":
                item.insertAfter(item.next());
                break;
            case "delete":
                console.log();
                let id = $(this).parents("tr").data("fop-initid");
                confirmar("Deseja deletar da lista?").then(s => {
                    if (s) {
                        $.post({
                            data: {query: 'mestre_delete_iniciativa', iniciativa_id: id},
                            url: '?token=<?=$missao_token?>',
                        })
                        $("#iniciativa tr[data-fop-initid=" + id + "]").remove()
                    }
                })
                break;
        }



        $('td.index', item.parent()).each(function (i) {
            $(this).html(i + 1);
        });
        $('input.prioridade', item.parent()).each(function (i) {
            $(this).val(i + 1);
        });


        submitIniciativa()
    });



    $(".iniciativa input").on("dblclick",(e)=>{
        $(e.currentTarget).removeAttr('readonly').addClass("border border-secondary").delay(200).focus();
    })
    $(".iniciativa input").on("focusout", (e)=>{
        let $this = $(e.currentTarget);
        if ($this.is('[readonly]')) {
            $this.attr('readonly', true)
        } else {
            $this.attr('readonly', true).removeClass('border border-secondary')
            submitIniciativa();
        }
    })

})