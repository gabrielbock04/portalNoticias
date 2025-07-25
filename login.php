<?php
session_start();
include_once './conexao/config.php';
include_once './conexao/funcoes.php';

$usuario = new Usuario($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        if ($dados_usuario = $usuario->login($email, $senha)) {
            $_SESSION['usuario_id'] = $dados_usuario['id'];
            $_SESSION['is_admin'] = $dados_usuario['is_admin'];
            $_SESSION['cargo'] = $dados_usuario['cargo'] ?? null;
            setcookie("nome_usuario", $dados_usuario['nome'], time() + (86400 * 30), "/");

            // Verifica se o usuario também é um funcionario
            $stmt = $db->prepare("SELECT * FROM funcionarios WHERE usuario_id = ?");
            $stmt->execute([$dados_usuario['id']]);
            $func = $stmt->fetch(PDO::FETCH_ASSOC);

            $_SESSION['eh_funcionario'] = $func ? true : false;

            header('Location: index.php');
            exit();
        } else {
            $mensagem_erro = "Credenciais inválidas!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>A U T E N T I C A Ç Ã O</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/login.css">
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            background: #804B30;
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: #fff;
            color: #222;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.12);
            padding: 40px 32px 32px 32px;
            max-width: 400px;
            width: 95%;
            margin: 40px auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .box h1 {
            color: #4B2A17;
            margin-bottom: 24px;
            font-size: 2rem;
            letter-spacing: 2px;
            text-align: center;
        }

        form {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        label {
            font-weight: bold;
            margin-bottom: 4px;
            color: #4B2A17;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        input[type="submit"],
        .btn-voltar {
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
            text-decoration: none;
            display: inline-block;
        }

        input[type="submit"]:hover,
        .btn-voltar:hover {
            filter: brightness(0.92);
        }

        .mensagem p {
            color: #b00;
            margin-top: 16px;
            text-align: center;
        }

        a {
            color: #7a4a2e;
            text-decoration: underline;
        }

        a:hover {
            color: #4B2A17;
        }

        @media (max-width: 600px) {
            .container {
                padding: 18px 8px;
                max-width: 98vw;
            }

            .box h1 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="box">
            <h1>Realize seu Login</h1>
            <form method="POST">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
                <label for="senha">Senha:</label>
                <input type="password" name="senha" required>
                <input type="submit" name="login" value="Login">
            </form>
            <p>Não tem uma conta? <a href="./crudUsuarios/cadastro_usuario.php">Registre-se aqui</a></p>
            <p>Esqueceu a senha? <a href="./recuperar_senha.php">Recuperar senha</a></p>
            <a href="index.php" class="btn-voltar">Voltar</a>
            <div class="mensagem">
                <?php if (isset($mensagem_erro)) echo '<p>' . $mensagem_erro . '</p>'; ?>
            </div>
        </div>
    </div>
</body>

</html>