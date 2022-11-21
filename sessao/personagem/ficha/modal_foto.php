<!-- Modal proeficiencias-->
<form class="modal modal-xl fade" id="editfoto" tabindex="-1">
    <div class="modal-dialog modal-fullscreen-md-down">
        <div class="modal-content bg-black border-light">
            <div class="modal-header">
                <span class="modal-title fs-4">Editar foto de personagem</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="">
                    <div class="m-2">
                        <label class="fs-4">Link da imagem</label>
                        <div class="col-12">
                            <div class="m-2">
                                <label class="form-floating w-100">
                                    <select class="form-select bg-black text-light border-light selector" name="foto">
                                        <option value="0" selected>Customizada</option>
                                        <option value="1">Desconhecido - Masculino</option>
                                        <option value="2">Desconhecido - Feminino</option>
                                        <option value="3">Mauro Nunes</option>
                                        <option value="4">Maya Shiruze</option>
                                        <option value="5">Bruna Sampaio</option>
                                        <option value="6">Leandro Weiss</option>
                                        <option value="7">Jaime Orthuga</option>
                                        <option value="8">Aniela Ukryty</option>
                                    </select>
                                    <label>Fotos prontas</label>
                                </label>
                            </div>
                        </div>
                        <div class="row row-cols-1 row-cols-lg-2 justify-content-center">
                            <div class="col">
                                <div class="m-2 input-group">
                                    <label class="form-floating">
                                        <input class="foto-perfil form-control form-control-sm bg-black text-light border-light" id="fp_input" name="fotourl" type="url" value="<?= $urlphoto ?>" required/>
                                        <label>Normal:</label>
                                    </label>
                                    <label class="btn btn-outline-light border-dashed" for="fp_file">
                                        <span id="fp_label" class="">Ou Selecione uma foto</span>
                                        <label class="progress" style="display: none;">
                                            <label class="progress-bar" id="fp_progress" role="progressbar"></label>
                                        </label>
                                        <input type="file" accept=".png,.gif,.jpeg,.jpg,.webp" id="fp_file" onchange="uploadFile('fp_',this,'<?= $fichat ?>','fp',()=>editupdatefoto($('#fp_input').val(),'#editfoto img'))" hidden/>
                                    </label>
                                </div>
                                <div class="m-2 input-group">
                                    <label class="form-floating">
                                        <input class="foto-perfil form-control form-control-sm bg-black text-light border-light" id="ff_input" name="fotofer" type="url" value="<?= $urlphotofer ?>" required/>
                                        <label>Ferido:</label>
                                    </label>
                                    <label class="btn btn-outline-light border-dashed">
                                        <span id="ff_label" class="">Ou Selecione uma foto</span>
                                        <label class="progress" style="display: none;">
                                            <label class="progress-bar" id="ff_progress" role="progressbar"></label>
                                        </label>
                                        <input type="file" name="video" accept=".png,.gif,.jpeg,.jpg,.webp" onchange="uploadFile('ff_',this,'<?= $fichat ?>','ff',()=>editupdatefoto($('#ff_input').val(),'#editfoto img'))" hidden/>
                                    </label>
                                </div>
                                <div class="m-2 input-group">
                                    <label class="form-floating">
                                        <input class="foto-perfil form-control form-control-sm bg-black text-light border-light" id="fm_input" name="fotomor" type="url" value="<?= $urlphotomor ?>" required/>
                                        <label>Morrendo:</label>
                                    </label>
                                    <label class="btn btn-outline-light border-dashed">
                                        <span id="fm_label" class="">Ou Selecione uma foto</span>
                                        <label class="progress" style="display: none;">
                                            <label class="progress-bar" id="fm_progress" role="progressbar"></label>
                                        </label>
                                        <input type="file" name="video" accept=".png,.gif,.jpeg,.jpg,.webp" onchange="uploadFile('fm_',this,'<?= $fichat ?>','fm',()=>editupdatefoto($('#fm_input').val(),'#editfoto img'))" hidden/>
                                    </label>
                                </div>
                                <div class="m-2 input-group">
                                    <label class="form-floating">
                                        <input class="foto-perfil form-control form-control-sm bg-black text-light border-light" id="fe_input" name="fotoenl" type="url" value="<?= $urlphotoenl ?>" required/>
                                        <label>Enlouquecendo:</label>
                                    </label>
                                    <label class="btn btn-outline-light border-dashed">
                                        <span id="fe_label" class="">Ou Selecione uma foto</span>
                                        <label class="progress" style="display: none;">
                                            <label class="progress-bar" id="fe_progress" role="progressbar"></label>
                                        </label>
                                        <input type="file" name="video" accept=".png,.gif,.jpeg,.jpg,.webp" onchange="uploadFile('fe_',this,'<?= $fichat ?>','fe',()=>editupdatefoto($('#fe_input').val(),'#editfoto img'))" hidden/>
                                    </label>

                                </div>
                                <div class="m-2 input-group">
                                    <label class="form-floating">
                                        <input class="foto-perfil form-control form-control-sm bg-black text-light border-light" id="fef_input" name="fotoef" type="url" value="<?= $urlphotoef ?>" required/>
                                        <label>Ferido e Enlouquecendo:</label>
                                    </label>
                                    <label class="btn btn-outline-light border-dashed">
                                        <span id="fef_label" class="">Ou Selecione uma foto</span>
                                        <label class="progress" style="display: none;">
                                            <label class="progress-bar" id="fef_progress" role="progressbar"></label>
                                        </label>
                                        <input type="file" name="video" accept=".png,.gif,.jpeg,.jpg,.webp" onchange="uploadFile('fef_',this,'<?= $fichat ?>','fef',()=>editupdatefoto($('#fef_input').val(),'#editfoto img'))" hidden/>
                                    </label>
                                </div>
                            </div>
                            <div class="col-auto text-center preview align-self-center">
                                <img class="rounded-circle border border-light" style="max-width: 172px;width: -webkit-fill-available;" src="<?= $urlphoto ?>" alt="">
                            </div>
                        </div>
                        <div class="return"></div>
                    </div>
                </div>
                <input type="hidden" name="status" value="editfoto">
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-success w-100" type="submit">Salvar</button>
            </div>
        </div>
    </div>
</form>

