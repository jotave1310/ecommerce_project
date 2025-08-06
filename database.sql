USE ecommerce_db;

-- Tabela de Categorias
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL UNIQUE,
    descricao TEXT
);

-- Tabela de Produtos
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10, 2) NOT NULL,
    estoque INT NOT NULL DEFAULT 0,
    categoria_id INT,
    imagem_url VARCHAR(255),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

-- Tabela de Usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    endereco VARCHAR(255),
    cidade VARCHAR(100),
    cep VARCHAR(10),
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Pedidos
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    endereco_entrega VARCHAR(255) NOT NULL,
    cidade_entrega VARCHAR(100) NOT NULL,
    cep_entrega VARCHAR(10) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Tabela de Itens do Pedido
CREATE TABLE itens_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT,
    produto_id INT,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);

-- Inserção de dados iniciais

-- Categorias
INSERT INTO categorias (nome, descricao) VALUES
("Eletrônicos", "Dispositivos eletrônicos e gadgets."),
("Informática", "Computadores, notebooks e acessórios."),
("Áudio", "Fones de ouvido, caixas de som e equipamentos de áudio.");

-- Produtos
INSERT INTO produtos (nome, descricao, preco, estoque, categoria_id, imagem_url) VALUES
("Smartphone Samsung Galaxy", "Smartphone com tela de 6.1 polegadas e câmera de 64MP", 899.99, 50, 1, ""),
("Notebook Dell Inspiron", "Notebook com processador Intel i5 e 8GB de RAM", 2499.99, 30, 2, ""),
("Fone de Ouvido Bluetooth", "Fone sem fio com cancelamento de ruído", 199.99, 100, 3, ""),
("Smart TV 55 polegadas", "TV 4K com sistema Android integrado", 1899.99, 20, 1, ""),
("Mouse Gamer RGB", "Mouse óptico com iluminação RGB e 6 botões", 89.99, 150, 2, ""),
("Teclado Mecânico", "Teclado mecânico com switches blue e backlight", 299.99, 80, 2, "");


