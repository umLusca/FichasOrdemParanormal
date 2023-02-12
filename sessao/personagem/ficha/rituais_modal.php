<!-- Modal Rituais-->
<form class="modal fade" id="addritual" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-xl modal-dialog modal-fullscreen-md-down">
        <div class="modal-content bg-black border-light">
            <div class="modal-header">
                <span class="modal-title fs-4">Adicionar Ritual.</span>
                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal" title="Fechar modal"></button>
            </div>
            <div class="modal-body" id="formaddritual">
                <div class="row row-cols-md-2 row-cols-1 g-1">
                    <div>
                        <label class="fs-4 fw-bold w-100">Foto do ritual
                            <select class="form-select bg-black text-light border-light selectosimbolo" name="foto">
                                <option selected>Desconhecido</option>
                                <option>Customizada</option>
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
            </div>
            <div class="modal-footer">
                <input name="status" value="addritual" type="hidden"/>
                <button type="submit" class="btn btn-success w-100" value="submit">Criar</button>
            </div>
        </div>
    </div>
</form>
<form class="modal fade" id="editritual" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-xl modal-dialog modal-fullscreen-md-down">
        <div class="modal-content bg-black border-light">
            <div class="modal-header">
                <span class="modal-title fs-4">Editar Ritual</span>
                <button class="btn-close btn-close-white"
                       type="button" data-bs-dismiss="modal" title="Fechar modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-1">
                    <div class="col-auto align-self-center">
                            <img src="/assets/img/desconhecido.webp" class="border foto" width="150" height="150" alt="Ritual">

                    </div>
                    <div class="col align-self-center">
                        <div class="m-2">
                            <label class="form-floating w-100">
                                <select class="form-select bg-black text-light border-light rituais" name="foto">
                                    <option selected>Desconhecido</option>
                                    <option>Customizada</option>
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
                                <label>Foto do Ritual</label>
                            </label>
                        </div>
                        <div class="m-2">
                            <label class="form-floating w-100">
                                <input class="form-control bg-black text-light border-light url" name="simbolourl" value="https://fichasop.com/assets/img/desconhecido.webp" maxlength="<?= $Fich_fotos ?>" type="url" required/>
                                <label>Link da imagem</label>
                                <span class="return invalid-feedback"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <hr>
                <h3 class="mt-3">Detalhes do Ritual</h3>
                <div class="row row-cols-md-2 row-cols-1 g-2">
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Ritual:</span>
                            <input type="text" class="form-control bg-black text-white border-start-0 ritual" maxlength="<?= $Ritu_nome ?>" name="ritual"/>
                        </label>
                    </div>
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Elemento:</span>
                            <input type="text" class="form-control bg-black text-white border-start-0 elemento" maxlength="<?= $Ritu_elem ?>" name="elemento"/>
                        </label>
                    </div>
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Circulo:</span>
                            <input type="text" class="form-control bg-black text-white border-start-0 circulo" maxlength="<?= $Ritu_circ ?>" name="circulo"/>
                        </label>
                    </div>
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Execução:</span>
                            <input type="text" class="form-control bg-black text-white border-start-0 conjuracao" maxlength="<?= $Ritu_conj ?>" name="conjuracao"/>
                        </label>
                    </div>
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Alcance:</span>
                            <input type="text" class="form-control bg-black text-white border-start-0 alcance" maxlength="<?= $Ritu_alca ?>" name="alcance"/>
                        </label>
                    </div>
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Alvo:</span>
                            <input type="text" class="form-control bg-black text-white border-start-0 alvo" maxlength="<?= $Ritu_alvo ?>" name="alvo"/>
                        </label>
                    </div>
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Duração:</span>
                            <input type="text" maxlength="<?= $Ritu_dura ?>" class="form-control bg-black text-white border-start-0 duracao" name="duracao"/>
                        </label>
                    </div>
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Resistência:</span>
                            <input type="text" maxlength="<?= $Ritu_resi ?>" class="form-control bg-black text-white border-start-0 resistencia" name="resistencia"/>
                        </label>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 mt-2">
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Normal:</span>
                            <input type="text" maxlength="<?= $Ritu_dan ?>" class="form-control bg-black text-white border-start-0 normal" name="dano1" placeholder="2d8+4"/>
                        </label>
                    </div>
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Discente:</span>
                            <input type="text" maxlength="<?= $Ritu_dan ?>" class="form-control bg-black text-white border-start-0 discente" name="dano2" placeholder="1d8+4"/>
                        </label>
                    </div>
                    <div>
                        <label class="input-group">
                            <span class="input-group-text input-group-sm bg-black text-white border-end-0">Verdadeiro:</span>
                            <input type="text" maxlength="<?= $Ritu_dan ?>" class="form-control bg-black text-white border-start-0 verdadeiro" name="dano3" placeholder="1d8+4"/>
                        </label>
                    </div>

                </div>
                <div>
                    <label class="w-100 mt-3">
                        <span class="fs-4">Detalhes: </span>
                        <textarea name="efeito" class="form-control form-control-sm bg-black text-white desc"></textarea>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <input name="status" value="editritual" type="hidden"/>
                <input class="did" name="did" value="" type="hidden"/>
                <button type="submit" class="btn btn-success w-100" value="submit">Criar</button>
            </div>
        </div>
    </div>
</form>
