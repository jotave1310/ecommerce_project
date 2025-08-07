<?php
session_start();

// Inicializar carrinho se não existir
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre - E-commerce Project</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="components.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .about-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: var(--spacing-xl) var(--spacing-lg);
        }
        
        .page-header {
            text-align: center;
            margin-bottom: var(--spacing-3xl);
            padding: var(--spacing-3xl) 0;
            background: linear-gradient(135deg, rgba(233, 69, 96, 0.1) 0%, rgba(15, 52, 96, 0.1) 100%);
            border-radius: var(--border-radius-xl);
            position: relative;
            overflow: hidden;
        }
        
        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(233, 69, 96, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(15, 52, 96, 0.05) 0%, transparent 50%);
            pointer-events: none;
        }
        
        .page-title {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 800;
            margin-bottom: var(--spacing-lg);
            background: linear-gradient(135deg, var(--text-light), var(--text-muted));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            z-index: 1;
        }
        
        .page-subtitle {
            font-size: 1.2rem;
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        
        .about-content {
            display: grid;
            gap: var(--spacing-3xl);
        }
        
        .about-section {
            background: var(--glass-bg);
            backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-xl);
            padding: var(--spacing-3xl);
            transition: all var(--transition-normal);
            position: relative;
            overflow: hidden;
        }
        
        .about-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.03), transparent);
            transition: left var(--transition-slow);
            pointer-events: none;
        }
        
        .about-section:hover::before {
            left: 100%;
        }
        
        .about-section:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
            border-color: rgba(255, 255, 255, 0.2);
        }
        
        .section-icon {
            font-size: 3rem;
            margin-bottom: var(--spacing-lg);
            display: block;
        }
        
        .section-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: var(--spacing-lg);
            position: relative;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border-radius: var(--border-radius-full);
        }
        
        .section-text {
            color: var(--text-muted);
            line-height: 1.7;
            font-size: 1.1rem;
            margin-bottom: var(--spacing-lg);
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--spacing-xl);
            margin-top: var(--spacing-xl);
        }
        
        .feature-item {
            background: rgba(255, 255, 255, 0.05);
            padding: var(--spacing-xl);
            border-radius: var(--border-radius-lg);
            border: 1px solid var(--glass-border);
            transition: all var(--transition-normal);
            text-align: center;
        }
        
        .feature-item:hover {
            transform: translateY(-4px);
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--primary-color);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: var(--spacing-md);
            display: block;
        }
        
        .feature-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: var(--spacing-sm);
        }
        
        .feature-description {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.5;
        }
        
        .tech-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--spacing-lg);
            margin-top: var(--spacing-xl);
        }
        
        .tech-item {
            background: rgba(255, 255, 255, 0.05);
            padding: var(--spacing-lg);
            border-radius: var(--border-radius-lg);
            border: 1px solid var(--glass-border);
            transition: all var(--transition-normal);
            display: flex;
            align-items: center;
            gap: var(--spacing-md);
        }
        
        .tech-item:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--primary-color);
        }
        
        .tech-icon {
            font-size: 2rem;
            flex-shrink: 0;
        }
        
        .tech-info {
            flex: 1;
        }
        
        .tech-name {
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: var(--spacing-xs);
        }
        
        .tech-description {
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--spacing-xl);
            margin-top: var(--spacing-xl);
        }
        
        .stat-item {
            text-align: center;
            padding: var(--spacing-xl);
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius-lg);
            border: 1px solid var(--glass-border);
            transition: all var(--transition-normal);
        }
        
        .stat-item:hover {
            transform: translateY(-4px);
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--primary-color);
        }
        
        .stat-number {
            font-family: 'Montserrat', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: var(--spacing-sm);
            display: block;
        }
        
        .stat-label {
            color: var(--text-light);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }
        
        .quote-section {
            background: linear-gradient(135deg, rgba(233, 69, 96, 0.1), rgba(15, 52, 96, 0.1));
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-xl);
            padding: var(--spacing-3xl);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .quote-section::before {
            content: '"';
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 8rem;
            color: rgba(233, 69, 96, 0.1);
            font-family: serif;
            pointer-events: none;
        }
        
        .quote-text {
            font-size: 1.5rem;
            font-style: italic;
            color: var(--text-light);
            margin-bottom: var(--spacing-lg);
            position: relative;
            z-index: 1;
        }
        
        .quote-author {
            color: var(--text-muted);
            font-weight: 500;
        }
        
        .timeline {
            position: relative;
            margin-top: var(--spacing-xl);
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, var(--primary-color), var(--accent-color));
            transform: translateX(-50%);
        }
        
        .timeline-item {
            display: flex;
            align-items: center;
            margin-bottom: var(--spacing-xl);
            position: relative;
        }
        
        .timeline-item:nth-child(even) {
            flex-direction: row-reverse;
        }
        
        .timeline-content {
            flex: 1;
            background: rgba(255, 255, 255, 0.05);
            padding: var(--spacing-xl);
            border-radius: var(--border-radius-lg);
            border: 1px solid var(--glass-border);
            margin: 0 var(--spacing-xl);
            transition: all var(--transition-normal);
        }
        
        .timeline-content:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--primary-color);
        }
        
        .timeline-date {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: var(--spacing-sm);
        }
        
        .timeline-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: var(--spacing-sm);
        }
        
        .timeline-description {
            color: var(--text-muted);
            font-size: 0.95rem;
        }
        
        .timeline-marker {
            width: 20px;
            height: 20px;
            background: var(--primary-color);
            border-radius: 50%;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
            border: 3px solid var(--dark-bg);
        }
        
        @media (max-width: 768px) {
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .tech-list {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .timeline::before {
                left: 20px;
            }
            
            .timeline-item {
                flex-direction: row !important;
                padding-left: var(--spacing-xl);
            }
            
            .timeline-marker {
                left: 20px;
            }
            
            .timeline-content {
                margin-left: var(--spacing-xl);
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <a href="index.php" class="logo">E-commerce Project</a>
                <nav>
                    <ul>
                        <li><a href="index.php">Início</a></li>
                        <li><a href="produtos_new.php">Produtos</a></li>
                        <li><a href="sobre_new.php">Sobre</a></li>
                        <li><a href="contato.php">Contato</a></li>
                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <li><a href="perfil.php">Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</a></li>
                            <?php if ($_SESSION['usuario_tipo'] == 'admin'): ?>
                                <li><a href="admin.php">Admin</a></li>
                            <?php endif; ?>
                            <li><a href="logout.php">Sair</a></li>
                        <?php else: ?>
                            <li><a href="login.php" class="btn-login">Login</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <a href="carrinho.php" class="cart-icon">
                    🛒 Carrinho (<?php echo array_sum($_SESSION['cart']); ?>)
                </a>
            </div>
        </div>
    </header>

    <main class="about-container">
        <div class="page-header">
            <h1 class="page-title">Sobre Nós</h1>
            <p class="page-subtitle">Conheça nossa história, missão e os valores que nos movem a oferecer a melhor experiência em tecnologia</p>
        </div>

        <div class="about-content">
            <div class="about-section">
                <span class="section-icon">🚀</span>
                <h2 class="section-title">Nossa Missão</h2>
                <p class="section-text">
                    O <strong>E-commerce Project</strong> nasceu com o objetivo de democratizar o acesso à tecnologia de ponta, 
                    oferecendo produtos de alta qualidade com preços justos e uma experiência de compra excepcional. 
                    Acreditamos que a tecnologia deve ser acessível a todos, transformando vidas e impulsionando o progresso.
                </p>
                <p class="section-text">
                    Nossa plataforma foi desenvolvida com as mais modernas tecnologias web, garantindo segurança, 
                    performance e uma interface intuitiva que proporciona uma jornada de compra fluida e agradável.
                </p>
            </div>

            <div class="about-section">
                <span class="section-icon">💡</span>
                <h2 class="section-title">Nossos Valores</h2>
                <div class="features-grid">
                    <div class="feature-item">
                        <span class="feature-icon">🎯</span>
                        <h3 class="feature-title">Excelência</h3>
                        <p class="feature-description">Buscamos sempre a perfeição em cada produto e serviço oferecido</p>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">🤝</span>
                        <h3 class="feature-title">Confiança</h3>
                        <p class="feature-description">Construímos relacionamentos duradouros baseados na transparência</p>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">⚡</span>
                        <h3 class="feature-title">Inovação</h3>
                        <p class="feature-description">Estamos sempre na vanguarda das tendências tecnológicas</p>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">🌟</span>
                        <h3 class="feature-title">Qualidade</h3>
                        <p class="feature-description">Selecionamos apenas produtos que atendem aos mais altos padrões</p>
                    </div>
                </div>
            </div>

            <div class="about-section">
                <span class="section-icon">⚙️</span>
                <h2 class="section-title">Tecnologias Utilizadas</h2>
                <p class="section-text">
                    Nossa plataforma foi construída utilizando tecnologias modernas e confiáveis, 
                    garantindo uma experiência robusta e segura para nossos clientes.
                </p>
                <div class="tech-list">
                    <div class="tech-item">
                        <span class="tech-icon">🐘</span>
                        <div class="tech-info">
                            <div class="tech-name">PHP 8+</div>
                            <div class="tech-description">Backend robusto e seguro</div>
                        </div>
                    </div>
                    <div class="tech-item">
                        <span class="tech-icon">🌐</span>
                        <div class="tech-info">
                            <div class="tech-name">HTML5</div>
                            <div class="tech-description">Estrutura semântica moderna</div>
                        </div>
                    </div>
                    <div class="tech-item">
                        <span class="tech-icon">🎨</span>
                        <div class="tech-info">
                            <div class="tech-name">CSS3</div>
                            <div class="tech-description">Design responsivo e elegante</div>
                        </div>
                    </div>
                    <div class="tech-item">
                        <span class="tech-icon">⚡</span>
                        <div class="tech-info">
                            <div class="tech-name">JavaScript</div>
                            <div class="tech-description">Interatividade avançada</div>
                        </div>
                    </div>
                    <div class="tech-item">
                        <span class="tech-icon">🗄️</span>
                        <div class="tech-info">
                            <div class="tech-name">MySQL</div>
                            <div class="tech-description">Banco de dados confiável</div>
                        </div>
                    </div>
                    <div class="tech-item">
                        <span class="tech-icon">🔧</span>
                        <div class="tech-info">
                            <div class="tech-name">Git</div>
                            <div class="tech-description">Controle de versão profissional</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="about-section">
                <span class="section-icon">📊</span>
                <h2 class="section-title">Nossos Números</h2>
                <p class="section-text">
                    Alguns números que demonstram nosso crescimento e o impacto positivo que temos gerado:
                </p>
                <div class="stats-grid">
                    <div class="stat-item">
                        <span class="stat-number">1000+</span>
                        <span class="stat-label">Produtos</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">5000+</span>
                        <span class="stat-label">Clientes</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">98%</span>
                        <span class="stat-label">Satisfação</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">24/7</span>
                        <span class="stat-label">Suporte</span>
                    </div>
                </div>
            </div>

            <div class="about-section">
                <span class="section-icon">🛠️</span>
                <h2 class="section-title">Funcionalidades da Plataforma</h2>
                <div class="features-grid">
                    <div class="feature-item">
                        <span class="feature-icon">🛒</span>
                        <h3 class="feature-title">Carrinho Inteligente</h3>
                        <p class="feature-description">Sistema de carrinho com persistência de sessão e cálculos automáticos</p>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">🔍</span>
                        <h3 class="feature-title">Busca Avançada</h3>
                        <p class="feature-description">Filtros inteligentes por categoria, preço e características</p>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">📱</span>
                        <h3 class="feature-title">Design Responsivo</h3>
                        <p class="feature-description">Experiência otimizada para todos os dispositivos</p>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">🔒</span>
                        <h3 class="feature-title">Segurança Total</h3>
                        <p class="feature-description">Proteção de dados e transações seguras</p>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">⚡</span>
                        <h3 class="feature-title">Performance</h3>
                        <p class="feature-description">Carregamento rápido e navegação fluida</p>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">🤖</span>
                        <h3 class="feature-title">Chatbot IA</h3>
                        <p class="feature-description">Assistente virtual para suporte instantâneo</p>
                    </div>
                </div>
            </div>

            <div class="about-section">
                <span class="section-icon">📅</span>
                <h2 class="section-title">Nossa Jornada</h2>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="timeline-date">Agosto 2025</div>
                            <div class="timeline-title">Lançamento da Plataforma</div>
                            <div class="timeline-description">
                                Início do desenvolvimento com foco em criar uma experiência de e-commerce moderna e intuitiva
                            </div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="timeline-date">Fase 1</div>
                            <div class="timeline-title">Estrutura Base</div>
                            <div class="timeline-description">
                                Desenvolvimento da arquitetura fundamental com PHP, HTML e CSS
                            </div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="timeline-date">Fase 2</div>
                            <div class="timeline-title">Funcionalidades Avançadas</div>
                            <div class="timeline-description">
                                Implementação do sistema de carrinho, checkout e interface administrativa
                            </div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="timeline-date">Fase 3</div>
                            <div class="timeline-title">Design e UX</div>
                            <div class="timeline-description">
                                Aprimoramento visual com animações, glassmorphism e experiência do usuário
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="quote-section">
                <p class="quote-text">
                    "Tecnologia é melhor quando aproxima as pessoas. Nossa missão é conectar você aos melhores produtos 
                    com a experiência mais humana possível."
                </p>
                <p class="quote-author">— Equipe E-commerce Project</p>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 E-commerce Project. Todos os direitos reservados.</p>
            <p>Desenvolvido por <a href="#" class="dexo-credit">Dexo</a></p>
        </div>
    </footer>

    <!-- Chatbot -->
    <div class="chatbot-container">
        <button class="chatbot-toggle">💬</button>
        <div class="chatbot-window">
            <div class="chatbot-header">
                <h4>🤖 Assistente Virtual</h4>
                <button class="chatbot-close">×</button>
            </div>
            <div class="chatbot-messages">
                <div style="color: #ffffff; margin-bottom: 1rem;">
                    Olá! 👋 Posso ajudá-lo com informações sobre nossa empresa. Como posso ajudar?
                </div>
            </div>
            <div class="chatbot-input-container">
                <input type="text" class="chatbot-input" placeholder="Digite sua mensagem...">
                <button class="chatbot-send">➤</button>
            </div>
        </div>
    </div>

    <script>
        // Animação de entrada das seções
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.about-section');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'fadeInUp 0.8s ease-out forwards';
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            
            sections.forEach((section, index) => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(30px)';
                section.style.animationDelay = `${index * 0.2}s`;
                observer.observe(section);
            });
        });
        
        // Animação dos números das estatísticas
        function animateNumbers() {
            const statNumbers = document.querySelectorAll('.stat-number');
            
            statNumbers.forEach(stat => {
                const target = parseInt(stat.textContent.replace(/\D/g, ''));
                const suffix = stat.textContent.replace(/\d/g, '');
                let current = 0;
                const increment = target / 50;
                
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    stat.textContent = Math.floor(current) + suffix;
                }, 30);
            });
        }
        
        // Observar quando as estatísticas entram na tela
        const statsSection = document.querySelector('.stats-grid');
        if (statsSection) {
            const statsObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateNumbers();
                        statsObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });
            
            statsObserver.observe(statsSection);
        }
    </script>
    
    <script src="animations.js"></script>
</body>
</html>

