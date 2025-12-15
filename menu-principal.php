<?php
// Inicia sessão para verificar se está logado (opcional, apenas para ajustar o botão de login)
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFMG Ouro Branco | Futuro em Movimento</title>

    <link rel="stylesheet" href="style-menu-principal.css">

    <link
        href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@700;900&family=Poppins:wght@300;400;600&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>

<body>
    <header class="glass-header">
        <div class="container header-content">
            <a href="menu-principal.php" id="logo-link">
                <img src="img/logo-b.png" alt="Logo IFMG" id="logo" />
            </a>

            <input type="checkbox" id="menu-toggle" class="hidden-toggle">
            <label for="menu-toggle" class="menu-icon"><i class="fa-solid fa-bars"></i></label>

            <nav class="nav-items">
                <a href="menu-cursos.php">Cursos</a>
                <a href="menu-lab.html">Laboratórios</a>
                <a href="menu-docentes.php">Docentes</a>
                <a href="menu-projetos.php">Projetos</a>

                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a href="dashboard.php" class="btn-login logged-in"><i class="fa-solid fa-user"></i> Painel</a>
                <?php else: ?>
                    <a href="login.php" class="btn-login">Acesso Restrito</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero-cinematic">
            <div class="hero-bg-wrapper">
                <div class="hero-bg" style="background-image: url('img/escola.png');"></div>
                <div class="hero-bg" style="background-image: url('img/ifmg-camp.png'); animation-delay: 6s;"></div>
                <div class="hero-bg" style="background-image: url('img/if-school.jpg'); animation-delay: 12s;"></div>
            </div>

            <div class="hero-overlay">
                <div class="hero-text">
                    <span class="badge-pill">Instituição Nota Máxima</span>
                    <h1>Transforme o seu <br><span class="text-gradient">Futuro Agora</span></h1>
                    <p>Ensino público, gratuito e de excelência. Conectando teoria e prática em um ambiente inovador.
                    </p>

                    <div class="hero-buttons">
                        <a href="menu-cursos.php" class="btn-primary-glow">Conheça os Cursos</a>
                        <a href="#destaques" class="btn-outline-light">Saiba Mais</a>
                    </div>
                </div>
            </div>

            <div class="scroll-indicator">
                <span>Explore</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
        </section>

        <section id="destaques" class="features-section">
            <div class="container">
                <div class="feature-grid">
                    <div class="glass-card">
                        <div class="icon-box"><i class="fa-solid fa-graduation-cap"></i></div>
                        <h3>Ensino de Elite</h3>
                        <p>Professores mestres e doutores dedicados à formação integral do aluno.</p>
                    </div>
                    <div class="glass-card">
                        <div class="icon-box"><i class="fa-solid fa-flask"></i></div>
                        <h3>Pesquisa Aplicada</h3>
                        <p>Laboratórios de ponta para desenvolver projetos reais e inovadores.</p>
                    </div>
                    <div class="glass-card">
                        <div class="icon-box"><i class="fa-solid fa-rocket"></i></div>
                        <h3>Carreira Global</h3>
                        <p>Formação alinhada com as demandas do mercado de trabalho atual.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="parallax-separator" style="background-image: url('img/sci.jpg');">
            <div class="parallax-content">
                <h2>Faça parte da nossa história</h2>
                <p>Venha construir conhecimento no IFMG Campus Ouro Branco</p>
                <a href="https://www.ifmg.edu.br/ourobranco/" class="btn-white">Ver Processo Seletivo</a>
            </div>
        </section>

        <section class="info-section">
            <div class="container">
                <div class="section-header">
                    <h2>Últimos Projetos</h2>
                    <div class="line"></div>
                </div>
                <div class="info-grid">
                    <article class="info-item">
                        <img src="img/comp.jpg" alt="Projeto 1">
                        <div class="info-text">
                            <small>Tecnologia</small>
                            <h4>Desenvolvimento Web Moderno</h4>
                            <a href="menu-projetos.php">Ler mais <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </article>
                    <article class="info-item">
                        <img src="img/metalurgia.jpg" alt="Projeto 2">
                        <div class="info-text">
                            <small>Indústria</small>
                            <h4>Novos Materiais Sustentáveis</h4>
                            <a href="menu-projetos.php">Ler mais <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>Endereço</h4>
                    <p><i class="fa-solid fa-location-dot"></i> Rua Afonso Sardinha, 90<br />Ouro Branco, MG - 36420-000
                    </p>
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
</body>

</html>