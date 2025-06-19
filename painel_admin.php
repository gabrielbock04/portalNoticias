<?php
session_start();
include_once './conexao/config.php';
include_once './conexao/funcoes.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit();
}

$db = (new Database())->getConnection();
$stmt = $db->prepare("SELECT id, nome, email, is_admin FROM usuarios");
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel de Administração</title>
</head>
<body>
    <h1>Usuários</h1>
    <table border="1">
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Administrador</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?= $usuario['nome'] ?></td>
            <td><?= $usuario['email'] ?></td>
            <td><?= $usuario['is_admin'] ? 'Sim' : 'Não' ?></td>
            <td>
                <?php if ($usuario['is_admin'] == 0): ?>
                    <a href="tornar_admin.php?id=<?= $usuario['id'] ?>">Tornar Admin</a>
                <?php else: ?>
                    <a href="remover_admin.php?id=<?= $usuario['id'] ?>">Remover Admin</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
