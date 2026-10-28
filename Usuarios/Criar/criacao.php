<?php
// Esse é o login.php
include('../../config.php');
include(DBAPI);
include(HEADER_TEMPLATE);
?>

<div id="actions" class="mt-5 mb-5 m2">
    <form action="valida.php" method="post" style="margin: 2%" enctype="multipart/form-data">
        <div class="row">

            <div class="form-control mb-4 d-flex flex-column align-items-center justify-content-center">
                <img src="../imagens/usuario-generico.jpg" id="pfp" class="mb-4 rounded-circle" style="height: 250px; width: 250px; border: 1px solid gray; clear: both;">
                <input type="file" style="display:none;" id="input" name="foto">
                <label for="input" class="btn btn-light" style="border: 1px solid gray;"> Selecionar sua foto de perfil</label>
            </div>


            <label for="apelido">Apelido</label>
            <input type="text" class="form-control mb-2" id="apelido" placeholder="seu apelido" name="nome">

            <label for="log">Usuário</label>
            <input type="text" class="form-control mb-2" id="log" placeholder="nome de usuário" name="login">

            <label for="apelido">Apelido</label>
            <input type="password" class="form-control mb-3" id="pass" placeholder="sua senha" name="senha">

            <!-- Submit button -->
            <div class="col-12 mb-2">
                <button type="submit" class="btn btn-secondary btn-block mb-4"><i class="fa-solid fa-user-check"></i>
                    Cadastrar</button>
                <a href="<?php echo BASEURL; ?>" class="btn btn-light btn-block mb-4"><i
                        class="fa-solid fa-rotate-left"></i> Cancelar</a>
            </div>
        </div>
    </form>
</div>

<Script>
    const input = document.getElementById('input');
    const imagem = document.getElementById('pfp');

    input.addEventListener('change', function() {
        if (input.files && input.files[0]) {
            const arquivo = input.files[0];

            const urlTemporaria = URL.createObjectURL(arquivo);
            imagem.src = urlTemporaria;

            imagem.style.display = 'block';
        }
    });
</Script>
<?php include(FOOTER_TEMPLATE); ?>