<?php if (!isset($_SESSION["UserID"])) { ?>
	<div class="modal fade" id="logar" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content bg-black text-white border-success">
				<form class="modal-body" id="login" method="post">
					<div class="modal-header border-0">
						<h5 class="modal-title" id="exampleModalLabel">Fazer Login</h5>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
								aria-label="Fechar"></button>
					</div>
					<div id="messagelogin"></div>
					<div class="row">
						<div class="col-md input-group my-1">
							<label class="input-group-text bg-black text-white border-light border-end-0" for="llogin">Email/User:</label>
							<input class="form-control bg-black text-white border-light border-start-0" id="llogin"
								   name="login" type="text"/>
						</div>
						<div class="col-md input-group my-1">
							<label class="input-group-text bg-black text-white border-light border-end-0" for="lsenha">Senha:</label>
							<input class="form-control bg-black text-white border-light border-start-0" id="lsenha"
								   name="senha" type="password"/>
						</div>
					</div>
					<div class="row mx-2">
						<div class="form-check form-switch col-6">
							<input class="form-check-input" type="checkbox" role="switch" id="lembrardemim"
								   name="lembrar">
							<label class="form-check-label" for="lembrardemim">Manter Ativo</label>
						</div>
						<div class="col-6">
							<button class="btn btn-sm btn-outline-info float-end" type="button" data-bs-toggle="modal"
									data-bs-target="#passr">Recuperar senha
							</button>
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
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
								aria-label="Fechar"></button>
					</div>
					<div id="passrmsg"></div>
					<div class="row">
						<div class="col-md input-group my-1">
							<label class="input-group-text bg-black text-white border-light border-end-0" for="remail">Email:</label>
							<input class="form-control bg-black text-white border-light border-start-0" id="remail"
								   name="email" type="text"/>
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
							<input class="form-control bg-black text-white border-light border-start-0" id="cnome"
								   name="nome" type="text"/>
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
if (isset($_SESSION["UserID"])) { ?>
	<div class="modal fade" id="perfil" tabindex="-1" aria-label="Perfil Modal" aria-hidden="true">
		<div class="modal-dialog modal-fullscreen">
			<div class="modal-content bg-black text-white border-success">
				<div class="clearfix card-header m-2">
					<button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="modal"
							aria-label="Close"></button>
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
										<button class="btn btn-sm btn-outline-light my-2 d-grid" data-bs-toggle="modal" data-bs-target="#configconta">
											Alterar informações da conta
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
											<label for="addmarca" class="input-group-text bg-black text-white border-end-0">Sua
												marca</label>
											<input id="addmarca" name="marca" value="<?= $_SESSION["UserMarca"] ?>" type="url" class="form-control bg-black text-white border-start-0"/>
											<button id="btnaddmarca" class="btn btn-outline-light">
												<i class="fa fa-regular fa-send"></i></button>
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
		<form class="modal fade" id="configconta" novalidate tabindex="-1">
			<div class="modal-dialog modal-fullscreen">
				<div class="modal-content bg-black text-white border-success">
					<div class="modal-header">
						<button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#perfil">
							<i class="fat fa-left"></i> Voltar
						</button>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="text-center m-2">
							<h3>Alterar informações da conta</h3>
						</div>
						<div class="row g-4 row-cols-1 row-cols-md-2 m-2">
							<div class="col">
								<div class="card bg-black text-white border-light">
									<div class="card-header">
										<span class="fs-4 card-title">Alterar Username</span>
									</div>
									<div class="card-body">
										<div class="m-2">
											<label class="form-floating w-100">
												<input type="text" class="form-control bg-transparent text-light" value="<?= $_SESSION["UserLogin"] ?>" disabled placeholder="Username Atual">
												<label>Username atual</label>
											</label>
										</div>
										<div class="m-2">
											<label class="form-floating w-100">
												<input type="text" class="form-control bg-transparent text-light" minlength="3" maxlength="16" name="username" placeholder="Novo username">
												<span class="invalid-feedback">O username só pode conter letras, números e "_"</span>
												<label>Novo username</label>
											</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col">
								<div class="card bg-black text-white border-light">
									<div class="card-header">
										<span class="fs-4 card-title">Alterar nome</span>
									</div>
									<div class="card-body">
										<div class="m-2">
											<label class="form-floating w-100">
												<input type="text" class="form-control bg-transparent text-light" value="<?= $_SESSION["UserName"] ?>" disabled placeholder="Nome Atual">
												<label>Nome atual</label>
											</label>
										</div>
										<div class="m-2">
											<label class="form-floating w-100">
												<input type="text" class="form-control bg-transparent text-light" minlength="2" name="nome" placeholder="Alterar Nome">
												<span class="invalid-feedback">O nome só pode conter letras e espaços (2-)</span>
												<label>Novo nome</label>
											</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col">
								<div class="card bg-black text-white border-light">
									<div class="card-header">
										<span class="fs-4 card-title">Alterar E-mail</span>
									</div>
									<div class="card-body">
										<div class="m-2">
											<label class="form-floating w-100">
												<input class="form-control bg-transparent text-light" value="<?= $_SESSION["UserEmail"] ?>" disabled placeholder="E-mail Atual">
												<label>E-mail atual</label>
											</label>
										</div>
										<div class="m-2">
											<label class="form-floating w-100">
												<input type="email" class="form-control bg-transparent text-light" minlength="5" maxlength="100" name="email" placeholder="Novo username">
												<span class="invalid-feedback">Preencha o e-mail corretamente.</span>
												<label>Novo E-mail</label>
											</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col">
								<div class="card bg-black text-white border-light">
									<div class="card-header">
										<span class="fs-4 card-title">Alterar Senha</span>
									</div>
									<div class="card-body">
										<div class="m-2">
											<label class="form-floating w-100">
												<input type="password" class="form-control bg-transparent text-light senha" minlength="8" maxlength="50" name="nsenha" placeholder="nova senha">
												<div class="invalid-feedback">Preencha sua senha de acordo com os
													requisitos:<br>
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
												<input type="password" class="form-control bg-transparent text-light csenha" minlength="8" maxlength="50" name="csenha" placeholder="Repetir nova senha">
												<span class="invalid-feedback">As senhas não coincidem</span>
												<label>Confirme a senha nova</label>
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="p-1 m-3">
							<div class="card bg-black text-white border-light">
								<div class="card-header">
									<span class="fs-4 card-title">Senha atual</span>
								</div>
								<div class="card-body">
									<div class="m-2">
										<label class="form-floating w-100">
											<input type="password" class="form-control bg-transparent text-light" minlength="8" maxlength="50" name="asenha" placeholder="senha atual" required>
											<span class="invalid-feedback">Preencha com sua senha atual. (8-50 caracteres)</span>
											<label>Senha atual</label>
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="warning m-2"></div>
					</div>
					<div class="modal-footer justify-content-center">
						<button type="submit" class="btn btn-outline-success" onclick="update_conta()">Atualizar
						</button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<!------------------------------------------------------------------------------------------------------------------->
<?php } ?>