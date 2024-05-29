<div class="col">
    <div class="card h-100" id="card_habilidades">
        <div class="card-header d-flex justify-content-center">
			<?php if (!isset($_GET["popout"]) and $edit) { ?>
                <div class="me-auto">
                    <button class="btn btn-sm text-secondary fa-lg popout" title="PopOut">
                        <i class="fa-regular fa-rectangle-vertical-history"></i>
                    </button>
                </div>
			<?php } ?>
            <nav>
                <div class="d-flex justify-content-center nav nav-pills" role="tablist">
                    <button class="btn btn-sm btn-outline-primary active mx-2" id="aba-habilidades" data-bs-toggle="tab" data-bs-target="#habilidades" type="button" role="tab" aria-controls="habilidades" aria-selected="true">
                        Habilidades
                    </button>
                    <button class="btn btn-sm btn-outline-primary mx-2" id="aba-poderes" data-bs-toggle="tab" data-bs-target="#poderes" type="button" role="tab" aria-controls="poderes" aria-selected="false">
                        Poderes
                    </button>
                </div>
            </nav>
			<?php if ($edit) { ?>
                <div class="ms-auto">
                    <button class="btn btn-sm text-success fa-lg" data-bs-toggle="modal" data-bs-target="#addhab" title="Adicionar Habilidade">
                        <i class="fa-regular fa-square-plus"></i>
                    </button>
                </div>
			<?php } ?>
        </div>
        <div class="card-body p-0 font1">
            <div class="tab-content m-2">
                <div class="tab-pane fade show active" id="habilidades" role="tabpanel" aria-labelledby="aba-habilidades" tabindex="0">
					<?php
					foreach ($s[2] as $r):
						?>
                        <div class="m-3" data-fop-hab="<?= $r["id"]?>">
							<?php if ($edit) { ?>
                                <div class="float-end">
                                    <button class="btn btn-sm fat fa-pencil text-warning" aria-label="Editar Habilidade '<?= $r["nome"] ?>'" onclick="editarhab(<?= $r["id"] ?>,'hab')"></button>
                                    <button class="btn btn-sm fat fa-trash text-danger" aria-label="Apagar Habilidade '<?= $r["nome"] ?>'" onclick="deletar(<?= $r["id"] ?>,'<?= $r["nome"] ?>','habilidade')"></button>
                                </div>
							<?php } ?>
                            <h4 class="m-0 habname"><?= $r["nome"]?></h4>
                            <p class="habdesc"><?= nl2br($r["descricao"])?></p>
                        </div>
					<?php
					endforeach;
					?>
                </div>
                <div class="tab-pane fade" id="poderes" role="tabpanel" aria-labelledby="aba-poderes" tabindex="0">
					<?php
					foreach ($s[7] as $r):
						?>
                        <div class="m-3" data-fop-pod="<?= $r["id"]?>">
							<?php if ($edit) { ?>
                                <div class="float-end">
                                    <button class="btn btn-sm fal fa-pencil text-warning" aria-label="Editar poder '<?= $r["nome"]; ?>'" onclick="editarhab(<?= $r["id"]?>,'pod')"></button>
                                    <button class="btn btn-sm fal fa-trash text-danger" aria-label="Apagar poder '<?= $r["nome"] ?>'" onclick="deletar(<?= $r["id"]; ?>,'<?= $r["nome"] ?>','poder')"></button>
                                </div>
							<?php } ?>
                            <h4 class="m-0 podname"><?= $r["nome"]; ?></h4>
                            <p class="poddesc"><?= nl2br($r["descricao"]); ?></p>
                        </div>
					<?php
					endforeach;
					?>
                </div>
            </div>
        </div>
    </div>
</div>