<!-- Modal proeficiencias-->
<div class="modal modal-xl fade" id="editdetalhes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" id="formeditdet">
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
                        <label for="fotourl" class="fs-4 fw-bold">Link da imagem</label>
                        <div class="row">
                            <div class="col-8" id="fotos">
                                <input id="fotourl" placeholder="Normal" class="foto-perfil form-control bg-black text-light border-light m-1" name="fotourl"  type="url" value="<?= $urlphoto ?>" required/>
                                <input id="fotomor" aria-label="" placeholder="Morrendo" class="foto-perfil form-control bg-black text-light border-light m-1" name="fotomor"  type="url" value="<?= $urlphotomor ?>"/>
                                <input id="fotoenl" aria-label="" placeholder="Enlouquecendo" class="foto-perfil form-control bg-black text-light border-light m-1" name="fotoenl"  type="url" value="<?= $urlphotoenl ?>" />
                                <input id="fotofer" aria-label="" placeholder="Ferido (<50% da vida)" class="foto-perfil form-control bg-black text-light border-light m-1" name="fotofer"  type="url" value="<?= $urlphotofer ?>"/>
                                <div class="invalid-feedback">A Imagem precisa ser valida</div>
                            </div>
                            <div id="prev" class="col-4 d-flex align-items-center"></div>
                        </div>
                        <div id="warning"></div>
                    </div>
                    <div class="m-2">
                        <label class="fs-4" for="enome">Nome</label>
                        <input id="enome" class="form-control bg-black text-light" name="nome" pattern="^[a-zA-Z áéíóúãõàèìòùÁÉÍÓÚÃÕÀÈÌÒÙçÇ]*$" value="<?= $nome ?>" maxlength="<?=$fich_nome?>" required/>
                        <div class="invalid-feedback">
                            O nome do seu personagem precisa conter apenas Letras e espaços.
                        </div>
                    </div>
                    <div class="m-2">
                        <label class="fs-4" for="enex">Nivel de Exposição Paranormal.</label>
                        <input id="enex" class="form-control bg-black text-light" name="nex" type="number" min="0"
                               max="100" value=""/>
                        <div class="invalid-feedback">
                            Providencie um nivel de exposição paranormal.
                        </div>
                    </div>

                    <div class="m-2">
                        <label class="fs-4" for="epp">Pontos de Prestigio.</label>
                        <input id="epp" class="form-control bg-black text-light" name="pp" type="number" min="0"
                               max="999999" value="<?= $pp ?>"/>
                        <div class="invalid-feedback">
                            Um número entre 0 e 999999
                        </div>
                    </div>

                    <div class="m-2">
                        <!---SELECTOR-->
                        <label class="fs-4 fw-bold" for="eclasse">Classe</label>
                        <select class="form-select bg-black text-light border-light" id="eclasse" name="classe"
                                required>
                            <option value="0">Desconhecido</option>
                            <option value="1">Combatente</option>
                            <option value="2">Especialista</option>
                            <option value="3">Ocultista</option>
                        </select>
                    </div>
                        <?=($rqs["classe"] == 1 AND $rqs["trilha"]== 1)?'SELECTED':''?>
                    <div class="m-2">
                        <label class="fs-4 fw-bold" for="etrilha">Trilha (10% NEX!)</label>
                        <select class="form-select bg-black text-light border-light" id="etrilha"
                                name="trilha" required>
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
                    </div>

                    <div class="m-2">
                        <label class="fs-4 fw-bold" for="eorigem">Origem</label>
                        <select class="form-select bg-black text-light border-light" id="eorigem" name="origem"
                                required="required">
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
                        </select>
                    </div>
                    <div class="m-2">
                        <label for="epatente" class="fs-4 fw-bold">Patente</label>
                        <select class="form-select bg-black text-light border-light" id="epatente" name="patente"
                                required>
                            <option value="0" SELECTED>Desconhecido</option>
                            <option value="1">Recruta</option>
                            <option value="2">Operador</option>
                            <option value="3">Agente Especial</option>
                            <option value="4">Oficial de Operações</option>
                            <option value="5">Agente de Elite</option>
                        </select>
                    </div>

                    <div class="m-2">
                        <label for="eelemento" class="fs-4 fw-bold">Elemento</label>
                        <select class="form-select bg-black text-light border-light" id="eelemento" name="elemento" required>
                            <option value="0" SELECTED>Nenhum</option>
                            <option value="1">Morte</option>
                            <option value="2">Sangue</option>
                            <option value="3">Energia</option>
                            <option value="4">Conhecimento</option>
                            <option value="5">Medo</option>
                        </select>
                    </div>
                    <div class="m-2">
                        <label class="fs-4" for="edesloc">Deslocamento</label>
                        <input id="edesloc" class="form-control bg-black  text-light " type="number" min="0" max="50" name="deslocamento" value="<?= $rqs["deslocamento"] ?>"/>
                    </div>
                    <div class="m-2">
                        <label class="fs-4" for="eidade">Idade</label>
                        <input id="eidade" class="form-control bg-black  text-light " type="number" min="0" max="150" name="idade" value="<?= $rqs["idade"] ?>"/>
                    </div>

                    <div class="m-2">
                        <label class="fs-4" for="elocal">Local de nascimento</label>
                        <input id="elocal" class="form-control bg-black  text-light" maxlength="<?=$Fich_loca?>" type="text" name="local" value="<?=$local?>"/>
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

