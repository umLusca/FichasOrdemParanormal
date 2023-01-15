<div class="modal" id="addnpc" tabindex="-1" aria-hidden="true">
    <div class="modal-xl modal-dialog modal-dialog-centered">
        <form class="modal-content" id="formaddnpc" method="post" autocomplete="off">
            <div class="modal-header">
                <ul class="nav nav-tabs" id="pills-tab" role="tablist">
                    <li class="nav-item col-auto" role="presentation">
                        <button class="nav-link active" id="pills-dados-tab" data-bs-toggle="pill" data-bs-target="#pills-dados" type="button" role="tab" aria-controls="pills-dados" aria-selected="true">
                            Dados
                        </button>
                    </li>
                    <li class="nav-item col-auto" role="presentation">
                        <button class="nav-link" id="pills-attr-tab" data-bs-toggle="pill" data-bs-target="#pills-attr" type="button" role="tab" aria-controls="pills-attr" aria-selected="false">
                            Atributos
                        </button>
                    </li>
                    <li class="nav-item col-auto" role="presentation">
                        <button class="nav-link" id="pills-per-tab" data-bs-toggle="pill" data-bs-target="#pills-per" type="button" role="tab" aria-controls="pills-per" aria-selected="false">
                            Perícias
                        </button>
                    </li>
                    <li class="nav-item col-auto" role="presentation">
                        <button class="nav-link" id="pills-def-tab" data-bs-toggle="pill" data-bs-target="#pills-def" type="button" role="tab" aria-controls="pills-def" aria-selected="false">
                            Defesas
                        </button>
                    </li>
                    <li class="nav-item col-auto" role="presentation">
                        <button class="nav-link" id="pills-out-tab" data-bs-toggle="pill" data-bs-target="#pills-out" type="button" role="tab" aria-controls="pills-out" aria-selected="false">
                            Outros
                        </button>
                    </li>
                </ul>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-dados" role="tabpanel" aria-labelledby="pills-dados-tab">
                        <h2 class="m-2">Principal</h2>
                        <div class="m-2">
                            <label class="form-floating">
                                <input class="form-control" name="nome" type="text" maxlength="30" placeholder="Nome" required/>
                                <label>Nome</label>
                            </label>

                            <div class="invalid-feedback">Precisa pelomenos do nome</div>
                        </div>
                        <div class="form-check form-switch m-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="adicionarmonstro" name="monstro" value="1">
                            <label class="form-check-label" for="adicionarmonstro">Adicionar ficha como Monstro.</label>
                        </div>
                        <div class="m-2">
                            <label class="fs-4" for="pv">Pontos de Vida</label>
                            <input id="pv" class="form-control " name="pv" type="number" min="<?= $PV_minima_npc ?>" max="<?= $PV_maxima_npc; ?>" value="1"/>
                        </div>
                        <div class="m-2">
                            <label class="fs-4" for="san">Pontos de Sanidade</label>
                            <input id="san" class="form-control " name="san" type="number" min="<?= $SAN_minima_npc ?>" max="<?= $SAN_maxima_npc ?>" value="0"/>
                        </div>
                        <div class="m-2">
                            <label class="fs-4" for="pe">Pontos de Esforço</label>
                            <input id="pe" class="form-control " name="pe" type="number" min="<?= $SAN_minima_npc ?>" max="<?= $PE_maxima_npc ?>" value="0"/>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-attr" role="tabpanel" aria-labelledby="pills-attr-tab">
                        <div class="containera text-white">
							<?= atributos(0, 0, 0, 0, 0, 1, 1) ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-per" role="tabpanel" aria-labelledby="pills-per-tab">
                        <h2 class="my-2">Perícias</h2>
                        <div class="row g-2 m-2 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="acrobacia" type="number" min="0" max="99" placeholder="Acrobacia"/>
                                    <label>Acrobacia</label>
                                </label>
                            </div>
                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="adestramento" type="number" min="0" max="99" placeholder="Adestramento"/>
                                    <label>Adestramento</label>
                                </label>
                            </div>
                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="artes" type="number" min="0" max="99" placeholder="Artes"/>
                                    <label>Artes</label>
                                </label>
                            </div>
                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="atletismo" type="number" min="0" max="99" placeholder="Atletismo"/>
                                    <label>Atletismo</label>
                                </label>
                            </div>
                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="atualidades" type="number" min="0" max="99" placeholder="Atualidades"/>
                                    <label>Atualidades</label>
                                </label>
                            </div>
                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="ciencia" type="number" min="0" max="99" placeholder="Ciências"/>
                                    <label>Ciências</label>
                                </label>
                            </div>
                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="crime" type="number" min="0" max="99" placeholder="Crime"/>
                                    <label>Crime</label>
                                </label>
                            </div>
                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="diplomacia" type="number" min="0" max="99" placeholder="Diplomacia"/>
                                    <label>Diplomacia</label>
                                </label>
                            </div>

                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="enganacao" type="number" min="0" max="99" placeholder="Enganação"/>
                                    <label>Enganação</label>
                                </label>
                            </div>
                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="fortitude" type="number" min="0" max="99" placeholder="Fortitude"/>
                                    <label>Fortitude</label>
                                </label>
                            </div>
                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="furtividade" type="number" min="0" max="99" placeholder="Furtividade"/>
                                    <label>Furtividade</label>
                                </label>
                            </div>
                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="iniciativa" type="number" min="0" max="99" placeholder="Iniciativa"/>
                                    <label>Iniciativa</label>
                                </label>
                            </div>
                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="intimidacao" type="number" min="0" max="99" placeholder="Intimidação"/>
                                    <label>Intimidação</label>
                                </label>
                            </div>
                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="intuicao" type="number" min="0" max="99" placeholder="Intuição"/>
                                    <label>Intuição</label>
                                </label>
                            </div>
                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="investigacao" type="number" min="0" max="99" placeholder="Investigação"/>
                                    <label>Investigação</label>
                                </label>
                            </div>
                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="luta" type="number" min="0" max="99" placeholder="Luta"/>
                                    <label>Luta</label>
                                </label>
                            </div>

                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="medicina" type="number" min="0" max="99" placeholder="Medicina"/>
                                    <label>Medicina</label>
                                </label>
                            </div>
                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="ocultismo" type="number" min="0" max="99" placeholder="Ocultismo"/>
                                    <label>Ocultismo</label>
                                </label>
                            </div>

                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="percepcao" type="number" min="0" max="99" placeholder="Percepção"/>
                                    <label>Percepção</label>
                                </label>
                            </div>
                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="pilotagem" type="number" min="0" max="99" placeholder="Pilotagem"/>
                                    <label>Pilotagem</label>
                                </label>
                            </div>

                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="pontaria" type="number" min="0" max="99" placeholder="Pontaria"/>
                                    <label>Pontaria</label>
                                </label>
                            </div>
                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="profissao" type="number" min="0" max="99" placeholder="Profissão"/>
                                    <label>Profissão</label>
                                </label>
                            </div>
                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="reflexos" type="number" min="0" max="99" placeholder="Reflexos"/>
                                    <label>Reflexos</label>
                                </label>
                            </div>

                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="religiao" type="number" min="0" max="99" placeholder="Religião"/>
                                    <label>Religião</label>
                                </label>
                            </div>
                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="sobrevivencia" type="number" min="0" max="99" placeholder="Sobrevivência"/>
                                    <label>Sobrevivência</label>
                                </label>
                            </div>

                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="tatica" type="number" min="0" max="99" placeholder="Tática"/>
                                    <label>Tática</label>
                                </label>
                            </div>

                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="tecnologia" type="number" min="0" max="99" placeholder="Tecnologia"/>
                                    <label>Tecnologia</label>
                                </label>
                            </div>
                            <div class="col">
                                <label class="form-floating">
                                    <input class="form-control" name="vontade" type="number" min="0" max="99" placeholder="Vontade"/>
                                    <label>Vontade</label>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-def" role="tabpanel" aria-labelledby="pills-def-tab">
                        <div>
                            <h2 class="my-2">Defesas</h2>
                            <div class="row m-2 g-1 row-cols-1 row-cols-sm-2">
                                <div class="col">
                                    <label class="form-floating">
                                        <input class="form-control" name="passiva" type="number" min="0" max="99" value="0"/>
                                        <label>Passiva</label>
                                    </label>
                                </div>
                                <div class="col">
                                    <label class="form-floating">
                                        <input class="form-control" name="esquiva" type="number" min="0" max="99" value="0"/>
                                        <label>Esquiva</label>
                                    </label>
                                </div>
                            </div>
                            <h2 class="my-2">Resistências</h2>
                            <div class="row m-2 g-1 row-cols-2 row-cols-sm-3 row-cols-lg-4 row-cols-xl-6">
                                <div class="col">
                                    <label class="form-floating">
                                        <input class="form-control" name="morte" type="number" min="0" max="99" placeholder="Morte"/>
                                        <label>Morte</label>
                                    </label>
                                </div>
                                <div class="col">
                                    <label class="form-floating">
                                        <input class="form-control" name="sangue" type="number" min="0" max="99" placeholder="Sangue"/>
                                        <label>Sangue</label>
                                    </label>
                                </div>
                                <div class="col">
                                    <label class="form-floating">
                                        <input class="form-control" name="energia" type="number" min="0" max="99" placeholder="Energia"/>
                                        <label>Energia</label>
                                    </label>
                                </div>
                                <div class="col">
                                    <label class="form-floating">
                                        <input class="form-control" name="conhecimento" type="number" min="0" max="99" placeholder="Conhecimento"/>
                                        <label>Conhecimento</label>
                                    </label>
                                </div>
                                <div class="col">
                                    <label class="form-floating">
                                        <input class="form-control" name="fisica" type="number" min="0" max="99" placeholder="Fisica"/>
                                        <label>Fisica</label>
                                    </label>
                                </div>
                                <div class="col">
                                    <label class="form-floating">
                                        <input class="form-control" name="balistica" type="number" min="0" max="99" placeholder="Balistica"/>
                                        <label>Balistica</label>
                                    </label>
                                </div>
                                <div class="col">
                                    <label class="form-floating">
                                        <input class="form-control" name="mental" type="number" min="0" max="99" placeholder="Mental"/>
                                        <label>Mental</label>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-out" role="tabpanel" aria-labelledby="pills-out-tab">
                        <label class="form-floating m-2">
                            <textarea class="form-control" maxlength="5000" name="ataques" type="text" placeholder="Ataques"></textarea>
                            <label>Ataques</label>
                        </label>
                        <label class="form-floating m-2">
                            <textarea class="form-control" maxlength="5000" name="habilidades" type="text" placeholder="Habilidades"></textarea>
                            <label>Habilidades</label>
                        </label>
                        <label class="form-floating m-2">
                            <textarea class="form-control" maxlength="5000" name="detalhes" type="text" placeholder="Detalhes"></textarea>
                            <label>Detalhes</label>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary">Enviar</button>
                <input type="hidden" name="status" value="addnpc"/>
            </div>
        </form>
    </div>
