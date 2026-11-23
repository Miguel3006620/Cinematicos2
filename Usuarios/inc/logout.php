<?php
require_once __DIR__ . '/../../config.php';

session_unset();
session_destroy();
session_start();

flash("Você saiu da conta.", 'info');
redirecionar('index.php');