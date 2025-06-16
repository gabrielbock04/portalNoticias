<?php
session_start();
include_once '../conexao/config.php';
include_once '../conexao/funcoes.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$db = (new Database())->getConnection();
$noticia = new Noticia($db);

if (isset($_GET['id'])) {
    $n = $noticia->buscarPorId($_GET['id']);

    // Somente o autor pode excluir
    if ($n['autor'] != $_SESSION['usuario_id']) {
        echo "Você não tem permissão para excluir esta notícia.";
        exit();
    }

    $noticia->excluir($_GET['id']);
    header('Location: ../index.php');
    exit();
}
?>
