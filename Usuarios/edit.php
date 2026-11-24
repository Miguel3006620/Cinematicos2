<?php
require_once __DIR__ . '/functions.php';
exigir_admin();

$id = (int) ($_GET['id'] ?? 0);
$usuario = buscar_usuario($id);

if (!$usuario) {
    negar_acesso("Usuário não encontrado.", 'Usuarios/index.php');
}

$ehPost = ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';

if ($ehPost) {
    if (atualizar_usuario((int) $usuario['id'])) {
        flash("Usuário atualizado com sucesso.", 'success');
        redirecionar('Usuarios/index.php');
    }
    // Se falhou, mostra o que foi digitado
    $usuario['nome']  = $_POST['usuario']['nome']  ?? $usuario['nome'];
    $usuario['user']  = $_POST['usuario']['user']  ?? $usuario['user'];
    $usuario['nivel'] = $_POST['usuario']['nivel'] ?? $usuario['nivel'];
}

include(HEADER_TEMPLATE);

$foto = !empty($usuario['foto']) ? $usuario['foto'] : FOTO_PADRAO;
?>

<div class="pt-4">
    <h2 class="mb-1">Atualizar usuário</h2>
    <hr>

    <?php mostrar_mensagem(); ?>

    <form action="edit.php?id=<?= (int) $usuario['id'] ?>" method="post" enctype="multipart/form-data">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="usuario[nome]" maxlength="50"
                    value="<?= e($usuario['nome']) ?>" required>
            </div>

            <div class="col-md-6">
                <label for="user" class="form-label">Usuário (login)</label>
                <input type="text" class="form-control" id="user" name="usuario[user]" maxlength="50"
                    value="<?= e($usuario['user']) ?>" required>
            </div>

            <div class="col-md-4">
                <label for="nivel" class="form-label">Nível de acesso</label>
                <select class="form-select" id="nivel" name="usuario[nivel]">
                    <option value="<?= NIVEL_USUARIO ?>" <?= $usuario['nivel'] === NIVEL_USUARIO ? 'selected' : '' ?>>Cliente</option>
                    <option value="<?= NIVEL_ADMIN ?>" <?= $usuario['nivel'] === NIVEL_ADMIN ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>

            <div class="col-md-4">
                <label for="senha" class="form-label">Nova senha</label>
                <input type="password" class="form-control" id="senha" name="usuario[password]"
                    autocomplete="new-password" placeholder="Deixe em branco para manter">
            </div>

            <div class="col-md-4">
                <label for="foto" class="form-label">Trocar foto</label>
                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
            </div>

            <div class="col-md-3">
                <label class="form-label">Pré-visualização</label>
                <img id="imgPreview" class="shadow rounded w-100"
                    src="<?= BASEURL ?>Usuarios/imagens/<?= e($foto) ?>" alt="Foto do usuário">
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-secondary">
                <i class="fa-solid fa-floppy-disk"></i> Salvar
            </button>
            <a href="index.php" class="btn btn-light">
                <i class="fa-solid fa-rotate-left"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<script>
    document.getElementById('foto').addEventListener('change', function () {
        if (this.files && this.files[0]) {
            document.getElementById('imgPreview').src = URL.createObjectURL(this.files[0]);
        }
    });
</script>

<?php include(FOOTER_TEMPLATE); ?>