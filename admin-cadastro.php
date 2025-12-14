<?php
// admin-cadastro.php
include 'conexao.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica se email já existe
    $check = $conn->prepare("SELECT id FROM usuario WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        $msg = "<p style='color:red'>E-mail já cadastrado!</p>";
    } else {
        $conn->begin_transaction();
        try {
            // 1. Cria Login (Usuario)
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt1 = $conn->prepare("INSERT INTO usuario (nome, email, senha, nivel) VALUES (?, ?, ?, 'professor')");
            $stmt1->bind_param("sss", $nome, $email, $senha_hash);
            $stmt1->execute();
            $id_usuario = $conn->insert_id;

            // 2. Cria Perfil Professor (Vazio/Rascunho) vinculado ao Usuario
            $stmt2 = $conn->prepare("INSERT INTO professor (nome, email, id_usuario) VALUES (?, ?, ?)");
            $stmt2->bind_param("ssi", $nome, $email, $id_usuario);
            $stmt2->execute();

            $conn->commit();
            $msg = "<p style='color:green'>Professor cadastrado com sucesso! ID de Login: $id_usuario</p>";
        } catch (Exception $e) {
            $conn->rollback();
            $msg = "<p style='color:red'>Erro: " . $e->getMessage() . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro Inicial (Dev)</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="d-flex align-items-center justify-content-center" style="height: 100vh; background: #eee;">
    <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
        <h3>Cadastro Inicial</h3>
        <p class="text-muted">Acesso exclusivo para desenvolvedores.</p>
        <?php echo $msg; ?>
        <form method="POST">
            <div class="mb-3">
                <label>Nome do Professor</label>
                <input type="text" name="nome" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>E-mail (Login)</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Senha Provisória</label>
                <input type="password" name="senha" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
        </form>
    </div>
</body>
</html>