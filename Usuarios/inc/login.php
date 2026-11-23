<?php
require_once __DIR__ . '/../../config.php';
redirecionar_se_logado();
include(HEADER_TEMPLATE);
?>

<div class="pt-4 mt-4" style="max-width: 420px; margin: auto;">
    <h2 class="mb-3"><i class="fa-solid fa-user-check"></i> Login</h2>

    <?php mostrar_mensagem(); ?>

    <form action="valida.php" method="post">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="log" name="login" placeholder="Usuário" required>
            <label for="log">Usuário</label>
        </div>

        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="pass" name="senha" placeholder="Senha" required>
            <label for="pass">Senha</label>
        </div>

        <div class="d-flex gap-2 mb-3">
            <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-user-check"></i> Conectar</button>
            <a href="<?= BASEURL ?>index.php" class="btn btn-light"><i class="fa-solid fa-rotate-left"></i> Cancelar</a>
        </div>
    </form>

    <p class="text-center">
        Ainda não tem conta? <a href="<?= BASEURL ?>Usuarios/add.php">Criar conta</a>
    </p>
</div>

<?php include(FOOTER_TEMPLATE); ?>