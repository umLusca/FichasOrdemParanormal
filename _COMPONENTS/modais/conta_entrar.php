
<form class="modal fade" id="login" tabindex="-1" action="/api/conta/entrar" data-refresh="true" ajax>
    <div class="modal-dialog">
        <div class="modal-content border-success">
            <div class="modal-header">
                <h5 class="modal-title">Fazer Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="row m-2 g-2">
                    <div class="col-12">
                        <div class="return alert m-0    " style="display: none"></div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-floating">
                            <input class="form-control" name="login" type="text" placeholder="Email/User"/>
                            <label>Email/User</label>
                        </label>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-floating">
                            <input class="form-control" name="senha" type="password" placeholder="Senha"/>
                            <label>Senha</label>
                        </label>
                    </div>
            
                    <div class="col-6">
                        <button class="btn btn-sm btn-outline-info" type="button" data-bs-toggle="modal" data-bs-target="#passr">
                            Recuperar senha
                        </button>
                    </div>
                    <div class="col-6">
                        <label class="form-check form-switch form-check-reverse">
                            <input class="form-check-input" type="checkbox" role="switch" name="lembrar">
                            <span class="form-check-label user-select-none">Manter Ativo</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer footer">
                <button type="submit" class="btn btn-success w-100">Entrar</button>
            </div>
        </div>
    </div>
</form>