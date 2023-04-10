<!-- Modal proficiencias-->
<form class="modal modal-xl fade" id="editprincipal" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <span class="fs-4 modal-title">Editar Status</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <span class="text-info"><i class="fa-solid fa-circle-info"></i> Sua vida, sanidade e esforço não atualiza quando muda de nex! para isso abra essa janela e clique em salvar quando alterar</span>

                <h4 class="text-center mt-3">Saúde <button class="btn btn-sm btn-outline-info" type="button">Ajuda</button></h4>
                <div class="row g-2">
                    <div class="col-12 col-xl-6">
                        <div class="card m-2">
                            <h5 class="card-header">Vida</h5>
                            <div class="card-body">
                                <label class="form-check form-switch">
                                    <input class="form-check-input changecalc" data-fop-type="pv" type="checkbox" role="switch">
                                    <span class="form-check-label">Calculo Automático</span>
                                </label>
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label class="input-group">
                                            <span class="input-group-text border-end-0">Total</span>
                                            <input class="form-control  border-start-0" min="0" max="<?=$maximo_PV?>" type="number" name="pv" value="<?=  $ficha["pv"] ?>"/>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-floating" style="display: none">
                                            <input class="form-control" min="-10" max="10" disabled type="number" name="bpv" value="<?=  $ficha["bpv"] ?>" required/>
                                            <label class="">Bônus por nível</label>
                                            
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-floating" style="display: none">
                                            <input class="form-control" min="0" max="20" disabled type="number" name="skippedpv" value="<?=  $ficha["skippedpv"] ?>" required/>
                                            <label class="">Níveis Pulados</label>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-floating" style="display: none">
                                            <input class="form-control" min="-999" max="999" disabled type="number" name="somapv" value="<?=  $ficha["somapv"] ?>" required/>
                                            <label class="">Soma no total</label>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6">
                        <div class="card m-2">
                            <h5 class="card-header">Sanidade</h5>
                            <div class="card-body">
                                <label class="form-check form-switch">
                                    <input class="form-check-input changecalc" data-fop-type="san" value="true" type="checkbox" role="switch">
                                    <span class="form-check-label">Calculo Automático</span>
                                </label>
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label class="input-group">
                                            <span class="input-group-text border-end-0">Total</span>
                                            <input class="form-control  border-start-0" min="0" max="<?=$maximo_SAN?>" type="number" name="san" value="<?=  $ficha["san"] ?>"/>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-floating" style="display: none">
                                            <input class="form-control" min="-10" max="10" disabled type="number" name="bsan" value="<?= $ficha["bsan"] ?>"/>
                                            <label class="">Bônus por nível</label>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-floating" style="display: none">
                                            <input class="form-control" min="0" max="20" disabled type="number" name="skippedsan" value="<?=  $ficha["skippedsan"] ?>"/>
                                            <label class="">Níveis Pulados</label>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-floating" style="display: none">
                                            <input class="form-control" min="-999" max="999" disabled type="number" name="somasan" value="<?=  $ficha["somasan"] ?>"/>
                                            <label class="">Soma no total</label>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card m-2">
                            <h5 class="card-header">Esforço</h5>
                            <div class="card-body">
                                <label class="form-check form-switch">
                                    <input class="form-check-input changecalc" data-fop-type="pe" type="checkbox" role="switch">
                                    <span class="form-check-label">Calculo Automático</span>
                                </label>
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label class="input-group">
                                            <span class="input-group-text border-end-0">Total</span>
                                            <input class="form-control  border-start-0" min="0" max="<?=$maximo_PE?>" type="number" name="pe" value="<?=  $ficha["pe"] ?>"/>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-floating" style="display: none">
                                            <input class="form-control" min="-10" max="10" disabled type="number" name="bpe" value="<?=  $ficha["bpe"] ?>"/>
                                            <label class="">Bônus por nível</label>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-floating" style="display: none">
                                            <input class="form-control" min="0" max="20" disabled  type="number" name="skippedpe" value="<?=  $ficha["skippedpe"] ?>"/>
                                            <label class="">Níveis Pulados</label>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-floating" style="display: none">
                                            <input class="form-control" min="-999" max="999" disabled type="number" name="somape" value="<?=  $ficha["somape"] ?>"/>
                                            <label class="">Soma no total</label>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="text-center mt-3">Conta-balas</h4>
                <div class="row row-cols-1 g-2">
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="input-group-text  border-end-0">Quantidade de balas:</span>
                            <input class="form-control  border-start-0" type="number" min="0" max="30" name="balas" value="<?= $ficha["balas"] ?>"/>
                        </label>
                    </div>
                </div>
                <h4 class="text-center mt-3">Defesas</h4>
                <div class="row row-cols-1 row-cols-md-3 g-2">
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="input-group-text  border-end-0">Passiva:</span>
                            <input class="form-control  border-start-0" type="number" min="0" max="999" name="passiva" value="<?= $passiva ?>"/>
                        </label>
                    </div>
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="input-group-text  border-end-0">Esquiva:</span>
                            <input class="form-control  border-start-0" type="number" min="0" max="999" name="esquiva" value="<?= $esquiva ?>"/>
                        </label>
                    </div>
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="input-group-text  border-end-0">Bloqueio:</span>
                            <input class="form-control  border-start-0" type="number" min="0" max="999" name="bloqueio" value="<?= $bloqueio ?>"/>
                        </label>
                    </div>
                </div>
                <h4 class="text-center mt-3">Resistencias a Elementos</h4>
                <div class="row row-cols-1 row-cols-md-2 g-1">
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="input-group-text  border-end-0">Mental:</span>
                            <input class="form-control  border-start-0"
                                   type="number" min="0" max="50" name="mental" value="<?= $insanidade ?>"/>
                        </label>
                    </div>
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="input-group-text  border-end-0">Morte:</span>
                            <input class="form-control  border-start-0" type="number" min="0"
                                   max="50" name="morte" value="<?= $morte ?>"/>
                        </label>
                    </div>
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="input-group-text  border-end-0">Conhecimento:</span>
                            <input class="form-control  border-start-0"
                                   type="number" min="0" max="50" name="conhecimento" value="<?= $conhecimento ?>"/>
                        </label>
                    </div>
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="input-group-text  border-end-0">Sangue:</span>
                            <input class="form-control  border-start-0"
                                   type="number" min="0" max="50" name="sangue" value="<?= $sangue ?>"/>
                        </label>
                    </div>
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="input-group-text  border-end-0">Energia:</span>
                            <input class="form-control  border-start-0"
                                   type="number" min="0" max="50" name="energia" value="<?= $energia ?>"/>
                        </label>
                    </div>
                    <div class="">
                    </div>
                </div>
                <h4 class="text-center mt-3">Outras Resistências</h4>
                <div class="row row-cols-md-2 row-cols-1 g-1">

                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="input-group-text  border-end-0">Física:</span>
                            <input class="form-control  border-start-0"
                                   type="number" min="0" max="50" name="fisica" value="<?= $fisica ?>"/>
                        </label>
                    </div>
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="input-group-text  border-end-0">Balística:</span>
                            <input class="form-control  border-start-0"
                                   type="number" min="0" max="50" name="balistica" value="<?= $balistica ?>"/>
                        </label>
                    </div>
                    <div>
                        <label class="input-group input-group-sm">
                            <span class="input-group-text  border-end-0">Corte:</span>
                            <input class="form-control  border-start-0"
                                   type="number" min="0" max="50" name="corte" value="<?= $corte ?>"/>
                        </label>

                    </div>
                    <div>
                        <label class="input-group input-group-sm">
                            <span class="input-group-text  border-end-0">Impacto:</span>
                            <input class="form-control  border-start-0"
                                   type="number" min="0" max="50" name="impacto" value="<?= $impacto ?>"/>
                        </label>

                    </div>
                    <div>
                        <label class="input-group input-group-sm">
                            <span class="input-group-text  border-end-0">Perfuração:</span>
                            <input class="form-control  border-start-0"
                                   type="number" min="0" max="50" name="perfuracao" value="<?= $perfuracao ?>"/>
                        </label>

                    </div>
                    <div>
                        <label class="input-group input-group-sm">
                            <span class="input-group-text  border-end-0">Eletricidade:</span>
                            <input class="form-control  border-start-0"
                                   type="number" min="0" max="50" name="eletricidade" value="<?= $eletricidade ?>"/>
                        </label>

                    </div>
                    <div>
                        <label class="input-group input-group-sm">
                            <span class="input-group-text  border-end-0">Fogo:</span>
                            <input class="form-control  border-start-0"
                                   type="number" min="0" max="50" name="fogo" value="<?= $fogo ?>"/>
                        </label>

                    </div>
                    <div>
                        <label class="input-group input-group-sm"><span
                                    class="input-group-text  border-end-0">Frio:</span>
                            <input class="form-control  border-start-0"
                                   type="number" min="0" max="50" name="frio" value="<?= $frio ?>"/></label>
                    </div>
                    <div>
                        <label class="input-group input-group-sm">
                            <span class="input-group-text  border-end-0">Química:</span>
                            <input class="form-control  border-start-0"
                                   type="number" min="0" max="50" name="quimico" value="<?= $quimica ?>"/>
                        </label>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="query" value="ficha_update_status"/>
                <button class="btn btn-outline-success w-100" type="submit">Salvar</button>
            </div>
        </div>
    </div>
