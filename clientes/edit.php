<?php
require_once __DIR__ . '/functions.php';
exigir_login();

$cliente = buscar_cliente((int) ($_GET['id'] ?? 0));
if (!$cliente) {
    negar_acesso("Cliente não encontrado.", 'clientes/index.php');
}

$ehPost = ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';

if ($ehPost && atualizar_cliente((int) $cliente['id'])) {
    flash("Cliente atualizado com sucesso.", 'success');
    redirecionar('clientes/index.php');
}

$c = $ehPost ? dados_cliente_post() : $cliente;

include(HEADER_TEMPLATE);

$tituloPagina = "Atualizar cliente";
$textoBotao   = "Salvar";
$acao         = "edit.php?id=" . (int) $cliente['id'];

include __DIR__ . '/form.php';

include(FOOTER_TEMPLATE);