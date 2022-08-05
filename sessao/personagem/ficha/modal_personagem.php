<!-- Modal proeficiencias-->
<div class="modal fade" id="editpersonagem" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" id="formeditdet" method="post">
                <div class="clearfix">
                    <button type="button" class="btn-close btn-close-white me-2 m-auto float-end" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <h1 class="text-center">Editar Detalhes Pessoais</h1>
                <nav>
                    <div class="nav nav-tabs justify-content-center" role="tablist">
                        <button class="btn btn-outline text-light active" id="edit-aba-personagem-principal" data-bs-toggle="tab" data-bs-target="#edit-personagem-principal" type="button" role="tab" aria-selected="true">Principal</button>
                        <button class="btn btn-outline text-light" id="edit-aba-personagem-outros" data-bs-toggle="tab" data-bs-target="#edit-personagem-outros" type="button" role="tab" aria-selected="false">Detalhes</button>
                        <button class="btn btn-outline text-light" id="edit-aba-personagem-anotacao" data-bs-toggle="tab" data-bs-target="#edit-personagem-anotacao" type="button" role="tab" aria-selected="false">Outros</button>
                    </div>
                </nav>
                <div class="tab-content">
                    <div class="tab-pane fade show active m-2" id="edit-personagem-principal"  role="tabpanel" tabindex="0">
                        <div class="my-2">
                            <label class="fs-4" for="chdp">História</label>
                            <textarea id="chdp" maxlength="<?=$Fich_hist?>" class="form-control bg-black text-light border-0" name="historia"><?= $historia; ?></textarea>
                        </div>
                        <div class="my-2">
                            <label class="fs-4" for="cadp">Aparência</label>
                            <textarea id="cadp" maxlength="<?=$Fich_apar?>" class="form-control bg-black text-light border-0" name="aparencia"><?= $aparencia?></textarea>
                        </div>
                        <div class="my-2">
                            <label class="fs-4" for="cpepp">Primeiro Encontro Paranormal</label>
                            <textarea id="cpepp" maxlength="<?=$Fich_prim?>" class="form-control bg-black text-light border-0" name="encontro"><?= $encontro?:''; ?></textarea>
                        </div>
                    </div>

                    <div class="tab-pane fade m-2" id="edit-personagem-outros" role="tabpanel" tabindex="0">
                        <div class="my-2">
                            <label class="fs-4" for="cmftdp">Doenças, Fobias e Manias...</label>
                            <textarea id="cmftdp" maxlength="<?=$Fich_medo?>" class="form-control bg-black text-light border-0" name="medos"><?= $medos?></textarea>
                        </div>
                        <div class="my-2">
                            <label class="fs-4" for="cfp">Favoritos(pessoas, itens, etc.)</label>
                            <textarea id="cfp" maxlength="<?=$Fich_favo?>" class="form-control bg-black text-light border-0" name="favoritos"><?=$favoritos?></textarea>
                        </div>
                        <div class="my-2">
                            <label class="fs-4" for="cpdp">Personalidade</label>
                            <textarea id="cpdp" maxlength="<?=$Fich_fras?>" class="form-control bg-black text-light border-0" name="frases"><?=$frases?></textarea>
                        </div>
                    </div>
                    <div class="tab-pane fade m-2" id="edit-personagem-anotacao" role="tabpanel" tabindex="0">
                        <div class="my-2">
                            <label class="fs-4" for="cppdp">Pior Pesadelo</label>
                            <textarea id="cppdp" maxlength="<?=$Fich_pesa?>" class="form-control bg-black text-light border-0" name="pesadelo"><?=$pesadelo?></textarea>
                        </div>
                        <div class="my-2">
                            <label class="fs-4" for="cadp">Anotações</label>
                            <textarea id="cadp" maxlength="<?=$Fich_note?>" class="form-control bg-black text-light border-0" name="anotacoes"><?=$anotacao?></textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="status" value="editpers">
                <div class="clearfix m-2">
                    <button class="btn btn-outline-success float-start" type="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

