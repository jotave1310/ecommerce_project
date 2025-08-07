<?php
session_start();

// Inicializar carrinho se não existir
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Produtos de exemplo (simulando banco de dados)
$produtos = [
    [
        'id' => 1,
        'nome' => 'Smartphone Samsung Galaxy S24',
        'categoria' => 'Eletrônicos',
        'preco' => 899.99,
        'descricao' => 'Smartphone premium com tela Dynamic AMOLED de 6.1 polegadas, câmera tripla de 50MP com zoom óptico 3x, processador Snapdragon 8 Gen 3, 8GB RAM, 256GB armazenamento, bateria 4000mAh com carregamento rápido 25W, resistente à água IP68.'
    ],
    [
        'id' => 2,
        'nome' => 'Notebook Dell Inspiron 15 3000',
        'categoria' => 'Informática',
        'preco' => 2499.99,
        'descricao' => 'Notebook para uso profissional com processador Intel Core i5-1235U de 12ª geração, 8GB RAM DDR4 expansível até 16GB, SSD 256GB NVMe, tela Full HD 15.6" antirreflexo, placa de vídeo Intel Iris Xe, Windows 11 Home, teclado numérico.'
    ],
    [
        'id' => 3,
        'nome' => 'Fone de Ouvido Sony WH-1000XM5',
        'categoria' => 'Áudio',
        'preco' => 199.99,
        'descricao' => 'Fone de ouvido wireless premium com cancelamento de ruído líder da indústria, drivers de 30mm, até 30h de bateria, carregamento rápido (3min = 3h), tecnologia LDAC, controles touch, microfone com supressão de ruído para chamadas.'
    ],
    [
        'id' => 4,
        'nome' => 'Smart TV LG 55" 4K OLED',
        'categoria' => 'Eletrônicos',
        'preco' => 1899.99,
        'descricao' => 'Smart TV OLED 55 polegadas com resolução 4K Ultra HD, tecnologia α9 Gen5 AI Processor, Dolby Vision IQ, Dolby Atmos, webOS 22, compatível com Alexa e Google Assistant, 4 portas HDMI 2.1, ideal para gaming com 120Hz.'
    ],
    [
        'id' => 5,
        'nome' => 'Mouse Gamer Logitech G Pro X',
        'categoria' => 'Gaming',
        'preco' => 89.99,
        'descricao' => 'Mouse gamer profissional com sensor HERO 25K, até 25.600 DPI, switches mecânicos Lightspeed, RGB LIGHTSYNC personalizável, design ambidestro ultralight 63g, cabo destacável, compatível com PowerPlay, usado por esports profissionais.'
    ],
    [
        'id' => 6,
        'nome' => 'Teclado Mecânico Corsair K95',
        'categoria' => 'Gaming',
        'preco' => 299.99,
        'descricao' => 'Teclado mecânico gamer premium com switches Cherry MX Speed, iluminação RGB por tecla, 6 teclas macro dedicadas, controles de mídia, apoio para punho destacável, estrutura em alumínio, tecnologia anti-ghosting, software iCUE.'
    ]
];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Project - Loja Online</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="components.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <a href="index_new.php" class="logo">E-commerce Project</a>
                <nav>
                    <ul>
                        <li><a href="index_new.php">Início</a></li>
                        <li><a href="produtos.php">Produtos</a></li>
                        <li><a href="sobre.php">Sobre</a></li>
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
                    🛒 Carrinho (<?php echo count($_SESSION['cart']); ?>)
                </a>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <h1 class="fade-in">Tecnologia de Ponta ao Seu Alcance</h1>
                <p class="fade-in">Descubra os melhores produtos tecnológicos com preços imbatíveis e qualidade garantida!</p>
            </div>
        </section>

        <!-- Produtos em Destaque -->
        <section class="products-section">
            <div class="container">
                <h2 class="section-title">Produtos em Destaque</h2>
                <div class="products-grid">
                    <?php foreach ($produtos as $produto): ?>
                        <div class="product-card">
                            <div class="product-image">
                                <span>Imagem do Produto</span>
                            </div>
                            <div class="product-category"><?php echo htmlspecialchars($produto['categoria']); ?></div>
                            <h3 class="product-title"><?php echo htmlspecialchars($produto['nome']); ?></h3>
                            <div class="product-price">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></div>
                            <p class="product-description"><?php echo htmlspecialchars(substr($produto['descricao'], 0, 120)) . '...'; ?></p>
                            <a href="produto.php?id=<?php echo $produto['id']; ?>" class="btn btn-primary">Ver Detalhes</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
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
                    Olá! 👋 Sou seu assistente virtual. Como posso ajudá-lo hoje?
                </div>
            </div>
            <div class="chatbot-input-container">
                <input type="text" class="chatbot-input" placeholder="Digite sua mensagem...">
                <button class="chatbot-send">➤</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="animations.js"></script>
</body>
</html>

