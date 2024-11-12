<card-status class="card h-100">
    <div class="card-header p-1 position-relative justify-content-between">
        <div class="position-absolute end-0">
            <button class="btn py-0 btn-sm text-warning" data-bs-toggle="modal" data-bs-target="#editprincipal" title="Editar">
                <i class="fal fa-pencil fa-lg"></i>
            </button>
        </div>
        <h5 class="m-0 text-center">Status</h5>
    </div>
    <div class="card-body p-0">
        <ul class="nav nav-tabs px-2 mt-2" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="card-status .paginas .painelStatus" type="button" role="tab">Status</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="card-status .paginas .painelAtributos" type="button" role="tab">Atributos</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="card-status .paginas .painelPericias" type="button" role="tab">Perícias</button>
            </li>
        </ul>

        <div class="tab-content paginas">
            <div class="tab-pane fade p-1 painelStatus show active" role="tabpanel" tabindex="0">
                <div class="row g-0 m-2 justify-content-evenly">

                    <div class="col-auto justify-content-center align-self-center" id="butmor">
                        <div class="card m-2">

                            <div class="card-body p-0">
                                <h5 class="m-0 text-center">Portrait</h5>
                                <hr class="my-1">
                                <div class="row row-cols-auto justify-content-center text-center m-1">
                                    <div>
                                        <h6>Status</h6>
                                        <div class="p-1">
                                            <input type="checkbox" class="btn-check" <?= isset($dados_missao) ? "disabled" : "" ?> id="combate" <?= $ficha["combate"] ? "checked" : "" ?>>
                                            <label class="d-grid btn btn-sm btn-outline-warning fw-bolder" for="combate">Combate</label>
                                        </div>
                                        <div class="p-1">
                                            <input type="checkbox" class="btn-check" id="morrendo" <?= $ficha["morrendo"] ? "checked" : "" ?>>
                                            <label class="d-grid btn btn-sm btn-outline-danger" for="morrendo">Morto</label>
                                        </div>
                                    </div>
                                    <div>
                                        <h6>Ocultar</h6>
                                        <div class="p-1">
                                            <input type="checkbox" class="btn-check" id="opv" <?= $ficha["opv"] ? "checked" : "" ?>>
                                            <label class="d-grid btn btn-sm btn-outline-danger" for="opv">Vida</label>
                                        </div>
                                        <div class="p-1">
                                            <input type="checkbox" class="btn-check" id="osan" <?= $ficha["osan"] ? "checked" : "" ?>>
                                            <label class="d-grid btn btn-sm btn-outline-primary" for="osan">Sanidade</label>
                                        </div>
                                        <div class="p-1">
                                            <input type="checkbox" class="btn-check" id="ope" <?= $ficha["ope"] ? "checked" : "" ?>>
                                            <label class="d-grid btn btn-sm btn-outline-warning" for="ope">Esforço</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto text-center align-self-center" style="width: -webkit-fill-available; max-width: 190px;  aspect-ratio: 1/1">
                        <div class="position-relative">
                            <div class="position-absolute top-0 end-0">
                                <button class="btn btn-sm text-warning" data-bs-toggle="modal" data-bs-target="#editfoto" title="editar foto perfil">
                                    <i class="fat fa-pencil"></i>
                                </button>
                            </div>
                            <div class="rounded-circle border h-100 w-100 overflow-hidden" style="aspect-ratio: 1/1">
                                <img data-bs-toggle="modal" data-bs-target="#trocarficha" alt="" src="" id="fotopersonagem" class="w-100 h-100" style="aspect-ratio: 1/1 "/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-2">
                    <div class="d-flex flex-column gap-2">
                        <barra class="d-block dblclick" data-barra="vida" data-min="0" data-max="pv" data-value="pva">
                            <div class="d-flex justify-content-between">
                                <div class="col-auto edit">
                                    <button class="btn btn-sm text-body-emphasis" data-update="-5">
                                        <i class="fa-solid fa-chevrons-left"></i> -5
                                    </button>
                                    <button class="btn btn-sm text-body-emphasis" data-update="-1">
                                        <i class="fa-solid fa-chevron-left"></i> -1
                                    </button>
                                </div>

                                <span class="fs-5 font2 m-0 text-center">Vida</span>

                                <div class="col-auto edit">
                                    <button class="btn btn-sm text-body-emphasis" data-update="+1">
                                        +1 <i class="fa-solid fa-chevron-right"></i>
                                    </button>
                                    <button class="btn btn-sm text-body-emphasis" data-update="+5">
                                        +5 <i class="fa-solid fa-chevrons-right"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="">
                                <div class="progress position-relative" style="height: 30px">
                                    <div class="w-100 font1 dblclick position-absolute d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <input class="border-0 text-body-emphasis form-control form-control-sm bg-transparent text-end" input-value type="number" readonly>
                                        </div>
                                        <div class="">
                                            <i class="far fa-xl fa-slash-forward text-body-emphasis"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <input class="border-0 text-body-emphasis form-control form-control-sm bg-transparent" input-max type="number" readonly>
                                        </div>
                                    </div>
                                    <div class="progress-bar bg-danger overflow-visible" data-barra role="progressbar" style="">


                                    </div>
                                </div>
                            </div>
                        </barra>
                        <barra class="d-block" data-barra="sanidade" data-min="0" data-max="san" data-value="sana">
                            <div class="d-flex justify-content-between">
                                <div class="col-auto edit">
                                    <button class="btn btn-sm text-body-emphasis" data-update="-5">
                                        <i class="fa-solid fa-chevrons-left"></i> -5
                                    </button>
                                    <button class="btn btn-sm text-body-emphasis" data-update="-1">
                                        <i class="fa-solid fa-chevron-left"></i> -1
                                    </button>
                                </div>

                                <span class="fs-5 font2 m-0 text-center">Sanidade</span>

                                <div class="col-auto edit">
                                    <button class="btn btn-sm text-body-emphasis" data-update="+1">
                                        +1 <i class="fa-solid fa-chevron-right"></i>
                                    </button>
                                    <button class="btn btn-sm text-body-emphasis" data-update="+5">
                                        +5 <i class="fa-solid fa-chevrons-right"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="">
                                <div class="progress position-relative" style="height: 30px">
                                    <div class="w-100 font1 dblclick position-absolute d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <input class="border-0 text-body-emphasis form-control form-control-sm bg-transparent text-end" input-value type="number" readonly>
                                        </div>
                                        <div class="">
                                            <i class="far fa-xl fa-slash-forward text-body-emphasis"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <input class="border-0 text-body-emphasis form-control form-control-sm bg-transparent" input-max type="number" readonly>
                                        </div>
                                    </div>
                                    <div class="progress-bar bg-primary overflow-visible" data-barra role="progressbar" style="">


                                    </div>
                                </div>
                            </div>
                        </barra>
                        <barra class="d-block" data-barra="esforco" data-min="0" data-max="pe" data-value="pea">
                            <div class="d-flex justify-content-between">
                                <div class="col-auto edit">
                                    <button class="btn btn-sm text-body-emphasis" data-update="-5">
                                        <i class="fa-solid fa-chevrons-left"></i> -5
                                    </button>
                                    <button class="btn btn-sm text-body-emphasis" data-update="-1">
                                        <i class="fa-solid fa-chevron-left"></i> -1
                                    </button>
                                </div>

                                <span class="fs-5 font2 m-0 text-center">Esforço</span>

                                <div class="col-auto edit">
                                    <button class="btn btn-sm text-body-emphasis" data-update="+1">
                                        +1 <i class="fa-solid fa-chevron-right"></i>
                                    </button>
                                    <button class="btn btn-sm text-body-emphasis" data-update="+5">
                                        +5 <i class="fa-solid fa-chevrons-right"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="">
                                <div class="progress position-relative" style="height: 30px">
                                    <div class="w-100 font1 dblclick position-absolute d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <input class="border-0 text-body-emphasis form-control form-control-sm bg-transparent text-end" input-value type="number" readonly>
                                        </div>
                                        <div class="">
                                            <i class="far fa-xl fa-slash-forward text-body-emphasis"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <input class="border-0 text-body-emphasis form-control form-control-sm bg-transparent" input-max type="number" readonly>
                                        </div>
                                    </div>
                                    <div class="progress-bar bg-warning overflow-visible" data-barra role="progressbar" style="">


                                    </div>
                                </div>
                            </div>
                        </barra>
                    </div>
					
					<?php if ($ficha["balas"] > 0) { ?>

                        <h4 class="font6 pt-4 text-center">Munição</h4>
                        <div class="d-flex justify-content-between">

                            <div class="col-auto">
                                <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(-2,'bala');">
                                    <i class="fa-solid fa-chevrons-left"></i> -2
                                </button>
                                <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(-1,'bala');">
                                    <i class="fa-solid fa-chevron-left"></i> -1
                                </button>
                            </div>
                            <div class="fs-4 justify-content-center mx-auto align-items-center font4 row g-0 dblclick">
                                <div class="col-5 me-0">
                                    <input type="number" title="Balas restantes" name="balaa" min="0" max="50" value="<?= $ficha["balasusadas"] ?>" class="balaa border-0 peatual form-control form-control-sm text-end" readonly>
                                </div>
                                <div class="col-auto">/</div>
                                <div class="col-5 ms-0">
                                    <input type="number" title="Balas total" name="bala" min="0" max="50" value="<?= $ficha["balas"] ?>" class="bala border-0 pemaxima form-control form-control-sm" readonly>
                                </div>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(1,'bala');">
                                    +1 <i class="fa-solid fa-chevron-right"></i>
                                </button>
                                <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(2,'bala');">
                                    +2 <i class="fa-solid fa-chevrons-right"></i>
                                </button>
                            </div>

                        </div>
                        <div id="bala" class="float-none">
                            <div class="progress h-auto position-relative rounded-0">
                                <div class="progress-bar bg-warning" id="barrabalaa" role="progressbar" title="Munição" style="width:<?= TirarPorcento($ficha["balasusadas"], $ficha["balas"]) ?>%;height: 30px" aria-valuenow="<?= $ficha["balasusadas"] ?>" aria-valuemin="0" aria-valuemax="<?= $ficha["balas"] ?>">
                                    <div class="position-absolute w-100 hstack justify-content-around">
										<?php for ($i = 0; $i < $ficha["balas"]; $i++) { ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="" style="height: 30px; fill: var(--bs-secondary-bg)" viewBox="199 -2 103 505">
                                                <path d="M293.946,456.778c0.107-0.386,0.213-0.773,0.293-1.175l6.715-26.02c0-0.63,0-1.261-0.026-1.891    c0.012-0.207,0.026-0.413,0.026-0.627V227.368c0.194-1.279,0.193-2.59-0.209-3.795c-0.304-1.485-0.945-2.761-1.863-3.772    l-14.715-29.431v-48.682c0-33.574-5.036-67.987-15.108-100.721L258.987,4.875C257.308,1.518,253.951-1,250.593-1    s-6.715,2.518-8.393,5.875l-10.072,36.092c-10.072,32.734-15.108,67.148-15.108,100.721v47.843l-15.948,31.895    c-1.315,1.972-1.585,4.455-0.839,6.651v198.988c0,0.214,0.014,0.42,0.026,0.627c-0.026,0.63-0.026,1.261-0.026,1.891l6.715,25.18    c0.165,0.823,0.401,1.613,0.674,2.385c-4.539,3.823-7.389,9.56-7.389,16.081v9.233c0,10.911,9.233,20.144,20.984,20.144h58.754    c11.751,0,20.984-9.233,21.823-20.144v-9.233C301.793,466.493,298.75,460.595,293.946,456.778z M223.734,451.407l-4.197-15.948    h62.111l-4.197,15.948c0,0-0.839,0.839-1.679,0.839h-51.2C223.734,452.246,223.734,452.246,223.734,451.407z M267.38,183.656    h-33.574v-33.574h33.574V183.656z M230.449,200.443h40.289l8.393,16.787h-57.075L230.449,200.443z M284.167,234.016v184.656    H217.02V234.016H284.167z M248.075,46.003l2.518-9.233l2.518,9.233c8.394,28.538,13.43,57.915,14.269,87.292h-33.574    C234.646,103.918,239.682,74.541,248.075,46.003z M284.167,482.462c0,1.679-1.679,3.357-3.357,3.357h-59.593    c-2.518,0-4.197-1.679-4.197-3.357v-9.233c0-2.518,1.679-4.197,4.197-4.197h3.357h52.039h3.357c2.518,0,4.197,1.679,4.197,4.197 V482.462z"></path>
                                            </svg>
										<?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
					<?php } ?>
                </div>

                <h4 class="font6 mt-4 text-center">Defesas</h4>
                <div class="row justify-content-center">
					<?= pill("Passiva", $ficha["passiva"]) ?>
					<?= pill("Esquiva", $ficha["esquiva"]) ?>
					<?= pill("Bloqueio", $ficha["bloqueio"]) ?>
                </div>
                <h4 class="font6 pt-4 text-center">Resistências</h4>
                <div class="row justify-content-center g-2">
					<?= pill("Físico", $ficha["fisico"]) ?>
					<?= pill("Balístico", $ficha["balistico"]) ?>
					<?= pill("Mental", $ficha["insanidade"]) ?>
					<?= pill("Morte", $ficha["morte"]) ?>
					<?= pill("Conhecimento", $ficha["conhecimento"]) ?>
					<?= pill("Sangue", $ficha["sangue"]) ?>
					<?= pill("Energia", $ficha["energia"]) ?>
					<?= pill("Corte", $ficha["corte"]) ?>
					<?= pill("Impacto", $ficha["impacto"]) ?>
					<?= pill("Perfuração", $ficha["perfuracao"]) ?>
					<?= pill("Elétrico", $ficha["eletrico"]) ?>
					<?= pill("Fogo", $ficha["fogo"]) ?>
					<?= pill("Frio", $ficha["frio"]) ?>
					<?= pill("Químico", $ficha["quimico"]) ?>
                </div>

            </div>

            <div class="tab-pane fade p-1 painelAtributos" role="tabpanel" tabindex="0">
                <div class="mx-1">
                    <i class="fa-regular fa-circle-info"></i>
                    <span> clique para rolar dados</span>
                </div>
				
				<?= atributos($ficha["forca"], $ficha["agilidade"], $ficha["inteligencia"], $ficha["vigor"], $ficha["presenca"], true) ?>

            </div>
            <div class="tab-pane fade p-1 painelPericias" role="tabpanel" tabindex="0">

                <button class="btn btn-sm btn-outline-info m-2 fa-lg toggleview" data-fop-status="0" title="Trocar Visualisação">
                    <i class="fal fa-arrow-down-a-z"></i> Trocar Ordem das perícias
                </button>
                <div class="row row-cols-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 g-1 font11" id="pericias">
					<?php
					
					function button_per($uid, $label, $atr, int $bonus, $level, $name = false): string
					{
						global $edit;
						$level_color = match ($level) {
							default => $bonus === 0 ? "text-secondary" : "text-info",
							1 => "text-success",
							2 => "text-primary",
							3 => "text-warning",
						};
						return '<div class="pericia ' . ($level + $bonus ? "" : "hiddable") . ' col text-center p-0 m-0" data-fop-uid="' . $uid . '" data-fop-bonus="' . $bonus . '" data-fop-level="' . $level . '">
                            <button onclick="rolar({dado:\'' . "{$atr}d20+{$bonus}" . '\', dano: false, nome:\'' . $label . '\'});" class="btn btn-sm text-secondary mb-4 p-0 w-100 h-100">
                            <i class="fa-thin fa-dice-d20 fa-2x"></i>
                            <span class="fs-5">+' . $bonus . '</span>
                            <span class="' . $level_color . ' fs-5 d-block">' . $label . ' ' . ($name ? "($name)" : "") . '</span>
                            </button>
                        </div>';
					}
					
					?>
					
					<?php
					
					
					$atrpericia = $atrpericia = [];
					$atrpericia["acrobacias"] = "agi";
					$atrpericia["adestramento"] = "pre";
					$atrpericia["atletismo"] = "for";
					$atrpericia["artes"] = "pre";
					$atrpericia["atualidades"] = "int";
					$atrpericia["ciencia"] = "int";
					
					$atrpericia["crime"] = "agi";
					$atrpericia["diplomacia"] = "pre";
					$atrpericia["enganacao"] = "pre";
					$atrpericia["fortitude"] = "vig";
					$atrpericia["furtividade"] = "agi";
					
					$atrpericia["iniciativa"] = "agi";
					$atrpericia["intimidacao"] = "pre";
					$atrpericia["intuicao"] = "pre";
					$atrpericia["investigacao"] = "int";
					$atrpericia["luta"] = "for";
					
					$atrpericia["medicina"] = "int";
					$atrpericia["ocultismo"] = "int";
					$atrpericia["percepcao"] = "pre";
					$atrpericia["pilotagem"] = "agi";
					$atrpericia["pontaria"] = "agi";
					
					$atrpericia["profissao"] = "int";
					$atrpericia["reflexos"] = "agi";
					$atrpericia["religiao"] = "pre";
					$atrpericia["sobrevivencia"] = "int";
					$atrpericia["tatica"] = "int";
					
					$atrpericia["tecnologia"] = "int";
					$atrpericia["vontade"] = "pre";
					
					
					foreach ($atrpericia as $pericia => $atr) {
						switch ($atr) {
							case "for":
								$valoratr = $ficha["forca"];
								break;
							case "agi":
								$valoratr = $ficha["agilidade"] ?: 0;
								break;
							case "int":
								$valoratr = $ficha["inteligencia"] ?: 0;
								break;
							case "pre":
								$valoratr = $ficha["presenca"] ?: 0;
								break;
							case "vig":
								$valoratr = $ficha["vigor"] ?: 0;
								break;
						}
						if ($valoratr === 0) {
							$atrpericia[$pericia] = -2;
						} elseif ($valoratr <= 1) {
							$atrpericia[$pericia] = $valoratr - 2;
						} else {
							$atrpericia[$pericia] = $valoratr;
						}
					}
     
					?>
					<?= button_per("acro", "Acrobacias", $atrpericia["acrobacias"], $ficha["acrobacias"], $ficha["tacrobacias"]) ?>
					<?= button_per("ades", "Adestramento", $atrpericia["adestramento"], $ficha["adestramento"], $ficha["tadestramento"]) ?>
					<?= button_per("arte", "Artes", $atrpericia["artes"], $ficha["artes"], $ficha["tartes"]) ?>
					<?= button_per("atle", "Atletismo", $atrpericia["atletismo"], $ficha["atletismo"], $ficha["tatletismo"]) ?>
					<?= button_per("atua", "Atualidades", $atrpericia["atualidades"], $ficha["atualidades"], $ficha["tatualidades"]) ?>
					<?= button_per("cien", "Ciência", $atrpericia["ciencia"], $ficha["ciencia"], $ficha["tciencia"], $ficha["nciencia"]) ?>
					<?= button_per("crim", "Crime", $atrpericia["crime"], $ficha["crime"], $ficha["tcrime"]) ?>
					<?= button_per("dipl", "Diplomacia", $atrpericia["diplomacia"], $ficha["diplomacia"], $ficha["tdiplomacia"]) ?>
					<?= button_per("enga", "Enganação", $atrpericia["enganacao"], $ficha["enganacao"], $ficha["tenganacao"]) ?>
					<?= button_per("fort", "Fortitude", $atrpericia["fortitude"], $ficha["fortitude"], $ficha["tfortitude"]) ?>
					<?= button_per("furt", "Furtividade", $atrpericia["furtividade"], $ficha["furtividade"], $ficha["tfurtividade"]) ?>
					<?= button_per("inic", "Iniciativa", $atrpericia["iniciativa"], $ficha["iniciativa"], $ficha["tiniciativa"]) ?>
					<?= button_per("inti", "Intimidação", $atrpericia["intimidacao"], $ficha["intimidacao"], $ficha["tintimidacao"]) ?>
					<?= button_per("intu", "Intuição", $atrpericia["intuicao"], $ficha["intuicao"], $ficha["tintuicao"]) ?>
					<?= button_per("inve", "Investigação", $atrpericia["investigacao"], $ficha["investigacao"], $ficha["tinvestigacao"]) ?>
					<?= button_per("luta", "Luta", $atrpericia["luta"], $ficha["luta"], $ficha["tluta"]) ?>
					<?= button_per("medi", "Medicina", $atrpericia["medicina"], $ficha["medicina"], $ficha["tmedicina"]) ?>
					<?= button_per("ocul", "Ocultismo", $atrpericia["ocultismo"], $ficha["ocultismo"], $ficha["tocultismo"]) ?>
					<?= button_per("perc", "Percepção", $atrpericia["percepcao"], $ficha["percepcao"], $ficha["tpercepcao"]) ?>
					<?= button_per("pilo", "Pilotagem", $atrpericia["pilotagem"], $ficha["pilotagem"], $ficha["tpilotagem"]) ?>
					<?= button_per("pont", "Pontaria", $atrpericia["pontaria"], $ficha["pontaria"], $ficha["tpontaria"]) ?>
					<?= button_per("prof", "Profissão", $atrpericia["profissao"], $ficha["profissao"], $ficha["tprofissao"], $ficha["nprofissao"]) ?>
					<?= button_per("refl", "Reflexos", $atrpericia["reflexos"], $ficha["reflexos"], $ficha["treflexo"]) ?>
					<?= button_per("reli", "Religião", $atrpericia["religiao"], $ficha["religiao"], $ficha["treligiao"]) ?>
					<?= button_per("sobr", "Sobrevivência", $atrpericia["sobrevivencia"], $ficha["sobrevivencia"], $ficha["tsobrevivencia"]) ?>
					<?= button_per("tati", "Tática", $atrpericia["tatica"], $ficha["tatica"], $ficha["ttatica"]) ?>
					<?= button_per("tecn", "Tecnologias", $atrpericia["tecnologia"], $ficha["tecnologia"], $ficha["ttecnologia"]) ?>
					<?= button_per("vont", "Vontade", $atrpericia["vontade"], $ficha["vontade"], $ficha["tvontade"]) ?>

                </div>
                <div class="text-center m-2">
                    <span class="text-secondary">Destreinadas</span>
                    <span class="text-info">Apenas Bônus</span>
                    <span class="text-success">Treinadas</span>
                    <span class="text-primary">Veterano</span>
                    <span class="text-warning">Expert</span>
                </div>
            </div>
        </div>


    </div>
</card-status>
