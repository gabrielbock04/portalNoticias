<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../index.php");
    exit();
}

include_once './conexao/config.php';
include_once './conexao/funcoes.php';
$db = (new Database())->getConnection();

// 1. Cadastrar o usuário
$senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
$stmt = $db->prepare("INSERT INTO usuarios (nome, email, senha, is_admin) VALUES (?, ?, ?, 0)");
$stmt->execute([$_POST['nome'], $_POST['email'], $senha_hash]);
$usuario_id = $db->lastInsertId();

// 2. Cadastrar os dados do funcionário
$stmt2 = $db->prepare("INSERT INTO funcionarios
    (usuario_id, nome, sobrenome, data_nascimento, cpf_cnpj, sexo, telefone, email, endereco, estado_civil, raca_cor, escolaridade, nacionalidade, rg)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt2->execute([
    $usuario_id,
    $_POST['nome'],
    $_POST['sobrenome'],
    $_POST['data_nascimento'],
    $_POST['cpf_cnpj'],
    $_POST['sexo'],
    $_POST['telefone'],
    $_POST['email'],
    $_POST['endereco'],
    $_POST['estado_civil'],
    $_POST['raca_cor'],
    $_POST['escolaridade'],
    $_POST['nacionalidade'],
    $_POST['rg']
]);

header("Location: ./painel_admin.php");
exit();
