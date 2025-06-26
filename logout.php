<?php
session_start();
setcookie('nome_usuario', '', time() - 3600, '/');

session_destroy();
header('Location: index.php');
exit();
