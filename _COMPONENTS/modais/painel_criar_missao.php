<form class="modal" id="criarsessao" tabindex="-1" method="post" novalidate>
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-secondary">
            <div class="modal-header">
                <h4 class="modal-title">Criar uma sessão como mestre</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="m-2 return"></div>
                <div class="m-2">
                    <label class="form-floating w-100">
                        <input type="text" name="title" class="form-control" placeholder="Título da missão" required/>
                        <label>Titulo da missão</label>
                    </label>
                </div>
                <div class="m-2">
                    <label class="form-floating w-100">
                        <textarea type="text" name="desc" class="form-control h-50" required rows="5" placeholder="descrição da missão"></textarea>
                        <label>Introdução da missão</label>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Criar Missão</button>
                <input type="hidden" name="status" value="criarmissao">
            </div>
        </div>
    </div>
</form>
