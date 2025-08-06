<?php
// Configurações do projeto

// Produtos de exemplo (em um projeto real, isso viria de um banco de dados)
$produtos = [
    1 => [
        'id' => 1,
        'nome' => 'Smartphone Samsung Galaxy',
        'preco' => 899.99,
        'descricao' => 'Smartphone com tela de 6.1 polegadas e câmera de 64MP',
        'categoria' => 'Eletrônicos'
    ],
    2 => [
        'id' => 2,
        'nome' => 'Notebook Dell Inspiron',
        'preco' => 2499.99,
        'descricao' => 'Notebook com processador Intel i5 e 8GB de RAM',
        'categoria' => 'Informática'
    ],
    3 => [
        'id' => 3,
        'nome' => 'Fone de Ouvido Bluetooth',
        'preco' => 199.99,
        'descricao' => 'Fone sem fio com cancelamento de ruído',
        'categoria' => 'Áudio'
    ],
    4 => [
        'id' => 4,
        'nome' => 'Smart TV 55 polegadas',
        'preco' => 1899.99,
        'descricao' => 'TV 4K com sistema Android integrado',
        'categoria' => 'Eletrônicos'
    ],
    5 => [
        'id' => 5,
        'nome' => 'Mouse Gamer RGB',
        'preco' => 89.99,
        'descricao' => 'Mouse óptico com iluminação RGB e 6 botões',
        'categoria' => 'Informática'
    ],
    6 => [
        'id' => 6,
        'nome' => 'Teclado Mecânico',
        'preco' => 299.99,
        'descricao' => 'Teclado mecânico com switches blue e backlight',
        'categoria' => 'Informática'
    ]
];

// Função para obter produto por ID
function obterProduto($id) {
    global $produtos;
    return isset($produtos[$id]) ? $produtos[$id] : null;
}

// Função para calcular total do carrinho
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

// Função para formatar preço
function formatarPreco($preco) {
    return 'R$ ' . number_format($preco, 2, ',', '.');
}
?>

