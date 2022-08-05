<div class="col">
    <div class="card h-100 bg-black border-light" id="card_dados">
        <div class="card-header clearfix p-0">
            <div class="float-start">
                <?php if (!isset($_GET["popout"]) AND $edit) { ?>
                    <button class="btn btn-sm text-white fa-lg popout" title="PopOut">
                        <i class="fa-regular fa-rectangle-vertical-history"></i>
                    </button>
                <?php } ?>
            </div>
            <?php if ($edit) { ?>
                <div class="float-end">
                    <button class="btn btn-sm text-warning fa-lg" data-bs-toggle="modal" data-bs-target="#editdetalhes" title="Editar">
                        <i class="fa-regular fa-pencil"></i>
                    </button>
                </div>
            <?php } ?>
        </div>
        <div class="card-body p-0">
            <h1 class="text-center">Detalhes</h1>
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
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-black position-absolute mx-2 pt-1 px-1 text-center">Origem:</div>
                            <div class="p-2 my-3 border border-light"><?=$origem?:'Desconhecida.';?></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-black position-absolute mx-2 pt-1 px-1 text-center">Classe:</div>
                            <div class="p-2 my-3 border border-light"><?= $classe?:'Desconhecido.' ?></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-black position-absolute mx-2 pt-1 px-1 text-center">Trilha:</div>
                            <div class="p-2 my-3 border border-light"><?=$trilha?:'Desconhecida.';?></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-black position-absolute mx-2 pt-1 px-1 text-center">Patente:</div>
                            <div class="p-2 my-3 border border-light"><?= $patente?:'Desconhecido.' ?></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-black position-absolute mx-2 pt-1 px-1 text-center">P.P.:</div>
                            <div class="p-2 my-3 border border-light"><?=$pp?:0;?></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-black position-absolute mx-2 pt-1 px-1 text-center">Idade:</div>
                            <div class="p-2 my-3 border border-light"><?= $idade?:'Desconhecido'?></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-black position-absolute mx-2 pt-1 px-1 text-center">NEX:</div>
                            <div class="p-2 my-3 border border-light"><?=$nex?:0;?></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-black position-absolute mx-3 pt-1 px-1 text-center">Nacionalidade:</div>
                            <div class="p-2 my-3 border border-light"><span><?=$local?:"Desconhecido.";?></span></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-black position-absolute mx-2 pt-1 px-1 text-center">Deslocamento:</div>
                            <div class="p-2 my-3 border border-light"><?=$deslocamento?:0;?></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="m-2 p-1">
                            <div class="bg-black position-absolute mx-2 pt-1 px-1 text-center">Afinidade:</div>
                            <div class="p-2 my-3 border border-light"><?php
                                switch ($rqs["afinidade"]){
                                    default:
                                        echo "Nenhum";
                                        break;
                                    case 1:
                                        echo "Morte";
                                        break;
                                    case 2:
                                        echo "Sangue";
                                        break;
                                    case 3:
                                        echo "Energia";
                                        break;
                                    case 4:
                                        echo "Conhecimento";
                                        break;
                                    case 5:
                                        echo "Medo";
                                        break;
                                }?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>