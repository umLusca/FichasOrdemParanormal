
<form class="modal fade" id="cadastrar" data-refresh="true" tabindex="-1" aria-hidden="true" method="post">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-success">
            <div class="modal-header">
                <h5 class="modal-title">Criar uma conta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="m-2 return"></div>
                <div class="m-2 row g-2">
                    <div class="col-12 col-sm-6">
                        <label class="form-floating">
                            <input class="form-control" name="nome" type="text" placeholder="Nome" maxlength="50" minlength="2"/>
                            <label>Nome</label>
                        </label>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-floating">
                            <input class="form-control" name="login" type="text" placeholder="Login/username" maxlength="16" minlength="2"/>
                            <label>Username</label>
                        </label>
                    </div>
                    <div class="col-12">
                        <label class="form-floating">
                            <input class="form-control" name="email" type="email" placeholder="Email da conta" maxlength="200" <?= !empty($_GET["email"]) ? "readonly value='{$_GET["email"]}'" : "" ?>/>
                            <label>Email</label>
                        </label>
                    </div>

                    <div class="col-12 col-sm-6">
                        <label class="form-floating">
                            <input class="form-control" name="senha" type="password" placeholder="Sua senha"/>
                            <label>Senha</label>
                        </label>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-floating">
                            <input class="form-control" name="csenha" type="password" placeholder="Repetir senha"/>
                            <label>Repetir senha</label>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success w-100">Cadastrar</button>
            </div>
        </div>
    </div>
</form>