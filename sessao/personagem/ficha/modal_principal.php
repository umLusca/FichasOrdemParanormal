<!-- Modal proeficiencias-->
<form class="modal modal-xl fade" id="editprincipal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-fullscreen-md-down">
        <div class="modal-content bg-black border-light">
            <div class="modal-header">
                <span class="fs-4 modal-title">Editar Status</span>
                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                        <span class="text-info fa-solid fa-circle-info"> Os campos em azuis pode ser calculados automaticamente colocando 1.</span>

                <h4 class="text-center mt-3">Saúde</h4>
                <div class="row row-cols-1 row-cols-md-3 g-2">
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="border-info input-group-text bg-black text-white border-end-0">Vida: total</span>
                            <input class="border-info form-control bg-black text-white border-start-0"
                                   min="1" max="999" type="number" name="pv" value="<?= $pv ?>"/>
                        </label>
                    </div>
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="border-info input-group-text bg-black text-white border-end-0">Sanidade: total</span>
                            <input class="border-info form-control bg-black text-white border-start-0"
                                   type="number" min=1 max="999" name="san" value="<?= $san ?>"/>
                        </label>
                    </div>
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="border-info input-group-text bg-black text-white border-end-0">Esforço: total</span>
                            <input class="border-info form-control bg-black text-white border-start-0"
                                   min="0" max="200" type="number" name="pe" value="<?= $pe ?>"/>
                        </label>
                    </div>
                </div>
                <h4 class="text-center mt-3">Defesas</h4>
                <div class="row row-cols-1 row-cols-md-3 g-2">
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="input-group-text bg-black text-white border-end-0">Passiva:</span>
                            <input class="form-control bg-black text-white border-start-0" type="number" min="0" max="999" name="passiva" value="<?= $passiva ?>"/>
                        </label>
                    </div>
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="input-group-text bg-black text-white border-end-0">Esquiva:</span>
                            <input class="form-control bg-black text-white border-start-0" type="number" min="0" max="999" name="esquiva" value="<?= $esquiva ?>"/>
                        </label>
                    </div>
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="input-group-text bg-black text-white border-end-0">Bloqueio:</span>
                            <input class="form-control bg-black text-white border-start-0" type="number" min="0" max="999" name="bloqueio" value="<?= $bloqueio ?>"/>
                        </label>
                    </div>
                </div>
                <h4 class="text-center mt-3">Resistencias a Elementos</h4>
                <div class="row row-cols-1 row-cols-md-2 g-1">
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="input-group-text bg-black text-white border-end-0">Mental:</span>
                            <input class="form-control bg-black text-white border-start-0"
                                   type="number" min="0" max="50" name="mental" value="<?= $insanidade ?>"/>
                        </label>
                    </div>
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="input-group-text bg-black text-white border-end-0">Morte:</span>
                            <input class="form-control bg-black text-white border-start-0" type="number" min="0"
                                   max="50" name="morte" value="<?= $morte ?>"/>
                        </label>
                    </div>
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="input-group-text bg-black text-white border-end-0">Conhecimento:</span>
                            <input class="form-control bg-black text-white border-start-0"
                                   type="number" min="0" max="50" name="conhecimento" value="<?= $conhecimento ?>"/>
                        </label>
                    </div>
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="input-group-text bg-black text-white border-end-0">Sangue:</span>
                            <input class="form-control bg-black text-white border-start-0"
                                   type="number" min="0" max="50" name="sangue" value="<?= $sangue ?>"/>
                        </label>
                    </div>
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="input-group-text bg-black text-white border-end-0">Energia:</span>
                            <input class="form-control bg-black text-white border-start-0"
                                   type="number" min="0" max="50" name="energia" value="<?= $energia ?>"/>
                        </label>
                    </div>
                    <div class="">
                    </div>
                </div>
                <h4 class="text-center mt-3">Outras Resistências</h4>
                <div class="row row-cols-md-2 row-cols-1 g-1">

                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="input-group-text bg-black text-white border-end-0">Física:</span>
                            <input class="form-control bg-black text-white border-start-0"
                                   type="number" min="0" max="50" name="fisica" value="<?= $fisica ?>"/>
                        </label>
                    </div>
                    <div class="">
                        <label class="input-group input-group-sm">
                            <span class="input-group-text bg-black text-white border-end-0">Balística:</span>
                            <input class="form-control bg-black text-white border-start-0"
                                   type="number" min="0" max="50" name="balistica" value="<?= $balistica ?>"/>
                        </label>
                    </div>
                    <div>
                        <label class="input-group input-group-sm">
                            <span class="input-group-text bg-black text-white border-end-0">Corte:</span>
                            <input class="form-control bg-black text-white border-start-0"
                                   type="number" min="0" max="50" name="corte" value="<?= $corte ?>"/>
                        </label>

                    </div>
                    <div>
                        <label class="input-group input-group-sm">
                            <span class="input-group-text bg-black text-white border-end-0">Impacto:</span>
                            <input class="form-control bg-black text-white border-start-0"
                                   type="number" min="0" max="50" name="impacto" value="<?= $impacto ?>"/>
                        </label>

                    </div>
                    <div>
                        <label class="input-group input-group-sm">
                            <span class="input-group-text bg-black text-white border-end-0">Perfuração:</span>
                            <input class="form-control bg-black text-white border-start-0"
                                   type="number" min="0" max="50" name="perfuracao" value="<?= $perfuracao ?>"/>
                        </label>

                    </div>
                    <div>
                        <label class="input-group input-group-sm">
                            <span class="input-group-text bg-black text-white border-end-0">Eletricidade:</span>
                            <input class="form-control bg-black text-white border-start-0"
                                   type="number" min="0" max="50" name="eletricidade" value="<?= $eletricidade ?>"/>
                        </label>

                    </div>
                    <div>
                        <label class="input-group input-group-sm">
                            <span class="input-group-text bg-black text-white border-end-0">Fogo:</span>
                            <input class="form-control bg-black text-white border-start-0"
                                   type="number" min="0" max="50" name="fogo" value="<?= $fogo ?>"/>
                        </label>

                    </div>
                    <div>
                        <label class="input-group input-group-sm"><span
                                    class="input-group-text bg-black text-white border-end-0">Frio:</span>
                            <input class="form-control bg-black text-white border-start-0"
                                   type="number" min="0" max="50" name="frio" value="<?= $frio ?>"/></label>
                    </div>
                    <div>
                        <label class="input-group input-group-sm">
                            <span class="input-group-text bg-black text-white border-end-0">Química:</span>
                            <input class="form-control bg-black text-white border-start-0"
                                   type="number" min="0" max="50" name="quimico" value="<?= $quimica ?>"/>
                        </label>
                    </div>


                    <input type="hidden" name="status" value="editpri"/>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-success w-100" type="submit">Salvar</button>
            </div>
        </div>
    </div>
