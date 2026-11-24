<?php
require_once __DIR__ . '/../config.php';
include(HEADER_TEMPLATE);
?>

<div class="pt-4" style="max-width: 640px; margin: auto;">
    <h2 class="mb-3"><i class="fa-solid fa-user-plus"></i> <?= is_admin() ? 'Cadastrar usuário' : 'Criar conta' ?></h2>

    <?php mostrar_mensagem(); ?>

    <form action="inc/Cadastro.php" method="post" enctype="multipart/form-data" onsubmit="return validarFoto()">
        <div class="text-center mb-4">
            <img src="<?= BASEURL ?>Usuarios/imagens/usuario-generico.jpg" id="pfp" class="rounded-circle mb-3"
                style="height: 200px; width: 200px; object-fit: cover; border: 1px solid gray;" alt="Foto de perfil">
            <br>
            <input type="file" accept="image/*" id="input" name="foto" class="d-none">
            <label for="input" class="btn btn-light">Selecionar foto de perfil</label>
        </div>

        <div class="mb-3">
            <label for="apelido" class="form-label">Nome</label>
            <input type="text" class="form-control" id="apelido" name="usuario[nome]" maxlength="50"
                placeholder="seu nome" required>
        </div>

        <div class="mb-3">
            <label for="log" class="form-label">Usuário</label>
            <input type="text" class="form-control" id="log" name="usuario[user]" maxlength="50"
                placeholder="nome de usuário" required>
        </div>

        <div class="mb-3">
            <label for="pass" class="form-label">Senha</label>
            <input type="password" class="form-control" id="pass" name="usuario[password]"
                placeholder="sua senha" autocomplete="new-password" required>
        </div>

        <?php if (is_admin()) : ?>
            <div class="mb-4">
                <label for="nivel" class="form-label">Nível de acesso</label>
                <select class="form-select" id="nivel" name="usuario[nivel]">
                    <option value="<?= NIVEL_USUARIO ?>" selected>Cliente</option>
                    <option value="<?= NIVEL_ADMIN ?>">Admin</option>
                </select>
            </div>
        <?php endif; ?>

        <div class="d-flex gap-2 mb-4">
            <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-user-check"></i> Cadastrar</button>
            <a href="<?= BASEURL ?>index.php" class="btn btn-light"><i class="fa-solid fa-rotate-left"></i> Cancelar</a>
        </div>
    </form>
</div>

<script>
    const input = document.getElementById('input');
    const imagem = document.getElementById('pfp');

    input.addEventListener('change', function () {
        if (input.files && input.files[0]) {
            imagem.src = URL.createObjectURL(input.files[0]);
        }
    });

    function validarFoto() {
        if (!input.files || input.files.length === 0) {
            alert('Selecione uma foto de perfil para continuar.');
            return false;
        }
        return true;
    }
</script>

<?php include(FOOTER_TEMPLATE); ?>