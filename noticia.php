<?php
session_start();
include_once './conexao/config.php';
include_once './conexao/funcoes.php';

if (!isset($_GET['id'])) {
    echo "Notícia não encontrada.";
    exit();
}

$db = (new Database())->getConnection();
$noticiaObj = new Noticia($db);
$comentarioObj = new Comentario($db);

$noticia = $noticiaObj->buscarPorId($_GET['id']);

if (!$noticia) {
    echo "Notícia não encontrada.";
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comentar']) && isset($_SESSION['usuario_id'])) {
    $comentario = trim($_POST['comentario']);
    if (!empty($comentario)) {
        $comentarioObj->adicionar($_GET['id'], $_SESSION['usuario_id'], $comentario);
        header("Location: noticia.php?id=" . $_GET['id']);
        exit();
    }
}

$comentarios = $comentarioObj->listarPorNoticia($noticia['id']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($noticia['titulo']) ?></title>
    <link rel="stylesheet" href="./styles/styles.css">
</head>
<body>
    <header class="header">
        <img src="./img/logo.png" alt="logo" class="logo">
        <nav class="header-nav">
            <a href="index.php" class="active">Notícias</a>
            <a href="#">Fatos Históricos</a>
            <a href="#">Curiosidades</a>
            <a href="#">Comunidade</a>
            <a href="#">Contato</a>
        </nav>
        <div class="header-actions">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <form action="./logout.php" method="post" style="display:inline;">
                    <button class="btnEntrar" type="submit">Sair</button>
                </form>
            <?php else: ?>
                <a href="./login.php"><button class="btn btnEntrar" type="button">Entrar</button></a>
                <a href="./cadastro_usuario.php"><button class="btn btnRegistrar registrar" type="button">Registrar-se</button></a>
            <?php endif; ?>
        </div>
    </header>

    
    <main class="main-content" style="max-width: 800px; margin: auto;">
        <h1><?= htmlspecialchars($noticia['titulo']) ?></h1>
        <p><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($noticia['data'])) ?></p>

        <?php if ($noticia['imagem']): ?>
            <img src="<?= htmlspecialchars($noticia['imagem']) ?>" alt="Imagem" style="max-width:100%; margin: 20px 0;">
        <?php endif; ?>

        <p style="font-size: 1.2rem;"><?= nl2br(htmlspecialchars($noticia['noticia'])) ?></p>

        <hr>
        <h3>Comentários:</h3>

        <?php if ($comentarios): ?>
            <?php foreach ($comentarios as $c): ?>
                <div style="background:#f2f2f2;padding:10px;margin-bottom:8px;border-radius:6px;">
                    <strong><?= htmlspecialchars($c['nome']) ?>:</strong>
                    <p><?= nl2br(htmlspecialchars($c['comentario'])) ?></p>
                    <small><?= date('d/m/Y H:i', strtotime($c['data'])) ?></small>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color:gray;">Nenhum comentário ainda.</p>
        <?php endif; ?>

        <?php if (isset($_SESSION['usuario_id'])): ?>
            <form method="post" style="margin-top:10px;">
                <textarea name="comentario" rows="3" required placeholder="Escreva um comentário..." style="width:100%;padding:8px;"></textarea><br>
                <button type="submit" name="comentar" class="btn btnEntrar">Comentar</button>
            </form>
        <?php else: ?>
            <p><a href="login.php">Faça login</a> para comentar.</p>
        <?php endif; ?>
    </main>
</body>
</html>
