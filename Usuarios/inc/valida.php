<?php
// Esse é o valida.php
include_once __DIR__ . '/../../config.php';
include_once __DIR__ . '/../functions.php';
require_once DBAPI;

function falha_login(): void
{
    $_SESSION['message'] = "Não foi possível se conectar!<br>Verifique seu usuário e senha.";
    $_SESSION['type'] = "danger";
    header("Location: " . BASEURL . "inc/login.php");
    exit;
}

if (empty($_POST['login']) || empty($_POST['senha'])) {
    falha_login();
}

$bd = open_database();
$bd->select_db(DB_NAME);

$login = $_POST['login'];
$senhaHash = criptografia($_POST['senha']);

$stmt = $bd->prepare("SELECT id, nome, user, nivel FROM usuarios WHERE user = ? AND password = ? LIMIT 1");
$stmt->bind_param("ss", $login, $senhaHash);
$stmt->execute();
$dados = $stmt->get_result()->fetch_assoc();

if (!$dados) {
    falha_login();
}

session_regenerate_id(true);
$_SESSION['id']      = $dados['id'];
$_SESSION['nome']    = $dados['nome'];
$_SESSION['user']    = $dados['user'];
$_SESSION['nivel']   = $dados['nivel'];
$_SESSION['message'] = "Bem vindo " . $dados['nome'] . "!";
$_SESSION['type']    = "info";

header("Location: " . BASEURL . "index.php");
exit;