<?php

include_once '../conexao/config.php';
include_once '../conexao/funcoes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario($db);
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmarSenha = $_POST['confirmar_senha'];

    if ($senha !== $confirmarSenha) {
        echo "<script>alert('As senhas não coincidem.'); window.history.back();</script>";
    } else {
        $usuario->criar($nome, $sexo, $fone, $email, $senha, $confirmarSenha);
        header('Location: ../login.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Adicionar Usuário</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./styles/cadastro_usuario.css">
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

        .container-cadastro {
            background: #fff;
            color: #222;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.12);
            padding: 40px 32px 32px 32px;
            max-width: 420px;
            width: 95%;
            margin: 40px auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container-cadastro h1 {
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

        input[type="text"],
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

        input[type="radio"] {
            margin-right: 6px;
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

        a {
            color: #7a4a2e;
            text-decoration: underline;
        }

        a:hover {
            color: #4B2A17;
        }

        @media (max-width: 600px) {
            .container-cadastro {
                padding: 18px 8px;
                max-width: 98vw;
            }

            .container-cadastro h1 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body>
    <div class="container-cadastro">
        <h1>Adicionar Usuário</h1>
        <form method="POST">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" required pattern="[A-Za-zÀ-ÿ\s]+" title="Digite apenas letras."
                oninput="this.value = this.value.replace(/[^A-Za-zÀ-ÿ\s]/g, '')">

            <label>Sexo:</label>
            <label for="masculino">
                <input type="radio" id="masculino" name="sexo" value="M" required> Masculino
            </label>
            <label for="feminino">
                <input type="radio" id="feminino" name="sexo" value="F" required> Feminino
            </label>

            <label for="fone">Fone:</label>
            <input type="text" name="fone" required pattern="\d+" title="Digite apenas números."
                oninput="this.value = this.value.replace(/[^0-9]/g, '')">

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" required>

            <label for="confirmar_senha">Confirmar Senha:</label>
            <input type="password" name="confirmar_senha" required>

            <input type="submit" value="Adicionar">
        </form>
        <a href="../index.php" class="btn-voltar">Voltar</a>
    </div>
</body>

</html>