<?php
require_once __DIR__ . '/functions.php';
exigir_login();

excluir_cliente((int) ($_GET['id'] ?? 0));

redirecionar('clientes/index.php');