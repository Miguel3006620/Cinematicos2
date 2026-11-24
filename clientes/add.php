<?php
require_once __DIR__ . '/functions.php';
exigir_login();

$ehPost = ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';

if ($ehPost && adicionar_cliente()) {
    flash("Cliente cadastrado com sucesso.", 'success');
    redirecionar('clientes/index.php');
}

$c = $ehPost ? dados_cliente_post() : [
    'nome' => '', 'email' => '', 'telefone' => '', 'data_nascimento' => '', 'cidade' => '',
];

include(HEADER_TEMPLATE);

$tituloPagina = "Novo cliente";
$textoBotao   = "Cadastrar cliente";
$acao         = "add.php";

include __DIR__ . '/form.php';

include(FOOTER_TEMPLATE);