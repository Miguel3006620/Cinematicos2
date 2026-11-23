<?php
// auth.php — regras de permissão centralizadas
if (session_status() === PHP_SESSION_NONE) session_start();

const NIVEL_ADMIN   = 'admin';
const NIVEL_USUARIO = 'usuario';

function usuario_logado(): bool
{
    return !empty($_SESSION['id'] ?? null);
}

function nivel_atual(): ?string
{
    return $_SESSION['nivel'] ?? null;
}

function is_admin(): bool
{
    return usuario_logado() && nivel_atual() === NIVEL_ADMIN;
}

function negar_acesso(string $msg = "Você não tem permissão para acessar esse recurso!"): void
{
    $_SESSION['message'] = $msg;
    $_SESSION['type'] = "danger";
    header("Location: " . BASEURL . "index.php");
    exit;
}

function exigir_login(): void
{
    if (!usuario_logado()) {
        negar_acesso("Você precisa estar logado para acessar esse recurso!");
    }
}

function exigir_admin(): void
{
    exigir_login();
    if (!is_admin()) negar_acesso();
}

/* ---- Usuários ---- */
function pode_ver_usuarios(): bool      { return usuario_logado(); }
function pode_adicionar_usuario(): bool { return is_admin(); }
function pode_excluir_usuario(): bool   { return is_admin(); }

// Admin edita qualquer um. Cliente edita só registros de cliente (inclusive o próprio), nunca admin.
function pode_editar_usuario(array $alvo): bool
{
    if (is_admin()) return true;
    return usuario_logado() && ($alvo['nivel'] ?? '') === NIVEL_USUARIO;
}

/* ---- Filmes ---- */
function pode_ver_filmes(): bool        { return usuario_logado(); }
function pode_adicionar_filme(): bool   { return is_admin(); }