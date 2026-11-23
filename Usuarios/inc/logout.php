<?php
// Esse é o logout.php
include("../../config.php");
if (session_status() === PHP_SESSION_NONE) session_start();
session_destroy();
header("Location: " . BASEURL . "index.php");
exit;