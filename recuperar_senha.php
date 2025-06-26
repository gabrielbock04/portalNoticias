<?php
session_start();
include_once './conexao/config.php';
include_once './conexao/funcoes.php';

$db = (new Database())->getConnection();
$usuario = new Usuario($db);

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $codigo = $usuario->gerarCodigoVerificacao($email);

        if ($codigo) {
            $link = "http://localhost/portalNoticias/verificar_codigo.php?codigo=$codigo";
            $mensagem = "Um e-mail foi enviado com instruções para redefinir sua senha.";


            echo "<p>Clique no link para redefinir sua senha: <a href='$link'>$link</a></p>";
        } else {
            $mensagem = "Erro ao gerar código de verificação.";
        }
    } else {
        $mensagem = "E-mail não encontrado.";
    }
}
?>

<!<!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <title>Recuperar Senha</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            html {
                scroll-behavior: smooth;
            }

            body {
                background: #804B30;
                margin: 0;
                font-family: 'Segoe UI', Arial, sans-serif;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .recuperar-container {
                background: #fff;
                color: #222;
                border-radius: 12px;
                box-shadow: 0 4px 24px rgba(0, 0, 0, 0.12);
                padding: 40px 32px 32px 32px;
                max-width: 400px;
                width: 95%;
                margin: 40px auto;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .recuperar-container h2 {
                color: #4B2A17;
                margin-bottom: 24px;
                font-size: 2rem;
                letter-spacing: 2px;
                text-align: center;
            }

            form {
                width: 100%;
                display: flex;
                flex-direction: column;
                gap: 16px;
            }

            label {
                font-weight: bold;
                margin-bottom: 4px;
                color: #4B2A17;
            }

            input[type="email"] {
                width: 100%;
                padding: 10px;
                border-radius: 8px;
                border: 1px solid #ccc;
                font-size: 1rem;
                box-sizing: border-box;
                margin-bottom: 10px;
                background: #f9f6f3;
            }

            input[type="submit"] {
                background-color: #7a4a2e;
                color: #fff;
                border: none;
                border-radius: 18px;
                padding: 10px 28px;
                font-size: 1.1rem;
                cursor: pointer;
                margin-top: 10px;
                transition: filter 0.2s;
                font-weight: 500;
                text-decoration: none;
                display: inline-block;
            }

            input[type="submit"]:hover {
                filter: brightness(0.92);
            }

            p {
                padding: 10px;
                background: #e9f7ef;
                color: #155724;
                border-radius: 4px;
                margin-bottom: 10px;
                border: 1px solid #c3e6cb;
                text-align: center;
            }

            a {
                color: #7a4a2e;
                text-decoration: underline;
            }

            a:hover {
                color: #4B2A17;
            }

            @media (max-width: 800px) {
                .recuperar-container {
                    padding: 18px 8px;
                    max-width: 98vw;
                }

                .recuperar-container h2 {
                    font-size: 1.3rem;
                }
            }
        </style>
    </head>

    <body>
        <div class="recuperar-container">
            <h2>Recuperar Senha</h2>
            <form method="POST">
                <label for="email">Digite seu e-mail cadastrado:</label>
                <input type="email" name="email" required>
                <input type="submit" value="Enviar código">
            </form>
            <?php if (!empty($mensagem)) echo '<p>' . $mensagem . '</p>'; ?>
        </div>
    </body>

    </html>