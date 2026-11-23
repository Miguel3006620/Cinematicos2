<?php
require_once __DIR__ . '/function.php';
exigir_admin();

$ehPost = ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';

if ($ehPost && adicionar_filme()) {
    flash("Filme cadastrado com sucesso.", 'success');
    redirecionar('filmes/index.php');
}

// Se falhou, mostra o que foi digitado. Senão, formulário vazio.
$f = $ehPost ? dados_filme_post() : [
    'titulo'                  => '',
    'autores'                 => '',
    'estudio'                 => '',
    'data_lancamento_oficial' => '',
    'valor_ingresso'          => '',
    'sinopse'                 => '',
    'categoria'               => '',
    'faixa_etaria'            => '',
];

include(HEADER_TEMPLATE);

$tituloPagina = "Novo filme";
$textoBotao   = "Adicionar filme";
$acao         = "add.php";
$capaAtual    = url_capa(null);

include __DIR__ . '/form.php';

include(FOOTER_TEMPLATE);