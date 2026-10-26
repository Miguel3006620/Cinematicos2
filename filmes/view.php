<?php
include('function.php');
view($_GET['id']);


include(HEADER_TEMPLATE);
?>
<br>
<?php if (!empty($_SESSION['message'])) : ?>
    <div class="alert alert-<?php echo $_SESSION['type']; ?>"><?php echo $_SESSION['message']; ?></div>
<?php endif; ?>
<style>

</style>
<div class="container py-4">
    <div class="movie-details-card">
        <!-- Cabeçalho -->
        <div class="movie-details-header">
            <div>
                <h2>
                    <i class="fa-solid fa-film"></i>
                    <?php echo $filme['titulo']; ?>
                </h2>
                <span>Detalhes do filme</span>
            </div>
        </div>

        <!-- Conteúdo -->
        <div class="movie-details-body">

            <!-- Capa -->
            <div class="movie-poster">
                <?php if (!empty($filme['capa'])) : ?>
                    <img src="../imgs/<?php echo $filme['capa']; ?>" alt="Capa de <?php echo $filme['titulo']; ?>">
                <?php else : ?>
                    <img src="../imagens_site/sem_imagem.jpg" alt="Sem capa disponível">
                <?php endif; ?>
            </div>

            <!-- Informações -->
            <div class="movie-info">

                <div class="movie-title">
                    <h1><?php echo $filme['titulo']; ?></h1>

                    <?php if (!empty($filme['faixa_etaria'])) : ?>
                        <span class="age-rating">
                            +<?php echo $filme['faixa_etaria']; ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="info-grid">

                    <div class="info-item">
                        <span class="info-label">
                            <i class="fa-solid fa-video"></i>
                            Diretor(es)
                        </span>
                        <span class="info-value">
                            <?php echo $filme['autores']; ?>
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <i class="fa-solid fa-building"></i>
                            Estúdio
                        </span>
                        <span class="info-value">
                            <?php echo $filme['estudio']; ?>
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <i class="fa-solid fa-calendar-days"></i>
                            Data de lançamento
                        </span>
                        <span class="info-value">
                            <?php echo formatData($filme['data_lancamento_oficial'], "d/m/Y"); ?>
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <i class="fa-solid fa-ticket"></i>
                            Valor do ingresso
                        </span>
                        <span class="info-value price">
                            <?php echo "R$ " . number_format($filme['valor_ingresso'], 2, ',', '.'); ?>
                        </span>
                    </div>

                    <div class="info-item info-item-full">
                        <span class="info-label">
                            <i class="fa-solid fa-tags"></i>
                            Gêneros
                        </span>
                        <span class="info-value">
                            <?php echo $filme['categoria']; ?>
                        </span>
                    </div>

                </div>

                <!-- Sinopse -->
                <div class="synopsis">
                    <h5>
                        <i class="fa-solid fa-align-left"></i>
                        Sinopse
                    </h5>

                    <p>
                        <?php echo $filme['sinopse']; ?>
                    </p>
                </div>

            </div>
        </div>

        <!-- Ações -->
        <div class="movie-actions">
            <a href="index.php" class="btn btn-light">
                <i class="fa-solid fa-arrow-rotate-left"></i>
                Voltar
            </a>

            <a href="edit.php?id=<?php echo $filme['id']; ?>" class="btn btn-primary">
                <i class="fa-solid fa-pen-to-square"></i>
                Editar filme
            </a>
        </div>

    </div>

</div>


<?php include FOOTER_TEMPLATE; ?>