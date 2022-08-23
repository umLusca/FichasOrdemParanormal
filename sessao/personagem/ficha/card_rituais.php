<div class="col">
    <div class="card h-100 bg-black border-light" id="card_rituais">
        <div class="card-header clearfix p-0">
            <div class="float-start">
                <?php if (!isset($_GET["popout"]) and $edit) { ?>
                    <button class="btn btn-sm text-white popout fa-lg" title="PopOut">
                        <i class="fa-regular fa-rectangle-vertical-history"></i>
                    </button>
                <?php } ?>
            </div>
            <div class="float-end">
                <?php if ($edit) { ?>
                    <button class="btn btn-sm text-warning fa-lg" data-bs-toggle="modal" data-bs-target="#editritual" title="Editar Rituais">
                        <i class="fa-regular fa-pencil"></i>
                    </button>
                    <button class="btn btn-sm text-success fa-lg" data-bs-toggle="modal" data-bs-target="#addritual" title="Adicionar Ritual">
                        <i class="fa-regular fa-square-plus"></i>
                    </button>
                <?php } ?>
            </div>
        </div>
        <div class="card-body p-0 font4">
            <h1 class="text-center font6">Rituais</h1>
            <div class="m-2">
                <nav class="m-2">
                    <div class="nav nav-tabs" role="tablist">
                        <?php foreach ($s[6] as $i => $r):?>
                            <button class="text-light nav-link <?=($i==0)?'active':''?>" id="but-ritual-tab-<?=$r["id"]?>" data-bs-toggle="tab" data-bs-target="#but-ritual-<?=$r["id"]?>" type="button" role="tab"><?=$r["nome"]?></button>
                        <?php endforeach;?>
                    </div>
                </nav>
                <div class="tab-content">
                        <?php foreach ($s[6] as $i => $r):?>
                            <div class="tab-pane fade <?=($i==0)?'show active':''?>" id="but-ritual-<?=$r["id"]?>" role="tabpanel">
                                <div class="container-fluid font2 text-start">
                                    <div class="row g-1">
                                        <div class="col-12 col-sm-3 col-xxl-2 text-start p-0 align-content-center">
                                            <img class="border border-light w-100" src="<?=($r["foto"]==='1')?"/assets/img/desconhecido.webp":$r["foto"]?>" alt="Ritual">
                                        </div>
                                        <div class="col row row-cols-2 align-content-center g-1 p-2">
                                            <div class="col-12 row m-0 border border-light rounded rounded-1">
                                                <span class="col border-0 form-control form-control-sm bg-black text-light">Nome: <?= $r["nome"] ?></span>
                                                <?php if ($edit) { ?>
                                                    <button class="col-auto border-0 float-end btn btn-sm btn-outline-light text-danger rounded-0" onclick="deletar(<?= $r["id"] ?>,'<?=$r["nome"]?>','deleteritual')">
                                                        <i class="fa-regular fa-trash"></i>
                                                    </button>
                                                <?php } ?>
                                            </div>
                                            <div class="col">
                                                <span class="form-control form-control-sm bg-black text-light">Circulo: <?=$r["circulo"]?></span>
                                            </div>
                                            <div class="col">
                                                <span class="form-control form-control-sm bg-black text-light">Elemento: <?=$r["elemento"]?></span>
                                            </div>
                                            <div class="col">
                                                <span class="bg-black form-control form-control-sm bg-black text-light">Execução: <?=$r["conjuracao"]?></span>
                                            </div>
                                            <div class="col">
                                                <span class="bg-black form-control form-control-sm bg-black text-light">Alcance: <?=$r["alcance"]?></span>
                                            </div>
                                            <div class="col">
                                                <span class="bg-black form-control form-control-sm bg-black text-light">Alvo: <?=$r["alvo"]?></span>
                                            </div>
                                            <div class="col">
                                                <span class="bg-black form-control form-control-sm bg-black text-light">Duração: <?=$r["duracao"]?></span>
                                            </div>
                                            <div class="col-12">
                                                <span class="bg-black form-control form-control-sm bg-black text-light">Resistência: <?=$r["resistencia"]?></span>
                                            </div>
                                        </div>
                                        <div class="row col-12 m-2 g-1">
                                            <div class="col-4 d-grid">
                                                <button class="btn btn-sm btn-outline-light" onclick="rolar('<?=$r["dano"]?>',1)" <?=$edit?:"disabled"?>>Normal</button>
                                            </div>
                                            <div class="col-4 d-grid">
                                                <button class="btn btn-sm btn-outline-light" onclick="rolar('<?=$r["dano2"]?>',2)" <?=$edit?:"disabled"?>>Discente</button>
                                            </div>
                                            <div class="col-4 d-grid">
                                                <button class="btn btn-sm btn-outline-light" onclick="rolar('<?=$r["dano3"]?>',2)" <?=$edit?:"disabled"?>>Verdadeiro</button>
                                            </div>
                                        </div>
                                        <textarea aria-label="Descrição" class="col-12 form-control form-control-sm bg-black text-white fs-5" rows="6" disabled>Descrição: <?= $r["efeito"] ?></textarea>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
            </div>
        </div>
    </div>
</div>