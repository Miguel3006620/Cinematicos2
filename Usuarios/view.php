<?php
//esse é o view.php
require_once('functions.php');
exigir_login();
view($_GET['id']);
include(HEADER_TEMPLATE);
?>