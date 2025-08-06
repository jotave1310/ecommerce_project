# Documentação da API - E-commerce Project

Esta documentação descreve as funções, estruturas de dados e fluxos de trabalho do E-commerce Project.

## 📋 Índice

- [Estrutura de Dados](#estrutura-de-dados)
- [Funções Principais](#funções-principais)
- [Fluxo de Sessões](#fluxo-de-sessões)
- [Validações](#validações)
- [Tratamento de Erros](#tratamento-de-erros)
- [Exemplos de Uso](#exemplos-de-uso)

## 🗃️ Estrutura de Dados

### Produto

Estrutura básica de um produto no sistema:

```php
$produto = [
    'id' => int,           // Identificador único do produto
    'nome' => string,      // Nome do produto
    'preco' => float,      // Preço em reais (formato decimal)
    'descricao' => string, // Descrição detalhada
    'categoria' => string  // Categoria do produto
];
```

**Exemplo**:
```php
$produto = [
    'id' => 1,
    'nome' => 'Smartphone Samsung Galaxy',
    'preco' => 899.99,
    'descricao' => 'Smartphone com tela de 6.1 polegadas e câmera de 64MP',
    'categoria' => 'Eletrônicos'
];
```

### Carrinho de Compras

O carrinho é armazenado na sessão PHP como um array associativo:

```php
$_SESSION['cart'] = [
    produto_id => quantidade,
    // Exemplo:
    1 => 2,  // Produto ID 1, quantidade 2
    3 => 1,  // Produto ID 3, quantidade 1
];
```

### Dados do Cliente (Checkout)

```php
$dadosCliente = [
    'nome' => string,      // Nome completo (obrigatório)
    'email' => string,     // Email válido (obrigatório)
    'telefone' => string,  // Telefone (obrigatório)
    'endereco' => string,  // Endereço completo (obrigatório)
    'cidade' => string,    // Cidade (obrigatório)
    'cep' => string        // CEP (obrigatório)
];
```

## 🔧 Funções Principais

### `obterProduto($id)`

Busca um produto específico pelo ID.

**Parâmetros**:
- `$id` (int): ID do produto a ser buscado

**Retorno**:
- `array|null`: Array com dados do produto ou `null` se não encontrado

**Exemplo**:
```php
$produto = obterProduto(1);
if ($produto) {
    echo $produto['nome']; // "Smartphone Samsung Galaxy"
} else {
    echo "Produto não encontrado";
}
```

**Implementação**:
```php
function obterProduto($id) {
    global $produtos;
    return isset($produtos[$id]) ? $produtos[$id] : null;
}
```

### `calcularTotalCarrinho($carrinho)`

Calcula o valor total dos produtos no carrinho.

**Parâmetros**:
- `$carrinho` (array): Array do carrinho no formato `[produto_id => quantidade]`

**Retorno**:
- `float`: Valor total do carrinho

**Exemplo**:
```php
$carrinho = [1 => 2, 3 => 1]; // 2x Produto 1, 1x Produto 3
$total = calcularTotalCarrinho($carrinho);
echo formatarPreco($total); // "R$ 1.999,97"
```

**Implementação**:
```php
function calcularTotalCarrinho($carrinho) {
    global $produtos;
    $total = 0;
    
    foreach ($carrinho as $produtoId => $quantidade) {
        if (isset($produtos[$produtoId])) {
            $total += $produtos[$produtoId]['preco'] * $quantidade;
        }
    }
    
    return $total;
}
```

### `formatarPreco($preco)`

Formata um valor numérico para o padrão monetário brasileiro.

**Parâmetros**:
- `$preco` (float): Valor a ser formatado

**Retorno**:
- `string`: Preço formatado com "R$" e separadores brasileiros

**Exemplo**:
```php
echo formatarPreco(1234.56); // "R$ 1.234,56"
echo formatarPreco(99.9);    // "R$ 99,90"
```

**Implementação**:
```php
function formatarPreco($preco) {
    return 'R$ ' . number_format($preco, 2, ',', '.');
}
```

## 🔄 Fluxo de Sessões

### Inicialização da Sessão

Todas as páginas iniciam com:

```php
session_start();

// Inicializar carrinho se não existir
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
```

### Adição de Produto ao Carrinho

**Fluxo**:
1. Usuário clica em "Adicionar ao Carrinho"
2. Formulário POST é enviado com `produto_id` e `quantidade`
3. Sistema valida os dados
4. Produto é adicionado ou quantidade é incrementada
5. Usuário recebe feedback visual

**Código**:
```php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar_carrinho'])) {
    $produtoId = (int)$_POST['produto_id'];
    $quantidade = isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : 1;
    
    if ($quantidade > 0 && obterProduto($produtoId)) {
        if (isset($_SESSION['cart'][$produtoId])) {
            $_SESSION['cart'][$produtoId] += $quantidade;
        } else {
            $_SESSION['cart'][$produtoId] = $quantidade;
        }
        $mensagem = "Produto adicionado ao carrinho com sucesso!";
    }
}
```

### Remoção de Produto do Carrinho

```php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remover_item'])) {
    $produtoId = (int)$_POST['produto_id'];
    unset($_SESSION['cart'][$produtoId]);
    $mensagem = "Item removido do carrinho!";
}
```

### Atualização de Quantidade

```php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar_quantidade'])) {
    $produtoId = (int)$_POST['produto_id'];
    $novaQuantidade = (int)$_POST['quantidade'];
    
    if ($novaQuantidade > 0) {
        $_SESSION['cart'][$produtoId] = $novaQuantidade;
    } else {
        unset($_SESSION['cart'][$produtoId]);
    }
}
```

## ✅ Validações

### Validação de Produto

```php
function validarProduto($produtoId) {
    return is_numeric($produtoId) && obterProduto((int)$produtoId) !== null;
}
```

### Validação de Quantidade

```php
function validarQuantidade($quantidade) {
    return is_numeric($quantidade) && (int)$quantidade > 0 && (int)$quantidade <= 10;
}
```

### Validação de Dados do Cliente

```php
function validarDadosCliente($dados) {
    $erros = [];
    
    if (empty(trim($dados['nome']))) {
        $erros[] = "Nome é obrigatório";
    }
    
    if (empty(trim($dados['email'])) || !filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
        $erros[] = "Email válido é obrigatório";
    }
    
    if (empty(trim($dados['telefone']))) {
        $erros[] = "Telefone é obrigatório";
    }
    
    if (empty(trim($dados['endereco']))) {
        $erros[] = "Endereço é obrigatório";
    }
    
    if (empty(trim($dados['cidade']))) {
        $erros[] = "Cidade é obrigatória";
    }
    
    if (empty(trim($dados['cep']))) {
        $erros[] = "CEP é obrigatório";
    }
    
    return $erros;
}
```

## 🚨 Tratamento de Erros

### Redirecionamentos de Segurança

```php
// Verificar se produto existe antes de exibir detalhes
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$produto = obterProduto((int)$_GET['id']);
if (!$produto) {
    header('Location: index.php');
    exit;
}
```

### Validação de Carrinho Vazio

```php
// Redirecionar se carrinho estiver vazio no checkout
if (empty($_SESSION['cart'])) {
    header('Location: carrinho.php');
    exit;
}
```

### Sanitização de Dados

```php
// Sempre usar htmlspecialchars para output
echo htmlspecialchars($produto['nome']);

// Sempre usar trim para input
$nome = trim($_POST['nome'] ?? '');
```

## 📝 Exemplos de Uso

### Exemplo 1: Listar Produtos com Preços Formatados

```php
require_once 'config.php';

foreach ($produtos as $produto) {
    echo "<div class='produto'>";
    echo "<h3>" . htmlspecialchars($produto['nome']) . "</h3>";
    echo "<p>Preço: " . formatarPreco($produto['preco']) . "</p>";
    echo "<p>" . htmlspecialchars($produto['descricao']) . "</p>";
    echo "</div>";
}
```

### Exemplo 2: Exibir Conteúdo do Carrinho

```php
session_start();
require_once 'config.php';

if (!empty($_SESSION['cart'])) {
    $total = 0;
    
    foreach ($_SESSION['cart'] as $produtoId => $quantidade) {
        $produto = obterProduto($produtoId);
        if ($produto) {
            $subtotal = $produto['preco'] * $quantidade;
            $total += $subtotal;
            
            echo "<tr>";
            echo "<td>" . htmlspecialchars($produto['nome']) . "</td>";
            echo "<td>" . formatarPreco($produto['preco']) . "</td>";
            echo "<td>" . $quantidade . "</td>";
            echo "<td>" . formatarPreco($subtotal) . "</td>";
            echo "</tr>";
        }
    }
    
    echo "<tr><td colspan='3'><strong>Total:</strong></td>";
    echo "<td><strong>" . formatarPreco($total) . "</strong></td></tr>";
} else {
    echo "<p>Carrinho vazio</p>";
}
```

### Exemplo 3: Processar Checkout

```php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finalizar_compra'])) {
    // Coletar dados do formulário
    $dadosCliente = [
        'nome' => trim($_POST['nome'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'telefone' => trim($_POST['telefone'] ?? ''),
        'endereco' => trim($_POST['endereco'] ?? ''),
        'cidade' => trim($_POST['cidade'] ?? ''),
        'cep' => trim($_POST['cep'] ?? '')
    ];
    
    // Validar dados
    $erros = validarDadosCliente($dadosCliente);
    
    if (empty($erros)) {
        // Processar pedido
        $numeroPedido = 'PED' . date('YmdHis') . rand(100, 999);
        
        // Aqui você salvaria no banco de dados em um sistema real
        
        // Limpar carrinho
        $_SESSION['cart'] = array();
        
        // Redirecionar para sucesso
        header('Location: sucesso.php?pedido=' . $numeroPedido);
        exit;
    }
}
```

## 🔐 Considerações de Segurança

### Sanitização de Input

```php
// Sempre validar e sanitizar dados de entrada
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
```

### Prevenção de XSS

```php
// Sempre escapar output HTML
echo htmlspecialchars($userInput, ENT_QUOTES, 'UTF-8');
```

### Validação de Sessão

```php
// Regenerar ID de sessão periodicamente
if (!isset($_SESSION['last_regeneration'])) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
} elseif (time() - $_SESSION['last_regeneration'] > 300) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}
```

## 📊 Métricas e Logs

### Log de Ações do Carrinho

```php
function logCarrinhoAction($action, $produtoId, $quantidade = null) {
    $logEntry = date('Y-m-d H:i:s') . " - $action - Produto: $produtoId";
    if ($quantidade) {
        $logEntry .= " - Quantidade: $quantidade";
    }
    $logEntry .= " - Session: " . session_id() . "\n";
    
    file_put_contents('logs/carrinho.log', $logEntry, FILE_APPEND | LOCK_EX);
}

// Uso:
logCarrinhoAction('ADD', $produtoId, $quantidade);
logCarrinhoAction('REMOVE', $produtoId);
```

### Estatísticas Básicas

```php
function getCarrinhoStats() {
    if (empty($_SESSION['cart'])) {
        return ['itens' => 0, 'total' => 0, 'produtos_unicos' => 0];
    }
    
    $stats = [
        'itens' => array_sum($_SESSION['cart']),
        'total' => calcularTotalCarrinho($_SESSION['cart']),
        'produtos_unicos' => count($_SESSION['cart'])
    ];
    
    return $stats;
}
```

---

**Última atualização**: Agosto 2025

