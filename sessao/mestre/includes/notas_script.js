
let typingTimer;                //timer identifier
const doneTypingInterval = 2500;  //time in ms, 5 seconds for example


function doneTyping() {
    let sync = $("#noteform").serialize();
    $.post({
        url: "",
        data: sync,
        beforeSend:()=>{
        },
        success:()=>{
            $("#syncnotes").attr("class", "text-success").html("<i class='fa-regular fa-cloud-check'></i>")
        },
        error:()=>{
            $("#syncnotes").attr("class", "text-danger").html("<i class='fa-regular fa-cloud-x'></i>");
        },
        complete:()=>{

        }
    })
}

$("#notas .addnote").on("click",()=>{

    $.post({
        data: {status: 'notas_criar'},
        url: "",
        complete: () => {
            location.reload();

        }
    })
})

$("#notas .deletenota").on("click",(e)=>{
    confirmar("Deseja apagar essa anotaçãp?").then(r => {
        if(r){

            $.post({
                data: {status: 'notas_deletar', note: $(e.currentTarget).data("fop-id")},
                url: "",
                complete:(d)=>{
                    location.reload();
                }
            })
        }
    })
})


$(()=>{

    $('#notes .note').on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    }).on('keydown', function () {
        clearTimeout(typingTimer);
        $("#syncnotes").attr("class", "text-warning").children().prop("class",'fal fa-arrow-rotate-right fa-spin');
    });


})






