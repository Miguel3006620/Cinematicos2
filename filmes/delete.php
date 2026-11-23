<?php
require_once __DIR__ . '/function.php';
exigir_admin();

excluir_filme((int) ($_GET['id'] ?? 0));

redirecionar('filmes/index.php');