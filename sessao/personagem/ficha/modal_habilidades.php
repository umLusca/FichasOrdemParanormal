<!-- Modal Habilidades-->
<form class="modal fade" id="addhab" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-black border-light">
            <div class="modal-header">
                <span class="fs-4">Adicionar</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="status" value="addhab"/>
                <div class="m-2">
                    <label class="form-floating w-100">
                        <input type="text" name="hab" class="form-control fs-6 bg-black text-white" placeholder="Título" minlength="5" required/>
                        <label>Nome</label>
                    </label>
                </div>
                <div class="m-2">
                    <label class="form-floating w-100">
                        <textarea class="form-control bg-black text-white" placeholder="Descriçao" name="desc" minlength="10" required></textarea>
                        <label>Descrição</label>
                    </label>
                </div>
                <div class="form-check form-switch m-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="addcomopoder" name="poder">
                    <label class="form-check-label" for="addcomopoder">Poder paranormal</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success w-100" value="submit">Adicionar</button>
            </div>
        </div>
    </div>
</form>

<!-- Editar Habilidades-->
<div class="modal fade" id="edithab" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-black border-light">
            <div class="modal-header">
                <nav>
                    <div class="d-flex justify-content-center m-2" role="tablist">
                        <button class="btn btn-outline text-light active mx-2" id="edit-aba-habilidades" data-bs-toggle="tab" data-bs-target="#edit-habilidades" type="button" role="tab" aria-controls="edit-habilidades" aria-selected="true">Habilidades</button>
                        <button class="btn btn-outline text-light mx-2" id="edit-aba-poderes" data-bs-toggle="tab" data-bs-target="#edit-poderes" type="button" role="tab" aria-controls="edit-poderes" aria-selected="false">Poderes</button>
                    </div>
                </nav>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="status" value="edithab"/>

                <div class="tab-content m-2">
                    <div class="tab-pane fade show active" id="edit-habilidades" role="tabpanel" aria-labelledby="edit-aba-habilidades" tabindex="0">
                        <h4 class="font6 text-center">Editar Habilidades</h4>
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
                        <h4 class="font6 text-center">Editar Poderes</h4>
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
            </div>
        </div>
    </div>
</div>
