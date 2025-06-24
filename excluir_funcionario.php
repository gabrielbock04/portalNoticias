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


$funcionario->excluir($id);

header("Location: painel_admin.php");
exit();
?>
