<!-- Modal ARMAS -->
<div class="modal fade" id="editinv" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-black border-light">
            <div class="modal-body px-2">
                <div class="clearfix mb-5">
                    <button type="button" class="btn-close btn-close-white me-2 m-auto float-end"
                            data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <h1 class="text-center">Armas</h1>
                <table class="table table-sm bg-black text-white table-borderless font2 mb-5 border border-light">
                    <thead>
                    <tr>
                        <th>
                            <button data-bs-toggle="modal" data-bs-target="#addarma" class="btn btn-sm text-success"
                                    title="Adicionar Arma">
                                <i class="fa-solid fa-square-plus"></i>
                            </button>
                        </th>
                        <th scope="col">Nome</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Ataque</th>
                        <th scope="col">Alcance</th>
                        <th scope="col">Dano</th>
                        <th scope="col">Crítico</th>
                        <th scope="col">Margem</th>
                        <th scope="col">Recarga</th>
                        <th scope="col">Especial</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($s[1] as $row): ?>
                        <tr id="armaid<?= $row["id"] ?>">
                            <td>
                                <button data-bs-toggle="modal" data-bs-target="#editarma"
                                        onclick="editarma(<?= $row["id"]; ?>)" class="btn btn-sm text-warning">
                                    <i class="fa-regular fa-pencil"></i>
                                </button>
                            </td>
                            <td class="arma"><?= $row['arma']; ?></td>
                            <td class="tipo"><?= $row['tipo']; ?></td>
                            <td class="ataque"><?= $row['ataque']; ?></td>
                            <td class="alcance"><?= $row['alcance']; ?></td>
                            <td class="dano"><?= $row['dano']; ?></td>
                            <td class="critico"><?= $row['critico']; ?></td>
                            <td class="margem"><?= $row['margem']; ?></td>
                            <td class="recarga"><?= $row['recarga']; ?></td>
                            <td class="especial"><?= $row['especial']; ?></td>
                            <td>
                                <button onclick="deletar(<?=$row["id"]?>, '<?=$row["arma"]?>', 'delarma')" title="Editar Arma" class="btn btn-sm text-danger">
                                    <i class="fa-regular fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <h1 class="text-center">Itens</h1>
                <table class="table table-sm bg-black text-white table-borderless font2 mb-3 border border-light">
                    <thead>
                    <tr>
                        <th>
                            <button data-bs-toggle="modal" data-bs-target="#additem" class="btn btn-sm text-success"
                                    title="Adicionar Item">
                                <i class="fa-regular fa-square-plus"></i>
                            </button>
                        </th>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Espaços</th>
                        <th scope="col">Categoria</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($s[4] as $row): ?>
                        <tr id="itemid<?= $row["id"] ?>">
                            <th>
                                <button data-bs-toggle="modal" data-bs-target="#edititem"
                                        onclick="edititem(<?= $row["id"]; ?>)" class="btn btn-sm text-warning">
                                    <i class="fa-regular fa-pencil"></i>
                                </button>
                            </th>
                            <th class="nome"><?= $row['nome']; ?></th>
                            <td class="desc"><?= $row['descricao']; ?></td>
                            <td class="espaco"><?= $row['espaco']; ?></td>
                            <td class="prestigio"><?= $row['prestigio']; ?></td>
                            <td>
                                <button onclick="deletar(<?= $row["id"]; ?>,'<?=$row['nome']?>','delitem')" title="Deletar <?=$row['nome']?>" class="btn btn-sm text-danger">
                                    <i class="fa-regular fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal EDITAR ARMA -->
