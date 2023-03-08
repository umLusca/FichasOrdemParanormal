<div class="col">
    <div class="card h-100" id="card_atributos">
        <div class="card-header d-flex justify-content-center">
                <div class="float-start">
                    <?php if (!isset($_GET["popout"]) AND $edit) { ?>
                        <button class="btn text-secondary btn-sm fa-lg popout"  title="PopOut">
                            <i class="fal fa-rectangle-vertical-history"></i>
                        </button>
                    <?php } ?>
                </div>
            <h4 class="m-0 mx-auto">Atributos</h4>
                    <div class="float-end">
                        <?php if ($edit) { ?>
                        <button class="btn btn-sm text-warning fa-lg" data-bs-toggle="modal" data-bs-target="#editatrr" title="Editar Atributos">
                            <i class="fa-regular fa-pencil"></i>
                        </button>
                        <?php } ?>
                    </div>
        </div>
        <div class="card-body p-0 ">
            <div class="container-fluid p-0 my-2">
                <?=atributos($forca,$agilidade,$intelecto,$vigor,$presenca,$edit)?>
            </div>
            <div class="mx-1">
                <i class="fa-regular fa-circle-info"></i>
                <span> clique para rolar dados</span>
            </div>
        </div>
    </div>
</div>