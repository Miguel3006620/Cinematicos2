<?php
require_once __DIR__ . '/function.php';
exigir_login();

$filmes = listar_filmes();

include(HEADER_TEMPLATE);
?>

<div class="pt-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="mb-0">Filmes</h2>
        <div>
            <?php if (pode_adicionar_filme()) : ?>
                <a class="btn btn-secondary" href="add.php"><i class="fa-solid fa-plus"></i> Novo filme</a>
            <?php endif; ?>
            <a class="btn btn-light" href="index.php"><i class="fa-solid fa-rotate"></i> Atualizar</a>
        </div>
    </div>

    <?php mostrar_mensagem(); ?>

    <table class="table table-hover align-middle text-center">
        <thead>
            <tr>
                <th>Capa</th>
                <th>Título</th>
                <th>Diretor(es)</th>
                <th>Lançamento</th>
                <th>Ingresso</th>
                <th class="text-end">Opções</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($filmes) : ?>
                <?php foreach ($filmes as $f) : ?>
                    <tr>
                        <td>
                            <img src="<?= e(url_capa($f['capa'])) ?>" style="width: 110px; height: 140px; object-fit: cover;" alt="">
                        </td>
                        <td class="text-start"><?= e($f['titulo']) ?></td>
                        <td><?= e($f['autores']) ?></td>
                        <td><?= e(formatar_data($f['data_lancamento_oficial'])) ?></td>
                        <td>R$ <?= number_format((float) $f['valor_ingresso'], 2, ',', '.') ?></td>
                        <td class="text-end">
                            <a href="view.php?id=<?= (int) $f['id'] ?>" class="btn btn-sm btn-light mb-1">
                                <i class="fa fa-eye"></i> Visualizar
                            </a>

                            <?php if (pode_editar_filme()) : ?>
                                <a href="edit.php?id=<?= (int) $f['id'] ?>" class="btn btn-sm btn-secondary mb-1">
                                    <i class="fa fa-pencil"></i> Editar
                                </a>
                            <?php endif; ?>

                            <?php if (pode_excluir_filme()) : ?>
                                <a href="#" class="btn btn-sm btn-dark mb-1" data-bs-toggle="modal" data-bs-target="#delete-modal"
                                    data-id="<?= (int) $f['id'] ?>" data-nome="<?= e($f['titulo']) ?>">
                                    <i class="fa fa-trash"></i> Excluir
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