<?php

$habstabs = [];
foreach ($s[9] as $tab){
    $habstabs += $tab;
}

?>

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
                    <button class="btn btn-sm btn-outline-primary active m-1 habtab noteditable" id="aba-habilidades" data-bs-toggle="tab" data-bs-target="#habilidades" type="button" role="tab" aria-controls="habilidades" aria-selected="true">
                        Habilidades
                    </button>
	                <?php
	                foreach ($s[9] as $habtab){
		                ?>
                        <button class="btn btn-sm btn-outline-primary m-1 habtab" id="aba-<?=$habtab["token"]?>" data-fop-token="<?=$habtab["token"]?>" data-bs-toggle="tab" data-bs-target="#pag-<?=$habtab["token"]?>" type="button" role="tab" aria-controls="pag-<?=$habtab["token"]?>" aria-selected="false"><?=elicon($habtab["nome"])?"<h5 class='visually-hidden'>{$habtab["nome"]}</h5>".elicon($habtab["nome"]):$habtab["nome"]?></button>
		                <?php
	                }
	                ?>
                    <?php if ($s[9]->num_rows <= 5){?>
                    <button class="btn btn-sm btn-outline-success border-success border-dashed m-1 addtab" title="Organize suas habilidades, por abas" type="button">
                        Adicionar
                    </button>
                    <?php }?>
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
            <h6 class="text-muted text-end">Segure na aba para opções.</h6>
            <div class="tab-content m-2">
                <div class="tab-pane fade show active" id="habilidades" role="tabpanel" aria-labelledby="aba-habilidades" tabindex="0">
					<?php
					foreach ($s[2] as $r):
                        if(!in_array($r["tab"], $habstabs, true)){
                        
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
					}
					endforeach;
					?>
                </div>
                 <?php
	            foreach ($s[9] as $habtab){
		            ?>
                    <div class="tab-pane fade" id="pag-<?=$habtab["token"]?>" role="tabpanel" aria-labelledby="aba-<?=$habtab["token"]?>" tabindex="0">
			            <?php
			            foreach ($s[2] as $r):
                            if($r["tab"] === $habtab["token"]){
				            ?>
                            <div class="m-3" data-fop-pod="<?= $r["id"]?>">
					            <?php if ($edit) { ?>
                                    <div class="float-end">
                                        <button class="btn btn-sm fal fa-pencil text-warning" aria-label="Editar poder '<?= $r["nome"]; ?>'" onclick="editarhab(<?= $r["id"]?>,'hab')"></button>
                                        <button class="btn btn-sm fal fa-trash text-danger" aria-label="Apagar poder '<?= $r["nome"] ?>'" onclick="deletar(<?= $r["id"]; ?>,'<?= $r["nome"] ?>','habilidade')"></button>
                                    </div>
					            <?php } ?>
                                <h4 class="m-0 podname"><?= $r["nome"]?></h4>
                                <p class="poddesc"><?= nl2br($r["descricao"])?></p>
                            </div>
                        <?php
                            }
			            endforeach;
			            ?>
                    </div>
		            <?php
	            }
	            ?>
            </div>
        </div>
    </div>
</div>