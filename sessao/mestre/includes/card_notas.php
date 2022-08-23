<div class="col-12" id="notas">
    <div class="card h-100 w-100 bg-black border-light">
        <div class="card-body p-0">
            <div class="card-header border-0">
                <div class="card-title fs-2 text-center font6">Anotações <span id="syncnotes" class="invisible"><i class="fas"></i></span></div>
            </div>
            <form class="container-fluid p-0" id="noteform">
                <ul class="nav nav-pills justify-content-center mb-3" id="notestitle" role="tablist">
                    <?php
                    foreach ($nt as $r):?>
                        <li class="nav-item title" role="presentation">
                            <button class="nav-link" id="a<?= $r["id"] ?>-tab" data-bs-toggle="pill"
                                    data-bs-target="#a<?= $r["id"] ?>" type="button" role="tab"
                                    aria-controls="a<?= $r["id"] ?>" aria-selected="true"><?= $r["nome"] ?></button>
                        </li>
                    <?php endforeach; ?>
                    <?php if ($nt->num_rows < 5) { ?>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="btn text-success" onclick="addnote();"><i
                                    class="fa-regular fa-square-plus"></i> Adicionar
                            </button>
                        </li>
                    <?php } ?>
                </ul>
                <div class="tab-content" id="notes">
                    <?php foreach ($nt as $r): ?>
                        <div class="tab-pane fade show" id="a<?= $r["id"] ?>" role="tabpanel"
                             aria-labelledby="a<?= $r["id"] ?>-tab">
                            <input type="hidden" name="id[]" value="<?= $r["id"] ?>"/>
                            <div class="input-group">
                                <input type="text" required class="note form-control bg-black text-light"
                                       name="titulo[]" aria-label="Titulo" placeholder="Titulo" maxlength="30"
                                       value="<?= $r["nome"] ?>"/>
                                <button type="button" onclick="deletenote(<?= $r["id"] ?>)"
                                        class="btn text-danger fa-regular fa-trash"></button>
                            </div>
                            <textarea aria-label="a<?= $r["id"] ?>" id="editor1" name="nota[]" class="note form-control bg-black text-light"
                                      rows="10" cols="80" maxlength="5000"><?= $r["notas"] ?></textarea>
                        </div>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" name="status" value="syncnotes"/>
            </form>
        </div>
    </div>
</div>