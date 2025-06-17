    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Recuperar Senha</title>
    </head>

    <body>

    </body>

    <h1>Recuperar Senha</h1>

    <?php
    session_start();
    ob_start();

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    include_once './conexao/config.php';
    include_once './conexao/funcoes.php';
    ?>

    <?php
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $dsn = 'mysql:host=localhost;dbname=portalNoticias_bd';
    $usuario = 'root';
    $senha = '';

    try {
        $conn = new PDO($dsn, $usuario, $senha);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('Erro na conexão: ' . $e->getMessage());
    }
    if (!empty($dados['recuperarSenha'])) {

        $query_usuario = "SELECT id, nome, sexo, fone, email, senha 
                      FROM usuarios
                      WHERE email = :email
                      LIMIT 1";
        $result_usuario = $conn->prepare($query_usuario);
        $result_usuario->bindParam(':email', $dados['email']);
        $result_usuario->execute();

        if ($result_usuario->rowCount() != 0) {
            $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);

            $chave_recuperar_senha = password_hash($row_usuario['id'] . $row_usuario['email'], PASSWORD_DEFAULT);

            $query_up_usuario = "UPDATE usuarios 
                             SET chave_recuperar_senha = :chave_recuperar_senha
                             WHERE id = :id
                             LIMIT 1";
            $editar_usuario = $conn->prepare($query_up_usuario);
            $editar_usuario->bindParam(':chave_recuperar_senha', $chave_recuperar_senha);
            $editar_usuario->bindParam(':id', $row_usuario['id']);

            if ($editar_usuario->execute()) {
                $link = "http://localhost/atualizar_senha.php?chave=$chave_recuperar_senha";

                require 'vendor/autoload.php';


                // Cria uma nova instância do PHPMailer
                $mail = new PHPMailer(true);

                try {
                    // Configurações do servidor SMTP do Mailtrap
                    $mail->isSMTP();
                    $mail->Host       = 'sandbox.smtp.mailtrap.io';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = '149c278d703845'; // Seu usuário Mailtrap
                    $mail->Password   = '3fd956f45e9a57'; // Sua senha Mailtrap
                    $mail->Port       = 2525;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

                    // Define o remetente e o destinatário
                    $mail->setFrom('from@example.com', 'Magic Elves');
                    $mail->addAddress('to@example.com', 'Mailtrap Inbox');

                    // Conteúdo do e-mail
                    $mail->isHTML(true);
                    $mail->Subject = 'Teste de envio com PHPMailer e Mailtrap';
                    $mail->Body    = '
        <h1>Parabéns!</h1>
        <p>Seu e-mail de teste com PHPMailer e Mailtrap foi enviado com sucesso.</p>
        <img src="https://assets-examples.mailtrap.io/integration-examples/welcome.png" style="width: 100%;">
    ';
                    $mail->AltBody = 'Seu e-mail de teste com PHPMailer e Mailtrap foi enviado com sucesso.';

                    // Envia o e-mail
                    $mail->send();
                    echo 'E-mail enviado com sucesso!';
                } catch (Exception $e) {
                    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
                }
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Tente novamente!</p>";
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: E-mail não encontrado!</p>";
        }
    }

    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>

    <form method="POST" action="">
        <label>E-mail</label>
        <input type="text" name="email" placeholder="Digite seu e-mail" required>
        <input type="submit" name="recuperarSenha" value="Recuperar">
    </form>

    </body>

    </html>