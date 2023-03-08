<div class="col">
    <div class="card h-100" id="card_personagem">
        <div class="card-header d-flex justify-content-between">
			<?php if (!isset($_GET["popout"]) && $edit) { ?>
                <div class="float-start">
                    <button class="btn btn-sm text-secondary fa-lg popout" title="PopOut">
                        <i class="fa-regular fa-rectangle-vertical-history"></i>
                    </button>
                </div>
			<?php } ?>
            <h4 class="m-0">ETC <span data-fop-icon class="icon"><i class="fas"></i></span></h4>
            <div class="float-end">
            </div>
        </div>
        <div class="card-body p-0">
            <nav>
                <div class="nav nav-tabs justify-content-center px-2 my-2" role="tablist">
                    <button class="nav-link active" id="aba-personagem-principal" data-bs-toggle="tab" data-bs-target="#personagem-principal" type="button" role="tab" aria-selected="true">
                        Principal
                    </button>
                    <button class="nav-link text-light" id="aba-personagem-outros" data-bs-toggle="tab" data-bs-target="#personagem-outros" type="button" role="tab" aria-selected="false">
                        Detalhes
                    </button>
                    <button class="nav-link text-light" id="aba-personagem-anotacao" data-bs-toggle="tab" data-bs-target="#personagem-anotacao" type="button" role="tab" aria-selected="false">
                        Outros
                    </button>
                </div>
            </nav>
            <div class="m-2">
                <div class="tab-content">
                    <div class="tab-pane fade show active m-2" id="personagem-principal" role="tabpanel" tabindex="0">
                        <div class="my-2">
                            <label class="fs-4" for="hdp">História</label>
                            <textarea id="hdp" class="form-control-plaintext" <?=$edit?:"disabled"?> maxlength="<?=$Fich_ETC?>" name="historia" placeholder="Clique para escrever"><?= $historia; ?></textarea>
                        </div>
                        <div class="my-2">
                            <label class="fs-4" for="adp">Aparência</label>
                            <textarea id="adp" class="form-control-plaintext" <?=$edit?:"disabled"?> maxlength="<?=$Fich_ETC?>" name="aparencia" placeholder="Clique para escrever"><?= $aparencia ?></textarea>
                        </div>
                        <div class="my-2">
                            <label class="fs-4" for="pepp">Primeiro Encontro Paranormal.</label>
                            <textarea id="pepp" class="form-control-plaintext" <?=$edit?:"disabled"?> maxlength="<?=$Fich_ETC?>" name="encontro" placeholder="Clique para escrever"><?= $encontro ?: '' ?></textarea>
                        </div>
                    </div>
                    <div class="tab-pane fade m-2" id="personagem-outros" role="tabpanel" tabindex="0">
                        <div class="my-2">
                            <label class="fs-4" for="mftdp">Doenças, Fobias e Manias...</label>
                            <textarea id="mftdp" class="form-control-plaintext" <?=$edit?:"disabled"?> maxlength="<?=$Fich_ETC?>" name="medos" placeholder="Clique para escrever"><?= $medos ?></textarea>
                        </div>
                        <div class="my-2">
                            <label class="fs-4" for="fdp">Favoritos(pessoas, itens, etc.)</label>
                            <textarea id="fdp" class="form-control-plaintext" <?=$edit?:"disabled"?> maxlength="<?=$Fich_ETC?>" name="favoritos" placeholder="Clique para escrever"><?= $favoritos ?></textarea>
                        </div>
                        <div class="my-2">
                            <label class="fs-4" for="pdp">Personalidade</label>
                            <textarea id="pdp" class="form-control-plaintext" <?=$edit?:"disabled"?> maxlength="<?=$Fich_ETC?>" name="frases" placeholder="Clique para escrever"><?= $frases ?></textarea>
                        </div>
                    </div>
                    <div class="tab-pane fade m-2" id="personagem-anotacao" role="tabpanel" tabindex="0">
                        <div class="my-2">
                            <label class="fs-4" for="ppdp">Pior Pesadelo</label>
                            <textarea id="ppdp" class="form-control-plaintext" <?=$edit?:"disabled"?> maxlength="<?=$Fich_ETC?>" name="pesadelo" placeholder="Clique para escrever"><?= $pesadelo; ?></textarea>
                        </div>
                        <div class="my-2">
                            <label class="fs-4" for="adp">Anotações</label>
                            <textarea id="adp" class="form-control-plaintext" <?=$edit?:"disabled"?> maxlength="<?=$Fich_ETC?>" rows="5" name="notas" placeholder="Clique para escrever"><?= $anotacao ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
