<?php
include "function.php";
add();
include HEADER_TEMPLATE;
?>
<style>

</style>
<div class="container py-4">
    <div class="movie-form-card">
        <div class="movie-form-header">
            <div>
                <h2 class="mb-1">
                    <i class="fa-solid fa-film"></i> Novo Filme
                </h2>
                <p class="mb-0">Cadastre as informações do filme</p>
            </div>
        </div>

        <form action="add.php" method="post" enctype="multipart/form-data">

            <div class="form-section">
                <h5><i class="fa-solid fa-circle-info"></i> Informações principais</h5>

                <div class="row g-3">
                    <div class="col-md-7">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="filme['titulo']" placeholder="Digite o título do filme" required>
                    </div>

                    <div class="col-md-5">
                        <label for="autores" class="form-label">Diretor(es)</label>
                        <input type="text" class="form-control" id="autores" name="filme['autores']" placeholder="Ex.: Christopher Nolan">
                    </div>

                    <div class="col-md-5">
                        <label for="estudio" class="form-label">Estúdio</label>
                        <input type="text" class="form-control" id="estudio" name="filme['estudio']" placeholder="Ex.: Warner Bros.">
                    </div>

                    <div class="col-md-4">
                        <label for="lancamento" class="form-label">Data de lançamento</label>
                        <input type="date" class="form-control" id="lancamento" name="filme['data_lancamento_oficial']">
                    </div>

                    <div class="col-md-3">
                        <label for="valor" class="form-label">Valor do ingresso</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="number" step="0.01" class="form-control" id="valor" name="filme['valor_ingresso']" placeholder="0,00">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h5><i class="fa-solid fa-tags"></i> Classificação</h5>

                <div class="row g-3">
                    <div class="col-md-8">
                        <label for="categoria" class="form-label">Gêneros</label>
                        <input type="text" class="form-control" id="categoria" name="filme['categoria']" placeholder="Ex.: Ação, sci-fi, Drama">
                        <div class="form-text">
                            Separe os gêneros por vírgula.
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="faixa" class="form-label">Faixa etária</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="faixa" name="filme['faixa_etaria']" placeholder="Ex.: 12">
                            <span class="input-group-text">anos</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h5><i class="fa-solid fa-align-left"></i> Sinopse</h5>

                <label for="sinopse" class="form-label">Sinopse do filme</label>
                <textarea class="form-control" id="sinopse" name="filme['sinopse']" rows="4" placeholder="Escreva uma breve descrição do filme..."></textarea>
            </div>

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
                        <img src="../imagens_site/sem_imagem.jpg" class="border" style="width: auto; height: 250px" id="capa-preview">
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn btn-light">
                    <i class="fa-solid fa-rotate-left"></i>
                    Cancelar
                </a>

                <button type="submit" class="btn btn-secondary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Adicionar filme
                </button>
            </div>
        </form>
    </div>
</div>
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