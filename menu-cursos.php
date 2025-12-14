<?php
include 'conexao.php';

// Busca todos os cursos cadastrados
$sql = "SELECT * FROM curso ORDER BY nome ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Nossos Cursos | IFMG</title>

  <link rel="stylesheet" href="css/style-menu-cursos.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=League+Spartan&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:wght@200&display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@700&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>

<body>
  <header>
    <div class="container">
      <a href="menu-principal.php" id="logo-link">
        <img src="img/logo-b.png" alt="" id="logo" />
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
    <section class="theme" style="background-color: greenyellow">
      <div class="theme-content">
        <h1 class="theme-title">Nossos Cursos</h1>
        <p class="theme-desc">Conheça os cursos oferecidos pela nossa instituição.</p>
      </div>
    </section>
    
    <section>
          <?php
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $img = !empty($row['imagem']) ? $row['imagem'] : 'img/escola.png';
              $nome = htmlspecialchars($row['nome']);
              $id = $row['id'];

              echo "
                            <div class='galeria-item'>
                                <a href='pagina-curso.php?id=$id'>
                                    <img src='$img' alt='Imagem do curso de $nome' style='width: 100%; height: 250px; object-fit: cover;'>
                                </a>
                                <div class='galeria-caption'>
                                    <a href='pagina-curso.php?id=$id' style='text-decoration:none; color:inherit;'>
                                        $nome
                                    </a>
                                </div>
                            </div>
                            ";
            }
          } else {
            echo "<p style='text-align:center; width:100%; grid-column: 1/-1;'>Nenhum curso cadastrado no momento.</p>";
          }
          ?>

        </div>
      </div>
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
          <p>Sábado: 12h - 20h</p>
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
            <a href="https://www.instagram.com/ifmg.ourobranco" target="_blank" aria-label="Instagram">
              <i class="fa-brands fa-instagram"></i>
            </a>
            <a href="https://www.facebook.com/ifmgob" target="_blank" aria-label="Facebook">
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