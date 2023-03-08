<div class="col-12" id="notas" style="min-height: 360px">
    <div class="card h-100 w-100 border-secondary">
        <div class="card-header d-flex">
            <h4 class="card-title m-0">Anotações <span id="syncnotes"><i class="fas"></i></span></h4>
	        <?php if (!isset($_GET["popout"])) { ?>
                <button class="btn text-secondary fa-lg mx-1 p-1 popout"  data-fop-pop="notas" style="height: 30px; width: 30px;">
                    <i class="fal fa-rectangle-vertical-history"></i>
                </button>
	        <?php } ?>
        </div>
        <div class="card-body p-0">
            <form class="container-fluid p-0" id="noteform">
                <ul class="nav nav-tabs px-2 my-2" id="notestitle" role="tablist">
                    <?php foreach ($q["notas"] as $ff => $r): ?>
                        <li class="nav-item title" role="presentation">
                            <button class="nav-link  <?=$ff===0?"active":""?>" id="a<?= $r["id"] ?>-tab" data-bs-toggle="pill" data-bs-target="#a<?= $r["id"] ?>" type="button" role="tab"><?= $r["nome"] ?></button>
                        </li>
                    <?php endforeach; ?>



                    <?php if ($q["notas"]->num_rows < 5) { ?>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link link-success addnote"><i class="fa-regular fa-square-plus"></i> Adicionar</button>
                        </li>
                    <?php } ?>
                </ul>
                <div class="tab-content" id="notes">
                    <?php foreach ($q["notas"] as $ff => $r): ?>
                        <div class="tab-pane fade <?=$ff===0?"active show":""?>" id="a<?= $r["id"] ?>" role="tabpanel">
                            <input type="hidden" name="id[]" value="<?= $r["id"] ?>"/>
                            <div class="m-2">
                                <div class="input-group ">
                                    <input type="text" required class="note form-control" name="titulo[]" aria-label="Titulo" placeholder="Titulo" maxlength="30" value="<?= $r["nome"] ?>"/>
                                    <button type="button" data-fop-id="<?= $r["id"] ?>" class="btn btn-outline-danger deletenota"><i class="fal fa-trash"></i></button>
                                </div>
                            </div>
                            <div class="m-2">
                                <textarea name="nota[]" class="note form-control form-control-plaintext border-top-0" rows="10" cols="80" maxlength="5000"><?= $r["notas"] ?></textarea>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" name="query" value="mestre_update_nota"/>
            </form>
        </div>
    </div>
</div>
