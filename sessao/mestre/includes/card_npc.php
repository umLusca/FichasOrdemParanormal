
<div class="col" id="npc">
    <div class="card h-100 w-100 bg-black border-light">
        <div class="card-body p-0">
            <div class="position-absolute end-0">
                <button class="btn text-success fa-lg" data-bs-toggle="modal" data-bs-target="#addnpc">
                    <i class="fa-regular fa-square-plus"></i>
                </button>
            </div>
            <div class="card-header border-0">
                <div class="card-title fs-2 text-center font6">Fichas NPCs</div>
            </div>
            <div class="container-fluid p-0">
                <nav>
                    <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="aba-npc" data-bs-toggle="pill" data-bs-target="#guia-npc" type="button" role="tab" aria-controls="guia-npc" aria-selected="true">NPC</button>
                        <button class="nav-link" id="aba-npc" data-bs-toggle="pill" data-bs-target="#guia-monstro" type="button" role="tab" aria-controls="guia-monstro" aria-selected="false">Monstros</button>
                    </div>
                </nav>
                <div class="d-flex align-items-start">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="guia-npc" role="tabpanel" aria-labelledby="aba-npc" tabindex="0">
                            <div class="row m-2" id="fichasnpc">
	                            <?php
	                            foreach ($fichanpcs as $r) {
		                            ?>
                                    <div class="col col-md-6 col-lg-4 col-xl-3 card-body border-0 text-center" id="npc<?= $r["id"] ?>">
                                        <div class="card bg-black border-light h-100">
                                            <button class="btn btn-sm text-danger position-absolute end-0" onclick="deletnpc(<?= $r["id"] ?>);"><i class="fa-regular fa-trash"></i></button>
                                            <button class="btn btn-sm text-warning position-absolute start-0" onclick="editnpc(<?= $r["id"] ?>);"><i class="fa-regular fa-pencil"></i></button>
                                            <div class="card-header border-0">
                                                <h4 class="card-title font4"><?= $r["nome"] ?></h4>
                                            </div>
                                            <ul class="nav nav-pills mb-3 justify-content-center" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="btn btn-outline text-light active" id="pills-principal-tab<?= $r["id"] ?>" data-bs-toggle="pill" data-bs-target="#pills-principal<?= $r["id"] ?>" type="button" role="tab" aria-controls="pills-principal<?= $r["id"] ?>" aria-selected="true">Principal</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="btn btn-outline text-light" id="pills-ataque-tab<?= $r["id"] ?>" data-bs-toggle="pill" data-bs-target="#pills-ataque<?= $r["id"] ?>" type="button" role="tab" aria-controls="pills-ataque<?= $r["id"] ?>" aria-selected="false">Defesas</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="btn btn-outline text-light" id="pills-pericias-tab<?= $r["id"] ?>" data-bs-toggle="pill" data-bs-target="#pills-pericias<?= $r["id"] ?>" type="button" role="tab" aria-controls="pills-pericias<?= $r["id"] ?>" aria-selected="false">Perícias</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="btn btn-outline text-light" id="pills-habilidades-tab<?= $r["id"] ?>" data-bs-toggle="pill" data-bs-target="#pills-habilidades<?= $r["id"] ?>" type="button" role="tab" aria-controls="pills-disabled<?= $r["id"] ?>" aria-selected="false">Outros</button>
                                                </li>
                                            </ul>
                                            <div class="card-body border-0">
                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="pills-principal<?= $r["id"] ?>" role="tabpanel" aria-labelledby="pills-principal-tab<?= $r["id"] ?>" tabindex="0">
                                                        <div class="my-2">
                                                            <strong>Atributos</strong>
                                                            <div class="row justify-content-center g-1 mt-2">
                                                                <div class="col-auto"><button class="btn btn-sm btn-outline-light" onclick="rolar('<?=ValorParaRolarDado($r["forca"])?>d20')">FOR: <?=($r["forca"])?></button></div>
                                                                <div class="col-auto"><button class="btn btn-sm btn-outline-light" onclick="rolar('<?=ValorParaRolarDado($r["agilidade"])?>d20')">AGI: <?=($r["agilidade"])?></button></div>
                                                                <div class="col-auto"><button class="btn btn-sm btn-outline-light" onclick="rolar('<?=ValorParaRolarDado($r["inteligencia"])?>d20')">INT: <?=($r["inteligencia"])?></button></div>
                                                                <div class="col-auto"><button class="btn btn-sm btn-outline-light" onclick="rolar('<?=ValorParaRolarDado($r["presenca"])?>d20')">PRE: <?=($r["presenca"])?></button></div>
                                                                <div class="col-auto"><button class="btn btn-sm btn-outline-light" onclick="rolar('<?=ValorParaRolarDado($r["vigor"])?>d20')">VIG: <?=($r["vigor"])?></button></div>
                                                            </div>
                                                        </div>
                                                        <div class="my-2">
                                                            <strong>Vida</strong>
                                                            <div class="">
                                                                <div class="position-absolute start-0 ps-2">
                                                                    <button class="btn btn-sm text-white" onclick="updtvida(-5,<?= $r["id"] ?>);">
                                                                        <i class="fa-solid fa-chevrons-left"></i> -5
                                                                    </button>
                                                                    <button class="btn btn-sm text-white" onclick="updtvida(-1,<?= $r["id"] ?>);">
                                                                        <i class="fa-solid fa-chevron-left"></i> -1
                                                                    </button>
                                                                </div>
                                                                <div class="position-absolute end-0 pe-2">
                                                                    <button class="btn btn-sm text-white" onclick="updtvida(1,<?= $r["id"] ?>);">
                                                                        +1 <i class="fa-solid fa-chevron-right"></i>
                                                                    </button>
                                                                    <button class="btn btn-sm text-white" onclick="updtvida(5,<?= $r["id"] ?>);">
                                                                        +5 <i class="fa-solid fa-chevrons-right"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="pvbar py-1 text-center">
                                                                    <span><?= $r["pva"] ?>/<?= $r["pv"] ?></span>
                                                                    <div class="progress">
                                                                        <div class="progress-bar bg-danger" style="width: <?= TirarPorcento($r["pva"], $r["pv"])?>%;" role="progressbar" aria-valuenow="<?= $r["pva"] ?>" aria-valuemin="0" aria-valuemax="<?= $r["pva"] ?>"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
								                            <?php if ($r["san"] > 0) {?>
                                                                <div class="my-2">
                                                                    <strong>Sanidade</strong>
                                                                    <div class="">
                                                                        <div class="position-absolute start-0 ps-2">
                                                                            <button class="btn btn-sm text-white" onclick="updtsan(-5,<?= $r["id"] ?>);">
                                                                                <i class="fa-solid fa-chevrons-left"></i> -5
                                                                            </button>
                                                                            <button class="btn btn-sm text-white" onclick="updtsan(-1,<?= $r["id"] ?>);">
                                                                                <i class="fa-solid fa-chevron-left"></i> -1
                                                                            </button>
                                                                        </div>
                                                                        <div class="position-absolute end-0 pe-2">
                                                                            <button class="btn btn-sm text-white" onclick="updtsan(1,<?= $r["id"] ?>);">
                                                                                +1 <i class="fa-solid fa-chevron-right"></i>
                                                                            </button>
                                                                            <button class="btn btn-sm text-white" onclick="updtsan(5,<?= $r["id"] ?>);">
                                                                                +5 <i class="fa-solid fa-chevrons-right"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="sanbar text-center py-1">
                                                                            <span><?= $r["sana"] ?>/<?= $r["san"] ?></span>
                                                                            <div class="progress">
                                                                                <div class="progress-bar bg-primary" style="width: <?= TirarPorcento($r["sana"] , $r["san"])?>%;" role="progressbar" aria-valuenow="<?= $r["sana"] ?>" aria-valuemin="0" aria-valuemax="<?= $r["san"] ?>"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
								                            <?php } if ($r["pe"] > 0) { ?>
                                                                <div class="my-2">
                                                                    <strong>Esforço</strong>
                                                                    <div class="">
                                                                        <div class="position-absolute start-0 ps-2">
                                                                            <button class="btn btn-sm text-white" onclick="updtpe(-5,<?= $r["id"] ?>);">
                                                                                <i class="fa-solid fa-chevrons-left"></i> -5
                                                                            </button>
                                                                            <button class="btn btn-sm text-white" onclick="updtpe(-1,<?= $r["id"] ?>);">
                                                                                <i class="fa-solid fa-chevron-left"></i> -1
                                                                            </button>
                                                                        </div>
                                                                        <div class="position-absolute end-0 pe-2">
                                                                            <button class="btn btn-sm text-white" onclick="updtpe(1,<?= $r["id"] ?>);">
                                                                                +1 <i class="fa-solid fa-chevron-right"></i>
                                                                            </button>
                                                                            <button class="btn btn-sm text-white" onclick="updtpe(5,<?= $r["id"] ?>);">
                                                                                +5 <i class="fa-solid fa-chevrons-right"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="pebar text-center py-1">
                                                                            <span><?= $r["pea"] ?>/<?= $r["pe"] ?></span>
                                                                            <div class="progress">
                                                                                <div class="progress-bar bg-warning" style="width: <?= TirarPorcento($r["pea"],$r["pe"]) * 100; ?>%;" role="progressbar" aria-valuenow="<?= $r["pea"] ?>" aria-valuemin="0" aria-valuemax="<?= $r["pe"] ?>"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
								                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="pills-ataque<?= $r["id"] ?>" role="tabpanel" aria-labelledby="pills-ataque-tab<?= $r["id"] ?>" tabindex="0">

							                            <?php

							                            if ($r["passiva"] !=0 || $r["esquiva"] != 0) {?>
                                                            <div class="my-2">
                                                            <strong>Defesas</strong>
                                                            <div class="row m-2 g-2 justify-content-center">
									                            <?= $r["passiva"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Passiva: ' . $r["passiva"] . '</span></div>' : "" ?>
									                            <?= $r["esquiva"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Esquiva: ' . $r["esquiva"] . '</span></div>' : "" ?>
                                                            </div>
                                                            </div><?php }


							                            if (!$r["morte"] == 0 and !$r["sangue"] == 0 and !$r["energia"] == 0 and !$r["conhecimento"] == 0 and !$r["mental"] == 0 and !$r["fisica"] == 0 and !$r["balistica"] == 0) {?>
                                                            <div class="my-2">
                                                            <h4>Resistências</h4>
                                                            <div class="row m-2 g-2 justify-content-center">
									                            <?= $r["morte"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Morte: ' . $r["morte"] . '</span></div>' : "" ?>
									                            <?= $r["sangue"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Sangue: ' . $r["sangue"] . '</span></div>' : "" ?>
									                            <?= $r["energia"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Energia: ' . $r["energia"] . '</span></div>' : "" ?>
									                            <?= $r["conhecimento"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Conhecimento: ' . $r["conhecimento"] . '</span></div>' : "" ?>
									                            <?= $r["mental"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Mental: ' . $r["mental"] . '</span></div>' : "" ?>
									                            <?= $r["fisica"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Física: ' . $r["fisica"] . '</span></div>' : "" ?>
									                            <?= $r["balistica"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Balística: ' . $r["balistica"] . '</span></div>' : "" ?>
                                                            </div>
                                                            </div><?php }
							                            ?>
                                                    </div>
                                                    <div class="tab-pane fade" id="pills-pericias<?= $r["id"] ?>" role="tabpanel" aria-labelledby="pills-pericias-tab<?= $r["id"] ?>" tabindex="0">
							                            <?php
							                            if (
								                            $r["acrobacia"]!=0 ||$r["adestramento"] !=0 ||$r["atletismo"] !=0 ||
								                            $r["atualidade"] !=0 ||$r["ciencia"] !=0 ||$r["diplomacia"] !=0 ||
								                            $r["enganacao"] !=0 ||$r["fortitude"] !=0 ||$r["furtividade"] !=0 ||
								                            $r["iniciativa"] !=0 ||$r["intimidacao"] !=0 ||$r["intuicao"] !=0 ||
								                            $r["investigacao"] !=0 || $r["luta"] !=0 || $r["medicina"]  !=0 ||
								                            $r["ocultismo"] !=0 || $r["percepcao"] !=0 || $r["pilotagem"] !=0 ||
								                            $r["pontaria"] !=0 ||$r["profissao"] !=0 || $r["reflexos"] !=0 ||
								                            $r["religiao"] !=0 || $r["sobrevivencia"] !=0 || $r["tatica"] !=0 ||
								                            $r["tecnologia"] !=0 || $r["vontade"] !=0){
								                            ?>
                                                            <div class="mt-4 pericias">
                                                                <h4>Perícias</h4>
                                                                <div class="row g-2 m-2 justify-content-center">
										                            <?= $r["acrobacia"] ? "<div class='col-auto m-1'><button class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["agilidade"]?:-2).'d20+'.$r["acrobacia"].'"'.")'>Acrobacia: +" . $r["acrobacia"] . "</button></div>" : "" ?>
										                            <?= $r["adestramento"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["presenca"]?:-2).'d20+'.$r["adestramento"].'"'.")'>Adestramento: +" . $r["adestramento"] . "</span></div>" : "" ?>
										                            <?= $r["atletismo"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["forca"]?:-2).'d20+'.$r["atletismo"].'"'.")'>Atletismo: +" . $r["atletismo"] . "</span></div>" : "" ?>
										                            <?= $r["atualidade"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["inteligencia"]?:-2).'d20+'.$r["atualidade"].'"'.")'>Atualidades: +" . $r["atualidade"] . "</span></div>" : "" ?>
										                            <?= $r["ciencia"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'   onclick='rolar(".'"'.($r["inteligencia"]?:-2).'d20+'.$r["ciencia"].'"'.")'>Ciências: +" . $r["ciencia"] . "</span></div>" : "" ?>
										                            <?= $r["crime"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["agilidade"]?:-2).'d20+'.$r["crime"].'"'.")'>Crime: +" . $r["crime"] . "</span></div>" : "" ?>
										                            <?= $r["diplomacia"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["presenca"]?:-2).'d20+'.$r["diplomacia"].'"'.")'>Diplomacia: +" . $r["diplomacia"] . "</span></div>" : "" ?>
										                            <?= $r["enganacao"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["presenca"]?:-2).'d20+'.$r["enganacao"].'"'.")'>Enganação: +" . $r["enganacao"] . "</span></div>" : "" ?>
										                            <?= $r["fortitude"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["vigor"]?:-2).'d20+'.$r["fortitude"].'"'.")'>Fortitude: +" . $r["fortitude"] . "</span></div>" : "" ?>
										                            <?= $r["furtividade"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["agilidade"]?:-2).'d20+'.$r["furtividade"].'"'.")'>Furtividade: +" . $r["furtividade"] . "</span></div>" : "" ?>
										                            <?= $r["iniciativa"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["agilidade"]?:-2).'d20+'.$r["iniciativa"].'"'.")'>Iniciativa: +" . $r["iniciativa"] . "</span></div>" : "" ?>
										                            <?= $r["intimidacao"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["presenca"]?:-2).'d20+'.$r["intimidacao"].'"'.")'>Intimidação: +" . $r["intimidacao"] . "</span></div>" : "" ?>
										                            <?= $r["intuicao"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["presenca"]?:-2).'d20+'.$r["intuicao"].'"'.")'>Intuição: +" . $r["intuicao"] . "</span></div>" : "" ?>
										                            <?= $r["investigacao"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["inteligencia"]?:-2).'d20+'.$r["investigacao"].'"'.")'>Investigação: +" . $r["investigacao"] . "</span></div>" : "" ?>
										                            <?= $r["luta"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["forca"]?:-2).'d20+'.$r["luta"].'"'.")'>Luta: +" . $r["luta"] . "</span></div>" : "" ?>
										                            <?= $r["medicina"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["inteligencia"]?:-2).'d20+'.$r["medicina"].'"'.")'>Medicina: +" . $r["medicina"] . "</span></div>" : "" ?>
										                            <?= $r["ocultismo"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["presenca"]?:-2).'d20+'.$r["ocultismo"].'"'.")'>Ocultismo: +" . $r["ocultismo"] . "</span></div>" : "" ?>
										                            <?= $r["percepcao"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["presenca"]?:-2).'d20+'.$r["percepcao"].'"'.")'>Percepção: +" . $r["percepcao"] . "</span></div>" : "" ?>
										                            <?= $r["pilotagem"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["agilidade"]?:-2).'d20+'.$r["pilotagem"].'"'.")'>Pilotagem: +" . $r["pilotagem"] . "</span></div>" : "" ?>
										                            <?= $r["pontaria"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["agilidade"]?:-2).'d20+'.$r["pontaria"].'"'.")'>Pontaria: +" . $r["pontaria"] . "</span></div>" : "" ?>
										                            <?= $r["profissao"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["inteligencia"]?:-2).'d20+'.$r["profissao"].'"'.")'>Profissão: +" . $r["profissao"] . "</span></div>" : "" ?>
										                            <?= $r["reflexos"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["agilidade"]?:-2).'d20+'.$r["reflexos"].'"'.")'>Reflexos: +" . $r["reflexos"] . "</span></div>" : "" ?>
										                            <?= $r["religiao"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["presenca"]?:-2).'d20+'.$r["religiao"].'"'.")'>Religião: +" . $r["religiao"] . "</span></div>" : "" ?>
										                            <?= $r["sobrevivencia"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["inteligencia"]?:-2).'d20+'.$r["sobrevivencia"].'"'.")'>Sobrevivência: +" . $r["sobrevivencia"] . "</span></div>" : "" ?>
										                            <?= $r["tatica"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["inteligencia"]?:-2).'d20+'.$r["tatica"].'"'.")'>Tática: +" . $r["tatica"] . "</span></div>" : "" ?>
										                            <?= $r["tecnologia"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["inteligencia"]?:-2).'d20+'.$r["tecnologia"].'"'.")'>Tecnologia: +" . $r["tecnologia"] . "</span></div>" : "" ?>
										                            <?= $r["vontade"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["presenca"]?:-2).'d20+'.$r["vontade"].'"'.")'>Vontade: +" . $r["vontade"] . "</span></div>" : "" ?>
                                                                </div>
                                                            </div>
							                            <?php } ?>
                                                    </div>
                                                    <div class="tab-pane fade" id="pills-habilidades<?= $r["id"] ?>" role="tabpanel" aria-labelledby="pills-habilidades-tab<?= $r["id"] ?>" tabindex="0">
                                                        <div class="m-2">
                                                            <label class="fs-4" for="ataque<?=$r["id"]?>">Ataques</label><br>
                                                            <textarea class="bg-black text-light w-100" readonly id="ataque<?=$r["id"]?>" name="ataques" type="text"><?=$r["ataques"]?></textarea>
                                                        </div>
                                                        <div class="m-2">
                                                            <label class="fs-4" for="habilidades<?=$r["id"]?>">Habilidades</label><br>
                                                            <textarea class="bg-black text-light w-100" readonly id="habilidades<?=$r["id"]?>" name="habilidades" type="text"><?=$r["habilidades"]?></textarea>
                                                        </div>
                                                        <div class="m-2">
                                                            <label class="fs-4" for="detalhes<?=$r["id"]?>">Detalhes</label><br>
                                                            <textarea class="bg-black text-light w-100" readonly id="detalhes<?=$r["id"]?>" name="detalhes" type="text"><?=$r["detalhes"]?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
		                            <?php
	                            }
	                            ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="guia-monstro" role="tabpanel" aria-labelledby="guia-monstro" tabindex="0">
                            <div class="row m-2" id="fichasmonstro">
		                        <?php
		                        foreach ($fichasmonstro as $r) {
			                        ?>
                                    <div class="col col-md-6 col-lg-4 col-xl-3 card-body border-0 text-center" id="npc<?= $r["id"] ?>">
                                        <div class="card bg-black border-light h-100">
                                            <button class="btn btn-sm text-danger position-absolute end-0" onclick="deletnpc(<?= $r["id"] ?>);"><i class="fa-regular fa-trash"></i></button>
                                            <button class="btn btn-sm text-warning position-absolute start-0" onclick="editnpc(<?= $r["id"] ?>);"><i class="fa-regular fa-pencil"></i></button>
                                            <div class="card-header border-0">
                                                <h4 class="card-title font4"><?= $r["nome"] ?></h4>
                                            </div>
                                            <ul class="nav nav-pills mb-3 justify-content-center" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="btn btn-outline text-light active" id="pills-principal-tab<?= $r["id"] ?>" data-bs-toggle="pill" data-bs-target="#pills-principal<?= $r["id"] ?>" type="button" role="tab" aria-controls="pills-principal<?= $r["id"] ?>" aria-selected="true">Principal</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="btn btn-outline text-light" id="pills-ataque-tab<?= $r["id"] ?>" data-bs-toggle="pill" data-bs-target="#pills-ataque<?= $r["id"] ?>" type="button" role="tab" aria-controls="pills-ataque<?= $r["id"] ?>" aria-selected="false">Defesas</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="btn btn-outline text-light" id="pills-pericias-tab<?= $r["id"] ?>" data-bs-toggle="pill" data-bs-target="#pills-pericias<?= $r["id"] ?>" type="button" role="tab" aria-controls="pills-pericias<?= $r["id"] ?>" aria-selected="false">Perícias</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="btn btn-outline text-light" id="pills-habilidades-tab<?= $r["id"] ?>" data-bs-toggle="pill" data-bs-target="#pills-habilidades<?= $r["id"] ?>" type="button" role="tab" aria-controls="pills-disabled<?= $r["id"] ?>" aria-selected="false">Outros</button>
                                                </li>
                                            </ul>
                                            <div class="card-body border-0">
                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="pills-principal<?= $r["id"] ?>" role="tabpanel" aria-labelledby="pills-principal-tab<?= $r["id"] ?>" tabindex="0">
                                                        <div class="my-2">
                                                            <strong>Atributos</strong>
                                                            <div class="row justify-content-center g-1 mt-2">
                                                                <div class="col-auto"><button class="btn btn-sm btn-outline-light" onclick="rolar('<?=ValorParaRolarDado($r["forca"])?>d20')">FOR: <?=($r["forca"])?></button></div>
                                                                <div class="col-auto"><button class="btn btn-sm btn-outline-light" onclick="rolar('<?=ValorParaRolarDado($r["agilidade"])?>d20')">AGI: <?=($r["agilidade"])?></button></div>
                                                                <div class="col-auto"><button class="btn btn-sm btn-outline-light" onclick="rolar('<?=ValorParaRolarDado($r["inteligencia"])?>d20')">INT: <?=($r["inteligencia"])?></button></div>
                                                                <div class="col-auto"><button class="btn btn-sm btn-outline-light" onclick="rolar('<?=ValorParaRolarDado($r["presenca"])?>d20')">PRE: <?=($r["presenca"])?></button></div>
                                                                <div class="col-auto"><button class="btn btn-sm btn-outline-light" onclick="rolar('<?=ValorParaRolarDado($r["vigor"])?>d20')">VIG: <?=($r["vigor"])?></button></div>
                                                            </div>
                                                        </div>
                                                        <div class="my-2">
                                                            <strong>Vida</strong>
                                                            <div class="">
                                                                <div class="position-absolute start-0 ps-2">
                                                                    <button class="btn btn-sm text-white" onclick="updtvida(-5,<?= $r["id"] ?>);">
                                                                        <i class="fa-solid fa-chevrons-left"></i> -5
                                                                    </button>
                                                                    <button class="btn btn-sm text-white" onclick="updtvida(-1,<?= $r["id"] ?>);">
                                                                        <i class="fa-solid fa-chevron-left"></i> -1
                                                                    </button>
                                                                </div>
                                                                <div class="position-absolute end-0 pe-2">
                                                                    <button class="btn btn-sm text-white" onclick="updtvida(1,<?= $r["id"] ?>);">
                                                                        +1 <i class="fa-solid fa-chevron-right"></i>
                                                                    </button>
                                                                    <button class="btn btn-sm text-white" onclick="updtvida(5,<?= $r["id"] ?>);">
                                                                        +5 <i class="fa-solid fa-chevrons-right"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="pvbar py-1 text-center">
                                                                    <span><?= $r["pva"] ?>/<?= $r["pv"] ?></span>
                                                                    <div class="progress">
                                                                        <div class="progress-bar bg-danger" style="width: <?= TirarPorcento($r["pva"], $r["pv"])?>%;" role="progressbar" aria-valuenow="<?= $r["pva"] ?>" aria-valuemin="0" aria-valuemax="<?= $r["pva"] ?>"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
									                        <?php if ($r["san"] > 0) {?>
                                                                <div class="my-2">
                                                                    <strong>Sanidade</strong>
                                                                    <div class="">
                                                                        <div class="position-absolute start-0 ps-2">
                                                                            <button class="btn btn-sm text-white" onclick="updtsan(-5,<?= $r["id"] ?>);">
                                                                                <i class="fa-solid fa-chevrons-left"></i> -5
                                                                            </button>
                                                                            <button class="btn btn-sm text-white" onclick="updtsan(-1,<?= $r["id"] ?>);">
                                                                                <i class="fa-solid fa-chevron-left"></i> -1
                                                                            </button>
                                                                        </div>
                                                                        <div class="position-absolute end-0 pe-2">
                                                                            <button class="btn btn-sm text-white" onclick="updtsan(1,<?= $r["id"] ?>);">
                                                                                +1 <i class="fa-solid fa-chevron-right"></i>
                                                                            </button>
                                                                            <button class="btn btn-sm text-white" onclick="updtsan(5,<?= $r["id"] ?>);">
                                                                                +5 <i class="fa-solid fa-chevrons-right"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="sanbar text-center py-1">
                                                                            <span><?= $r["sana"] ?>/<?= $r["san"] ?></span>
                                                                            <div class="progress">
                                                                                <div class="progress-bar bg-primary" style="width: <?= TirarPorcento($r["sana"] , $r["san"])?>%;" role="progressbar" aria-valuenow="<?= $r["sana"] ?>" aria-valuemin="0" aria-valuemax="<?= $r["san"] ?>"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
									                        <?php } if ($r["pe"] > 0) { ?>
                                                                <div class="my-2">
                                                                    <strong>Esforço</strong>
                                                                    <div class="">
                                                                        <div class="position-absolute start-0 ps-2">
                                                                            <button class="btn btn-sm text-white" onclick="updtpe(-5,<?= $r["id"] ?>);">
                                                                                <i class="fa-solid fa-chevrons-left"></i> -5
                                                                            </button>
                                                                            <button class="btn btn-sm text-white" onclick="updtpe(-1,<?= $r["id"] ?>);">
                                                                                <i class="fa-solid fa-chevron-left"></i> -1
                                                                            </button>
                                                                        </div>
                                                                        <div class="position-absolute end-0 pe-2">
                                                                            <button class="btn btn-sm text-white" onclick="updtpe(1,<?= $r["id"] ?>);">
                                                                                +1 <i class="fa-solid fa-chevron-right"></i>
                                                                            </button>
                                                                            <button class="btn btn-sm text-white" onclick="updtpe(5,<?= $r["id"] ?>);">
                                                                                +5 <i class="fa-solid fa-chevrons-right"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="pebar text-center py-1">
                                                                            <span><?= $r["pea"] ?>/<?= $r["pe"] ?></span>
                                                                            <div class="progress">
                                                                                <div class="progress-bar bg-warning" style="width: <?= TirarPorcento($r["pea"],$r["pe"]) * 100; ?>%;" role="progressbar" aria-valuenow="<?= $r["pea"] ?>" aria-valuemin="0" aria-valuemax="<?= $r["pe"] ?>"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
									                        <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="pills-ataque<?= $r["id"] ?>" role="tabpanel" aria-labelledby="pills-ataque-tab<?= $r["id"] ?>" tabindex="0">

								                        <?php

								                        if ($r["passiva"] !=0 || $r["esquiva"] != 0) {?>
                                                            <div class="my-2">
                                                            <strong>Defesas</strong>
                                                            <div class="row m-2 g-2 justify-content-center">
										                        <?= $r["passiva"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Passiva: ' . $r["passiva"] . '</span></div>' : "" ?>
										                        <?= $r["esquiva"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Esquiva: ' . $r["esquiva"] . '</span></div>' : "" ?>
                                                            </div>
                                                            </div><?php }


								                        if (!$r["morte"] == 0 and !$r["sangue"] == 0 and !$r["energia"] == 0 and !$r["conhecimento"] == 0 and !$r["mental"] == 0 and !$r["fisica"] == 0 and !$r["balistica"] == 0) {?>
                                                            <div class="my-2">
                                                            <h4>Resistências</h4>
                                                            <div class="row m-2 g-2 justify-content-center">
										                        <?= $r["morte"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Morte: ' . $r["morte"] . '</span></div>' : "" ?>
										                        <?= $r["sangue"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Sangue: ' . $r["sangue"] . '</span></div>' : "" ?>
										                        <?= $r["energia"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Energia: ' . $r["energia"] . '</span></div>' : "" ?>
										                        <?= $r["conhecimento"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Conhecimento: ' . $r["conhecimento"] . '</span></div>' : "" ?>
										                        <?= $r["mental"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Mental: ' . $r["mental"] . '</span></div>' : "" ?>
										                        <?= $r["fisica"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Física: ' . $r["fisica"] . '</span></div>' : "" ?>
										                        <?= $r["balistica"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Balística: ' . $r["balistica"] . '</span></div>' : "" ?>
                                                            </div>
                                                            </div><?php }
								                        ?>
                                                    </div>
                                                    <div class="tab-pane fade" id="pills-pericias<?= $r["id"] ?>" role="tabpanel" aria-labelledby="pills-pericias-tab<?= $r["id"] ?>" tabindex="0">
								                        <?php
								                        if (
									                        $r["acrobacia"]!=0 ||$r["adestramento"] !=0 ||$r["atletismo"] !=0 ||
									                        $r["atualidade"] !=0 ||$r["ciencia"] !=0 ||$r["diplomacia"] !=0 ||
									                        $r["enganacao"] !=0 ||$r["fortitude"] !=0 ||$r["furtividade"] !=0 ||
									                        $r["iniciativa"] !=0 ||$r["intimidacao"] !=0 ||$r["intuicao"] !=0 ||
									                        $r["investigacao"] !=0 || $r["luta"] !=0 || $r["medicina"]  !=0 ||
									                        $r["ocultismo"] !=0 || $r["percepcao"] !=0 || $r["pilotagem"] !=0 ||
									                        $r["pontaria"] !=0 ||$r["profissao"] !=0 || $r["reflexos"] !=0 ||
									                        $r["religiao"] !=0 || $r["sobrevivencia"] !=0 || $r["tatica"] !=0 ||
									                        $r["tecnologia"] !=0 || $r["vontade"] !=0){
									                        ?>
                                                            <div class="mt-4 pericias">
                                                                <h4>Perícias</h4>
                                                                <div class="row g-2 m-2 justify-content-center">
											                        <?= $r["acrobacia"] ? "<div class='col-auto m-1'><button class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["agilidade"]?:-2).'d20+'.$r["acrobacia"].'"'.")'>Acrobacia: +" . $r["acrobacia"] . "</button></div>" : "" ?>
											                        <?= $r["adestramento"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["presenca"]?:-2).'d20+'.$r["adestramento"].'"'.")'>Adestramento: +" . $r["adestramento"] . "</span></div>" : "" ?>
											                        <?= $r["atletismo"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["forca"]?:-2).'d20+'.$r["atletismo"].'"'.")'>Atletismo: +" . $r["atletismo"] . "</span></div>" : "" ?>
											                        <?= $r["atualidade"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["inteligencia"]?:-2).'d20+'.$r["atualidade"].'"'.")'>Atualidades: +" . $r["atualidade"] . "</span></div>" : "" ?>
											                        <?= $r["ciencia"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'   onclick='rolar(".'"'.($r["inteligencia"]?:-2).'d20+'.$r["ciencia"].'"'.")'>Ciências: +" . $r["ciencia"] . "</span></div>" : "" ?>
											                        <?= $r["crime"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["agilidade"]?:-2).'d20+'.$r["crime"].'"'.")'>Crime: +" . $r["crime"] . "</span></div>" : "" ?>
											                        <?= $r["diplomacia"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["presenca"]?:-2).'d20+'.$r["diplomacia"].'"'.")'>Diplomacia: +" . $r["diplomacia"] . "</span></div>" : "" ?>
											                        <?= $r["enganacao"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["presenca"]?:-2).'d20+'.$r["enganacao"].'"'.")'>Enganação: +" . $r["enganacao"] . "</span></div>" : "" ?>
											                        <?= $r["fortitude"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["vigor"]?:-2).'d20+'.$r["fortitude"].'"'.")'>Fortitude: +" . $r["fortitude"] . "</span></div>" : "" ?>
											                        <?= $r["furtividade"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["agilidade"]?:-2).'d20+'.$r["furtividade"].'"'.")'>Furtividade: +" . $r["furtividade"] . "</span></div>" : "" ?>
											                        <?= $r["iniciativa"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["agilidade"]?:-2).'d20+'.$r["iniciativa"].'"'.")'>Iniciativa: +" . $r["iniciativa"] . "</span></div>" : "" ?>
											                        <?= $r["intimidacao"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["presenca"]?:-2).'d20+'.$r["intimidacao"].'"'.")'>Intimidação: +" . $r["intimidacao"] . "</span></div>" : "" ?>
											                        <?= $r["intuicao"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["presenca"]?:-2).'d20+'.$r["intuicao"].'"'.")'>Intuição: +" . $r["intuicao"] . "</span></div>" : "" ?>
											                        <?= $r["investigacao"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["inteligencia"]?:-2).'d20+'.$r["investigacao"].'"'.")'>Investigação: +" . $r["investigacao"] . "</span></div>" : "" ?>
											                        <?= $r["luta"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["forca"]?:-2).'d20+'.$r["luta"].'"'.")'>Luta: +" . $r["luta"] . "</span></div>" : "" ?>
											                        <?= $r["medicina"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["inteligencia"]?:-2).'d20+'.$r["medicina"].'"'.")'>Medicina: +" . $r["medicina"] . "</span></div>" : "" ?>
											                        <?= $r["ocultismo"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["presenca"]?:-2).'d20+'.$r["ocultismo"].'"'.")'>Ocultismo: +" . $r["ocultismo"] . "</span></div>" : "" ?>
											                        <?= $r["percepcao"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["presenca"]?:-2).'d20+'.$r["percepcao"].'"'.")'>Percepção: +" . $r["percepcao"] . "</span></div>" : "" ?>
											                        <?= $r["pilotagem"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["agilidade"]?:-2).'d20+'.$r["pilotagem"].'"'.")'>Pilotagem: +" . $r["pilotagem"] . "</span></div>" : "" ?>
											                        <?= $r["pontaria"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["agilidade"]?:-2).'d20+'.$r["pontaria"].'"'.")'>Pontaria: +" . $r["pontaria"] . "</span></div>" : "" ?>
											                        <?= $r["profissao"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["inteligencia"]?:-2).'d20+'.$r["profissao"].'"'.")'>Profissão: +" . $r["profissao"] . "</span></div>" : "" ?>
											                        <?= $r["reflexos"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["agilidade"]?:-2).'d20+'.$r["reflexos"].'"'.")'>Reflexos: +" . $r["reflexos"] . "</span></div>" : "" ?>
											                        <?= $r["religiao"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["presenca"]?:-2).'d20+'.$r["religiao"].'"'.")'>Religião: +" . $r["religiao"] . "</span></div>" : "" ?>
											                        <?= $r["sobrevivencia"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["inteligencia"]?:-2).'d20+'.$r["sobrevivencia"].'"'.")'>Sobrevivência: +" . $r["sobrevivencia"] . "</span></div>" : "" ?>
											                        <?= $r["tatica"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["inteligencia"]?:-2).'d20+'.$r["tatica"].'"'.")'>Tática: +" . $r["tatica"] . "</span></div>" : "" ?>
											                        <?= $r["tecnologia"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["inteligencia"]?:-2).'d20+'.$r["tecnologia"].'"'.")'>Tecnologia: +" . $r["tecnologia"] . "</span></div>" : "" ?>
											                        <?= $r["vontade"] ? "<div class='col-auto m-1'><span class='btn btn-sm btn-outline-light'  onclick='rolar(".'"'.($r["presenca"]?:-2).'d20+'.$r["vontade"].'"'.")'>Vontade: +" . $r["vontade"] . "</span></div>" : "" ?>
                                                                </div>
                                                            </div>
								                        <?php } ?>
                                                    </div>
                                                    <div class="tab-pane fade" id="pills-habilidades<?= $r["id"] ?>" role="tabpanel" aria-labelledby="pills-habilidades-tab<?= $r["id"] ?>" tabindex="0">
                                                        <div class="m-2">
                                                            <label class="fs-4" for="ataque<?=$r["id"]?>">Ataques</label><br>
                                                            <textarea class="bg-black text-light w-100" readonly id="ataque<?=$r["id"]?>" name="ataques" type="text"><?=$r["ataques"]?></textarea>
                                                        </div>
                                                        <div class="m-2">
                                                            <label class="fs-4" for="habilidades<?=$r["id"]?>">Habilidades</label><br>
                                                            <textarea class="bg-black text-light w-100" readonly id="habilidades<?=$r["id"]?>" name="habilidades" type="text"><?=$r["habilidades"]?></textarea>
                                                        </div>
                                                        <div class="m-2">
                                                            <label class="fs-4" for="detalhes<?=$r["id"]?>">Detalhes</label><br>
                                                            <textarea class="bg-black text-light w-100" readonly id="detalhes<?=$r["id"]?>" name="detalhes" type="text"><?=$r["detalhes"]?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
			                        <?php
		                        }
		                        ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>