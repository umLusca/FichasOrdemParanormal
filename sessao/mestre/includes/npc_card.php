<?php
function Echo_FichaNPC($fichas, $type): void
{
	foreach ($fichas as $r) {
		if ($r["categoria"] == $type) {
			?>
            <div class="col col-md-6 col-lg-4 col-xl-3 border-0 text-center" id="npc<?= $r["id"] ?>">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="col-auto">
                            <button class="btn btn-sm text-warning" onclick="editnpc(<?= $r["id"] ?>,'<?= $r["categoria"] ?>');">
                                <i class="fa-regular fa-pencil"></i>
                            </button>
                            <button class="btn btn-sm text-primary" title="Duplicar Ficha" onclick="copynpc(<?= $r["id"] ?>);">
                                <i class="fa-regular fa-copy"></i>
                            </button>
                        </div>
                        <h5 class="text-truncate"><?= $r["nome"] ?></h5>
                        <div class="col-auto">
                            <button class="btn btn-sm text-danger " onclick="deletnpc(<?= $r["id"] ?>);">
                                <i class="fa-regular fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <ul class="nav nav-tabs justify-content-center" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link link-secondary active" id="pills-principal-tab<?= $r["id"] ?>" data-bs-toggle="pill" data-bs-target="#pills-principal<?= $r["id"] ?>" type="button" role="tab" aria-controls="pills-principal<?= $r["id"] ?>" aria-selected="true">
                                Principal
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link link-secondary" id="pills-ataque-tab<?= $r["id"] ?>" data-bs-toggle="pill" data-bs-target="#pills-ataque<?= $r["id"] ?>" type="button" role="tab" aria-controls="pills-ataque<?= $r["id"] ?>" aria-selected="false">
                                Defesas
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link link-secondary" id="pills-pericias-tab<?= $r["id"] ?>" data-bs-toggle="pill" data-bs-target="#pills-pericias<?= $r["id"] ?>" type="button" role="tab" aria-controls="pills-pericias<?= $r["id"] ?>" aria-selected="false">
                                Perícias
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link link-secondary" id="pills-habilidades-tab<?= $r["id"] ?>" data-bs-toggle="pill" data-bs-target="#pills-habilidades<?= $r["id"] ?>" type="button" role="tab" aria-controls="pills-disabled<?= $r["id"] ?>" aria-selected="false">
                                Outros
                            </button>
                        </li>
                    </ul>
                    <div class="card-body border-0">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pills-principal<?= $r["id"] ?>" role="tabpanel" aria-labelledby="pills-principal-tab<?= $r["id"] ?>" tabindex="0">
                                <div class="my-2">
                                    <strong>Atributos</strong>
                                    <div class="row justify-content-center g-1 mt-2">
										<?= pillbutton("FOR", $r["forca"], true, "rolar({nome:'Força',dado:'" . ValorParaRolarDado($r["forca"]) . "d20'})") ?>
										<?= pillbutton("AGI", $r["agilidade"], true, "rolar({nome:'Agilidade',dado:'" . ValorParaRolarDado($r["agilidade"]) . "d20'})") ?>
										<?= pillbutton("INT", $r["inteligencia"], true, "rolar({nome:'Intelecto',dado:'" . ValorParaRolarDado($r["inteligencia"]) . "d20'})") ?>
										<?= pillbutton("PRE", $r["presenca"], true, "rolar({nome:'Presença',dado:'" . ValorParaRolarDado($r["presenca"]) . "d20'})") ?>
										<?= pillbutton("VIG", $r["vigor"], true, "rolar({nome:'Vigor',dado:'" . ValorParaRolarDado($r["vigor"]) . "d20'})") ?>
                                    </div>
                                </div>
                                <div class="my-2">
                                    <strong>Vida</strong>
                                    <div class="">
                                        <div class="position-absolute start-0 ps-2">
                                            <button class="btn btn-sm text-secondary" onclick="updt('pv',-5,<?= $r["id"] ?>);">
                                                <i class="fa-solid fa-chevrons-left"></i> -5
                                            </button>
                                            <button class="btn btn-sm text-secondary" onclick="updt('pv',-1,<?= $r["id"] ?>);">
                                                <i class="fa-solid fa-chevron-left"></i> -1
                                            </button>
                                        </div>
                                        <div class="position-absolute end-0 pe-2">
                                            <button class="btn btn-sm text-secondary" onclick="updt('pv',1,<?= $r["id"] ?>);">
                                                +1 <i class="fa-solid fa-chevron-right"></i>
                                            </button>
                                            <button class="btn btn-sm text-secondary" onclick="updt('pv',5,<?= $r["id"] ?>);">
                                                +5 <i class="fa-solid fa-chevrons-right"></i>
                                            </button>
                                        </div>
                                        <div class="pvbar py-1 text-center">
                                            <span aria-label="pva" class="status"><?= $r["pva"] ?></span>/<span aria-label="pv" class="status"><?= $r["pv"] ?></span>
                                            <div class="progress">
                                                <div class="progress-bar bg-danger" style="width: <?= TirarPorcento($r["pva"], $r["pv"]) ?>%;" role="progressbar" aria-valuenow="<?= $r["pva"] ?>" aria-valuemin="0" aria-valuemax="<?= $r["pva"] ?>"></div>
                                            </div>
                                        </div>
                                    </div>
									<?php if ($r["san"] > 0) { ?>
                                        <div class="my-2">
                                            <strong>Sanidade</strong>
                                            <div class="">
                                                <div class="position-absolute start-0 ps-2">
                                                    <button class="btn btn-sm text-secondary" onclick="updt('san',-5,<?= $r["id"] ?>);">
                                                        <i class="fa-solid fa-chevrons-left"></i> -5
                                                    </button>
                                                    <button class="btn btn-sm text-secondary" onclick="updt('san',-1,<?= $r["id"] ?>);">
                                                        <i class="fa-solid fa-chevron-left"></i> -1
                                                    </button>
                                                </div>
                                                <div class="position-absolute end-0 pe-2">
                                                    <button class="btn btn-sm text-secondary" onclick="updt('san',1,<?= $r["id"] ?>);">
                                                        +1 <i class="fa-solid fa-chevron-right"></i>
                                                    </button>
                                                    <button class="btn btn-sm text-secondary" onclick="updt('san',5,<?= $r["id"] ?>);">
                                                        +5 <i class="fa-solid fa-chevrons-right"></i>
                                                    </button>
                                                </div>
                                                <div class="sanbar text-center py-1">
                                                    <span aria-label="sana" class="status"><?= $r["sana"] ?></span>/<span aria-label="san" class="status"><?= $r["san"] ?></span>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-primary" style="width: <?= TirarPorcento($r["sana"], $r["san"]) ?>%;" role="progressbar" aria-valuenow="<?= $r["sana"] ?>" aria-valuemin="0" aria-valuemax="<?= $r["san"] ?>"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
									<?php }
									if ($r["pe"] > 0) { ?>
                                        <div class="my-2">
                                            <strong>Esforço</strong>
                                            <div class="">
                                                <div class="position-absolute start-0 ps-2">
                                                    <button class="btn btn-sm text-secondary" onclick="updt('pe',-5,<?= $r["id"] ?>);">
                                                        <i class="fa-solid fa-chevrons-left"></i> -5
                                                    </button>
                                                    <button class="btn btn-sm text-secondary" onclick="updt('pe',-1,<?= $r["id"] ?>);">
                                                        <i class="fa-solid fa-chevron-left"></i> -1
                                                    </button>
                                                </div>
                                                <div class="position-absolute end-0 pe-2">
                                                    <button class="btn btn-sm text-secondary" onclick="updt('pe',1,<?= $r["id"] ?>);">
                                                        +1 <i class="fa-solid fa-chevron-right"></i>
                                                    </button>
                                                    <button class="btn btn-sm text-secondary" onclick="updt('pe',5,<?= $r["id"] ?>);">
                                                        +5 <i class="fa-solid fa-chevrons-right"></i>
                                                    </button>
                                                </div>
                                                <div class="pebar text-center py-1">
                                                    <span aria-label="pea" class="status"><?= $r["pea"] ?></span>/<span aria-label="pe" class="status"><?= $r["pe"] ?></span>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning" style="width: <?= TirarPorcento($r["pea"], $r["pe"]) ?>%;" role="progressbar" aria-valuenow="<?= $r["pea"] ?>" aria-valuemin="0" aria-valuemax="<?= $r["pe"] ?>"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
									<?php } ?>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-ataque<?= $r["id"] ?>" role="tabpanel" aria-labelledby="pills-ataque-tab<?= $r["id"] ?>" tabindex="0">
								
								<?php
								
								if ($r["passiva"] != 0 || $r["esquiva"] != 0) { ?>
                                    <div class="my-2">
                                    <strong>Defesas</strong>
                                    <div class="row m-2 g-2 justify-content-center">
										<?= pill("Passiva", $r["passiva"]) ?>
										<?= pill("Esquiva", $r["esquiva"]) ?>
                                    </div>
                                    </div><?php }
								
								
								if (!$r["morte"] == 0 || !$r["sangue"] == 0 || !$r["energia"] == 0 || !$r["conhecimento"] == 0 || !$r["mental"] == 0 || !$r["fisica"] == 0 || !$r["balistica"] == 0) { ?>
                                    <div class="my-2">
                                    <h4>Resistências</h4>
                                    <div class="row m-2 g-2 justify-content-center">
										
										<?= pill("Morte", $r["morte"]) ?>
										<?= pill("Sangue", $r["sangue"]) ?>
										<?= pill("Energia", $r["energia"]) ?>
										<?= pill("Conhecimento", $r["conhecimento"]) ?>
										<?= pill("Mental", $r["mental"]) ?>
										<?= pill("Física", $r["fisica"]) ?>
										<?= pill("Balística", $r["balistica"]) ?>


                                    </div>
                                    </div><?php }
								?>
                            </div>
                            <div class="tab-pane fade" id="pills-pericias<?= $r["id"] ?>" role="tabpanel" aria-labelledby="pills-pericias-tab<?= $r["id"] ?>" tabindex="0">
								<?php
								if ($r["acrobacia"] != 0 || $r["adestramento"] != 0 || $r["atletismo"] != 0 ||
									$r["atualidade"] != 0 || $r["artes"] != 0 || $r["ciencia"] != 0 || $r["diplomacia"] != 0 ||
									$r["enganacao"] != 0 || $r["fortitude"] != 0 || $r["furtividade"] != 0 ||
									$r["iniciativa"] != 0 || $r["intimidacao"] != 0 || $r["intuicao"] != 0 ||
									$r["investigacao"] != 0 || $r["luta"] != 0 || $r["medicina"] != 0 ||
									$r["ocultismo"] != 0 || $r["percepcao"] != 0 || $r["pilotagem"] != 0 ||
									$r["pontaria"] != 0 || $r["profissao"] != 0 || $r["reflexos"] != 0 ||
									$r["religiao"] != 0 || $r["sobrevivencia"] != 0 || $r["tatica"] != 0 ||
									$r["tecnologia"] != 0 || $r["vontade"] != 0) {
									?>
                                    <div class="mt-4 pericias">
                                        <h4>Perícias</h4>
                                        <div class="row g-2 m-2 justify-content-center">
											<?= pillbutton("Acobracia", $r["acrobacia"], true,       "rolar({dado:'{$r["agilidade"]}d20+{$r["acrobacia"]}',dano:0,nome:'Acobracia'})") ?>
											<?= pillbutton("Adestramento", $r["adestramento"], true, "rolar({dado:'{$r["presenca"]}d20+{$r["adestramento"]}',dano:0,nome:'Adestramento'})") ?>
											<?= pillbutton("Artes", $r["artes"], true, "rolar({dado:'{$r["presenca"]}d20+{$r["artes"]}',dano:0,nome:'Atualidade'})") ?>
											<?= pillbutton("Atletismo", $r["atletismo"], true, "rolar({dado:'{$r["forca"]}d20+{$r["atletismo"]}',nome:'Atletismo'})") ?>
											<?= pillbutton("Atualidade", $r["atualidade"], true, "rolar({dado:'{$r["inteligencia"]}d20+{$r["atualidade"]}', nome:'Atualidade'})") ?>
											<?= pillbutton("Ciência", $r["ciencia"], true, "rolar({dado:'{$r["inteligencia"]}d20+{$r["ciencia"]}', nome:'Ciência'})") ?>
											<?= pillbutton("Crime", $r["crime"], true, "rolar({dado:'{$r["agilidade"]}d20+{$r["crime"]}', nome:'Crime'})") ?>
											<?= pillbutton("Diplomacia", $r["diplomacia"], true, "rolar({dado:'{$r["presenca"]}d20+{$r["diplomacia"]}', nome:'Diplomacia'})") ?>
											<?= pillbutton("Enganação", $r["enganacao"], true, "rolar({dado:'{$r["presenca"]}d20+{$r["enganacao"]}', nome:'Enganação'})") ?>
											<?= pillbutton("Fortitude", $r["fortitude"], true, "rolar({dado:'{$r["vigor"]}d20+{$r["fortitude"]}', nome:'Fortitude'})") ?>
											<?= pillbutton("Furtividade", $r["furtividade"], true, "rolar({dado:'{$r["agilidade"]}d20+{$r["furtividade"]}', nome:'Furtividade'})") ?>
											<?= pillbutton("Iniciativa", $r["iniciativa"], true, "rolar({dado:'{$r["agilidade"]}d20+{$r["iniciativa"]}', nome:'Iniciativa'})") ?>
											<?= pillbutton("Intimidação", $r["intimidacao"], true, "rolar({dado:'{$r["presenca"]}d20+{$r["intimidacao"]}', nome:'Intimidação'})") ?>
											<?= pillbutton("Intuição", $r["intuicao"], true, "rolar({dado:'{$r["inteligencia"]}d20+{$r["intuicao"]}', nome:'Intuição'})") ?>
											<?= pillbutton("Investigação", $r["investigacao"], true, "rolar({dado:'{$r["inteligencia"]}d20+{$r["investigacao"]}', nome:'Investigação'})") ?>
											<?= pillbutton("Luta", $r["luta"], true, "rolar({dado:'{$r["forca"]}d20+{$r["luta"]}', nome:'Luta'})") ?>
											<?= pillbutton("Medicina", $r["medicina"], true, "rolar({dado:'{$r["inteligencia"]}d20+{$r["medicina"]}', nome:'Medicina'})") ?>
											<?= pillbutton("Ocultismo", $r["ocultismo"], true, "rolar({dado:'{$r["inteligencia"]}d20+{$r["ocultismo"]}', nome:'Ocultismo'})") ?>
											<?= pillbutton("Percepção", $r["percepcao"], true, "rolar({dado:'{$r["presenca"]}d20+{$r["percepcao"]}', nome:'Percepção'})") ?>
											<?= pillbutton("Pilotagem", $r["pilotagem"], true, "rolar({dado:'{$r["agilidade"]}d20+{$r["pilotagem"]}', nome:'Pilotagem'})") ?>
											<?= pillbutton("Pontaria", $r["pontaria"], true, "rolar({dado:'{$r["agilidade"]}d20+{$r["pontaria"]}', nome:'Pontaria'})") ?>
											<?= pillbutton("Profissão", $r["profissao"], true, "rolar({dado:'{$r["inteligencia"]}d20+{$r["profissao"]}', nome:'Profissão'})") ?>
											<?= pillbutton("Reflexos", $r["reflexos"], true, "rolar({dado:'{$r["agilidade"]}d20+{$r["reflexos"]}', nome:'Reflexos'})") ?>
											<?= pillbutton("Religião", $r["religiao"], true, "rolar({dado:'{$r["presenca"]}d20+{$r["religiao"]}', nome:'Religião'})") ?>
											<?= pillbutton("Sobrevivência", $r["sobrevivencia"], true, "rolar({dado:'{$r["inteligencia"]}d20+{$r["sobrevivencia"]}', nome:'Sobrevivência'})") ?>
											<?= pillbutton("Tática", $r["tatica"], true, "rolar({dado:'{$r["inteligencia"]}d20+{$r["tatica"]}', nome:'Tática'})") ?>
											<?= pillbutton("Tecnologia", $r["tecnologia"], true, "rolar({dado:'{$r["inteligencia"]}d20+{$r["tecnologia"]}', nome:'Tecnologia'})") ?>
											<?= pillbutton("Vontade", $r["vontade"], true, "rolar({dado:'{$r["presenca"]}d20+{$r["vontade"]}', nome:'Vontade'})") ?>
                                        </div>
                                    </div>
								<?php } ?>
                            </div>
                            <div class="tab-pane fade" id="pills-habilidades<?= $r["id"] ?>" role="tabpanel" aria-labelledby="pills-habilidades-tab<?= $r["id"] ?>" tabindex="0">
                                <div class="m-2">
                                    <label class="fs-4" for="ataque<?= $r["id"] ?>">Ataques</label><br>
                                    <textarea class="form-control" readonly id="ataque<?= $r["id"] ?>" name="ataques" type="text"><?= $r["ataques"] ?></textarea>
                                </div>
                                <div class="m-2">
                                    <label class="fs-4" for="habilidades<?= $r["id"] ?>">Habilidades</label><br>
                                    <textarea class="form-control" readonly id="habilidades<?= $r["id"] ?>" name="habilidades" type="text"><?= $r["habilidades"] ?></textarea>
                                </div>
                                <div class="m-2">
                                    <label class="fs-4" for="detalhes<?= $r["id"] ?>">Detalhes</label><br>
                                    <textarea class="form-control" readonly id="detalhes<?= $r["id"] ?>" name="detalhes" type="text"><?= $r["detalhes"] ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<?php
		}
	}
}

