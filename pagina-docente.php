<?php
include 'conexao.php';

// 1. Verifica ID
$id_professor = $_GET['id'] ?? null;

if (!$id_professor) {
    die("<div style='text-align:center; padding:50px; font-family:sans-serif;'>Professor não selecionado. <a href='menu-docentes.php'>Voltar</a></div>");
}

// 2. Busca dados do Professor
$stmt = $conn->prepare("SELECT * FROM professor WHERE id = ?");
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$prof = $stmt->get_result()->fetch_assoc();

if (!$prof) {
    die("<div style='text-align:center; padding:50px; font-family:sans-serif;'>Professor não encontrado. <a href='menu-docentes.php'>Voltar</a></div>");
}

// 3. Busca Produções
$stmt_prod = $conn->prepare("SELECT * FROM producao WHERE id_professor = ? ORDER BY data_pub DESC");
$stmt_prod->bind_param("i", $id_professor);
$stmt_prod->execute();
$producoes = $stmt_prod->get_result();

// 3. Busca Projetos (Nova lógica com JOIN)
// "Selecione todos os projetos ONDE o id deste professor esteja na tabela de ligação"
$sql_proj = "
    SELECT p.* FROM projeto p
    INNER JOIN projeto_professor pp ON p.id = pp.id_projeto
    WHERE pp.id_professor = ?
    ORDER BY p.data_inicio DESC
";

$stmt_proj = $conn->prepare($sql_proj);
$stmt_proj->bind_param("i", $id_professor); // Usa o ID do professor da página
$stmt_proj->execute();
$projetos = $stmt_proj->get_result();

