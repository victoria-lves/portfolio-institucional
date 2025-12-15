<?php
// --- PARTE DA LÓGICA (PHP) ---
session_start();
include 'conexao.php';

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Previne injeção de SQL e busca o usuário
    $stmt = $conn->prepare("SELECT id, nome, senha, nivel FROM usuario WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // Verifica a senha criptografada
        if (password_verify($senha, $user['senha'])) {
            // Sucesso! Salva dados na sessão
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nome'] = $user['nome'];
            $_SESSION['nivel'] = $user['nivel'];

            // Busca o ID do professor associado para facilitar edições futuras
            $stmt_prof = $conn->prepare("SELECT id FROM professor WHERE id_usuario = ?");
            $stmt_prof->bind_param("i", $user['id']);
            $stmt_prof->execute();
            $prof = $stmt_prof->get_result()->fetch_assoc();

            // Se tiver perfil de professor, salva o ID, senão deixa null (será criado ao tentar editar)
            $_SESSION['id_professor'] = $prof ? $prof['id'] : null;

            // Redireciona para o painel
            header("Location: dashboard.php");
            exit();
        } else {
            $erro = "Senha incorreta.";
        }
    } else {
        $erro = "E-mail não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Acesso Restrito</title>
    <link rel="stylesheet" href="css/style-login.css">

    <link
        href="https://fonts.googleapis.com/css2?family=League+Spartan&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:wght@200&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@700&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />

    <style>
        /* Pequeno estilo extra para mostrar a mensagem de erro */
        .msg-erro {
            background-color: rgba(255, 0, 0, 0.7);
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <main class="container">
        <form method="POST" action="">
            <h1>Login para Professores</h1>

            <?php if (!empty($erro)): ?>
                <div class="msg-erro"><?php echo $erro; ?></div>
            <?php endif; ?>

            <div class="input-box">
                <input type="email" name="email" placeholder="E-mail" required>
            </div>
            <div class="input-box">
                <input type="password" name="senha" placeholder="Senha" required>
            </div>

            <div class="remember-forgot">
                <label>
                    <input type="checkbox">
                    Lembrar senha
                </label>
                <a href="recuperar-senha.html" id="link-password">Esqueceu sua senha?</a>
            </div>

            <button type="submit">Login</button>

            <div class="register">
                <p>É professor e não tem acesso? <a href="#">Contate-nos!</a></p>
                <a href="menu-principal.php">Voltar ao menu</a>
            </div>
        </form>
    </main>
</body>

</html>