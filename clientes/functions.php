<?php
require_once __DIR__ . '/../config.php';
require_once DBAPI;

/* ---------- Utilitários ---------- */

function data_br(?string $data): string
{
    if (empty($data)) return '';
    $dt = DateTime::createFromFormat('Y-m-d', $data);
    return $dt ? $dt->format('d/m/Y') : '';
}

/* ---------- Consultas ---------- */

function listar_clientes(): ?array
{
    return find_all("clientes");
}

function buscar_cliente(int $id): ?array
{
    return $id > 0 ? (find("clientes", $id) ?: null) : null;
}

/* ---------- Formulário ---------- */

function dados_cliente_post(): array
{
    $c = $_POST['cliente'] ?? [];
    if (!is_array($c)) $c = [];

    return [
        'nome'            => trim((string) ($c['nome'] ?? '')),
        'email'           => trim((string) ($c['email'] ?? '')),
        'telefone'        => trim((string) ($c['telefone'] ?? '')),
        'data_nascimento' => trim((string) ($c['data_nascimento'] ?? '')),
        'cidade'          => trim((string) ($c['cidade'] ?? '')),
    ];
}

// Retorna a mensagem do primeiro erro, ou null se estiver tudo certo
function erro_validacao_cliente(array $d): ?string
{
    if ($d['nome'] === '')                        return "Informe o nome do cliente.";
    if (mb_strlen($d['nome']) > 100)              return "O nome pode ter no máximo 100 caracteres.";
    if (!filter_var($d['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($d['email']) > 120) {
        return "Informe um e-mail válido.";
    }
    if ($d['telefone'] === '' || mb_strlen($d['telefone']) > 20) {
        return "Informe um telefone (máximo 20 caracteres).";
    }
    if (!DateTime::createFromFormat('Y-m-d', $d['data_nascimento'])) {
        return "Informe uma data de nascimento válida.";
    }
    if (mb_strlen($d['cidade']) > 80)             return "A cidade pode ter no máximo 80 caracteres.";

    return null;
}

/* ---------- Operações ---------- */

function adicionar_cliente(): bool
{
    $dados = dados_cliente_post();

    if ($erro = erro_validacao_cliente($dados)) {
        flash($erro);
        return false;
    }

    save('clientes', $dados);

    return ($_SESSION['type'] ?? '') === 'success';
}

function atualizar_cliente(int $id): bool
{
    $dados = dados_cliente_post();

    if ($erro = erro_validacao_cliente($dados)) {
        flash($erro);
        return false;
    }

    update('clientes', $id, $dados);

    return ($_SESSION['type'] ?? '') === 'success';
}

function excluir_cliente(int $id): void
{
    if (!buscar_cliente($id)) {
        flash("Cliente não encontrado.");
        return;
    }

    remove('clientes', $id);
}