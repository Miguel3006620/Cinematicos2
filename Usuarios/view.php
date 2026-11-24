<?php
require_once __DIR__ . '/functions.php';
exigir_admin();

$usuario = buscar_usuario((int) ($_GET['id'] ?? 0));
if (!$usuario) {
    negar_acesso("Usuário não encontrado.", 'Usuarios/index.php');
}

include(HEADER_TEMPLATE);

$foto = !empty($usuario['foto']) ? $usuario['foto'] : FOTO_PADRAO;
?>

<div class="pt-4">
    <h2 class="mb-1">Usuário #<?= (int) $usuario['id'] ?></h2>
    <hr>

    <?php mostrar_mensagem(); ?>

    <dl class="row">
        <dt class="col-sm-3">Nome</dt>
        <dd class="col-sm-9"><?= e($usuario['nome']) ?></dd>

        <dt class="col-sm-3">Login</dt>
        <dd class="col-sm-9"><?= e($usuario['user']) ?></dd>

        <dt class="col-sm-3">Nível</dt>
        <dd class="col-sm-9"><?= $usuario['nivel'] === NIVEL_ADMIN ? 'Admin' : 'Cliente' ?></dd>

        <dt class="col-sm-3">Foto</dt>
        <dd class="col-sm-9">
            <img src="<?= BASEURL ?>Usuarios/imagens/<?= e($foto) ?>" class="shadow rounded"
                style="max-width: 300px;" alt="Foto de <?= e($usuario['nome']) ?>">
        </dd>
    </dl>

    <div class="mt-3">
        <?php if (pode_editar_usuario($usuario)) : ?>
            <a href="edit.php?id=<?= (int) $usuario['id'] ?>" class="btn btn-secondary">
                <i class="fa-solid fa-pen-to-square"></i> Editar
            </a>
        <?php endif; ?>
        <a href="index.php" class="btn btn-light"><i class="fa-solid fa-rotate-left"></i> Voltar</a>
    </div>
</div>

<?php include(FOOTER_TEMPLATE); ?>