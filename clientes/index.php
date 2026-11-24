<?php
require_once __DIR__ . '/functions.php';
// Visitante pode listar: sem exigir_login

$clientes = listar_clientes();

include(HEADER_TEMPLATE);
?>

<div class="pt-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="mb-0">Clientes</h2>
        <div>
            <?php if (pode_adicionar_cliente()) : ?>
                <a class="btn btn-secondary" href="add.php"><i class="fa fa-plus"></i> Novo cliente</a>
            <?php endif; ?>
            <a class="btn btn-light" href="index.php"><i class="fas fa-sync-alt"></i> Atualizar</a>
        </div>
    </div>

    <?php mostrar_mensagem(); ?>

    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Cidade</th>
                <th>Nascimento</th>
                <th class="text-end">Opções</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($clientes) : ?>
                <?php foreach ($clientes as $c) : ?>
                    <tr>
                        <td><?= (int) $c['id'] ?></td>
                        <td><?= e($c['nome']) ?></td>
                        <td><?= e($c['email']) ?></td>
                        <td><?= e($c['telefone']) ?></td>
                        <td><?= e($c['cidade']) ?></td>
                        <td><?= e(data_br($c['data_nascimento'])) ?></td>
                        <td class="text-end">
                            <a href="view.php?id=<?= (int) $c['id'] ?>" class="btn btn-sm btn-light">
                                <i class="fa fa-eye"></i> Visualizar
                            </a>

                            <?php if (pode_editar_cliente()) : ?>
                                <a href="edit.php?id=<?= (int) $c['id'] ?>" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-edit"></i> Editar
                                </a>
                            <?php endif; ?>

                            <?php if (pode_excluir_cliente()) : ?>
                                <a href="#" class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#delete-modal"
                                    data-id="<?= (int) $c['id'] ?>" data-nome="<?= e($c['nome']) ?>">
                                    <i class="fa-solid fa-trash-can"></i> Excluir
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7" style="color: white">Nenhum registro encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include(ABSPATH . 'inc/modal.php'); ?>
<?php include(FOOTER_TEMPLATE); ?>