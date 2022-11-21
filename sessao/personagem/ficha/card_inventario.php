<div class="col">
    <div class="card bg-black text-white border-light" id="card_inventario">
        <div class="card-header clearfix text-center p-0">
			<?php if ($edit) { ?>
                <div class="float-start">
					<?php if (!isset($_GET["popout"])) { ?>
                        <button class="btn btn-sm text-white fa-lg popout" title="PopOut">
                            <i class="fa-regular fa-rectangle-vertical-history"></i>
                        </button>
					<?php } ?>
                    <button class="btn btn-sm text-info fa-lg" id="vera" title="Ver informações inventario">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
			<?php } ?>
            <span class="fs-4 font6">Inventário (<?= $espacosusados ?>/<?= $invmax ?>)</span>
			<?php if ($edit) { ?>
                <div class="float-end">
                    <button class="btn btn-sm text-warning fa-lg" data-bs-toggle="modal" data-bs-target="#editinv"
                            title="Editar Inventario">
                        <i class="fa-regular fa-pencil"></i>
                    </button>
                </div>
			<?php } ?>
        </div>
        <div class="card-body p-0">
            <h3 class="text-center">Armas</h3>
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-1 m-2">
				<?php foreach ($s[1] as $i => $arma): ?>
                    <div class="col">
                        <div class="card h-100 border text-white bg-dark position-relative" id="arma<?= $arma["id"] ?>">
                            <div class="position-absolute end-0 top-0">
                                <button class="btn btn-sm btn-outline-warning" onclick="edit('arma',<?= $arma["id"] ?>)"><i class="fat fa-pencil"></i></button>
                            </div>
                            <img class="card-img-top oto" src="<?= $arma["foto"] ?>">
                            <div class="card-body p-0">
                                <div class="card-title text-center arma"><?= $arma["arma"] ?></div>
								<?php if (!empty($arma["tipo"])) { ?>
                                    <div class="input-group rounded-0">
                                        <span class="input-group-text rounded-0 bg-transparent text-light"><i class="fa-thin fa-seal-question"></i></span>
                                        <span class="form-control rounded-0 bg-transparent text-light tipo"><?= $arma["tipo"] ?></span>
                                    </div>
								<?php }
								if (!empty($arma["especial"])) {
									?>
                                    <div class="input-group rounded-0">
                                        <span class="input-group-text rounded-0 bg-transparent text-light"><i class="fa-thin fa-sparkles"></i></span>
                                        <span class="form-control rounded-0 bg-transparent text-light especial"><?= $arma["especial"] ?></span>
                                    </div>
								<?php }
								if (!empty($arma["recarga"])) {
									?>
                                    <div class="input-group rounded-0">
                                        <span class="input-group-text rounded-0 bg-transparent text-light"><i class="fa-thin fa-rotate"></i></span>
                                        <span class="form-control rounded-0 bg-transparent text-light recarga"><?= $arma["recarga"] ?></span>
                                    </div>
								<?php }
								if (!empty($arma["alcance"])) {
									?>
                                    <div class="input-group rounded-0">
                                        <span class="input-group-text rounded-0 bg-transparent text-light"><i class="fa-thin fa-crosshairs"></i></span>
                                        <span class="form-control rounded-0 bg-transparent text-light alcance"><?= $arma["alcance"] ?></span>
                                    </div>
								<?php } ?>
                                <div class="top-100 position-sticky">
									<?php if (!empty($arma["ataque"])) { ?>
                                        <div class="d-grid">
                                            <button class="btn btn-sm p-0 btn-outline-info rounded-0 ataque" data-dado="<?= $arma["ataque"] ?>" onclick='rolar("<?= DadoDinamico($arma['ataque'], $dc) ?>", 0, "Ataque Arma")'>
                                                Teste<br>
												<?= $arma["ataque"] ?>
                                            </button>
                                        </div>
									<?php }
									if (!empty($arma["dano"]) && !empty($arma["critico"])) {
										?>
                                        <div class="btn-group btn-group-sm btn-group-sm rounded-0 w-100">
											<?php if (!empty($arma["dano"])) { ?>
                                                <button class="btn btn-outline-danger position-relative rounded-0 p- dano" data-dado="<?= $arma["dano"] ?>" onclick="rolar('<?= $arma['dano'] ?>', 1, 'Dano Arma')">
                                                    Normal<br>
													<?= $arma["dano"] ?>
                                                </button>
											<?php }
											if (!empty($arma["critico"])) { ?>
                                                <button class="btn btn-outline-danger position-relative rounded-0 p-0 critico" data-margem="<?= $arma["margem"] ?>" data-dado="<?= $arma["critico"] ?>" onclick="rolar('<?= $arma['critico'] ?>', 1, 'Crítico Arma')">
                                                    Crítico<br>
													<?= $arma["critico"] ?>/<?= $arma["margem"] ?>
                                                </button>
											<?php } ?>
                                        </div>
									<?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
				<?php endforeach; ?>
                <div class="col">
                    <div class="card btn btn-outline-success bg-transparent border-dashed h-100" data-bs-toggle="modal" data-bs-target="#addarma">
                        <div class="m-auto">
                            <h2>Adicionar Arma</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-2" id="inv">
				<?php if ($s[1]->num_rows > 0) { ?>
                    (Essa tabela será removida em breve....)
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered border-dark bg-black text-white table-borderless font2"
                               id="armas">
                            <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th class="trocavision" scope="col" style="display: none;">Tipo</th>
                                <th class="trocavision" scope="col">Ataque</th>
                                <th class="trocavision" scope="col" style="display: none;">Alcance</th>
                                <th class="trocavision" scope="col">Dano</th>
                                <th class="trocavision" scope="col">Crítico</th>
                                <th class="trocavision" scope="col" style="display: none;">Recarga</th>
                                <th class="trocavision" scope="col" style="display: none;">Especial</th>
                            </tr>
                            </thead>
                            <tbody>
							<?php foreach ($s[1] as $row): ?>
                                <tr>
                                    <td><?php echo $row['arma']; ?></td>
                                    <td class="trocavision" style="display: none;"><?= $row['tipo'] ?></td>
                                    <td class="trocavision">
                                        <button class="btn btn-sm fw-bolder text-info" title="Rolar Ataque"
											<?php if ($edit) { ?>
                                                onclick='rolar("<?= DadoDinamico($row['ataque'], $dc) ?>", 0, "Ataque Arma")'
											<?php } else { ?>disabled<?php } ?>>
                                            <i class="fa-regular fa-dice"></i><?= $row["ataque"] ?>
                                        </button>
                                    </td>
                                    <td class="trocavision" style="display: none;"><?= $row['alcance']; ?></td>
                                    <td class="trocavision">
                                        <button class="btn btn-sm fw-bolder text-danger" title="Rolar Dano"
											<?php if ($edit) { ?>
                                                onclick="rolar('<?= $row['dano'] ?>', 1, 'Dano Arma')"
											<?php } else { ?>
                                                disabled
											<?php } ?>>
                                            <i class="fa-regular fa-dice"></i>
											<?= $row['dano'] ?>
                                        </button>
                                    </td>
                                    <td class="trocavision">
                                        <button class="btn btn-sm fw-bolder text-danger" title="Rolar Dano critico"
											<?php if ($edit) { ?>
                                                onclick="rolar('<?= $row['critico'] ?>', 1, 'Crítico Arma')"
											<?php } else { ?>
                                                disabled
											<?php } ?>>
                                            <i class="fa-regular fa-dice"></i>
											<?= $row['margem'] ? $row["margem"] . ' / ' : '' ?><?= $row['critico'] ?>
                                        </button>
                                    </td>
                                    <td class="trocavision" style="display: none;"><?= $row['recarga']; ?></td>
                                    <td class="trocavision" style="display: none;"><?= $row['especial']; ?></td>
                                </tr>
							<?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
					<?php
				}
				if ($s[4]->num_rows > 0) {
					?>
                    <h3 class="mx-2">Itens</h3>
                    <div class="table-responsive">

                        <table class="table table-bordered border-dark table-sm bg-black text-white table-borderless font2"
                               id="itens">
                            <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th class="trocavision" scope="col">Descrição</th>
                                <th class="trocavision" scope="col" style="display: none;">Espaços</th>
                                <th class="trocavision" scope="col" style="display: none;">Categoria</th>
                            </tr>
                            </thead>
                            <tbody>
							<?php foreach ($s[4] as $row): ?>
                                <tr>
                                    <td><?= $row['nome']; ?></td>
                                    <td class="trocavision"><?= $row['descricao']; ?></td>
                                    <td class="trocavision" style="display: none;"><?= $row['espaco']; ?></td>
                                    <td class="trocavision" style="display: none;"><?= $row['prestigio']; ?></td>
                                </tr>
							<?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
					<?php
				}
				?>
            </div>
        </div>
    </div>
</div>