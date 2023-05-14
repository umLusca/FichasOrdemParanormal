<!-- Modal Habilidades-->
<form class="modal fade" id="addhab" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-secondary">
            <div class="modal-header">
                <span class="fs-4 modal-title">Adicionar</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="m-2">
                    <label class="form-floating w-100">
                        <select type="text" name="tab" class="form-select" aria-label="Aba onde vai ficar essa habilidade" required>
                            <option>Habilidades</option>
				            <?php foreach ($s[9] as $tab){?>
                                <option value="<?=$tab["token"]?>"><?=$tab["nome"]?></option>
				            <?php } ?>
                        </select>
                        <label>Aba</label>
                    </label>
                </div>
                <div class="m-2">
                    <label class="form-floating w-100">
                        <input type="text" name="hab" class="form-control fs-6 " placeholder="Título" minlength="5" maxlength="200" required/>
                        <label>Nome</label>
                    </label>
                </div>
                <div class="m-2">
                    <label class="form-floating w-100">
                        <textarea class="form-control-plaintext border" style="min-height: 300px" placeholder="Descriçao" name="desc" minlength="10" rows="5" maxlength="1000" required></textarea>
                        <label>Descrição</label>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="query" value="ficha_add_habilidade"/>
                <button type="submit" class="btn btn-success w-100" value="submit">Adicionar</button>
            </div>
        </div>
    </div>
</form>


<form class="modal fade" id="habedit" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-secondary">
            <div class="modal-header">
                <span class="fs-4 modal-title">Editar</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="m-2">
                    <label class="form-floating w-100">
                        <select type="text" name="tab" class="form-select" aria-label="Aba onde vai ficar essa habilidade" required>
                            <option>Habilidades</option>
				            <?php foreach ($s[9] as $tab){?>
                                <option value="<?=$tab["token"]?>"><?=$tab["nome"]?></option>
				            <?php } ?>
                        </select>
                        <label>Aba</label>
                    </label>
                </div>
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
                <input type="hidden" name="id" value=""/>
                <button type="submit" class="btn btn-success w-100" value="submit">Salvar</button>
            </div>
        </div>
    </div>
</form>

<form class="modal fade" id="habaddtab" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <span class="fs-4 modal-title">Adicionar pagina</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="m-2">
                    <label class="form-floating w-100">
                        <input type="text" name="name" class="form-control fs-6" placeholder="Título" minlength="3" maxlength="30" required/>
                        <label>Nome</label>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="query" value="ficha_add_habtab">
                <button class="btn btn-success w-100">Adicionar</button>
            </div>
        </div>
        
    </div>
    
</form>

<form class="modal fade" id="habedttab" data-fop-token="" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <span class="fs-4 modal-title">Editar pagina</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="m-2">
                    <label class="form-floating w-100">
                        <input type="text" name="name" class="form-control fs-6" placeholder="Título" minlength="3" maxlength="30" required/>
                        <label>Nome</label>
                    </label>
                </div>
                <input type="hidden" name="query" value="ficha_update_habtab">
                <input type="hidden" name="token" value="">
            </div>
            <div class="modal-footer d-flex">
                <button class="btn btn-danger deletehabtab">Apagar</button>
                <button class="btn btn-success flex-grow-1">Salvar</button>
            </div>
        </div>
        
    </div>
    
</form>
