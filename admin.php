<?php
session_start();
require_once 'db_connect.php';

// Verificar se o usuário é admin
if (!isset($_SESSION['usuario_id']) || !verificarAdmin($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

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

$mensagem = '';
$tipo_mensagem = '';

// Obter categorias do banco de dados
$categorias = obterCategorias();

// Processar formulário de adicionar produto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar_produto'])) {
    $nome = trim($_POST['nome'] ?? '');
    $descricao_curta = trim($_POST['descricao_curta'] ?? '');
    $descricao_longa = trim($_POST['descricao_longa'] ?? '');
    $preco = floatval(str_replace(',', '.', $_POST['preco'] ?? 0)); // Converte vírgula para ponto
    $categoria_id = intval($_POST['categoria_id'] ?? 0);
    $estoque = intval($_POST['estoque'] ?? 0);
    $destaque = isset($_POST['destaque']) ? 1 : 0;
    $especificacoes_json = trim($_POST['especificacoes_json'] ?? '');

    // Validar dados
    if (empty($nome) || empty($descricao_curta) || empty($descricao_longa) || $preco <= 0 || $categoria_id <= 0 || $estoque < 0) {
        $mensagem = "Por favor, preencha todos os campos obrigatórios corretamente.";
        $tipo_mensagem = "error";
    } else {
        $imagem_url = '';
        
        // Processar upload de imagem se fornecida
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadResult = uploadImagem($_FILES['imagem']);
            if ($uploadResult['success']) {
                $imagem_url = $uploadResult['filepath']; // Salva o caminho completo
            } else {
                $mensagem = $uploadResult['message'];
                $tipo_mensagem = "error";
            }
        }
        
        if (empty($mensagem)) { // Se não houve erro no upload
            $produto_id = adicionarProduto($nome, $descricao_curta, $descricao_longa, $preco, $categoria_id, $estoque, $imagem_url, $especificacoes_json, $destaque);
            
            if ($produto_id) {
                $mensagem = "Produto adicionado com sucesso! ID: " . $produto_id;
                $tipo_mensagem = "success";
                // Limpar campos do formulário após sucesso
                $_POST = array(); 
            } else {
                $mensagem = "Erro ao adicionar produto. Verifique os logs.";
                $tipo_mensagem = "error";
            }
        }
    }
}

// Obter todos os produtos para listar
$produtos_cadastrados = obterTodosProdutos();

// Obter estatísticas de produtos
$estatisticas_produtos = obterEstatisticasProdutos();

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
            object-fit: cover;
            border-radius: var(--border-radius-sm);
            display: block;
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
                        <li><a href="admin.php">Admin</a></li>
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
                <span class="stat-number"><?php echo $estatisticas_produtos['total_produtos']; ?></span>
                <span class="stat-label">Produtos Cadastrados</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">R$ <?php echo number_format($estatisticas_produtos['valor_total_estoque'], 2, ',', '.'); ?></span>
                <span class="stat-label">Valor Total Estoque</span>
            </div>
            <div class="stat-card">
                <span class="stat-number"><?php echo $estatisticas_produtos['produtos_destaque']; ?></span>
                <span class="stat-label">Produtos em Destaque</span>
            </div>
            <div class="stat-card">
                <span class="stat-number"><?php echo $estatisticas_produtos['produtos_baixo_estoque']; ?></span>
                <span class="stat-label">Baixo Estoque</span>
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
                               placeholder="Ex: Smartphone Samsung Galaxy S24" value="<?php echo htmlspecialchars($_POST['nome'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="descricao_curta" class="form-label">Descrição Curta</label>
                        <textarea id="descricao_curta" name="descricao_curta" class="form-textarea" 
                                  placeholder="Breve descrição do produto (máx. 255 caracteres)" required><?php echo htmlspecialchars($_POST['descricao_curta'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="descricao_longa" class="form-label">Descrição Longa</label>
                        <textarea id="descricao_longa" name="descricao_longa" class="form-textarea" 
                                  placeholder="Descrição detalhada do produto" required><?php echo htmlspecialchars($_POST['descricao_longa'] ?? ''); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="preco" class="form-label">Preço (R$)</label>
                        <input type="number" id="preco" name="preco" class="form-input" step="0.01" 
                               placeholder="Ex: 899.99" value="<?php echo htmlspecialchars($_POST['preco'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="categoria_id" class="form-label">Categoria</label>
                        <select id="categoria_id" name="categoria_id" class="form-select" required>
                            <option value="">Selecione uma categoria</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>" <?php echo (isset($_POST['categoria_id']) && $_POST['categoria_id'] == $cat['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat['nome']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="estoque" class="form-label">Estoque</label>
                        <input type="number" id="estoque" name="estoque" class="form-input" 
                               placeholder="Ex: 50" value="<?php echo htmlspecialchars($_POST['estoque'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="especificacoes_json" class="form-label">Especificações (JSON)</label>
                        <textarea id="especificacoes_json" name="especificacoes_json" class="form-textarea" 
                                  placeholder="Ex: {'Cor': 'Preto', 'Memória': '128GB'}"><?php echo htmlspecialchars($_POST['especificacoes_json'] ?? ''); ?></textarea>
                        <p class="file-upload-hint">Formato JSON: {"Chave":"Valor", "Outra Chave":"Outro Valor"}</p>
                    </div>

                    <div class="form-group">
                        <label for="imagem" class="form-label">Imagem do Produto</label>
                        <div class="file-upload-container">
                            <input type="file" id="imagem" name="imagem" class="file-upload-input" accept="image/*">
                            <label for="imagem" class="file-upload-label">
                                <span class="file-upload-icon">🖼️</span>
                                <span class="file-upload-text">Arraste e solte ou clique para selecionar uma imagem</span>
                                <span class="file-upload-hint">JPG, PNG, GIF ou WebP (Máx. 5MB)</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="checkbox" id="destaque" name="destaque" value="1" <?php echo (isset($_POST['destaque']) && $_POST['destaque'] == 1) ? 'checked' : ''; ?>>
                        <label for="destaque" class="form-label" style="display: inline; margin-left: 10px;">Marcar como Destaque</label>
                    </div>
                    
                    <button type="submit" name="adicionar_produto" class="btn-admin">
                        Adicionar Produto
                    </button>
                </form>
            </div>

            <!-- Lista de Produtos Cadastrados -->
            <div class="admin-card products-list">
                <h2 class="card-title">
                    <span class="card-icon">📋</span>
                    Produtos Cadastrados
                </h2>
                <div style="max-height: 600px; overflow-y: auto;">
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Imagem</th>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Preço</th>
                                <th>Estoque</th>
                                <th>Destaque</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($produtos_cadastrados)): ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; color: var(--text-dark);">Nenhum produto cadastrado ainda.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($produtos_cadastrados as $produto): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($produto['id']); ?></td>
                                        <td>
                                            <?php if (!empty($produto['imagem_url'])): ?>
                                                <img src="<?php echo htmlspecialchars($produto['imagem_url']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" class="product-image-thumb">
                                            <?php else: ?>
                                                <div class="product-image-thumb">N/A</div>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($produto['nome']); ?></td>
                                        <td><?php echo htmlspecialchars($produto['categoria_nome']); ?></td>
                                        <td class="price-cell">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                                        <td><?php echo htmlspecialchars($produto['estoque']); ?></td>
                                        <td><?php echo $produto['destaque'] ? 'Sim' : 'Não'; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
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

