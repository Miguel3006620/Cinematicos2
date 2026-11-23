<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../functions.php';

// Acesso direto por GET volta para o login
exigir_post('Usuarios/inc/login.php');

function falha_login(): void
{
    negar_acesso("Não foi possível entrar. Verifique seu usuário e senha.", 'Usuarios/inc/login.php');
}

$login = trim($_POST['login'] ?? '');
$senha = $_POST['senha'] ?? '';

if ($login === '' || $senha === '') {
    falha_login();
}

try {
    $bd = open_database();
    $stmt = $bd->prepare("SELECT id, nome, user, nivel FROM usuarios WHERE user = ? AND password = ? LIMIT 1");
    $hash = criptografia($senha);
    $stmt->bind_param("ss", $login, $hash);
    $stmt->execute();
    $dados = $stmt->get_result()->fetch_assoc();
    close_database($bd);
} catch (Exception $e) {
    negar_acesso("Não foi possível conectar ao banco de dados.", 'Usuarios/inc/login.php');
}

if (!$dados) {
    falha_login();
}

session_regenerate_id(true);
$_SESSION['id']    = $dados['id'];
$_SESSION['nome']  = $dados['nome'];
$_SESSION['user']  = $dados['user'];
$_SESSION['nivel'] = $dados['nivel'];

flash("Bem vindo, " . e($dados['nome']) . "!", 'info');
redirecionar('index.php');