<!-- Modal proficiencias-->
<form class="modal modal-xl fade" id="editdetalhes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog border-secondary modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <span class="fs-4 modal-title">Editar Detalhes</span>
                <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="">
                    <div class="m-1 g-3 row row-cols-1 row-cols-lg-2">
                        <div class="">
                            <label class="fs-4 w-100">Nome
                            <input class="form-control  nome" name="nome" pattern="^[0-9a-zA-Z áéíóúãõàèìòùÁÉÍÓÚÃÕÀÈÌÒÙçÇ]*$" value="<?= $nome ?>" maxlength="<?=$fich_nome?>" required/>
                                <span class="invalid-feedback">O nome do seu personagem precisa conter apenas Letras, números e espaços.</span>
                            </label>
                        </div>
                        <div class="">
                            <label class="fs-4 w-100">Local de nascimento
                                <input class="form-control  local" maxlength="<?=$Fich_loca?>" type="text" name="local" value="<?=$local?>"/>
                            </label>
                        </div>
                        <div class="">
                            <label class="fs-4 w-100">NEX.
                                <input class="form-control  nex" id="enex" name="nex" type="number" min="0" max="100" value="<?=$ficha["nex"]?>" required/>
                                <span class="invalid-feedback">Coloque um número entre 0 e 100.</span>
                            </label>
                        </div>
                        <div class="">
                            <label class="fs-4 w-100">Elemento
                                <input type="text" class="form-control  elemento" maxlength="50" list="elementos" name="elemento" value="<?=$ficha["afinidade"]?>">
                                <datalist id="elementos">
                                    <?=Super_options("elementos",$ficha["afinidade"])?>
                                </datalist>
                            </label>
                        </div>
                        <div class="">

                            <label class="fs-4 w-100">Classe
                                <input type="text" class="form-control  classe" maxlength="50" list="classes" name="classe" value="<?=$ficha["classe"]?>" required>
                                <datalist id="classes">
                                    <?=Super_options("classes",$ficha["classe"])?>
                                </datalist>
                            </label>
                        </div>
                        <div class="">
                            <label class="fs-4 w-100">Trilha
                                <input type="text" class="form-control  trilha" maxlength="50" list="trilhas" name="trilha" value="<?=$ficha["trilha"]?>">
                                <datalist id="trilhas">
                                    <?=Super_options("trilhas",$ficha["trilha"])?>
                                </datalist>
                            </label>
                        </div>
                        <div class="">
                            <label class="fs-4 w-100">Origem
                                <input type="text" class="form-control  origem" maxlength="50" list="origens" name="origem" value="<?=$ficha["origem"]?>" required>
                                <datalist id="origens">
                                    <?=Super_options("origens",$ficha["origem"])?>
                                </datalist>
                            </label>
                        </div>
                        <div class="">

                            <label class="fs-4 w-100">Patente
                                <input type="text" class="form-control  elemento" maxlength="50" list="patentes" name="patente" value="<?=$ficha["patente"]?>">
                                <datalist id="patentes">
                                    <?=Super_options("patentes",$ficha["patente"])?>
                                </datalist>
                            </label>
                        </div>
                        <div>
                            <label class="fs-4 w-100">Pontos de Prestigio.
                                <input class="form-control  pp" name="pp" type="number" min="0" max="999999" value="<?=$pp;?>"/>
                                <span class="invalid-feedback">Um número entre 0 e 999999</span>
                            </label>
                        </div>
                        <div>
                            <label class="fs-4 w-100">PE/Rodada.
                                <input class="form-control  perodada" name="pr" type="number" min="0" max="127" value="<?= $pe_rodada ?>" required/>
                                <span class="invalid-feedback">Um número entre 0 e 127</span>
                            </label>
                        </div>
                        <div class="">
                            <label class="fs-4 w-100">Idade
                                <input class="form-control  idade" type="number" min="0" max="150" name="idade" value="<?= $ficha["idade"] ?>"/>
                            </label>
                        </div>
                        <div class="">
                            <label class="fs-4 w-100">Deslocamento
                                <input class="form-control  deslocamento" type="number" min="0" max="50" name="deslocamento" value="<?= $ficha["deslocamento"] ?>"/>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="query" value="ficha_update_detalhes">
                <button class="btn btn-outline-success w-100" type="submit">Salvar</button>
            </div>
        </div>
    </div>
</form>

