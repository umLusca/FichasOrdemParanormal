<!-- Modal Habilidades-->
<div class="modal fade" id="addhab" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" id="formaddhab">
                <button type="button" class="btn-close btn-close-white position-absolute end-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                <input type="hidden" name="status" value="addhab"/>
                <div class="text-center"><h2>Adicionar</h2></div>
                <div class="m-3">
                    <label for="habnome" class="fs-4 fw-bold">Nome</label>
                    <input type="text" id="habnome" name="hab" class="form-control fs-6 bg-black text-white" minlength="5" required/>

                    <label for="deschab" class="fs-4 fw-bold">Descrição</label>
                    <textarea id="deschab" class="form-control bg-black text-white" name="desc" minlength="10" required></textarea>

                    <div class="form-check form-switch my-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="addcomopoder" name="poder">
                        <label class="form-check-label" for="addcomopoder">Poder paranormal</label>
                    </div>

                </div>
                <div class="clearfix">
                    <button type="submit" class="btn btn-success float-end" value="submit">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Editar Habilidades-->
<div class="modal fade" id="edithab" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" id="formedithab">
                <button type="button" class="btn-close btn-close-white position-absolute end-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                <input type="hidden" name="status" value="edithab"/>
                <nav>
                    <div class="d-flex justify-content-center m-2" role="tablist">
                        <button class="btn btn-outline text-light active mx-2" id="edit-aba-habilidades" data-bs-toggle="tab" data-bs-target="#edit-habilidades" type="button" role="tab" aria-controls="edit-habilidades" aria-selected="true">Habilidades</button>
                        <button class="btn btn-outline text-light mx-2" id="edit-aba-poderes" data-bs-toggle="tab" data-bs-target="#edit-poderes" type="button" role="tab" aria-controls="edit-poderes" aria-selected="false">Poderes</button>
                    </div>
                </nav>

                <div class="tab-content m-2">
                    <div class="tab-pane fade show active" id="edit-habilidades" role="tabpanel" aria-labelledby="edit-aba-habilidades" tabindex="0">
                        <h1 class="font6 text-center">Editar Habilidades</h1>
                        <?php
                        foreach ($s[2] as $r):
                            ?>
                            <input type="hidden" name="did[]" value="<?= $r["id"] ?>">
                            <input type="hidden" name="p[]" value="0">
                            <div class="m-3">
                                <input type="text" aria-label="" name="nome[]" class="form-control fs-6 bg-black text-white" value="<?= $r["nome"]; ?>"/>
                                <textarea aria-label="" name="desc[]" class="form-control bg-black text-light border-0 font7"><?= $r["descricao"]; ?></textarea>
                            </div>
                        <?php
                        endforeach;

                        ?>
                    </div>
                    <div class="tab-pane fade" id="edit-poderes" role="tabpanel" aria-labelledby="edit-aba-poderes" tabindex="0">
                        <h1 class="font6 text-center">Editar Poderes</h1>
                        <?php
                        foreach ($s[7] as $r):
                            ?>
                            <input type="hidden" name="did[]" value="<?= $r["id"] ?>">
                            <input type="hidden" name="p[]" value="1">
                            <div class="m-3">
                                <input type="text" aria-label="" name="nome[]" class="form-control fs-6 bg-black text-white" value="<?= $r["nome"]; ?>"/>
                                <textarea aria-label="" name="desc[]" class="form-control bg-black text-light border-0 font7"><?= $r["descricao"]; ?></textarea>
                            </div>
                        <?php
                        endforeach;

                        ?>
                    </div>
                </div>

                <div class="clearfix">
                    <button type="submit" class="btn btn-success float-end" value="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