</form>

<!---TROCAR DE PERFIL MODAL--->
<div class="modal fade" id="trocarficha" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="fs-4 modal-title">Trocar Rápido</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body justify-content-center text-center">
				
				<?php
				$k = $con->query("SELECT * FROM `ligacoes` WHERE `id_usuario` = '" . $_SESSION["UserID"] . "' AND `id_ficha` IS NOT NULL;");
				if ($k->num_rows) {
					echo "<h5>Com missão</h5>";
					foreach ($k as $r):
						$ks = $con->query("SELECT * FROM `fichas_personagem` WHERE `id` = '" . $r["id_ficha"] . "'");
						$rs = mysqli_fetch_array($ks);
						?>
                        <div class="d-grid gap-2 m-2">
                            <a class="btn btn-primary" href="./?token=<?= $rs["token"] ?>"><?= $rs["nome"] ?></a>
                        </div>
					<?php
					endforeach;
				}
				$k = $con->query("SELECT * FROM `fichas_personagem` WHERE `usuario` = '" . $_SESSION["UserID"] . "';");
				if ($k->num_rows) {
					echo "<h5>Todas as Fichas</h5>";
					foreach ($k as $r):
						?>
                        <div class="d-grid gap-2 m-2">
                            <a class="btn btn-primary" href="./?token=<?= $r["token"] ?>"><?= $r["nome"] ?></a>
                        </div>
					<?php
					endforeach;
				}
				
				?>
            </div>
        </div>
    </div>
