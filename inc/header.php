<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Cinematicos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/add.css">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/edit.css">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/view.css">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/all.min.css">

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

<body class="">
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top container mb-3 " data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo BASEURL; ?>index.php"><img src="./imagens_site/logo.png" style="width: 50px; height: auto">
                Cinematicos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCrud" aria-controls="navbarCrud" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-users"></i> Clientes
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?php echo BASEURL; ?>customers/add.php"><i class="fa-solid fa-user-plus"></i> Adicionar Cliente</a></li>
                            <li><a class="dropdown-item" href="<?php echo BASEURL; ?>customers/"><i class="fa-solid fa-users"></i> Gerenciar Clientes</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-boxes-stacked"></i> Filmes
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?php echo BASEURL; ?>filmes/add.php"><i class="fa-solid fa-box"></i> Adicionar filme</a></li>
                            <li><a class="dropdown-item" href="<?php echo BASEURL; ?>filmes/"><i class="fa-solid fa-boxes-stacked"></i> Gerenciar filmes</a></li>
                        </ul>
                    </li>
                    <?php if (isset($_SESSION['user'])) : //Verifica se está logado 
                    ?>
                        <?php if ($_SESSION['user'] == "admin") : //Verifica se está logado como admin 
                        ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-user-lock"></i> Usuários
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="<?php echo BASEURL; ?>usuarios/add.php"><i class="fa-solid fa-user-tie"></i> Adicionar Usuário</a></li>
                                    <li><a class="dropdown-item" href="<?php echo BASEURL; ?>usuarios/"><i class="fa-solid fa-user-lock"></i> Gerenciar Usuários</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASEURL; ?>usuarios/inc/logout.php">
                                Bem vindo <?php echo $_SESSION['user'] ?>! <i class="fa-solid fa-person-walking-arrow-right"></i> Desconectar
                            </a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASEURL; ?>usuarios/inc/login.php">
                                <i class="fa-solid fa-users"></i> Login
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">