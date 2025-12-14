<?php
include 'conexao.php';

// Busca todos os professores cadastrados no banco de dados
// Ordenamos por nome para ficar organizado
$sql = "SELECT * FROM professor ORDER BY nome ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Nossos Docentes | IFMG</title>

  <link rel="stylesheet" href="css/style-menu-prof.css" />

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
    <section class="theme">
      <div class="theme-content">
        <h1 class="theme-title">Nossos Docentes</h1>
        <p class="theme-desc">Conheça os professores da nossa instituição.</p>
      </div>
    </section>

    <section class="filtro-docentes">
      <div class="container">
        <div class="filtro-content">
          <div class="filtro-header">
            <h2>Filtrar por</h2>
            <div class="search-box">
              <input type="search" id="searchInput" placeholder="Nome do docente...">
            </div>
          </div>
          <form class="filtro-form">
            <h3>Gabinete / Área</h3>
            <div class="filtro-labels">
              <label for="adm">
                <input type="checkbox" id="adm" class="gabinete-checkbox" value="Administração"> Administração
              </label>
              <label for="humanas">
                <input type="checkbox" id="humanas" class="gabinete-checkbox" value="Humanas"> Humanas
              </label>
              <label for="informatica">
                <input type="checkbox" id="informatica" class="gabinete-checkbox" value="Informática"> Informática
              </label>
              <label for="linguagens">
                <input type="checkbox" id="linguagens" class="gabinete-checkbox" value="Linguagens"> Linguagens
              </label>
              <label for="matematica">
                <input type="checkbox" id="matematica" class="gabinete-checkbox" value="Matemática"> Matemática
              </label>
              <label for="metalurgia">
                <input type="checkbox" id="metalurgia" class="gabinete-checkbox" value="Metalurgia"> Metalurgia
              </label>
              <label for="naturezas">
                <input type="checkbox" id="naturezas" class="gabinete-checkbox" value="Naturezas"> Naturezas
              </label>
            </div>
            <button type="button" id="filterButton" class="filtro-button">Filtrar</button>
          </form>
        </div>
      </div>
    </section>

    <section class="grid-docentes">
      <div class="container">
        <div class="grid-cards" id="docentesContainer">

          <?php
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              // Define imagem padrão se não tiver
              $img = !empty($row['pfp']) ? $row['pfp'] : 'https://via.placeholder.com/300x250?text=Sem+Foto';

              // Tratamento para garantir que atributos HTML fiquem corretos
              $nome = htmlspecialchars($row['nome']);
              $gabinete = htmlspecialchars($row['gabinete']);
              $formacao = htmlspecialchars($row['formacao']);

              // Gera o Card HTML dinamicamente
              // Importante: data-nome e data-gabinete são usados pelo JavaScript de filtro
              echo "
                    <div class='card-docente' data-nome='$nome' data-gabinete='$gabinete'>
                      <div class='docente-imagem'>
                        <a href='perfil-prof.php?id={$row['id']}'>
                          <img src='$img' alt='Foto de $nome' style='width:100%; height:100%; object-fit:cover;'>
                        </a>
                      </div>
                      <div class='docente-info'>
                        <a href='perfil-prof.php?id={$row['id']}'>
                            <h3>$nome</h3>
                        </a>
                        <p>$formacao</p>
                        <small style='color:green'>$gabinete</small>
                      </div>
                    </div>
                    ";
            }
          } else {
            echo "<p style='text-align:center; width:100%;'>Nenhum docente cadastrado ainda.</p>";
          }
          ?>

        </div>
      </div>
    </section>
  </main>

  <footer>
    <div class="container">
      <div class="footer-content">
        <div class="footer-address">
          <h4>Endereço</h4>
          <p>Rua Afonso Sardinha, 90<br />Ouro Branco, MG - 36420-000</p>
        </div>
        <div class="footer-schedule">
          <h4>Funcionamento</h4>
          <p>Segunda a Sexta: 08h - 22h</p>
          <p>Sábado: 12h - 20h</p>
        </div>
        <div class="footer-contact">
          <h4>Contato</h4>
          <p>E-mail: secretaria.ourobranco@ifmg.edu.br</p>
          <p>Telefone: (31) 2137-5700</p>
        </div>
        <div class="footer-social">
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

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const searchInput = document.getElementById('searchInput');
      const filterButton = document.getElementById('filterButton'); // Botão opcional
      const gabineteCheckboxes = document.querySelectorAll('.gabinete-checkbox');
      const docenteCards = document.querySelectorAll('.card-docente');

      function filtrarDocentes() {
        // Normaliza texto para busca (remove acentos e minúsculas)
        const searchTerm = searchInput.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");

        const selectedGabinetes = [];
        gabineteCheckboxes.forEach(checkbox => {
          if (checkbox.checked) {
            selectedGabinetes.push(checkbox.value);
          }
        });

        docenteCards.forEach(card => {
          // Pega os dados dos atributos data-*
          const nomeRaw = card.getAttribute('data-nome').toLowerCase();
          const nomeNormalized = nomeRaw.normalize("NFD").replace(/[\u0300-\u036f]/g, "");

          const gabinete = card.getAttribute('data-gabinete');

          // Lógica de match
          const nomeMatch = searchTerm === '' || nomeNormalized.includes(searchTerm);
          const gabineteMatch = selectedGabinetes.length === 0 || selectedGabinetes.includes(gabinete);

          if (nomeMatch && gabineteMatch) {
            card.style.display = 'block';
          } else {
            card.style.display = 'none';
          }
        });
      }

      // Filtra em tempo real ao digitar
      searchInput.addEventListener('input', filtrarDocentes);

      // Filtra ao clicar nos checkboxes
      gabineteCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', filtrarDocentes);
      });

      // Mantém funcionalidade do botão se o usuário preferir clicar
      if (filterButton) {
        filterButton.addEventListener('click', filtrarDocentes);
      }
    });
  </script>

</body>

</html>