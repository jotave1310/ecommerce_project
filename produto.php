<?php
session_start();

// Inicializar carrinho se não existir
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Obter ID do produto
$produto_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Base de dados de produtos com descrições detalhadas
$produtos = [
    1 => [
        'id' => 1,
        'nome' => 'Smartphone Samsung Galaxy S24 Ultra',
        'categoria' => 'Eletrônicos',
        'preco' => 899.99,
        'preco_original' => 1199.99,
        'desconto' => 25,
        'descricao_curta' => 'Smartphone premium com tela Dynamic AMOLED de 6.8 polegadas, câmera de 200MP e S Pen integrada.',
        'descricao_completa' => 'O Samsung Galaxy S24 Ultra representa o ápice da tecnologia móvel, oferecendo uma experiência incomparável para usuários exigentes. Com sua tela Dynamic AMOLED 2X de 6.8 polegadas e resolução QHD+, cada imagem ganha vida com cores vibrantes e detalhes impressionantes. O display suporta taxa de atualização adaptativa de 120Hz, garantindo fluidez excepcional em jogos e navegação.

A câmera principal de 200MP com zoom óptico de 10x permite capturar fotos profissionais mesmo à distância, enquanto o sistema de estabilização óptica garante imagens nítidas em qualquer situação. O processador Snapdragon 8 Gen 3 oferece desempenho excepcional para multitarefas e jogos pesados, complementado por 12GB de RAM LPDDR5X e 256GB de armazenamento UFS 4.0.

A S Pen integrada transforma o dispositivo em uma ferramenta de produtividade completa, permitindo anotações precisas, edição de fotos e controle remoto de apresentações. A bateria de 5000mAh com carregamento rápido de 45W garante uso intenso durante todo o dia, enquanto a certificação IP68 oferece proteção contra água e poeira.',
        'especificacoes' => [
            'Tela' => '6.8" Dynamic AMOLED 2X, QHD+, 120Hz',
            'Processador' => 'Snapdragon 8 Gen 3',
            'RAM' => '12GB LPDDR5X',
            'Armazenamento' => '256GB UFS 4.0',
            'Câmera Principal' => '200MP + 50MP + 12MP + 10MP',
            'Câmera Frontal' => '12MP',
            'Bateria' => '5000mAh, carregamento 45W',
            'Sistema' => 'Android 14 com One UI 6.1',
            'Conectividade' => '5G, Wi-Fi 7, Bluetooth 5.3',
            'Resistência' => 'IP68',
            'Dimensões' => '162.3 x 79.0 x 8.6 mm',
            'Peso' => '232g'
        ],
        'imagens' => ['produto_1_1.jpg', 'produto_1_2.jpg', 'produto_1_3.jpg'],
        'estoque' => 15,
        'vendedor' => 'Samsung Store Oficial',
        'avaliacao_media' => 4.8,
        'total_avaliacoes' => 1247,
        'frete_gratis' => true,
        'entrega_rapida' => true
    ],
    2 => [
        'id' => 2,
        'nome' => 'Notebook Dell Inspiron 15 3000 Business',
        'categoria' => 'Informática',
        'preco' => 2499.99,
        'preco_original' => 2899.99,
        'desconto' => 14,
        'descricao_curta' => 'Notebook profissional com processador Intel Core i5 de 12ª geração, 16GB RAM e SSD 512GB.',
        'descricao_completa' => 'O Dell Inspiron 15 3000 Business foi desenvolvido especificamente para profissionais que exigem performance e confiabilidade. Equipado com processador Intel Core i5-1235U de 12ª geração, oferece o equilíbrio perfeito entre eficiência energética e poder de processamento para tarefas corporativas exigentes.

A tela Full HD de 15.6 polegadas com tecnologia antirreflexo proporciona visualização confortável mesmo em ambientes com muita luz, ideal para longas jornadas de trabalho. Os 16GB de RAM DDR4 garantem multitarefas fluidas, permitindo executar múltiplas aplicações simultaneamente sem perda de performance.

O SSD NVMe de 512GB oferece inicialização rápida do sistema e acesso instantâneo aos arquivos, aumentando significativamente a produtividade. O design robusto com acabamento profissional transmite seriedade e elegância em reuniões e apresentações.

A conectividade completa inclui portas USB-C, USB 3.2, HDMI 1.4, leitor de cartão SD e entrada para fone de ouvido, atendendo todas as necessidades de conectividade do ambiente corporativo. A bateria de longa duração permite trabalhar por até 8 horas sem necessidade de recarga.',
        'especificacoes' => [
            'Processador' => 'Intel Core i5-1235U (12ª geração)',
            'Memória RAM' => '16GB DDR4 2666MHz (expansível até 32GB)',
            'Armazenamento' => 'SSD 512GB NVMe PCIe',
            'Tela' => '15.6" Full HD (1920x1080) antirreflexo',
            'Placa de Vídeo' => 'Intel Iris Xe Graphics',
            'Sistema Operacional' => 'Windows 11 Pro',
            'Conectividade' => 'Wi-Fi 6, Bluetooth 5.2',
            'Portas' => '2x USB 3.2, 1x USB-C, HDMI 1.4, SD Card',
            'Áudio' => 'Alto-falantes estéreo com Waves MaxxAudio',
            'Webcam' => 'HD 720p com microfone integrado',
            'Bateria' => '3-cell 41Wh, até 8 horas de uso',
            'Dimensões' => '358.5 x 235.6 x 18.9 mm',
            'Peso' => '1.85kg'
        ],
        'imagens' => ['produto_2_1.jpg', 'produto_2_2.jpg', 'produto_2_3.jpg'],
        'estoque' => 8,
        'vendedor' => 'Dell Oficial',
        'avaliacao_media' => 4.6,
        'total_avaliacoes' => 892,
        'frete_gratis' => true,
        'entrega_rapida' => false
    ],
    3 => [
        'id' => 3,
        'nome' => 'Fone de Ouvido Sony WH-1000XM5 Wireless',
        'categoria' => 'Áudio',
        'preco' => 199.99,
        'preco_original' => 299.99,
        'desconto' => 33,
        'descricao_curta' => 'Fone de ouvido premium com cancelamento de ruído líder da indústria e qualidade de áudio Hi-Res.',
        'descricao_completa' => 'O Sony WH-1000XM5 estabelece novos padrões em cancelamento de ruído e qualidade sonora. Equipado com dois processadores dedicados e oito microfones, oferece o cancelamento de ruído mais avançado da categoria, bloqueando efetivamente ruídos de aviões, trânsito e ambientes ruidosos.

Os drivers de 30mm especialmente desenvolvidos reproduzem áudio Hi-Res com clareza excepcional, desde graves profundos até agudos cristalinos. A tecnologia LDAC permite transmissão de áudio de alta qualidade via Bluetooth, mantendo a fidelidade sonora mesmo sem fio.

O design renovado apresenta construção mais leve e confortável, com almofadas macias que se adaptam perfeitamente ao formato da cabeça. A bateria de longa duração oferece até 30 horas de reprodução com cancelamento de ruído ativo, e o carregamento rápido de 3 minutos proporciona 3 horas adicionais de uso.

A conectividade inteligente permite conexão simultânea com dois dispositivos, facilitando a alternância entre smartphone e laptop. Os controles touch intuitivos respondem a gestos simples para ajustar volume, pular faixas e atender chamadas.',
        'especificacoes' => [
            'Tipo' => 'Over-ear, fechado',
            'Drivers' => '30mm, neodímio',
            'Resposta de Frequência' => '4Hz - 40kHz',
            'Impedância' => '48Ω (1kHz)',
            'Conectividade' => 'Bluetooth 5.2, LDAC, SBC, AAC',
            'Cancelamento de Ruído' => 'Ativo com 2 processadores',
            'Microfones' => '8 microfones para NC e chamadas',
            'Bateria' => 'Até 30h (NC ligado), 40h (NC desligado)',
            'Carregamento' => 'USB-C, carregamento rápido',
            'Controles' => 'Touch panel no lado direito',
            'Peso' => '250g',
            'Acessórios' => 'Cabo USB-C, cabo de áudio 3.5mm, estojo',
            'Certificações' => 'Hi-Res Audio, Hi-Res Audio Wireless'
        ],
        'imagens' => ['produto_3_1.jpg', 'produto_3_2.jpg', 'produto_3_3.jpg'],
        'estoque' => 23,
        'vendedor' => 'Sony Store',
        'avaliacao_media' => 4.9,
        'total_avaliacoes' => 2156,
        'frete_gratis' => true,
        'entrega_rapida' => true
    ]
];

