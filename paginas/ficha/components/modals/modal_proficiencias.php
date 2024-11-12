<!-- Modal proficiencias-->
<form class="modal fade" id="addpro" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="fs-4 modal-title">Adicionar Proficiência</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="m-3">
                    <label class="form-floating w-100">
                        <input type="text" maxlength="<?= $Pro_nome ?>" placeholder="Proficiencia" name="pro" class="form-control"/>
                        <label>Proficiência</label>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="query" value="ficha_add_proficiencia"/>
                <button type="submit" class="btn btn-success w-100" value="submit">Salvar</button>
            </div>
        </div>
    </div>
</form>


<!-- Modal editar proficiencias-->
<form class="modal fade" id="editpro">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title fs-4">Editar Proficiências.</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
				<?php foreach ($s[3] as $r): ?>
                    <div class="m-3">
                        <label class="form-floating w-100">
                            <input aria-label="<?= $r["nome"]; ?>" placeholder="Proficiencia" class="form-control text-decoration-underline" name="pro[]" value="<?= $r["nome"] ?>"/>
                            <label>Proficiência</label>
                        </label>
                    </div>
                    <input type="hidden" name="did[]" maxlength="<?= $Pro_nome ?>" value="<?= $r["id"] ?>">
				<?php endforeach; ?>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="status" value="editpro"/>
                <button type="submit" class="btn btn-success w-100" value="submit">Salvar</button>
            </div>
        </div>
    </div>
</form>
