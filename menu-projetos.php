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

    <link
        href="https://fonts.googleapis.com/css2?family=League+Spartan&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:wght@200&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@700&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link rel="stylesheet" href="css/style-menu-projetos.css">

    <style>
        /* Estilos adicionais para os Cards de Projeto (inspirado no menu-docentes) */
        .grid-projetos {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            padding: 40px 0;
        }

        .card-projeto {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-top: 4px solid #006400;
            /* Cor primária */
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .card-projeto:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .projeto-body {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .projeto-area {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #777;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .projeto-titulo {
            font-family: "League Spartan", sans-serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: #006400;
            margin-bottom: 15px;
            text-decoration: none;
            line-height: 1.3;
        }

        .projeto-desc {
            color: #555;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 20px;
            flex-grow: 1;
            /* Empurra o rodapé do card para baixo */
        }

        .projeto-footer {
            margin-top: auto;
            padding-top: 15px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .projeto-status {
            font-size: 0.85rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 15px;
        }

        .status-andamento {
            background-color: #e6ffe6;
            color: #008000;
        }

        .status-concluido {
            background-color: #e6f7ff;
            color: #0056b3;
        }

        .status-pausado {
            background-color: #f8f9fa;
            color: #6c757d;
        }

        .btn-ver {
            color: #006400;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-ver:hover {
            text-decoration: underline;
        }

        /* Estilo do filtro (reaproveitado visualmente) */
        .filtro-container {
            background-color: #f4f4f9;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 40px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .search-box {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .filtro-areas {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .area-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            background: white;
            padding: 8px 15px;
            border-radius: 20px;
            border: 1px solid #ddd;
            transition: all 0.2s;
        }

        .area-checkbox:hover {
            border-color: #006400;
        }

        .area-checkbox input {
            accent-color: #006400;
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <a href="menu-principal.php" id="logo-link">
                <img src="img/logo-b.png" alt="IFMG Campus Ouro Branco" id="logo">
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
                <h1 class="theme-title">Nossos Projetos</h1>
                <p class="theme-desc">Conheça os projetos da nossa instituição.</p>
            </div>
        </section>

        <section class="projetos">
            <div class="container">
                <div class="filtro-container">
                    <input type="text" id="searchInput" class="search-box"
                        placeholder="Buscar projeto por título ou autor...">

                    <div class="filtro-areas">
                        <strong>Filtrar por Área:</strong>
                        <label class="area-checkbox"><input type="checkbox" value="Informática" class="filtro-area">
                            Informática</label>
                        <label class="area-checkbox"><input type="checkbox" value="Metalurgia" class="filtro-area">
                            Metalurgia</label>
                        <label class="area-checkbox"><input type="checkbox" value="Administração" class="filtro-area">
                            Administração</label>
                        <label class="area-checkbox"><input type="checkbox" value="Engenharias" class="filtro-area">
                            Engenharias</label>
                        <label class="area-checkbox"><input type="checkbox" value="Ciências" class="filtro-area">
                            Ciências</label>
                        <label class="area-checkbox"><input type="checkbox" value="Humanas" class="filtro-area">
                            Humanas</label>
                        <label class="area-checkbox"><input type="checkbox" value="Pedagogia" class="filtro-area">
                            Pedagogia</label>
                    </div>
                </div>

                <div class="grid-projetos" id="projetosContainer">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['id'];
                            $titulo = htmlspecialchars($row['titulo']);
                            $area = htmlspecialchars($row['area_conhecimento']);
                            // Limita a descrição a 120 caracteres para não quebrar o card
                            $descricao = htmlspecialchars(substr($row['descricao'], 0, 120)) . (strlen($row['descricao']) > 120 ? '...' : '');
                            $status = htmlspecialchars($row['status']);
                            $autor = htmlspecialchars($row['autor']);

                            // Define classe de cor para o status
                            $statusClass = 'status-pausado';
                            if ($status == 'Em andamento')
                                $statusClass = 'status-andamento';
                            if ($status == 'Concluído')
                                $statusClass = 'status-concluido';

                            echo "
                            <div class='card-projeto' data-titulo='$titulo' data-autor='$autor' data-area='$area'>
                                <div class='projeto-body'>
                                    <span class='projeto-area'><i class='fa-solid fa-tag'></i> $area</span>
                                    <a href='pag-projeto.php?id=$id' class='projeto-titulo'>$titulo</a>
                                    <p class='projeto-desc'>$descricao</p>
                                    
                                    <div class='projeto-footer'>
                                        <span class='projeto-status $statusClass'>$status</span>
                                        <a href='pag-projeto.php?id=$id' class='btn-ver'>Ver Detalhes <i class='fa-solid fa-arrow-right'></i></a>
                                    </div>
                                </div>
                            </div>
                            ";
                        }
                    } else {
                        echo "<p style='text-align:center; width:100%; font-size:1.2rem; color:#666;'>Nenhum projeto cadastrado no momento.</p>";
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
                    <p>Rua Afonso Sardinha, 90<br>Ouro Branco, MG - 36420-000</p>
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
            <p>&copy; 2025 Instituto Federal de Minas Gerais - Campus Ouro Branco</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const areaCheckboxes = document.querySelectorAll('.filtro-area');
            const projetoCards = document.querySelectorAll('.card-projeto');

            function filtrarProjetos() {
                // Normaliza texto para busca (remove acentos e minúsculas)
                const searchTerm = searchInput.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");

                const selectedAreas = [];
                areaCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedAreas.push(checkbox.value.toLowerCase());
                    }
                });

                projetoCards.forEach(card => {
                    // Pega os dados dos atributos data-*
                    const titulo = card.getAttribute('data-titulo').toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                    const autor = card.getAttribute('data-autor').toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                    const area = card.getAttribute('data-area').toLowerCase();

                    // Lógica de match (busca no título OU no autor)
                    const textMatch = searchTerm === '' || titulo.includes(searchTerm) || autor.includes(searchTerm);

                    // Verifica se a área do projeto está nas áreas selecionadas (ou se nenhuma foi selecionada)
                    // Usamos 'includes' parcial para pegar casos como "Engenharia de Software" se o filtro for "Engenharia"
                    const areaMatch = selectedAreas.length === 0 || selectedAreas.some(sel => area.includes(sel));

                    if (textMatch && areaMatch) {
                        card.style.display = 'flex'; // Flex para manter o layout do card
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            // Filtra em tempo real ao digitar
            searchInput.addEventListener('input', filtrarProjetos);

            // Filtra ao clicar nos checkboxes
            areaCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', filtrarProjetos);
            });
        });
    </script>
</body>

</html>