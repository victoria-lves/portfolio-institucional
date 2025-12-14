<?php
session_start();
include 'conexao.php';

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Busca o usuário pelo email
    $stmt = $conn->prepare("SELECT id, senha, nivel FROM usuario WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        // Verifica a senha criptografada
        if (password_verify($senha, $user['senha'])) {
            // Sucesso! Salva dados na sessão
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['nivel'] = $user['nivel'];
            
            // Busca o ID do professor associado a este usuário para facilitar depois
            $stmt_prof = $conn->prepare("SELECT id, nome FROM professor WHERE id_usuario = ?");
            $stmt_prof->bind_param("i", $user['id']);
            $stmt_prof->execute();
            $prof = $stmt_prof->get_result()->fetch_assoc();
            
            $_SESSION['professor_id'] = $prof['id'];
            $_SESSION['professor_nome'] = $prof['nome'];

            // Redireciona para o painel
            header("Location: painel.php"); 
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
    <title>Login - IFMG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #004d40; color: white; } /* Cor verde IFMG */
        .card { border: none; border-radius: 15px; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card shadow p-5" style="width: 100%; max-width: 400px; color: #333;">
        <div class="text-center mb-4">
            <h3>Acesso Restrito</h3>
            <p class="text-muted">Gestão de Portfólio</p>
        </div>

        <?php if($erro): ?>
            <div class="alert alert-danger text-center"><?php echo $erro; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label>E-mail</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Senha</label>
                <input type="password" name="senha" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100 fw-bold">Entrar</button>
        </form>
        <div class="text-center mt-3">
            <a href="menu-principal.php" class="text-decoration-none text-muted">Voltar ao site</a>
        </div>
    </div>
</body>
</html>