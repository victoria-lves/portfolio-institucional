<?php
// dashboard.php
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
            <span class="navbar-brand">Olá, <?php echo $_SESSION['usuario_nome']; ?></span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Sair</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            
            <div class="col-md-5 mb-4">
                <div class="card h-100 shadow-sm text-center p-4">
                    <div class="card-body">
                        <i class="fa-solid fa-user-pen fa-3x text-success mb-3"></i>
                        <h4>Meu Perfil</h4>
                        <p>Complete suas informações (Bio, Formação, Foto).</p>
                        <a href="criar_perfil.php" class="btn btn-success w-100">Editar Dados</a>
                    </div>
                </div>
            </div>

            <div class="col-md-5 mb-4">
                <div class="card h-100 shadow-sm text-center p-4">
                    <div class="card-body">
                        <i class="fa-solid fa-list-check fa-3x text-primary mb-3"></i>
                        <h4>Meus Projetos</h4>
                        <p>Adicione novos projetos de pesquisa ou extensão.</p>
                        <a href="criar_projeto.php" class="btn btn-primary w-100">Gerenciar Projetos</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>