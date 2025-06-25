<?php
session_start();
if (!isset($_SESSION['usuario_id']) || (!$_SESSION['is_admin'] && !$_SESSION['is_funcionario'])) {
    header('Location: ../index.php');
    exit();
}

include_once '../conexao/config.php';
include_once '../conexao/funcoes.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit();
}

$db = (new Database())->getConnection();
$noticia = new Noticia($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $texto = $_POST['noticia']; // agora com HTML do TinyMCE
    $imagem = $_POST['imagem'] ?? null;
    $autor = $_SESSION['usuario_id'];
    $data = date('Y-m-d H:i:s');

    $noticia->criar($titulo, $texto, $imagem, $data, $autor);
    header('Location: ../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nova Notícia</title>
    <script src="https://cdn.tiny.cloud/1/37ybikexkmn7wucbg1x3kgi89eul0az7uq9v07orofaq4hku/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#noticia',
            plugins: 'image link media lists table code',
            toolbar: 'undo redo | styleselect | bold italic underline | fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | forecolor backcolor | code',
            menubar: false,
            height: 400,
            automatic_uploads: true,
            images_upload_url: 'upload_imagem.php',
            images_upload_handler: function (blobInfo, success, failure) {
                success("data:" + blobInfo.blob().type + ";base64," + blobInfo.base64());
            }
        });
    </script>
</head>
<body>
    <h2>Publicar Nova Notícia</h2>

    <form method="POST">
        <label>Título:</label><br>
        <input type="text" name="titulo" required><br><br>

        <label>Conteúdo:</label><br>
        <textarea id="noticia" name="noticia" rows="10" required></textarea><br><br>

        <label>Imagem principal (URL):</label><br>
        <input type="text" name="imagem"><br><br>

        <input type="submit" value="Publicar">
    </form>
</body>
</html>
