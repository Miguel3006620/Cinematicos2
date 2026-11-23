<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../functions.php';

// Acesso direto por GET volta para o formulário
exigir_post('Usuarios/add.php');

if (!add()) {
    redirecionar('Usuarios/add.php');
}

flash("Cadastro realizado com sucesso! Faça seu login.", 'success');
redirecionar('Usuarios/inc/login.php');