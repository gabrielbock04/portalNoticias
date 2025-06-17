<?php
session_start();
ob_start();

include_once './conexao/config.php';
include_once './conexao/funcoes.php';


$chave_recuperar_senha = filter_input(INPUT_GET, 'chave', FILTER_DEFAULT);

if (empty($chave_recuperar_senha)) {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link inválido!</p>";
    header('Location: index.php');
    exit();
} else {
    $query_usuario = "SELECT id FROM usuarios WHERE chave_recuperar_senha = :chave_recuperar_senha LIMIT 1";
    $result_usuario = $conn->prepare($query_usuario);
    $result_usuario->bindParam(':chave_recuperar_senha', $chave_recuperar_senha);
    $result_usuario->execute();

    if ($result_usuario->rowCount() === 0) {
        $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link inválido!</p>";
        header('Location: index.php');
        exit();
    } else {
        $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Senha</title>
</head>

<body>

    <h1>Atualizar Senha</h1>

    <?php
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['SendNovaSenha'])) {
        $senha_usuario = password_hash($dados['senha_usuario'], PASSWORD_DEFAULT);
        $chave_nula = NULL;

        $query_up_usuario = "UPDATE usuarios 
            SET senha = :senha_usuario, 
                chave_recuperar_senha = :chave_recuperar_senha 
            WHERE id = :id 
            LIMIT 1";
        $editar_usuario = $conn->prepare($query_up_usuario);
        $editar_usuario->bindParam(':senha_usuario', $senha_usuario);
        $editar_usuario->bindParam(':chave_recuperar_senha', $chave_nula, PDO::PARAM_NULL);
        $editar_usuario->bindParam(':id', $row_usuario['id']);

        if ($editar_usuario->execute()) {
            $_SESSION['msg'] = "<p style='color: green;'>Senha atualizada com sucesso!</p>";
            header('Location: index.php');
            exit();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Tente novamente!</p>";
        }
    }

    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>

    <form method="POST" action="">
        <label>Senha</label>
        <input type="password" name="senha_usuario" placeholder="Digite a nova senha"><br><br>
        <input type="submit" name="SendNovaSenha" value="Atualizar"><br><br>
    </form>

    Lembrou a senha? <a href="index.php">clique aqui</a> para logar
</body>
</html>
