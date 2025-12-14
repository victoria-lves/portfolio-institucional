<?php
include 'conexao.php';

// 1. Verifica se foi passado um ID na URL (ex: perfil-prof.php?id=1)
$id_professor = $_GET['id'] ?? null;

if (!$id_professor) {
    die("Professor não selecionado. <a href='menu-docentes.html'>Voltar</a>");
}

// 2. Busca os dados do Professor no Banco
$stmt = $conn->prepare("SELECT * FROM professor WHERE id = ?");
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$result = $stmt->get_result();
$prof = $result->fetch_assoc();

if (!$prof) {
    die("Professor não encontrado.");
}

// 3. Busca as Produções Acadêmicas desse professor
$stmt_prod = $conn->prepare("SELECT * FROM producao WHERE id_professor = ? ORDER BY data_pub DESC");
$stmt_prod->bind_param("i", $id_professor);
$stmt_prod->execute();
$producoes = $stmt_prod->get_result();

// Define uma imagem padrão caso o professor não tenha foto
$foto_perfil = !empty($prof['pfp']) ? $prof['pfp'] : 'https://via.placeholder.com/200?text=Sem+Foto';
?>

<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Perfil - <?php echo htmlspecialchars($prof['nome']); ?> | IFMG</title>
    
    <link rel="stylesheet" href="css/style-prof.css" />
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:wght@200&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@700&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  </head>
  
  <body>
    <header>
      <div class="container">
        <a href="menu-principal.html" id="logo-link">
          <img src="img/logo-b.png" alt="" id="logo" />
        </a>
        <nav class="nav-items">
          <a href="menu-cursos.html">CURSOS</a>
          <a href="menu-lab.html">LABORATÓRIOS</a>
          <a href="menu-docentes.html">DOCENTES</a>
          <a href="menu-projetos.html">PROJETOS</a>
        </nav>
      </div>
    </header>

    <main>
      <section class="section-profile">
        <img src="<?php echo $foto_perfil; ?>" alt="Foto de <?php echo $prof['nome']; ?>" id="pfp" />
        <h2 id="nome-prof"><?php echo htmlspecialchars($prof['nome']); ?></h2>
        
        <p id="bio-prof">
           <?php echo nl2br(htmlspecialchars($prof['bio'])); ?>
        </p>
      </section>

      <?php if(!empty($prof['formacao'])): ?>
      <section class="section-card">
        <i class="fa-solid fa-graduation-cap"></i>
        <h3>Formação</h3>
        <p><?php echo htmlspecialchars($prof['formacao']); ?></p>
      </section>
      <?php endif; ?>

      <?php if(!empty($prof['disciplina'])): ?>
      <section class="section-card">
        <i class="fa-solid fa-book-open"></i>
        <h3>Disciplinas</h3>
        <p><?php echo htmlspecialchars($prof['disciplina']); ?></p>
      </section>
      <?php endif; ?>

      <section class="section-card">
        <i class="fa-solid fa-pen"></i>
        <h3>Produções Acadêmicas</h3>
        
        <?php if ($producoes->num_rows > 0): ?>
            <ul style="text-align: left; list-style: none; padding: 0;">
                <?php while($prod = $producoes->fetch_assoc()): ?>
                    <li style="margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px;">
                        <strong><?php echo htmlspecialchars($prod['tipo']); ?>:</strong> 
                        <?php echo htmlspecialchars($prod['titulo']); ?> 
                        
                        <?php if($prod['link']): ?>
                            <a href="<?php echo htmlspecialchars($prod['link']); ?>" target="_blank" style="color: blue;">
                                <i class="fa-solid fa-external-link-alt"></i> Acessar
                            </a>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Nenhuma produção cadastrada.</p>
        <?php endif; ?>
      </section>

      <section class="section-card">
        <a href="menu-projetos.html">
          <i class="fa-solid fa-folder-open"></i>
          <h3>Ver Projetos</h3>
        </a>
      </section>

      <section class="section-card">
        <i class="fa-solid fa-envelope"></i>
        <h3>Contato</h3>
        
        <?php if(!empty($prof['email'])): ?>
            <p id="e-mail">E-mail: <a href="mailto:<?php echo $prof['email']; ?>"><?php echo $prof['email']; ?></a></p>
        <?php endif; ?>

        <?php if(!empty($prof['lattes'])): ?>
            <p id="lattes">Currículo Lattes: <a href="<?php echo $prof['lattes']; ?>" target="_blank">Acessar Lattes</a></p>
        <?php endif; ?>

        <?php if(!empty($prof['linkedin'])): ?>
            <p id="outro">LinkedIn: <a href="<?php echo $prof['linkedin']; ?>" target="_blank">Acessar Perfil</a></p>
        <?php endif; ?>

        <?php if(!empty($prof['gabinete'])): ?>
            <p id="local"><strong>Gabinete/Área:</strong> <?php echo $prof['gabinete']; ?></p>
        <?php endif; ?>

        <?php if(!empty($prof['atendimento'])): ?>
            <p id="atendimento"><strong>Horário de Atendimento:</strong><br> <?php echo $prof['atendimento']; ?></p>
        <?php endif; ?>
      </section>
    </main>

    <footer>
      <div class="container">
        <div class="footer-content">
          <div id="footer-address">
            <h4>Endereço</h4>
            <p>Rua Afonso Sardinha, 90<br />Ouro Branco, MG - 36420-000</p>
          </div>
          <div id="footer-schedule">
            <h4>Funcionamento</h4>
            <p>Segunda a Sexta: 08h - 22h</p>
            <p>Sabado: 12h - 20h</p>
          </div>
          <div id="footer-contact">
            <h4>Contato</h4>
            <p>E-mail: secretaria.ourobranco@ifmg.edu.br</p>
            <p>Telefone: (31) 2137-5700</p>
          </div>
          <div id="footer-social">
            <h4>Redes Sociais</h4>
            <div class="social-icons">
              <a href="https://www.youtube.com/@IFMGCampusOuroBranco" target="_blank" aria-label="Youtube">
                <i class="fa-brands fa-youtube"></i>
              </a>
              <a href="https://www.instagram.com/ifmg.ourobranco" target="_blank" aria-label="Youtube">
                <i class="fa-brands fa-instagram"></i>
              </a>
              <a href="https://www.facebook.com/ifmgob" target="_blank" aria-label="Youtube">
                <i class="fa-brands fa-facebook"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div id="copyright">
        <p>
          &copy; 2025 Instituto Federal de Minas Gerais - Campus Ouro Branco
        </p>
      </div>
    </footer>
  </body>
</html>