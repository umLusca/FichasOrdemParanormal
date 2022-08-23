<!-- Modal ATRIBUTOS-->
<div class="modal fade" id="editatrr" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" id="formeditatr">
                <div class="text-center"><h2>Editar Atributos.</h2></div>
                <div class="containera text-white" id="atributos" title="Atributos, clique para editar">
	                <?=atributos($forca,$agilidade,$intelecto,$vigor,$presenca,1,1)?>
                </div>
                <div class="clearfix">
                    <input name="status" value="editattr" type="hidden"/>
                    <button type="button" class="btn btn-danger float-start" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success float-end" value="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
