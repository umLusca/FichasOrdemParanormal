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
                            <label class="fs-4 w-100">Nivel de Exposição Paranormal.
                                <input class="form-control bg-black text-light nex" id="enex" name="nex" type="number" min="0" max="100" value="" required/>
                                <span class="invalid-feedback">Coloque um número entre 0 e 100.</span>
                            </label>
                        </div>
                        <div class="">
                            <label class="fs-4 w-100">Elemento
                                <select class="form-select bg-black text-light border-light elemento" name="elemento">
                                    <option value="0" SELECTED>Nenhum</option>
                                    <option value="1">Morte</option>
                                    <option value="2">Sangue</option>
                                    <option value="3">Energia</option>
                                    <option value="4">Conhecimento</option>
                                    <option value="5">Medo</option>
                                </select>
                            </label>
                        </div>
                        <div class="">
                            <label class="fs-4 fw-bold w-100">Classe
                                <select class="form-select bg-black text-light border-light classe" id="eclasse" name="classe" required>
                                    <option value="0">Mundano</option>
                                    <option value="1">Combatente</option>
                                    <option value="2">Especialista</option>
                                    <option value="3">Ocultista</option>
                                </select>
                            </label>
                        </div>
                        <div class="">
                            <label class="fs-4 fw-bold w-100">Trilha (10% NEX!)
                                <select class="form-select bg-black text-light border-light trilha" id="etrilha" name="trilha" required>
                                    <option value="0" class="" <?=($rqs["classe"] == 0 AND $rqs["trilha"]== 0)?'SELECTED':''?>>Nenhuma</option>
                                    <option value="1" class="trilha trilha-combatente" style="display: none;" <?=($rqs["classe"] == 1 AND $rqs["trilha"]== 1)?'SELECTED':''?>>Aniquilador</option>
                                    <option value="2" class="trilha trilha-combatente" style="display: none;" <?=($rqs["classe"] == 1 AND $rqs["trilha"]== 2)?'SELECTED':''?>>Comandante de Campo</option>
                                    <option value="3" class="trilha trilha-combatente" style="display: none;" <?=($rqs["classe"] == 1 AND $rqs["trilha"]== 3)?'SELECTED':''?>>Guerreiro</option>
                                    <option value="4" class="trilha trilha-combatente" style="display: none;" <?=($rqs["classe"] == 1 AND $rqs["trilha"]== 4)?'SELECTED':''?>>Operações Especiais</option>
                                    <option value="5" class="trilha trilha-combatente" style="display: none;" <?=($rqs["classe"] == 1 AND $rqs["trilha"]== 5)?'SELECTED':''?>>Tropa de Choque</option>
                                    <option value="1" class="trilha trilha-especialista" style="display: none;" <?=($rqs["classe"] == 2 AND $rqs["trilha"]== 1)?'SELECTED':''?>>Atirador de Elite</option>
                                    <option value="2" class="trilha trilha-especialista" style="display: none;" <?=($rqs["classe"] == 2 AND $rqs["trilha"]== 2)?'SELECTED':''?>>Infiltrador</option>
                                    <option value="3" class="trilha trilha-especialista" style="display: none;" <?=($rqs["classe"] == 2 AND $rqs["trilha"]== 3)?'SELECTED':''?>>Médico de Campo</option>
                                    <option value="4" class="trilha trilha-especialista" style="display: none;" <?=($rqs["classe"] == 2 AND $rqs["trilha"]== 4)?'SELECTED':''?>>Negociador</option>
                                    <option value="5" class="trilha trilha-especialista" style="display: none;" <?=($rqs["classe"] == 2 AND $rqs["trilha"]== 5)?'SELECTED':''?>>Técnico</option>
                                    <option value="1" class="trilha trilha-ocultista" style="display: none;" <?=($rqs["classe"] == 3 AND $rqs["trilha"]== 1)?'SELECTED':''?>>Conduíte</option>
                                    <option value="2" class="trilha trilha-ocultista" style="display: none;" <?=($rqs["classe"] == 3 AND $rqs["trilha"]== 2)?'SELECTED':''?>>Flagelador</option>
                                    <option value="3" class="trilha trilha-ocultista" style="display: none;" <?=($rqs["classe"] == 3 AND $rqs["trilha"]== 3)?'SELECTED':''?>>Graduado</option>
                                    <option value="4" class="trilha trilha-ocultista" style="display: none;" <?=($rqs["classe"] == 3 AND $rqs["trilha"]== 4)?'SELECTED':''?>>Intuitivo</option>
                                    <option value="5" class="trilha trilha-ocultista" style="display: none;" <?=($rqs["classe"] == 3 AND $rqs["trilha"]== 5)?'SELECTED':''?>>Lâmina Paranormal</option>
                                </select>
                            </label>
                        </div>
                        <div class="">
                            <label class="fs-4 fw-bold w-100">Origem
                            <select class="form-select bg-black text-light border-light origem" name="origem" required="required">
                                <option value="0" selected>Desconhecido</option>
                                <option value="1">Acadêmico</option>
                                <option value="2">Agente de Saúde</option>
                                <option value="3">Amnésico</option>
                                <option value="4">Artista</option>
                                <option value="5">Atleta</option>
                                <option value="25">Chef</option>
                                <option value="6">Criminoso</option>
                                <option value="7">Cultista Arrependido</option>
                                <option value="8">Desgarrado</option>
                                <option value="9">Engenheiro</option>
                                <option value="10">Executivo</option>
                                <option value="11">Investigador</option>
                                <option value="12">Lutador</option>
                                <option value="13">Magnata</option>
                                <option value="14">Mercenário</option>
                                <option value="15">Militar</option>
                                <option value="16">Operário</option>
                                <option value="17">Policial</option>
                                <option value="18">Religioso</option>
                                <option value="19">Servidor Público</option>
                                <option value="20">Teórico da Conspiração</option>
                                <option value="21">T.I.</option>
                                <option value="22">Trabalhador Rural</option>
                                <option value="23">Trambiqueiro</option>
                                <option value="24">Universitário</option>
                                <option value="26">Vítima</option>
                            </select></label>
                        </div>
                        <div class="">
                            <label class="fs-4 fw-bold w-100">Patente
                                <select class="form-select bg-black text-light border-light patente" name="patente" required>
                                    <option value="0" SELECTED>Desconhecido</option>
                                    <option value="1">Recruta</option>
                                    <option value="2">Operador</option>
                                    <option value="3">Agente Especial</option>
                                    <option value="4">Oficial de Operações</option>
                                    <option value="5">Agente de Elite</option>
                                </select>
                            </label>
                        </div>
                        <div>
                            <label class="fs-4 w-100">Pontos de Prestigio.
                                <input class="form-control bg-black text-light pp" name="pp" type="number" min="0" max="999999" value="<?=$pp;?>"/>
                                <span class="invalid-feedback">Um número entre 0 e 999999</span>
                            </label>
                        </div>
                        <div>
                            <label class="fs-4 w-100">Limite de PE por Rodada.
                                <input class="form-control bg-black text-light perodada" name="pr" type="number" min="0" max="127" value="<?= $pe_rodada ?>" required/>
                                <span class="invalid-feedback">
                                    Um número entre 0 e 127
                                </span>
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

