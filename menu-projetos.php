<?php
include 'conexao.php';

// Busca todos os projetos ordenados pela data de início (mais recentes primeiro)
$sql = "SELECT * FROM projeto ORDER BY data_inicio DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Projetos de Pesquisa e Extensão | IFMG Ouro Branco</title>
  <meta name="description"
    content="Conheça os projetos de pesquisa, ensino e extensão do IFMG Campus Ouro Branco. Inovação, tecnologia e desenvolvimento acadêmico." />

  <link rel="stylesheet" href="style-menu-projetos.css">
  <link rel="stylesheet" href="css/style-menu-projetos.css">
  <link
    href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@700&family=Poppins:wght@300;400;600&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

  <header>
    <div class="container header-content">
      <a href="menu-principal.php" id="logo-link" aria-label="Voltar para a página inicial">
        <img src="img/logo-b.png" alt="Logo do IFMG Campus Ouro Branco" id="logo">
      </a>

      <button class="menu-toggle" aria-label="Abrir menu">
        <i class="fa-solid fa-bars"></i>
      </button>

      <nav class="nav-items">
        <a href="menu-cursos.php">Cursos</a>
        <a href="menu-lab.html">Laboratórios</a>
        <a href="menu-docentes.php">Docentes</a>
        <a href="menu-projetos.php" class="active">Projetos</a>
        <a href="login.php" class="btn-login">Acesso Restrito</a>
      </nav>
    </div>
  </header>

  <main>
    <section class="theme" style="background-image: url('img/projetos-bg.jpg');">
      <div class="theme-overlay"></div>
      <div class="theme-content">
        <h1 class="theme-title">Nossos Projetos</h1>
        <p class="theme-desc">Ciência, tecnologia e inovação desenvolvidas no campus.</p>
      </div>
    </section>

    <section class="filtro-section">
      <div class="container">
        <div class="filtro-box">

          <div class="filtro-top">
            <div class="search-wrapper">
              <i class="fa-solid fa-search"></i>
              <input type="text" id="searchInput" placeholder="Buscar por título, professor ou palavra-chave...">
            </div>
            <div class="filter-label">
              <i class="fa-solid fa-filter"></i> Áreas de Conhecimento:
            </div>
          </div>

          <form class="filtro-form" onsubmit="event.preventDefault()">
            <div class="filtro-opcoes">
              <?php
              $areas = ['Informática', 'Metalurgia', 'Administração', 'Engenharias', 'Ciências', 'Humanas', 'Pedagogia'];
              foreach ($areas as $area) {
                echo "
                    <label class='checkbox-container'>
                      <input type='checkbox' value='$area' class='filtro-area'>
                      <span class='checkmark'></span> $area
                    </label>";
              }
              ?>
            </div>
            <button type="button" id="btn-limpar" class="btn-filtrar">Limpar Filtros</button>
          </form>

        </div>
      </div>
    </section>

    <section class="projetos-section">
      <div class="container">
        <div class="grid-projetos" id="projetosContainer">
          <?php
          if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $id = $row['id'];
              $titulo = htmlspecialchars($row['titulo']);
              $area = htmlspecialchars($row['area_conhecimento']);
              $status = htmlspecialchars($row['status']);
              $autor = htmlspecialchars($row['autor']); // Aqui virá "Prof. A, Prof. B"
          
              // Resumo da descrição
              $descricao = htmlspecialchars(strip_tags($row['descricao']));
              if (strlen($descricao) > 120) {
                $descricao = substr($descricao, 0, 120) . "...";
              }

              // Classes de cor para o status
              $statusClass = 'status-pausado';
              if ($status == 'Em andamento')
                $statusClass = 'status-andamento';
              if ($status == 'Concluído')
                $statusClass = 'status-concluido';

              // Renderiza o Card
              echo "
              <article class='card-projeto' data-titulo='$titulo' data-autor='$autor' data-area='$area'>
                
                <div class='projeto-header'>
                    <div class='badges'>
                        <span class='badge-area'><i class='fa-solid fa-tag'></i> $area</span>
                        <span class='badge-status $statusClass'>$status</span>
                    </div>
                </div>
                
                <div class='projeto-body'>
                  <a href='pagina-projeto.php?id=$id' class='projeto-titulo'>$titulo</a>
                  
                  <div class='projeto-meta'>
                    <p class='projeto-autor' title='$autor'>
                        <i class='fa-solid fa-users'></i> $autor
                    </p>
                  </div>
                  
                  <p class='projeto-desc'>$descricao</p>
                </div>

                <div class='projeto-footer'>
                   <a href='pagina-projeto.php?id=$id' class='btn-ver-detalhes'>
                     Ver Projeto <i class='fa-solid fa-arrow-right'></i>
                   </a>
                </div>
              </article>
              ";
            }
          } else {
            echo "<div class='empty-state'><p>Nenhum projeto encontrado.</p></div>";
          }
          ?>
        </div>

        <div id="no-results" style="display: none;">
          <i class="fa-regular fa-folder-open"></i>
          <p>Nenhum projeto corresponde à sua busca.</p>
        </div>

      </div>
    </section>
  </main>

  <footer>
    <div class="container">
      <div class="footer-content">
        <div class="footer-section">
          <h4>Endereço</h4>
          <p><i class="fa-solid fa-location-dot"></i> Rua Afonso Sardinha, 90<br>Ouro Branco, MG - 36420-000</p>
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
    document.querySelector('.menu-toggle').addEventListener('click', function () {
      document.querySelector('.nav-items').classList.toggle('active');
    });

    // Lógica de Filtragem (Javascript Puro)
    document.addEventListener('DOMContentLoaded', function () {
      const searchInput = document.getElementById('searchInput');
      const areaCheckboxes = document.querySelectorAll('.filtro-area');
      const cards = document.querySelectorAll('.card-projeto');
      const noResults = document.getElementById('no-results');
      const btnLimpar = document.getElementById('btn-limpar');

      function filtrar() {
        // Normaliza o termo de busca (sem acentos, minúsculo)
        const termo = searchInput.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");

        // Pega áreas selecionadas
        const areasSelecionadas = Array.from(areaCheckboxes)
          .filter(cb => cb.checked)
          .map(cb => cb.value.toLowerCase());

        let visiveis = 0;

        cards.forEach(card => {
          const titulo = card.getAttribute('data-titulo').toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
          const autor = card.getAttribute('data-autor').toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
          const area = card.getAttribute('data-area').toLowerCase();

          // Verifica Busca Texto (Título OU Autor)
          const matchTexto = termo === '' || titulo.includes(termo) || autor.includes(termo);

          // Verifica Área (Se nenhuma marcada, mostra tudo. Senão, verifica se a área está na lista)
          const matchArea = areasSelecionadas.length === 0 || areasSelecionadas.some(sel => area.includes(sel));

          if (matchTexto && matchArea) {
            card.style.display = 'flex';
            visiveis++;
          } else {
            card.style.display = 'none';
          }
        });

        // Mostra/Esconde mensagem de "Sem resultados"
        noResults.style.display = (visiveis === 0) ? 'block' : 'none';
      }

      // Listeners
      searchInput.addEventListener('input', filtrar);
      areaCheckboxes.forEach(cb => cb.addEventListener('change', filtrar));

      btnLimpar.addEventListener('click', () => {
        searchInput.value = '';
        areaCheckboxes.forEach(cb => cb.checked = false);
        filtrar();
      });
    });
  </script>
</body>

</html>