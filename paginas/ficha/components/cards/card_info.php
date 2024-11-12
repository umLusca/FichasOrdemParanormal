<card-info class="card h-100">
    <style>
        .col:has(.label):has(:empty) {
            display: none;
            
        }
    </style>
    <div class="card-header p-1 position-relative justify-content-between">
        <h5 class="m-0 text-center">Informações <span data-fop-icon class="icon"><i class="fas"></i></span></h5>
    </div>
    <div class="card-body p-0">
        <ul class="nav nav-tabs px-2 mt-2" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="card-info .paginas .info" type="button" role="tab">Gerais</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="card-info .paginas .hist" type="button" role="tab">Histórias</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="card-info .paginas .note" type="button" role="tab">Anotações</button>
            </li>

        </ul>
        
  
        <div class="tab-content paginas">
            <div class="tab-pane fade p-1 info show active" id="home-tab-pane" role="tabpanel" tabindex="0">
                <div class="row row-cols-2 row-cols-md-2 g-1 p-1 mt-2">
                    <div class="col">
                        <div class="position-relative overflow-hidden">
                            <div class="position-absolute start-50 translate-middle ms-3 mt-2 w-100 ">
                                <label class="bg-body px-2">
                                    Nome
                                </label>
                            </div>
                            <div class="m-2 p-2 border border-secondary d-block label">
                                <span><?= $ficha["nome"] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="position-relative overflow-hidden">
                            <div class="position-absolute start-50 translate-middle ms-3 mt-2 w-100 ">
                                <label class="bg-body px-2">
                                    Jogador
                                </label>
                            </div>
                            <div class="m-2 p-2 border border-secondary d-block label">
                                <span><?= $ficha["usuario"] ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="position-relative overflow-hidden">
                            <div class="position-absolute start-50 translate-middle ms-3 mt-2 w-100 ">
                                <label class="bg-body px-2">
                                    Classe
                                </label>
                            </div>
                            <div class="m-2 p-2 border border-secondary d-block label">
                                <span><?= $ficha["classe"] ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="position-relative overflow-hidden">
                            <div class="position-absolute start-50 translate-middle ms-3 mt-2 w-100 ">
                                <label class="bg-body px-2">
                                    Trilha
                                </label>
                            </div>
                            <div class="m-2 p-2 border border-secondary d-block label">
                                <span><?= $ficha["trilha"] ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="position-relative overflow-hidden">
                            <div class="position-absolute start-50 translate-middle ms-3 mt-2 w-100 ">
                                <label class="bg-body px-2">
                                    Origem
                                </label>
                            </div>
                            <div class="m-2 p-2 border border-secondary d-block label">
                                <span><?= $ficha["origem"] ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="position-relative overflow-hidden">
                            <div class="position-absolute start-50 translate-middle ms-3 mt-2 w-100 ">
                                <label class="bg-body px-2">
                                    Nivel de Exposição
                                </label>
                            </div>
                            <div class="m-2 p-2 border border-secondary d-block label">
                                <span><?= $ficha["nex"] ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="position-relative overflow-hidden">
                            <div class="position-absolute start-50 translate-middle ms-3 mt-2 w-100 ">
                                <label class="bg-body px-2">
                                    Local de Nascimento
                                </label>
                            </div>
                            <div class="m-2 p-2 border border-secondary d-block label">
                                <span><?= $ficha["local"] ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="position-relative overflow-hidden">
                            <div class="position-absolute start-50 translate-middle ms-3 mt-2 w-100 ">
                                <label class="bg-body px-2">
                                    Patente (Pontos)
                                </label>
                            </div>
                            <div class="m-2 p-2 border border-secondary d-block label">
                                <span><?= $ficha["patente"] ?><?php
	                                if ($ficha["pp"]) { ?> ( <?= $ficha["pp"] ?> )<?php
	                                } ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="position-relative overflow-hidden">
                            <div class="position-absolute start-50 translate-middle ms-3 mt-2 w-100 ">
                                <label class="bg-body px-2">
                                    PE por Rodada
                                </label>
                            </div>
                            <div class="m-2 py-2 border border-secondary d-block label">
                                <span><?= $ficha["limite_pe"] ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="position-relative overflow-hidden">
                            <div class="position-absolute start-50 translate-middle ms-3 mt-2 w-100 ">
                                <label class="bg-body px-2">
                                    Afinidade
                                </label>
                            </div>
                            <div class="m-2 p-2 border border-secondary d-block label">
                                <span><?= $ficha["afinidade"] ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="position-relative overflow-hidden">
                            <div class="position-absolute start-50 translate-middle ms-3 mt-2 w-100 ">
                                <label class="bg-body px-2">
                                    Idade
                                </label>
                            </div>
                            <div class="m-2 p-2 border border-secondary d-block label">
								<span><?= $ficha["idade"] ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="position-relative overflow-hidden">
                            <div class="position-absolute start-50 translate-middle ms-3 mt-2 w-100 ">
                                <label class="bg-body px-2">
                                    Deslocamento
                                </label>
                            </div>
                            <div class="m-2 p-2 border border-secondary d-block label">
                                <span><?= $ficha["deslocamento"] ?></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane fade p-1 hist" id="profile-tab-pane" role="tabpanel" tabindex="0">
                <div class="my-2">
                    <label class="fs-4" for="hdp">História</label>
                    <textarea id="hdp" class="form-control-plaintext" <?= $edit ?: "disabled" ?> maxlength="<?= $Fich_ETC ?>" name="historia" placeholder="Clique para escrever"><?= $historia; ?></textarea>
                </div>
                <div class="my-2">
                    <label class="fs-4" for="pepp">Primeiro Encontro Paranormal.</label>
                    <textarea id="pepp" class="form-control-plaintext" <?= $edit ?: "disabled" ?> maxlength="<?= $Fich_ETC ?>" name="encontro" placeholder="Clique para escrever"><?= $encontro ?: '' ?></textarea>
                </div>
                <div class="my-2">
                    <label class="fs-4" for="ppdp">Pior Pesadelo</label>
                    <textarea id="ppdp" class="form-control-plaintext" <?= $edit ?: "disabled" ?> maxlength="<?= $Fich_ETC ?>" name="pesadelo" placeholder="Clique para escrever"><?= $pesadelo; ?></textarea>
                </div>
            </div>
            <div class="tab-pane fade p-1 note" id="profile-tab-pane" role="tabpanel" tabindex="0">

                <div class="my-2">
                    <label class="fs-4" for="adp">Aparência</label>
                    <textarea id="adp" class="form-control-plaintext" <?= $edit ?: "disabled" ?> maxlength="<?= $Fich_ETC ?>" name="aparencia" placeholder="Clique para escrever"><?= $aparencia ?></textarea>
                </div>

                <div class="my-2">
                    <label class="fs-4" for="mftdp">Doenças, Fobias e Manias...</label>
                    <textarea id="mftdp" class="form-control-plaintext" <?= $edit ?: "disabled" ?> maxlength="<?= $Fich_ETC ?>" name="medos" placeholder="Clique para escrever"><?= $medos ?></textarea>
                </div>
                <div class="my-2">
                    <label class="fs-4" for="fdp">Favoritos(pessoas, itens, etc.)</label>
                    <textarea id="fdp" class="form-control-plaintext" <?= $edit ?: "disabled" ?> maxlength="<?= $Fich_ETC ?>" name="favoritos" placeholder="Clique para escrever"><?= $favoritos ?></textarea>
                </div>
                <div class="my-2">
                    <label class="fs-4" for="pdp">Personalidade</label>
                    <textarea id="pdp" class="form-control-plaintext" <?= $edit ?: "disabled" ?> maxlength="<?= $Fich_ETC ?>" name="frases" placeholder="Clique para escrever"><?= $frases ?></textarea>
                </div>

                <div class="my-2">
                    <label class="fs-4" for="adp">Anotações</label>
                    <textarea id="adp" class="form-control-plaintext" <?= $edit ?: "disabled" ?> maxlength="<?= $Fich_ETC ?>" rows="5" name="notas" placeholder="Clique para escrever"><?= $anotacao ?></textarea>
                </div>
            </div>
        </div>

    </div>
</card-info>
