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
                <?=atributos($forca,$agilidade,$intelecto,$vigor,$presenca)?>
            </div>
        </div>
        <div class="mx-1 bottom-0">
            <i class="fa-regular fa-circle-info"></i>
            <span> clique para rolar dados</span>
        </div>
    </div>
</div>