<?php
include "function.php";
edit();
include HEADER_TEMPLATE;
?>

<?php if (!empty($_SESSION['message'])) : ?>
    <div class="alert alert-<?php echo $_SESSION['type']; ?>"><?php echo $_SESSION['message']; ?></div>
<?php endif; ?>
<style>

</style>
<h2>Atualizar filme</h2>

<form action="edit.php?id=<?= $customer['id']; ?>" method="post" enctype="multipart/form-data">

    <div class="form-section">
        <h5><i class="fa-solid fa-circle-info"></i> Informações principais</h5>

        <div class="row g-3">
            <div class="col-md-7">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="filme['titulo']" placeholder="Digite o título do filme" value="<?php echo $customer['titulo']; ?>" required>
            </div>

            <div class="col-md-5">
                <label for="autores" class="form-label">Diretor(es)</label>
                <input type="text" class="form-control" id="autores" name="filme['autores']" value="<?php echo $customer['autores']; ?>" placeholder="Ex.: Christopher Nolan">
            </div>

            <div class="col-md-5">
                <label for="estudio" class="form-label">Estúdio</label>
                <input type="text" class="form-control" id="estudio" name="filme['estudio']" value="<?php echo $customer['estudio']; ?>" placeholder="Ex.: Warner Bros.">
            </div>

            <div class="col-md-4">
                <label for="lancamento" class="form-label">Data de lançamento</label>
                <input type="date" class="form-control" id="lancamento" name="filme['data_lancamento_oficial']" value="<?php echo formatData($customer['data_lancamento_oficial'], 'Y-m-d'); ?>">
            </div>

            <div class="col-md-3">
                <label for="valor" class="form-label">Valor do ingresso</label>
                <div class="input-group">
                    <span class="input-group-text">R$</span>
                    <input type="number" step="0.01" class="form-control" id="valor" name="filme['valor_ingresso']" placeholder="0,00" value="<?php echo $customer['valor_ingresso']; ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="form-section">
        <h5><i class="fa-solid fa-tags"></i> Classificação</h5>

        <div class="row g-3">
            <div class="col-md-8">
                <label for="categoria" class="form-label">Gêneros</label>
                <input type="text" class="form-control" id="categoria" name="filme['categoria']" placeholder="Ex.: Ação, sci-fi, Drama" value="<?php echo $customer['categoria']; ?>">
                <div class="form-text">
                    Separe os gêneros por vírgula.
                </div>
            </div>

            <div class="col-md-4">
                <label for="faixa" class="form-label">Faixa etária</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="faixa" name="filme['faixa_etaria']" placeholder="Ex.: 12" value="<?php echo $customer['faixa_etaria']; ?>">
                    <span class="input-group-text">anos</span>
                </div>
            </div>
        </div>
    </div>

    <div class="form-section">
        <h5><i class="fa-solid fa-align-left"></i> Sinopse</h5>

        <label for="sinopse" class="form-label">Sinopse do filme</label>
        <textarea class="form-control" id="sinopse" name="filme['sinopse']"  rows="4" placeholder="Escreva uma breve descrição do filme..."><?php echo $customer['sinopse']; ?></textarea>    </div>

    <div class="form-section">
        <h5><i class="fa-solid fa-image"></i> Capa</h5>

        <div class="row g-4 mb-3">
            <div class="col-md-7">
                <label for="capa" class="form-label">Capa do filme</label>
                <input type="file" class="form-control" id="capa" name="filme[capa]" accept="image/*">
            </div>
        </div>
        <div class="row g-5 ">
            <div class="col-md-5">
                <?php if (!empty($customer['capa'])) : ?>
                    <img src="../imgs/<?php echo $customer['capa']; ?>" id="capa-preview" style="width: auto; height: 250px" alt="Capa de <?php echo $customer['titulo']; ?>">
                <?php else : ?>
                    <img src="../imagens_site/sem_imagem.jpg" alt="Sem capa disponível">
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div id="actions" class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-secondary">
                <i class="fa-solid fa-floppy-disk"></i> Salvar
            </button>
            <a href="index.php" class="btn btn-light">
                <i class="fa-solid fa-rotate-left"></i> Cancelar
            </a>
        </div>
    </div>
</form>

<script>
    const input = document.getElementById('capa');
    const imagem = document.getElementById('capa-preview');

    input.addEventListener('change', function() {
        if (input.files && input.files[0]) {
            const arquivo = input.files[0];

            const urlTemporaria = URL.createObjectURL(arquivo);
            imagem.src = urlTemporaria;

            imagem.style.display = 'block';
        }
    });
</script>

<?php include FOOTER_TEMPLATE; ?>