</div>


<form class="modal modal-xl fade" id="editfoto" tabindex="-1">
    <div class="modal-dialog modal-fullscreen-md-down">
        <div class="modal-content">
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
                                    <select class="form-select selector" name="foto">
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
                                <div class="m-2 input-group" data-fop-initialize="Upload">
                                    <label class="form-floating">
                                        <input class="foto-perfil form-control form-control-sm border-secondary" name="fotourl" type="url" value="<?= $urlphoto ?>" required/>
                                        <label>Normal:</label>
                                    </label>
                                    <label class="btn btn-outline-secondary border-dashed">
                                        <span class="msg">Enviar foto</span>
                                        <span class="progress" style="display: none;">
                                            <span class="progress-bar" role="progressbar"></span>
                                        </span>
                                        <input type="file" accept=".png,.gif,.jpeg,.jpg,.webp"  hidden/>
                                    </label>
                                </div>
                                <div class="m-2 input-group" data-fop-initialize="Upload">
                                    <label class="form-floating">
                                        <input class="foto-perfil form-control form-control-sm border-secondary" id="ff_input" name="fotofer" type="url" value="<?= $urlphotofer ?>" required/>
                                        <label>Ferido:</label>
                                    </label>
                                    <label class="btn btn-outline-secondary border-dashed">
                                        <span class="msg">Enviar foto</span>
                                        <span class="progress" style="display: none;">
                                            <span class="progress-bar" role="progressbar"></span>
                                        </span>
                                        <input type="file" accept=".png,.gif,.jpeg,.jpg,.webp"  hidden/>
                                    </label>
                                </div>
                                <div class="m-2 input-group" data-fop-initialize="Upload">
                                    <label class="form-floating">
                                        <input class="foto-perfil form-control form-control-sm border-secondary" id="fm_input" name="fotomor" type="url" value="<?= $urlphotomor ?>" required/>
                                        <label>Morrendo:</label>
                                    </label>
                                    <label class="btn btn-outline-secondary border-dashed">
                                        <span class="msg">Enviar foto</span>
                                        <span class="progress" style="display: none;">
                                            <span class="progress-bar" role="progressbar"></span>
                                        </span>
                                        <input type="file" accept=".png,.gif,.jpeg,.jpg,.webp"  hidden/>
                                    </label>
                                </div>
                                <div class="m-2 input-group" data-fop-initialize="Upload">
                                    <label class="form-floating">
                                        <input class="foto-perfil form-control form-control-sm border-secondary" id="fe_input" name="fotoenl" type="url" value="<?= $urlphotoenl ?>" required/>
                                        <label>Enlouquecendo:</label>
                                    </label>
                                    <label class="btn btn-outline-secondary border-dashed">
                                        <span class="msg">Enviar foto</span>
                                        <span class="progress" style="display: none;">
                                            <span class="progress-bar" role="progressbar"></span>
                                        </span>
                                        <input type="file" accept=".png,.gif,.jpeg,.jpg,.webp"  hidden/>
                                    </label>

                                </div>
                                <div class="m-2 input-group" data-fop-initialize="Upload">
                                    <label class="form-floating">
                                        <input class="foto-perfil form-control form-control-sm border-secondary" id="fef_input" name="fotoef" type="url" value="<?= $urlphotoef ?>" required/>
                                        <label>Ferido e Enlouquecendo:</label>
                                    </label>
                                    <label class="btn btn-outline-secondary border-dashed">
                                        <span class="msg">Enviar foto</span>
                                        <span class="progress" style="display: none;">
                                            <span class="progress-bar" role="progressbar"></span>
                                        </span>
                                        <input type="file" accept=".png,.gif,.jpeg,.jpg,.webp"  hidden/>
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
            </div>
            <div class="modal-footer">
                <input type="hidden" name="query" value="ficha_update_foto">
                <button class="btn btn-outline-success w-100" type="submit">Salvar</button>
            </div>
        </div>
    </div>
</form>

