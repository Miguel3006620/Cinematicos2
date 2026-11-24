<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Cinematicos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Aplica o tema do sistema antes da página aparecer (evita piscar) -->
    <script>
        (function () {
            var mq = window.matchMedia('(prefers-color-scheme: dark)');
            function aplicarTema() {
                document.documentElement.setAttribute('data-bs-theme', mq.matches ? 'dark' : 'light');
            }
            aplicarTema();
            mq.addEventListener('change', aplicarTema);
        })();
    </script>

    <link rel="stylesheet" href="<?= BASEURL ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASEURL ?>css/all.min.css">
    <link rel="stylesheet" href="<?= BASEURL ?>css/tema.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand" href="<?= BASEURL ?>index.php">
                <img src="<?= BASEURL ?>imagens_site/logo.png" style="width: 42px; height: auto" alt="">
                Cinematicos
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#menuPrincipal" aria-controls="menuPrincipal"
                aria-expanded="false" aria-label="Abrir menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menuPrincipal">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-film"></i> Filmes
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= BASEURL ?>filmes/index.php"><i class="fa-solid fa-boxes-stacked"></i> Ver filmes</a></li>
                            <?php if (pode_adicionar_filme()) : ?>
                                <li><a class="dropdown-item" href="<?= BASEURL ?>filmes/add.php"><i class="fa-solid fa-plus"></i> Adicionar filme</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-address-book"></i> Clientes
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= BASEURL ?>clientes/index.php"><i class="fa-solid fa-users"></i> Ver clientes</a></li>
                            <?php if (pode_adicionar_cliente()) : ?>
                                <li><a class="dropdown-item" href="<?= BASEURL ?>clientes/add.php"><i class="fa-solid fa-user-plus"></i> Novo cliente</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <?php if (pode_ver_usuarios()) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user-lock"></i> Usuários
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= BASEURL ?>Usuarios/index.php"><i class="fa-solid fa-user-lock"></i> Ver usuários</a></li>
                                <li><a class="dropdown-item" href="<?= BASEURL ?>Usuarios/add.php"><i class="fa-solid fa-user-tie"></i> Cadastrar usuário</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>

                <ul class="navbar-nav align-items-lg-center">
                    <?php if (usuario_logado()) : ?>
                        <li class="nav-item">
                            <span class="nav-link">
                                <i class="fa-solid fa-circle-user"></i> <?= e($_SESSION['user']) ?>
                                <?php if (is_admin()) : ?><span class="badge bg-danger ms-1">Admin</span><?php endif; ?>
                            </span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASEURL ?>Usuarios/inc/logout.php">
                                <i class="fa-solid fa-right-from-bracket"></i> Sair
                            </a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASEURL ?>Usuarios/inc/login.php">
                                <i class="fa-solid fa-right-to-bracket"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-sm btn-secondary ms-lg-2 mt-1 mt-lg-0" href="<?= BASEURL ?>Usuarios/add.php">
                                <i class="fa-solid fa-user-plus"></i> Criar conta
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container" style="padding-top: 90px;">