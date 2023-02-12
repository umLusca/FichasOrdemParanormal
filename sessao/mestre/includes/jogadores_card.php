<?php

?>


<div class="col-md-6" id="player">
    <div class="card border-secondary h-100">
        <div class="card-header text-center">
            <div class="position-absolute start-0">
                <?php if ((bool)$missao["combate"]) { ?>
                    <button class="btn btn-outline-warning mx-1 p-0" aria-checked="false" title="Alternar status de Combate" onclick="toggleCombate(this);">
                    <span class="fa-stack fa-sm">
                        <i class="fa-regular fa-slash fa-stack-1x"></i>
                        <i class="fa-regular fa-sword fa-stack-1x"></i>
                    </span>
                    </button>
                <?php } else { ?>
                    <button class="btn btn-warning mx-1 p-0" aria-checked="false" title="Alternar status de Combate" onclick="toggleCombate(this);">
                    <span class="fa-stack fa-sm">
                        <i class="fa-regular fa-sword fa-stack-1x"></i>
                    </span>
                    </button>
                <?php } ?>
            </div>
            <div class="position-absolute end-0">
                <button class="btn btn-outline-success fa-lg mx-1 p-1" data-bs-toggle="modal" data-bs-target="#adicionar">
                    <i class="fat fa-plus-large"></i>
                </button>
            </div>
            <h3 class="font6 m-0">Fichas Personagens</h3>
        </div>
        <div class="card-body p-0 font2">
            <div class="row row-cols-lg-2 row-cols-xxl-3 row-cols-1 g-2 p-2" id="fichasperson">
                <?php
                foreach ($q["personagens"] as $ficha) {

                    if ($ficha["peso_inv"] > 1) {
                        $invmax = $ficha["peso_inv"];
                    } else {
                        $invmax = pesoinv($ficha["forca"], $ficha["inteligencia"], $ficha["classe"], $ficha["trilha"], $ficha["origem"]);
                    }
                    $s = $con->query("Select SUM(espaco) AS pesototal From `inventario` where `id_ficha` = '" . $ficha["id"] . "';");
                    $espacosusados = mysqli_fetch_array($s)["pesototal"];

                    ?>
                    <div class="col">
                        <div class="card-body h-100 p-0" id="player<?= $ficha["token"] ?>">
                            <div class="card h-100">
                                <div class="card-header">
                                    <a class="card-title fs-5 text-decoration-none" href="./../personagem/?token=<?= $ficha["token"] ?>">
                                        <span class="font7 link-secondary"><?= $ficha["nome"] ?></span>
                                        <i class="fat fa-arrow-up-right-from-square"></i>
                                    </a>
                                    <div class="float-end d-inline">
                                        <a class="btn btn-sm btn-outline-info" href="./../personagem/portrait/<?= ($id == 5887) ? "Espiral/" : '' ?>?token=<?= $ficha["token"] ?>"><i class="fa-solid fa-user"></i></a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="desvincular(<?= $ficha["id"] ?>)" title="Desvincular ficha">
                                            <i class="fa-solid fa-link-slash"></i></button>
                                    </div>
                                </div>
                                <div class="card-body p-0 border-0 text-center">
                                    <nav>

                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <button class="nav-link active"
                                                        id="aba-principal-<?= $ficha["token"] ?>"
                                                        data-bs-target="#principal-<?= $ficha["token"] ?>"
                                                        aria-controls="nav-home" data-bs-toggle="tab" type="button"
                                                        role="tab" aria-selected="true">Principal
                                                </button>
                                            </li>
                                            <li class="nav-item">
                                                <button class="nav-link"
                                                        id="aba-detalhes-<?= $ficha["token"] ?>"
                                                        data-bs-target="#detalhes-<?= $ficha["token"] ?>"
                                                        aria-controls="nav-profile" data-bs-toggle="tab" type="button"
                                                        role="tab" aria-selected="false">Detalhes
                                                </button>
                                            </li>
                                            <li class="nav-item">

                                                <button class="nav-link"
                                                        id="aba-dados-<?= $ficha["token"] ?>"
                                                        data-bs-target="#dados-<?= $ficha["token"] ?>"
                                                        aria-controls="nav-contact" data-bs-toggle="tab" type="button"
                                                        role="tab" aria-selected="false">Dados
                                                </button>
                                            </li>
                                            <li class="nav-item">
                                                <button class="nav-link"
                                                        id="aba-outros-<?= $ficha["token"] ?>"
                                                        data-bs-target="#outros-<?= $ficha["token"] ?>"
                                                        aria-controls="nav-disabled" data-bs-toggle="tab" type="button"
                                                        role="tab" aria-selected="false">Outros
                                                </button>
                                            </li>
                                        </ul>
                                    </nav>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active principal"
                                             id="principal-<?= $ficha["token"] ?>" role="tabpanel"
                                             aria-labelledby="aba-principal-<?= $ficha["token"] ?>"
                                             tabindex="0">

                                            <div class="my-2">
                                                <span>PV: <?= $ficha["pva"] ?>/<?= $ficha["pv"] ?></span>
                                                <div class="progress">
                                                    <div class="progress-bar bg-danger" style="width: <?= TirarPorcento($ficha["pva"], $ficha["pv"]) ?>%;" role="progressbar"></div>
                                                </div>
                                            </div>
                                            <?php
                                            if ($ficha["san"]) {
                                                ?>
                                                <div class="my-2">
                                                    <span>SAN: <?= $ficha["sana"] ?>/<?= $ficha["san"] ?></span>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-primary" style="width: <?= TirarPorcento($ficha["sana"], $ficha["san"]) ?>%;" role="progressbar"></div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($ficha["pe"]) { ?>
                                                <div class="my-2">
                                                    <span>PE: <?= $ficha["pea"] ?>/<?= $ficha["pe"] ?></span>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning" style="width: <?= TirarPorcento($ficha["pea"], $ficha["pe"]) ?>%;" role="progressbar"></div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="my-2 px-3">
                                                <span class="">Peso: <?= $espacosusados ?: "0" ?>/<?= $invmax ?></span>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade p-1" id="detalhes-<?= $ficha["token"] ?>" role="tabpanel"
                                             aria-labelledby="aba-detalhes-<?= $ficha["id"] ?>" tabindex="0">
                                            <div class="my-2">
                                                <span class="fs-6">Defesas</span>
                                                <div class="row g-2 justify-content-center row-cols-3 my-2 mt-1">
                                                    <?= pill("Passiva", $ficha["passiva"]) ?>
                                                    <?= pill("Esquiva", $ficha["esquiva"]) ?>
                                                    <?= pill("Bloqueio", $ficha["bloqueio"]) ?>
                                                </div>
                                                <span class="fs-6">Resistencia</span>
                                                <div class="row g-2 justify-content-center my-2 mt-1">
                                                    <?=pill("Mental", $ficha["mental"] )?>
                                                    <?=pill("Morte", $ficha["morte"] )?>
                                                    <?=pill("Conhecimento", $ficha["conhecimento"] )?>
                                                    <?=pill("Sangue", $ficha["sangue"] )?>
                                                    <?=pill("Energia",  $ficha["energia"] )?>

                                                    <?=pill("Balística", $ficha["balistica"] )?>
                                                    <?=pill("Corte",  $ficha["corte"] )?>
                                                    <?=pill("Eletrico",  $ficha["eletricidade"] )?>
                                                    <?=pill("Fogo",  $ficha["fogo"] )?>
                                                    <?=pill("Frio",  $ficha["frio"] )?>
                                                    <?=pill("Física", $ficha["fisica"] )?>
                                                    <?=pill("Impacto",  $ficha["impacto"] )?>
                                                    <?=pill("Perfuração",  $ficha["perfuracao"] )?>
                                                    <?=pill("Química",  $ficha["quimico"] )?>




                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade p-1" id="dados-<?= $ficha["token"] ?>" role="tabpanel"
                                             aria-labelledby="aba-dados-<?= $ficha["id"] ?>" tabindex="0">
                                            <div class="m-2">
                                                <span class="fs-6">Atributos</span>
                                                <div class="row justify-content-center g-2 my-2 mt-1">
                                                    <?=pill("FOR", $ficha["forca"],false)?>
                                                    <?=pill("AGI", $ficha["agilidade"],false)?>
                                                    <?=pill("INT", $ficha["inteligencia"],false)?>
                                                    <?=pill("PRE", $ficha["presenca"],false)?>
                                                    <?=pill("VIG",  $ficha["vigor"],false)?>
                                                </div>
                                                <span class="fs-6">Perícias</span>
                                                <?php if ($ficha["acrobacia"] != 0 || $ficha["artes"] != 0 || $ficha["adestramento"] != 0 || $ficha["atletismo"] != 0 || $ficha["atualidade"] != 0 || $ficha["ciencia"] != 0 || $ficha["diplomacia"] != 0 || $ficha["enganacao"] != 0 || $ficha["fortitude"] != 0 || $ficha["furtividade"] != 0 || $ficha["iniciativa"] != 0 || $ficha["intimidacao"] != 0 || $ficha["intuicao"] != 0 || $ficha["investigacao"] != 0 || $ficha["luta"] != 0 || $ficha["medicina"] != 0 || $ficha["ocultismo"] != 0 || $ficha["percepcao"] != 0 || $ficha["pilotagem"] != 0 || $ficha["pontaria"] != 0 || $ficha["profissao"] != 0 || $ficha["reflexos"] != 0 || $ficha["religiao"] != 0 || $ficha["sobrevivencia"] != 0 || $ficha["tatica"] != 0 || $ficha["tecnologia"] != 0 || $ficha["vontade"] != 0) { ?>
                                                    <div class="row justify-content-center g-2 my-2 mt-1">
                                                        <?=pill("Acrobacia",$ficha["acrobacias"] )?>
                                                        <?=pill("Adestramento",$ficha["adestramento"] )?>
                                                        <?=pill("Arte", $ficha["artes"])?>
                                                        <?=pill("Atletismo",$ficha["atletismo"] )?>
                                                        <?=pill("Atualidade", $ficha["atualidades"])?>
                                                        <?=pill("Ciência", $ficha["ciencia"])?>
                                                        <?=pill("Crime",$ficha["crime"] )?>
                                                        <?=pill("Diplomacia",$ficha["diplomacia"] )?>
                                                        <?=pill("Enganação", $ficha["enganacao"])?>
                                                        <?=pill("Fortitude", $ficha["fortitude"])?>
                                                        <?=pill("Furtividade",$ficha["furtividade"]  )?>
                                                        <?=pill("Iniciativa",  $ficha["iniciativa"] )?>
                                                        <?=pill("Intimidação", $ficha["intimidacao"])?>
                                                        <?=pill("Intuição", $ficha["intuicao"] )?>
                                                        <?=pill("Investigação", $ficha["investigacao"] )?>
                                                        <?=pill("Luta",  $ficha["luta"] )?>
                                                        <?=pill("Medicina", $ficha["medicina"] )?>
                                                        <?=pill("Ocultismo",  $ficha["ocultismo"])?>
                                                        <?=pill("Percepção",$ficha["percepcao"] )?>
                                                        <?=pill("Pilotagem",  $ficha["pilotagem"])?>
                                                        <?=pill("Pontaria", $ficha["pontaria"] )?>
                                                        <?=pill("Profissão", $ficha["profissao"] )?>
                                                        <?=pill("Reflexos", $ficha["reflexos"] )?>
                                                        <?=pill("Religião", $ficha["religiao"]  )?>
                                                        <?=pill("Sobrevivência", $ficha["sobrevivencia"] )?>
                                                        <?=pill("Tática",$ficha["tatica"]  )?>
                                                        <?=pill("Tecnologia",$ficha["tecnologia"] )?>
                                                        <?=pill("Vontade",$ficha["vontade"] )?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade p-1" id="outros-<?= $ficha["token"] ?>" role="tabpanel"
                                             aria-labelledby="aba-outros-<?= $ficha["token"] ?>" tabindex="0">
                                            <div class="m-2">
                                                <h5 class="fs-5">Informações</h5>
                                                <div class="row g-2 row-cols-1">
                                                    <?= !empty($ficha["idade"]) ? "<span class='p-1 rounded-1 border'>Idade: " . $ficha["idade"] . "</span>" : "" ?>
                                                    <?= !empty($ficha["local"]) ? "<span class='p-1 rounded-1 border'>Local: " . $ficha["local"] . "</span>" : "" ?>
                                                    <?= !empty($ficha["origem"]) ? "<span class='p-1 rounded-1 border'>Origem: " . $ficha["origem"] . "</span>" : "" ?>
                                                    <?= !empty($ficha["classe"]) ? "<span class='p-1 rounded-1 border'>Classe: " . $ficha["classe"] . "</span>" : "" ?>
                                                    <?= !empty($ficha["trilha"]) ? "<span class='p-1 rounded-1 border'>Trilha: " . $ficha["trilha"] . "</span>" : "" ?>
                                                    <?= !empty($ficha["patente"]) ? "<span class='p-1 rounded-1 border'>Patente: " . $ficha["patente"] . "</span>" : "" ?>
                                                    <?= !empty($ficha["pp"]) ? "<span class='p-1 rounded-1 border'>P.P.: " . $ficha["pp"] . "</span>" : "" ?>
                                                    <?= !empty($ficha["nex"]) ? "<span class='p-1 rounded-1 border'>NEX: " . $ficha["nex"] . "%</span>" : "" ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>