// Verificar se produto existe
if (!isset($produtos[$produto_id])) {
    header('Location: index.php');
    exit();
}

$produto = $produtos[$produto_id];

// Produtos relacionados (mesma categoria)
$produtos_relacionados = array_filter($produtos, function($p) use ($produto) {
    return $p['categoria'] === $produto['categoria'] && $p['id'] !== $produto['id'];
});

// Avaliações de exemplo
$avaliacoes = [
    [
        'usuario' => 'Carlos M.',
        'nota' => 5,
        'titulo' => 'Excelente produto!',
        'comentario' => 'Superou minhas expectativas. A qualidade é excepcional e chegou muito rápido.',
        'data' => '2025-01-15',
        'verificado' => true,
        'util' => 12
    ],
    [
        'usuario' => 'Ana S.',
        'nota' => 4,
        'titulo' => 'Muito bom, recomendo',
        'comentario' => 'Produto de qualidade, exatamente como descrito. Único ponto negativo foi a demora na entrega.',
        'data' => '2025-01-10',
        'verificado' => true,
        'util' => 8
    ],
    [
        'usuario' => 'Roberto L.',
        'nota' => 5,
        'titulo' => 'Perfeito!',
        'comentario' => 'Já é meu segundo produto desta marca. Qualidade impecável e atendimento excelente.',
        'data' => '2025-01-08',
        'verificado' => true,
        'util' => 15
    ]
];

