<div class="col">
    <div class="card h-100 bg-black border-light" id="card_rituais">
        <div class="card-header clearfix text-center p-0">
			<?php if (!isset($_GET["popout"]) and $edit) { ?>
                <div class="float-start">
                    <button class="btn btn-sm text-white popout fa-lg" title="PopOut">
                        <i class="fa-regular fa-rectangle-vertical-history"></i>
                    </button>
                </div>
			<?php } ?>
            <span class="font6 fs-4">Rituais</span>

			<?php if ($edit) { ?>
                <div class="float-end">
                    <button class="btn btn-sm text-success fa-lg" data-bs-toggle="modal" data-bs-target="#addritual"
                            title="Adicionar Ritual">
                        <i class="fa-regular fa-square-plus"></i>
                    </button>
                </div>
			<?php } ?>
        </div>
        <div class="card-body font1">
            <nav class="">
                <div class="nav nav-tabs" role="tablist">
					<?php foreach ($s[6] as $i => $r): ?>
                        <button class="text-light btn-sm nav-link <?= ($i == 0) ? 'active' : '' ?>"
                                id="but-ritual-tab-<?= $i ?>"
                                data-bs-toggle="tab"
                                data-bs-target="#but-ritual-<?= $i ?>"
                                type="button"
                                role="tab"><?= $r["nome"] ?></button>
					<?php endforeach; ?>
                </div>
            </nav>
            <div class="m-2">
                <div class="tab-content">
					<?php foreach ($s[6] as $i => $r): ?>
                        <div class="tab-pane fade <?= ($i == 0) ? 'show active' : '' ?>" id="but-ritual-<?= $i ?>"
                             role="tabpanel">
                            <div class="container-fluid font2 text-start">
                                <div class="row g-1">
                                    <div class="col-12 col-md-auto text-center align-self-center">
                                        <img class="border border-light foto" style="width: 25vh;"
                                             src="<?= ($r["foto"] === '1') ? "/assets/img/desconhecido.webp" : $r["foto"] ?>"
                                             alt="Ritual">
                                    </div>
                                    <div class="col-12 col-md align-content-center">
                                        <div class="row g-1 m-1 row-cols-2">
                                            <div class="col-12">
                                                <div class="position-relative border rounded-1">
													<?php if ($edit) { ?>
                                                        <div class="btn-group position-sticky float-end">

                                                            <button class="btn btn-sm text-warning" onclick="editritual(<?=$i?>,<?= $r["id"] ?>)">
                                                                <i class="fat fa-pencil"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-danger" onclick="deletar(<?= $r["id"] ?>,'<?= $r["nome"] ?>','deleteritual')">
                                                                <i class="fat fa-trash"></i>
                                                            </button>
                                                        </div>
													<?php } ?>
                                                    <span class="col form-control form-control-sm bg-black text-light border-0">Nome: <span class="nome"><?= $r["nome"] ?></span></span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <span class="form-control form-control-sm bg-black text-light">Elemento: <span class="elemento"><?= $r["elemento"] ?></span> -  <span class="circulo"><?= $r["circulo"] ?></span></span>
                                            </div>
                                            <div class="col">
                                                <span class="bg-black form-control form-control-sm bg-black text-light">Execução:  <span class="conjuracao"><?= $r["conjuracao"] ?></span></span>
                                            </div>
                                            <div class="col">
                                                <span class="bg-black form-control form-control-sm bg-black text-light">Alcance:  <span class="alcance"><?= $r["alcance"] ?></span></span>
                                            </div>
                                            <div class="col">
                                                <span class="bg-black form-control form-control-sm bg-black text-light">Alvo:  <span class="alvo"><?= $r["alvo"] ?></span></span>
                                            </div>
                                            <div class="col">
                                                <span class="bg-black form-control form-control-sm bg-black text-light">Duração:  <span class="duracao"><?= $r["duracao"] ?></span></span>
                                            </div>
                                            <div class="col">
                                                <span class="bg-black form-control form-control-sm bg-black text-light">Resistência:  <span class="resistencia"><?= $r["resistencia"] ?></span></span>
                                            </div>
                                            <div class="col-12">
                                                <div class="row g-1">
                                                    <div class="col-4 d-grid">
                                                        <button class="btn btn-sm btn-outline-light normal" data-dado="<?= $r["dano"] ?>"
                                                                onclick="rolar('<?= $r["dano"] ?>',1)" <?= $edit ?: "disabled" ?>>
                                                            Normal
                                                        </button>
                                                    </div>
                                                    <div class="col-4 d-grid">
                                                        <button class="btn btn-sm btn-outline-light discente" data-dado="<?= $r["dano2"] ?>"
                                                                onclick="rolar('<?= $r["dano2"] ?>',2)" <?= $edit ?: "disabled" ?>>
                                                            Discente
                                                        </button>
                                                    </div>
                                                    <div class="col-4 d-grid">
                                                        <button class="btn btn-sm btn-outline-light verdadeiro" data-dado="<?= $r["dano3"] ?>"
                                                                onclick="rolar('<?= $r["dano3"] ?>',2)" <?= $edit ?: "disabled" ?>>
                                                            Verdadeiro
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 fs-5">
                                        <div class="border rounded-1 p-2">
                                            <span class="desc"><?= $r["efeito"] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					<?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>