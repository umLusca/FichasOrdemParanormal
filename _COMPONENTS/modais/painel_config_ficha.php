
<form class="modal" id="configplayer" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content border-secondary">
			<div class="modal-header text-center">
				<h4 class="modal-title">Configurações da ficha</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"
				        aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="form-check form-switch">
					<input class="form-check-input" type="checkbox" name="view" value="1" role="switch"
					       id="visivel">
					<label class="form-check-label" for="visivel">Tornar ficha vísivel para todo mundo</label>
				</div>
				<input type="hidden" name="status" value="player">
				<input type="hidden" id="inputidficha" name="token" value="">
			
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-danger" id="deletficha" onclick="deleteficha()"><i
						class="fa-regular fa-trash"></i></button>
				<button type="submit" class="btn btn-sm btn-primary ms-auto"><i class="far fa-floppy-disk"></i>
					Salvar
				</button>
			</div>
		</div>
	</div>
</form>
