<?php
require_once __DIR__ . '/functions.php';
exigir_login();

$usuarios = listar_usuarios();

include(HEADER_TEMPLATE);
?>

<div class="pt-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="mb-0">Usuários</h2>
        <div>
            <?php if (pode_adicionar_usuario()) : ?>
                <a class="btn btn-secondary" href="add.php"><i class="fa fa-plus"></i> Novo usuário</a>
            <?php endif; ?>
            <a class="btn btn-light" href="index.php"><i class="fas fa-sync-alt"></i> Atualizar</a>
        </div>
    </div>

    <form method="post" action="index.php" class="mb-3">
        <div class="input-group" style="max-width: 420px;">
            <input type="text" class="form-control" maxlength="80" name="users"
                placeholder="Buscar por nome" value="<?= e($_POST['users'] ?? '') ?>">
            <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> Consultar</button>
        </div>
    </form>

    <?php mostrar_mensagem(); ?>

    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Id</th>
                <th>Foto</th>
                <th>Nome</th>
                <th>Usuário</th>
                <th>Nível</th>
                <th class="text-end">Opções</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($usuarios) : ?>
                <?php foreach ($usuarios as $u) : ?>
                    <?php
                    $ehEuMesmo = (int) $u['id'] === (int) ($_SESSION['id'] ?? 0);
                    $foto = !empty($u['foto']) ? $u['foto'] : FOTO_PADRAO;
                    ?>
                    <tr>
                        <td><?= (int) $u['id'] ?></td>
                        <td>
                            <img src="<?= BASEURL ?>Usuarios/imagens/<?= e($foto) ?>"
                                class="rounded" width="60" height="60" style="object-fit: cover;" alt="">
                        </td>
                        <td><?= e($u['nome']) ?></td>
                        <td><?= e($u['user']) ?></td>
                        <td>
                            <?php if ($u['nivel'] === NIVEL_ADMIN) : ?>
                                <span class="badge bg-dark">Admin</span>
                            <?php else : ?>
                                <span class="badge bg-secondary">Cliente</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <a href="view.php?id=<?= (int) $u['id'] ?>" class="btn btn-sm btn-light">
                                <i class="fa fa-eye"></i> Visualizar
                            </a>

                            <?php if (pode_editar_usuario($u)) : ?>
                                <a href="edit.php?id=<?= (int) $u['id'] ?>" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-edit"></i> Editar
                                </a>
                            <?php endif; ?>

                            <?php if (pode_excluir_usuario() && !$ehEuMesmo) : ?>
                                <a href="#" class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#delete-modal"
                                    data-id="<?= (int) $u['id'] ?>" data-nome="<?= e($u['nome']) ?>">
                                    <i class="fa-solid fa-trash-can"></i> Excluir
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6">Nenhum registro encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include(ABSPATH . 'inc/modal.php'); ?>
<?php include(FOOTER_TEMPLATE); ?>