<div class="modal fade" id="editarma" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" method="post" autocomplete="off" id="formeditarma">
                <div class="border-0 modal-header fs-1">Editar arma</div>
                <div class="row my-5 g-2">
                    <div class="col-12">
                        <div class="input-group">
                            <label for="enome"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Nome:</label>
                            <input id="enome" maxlength="<?=$Arma_nome?>" name="nome" type="text" class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-group">
                            <label for="etipo" class="p-1 input-group-text border-light bg-black text-white border-end-0">Tipo:</label>
                            <input id="etipo" name="tipo" type="text" maxlength="<?=$Arma_tipo?>" class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group">
                            <label for="eataque" class="p-1 input-group-text border-light bg-black text-white border-end-0">Ataque:</label>
                            <input id="eataque" name="ataque" type="text" minlength="0" maxlength="<?=$Arma_ataq?>" placeholder="1d20"
                                   class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group">
                            <label for="ealcance"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Alcance:</label>
                            <input id="ealcance" name="alcance" type="text" maxlength="<?=$Arma_alca?>"
                                   class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group">
                            <label for="edano"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Dano:</label>
                            <input id="edano" name="dano" type="text" maxlength="<?=$Arma_dano?>" placeholder="1d4"
                                   class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group">
                            <label for="ecritico"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Critico:</label>
                            <input id="ecritico" name="critico" type="text" maxlength="<?=$Arma_crit?>" placeholder="2d4"
                                   class="form-control border-start-0 border-light bg-black text-white"/>
                            <input id="emargem" title="margem" name="margem" type="number" min="0" max="20" maxlength="<?=$Arma_crit?>" placeholder="18"
                                   class="form-control border-light bg-black text-white"/>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group">
                            <label for="erecarga"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Recarga:</label>
                            <input id="erecarga" name="recarga" type="text" maxlength="<?=$Arma_reca?>"
                                   class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                    </div>


                    <div class="col-6">
                        <div class="input-group">
                            <label for="eespecial"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Especial:</label>
                            <input id="eespecial" name="especial" type="text" maxlength="<?=$Arma_espe?>"
                                   class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="did" value="" id="editarmaid"/>
                <input type="hidden" name="status" value="editarma"/>
                <div class="clearfix mx-5">
                    <button type="button" class="btn btn-secondary float-start" data-bs-dismiss="modal"
                            onclick="cleanedit()">Cancelar
                    </button>
                    <button type="submit" class="btn btn-success float-end" data-bs-dismiss="modal">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal EDITAR ITEM -->
<div class="modal fade" id="edititem" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" method="post" autocomplete="off" id="formedititem">
                <div class="border-0 modal-header fs-1">Editar Item</div>
                <div class="row my-5 justify-content-center g2">
                    <div class="col-12">
                        <div class="input-group">
                            <label for="enom" class="p-1 input-group-text border-light bg-black text-white border-end-0">Nome:</label>
                            <input id="enom" name="nome" type="text" maxlength="<?=$Inv_nome?>" class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-group">
                            <label for="edes"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Descrição:</label>
                            <input id="edes" name="descricao" type="text" maxlength="<?=$Inv_desc?>"
                                   class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group">
                            <label for="epes"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Peso/Espaço:</label>
                            <input id="epes" name="peso" type="number" min="-50"
                                   class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group">
                            <label for="epre"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Categoria:</label>
                            <input id="epre" name="prestigio" type="number" max="50"
                                   class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="did" value="" id="edititid"/>
                <input type="hidden" name="status" value="edititem"/>
                <div class="clearfix mx-5">
                    <button type="button" class="btn btn-secondary float-start" data-bs-dismiss="modal"
                            onclick="cleanedit()">Cancelar
                    </button>
                    <button type="submit" class="btn btn-success float-end" data-bs-dismiss="modal">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal ADD ITEM -->
<div class="modal fade" id="additem" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" method="post" autocomplete="off" id="formadditem">
                <div class="border-0 modal-header fs-1">Adicionar Item</div>
                <div class="row my-5 g-2">
                    <div class="col-12">
                        <div class="input-group">
                            <label for="anom"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Nome:</label>
                            <input id="anom" name="nome" type="text" maxlength="<?=$Inv_nome?>"
                                   class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-group">
                            <label for="ades"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Descrição:</label>
                            <input id="ades" name="descricao" type="text" maxlength="<?=$Inv_desc?>"
                                   class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group">
                            <label for="apes"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Peso/Espaço:</label>
                            <input id="apes" name="peso" type="number" min="-50" max="50" class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group">
                            <label for="apre"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Categoria:</label>
                            <input id="apre" name="prestigio" type="number" min="-50" max="50"
                                   class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="status" value="additem"/>
                <div class="clearfix mx-5">
                    <button type="button" class="btn btn-secondary float-start" data-bs-dismiss="modal"
                            onclick="cleanedit()">Cancelar
                    </button>
                    <button type="submit" class="btn btn-success float-end" data-bs-dismiss="modal">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!--------------------------ADD ARMAS---------------------------------------------------------------->
