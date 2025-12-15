<?php
include 'conexao.php';

// 1. Verifica se foi passado um ID na URL (ex: pagina-projeto.php?id=1)
$id_projeto = $_GET['id'] ?? null;

if (!$id_projeto) {
    die("Projeto não selecionado. <a href='menu-projetos.php'>Voltar</a>");
}

// 2. Busca os dados do Projeto no Banco
$stmt = $conn->prepare("SELECT * FROM projeto WHERE id = ?");
$stmt->bind_param("i", $id_projeto);
$stmt->execute();
$result = $stmt->get_result();
$proj = $result->fetch_assoc();

if (!$proj) {
    die("Projeto não encontrado.");
}

// 3. Formatação de Datas e Status
$data_inicio = date('d/m/Y', strtotime($proj['data_inicio']));
$data_fim = $proj['data_fim'] ? date('d/m/Y', strtotime($proj['data_fim'])) : '---';

// Define a classe CSS baseada no status para ficar colorido corretamente
$status_class = 'pendente'; // Padrão cinza
if ($proj['status'] == 'Em andamento') {
    $status_class = 'ativo'; // Verde
} elseif ($proj['status'] == 'Concluído') {
    $status_class = 'concluido'; // Azul
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto: <?php echo htmlspecialchars($proj['titulo']); ?> | IFMG</title>

    <link rel="stylesheet" href="css/style-pagina-projeto.css">
    <link
        href="https://fonts.googleapis.com/css2?family=League+Spartan&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:wght@200&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@700&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
    <header>
        <div class="container">
            <a href="menu-principal.php" id="logo-link">
                <img src="img/logo-b.png" alt="IFMG Campus Ouro Branco" id="logo" />
            </a>
            <nav class="nav-items">
                <a href="menu-cursos.php">CURSOS</a>
                <a href="menu-lab.html">LABORATÓRIOS</a>
                <a href="menu-docentes.php">DOCENTES</a>
                <a href="menu-projetos.php">PROJETOS</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="projeto-header">
            <div class="container">
                <div class="breadcrumb">
                    <a href="menu-projetos.php"><i class="fas fa-arrow-left"></i> Voltar para Projetos</a>
                </div>
                <div class="header-content">
                    <span class="area-badge"><?php echo htmlspecialchars($proj['area_conhecimento']); ?></span>
                    <h1 class="projeto-titulo"><?php echo htmlspecialchars($proj['titulo']); ?></h1>
                    <div class="projeto-meta">
                        <div class="meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Início: <strong><?php echo $data_inicio; ?></strong></span>
                        </div>
                        <?php if ($proj['data_fim']): ?>
                            <div class="meta-item">
                                <i class="fas fa-calendar-check"></i>
                                <span>Término: <strong><?php echo $data_fim; ?></strong></span>
                            </div>
                        <?php endif; ?>
                        <div class="meta-item">
                            <i class="fas fa-chart-line"></i>
                            <span>Status: <span
                                    class="status <?php echo $status_class; ?>"><?php echo htmlspecialchars($proj['status']); ?></span></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="projeto-conteudo">
            <div class="container">
                <div class="conteudo-grid">
                    <div class="coluna-principal">
                        <div class="card">
                            <h2><i class="fas fa-align-left"></i> Descrição do Projeto</h2>
                            <div class="card-content">
                                <p><?php echo nl2br(htmlspecialchars($proj['descricao'])); ?></p>

                                <?php if (!empty($proj['objetivos'])): ?>
                                    <h3>Objetivos</h3>
                                    <p><?php echo nl2br(htmlspecialchars($proj['objetivos'])); ?></p>
                                <?php endif; ?>

                                <?php if (!empty($proj['resultados'])): ?>
                                    <h3>Resultados Esperados/Alcançados</h3>
                                    <p><?php echo nl2br(htmlspecialchars($proj['resultados'])); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="card">
                            <h2><i class="fas fa-images"></i> Galeria do Projeto</h2>
                            <div class="card-content">
                                <p style="color: #666; font-style: italic;">Imagens ilustrativas</p>
                                <div class="galeria-projeto">
                                    <div class="galeria-item">
                                        <img src="img/sci.jpg" alt="Imagem do projeto">
                                    </div>
                                    <div class="galeria-item">
                                        <img src="img/comp.jpg" alt="Imagem do projeto">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="coluna-lateral">
                        <div class="card">
                            <h2><i class="fas fa-info-circle"></i> Informações do Projeto</h2>
                            <div class="card-content">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-user"></i>
                                        <span>Autor Principal</span>
                                    </div>
                                    <div class="info-value">
                                        <strong><?php echo htmlspecialchars($proj['autor']); ?></strong>
                                    </div>
                                </div>

                                <?php if (!empty($proj['alunos_envolvidos'])): ?>
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-graduation-cap"></i>
                                            <span>Alunos Envolvidos</span>
                                        </div>
                                        <div class="info-value">
                                            <p><?php echo nl2br(htmlspecialchars($proj['alunos_envolvidos'])); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($proj['agencia_financiadora'])): ?>
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-university"></i>
                                            <span>Agência Financiadora</span>
                                        </div>
                                        <div class="info-value">
                                            <strong><?php echo htmlspecialchars($proj['agencia_financiadora']); ?></strong>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($proj['financiamento']) && $proj['financiamento'] > 0): ?>
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-money-bill-wave"></i>
                                            <span>Financiamento</span>
                                        </div>
                                        <div class="info-value">
                                            <div class="valor-financiamento">
                                                <span class="valor">R$
                                                    <?php echo number_format($proj['financiamento'], 2, ',', '.'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($proj['links'])): ?>
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-link"></i>
                                            <span>Links Relacionados</span>
                                        </div>
                                        <div class="info-value">
                                            <?php
                                            $links = preg_split('/[\n,]+/', $proj['links']);
                                            foreach ($links as $link):
                                                $link = trim($link);
                                                if (!empty($link)):
                                                    ?>
                                                    <a href="<?php echo $link; ?>" target="_blank" class="link-projeto"><i
                                                            class="fas fa-external-link-alt"></i> Acessar Link</a>
                                                    <?php
                                                endif;
                                            endforeach;
                                            ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="projeto-contato">
            <div class="container">
                <div class="card">
                    <h2><i class="fas fa-envelope"></i> Contato e Informações</h2>
                    <div class="card-content">
                        <p>Para mais informações sobre este projeto, entre em contato com a secretaria ou com o autor
                            responsável.</p>
                        <div class="contato-info">
                            <div class="contato-item">
                                <i class="fas fa-user"></i>
                                <div>
                                    <strong><?php echo htmlspecialchars($proj['autor']); ?></strong>
                                    <p>Coordenador do Projeto</p>
                                </div>
                            </div>
                            <div class="contato-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <div>
                                    <strong>IFMG Campus Ouro Branco</strong>
                                    <p><?php echo htmlspecialchars($proj['area_conhecimento']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-address">
                    <h4>Endereço</h4>
                    <p>Rua Afonso Sardinha, 90<br>Ouro Branco, MG - 36420-000</p>
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
            <p>&copy; 2025 Instituto Federal de Minas Gerais - Campus Ouro Branco</p>
        </div>
    </footer>
</body>

</html>