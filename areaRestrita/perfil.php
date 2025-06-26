<?php
session_start();
include_once '../conexao/config.php';
include_once '../conexao/funcoes.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$db = (new Database())->getConnection();
$usuarioObj = new Usuario($db);
$mensagem = '';
$dados = $usuarioObj->lerPorId($_SESSION['usuario_id']) ?? [];

// Excluir apenas a foto
if (isset($_POST['excluir_foto'])) {
    if (!empty($dados['foto']) && file_exists($dados['foto'])) {
        unlink($dados['foto']);
    }

    $usuarioObj->atualizar(
        $dados['id'],
        $dados['nome'] ?? '',
        $dados['sexo'] ?? '',
        $dados['fone'] ?? '',
        $dados['email'] ?? '',
        null
    );
    $mensagem = "✅ Foto de perfil removida.";
    $dados = $usuarioObj->lerPorId($_SESSION['usuario_id']);
}

// Excluir conta
if (isset($_POST['excluir_conta'])) {
    if (!empty($dados['foto']) && file_exists($dados['foto'])) {
        unlink($dados['foto']);
    }

    $usuarioObj->deletar($dados['id']);
    session_destroy();
    header("Location: login.php?msg=conta_excluida");
    exit();
}

// Atualizar dados
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['excluir_foto']) && !isset($_POST['excluir_conta'])) {
    $nome = $_POST['nome'] ?? '';
    $sexo = $_POST['sexo'] ?? '';
    $fone = $_POST['fone'] ?? '';
    $email = $_POST['email'] ?? '';
    $nova_senha = $_POST['nova_senha'] ?? null;
    $senha_antiga = $_POST['senha_antiga'] ?? null;

    $foto = $dados['foto'] ?? null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $tipo = mime_content_type($_FILES['foto']['tmp_name']);
        if (in_array($tipo, ['image/jpeg', 'image/png', 'image/gif'])) {
            $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $nomeArquivo = uniqid() . '.' . $extensao;
            $caminho = 'uploads/' . $nomeArquivo;

            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminho)) {
                $foto = $caminho;
            }
        } else {
            $mensagem = "❌ Tipo de imagem não suportado.";
        }
    }

    if (!empty($nova_senha)) {
        if (!password_verify($senha_antiga, $dados['senha'])) {
            $mensagem = "❌ Senha atual incorreta!";
        } else {
            $usuarioObj->atualizar($dados['id'], $nome, $sexo, $fone, $email, $foto, $nova_senha);
            $mensagem = "✅ Dados atualizados com nova senha.";
        }
    } else {
        $usuarioObj->atualizar($dados['id'], $nome, $sexo, $fone, $email, $foto);
        $mensagem = "✅ Dados atualizados com sucesso.";
    }

    $dados = $usuarioObj->lerPorId($_SESSION['usuario_id']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Meu Perfil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../styles/stylesPerfil">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Modern+Antiqua&display=swap" rel="stylesheet">
</head>

<body>
    <header class="header-portal">
        <div class="container-header">
            <a href="index.php" class="logo">
                <i class="fa-solid fa-user"></i> Meu Perfil
            </a>
            <nav class="nav-header">
                <a href="index.php"><i class="fa fa-home"></i> Início</a>
                <a href="perfil.php"><i class="fa fa-user"></i> Perfil</a>
                <a href="logout.php"><i class="fa fa-sign-out-alt"></i> Sair</a>
            </nav>
        </div>
    </header>

    <div class="perfil-container">
        <h2>Meu Perfil</h2>

        <?php if ($mensagem): ?>
            <p><?php echo $mensagem; ?></p>
        <?php endif; ?>

        <?php if (!empty($dados['foto'])): ?>
            <img src="<?= htmlspecialchars($dados['foto']) ?>" alt="Foto de Perfil">
            <form method="POST" style="margin-bottom: 10px;">
                <input type="hidden" name="excluir_foto" value="1">
                <button type="submit" onclick="return confirm('Excluir foto de perfil?')">Excluir Foto</button>
            </form>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <label>Nome:</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($dados['nome'] ?? '') ?>">

            <label>Sexo:</label>
            <select name="sexo">
                <option value="M" <?= ($dados['sexo'] ?? '') === 'M' ? 'selected' : '' ?>>Masculino</option>
                <option value="F" <?= ($dados['sexo'] ?? '') === 'F' ? 'selected' : '' ?>>Feminino</option>
            </select>

            <label>Telefone:</label>
            <input type="text" name="fone" value="<?= htmlspecialchars($dados['fone'] ?? '') ?>">

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($dados['email'] ?? '') ?>">

            <label>Foto de Perfil:</label>
            <input type="file" name="foto" accept="image/*">

            <hr>
            <h3>Alterar senha (opcional)</h3>
            <label>Senha atual:</label>
            <input type="password" name="senha_antiga">

            <label>Nova senha:</label>
            <input type="password" name="nova_senha">

            <input type="submit" value="Salvar alterações">
        </form>

        <form method="POST" onsubmit="return confirm('Tem certeza que deseja excluir sua conta? Esta ação é irreversível!')">
            <input type="hidden" name="excluir_conta" value="1">
            <button type="submit" style="color:red;">Excluir minha conta</button>
        </form>
    </div>
</body>

</html>