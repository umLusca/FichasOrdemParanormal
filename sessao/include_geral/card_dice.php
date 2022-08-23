<div class="col-md-6" id="card_rolar">
    <div class="card h-100 bg-black border-light" style="min-height: 360px;">
        <div class="clearfix">
            <div class="float-start">
                <button class="btn btn-sm text-info fa-lg" title="Como rolar dados. " data-bs-toggle="modal" data-bs-target="#rolardados">
                    <i class="fa-regular fa-circle-info"></i>
                </button>
            </div>
            <div class="float-end">
                <button class="btn btn-sm text-success fa-lg" title="Adicionar dado" data-bs-toggle="modal" data-bs-target="#adddado">
                    <i class="fa-regular fa-square-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-header text-center border-0">
            <label class="card-title font6 fs-2 font6" for="rolardadosinput">Dados Customizados</label>
        </div>
        <div class="card-body p-0 font1">
            <div class="container-fluid p-0 justify-content-center text-center">
                <div id="returncusdados"></div>
                <div class="p-2">
                    <div class="row g-0 border border-light">
                        <input type="text" class="col form-control bg-black text-white border-0" placeholder="1d20+5" id="rolardadosinput"/>
                        <button class="col-auto btn btn-sm btn-outline-light border-0 rounded-0" id="rolardadosbutton"><i class="fa-regular fa-paper-plane-top"></i></button>
                    </div>
                </div>
                <div class="my-2">
                    <span class="text-center card-title font6 fs-2">Dados salvos</span>
                    <div class="row row-cols-auto g-2 justify-content-center" id="dados">
                        <?php
                        foreach ($m as $dado): switch ($dado["foto"]) {
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
                                <button class="btn text-light" <?=(!isset($edit) OR $edit)?:"disabled"?>>
                                    <i class="fa-light <?= $iconedado ?> fa-2x"></i><br><?= $dado["nome"]; ?>
                                </button>
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <i class="text-info position-absolute bottom-0"><i class=" fa-regular fa-info-circle"></i> Segure para mais opções nos dados.</i>
    </div>
</div>