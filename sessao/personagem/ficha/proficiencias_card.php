<div class="col">
    <div class="card h-100" id="card_proficiencias">
        <div class="card-header d-flex justify-content-between">
	        <?php if (!isset($_GET["popout"]) AND $edit) { ?>
            <div class="me-auto">
                    <button class="btn btn-sm text-secondary popout fa-lg" title="PopOut">
                        <i class="fa-regular fa-rectangle-vertical-history"></i>
                    </button>
            </div>
            <?php } ?>
            <h4 class="m-0">Proficiências</h4>
	        <?php if ($edit) { ?>
                <div class="ms-auto">
                    <button class="btn btn-sm text-warning fa-lg" data-bs-toggle="modal" data-bs-target="#editpro" title="Editar Proficiências">
                        <i class="fa-regular fa-pencil"></i>
                    </button>
                    <button class="btn btn-sm text-success fa-lg" data-bs-toggle="modal" data-bs-target="#addpro" title="Adicionar Proficiência">
                        <i class="fa-regular fa-square-plus"></i>
                    </button>
                </div>
		    <?php } ?>
        </div>
        <div class="card-body p-0 font1">
            <?php foreach ($s[3] as $r): ?>
                <div class="mx-4 my-3">
                    <div class="input-group">
                        <span id="<?= $r["nome"]; ?>" aria-label="<?= $r["nome"]; ?>"
                               class="input-group-text text-decoration-underline bg-body flex-grow-1"><?= $r["nome"]; ?></span>
                        <?php
                        if ($edit) {
                            ?>
                            <button class="btn btn-sm btn-outline-danger"
                                    title="Apagar Proeficiencia: '<?=$r["nome"]?>'"
                                    onclick="deletar(<?=$r["id"]?>,'<?=$r["nome"]?>','proficiencia')">
                                <i class="fa-regular fa-trash"></i>
                            </button>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
            endforeach;
            ?>
        </div>
    </div>
</div>
