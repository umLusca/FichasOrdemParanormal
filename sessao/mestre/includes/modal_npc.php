<div class="modal" id="addnpc" tabindex="-1" aria-hidden="true">
    <div class="modal-xl modal-dialog modal-dialog-centered">
        <form class="modal-content bg-black border-light" id="formaddnpc" method="post" autocomplete="off">
            <div class="modal-header">
                <ul class="nav nav-pills mb-3 row justify-content-center" id="pills-tab" role="tablist">
                    <li class="nav-item col-auto" role="presentation">
                        <button class="nav-link active" id="pills-dados-tab" data-bs-toggle="pill" data-bs-target="#pills-dados" type="button" role="tab" aria-controls="pills-dados" aria-selected="true">Dados</button>
                    </li>
                    <li class="nav-item col-auto" role="presentation">
                        <button class="nav-link" id="pills-attr-tab" data-bs-toggle="pill" data-bs-target="#pills-attr" type="button" role="tab" aria-controls="pills-attr" aria-selected="false">Atributos</button>
                    </li>
                    <li class="nav-item col-auto" role="presentation">
                        <button class="nav-link" id="pills-per-tab" data-bs-toggle="pill" data-bs-target="#pills-per" type="button" role="tab" aria-controls="pills-per" aria-selected="false">Perícias</button>
                    </li>
                    <li class="nav-item col-auto" role="presentation">
                        <button class="nav-link" id="pills-def-tab" data-bs-toggle="pill" data-bs-target="#pills-def" type="button" role="tab" aria-controls="pills-def" aria-selected="false">Defesas</button>
                    </li>
                    <li class="nav-item col-auto" role="presentation">
                        <button class="nav-link" id="pills-out-tab" data-bs-toggle="pill" data-bs-target="#pills-out" type="button" role="tab" aria-controls="pills-out" aria-selected="false">Outros</button>
                    </li>
                </ul>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-dados" role="tabpanel" aria-labelledby="pills-dados-tab">
                        <h2 class="my-2">Principal</h2>
                        <div class="m-2">
                            <label class="fs-4" for="nome">Nome</label>
                            <input id="nome" class="form-control bg-black text-light" name="nome" type="text" maxlength="30" value="NPC" required/>

                            <div class="invalid-feedback">Precisa pelomenos do nome</div>
                        </div>
                        <div class="form-check form-switch m-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="adicionarmonstro" name="monstro" value="1">
                            <label class="form-check-label" for="adicionarmonstro">Adicionar ficha como Monstro.</label>
                        </div>
                        <div class="m-2">
                            <label class="fs-4" for="pv">Pontos de Vida</label>
                            <input id="pv" class="form-control bg-black text-light" name="pv" type="number" min="<?=$PV_minima_npc?>" max="<?=$PV_maxima_npc;?>" value="1"/>
                        </div>
                        <div class="m-2">
                            <label class="fs-4" for="san">Pontos de Sanidade</label>
                            <input id="san" class="form-control bg-black text-light" name="san" type="number" min="<?=$SAN_minima_npc?>" max="<?=$SAN_maxima_npc?>" value="0"/>
                        </div>
                        <div class="m-2">
                            <label class="fs-4" for="pe">Pontos de Esforço</label>
                            <input id="pe" class="form-control bg-black text-light" name="pe" type="number" min="<?=$SAN_minima_npc?>" max="<?=$PE_maxima_npc?>" value="0"/>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-attr" role="tabpanel" aria-labelledby="pills-attr-tab">
                        <div class="containera text-white">
                            <?=atributos(0,0,0,0,0,1,1)?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-per" role="tabpanel" aria-labelledby="pills-per-tab">
                        <h2 class="my-2">Perícias</h2>
                        <div class="row g-2 m-2">
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="acrobacia">Acrobacia:</label>
                                    <input id="acrobacia" class="input-group-text bg-black text-light" name="acrobacia" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="adestramento">Adestramento:</label>
                                    <input id="adestramento" class="input-group-text bg-black text-light" name="adestramento" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="artes">Artes:</label>
                                    <input id="artes" class="input-group-text bg-black text-light" name="artes" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="atletismo">Atletismo:</label>
                                    <input id="atletismo" class="input-group-text bg-black text-light" name="atletismo" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="atualidades">Atualidades:</label>
                                    <input id="atualidades" class="input-group-text bg-black text-light" name="atualidades" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="ciencia">Ciências:</label>
                                    <input id="ciencia" class="input-group-text bg-black text-light" name="ciencia" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="crime">Crime:</label>
                                    <input id="crime" class="input-group-text bg-black text-light" name="crime" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="diplomacia">Diplomacia:</label>
                                    <input id="diplomacia" class="input-group-text bg-black text-light" name="diplomacia" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="enganacao">Enganação:</label>
                                    <input id="enganacao" class="input-group-text bg-black text-light" name="enganacao" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="fortitude">Fortitude:</label>
                                    <input id="fortitude" class="input-group-text bg-black text-light" name="fortitude" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="furtividade">Furtividade:</label>
                                    <input id="furtividade" class="input-group-text bg-black text-light" name="furtividade" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="iniciativ">Iniciativa:</label>
                                    <input id="iniciativ" class="input-group-text bg-black text-light" name="iniciativa" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="intimidacao">Intimidação:</label>
                                    <input id="intimidacao" class="input-group-text bg-black text-light" name="intimidacao" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="intuicao">Intuição:</label>
                                    <input id="intuicao" class="input-group-text bg-black text-light" name="intuicao" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="investigacao">Investigação:</label>
                                    <input id="investigacao" class="input-group-text bg-black text-light" name="investigacao" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="luta">Luta:</label>
                                    <input id="luta" class="input-group-text bg-black text-light" name="luta" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="medicina">Medicina:</label>
                                    <input id="medicina" class="input-group-text bg-black text-light" name="medicina" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="ocultismo">Ocultismo:</label>
                                    <input id="ocultismo" class="input-group-text bg-black text-light" name="ocultismo" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="percepcao">Percepção:</label>
                                    <input id="percepcao" class="input-group-text bg-black text-light" name="percepcao" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="pilotagem">Pilotagem:</label>
                                    <input id="pilotagem" class="input-group-text bg-black text-light" name="pilotagem" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="pontaria">Pontaria:</label>
                                    <input id="pontaria" class="input-group-text bg-black text-light" name="pontaria" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="profissao">Profissão:</label>
                                    <input id="profissao" class="input-group-text bg-black text-light" name="profissao" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="reflexos">Reflexos:</label>
                                    <input id="reflexos" class="input-group-text bg-black text-light" name="reflexos" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="religiao">Religião:</label>
                                    <input id="religiao" class="input-group-text bg-black text-light" name="religiao" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="sobrevivencia">Sobrevivência:</label>
                                    <input id="sobrevivencia" class="input-group-text bg-black text-light" name="sobrevivencia" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="tatica">Tática:</label>
                                    <input id="tatica" class="input-group-text bg-black text-light" name="tatica" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="tecnologia">Tecnologia:</label>
                                    <input id="tecnologia" class="input-group-text bg-black text-light" name="tecnologia" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="vontade">Vontade:</label>
                                    <input id="vontade" class="input-group-text bg-black text-light" name="vontade" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-def" role="tabpanel" aria-labelledby="pills-def-tab">
                        <div>
                            <h2 class="my-2">Defesas</h2>
                            <div class="m-2">
                                <label class="fs-4" for="passiva">Passiva</label>
                                <input id="passiva" class="form-control bg-black text-light" name="passiva" type="number" min="0" max="99" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="esquiva">Esquiva</label>
                                <input id="esquiva" class="form-control bg-black text-light" name="esquiva" type="number" min="0" max="99" value="0"/>
                            </div>
                            <h2 class="my-2">Resistências</h2>
                            <div class="m-2">
                                <label class="fs-4" for="morte">Morte</label>
                                <input id="morte" class="form-control bg-black text-light" name="morte" type="number" min="0" max="99" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="sangue">Sangue</label>
                                <input id="sangue" class="form-control bg-black text-light" name="sangue" type="number" min="0" max="99" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="energia">Energia</label>
                                <input id="energia" class="form-control bg-black text-light" name="energia" type="number" min="0" max="99" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="conhecimento">Conhecimento</label>
                                <input id="conhecimento" class="form-control bg-black text-light" name="conhecimento" type="number" min="0" max="99" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="fisica">Fisica</label>
                                <input id="fisica" class="form-control bg-black text-light" name="fisica" type="number" min="0" max="99" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="balistica">Balistica</label>
                                <input id="balistica" class="form-control bg-black text-light" name="balistica" type="number" min="0" max="99" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="mental">Mental</label>
                                <input id="mental" class="form-control bg-black text-light" name="mental" type="number" min="0" max="99" value="0"/>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-out" role="tabpanel" aria-labelledby="pills-out-tab">
                        <div class="m-2">
                            <label class="fs-4" for="ataque">Ataques</label><br>
                            <textarea class="w-100 bg-black text-light" id="ataque" maxlength="5000" name="ataques" type="text"></textarea>
                        </div>
                        <div class="m-2">
                            <label class="fs-4" for="habilidades">Habilidades</label><br>
                            <textarea class="w-100 bg-black text-light" id="habilidades" maxlength="5000" name="habilidades" type="text"></textarea>
                        </div>
                        <div class="m-2">
                            <label class="fs-4" for="detalhes">Detalhes</label><br>
                            <textarea class="w-100 bg-black text-light" id="detalhes" maxlength="5000" name="detalhes" type="text"></textarea>
                        </div>
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


