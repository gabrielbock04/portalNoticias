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

    // Somente o autor pode editar
    if ($n['autor'] != $_SESSION['usuario_id']) {
        echo "Você não tem permissão para editar esta notícia.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $texto = $_POST['noticia'];
    $imagem = $_POST['imagem'];

    $noticia->atualizar($id, $titulo, $texto, $imagem);
    header('Location: ../index.php');
    exit();
}
?>

<form method="POST">
    <h2>Editar Notícia</h2>
    <input type="hidden" name="id" value="<?php echo $n['id']; ?>">

    <label>Título:</label><br>
    <input type="text" name="titulo" value="<?php echo $n['titulo']; ?>" required><br><br>

    <label>Notícia:</label><br>
    <textarea name="noticia" rows="6" required><?php echo $n['noticia']; ?></textarea><br><br>

    <label>Imagem:</label><br>
    <input type="text" name="imagem" value="<?php echo $n['imagem']; ?>"><br><br>

    <input type="submit" value="Salvar alterações">
</form>
