<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Cinematicos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?= BASEURL ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASEURL ?>css/add.css">
    <link rel="stylesheet" href="<?= BASEURL ?>css/edit.css">
    <link rel="stylesheet" href="<?= BASEURL ?>css/view.css">
    <link rel="stylesheet" href="<?= BASEURL ?>css/all.min.css">

    <style>
        body {
            margin-top: 1.5rem;
            padding-top: 50px;
        }

        .btn-light {
            background-color: #cccccc;
            border-color: #cccccc;
            color: #000000;
        }

        .btn-light:hover {
            background-color: #999999;
            border-color: #999999;
            color: #000000;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top container mb-3" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= BASEURL ?>index.php">
                <img src="<?= BASEURL ?>imagens_site/logo.png" style="width: 50px; height: auto" alt="">
                Cinematicos
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Abrir menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if (usuario_logado()) : ?>
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
                                <i class="fa-solid fa-user-lock"></i> Usuários
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= BASEURL ?>Usuarios/index.php"><i class="fa-solid fa-user-lock"></i> Ver usuários</a></li>
                                <?php if (pode_adicionar_usuario()) : ?>
                                    <li><a class="dropdown-item" href="<?= BASEURL ?>Usuarios/add.php"><i class="fa-solid fa-user-tie"></i> Cadastrar usuário</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>

                <ul class="navbar-nav">
                    <?php if (usuario_logado()) : ?>
                        <li class="nav-item">
                            <span class="nav-link">Bem vindo <?= e($_SESSION['user']) ?>!</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASEURL ?>Usuarios/inc/logout.php">
                                <i class="fa-solid fa-person-walking-arrow-right"></i> Desconectar
                            </a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASEURL ?>Usuarios/inc/login.php">
                                <i class="fa-solid fa-users"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASEURL ?>Usuarios/add.php">
                                <i class="fa-solid fa-user-plus"></i> Criar conta
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">