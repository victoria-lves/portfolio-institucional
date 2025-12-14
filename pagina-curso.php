<?php
include 'conexao.php';

// 1. Pega o ID da URL (ex: pag-curso.php?id=1)
$id_curso = $_GET['id'] ?? null;

if (!$id_curso) {
    die("Curso não selecionado. <a href='menu-cursos.php'>Voltar</a>");
}

// 2. Busca dados no banco
$stmt = $conn->prepare("SELECT * FROM curso WHERE id = ?");
$stmt->bind_param("i", $id_curso);
$stmt->execute();
$curso = $stmt->get_result()->fetch_assoc();

if (!$curso) {
    die("Curso não encontrado.");
}

// Imagem padrão se não houver
$img_capa = !empty($curso['imagem']) ? $curso['imagem'] : 'img/escola.png';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($curso['nome']); ?> | IFMG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link
        href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@700&family=Poppins:wght@300;400;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link rel="stylesheet" href="css/style-pag-projeto.css">

    <style>
        /* Ajustes específicos para Curso */
        .curso-header {
            background: linear-gradient(rgba(0, 50, 0, 0.8), rgba(0, 50, 0, 0.8)), url('<?php echo $img_capa; ?>');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .info-card-destaque {
            background-color: #f8f9fa;
            border-left: 5px solid #006400;
            padding: 15px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <header>
        <div class="container">
            <a href="menu-principal.php" id="logo-link">
                <img src="img/logo-b.png" alt="IFMG" id="logo" />
            </a>
            <nav class="nav-items">
                <a href="menu-cursos.php">CURSOS</a>
                <a href="menu-lab.html">LABORATÓRIOS</a>
                <a href="menu-docentes.php">DOCENTES</a>
                <a href="menu-projetos.php">PROJETOS</a>
                <a href="login.php">ACESSO RESTRITO</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="curso-header">
            <div class="container">
                <span class="area-badge"
                    style="background: #ffd700; color: #333;"><?php echo htmlspecialchars($curso['nivel']); ?></span>
                <h1 class="projeto-titulo" style="font-size: 3rem; margin-top: 20px;">
                    <?php echo htmlspecialchars($curso['nome']); ?>
                </h1>
                <p style="font-size: 1.2rem; margin-top: 10px; opacity: 0.9;">
                    <i class="fa-solid fa-layer-group"></i> Área: <?php echo htmlspecialchars($curso['area']); ?>
                </p>
            </div>
        </section>

        <section class="projeto-conteudo">
            <div class="container">
                <div class="conteudo-grid">

                    <div class="coluna-principal">
                        <div class="card">
                            <h2><i class="fa-solid fa-book-open"></i> Sobre o Curso</h2>
                            <div class="card-content">
                                <p><?php echo nl2br(htmlspecialchars($curso['descricao'])); ?></p>

                                <?php if (!empty($curso['perfil_egresso'])): ?>
                                    <h3>Perfil do Egresso</h3>
                                    <p><?php echo nl2br(htmlspecialchars($curso['perfil_egresso'])); ?></p>
                                <?php endif; ?>

                                <?php if (!empty($curso['atuacao'])): ?>
                                    <h3>Área de Atuação</h3>
                                    <p><?php echo nl2br(htmlspecialchars($curso['atuacao'])); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="card">
                            <h2><i class="fa-solid fa-file-pdf"></i> Documentos Importantes</h2>
                            <div class="card-content">
                                <ul style="list-style: none; padding: 0;">
                                    <li style="margin-bottom: 10px;">
                                        <a href="#" style="color: #006400; text-decoration: none; font-weight: 500;">
                                            <i class="fa-solid fa-download"></i> Projeto Pedagógico do Curso (PPC)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" style="color: #006400; text-decoration: none; font-weight: 500;">
                                            <i class="fa-solid fa-download"></i> Matriz Curricular
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="coluna-lateral">

                        <div class="card">
                            <h2><i class="fa-solid fa-circle-info"></i> Informações</h2>
                            <div class="card-content">
                                <div class="info-item">
                                    <div class="info-label"><i class="fa-regular fa-clock"></i> Duração</div>
                                    <div class="info-value">
                                        <strong><?php echo htmlspecialchars($curso['duracao']); ?></strong>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label"><i class="fa-solid fa-sun"></i> Turno</div>
                                    <div class="info-value">
                                        <strong><?php echo htmlspecialchars($curso['turno']); ?></strong>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label"><i class="fa-solid fa-location-dot"></i> Campus</div>
                                    <div class="info-value"><strong>Ouro Branco</strong></div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <h2><i class="fa-solid fa-user-tie"></i> Coordenação</h2>
                            <div class="card-content">
                                <p><strong><?php echo htmlspecialchars($curso['coordenador']); ?></strong></p>
                                <?php if (!empty($curso['email_coordenador'])): ?>
                                    <p style="font-size: 0.9rem; color: #555; margin-top: 5px;">
                                        <i class="fa-solid fa-envelope"></i>
                                        <?php echo htmlspecialchars($curso['email_coordenador']); ?>
                                    </p>
                                <?php endif; ?>
                                <hr>
                                <a href="mailto:<?php echo htmlspecialchars($curso['email_coordenador']); ?>"
                                    class="btn-ver"
                                    style="display:block; text-align:center; background:#006400; color:white; padding:10px; border-radius:5px; margin-top:10px;">
                                    Fale com o Coordenador
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <div id="copyright">
                <p>&copy; 2025 Instituto Federal de Minas Gerais - Campus Ouro Branco</p>
            </div>
        </div>
    </footer>

</body>

</html>