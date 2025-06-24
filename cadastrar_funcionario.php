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
</head>
<body>
    <h1>Cadastrar Funcionário</h1>
    <form action="processar_funcionario.php" method="POST">
        <label>Nome: <input type="text" name="nome" required></label><br>
        <label>Sobrenome: <input type="text" name="sobrenome" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Senha: <input type="password" name="senha" required></label><br>
        <label>Data de Nascimento: <input type="date" name="data_nascimento"></label><br>
        <label>CPF/CNPJ: <input type="text" name="cpf_cnpj" required></label><br>
        <label>Sexo:
            <select name="sexo">
                <option value="M">Masculino</option>
                <option value="F">Feminino</option>
                <option value="Outro">Outro</option>
            </select>
        </label><br>
        <label>Telefone: <input type="text" name="telefone"></label><br>
        <label>Endereço: <input type="text" name="endereco"></label><br>
        <label>Estado Civil: <input type="text" name="estado_civil"></label><br>
        <label>Raça/Cor: <input type="text" name="raca_cor"></label><br>
        <label>Escolaridade: <input type="text" name="escolaridade"></label><br>
        <label>Nacionalidade: <input type="text" name="nacionalidade"></label><br>
        <label>RG: <input type="text" name="rg"></label><br>
        <button type="submit">Salvar</button>
    </form>
    <a href="../painel_admin.php">Voltar</a>
</body>
</html>
