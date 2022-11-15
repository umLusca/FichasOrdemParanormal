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
                        <div class="row">
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
                            <div class="col">
                                <div class="m-2">
                                    <label class="form-floating w-100">
                                        <input class="foto-perfil form-control form-control-sm bg-black text-light border-light" name="fotourl" type="url" value="<?= $urlphoto ?>" required/>
                                        <label>Normal:</label>
                                    </label>
                                </div>
                                <div class="m-2">
                                    <label class="form-floating w-100">
                                        <input class="foto-perfil form-control form-control-sm bg-black text-light border-light" name="fotofer" type="url" value="<?= $urlphotofer ?>" required/>
                                        <label>Ferido:</label>
                                    </label>
                                </div>
                                <div class="m-2">
                                    <label class="form-floating w-100">
                                        <input class="foto-perfil form-control form-control-sm bg-black text-light border-light" name="fotomor" type="url" value="<?= $urlphotomor ?>" required/>
                                        <label>Morrendo:</label>
                                    </label>
                                </div>
                                <div class="m-2">
                                    <label class="form-floating w-100">
                                        <input class="foto-perfil form-control form-control-sm bg-black text-light border-light" name="fotoenl" type="url" value="<?= $urlphotoenl ?>" required/>
                                        <label>Enlouquecendo:</label>
                                    </label>
                                </div>
                                <div class="m-2">
                                    <label class="form-floating w-100">
                                        <input class="foto-perfil form-control form-control-sm bg-black text-light border-light" name="fotoef" type="url" value="<?= $urlphotoef ?>" required/>
                                        <label>Ferido e Enlouquecendo:</label>
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

