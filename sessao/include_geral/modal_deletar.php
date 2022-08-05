<div class="modal fade" id="deletar" data-bs-keyboard="false" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content bg-black border-light">
			<form class="modal-body" method="post" id="formdeletar">
				<div class="border-0 modal-header fs-4"><span>Deseja Deletar:</span> <span id="deletarnome"></span></div>
				<input type="hidden" id="deletarid" name="did" value=""/>
				<input type="hidden" id="deletarstatus" name="status" value=""/>
				<div class="clearfix">
					<button type="button" class="btn btn-secondary float-start" data-bs-dismiss="modal" onclick="cleanedit();">Cancelar</button>
					<button type="submit" class="btn btn-danger float-end" data-bs-dismiss="modal">DELETAR!</button>
				</div>
			</form>
		</div>
	</div>
</div>
