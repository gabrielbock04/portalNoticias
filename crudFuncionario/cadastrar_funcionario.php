<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Funcionário</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

        .funcionario-container {
            background: #fff;
            color: #4B2A17;
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

        h1 {
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
            gap: 14px;
        }

        label {
            font-weight: bold;
            margin-bottom: 4px;
            color: #4B2A17;
            display: flex;
            flex-direction: column;
            font-size: 1rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
            box-sizing: border-box;
            margin-top: 4px;
            background: #f9f6f3;
        }

        button[type="submit"] {
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

        button[type="submit"]:hover {
            filter: brightness(0.92);
        }

        a {
            color: #7a4a2e;
            text-decoration: underline;
            margin-top: 18px;
            display: inline-block;
        }

        a:hover {
            color: #4B2A17;
        }

        @media (max-width: 800px) {
            .funcionario-container {
                padding: 18px 8px;
                max-width: 98vw;
            }

            h1 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body>
    <div class="funcionario-container">
        <h1>Cadastrar Funcionário</h1>
        <form action="processar_funcionario.php" method="POST">
            <label>Nome: <input type="text" name="nome" required></label>
            <label>Sobrenome: <input type="text" name="sobrenome" required></label>
            <label>Email: <input type="email" name="email" required></label>
            <label>Senha: <input type="password" name="senha" required></label>
            <label>Data de Nascimento: <input type="date" name="data_nascimento"></label>
            <label>CPF/CNPJ: <input type="text" name="cpf_cnpj" required></label>
            <label>Sexo:
                <select name="sexo">
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>
                </select>
            </label>
            <label>Telefone: <input type="text" name="telefone"></label>
            <label>Endereço: <input type="text" name="endereco"></label>
            <label>Estado Civil: <input type="text" name="estado_civil"></label>
            <label>Raça/Cor: <input type="text" name="raca_cor"></label>
            <label>Escolaridade: <input type="text" name="escolaridade"></label>
            <label>Nacionalidade: <input type="text" name="nacionalidade"></label>
            <label>RG: <input type="text" name="rg"></label>
            <button type="submit">Salvar</button>
        </form>
        <a href="../admin/painel_admin.php">Voltar</a>
    </div>
</body>