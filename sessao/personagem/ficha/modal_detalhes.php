<!-- Modal proeficiencias-->
<div class="modal modal-xl fade" id="editdetalhes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-fullscreen-md-down">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" novalidate id="form_editar_principal">
                <div class="clearfix">
                    <button type="button" class="btn-close btn-close-white me-2 m-auto float-end"
                            data-bs-dismiss="modal" aria-label="Fechar"></button>
                    <div class="float-start m-2">
                        <span class="text-info"><i class="fa-regular fa-circle-info"></i> Os campos em azuis pode ser calculados automaticamente colocando 1.</span>
                    </div>
                </div>
                <h1 class="text-center">Editar Detalhes</h1>
                <div class="">
                    <div class="m-2">
                        <label for="foto" class="fs-4 fw-bold">Estilo de foto.</label>
                        <select class="form-select bg-black text-light border-light" id="foto" name="foto">
                            <option value="1">Desconhecido - Masculino</option>
                            <option value="2">Desconhecido - Feminino</option>
                            <option value="3">Mauro Nunes</option>
                            <option value="4">Maya Shiruze</option>
                            <option value="5">Bruna Sampaio</option>
                            <option value="6">Leandro Weiss</option>
                            <option value="7">Jaime Orthuga</option>
                            <option value="8">Aniela Ukryty</option>
                            <option value="9" selected>Customizada</option>
                        </select>
                    </div>
                    <div class="m-2" id="divfotourl">
                        <label for="fotourl" class="fs-4">Link da imagem</label>
                        <div class="row">
                            <div class="col" id="fotos">
                                <label class="input-group input-group-sm m-1">
                                    <span class="input-group-text bg-black border-light text-light border-end-0">Normal:</span>
                                    <input id="fotourl" class="foto-perfil form-control form-control-sm bg-black text-light border-light border-start-0" name="fotourl"  type="url" value="<?= $urlphoto ?>" required/>
                                </label>
                                <label class="input-group input-group-sm m-1">
                                    <span class="input-group-text bg-black border-light text-light border-end-0">Ferido:</span>
                                    <input id="fotourl" class="foto-perfil form-control form-control-sm bg-black text-light border-light border-start-0" name="fotofer"  type="url" value="<?= $urlphotofer ?>" required/>
                                </label>
                                <label class="input-group input-group-sm m-1">
                                    <span class="input-group-text bg-black border-light text-light border-end-0">Morrendo:</span>
                                    <input id="fotourl" class="foto-perfil form-control form-control-sm bg-black text-light border-light border-start-0" name="fotomor"  type="url" value="<?= $urlphotomor ?>" required/>
                                </label>
                                <label class="input-group input-group-sm m-1">
                                    <span class="input-group-text bg-black border-light text-light border-end-0">Enlouquecendo:</span>
                                    <input id="fotourl" class="foto-perfil form-control form-control-sm bg-black text-light border-light border-start-0" name="fotoenl"  type="url" value="<?= $urlphotoenl ?>" required/>
                                </label>
                                <label class="input-group input-group-sm m-1">
                                    <span class="input-group-text bg-black border-light text-light border-end-0">Ferido e Enlouquecendo:</span>
                                    <input id="fotourl" class="foto-perfil form-control form-control-sm bg-black text-light border-light border-start-0" name="fotoef"  type="url" value="<?= $urlphotoef ?>" required/>
                                </label>
                            </div>
                            <div id="prev" class="col-auto text-center"></div>
                        </div>
                        <div id="warning"></div>
                    </div>
                    <div class="m-1 g-3 row row-cols-1 row-cols-lg-2">
                        <div class="">
                            <label class="fs-4 w-100">Nome
                            <input class="form-control bg-black text-light nome" name="nome" pattern="^[0-9a-zA-Z áéíóúãõàèìòùÁÉÍÓÚÃÕÀÈÌÒÙçÇ]*$" value="<?= $nome ?>" maxlength="<?=$fich_nome?>" required/>
                                <span class="invalid-feedback">O nome do seu personagem precisa conter apenas Letras, números e espaços.</span>
                            </label>
                        </div>
                        <div class="">
                            <label class="fs-4 w-100">Local de nascimento
                                <input class="form-control bg-black text-light local" maxlength="<?=$Fich_loca?>" type="text" name="local" value="<?=$local?>"/>
                            </label>
                        </div>
                        <div class="">
                            <label class="fs-4 w-100">NEX.
                                <input class="form-control bg-black text-light nex" id="enex" name="nex" type="number" min="0" max="100"  value="<?=$rqs["nex"]?>" required/>
                                <span class="invalid-feedback">Coloque um número entre 0 e 100.</span>
                            </label>
                        </div>
                        <div class="">
                            <label class="fs-4 w-100">Elemento
                                <input type="text" class="form-control bg-black text-light elemento" maxlength="50" list="elementos" name="elemento" value="<?=$rqs["afinidade"]?>">
                                <datalist id="elementos">
                                    <?=Super_options("elementos",$rqs["afinidade"])?>
                                </datalist>
                            </label>
                        </div>
                        <div class="">

                            <label class="fs-4 w-100">Classe
                                <input type="text" class="form-control bg-black text-light classe" maxlength="50" list="classes" name="classe" value="<?=$rqs["classe"]?>" required>
                                <datalist id="classes">
                                    <?=Super_options("classes",$rqs["classe"])?>
                                </datalist>
                            </label>
                        </div>
                        <div class="">
                            <label class="fs-4 w-100">Trilha
                                <input type="text" class="form-control bg-black text-light trilha" maxlength="50" list="trilhas" name="trilha" value="<?=$rqs["trilha"]?>">
                                <datalist id="trilhas">
                                    <?=Super_options("trilhas",$rqs["trilha"])?>
                                </datalist>
                            </label>
                        </div>
                        <div class="">
                            <label class="fs-4 w-100">Origem
                                <input type="text" class="form-control bg-black text-light origem" maxlength="50" list="origens" name="origem" value="<?=$rqs["origem"]?>" required>
                                <datalist id="origens">
                                    <?=Super_options("origens",$rqs["origem"])?>
                                </datalist>
                            </label>
                        </div>
                        <div class="">

                            <label class="fs-4 w-100">Patente
                                <input type="text" class="form-control bg-black text-light elemento" maxlength="50" list="patentes" name="patente" value="<?=$rqs["patente"]?>">
                                <datalist id="patentes">
                                    <?=Super_options("patentes",$rqs["patente"])?>
                                </datalist>
                            </label>
                        </div>
                        <div>
                            <label class="fs-4 w-100">Pontos de Prestigio.
                                <input class="form-control bg-black text-light pp" name="pp" type="number" min="0" max="999999" value="<?=$pp;?>"/>
                                <span class="invalid-feedback">Um número entre 0 e 999999</span>
                            </label>
                        </div>
                        <div>
                            <label class="fs-4 w-100">PE/Rodada.
                                <input class="form-control bg-black text-light perodada" name="pr" type="number" min="0" max="127" value="<?= $pe_rodada ?>" required/>
                                <span class="invalid-feedback">Um número entre 0 e 127</span>
                            </label>
                        </div>
                        <div class="">
                            <label class="fs-4 w-100">Idade
                                <input class="form-control bg-black text-light idade" type="number" min="0" max="150" name="idade" value="<?= $rqs["idade"] ?>"/>
                            </label>
                        </div>
                        <div class="">
                            <label class="fs-4 w-100">Deslocamento
                                <input class="form-control bg-black text-light deslocamento" type="number" min="0" max="50" name="deslocamento" value="<?= $rqs["deslocamento"] ?>"/>
                            </label>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="status" value="editdet">
                <div class="clearfix m-2">
                    <button class="btn btn-outline-success float-start" type="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

