<?php
//esse é o delete.php
include "functions.php";
exigir_admin();

if (isset($_GET['id'])) {
    try {
        $usuario = find("usuarios", $_GET['id']);
        delete($_GET['id']); // redireciona para index.php
        if (!empty($usuario['foto'])) {
            @unlink(__DIR__ . "/imagens/" . $usuario['foto']);
        }
        exit;
    } catch (Exception $e) {
        $_SESSION['message'] = "Não foi possível realizar a operação: " . $e->getMessage();
        $_SESSION['type'] = "danger";
    }
}
header("Location: index.php");
exit;