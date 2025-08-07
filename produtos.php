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
        'nome' => 'Smartphone Samsung Galaxy S24 Ultra',
        'categoria' => 'Eletrônicos',
        'preco' => 899.99,
        'descricao' => 'Smartphone premium com tela Dynamic AMOLED de 6.8 polegadas, câmera de 200MP e S Pen integrada.',
        'estoque' => 15,
        'destaque' => true
    ],
    [
        'id' => 2,
        'nome' => 'Notebook Dell Inspiron 15 3000 Business',
        'categoria' => 'Informática',
        'preco' => 2499.99,
        'descricao' => 'Notebook profissional com processador Intel Core i5 de 12ª geração, 16GB RAM e SSD 512GB.',
        'estoque' => 8,
        'destaque' => true
    ],
    [
        'id' => 3,
        'nome' => 'Fone de Ouvido Sony WH-1000XM5 Wireless',
        'categoria' => 'Áudio',
        'preco' => 199.99,
        'descricao' => 'Fone de ouvido premium com cancelamento de ruído líder da indústria e qualidade de áudio Hi-Res.',
        'estoque' => 23,
        'destaque' => true
    ],
    [
        'id' => 4,
        'nome' => 'Smart TV LG 55" 4K OLED',
        'categoria' => 'Eletrônicos',
        'preco' => 1899.99,
        'descricao' => 'Smart TV OLED 55 polegadas com resolução 4K Ultra HD, tecnologia α9 Gen5 AI Processor.',
        'estoque' => 12,
        'destaque' => true
    ],
    [
        'id' => 5,
        'nome' => 'Mouse Gamer Logitech G Pro X',
        'categoria' => 'Gaming',
        'preco' => 89.99,
        'descricao' => 'Mouse gamer profissional com sensor HERO 25K, até 25.600 DPI, switches mecânicos Lightspeed.',
        'estoque' => 35,
        'destaque' => false
    ],
    [
        'id' => 6,
        'nome' => 'Teclado Mecânico Corsair K95',
        'categoria' => 'Gaming',
        'preco' => 299.99,
        'descricao' => 'Teclado mecânico gamer premium com switches Cherry MX Speed, iluminação RGB por tecla.',
        'estoque' => 18,
        'destaque' => false
    ],
    [
        'id' => 7,
        'nome' => 'Monitor Gamer ASUS ROG 27"',
        'categoria' => 'Gaming',
        'preco' => 1299.99,
        'descricao' => 'Monitor gamer 27 polegadas, 144Hz, 1ms, G-Sync, resolução QHD 2560x1440.',
        'estoque' => 9,
        'destaque' => false
    ],
    [
        'id' => 8,
        'nome' => 'Webcam Logitech C920 HD Pro',
        'categoria' => 'Informática',
        'preco' => 159.99,
        'descricao' => 'Webcam Full HD 1080p com microfone estéreo, ideal para videoconferências e streaming.',
        'estoque' => 27,
        'destaque' => false
    ],
    [
        'id' => 9,
        'nome' => 'SSD Kingston NV2 1TB',
        'categoria' => 'Informática',
        'preco' => 249.99,
        'descricao' => 'SSD NVMe PCIe 4.0 de 1TB, velocidades de leitura até 3.500 MB/s, ideal para upgrades.',
        'estoque' => 42,
        'destaque' => false
    ],
    [
        'id' => 10,
        'nome' => 'Caixa de Som JBL Charge 5',
        'categoria' => 'Áudio',
        'preco' => 399.99,
        'descricao' => 'Caixa de som Bluetooth portátil, à prova d\'água IP67, 20 horas de bateria.',
        'estoque' => 16,
        'destaque' => false
    ],
    [
        'id' => 11,
        'nome' => 'Tablet Apple iPad Air 5ª Geração',
        'categoria' => 'Eletrônicos',
        'preco' => 1899.99,
        'descricao' => 'iPad Air com chip M1, tela Liquid Retina 10.9", 64GB, Wi-Fi, compatível com Apple Pencil.',
        'estoque' => 7,
        'destaque' => false
    ],
    [
        'id' => 12,
        'nome' => 'Carregador Wireless Anker PowerWave',
        'categoria' => 'Eletrônicos',
        'preco' => 79.99,
        'descricao' => 'Carregador sem fio 15W, compatível com iPhone e Android, design elegante e compacto.',
        'estoque' => 31,
        'destaque' => false
    ]
];