<div class="modal fade" id="addarma" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" method="post" autocomplete="off" id="formaddarmas" novalidate>
                <div class="border-0 modal-header fs-1">Adicionar arma</div>
                <div class="row my-3 mx-1">
                    <div class="col-sm">
                        <div class="input-group input-group-sm mb-2">
                            <label for="anome"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Nome:</label>
                            <input autocomplete="" id="anome" name="nome" type="text" maxlength="<?=$Arma_nome?>"
                                   class="rounded-end form-control border-start-0 border-light bg-black text-white"
                                   required/>
                            <div class="invalid-feedback">Coloque o Nome.(Apenas letras e espaços)</div>
                        </div>
                        <div class="input-group input-group-sm mb-2">
                            <label for="atipo"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Tipo:</label>
                            <input id="atipo" name="tipo" type="text" maxlength="<?=$Arma_tipo?>"
                                   class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                        <div class="invalid-feedback">(Apenas letras e espaços)</div>
                        <div class="input-group input-group-sm mb-2">
                            <label for="aataque"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Ataque:</label>
                            <input id="aataque" name="ataque" type="text" maxlength="<?=$Arma_ataq?>"
                                   placeholder="Caso não saiba, olhe no como rolar dados!" value="2d20+|FOR|" class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                        <div class="input-group input-group-sm mb-2">
                            <label for="aalcance"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Alcance:</label>
                            <input id="aalcance" name="alcance" type="text" maxlength="<?=$Arma_alca?>"
                                   class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="input-group input-group-sm mb-2">
                            <label for="adano"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Dano:</label>
                            <input id="adano" name="dano" type="text" placeholder="1d4+|FOR|" maxlength="<?=$Arma_dano?>"
                                   class="form-control border-start-0 border-light bg-black text-white rounded-end"
                                   required/>
                            <div class="invalid-feedback">(Apenas valores dos dados ex: 2d20+5)</div>
                        </div>
                        <div class="input-group input-group-sm mb-2">
                            <label for="acritico"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Critico:</label>
                            <input id="acritico" name="critico" type="text" placeholder="2d4+|2*FOR|" maxlength="<?=$Arma_crit?>"
                                   class="form-control border-start-0 border-light bg-black text-white"/>
                            <input title="margem" name="margem" type="number" placeholder="19" min="0" max="20" maxlength="<?=$Arma_crit?>"
                                   class="form-control border-light bg-black text-white"/>
                        </div>
                        <div class="input-group input-group-sm mb-2">
                            <label for="arecarga"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Recarga:</label>
                            <input id="arecarga" name="recarga" type="text" maxlength="<?=$Arma_reca?>"
                                   class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                        <div class="input-group input-group-sm mb-2">
                            <label for="aespecial"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Especial:</label>
                            <input id="aespecial" name="especial" type="text" maxlength="<?=$Arma_espe?>"
                                   class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                    </div>
                    <div class="col-sm" id="addarmainv">
                        <h4 class="text-center">Inventario</h4>
                        <div class="input-group input-group-sm my-2">
                            <label for="adesc"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Detalhes/Descrição:</label>
                            <input id="adesc" name="desc" type="text" maxlength="<?=$Inv_desc?>"
                                   class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                        <div class="input-group input-group-sm mb-2">
                            <label for="apeso"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Peso/Espaço:</label>
                            <input id="apeso" name="peso" value="0" max="50" min="-50" type="number"
                                   class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                        <div class="input-group input-group-sm mb-2">
                            <label for="aprest"
                                   class="p-1 input-group-text border-light bg-black text-white border-end-0">Categoria:</label>
                            <input id="aprest" name="prestigio" value=0 max='50' min='-50' type="number"
                                   class="form-control border-start-0 border-light bg-black text-white"/>
                        </div>
                        <div class="m-2 form-check form-switch">
                            <input class="form-check-input" type="checkbox" checked role="switch" id="addarmainvswitch"
                                   name="lembrar">
                            <label class="form-check-label" for="addarmainvswitch">Adicionar Ao inventario</label>
                        </div>
                        <input type="hidden" name="opc" value="addinvtoo"/>
                    </div>
                </div>
                <input type="hidden" name="status" value="addarma"/>
                <div class="clearfix mx-5">
                    <button type="button" class="btn btn-secondary float-start" data-bs-dismiss="modal"
                            onclick="cleanedit()">Cancelar
                    </button>
                    <button type="submit" class="btn btn-success float-end">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>