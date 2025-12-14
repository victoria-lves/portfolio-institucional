<?php
include 'conexao.php';

// 1. Pega o ID da URL
$id_curso = $_GET['id'] ?? null;

if (!$id_curso) {
    die("<div style='text-align:center; padding:50px; font-family:sans-serif;'>Curso não selecionado. <a href='menu-cursos.php'>Voltar para Cursos</a></div>");
}

// 2. Busca dados no banco
$stmt = $conn->prepare("SELECT * FROM curso WHERE id = ?");
$stmt->bind_param("i", $id_curso);
$stmt->execute();
$curso = $stmt->get_result()->fetch_assoc();

if (!$curso) {
    die("<div style='text-align:center; padding:50px; font-family:sans-serif;'>Curso não encontrado. <a href='menu-cursos.php'>Voltar para Cursos</a></div>");
}

// Imagem padrão se não houver
$img_capa = !empty($curso['imagem']) ? $curso['imagem'] : 'img/escola.png';

// Lógica de SEO baseada no nome do curso
$nome_curso = $curso['nome'];
$seo_title = $nome_curso . " | IFMG Ouro Branco";
$seo_desc = "Conheça o curso de " . $nome_curso . " do IFMG Campus Ouro Branco. Grade curricular, mercado de trabalho e infraestrutura completa.";
$seo_keywords = "cursos IFMG Ouro Branco, vestibular IFMG"; // Padrão

// Personalização por curso (Baseado na sua lista)
if (stripos($nome_curso, 'Administração') !== false && stripos($curso['nivel'], 'Técnico') !== false) {
    $seo_keywords = "técnico em administração integrado IFMG Ouro Branco, curso técnico administração ensino médio, administração integrado IFMG duração";
    $seo_desc = "Faça o Técnico em Administração Integrado ao Ensino Médio no IFMG Ouro Branco. Formação de excelência para o mercado de trabalho.";
} 
elseif (stripos($nome_curso, 'Informática') !== false && stripos($curso['nivel'], 'Técnico') !== false) {
    $seo_keywords = "técnico em informática IFMG Ouro Branco, curso técnico informática integrado, formação técnica informática campus Ouro Branco, tecnologia informação IFMG";
}
elseif (stripos($nome_curso, 'Metalurgia') !== false && stripos($curso['nivel'], 'Técnico') !== false) {
    $seo_keywords = "técnico em metalurgia IFMG Ouro Branco, curso metalurgia integrado ensino médio, formação técnica metalurgia Minas Gerais";
}
elseif (stripos($nome_curso, 'Sistemas de Informação') !== false) {
    $seo_keywords = "bacharelado sistemas informação IFMG Ouro Branco, curso SI graduação IFMG, tecnologia informação graduação campus Ouro Branco, Sistemas de Informação nota corte IFMG";
    $seo_title = "Bacharelado em Sistemas de Informação | IFMG Ouro Branco";
}
elseif (stripos($nome_curso, 'Engenharia Metalúrgica') !== false) {
    $seo_keywords = "engenharia metalúrgica IFMG Ouro Branco, curso engenharia metalúrgica Minas Gerais, graduação metalurgia IFMG, engenheiro metalurgista formação";
}
// ... Adicione os outros `elseif` para Pedagogia, Gestão, etc.

?>



<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($seo_title); ?></title>
  <meta name="description" content="<?php echo htmlspecialchars($seo_desc); ?>">
  <meta name="keywords" content="<?php echo htmlspecialchars($seo_keywords); ?>">

  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

  <link rel="stylesheet" href="style-pagina-cursos.css">
</head>

