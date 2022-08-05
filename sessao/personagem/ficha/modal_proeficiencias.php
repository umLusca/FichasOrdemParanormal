<!-- Modal proeficiencias-->
<div class="modal fade" id="addpro" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" method="post">
                <input type="hidden" name="status" value="addpro"/>
                <div class="text-center"><h2>Adicionar uma Proficiência.</h2></div>
                <div class="m-3">
                    <label for="pronome" class="fs-4 fw-bold">Nome da Proficiência</label>
                    <input type="text" id="pronome" maxlength="<?=$Pro_nome?>" name="pro" class="form-control fs-6 bg-black text-white"/>
                </div>
                <div class="clearfix">
                    <button type="button" class="btn btn-danger float-start" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success float-end" value="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal editar proeficiencias-->
<div class="modal fade" id="editpro" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" method="post">
                <div class="text-center"><h2>Editar Proficiências.</h2></div>
                <?php foreach ($s[3] as $r): ?>
                <div class="m-3">
                        <input aria-label="<?= $r["nome"]; ?>" class="form-control bg-black text-decoration-underline text-light" name="pro[]" value="<?= $r["nome"] ?>"/>
                        <input type="hidden" name="did[]" maxlength="<?=$Pro_nome?>" value="<?= $r["id"] ?>">
                </div>
                <?php endforeach; ?>
                <input type="hidden" name="status" value="editpro"/>
                <div class="clearfix">
                    <button type="button" class="btn btn-danger float-start" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success float-end" value="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
