<?php
require_once __DIR__ . '/config.php';

// Monta um card do dashboard
function card(string $href, string $icone, string $texto, string $classe = 'btn-light'): string
{
    return '<div class="col-lg-2 col-sm-3 col-6">'
        . '<a href="' . e(BASEURL . $href) . '" class="btn ' . $classe . ' w-100 p-3">'
        . '<i class="fa-solid ' . $icone . ' fa-3x d-block mb-2"></i>'
        . e($texto)
        . '</a></div>';
}

include(HEADER_TEMPLATE);
?>

<div class="pt-4">
    <h1>Dashboard</h1>
    <hr>

    <?php mostrar_mensagem(); ?>

    <?php if (!usuario_logado()) : ?>
        <div class="alert alert-secondary d-flex flex-wrap justify-content-between align-items-center gap-2">
            <span>Entre ou crie uma conta para cadastrar, editar e excluir registros.</span>
            <span>
                <a href="<?= BASEURL ?>Usuarios/inc/login.php" class="btn btn-secondary btn-sm">Login</a>
                <a href="<?= BASEURL ?>Usuarios/add.php" class="btn btn-light btn-sm">Criar conta</a>
            </span>
        </div>
    <?php endif; ?>

    <div class="row g-3 mt-2">
        <?php
        echo card('filmes/index.php', 'fa-boxes-stacked', 'Filmes');
        if (pode_adicionar_filme()) echo card('filmes/add.php', 'fa-film', 'Novo filme', 'btn-secondary');

        echo card('clientes/index.php', 'fa-address-book', 'Clientes');
        if (pode_adicionar_cliente()) echo card('clientes/add.php', 'fa-user-plus', 'Novo cliente', 'btn-secondary');

        if (pode_ver_usuarios()) echo card('Usuarios/index.php', 'fa-user-lock', 'Usuários');
        if (pode_adicionar_usuario()) echo card('Usuarios/add.php', 'fa-user-tie', 'Novo usuário', 'btn-secondary');
        ?>
    </div>
</div>

<?php include(FOOTER_TEMPLATE); ?>