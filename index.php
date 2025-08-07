<?php
session_start();
require_once 'db_connect.php'; // Incluir o arquivo de conexão com o banco de dados

// Inicializar carrinho se não existir
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Obter produtos em destaque do banco de dados
$produtos = obterProdutosDestaque(); // Supondo que esta função retorne produtos marcados como destaque

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
                <a href="index.php" class="logo">E-commerce Project</a>
                <nav>
                    <ul>
                        <li><a href="index.php">Início</a></li>
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
                    🛒 Carrinho (<?php echo array_sum($_SESSION['cart']); ?>)
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
                                <?php if (!empty($produto['imagem_url'])): ?>
                                    <img src="<?php echo htmlspecialchars($produto['imagem_url']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                                <?php else: ?>
                                    <span>Imagem do Produto</span>
                                <?php endif; ?>
                            </div>
                            <div class="product-category"><?php echo htmlspecialchars($produto['categoria_nome']); ?></div>
                            <h3 class="product-title"><?php echo htmlspecialchars($produto['nome']); ?></h3>
                            <div class="product-price">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></div>
                            <p class="product-description"><?php echo htmlspecialchars($produto['descricao_curta']); ?></p>
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

