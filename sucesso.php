<?php
session_start();

// Verificar se há número do pedido
if (!isset($_GET['pedido'])) {
    header('Location: index.php');
    exit;
}

$numeroPedido = htmlspecialchars($_GET['pedido']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Realizada - E-commerce Project</title>
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
                    🛒 Carrinho (0)
                </a>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div style="background-color: white; padding: 4rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; margin-top: 3rem;">
                <div style="font-size: 4rem; color: #27ae60; margin-bottom: 2rem;">✅</div>
                
                <h1 style="color: #2c3e50; margin-bottom: 1rem;">Compra Realizada com Sucesso!</h1>
                
                <p style="font-size: 1.2rem; margin-bottom: 2rem; color: #7f8c8d;">
                    Obrigado por comprar conosco! Seu pedido foi processado com sucesso.
                </p>
                
                <div style="background-color: #ecf0f1; padding: 1.5rem; border-radius: 5px; margin-bottom: 2rem;">
                    <strong>Número do Pedido:</strong> <?php echo $numeroPedido; ?>
                </div>
                
                <p style="margin-bottom: 2rem;">
                    Você receberá um email de confirmação em breve com os detalhes do seu pedido e informações de entrega.
                </p>
                
                <div style="display: flex; gap: 1rem; justify-content: center;">
                    <a href="index.php" class="btn btn-success">Continuar Comprando</a>
                    <a href="produtos.php" class="btn">Ver Mais Produtos</a>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 E-commerce Project. Todos os direitos reservados. | Dexo</p>
        </div>
    </footer>
</body>
</html>

