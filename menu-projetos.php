<?php
include 'conexao.php';

// Busca todos os projetos cadastrados
// Ordena pelos mais recentes (data_inicio)
$sql = "SELECT * FROM projeto ORDER BY data_inicio DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nossos Projetos | IFMG</title>

  <link rel="stylesheet" href="style-menu-projetos.css">

  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
  <header>
    <div class="container header-content">
      <a href="menu-principal.php" id="logo-link" aria-label="Voltar para a página inicial">
        <img src="img/logo-b.png" alt="Logo do IFMG Campus Ouro Branco" id="logo">
      </a>
      
      <button class="menu-toggle" aria-label="Abrir menu de navegação">
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
    <section class="theme">
      <div class="theme-overlay"></div>
      <div class="theme-content">
        <h1 class="theme-title">Nossos Projetos</h1>
        <p class="theme-desc">Iniciativas que conectam ciência, tecnologia e sociedade.</p>
      </div>
    </section>

    <section class="filtro-section">
      <div class="container">
        <div class="filtro-box">
          <div class="filtro-top">
            <div class="search-wrapper">
               <i class="fa-solid fa-search"></i>
               <input type="text" id="searchInput" placeholder="Buscar projeto por título ou autor...">
            </div>
            <div class="filter-label">
               <i class="fa-solid fa-filter"></i> Filtrar por Área:
            </div>
          </div>

          <form class="filtro-form" onsubmit="event.preventDefault()">
             <div class="filtro-opcoes">
                <label class="checkbox-container">
                  <input type="checkbox" value="Informática" class="filtro-area">
                  <span class="checkmark"></span> Informática
                </label>
                <label class="checkbox-container">
                  <input type="checkbox" value="Metalurgia" class="filtro-area">
                  <span class="checkmark"></span> Metalurgia
                </label>
                <label class="checkbox-container">
                  <input type="checkbox" value="Administração" class="filtro-area">
                  <span class="checkmark"></span> Administração
                </label>
                <label class="checkbox-container">
                  <input type="checkbox" value="Engenharias" class="filtro-area">
                  <span class="checkmark"></span> Engenharias
                </label>
                <label class="checkbox-container">
                  <input type="checkbox" value="Ciências" class="filtro-area">
                  <span class="checkmark"></span> Ciências
                </label>
                <label class="checkbox-container">
                  <input type="checkbox" value="Humanas" class="filtro-area">
                  <span class="checkmark"></span> Humanas
                </label>
                <label class="checkbox-container">
                  <input type="checkbox" value="Pedagogia" class="filtro-area">
                  <span class="checkmark"></span> Pedagogia
                </label>
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
              // Limita a descrição a 110 caracteres
              $descricao = htmlspecialchars(substr($row['descricao'], 0, 110)) . (strlen($row['descricao']) > 110 ? '...' : '');
              $status = htmlspecialchars($row['status']);
              $autor = htmlspecialchars($row['autor']);

              // Define classe de cor para o status
              $statusClass = 'status-pausado';
              if ($status == 'Em andamento') $statusClass = 'status-andamento';
              if ($status == 'Concluído') $statusClass = 'status-concluido';

              echo "
              <article class='card-projeto' data-titulo='$titulo' data-autor='$autor' data-area='$area'>
                <div class='projeto-header'>
                   <span class='projeto-area'><i class='fa-solid fa-tag'></i> $area</span>
                   <span class='projeto-status $statusClass'>$status</span>
                </div>
                
                <div class='projeto-body'>
                  <a href='pag-projeto.php?id=$id' class='projeto-titulo'>$titulo</a>
                  <p class='projeto-autor'><i class='fa-solid fa-user-pen'></i> $autor</p>
                  <p class='projeto-desc'>$descricao</p>
                </div>

                <div class='projeto-footer'>
                   <a href='pag-projeto.php?id=$id' class='btn-ver'>
                     Ver Detalhes <i class='fa-solid fa-arrow-right'></i>
                   </a>
                </div>
              </article>
              ";
            }
          } else {
            echo "<div class='empty-state'><p>Nenhum projeto cadastrado no momento.</p></div>";
          }
          ?>
        </div>

        <div id="no-results" style="display: none; text-align: center; padding: 50px; color: #666;">
            <i class="fa-solid fa-folder-open" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.5;"></i>
            <p>Nenhum projeto encontrado com os filtros atuais.</p>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Menu Mobile
        document.querySelector('.menu-toggle').addEventListener('click', function() {
           document.querySelector('.nav-items').classList.toggle('active');
        });

        const searchInput = document.getElementById('searchInput');
        const areaCheckboxes = document.querySelectorAll('.filtro-area');
        const projetoCards = document.querySelectorAll('.card-projeto');
        const btnLimpar = document.getElementById('btn-limpar');
        const noResultsMsg = document.getElementById('no-results');

        function filtrarProjetos() {
            // Normaliza texto para busca (remove acentos e minúsculas)
            const searchTerm = searchInput.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            
            const selectedAreas = Array.from(areaCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value.toLowerCase());
            
            let visiveis = 0;

            projetoCards.forEach(card => {
                const titulo = card.getAttribute('data-titulo').toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                const autor = card.getAttribute('data-autor').toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                const area = card.getAttribute('data-area').toLowerCase();
                
                const textMatch = searchTerm === '' || titulo.includes(searchTerm) || autor.includes(searchTerm);
                
                // includes parcial para pegar subcategorias se houver
                const areaMatch = selectedAreas.length === 0 || selectedAreas.some(sel => area.includes(sel));
                
                if (textMatch && areaMatch) {
                    card.style.display = 'flex'; // Mantém flex para o layout do card
                    visiveis++;
                } else {
                    card.style.display = 'none';
                }
            });

            if(visiveis === 0) {
               noResultsMsg.style.display = 'block';
            } else {
               noResultsMsg.style.display = 'none';
            }
        }
        
        // Eventos
        searchInput.addEventListener('input', filtrarProjetos);
        
        areaCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', filtrarProjetos);
        });

        btnLimpar.addEventListener('click', function(){
            searchInput.value = '';
            areaCheckboxes.forEach(cb => cb.checked = false);
            filtrarProjetos();
        });
    });
  </script>
</body>
</html>