<div class="modal" id="editnpc" tabindex="-1" aria-hidden="true">
    <div class="modal-xl modal-dialog modal-dialog-centered">
        <form class="modal-content bg-black border-light" id="" method="post" autocomplete="off">
            <div class="modal-header">
                <ul class="nav nav-pills mb-3 row justify-content-center" role="tablist">
                    <li class="nav-item col-auto" role="presentation">
                        <button class="nav-link active" id="pills-edados-tab" data-bs-toggle="pill" data-bs-target="#pills-edados" type="button" role="tab" aria-controls="pills-edados" aria-selected="true">Dados</button>
                    </li>
                    <li class="nav-item col-auto" role="presentation">
                        <button class="nav-link" id="pills-eattr-tab" data-bs-toggle="pill" data-bs-target="#pills-eattr" type="button" role="tab" aria-controls="pills-eattr" aria-selected="false">Atributos</button>
                    </li>
                    <li class="nav-item col-auto" role="presentation">
                        <button class="nav-link" id="pills-eper-tab" data-bs-toggle="pill" data-bs-target="#pills-eper" type="button" role="tab" aria-controls="pills-eper" aria-selected="false">Perícias</button>
                    </li>
                    <li class="nav-item col-auto" role="presentation">
                        <button class="nav-link" id="pills-edef-tab" data-bs-toggle="pill" data-bs-target="#pills-edef" type="button" role="tab" aria-controls="pills-edef" aria-selected="false">Defesas</button>
                    </li>
                    <li class="nav-item col-auto" role="presentation">
                        <button class="nav-link" id="pills-eout-tab" data-bs-toggle="pill" data-bs-target="#pills-eout" type="button" role="tab" aria-controls="pills-eout" aria-selected="false">Outros</button>
                    </li>
                </ul>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pills-edados" role="tabpanel" aria-labelledby="pills-dados-tab">
                        <h2 class="my-2">Principal</h2>
                        <div class="m-2">
                            <label class="fs-4" for="enome">Nome</label>
                            <input id="enome" class="form-control bg-black text-light" name="nome" type="text" maxlength="30" value="NPC" required/>
                            <div class="invalid-feedback">Precisa pelomenos do nome</div>
                        </div>
                        <div class="form-check form-switch m-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="editarmonstro" name="monstro" value="1">
                            <label class="form-check-label" for="editarmonstro">Adicionar ficha como Monstro.</label>
                        </div>
                        <div class="m-2">
                            <label class="fs-4" for="epv">Pontos de Vida</label>
                            <input id="epv" class="form-control bg-black text-light" name="pv" type="number" min="1" max="999999999" value="1"/>
                        </div>
                        <div class="m-2">
                            <label class="fs-4" for="esan">Pontos de Sanidade</label>
                            <input id="esan" class="form-control bg-black text-light" name="san" type="number" min="0" max="999999999" value="0"/>
                        </div>
                        <div class="m-2">
                            <label class="fs-4" for="epe">Pontos de Esforço</label>
                            <input id="epe" class="form-control bg-black text-light" name="pe" type="number" min="0" max="999999999" value="0"/>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-eattr" role="tabpanel" aria-labelledby="pills-eattr-tab">
                        <div class="containera text-white" id="editattr">
	                        <?=atributos(0,0,0,0,0,1,1)?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-eper" role="tabpanel" aria-labelledby="pills-eper-tab">
                        <h2 class="my-2">Perícias</h2>
                        <div class="row g-2 m-2">
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="eacrobacia">Acrobacia:</label>
                                    <input id="eacrobacia" class="input-group-text bg-black text-light" name="acrobacia" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="adestramento">Adestramento:</label>
                                    <input id="eadestramento" class="input-group-text bg-black text-light" name="adestramento" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="eartes">Artes:</label>
                                    <input id="eartes" class="input-group-text bg-black text-light" name="artes" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="eatletismo">Atletismo:</label>
                                    <input id="eatletismo" class="input-group-text bg-black text-light" name="atletismo" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="eatualidades">Atualidades:</label>
                                    <input id="eatualidades" class="input-group-text bg-black text-light" name="atualidades" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="eciencia">Ciências:</label>
                                    <input id="eciencia" class="input-group-text bg-black text-light" name="ciencia" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="ecrime">Crime:</label>
                                    <input id="ecrime" class="input-group-text bg-black text-light" name="crime" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="ediplomacia">Diplomacia:</label>
                                    <input id="ediplomacia" class="input-group-text bg-black text-light" name="diplomacia" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="eenganacao">Enganação:</label>
                                    <input id="eenganacao" class="input-group-text bg-black text-light" name="enganacao" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="efortitude">Fortitude:</label>
                                    <input id="efortitude" class="input-group-text bg-black text-light" name="fortitude" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="efurtividade">Furtividade:</label>
                                    <input id="efurtividade" class="input-group-text bg-black text-light" name="furtividade" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="einiciativ">Iniciativa:</label>
                                    <input id="einiciativ" class="input-group-text bg-black text-light" name="iniciativa" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="eintimidacao">Intimidação:</label>
                                    <input id="eintimidacao" class="input-group-text bg-black text-light" name="intimidacao" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="eintuicao">Intuição:</label>
                                    <input id="eintuicao" class="input-group-text bg-black text-light" name="intuicao" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="einvestigacao">Investigação:</label>
                                    <input id="einvestigacao" class="input-group-text bg-black text-light" name="investigacao" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="eluta">Luta:</label>
                                    <input id="eluta" class="input-group-text bg-black text-light" name="luta" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="emedicina">Medicina:</label>
                                    <input id="emedicina" class="input-group-text bg-black text-light" name="medicina" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="eocultismo">Ocultismo:</label>
                                    <input id="eocultismo" class="input-group-text bg-black text-light" name="ocultismo" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="epercepcao">Percepção:</label>
                                    <input id="epercepcao" class="input-group-text bg-black text-light" name="percepcao" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="epilotagem">Pilotagem:</label>
                                    <input id="epilotagem" class="input-group-text bg-black text-light" name="pilotagem" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="epontaria">Pontaria:</label>
                                    <input id="epontaria" class="input-group-text bg-black text-light" name="pontaria" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="eprofissao">Profissão:</label>
                                    <input id="eprofissao" class="input-group-text bg-black text-light" name="profissao" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="ereflexos">Reflexos:</label>
                                    <input id="ereflexos" class="input-group-text bg-black text-light" name="reflexos" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="ereligiao">Religião:</label>
                                    <input id="ereligiao" class="input-group-text bg-black text-light" name="religiao" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="esobrevivencia">Sobrevivência:</label>
                                    <input id="esobrevivencia" class="input-group-text bg-black text-light" name="sobrevivencia" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="etatica">Tática:</label>
                                    <input id="etatica" class="input-group-text bg-black text-light" name="tatica" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="etecnologia">Tecnologia:</label>
                                    <input id="etecnologia" class="input-group-text bg-black text-light" name="tecnologia" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text bg-black text-light" for="evontade">Vontade:</label>
                                    <input id="evontade" class="input-group-text bg-black text-light" name="vontade" type="number" min="0" max="99" value="0"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-edef" role="tabpanel" aria-labelledby="pills-def-tab">
                        <div>
                            <h2 class="my-2">Defesas</h2>
                            <div class="m-2">
                                <label class="fs-4" for="epassiva">Passiva</label>
                                <input id="epassiva" class="form-control bg-black text-light" name="passiva" type="number" min="0" max="99" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="eesquiva">Esquiva</label>
                                <input id="eesquiva" class="form-control bg-black text-light" name="esquiva" type="number" min="0" max="99" value="0"/>
                            </div>
                            <h2 class="my-2">Resistências</h2>
                            <div class="m-2">
                                <label class="fs-4" for="emorte">Morte</label>
                                <input id="emorte" class="form-control bg-black text-light" name="morte" type="number" min="0" max="99" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="esangue">Sangue</label>
                                <input id="esangue" class="form-control bg-black text-light" name="sangue" type="number" min="0" max="99" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="eenergia">Energia</label>
                                <input id="eenergia" class="form-control bg-black text-light" name="energia" type="number" min="0" max="99" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="econhecimento">Conhecimento</label>
                                <input id="econhecimento" class="form-control bg-black text-light" name="conhecimento" type="number" min="0" max="99" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="efisica">Fisica</label>
                                <input id="efisica" class="form-control bg-black text-light" name="fisica" type="number" min="0" max="99" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="ebalistica">Balistica</label>
                                <input id="ebalistica" class="form-control bg-black text-light" name="balistica" type="number" min="0" max="99" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="emental">Mental</label>
                                <input id="emental" class="form-control bg-black text-light" name="mental" type="number" min="0" max="99" value="0"/>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-eout" role="tabpanel" aria-labelledby="pills-out-tab">
                        <div class="m-2">
                            <label class="fs-4" for="eataque">Ataques</label>
                            <textarea class="w-100 bg-black text-light" maxlength="5000" id="eataque" name="ataques" type="text"></textarea>
                        </div>
                        <div class="m-2">
                            <label class="fs-4" for="ehabilidades">Habilidades</label>
                            <textarea class="w-100 bg-black text-light" maxlength="5000" id="ehabilidades" name="habilidades" type="text"></textarea>
                        </div>
                        <div class="m-2">
                            <label class="fs-4" for="edetalhes">Detalhes</label>
                            <textarea class="w-100 bg-black text-light" maxlength="5000" id="edetalhes" name="detalhes" type="text"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary">Enviar</button>
                <input type="hidden" name="status" value="editnpc"/>
                <input type="hidden" id='efni' name="efni" value=""/>
            </div>
        </form>
    </div>
</div>