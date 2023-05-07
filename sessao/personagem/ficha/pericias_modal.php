<form class="modal fade" id="editper" tabindex="-1">
    <div class="modal-dialog modal-fullscreen-lg-down modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <span class="fs-4 modal-title">Editar Pericias</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body font1">
                <div class="row row-cols-1 row-cols-md-2 row-cols-md-4 g-3">
					<?php
					function input_per($label, $value, int $level, $name, $prof = false)
					{
						?>
                        <div class="col text-center p-2">
                        <div class="card"><?=$prof?>
                            <div class="card-header font1 d-flex justify-content-between">
                                <h5 class="px-1 text-center w-100"><?= $label ?></h5>
								<?php if (is_string($prof)) { ?>
                                    <div class="px-1">
                                        <input class="form-control form-control-sm font2" style="max-width: 110px;" type="text" minlength="0" maxlength="25" placeholder="Área" value="<?=$prof ?: "" ?>" name="n<?= $name ?>"/>
                                    </div>
								<?php } ?>
                            </div>
                            <div class="card-body">
                                <div class="input-group input-group-sm">
                                    <select class="form-select" type="number" name="t<?= $name ?>">
                                        <option value="0">Destreinado</option>
                                        <option value="1"
											<?= $level === 1 ? "selected" : "" ?>>Treinado
                                        </option>
                                        <option value="2"
											<?= $level === 2 ? "selected" : "" ?>>Veterano
                                        </option>
                                        <option value="3"
											<?= $level === 3 ? "selected" : "" ?>>Expert
                                        </option>
                                    </select>
                                    <input class="form-control" type="number" min="0" max="99" placeholder="Outros" value="<?= $value ?: "" ?>" name="<?= $name ?>"/>

                                </div>
                            </div>
                        </div>

                        </div><?php
					}
					
					?>
					<?= input_per("Acrobacias", $acrobacias, $ficha["tacrobacia"], "acrobacias") ?>
					<?= input_per("Adestramento", $adestramento, $ficha["tadestramento"], "adestramento") ?>
					<?= input_per("Artes", $artes, $ficha["tarte"], "artes") ?>
					<?= input_per("Atletismo", $atletismo, $ficha["tatletismo"], "atletismo") ?>
					<?= input_per("Atualidades", $atualidades, $ficha["tatualidade"], "atualidades") ?>
					<?= input_per("Ciência", $ciencia, $ficha["tciencia"], "ciencia",$ficha["nciencia"]) ?>
					<?= input_per("Crime", $crime, $ficha["tcrime"], "crime") ?>
					<?= input_per("Diplomacia", $diplomacia, $ficha["tdiplomacia"], "diplomacia") ?>
					<?= input_per("Enganação", $enganacao, $ficha["tenganacao"], "enganacao") ?>
					<?= input_per("Fortitude", $fortitude, $ficha["tfortitude"], "fortitude") ?>
					<?= input_per("Furtividade", $furtividade, $ficha["tfurtividade"], "furtividade") ?>
					<?= input_per("Iniciativa", $iniciativa, $ficha["tiniciativa"], "iniciativa") ?>
					<?= input_per("Intimidação", $intimidacao, $ficha["tintimidacao"], "intimidacao") ?>
					<?= input_per("Intuição", $intuicao, $ficha["tintuicao"], "intuicao") ?>
					<?= input_per("Investigação", $investigacao, $ficha["tinvestigacao"], "investigacao") ?>
					<?= input_per("Luta", $luta, $ficha["tluta"], "luta") ?>
					<?= input_per("Medicina", $medicina, $ficha["tmedicina"], "medicina") ?>
					<?= input_per("Ocultismo", $ocultismo, $ficha["tocultismo"], "ocultismo") ?>
					<?= input_per("Percepção", $percepcao, $ficha["tpercepcao"], "percepcao") ?>
					<?= input_per("Pilotagem", $pilotagem, $ficha["tpilotagem"], "pilotagem") ?>
					<?= input_per("Pontaria", $pontaria, $ficha["tpontaria"], "pontaria") ?>
					<?= input_per("Profissão", $profissao, $ficha["tprofissao"], "profissao", $ficha["nprofissao"]) ?>
					<?= input_per("Reflexos", $reflexos, $ficha["treflexo"], "reflexo") ?>
					<?= input_per("Religião", $religiao, $ficha["treligiao"], "religiao") ?>
					<?= input_per("Sobrevivência", $sobrevivencia, $ficha["tsobrevivencia"], "sobrevivencia") ?>
					<?= input_per("Tática", $tatica, $ficha["ttatica"], "tatica") ?>
					<?= input_per("Tecnologia", $tecnologia, $ficha["ttecnologia"], "tecnologia") ?>
					<?= input_per("Vontade", $vontade, $ficha["tvontade"], "vontade") ?>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="query" value="ficha_update_pericias"/>
                <button type="submit" class="btn btn-success w-100">Salvar</button>
            </div>
        </div>
    </div>
</form>
