<!-- Modal Rituais-->
<div class="modal fade" id="addritual" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-lg modal-dialog">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" id="formaddritual">
                <div class="text-center"><h2>Adicionar Ritual.</h2></div>
                <div class="container-fluid my-2">
                    <div class="m-2">
                        <label for="fotosimbolo" class="fs-4 fw-bold">Foto do ritual</label>
                        <select class="form-select bg-black text-light border-light" id="fotosimbolo" name="foto">
                            <option value="1" selected>Desconhecido</option>
                            <option value="2">Customizada</option>
                            <option value="1" disabled>---------Rituais da Wiki---------</option>
                            <option value="3">Amaldiçoar tecnologias</option>
                            <option value="4">Assombração Forçada</option>
                            <option value="5">Carmuflagem</option>
                            <option value="6">Cicatrização Acelerada</option>
                            <option value="7">Coincidência Forçada</option>
                            <option value="8">Compressão Paranormal</option>
                            <option value="9">Comunicação com Espiritos</option>
                            <option value="10">Dama de Sangue</option>
                            <option value="11">Decadenzia</option>
                            <option value="12">Derreter criaturas de sangue</option>
                            <option value="13">Descarnar</option>
                            <option value="14">Destruição</option>
                            <option value="15">Dissipar espíritos</option>
                            <option value="16">Cinerária (Invocar Névoa)</option>
                            <option value="17">Leitura psiquica</option>
                            <option value="18">Ódio Incontrolavel</option>
                            <option value="19">Papel Graduação(?)</option>
                            <option value="20">Paralisia Anormal</option>
                            <option value="21">Passagem de Conhecimento</option>
                            <option value="22">Pavor Anormal</option>
                            <option value="23">Reação</option>
                            <option value="24">Espelho</option>
                            <option value="25">Sentir Através</option>
                            <option value="26">Sugada Mortal</option>
                            <option value="27">Transcender</option>
                        </select>
                    </div>
                    <div class="m-2" id="divfotosimbolourl" style="display: none;">
                        <label for="simbolourl" class="fs-4 fw-bold">Link da imagem</label>
                        <input id="simbolourl" maxlength="<?=$Fich_fotos?>" class="form-control bg-black text-light border-light" name="simbolourl"
                               type="url" required disabled/>
                        <div class="invalid-feedback">A Imagem precisa ser valida.</div>
                    </div>
                    <div class="col text-center">
                        <div id="prevsimbolo">
                            <img src="/assets/img/desconhecido.png" width="200" height="200" alt="Ritual">
                        </div>
                        <div id="warningsimbolo"></div>
                        <div class="container-fluid">
                            <div class="input-group m-1">
                                <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                       for="arname">Ritual:</label>
                                <input type="text" class="form-control bg-black text-white border-start-0" id="arname"
                                       maxlength="<?=$Ritu_nome?>"  name="ritual"/>
                            </div>
                            <div class="input-group m-1">
                                <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                       for="arele">Elemento:</label>
                                <input type="text" class="form-control bg-black text-white border-start-0" id="arele"
                                       maxlength="<?=$Ritu_elem?>"  name="elemento"/>
                            </div>
                            <div class="input-group m-1">
                                <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                       for="arcir">Circulo:</label>
                                <input type="text" class="form-control bg-black text-white border-start-0" id="arcir"
                                       maxlength="<?=$Ritu_circ?>"  name="circulo"/>
                            </div>
                            <div class="input-group m-1">
                                <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                       for="arcon">Execução:</label>
                                <input type="text" class="form-control bg-black text-white border-start-0" id="arcon"
                                       maxlength="<?=$Ritu_conj?>"  name="conjuracao"/>
                            </div>
                            <div class="input-group m-1">
                                <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                       for="aralc">Alcance:</label>
                                <input type="text" class="form-control bg-black text-white border-start-0" id="aralc"
                                       maxlength="<?=$Ritu_alca?>"  name="alcance"/>
                            </div>
                            <div class="input-group m-1">
                                <label class="input-group-text input-group-sm bg-black text-white border-end-0"
                                       for="aralv">Alvo:</label>
                                <input type="text" class="form-control bg-black text-white border-start-0" id="aralv"
                                       maxlength="<?=$Ritu_alvo?>"  name="alvo"/>
                            </div>
                            <div class="input-group m-1">
                                <label class="input-group-text input-group-sm bg-black text-white border-end-0" for="ardur">Duração:</label>
                                <input type="text"  maxlength="<?=$Ritu_dura?>" class="form-control bg-black text-white border-start-0" id="ardur" name="duracao"/>
                            </div>
                            <div class="input-group m-1">
                                <label class="input-group-text input-group-sm bg-black text-white border-end-0" for="ard1">Dano 1:</label>
                                <input type="text" maxlength="<?=$Ritu_dan1?>" class="form-control bg-black text-white border-start-0" id="ard1" name="dano1" placeholder="2d8+4"/>
                            </div>
                            <div class="input-group m-1">
                                <label class="input-group-text input-group-sm bg-black text-white border-end-0" for="ard2">Dano 2:</label>
                                <input type="text"  maxlength="<?=$Ritu_dan2?>" class="form-control bg-black text-white border-start-0" id="ard2" name="dano2" placeholder="1d8+4"/>
                            </div>
                            <label class="fs-4" for="arefe">Descrição: (coloque também o que estiver a faltar acima.)</label>
                            <textarea id="arefe" name="efeito" class="form-control form-control-sm bg-black text-white"></textarea>
                        </div>
                    </div>
                </div>
                <div class="clearfix">
                    <input name="status" value="addritual" type="hidden"/>
                    <button type="button" class="btn btn-danger float-start" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success float-end" value="submit">Criar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Rituais-->
