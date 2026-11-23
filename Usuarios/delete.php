<?php
require_once __DIR__ . '/functions.php';
exigir_admin();

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    flash("ID inválido.");
} elseif ($id === (int) ($_SESSION['id'] ?? 0)) {
    flash("Você não pode excluir a própria conta enquanto estiver logado.");
} else {
    $alvo = buscar_usuario($id);

    if (!$alvo) {
        flash("Usuário não encontrado.");
    } else {
        clear_messages();
        remove('usuarios', $id);

        // Apaga a foto só se a exclusão deu certo (nunca apaga a foto padrão)
        if (($_SESSION['type'] ?? '') === 'success'
            && !empty($alvo['foto'])
            && $alvo['foto'] !== FOTO_PADRAO) {
            @unlink(__DIR__ . "/imagens/" . basename($alvo['foto']));
        }
    }
}

redirecionar('Usuarios/index.php');