// Processar adição ao carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar_carrinho'])) {
    $quantidade = intval($_POST['quantidade'] ?? 1);
    
    if (isset($_SESSION['cart'][$produto_id])) {
        $_SESSION['cart'][$produto_id] += $quantidade;
    } else {
        $_SESSION['cart'][$produto_id] = $quantidade;
    }
    
    $mensagem_sucesso = "Produto adicionado ao carrinho!";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($produto['nome']); ?> - E-commerce Project</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="components.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .product-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: var(--spacing-xl) var(--spacing-lg);
        }
        
        .breadcrumb {
            margin-bottom: var(--spacing-xl);
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        
        .breadcrumb a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color var(--transition-normal);
        }
        
        .breadcrumb a:hover {
            color: var(--primary-color);
        }
        
        .product-main {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--spacing-3xl);
            margin-bottom: var(--spacing-3xl);
        }
        
        .product-gallery {
            position: sticky;
            top: 100px;
            height: fit-content;
        }
        
        .main-image {
            width: 100%;
            height: 500px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: var(--spacing-lg);
            color: var(--text-muted);
            font-size: 1.2rem;
            position: relative;
            overflow: hidden;
        }
        
        .image-thumbnails {
            display: flex;
            gap: var(--spacing-md);
            justify-content: center;
        }
        
        .thumbnail {
            width: 80px;
            height: 80px;
            background: var(--glass-bg);
            border: 2px solid var(--glass-border);
            border-radius: var(--border-radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-normal);
            color: var(--text-muted);
            font-size: 0.8rem;
        }
        
        .thumbnail:hover,
        .thumbnail.active {
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }
        
        .product-info {
            padding: var(--spacing-lg) 0;
        }
        
        .product-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: var(--spacing-md);
            line-height: 1.3;
        }
        
        .product-rating {
            display: flex;
            align-items: center;
            gap: var(--spacing-md);
            margin-bottom: var(--spacing-lg);
        }
        
        .stars {
            display: flex;
            gap: var(--spacing-xs);
        }
        
        .star {
            color: #ffc107;
            font-size: 1.2rem;
        }
        
        .star.empty {
            color: var(--text-dark);
        }
        
        .rating-text {
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        
        .rating-text a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .price-section {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-lg);
            padding: var(--spacing-xl);
            margin-bottom: var(--spacing-xl);
        }
        
        .price-original {
            color: var(--text-dark);
            text-decoration: line-through;
            font-size: 1.1rem;
            margin-bottom: var(--spacing-xs);
        }
        
        .price-current {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: var(--spacing-sm);
        }
        
        .discount-badge {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: var(--spacing-xs) var(--spacing-md);
            border-radius: var(--border-radius-full);
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: var(--spacing-lg);
        }
        
        .shipping-info {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-sm);
            margin-bottom: var(--spacing-xl);
        }
        
        .shipping-item {
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        
        .shipping-item.highlight {
            color: var(--success-color);
            font-weight: 500;
        }
        
        .quantity-selector {
            display: flex;
            align-items: center;
            gap: var(--spacing-lg);
            margin-bottom: var(--spacing-xl);
        }
        
        .quantity-label {
            color: var(--text-light);
            font-weight: 500;
        }
        
        .quantity-controls {
            display: flex;
            align-items: center;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-md);
            overflow: hidden;
        }
        
        .quantity-btn {
            background: none;
            border: none;
            color: var(--text-light);
            padding: var(--spacing-md);
            cursor: pointer;
            transition: background var(--transition-normal);
            font-size: 1.2rem;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .quantity-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .quantity-input {
            background: none;
            border: none;
            color: var(--text-light);
            text-align: center;
            width: 60px;
            padding: var(--spacing-md);
            font-size: 1rem;
        }
        
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-md);
        }
        
        .btn-buy-now {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            border: none;
            padding: var(--spacing-lg) var(--spacing-xl);
            border-radius: var(--border-radius-md);
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-normal);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-buy-now:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .btn-add-cart {
            background: transparent;
            color: var(--text-light);
            border: 2px solid var(--glass-border);
            padding: var(--spacing-lg) var(--spacing-xl);
            border-radius: var(--border-radius-md);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-normal);
        }
        
        .btn-add-cart:hover {
            background: var(--glass-bg);
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }
        
        .seller-info {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-lg);
            padding: var(--spacing-lg);
            margin-top: var(--spacing-xl);
        }
        
        .seller-name {
            color: var(--text-light);
            font-weight: 600;
            margin-bottom: var(--spacing-sm);
        }
        
        .seller-badge {
            background: var(--success-color);
            color: white;
            padding: var(--spacing-xs) var(--spacing-sm);
            border-radius: var(--border-radius-sm);
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .product-details {
            margin-top: var(--spacing-3xl);
        }
        
        .details-tabs {
            display: flex;
            border-bottom: 1px solid var(--glass-border);
            margin-bottom: var(--spacing-xl);
        }
        
        .tab-button {
            background: none;
            border: none;
            color: var(--text-muted);
            padding: var(--spacing-lg) var(--spacing-xl);
            cursor: pointer;
            transition: all var(--transition-normal);
            font-weight: 500;
            border-bottom: 2px solid transparent;
        }
        
        .tab-button.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
            animation: fadeInUp 0.5s ease-out;
        }
        
        .description-content {
            color: var(--text-light);
            line-height: 1.8;
            font-size: 1.05rem;
        }
        
        .description-content p {
            margin-bottom: var(--spacing-lg);
        }
        
        .specs-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .specs-table tr {
            border-bottom: 1px solid var(--glass-border);
        }
        
        .specs-table td {
            padding: var(--spacing-lg);
            vertical-align: top;
        }
        
        .specs-table td:first-child {
            color: var(--text-muted);
            font-weight: 500;
            width: 200px;
        }
        
        .specs-table td:last-child {
            color: var(--text-light);
        }
        
        .reviews-section {
            margin-top: var(--spacing-xl);
        }
        
        .reviews-summary {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: var(--spacing-xl);
            margin-bottom: var(--spacing-xl);
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-lg);
            padding: var(--spacing-xl);
        }
        
        .rating-overview {
            text-align: center;
        }
        
        .rating-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: var(--spacing-sm);
        }
        
        .rating-bars {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-sm);
        }
        
        .rating-bar {
            display: flex;
            align-items: center;
            gap: var(--spacing-md);
        }
        
        .bar-label {
            color: var(--text-muted);
            font-size: 0.9rem;
            width: 60px;
        }
        
        .bar-fill {
            flex: 1;
            height: 8px;
            background: var(--glass-border);
            border-radius: var(--border-radius-full);
            overflow: hidden;
        }
        
        .bar-progress {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: var(--border-radius-full);
        }
        
        .bar-count {
            color: var(--text-muted);
            font-size: 0.9rem;
            width: 40px;
            text-align: right;
        }
        
        .review-item {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-lg);
            padding: var(--spacing-xl);
            margin-bottom: var(--spacing-lg);
        }
        
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: var(--spacing-md);
        }
        
        .review-user {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-xs);
        }
        
        .user-name {
            color: var(--text-light);
            font-weight: 600;
        }
        
        .review-date {
            color: var(--text-muted);
            font-size: 0.85rem;
        }
        
        .verified-badge {
            background: var(--success-color);
            color: white;
            padding: var(--spacing-xs) var(--spacing-sm);
            border-radius: var(--border-radius-sm);
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .review-title {
            color: var(--text-light);
            font-weight: 600;
            margin-bottom: var(--spacing-sm);
        }
        
        .review-comment {
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: var(--spacing-md);
        }
        
        .review-actions {
            display: flex;
            align-items: center;
            gap: var(--spacing-lg);
        }
        
        .helpful-btn {
            background: none;
            border: 1px solid var(--glass-border);
            color: var(--text-muted);
            padding: var(--spacing-sm) var(--spacing-md);
            border-radius: var(--border-radius-sm);
            cursor: pointer;
            transition: all var(--transition-normal);
            font-size: 0.85rem;
        }
        
        .helpful-btn:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .related-products {
            margin-top: var(--spacing-3xl);
        }
        
        .related-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: var(--spacing-xl);
        }
        
        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: var(--spacing-xl);
        }
        
        .success-message {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: #28a745;
            padding: var(--spacing-lg);
            border-radius: var(--border-radius-md);
            margin-bottom: var(--spacing-xl);
            backdrop-filter: blur(10px);
            text-align: center;
            font-weight: 500;
        }
        
        @media (max-width: 768px) {
            .product-main {
                grid-template-columns: 1fr;
                gap: var(--spacing-xl);
            }
            
            .product-gallery {
                position: static;
            }
            
            .main-image {
                height: 300px;
            }
            
            .product-title {
                font-size: 1.5rem;
            }
            
            .price-current {
                font-size: 2rem;
            }
            
            .details-tabs {
                flex-wrap: wrap;
            }
            
            .tab-button {
                padding: var(--spacing-md);
                font-size: 0.9rem;
            }
            
            .reviews-summary {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .related-grid {
                grid-template-columns: 1fr;
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
                        <li><a href="produtos.php">Produtos</a></li>
                        <li><a href="sobre.php">Sobre</a></li>
                        <li><a href="contato.php">Contato</a></li>
                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <li><a href="perfil.php">Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</a></li>
                            <li><a href="logout.php">Sair</a></li>
                        <?php else: ?>
                            <li><a href="login_new.php" class="btn-login">Login</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <a href="carrinho.php" class="cart-icon">
                    🛒 Carrinho (<?php echo array_sum($_SESSION['cart']); ?>)
                </a>
            </div>
        </div>
    </header>

    <main class="product-container">
        <nav class="breadcrumb">
            <a href="index.php">Início</a> > 
            <a href="produtos.php">Produtos</a> > 
            <a href="#"><?php echo htmlspecialchars($produto['categoria']); ?></a> > 
            <span><?php echo htmlspecialchars($produto['nome']); ?></span>
        </nav>

        <?php if (isset($mensagem_sucesso)): ?>
            <div class="success-message">
                ✅ <?php echo htmlspecialchars($mensagem_sucesso); ?>
            </div>
        <?php endif; ?>

        <div class="product-main">
            <div class="product-gallery">
                <div class="main-image">
                    <span>Imagem Principal do Produto</span>
                </div>
                <div class="image-thumbnails">
                    <div class="thumbnail active">Img 1</div>
                    <div class="thumbnail">Img 2</div>
                    <div class="thumbnail">Img 3</div>
                </div>
            </div>

            <div class="product-info">
                <h1 class="product-title"><?php echo htmlspecialchars($produto['nome']); ?></h1>
                
                <div class="product-rating">
                    <div class="stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="star <?php echo $i <= floor($produto['avaliacao_media']) ? '' : 'empty'; ?>">★</span>
                        <?php endfor; ?>
                    </div>
                    <span class="rating-text">
                        <?php echo $produto['avaliacao_media']; ?> 
                        (<a href="#reviews"><?php echo $produto['total_avaliacoes']; ?> avaliações</a>)
                    </span>
                </div>

                <div class="price-section">
                    <?php if ($produto['desconto'] > 0): ?>
                        <div class="price-original">R$ <?php echo number_format($produto['preco_original'], 2, ',', '.'); ?></div>
                        <div class="discount-badge"><?php echo $produto['desconto']; ?>% OFF</div>
                    <?php endif; ?>
                    <div class="price-current">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></div>
                    
                    <div class="shipping-info">
                        <?php if ($produto['frete_gratis']): ?>
                            <div class="shipping-item highlight">
                                🚚 Frete GRÁTIS para todo o Brasil
                            </div>
                        <?php endif; ?>
                        <?php if ($produto['entrega_rapida']): ?>
                            <div class="shipping-item highlight">
                                ⚡ Entrega rápida em 24-48h
                            </div>
                        <?php endif; ?>
                        <div class="shipping-item">
                            📦 Estoque disponível: <?php echo $produto['estoque']; ?> unidades
                        </div>
                        <div class="shipping-item">
                            🔒 Compra 100% segura e protegida
                        </div>
                    </div>
                </div>

                <form method="POST" class="purchase-form">
                    <div class="quantity-selector">
                        <span class="quantity-label">Quantidade:</span>
                        <div class="quantity-controls">
                            <button type="button" class="quantity-btn" onclick="changeQuantity(-1)">-</button>
                            <input type="number" class="quantity-input" name="quantidade" value="1" min="1" max="<?php echo $produto['estoque']; ?>" id="quantity">
                            <button type="button" class="quantity-btn" onclick="changeQuantity(1)">+</button>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button type="submit" name="comprar_agora" class="btn-buy-now">
                            Comprar Agora
                        </button>
                        <button type="submit" name="adicionar_carrinho" class="btn-add-cart">
                            Adicionar ao Carrinho
                        </button>
                    </div>
                </form>

                <div class="seller-info">
                    <div class="seller-name"><?php echo htmlspecialchars($produto['vendedor']); ?></div>
                    <span class="seller-badge">✓ Vendedor Verificado</span>
                </div>
            </div>
        </div>

        <div class="product-details">
            <div class="details-tabs">
                <button class="tab-button active" onclick="switchTab('description')">Descrição</button>
                <button class="tab-button" onclick="switchTab('specifications')">Especificações</button>
                <button class="tab-button" onclick="switchTab('reviews')">Avaliações</button>
            </div>

            <div class="tab-content active" id="description">
                <div class="description-content">
                    <?php 
                    $paragraphs = explode("\n\n", $produto['descricao_completa']);
                    foreach ($paragraphs as $paragraph): 
                    ?>
                        <p><?php echo htmlspecialchars($paragraph); ?></p>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="tab-content" id="specifications">
                <table class="specs-table">
                    <?php foreach ($produto['especificacoes'] as $spec => $value): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($spec); ?></td>
                            <td><?php echo htmlspecialchars($value); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>

            <div class="tab-content" id="reviews">
                <div class="reviews-section">
                    <div class="reviews-summary">
                        <div class="rating-overview">
                            <div class="rating-number"><?php echo $produto['avaliacao_media']; ?></div>
                            <div class="stars">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span class="star <?php echo $i <= floor($produto['avaliacao_media']) ? '' : 'empty'; ?>">★</span>
                                <?php endfor; ?>
                            </div>
                            <div style="color: var(--text-muted); margin-top: var(--spacing-sm);">
                                <?php echo $produto['total_avaliacoes']; ?> avaliações
                            </div>
                        </div>
                        
                        <div class="rating-bars">
                            <div class="rating-bar">
                                <span class="bar-label">5 estrelas</span>
                                <div class="bar-fill">
                                    <div class="bar-progress" style="width: 78%"></div>
                                </div>
                                <span class="bar-count">972</span>
                            </div>
                            <div class="rating-bar">
                                <span class="bar-label">4 estrelas</span>
                                <div class="bar-fill">
                                    <div class="bar-progress" style="width: 15%"></div>
                                </div>
                                <span class="bar-count">187</span>
                            </div>
                            <div class="rating-bar">
                                <span class="bar-label">3 estrelas</span>
                                <div class="bar-fill">
                                    <div class="bar-progress" style="width: 5%"></div>
                                </div>
                                <span class="bar-count">62</span>
                            </div>
                            <div class="rating-bar">
                                <span class="bar-label">2 estrelas</span>
                                <div class="bar-fill">
                                    <div class="bar-progress" style="width: 1%"></div>
                                </div>
                                <span class="bar-count">15</span>
                            </div>
                            <div class="rating-bar">
                                <span class="bar-label">1 estrela</span>
                                <div class="bar-fill">
                                    <div class="bar-progress" style="width: 1%"></div>
                                </div>
                                <span class="bar-count">11</span>
                            </div>
                        </div>
                    </div>

                    <?php foreach ($avaliacoes as $avaliacao): ?>
                        <div class="review-item">
                            <div class="review-header">
                                <div class="review-user">
                                    <span class="user-name"><?php echo htmlspecialchars($avaliacao['usuario']); ?></span>
                                    <span class="review-date"><?php echo date('d/m/Y', strtotime($avaliacao['data'])); ?></span>
                                </div>
                                <?php if ($avaliacao['verificado']): ?>
                                    <span class="verified-badge">✓ Compra Verificada</span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="stars" style="margin-bottom: var(--spacing-sm);">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span class="star <?php echo $i <= $avaliacao['nota'] ? '' : 'empty'; ?>">★</span>
                                <?php endfor; ?>
                            </div>
                            
                            <h4 class="review-title"><?php echo htmlspecialchars($avaliacao['titulo']); ?></h4>
                            <p class="review-comment"><?php echo htmlspecialchars($avaliacao['comentario']); ?></p>
                            
                            <div class="review-actions">
                                <button class="helpful-btn">
                                    👍 Útil (<?php echo $avaliacao['util']; ?>)
                                </button>
                                <button class="helpful-btn">
                                    💬 Responder
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <?php if (!empty($produtos_relacionados)): ?>
            <div class="related-products">
                <h2 class="related-title">Produtos Relacionados</h2>
                <div class="related-grid">
                    <?php foreach (array_slice($produtos_relacionados, 0, 3) as $relacionado): ?>
                        <div class="product-card">
                            <div class="product-image">
                                <span>Imagem do Produto</span>
                            </div>
                            <div class="product-category"><?php echo htmlspecialchars($relacionado['categoria']); ?></div>
                            <h3 class="product-title"><?php echo htmlspecialchars($relacionado['nome']); ?></h3>
                            <div class="product-price">R$ <?php echo number_format($relacionado['preco'], 2, ',', '.'); ?></div>
                            <p class="product-description"><?php echo htmlspecialchars(substr($relacionado['descricao_curta'], 0, 100)) . '...'; ?></p>
                            <a href="produto_new.php?id=<?php echo $relacionado['id']; ?>" class="btn btn-primary">Ver Detalhes</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 E-commerce Project. Todos os direitos reservados.</p>
            <p>Desenvolvido por <a href="#" class="dexo-credit">Dexo</a></p>
        </div>
    </footer>

    <script>
        function switchTab(tabName) {
            // Remover classe active de todos os botões e conteúdos
            document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
            
            // Adicionar classe active ao botão e conteúdo selecionados
            event.target.classList.add('active');
            document.getElementById(tabName).classList.add('active');
        }
        
        function changeQuantity(change) {
            const input = document.getElementById('quantity');
            const currentValue = parseInt(input.value);
            const newValue = currentValue + change;
            const max = parseInt(input.max);
            
            if (newValue >= 1 && newValue <= max) {
                input.value = newValue;
            }
        }
        
        // Efeito de troca de imagens nas thumbnails
        document.querySelectorAll('.thumbnail').forEach((thumb, index) => {
            thumb.addEventListener('click', function() {
                document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                // Aqui você adicionaria a lógica para trocar a imagem principal
                const mainImage = document.querySelector('.main-image');
                mainImage.innerHTML = `<span>Imagem ${index + 1} do Produto</span>`;
            });
        });
        
        // Animação de scroll suave para as avaliações
        document.querySelector('a[href="#reviews"]')?.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('#reviews').scrollIntoView({
                behavior: 'smooth'
            });
            switchTab('reviews');
        });
        
        // Validação da quantidade
        document.getElementById('quantity').addEventListener('input', function() {
            const value = parseInt(this.value);
            const max = parseInt(this.max);
            
            if (value > max) {
                this.value = max;
            } else if (value < 1) {
                this.value = 1;
            }
        });
    </script>
    
    <script src="animations.js"></script>
</body>
</html>

