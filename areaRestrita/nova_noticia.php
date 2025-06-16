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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $texto = $_POST['noticia'];
    $imagem = $_POST['imagem'] ?? null;
    $autor = $_SESSION['usuario_id'];
    $data = date('Y-m-d H:i:s');

    $noticia->criar($titulo, $texto, $imagem, $data, $autor);
    header('Location: ../index.php');
    exit();
}
?>

<form method="POST">
    <h2>Nova Notícia</h2>
    <label>Título:</label><br>
    <input type="text" name="titulo" required><br><br>

    <label>Notícia:</label><br>
    <textarea name="noticia" rows="6" required></textarea><br><br>

    <label>Imagem (URL ou caminho):</label><br>
    <input type="text" name="imagem"><br><br>

    <input type="submit" value="Publicar">
</form>
