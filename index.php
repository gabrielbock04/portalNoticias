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
    <link rel="stylesheet" href="./styles/styles.css">
</head>

<body>
    <header class="header" style="background-color: #000; display: flex; align-items: center; padding: 5px 40px;">
        <img src="./img/logo.png" alt="logo" style="height:100px; margin-right: 30px;">
        <nav class="header-nav">
            <a href="#" style="margin-right: 20px; color: #fff;" class="active">Notícias</a>
            <a href="#" style="margin-right: 20px; color: #fff;">Fatos Históricos</a>
            <a href="#" style="margin-right: 20px; color: #fff;">Curiosidades</a>
            <a href="#" style="margin-right: 20px; color: #fff;">Comunidade</a>
            <a href="#" style="margin-right: 20px; color: #fff;">Contato</a>
        </nav>

        <div class="header-actions">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <form action="./logout.php" method="post" style="display:inline;">
                    <button class="secondary" type="submit">Sair</button>
                </form>
            <?php else: ?>
                <a href="./login.php"><button class="secondary">Entrar</button></a>
                <a href="./cadastro_usuario.php"><button>Registrar-se</button></a>
            <?php endif; ?>
        </div>
    </header>
    </header>

    <main class="main-content">
        <div class="section-title">ÚLTIMAS NOTÍCIAS</div>
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 10px;">
            <div class="search-bar-container">
                <input class="search-bar" type="text" placeholder="Buscar notícia...">
                <span style="font-size:1.1rem; color:#888;">&#128269;</span>
            </div>
            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                <a href="./areaRestrita/nova_noticia.php" class="btn">+ Nova Notícia</a>
            <?php endif; ?>

        </div>
        <div class="filters">
            <button class="filter-btn active">New</button>
            <button class="filter-btn">Mais recentes</button>
            <button class="filter-btn">Mais antigas</button>
            <button class="filter-btn" disabled>Rating</button>
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
                    <div class="card-title"><?php echo htmlspecialchars($n['titulo']); ?></div>
                    <div style="font-size:0.95rem;color:#666;margin-bottom:8px;">
                        <strong>Data:</strong> <?php echo htmlspecialchars($n['data']); ?>
                    </div>
                    <div style="margin-bottom:10px;">
                        <?php echo nl2br(htmlspecialchars(substr($n['noticia'], 0, 200))); ?>...
                    </div>
                    <?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $n['autor']): ?>
                        <a href="./areaRestrita/editar_noticia.php?id=<?php echo $n['id']; ?>" class="btn secondary" style="margin-right:6px;">Editar</a>
                        <a href="./areaRestrita/excluir_noticia.php?id=<?php echo $n['id']; ?>" class="btn secondary" onclick="return confirm('Excluir esta notícia?')">Excluir</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>

</html>