<?php
require_once __DIR__ . '/function.php';
exigir_login();

$filme = buscar_filme((int) ($_GET['id'] ?? 0));
if (!$filme) {
    negar_acesso("Filme não encontrado.", 'filmes/index.php');
}

include(HEADER_TEMPLATE);
?>

<div class="container py-4">
    <?php mostrar_mensagem(); ?>

    <div class="movie-details-card">
        <div class="movie-details-header">
            <h2><i class="fa-solid fa-film"></i> <?= e($filme['titulo']) ?></h2>
            <span>Detalhes do filme</span>
        </div>

        <div class="movie-details-body">
            <div class="movie-poster">
                <img src="<?= e(url_capa($filme['capa'])) ?>" alt="Capa de <?= e($filme['titulo']) ?>">
            </div>

            <div class="movie-info">
                <div class="movie-title">
                    <h1><?= e($filme['titulo']) ?></h1>
                    <?php if (!empty($filme['faixa_etaria'])) : ?>
                        <span class="age-rating">+<?= (int) $filme['faixa_etaria'] ?></span>
                    <?php endif; ?>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label"><i class="fa-solid fa-video"></i> Diretor(es)</span>
                        <span class="info-value"><?= e($filme['autores']) ?></span>
                    </div>

                    <div class="info-item">
                        <span class="info-label"><i class="fa-solid fa-building"></i> Estúdio</span>
                        <span class="info-value"><?= e($filme['estudio']) ?></span>
                    </div>

                    <div class="info-item">
                        <span class="info-label"><i class="fa-solid fa-calendar-days"></i> Lançamento</span>
                        <span class="info-value"><?= e(formatar_data($filme['data_lancamento_oficial'])) ?></span>
                    </div>

                    <div class="info-item">
                        <span class="info-label"><i class="fa-solid fa-ticket"></i> Valor do ingresso</span>
                        <span class="info-value price">R$ <?= number_format((float) $filme['valor_ingresso'], 2, ',', '.') ?></span>
                    </div>

                    <div class="info-item info-item-full">
                        <span class="info-label"><i class="fa-solid fa-tags"></i> Gêneros</span>
                        <span class="info-value"><?= e($filme['categoria']) ?></span>
                    </div>
                </div>

                <div class="synopsis">
                    <h5><i class="fa-solid fa-align-left"></i> Sinopse</h5>
                    <p><?= nl2br(e($filme['sinopse'])) ?></p>
                </div>
            </div>
        </div>

        <div class="movie-actions">
            <a href="index.php" class="btn btn-light">
                <i class="fa-solid fa-arrow-rotate-left"></i> Voltar
            </a>

            <?php if (pode_editar_filme()) : ?>
                <a href="edit.php?id=<?= (int) $filme['id'] ?>" class="btn btn-primary">
                    <i class="fa-solid fa-pen-to-square"></i> Editar filme
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include(FOOTER_TEMPLATE); ?>