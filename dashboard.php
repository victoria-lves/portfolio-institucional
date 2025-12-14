<?php
// dashboard.php
if(!isset($_SESSION)) {
    session_start();
}

// Se não existir a variável ID na sessão, o usuário não fez login: expulsa ele
if(!isset($_SESSION['id'])) {
    die("Você não pode acessar esta página porque não está logado.<p><a href=\"index.html\">Entrar</a></p>");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Painel do Professor</title>
</head>
<body>
    <h1>Bem vindo, <?php echo $_SESSION['nome']; ?></h1>
    
    <p>Aqui ficam as notas e ferramentas do professor.</p>

    <p>
        <a href="logout.php">Sair</a>
    </p>
</body>
</html>