<div class="col-md-6" id="card_rolar">
    <div class="card h-100" style="min-height: 360px;">
        <div class="card-header clearfix text-center p-0">
            <div class="float-start">
                <button class="btn btn-sm text-info fa-lg" title="Como rolar dados. " data-bs-toggle="modal" data-bs-target="#rolardados">
                    <i class="fa-regular fa-circle-info"></i>
                </button>
            </div>
            <span class="fs-4 font6">Dados Customizado</span>
            
            <div class="float-end">
                <button class="btn btn-sm text-success fa-lg" title="Adicionar dado" data-bs-toggle="modal" data-bs-target="#adddado">
                    <i class="fa-regular fa-square-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0 font1">
            <h6 class="text-muted text-end">Segure para mais opções nos dados.</h6>
            <div class="m-2">
                <div class="row row-cols-auto g-2 justify-content-center" id="dados">
			        <?php
			        foreach ($m as $dado):
				        switch ($dado["foto"]) {
					        default:
						        $iconedado = "fa-dice-d20";
						        break;
					        case 1:
						        $iconedado = "fa-dice-d4";
						        break;
					        case 2:
						        $iconedado = "fa-dice-d6";
						        break;
					        case 3:
						        $iconedado = "fa-dice-d8";
						        break;
					        case 4:
						        $iconedado = "fa-dice-d10";
						        break;
					        case 5:
						        $iconedado = "fa-dice-d12";
						        break;
					        case 7:
						        $iconedado = "fa-dice-one";
						        break;
					        case 8:
						        $iconedado = "fa-dice-two";
						        break;
					        case 9:
						        $iconedado = "fa-dice-three";
						        break;
					        case 10:
						        $iconedado = "fa-dice-four";
						        break;
					        case 11:
						        $iconedado = "fa-dice-five";
						        break;
					        case 12:
						        $iconedado = "fa-dice-six";
						        break;
				        }
				        ?>
                        <div class="col dado" aria-foto="<?= $dado["foto"]; ?>" aria-dado="<?= $dado["dado"]; ?>" aria-id="<?= $dado["id"]; ?>" aria-nome="<?= $dado["nome"]; ?>" title="<?= $dado["dado"] ?>" onclick="rolar('<?= $dado["dado"] ?>',<?=$dado["dano"]?>,'<?= $dado["nome"]?>')">
                            <button class="btn btn-lg text-body-emphasis" <?=(!isset($edit) OR $edit)?:"disabled"?>>
                                <i class="fal <?= $iconedado ?> fa-2x"></i><br><?= $dado["nome"]; ?>
                            </button>
                        </div>
			        <?php
			        endforeach;
			        ?>
                </div>
            </div>
            <form class="m-2 position-sticky top-100" id="formfastdice" ajax>

                <div class="return"></div>
                <div class="input-group">
                    <label class="form-floating text-start">
                        <input type="text" class="form-control border-secondary border-end-0" placeholder="/AGI/d20+/PONT/+1d6"/>
                        <label>Dado Rapido (EX: "/AGI/d20" )</label>
                    </label>
                    <button class="btn btn-lg btn-outline-secondary border-start-0" type="submit"><i class="fa-regular fa-paper-plane-top"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>