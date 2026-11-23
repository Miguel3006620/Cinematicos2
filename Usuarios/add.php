<?php
// Esse é o add.php (cadastro) — fica em usuarios/
if (!isset($_SESSION)) session_start();
include_once __DIR__ . '/../config.php';
include_once DBAPI;
exigir_admin();
include(HEADER_TEMPLATE);
?>

<div id="actions" class="mt-5 mb-5 m2">

    <?php if (!empty($_SESSION['message'])) : ?>
        <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
            <?php echo $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php $_SESSION['message'] = null; $_SESSION['type'] = null; ?>
    <?php endif; ?>

    <form action="inc/Cadastro.php" method="post" style="margin: 2%" enctype="multipart/form-data" onsubmit="return validarFoto()">
        <div class="row">

            <div class="form-control mb-4 d-flex flex-column align-items-center justify-content-center">
                <img src="<?php echo BASEURL; ?>imagens/usuario-generico.jpg" id="pfp" class="mb-4 rounded-circle" style="height: 250px; width: 250px; border: 1px solid gray;">
                <input type="file" accept="image/*" style="display:none;" id="input" name="foto">
                <label for="input" class="btn btn-light" style="border: 1px solid gray;">Selecionar sua foto de perfil</label>
            </div>

            <label for="apelido">Nome</label>
            <input type="text" class="form-control mb-2" id="apelido" placeholder="seu nome" name="usuario[nome]">

            <label for="log">Usuário</label>
            <input type="text" class="form-control mb-2" id="log" placeholder="nome de usuário" name="usuario[user]">

            <label for="pass">Senha</label>
            <input type="password" class="form-control mb-3" id="pass" placeholder="sua senha" name="usuario[password]">

            <div class="col-12 mb-2">
                <button type="submit" class="btn btn-secondary btn-block mb-4"><i class="fa-solid fa-user-check"></i> Cadastrar</button>
                <a href="<?php echo BASEURL; ?>" class="btn btn-light btn-block mb-4"><i class="fa-solid fa-rotate-left"></i> Cancelar</a>
            </div>
        </div>
    </form>
</div>

<script>
    const input = document.getElementById('input');
    const imagem = document.getElementById('pfp');

    input.addEventListener('change', function() {
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