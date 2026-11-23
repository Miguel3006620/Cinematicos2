<?php
//esse é o edit.php
include("functions.php");

exigir_login();
if (isset($_GET['id'])) {
    $alvo = find("usuarios", $_GET['id']);
    if (!$alvo || !pode_editar_usuario($alvo)) {
        negar_acesso("Você só pode editar outros clientes.");
    }
}

edit();
include(HEADER_TEMPLATE);
?>