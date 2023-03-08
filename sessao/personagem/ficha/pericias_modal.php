<form class="modal fade" id="editper" tabindex="-1">
    <div class="modal-dialog modal-fullscreen-lg-down modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <span class="fs-4 modal-title">Editar Pericias</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body font1">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
					<?php
					function input_per($label,$value,$name){
						return '<div class="col">
                                <label class="form-floating m-1">
                                    <input class="form-control" type="number" min="0" max="99" value="'.$value.'" name="'.$name.'"/>
                                    <label>'.$label.'</label>
                                </label>
                             </div>';
					}
					?>
					<?=input_per("Acrobacias",$acrobacias,"acrobacias")?>
					<?=input_per("Adestramento",$adestramento,"adestramento")?>
					<?=input_per("Artes",$artes,"artes")?>
					<?=input_per("Atletismo",$atletismo,"atletismo")?>
					<?=input_per("Atualidades",$atualidades,"atualidades")?>
					<?=input_per("Ciência",$ciencia,"ciencia")?>
					<?=input_per("Crime",$crime,"crime")?>
					<?=input_per("Diplomacia",$diplomacia,"diplomacia")?>
					<?=input_per("Enganação",$enganacao,"enganacao")?>
					<?=input_per("Fortitude",$fortitude,"fortitude")?>
					<?=input_per("Furtividade",$furtividade,"furtividade")?>
					<?=input_per("Iniciativa",$iniciativa,"iniciativa")?>
					<?=input_per("Intimidação",$intimidacao,"intimidacao")?>
					<?=input_per("Intuição",$intuicao,"intuicao")?>
					<?=input_per("Investigação",$investigacao,"investigacao")?>
					<?=input_per("Luta",$luta,"luta")?>
					<?=input_per("Medicina",$medicina,"medicina")?>
					<?=input_per("Ocultismo",$ocultismo,"ocultismo")?>
					<?=input_per("Percepção",$percepcao,"percepcao")?>
					<?=input_per("Pilotagem",$pilotagem,"pilotagem")?>
					<?=input_per("Pontaria",$pontaria,"pontaria")?>
					<?=input_per("Profissão",$profissao,"profissao")?>
					<?=input_per("Reflexos",$reflexos,"reflexo")?>
					<?=input_per("Religião",$religiao,"religiao")?>
					<?=input_per("Sobrevivência",$sobrevivencia,"sobrevivencia")?>
					<?=input_per("Tática",$tatica,"tatica")?>
					<?=input_per("Tecnologia",$tecnologia,"tecnologia")?>
					<?=input_per("Vontade",$vontade,"vontade")?>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="query" value="ficha_update_pericias"/>
                <button type="submit" class="btn btn-success w-100">Salvar</button>
            </div>
        </div>
    </div>
</form>
