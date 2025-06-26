<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit();
}

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

    // Permite somente o autor da notícia OU o administrador
    if ($n['autor'] != $_SESSION['usuario_id'] && $_SESSION['is_admin'] != 1) {
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

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Notícia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- TinyMCE CDN -->
    <script src="https://cdn.tiny.cloud/1/37ybikexkmn7wucbg1x3kgi89eul0az7uq9v07orofaq4hku/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea[name="noticia"]',
            height: 300,
            menubar: false,
            plugins: 'lists link image table code',
            toolbar: 'undo redo | bold italic underline | bullist numlist | link image | code',
            language: 'pt_BR'
        });
    </script>
    <style>
        body {
            background: #804B30;
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .editar-container {
            background: #fff;
            color: #4B2A17;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.12);
            padding: 40px 32px 32px 32px;
            max-width: 500px;
            width: 95%;
            margin: 40px auto;
        }

        h2 {
            color: #4B2A17;
            margin-bottom: 24px;
            text-align: center;
        }

        label {
            font-weight: bold;
            color: #4B2A17;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
            margin-bottom: 10px;
            background: #f9f6f3;
        }

        input[type="submit"] {
            background-color: #7a4a2e;
            color: #fff;
            border: none;
            border-radius: 18px;
            padding: 10px 28px;
            font-size: 1.1rem;
            cursor: pointer;
            margin-top: 10px;
            transition: filter 0.2s;
            font-weight: 500;
            display: inline-block;
        }

        input[type="submit"]:hover {
            filter: brightness(0.92);
        }

        @media (max-width: 800px) {
            .editar-container {
                padding: 18px 8px;
                max-width: 98vw;
            }

            h2 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body>
    <div class="editar-container">
        <form method="POST">
            <h2>Editar Notícia</h2>
            <input type="hidden" name="id" value="<?php echo $n['id']; ?>">

            <label>Título:</label>
            <input type="text" name="titulo" value="<?php echo htmlspecialchars($n['titulo']); ?>" required>

            <label>Notícia:</label>
            <textarea name="noticia" rows="10" required><?php echo htmlspecialchars($n['noticia']); ?></textarea>

            <label>Imagem (URL):</label>
            <input type="text" name="imagem" value="<?php echo htmlspecialchars($n['imagem']); ?>">

            <input type="submit" value="Salvar alterações">
        </form>
    </div>
</body>

</html>