<div class="col">
    <div class="card h-100" id="card_principal">
        <div class="card-header d-flex justify-content-between">
            <?php if (!isset($_GET["popout"]) and $edit) { ?>
                <div class="float-start">
                    <button class="btn btn-sm text-white popout fa-lg" title="PopOut">
                        <i class="fal fa-rectangle-vertical-history"></i>
                    </button>
                </div>
            <?php } ?>
            <h4 class="m-0">Principal</h4>
            <?php if ($edit) { ?>
                <div class="float-end">
                    <button class="btn btn-sm text-warning fa-lg" data-bs-toggle="modal" data-bs-target="#editprincipal" title="Editar">
                        <i class="fal fa-pencil"></i>
                    </button>
                </div>
            <?php } ?>
        </div>
        <div class="card-body p-0">
            <div class="row g-0 m-2 justify-content-center">
                <div class="col-auto text-center align-self-center m-2" style="width: -webkit-fill-available; max-width: 190px;  aspect-ratio: 1/1">
                    <div class="position-relative">
                        <div class="position-absolute top-0 end-0">
                            <button class="btn btn-sm text-warning" data-bs-toggle="modal" data-bs-target="#editfoto" title="editar foto perfil">
                                <i class="fat fa-pencil"></i>
                            </button>
                        </div>
                        <img data-bs-toggle="modal" data-bs-target="#trocarficha" alt="Foto perfil" src="<?php
                        if ($pva <= 0) {
                            echo $urlphotomor;
                        } else
                            if ($sana <= 0) {
                                if (TirarPorcento($pva, $pv) < 50) {
                                    echo $urlphotoef;
                                } else {
                                    echo $urlphotoenl;
                                }
                            } else {
                                if (TirarPorcento($pva, $pv) < 50) {
                                    echo $urlphotofer;
                                } else {
                                    echo $urlphoto;
                                }
                            }


                        ?>" id="fotopersonagem" class="rounded-circle border img-fluid" style="aspect-ratio: 1/1"/>
                    </div>
                </div>
            </div>
            <div class="m-2">
                <div id="saude">
                    <h4 class="font6 pt-4 fs-4 text-center">Vida</h4>
                    <div class="d-flex justify-content-between">
                        <?php if ($edit) { ?>
                            <div class="col-auto">
                                <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(-5,'pv');">
                                    <i class="fa-solid fa-chevrons-left"></i> -5
                                </button>
                                <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(-1,'pv');">
                                    <i class="fa-solid fa-chevron-left"></i> -1
                                </button>
                            </div>
                        <?php } ?>
                        <div class="col fs-4 justify-content-center align-items-center font4 row g-0 dblclick">
                            <div class="col me-0">
                                <input type="number" title="Vida Atual" min="<?= $minimo_PVA ?>" max="<?= $maximo_PV ?>" name="pva" value="<?= $pva ?>" class="pva border-0 vidaatual form-control form-control-sm text-end" readonly>
                            </div>
                            <div class="col-auto">/</div>
                            <div class="col ms-0">
                                <input type="number" title="Vida Máxima" name="pv" min="1" max="<?= $maximo_PV ?>" value="<?= $pv ?>" class=" pv border-0 vidamaxima form-control form-control-sm" readonly>
                            </div>
                        </div>
                        <?php if ($edit) { ?>
                            <div class="col-auto">
                                <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(1,'pv');">
                                    +1 <i class="fa-solid fa-chevron-right"></i>
                                </button>
                                <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(5,'pv');">
                                    +5 <i class="fa-solid fa-chevrons-right"></i>
                                </button>
                            </div>
                        <?php } ?>
                    </div>
                    <div id="pv" class="float-none">
                        <div class="progress h-auto">
                            <div class="progress-bar bg-danger text-end" id="barrapva" role="progressbar" title="Vida" style="width:<?= $ppv; ?>%;height: 30px" aria-valuenow="<?= $pva ?>" aria-valuemin="0" aria-valuemax="<?= $pv ?>"></div>
                        </div>
                    </div>


                    <h4 class="font6 pt-4 fs-4 fw-bold text-center">Sanidade</h4>
                    <?php if ($san > 0) { ?>
                        <div class="d-flex justify-content-between">
                            <?php if ($edit) { ?>
                                <div class="col-auto">
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(-5,'san');">
                                        <i class="fa-solid fa-chevrons-left"></i> -5
                                    </button>
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(-1,'san');">
                                        <i class="fa-solid fa-chevron-left"></i> -1
                                    </button>
                                </div>
                            <?php } ?>
                            <div class="col fs-4 justify-content-center align-items-center font4 row g-0 dblclick">
                                <div class="col me-0">
                                    <input type="number" title="Sanidade Atual" name="sana" min="<?= $minimo_SANA ?>" max="<?= $maximo_SAN ?>" value="<?= $sana ?>" class="sana border-0 sanatual form-control form-control-sm text-end" readonly>
                                </div>
                                <div class="col-auto">/</div>
                                <div class="col ms-0">
                                    <input type="number" title="Sanidade Máxima" name="san" min="1" max="<?= $maximo_SAN ?>" value="<?= $san ?>" class="san border-0 sanmaxima form-control form-control-sm" readonly>
                                </div>
                            </div>
                            <?php if ($edit) { ?>
                                <div class="col-auto">
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(1,'san');">
                                        +1 <i class="fa-solid fa-chevron-right"></i>
                                    </button>
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(5,'san');">
                                        +5 <i class="fa-solid fa-chevrons-right"></i>
                                    </button>
                                </div>
                            <?php } ?>
                        </div>
                        <div id="san" class="float-none">
                            <div class="progress h-auto bg-dark fw-bolder">
                                <div class="progress-bar bg-primary text-end" id="barrasana" role="progressbar" title="Vida" style="width:<?= $psan; ?>%;height: 30px" aria-valuenow="<?= $sana ?>" aria-valuemin="0" aria-valuemax="<?= $san ?>"></div>
                            </div>
                        </div>
                    <?php }

                    if ($pe > 0) {
                        ?>

                        <h4 class="font6 pt-4 fw-bold text-center">Esforço</h4>
                        <div class="d-flex justify-content-between">
                            <?php if ($edit) { ?>
                                <div class="col-auto">
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(-5,'pe');">
                                        <i class="fa-solid fa-chevrons-left"></i> -5
                                    </button>
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(-1,'pe');">
                                        <i class="fa-solid fa-chevron-left"></i> -1
                                    </button>
                                </div>
                            <?php } ?>
                            <div class="fs-4 justify-content-center mx-auto align-items-center font4 row g-0 dblclick">
                                <div class="col-5 me-0">
                                    <input type="number" title="PE Atual" name="pea" min="<?= $minimo_PEA ?>" max="<?= $maximo_PE ?>" value="<?= $pea ?>" class="pea border-0 peatual form-control form-control-sm text-end" readonly>
                                </div>
                                <div class="col-auto">/</div>
                                <div class="col-5 ms-0">
                                    <input type="number" title="PE Máximo" name="pe" min="1" max="<?= $maximo_PE ?>" value="<?= $pe ?>" class="pe border-0 pemaxima form-control form-control-sm" readonly>
                                </div>
                            </div>
                            <?php if ($edit) { ?>
                                <div class="col-auto">
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(1,'pe');">
                                        +1 <i class="fa-solid fa-chevron-right"></i>
                                    </button>
                                    <button class="btn btn-sm text-body-emphasis" onclick="updtsaude(5,'pe');">
                                        +5 <i class="fa-solid fa-chevrons-right"></i>
                                    </button>
                                </div>
                            <?php } ?>
                        </div>
                        <div id="pe" class="float-none">
                            <div class="progress h-auto bg-dark fw-bolder">
                                <div class="progress-bar bg-warning text-end" id="barrapea" role="progressbar" title="Esforço" style="width:<?= $ppe; ?>%;height: 30px" aria-valuenow="<?= $pea ?>" aria-valuemin="0" aria-valuemax="<?= $pe ?>"></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <?php
                if ($passiva > 0 || $esquiva > 0 || $bloqueio > 0) {
                    ?>
                    <h4 class="font6 mt-4 text-center">Defesas</h4>
                    <div class="row justify-content-center">
                        <?= pill("Passiva", $passiva) ?>
                        <?= pill("Esquiva", $esquiva) ?>
                        <?= pill("Bloqueio", $bloqueio) ?>
                    </div>
                    <?php }
                if ($balistica > 0 or $fisica > 0 or $conhecimento > 0 or $morte > 0 or $sangue > 0 or $energia > 0 or $insanidade > 0) {?>
                    <h4 class="font6 pt-4 text-center">Resistencias</h4>
                    <div class="row justify-content-center g-2">
                        <?= pill("Físico", $fisica) ?>
                        <?= pill("Balístico", $balistica) ?>
                        <?= pill("Mental", $insanidade) ?>
                        <?= pill("Morte", $morte) ?>
                        <?= pill("Conhecimento", $conhecimento) ?>
                        <?= pill("Sangue", $sangue) ?>
                        <?= pill("Energia", $energia) ?>
                        <?= pill("Corte", $corte) ?>
                        <?= pill("Impacto", $impacto) ?>
                        <?= pill("Perfuração", $perfuracao) ?>
                        <?= pill("Elétrico", $eletricidade) ?>
                        <?= pill("Fogo", $fogo) ?>
                        <?= pill("Frio", $frio) ?>
                        <?= pill("Químico", $quimica) ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
