
<form class="modal fade" id="passr" tabindex="-1" method="post">
    <div class="modal-dialog">
        <div class="modal-content border-success">
            <div class="modal-header">
                <h5 class="modal-title">Recuperar senha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="m-2 return"></div>
                <div class="m-2">
                    <label class="form-floating">
                        <input class="form-control" name="email" type="text" placeholder="Email"/>
                        <label>Email</label>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <input class="form-control" name="query" type="hidden" value="conta_recuperar"/>
                <button type="submit" class="btn btn-success w-100">Recuperar</button>
            </div>
        </div>
    </div>
</form>
