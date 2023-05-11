<div class="col">
    <div class="card h-100" id="card_pericias">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="m-0 order-2">Perícias
                <i class="fal fa-info-circle text-info" role="button" data-bs-toggle="modal" data-bs-target="#modal_pericias"></i>
            </h4>

            <div class="order-1">
				<?php if (!isset($_GET["popout"]) and $edit) { ?>
                    <button class="btn btn-sm text-secondary fa-lg popout" title="PopOut">
                        <i class="fa-regular fa-rectangle-vertical-history"></i>
                    </button>
				<?php } ?>
                <button class="btn btn-sm text-info fa-lg toggleview" data-fop-status="0" title="Trocar Visualisação">
                    <i class="fal fa-arrow-down-a-z"></i>
                </button>
            </div>
			<?php if ($edit) { ?>
                <div class="text-end order-3">
                    <button class="btn btn-sm text-warning fa-lg" data-bs-toggle="modal" data-bs-target="#editper" title="Editar Pericias">
                        <i class="fa-regular fa-pencil"></i>
                    </button>
                </div>
			<?php } ?>
        </div>
        <div class="card-body font10">
            <div class="row row-cols-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 g-1 font11" id="pericias">
				<?php
				
				function button_per($uid, $label, $atr, int $bonus, $level, $name = false): void
				{
					global $edit;
					$level_color = match ($level) {
						default => $bonus === 0 ? "text-secondary" : "text-info",
						1 => "text-success",
						2 => "text-primary",
						3 => "text-warning",
					};
					
					?>
                    <div class="pericia <?= $level+$bonus?"":"hiddable" ?> col text-center p-0 m-0" data-fop-uid="<?= $uid ?>" data-fop-bonus="<?= $bonus ?>" data-fop-level="<?= $level ?>">
                        <button onclick="rolar({dado:'<?= "{$atr}d20+{$bonus}" ?>', dano: false, nome:'<?= $label ?>'});" class="btn btn-sm text-secondary mb-4 p-0 w-100 h-100">
                            <i class="fa-thin fa-dice-d20 fa-2x"></i><span class="fs-5">+<?= $bonus ?></span>
                            <span class="<?= $level_color ?> fs-5 d-block"><?= $label ?> <?= $name ? "($name)" : "" ?></span>
                        </button>
                        
                        
                    </div>
					<?php
				}
				
				
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
				$atrpericia["reflexo"] = "agi";
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
				function Trenado($bonus)
				{
					if ($bonus <= 4) {
						return "secondary";
					}
					if ($bonus >= 5 and $bonus <= 9) {
						return "success";
					}
					if ($bonus >= 10 and $bonus <= 14) {
						return "primary";
					}
					if ($bonus >= 15) {
						return "warning";
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
                <span class="text-secondary">Não treinadas</span>
                <span class="text-success">Treinadas</span>
                <span class="text-primary">Veterano</span>
                <span class="text-warning">Expert</span>
            </div>
        </div>
    </div>
</div>