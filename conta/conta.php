<?php if (!isset($_SESSION["UserID"])) {?>
    <div class="modal fade" id="logar" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content bg-black text-white border-success">
                <form class="modal-body" id="login" method="post">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="exampleModalLabel">Fazer Login</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div id="messagelogin"></div>
                    <div class="row">
                        <div class="col-md input-group my-1">
                            <label class="input-group-text bg-black text-white border-light border-end-0" for="llogin">Username:</label>
                            <input class="form-control bg-black text-white border-light border-start-0" id="llogin" name="login" type="text"/>
                        </div>
                        <div class="col-md input-group my-1">
                            <label class="input-group-text bg-black text-white border-light border-end-0" for="lsenha">Senha:</label>
                            <input class="form-control bg-black text-white border-light border-start-0" id="lsenha" name="senha" type="password"/>
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="form-check form-switch col-6">
                            <input class="form-check-input" type="checkbox" role="switch" id="lembrardemim" name="lembrar">
                            <label class="form-check-label" for="lembrardemim">Manter Ativo</label>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-sm btn-outline-info float-end" type="button" data-bs-toggle="modal" data-bs-target="#passr">Recuperar senha</button>
                        </div>
                    </div>
                    <div class="modal-footer border-0 justify-content-between" id="footerlogin">
                        <input type="hidden" name="logar" value="1">
                        <button type="submit" class="btn btn-success">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="passr" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content bg-black text-white border-success">
                <form class="modal-body" id="passrf" method="post">
                    <div class="modal-header border-0">
                        <h5 class="modal-title">Recuperar senha</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div id="passrmsg"></div>
                    <div class="row">
                        <div class="col-md input-group my-1">
                            <label class="input-group-text bg-black text-white border-light border-end-0" for="remail">Email:</label>
                            <input class="form-control bg-black text-white border-light border-start-0" id="remail" name="email" type="text"/>
                        </div>
                    </div>
                    <div class="modal-footer border-0" id="footerpassr">
                        <input type="hidden" name="update" value="recuperar">
                        <button type="submit" class="btn btn-success">Recuperar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="cadastrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-black text-white border-success">
                <form class="modal-body" id="cadastro" method="post">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="exampleModalLabel">Criar uma conta</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Fechar"></button>
                    </div>
                    <div id="messagecadastro"></div>
                    <div class="row">
                        <div class="col-md input-group m-1">
                            <label class="input-group-text bg-black text-white border-light border-end-0" for="cnome">Nome:</label>
                            <input class="form-control bg-black text-white border-light border-start-0" id="cnome" name="nome" type="text"/>
                        </div>
                        <div class="col-md input-group m-1">
                            <label class="input-group-text bg-black text-white border-light border-end-0" for="clogin">Username:</label>
                            <input class="form-control bg-black text-white border-light border-start-0" id="clogin"
                                   name="login" type="text"/>
                        </div>
                        <?php if (isset($_GET["email"])) { ?>
                            <div class="col-md input-group m-1">
                                <label class="input-group-text bg-black text-white border-light border-end-0"
                                       for="cemail">Email:</label>
                                <input class="form-control bg-black text-white border-light border-start-0" disabled
                                       id="cemail" type="email" value="<?php echo ($_GET["email"]) ?: ''; ?>"/>
                            </div>

                            <input name="email" type="hidden" value="<?php echo ($_GET["email"]) ?: ''; ?>"/>
                        <?php } else { ?>
                            <div class="col-md input-group m-1">
                                <label class="input-group-text bg-black text-white border-light border-end-0"
                                       for="cemail">Email:</label>
                                <input class="form-control bg-black text-white border-light border-start-0" id="cemail"
                                       name="email" type="email"/>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="row">
                        <div class="col-md input-group m-1">
                            <label class="input-group-text bg-black text-white border-light border-end-0" for="csenha">Senha:</label>
                            <input class="form-control bg-black text-white border-light border-start-0" id="csenha"
                                   name="senha" type="password"/>
                        </div>
                        <div class="col-md input-group m-1">
                            <label class="input-group-text bg-black text-white border-light border-end-0" for="ccsenha">Repetir
                                senha:</label>
                            <input class="form-control bg-black text-white border-light border-start-0" id="ccsenha"
                                   name="csenha" type="password"/>
                        </div>
                    </div>
                    <div class="modal-footer border-0" id="footercadastro">
                        <input type="hidden" name="cadastrar" value="1">
                        <button type="submit" class="btn btn-success">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php }
 if (isset($_SESSION["UserID"])){ ?>
    <div class="modal fade" id="perfil" tabindex="-1" aria-label="Perfil Modal" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-black text-white border-success">
                <div class="clearfix card-header m-2">
                    <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <h1 class="text-center my-3">Perfil</h1>
                <div class="p-4 text-center" id="alertboxperfil"></div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <div class="card bg-black text-white border-light m-3">
                                <div class="card-header text-center text-warning">
                                    <h3>Editar informações da conta</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid">
                                        <button class="btn btn-sm btn-outline-light my-2 d-grid" data-bs-toggle="modal"
                                                data-bs-target="#trocarlogin">Trocar UserName
                                        </button>
                                        <button class="btn btn-sm btn-outline-light my-2 d-grid" data-bs-toggle="modal"
                                                data-bs-target="#trocaremail">Trocar Email
                                        </button>
                                        <button class="btn btn-sm btn-outline-light my-2 d-grid" data-bs-toggle="modal"
                                                data-bs-target="#trocarsenha">Trocar Senha
                                        </button>
                                        <button class="btn btn-sm btn-outline-light my-2 d-grid" data-bs-toggle="modal"
                                                data-bs-target="#trocarnome">Trocar Nome
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card bg-black text-white border-light m-3">
                                <div class="card-header text-center text-success">
                                    <h3>Missões e fichas</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid" id="addfotomarca">
                                        <div class="return"></div>
                                        <div class="input-group p-3">
                                            <label for="addmarca" class="input-group-text bg-black text-white border-end-0">Sua marca</label>
                                            <input id="addmarca" name="marca" value="<?=$_SESSION["UserMarca"]?>" type="url" class="form-control bg-black text-white border-start-0" required/>
                                            <button id="btnaddmarca" class="btn btn-outline-light"><i class="fa fa-regular fa-send"></i></button>
                                        </div>
                                        <div class="warning"></div>
                                            <div class="preview d-flex justify-content-center"></div>
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

    <!------------------------------------------------------------------------------------------------------------------->
    <div id="updateforms">
        <div class="modal fade" id="trocarlogin" tabindex="-1" aria-label="Trocar login - Modal">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content bg-black text-white border-success">
                    <div class="clearfix card-header">
                        <button type="button" class="btn float-start text-warning" data-bs-toggle="modal"
                                data-bs-target="#perfil"><i class="fa-solid fa-left"></i> Voltar
                        </button>
                        <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <form class="modal-body text-center" novalidate autocomplete="off">
                        <h3 class="text-center">Trocar Username</h3>
                        <div class="input-group p-3">
                            <input class="form-control bg-black text-white" readonly
                                   value='Login Atual: <?= $_SESSION["UserLogin"] ?>' aria-label="Login Antigo."/>
                        </div>
                        <div class="input-group p-3">
                            <label for="newlogin" class="input-group-text bg-black text-white border-end-0">Username
                                novo:</label>
                            <input id="newlogin" name="login" class="form-control bg-black text-white border-start-0"
                                   required/>
                        </div>
                        <ul>
                            <li>Letras maiusculas e minusculas não farão diferença no username.</li>
                            <li>Só pode ter letras, pontos, e numeros no username.</li>
                        </ul>
                        <input type="hidden" name="update" value="login">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-success text-center">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="trocaremail" tabindex="-1" aria-label="Trocar Email - Modal">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content bg-black text-white border-success">
                    <div class="clearfix card-header">
                        <button type="button" class="btn float-start text-warning" data-bs-toggle="modal"
                                data-bs-target="#perfil"><i class="fa-solid fa-left"></i> Voltar
                        </button>
                        <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <form class="modal-body text-center" novalidate>
                        <h3 class="text-center">Trocar Email</h3>
                        <div class="input-group p-3">
                            <input class="form-control bg-black text-white" disabled
                                   value='Email Atual: <?= $_SESSION["UserEmail"] ?>' aria-label="Nome label antiga"/>
                        </div>
                        <div class="input-group p-3">
                            <label for="newemail" class="input-group-text bg-black text-white border-end-0">Email
                                novo:</label>
                            <input id="newemail" name="email" class="form-control bg-black text-white border-start-0"/>
                        </div>
                        <div class="input-group p-3">
                            <label for="connewemail" class="input-group-text bg-black text-white border-end-0">Repetir
                                email:</label>
                            <input id="connewemail" name="conemail"
                                   class="form-control bg-black text-white border-start-0"/>
                        </div>
                        <ul>
                            <!--<li>Como existe a hipótese do novo email já ter sido chamado para uma missão, agora é necessário confirmar email</li>-->
                            <li>Não é possivel, ainda, alterar email para um que foi chamado para a missão, em breve
                                resolveremos isso.
                            </li>
                        </ul>
                        <input type="hidden" name="update" value="email">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-success text-center">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="trocarsenha" tabindex="-1" aria-label="Trocar senha Modal">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content bg-black text-white border-success">
                    <div class="clearfix card-header">
                        <button type="button" class="btn float-start text-warning" data-bs-toggle="modal"
                                data-bs-target="#perfil"><i class="fa-solid fa-left"></i> Voltar
                        </button>
                        <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <form class="modal-body text-center" novalidate>
                        <h3 class="text-center">Trocar Senha</h3>
                        <div class="input-group p-3">
                            <label for="newpass" class="input-group-text bg-black text-white border-end-0">Nova
                                Senha</label>
                            <input id="newpass" name="pass" class="form-control bg-black text-white border-start-0"/>
                        </div>
                        <div class="input-group p-3">
                            <label for="connewpass" class="input-group-text bg-black text-white border-end-0">Repetir
                                Senha</label>
                            <input id="connewpass" name="conpass"
                                   class="form-control bg-black text-white border-start-0"/>
                        </div>
                        <span>Para nova senha é necessário alguns requisitos:</span>
                        <ul>
                            <li>Precisa ter pelomenos 1 letra maiuscula.</li>
                            <li>Precisa ter pelomenos 1 letra minusculas.</li>
                            <li>Precisa ter pelomenos um número na senha.</li>
                            <li>Precisa ter no mínimo de 8 caracteres.</li>
                        </ul>
                        <input type="hidden" name="update" value="senha">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-success text-center">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="trocarnome" tabindex="-1" aria-label="Trocar Nome - Modal">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content bg-black text-white border-success">
                    <div class="clearfix card-header">
                        <button type="button" class="btn float-start text-warning" data-bs-toggle="modal"
                                data-bs-target="#perfil"><i class="fa-solid fa-left"></i> Voltar
                        </button>
                        <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <h3 class="text-center">Trocar Nome</h3>
                    <form class="modal-body text-center" novalidate>
                        <h3 class="text-center">Trocar username</h3>
                        <div class="input-group p-3">
                            <input class="form-control bg-black text-white" disabled
                                   value='Nome da conta Atualmente: <?= $_SESSION["UserName"] ?>'
                                   aria-label="Nome label antiga"/>
                        </div>
                        <div class="input-group p-3">
                            <label for="newname" class="input-group-text bg-black text-white border-end-0">Novo
                                nome:</label>
                            <input id="newname" name="nome" class="form-control bg-black text-white border-start-0"
                                   required/>
                        </div>
                        <ul>
                            <li>Somente letras e espaços</li>
                            <li>Ideal é ter apenas nome e sobrenome</li>
                            <li>Nome sempre começa com letra maiuscula. ;)</li>
                        </ul>
                        <input type="hidden" name="update" value="nome">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-success text-center">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!------------------------------------------------------------------------------------------------------------------->
<?php }?>