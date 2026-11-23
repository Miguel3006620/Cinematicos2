<?php
require_once __DIR__ . '/config.php';
include(HEADER_TEMPLATE);
?>

<div class="pt-4">
    <h1>Dashboard</h1>
    <hr>

    <?php mostrar_mensagem(); ?>

    <?php if (!usuario_logado()) : ?>
        <div class="text-center py-5">
            <h3 class="mb-3">Bem-vindo ao Cinematicos</h3>
            <p class="mb-4">Entre na sua conta ou crie uma para acessar o catálogo de filmes.</p>
            <a href="<?= BASEURL ?>Usuarios/inc/login.php" class="btn btn-secondary me-2">
                <i class="fa-solid fa-user-check"></i> Login
            </a>
            <a href="<?= BASEURL ?>Usuarios/add.php" class="btn btn-light">
                <i class="fa-solid fa-user-plus"></i> Criar conta
            </a>
        </div>
    <?php else : ?>
        <div class="row g-3 mt-2">
            <?php if (pode_ver_filmes()) : ?>
                <div class="col-lg-2 col-sm-3 col-6">
                    <a href="<?= BASEURL ?>filmes/index.php" class="btn btn-light w-100 p-3">
                        <i class="fa-solid fa-boxes-stacked fa-3x d-block mb-2"></i>
                        Filmes
                    </a>
                </div>
            <?php endif; ?>

            <?php if (pode_adicionar_filme()) : ?>
                <div class="col-lg-2 col-sm-3 col-6">
                    <a href="<?= BASEURL ?>filmes/add.php" class="btn btn-secondary w-100 p-3">
                        <i class="fa-solid fa-film fa-3x d-block mb-2"></i>
                        Novo filme
                    </a>
                </div>
            <?php endif; ?>

            <?php if (pode_ver_usuarios()) : ?>
                <div class="col-lg-2 col-sm-3 col-6">
                    <a href="<?= BASEURL ?>Usuarios/index.php" class="btn btn-light w-100 p-3">
                        <i class="fa-solid fa-user-lock fa-3x d-block mb-2"></i>
                        Usuários
                    </a>
                </div>
            <?php endif; ?>

            <?php if (pode_adicionar_usuario()) : ?>
                <div class="col-lg-2 col-sm-3 col-6">
                    <a href="<?= BASEURL ?>Usuarios/add.php" class="btn btn-secondary w-100 p-3">
                        <i class="fa-solid fa-user-tie fa-3x d-block mb-2"></i>
                        Novo usuário
                    </a>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php include(FOOTER_TEMPLATE); ?>