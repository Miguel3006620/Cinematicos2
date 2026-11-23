<?php
require_once __DIR__ . '/function.php';
exigir_admin();

$filme = buscar_filme((int) ($_GET['id'] ?? 0));
if (!$filme) {
    negar_acesso("Filme não encontrado.", 'filmes/index.php');
}

$ehPost = ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';

if ($ehPost && atualizar_filme((int) $filme['id'])) {
    flash("Filme atualizado com sucesso.", 'success');
    redirecionar('filmes/index.php');
}

// Se falhou, mostra o que foi digitado. Senão, os dados atuais.
$f = $ehPost ? dados_filme_post() : [
    'titulo'                  => $filme['titulo'],
    'autores'                 => $filme['autores'],
    'estudio'                 => $filme['estudio'],
    'data_lancamento_oficial' => formatar_data($filme['data_lancamento_oficial'], 'Y-m-d'),
    'valor_ingresso'          => $filme['valor_ingresso'],
    'sinopse'                 => $filme['sinopse'],
    'categoria'               => $filme['categoria'],
    'faixa_etaria'            => $filme['faixa_etaria'],
];

include(HEADER_TEMPLATE);

$tituloPagina = "Atualizar filme";
$textoBotao   = "Salvar";
$acao         = "edit.php?id=" . (int) $filme['id'];
$capaAtual    = url_capa($filme['capa']);

include __DIR__ . '/form.php';

include(FOOTER_TEMPLATE);