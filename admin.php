<?php
session_start();

// Simulação de verificação de admin (em produção, usar sistema de autenticação real)
$isAdmin = true; // Para demonstração

// Função para fazer upload de imagem
function uploadImagem($arquivo) {
    $uploadDir = 'uploads/produtos/';
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $maxSize = 5 * 1024 * 1024; // 5MB
    
    if (!isset($arquivo) || $arquivo['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'Erro no upload do arquivo.'];
    }
    
    if (!in_array($arquivo['type'], $allowedTypes)) {
        return ['success' => false, 'message' => 'Tipo de arquivo não permitido. Use JPG, PNG, GIF ou WebP.'];
    }
    
    if ($arquivo['size'] > $maxSize) {
        return ['success' => false, 'message' => 'Arquivo muito grande. Máximo 5MB.'];
    }
    
    $extension = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
    $filename = uniqid('produto_') . '.' . $extension;
    $filepath = $uploadDir . $filename;
    
    if (move_uploaded_file($arquivo['tmp_name'], $filepath)) {
        return ['success' => true, 'filename' => $filename, 'filepath' => $filepath];
    } else {
        return ['success' => false, 'message' => 'Erro ao salvar o arquivo.'];
    }
}

// Produtos de exemplo (simulando banco de dados)
$produtos = [
    [
        'id' => 1,
        'nome' => 'Smartphone Samsung Galaxy S24',
        'categoria' => 'Eletrônicos',
        'preco' => 899.99,
        'descricao' => 'Smartphone premium com tela Dynamic AMOLED de 6.1 polegadas',
        'imagem' => 'produto_1.jpg'
    ],
    [
        'id' => 2,
        'nome' => 'Notebook Dell Inspiron 15 3000',
        'categoria' => 'Informática',
        'preco' => 2499.99,
        'descricao' => 'Notebook para uso profissional com processador Intel Core i5',
        'imagem' => 'produto_2.jpg'
    ]
];

$mensagem = '';
$tipo_mensagem = '';

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $preco = floatval($_POST['preco'] ?? 0);
    $descricao = trim($_POST['descricao'] ?? '');
    
    // Validar dados
    if (empty($nome) || empty($categoria) || $preco <= 0 || empty($descricao)) {
        $mensagem = "Por favor, preencha todos os campos corretamente.";
        $tipo_mensagem = "error";
    } else {
        $imagemPath = '';
        
        // Processar upload de imagem se fornecida
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadResult = uploadImagem($_FILES['imagem']);
            if ($uploadResult['success']) {
                $imagemPath = $uploadResult['filename'];
            } else {
                $mensagem = $uploadResult['message'];
                $tipo_mensagem = "error";
            }
        }
        
        if (empty($mensagem)) {
            // Simular adição ao banco de dados
            $novoProduto = [
                'id' => count($produtos) + 1,
                'nome' => $nome,
                'categoria' => $categoria,
                'preco' => $preco,
                'descricao' => $descricao,
                'imagem' => $imagemPath
            ];
            
            $produtos[] = $novoProduto;
            $mensagem = "Produto adicionado com sucesso!";
            $tipo_mensagem = "success";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - E-commerce Project</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="components.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .admin-container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 var(--spacing-lg);
        }
        
        .admin-header {
            text-align: center;
            margin-bottom: var(--spacing-3xl);
            padding: var(--spacing-xl) 0;
        }
        
        .admin-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: var(--spacing-md);
        }
        
        .admin-subtitle {
            color: var(--text-muted);
            font-size: 1.1rem;
        }
        
        .admin-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--spacing-3xl);
            margin-bottom: var(--spacing-3xl);
        }
        
        .admin-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-xl);
            padding: var(--spacing-3xl);
            transition: all var(--transition-normal);
        }
        
        .admin-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
            border-color: rgba(255, 255, 255, 0.2);
        }
        
        .card-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: var(--spacing-xl);
            display: flex;
            align-items: center;
            gap: var(--spacing-md);
        }
        
        .card-icon {
            font-size: 1.8rem;
        }
        
        .form-group {
            margin-bottom: var(--spacing-xl);
        }
        
        .form-label {
            display: block;
            color: var(--text-light);
            font-weight: 500;
            margin-bottom: var(--spacing-sm);
            font-size: 0.95rem;
        }
        
        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: var(--spacing-lg);
            background: rgba(255, 255, 255, 0.08);
            border: 2px solid var(--glass-border);
            border-radius: var(--border-radius-md);
            color: var(--text-light);
            font-size: 1rem;
            transition: all var(--transition-normal);
            backdrop-filter: blur(10px);
        }
        
        .form-input:focus, .form-textarea:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.2);
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-2px);
        }
        
        .form-input::placeholder, .form-textarea::placeholder {
            color: var(--text-dark);
        }
        
        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        .file-upload-container {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }
        
        .file-upload-input {
            position: absolute;
            left: -9999px;
        }
        
        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--spacing-md);
            padding: var(--spacing-lg);
            background: rgba(255, 255, 255, 0.08);
            border: 2px dashed var(--glass-border);
            border-radius: var(--border-radius-md);
            color: var(--text-light);
            cursor: pointer;
            transition: all var(--transition-normal);
            backdrop-filter: blur(10px);
            min-height: 120px;
            flex-direction: column;
        }
        
        .file-upload-label:hover {
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-2px);
        }
        
        .file-upload-icon {
            font-size: 2rem;
            color: var(--primary-color);
        }
        
        .file-upload-text {
            text-align: center;
        }
        
        .file-upload-hint {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: var(--spacing-xs);
        }
        
        .btn-admin {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            border: none;
            padding: var(--spacing-lg) var(--spacing-2xl);
            border-radius: var(--border-radius-md);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-normal);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
            width: 100%;
        }
        
        .btn-admin::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left var(--transition-slow);
        }
        
        .btn-admin:hover::before {
            left: 100%;
        }
        
        .btn-admin:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .products-list {
            background: var(--glass-bg);
            backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-xl);
            padding: var(--spacing-3xl);
            grid-column: 1 / -1;
        }
        
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: var(--spacing-xl);
        }
        
        .products-table th,
        .products-table td {
            padding: var(--spacing-lg);
            text-align: left;
            border-bottom: 1px solid var(--glass-border);
        }
        
        .products-table th {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-light);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        .products-table td {
            color: var(--text-muted);
        }
        
        .product-image-thumb {
            width: 50px;
            height: 50px;
            background: var(--card-bg);
            border-radius: var(--border-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            color: var(--text-dark);
        }
        
        .price-cell {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .alert {
            padding: var(--spacing-lg);
            border-radius: var(--border-radius-md);
            margin-bottom: var(--spacing-xl);
            font-weight: 500;
            backdrop-filter: blur(10px);
        }
        
        .alert-success {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: #28a745;
        }
        
        .alert-error {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #dc3545;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--spacing-xl);
            margin-bottom: var(--spacing-3xl);
        }
        
        .stat-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-lg);
            padding: var(--spacing-xl);
            text-align: center;
            transition: all var(--transition-normal);
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            display: block;
            margin-bottom: var(--spacing-sm);
        }
        
        .stat-label {
            color: var(--text-muted);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        @media (max-width: 768px) {
            .admin-grid {
                grid-template-columns: 1fr;
                gap: var(--spacing-xl);
            }
            
            .admin-card {
                padding: var(--spacing-xl);
            }
            
            .products-table {
                font-size: 0.9rem;
            }
            
            .products-table th,
            .products-table td {
                padding: var(--spacing-md);
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
                        <li><a href="admin_new.php">Admin</a></li>
                        <li><a href="logout.php">Sair</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="admin-container">
        <div class="admin-header">
            <h1 class="admin-title">Painel Administrativo</h1>
            <p class="admin-subtitle">Gerencie produtos e monitore o desempenho da sua loja</p>
        </div>

        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-<?php echo $tipo_mensagem; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <!-- Estatísticas -->
        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-number"><?php echo count($produtos); ?></span>
                <span class="stat-label">Produtos Cadastrados</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">R$ <?php echo number_format(array_sum(array_column($produtos, 'preco')), 2, ',', '.'); ?></span>
                <span class="stat-label">Valor Total Estoque</span>
            </div>
            <div class="stat-card">
                <span class="stat-number"><?php echo count(array_unique(array_column($produtos, 'categoria'))); ?></span>
                <span class="stat-label">Categorias Ativas</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">98%</span>
                <span class="stat-label">Taxa de Satisfação</span>
            </div>
        </div>

        <div class="admin-grid">
            <!-- Formulário de Adicionar Produto -->
            <div class="admin-card">
                <h2 class="card-title">
                    <span class="card-icon">📦</span>
                    Adicionar Novo Produto
                </h2>
                
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nome" class="form-label">Nome do Produto</label>
                        <input type="text" id="nome" name="nome" class="form-input" 
                               placeholder="Ex: Smartphone Samsung Galaxy S24" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="categoria" class="form-label">Categoria</label>
                        <select id="categoria" name="categoria" class="form-select" required>
                            <option value="">Selecione uma categoria</option>
                            <option value="Eletrônicos">Eletrônicos</option>
                            <option value="Informática">Informática</option>
                            <option value="Gaming">Gaming</option>
                            <option value="Áudio">Áudio</option>
                            <option value="Casa e Jardim">Casa e Jardim</option>
                            <option value="Esportes">Esportes</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="preco" class="form-label">Preço (R$)</label>
                        <input type="number" id="preco" name="preco" class="form-input" 
                               step="0.01" min="0" placeholder="0,00" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="imagem" class="form-label">Imagem do Produto</label>
                        <div class="file-upload-container">
                            <input type="file" id="imagem" name="imagem" class="file-upload-input" 
                                   accept="image/jpeg,image/png,image/gif,image/webp">
                            <label for="imagem" class="file-upload-label">
                                <span class="file-upload-icon">📷</span>
                                <div class="file-upload-text">
                                    <strong>Clique para selecionar uma imagem</strong>
                                    <div class="file-upload-hint">JPG, PNG, GIF ou WebP (máx. 5MB)</div>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea id="descricao" name="descricao" class="form-textarea" 
                                  placeholder="Descreva detalhadamente o produto, suas características e benefícios..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn-admin">
                        Adicionar Produto
                    </button>
                </form>
            </div>

            <!-- Painel de Controle -->
            <div class="admin-card">
                <h2 class="card-title">
                    <span class="card-icon">⚙️</span>
                    Painel de Controle
                </h2>
                
                <div style="display: flex; flex-direction: column; gap: var(--spacing-lg);">
                    <button class="btn btn-secondary" onclick="window.location.href='index.php'">
                        🏠 Ver Site Principal
                    </button>
                    <button class="btn btn-secondary" onclick="window.location.href='produtos.php'">
                        📋 Gerenciar Produtos
                    </button>
                    <button class="btn btn-secondary" onclick="window.location.href='#'">
                        👥 Gerenciar Usuários
                    </button>
                    <button class="btn btn-secondary" onclick="window.location.href='#'">
                        📊 Relatórios
                    </button>
                    <button class="btn btn-secondary" onclick="window.location.href='#'">
                        🛒 Pedidos
                    </button>
                </div>
                
                <div style="margin-top: var(--spacing-xl); padding-top: var(--spacing-xl); border-top: 1px solid var(--glass-border);">
                    <h3 style="color: var(--text-light); margin-bottom: var(--spacing-md);">Ações Rápidas</h3>
                    <div style="display: flex; flex-direction: column; gap: var(--spacing-sm);">
                        <button class="btn btn-primary" style="font-size: 0.9rem; padding: var(--spacing-sm) var(--spacing-md);">
                            🔄 Sincronizar Estoque
                        </button>
                        <button class="btn btn-primary" style="font-size: 0.9rem; padding: var(--spacing-sm) var(--spacing-md);">
                            📧 Enviar Newsletter
                        </button>
                        <button class="btn btn-primary" style="font-size: 0.9rem; padding: var(--spacing-sm) var(--spacing-md);">
                            🧹 Limpar Cache
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Produtos -->
        <div class="products-list">
            <h2 class="card-title">
                <span class="card-icon">📋</span>
                Produtos Cadastrados
            </h2>
            
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Preço</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td>
                                <div class="product-image-thumb">
                                    <?php if (!empty($produto['imagem'])): ?>
                                        <img src="uploads/produtos/<?php echo htmlspecialchars($produto['imagem']); ?>" 
                                             alt="<?php echo htmlspecialchars($produto['nome']); ?>"
                                             style="width: 100%; height: 100%; object-fit: cover; border-radius: var(--border-radius-sm);">
                                    <?php else: ?>
                                        📷
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($produto['nome']); ?></td>
                            <td><?php echo htmlspecialchars($produto['categoria']); ?></td>
                            <td class="price-cell">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars(substr($produto['descricao'], 0, 50)) . '...'; ?></td>
                            <td>
                                <button class="btn btn-secondary" style="font-size: 0.8rem; padding: var(--spacing-xs) var(--spacing-sm);">
                                    ✏️ Editar
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 E-commerce Project. Todos os direitos reservados.</p>
            <p>Desenvolvido por <a href="#" class="dexo-credit">Dexo</a></p>
        </div>
    </footer>

    <script>
        // Atualizar label do upload quando arquivo for selecionado
        document.getElementById('imagem').addEventListener('change', function(e) {
            const label = document.querySelector('.file-upload-label');
            const file = e.target.files[0];
            
            if (file) {
                label.innerHTML = `
                    <span class="file-upload-icon">✅</span>
                    <div class="file-upload-text">
                        <strong>${file.name}</strong>
                        <div class="file-upload-hint">Arquivo selecionado (${(file.size / 1024 / 1024).toFixed(2)} MB)</div>
                    </div>
                `;
                label.style.borderColor = 'var(--success-color)';
                label.style.background = 'rgba(40, 167, 69, 0.1)';
            }
        });

        // Validação em tempo real do preço
        document.getElementById('preco').addEventListener('input', function(e) {
            const value = parseFloat(e.target.value);
            if (value < 0) {
                e.target.style.borderColor = 'var(--danger-color)';
            } else {
                e.target.style.borderColor = '';
            }
        });

        // Contador de caracteres para descrição
        const descricaoTextarea = document.getElementById('descricao');
        const maxLength = 1000;
        
        descricaoTextarea.addEventListener('input', function(e) {
            const length = e.target.value.length;
            const remaining = maxLength - length;
            
            if (!document.querySelector('.char-counter')) {
                const counter = document.createElement('div');
                counter.className = 'char-counter';
                counter.style.cssText = `
                    font-size: 0.8rem;
                    color: var(--text-muted);
                    text-align: right;
                    margin-top: var(--spacing-xs);
                `;
                e.target.parentNode.appendChild(counter);
            }
            
            const counter = document.querySelector('.char-counter');
            counter.textContent = `${length}/${maxLength} caracteres`;
            
            if (remaining < 50) {
                counter.style.color = 'var(--warning-color)';
            } else if (remaining < 0) {
                counter.style.color = 'var(--danger-color)';
            } else {
                counter.style.color = 'var(--text-muted)';
            }
        });
    </script>
    
    <script src="animations.js"></script>
</body>
</html>

