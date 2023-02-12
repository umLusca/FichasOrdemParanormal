<!-- Modal PERICIAS-->
<form class="modal fade" id="editper" tabindex="-1">
    <div class="modal-dialog modal-fullscreen-lg-down modal-xl">
        <div class="modal-content bg-black border-light">
            <div class="modal-header">
                <span class="fs-4 modal-title">Editar Pericias</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body font1">

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
                    <div class="col">
                        <label class="fs-4 " for="Acrobacias">Acrobacias</label>
                        <input id="Acrobacias" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $acrobacias ?>" name="acrobacias"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Adestramento">Adestramento</label>
                        <input id="Adestramento" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $adestramento ?>" name="adestramento"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Artes">Artes</label>
                        <input id="Artes" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $artes ?>" name="artes"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Atletismo">Atletismo</label>
                        <input id="Atletismo" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $atletismo; ?>" name="atletismo"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Atualidades">Atualidades</label>
                        <input id="Atualidades" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $atualidades; ?>" name="atualidades"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Ciência">Ciência</label>
                        <input id="Ciência" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $ciencia; ?>" name="ciencia"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="crime">Crime</label>
                        <input id="crime" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $crime ?>" name="crime"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Diplomacia">Diplomacia</label>
                        <input id="Diplomacia" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $diplomacia; ?>" name="diplomacia"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Enganação">Enganação</label>
                        <input id="Enganação" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $enganacao; ?>" name="enganacao"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Fortitude">Fortitude</label>
                        <input id="Fortitude" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $fortitude; ?>" name="fortitude"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Furtividade">Furtividade</label>
                        <input id="Furtividade" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $furtividade; ?>" name="furtividade"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Iniciativa">Iniciativa</label>
                        <input id="Iniciativa" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $iniciativa ?>" name="iniciativa"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Intimidação">Intimidação</label>
                        <input id="Intimidação" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $intimidacao; ?>" name="intimidacao"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Intuição">Intuição</label>
                        <input id="Intuição" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $intuicao; ?>" name="intuicao"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Investigação">Investigação</label>
                        <input id="Investigação" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $investigacao; ?>" name="investigacao"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Luta">Luta</label>
                        <input id="Luta" class="form-control m-1 bg-black text-light border-light" type="number" min="0"
                               max="99" value="<?= $luta; ?>" name="luta"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Medicina">Medicina</label>
                        <input id="Medicina" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $medicina; ?>" name="medicina"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Ocultismo">Ocultismo</label>
                        <input id="Ocultismo" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $ocultismo; ?>" name="ocultismo"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Percepção">Percepção</label>
                        <input id="Percepção" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $percepcao; ?>" name="percepcao"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Pilotagem">Pilotagem</label>
                        <input id="Pilotagem" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $pilotagem; ?>" name="pilotagem"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Pontaria">Pontaria</label>
                        <input id="Pontaria" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $pontaria; ?>" name="pontaria"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Profissão">Profissão</label>
                        <input id="Profissão" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $profissao; ?>" name="profissao"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Reflexo">Reflexos</label>
                        <input id="Reflexo" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $reflexos; ?>" name="reflexo"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Religião">Religião</label>
                        <input id="Religião" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $religiao; ?>" name="religiao"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Sobrevivencia">Sobrevivência</label>
                        <input id="Sobrevivencia" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $sobrevivencia ?>" name="sobrevivencia"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Tática">Tática</label>
                        <input id="Tática" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $tatica; ?>" name="tatica"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Tecnologia">Tecnologia</label>
                        <input id="Tecnologia" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $tecnologia; ?>" name="tecnologia"/>
                    </div>
                    <div class="col">
                        <label class="fs-4 " for="Vontade">Vontade</label>
                        <input id="Vontade" class="form-control m-1 bg-black text-light border-light" type="number"
                               min="0" max="99" value="<?= $vontade; ?>" name="vontade"/>
                    </div>
                </div>
                <input type="hidden" name="status" value="editper"/>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success w-100">Salvar</button>
            </div>
        </div>
    </div>
</form>
