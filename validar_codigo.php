<?php
session_start();
ob_start();

include_once './conexao/config.php';
include_once './conexao/funcoes.php';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar código</title>
</head>

<body>

    <h2>Digite o código enviado no e-mail cadastrado</h2>

    <?php
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['ValCodigo'])) {
        $query_usuario = "SELECT id, nome, email, senha 
            FROM usuarios
            WHERE id = :id
            AND email = :usuario
            AND codigo_autenticacao = :codigo_autenticacao
            LIMIT 1";

        $result_usuario = $conn->prepare($query_usuario);
        $result_usuario->bindParam(':id', $_SESSION['id']);
        $result_usuario->bindParam(':usuario', $_SESSION['usuario']);
        $result_usuario->bindParam(':codigo_autenticacao', $dados['codigo_autenticacao']);
        $result_usuario->execute();

        if ($result_usuario->rowCount() != 0) {
            $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);

            $query_up_usuario = "UPDATE usuarios SET
                codigo_autenticacao = NULL,
                data_codigo_autenticacao = NULL
                WHERE id = :id
                LIMIT 1";

            $result_up_usuario = $conn->prepare($query_up_usuario);
            $result_up_usuario->bindParam(':id', $_SESSION['id']);
            $result_up_usuario->execute();

            $_SESSION['nome'] = $row_usuario['nome'];
            $_SESSION['codigo_autenticacao'] = true;

            header('Location: dashboard.php');
            exit();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Código inválido!</p>";
        }
    }

    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>

    <form method="POST" action="">
        <label>Código: </label>
        <input type="text" name="codigo_autenticacao" placeholder="Digite o código"><br><br>
        <input type="submit" name="ValCodigo" value="Validar"><br><br>
    </form><br>

</body>
</html>
