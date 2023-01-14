<div class="col" id="card_dadosjogados">
    <div class="card border-secondary h-100 overflow-auto" style="min-height: 360px;">
        <div class="card-header text-center">
            <h3 class="m-0 font6">Ultimos testes.</h3>
        </div>
        <div class="card-body p-0 h-auto">
            <div class="container-fluid p-0 position-absolute">
                <div class="d-flex flex-column" id="dados_recentes">
					<?php


					foreach ($q["dados_player"] as $dados) {
						
						$dado = json_decode($dados["dados"], true);
                        ?>
                        <div class="row m-1">
                            <div class="col-auto text-center align-self-center">
                                <img alt="Foto perfil" src="<?= $dado["foto"] ?>" height="50" width="50" class="rounded-circle border border-1 border-secondary">
                                <div class="text-truncate font7"><?= $dado["nome"] ?></div>
                            </div>
                            <div class="col">
                                <h6><?=$dado["dado"]["nome"]?></h6>
                                <span class="text-muted fw-lighter small">
                                    <?php
                                    echo "<h5>{$dado["dado"]["print"]}={$dado["dado"]["resultado"]}</h5>";
                                    foreach ($dado["dado"]["dados"] as $roll) {
	                                    echo strtoupper($roll["dado"]) . ": ";
	                                    foreach ($roll["resultados"] as $i => $resultado) {
                                            if(!$dado["dado"]["dano"] && ($roll["dado"] === "d20") && ((int)$resultado >= $dado["dado"]["margem"])) {
                                                echo "<span class='fw-bold text-danger'>$resultado</span>";
                                            } else {
                                                echo $resultado;
                                            }
                                            if($i !== count($roll["resultados"])-1){
                                                echo ", ";
                                            }
	                                    }
                                    }
                                    ?>
                                </span>
                        
                            </div>
                        </div>
                        <hr>
						<?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>