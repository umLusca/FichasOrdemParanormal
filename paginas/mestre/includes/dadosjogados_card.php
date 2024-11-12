<div class="col-12 <?=isset($_GET["popout"])?:"col-md-6"?>" id="card_dadosjogados">
    <div class="card border-secondary h-100" style="min-height: 360px;">
        <div class="card-header d-flex">
            <h4 class="m-0">Ultimos testes</h4>
	        <?php if (!isset($_GET["popout"])) { ?>
                <button class="btn text-secondary fa-lg mx-1 p-1 popout" data-fop-pop="testes" style="height: 30px; width: 30px;">
                    <i class="fal fa-rectangle-vertical-history"></i>
                </button>
	        <?php } ?>
        </div>
        <div class="card-body p-0">
            <div class="position-relative h-100 overflow-auto">
                <div class="d-flex flex-column position-absolute h-100 w-100" id="dados_recentes">
		            <?php
		            foreach ($q["dados_player"] as $dados) {
                        $dado = json_decode($dados["dados"], true);
			            ?>
                        <div class="d-flex m-1">
                            <div class="text-center align-self-center p-1 px-3">
                                <img alt="Foto perfil" src="<?= $dado["foto"] ?>" height="50" width="50" class="rounded-circle border border-1 border-secondary">
                                <h6 class="text-truncate font7"><?= $dado["nome"] ?></h6>
                                <small><?=TempoDecorrido(strtotime($dados["data"]))?></small>
                            </div>
                            <div class="p-1 px-3">
                                <h6><?= $dado["dado"]["nome"] ?></h6>
                                    <?php
                                    echo "<h5>{$dado["dado"]["print"]}={$dado["dado"]["resultado"]}</h5>";
                                    foreach ($dado["dado"]["dados"] as $roll) {
	                                    echo strtoupper($roll["dado"]) . ": ";
	                                    foreach ($roll["resultados"] as $i => $resultado) {
		                                    if (!$dado["dado"]["dano"] && ($roll["dado"] === "d20") && ((int)$resultado >= $dado["dado"]["margem"])) {
			                                    echo "<span class='fw-bold text-danger'>$resultado</span>";
		                                    } else {
			                                    echo $resultado;
		                                    }
		                                    if ($i !== count($roll["resultados"]) - 1) {
			                                    echo ", ";
		                                    }
	                                    }
                                        echo "<br/>";
                                    }
                                    ?>
                            </div>
                        </div>
                        <hr>
		            <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>