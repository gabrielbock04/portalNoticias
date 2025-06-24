<?php
session_start();
include_once './conexao/config.php';
include_once './conexao/funcoes.php';

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: login.php');
    exit();
}

$db = (new Database())->getConnection();
$usuario = new Usuario($db);
$funcionario = new Funcionario($db);

$usuarios = $usuario->ler();
$funcionarios = $funcionario->listarTodos();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Administrador</title>
</head>
<body>
    <h1>Painel do Administrador</h1>
    <a href="cadastro_usuario.php">Cadastrar Novo Usuário</a> |
    <a href="cadastrar_funcionario.php">Cadastrar Novo Funcionário</a> |
    <a href="logout.php">Logout</a>

    <h2>Usuários</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Sexo</th>
            <th>Fone</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $usuarios->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo ($row['sexo'] === 'M') ? 'Masculino' : 'Feminino'; ?></td>
                <td><?php echo $row['fone']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                    <a href="crudUsuarios/editar_usuario.php?id=<?php echo $row['id']; ?>">Editar</a> |
                    <a href="crudUsuarios/excluir_usuario.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Excluir este usuário?')">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Funcionários</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Sobrenome</th>
            <th>CPF/CNPJ</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($funcionarios as $f) : ?>
            <tr>
                <td><?php echo $f['id']; ?></td>
                <td><?php echo $f['nome']; ?></td>
                <td><?php echo $f['sobrenome']; ?></td>
                <td><?php echo $f['cpf_cnpj']; ?></td>
                <td><?php echo $f['email']; ?></td>
                <td><?php echo $f['telefone']; ?></td>
                <td>
                    <a href="crudFuncionarios/editar_funcionario.php?id=<?php echo $f['id']; ?>">Editar</a> |
                    <a href="crudFuncionarios/excluir_funcionario.php?id=<?php echo $f['id']; ?>" onclick="return confirm('Excluir este funcionário?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
