<div class="col">
    <div class="card h-100 bg-black border-light" id="card_habilidades">
        <div class="card-header clearfix p-0">
            <div class="float-start">
	            <?php if (!isset($_GET["popout"]) AND $edit) { ?>
                    <button class="btn btn-sm text-white fa-lg popout" title="PopOut">
                        <i class="fa-regular fa-rectangle-vertical-history"></i>
                    </button>
	            <?php }?>
            </div>
            <div class="float-end">
                <?php if ($edit) { ?>
                    <button class="btn btn-sm text-warning fa-lg" data-bs-toggle="modal" data-bs-target="#edithab" title="Editar Habilidades">
                        <i class="fa-regular fa-pencil"></i>
                    </button>
                    <button class="btn btn-sm text-success fa-lg" data-bs-toggle="modal" data-bs-target="#addhab" title="Adicionar Habilidade">
                        <i class="fa-regular fa-square-plus"></i>
                    </button>
                <?php }?>
            </div>
        </div>
        <div class="card-body p-0 font1">
            <nav>
                <div class="d-flex justify-content-center m-2" role="tablist">
                    <button class="btn btn-outline text-light active mx-2 fs-3" id="aba-habilidades" data-bs-toggle="tab" data-bs-target="#habilidades" type="button" role="tab" aria-controls="habilidades" aria-selected="true">Habilidades</button>
                    <button class="btn btn-outline text-light mx-2 fs-3" id="aba-poderes" data-bs-toggle="tab" data-bs-target="#poderes" type="button" role="tab" aria-controls="poderes" aria-selected="false">Poderes</button>
                </div>
            </nav>
            <div class="tab-content m-2">
                <div class="tab-pane fade show active" id="habilidades" role="tabpanel" aria-labelledby="aba-habilidades" tabindex="0">
                    <?php
                    foreach ($s[2] as $r):
                        ?>
                        <div class="m-3 clearfix">
                            <label for="h<?= $r["id"]; ?>" class="fs-4"><?= $r["nome"]; ?></label>
                            <?php
                            if ($edit) {
                                ?>
                                <button class="btn btn-sm fa fa-trash text-danger float-end"
                                        aria-label="Apagar Habilidade '<?= $r["nome"]; ?>'"
                                        onclick="deletar(<?=$r["id"]?>,'<?= $r["nome"]; ?>','delethab')"></button>
                            <?php }
                            ?>
                            <div class="font7">
                                <span>
                                    <?= $r["descricao"]; ?>
                                </span>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
                <div class="tab-pane fade" id="poderes" role="tabpanel" aria-labelledby="aba-poderes" tabindex="0">
                    <?php
                    foreach ($s[7] as $r):
                        ?>
                        <div class="m-3 clearfix">
                            <label for="p<?= $r["id"]; ?>" class="fs-4"><?= $r["nome"]; ?></label>
                            <?php
                            if ($edit) {
                                ?>
                                <button class="btn btn-sm fa fa-trash text-danger float-end" aria-label="Apagar poder '<?= $r["nome"]; ?>'" onclick="deletar(<?= $r["id"]; ?>,'<?= $r["nome"]?>','deletpod')"></button>
                            <?php }
                            ?>

                            <div class="font7">
                                <span><?= $r["descricao"]; ?></span>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>