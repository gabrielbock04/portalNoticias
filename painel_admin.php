<?php
session_start();
include_once './conexao/config.php';

$db = (new Database())->getConnection();
$stmt = $db->prepare("SELECT f.*, u.email as email_login FROM funcionarios f JOIN usuarios u ON f.usuario_id = u.id");
$stmt->execute();
$funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Lista de Funcionários</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Telefone</th>
        <th>CPF/CNPJ</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($funcionarios as $f): ?>
    <tr>
        <td><?= $f['id'] ?></td>
        <td><?= $f['nome'] . ' ' . $f['sobrenome'] ?></td>
        <td><?= $f['email_login'] ?></td>
        <td><?= $f['telefone'] ?></td>
        <td><?= $f['cpf_cnpj'] ?></td>
        <td>
            <a href="editar_funcionario.php?id=<?= $f['id'] ?>">Editar</a>
            <a href="excluir_funcionario.php?id=<?= $f['id'] ?>" onclick="return confirm('Excluir este funcionário?')">Excluir</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>