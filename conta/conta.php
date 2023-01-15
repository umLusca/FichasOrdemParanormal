<?php if (!isset($_SESSION["UserID"])) { ?>
    <form class="modal fade" id="login" tabindex="-1" ajax>
        <div class="modal-dialog">
            <div class="modal-content border-success">
                <div class="modal-header">
                    <h5 class="modal-title">Fazer Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="m-2 return"></div>
                    <div class="row m-2">
                        <div class="col">
                            <label class="form-floating">
                                <input class="form-control" name="login" type="text" placeholder="Email/User"/>
                                <label>Email/User</label>
                            </label>
                        </div>
                        <div class="col">
                            <label class="form-floating">
                                <input class="form-control" name="senha" type="password" placeholder="Senha"/>
                                <label>Senha</label>
                            </label>
                        </div>
                    </div>
                    <div class="row m-2">
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
                    <button type="submit" class="btn btn-success w-100">Recuperar</button>
                </div>
            </div>
        </div>
    </form>
    <form class="modal fade" id="cadastrar" tabindex="-1" aria-hidden="true" method="post">
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

<?php }
if (isset($_SESSION["UserID"])) { ?>
    <div class="modal fade" id="perfil" tabindex="-1" aria-label="Perfil Modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content border-secondary">
                <div class="modal-header">
                    <h1 class="fs-5 modal-title">Dados da Conta</h1>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" title="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="row row-cols-2 row-cols-md-2 g-2 m-3">
                        <div class="col">
                            <div class="card border-secondary h-100">
                                <div class="card-header">
                                    <h1 class="fs-4 card-title">Editar informações da conta</h1>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid top-100 position-sticky m-2">
                                        <button class="btn btn-lg btn-outline-warning d-grid" type="button" data-bs-toggle="modal" data-bs-target="#configconta">
                                            Alterar informações da conta
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card border-secondary h-100">
                                <div class="card-header">
                                    <h1 class="fs-4 card-title">Missões e Fichas</h1>
                                </div>
                                <div class="card-body" id="addmarcadiv">
                                    <div class="return"></div>
                                    <div class="m-2">
                                        <div class="input-group">
                                            <label class="form-floating border-secondary">
                                                <input placeholder="URL da MARCA" value="<?= $_SESSION["UserMarca"] ?>" type="url" class="form-control"/>
                                                <label>URL da marca</label>
                                            </label>
                                            <button class="btn btn-outline-secondary border-secondary-subtle submit" type="button">
                                                <i class="fal fa-send"></i>
                                            </button>
                                        </div>
                                        <div class="preview d-flex justify-content-center">
                                            <img src="<?= $_SESSION["UserMarca"] ?>" style="width: 50%;  max-width: 200px;" alt="Marca">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!------------------------------------------------------------------------------------------------------------------->
    <div id="updateforms">
        <form class="modal fade" id="configconta" novalidate tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content border-success">
                    <div class="modal-header">
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#perfil">
                            <i class="fat fa-left"></i> Voltar
                        </button>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center m-2">
                            <h3>Alterar informações da conta</h3>
                        </div>
                        <div class="row g-4 row-cols-1 row-cols-md-2 m-2">
                            <div class="col">
                                <div class="card border-secondary">
                                    <div class="card-header">
                                        <span class="fs-4 card-title">Alterar Username</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="m-2">
                                            <label class="form-floating w-100">
                                                <input type="text" class="form-control" value="<?= $_SESSION["UserLogin"] ?>" disabled placeholder="Username Atual">
                                                <label>Username atual</label>
                                            </label>
                                        </div>
                                        <div class="m-2">
                                            <label class="form-floating w-100">
                                                <input type="text" class="form-control" minlength="3" maxlength="16" name="username" placeholder="Novo username">
                                                <span class="invalid-feedback">O username só pode conter letras, números e "_"</span>
                                                <label>Novo username</label>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card border-secondary">
                                    <div class="card-header">
                                        <span class="fs-4 card-title">Alterar nome</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="m-2">
                                            <label class="form-floating w-100">
                                                <input type="text" class="form-control" value="<?= $_SESSION["UserName"] ?>" disabled placeholder="Nome Atual">
                                                <label>Nome atual</label>
                                            </label>
                                        </div>
                                        <div class="m-2">
                                            <label class="form-floating w-100">
                                                <input type="text" class="form-control" minlength="2" name="nome" placeholder="Alterar Nome">
                                                <span class="invalid-feedback">O nome só pode conter letras e espaços (2-)</span>
                                                <label>Novo nome</label>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card border-secondary">
                                    <div class="card-header">
                                        <span class="fs-4 card-title">Alterar E-mail</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="m-2">
                                            <label class="form-floating w-100">
                                                <input class="form-control" value="<?= $_SESSION["UserEmail"] ?>" disabled placeholder="E-mail Atual">
                                                <label>E-mail atual</label>
                                            </label>
                                        </div>
                                        <div class="m-2">
                                            <label class="form-floating w-100">
                                                <input type="email" class="form-control" minlength="5" maxlength="100" name="email" placeholder="Novo username">
                                               <label>Novo E-mail</label>
                                                <span class="invalid-feedback">Preencha o e-mail corretamente.</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card border-secondary">
                                    <div class="card-header">
                                        <span class="fs-4 card-title">Alterar Senha</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="m-2">
                                            <label class="form-floating w-100">
                                                <input type="password" class="form-control senha" minlength="8" maxlength="50" name="nsenha" placeholder="nova senha">
                                                <div class="invalid-feedback">Preencha sua senha conforme os requisitos:<br>
                                                    <ul>
                                                        <li>Entre 8 e 50 Caracteres</li>
                                                        <li>Precisa de ao menos 1 Número</li>
                                                        <li>Precisa de ao menos 1 letra minúscula</li>
                                                        <li>Precisa de ao menos 1 letra maiúscula</li>
                                                    </ul>
                                                </div>
                                                <label>Senha nova</label>
                                            </label>
                                        </div>
                                        <div class="m-2">
                                            <label class="form-floating w-100">
                                                <input type="password" class="form-control csenha" minlength="8" maxlength="50" name="csenha" placeholder="Repetir nova senha">
                                                <span class="invalid-feedback">As senhas não coincidem</span>
                                                <label>Confirme a senha nova</label>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-1 m-3">
                            <div class="card border-secondary">
                                <div class="card-header">
                                    <span class="fs-4 card-title">Senha atual</span>
                                </div>
                                <div class="card-body">
                                    <div class="m-2">
                                        <label class="form-floating w-100">
                                            <input type="password" class="form-control" minlength="8" maxlength="50" name="asenha" placeholder="senha atual" required>
                                            <span class="invalid-feedback">Preencha com sua senha atual. (8-50 caracteres)</span>
                                            <label>Senha atual</label>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="warning m-2"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-success w-100">Atualizar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!------------------------------------------------------------------------------------------------------------------->
<?php } ?>