</form>

<!---TROCAR DE PERFIL MODAL--->
<div class="modal fade" id="trocarficha" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-black border-light">
            <div class="modal-header">
                <span class="fs-4 modal-title">Trocar Rápido</span>
                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body justify-content-center text-center">

                <?php
                $k = $con->query("SELECT * FROM `ligacoes` WHERE `id_usuario` = '" . $_SESSION["UserID"] . "' AND `id_ficha` IS NOT NULL;");
                if ($k->num_rows) {
                    echo "<h5>Com missão</h5>";
                    foreach ($k as $r):
                        $ks = $con->query("SELECT * FROM `fichas_personagem` WHERE `id` = '" . $r["id_ficha"] . "'");
                        $rs = mysqli_fetch_array($ks);
                        ?>
                        <div class="d-grid gap-2 m-2">
                            <a class="btn btn-primary" href="./?token=<?= $rs["token"] ?>"><?= $rs["nome"] ?></a>
                        </div>
                    <?php
                    endforeach;
                }
                $k = $con->query("SELECT * FROM `fichas_personagem` WHERE `usuario` = '" . $_SESSION["UserID"] . "';");
                if ($k->num_rows) {
                    echo "<h5>Todas as Fichas</h5>";
                    foreach ($k as $r):
                        ?>
                        <div class="d-grid gap-2 m-2">
                            <a class="btn btn-primary" href="./?token=<?= $r["token"] ?>"><?= $r["nome"] ?></a>
                        </div>
                    <?php
                    endforeach;
                }

                ?>
            </div>
        </div>
    </div>
</div>
