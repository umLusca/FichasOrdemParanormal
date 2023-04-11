<div class="col">
    <div class="card" id="card_inventario">
        <div class="card-header d-flex justify-content-between">
            <?php if ($edit) { ?>
                <div class="float-start">
                    <?php if (!isset($_GET["popout"])) { ?>
                        <button class="btn btn-sm text-secondary fa-lg popout" title="PopOut">
                            <i class="fa-regular fa-rectangle-vertical-history"></i>
                        </button>
                    <?php } ?>
                </div>
            <?php } ?>
            <h4 class="m-0">Inventário
                <i class="fal fa-info-circle text-info" role="button" data-bs-toggle="modal" data-bs-target="#modal_inventario"></i>
                (<span class="pesoatual"><?= $espacosusados ?></span>/<?= $invmax ?>)</h4>
            <?php if ($edit) { ?>
                <div class="float-end">
                    <button class="btn btn-sm text-warning fa-lg" data-bs-toggle="modal" data-bs-target="#editpesoinv" title="Editar peso">
                        <i class="fa-regular fa-pencil"></i>
                    </button>
                </div>
            <?php } ?>
        </div>
        <div class="card-body p-0">
            <h3 class="text-center">Armas</h3>
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-2 my-2 m-3">
                <?php foreach ($s[8] as $i => $arma): ?>
                    <div class="col">
                        <div class="card h-100 border border-danger position-relative" style="min-height: 100px" data-fop-initialize="ToggleArma" id="arma<?= $arma["id"] ?>">

                            <?php if ($edit) { ?>
                                <div class="position-absolute start-0-0 top-0">
                                    <button type="button" class="btn btn-sm btn-outline-danger" title="Apagar Arma" onclick="deletar(<?= $arma["id"] ?>, '<?= $arma["arma"] ?>', 'arma')">
                                        <i class="fa-regular fa-trash"></i>
                                    </button>
                                </div>
                                <div class="position-absolute end-0 top-0">
                                    <button class="btn btn-sm btn-outline-warning" title="Editar Arma" onclick="edit('arma',<?= $arma["id"] ?>)">
                                        <i class="fat fa-pencil"></i>
                                    </button>
                                </div>
                            <?php } ?>
                            <img class="card-img-top oto align-self-center" src="<?= $arma["foto"] ?>" style="height: 150px; width: fit-content !important;;" alt="Foto">
                            <div class="card-body p-0">
                                <div class="input-group">
                                    <span class="input-group-text rounded-0 bg-body p-1" style="width: 42px">
                                        <button class="btn btn-sm btn-outline-info" style="width: 31px;" data-fop-function="toggle"><i class="fal fa-eye"></i></button></span>
                                    <span class="input-group-text rounded-0 flex-grow-1 bg-body nome"><?= $arma["nome"] ?></span>
                                </div>
                                <div class="infoarma">
                                    <?php if (!empty($arma["tipo"])) { ?>
                                        <div class="input-group" data-bs-toggle="tooltip" data-bs-title="Tipo">
                                            <span class="input-group-text rounded-0 bg-body"><i class="fa-thin fa-seal-question"></i></span>
                                            <span class="input-group-text rounded-0 flex-grow-1 bg-body tipo"><?= $arma["tipo"] ?></span>
                                        </div>
                                    <?php }
                                    if (!empty($arma["especial"])) {
                                        ?>
                                        <div class="input-group" data-bs-toggle="tooltip" data-bs-title="Especial">
                                            <span class="input-group-text rounded-0 bg-body"><i class="fa-thin fa-sparkles"></i></span>
                                            <span class="input-group-text rounded-0 flex-grow-1 bg-body especial"><?= $arma["especial"] ?></span>
                                        </div>
                                    <?php }
                                    if (!empty($arma["recarga"])) {
                                        ?>
                                        <div class="input-group" data-bs-toggle="tooltip" data-bs-title="Recarga">
                                            <span class="input-group-text rounded-0 bg-body"><i class="fa-thin fa-rotate"></i></span>
                                            <span class="input-group-text rounded-0 flex-grow-1 bg-body  recarga"><?= $arma["recarga"] ?></span>
                                        </div>
                                    <?php }
                                    if (!empty($arma["alcance"])) {
                                        ?>
                                        <div class="input-group" data-bs-toggle="tooltip" data-bs-title="Alcance">
                                            <span class="input-group-text rounded-0 bg-body"><i class="fa-thin fa-crosshairs"></i></span>
                                            <span class="input-group-text rounded-0 flex-grow-1 bg-body alcance"><?= $arma["alcance"] ?></span>
                                        </div>
                                    <?php } ?>

                                </div>
                                <div class="infoitem">
                                    <div class="d-flex">
                                        <div class="input-group" data-bs-toggle="tooltip" data-bs-title="Categoria">
                                            <span class="input-group-text rounded-0 bg-body" style="width: 42px;"><i class="fa-thin fa-line-height"></i></span>
                                            <span class="input-group-text rounded-0 flex-grow-1 bg-body" data-fop-info="prestigio"><?= $arma["prestigio"] ?></span>
                                        </div>
                                        <div class="input-group text-end" data-bs-toggle="tooltip" data-bs-title="Peso">
                                            <span class="input-group-text rounded-0 flex-grow-1 justify-content-end bg-body" data-fop-info="espaco"><?= $arma["espaco"] ?></span>
                                            <span class="input-group-text rounded-0 bg-body"><i class="fa-thin fa-dumbbell"></i></span>
                                        </div>
                                    </div>
                                    <div class="p-2" data-fop-info="descricao"><?= nl2br($arma["descricao"]) ?></div>
                                </div>
                                <div class="top-100 position-sticky">
                                    <?php if (!empty($arma["ataque"])) { ?>
                                        <div class="d-grid">
                                            <button class="btn btn-sm p-0 btn-outline-info rounded-0 ataque" data-dado="<?= $arma["ataque"] ?>" onclick='rolar(<?= "[{nome:`Teste {$arma["arma"]}`,dado: `{$arma["ataque"]}`, dano: false,margem:{$arma["margem"]}}" ?>,<?= "{nome:`Dano {$arma["arma"]}`,dado: `{$arma["dano"]}`, dano: 1}" ?>,<?= "{nome:`Crítico {$arma["arma"]}`,dado: `{$arma["critico"]}`, dano: 1}]" ?>)'>
                                                Teste<br>
                                                <?= $arma["ataque"] ?>
                                            </button>
                                        </div>
                                    <?php }
                                    if (!empty($arma["dano"]) && !empty($arma["critico"])) {
                                        ?>
                                        <div class="btn-group btn-group-sm btn-group-sm rounded-0 w-100">
                                            <?php if (!empty($arma["dano"])) { ?>
                                                <button class="btn btn-outline-danger position-relative rounded-0 p- dano" data-dado="<?= $arma["dano"] ?>" onclick="rolar({dado:'<?= $arma['dano'] ?>',dano:1,nome:'Dano Arma'})">
                                                    Normal<br>
                                                    <?= $arma["dano"] ?>
                                                </button>
                                            <?php }
                                            if (!empty($arma["critico"])) { ?>
                                                <button class="btn btn-outline-danger position-relative rounded-0 p-0 critico" data-margem="<?= $arma["margem"] ?>" data-dado="<?= $arma["critico"] ?>" onclick="rolar({dado:'<?= $arma['critico'] ?>',dano:1,nome: 'Crítico Arma'})">
                                                    Crítico<br>
                                                    <?= $arma["critico"] ?>/<?= $arma["margem"] ?>
                                                </button>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php foreach ($s[1] as $i => $arma): //TO REMOVE ?>
                    <div class="col">
                        <div class="card h-100 border-dashed border-warning position-relative" data-bs-toggle="popover" data-bs-placement="top" data-bs-title="Novo sistema de inventário" data-bs-content="Esse item vai ser apagado em breve, recrie ele para evitar isso." data-bs-trigger="hover focus" style="min-height: 100px" id="arma<?= $arma["id"] ?>">

                            <?php if ($edit) { ?>
                                <div class="position-absolute start-0-0 top-0">
                                    <button type="button" class="btn btn-sm btn-outline-danger" title="Apagar Arma" onclick="deletar(<?= $arma["id"] ?>, '<?= $arma["arma"] ?>', 'arma')">
                                        <i class="fa-regular fa-trash"></i>
                                    </button>
                                </div>
                                <div class="position-absolute end-0 top-0">
                                    <a class="btn btn-sm btn-outline-warning">
                                        <i class="fat fa-warning"></i>
                                    </a>
                                </div>
                            <?php } ?>
                            <img class="card-img-top oto align-self-center" src="<?= $arma["foto"] ?>" style="height: 150px; width: fit-content !important;;">
                            <div class="card-body p-0">
                                <div class="card-title text-center arma"><?= $arma["arma"] ?></div>
                                <?php if (!empty($arma["tipo"])) { ?>
                                    <div class="input-group">
                                        <span class="input-group-text rounded-0 bg-body"><i class="fa-thin fa-seal-question"></i></span>
                                        <span class="input-group-text rounded-0 flex-grow-1 bg-body tipo"><?= $arma["tipo"] ?></span>
                                    </div>
                                <?php }
                                if (!empty($arma["especial"])) {
                                    ?>
                                    <div class="input-group">
                                        <span class="input-group-text rounded-0 bg-body"><i class="fa-thin fa-sparkles"></i></span>
                                        <span class="input-group-text rounded-0 flex-grow-1 bg-body especial"><?= $arma["especial"] ?></span>
                                    </div>
                                <?php }
                                if (!empty($arma["recarga"])) {
                                    ?>
                                    <div class="input-group">
                                        <span class="input-group-text rounded-0 bg-body"><i class="fa-thin fa-rotate"></i></span>
                                        <span class="input-group-text rounded-0 flex-grow-1 bg-body  recarga"><?= $arma["recarga"] ?></span>
                                    </div>
                                <?php }
                                if (!empty($arma["alcance"])) {
                                    ?>
                                    <div class="input-group">
                                        <span class="input-group-text rounded-0 bg-body"><i class="fa-thin fa-crosshairs"></i></span>
                                        <span class="input-group-text rounded-0 flex-grow-1 bg-body alcance"><?= $arma["alcance"] ?></span>
                                    </div>
                                <?php } ?>
                                <div class="top-100 position-sticky">
                                    <?php if (!empty($arma["ataque"])) { ?>
                                        <div class="d-grid">
                                            <button class="btn btn-sm p-0 btn-outline-info rounded-0 ataque" data-dado="<?= $arma["ataque"] ?>" onclick='rolar(<?= "[{nome:`Teste {$arma["arma"]}`,dado: `{$arma["ataque"]}`, dano: false,margem:{$arma["margem"]}}" ?>,<?= "{nome:`Dano {$arma["arma"]}`,dado: `{$arma["dano"]}`, dano: 1}" ?>,<?= "{nome:`Crítico {$arma["arma"]}`,dado: `{$arma["critico"]}`, dano: 1}]" ?>)'>
                                                Teste<br>
                                                <?= $arma["ataque"] ?>
                                            </button>
                                        </div>
                                    <?php }
                                    if (!empty($arma["dano"]) && !empty($arma["critico"])) {
                                        ?>
                                        <div class="btn-group btn-group-sm btn-group-sm rounded-0 w-100">
                                            <?php if (!empty($arma["dano"])) { ?>
                                                <button class="btn btn-outline-danger position-relative rounded-0 p- dano" data-dado="<?= $arma["dano"] ?>" onclick="rolar({dado:'<?= $arma['dano'] ?>',dano:1,nome:'Dano Arma'})">
                                                    Normal<br>
                                                    <?= $arma["dano"] ?>
                                                </button>
                                            <?php }
                                            if (!empty($arma["critico"])) { ?>
                                                <button class="btn btn-outline-danger position-relative rounded-0 p-0 critico" data-margem="<?= $arma["margem"] ?>" data-dado="<?= $arma["critico"] ?>" onclick="rolar({dado:'<?= $arma['critico'] ?>',dano:1,nome: 'Crítico Arma'})">
                                                    Crítico<br>
                                                    <?= $arma["critico"] ?>/<?= $arma["margem"] ?>
                                                </button>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if ($edit) { ?>
                    <div class="col">
                        <div class="card btn border-dashed border-danger h-100" data-bs-toggle="modal" data-bs-target="#addarma">
                            <div class="m-auto">
                                <h2>Adicionar Arma</h2>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            </div>

            <h3 class="text-center">Itens</h3>
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-2 my-2 m-3">

                <?php foreach ($s[4] as $i => $item): ?>
                    <div class="col">
                        <div class="card h-100 border border-info position-relative" style="min-height: 100px" id="item<?= $item["id"] ?>">

                            <?php if ($edit) { ?>
                                <div class="position-absolute start-0-0 top-0">
                                    <button type="button" class="btn btn-sm btn-outline-danger" title="Apagar Arma" onclick="deletar(<?= $item["id"] ?>, '<?= $item["nome"] ?>', 'item')">
                                        <i class="fa-regular fa-trash"></i>
                                    </button>
                                </div>
                                <div class="position-absolute end-0 top-0">
                                    <button class="btn btn-sm btn-outline-warning" title="Editar Arma" onclick="edit('item',<?= $item["id"] ?>)">
                                        <i class="fat fa-pencil"></i>
                                    </button>
                                </div>

                            <?php } ?>
                            <img class="card-img-top align-self-center" src="<?= $item["foto"] ?>" style="height: 150px; width: fit-content!important;" alt="Foto" data-fop-info="foto">
                            <div class="card-body p-0">
                                <div class="card-title text-center" data-fop-info="nome"><?= $item["nome"] ?></div>
                                <div class="d-flex">
                                    <div class="input-group" data-bs-toggle="tooltip" data-bs-title="Categoria">
                                        <span class="input-group-text rounded-0 bg-body"><i class="fa-thin fa-line-height"></i></span>
                                        <span class="input-group-text rounded-0 flex-grow-1 bg-body" data-fop-info="prestigio"><?= $item["prestigio"] ?></span>
                                    </div>
                                    <div class="input-group text-end" data-bs-toggle="tooltip" data-bs-title="Peso">
                                        <span class="input-group-text rounded-0 flex-grow-1 justify-content-end bg-body" data-fop-info="espaco"><?= $item["espaco"] ?></span>
                                        <span class="input-group-text rounded-0 bg-body"><i class="fa-thin fa-dumbbell"></i></span>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text rounded-0 bg-body"><i class="fa-thin fa-crosshairs"></i></span>
                                    <span class="input-group-text rounded-0 flex-grow-1 bg-body quantidade"><?= $item["quantidade"] ?></span>
                                </div>
                                <div class="p-2" data-fop-info="descricao"><?= nl2br($item["descricao"]) ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if ($edit) { ?>
                    <div class="col">
                        <div class="card btn  border-info border-dashed h-100" data-bs-toggle="modal" data-bs-target="#additem">
                            <div class="m-auto">
                                <h2>Adicionar Item</h2>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            </div>
            <div class="py-2" id="inv">
                <?php
                if ($s[4]->num_rows > 0) {
                    ?>
                    <h3 class="mx-2">Itens (Futuramente extinta ;-;)</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered table-sm font2" id="itens">
                            <colgroup>
                                <col style="width: min-content">
                                <col>
                                <col style="width: 75px">
                                <col style="width: 50px">
                                <col style="width: 85px">
                            </colgroup>
                            <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Categoria</th>
                                <th scope="col">Peso</th>
                                <th scope="col">Quantidade</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($s[4] as $row): ?>
                                <tr data-fop-item="<?= $row["id"] ?>">
                                    <td><?= $row['nome']; ?></td>
                                    <td><?= $row['descricao']; ?></td>
                                    <td><?= $row['prestigio']; ?></td>
                                    <td><span class="peso"><?= $row['espaco']; ?></span></td>
                                    <td><span class="quantidade"><?= $row['quantidade']; ?></span>x
                                        <button class="btn btn-sm text-info p-1" onclick="item('plus',<?= $row['id'] ?>)">
                                            <i class="fal fa-plus-circle"></i></button>
                                        <button class="btn btn-sm text-info p-1" onclick="item('minus',<?= $row['id'] ?>)">
                                            <i class="fal fa-minus-circle"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>