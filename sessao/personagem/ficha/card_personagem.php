<div class="col">
    <div class="card h-100 bg-black border-light" id="card_personagem">
        <div class="card-header clearfix text-center p-0">
	        <?php if (!isset($_GET["popout"]) AND $edit) { ?>
            <div class="float-start">
                    <button class="btn btn-sm text-white fa-lg popout" title="PopOut">
                        <i class="fa-regular fa-rectangle-vertical-history"></i>
                    </button>
            </div>
            <?php } ?>
            <span class="font6 fs-4">Personagem</span>
	        <?php if ($edit) { ?>
                <div class="float-end">
                        <button class="btn btn-sm text-warning fa-lg" data-bs-toggle="modal" data-bs-target="#editpersonagem" title="Editar Personagem">
                            <i class="fa-regular fa-pencil"></i>
                        </button>
                </div>
            <?php } ?>
        </div>
        <div class="card-body p-0">
            <div class="m-2">
                <nav>
                    <div class="nav nav-tabs justify-content-center" role="tablist">
                        <button class="btn btn-outline text-light active" id="aba-personagem-principal" data-bs-toggle="tab" data-bs-target="#personagem-principal" type="button" role="tab" aria-selected="true">Principal</button>
                        <button class="btn btn-outline text-light" id="aba-personagem-outros" data-bs-toggle="tab" data-bs-target="#personagem-outros" type="button" role="tab" aria-selected="false">Detalhes</button>
                        <button class="btn btn-outline text-light" id="aba-personagem-anotacao" data-bs-toggle="tab" data-bs-target="#personagem-anotacao" type="button" role="tab" aria-selected="false">Outros</button>
                    </div>
                </nav>
                <div class="tab-content">
                    <div class="tab-pane fade show active m-2" id="personagem-principal" role="tabpanel" tabindex="0">
                        <div class="my-2">
                            <label class="fs-4" for="hdp">História</label>
                            <textarea id="hdp" class="form-control bg-black text-light border-0" disabled><?= $historia; ?></textarea>
                        </div>
                        <div class="my-2">
                            <label class="fs-4" for="adp">Aparência</label>
                            <textarea id="adp" class="form-control bg-black text-light border-0" disabled><?= $aparencia?></textarea>
                        </div>
                        <div class="my-2">
                            <label class="fs-4" for="pepp">Primeiro Encontro Paranormal.</label>
                            <textarea id="pepp" class="form-control bg-black text-light border-0" disabled><?= $encontro?:''?></textarea>
                        </div>
                    </div>
                    <div class="tab-pane fade m-2" id="personagem-outros" role="tabpanel" tabindex="0">
                        <div class="my-2">
                            <label class="fs-4" for="mftdp">Doenças, Fobias e Manias...</label>
                            <textarea id="mftdp" class="form-control bg-black text-light border-0" disabled><?= $medos?></textarea>
                        </div>
                        <div class="my-2">
                            <label class="fs-4" for="fdp">Favoritos(pessoas, itens, etc.)</label>
                            <textarea id="fdp" class="form-control bg-black text-light border-0" disabled><?=$favoritos?></textarea>
                        </div>
                        <div class="my-2">
                            <label class="fs-4" for="pdp">Personalidade</label>
                            <textarea id="pdp" class="form-control bg-black text-light border-0" disabled><?=$frases?></textarea>
                        </div>
                    </div>
                    <div class="tab-pane fade m-2" id="personagem-anotacao" role="tabpanel" tabindex="0">
                        <div class="my-2">
                            <label class="fs-4" for="ppdp">Pior Pesadelo</label>
                            <textarea id="ppdp" class="form-control bg-black text-light border-0" disabled><?= $pesadelo; ?></textarea>
                        </div>
                        <div class="my-2">
                            <label class="fs-4" for="adp">Anotações</label>
                            <textarea id="adp" class="form-control bg-black text-light border-0" rows="5" disabled><?=$anotacao?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