<body>

  <header>
    <div class="container header-content">
      <a href="menu-principal.php" id="logo-link" aria-label="Voltar para a página inicial">
        <img src="img/logo-b.png" alt="Logo do IFMG Campus Ouro Branco" id="logo" />
      </a>
      
      <button class="menu-toggle" aria-label="Abrir menu de navegação">
        <i class="fa-solid fa-bars"></i>
      </button>

      <nav class="nav-items">
        <a href="menu-cursos.php" class="active">Cursos</a>
        <a href="menu-lab.html">Laboratórios</a>
        <a href="menu-docentes.php">Docentes</a>
        <a href="menu-projetos.php">Projetos</a>
        <a href="login.php" class="btn-login">Acesso Restrito</a>
      </nav>
    </div>
  </header>

  <main>
    <section class="theme" style="background-image: url('<?php echo htmlspecialchars($img_capa); ?>');">
      <div class="theme-overlay"></div>
      
      <a href="menu-cursos.php" class="btn-voltar-canto">
        <i class="fa-solid fa-arrow-left"></i> Voltar
      </a>

      <div class="theme-content">
        <span class="area-badge"><?php echo htmlspecialchars($curso['nivel']); ?></span>
        <h1 class="theme-title"><?php echo htmlspecialchars($curso['nome']); ?></h1>
        <p class="theme-desc">
            <i class="fa-solid fa-layer-group"></i> Área: <?php echo htmlspecialchars($curso['area']); ?>
        </p>
      </div>
    </section>

    <section class="conteudo-section">
      <div class="container">
        <div class="conteudo-grid">

          <div class="coluna-principal">
            
            <article class="content-card">
              <div class="card-header">
                <h2><i class="fa-solid fa-book-open"></i> Sobre o Curso</h2>
              </div>
              <div class="card-body">
                <p><?php echo nl2br(htmlspecialchars($curso['descricao'])); ?></p>

                <?php if (!empty($curso['perfil_egresso'])): ?>
                  <div class="topico-extra">
                    <h3>Perfil do Egresso</h3>
                    <p><?php echo nl2br(htmlspecialchars($curso['perfil_egresso'])); ?></p>
                  </div>
                <?php endif; ?>

                <?php if (!empty($curso['atuacao'])): ?>
                  <div class="topico-extra">
                    <h3>Área de Atuação</h3>
                    <p><?php echo nl2br(htmlspecialchars($curso['atuacao'])); ?></p>
                  </div>
                <?php endif; ?>
              </div>
            </article>

            <article class="content-card">
              <div class="card-header">
                <h2><i class="fa-solid fa-file-pdf"></i> Documentos Importantes</h2>
              </div>
              <div class="card-body">
                <ul class="lista-documentos">
                  <li>
                    <a href="#">
                      <i class="fa-solid fa-download"></i> Projeto Pedagógico do Curso (PPC)
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa-solid fa-download"></i> Matriz Curricular
                    </a>
                  </li>
                </ul>
              </div>
            </article>

          </div>

          <aside class="coluna-lateral">

            <div class="sidebar-card">
              <h3><i class="fa-solid fa-circle-info"></i> Informações</h3>
              <ul class="info-list">
                <li>
                    <span><i class="fa-regular fa-clock"></i> Duração</span>
                    <strong><?php echo htmlspecialchars($curso['duracao']); ?></strong>
                </li>
                <li>
                    <span><i class="fa-solid fa-sun"></i> Turno</span>
                    <strong><?php echo htmlspecialchars($curso['turno']); ?></strong>
                </li>
                <li>
                    <span><i class="fa-solid fa-location-dot"></i> Campus</span>
                    <strong>Ouro Branco</strong>
                </li>
              </ul>
            </div>

            <div class="sidebar-card">
              <h3><i class="fa-solid fa-user-tie"></i> Coordenação</h3>
              <div class="coord-info">
                <p class="coord-nome"><?php echo htmlspecialchars($curso['coordenador']); ?></p>
                
                <?php if (!empty($curso['email_coordenador'])): ?>
                    <p class="coord-email">
                        <i class="fa-solid fa-envelope"></i> <?php echo htmlspecialchars($curso['email_coordenador']); ?>
                    </p>
                    <a href="mailto:<?php echo htmlspecialchars($curso['email_coordenador']); ?>" class="btn-contato">
                        Fale com o Coordenador
                    </a>
                <?php endif; ?>
              </div>
            </div>

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