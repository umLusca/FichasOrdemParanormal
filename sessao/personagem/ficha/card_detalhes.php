<div class="col">
    <div class="card h-100 bg-black border-light" id="card_dados">
        <div class="card-header text-center clearfix p-0">
            <?php if (!isset($_GET["popout"]) and $edit) { ?>
                <div class="float-start">
                    <button class="btn btn-sm text-white fa-lg popout" title="PopOut">
                        <i class="fa-regular fa-rectangle-vertical-history"></i>
                    </button>
                </div>
            <?php } ?>
            <span class="fs-4">Detalhes</span>
            <?php if ($edit) { ?>
                <div class="float-end">
                    <button class="btn btn-sm text-warning fa-lg" data-bs-toggle="modal" data-bs-target="#editdetalhes"
                            title="Editar">
                        <i class="fa-regular fa-pencil"></i>
                    </button>
                </div>
            <?php } ?>
        </div>
        <div class="card-body p-0">
            <div class="row row-cols-1 row-cols-md-2 g-1">
                <div class="col">
                    <div class="m-2 p-1">
                        <div class="bg-black position-absolute mx-2 pt-1 px-1 text-center">Nome:</div>
                        <div class="p-2 my-3 border border-light"><?= $nome ?></div>
                    </div>
                </div>
                <div class="col">
                    <div class="m-2 p-1">
                        <div class="bg-black position-absolute mx-2 pt-1 px-1 text-center">Jogador:</div>
                        <div class="p-2 my-3 border border-light"><?= $usuario ?></div>
                    </div>
                </div>
                <?php
                if(!empty($rqs["classe"])){?>
                <div class="col">
                    <div class="m-2 p-1">
                        <div class="bg-black position-absolute mx-2 pt-1 px-1 text-center">Classe:</div>
                        <div class="p-2 my-3 border border-light"><?= $rqs["classe"] ?></div>
                    </div>
                </div>
                <?php }?>
                <?php
                if(!empty($rqs["trilha"])){?>
                <div class="col">
                    <div class="m-2 p-1">
                        <div class="bg-black position-absolute mx-2 pt-1 px-1 text-center">Trilha:</div>
                        <div class="p-2 my-3 border border-light"><?= $rqs["trilha"] ?></div>
                    </div>
                </div>
                <?php }?>
                <?php if (!empty($rqs["origem"])) { ?>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-black position-absolute mx-2 pt-1 px-1 text-center">Origem:</div>
                            <div class="p-2 my-3 border border-light"><?= $rqs["origem"] ?></div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($nex) { ?>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-black position-absolute mx-2 pt-1 px-1 text-center">NEX:</div>
                            <div class="p-2 my-3 border border-light"><?= $nex ?></div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (!empty($local)) { ?>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-black position-absolute mx-3 pt-1 px-1 text-center">Nacionalidade:</div>
                            <div class="p-2 my-3 border border-light"><span><?= $local ?></span></div>
                        </div>
                    </div>
                <?php } ?>

                <?php if (!empty($patente) && $pp) { ?>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-black position-absolute mx-2 pt-1 px-1 text-center">Patente:</div>
                            <div class="p-2 my-3 border border-light"><?= $patente ?> <?php if ($pp) { ?> - <?= $pp?><?php } ?></div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($pe_rodada) { ?>
                <div class="col">
                    <div class="m-2 p-1">
                        <div class="bg-black position-absolute mx-2 pt-1 px-1 text-center">PE/Rodada:</div>
                        <div class="p-2 my-3 border border-light"><?= $pe_rodada ?></div>
                    </div>
                </div>
                <?php } ?>
                <?php if (!empty($rqs["afinidade"])) { ?>
                <div class="col">
                    <div class="m-2 p-1">
                        <div class="bg-black position-absolute mx-2 pt-1 px-1 text-center">Afinidade:</div>
                        <div class="p-2 my-3 border border-light"><?= $rqs["afinidade"] ?></div>
                    </div>
                </div>
                <?php } ?>
                <?php if ($idade) { ?>
                <div class="col">
                    <div class="m-2 p-1">
                        <div class="bg-black position-absolute mx-2 pt-1 px-1 text-center">Idade:</div>
                        <div class="p-2 my-3 border border-light"><?= $idade ?></div>
                    </div>
                </div>
                <?php } ?>
                <?php if ($deslocamento) { ?>
                <div class="col">
                    <div class="m-2 p-1">
                        <div class="bg-black position-absolute mx-2 pt-1 px-1 text-center">Deslocamento:</div>
                        <div class="p-2 my-3 border border-light"><?= $deslocamento ?: 0; ?></div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>