<?php
session_start();
require_once 'config.php';

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
    <title>Produtos - E-commerce Project</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">E-commerce Project</div>
                <nav>
                    <ul>
                        <li><a href="index.php">Início</a></li>
                        <li><a href="produtos.php">Produtos</a></li>
                        <li><a href="sobre.php">Sobre</a></li>
                        <li><a href="contato.php">Contato</a></li>
                    </ul>
                </nav>
                <a href="carrinho.php" class="cart-icon">
                    🛒 Carrinho (<?php echo count($_SESSION['cart']); ?>)
                </a>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <h1 style="color: #2c3e50; margin-bottom: 2rem;">Todos os Produtos</h1>

            <div class="products-grid">
                <?php foreach ($produtos as $produto): ?>
                    <div class="product-card">
                        <div class="product-image">
                            Imagem do Produto
                        </div>
                        <div class="product-title"><?php echo htmlspecialchars($produto['nome']); ?></div>
                        <div style="background-color: #ecf0f1; padding: 0.3rem; border-radius: 3px; margin-bottom: 0.5rem; font-size: 0.9rem;">
                            <?php echo htmlspecialchars($produto['categoria']); ?>
                        </div>
                        <div class="product-price"><?php echo formatarPreco($produto['preco']); ?></div>
                        <p style="margin-bottom: 1rem;"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                        <a href="produto.php?id=<?php echo $produto['id']; ?>" class="btn">Ver Detalhes</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 E-commerce Project. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>

