<?php
require_once __DIR__ . '/../config.php';
require_once DBAPI;

const EXTENSOES_CAPA = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

/* ---------- Utilitários ---------- */

function formatar_data(?string $data, string $formato = 'd/m/Y'): string
{
    if (empty($data)) return '';
    $dt = DateTime::createFromFormat('Y-m-d', $data, new DateTimeZone("America/Sao_Paulo"));
    return $dt ? $dt->format($formato) : '';
}

function url_capa(?string $capa): string
{
    return BASEURL . (!empty($capa) ? 'imgs/' . $capa : 'imagens_site/sem_imagem.jpg');
}

/* ---------- Consultas ---------- */

function listar_filmes(): ?array
{
    return find_all("filmes");
}

function buscar_filme(int $id): ?array
{
    return $id > 0 ? (find("filmes", $id) ?: null) : null;
}

/* ---------- Formulário ---------- */

// Lê e normaliza os dados enviados pelo formulário
function dados_filme_post(): array
{
    $f = $_POST['filme'] ?? [];
    if (!is_array($f)) $f = [];

    $valor = str_replace(',', '.', trim((string) ($f['valor_ingresso'] ?? '0')));

    return [
        'titulo'                  => trim((string) ($f['titulo'] ?? '')),
        'autores'                 => trim((string) ($f['autores'] ?? '')),
        'estudio'                 => trim((string) ($f['estudio'] ?? '')),
        'data_lancamento_oficial' => trim((string) ($f['data_lancamento_oficial'] ?? '')),
        'valor_ingresso'          => number_format((float) $valor, 2, '.', ''),
        'sinopse'                 => trim((string) ($f['sinopse'] ?? '')),
        'categoria'               => trim((string) ($f['categoria'] ?? '')),
        'faixa_etaria'            => (int) ($f['faixa_etaria'] ?? 0),
    ];
}

// Retorna a mensagem do primeiro erro encontrado, ou null se estiver tudo certo
function erro_validacao(array $d): ?string
{
    if ($d['titulo'] === '')                                   return "Informe o título do filme.";
    if (mb_strlen($d['titulo']) > 140)                         return "O título pode ter no máximo 140 caracteres.";
    if (mb_strlen($d['autores']) > 150)                        return "Diretor(es): no máximo 150 caracteres.";
    if (mb_strlen($d['estudio']) > 100)                        return "Estúdio: no máximo 100 caracteres.";
    if (mb_strlen($d['categoria']) > 100)                      return "Gêneros: no máximo 100 caracteres.";
    if (mb_strlen($d['sinopse']) > 400)                        return "A sinopse pode ter no máximo 400 caracteres.";
    if (!DateTime::createFromFormat('Y-m-d', $d['data_lancamento_oficial'])) {
        return "Informe uma data de lançamento válida.";
    }
    if ((float) $d['valor_ingresso'] < 0)                      return "O valor do ingresso não pode ser negativo.";
    if ($d['faixa_etaria'] < 0 || $d['faixa_etaria'] > 99)     return "A faixa etária deve estar entre 0 e 99.";

    return null;
}

// Valida e salva a capa em imgs/. Retorna o nome do arquivo ou null (com mensagem de erro).
function salvar_capa(array $arquivo): ?string
{
    if ($arquivo['error'] !== UPLOAD_ERR_OK) {
        flash("Não foi possível enviar a capa.");
        return null;
    }

    if ($arquivo['size'] > 5 * 1024 * 1024) {
        flash("A capa é muito grande (máximo 5 MB).");
        return null;
    }

    $ext = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, EXTENSOES_CAPA, true)) {
        flash("A capa deve ser JPG, JPEG, PNG, GIF ou WEBP.");
        return null;
    }

    if (@getimagesize($arquivo['tmp_name']) === false) {
        flash("O arquivo enviado não é uma imagem válida.");
        return null;
    }

    $nome = uniqid() . "." . $ext;

    if (!move_uploaded_file($arquivo['tmp_name'], __DIR__ . '/../imgs/' . $nome)) {
        flash("Não foi possível salvar a capa no servidor.");
        return null;
    }

    return $nome;
}

/* ---------- Operações ---------- */

function adicionar_filme(): bool
{
    $dados = dados_filme_post();

    if ($erro = erro_validacao($dados)) {
        flash($erro);
        return false;
    }

    if (empty($_FILES['capa']['name'])) {
        flash("Selecione a capa do filme.");
        return false;
    }

    $capa = salvar_capa($_FILES['capa']);
    if ($capa === null) {
        return false;
    }

    $dados['capa'] = $capa;
    save('filmes', $dados);

    return ($_SESSION['type'] ?? '') === 'success';
}

function atualizar_filme(int $id): bool
{
    $dados = dados_filme_post();

    if ($erro = erro_validacao($dados)) {
        flash($erro);
        return false;
    }

    // Capa só muda se uma nova for enviada
    if (!empty($_FILES['capa']['name'])) {
        $capa = salvar_capa($_FILES['capa']);
        if ($capa === null) {
            return false;
        }
        $dados['capa'] = $capa;
    }

    update('filmes', $id, $dados);

    return ($_SESSION['type'] ?? '') === 'success';
}

function excluir_filme(int $id): void
{
    $filme = buscar_filme($id);

    if (!$filme) {
        flash("Filme não encontrado.");
        return;
    }

    clear_messages();
    remove('filmes', $id);

    if (($_SESSION['type'] ?? '') === 'success' && !empty($filme['capa'])) {
        @unlink(__DIR__ . '/../imgs/' . basename($filme['capa']));
    }
}