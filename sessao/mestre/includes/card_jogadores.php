<div class="col-md-6" id="player">
    <div class="card bg-black border-light h-100">
        <div class="card-header text-center">
            <div class="position-absolute end-0">
                <button class="btn btn-outline-success fa-lg mx-1 p-1" data-bs-toggle="modal" data-bs-target="#adicionar">
                    <i class="fat fa-plus-large"></i>
                </button>
            </div>
            <h3 class="font6 m-0">Fichas Personagens</h3>
        </div>
        <div class="card-body p-0 font2">
            <div class="row row-cols-lg-2 row-cols-xxl-3 row-cols-1 g-2 p-2" id="fichasperson">
				<?php
				foreach ($jogadores as $ficha) {

					if ($ficha["peso_inv"] > 1) {
						$invmax = $ficha["peso_inv"];
					} else {
						$invmax = pesoinv($ficha["forca"], $ficha["inteligencia"], $ficha["classe"], $ficha["trilha"], $ficha["origem"]);
					}

					$s = $con->query("Select SUM(espaco) AS pesototal From `inventario` where `id_ficha` = '" . $ficha["id"] . "';");
					$ddinv = mysqli_fetch_array($s);
					$espacosusados = $ddinv["pesototal"];

					?>
                    <div class="col">
                        <div class="card-body h-100 p-0" id="player<?= $ficha["token"] ?>">
                            <div class="card h-100 bg-black border-light">
                                <div class="card-header">
                                    <a class="card-title fs-5 text-decoration-none" href="./../personagem/?token=<?= $ficha["token"] ?>">
                                        <span class="font7 link-light"><?= $ficha["nome"] ?></span>
                                        <i class="fat fa-arrow-up-right-from-square"></i>
                                    </a>
                                    <div class="float-end d-inline">
                                        <a class="btn btn-sm btn-outline-info" href="./../personagem/portrait/<?= ($id == 5887) ? "Espiral/" : '' ?>?token=<?= $ficha["token"] ?>"><i class="fa-solid fa-user"></i></a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="desvincular(<?= $ficha["id"] ?>)" title="Desvincular ficha"><i class="fa-solid fa-link-slash"></i></button>
                                    </div>
                                </div>
                                <div class="card-body p-0 border-0 text-center">
                                    <nav>
                                        <div class="btn-group" role="tablist">
                                            <button class="btn btn-sm btn-outline text-light active"
                                                    id="aba-principal-<?= $ficha["token"] ?>"
                                                    data-bs-target="#principal-<?= $ficha["token"] ?>"
                                                    aria-controls="nav-home" data-bs-toggle="tab" type="button"
                                                    role="tab" aria-selected="true">Principal
                                            </button>
                                            <button class="btn btn-sm btn-outline text-light"
                                                    id="aba-detalhes-<?= $ficha["token"] ?>"
                                                    data-bs-target="#detalhes-<?= $ficha["token"] ?>"
                                                    aria-controls="nav-profile" data-bs-toggle="tab" type="button"
                                                    role="tab" aria-selected="false">Detalhes
                                            </button>
                                            <button class="btn btn-sm btn-outline text-light"
                                                    id="aba-dados-<?= $ficha["token"] ?>"
                                                    data-bs-target="#dados-<?= $ficha["token"] ?>"
                                                    aria-controls="nav-contact" data-bs-toggle="tab" type="button"
                                                    role="tab" aria-selected="false">Dados
                                            </button>
                                            <button class="btn btn-sm btn-outline text-light"
                                                    id="aba-outros-<?= $ficha["token"] ?>"
                                                    data-bs-target="#outros-<?= $ficha["token"] ?>"
                                                    aria-controls="nav-disabled" data-bs-toggle="tab" type="button"
                                                    role="tab" aria-selected="false">Outros
                                            </button>
                                        </div>
                                    </nav>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active principal p-1"
                                             id="principal-<?= $ficha["token"] ?>" role="tabpanel"
                                             aria-labelledby="aba-principal-<?= $ficha["token"] ?>"
                                             tabindex="0">

                                            <div class="my-2">
                                                <span>PV: <?= $ficha["pva"] ?>/<?= $ficha["pv"] ?></span>
                                                <div class="progress">
                                                    <div class="progress-bar bg-danger" style="width: <?= TirarPorcento($ficha["pva"], $ficha["pv"]) ?>%;" role="progressbar"></div>
                                                </div>
                                            </div>
											<?php
											if ($ficha["san"]) {
												?>
                                                <div class="my-2">
                                                    <span>SAN: <?= $ficha["sana"] ?>/<?= $ficha["san"] ?></span>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-primary" style="width: <?= TirarPorcento($ficha["sana"], $ficha["san"]) ?>%;" role="progressbar"></div>
                                                    </div>
                                                </div>
											<?php } ?>
											<?php if ($ficha["pe"]) { ?>
                                                <div class="my-2">
                                                    <span>PE: <?= $ficha["pea"] ?>/<?= $ficha["pe"] ?></span>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning" style="width: <?= TirarPorcento($ficha["pea"], $ficha["pe"]) ?>%;" role="progressbar"></div>
                                                    </div>
                                                </div>
											<?php } ?>
                                            <div class="my-2 px-3">
                                                <span class="">Peso: <?= $espacosusados ?: "0" ?>/<?= $invmax ?></span>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade p-1" id="detalhes-<?= $ficha["token"] ?>" role="tabpanel"
                                             aria-labelledby="aba-detalhes-<?= $ficha["id"] ?>" tabindex="0">
                                            <div class="my-2">
                                                <span class="fs-6">Defesas</span>
                                                <div class="btn-group justify-content-center font6 w-100">
													<?= $ficha["passiva"] ? '<span class="btn btn-sm btn-outline-light">Passiva: ' . $ficha["passiva"] . '</span>' : ''
													?>

													<?= $ficha["esquiva"] ? '<span class="btn btn-sm btn-outline-light">Esquiva: ' . $ficha["esquiva"] . '</span>' : ''
													?>
													<?= $ficha["bloqueio"] ? '<span class="btn btn-sm btn-outline-light">Bloqueio: ' . $ficha["bloqueio"] . '</span>' : ''
													?>
                                                </div>
                                                <span class="fs-6">Resistencia</span>
                                                <div class="row g-2 justify-content-center">
													<?= $ficha["balistica"] ? '<div class="col-auto">
                                                                <span class="form-control form-control-sm border-light text-light bg-black">Balística: ' . $ficha["balistica"] . '</span>
                                                            </div>' : '' ?>

													<?= $ficha["fogo"] ? '
                                                        <div class="col-auto">
                                                            <span class="form-control form-control-sm border-light text-light bg-black">Fogo: ' . $ficha["fogo"] . '</span>
                                                        </div>' : ''
													?>

													<?= $ficha["fisica"] ? '
                                                        <div class="col-auto">
                                                            <span class="form-control form-control-sm border-light text-light bg-black">Física: ' . $ficha["fisica"] . '</span>
                                                        </div>' : ''
													?>
													<?= $ficha["insanidade"] ? '
                                                       <div class="col-auto">
                                                           <span class="form-control form-control-sm border-light text-light bg-black">Mental: ' . $ficha["insanidade"] . '</span>
                                                       </div>' : ''
													?>

													<?= $ficha["morte"] ? '
                                                        <div class="col-auto">
                                                            <span class="form-control form-control-sm border-light text-light bg-black">Morte: ' . $ficha["morte"] . '</span>
                                                        </div>' : ''
													?>

													<?= $ficha["conhecimento"] ? '
                                                        <div class="col-auto">
                                                            <span class="form-control form-control-sm border-light text-light bg-black">Conhecimento: ' . $ficha["conhecimento"] . '</span>
                                                        </div>' : ''
													?>
													<?= $ficha["sangue"] ? '
                                                        <div class="col-auto">
                                                            <span class="form-control form-control-sm border-light text-light bg-black">Sangue: ' . $ficha["sangue"] . '</span>
                                                        </div>' : ''
													?>

													<?= $ficha["energia"] ? '
                                                        <div class="col-auto">
                                                            <span class="form-control form-control-sm border-light text-light bg-black">Energia: ' . $ficha["energia"] . '</span>
                                                        </div>' : ''
													?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade p-1" id="dados-<?= $ficha["token"] ?>" role="tabpanel"
                                             aria-labelledby="aba-dados-<?= $ficha["id"] ?>" tabindex="0">
                                            <div class="m-2">
                                                <span class="fs-6">Atributos</span>
                                                <div class="row justify-content-center g-2">
                                                    <div class='col-auto'>
                                                        <span class='p-1 rounded-1 border'>FOR: <?= $ficha["forca"] ?></span>
                                                    </div>
                                                    <div class='col-auto'>
                                                        <span class='p-1 rounded-1 border'>AGI: <?= $ficha["agilidade"] ?></span>
                                                    </div>
                                                    <div class='col-auto'>
                                                        <span class='p-1 rounded-1 border'>INT: <?= $ficha["inteligencia"] ?></span>
                                                    </div>
                                                    <div class='col-auto'>
                                                        <span class='p-1 rounded-1 border'>PRE: <?= $ficha["presenca"] ?></span>
                                                    </div>
                                                    <div class='col-auto'>
                                                        <span class='p-1 rounded-1 border'>VIG: <?= $ficha["vigor"] ?></span>
                                                    </div>
                                                </div>
                                                <span class="fs-6">Perícias</span>
												<?php if ($ficha["acrobacia"] != 0 || $ficha["artes"] != 0 || $ficha["adestramento"] != 0 || $ficha["atletismo"] != 0 || $ficha["atualidade"] != 0 || $ficha["ciencia"] != 0 || $ficha["diplomacia"] != 0 || $ficha["enganacao"] != 0 || $ficha["fortitude"] != 0 || $ficha["furtividade"] != 0 || $ficha["iniciativa"] != 0 || $ficha["intimidacao"] != 0 || $ficha["intuicao"] != 0 || $ficha["investigacao"] != 0 || $ficha["luta"] != 0 || $ficha["medicina"] != 0 || $ficha["ocultismo"] != 0 || $ficha["percepcao"] != 0 || $ficha["pilotagem"] != 0 || $ficha["pontaria"] != 0 || $ficha["profissao"] != 0 || $ficha["reflexos"] != 0 || $ficha["religiao"] != 0 || $ficha["sobrevivencia"] != 0 || $ficha["tatica"] != 0 || $ficha["tecnologia"] != 0 || $ficha["vontade"] != 0) { ?>
                                                    <div class="row justify-content-center g-2">

														<?= $ficha["acrobacias"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Acrobacia: +" . $ficha["acrobacias"] . "</span></div>" : "" ?>
														<?= $ficha["adestramento"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Adestramento: +" . $ficha["adestramento"] . "</span></div>" : "" ?>
														<?= $ficha["artes"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Artes: +" . $ficha["artes"] . "</span></div>" : "" ?>
														<?= $ficha["atletismo"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Atletismo: +" . $ficha["atletismo"] . "</span></div>" : "" ?>
														<?= $ficha["atualidade"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Atualidades: +" . $ficha["atualidade"] . "</span></div>" : "" ?>
														<?= $ficha["ciencia"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Ciências: +" . $ficha["ciencia"] . "</span></div>" : "" ?>
														<?= $ficha["crime"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Crime: +" . $ficha["crime"] . "</span></div>" : "" ?>
														<?= $ficha["diplomacia"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Diplomacia: +" . $ficha["diplomacia"] . "</span></div>" : "" ?>
														<?= $ficha["enganacao"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Enganação: +" . $ficha["enganacao"] . "</span></div>" : "" ?>
														<?= $ficha["fortitude"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Fortitude: +" . $ficha["fortitude"] . "</span></div>" : "" ?>
														<?= $ficha["furtividade"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Furtividade: +" . $ficha["furtividade"] . "</span></div>" : "" ?>
														<?= $ficha["iniciativa"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Iniciativa: +" . $ficha["iniciativa"] . "</span></div>" : "" ?>
														<?= $ficha["intimidacao"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Intimidação: +" . $ficha["intimidacao"] . "</span></div>" : "" ?>
														<?= $ficha["intuicao"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Intuição: +" . $ficha["intuicao"] . "</span></div>" : "" ?>
														<?= $ficha["investigacao"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Investigação: +" . $ficha["investigacao"] . "</span></div>" : "" ?>
														<?= $ficha["luta"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Luta: +" . $ficha["luta"] . "</span></div>" : "" ?>
														<?= $ficha["medicina"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Medicina: +" . $ficha["medicina"] . "</span></div>" : "" ?>
														<?= $ficha["ocultismo"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Ocultismo: +" . $ficha["ocultismo"] . "</span></div>" : "" ?>
														<?= $ficha["percepcao"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Percepção: +" . $ficha["percepcao"] . "</span></div>" : "" ?>
														<?= $ficha["pilotagem"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Pilotagem: +" . $ficha["pilotagem"] . "</span></div>" : "" ?>
														<?= $ficha["pontaria"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Pontaria: +" . $ficha["pontaria"] . "</span></div>" : "" ?>
														<?= $ficha["profissao"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Profissão: +" . $ficha["profissao"] . "</span></div>" : "" ?>
														<?= $ficha["reflexos"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Reflexos: +" . $ficha["reflexos"] . "</span></div>" : "" ?>
														<?= $ficha["religiao"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Religião: +" . $ficha["religiao"] . "</span></div>" : "" ?>
														<?= $ficha["sobrevivencia"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Sobrevivência: +" . $ficha["sobrevivencia"] . "</span></div>" : "" ?>
														<?= $ficha["tatica"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Tática: +" . $ficha["tatica"] . "</span></div>" : "" ?>
														<?= $ficha["tecnologia"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Tecnologia: +" . $ficha["tecnologia"] . "</span></div>" : "" ?>
														<?= $ficha["vontade"] ? "<div class='col-auto'><span class='p-1 rounded-1 border'>Vontade: +" . $ficha["vontade"] . "</span></div>" : "" ?>
                                                    </div>
												<?php } ?>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade p-1" id="outros-<?= $ficha["token"] ?>" role="tabpanel"
                                             aria-labelledby="aba-outros-<?= $ficha["token"] ?>" tabindex="0">
                                            <div class="m-2">
                                                <span class="fs-6">Informações</span>
                                                <div class="row g-2 row-cols-1">
													<?= !empty($ficha["idade"]) ? "<span class='p-1 rounded-1 border'>Idade: " . $ficha["idade"] . "</span>" : "" ?>
													<?= !empty($ficha["local"]) ? "<span class='p-1 rounded-1 border'>Local: " . $ficha["local"] . "</span>" : "" ?>
													<?= !empty($ficha["origem"]) ? "<span class='p-1 rounded-1 border'>Origem: " . $ficha["origem"] . "</span>" : "" ?>
													<?= !empty($ficha["classe"]) ? "<span class='p-1 rounded-1 border'>Classe: " . $ficha["classe"] . "</span>" : "" ?>
													<?= !empty($ficha["trilha"]) ? "<span class='p-1 rounded-1 border'>Trilha: " . $ficha["trilha"] . "</span>" : "" ?>
													<?= !empty($ficha["patente"]) ? "<span class='p-1 rounded-1 border'>Patente: " . $ficha["patente"] . "</span>" : "" ?>
													<?= !empty($ficha["pp"]) ? "<span class='p-1 rounded-1 border'>P.P.: " . $ficha["pp"] . "</span>" : "" ?>
													<?= !empty($ficha["nex"]) ? "<span class='p-1 rounded-1 border'>NEX: " . $ficha["nex"] . "%</span>" : "" ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				<?php } ?>
            </div>
        </div>
    </div>
</div>