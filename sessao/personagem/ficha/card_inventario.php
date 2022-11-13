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
            <span class="fs-4 font6">Inventário</span>
			<?php if ($edit) { ?>
                <div class="float-end">
                    <button class="btn btn-sm text-warning fa-lg" data-bs-toggle="modal" data-bs-target="#editinv"
                            title="Editar Inventario">
                        <i class="fa-regular fa-pencil"></i>
                    </button>
                </div>
			<?php } ?>
        </div>
        <h4 class="text-center"><?= $espacosusados ?>/<?= $invmax?></h4>
        <div class="card-body p-0">
            <div class="py-2" id="inv">
				<?php if ($s[1]->num_rows > 0) { ?>
                    <h3 class="mx-2">Armas</h3>
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