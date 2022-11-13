<!-- Modal Rituais-->
<div class="modal fade" id="addritual" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-xl modal-dialog modal-fullscreen-md-down">
        <div class="modal-content bg-black border-light">
            <div class="modal-header">
                <h3 class="modal-title">Adicionar Ritual.</h3>
                <button class="btn-close btn-close-white"
                        data-bs-dismiss="modal" title="Fechar modal"></button>
            </div>
            <form class="modal-body" id="formaddritual">
                <div class="row row-cols-md-2 row-cols-1 g-1">
                    <div>
                        <label class="fs-4 fw-bold w-100">Foto do ritual
                            <select class="form-select bg-black text-light border-light selectosimbolo" name="foto">
                                <option selected>Desconhecido</option>
                                <option >Customizada</option>
                                <option disabled>---------Rituais da Wiki---------</option>
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
                        </label>

                        <label id="simbolourl" class="w-100">
                            <span class="fs-4 fw-bold">Link da imagem</span>
                            <input class="form-control bg-black text-light border-light" oninput="updateritualfoto(this);" name="simbolourl" value="https://fichasop.com/assets/img/desconhecido.webp"
                                   maxlength="<?= $Fich_fotos ?>" type="url" readonly required/>
                            <span class="aviso invalid-feedback"></span>
                        </label>
                    </div>
                    <div class="text-center">
                        <div id="prevsimbolo">
                            <img src="/assets/img/desconhecido.webp" width="150" height="150" alt="Ritual">
                        </div>
                    </div>
                </div>
                <hr>
                <h3 class="mt-3">Detalhes do Ritual</h3>
                <div class="row row-cols-md-2 row-cols-1 g-2">
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Ritual:</span>
                            <input type="text" class="form-control bg-black text-white border-start-0" maxlength="<?= $Ritu_nome ?>" name="ritual"/>
                        </label>
                    </div>
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Elemento:</span>
                            <input type="text" class="form-control bg-black text-white border-start-0" maxlength="<?= $Ritu_elem ?>" name="elemento"/>
                        </label>
                    </div>
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Circulo:</span>
                            <input type="text" class="form-control bg-black text-white border-start-0" maxlength="<?= $Ritu_circ ?>" name="circulo"/>
                        </label>
                    </div>
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Execução:</span>
                            <input type="text" class="form-control bg-black text-white border-start-0" maxlength="<?= $Ritu_conj ?>" name="conjuracao"/>
                        </label>
                    </div>
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Alcance:</span>
                            <input type="text" class="form-control bg-black text-white border-start-0" maxlength="<?= $Ritu_alca ?>" name="alcance"/>
                        </label>
                    </div>
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Alvo:</span>
                            <input type="text" class="form-control bg-black text-white border-start-0" maxlength="<?= $Ritu_alvo ?>" name="alvo"/>
                        </label>
                    </div>
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Duração:</span>
                            <input type="text" maxlength="<?= $Ritu_dura ?>" class="form-control bg-black text-white border-start-0" name="duracao"/>
                        </label>
                    </div>
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Resistência:</span>
                            <input type="text" maxlength="<?= $Ritu_resi ?>" class="form-control bg-black text-white border-start-0" name="resistencia"/>
                        </label>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 mt-2">
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Normal:</span>
                            <input type="text" maxlength="<?= $Ritu_dan ?>" class="form-control bg-black text-white border-start-0" name="dano1" placeholder="2d8+4"/>
                        </label>
                    </div>
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Discente:</span>
                            <input type="text" maxlength="<?= $Ritu_dan ?>" class="form-control bg-black text-white border-start-0" name="dano2" placeholder="1d8+4"/>
                        </label>
                    </div>
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Verdadeiro:</span>
                            <input type="text" maxlength="<?= $Ritu_dan ?>" class="form-control bg-black text-white border-start-0" name="dano3" placeholder="1d8+4"/>
                        </label>
                    </div>

                </div>
                <div>
                    <label class="w-100 mt-3">
                        <span class="fs-4">Detalhes: </span>
                        <textarea name="efeito" class="form-control form-control-sm bg-black text-white"></textarea>
                    </label>
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
                                            <img src="/assets/img/desconhecido.webp" width="200" height="200" alt="Ritual">
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
                                    <label class="input-group-text input-group-sm bg-black text-white border-end-0" for="arres<?= $r["id"] ?>">Resistência:</label>
                                    <input type="text" maxlength="<?=$Ritu_dura?>" class="form-control bg-black text-white border-start-0" id="arres<?= $r["id"] ?>" name="resistencia[]" value="<?= $r["resistencia"] ?>"/>
                                </div>
                                <div class="input-group m-1">
                                    <label class="input-group-text input-group-sm bg-black text-white border-end-0" for="eard1<?= $r["id"] ?>">Normal:</label>
                                    <input type="text" maxlength="<?=$Ritu_dan?>" class="form-control bg-black text-white border-start-0" id="eard1<?= $r["id"] ?>" name="dano1[]" value="<?= $r["dano"] ?>" placeholder="2d8+4"/>
                                </div>
                                <div class="input-group m-1">
                                    <label class="input-group-text input-group-sm bg-black text-white border-end-0" for="eard2<?= $r["id"] ?>">Discente:</label>
                                    <input type="text" maxlength="<?=$Ritu_dan?>" class="form-control bg-black text-white border-start-0" id="eard2<?= $r["id"] ?>" name="dano2[]" value="<?= $r["dano2"] ?>" placeholder="1d8+4"/>
                                </div>
                                <div class="input-group m-1">
                                    <label class="input-group-text input-group-sm bg-black text-white border-end-0" for="eard3<?= $r["id"] ?>">Verdadeiro:</label>
                                    <input type="text" maxlength="<?=$Ritu_dan?>" class="form-control bg-black text-white border-start-0" id="eard3<?= $r["id"] ?>" name="dano3[]" value="<?= $r["dano3"] ?>" placeholder="1d8+4"/>
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
