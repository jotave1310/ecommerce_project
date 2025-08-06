<?php
session_start();
require_once 'config.php';

// Inicializar carrinho se não existir
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Processar remoção de item do carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remover_item'])) {
    $produtoId = (int)$_POST['produto_id'];
    unset($_SESSION['cart'][$produtoId]);
    $mensagem = "Item removido do carrinho!";
}

// Processar atualização de quantidade
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar_quantidade'])) {
    $produtoId = (int)$_POST['produto_id'];
    $novaQuantidade = (int)$_POST['quantidade'];
    
    if ($novaQuantidade > 0) {
        $_SESSION['cart'][$produtoId] = $novaQuantidade;
        $mensagem = "Quantidade atualizada!";
    } else {
        unset($_SESSION['cart'][$produtoId]);
        $mensagem = "Item removido do carrinho!";
    }
}

// Processar limpeza do carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['limpar_carrinho'])) {
    $_SESSION['cart'] = array();
    $mensagem = "Carrinho limpo!";
}

$total = calcularTotalCarrinho($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras - E-commerce Project</title>
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
            <h1 style="color: #2c3e50; margin-bottom: 2rem;">Carrinho de Compras</h1>

            <?php if (isset($mensagem)): ?>
                <div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 2rem;">
                    <?php echo htmlspecialchars($mensagem); ?>
                </div>
            <?php endif; ?>

            <?php if (empty($_SESSION['cart'])): ?>
                <div style="background-color: white; padding: 3rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center;">
                    <h2>Seu carrinho está vazio</h2>
                    <p style="margin: 1rem 0;">Adicione alguns produtos para continuar comprando!</p>
                    <a href="index.php" class="btn">Continuar Comprando</a>
                </div>
            <?php else: ?>
                <div class="cart-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Preço Unitário</th>
                                <th>Quantidade</th>
                                <th>Subtotal</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $produtoId => $quantidade): ?>
                                <?php $produto = obterProduto($produtoId); ?>
                                <?php if ($produto): ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo htmlspecialchars($produto['nome']); ?></strong><br>
                                            <small><?php echo htmlspecialchars($produto['categoria']); ?></small>
                                        </td>
                                        <td><?php echo formatarPreco($produto['preco']); ?></td>
                                        <td>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="produto_id" value="<?php echo $produtoId; ?>">
                                                <input type="number" name="quantidade" value="<?php echo $quantidade; ?>" 
                                                       min="0" max="10" style="width: 60px; padding: 0.3rem;">
                                                <button type="submit" name="atualizar_quantidade" class="btn" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;">
                                                    Atualizar
                                                </button>
                                            </form>
                                        </td>
                                        <td><?php echo formatarPreco($produto['preco'] * $quantidade); ?></td>
                                        <td>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="produto_id" value="<?php echo $produtoId; ?>">
                                                <button type="submit" name="remover_item" class="btn btn-danger" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;">
                                                    Remover
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="cart-total">
                    <div class="total-price">
                        Total: <?php echo formatarPreco($total); ?>
                    </div>
                    
                    <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                        <form method="POST" style="display: inline;">
                            <button type="submit" name="limpar_carrinho" class="btn btn-danger">
                                Limpar Carrinho
                            </button>
                        </form>
                        
                        <a href="index.php" class="btn">Continuar Comprando</a>
                        
                        <a href="checkout.php" class="btn btn-success">Finalizar Compra</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 E-commerce Project. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>