// Filtros
$categoria_filtro = $_GET['categoria'] ?? '';
$preco_min = isset($_GET['preco_min']) ? floatval($_GET['preco_min']) : 0;
$preco_max = isset($_GET['preco_max']) ? floatval($_GET['preco_max']) : 999999;
$busca = $_GET['busca'] ?? '';

// Aplicar filtros
$produtos_filtrados = array_filter($produtos, function($produto) use ($categoria_filtro, $preco_min, $preco_max, $busca) {
    $categoria_ok = empty($categoria_filtro) || $produto['categoria'] === $categoria_filtro;
    $preco_ok = $produto['preco'] >= $preco_min && $produto['preco'] <= $preco_max;
    $busca_ok = empty($busca) || stripos($produto['nome'], $busca) !== false || stripos($produto['descricao'], $busca) !== false;
    
    return $categoria_ok && $preco_ok && $busca_ok;
});

// Obter categorias únicas
$categorias = array_unique(array_column($produtos, 'categoria'));
sort($categorias);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - E-commerce Project</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="components.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .products-container {
            max-width: 1400px;
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
        
        .filters-section {
            background: var(--glass-bg);
            backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-xl);
            padding: var(--spacing-xl);
            margin-bottom: var(--spacing-3xl);
            transition: all var(--transition-normal);
        }
        
        .filters-section:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .filters-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: var(--spacing-lg);
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
        }
        
        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--spacing-lg);
            margin-bottom: var(--spacing-lg);
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-sm);
        }
        
        .filter-label {
            color: var(--text-light);
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .filter-input, .filter-select {
            padding: var(--spacing-md);
            background: rgba(255, 255, 255, 0.08);
            border: 2px solid var(--glass-border);
            border-radius: var(--border-radius-md);
            color: var(--text-light);
            font-size: 0.95rem;
            transition: all var(--transition-normal);
            backdrop-filter: blur(10px);
        }
        
        .filter-input:focus, .filter-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.2);
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-2px);
        }
        
        .filter-input::placeholder {
            color: var(--text-dark);
        }
        
        .filter-actions {
            display: flex;
            gap: var(--spacing-md);
            justify-content: center;
        }
        
        .btn-filter {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            border: none;
            padding: var(--spacing-md) var(--spacing-xl);
            border-radius: var(--border-radius-md);
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-normal);
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .btn-clear {
            background: transparent;
            color: var(--text-light);
            border: 2px solid var(--glass-border);
            padding: var(--spacing-md) var(--spacing-xl);
            border-radius: var(--border-radius-md);
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-normal);
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-clear:hover {
            background: var(--glass-bg);
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }
        
        .products-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-xl);
            padding: var(--spacing-lg);
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-lg);
        }
        
        .products-count {
            color: var(--text-light);
            font-weight: 500;
        }
        
        .sort-select {
            padding: var(--spacing-sm) var(--spacing-md);
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-md);
            color: var(--text-light);
            cursor: pointer;
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: var(--spacing-xl);
            margin-bottom: var(--spacing-3xl);
        }
        
        .product-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-xl);
            padding: var(--spacing-xl);
            transition: all var(--transition-normal);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
        
        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
            transition: left var(--transition-slow);
            pointer-events: none;
        }
        
        .product-card:hover::before {
            left: 100%;
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: rgba(255, 255, 255, 0.2);
        }
        
        .product-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, var(--card-bg), var(--dark-bg));
            border-radius: var(--border-radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: var(--spacing-lg);
            color: var(--text-muted);
            font-size: 0.9rem;
            position: relative;
            overflow: hidden;
        }
        
        .product-category {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: var(--spacing-xs) var(--spacing-md);
            border-radius: var(--border-radius-full);
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: var(--spacing-md);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .product-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: var(--spacing-sm);
            line-height: 1.3;
        }
        
        .product-price {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: var(--spacing-md);
        }
        
        .product-description {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: var(--spacing-lg);
            line-height: 1.5;
        }
        
        .product-stock {
            color: var(--success-color);
            font-size: 0.85rem;
            margin-bottom: var(--spacing-md);
            font-weight: 500;
        }
        
        .product-stock.low {
            color: var(--warning-color);
        }
        
        .product-stock.out {
            color: var(--danger-color);
        }
        
        .no-products {
            text-align: center;
            padding: var(--spacing-3xl);
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-xl);
            color: var(--text-muted);
        }
        
        .no-products-icon {
            font-size: 4rem;
            margin-bottom: var(--spacing-lg);
            opacity: 0.5;
        }
        
        .no-products-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: var(--spacing-md);
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: var(--spacing-md);
            margin-top: var(--spacing-3xl);
        }
        
        .pagination-btn {
            padding: var(--spacing-md) var(--spacing-lg);
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-md);
            color: var(--text-light);
            text-decoration: none;
            transition: all var(--transition-normal);
        }
        
        .pagination-btn:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }
        
        .pagination-btn.active {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        @media (max-width: 768px) {
            .filters-grid {
                grid-template-columns: 1fr;
            }
            
            .products-grid {
                grid-template-columns: 1fr;
            }
            
            .products-stats {
                flex-direction: column;
                gap: var(--spacing-md);
                text-align: center;
            }
            
            .filter-actions {
                flex-direction: column;
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

    <main class="products-container">
        <div class="page-header">
            <h1 class="page-title">Catálogo de Produtos</h1>
            <p class="page-subtitle">Descubra nossa seleção completa de produtos tecnológicos com a melhor qualidade e preços competitivos</p>
        </div>

        <div class="filters-section">
            <h2 class="filters-title">
                🔍 Filtros de Busca
            </h2>
            <form method="GET" action="">
                <div class="filters-grid">
                    <div class="filter-group">
                        <label class="filter-label">Buscar Produto</label>
                        <input type="text" name="busca" class="filter-input" 
                               placeholder="Digite o nome do produto..." 
                               value="<?php echo htmlspecialchars($busca); ?>">
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Categoria</label>
                        <select name="categoria" class="filter-select">
                            <option value="">Todas as categorias</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?php echo htmlspecialchars($categoria); ?>" 
                                        <?php echo $categoria_filtro === $categoria ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($categoria); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Preço Mínimo (R$)</label>
                        <input type="number" name="preco_min" class="filter-input" 
                               placeholder="0,00" step="0.01" min="0"
                               value="<?php echo $preco_min > 0 ? $preco_min : ''; ?>">
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Preço Máximo (R$)</label>
                        <input type="number" name="preco_max" class="filter-input" 
                               placeholder="999999,00" step="0.01" min="0"
                               value="<?php echo $preco_max < 999999 ? $preco_max : ''; ?>">
                    </div>
                </div>
                
                <div class="filter-actions">
                    <button type="submit" class="btn-filter">
                        🔍 Aplicar Filtros
                    </button>
                    <a href="produtos_new.php" class="btn-clear">
                        🗑️ Limpar Filtros
                    </a>
                </div>
            </form>
        </div>

        <div class="products-stats">
            <div class="products-count">
                <strong><?php echo count($produtos_filtrados); ?></strong> produto(s) encontrado(s)
                <?php if (!empty($categoria_filtro) || !empty($busca) || $preco_min > 0 || $preco_max < 999999): ?>
                    com os filtros aplicados
                <?php endif; ?>
            </div>
            <select class="sort-select" onchange="sortProducts(this.value)">
                <option value="nome">Ordenar por Nome</option>
                <option value="preco_asc">Menor Preço</option>
                <option value="preco_desc">Maior Preço</option>
                <option value="categoria">Categoria</option>
            </select>
        </div>

        <?php if (empty($produtos_filtrados)): ?>
            <div class="no-products">
                <div class="no-products-icon">📦</div>
                <h3 class="no-products-title">Nenhum produto encontrado</h3>
                <p>Tente ajustar os filtros de busca ou navegue por todas as categorias.</p>
                <a href="produtos_new.php" class="btn btn-primary" style="margin-top: var(--spacing-lg);">
                    Ver Todos os Produtos
                </a>
            </div>
        <?php else: ?>
            <div class="products-grid" id="products-grid">
                <?php foreach ($produtos_filtrados as $produto): ?>
                    <div class="product-card" data-nome="<?php echo htmlspecialchars($produto['nome']); ?>" 
                         data-preco="<?php echo $produto['preco']; ?>" 
                         data-categoria="<?php echo htmlspecialchars($produto['categoria']); ?>">
                        <div class="product-image">
                            <span>Imagem do Produto</span>
                        </div>
                        <div class="product-category"><?php echo htmlspecialchars($produto['categoria']); ?></div>
                        <h3 class="product-title"><?php echo htmlspecialchars($produto['nome']); ?></h3>
                        <div class="product-price">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></div>
                        <p class="product-description"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                        
                        <div class="product-stock <?php echo $produto['estoque'] <= 5 ? ($produto['estoque'] == 0 ? 'out' : 'low') : ''; ?>">
                            <?php if ($produto['estoque'] == 0): ?>
                                ❌ Fora de estoque
                            <?php elseif ($produto['estoque'] <= 5): ?>
                                ⚠️ Últimas <?php echo $produto['estoque']; ?> unidades
                            <?php else: ?>
                                ✅ Em estoque (<?php echo $produto['estoque']; ?> unidades)
                            <?php endif; ?>
                        </div>
                        
                        <a href="produto.php?id=<?php echo $produto['id']; ?>" class="btn btn-primary">
                            Ver Detalhes
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
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
                    Olá! 👋 Posso ajudá-lo a encontrar produtos. Como posso ajudar?
                </div>
            </div>
            <div class="chatbot-input-container">
                <input type="text" class="chatbot-input" placeholder="Digite sua mensagem...">
                <button class="chatbot-send">➤</button>
            </div>
        </div>
    </div>

    <script>
        function sortProducts(sortBy) {
            const grid = document.getElementById('products-grid');
            const cards = Array.from(grid.children);
            
            cards.sort((a, b) => {
                switch(sortBy) {
                    case 'nome':
                        return a.dataset.nome.localeCompare(b.dataset.nome);
                    case 'preco_asc':
                        return parseFloat(a.dataset.preco) - parseFloat(b.dataset.preco);
                    case 'preco_desc':
                        return parseFloat(b.dataset.preco) - parseFloat(a.dataset.preco);
                    case 'categoria':
                        return a.dataset.categoria.localeCompare(b.dataset.categoria);
                    default:
                        return 0;
                }
            });
            
            // Remover todos os cards
            cards.forEach(card => card.remove());
            
            // Adicionar cards ordenados com animação
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    grid.appendChild(card);
                    
                    setTimeout(() => {
                        card.style.transition = 'all 0.5s ease-out';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                }, index * 50);
            });
        }
        
        // Animação de entrada dos produtos
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.product-card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'fadeInUp 0.6s ease-out forwards';
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.animationDelay = `${index * 0.1}s`;
                observer.observe(card);
            });
        });
        
        // Busca em tempo real
        const buscaInput = document.querySelector('input[name="busca"]');
        if (buscaInput) {
            let timeoutId;
            buscaInput.addEventListener('input', function() {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(() => {
                    const termo = this.value.toLowerCase();
                    const cards = document.querySelectorAll('.product-card');
                    
                    cards.forEach(card => {
                        const nome = card.dataset.nome.toLowerCase();
                        const categoria = card.dataset.categoria.toLowerCase();
                        
                        if (nome.includes(termo) || categoria.includes(termo)) {
                            card.style.display = 'block';
                            card.style.animation = 'fadeInUp 0.3s ease-out';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                    
                    // Atualizar contador
                    const visibleCards = document.querySelectorAll('.product-card[style*="display: block"], .product-card:not([style*="display: none"])');
                    const counter = document.querySelector('.products-count strong');
                    if (counter) {
                        counter.textContent = visibleCards.length;
                    }
                }, 300);
            });
        }
    </script>
    
    <script src="animations.js"></script>
</body>
</html>

