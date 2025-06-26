<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../index.php");
    exit();
}

include_once './conexao/config.php';
include_once './conexao/funcoes.php';

$db = (new Database())->getConnection();
$funcionario = new Funcionario($db);


if (!isset($_GET['id'])) {
    echo "ID do funcionário não fornecido.";
    exit();
}

$id = $_GET['id'];
$dados = $funcionario->buscarPorId($id);

if (!$dados) {
    echo "Funcionário não encontrado.";
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dadosAtualizados = [
        'nome' => $_POST['nome'],
        'sobrenome' => $_POST['sobrenome'],
        'data_nascimento' => $_POST['data_nascimento'],
        'cpf_cnpj' => $_POST['cpf_cnpj'],
        'sexo' => $_POST['sexo'],
        'telefone' => $_POST['telefone'],
        'email' => $_POST['email'],
        'endereco' => $_POST['endereco'],
        'estado_civil' => $_POST['estado_civil'],
        'raca_cor' => $_POST['raca_cor'],
        'escolaridade' => $_POST['escolaridade'],
        'nacionalidade' => $_POST['nacionalidade'],
        'rg' => $_POST['rg']
    ];

    $funcionario->atualizar($id, $dadosAtualizados);
    header("Location: painel_admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Funcionário</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body>
    <h1>Editar Funcionário</h1>

    <form method="POST">
        <label>Nome: <input type="text" name="nome" value="<?= htmlspecialchars($dados['nome']) ?>" required></label><br>
        <label>Sobrenome: <input type="text" name="sobrenome" value="<?= htmlspecialchars($dados['sobrenome']) ?>" required></label><br>
        <label>Data de Nascimento: <input type="date" name="data_nascimento" value="<?= $dados['data_nascimento'] ?>"></label><br>
        <label>CPF/CNPJ: <input type="text" name="cpf_cnpj" value="<?= htmlspecialchars($dados['cpf_cnpj']) ?>"></label><br>
        <label>Sexo:
            <select name="sexo">
                <option value="M" <?= $dados['sexo'] == 'M' ? 'selected' : '' ?>>Masculino</option>
                <option value="F" <?= $dados['sexo'] == 'F' ? 'selected' : '' ?>>Feminino</option>
            </select>
        </label><br>
        <label>Telefone: <input type="text" name="telefone" value="<?= htmlspecialchars($dados['telefone']) ?>"></label><br>
        <label>Email: <input type="email" name="email" value="<?= htmlspecialchars($dados['email']) ?>"></label><br>
        <label>Endereço: <input type="text" name="endereco" value="<?= htmlspecialchars($dados['endereco']) ?>"></label><br>
        <label>Estado Civil: <input type="text" name="estado_civil" value="<?= htmlspecialchars($dados['estado_civil']) ?>"></label><br>
        <label>Raça/Cor: <input type="text" name="raca_cor" value="<?= htmlspecialchars($dados['raca_cor']) ?>"></label><br>
        <label>Escolaridade: <input type="text" name="escolaridade" value="<?= htmlspecialchars($dados['escolaridade']) ?>"></label><br>
        <label>Nacionalidade: <input type="text" name="nacionalidade" value="<?= htmlspecialchars($dados['nacionalidade']) ?>"></label><br>
        <label>RG: <input type="text" name="rg" value="<?= htmlspecialchars($dados['rg']) ?>"></label><br>

        <button type="submit">Salvar Alterações</button>
        <a href="painel_admin.php">Cancelar</a>
    </form>
</body>

</html>