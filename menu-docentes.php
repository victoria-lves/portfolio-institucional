<?php
include 'conexao.php';

// Busca todos os professores cadastrados
$sql = "SELECT * FROM professor ORDER BY nome ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Nossos Docentes | IFMG</title>

  <link rel="stylesheet" href="style-menu-docentes.css" />

  <link
    href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@700&family=Poppins:wght@300;400;600&display=swap"
    rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
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
        <a href="menu-cursos.php">Cursos</a>
        <a href="menu-lab.html">Laboratórios</a>
        <a href="menu-docentes.php" class="active">Docentes</a>
        <a href="menu-projetos.php">Projetos</a>
        <a href="login.php" class="btn-login">Acesso Restrito</a>
      </nav>
    </div>
  </header>

  <main>
    <section class="theme">
      <div class="theme-overlay"></div>
      <div class="theme-content">
        <h1 class="theme-title">Corpo Docente</h1>
        <p class="theme-desc">Conheça os professores mestres e doutores dedicados à excelência no ensino.</p>
      </div>
    </section>

    <section class="filtro-section">
      <div class="container">
        <div class="filtro-box">

          <div class="filtro-top">
            <div class="search-wrapper">
              <i class="fa-solid fa-search"></i>
              <input type="search" id="searchInput" placeholder="Busque por nome do professor...">
            </div>
            <div class="filter-label">
              <i class="fa-solid fa-filter"></i> Filtrar por Área:
            </div>
          </div>

          <form class="filtro-form" onsubmit="event.preventDefault()">
            <div class="filtro-opcoes">
              <label class="checkbox-container">
                <input type="checkbox" value="Administração" class="gabinete-checkbox">
                <span class="checkmark"></span> Administração
              </label>
              <label class="checkbox-container">
                <input type="checkbox" value="Humanas" class="gabinete-checkbox">
                <span class="checkmark"></span> Humanas
              </label>
              <label class="checkbox-container">
                <input type="checkbox" value="Informática" class="gabinete-checkbox">
                <span class="checkmark"></span> Informática
              </label>
              <label class="checkbox-container">
                <input type="checkbox" value="Linguagens" class="gabinete-checkbox">
                <span class="checkmark"></span> Linguagens
              </label>
              <label class="checkbox-container">
                <input type="checkbox" value="Matemática" class="gabinete-checkbox">
                <span class="checkmark"></span> Matemática
              </label>
              <label class="checkbox-container">
                <input type="checkbox" value="Metalurgia" class="gabinete-checkbox">
                <span class="checkmark"></span> Metalurgia
              </label>
              <label class="checkbox-container">
                <input type="checkbox" value="Naturezas" class="gabinete-checkbox">
                <span class="checkmark"></span> Naturezas
              </label>
            </div>
            <button type="button" id="btn-limpar" class="btn-filtrar">Limpar Filtros</button>
          </form>
        </div>
      </div>
    </section>

    <section class="docentes-section">
      <div class="container">
        <div class="galeria-grid" id="docentesContainer">

          <?php
          if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              // Define imagem padrão se não tiver
              $img = !empty($row['pfp']) ? htmlspecialchars($row['pfp']) : 'https://via.placeholder.com/300x300?text=Sem+Foto';

              // Sanitização de dados
              $nome = htmlspecialchars($row['nome']);
              $gabinete = htmlspecialchars($row['gabinete']);
              $formacao = htmlspecialchars($row['formacao']);
              $id = $row['id'];

              // Define cor do badge baseado na área (opcional, visual extra)
              $badgeClass = strtolower($gabinete); // ex: informatica, metalurgia...
          
              echo "
              <article class='docente-card' data-nome='$nome' data-gabinete='$gabinete'>
                <div class='card-image'>
                  <a href='pagina-docente.php?id=$id'>
                    <img src='$img' alt='Foto de $nome' loading='lazy'>
                  </a>
                  <span class='card-badge'>$gabinete</span>
                </div>
                <div class='card-content'>
                  <h3 class='card-title'>
                    <a href='pagina-docente.php?id=$id'>$nome</a>
                  </h3>
                  <p class='card-info'>$formacao</p>
                  
                  <a href='pagina-docente.php?id=$id' class='btn-detalhes'>
                    Ver Perfil <i class='fa-solid fa-arrow-right'></i>
                  </a>
                </div>
              </article>
              ";
            }
          } else {
            echo "<div class='empty-state'><p>Nenhum docente cadastrado ainda.</p></div>";
          }
          ?>

        </div>

        <div id="no-results" style="display: none; text-align: center; padding: 50px; color: #666;">
          <i class="fa-solid fa-user-slash" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.5;"></i>
          <p>Nenhum professor encontrado com os filtros atuais.</p>
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
    document.addEventListener('DOMContentLoaded', function () {
      // Menu Mobile
      document.querySelector('.menu-toggle').addEventListener('click', function () {
        document.querySelector('.nav-items').classList.toggle('active');
      });

      // Lógica de Filtro
      const searchInput = document.getElementById('searchInput');
      const btnLimpar = document.getElementById('btn-limpar');
      const gabineteCheckboxes = document.querySelectorAll('.gabinete-checkbox');
      const docenteCards = document.querySelectorAll('.docente-card');
      const noResultsMsg = document.getElementById('no-results');

      function filtrarDocentes() {
        const searchTerm = searchInput.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");

        const selectedGabinetes = Array.from(gabineteCheckboxes)
          .filter(cb => cb.checked)
          .map(cb => cb.value);

        let visiveis = 0;

        docenteCards.forEach(card => {
          const nomeRaw = card.getAttribute('data-nome').toLowerCase();
          const nomeNormalized = nomeRaw.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
          const gabinete = card.getAttribute('data-gabinete');

          const nomeMatch = searchTerm === '' || nomeNormalized.includes(searchTerm);
          const gabineteMatch = selectedGabinetes.length === 0 || selectedGabinetes.includes(gabinete);

          if (nomeMatch && gabineteMatch) {
            card.style.display = 'flex'; // Flex para manter o layout do card
            visiveis++;
          } else {
            card.style.display = 'none';
          }
        });

        // Mostra mensagem se nenhum visível
        if (visiveis === 0) {
          noResultsMsg.style.display = 'block';
        } else {
          noResultsMsg.style.display = 'none';
        }
      }

      // Event Listeners
      searchInput.addEventListener('input', filtrarDocentes);

      gabineteCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', filtrarDocentes);
      });

      btnLimpar.addEventListener('click', function () {
        searchInput.value = '';
        gabineteCheckboxes.forEach(cb => cb.checked = false);
        filtrarDocentes();
      });
    });
  </script>
</body>

</html>