<?php
// auth.php: sessão, permissões e mensagens. Carregado pelo config.php.
if (session_status() === PHP_SESSION_NONE) session_start();

const NIVEL_ADMIN   = 'admin';
const NIVEL_USUARIO = 'usuario';

/* ---------- Utilitários ---------- */

// Escapa texto para HTML
function e($valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

/* ---------- Sessão ---------- */

function usuario_logado(): bool
{
    return !empty($_SESSION['id']);
}

function is_admin(): bool
{
    return usuario_logado() && ($_SESSION['nivel'] ?? null) === NIVEL_ADMIN;
}

/* ---------- Mensagens ---------- */

function flash(string $mensagem, string $tipo = 'danger'): void
{
    $_SESSION['message'] = $mensagem;
    $_SESSION['type'] = $tipo;
}

function clear_messages(): void
{
    $_SESSION['message'] = null;
    $_SESSION['type'] = null;
}

// Mostra a mensagem guardada na sessão (uma única vez)
function mostrar_mensagem(): void
{
    if (empty($_SESSION['message'])) return;

    $tipo = e($_SESSION['type'] ?? 'info');
    echo '<div class="alert alert-' . $tipo . ' alert-dismissible fade show mt-3" role="alert">'
        . $_SESSION['message']
        . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>'
        . '</div>';

    clear_messages();
}

/* ---------- Redirecionamentos ---------- */

function redirecionar(string $caminho): void
{
    header("Location: " . BASEURL . $caminho);
    exit;
}

function negar_acesso(string $mensagem, string $destino = 'index.php'): void
{
    flash($mensagem, 'danger');
    redirecionar($destino);
}

/* ---------- Verificações de acesso (use no topo de cada página) ---------- */

// Visitante é enviado para o login
function exigir_login(): void
{
    if (!usuario_logado()) {
        flash("Faça login para acessar esta página.", 'warning');
        redirecionar('Usuarios/inc/login.php');
    }
}

// Só admin. Visitante vai ao login; cliente volta ao início com aviso.
function exigir_admin(): void
{
    exigir_login();
    if (!is_admin()) {
        negar_acesso("Apenas administradores podem acessar esta página.");
    }
}

// Arquivos que só processam dados (POST). Acesso direto pela URL volta para o destino.
function exigir_post(string $destino): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        redirecionar($destino);
    }
}

// Login: quem já está logado não precisa ver a tela
function redirecionar_se_logado(): void
{
    if (usuario_logado()) {
        redirecionar('index.php');
    }
}

/* ---------- Permissões ---------- */

// Usuários
function pode_ver_usuarios(): bool      { return usuario_logado(); }
function pode_adicionar_usuario(): bool { return is_admin(); }
function pode_excluir_usuario(): bool   { return is_admin(); }

// Admin edita qualquer um. Cliente edita só clientes (inclusive a si mesmo), nunca admins.
function pode_editar_usuario(array $alvo): bool
{
    if (is_admin()) return true;
    return usuario_logado() && ($alvo['nivel'] ?? '') === NIVEL_USUARIO;
}

// Filmes: cliente vê. Só admin cria, edita e exclui.
function pode_ver_filmes(): bool      { return usuario_logado(); }
function pode_adicionar_filme(): bool { return is_admin(); }
function pode_editar_filme(): bool    { return is_admin(); }
function pode_excluir_filme(): bool   { return is_admin(); }