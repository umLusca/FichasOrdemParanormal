
<div class="modal" id="adicionar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content bg-black border-light" id="formadd" method="post" autocomplete="off">
            <div class="modal-body">
                <div class="modal-header border-0 text-center">
                    <h4 class="modal-title">Adicionar jogador</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="my-1" id="msgadd"></div>
                <div class="container-fluid">
                    <p class="text-info">Para convidar um jogador, coloque o email do mesmo.</p>
                    <label class="fs-5 m-1" for="email">Email do jogador</label>
                    <input type="email" id="email" name="email" class="form-control bg-black text-light" required/>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary">Enviar</button>
                <input type="hidden" name="status" value="addplayer"/>
            </div>
        </form>
    </div>
</div>