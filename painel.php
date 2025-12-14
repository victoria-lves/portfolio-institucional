<?php
// Segurança: Se não estiver logado, manda pro login
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Professor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    
    <nav class="navbar navbar-dark bg-success shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fa-solid fa-user-graduate"></i> Olá, <?php echo $_SESSION['professor_nome']; ?>
            </a>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Sair</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-5 text-secondary">O que você deseja gerenciar?</h2>
        
        <div class="row justify-content-center">
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm hover-shadow text-center p-4">
                    <div class="card-body">
                        <i class="fa-solid fa-id-card fa-3x text-success mb-3"></i>
                        <h4 class="card-title">Meu Perfil</h4>
                        <p class="card-text text-muted">Edite sua bio, foto, formação e contatos.</p>
                        <a href="criar-perfil.php?id=<?php echo $_SESSION['professor_id']; ?>" class="btn btn-success w-100">Editar Perfil</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm text-center p-4">
                    <div class="card-body">
                        <i class="fa-solid fa-folder-open fa-3x text-primary mb-3"></i>
                        <h4 class="card-title">Meus Projetos</h4>
                        <p class="card-text text-muted">Cadastre ou atualize seus projetos de pesquisa e extensão.</p>
                        <a href="listar_projetos.php" class="btn btn-primary w-100">Gerenciar Projetos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>