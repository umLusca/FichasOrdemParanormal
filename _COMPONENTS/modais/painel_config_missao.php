<form class="modal" id="configmissao" tabindex="-1" novalidate method="post">
	<div class="modal-dialog">
		<div class="modal-content border-secondary">
			<div class="modal-header">
				<h3 class="modal-title">Configurações da missão</h3>
				<button type="button" class="btn-close" data-bs-dismiss="modal"
				        aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="return m-2"></div>
				<div class="m-2">
					<label class="form-floating w-100 ">
						<input name="title" type="text" class="form-control title"
						       placeholder="titulo missão">
						<label>Título</label>
					</label>
				</div>
				<div class="m-2">
					<label class="form-floating w-100">
                                <textarea name="desc" style="min-height: 200px" rows="7"
                                          class="form-control desc"
                                          placeholder="descrição missão"></textarea>
						<label>Descrição da missão</label>
					</label>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-danger me-auto" id="deletmissao" onclick="deletemissao()">
					<i class="fa-regular fa-trash"></i> Deletar Missão Permanentemente!
				</button>
				<button type="submit" class="btn btn-primary">Salvar Configurações</button>
				<input type="hidden" name="status" value="editmis">
				<input type="hidden" id="inputidmissao" name="id" value="">
			</div>
		</div>
	</div>
</form>