</div>

<form class="modal" id="editnpc" tabindex="-1" aria-hidden="true" method="post" autocomplete="off">
    <div class="modal-xl modal-dialog modal-dialog-centered">
        <div class="modal-content border-secondary">
            <div class="modal-header">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-edados-tab" data-bs-toggle="pill" data-bs-target="#pills-edados" type="button" role="tab" aria-controls="pills-edados" aria-selected="true">
                            Dados
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-eattr-tab" data-bs-toggle="pill" data-bs-target="#pills-eattr" type="button" role="tab" aria-controls="pills-eattr" aria-selected="false">
                            Atributos
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-eper-tab" data-bs-toggle="pill" data-bs-target="#pills-eper" type="button" role="tab" aria-controls="pills-eper" aria-selected="false">
                            Perícias
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-edef-tab" data-bs-toggle="pill" data-bs-target="#pills-edef" type="button" role="tab" aria-controls="pills-edef" aria-selected="false">
                            Defesas
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-eout-tab" data-bs-toggle="pill" data-bs-target="#pills-eout" type="button" role="tab" aria-controls="pills-eout" aria-selected="false">
                            Outros
                        </button>
                    </li>
                </ul>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pills-edados" role="tabpanel" aria-labelledby="pills-dados-tab">
                        <h2 class="my-2">Principal</h2>
                        <div class="m-2 form-floating">
                            <input id="enome" class="form-control" name="nome" type="text" maxlength="30" value="NPC" required/>
                            <label for="enome">Nome</label>
                            <div class="invalid-feedback">Precisa pelomenos do nome</div>
                        </div>
                        <div class="form-check form-switch m-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="editarmonstro" name="monstro" value="1">
                            <label class="form-check-label" for="editarmonstro">Adicionar ficha como Monstro.</label>
                        </div>
                        <div class="m-2">
                            <label class="fs-4" for="epv">Pontos de Vida</label>
                            <input id="epv" class="form-control " name="pv" type="number" min="1" max="999999999" value="1"/>
                        </div>
                        <div class="m-2">
                            <label class="fs-4" for="esan">Pontos de Sanidade</label>
                            <input id="esan" class="form-control " name="san" type="number" min="0" max="999999999" value="0"/>
                        </div>
                        <div class="m-2">
                            <label class="fs-4" for="epe">Pontos de Esforço</label>
                            <input id="epe" class="form-control " name="pe" type="number" min="0" max="999999999" value="0"/>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-eattr" role="tabpanel" aria-labelledby="pills-eattr-tab">
                        <div id="editattr">
							<?= atributos(0, 0, 0, 0, 0, 1, 1) ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-eper" role="tabpanel" aria-labelledby="pills-eper-tab">
                        <h2 class="my-2">Perícias</h2>
                        <div class="row g-2 m-1 row-cols-2 row-cols-sm-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6">
                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="eacrobacia" class="form-control" name="acrobacia" type="number" min="0" max="99" value="0"/>
                                    <label  for="eacrobacia">Acrobacia:</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="eadestramento" class="form-control" name="adestramento" type="number" min="0" max="99" value="0"/>
                                    <label for="eadestramento">Adestramento:</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="eartes" class="form-control" name="artes" type="number" min="0" max="99" value="0"/>
                                    <label  for="eartes">Artes:</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="eatletismo" class="form-control" name="atletismo" type="number" min="0" max="99" value="0"/>
                                    <label  for="eatletismo">Atletismo:</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="eatualidades" class="form-control" name="atualidades" type="number" min="0" max="99" value="0"/>
                                    <label  for="eatualidades">Atualidades:</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="eciencia" class="form-control" name="ciencia" type="number" min="0" max="99" value="0"/>
                                    <label  for="eciencia">Ciências:</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="ecrime" class="form-control" name="crime" type="number" min="0" max="99" value="0"/>
                                    <label  for="ecrime">Crime:</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="ediplomacia" class="form-control" name="diplomacia" type="number" min="0" max="99" value="0"/>
                                    <label  for="ediplomacia">Diplomacia:</label>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="eenganacao" class="form-control" name="enganacao" type="number" min="0" max="99" value="0"/>
                                    <label  for="eenganacao">Enganação:</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="efortitude" class="form-control" name="fortitude" type="number" min="0" max="99" value="0"/>
                                    <label  for="efortitude">Fortitude:</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="efurtividade" class="form-control" name="furtividade" type="number" min="0" max="99" value="0"/>
                                    <label  for="efurtividade">Furtividade:</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="einiciativ" class="form-control" name="iniciativa" type="number" min="0" max="99" value="0"/>
                                    <label  for="einiciativ">Iniciativa:</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="eintimidacao" class="form-control" name="intimidacao" type="number" min="0" max="99" value="0"/>
                                    <label  for="eintimidacao">Intimidação:</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="eintuicao" class="form-control" name="intuicao" type="number" min="0" max="99" value="0"/>
                                    <label  for="eintuicao">Intuição:</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="einvestigacao" class="form-control" name="investigacao" type="number" min="0" max="99" value="0"/>
                                    <label  for="einvestigacao">Investigação:</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="eluta" class="form-control" name="luta" type="number" min="0" max="99" value="0"/>
                                    <label  for="eluta">Luta:</label>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="emedicina" class="form-control" name="medicina" type="number" min="0" max="99" value="0"/>
                                    <label  for="emedicina">Medicina:</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="eocultismo" class="form-control" name="ocultismo" type="number" min="0" max="99" value="0"/>
                                    <label  for="eocultismo">Ocultismo:</label>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="epercepcao" class="form-control" name="percepcao" type="number" min="0" max="99" value="0"/>
                                    <label  for="epercepcao">Percepção:</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="epilotagem" class="form-control" name="pilotagem" type="number" min="0" max="99" value="0"/>
                                    <label  for="epilotagem">Pilotagem:</label>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="epontaria" class="form-control" name="pontaria" type="number" min="0" max="99" value="0"/>
                                    <label  for="epontaria">Pontaria:</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="eprofissao" class="form-control" name="profissao" type="number" min="0" max="99" value="0"/>
                                    <label  for="eprofissao">Profissão:</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="ereflexos" class="form-control" name="reflexos" type="number" min="0" max="99" value="0"/>
                                    <label  for="ereflexos">Reflexos:</label>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="ereligiao" class="form-control" name="religiao" type="number" min="0" max="99" value="0"/>
                                    <label  for="ereligiao">Religião:</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="esobrevivencia" class="form-control" name="sobrevivencia" type="number" min="0" max="99" value="0"/>
                                    <label  for="esobrevivencia">Sobrevivência:</label>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="etatica" class="form-control" name="tatica" type="number" min="0" max="99" value="0"/>
                                    <label  for="etatica">Tática:</label>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="etecnologia" class="form-control" name="tecnologia" type="number" min="0" max="99" value="0"/>
                                    <label  for="etecnologia">Tecnologia</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-floating">
                                    <input id="evontade" class="form-control" name="vontade" type="number" min="0" max="99" value="0"/>
                                    <label  for="evontade">Vontade</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-edef" role="tabpanel" aria-labelledby="pills-def-tab">
                        <div>
                            <h2 class="my-2">Defesas</h2>
                            <div class="m-2">
                                <label class="fs-4" for="epassiva">Passiva</label>
                                <input id="epassiva" class="form-control " name="passiva" type="number" min="0" max="99" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="eesquiva">Esquiva</label>
                                <input id="eesquiva" class="form-control " name="esquiva" type="number" min="0" max="99" value="0"/>
                            </div>
                            <h2 class="my-2">Resistências</h2>
                            <div class="m-2">
                                <label class="fs-4" for="emorte">Morte</label>
                                <input id="emorte" class="form-control " name="morte" type="number" min="0" max="99" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="esangue">Sangue</label>
                                <input id="esangue" class="form-control " name="sangue" type="number" min="0" max="99" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="eenergia">Energia</label>
                                <input id="eenergia" class="form-control " name="energia" type="number" min="0" max="99" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="econhecimento">Conhecimento</label>
                                <input id="econhecimento" class="form-control " name="conhecimento" type="number" min="0" max="99" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="efisica">Fisica</label>
                                <input id="efisica" class="form-control " name="fisica" type="number" min="0" max="99" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="ebalistica">Balistica</label>
                                <input id="ebalistica" class="form-control " name="balistica" type="number" min="0" max="99" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="emental">Mental</label>
                                <input id="emental" class="form-control " name="mental" type="number" min="0" max="99" value="0"/>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-eout" role="tabpanel" aria-labelledby="pills-out-tab">
                        <div class="m-2 form-floating">
                            <textarea class="form-control" maxlength="5000" id="eataque" name="ataques" type="text" placeholder="Ataques"></textarea>
                            <label for="eataque">Ataques</label>
                        </div>
                        <div class="m-2 form-floating">
                            <textarea class="form-control" maxlength="5000" id="ehabilidades" name="habilidades" type="text" placeholder="Habilidades"></textarea>
                            <label for="ehabilidades">Habilidades</label>
                        </div>
                        <div class="m-2 form-floating">
                            <textarea class="form-control" maxlength="5000" id="edetalhes" name="detalhes" type="text" placeholder="Detalhes"></textarea>
                            <label for="edetalhes">Detalhes</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary">Enviar</button>
                <input type="hidden" name="status" value="editnpc"/>
                <input type="hidden" id='efni' name="efni" value=""/>
            </div>
        </div>
    </div>
</form>