<div class="modal fade" id="editritual" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-fullscreen modal-dialog">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" id="formeditritual" autocomplete="off">
                <div class="text-center"><h2>Editar Rituais.</h2></div>
                <div class="container-fluid my-2 row">
                    <?php
                    foreach ($s[6] as $r):?>
                        <div class="col-md-6">
                            <div class="m-4">
                                <div class="teedfa" id="aff<?=$r["id"]?>">
                                    <div class="m-2">
                                        <label for="fotosimbolo<?= $r["id,"] ?>" class="fs-4 fw-bold ">Foto do
                                            ritual</label>
                                        <select class="form-select bg-black text-light border-light fotosimbolo" id="fotosimbolo<?= $r["id"] ?>" name="foto[]">
                                            <option value="1" <?= (intval($r["foto"]) <= 2) ? "selected" : "" ?>>Desconhecido</option>
                                            <option value="2" <?= (intval($r["foto"]) >= 2) ? "" : "selected" ?>>Customizada</option>
                                            <option value="1" disabled>---------Rituais da Wiki---------</option>
                                            <option value="3">Amaldiçoar tecnologias</option>
                                            <option value="4">Assombração Forçada</option>
                                            <option value="5">Carmuflagem</option>
                                            <option value="6">Cicatrização Acelerada</option>
                                            <option value="7">Coincidência Forçada</option>
                                            <option value="8">Compressão Paranormal</option>
                                            <option value="9">Comunicação com Espiritos</option>
                                            <option value="10">Dama de Sangue</option>
                                            <option value="11">Decadenzia</option>
                                            <option value="12">Derreter criaturas de sangue</option>
                                            <option value="13">Descarnar</option>
                                            <option value="14">Destruição</option>
                                            <option value="15">Dissipar espíritos</option>
                                            <option value="16">Cinerária (Invocar Névoa)</option>
                                            <option value="17">Leitura psiquica</option>
                                            <option value="18">Ódio Incontrolavel</option>
                                            <option value="19">Papel Graduação(?)</option>
                                            <option value="20">Paralisia Anormal</option>
                                            <option value="21">Passagem de Conhecimento</option>
                                            <option value="22">Pavor Anormal</option>
                                            <option value="23">Reação</option>
                                            <option value="24">Espelho</option>
                                            <option value="25">Sentir Através</option>
                                            <option value="26">Sugada Mortal</option>
                                            <option value="27">Transcender</option>
                                        </select>
                                    </div>
                                    <div class="m-2 divfotosimbolourl" <?= intval($r["foto"]) ? "style='display: none;'" : "" ?>>
                                        <label for="simbolourl<?= $r["id"] ?>" class="fs-4 fw-bold">Link da
                                            imagem</label>
                                        <input id="simbolourl<?= $r["id"] ?>" maxlength="<?=$Fich_fotos?>" class="form-control bg-black text-light border-light simbolourl" name="simbolourl[<?=$r["id"]?>]" value="<?=$r["foto"]?>" type="url" required <?= intval($r["foto"]) ? "disabled" : "" ?>/>
                                        <div class="invalid-feedback">A Imagem precisa ser valida.</div>
                                    </div>
                                    <div class="col text-center">
                                        <div class="prevsimbolo">
                                            <img src="/assets/img/desconhecido.png" width="200" height="200" alt="Ritual">
                                        </div>
                                        <div class="warningsimbolo"></div>
                                    </div>
                                </div>
                                <div class="input-group m-1">
                                    <label class="input-group-text input-group-sm bg-black text-white border-end-0" for="arname<?= $r["id"] ?>">Ritual:</label>
                                    <input required maxlength="<?=$Ritu_nome?>" type="text" class="form-control bg-black text-white border-start-0" id="arname<?= $r["id"] ?>" name="ritual[]" value="<?= $r["nome"] ?>"/>
                                </div>
                                <div class="input-group m-1">
                                    <label class="input-group-text input-group-sm bg-black text-white border-end-0" for="arele<?= $r["id"] ?>">Elemento:</label>
                                    <input type="text" maxlength="<?=$Ritu_elem?>" class="form-control bg-black text-white border-start-0" id="arele<?= $r["id"] ?>" name="elemento[]" value="<?= $r["elemento"] ?>"/>
                                </div>
                                <div class="input-group m-1">
                                    <label class="input-group-text input-group-sm bg-black text-white border-end-0" for="arcir<?= $r["id"] ?>">Circulo:</label>
                                    <input type="text" maxlength="<?=$Ritu_circ?>" class="form-control bg-black text-white border-start-0" id="arcir<?= $r["id"] ?>" name="circulo[]" value="<?= $r["circulo"] ?>"/>
                                </div>
                                <div class="input-group m-1">
                                    <label class="input-group-text input-group-sm bg-black text-white border-end-0" for="arcon<?= $r["id"] ?>">Execução:</label>
                                    <input type="text" maxlength="<?=$Ritu_conj?>" class="form-control bg-black text-white border-start-0" id="arcon<?= $r["id"] ?>" name="conjuracao[]" value="<?= $r["conjuracao"] ?>"/>
                                </div>
                                <div class="input-group m-1">
                                    <label class="input-group-text input-group-sm bg-black text-white border-end-0" for="aralc<?= $r["id"] ?>">Alcance:</label>
                                    <input type="text" maxlength="<?=$Ritu_alca?>" class="form-control bg-black text-white border-start-0" id="aralc<?= $r["id"] ?>" name="alcance[]" value="<?= $r["alcance"] ?>"/>
                                </div>
                                <div class="input-group m-1">
                                    <label class="input-group-text input-group-sm bg-black text-white border-end-0" for="aralv<?= $r["id"] ?>">Alvo:</label>
                                    <input type="text" maxlength="<?=$Ritu_alvo?>" class="form-control bg-black text-white border-start-0" id="aralv<?= $r["id"] ?>" name="alvo[]" value="<?= $r["alvo"] ?>"/>
                                </div>
                                <div class="input-group m-1">
                                    <label class="input-group-text input-group-sm bg-black text-white border-end-0" for="ardur<?= $r["id"] ?>">Duração:</label>
                                    <input type="text" maxlength="<?=$Ritu_dura?>" class="form-control bg-black text-white border-start-0" id="ardur<?= $r["id"] ?>" name="duracao[]" value="<?= $r["duracao"] ?>"/>
                                </div>
                                <div class="input-group m-1">
                                    <label class="input-group-text input-group-sm bg-black text-white border-end-0" for="eard1<?= $r["id"] ?>">Dano 1:</label>
                                    <input type="text" maxlength="<?=$Ritu_dan1?>" class="form-control bg-black text-white border-start-0" id="eard1<?= $r["id"] ?>" name="dano1[]" value="<?= $r["dano"] ?>" placeholder="2d8+4"/>
                                </div>
                                <div class="input-group m-1">
                                    <label class="input-group-text input-group-sm bg-black text-white border-end-0" for="eard2<?= $r["id"] ?>">Dano 2:</label>
                                    <input type="text" maxlength="<?=$Ritu_dan2?>" class="form-control bg-black text-white border-start-0" id="eard2<?= $r["id"] ?>" name="dano2[]" value="<?= $r["dano2"] ?>" placeholder="1d8+4"/>
                                </div>
                                <div class="m-1">
                                    <label class="fs-4" for="arefe<?= $r["id"] ?>">Descrição:</label>
                                    <textarea required id="arefe<?= $r["id"] ?>" maxlength="<?=$Ritu_efei?>" name="desc[]" class="form-control form-control-sm bg-black text-white"><?= $r["efeito"] ?></textarea>
                                </div>
                            </div>
                        </div>
                        <input name="did[]" value="<?=$r["id"]?>" type="hidden"/>
                    <?php endforeach; ?>
                </div>
                <div class="clearfix">
                    <input name="status" value="editritual" type="hidden"/>
                    <button type="button" class="btn btn-danger float-start" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success float-end" value="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
