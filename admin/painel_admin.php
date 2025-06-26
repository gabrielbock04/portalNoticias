<?php
session_start();
include_once '../conexao/config.php';
include_once '../conexao/funcoes.php';

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: ../admin/painel_admin.php');
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
    <title style="background-color: #fff;">Painel do Administrador</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../styles/stylesPainelAdmin.css">
</head>

<body>
    <h1>Painel do Administrador</h1>
    <div class="painel-links">
        <a href="../crudUsuarios/cadastro_usuario.php">Cadastrar Novo Usuário</a> |
        <a href="../crudFuncionario/cadastrar_funcionario.php">Cadastrar Novo Funcionário</a> |
        <a href="../logout.php">Logout</a>
    </div>
    <div class="painel-container">
        <h2>Usuários</h2>
        <table>
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
                    <td data-label="ID"><?php echo $row['id']; ?></td>
                    <td data-label="Nome"><?php echo $row['nome']; ?></td>
                    <td data-label="Sexo"><?php echo ($row['sexo'] === 'M') ? 'Masculino' : 'Feminino'; ?></td>
                    <td data-label="Fone"><?php echo $row['fone']; ?></td>
                    <td data-label="Email"><?php echo $row['email']; ?></td>
                    <td data-label="Ações">
                        <a href="../crudUsuarios/editar_usuario.php?id=<?php echo $row['id']; ?>">Editar</a> |
                        <a href="../crudUsuarios/excluir_usuario.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Excluir este usuário?')">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <h2>Funcionários</h2>
        <table>
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
                    <td data-label="ID"><?php echo $f['id']; ?></td>
                    <td data-label="Nome"><?php echo $f['nome']; ?></td>
                    <td data-label="Sobrenome"><?php echo $f['sobrenome']; ?></td>
                    <td data-label="CPF/CNPJ"><?php echo $f['cpf_cnpj']; ?></td>
                    <td data-label="Email"><?php echo $f['email']; ?></td>
                    <td data-label="Telefone"><?php echo $f['telefone']; ?></td>
                    <td data-label="Ações">
                        <a href="../crudFuncionarios/editar_funcionario.php?id=<?php echo $f['id']; ?>">Editar</a> |
                        <a href="../crudFuncionarios/excluir_funcionario.php?id=<?php echo $f['id']; ?>" onclick="return confirm('Excluir este funcionário?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>