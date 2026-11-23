<?php
// Formulário de filme, usado por add.php e edit.php.
// Espera: $f (dados), $acao (action do form), $capaAtual (url), $tituloPagina, $textoBotao
?>
<div class="container py-4">
    <h2 class="mb-3"><i class="fa-solid fa-film"></i> <?= e($tituloPagina) ?></h2>

    <?php mostrar_mensagem(); ?>

    <form action="<?= e($acao) ?>" method="post" enctype="multipart/form-data">

        <div class="mb-4">
            <h5><i class="fa-solid fa-circle-info"></i> Informações principais</h5>
            <div class="row g-3">
                <div class="col-md-7">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="filme[titulo]" maxlength="140"
                        value="<?= e($f['titulo']) ?>" placeholder="Digite o título do filme" required>
                </div>

                <div class="col-md-5">
                    <label for="autores" class="form-label">Diretor(es)</label>
                    <input type="text" class="form-control" id="autores" name="filme[autores]" maxlength="150"
                        value="<?= e($f['autores']) ?>" placeholder="Ex.: Christopher Nolan">
                </div>

                <div class="col-md-5">
                    <label for="estudio" class="form-label">Estúdio</label>
                    <input type="text" class="form-control" id="estudio" name="filme[estudio]" maxlength="100"
                        value="<?= e($f['estudio']) ?>" placeholder="Ex.: Warner Bros.">
                </div>

                <div class="col-md-4">
                    <label for="lancamento" class="form-label">Data de lançamento</label>
                    <input type="date" class="form-control" id="lancamento" name="filme[data_lancamento_oficial]"
                        value="<?= e($f['data_lancamento_oficial']) ?>" required>
                </div>

                <div class="col-md-3">
                    <label for="valor" class="form-label">Valor do ingresso</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" step="0.01" min="0" class="form-control" id="valor"
                            name="filme[valor_ingresso]" value="<?= e($f['valor_ingresso']) ?>" placeholder="0,00">
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <h5><i class="fa-solid fa-tags"></i> Classificação</h5>
            <div class="row g-3">
                <div class="col-md-8">
                    <label for="categoria" class="form-label">Gêneros</label>
                    <input type="text" class="form-control" id="categoria" name="filme[categoria]" maxlength="100"
                        value="<?= e($f['categoria']) ?>" placeholder="Ex.: Ação, Sci-fi, Drama">
                    <div class="form-text">Separe os gêneros por vírgula.</div>
                </div>

                <div class="col-md-4">
                    <label for="faixa" class="form-label">Faixa etária</label>
                    <div class="input-group">
                        <input type="number" min="0" max="99" class="form-control" id="faixa"
                            name="filme[faixa_etaria]" value="<?= e($f['faixa_etaria'] ?: '') ?>" placeholder="Ex.: 12">
                        <span class="input-group-text">anos</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <h5><i class="fa-solid fa-align-left"></i> Sinopse</h5>
            <textarea class="form-control" id="sinopse" name="filme[sinopse]" rows="4" maxlength="400"
                placeholder="Escreva uma breve descrição do filme..."><?= e($f['sinopse']) ?></textarea>
        </div>

        <div class="mb-4">
            <h5><i class="fa-solid fa-image"></i> Capa</h5>
            <div class="row g-3">
                <div class="col-md-7">
                    <label for="capa" class="form-label">Arquivo da capa</label>
                    <input type="file" class="form-control" id="capa" name="capa" accept="image/*">
                </div>
                <div class="col-12">
                    <img id="capa-preview" src="<?= e($capaAtual) ?>" class="border"
                        style="height: 250px; width: auto;" alt="Capa">
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-secondary">
                <i class="fa-solid fa-floppy-disk"></i> <?= e($textoBotao) ?>
            </button>
            <a href="index.php" class="btn btn-light">
                <i class="fa-solid fa-rotate-left"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<script>
    document.getElementById('capa').addEventListener('change', function () {
        if (this.files && this.files[0]) {
            document.getElementById('capa-preview').src = URL.createObjectURL(this.files[0]);
        }
    });
</script>