// Imagem padrão
$foto_perfil = !empty($prof['pfp']) ? htmlspecialchars($prof['pfp']) : 'https://via.placeholder.com/200?text=Sem+Foto';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil - <?php echo htmlspecialchars($prof['nome']); ?> | IFMG</title>

  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

  <link rel="stylesheet" href="style-pagina-docente.css">
  
  <style>
    /* Ajustes específicos para a foto de perfil no Hero */
    .profile-hero {
        display: flex; flex-direction: column; align-items: center;
        background: linear-gradient(to bottom, var(--primary-color), var(--primary-dark));
        padding: 60px 20px; color: white; text-align: center;
    }
    .profile-img {
        width: 150px; height: 150px; border-radius: 50%; 
        border: 5px solid rgba(255,255,255,0.3); object-fit: cover;
        margin-bottom: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    .profile-name {
        font-family: 'League Spartan', sans-serif; font-size: 2.5rem; margin-bottom: 10px;
    }
    .profile-role {
        font-size: 1.1rem; opacity: 0.9; font-weight: 300;
        background: rgba(255,255,255,0.1); padding: 5px 15px; border-radius: 20px;
    }
  </style>
</head>

<body>

  <header>
    <div class="container header-content">
      <a href="menu-principal.php" id="logo-link">
        <img src="img/logo-b.png" alt="Logo IFMG" id="logo">
      </a>
      <button class="menu-toggle"><i class="fa-solid fa-bars"></i></button>
      <nav class="nav-items">
        <a href="menu-cursos.php">Cursos</a>
        <a href="menu-lab.html">Laboratórios</a>
        <a href="menu-docentes.php" class="active">Docentes</a>
        <a href="menu-projetos.php">Projetos</a>
        <a href="login.php" class="btn-login">Acesso Restrito</a>
      </nav>
    </div>
  </header>

  <main>
    <section class="profile-hero">
        <img src="<?php echo $foto_perfil; ?>" alt="<?php echo htmlspecialchars($prof['nome']); ?>" class="profile-img">
        <h1 class="profile-name"><?php echo htmlspecialchars($prof['nome']); ?></h1>
        <span class="profile-role">
            <?php echo !empty($prof['gabinete']) ? htmlspecialchars($prof['gabinete']) : 'Docente'; ?>
        </span>
    </section>

    <section class="conteudo-section">
      <div class="container">
        
        <a href="menu-docentes.php" style="display:inline-flex; align-items:center; gap:8px; margin-bottom:30px; color:#666; text-decoration:none; font-weight:600;">
            <i class="fa-solid fa-arrow-left"></i> Voltar para Docentes
        </a>

        <div class="conteudo-grid">

          <div class="coluna-principal">
            
            <article class="content-card">
              <div class="card-header">
                <h2><i class="fa-solid fa-user"></i> Sobre</h2>
              </div>
              <div class="card-body">
                <p><?php echo nl2br(htmlspecialchars($prof['bio'])); ?></p>
              </div>
            </article>

            <?php if (!empty($prof['formacao'])): ?>
            <article class="content-card">
              <div class="card-header">
                <h2><i class="fa-solid fa-graduation-cap"></i> Formação Acadêmica</h2>
              </div>
              <div class="card-body">
                <p><?php echo nl2br(htmlspecialchars($prof['formacao'])); ?></p>
              </div>
            </article>
            <?php endif; ?>

            <article class="content-card">
              <div class="card-header">
                <h2><i class="fa-solid fa-book-open"></i> Produções Acadêmicas</h2>
              </div>
              <div class="card-body">
                <?php if ($producoes->num_rows > 0): ?>
                    <ul class="lista-documentos">
                    <?php while ($prod = $producoes->fetch_assoc()): ?>
                        <li>
                            <div style="width:100%;">
                                <strong style="color:var(--primary-color); display:block; margin-bottom:5px;">
                                    <?php echo htmlspecialchars($prod['tipo']); ?>
                                </strong>
                                <?php echo htmlspecialchars($prod['titulo']); ?>
                                <?php if ($prod['link']): ?>
                                    <a href="<?php echo htmlspecialchars($prod['link']); ?>" target="_blank" style="margin-top:10px; font-size:0.9rem;">
                                        <i class="fa-solid fa-external-link-alt"></i> Acessar
                                    </a>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p style="font-style:italic; color:#777;">Nenhuma produção cadastrada.</p>
                <?php endif; ?>
              </div>
            </article>

          </div>

          <aside class="coluna-lateral">

            <div class="sidebar-card">
              <h3><i class="fa-solid fa-envelope"></i> Contato</h3>
              <div class="coord-info">
                <?php if (!empty($prof['email'])): ?>
                    <p class="coord-email">
                        <i class="fa-solid fa-at"></i> <?php echo htmlspecialchars($prof['email']); ?>
                    </p>
                    <a href="mailto:<?php echo htmlspecialchars($prof['email']); ?>" class="btn-contato">
                        Enviar E-mail
                    </a>
                <?php endif; ?>
              </div>
            </div>

            <?php if (!empty($prof['lattes']) || !empty($prof['linkedin'])): ?>
            <div class="sidebar-card">
              <h3><i class="fa-solid fa-link"></i> Links Externos</h3>
              <ul class="info-list">
                <?php if (!empty($prof['lattes'])): ?>
                <li>
                    <span><i class="fa-solid fa-file-contract"></i> Currículo Lattes</span>
                    <a href="<?php echo htmlspecialchars($prof['lattes']); ?>" target="_blank" style="color:var(--primary-color); font-weight:600;">Acessar</a>
                </li>
                <?php endif; ?>
                
                <?php if (!empty($prof['linkedin'])): ?>
                <li>
                    <span><i class="fa-brands fa-linkedin"></i> LinkedIn</span>
                    <a href="<?php echo htmlspecialchars($prof['linkedin']); ?>" target="_blank" style="color:var(--primary-color); font-weight:600;">Acessar</a>
                </li>
                <?php endif; ?>
              </ul>
            </div>
            <?php endif; ?>

            <?php if (!empty($prof['atendimento']) || !empty($prof['gabinete'])): ?>
            <div class="sidebar-card">
              <h3><i class="fa-solid fa-clock"></i> Atendimento</h3>
              <div class="card-body" style="padding:20px;">
                <?php if (!empty($prof['gabinete'])): ?>
                    <p><strong><i class="fa-solid fa-door-open"></i> Gabinete:</strong><br> <?php echo htmlspecialchars($prof['gabinete']); ?></p>
                <?php endif; ?>
                
                <?php if (!empty($prof['atendimento'])): ?>
                    <p style="margin-top:15px;"><strong><i class="fa-regular fa-calendar"></i> Horários:</strong><br> <?php echo htmlspecialchars($prof['atendimento']); ?></p>
                <?php endif; ?>
              </div>
            </div>
            <?php endif; ?>

          </aside>

        </div>
      </div>
    </section>
  </main>

  <footer>
    <div class="container">
      <div class="footer-content">
        <div class="footer-section">
          <h4>Endereço</h4>
          <p><i class="fa-solid fa-location-dot"></i> Rua Afonso Sardinha, 90<br />Ouro Branco, MG - 36420-000</p>
        </div>
        <div class="footer-section">
          <h4>Funcionamento</h4>
          <p><i class="fa-regular fa-clock"></i> Seg a Sex: 08h - 22h</p>
          <p>Sábado: 12h - 20h</p>
        </div>
        <div class="footer-section">
          <h4>Contato</h4>
          <p><i class="fa-regular fa-envelope"></i> secretaria.ourobranco@ifmg.edu.br</p>
          <p><i class="fa-solid fa-phone"></i> (31) 2137-5700</p>
        </div>
        <div class="footer-section">
          <h4>Redes Sociais</h4>
          <div class="social-icons">
            <a href="#" aria-label="Youtube"><i class="fa-brands fa-youtube"></i></a>
            <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a>
          </div>
        </div>
      </div>
      <div class="copyright">
        <p>&copy; 2025 Instituto Federal de Minas Gerais - Campus Ouro Branco</p>
      </div>
    </div>
  </footer>

  <script>
    // Menu Mobile
    document.querySelector('.menu-toggle').addEventListener('click', function() {
      document.querySelector('.nav-items').classList.toggle('active');
    });
  </script>

</body>
</html>