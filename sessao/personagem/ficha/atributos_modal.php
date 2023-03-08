<!-- Modal ATRIBUTOS-->
<form class="modal fade" id="editatrr" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-secondary">
            <div class="modal-header">
                <span class="fs-4 modal-title">Editar Atributos</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="containera" id="atributos" title="Atributos, clique para editar">
	                <?=atributos($forca,$agilidade,$intelecto,$vigor,$presenca,1,1)?>
                </div>
            </div>
            <div class="modal-footer">
                <input name="query" value="ficha_update_atributos" type="hidden"/>
                <button type="button" class="btn btn-danger me-auto" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-success" value="submit">Salvar</button>
            </div>
        </div>
    </div>
</form>