?>
<div class="col-12" id="npc">
    <div class="card h-100 border-secondary">
        <div class="card-header d-flex justify-content-between">
            <div class="d-flex">
                <h4 class="card-title m-0">Fichas NPCs</h4>
				<?php if (!isset($_GET["popout"])) { ?>
                    <button class="btn text-secondary fa-lg mx-1 p-1 popout" data-fop-pop="npc" style="height: 30px; width: 30px;">
                        <i class="fal fa-rectangle-vertical-history"></i>
                    </button>
				<?php } ?>
            </div>
            <div class="">
                <button class="btn btn-outline-success fa-lg p-1" data-bs-toggle="modal" data-bs-target="#addnpc">
                    <i class="fal fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="container-fluid p-0">
                <nav>
                    <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="aba-npc" data-bs-toggle="pill" data-bs-target="#guia-npc" type="button" role="tab" aria-controls="guia-npc" aria-selected="true">
                            NPC
                        </button>
                        <button class="nav-link" id="aba-npc" data-bs-toggle="pill" data-bs-target="#guia-monstro" type="button" role="tab" aria-controls="guia-monstro" aria-selected="false">
                            Monstros
                        </button>
                    </div>
                </nav>
                <div class="d-flex align-items-start">
                    <div class="tab-content container-fluid">
                        <div class="tab-pane fade show active" id="guia-npc" role="tabpanel" aria-labelledby="aba-npc" tabindex="0">
                            <div class="row m-2 g-2" id="fichasnpc">
								<?php
								Echo_FichaNPC($q["npcs"], "0")
								?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="guia-monstro" role="tabpanel" aria-labelledby="guia-monstro" tabindex="0">
                            <div class="row m-2 g-2" id="fichasmonstro">
								<?php
								Echo_FichaNPC($q["npcs"], "1")
								?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>