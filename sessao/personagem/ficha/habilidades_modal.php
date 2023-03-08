<!-- Modal Habilidades-->
<form class="modal fade" id="addhab" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-secondary">
            <div class="modal-header">
                <span class="fs-4 modal-title">Adicionar</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="m-2">
                    <label class="form-floating w-100">
                        <input type="text" name="hab" class="form-control fs-6 " placeholder="Título" minlength="5" maxlength="200" required/>
                        <label>Nome</label>
                    </label>
                </div>
                <div class="m-2">
                    <label class="form-floating w-100">
                        <textarea class="form-control form-control-plaintext" style="min-height: 300px" placeholder="Descriçao" name="desc" minlength="10" rows="5" maxlength="1000" required></textarea>
                        <label>Descrição</label>
                    </label>
                </div>
                <div class="form-check form-switch m-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="addcomopoder" name="poder">
                    <label class="form-check-label" for="addcomopoder">Poder paranormal</label>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="query" value="ficha_add_habilidade"/>
                <button type="submit" class="btn btn-success w-100" value="submit">Adicionar</button>
            </div>
        </div>
    </div>
</form>


<form class="modal fade" id="habedit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-secondary">
            <div class="modal-header">
                <span class="fs-4 modal-title">Editar</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="m-2">
                    <label class="form-floating w-100">
                        <input type="text" name="name" class="form-control fs-6" placeholder="Título" minlength="5" maxlength="200" required/>
                        <label>Nome</label>
                    </label>
                </div>
                <div class="m-2">
                    <label class="form-floating w-100">
                        <textarea class="form-control-plaintext" style="min-height: 300px" placeholder="Descriçao" name="desc" minlength="10" rows="5" maxlength="1000" required></textarea>
                        <label>Descrição</label>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="query" value="ficha_update_habilidade"/>
                <input type="hidden" name="type" value=""/>
                <input type="hidden" name="id" value=""/>
                <button type="submit" class="btn btn-success w-100" value="submit">Salvar</button>
            </div>
        </div>
    </div>
</form>
