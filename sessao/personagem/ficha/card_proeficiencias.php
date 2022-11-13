<div class="col">
    <div class="card h-100 bg-black border-light" id="card_proeficiencias">
        <div class="card-header clearfix text-center p-0">
	        <?php if (!isset($_GET["popout"]) AND $edit) { ?>
            <div class="float-start">
                    <button class="btn btn-sm text-white popout fa-lg" title="PopOut">
                        <i class="fa-regular fa-rectangle-vertical-history"></i>
                    </button>
            </div>
            <?php } ?>
            <span class="font6 fs-4">Proficiências</span>
	        <?php if ($edit) { ?>
                <div class="float-end">
                    <button class="btn btn-sm text-warning fa-lg" data-bs-toggle="modal" data-bs-target="#editpro" title="Editar proficiências">
                        <i class="fa-regular fa-pencil"></i>
                    </button>
                    <button class="btn btn-sm text-success fa-lg" data-bs-toggle="modal" data-bs-target="#addpro" title="Adicionar Proeficiência">
                        <i class="fa-regular fa-square-plus"></i>
                    </button>
                </div>
		    <?php } ?>
        </div>
        <div class="card-body p-0 font1">
            <?php foreach ($s[3] as $r): ?>
                <div class="mx-4 my-3">
                    <div class="input-group">
                        <input id="<?= $r["nome"]; ?>" aria-label="<?= $r["nome"]; ?>"
                               class="form-control bg-black text-decoration-underline text-light" disabled
                               value="<?= $r["nome"]; ?>"/>
                        <?php
                        if ($edit) {
                            ?>
                            <button class="btn btn-sm text-danger btn-outline-light"
                                    title="Apagar Proeficiencia: '<?=$r["nome"]?>'"
                                    onclick="deletar(<?=$r["id"]?>,'<?=$r["nome"]?>','deletpro')">
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
