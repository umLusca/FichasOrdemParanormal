<?php
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $url = "https://";
else
    $url = "http://";
// Append the host(domain name, ip) to the URL.
$url .= $_SERVER['HTTP_HOST'];
?>
	<header class="font5" id="header">
		<div class="d-flex flex-wrap border-bottom border-light justify-content-between bg-black fixed-top">
			<div class="col d-none d-md-block">
				<a class="btn btn-sm fw-bolder text-light" href='/'>
					<i class="fa-regular fa-house-blank"></i></a><!--
            --><a class="btn btn-sm fw-bolder text-light" href='/creditos'>
					<i class="fa-regular fa-bars"></i> Créditos</a><!--
            --><a class="btn btn-sm fw-bolder text-light" href='https://jamboeditora.com.br/'>
					<i class="fa-regular fa-heart"></i> Jambo</a><!--
            --><a class="btn btn-sm fw-bolder text-white" data-bs-toggle="modal" data-bs-target="#doar">
					<i class="fa-regular fa-heart"></i> Doar</a>
			</div>
			<div class="col-auto dropdown d-md-none">
				<button title="Menu" class="btn btn-sm text-light" role="button" id="dropdownMenuLink"
						data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-bars"></i> Menu
				</button>
				<div class="dropdown-menu dropdown-menu-dark" title="Menu" aria-labelledby="dropdownMenuLink">
					<a class="dropdown-item text-light" href='/'><i class="fa-regular fa-house-blank"></i> Inicio</a>
					<a class="dropdown-item text-light" href='/creditos'><i class="fa-regular fa-bars"></i> Créditos</a>
					<a class="dropdown-item text-light" href='https://jamboeditora.com.br/'><i class="fa-regular fa-heart"></i> Jambo</a>
            		<a class="dropdown-item text-light" data-bs-toggle="modal" data-bs-target="#doar"><i class="fa-regular fa-heart"></i> Doar</a>
				</div>
			</div>

			<div class="col-auto d-none d-md-block">
                <?php if (isset($_SESSION["UserID"])) { ?>
					<a class="btn btn-sm fw-bolder text-warning" data-bs-toggle="modal" data-bs-target="#perfil"><i
								class="fa-regular fa-user"></i> Conta</a>
					<a class="btn btn-sm fw-bolder text-success" href='/sessao'><i class="fa-solid fa-dice-d10"></i>
						Sessões de RPG</a>
					<a class="btn btn-sm fw-bolder text-danger" href='/encerrar'><i
								class="fa-regular fa-user-xmark"></i> Encerrar Sessão</a>
                <?php } else { ?>
					<a class="btn btn-sm fw-bolder text-danger" data-bs-toggle="modal" data-bs-target="#cadastrar"><i
								class="fa-regular fa-user-plus"></i> Sou novo</a>
					<a class="btn btn-sm fw-bolder text-success" data-bs-toggle="modal" data-bs-target="#logar"><i
								class="fa-regular fa-user-check"></i> Entrar</a>
                <?php } ?>
				<a class="btn btn-sm fw-bolder text-light" href='https://discord.gg/gHaAxqC2Hw'><i
							class="fa-regular fa-circle-question"></i> Problemas?</a>
			</div>

			<div class="col-auto dropdown d-md-none">
				<button title="Menu" class="btn btn-sm text-light" role="button" id="dropdownMenuLink"
						data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-bars"></i> Painel
				</button>
				<div class="dropdown-menu dropdown-menu-dark" title="Menu" aria-labelledby="dropdownMenuLink">
					<a class="dropdown-item text-light" href='https://discord.gg/gHaAxqC2Hw'><i
								class="fa-regular fa-circle-question"></i> Problemas?</a>
                    <?php if (isset($_SESSION["UserID"])) { ?>
						<a class="dropdown-item fw-bolder text-warning" data-bs-toggle="modal" data-bs-target="#perfil"><i
									class="fa-regular fa-user"></i> Conta</a>
						<a class="dropdown-item fw-bolder text-success" href='/sessao'><i
									class="fa-solid fa-dice-d10"></i> Sessões de RPG</a>
						<a class="dropdown-item fw-bolder text-danger" href='/encerrar'><i
									class="fa-regular fa-user-xmark"></i> Encerrar Sessão</a>
                    <?php } else { ?>
						<a class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#cadastrar"><i
									class="fa-regular fa-user-plus"></i> Sou novo</a>
						<a class="dropdown-item text-success" data-bs-toggle="modal" data-bs-target="#logar"><i
									class="fa-regular fa-user-check"></i> Entrar</a>
                    <?php } ?>
				</div>
			</div>
		</div>
        <div class="w-100" style="height: 32px;"></div>
	</header>

	<div class="modal fade" id="doar" tabindex="-1" aria-labelledby="titledoar" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content bg-black text-white border-success">
				<div class="modal-body">
					<div class="modal-header border-0">
						<h5 class="modal-title" id="titledoar">Ajudar com doação</h5>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
								aria-label="Fechar"></button>
					</div>
					<div class="m-2 text-center">
						<h3>Quem Sou eu?</h3>
						<span>
                        Olá. O meu nome è Lucas. Tenho 17 anos e atualmente estou no 3º ano do ensino médio. O meu hobbie é programar e passo a maior parte do meu tempo atualizando o site.
                        Não recebo nenhuma remuneração do site, nem pretendo colocar propagandas, penso que vou criar sistema chamado membro elite, que terá funções extra, mas nem comecei.
                        Então... se quiser me dar uma força para manter este site online, a melhor forma de fazer isso é-me ajudando com doação.
                    </span>
					</div>
					<span>Não vou pedir nenhum valor, estará livre para doar qualquer quantia.</span>
					<div class="m-2 text-center">
						<h3>Meu Pix</h3>
						<p class="text-decoration-underline">d14f80f4-1567-4268-80d6-0abf7e572454</p>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
require_once RootDir . "conta/conta.php";
?>