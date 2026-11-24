<?php
// Formulário de cliente, usado por add.php e edit.php.
// Espera: $c (dados), $acao, $tituloPagina, $textoBotao
?>
<div class="pt-4">
    <h2 class="mb-3"><i class="fa-solid fa-address-book"></i> <?= e($tituloPagina) ?></h2>

    <?php mostrar_mensagem(); ?>

    <form action="<?= e($acao) ?>" method="post">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="cliente[nome]" maxlength="100"
                    value="<?= e($c['nome']) ?>" required>
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="cliente[email]" maxlength="120"
                    value="<?= e($c['email']) ?>" required>
            </div>

            <div class="col-md-4">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="cliente[telefone]" maxlength="20"
                    value="<?= e($c['telefone']) ?>" placeholder="(15) 99999-9999" required>
            </div>

            <div class="col-md-4">
                <label for="nascimento" class="form-label">Data de nascimento</label>
                <input type="date" class="form-control" id="nascimento" name="cliente[data_nascimento]"
                    value="<?= e($c['data_nascimento']) ?>" required>
            </div>

            <div class="col-md-4">
                <label for="cidade" class="form-label">Cidade</label>
                <input type="text" class="form-control" id="cidade" name="cliente[cidade]" maxlength="80"
                    value="<?= e($c['cidade']) ?>">
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-secondary">
                <i class="fa-solid fa-floppy-disk"></i> <?= e($textoBotao) ?>
            </button>
            <a href="index.php" class="btn btn-light">
                <i class="fa-solid fa-rotate-left"></i> Cancelar
            </a>
        </div>
    </form>
</div>