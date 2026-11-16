<?php
// Esse é o Cadastro.php — fica em usuarios/inc/
if (!isset($_SESSION)) session_start();
include_once __DIR__ . '/../../config.php';
include_once __DIR__ . '/../functions.php';

if (!add()) {
    header("Location: ../add.php");
    exit;
}

$_SESSION['message'] = "Cadastro realizado com sucesso! Faça seu login.";
$_SESSION['type'] = "success";
header("Location: login.php");
exit;