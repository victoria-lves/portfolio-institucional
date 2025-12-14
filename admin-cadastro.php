<?php
include 'conexao.php';
// Aqui você poderia adicionar uma verificação: se quem está acessando não é admin, bloqueia.

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome']; // Nome vai para a tabela professor
    $email = $_POST['email']; // Email vai para a tabela usuario
    $senha = $_POST['senha'];
    
    // 1. Verifica se email já existe
    $check = $conn->prepare("SELECT id FROM usuario WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        $msg = "<div class='alert alert-danger'>E-mail já está em uso!</div>";
    } else {
        // 2. Cria o Usuário (Login)
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $conn->begin_transaction(); // Inicia transação para garantir que cria os dois ou nenhum

        try {
            $stmt1 = $conn->prepare("INSERT INTO usuario (email, senha, nivel) VALUES (?, ?, 'professor')");
            $stmt1->bind_param("ss", $email, $senha_hash);
            $stmt1->execute();
            $id_usuario = $conn->insert_id; // Pega o ID do usuário criado

            // 3. Cria o Perfil do Professor (Vinculado)
            // Note que salvamos o e-mail de contato igual ao de login inicialmente
            $stmt2 = $conn->prepare("INSERT INTO professor (nome, email, id_usuario) VALUES (?, ?, ?)");
            $stmt2->bind_param("ssi", $nome, $email, $id_usuario);
            $stmt2->execute();

            $conn->commit(); // Confirma tudo
            $msg = "<div class='alert alert-success'>Cadastro realizado! O professor já pode logar.</div>";
        } catch (Exception $e) {
            $conn->rollback(); // Se der erro, desfaz tudo
            $msg = "<div class='alert alert-danger'>Erro ao cadastrar: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Acesso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4">Novo Professor</h3>
        <?php echo $msg; ?>
        <form method="POST">
            <div class="mb-3">
                <label>Nome Completo</label>
                <input type="text" name="nome" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>E-mail de Login</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Senha Provisória</label>
                <input type="password" name="senha" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Cadastrar Usuário</button>
        </form>
        <a href="login.php" class="d-block text-center mt-3">Voltar para Login</a>
    </div>
</body>
</html>