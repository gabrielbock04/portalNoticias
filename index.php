<?php
session_start();
include_once './conexao/config.php';
include_once './conexao/funcoes.php';

$db = (new Database())->getConnection();
$noticia = new Noticia($db);
$noticias = $noticia->listarTodas();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Página Inicial - Notícias</title>
</head>
<body>
    <h1>Notícias</h1>

    <?php if (isset($_SESSION['usuario_id'])): ?>
        <p><a href="./areaRestrita/nova_noticia.php">+ Nova Notícia</a></p>
    <?php endif; ?>

    <?php foreach ($noticias as $n): ?>
        <div style="border-bottom:1px solid #ccc; padding:10px 0;">
            <h2><?php echo htmlspecialchars($n['titulo']); ?></h2>
            <p><strong>Data:</strong> <?php echo $n['data']; ?></p>
            <?php if ($n['imagem']): ?>
                <img src="<?php echo $n['imagem']; ?>" alt="Imagem" width="300"><br>
            <?php endif; ?>
            <p><?php echo nl2br(substr($n['noticia'], 0, 200)); ?>...</p>

            <?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $n['autor']): ?>
                <a href="./areaRestrita/editar_noticia.php?id=<?php echo $n['id']; ?>">Editar</a> |
                <a href="./areaRestrita/excluir_noticia.php?id=<?php echo $n['id']; ?>" onclick="return confirm('Excluir esta notícia?')">Excluir</a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</body>
</html>
