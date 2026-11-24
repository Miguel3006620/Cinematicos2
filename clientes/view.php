<?php
require_once __DIR__ . '/functions.php';
// Visitante pode visualizar: sem exigir_login

$cliente = buscar_cliente((int) ($_GET['id'] ?? 0));
if (!$cliente) {
    negar_acesso("Cliente não encontrado.", 'clientes/index.php');
}

include(HEADER_TEMPLATE);
?>

<div class="pt-4">
    <h2 class="mb-1">Cliente #<?= (int) $cliente['id'] ?></h2>
    <hr>

    <?php mostrar_mensagem(); ?>

    <dl class="row">
        <dt class="col-sm-3">Nome</dt>
        <dd class="col-sm-9"><?= e($cliente['nome']) ?></dd>

        <dt class="col-sm-3">E-mail</dt>
        <dd class="col-sm-9"><?= e($cliente['email']) ?></dd>

        <dt class="col-sm-3">Telefone</dt>
        <dd class="col-sm-9"><?= e($cliente['telefone']) ?></dd>

        <dt class="col-sm-3">Data de nascimento</dt>
        <dd class="col-sm-9"><?= e(data_br($cliente['data_nascimento'])) ?></dd>

        <dt class="col-sm-3">Cidade</dt>
        <dd class="col-sm-9"><?= e($cliente['cidade']) ?></dd>
    </dl>

    <div class="mt-3">
        <?php if (pode_editar_cliente()) : ?>
            <a href="edit.php?id=<?= (int) $cliente['id'] ?>" class="btn btn-secondary">
                <i class="fa-solid fa-pen-to-square"></i> Editar
            </a>
        <?php endif; ?>
        <a href="index.php" class="btn btn-light"><i class="fa-solid fa-rotate-left"></i> Voltar</a>
    </div>
</div>

<?php include(FOOTER_TEMPLATE); ?>