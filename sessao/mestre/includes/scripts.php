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

    $(document).ready(function () {


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


        $('body .popout').on('click', function (e) {
            window.open(`/sessao/mestre?popout=${$(e.currentTarget).attr("data-fop-pop")}&token=<?=$missao_token?>`, "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
            return false;
        })
   
    });
</script>