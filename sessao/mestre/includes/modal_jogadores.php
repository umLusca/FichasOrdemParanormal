<form class="modal" id="adicionar" tabindex="-1" aria-hidden="true" method="post" autocomplete="off">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-black border-light">
            <div class="modal-header border-0 text-center">
                <span class="modal-title fs-4">Adicionar jogador</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="return"></div>
                <div class="m-2">
                <label class="form-floating w-100">
                    <input type="text" name="user" placeholder="Email ou Username do jogador" class="form-control bg-black text-light" required/>
                    <label>Email / User</label>
                </label>
                </div>
            </div>
            <div class="modal-footer border-0 d-grid">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </div>
    </div>
</form>