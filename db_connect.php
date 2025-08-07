<?php
/**
 * Arquivo de conexão com o banco de dados MySQL
 * E-commerce Project
 */

// Configurações do banco de dados
$db_host = 'localhost';
$db_name = 'ecommerce_db';
$db_user = 'ecommerce_user';
$db_pass = 'password';

try {
    // Criar conexão PDO
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    
    // Configurar PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Configurar PDO para retornar arrays associativos
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

/**
 * Função para obter um produto pelo ID
 */
function obterProduto($id) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT p.*, c.nome as categoria_nome FROM produtos p 
                              LEFT JOIN categorias c ON p.categoria_id = c.id 
                              WHERE p.id = ?");
        $stmt->execute([$id]);
        $produto = $stmt->fetch();
        
        if ($produto) {
            // Manter compatibilidade com o código existente
            $produto['categoria'] = $produto['categoria_nome'];
        }
        
        return $produto;
    } catch (PDOException $e) {
        error_log("Erro ao obter produto: " . $e->getMessage());
        return null;
    }
}

/**
 * Função para obter todos os produtos
 */
function obterTodosProdutos() {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT p.*, c.nome as categoria_nome FROM produtos p 
                              LEFT JOIN categorias c ON p.categoria_id = c.id 
                              ORDER BY p.id");
        $stmt->execute();
        $produtos = $stmt->fetchAll();
        
        // Manter compatibilidade com o código existente
        foreach ($produtos as &$produto) {
            $produto['categoria'] = $produto['categoria_nome'];
        }
        
        return $produtos;
    } catch (PDOException $e) {
        error_log("Erro ao obter produtos: " . $e->getMessage());
        return [];
    }
}

/**
 * Função para obter produtos em destaque (primeiros 4)
 */
function obterProdutosDestaque($limite = 4) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT p.*, c.nome as categoria_nome FROM produtos p 
                              LEFT JOIN categorias c ON p.categoria_id = c.id 
                              ORDER BY p.id LIMIT ?");
        $stmt->execute([$limite]);
        $produtos = $stmt->fetchAll();
        
        // Manter compatibilidade com o código existente
        foreach ($produtos as &$produto) {
            $produto['categoria'] = $produto['categoria_nome'];
        }
        
        return $produtos;
    } catch (PDOException $e) {
        error_log("Erro ao obter produtos em destaque: " . $e->getMessage());
        return [];
    }
}

/**
 * Função para calcular o total do carrinho
 */
function calcularTotalCarrinho($carrinho) {
    global $pdo;
    $total = 0;
    
    if (empty($carrinho)) {
        return $total;
    }
    
    try {
        $ids = array_keys($carrinho);
        $placeholders = str_repeat('?,', count($ids) - 1) . '?';
        
        $stmt = $pdo->prepare("SELECT id, preco FROM produtos WHERE id IN ($placeholders)");
        $stmt->execute($ids);
        $produtos = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        
        foreach ($carrinho as $produtoId => $quantidade) {
            if (isset($produtos[$produtoId])) {
                $total += $produtos[$produtoId] * $quantidade;
            }
        }
        
        return $total;
    } catch (PDOException $e) {
        error_log("Erro ao calcular total do carrinho: " . $e->getMessage());
        return 0;
    }
}

/**
 * Função para formatar preço (mantida para compatibilidade)
 */
function formatarPreco($preco) {
    return 'R$ ' . number_format($preco, 2, ',', '.');
}

/**
 * Função para salvar pedido no banco de dados
 */
function salvarPedido($dadosCliente, $carrinho, $total) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        // Inserir pedido
        $stmt = $pdo->prepare("INSERT INTO pedidos (usuario_id, status, total, endereco_entrega, cidade_entrega, cep_entrega) 
                              VALUES (NULL, 'Pendente', ?, ?, ?, ?)");
            $stmt->execute([
                $total,
                $dadosCliente["endereco"] ?? null,
                $dadosCliente["cidade"] ?? null,
                $dadosCliente["cep"] ?? null
            ]);
        
        $pedidoId = $pdo->lastInsertId();
        
        // Inserir itens do pedido
        $stmt = $pdo->prepare("INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unitario) 
                              VALUES (?, ?, ?, ?)");
        
        foreach ($carrinho as $produtoId => $quantidade) {
            $produto = obterProduto($produtoId);
            if ($produto) {
                $stmt->execute([$pedidoId, $produtoId, $quantidade, $produto['preco']]);
            }
        }
        
        $pdo->commit();
        return $pedidoId;
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log("Erro ao salvar pedido: " . $e->getMessage());
        return false;
    }
}

/**
 * Função para obter todas as categorias
 */
function obterCategorias() {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM categorias ORDER BY nome");
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Erro ao obter categorias: " . $e->getMessage());
        return [];
    }
}
?>

