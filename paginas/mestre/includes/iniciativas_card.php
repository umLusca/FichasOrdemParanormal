<div class="col-12 <?=isset($_GET["popout"])?:"col-md-6"?>" id="rodada">
    <div class="card h-100 border-secondary">
        <div class="card-body p-0">
            <div class="card-header d-flex">
                <h4 class="m-0">Iniciativas</h4>
	            <?php if (!isset($_GET["popout"])) { ?>
                    <button class="btn text-secondary fa-lg mx-1 p-1 popout" data-fop-pop="iniciativas" style="height: 30px; width: 30px;">
                        <i class="fal fa-rectangle-vertical-history"></i>
                    </button>
	            <?php } ?>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover table-bordered" id="iniciativa">
                    <colgroup>
                        <col style="width: 40px">
                        <col>
                        <col>
                        <col style="width: 80px">
                        <col style="width: 80px">
                        <col style="width: 80px">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>
                            <button type="button" class="btn btn-sm text-success" data-fop-initfunction="add">
                                <i class="fa-regular fa-square-plus"></i>
                            </button>
                        </th>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Iniciativa</th>
                        <th>Dano</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="ui-drag">
					<?php


					if ($q["iniciativas"]->num_rows) {
						foreach ($q["iniciativas"] as $i => $r) {
							$p = $i + 1;
                            ?>
                            <tr class="drag" data-fop-initid="<?=$r["id"]?>">
                                <input type="hidden" class="prioridade" name="init[<?=$i?>][p]" value="<?= $p ?>">
                                <input type="hidden" class="hidden" name="init[<?=$i?>][id]" value="<?= $r["id"] ?>">
                                <td class="">
                                    <button type="button" class="btn btn-sm up text-info" data-fop-initfunction="up"><i class="fa-solid fa-chevrons-up"></i></button>
                                </td>
                                <td class="index">
                                    <?=$p?>
                                </td>
                                <td class="iniciativa">
                                    <input type="text" style="min-width: 40px" autocomplete="off" name="init[<?=$i?>][n]" class="form-control form-control-plaintext form-control-sm" readonly value="<?= $r["nome"]; ?>">
                                </td>
                                <td class="iniciativa">
                                    <input type="number" style="min-width: 40px" autocomplete="off" name="init[<?=$i?>][i]" class="form-control form-control-plaintext form-control-sm" readonly value="<?= $r["iniciativa"]; ?>">
                                </td>
                                <td class="iniciativa">
                                    <input type="number" style="min-width: 40px" autocomplete="off" name="init[<?=$i?>][d]" class="form-control form-control-plaintext form-control-sm" readonly value="<?= $r["dano"]; ?>">
                                </td>
                                <td class="p-0">
                                    <div class="d-inline">
                                        <button type="button" class="btn down btn-sm text-info" data-fop-initfunction="down">
                                            <i class="fa-solid fa-chevrons-down"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm text-danger" data-fop-initfunction="delete">
                                            <i class="fa-regular fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
							<?php
						}} else { ?>
                        <tr>
                            <td></td>
                            <td class="index"></td>
                            <td>Crie uma iniciativa</td>
                            <td>adicionando um personagem.</td>
                            <td></td>
                            <td></td>
                        </tr>
						<?php
					}
					?>
                    </tbody>
                </table>
                <div class="card-footer border-0">
                        <span class="text-info"><i
                                    class="fa-regular fa-circle-info"></i> Clique duas vezes para editar.</span>
                </div>
            </div>
        </div>
    </div>
</div>