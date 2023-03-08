<div class="col">
    <div class="card h-100" id="card_dados">
        <div class="card-header d-flex justify-content-between">
            <?php if (!isset($_GET["popout"]) and $edit) { ?>
                <div class="float-start">
                    <button class="btn btn-sm text-secondary fa-lg popout" title="PopOut">
                        <i class="fal fa-rectangle-vertical-history"></i>
                    </button>
                </div>
            <?php } ?>
            <h4 class="m-0">Informações</h4>
            <?php if ($edit) { ?>
                <div class="float-end">
                    <button class="btn btn-sm text-warning fa-lg" data-bs-toggle="modal" data-bs-target="#editdetalhes" title="Editar">
                        <i class="fal fa-pencil"></i>
                    </button>
                </div>
            <?php } ?>
        </div>
        <div class="card-body p-0">
            <div class="row row-cols-1 row-cols-md-2 g-1">
                <div class="col">
                    <div class="m-2 p-1">
                        <div class="bg-body position-absolute mx-2 pt-1 px-1 text-center">Nome</div>
                        <div class="p-2 my-3 border border-secondary"><?= $nome ?></div>
                    </div>
                </div>
                <div class="col">
                    <div class="m-2 p-1">
                        <div class="bg-body position-absolute mx-2 pt-1 px-1 text-center">Jogador</div>
                        <div class="p-2 my-3 border border-secondary"><?= $usuario ?></div>
                    </div>
                </div>
                <?php
                if (!empty($ficha["classe"])) {
                    ?>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-body position-absolute mx-2 pt-1 px-1 text-center">Classe</div>
                            <div class="p-2 my-3 border border-secondary"><?= $ficha["classe"] ?></div>
                        </div>
                    </div>
                <?php } ?>
                <?php
                if (!empty($ficha["trilha"])) {
                    ?>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-body position-absolute mx-2 pt-1 px-1 text-center">Trilha</div>
                            <div class="p-2 my-3 border border-secondary"><?= $ficha["trilha"] ?></div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (!empty($ficha["origem"])) { ?>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-body position-absolute mx-2 pt-1 px-1 text-center">Origem</div>
                            <div class="p-2 my-3 border border-secondary"><?= $ficha["origem"] ?></div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($nex) { ?>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-body position-absolute mx-2 pt-1 px-1 text-center">NEX</div>
                            <div class="p-2 my-3 border border-secondary"><?= $nex ?></div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (!empty($local)) { ?>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-body position-absolute mx-3 pt-1 px-1 text-center">Nacionalidade</div>
                            <div class="p-2 my-3 border border-secondary"><span><?= $local ?></span></div>
                        </div>
                    </div>
                <?php } ?>

                <?php if (!empty($patente) && $pp) { ?>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-body position-absolute mx-2 pt-1 px-1 text-center">Patente</div>
                            <div class="p-2 my-3 border border-secondary"><?= $patente ?> <?php if ($pp) { ?> - <?= $pp ?><?php } ?></div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($pe_rodada) { ?>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-body position-absolute mx-2 pt-1 px-1 text-center">PE/Rodada</div>
                            <div class="p-2 my-3 border border-secondary"><?= $pe_rodada ?></div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (!empty($ficha["afinidade"])) { ?>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-body position-absolute mx-2 pt-1 px-1 text-center">Afinidade</div>
                            <div class="p-2 my-3 border border-secondary"><?= $ficha["afinidade"] ?></div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($idade) { ?>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-body position-absolute mx-2 pt-1 px-1 text-center">Idade</div>
                            <div class="p-2 my-3 border border-secondary"><?= $idade ?></div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($deslocamento) { ?>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-body position-absolute mx-2 pt-1 px-1 text-center">Deslocamento</div>
                            <div class="p-2 my-3 border border-secondary"><?= $deslocamento ?: 0; ?></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>