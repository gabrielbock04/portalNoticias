<?php
session_start();
include_once './conexao/config.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit();
}

$db = (new Database())->getConnection();
$id = $_GET['id'];

$stmt = $db->prepare("UPDATE usuarios SET is_admin = 0 WHERE id = ?");
$stmt->execute([$id]);

header("Location: painel_admin.php");
