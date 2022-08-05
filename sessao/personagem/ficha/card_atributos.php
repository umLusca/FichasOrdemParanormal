<div class="col">
    <div class="card h-100 bg-black border-light" id="card_atributos">
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
                        <button class="btn btn-sm text-warning fa-lg" data-bs-toggle="modal" data-bs-target="#editatrr" title="Editar Atributos">
                            <i class="fa-regular fa-pencil"></i>
                        </button>
                    </div>
		        <?php } ?>
        </div>
        <div class="card-body p-0 ">
            <h1 class="text-center font6">Atributos</h1>
            <div class="container-fluid p-0 mb-2">
                <div class="containera mx-auto font4">
                    <button class="atributos p-0 for btn rounded-circle text-white" <?=$edit?"onclick='rolar(".'"'.(ValorParaRolarDado($forca)).'d20");'."'":'disabled'?>><?=$forca?></button>
                    <button class="atributos p-0 agi btn rounded-circle text-white" <?=$edit?"onclick='rolar(".'"'.(ValorParaRolarDado($agilidade)).'d20");'."'":'disabled'?>><?=$agilidade?></button>
                    <button class="atributos p-0 int btn rounded-circle text-white" <?=$edit?"onclick='rolar(".'"'.(ValorParaRolarDado($intelecto)).'d20");'."'":'disabled'?>><?=$intelecto?></button>
                    <button class="atributos p-0 pre btn rounded-circle text-white" <?=$edit?"onclick='rolar(".'"'.(ValorParaRolarDado($presenca)).'d20");'."'":'disabled'?>><?=$presenca?></button>
                    <button class="atributos p-0 vig btn rounded-circle text-white" <?=$edit?"onclick='rolar(".'"'.(ValorParaRolarDado($vigor)).'d20");'."'":'disabled'?>><?=$vigor?></button>
                    <img src="/assets/img/Atributos.png" alt="Atributos">
                </div>
            </div>
        </div>
        <div class="mx-1 bottom-0">
            <i class="fa-regular fa-circle-info"></i>
            <span> clique para rolar dados</span>
        </div>
    </div>
</div>