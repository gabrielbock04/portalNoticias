<?php
session_start();
include_once './conexao/config.php';
include_once './conexao/funcoes.php';

$db = (new Database())->getConnection();
$noticia = new Noticia($db);
$comentarioObj = new Comentario($db);

if (isset($_GET['busca']) && !empty(trim($_GET['busca']))) {
    $termo = trim($_GET['busca']);
    $noticias = $noticia->buscarPorTitulo($termo);
} else {
    $noticias = $noticia->listarTodas();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comentar'])) {
    if (isset($_SESSION['usuario_id'])) {
        $noticia_id = $_POST['noticia_id'];
        $comentario = trim($_POST['comentario']);
        if (!empty($comentario)) {
            $comentarioObj->adicionar($noticia_id, $_SESSION['usuario_id'], $comentario);
            header("Location: index.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Página Inicial - Notícias</title>
    <link rel="stylesheet" href="./styles/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Modern+Antiqua&display=swap" rel="stylesheet">
</head>

<body>
    <header class="header">
        <img src="./img/logo.png" alt="logo" class="logo">
        <nav class="header-nav">
            <a href="#" class="active">Notícias</a>
            <a href="#">Fatos Históricos</a>
            <a href="#">Curiosidades</a>
            <a href="#">Comunidade</a>
            <a href="#">Contato</a>
        </nav>
        <div class="header-actions">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                    <a href="./painel_admin.php"><button class="btn btnEntrar" type="button">Painel do Admin</button></a>
                <?php endif; ?>
                <form action="./logout.php" method="post" style="display:inline;">
                    <button class="btnEntrar" type="submit">Sair</button>
                </form>
            <?php else: ?>
                <a href="./login.php"><button class="btn btnEntrar" type="button">Entrar</button></a>
                <a href="./cadastro_usuario.php"><button class="btn btnRegistrar registrar" type="button">Registrar-se</button></a>
            <?php endif; ?>
        </div>

    </header>

    <main class="main-content">
        <div class="section-titulo">ÚLTIMAS NOTÍCIAS</div>

        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 10px;">
            <form method="GET" class="pesquisa-bar-container" style="display: flex; align-items: center;">
                <input class="pesquisa-bar" type="text" name="busca" placeholder="Buscar notícia..." value="<?= isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : '' ?>">
                <button type="submit" style="background: none; border: none; font-size:2.0rem; color:#888;">🔍</button>
            </form>

            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                <a href="./areaRestrita/nova_noticia.php" class="btn">+ Nova Notícia</a>
            <?php endif; ?>
        </div>

        <div class="filtros">
            <button class="filtro-btn active">New</button>
            <button class="filtro-btn">Mais recentes</button>
            <button class="filtro-btn">Mais antigas</button>
            <button class="filtro-btn" disabled>Rating</button>
        </div>

        <div class="cards-grid">
            <?php foreach ($noticias as $n): ?>
                <div class="card">
                    <?php if ($n['imagem']): ?>
                        <div class="card-img">
                            <img src="<?php echo htmlspecialchars($n['imagem']); ?>" alt="Imagem" style="width:100%;height:100%;object-fit:cover;border-radius:6px;">
                        </div>
                    <?php else: ?>
                        <div class="card-img">&#128247;</div>
                    <?php endif; ?>

                    <a href="noticia.php?id=<?php echo $n['id']; ?>" class="card-title" style="text-decoration:none; color:inherit;">
                        <?php echo htmlspecialchars($n['titulo']); ?>
                    </a>

                    <div style="font-size:1.9rem;color:#666;margin-bottom:8px;">
                        <?php echo date('d/m/Y H:i', strtotime($n['data'])); ?>

                    </div>
                    <div style="margin-bottom:10px;">
                        <?php echo nl2br(htmlspecialchars(substr($n['noticia'], 0, 200))); ?>...
                    </div>

                    <?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $n['autor']): ?>
                        <a href="./areaRestrita/editar_noticia.php?id=<?php echo $n['id']; ?>" class="btn btnEntrar" style="margin-right:6px;">Editar</a>
                        <a href="./areaRestrita/excluir_noticia.php?id=<?php echo $n['id']; ?>" class="btn btnEntrar" onclick="return confirm('Excluir esta notícia?')">Excluir</a>
                    <?php endif; ?>


                    <?php $comentarios = $comentarioObj->listarPorNoticia($n['id']); ?>
                    <div class="comentarios" style="margin-top:15px;">
                        <h4>Comentários:</h4>

                        <?php if ($comentarios): ?>
                            <?php foreach ($comentarios as $c): ?>
                                <div style="background:#f2f2f2; padding:8px; border-radius:6px; margin-bottom:5px;">
                                    <strong><?= htmlspecialchars($c['nome']) ?>:</strong><br>
                                    <p style="margin:4px 0;"><?= nl2br(htmlspecialchars($c['comentario'])) ?></p>
                                    <small><?= date('d/m/Y H:i', strtotime($c['data'])) ?></small>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="color:gray;">Nenhum comentário ainda.</p>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <form method="post" style="margin-top:10px;">
                                <input type="hidden" name="noticia_id" value="<?= $n['id'] ?>">
                                <textarea name="comentario" rows="3" placeholder="Escreva seu comentário..." required style="width:100%; padding:8px;"></textarea><br>
                                <button type="submit" name="comentar" class="btn btnEntrar">Comentar</button>
                            </form>
                        <?php else: ?>
                            <p style="font-style: italic;"><a href="login.php">Faça login</a> para comentar.</p>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>

</html>