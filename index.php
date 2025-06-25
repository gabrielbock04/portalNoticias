<?php
session_start();

include_once './conexao/config.php';
include_once './conexao/funcoes.php';


$db = (new Database())->getConnection();
$noticia = new Noticia($db);

if (isset($_GET['busca']) && !empty(trim($_GET['busca']))) {
    $termo = trim($_GET['busca']);
    $noticias = $noticia->buscarPorTitulo($termo); // função personalizada
} else {
    $noticias = $noticia->listarTodas();
}
?>
<?php
if (isset($_COOKIE['nome_usuario'])) {
    echo "Bem-vindo de volta, " . htmlspecialchars($_COOKIE['nome_usuario']) . "!";
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Portal de Notícias</title>
    <link rel="stylesheet" href="./styles/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Modern+Antiqua&display=swap" rel="stylesheet">
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: #fff;
            box-sizing: border-box;
            width: 100%;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        .header {
            background: rgb(88, 55, 33);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 48px;
            height: 96px;
        }

        .logo {
            width: 205px;
            height: 100px;
        }

        .header-nav {
            display: flex;
            gap: 32px;
        }

        .header-nav a {
            font-size: 1.4rem;
            font-family: 'Modern Antiqua', serif;
            color: #fff;
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 10px;
            transition: background 0.2s;
        }

        .header-nav a.active,
        .header-nav a:hover {
            background: #7a4a2e;
            color: #fff;
        }

        .btnEntrar,
        .btnRegistrar {
            font-family: 'Modern Antiqua', serif;
        }

        .hero-section {
            display: flex;
            background: #5b3323 url('./img/papiroHome.png') center center no-repeat;
            background-size: cover;
            color: #fff;
            min-height: 520px;
            align-items: stretch;
            width: 100%;
            font-family: 'Modern Antiqua', serif;
            position: relative;
            z-index: 1;
        }

        .hero-images {
            display: flex;
            flex-direction: column;
            gap: 24px;
            padding: 48px 0 48px 48px;
        }

        .hero-images>div {
            display: flex;
            gap: 24px;
        }

        .hero-images img {
            width: 180px;
            height: 180px;
            object-fit: cover;
            border-radius: 24px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            background: #fff;
        }

        .hero-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 64px;
        }

        .hero-content h1 {
            font-size: 4.2rem;
            font-weight: 400;
            margin-bottom: 32px;
            color: #fff;
        }

        .hero-content p {
            font-size: 1.6rem;
            margin-bottom: 32px;
            color: #f3e6e0;
            line-height: 1.5;
        }

        .hero-content a {
            background: #fff;
            color: #7a4a2e;
            padding: 14px 40px;
            border-radius: 24px;
            font-size: 1.2rem;
            text-decoration: none;
            font-weight: bold;
            width: fit-content;
            font-family: 'Modern Antiqua', serif;
            margin-top: 12px;
            transition: background 0.2s;
        }

        .hero-content a:hover {
            background: #7a4a2e;
            color: #fff;
        }

        .main-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 48px 32px;
        }

        @media (max-width: 1100px) {
            .hero-section {
                flex-direction: column;
                align-items: center;
                min-height: unset;
            }

            .hero-images {
                flex-direction: row;
                padding: 24px 0 0 0;
                gap: 12px;
            }

            .hero-images>div {
                flex-direction: column;
                gap: 12px;
            }

            .hero-images img {
                width: 110px;
                height: 110px;
            }

            .hero-content {
                padding: 32px;
            }

            .hero-content h1 {
                font-size: 2.2rem;
            }

            .hero-content p {
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div style="display: flex; align-items: center; gap: 24px;">
            <img src="./img/logo.png" alt="logo" class="logo">
        </div>
        <nav class="header-nav">
            <a href="#home" class="active">Seções</a>
            <a href="#noticias">Notícias</a>
            <a href="#contato">Contato</a>
            <a href="#sobre">Sobre</a>
        </nav>
        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
            <a href="./areaRestrita/nova_noticia.php" class="btn" style="background:#7a4a2e; color:#fff; border-radius:18px; padding:8px 24px; text-decoration:none;">+ Nova Notícia</a>
        <?php endif; ?>
        <?php if (isset($_SESSION['usuario_id'])): ?>
            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                <a href="painel_admin.php" style="background:#7a4a2e; color:#fff; border-radius:18px; padding:8px 24px; text-decoration:none; font-weight:bold;">Painel do Admin</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="./login.php" class="btn btnEntrar" style="background:#7a4a2e; color:#fff; border-radius:18px; padding:10px 28px; font-size:1.1rem; margin-right:10px; text-decoration:none;">Entrar</a>
            <a href="./cadastro_usuario.php" class="btn btnRegistrar registrar" style="background:#fff; color:#7a4a2e; border-radius:18px; padding:10px 28px; font-size:1.1rem; text-decoration:none;">Registrar-se</a>
        <?php endif; ?>
        <div>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <form action="./logout.php" method="post" style="display:inline;">
                    <button class="btnEntrar" type="submit" style="background:#7a4a2e; color:#fff; border:none; border-radius:18px; padding:10px 28px; font-size:1.1rem;">Sair</button>
                </form>
            <?php endif; ?>
        </div>
    </header>


    <section id="home" class="hero-section" style="display: flex; background:rgb(128, 75, 48); color: #fff; min-height: 300px; width: 100%; font-family: 'Modern Antiqua', serif;">
        <div class="hero-images"
            style="display: flex; flex-direction: column; gap: 50px; padding: 65px 0 80px 80px;
        position: relative;
        background: url('./img/papiroHome.png') center center no-repeat;
        background-size: cover; 
        width: 490px;
        height: 489px;
        margin-left: 20px;">
            <div style="display: flex; gap: 50px;">
                <img id="carrossel-jornal"
                    src="./img/jornal1.jpeg"
                    alt="Jornal antigo"
                    style="width: 420px; margin-top: -1px; margin-left: -10px; height: 505px; object-fit: cover; border-radius: 24px; transition: opacity 0.5s;">
            </div>
            <script>
                // Caminhos das imagens de jornais
                const imagensJornais = [
                    './img/jornal1.jpeg',
                    './img/jornal2.jpeg',
                    // './img/jornal3.jpg',
                    // './img/jornal4.jpg',
                    // './img/jornal5.jpg'
                ];
                let idxJornal = 0;
                const imgJornal = document.getElementById('carrossel-jornal');
                setInterval(() => {
                    idxJornal = (idxJornal + 1) % imagensJornais.length;
                    imgJornal.style.opacity = 0;
                    setTimeout(() => {
                        imgJornal.src = imagensJornais[idxJornal];
                        imgJornal.style.opacity = 1;
                    }, 400);
                }, 5000);
            </script>
        </div>
        <div class="hero-content" style="flex: 1; margin-top: -100px; margin-left: -45px; display: flex; flex-direction: column; justify-content: center; padding: 0 64px;">
            <h1 style="font-size: 3.4rem; font-weight: 400; margin-bottom: 32px; color: #fff; line-height: 1.1;">
                Fatos Históricos e Curiosidades <br> que atravessam o tempo
            </h1>
            <p style="font-size: 1.28rem; margin-top: -5px ;color: #f3e6e0; line-height: 1.5; max-width: 750px;">
                Descubra curiosidades, fatos marcantes e relatos fascinantes do passado.<br>
                Navegue por memórias, mapas antigos e imagens raras, como se folheasse um almanaque repleto de descobertas. Sinta-se parte dessa viagem nostálgica e envolvente.
            </p>
            <a href="#historia-viva" class="btn-ver-historias">LEIA AGORA</a>
        </div>
    </section>
    <!-- Fim Hero Section -->
    <!-- Nova Section inspirada nas imagens enviadas -->
    <section id="noticias" style="background: #f9f6f0; padding: 64px 0 32px 0;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 40px;">
            <h2 style="font-family: 'Modern Antiqua', serif; font-size: 3rem; color: #4b2a17; margin-bottom: 18px; font-weight: 400;">
                História viva, curiosidade sem fim
            </h2>
            <p style="font-size: 1.3rem; color: #6d3c24; margin-bottom: 48px; max-width: 900px;">
                Viaje por séculos de descobertas, mistérios e relatos que atravessam gerações. Cada história é um convite para explorar o passado com olhos curiosos e mente aberta.
            </p>
            <div style="display: flex; gap: 32px; flex-wrap: wrap; justify-content: center;">
                <!-- Card 1 -->
                <div style="background: #fff; border-radius: 24px; box-shadow: 0 2px 16px rgba(0,0,0,0.06); width: 400px; padding-bottom: 32px; display: flex; flex-direction: column; align-items: flex-start;">
                    <img src="./img/livro_caneta.jpg" alt="Linha do tempo" style="width: 100%; height: 220px; object-fit: cover; border-radius: 24px 24px 0 0;">
                    <div style="padding: 24px;">
                        <span style="color: #a78a6d; font-size: 1rem;">Linha do tempo</span>
                        <h3 style="font-family: 'Modern Antiqua', serif; font-size: 1.6rem; color: #4b2a17; margin: 10px 0 12px 0; font-weight: 400;">
                            Marcos que moldaram o mundo
                        </h3>
                        <p style="color: #6d3c24; font-size: 1.08rem; margin-bottom: 24px;">
                            Percorra datas marcantes, eventos curiosos e transformações históricas. Descubra como cada época deixou sua marca e inspire-se com as jornadas do tempo.
                        </p>
                        <a href="#" style="background: #6d3c24; color: #fff; padding: 12px 32px; border-radius: 20px; font-size: 1.1rem; text-decoration: none;">Explorar</a>
                    </div>
                </div>
                <!-- Card 2 -->
                <div style="background: #fff; border-radius: 24px; box-shadow: 0 2px 16px rgba(0,0,0,0.06); width: 400px; padding-bottom: 32px; display: flex; flex-direction: column; align-items: flex-start;">
                    <img src="./img/mapa_antigo.jpg" alt="Artigos" style="width: 100%; height: 220px; object-fit: cover; border-radius: 24px 24px 0 0;">
                    <div style="padding: 24px;">
                        <span style="color: #a78a6d; font-size: 1rem;">Artigos</span>
                        <h3 style="font-family: 'Modern Antiqua', serif; font-size: 1.6rem; color: #4b2a17; margin: 10px 0 12px 0; font-weight: 400;">
                            Narrativas que atravessam gerações
                        </h3>
                        <p style="color: #6d3c24; font-size: 1.08rem; margin-bottom: 24px;">
                            Mergulhe em reportagens sobre personagens, culturas e fatos pouco conhecidos. Conhecimento contado de forma envolvente, como nas páginas de um diário antigo.
                        </p>
                        <a href="#" style="background: #6d3c24; color: #fff; padding: 12px 32px; border-radius: 20px; font-size: 1.1rem; text-decoration: none;">Ler mais</a>
                    </div>
                </div>
                <!-- Card 3 -->
                <div style="background: #fff; border-radius: 24px; box-shadow: 0 2px 16px rgba(0,0,0,0.06); width: 400px; padding-bottom: 32px; display: flex; flex-direction: column; align-items: flex-start;">
                    <img src="./img/curiosidades.jpg" alt="Curiosidades" style="width: 100%; height: 220px; object-fit: cover; border-radius: 24px 24px 0 0;">
                    <div style="padding: 24px;">
                        <span style="color: #a78a6d; font-size: 1rem;">Curiosidades</span>
                        <h3 style="font-family: 'Modern Antiqua', serif; font-size: 1.6rem; color: #4b2a17; margin: 10px 0 12px 0; font-weight: 400;">
                            Você sabia? Detalhes do passado
                        </h3>
                        <p style="color: #6d3c24; font-size: 1.08rem; margin-bottom: 24px;">
                            Encontre invenções, segredos e pequenas pérolas históricas que surpreendem e encantam. O passado guarda histórias fascinantes esperando por você.
                        </p>
                        <a href="#" style="background: #6d3c24; color: #fff; padding: 12px 32px; border-radius: 20px; font-size: 1.1rem; text-decoration: none;">Descobrir</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Destaques em carrossel horizontal com efeito opaco ao passar o mouse -->
    <section style="background: #f9f6f0; padding: 56px 0;">
        <div style="max-width: 1320px; margin: 0 auto; padding: 0 24px;">
            <h2 style="font-family: 'Modern Antiqua', serif; font-size: 2.4rem; color: #4b2a17; margin-bottom: 32px; font-weight: 400;">
                Destaques do tempo
            </h2>
            <div class="carrossel-destaques" style="display: flex; gap: 32px; overflow-x: auto; scroll-snap-type: x mandatory; padding-bottom: 16px;">
                <!-- Card 1 -->
                <div class="destaque-card" style="background: #fff; border-radius: 24px; min-width: 900px; max-width: 900px; display: flex; overflow: hidden; box-shadow: 0 2px 16px rgba(0,0,0,0.06); scroll-snap-align: start; transition: opacity 0.3s;">
                    <img src="./img/globo.jpg" alt="Globo" style="width: 50%; object-fit: cover; height: 340px;">
                    <div style="flex: 1; padding: 40px 36px 36px 36px; display: flex; flex-direction: column; justify-content: center;">
                        <span style="display:inline-block; background:#ede7df; color:#7a4a2e; font-size:0.95rem; border-radius:12px; padding:6px 18px 4px 18px; margin-bottom:18px;">
                            12 de junho de 1942
                        </span>
                        <h3 style="font-family: 'Modern Antiqua', serif; font-size:2.1rem; color:#4b2a17; margin:0 0 18px 0; font-weight:400;">
                            O diário que mudou o mundo
                        </h3>
                        <p style="color:#6d3c24; font-size:1.13rem; margin-bottom:28px;">
                            Descubra como as palavras de Anne Frank atravessaram décadas, inspirando gerações e revelando detalhes do cotidiano em tempos de guerra. Uma viagem íntima pelas páginas da história.
                        </p>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <img src="./img/autor1.jpg" alt="Autor" style="width:48px; height:48px; border-radius:50%; object-fit:cover;">
                            <div>
                                <div style="color:#4b2a17; font-size:1.05rem;">Taylor Cardoso</div>
                                <div style="color:#a78a6d; font-size:0.98rem;">Publicado em 12/06/2024</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="destaque-card" style="background: #fff; border-radius: 24px; min-width: 900px; max-width: 900px; display: flex; overflow: hidden; box-shadow: 0 2px 16px rgba(0,0,0,0.06); scroll-snap-align: start; transition: opacity 0.3s;">
                    <img src="./img/mapa_antigo.jpg" alt="Mapa antigo" style="width: 50%; object-fit: cover; height: 340px;">
                    <div style="flex: 1; padding: 40px 36px 36px 36px; display: flex; flex-direction: column; justify-content: center;">
                        <span style="display:inline-block; background:#ede7df; color:#7a4a2e; font-size:0.95rem; border-radius:12px; padding:6px 18px 4px 18px; margin-bottom:18px;">
                            8 de março de 1876
                        </span>
                        <h3 style="font-family: 'Modern Antiqua', serif; font-size:2.1rem; color:#4b2a17; margin:0 0 18px 0; font-weight:400;">
                            O mapa que revelou novos mundos
                        </h3>
                        <p style="color:#6d3c24; font-size:1.13rem; margin-bottom:28px;">
                            Conheça a história do mapa que mudou rotas e conectou culturas. Uma peça rara que narra aventuras, descobertas e o fascínio pelo desconhecido.
                        </p>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <img src="./img/autor2.jpg" alt="Autor" style="width:48px; height:48px; border-radius:50%; object-fit:cover;">
                            <div>
                                <div style="color:#4b2a17; font-size:1.05rem;">Maria Antunes</div>
                                <div style="color:#a78a6d; font-size:0.98rem;">Publicado em 08/03/2024</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="destaque-card" style="background: #fff; border-radius: 24px; min-width: 900px; max-width: 900px; display: flex; overflow: hidden; box-shadow: 0 2px 16px rgba(0,0,0,0.06); scroll-snap-align: start; transition: opacity 0.3s;">
                    <img src="./img/cafe_antigo.jpg" alt="Café antigo" style="width: 50%; object-fit: cover; height: 340px;">
                    <div style="flex: 1; padding: 40px 36px 36px 36px; display: flex; flex-direction: column; justify-content: center;">
                        <span style="display:inline-block; background:#ede7df; color:#7a4a2e; font-size:0.95rem; border-radius:12px; padding:6px 18px 4px 18px; margin-bottom:18px;">
                            20 de setembro de 1921
                        </span>
                        <h3 style="font-family: 'Modern Antiqua', serif; font-size:2.1rem; color:#4b2a17; margin:0 0 18px 0; font-weight:400;">
                            O café onde histórias se encontram
                        </h3>
                        <p style="color:#6d3c24; font-size:1.13rem; margin-bottom:28px;">
                            Descubra o charme dos cafés antigos, onde escritores, artistas e pensadores se reuniam para trocar ideias e criar movimentos culturais inesquecíveis.
                        </p>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <img src="./img/autor3.jpg" alt="Autor" style="width:48px; height:48px; border-radius:50%; object-fit:cover;">
                            <div>
                                <div style="color:#4b2a17; font-size:1.05rem;">João Mendes</div>
                                <div style="color:#a78a6d; font-size:0.98rem;">Publicado em 20/09/2021</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Adicione mais cards conforme desejar -->
            </div>
        </div>
        <style>
            .carrossel-destaques::-webkit-scrollbar {
                height: 10px;
            }

            .carrossel-destaques::-webkit-scrollbar-thumb {
                background: #e0d6c7;
                border-radius: 8px;
            }

            .destaque-card:hover {
                opacity: 0.7;
            }

            .carrossel-destaques {
                scrollbar-color: #e0d6c7 #f9f6f0;
                scrollbar-width: thin;
            }
        </style>
    </section>

    <!-- Nova seção de cards históricos -->
    <section style="background: #f9f6f0; padding: 56px 0;">
        <div style="max-width: 1320px; margin: 0 auto; padding: 0 24px;">
            <h2 style="font-family: 'Modern Antiqua', serif; font-size: 2.4rem; color: #4b2a17; margin-bottom: 32px; font-weight: 400;">
                Momentos que marcaram a história
            </h2>
            <form method="GET" class="pesquisa-bar-container" style="display: flex; align-items: center;">
                <input class="pesquisa-bar" type="text" name="busca" placeholder="Buscar notícia..." value="<?= isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : '' ?>">
                <button type="submit" style="background: none; border: none; font-size:2.0rem; color:#888;">🔍</button>
            </form>
            <div class="cards-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
                <?php foreach ($noticias as $n): ?>
                    <div class="card" style="background:#fff; border-radius:18px; box-shadow:0 2px 12px rgba(0,0,0,0.07); padding:18px; display:flex; flex-direction:column;">
                        <a href="noticia.php?id=<?php echo $n['id']; ?>" style="text-decoration: none; color: inherit; display: block;">
                            <?php if ($n['imagem']): ?>
                                <div class="card-img" style="width:100%;height:180px;overflow:hidden; border-radius:12px; margin-bottom:12px;">
                                    <img src="<?php echo htmlspecialchars($n['imagem']); ?>" alt="Imagem" style="width:100%;height:100%;object-fit:cover;">
                                </div>
                            <?php else: ?>
                                <div class="card-img" style="width:100%;height:180px;display:flex;align-items:center;justify-content:center;font-size:3rem;color:#ccc; background:#f3e6e0; border-radius:12px; margin-bottom:12px;">📷</div>
                            <?php endif; ?>

                            <div class="card-title" style="font-size: 1.6rem; font-weight: bold; margin-bottom: 6px;">
                                <?php echo htmlspecialchars($n['titulo']); ?>
                            </div>

                            <div style="font-size:1.1rem;color:#666;margin-bottom:8px;">
                                <strong>Data:</strong> <?php echo date('d/m/Y H:i', strtotime($n['data'])); ?>
                            </div>
                            <div style="margin-bottom:10px; color:#444;">
                                <?php echo nl2br(htmlspecialchars(substr($n['noticia'], 0, 200))); ?>...
                            </div>
                        </a>

                        <?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $n['autor']): ?>
                            <div style="margin-top:10px;">
                                <a href="./areaRestrita/editar_noticia.php?id=<?php echo $n['id']; ?>" class="btn btnEntrar" style="background:#7a4a2e; color:#fff; border-radius:14px; padding:6px 18px; text-decoration:none; margin-right:6px;">Editar</a>
                                <a href="./areaRestrita/excluir_noticia.php?id=<?php echo $n['id']; ?>" class="btn btnEntrar" style="background:#e57373; color:#fff; border-radius:14px; padding:6px 18px; text-decoration:none;" onclick="return confirm('Excluir esta notícia?')">Excluir</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
    </section>
    <!-- Depoimentos de Professores - Carrossel automático com animação de slide e borda de comentário -->
    <!-- Carrossel de depoimentos funcional -->
    <section id="contato" style="background: #3d2217; padding: 64px 0;">
        <div style="max-width: 900px; margin: 0 auto; position: relative;">
            <div class="depoimentos-carrossel">
                <div class="depoimento-slide ativo">
                    <div class="comentario-borda">
                        <img src="./img/prof1.jpg" alt="Professor" class="prof-img">
                        <p class="comentario-texto">
                            Descobrir este portal é como abrir um velho almanaque: cada página traz uma surpresa, um detalhe esquecido, uma história que ganha vida diante dos olhos. Aqui, o passado se faz presente, envolvente e cheio de cor. Recomendo a todos que desejam aprender de forma visual, leve e encantadora.
                        </p>
                        <div>
                            <div class="comentario-nome">Alex Duarte</div>
                            <div class="comentario-cargo">Professor de história</div>
                        </div>
                    </div>
                </div>
                <div class="depoimento-slide">
                    <div class="comentario-borda">
                        <img src="./img/prof2.jpg" alt="Professor" class="prof-img">
                        <p class="comentario-texto">
                            Utilizo o portal em minhas aulas para ilustrar fatos históricos de maneira dinâmica. Os alunos se envolvem mais e aprendem com prazer. É uma ferramenta indispensável para quem ama ensinar história!
                        </p>
                        <div>
                            <div class="comentario-nome">Marina Lopes</div>
                            <div class="comentario-cargo">Professora de história</div>
                        </div>
                    </div>
                </div>
                <div class="depoimento-slide">
                    <div class="comentario-borda">
                        <img src="./img/prof3.jpg" alt="Professor" class="prof-img">
                        <p class="comentario-texto">
                            O conteúdo do portal é confiável e muito bem apresentado. Recomendo para professores, estudantes e todos que têm curiosidade sobre o passado.
                        </p>
                        <div>
                            <div class="comentario-nome">Carlos Henrique</div>
                            <div class="comentario-cargo">Professor de história</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .depoimentos-carrossel {
                overflow: hidden;
                position: relative;
                height: 380px;
            }

            .depoimento-slide {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                pointer-events: none;
                transform: translateX(100%);
                z-index: 1;
                transition: opacity 0.5s, transform 0.7s;
            }

            .depoimento-slide.ativo {
                opacity: 1;
                pointer-events: auto;
                transform: translateX(0);
                z-index: 2;
            }

            .depoimento-slide.saindo {
                opacity: 0;
                transform: translateX(-100%);
                z-index: 1;
            }

            .comentario-borda {
                background: #2d1810;
                border: 3px solid #a78a6d;
                border-radius: 32px 32px 18px 18px;
                padding: 36px 38px 32px 38px;
                box-shadow: 0 4px 24px rgba(0, 0, 0, 0.10);
                width: 100%;
                max-width: 900px;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                margin: 0 auto;
            }

            .prof-img {
                width: 64px;
                height: 64px;
                border-radius: 50%;
                object-fit: cover;
                margin-bottom: 24px;
                border: 3px solid #a78a6d;
                background: #fff;
            }

            .hero-content a,
            .btn-ver-historias {
                background: #fff;
                color: #7a4a2e;
                font-family: 'Modern Antiqua', serif;
                font-size: 1.15rem;
                border-radius: 20px;
                padding: 12px 36px;
                margin-top: 10px;
                text-decoration: none;
                font-weight: bold;
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
                transition: background 0.2s, color 0.2s;
                display: inline-block;
            }

            .hero-content a:hover,
            .btn-ver-historias:hover {
                background: #b08350;
                color: #fff;
            }

            .comentario-texto {
                font-size: 1.6rem;
                font-family: 'Modern Antiqua', serif;
                margin-bottom: 36px;
                line-height: 1.4;
                color: #fff;
            }

            .comentario-nome {
                font-weight: bold;
                color: #fff;
            }

            .comentario-cargo {
                font-size: 1.1rem;
                color: #e0d6c7;
            }

            @media (max-width: 700px) {
                .comentario-borda {
                    padding: 18px 10px 18px 10px !important;
                    border-radius: 22px 22px 14px 14px !important;
                }

                .prof-img {
                    width: 48px;
                    height: 48px;
                }
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const slides = document.querySelectorAll('.depoimento-slide');
                let indiceAtual = 0;
                let animando = false;

                function mostrarSlideAnimado(novoIndice) {
                    if (animando || novoIndice === indiceAtual) return;
                    animando = true;
                    const slideAtual = slides[indiceAtual];
                    const proximo = slides[novoIndice];

                    // Prepara o próximo slide para entrar pela direita
                    proximo.classList.remove('ativo', 'saindo');
                    proximo.style.transition = 'none';
                    proximo.style.transform = 'translateX(100%)';
                    proximo.offsetHeight; // força reflow
                    proximo.style.transition = '';
                    proximo.classList.add('ativo');
                    proximo.style.transform = 'translateX(0)'; // <-- ESSENCIAL

                    // Anima o slide atual para a esquerda
                    slideAtual.classList.remove('ativo');
                    slideAtual.classList.add('saindo');
                    slideAtual.style.transform = 'translateX(-100%)';

                    // Após a animação, reseta o slide anterior para a direita
                    setTimeout(() => {
                        slideAtual.classList.remove('saindo');
                        slideAtual.style.transition = 'none';
                        slideAtual.style.transform = 'translateX(100%)';
                        slideAtual.offsetHeight; // força reflow
                        slideAtual.style.transition = '';
                        indiceAtual = novoIndice;
                        animando = false;
                    }, 700);
                }

                function proximoSlide() {
                    let novoIndice = (indiceAtual + 1) % slides.length;
                    mostrarSlideAnimado(novoIndice);
                }

                // Inicializa
                slides.forEach((slide, i) => {
                    slide.classList.remove('ativo', 'saindo');
                    slide.style.transform = 'translateX(100%)';
                });
                slides[0].classList.add('ativo');
                slides[0].style.transform = 'translateX(0)';

                setInterval(proximoSlide, 6000); // Troca a cada 6 segundos
            });
        </script>
    </section>

    <!-- Galeria de Memórias Visuais com efeito de slide lateral e zoom ao passar o mouse -->
    <section style="background: #f9f6f0; padding: 56px 0;">
        <h2 style="font-family: 'Modern Antiqua', serif; font-size: 2.6rem; color: #4b2a17; text-align: center; margin-bottom: 38px; font-weight: 400;">
            Galeria de Memórias Visuais
        </h2>
        <div class="galeria-carrossel" style="display: flex; gap: 40px; overflow-x: auto; scroll-snap-type: x mandatory; padding: 24px 0 32px 0;">
            <div class="galeria-card" style="min-width: 380px; max-width: 380px; border-radius: 28px; overflow: hidden; background: #fff; box-shadow: 0 2px 16px rgba(0,0,0,0.08); scroll-snap-align: start; transition: box-shadow 0.3s;">
                <div class="galeria-img-container">
                    <img src="./img/galeria1.jpg" alt="Livros antigos" class="galeria-img">
                </div>
            </div>
            <div class="galeria-card" style="min-width: 380px; max-width: 380px; border-radius: 28px; overflow: hidden; background: #fff; box-shadow: 0 2px 16px rgba(0,0,0,0.08); scroll-snap-align: start; transition: box-shadow 0.3s;">
                <div class="galeria-img-container">
                    <img src="./img/galeria2.jpg" alt="Globo antigo" class="galeria-img">
                </div>
            </div>
            <div class="galeria-card" style="min-width: 380px; max-width: 380px; border-radius: 28px; overflow: hidden; background: #fff; box-shadow: 0 2px 16px rgba(0,0,0,0.08); scroll-snap-align: start; transition: box-shadow 0.3s;">
                <div class="galeria-img-container">
                    <img src="./img/galeria3.jpg" alt="Caderno antigo" class="galeria-img">
                </div>
            </div>
            <!-- Adicione mais cards conforme desejar -->
        </div>
        <style>
            .galeria-carrossel::-webkit-scrollbar {
                height: 10px;
            }

            .galeria-carrossel::-webkit-scrollbar-thumb {
                background: #e0d6c7;
                border-radius: 8px;
            }

            .galeria-carrossel {
                scrollbar-color: #e0d6c7 #f9f6f0;
                scrollbar-width: thin;
            }

            .galeria-card:hover {
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.13);
            }

            .galeria-img-container {
                width: 100%;
                height: 420px;
                overflow: hidden;
                display: flex;
                align-items: flex-end;
                justify-content: center;
                background: #eee;
            }

            .galeria-img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.5s cubic-bezier(.22, 1, .36, 1);
                transform: scale(1) translateY(0);
            }

            .galeria-card:hover .galeria-img {
                transform: scale(1.13) translateY(-30px);
            }

            @media (max-width: 900px) {
                .galeria-card {
                    min-width: 260px !important;
                    max-width: 260px !important;
                }

                .galeria-img-container {
                    height: 260px !important;
                }
            }
        </style>
    </section>

    <footer style="background: #3d2217; color: #fff; padding: 48px 0 0 0; font-family: 'Modern Antiqua', serif;">
        <div style="max-width: 1320px; margin: 0 auto; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 32px; padding: 0 32px;">
            <div style="flex: 1 1 220px; min-width: 220px;">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 18px;">
                    <img src="./img/logo.png" alt="Logo" style="width: 108px; height: 108px; border-radius: 12px; background: #fff;">
                    <span style="font-size: 1.8rem; font-weight: bold; letter-spacing: 1px;">ALMANAQUE DO TEMPO</span>
                </div>
            </div>
            <div style="flex: 1 1 160px; min-width: 160px;">
                <div style="font-size: 1rem; color: #a78a6d; margin-bottom: 10px; letter-spacing: 1px;">Descubra</div>
                <div><a href="#" style="color: #fff; text-decoration: none;">Artigos</a></div>
                <div><a href="#" style="color: #fff; text-decoration: none;">Curiosidades</a></div>
                <div><a href="#" style="color: #fff; text-decoration: none;">Eventos</a></div>
                <div><a href="#" style="color: #fff; text-decoration: none;">Mapas</a></div>
                <div><a href="#" style="color: #fff; text-decoration: none;">Imagens</a></div>
            </div>
            <div style="flex: 1 1 160px; min-width: 160px;">
                <div style="font-size: 1rem; color: #a78a6d; margin-bottom: 10px; letter-spacing: 1px;">Explore</div>
                <div><a href="#" style="color: #fff; text-decoration: none;">Reportagens</a></div>
                <div><a href="#" style="color: #fff; text-decoration: none;">Timelines</a></div>
                <div><a href="#" style="color: #fff; text-decoration: none;">Cultura</a></div>
                <div><a href="#" style="color: #fff; text-decoration: none;">História</a></div>
                <div><a href="#" style="color: #fff; text-decoration: none;">Sabia?</a></div>
            </div>
            <div style="flex: 1 1 160px; min-width: 160px;">
                <div style="font-size: 1rem; color: #a78a6d; margin-bottom: 10px; letter-spacing: 1px;">Conecte</div>
                <div><a href="#" style="color: #fff; text-decoration: none;">Contato</a></div>
                <div><a href="#" style="color: #fff; text-decoration: none;">Equipe</a></div>
                <div><a href="#" style="color: #fff; text-decoration: none;">Envie</a></div>
                <div><a href="#" style="color: #fff; text-decoration: none;">Sugira</a></div>
                <div><a href="#" style="color: #fff; text-decoration: none;">Ajuda</a></div>
            </div>
            <div style="flex: 1 1 160px; min-width: 160px;">
                <div style="font-size: 1rem; color: #a78a6d; margin-bottom: 10px; letter-spacing: 1px;">Legal</div>
                <div><a href="#" style="color: #fff; text-decoration: none;">Política</a></div>
                <div><a href="#" style="color: #fff; text-decoration: none;">Termos</a></div>
                <div><a href="#" style="color: #fff; text-decoration: none;">Cookies</a></div>
                <div><a href="#" style="color: #fff; text-decoration: none;">Acessibilidade</a></div>
                <div><a href="#" style="color: #fff; text-decoration: none;">Créditos</a></div>
            </div>
            <div style="flex: 1 1 120px; min-width: 120px; display: flex; flex-direction: column; align-items: flex-start; justify-content: flex-end;">
                <button style="background: #7a4a2e; color: #fff; border: none; border-radius: 22px; padding: 10px 28px; font-size: 1.1rem; margin-bottom: 18px; cursor: pointer;">Assine</button>
                <div style="display: flex; gap: 16px; margin-bottom: 18px;">
                    <a href="#" style="color: #fff; font-size: 1.6rem;"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" style="color: #fff; font-size: 1.6rem;"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" style="color: #fff; font-size: 1.6rem;"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="#" style="color: #fff; font-size: 1.6rem;"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="#" style="color: #fff; font-size: 1.6rem;"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <hr style="border: none; border-top: 2px solid #5b3323; margin: 24px 0 0 0;">
        <div style="max-width: 1320px; margin: 0 auto; padding: 18px 32px 0 32px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; font-size: 1.1rem;">
            <div style="color: #fff; opacity: 0.85;">
                <a href="#" style="color: #fff; text-decoration: none; margin-right: 18px;">Sobre</a>
                <a href="#" style="color: #fff; text-decoration: none; margin-right: 18px;">Arquivo</a>
                <a href="#" style="color: #fff; text-decoration: none;">Boletim</a>
            </div>
            <div style="color: #a78a6d; text-align: right;">
                Todos os direitos reservados © 2025
            </div>
        </div>
    </footer>



    </div>

    </main>
</body>

</html>