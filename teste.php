<?php
session_start();
ob_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Conexão com banco
include_once './conexao/config.php';
include_once './conexao/funcoes.php';

require 'vendor/autoload.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>

    <h2>Login</h2>

    <?php
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['SendLogin'])) {

        // Buscar usuário
        $query_usuario = "SELECT id, nome, usuario, senha_usuario FROM usuarios WHERE usuario = :usuario LIMIT 1";
        $result_usuario = $conn->prepare($query_usuario);
        $result_usuario->bindParam(':usuario', $dados['usuario']);
        $result_usuario->execute();

        if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
            $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);

            if (password_verify($dados['senha_usuario'], $row_usuario['senha_usuario'])) {
                $_SESSION['id'] = $row_usuario['id'];
                $_SESSION['usuario'] = $row_usuario['usuario'];

                $data = date('Y-m-d H:i:s');
                $codigo_autenticacao = mt_rand(100000, 999999);

                // Salvar código no banco
                $query_up_usuario = "UPDATE usuarios SET codigo_autenticacao = :codigo_autenticacao, data_codigo_autenticacao = :data_codigo_autenticacao WHERE id = :id LIMIT 1";
                $result_up_usuario = $conn->prepare($query_up_usuario);
                $result_up_usuario->bindParam(':codigo_autenticacao', $codigo_autenticacao);
                $result_up_usuario->bindParam(':data_codigo_autenticacao', $data);
                $result_up_usuario->bindParam(':id', $row_usuario['id']);
                $result_up_usuario->execute();

                // Enviar e-mail via Mailtrap
                $mail = new PHPMailer(true);

                try {
                    $mail->CharSet = 'UTF-8';
                    $mail->isSMTP();
                    $mail->Host = 'sandbox.smtp.mailtrap.io'; // HOST DO MAILTRAP
                    $mail->SMTPAuth = true;
                    $mail->Username = 'SEU_USERNAME_DO_MAILTRAP'; // SUBSTITUA AQUI
                    $mail->Password = 'SUA_SENHA_DO_MAILTRAP';   // SUBSTITUA AQUI
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 2525;

                    $mail->setFrom('sistema@seudominio.com', 'Portal Noticias');
                    $mail->addAddress($row_usuario['usuario'], $row_usuario['nome']);

                    $mail->isHTML(true);
                    $mail->Subject = 'Código de Verificação - Login';
                    $mail->Body = "Olá <strong>{$row_usuario['nome']}</strong>,<br><br>Seu código de autenticação é: <strong>{$codigo_autenticacao}</strong><br><br>Este código é válido por alguns minutos.";
                    $mail->AltBody = "Olá {$row_usuario['nome']}, Seu código de autenticação é: {$codigo_autenticacao}";

                    $mail->send();

                    header('Location: validar_codigo.php');
                    exit;
                } catch (Exception $e) {
                    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
                }
            } else {
                $_SESSION['msg'] = "<p style='color:red;'>Erro: Usuário ou senha inválidos!</p>";
            }
        } else {
            $_SESSION['msg'] = "<p style='color:red;'>Erro: Usuário ou senha inválidos!</p>";
        }
    }

    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>

    <form method="POST" action="">
        <label>Usuário: </label>
        <input type="text" name="usuario" placeholder="Digite o usuário"><br><br>

        <label>Senha: </label>
        <input type="password" name="senha_usuario" placeholder="Digite a senha"><br><br>

        <input type="submit" name="SendLogin" value="Acessar"><br><br>
    </form>

    <a href="cadastrar.php">Cadastrar</a> -
    <a href="recuperar_senha.php">Esqueceu a senha?</a><br><br>

</body>

</html>