<div class="col">
    <div class="card h-100" id="card_principal">
        <div class="card-header d-flex justify-content-between">
			<?php if (!isset($_GET["popout"]) and $edit) { ?>
                <div class="float-start">
                    <button class="btn btn-sm text-secondary popout fa-lg" title="PopOut">
                        <i class="fal fa-rectangle-vertical-history"></i>
                    </button>
                </div>
			<?php } ?>
            <h4 class="m-0">Principal</h4>
			<?php if ($edit) { ?>
                <div class="float-end">
                    <button class="btn btn-sm text-warning fa-lg" data-bs-toggle="modal" data-bs-target="#editprincipal" title="Editar">
                        <i class="fal fa-pencil"></i>
                    </button>
                </div>
			<?php } ?>
        </div>
        <div class="card-body p-0">
            <div class="row g-0 m-2 justify-content-center">
				<?php if ($edit) { ?>
                    <div class="col-auto justify-content-center align-self-center" id="butmor">
                        <div class="card m-2">
                            <div class="card-header text-center">
                                <h5 class="m-0"><span>Portrait</span></h5>
                            </div>
                            <div class="card-body p-1">
                                <div class="row row-cols-auto justify-content-center text-center">
                                    <div>
                                        <h5>Status</h5>
                                        <div class="p-1">
                                            <input type="checkbox" class="btn-check" <?=isset($dados_missao)?"disabled":""?> id="combate" <?= $ficha["combate"] ? "checked" : "" ?>>
                                            <label class="d-grid btn btn-sm btn-outline-warning fw-bolder" for="combate">Combate</label>
                                        </div>
                                        <div class="p-1">
                                            <input type="checkbox" class="btn-check" id="morrendo" <?= $ficha["morrendo"] ? "checked" : "" ?>>
                                            <label class="d-grid btn btn-sm btn-outline-danger" for="morrendo">Morto</label>
                                        </div>
                                    </div>
                                    <div>
                                        <h5>Ocultar</h5>
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
				
				<?php } ?>
                <div class="col-auto text-center align-self-center" style="width: -webkit-fill-available; max-width: 190px;  aspect-ratio: 1/1">
                    <div class="position-relative">
                        <div class="position-absolute top-0 end-0">
                            <button class="btn btn-sm text-warning" data-bs-toggle="modal" data-bs-target="#editfoto" title="editar foto perfil">
                                <i class="fat fa-pencil"></i>
                            </button>
                        </div>
                        <img data-bs-toggle="modal" data-bs-target="#trocarficha" alt="Foto perfil" src="<?php
						if ($pva <= 0) {
							echo $urlphotomor;
						} else
							if ($sana <= 0) {
								if (TirarPorcento($pva, $pv) < 50) {
									echo $urlphotoef;
								} else {
									echo $urlphotoenl;
								}
							} else {
								if (TirarPorcento($pva, $pv) < 50) {
									echo $urlphotofer;
								} else {
									echo $urlphoto;
								}
							}
						
						
						?>" id="fotopersonagem" class="rounded-circle border img-fluid" style="aspect-ratio: 1/1"/>
                    </div>
                </div>
            </div>
            <div class="m-2">
                <div id="saude">
					<?php if ($ficha["pv"] > 0) { ?>
                        <h4 class="font6 pt-4 fs-4 text-center">Vida</h4>
                        <div class="d-flex justify-content-between">
							<?php if ($edit) { ?>
                                <div class="col-auto">
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(-5,'pv');">
                                        <i class="fa-solid fa-chevrons-left"></i> -5
                                    </button>
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(-1,'pv');">
                                        <i class="fa-solid fa-chevron-left"></i> -1
                                    </button>
                                </div>
							<?php } ?>
                            <div class="col fs-4 justify-content-center align-items-center font4 row g-0 dblclick">
                                <div class="col me-0">
                                    <input type="number" title="Vida Atual" min="<?= $minimo_PVA ?>" max="<?= $maximo_PV ?>" name="pva" value="<?= $pva ?>" class="pva border-0 vidaatual form-control form-control-sm text-end" readonly>
                                </div>
                                <div class="col-auto">/</div>
                                <div class="col ms-0">
                                    <input type="number" title="Vida Máxima" name="pv" min="1" max="<?= $maximo_PV ?>" value="<?= $pv ?>" class=" pv border-0 vidamaxima form-control form-control-sm" readonly>
                                </div>
                            </div>
							<?php if ($edit) { ?>
                                <div class="col-auto">
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(1,'pv');">
                                        +1 <i class="fa-solid fa-chevron-right"></i>
                                    </button>
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(5,'pv');">
                                        +5 <i class="fa-solid fa-chevrons-right"></i>
                                    </button>
                                </div>
							<?php } ?>
                        </div>
                        <div id="pv" class="float-none">
                            <div class="progress h-auto">
                                <div class="progress-bar bg-danger text-end" id="barrapva" role="progressbar" title="Vida" style="width:<?= $ppv; ?>%;height: 30px" aria-valuenow="<?= $pva ?>" aria-valuemin="0" aria-valuemax="<?= $pv ?>"></div>
                            </div>
                        </div>
					<?php } ?>
					
					<?php if ($san > 0) { ?>
                        <h4 class="font6 pt-4 fs-4 text-center">Sanidade</h4>
                        <div class="d-flex justify-content-between">
							<?php if ($edit) { ?>
                                <div class="col-auto">
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(-5,'san');">
                                        <i class="fa-solid fa-chevrons-left"></i> -5
                                    </button>
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(-1,'san');">
                                        <i class="fa-solid fa-chevron-left"></i> -1
                                    </button>
                                </div>
							<?php } ?>
                            <div class="col fs-4 justify-content-center align-items-center font4 row g-0 dblclick">
                                <div class="col me-0">
                                    <input type="number" title="Sanidade Atual" name="sana" min="<?= $minimo_SANA ?>" max="<?= $maximo_SAN ?>" value="<?= $sana ?>" class="sana border-0 sanatual form-control form-control-sm text-end" readonly>
                                </div>
                                <div class="col-auto">/</div>
                                <div class="col ms-0">
                                    <input type="number" title="Sanidade Máxima" name="san" min="1" max="<?= $maximo_SAN ?>" value="<?= $san ?>" class="san border-0 sanmaxima form-control form-control-sm" readonly>
                                </div>
                            </div>
							<?php if ($edit) { ?>
                                <div class="col-auto">
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(1,'san');">
                                        +1 <i class="fa-solid fa-chevron-right"></i>
                                    </button>
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(5,'san');">
                                        +5 <i class="fa-solid fa-chevrons-right"></i>
                                    </button>
                                </div>
							<?php } ?>
                        </div>
                        <div id="san" class="float-none">
                            <div class="progress h-auto">
                                <div class="progress-bar bg-primary" id="barrasana" role="progressbar" title="Sanidade" style="width:<?= $psan; ?>%;height: 30px" aria-valuenow="<?= $sana ?>" aria-valuemin="0" aria-valuemax="<?= $san ?>"></div>
                            </div>
                        </div>
					<?php }
					
					if ($pe > 0) {
						?>

                        <h4 class="font6 pt-4 text-center">Esforço</h4>
                        <div class="d-flex justify-content-between">
							<?php if ($edit) { ?>
                                <div class="col-auto">
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(-5,'pe');">
                                        <i class="fa-solid fa-chevrons-left"></i> -5
                                    </button>
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(-1,'pe');">
                                        <i class="fa-solid fa-chevron-left"></i> -1
                                    </button>
                                </div>
							<?php } ?>
                            <div class="fs-4 justify-content-center mx-auto align-items-center font4 row g-0 dblclick">
                                <div class="col-5 me-0">
                                    <input type="number" title="PE Atual" name="pea" min="<?= $minimo_PEA ?>" max="<?= $maximo_PE ?>" value="<?= $pea ?>" class="pea border-0 peatual form-control form-control-sm text-end" readonly>
                                </div>
                                <div class="col-auto">/</div>
                                <div class="col-5 ms-0">
                                    <input type="number" title="PE Máximo" name="pe" min="1" max="<?= $maximo_PE ?>" value="<?= $pe ?>" class="pe border-0 pemaxima form-control form-control-sm" readonly>
                                </div>
                            </div>
							<?php if ($edit) { ?>
                                <div class="col-auto">
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(1,'pe');">
                                        +1 <i class="fa-solid fa-chevron-right"></i>
                                    </button>
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(5,'pe');">
                                        +5 <i class="fa-solid fa-chevrons-right"></i>
                                    </button>
                                </div>
							<?php } ?>
                        </div>
                        <div id="pe" class="float-none">
                            <div class="progress h-auto">
                                <div class="progress-bar bg-warning" id="barrapea" role="progressbar" title="Esforço" style="width:<?= $ppe; ?>%;height: 30px" aria-valuenow="<?= $pea ?>" aria-valuemin="0" aria-valuemax="<?= $pe ?>"></div>
                            </div>
                        </div>
					<?php }
					if ($ficha["balas"] > 0) {
						?>

                        <h4 class="font6 pt-4 text-center">Munição</h4>
                        <div class="d-flex justify-content-between">
							<?php if ($edit) { ?>
                                <div class="col-auto">
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(-2,'bala');">
                                        <i class="fa-solid fa-chevrons-left"></i> -2
                                    </button>
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(-1,'bala');">
                                        <i class="fa-solid fa-chevron-left"></i> -1
                                    </button>
                                </div>
							<?php } ?>
                            <div class="fs-4 justify-content-center mx-auto align-items-center font4 row g-0 dblclick">
                                <div class="col-5 me-0">
                                    <input type="number" title="Balas restantes" name="balaa" min="0" max="50" value="<?= $ficha["balasusadas"] ?>" class="balaa border-0 peatual form-control form-control-sm text-end" readonly>
                                </div>
                                <div class="col-auto">/</div>
                                <div class="col-5 ms-0">
                                    <input type="number" title="Balas total" name="bala" min="0" max="50" value="<?= $ficha["balas"] ?>" class="bala border-0 pemaxima form-control form-control-sm" readonly>
                                </div>
                            </div>
							<?php if ($edit) { ?>
                                <div class="col-auto">
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(1,'bala');">
                                        +1 <i class="fa-solid fa-chevron-right"></i>
                                    </button>
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(2,'bala');">
                                        +2 <i class="fa-solid fa-chevrons-right"></i>
                                    </button>
                                </div>
							<?php } ?>
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
				
				<?php
				if ($passiva > 0 || $esquiva > 0 || $bloqueio > 0) {
					?>
                    <h4 class="font6 mt-4 text-center">Defesas</h4>
                    <div class="row justify-content-center">
						<?= pill("Passiva", $passiva) ?>
						<?= pill("Esquiva", $esquiva) ?>
						<?= pill("Bloqueio", $bloqueio) ?>
                    </div>
				<?php }
				if ($balistica > 0 or $fisica > 0 or $conhecimento > 0 or $morte > 0 or $sangue > 0 or $energia > 0 or $insanidade > 0) { ?>
                    <h4 class="font6 pt-4 text-center">Resistencias</h4>
                    <div class="row justify-content-center g-2">
						<?= pill("Físico", $fisica) ?>
						<?= pill("Balístico", $balistica) ?>
						<?= pill("Mental", $insanidade) ?>
						<?= pill("Morte", $morte) ?>
						<?= pill("Conhecimento", $conhecimento) ?>
						<?= pill("Sangue", $sangue) ?>
						<?= pill("Energia", $energia) ?>
						<?= pill("Corte", $corte) ?>
						<?= pill("Impacto", $impacto) ?>
						<?= pill("Perfuração", $perfuracao) ?>
						<?= pill("Elétrico", $eletricidade) ?>
						<?= pill("Fogo", $fogo) ?>
						<?= pill("Frio", $frio) ?>
						<?= pill("Químico", $quimica) ?>
                    </div>
				<?php } ?>
            </div>
        </div>
    </div>
</div>
