<?php
session_start();
include_once './conexao/config.php';
include_once './conexao/funcoes.php';

$usuario = new Usuario($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        if ($dados_usuario = $usuario->login($email, $senha)) {
            $_SESSION['usuario_id'] = $dados_usuario['id'];
            $_SESSION['is_admin'] = $dados_usuario['is_admin'];
            $_SESSION['cargo'] = $dados_usuario['cargo'] ?? null;
            setcookie("nome_usuario", $dados_usuario['nome'], time() + (86400 * 30), "/");


            // Verifica se o usuario também é um funcionario
            $stmt = $db->prepare("SELECT * FROM funcionarios WHERE usuario_id = ?");
            $stmt->execute([$dados_usuario['id']]);
            $func = $stmt->fetch(PDO::FETCH_ASSOC);

            $_SESSION['eh_funcionario'] = $func ? true : false;

            header('Location: index.php');
            exit();
        } else {
            $mensagem_erro = "Credenciais inválidas!";
        }
    }
}
?>
<!DOCTYPE html>
<html>


<head>
    <title>A U T E N T I C A Ç Ã O</title>

</head>


<body>


    <div class="container">


        <div class="box">
            <h1>A U T E N T I C A Ç Ã O</h1>


            <form method="POST">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
                <br><br>
                <label for="senha">Senha:</label>
                <input type="password" name="senha" required>
                <br><br>
                <input type="submit" name="login" value="Login">
            </form>
            <p>Não tem uma conta? <a href="./cadastro_usuario.php">Registre-se aqui</a></p>
            <p> Esqueceu a senha? <a href="./recuperar_senha.php">Recuperar senha</a></p>
            <div class="mensagem">
                <?php if (isset($mensagem_erro)) echo '<p>' . $mensagem_erro . '</p>'; ?>
            </div>
        </div>


</body>


</html>