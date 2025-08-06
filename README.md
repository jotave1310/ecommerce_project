# E-commerce Project

Um projeto de loja online desenvolvido em PHP, HTML e CSS como demonstração de desenvolvimento web completo.

## 📋 Índice

- [Sobre o Projeto](#sobre-o-projeto)
- [Tecnologias Utilizadas](#tecnologias-utilizadas)
- [Funcionalidades](#funcionalidades)
- [Instalação e Configuração](#instalação-e-configuração)
- [Estrutura do Projeto](#estrutura-do-projeto)
- [Como Usar](#como-usar)
- [Contribuição](#contribuição)
- [Licença](#licença)

## 🎯 Sobre o Projeto

O **E-commerce Project** é uma aplicação web completa que simula uma loja online, desenvolvida para demonstrar conhecimentos em desenvolvimento web usando tecnologias server-side e client-side. O projeto inclui todas as funcionalidades essenciais de um e-commerce moderno, desde a exibição de produtos até o processo de checkout.

### Objetivos do Projeto

- Demonstrar proficiência em PHP para desenvolvimento backend
- Implementar design responsivo com HTML5 e CSS3
- Criar uma experiência de usuário intuitiva e moderna
- Aplicar boas práticas de desenvolvimento web
- Implementar controle de versão com Git/GitHub
- Documentar adequadamente o código e funcionalidades

## 🚀 Tecnologias Utilizadas

### Backend
- **PHP 8.1+**: Linguagem principal para lógica server-side
- **Sessões PHP**: Gerenciamento de estado do carrinho de compras
- **Apache**: Servidor web para hospedagem

### Frontend
- **HTML5**: Estruturação semântica das páginas
- **CSS3**: Estilização e design responsivo
- **JavaScript**: Interações básicas do lado cliente

### Ferramentas de Desenvolvimento
- **Git**: Controle de versão
- **GitHub**: Repositório remoto e colaboração
- **Apache/PHP**: Ambiente de desenvolvimento local

## ✨ Funcionalidades

### 🛍️ Catálogo de Produtos
- Exibição de produtos em grid responsivo
- Detalhes completos de cada produto
- Categorização por tipo de produto
- Preços formatados em moeda brasileira

### 🛒 Carrinho de Compras
- Adição/remoção de produtos
- Atualização de quantidades
- Cálculo automático de totais
- Persistência durante a sessão

### 💳 Sistema de Checkout
- Formulário de dados do cliente
- Validação de campos obrigatórios
- Resumo do pedido
- Confirmação de compra

### 📱 Design Responsivo
- Layout adaptável para desktop e mobile
- Navegação otimizada para touch
- Imagens e textos escaláveis

### 🔧 Funcionalidades Técnicas
- Estrutura MVC simplificada
- Separação de configurações
- Código limpo e documentado
- Tratamento de erros

## 🔧 Instalação e Configuração

### Pré-requisitos

- PHP 8.1 ou superior
- Apache ou Nginx
- Git

### Passo a Passo

1. **Clone o repositório**
   ```bash
   git clone https://github.com/jotave1310/ecommerce_project.git
   cd ecommerce_project
   ```

2. **Configure o servidor web**
   
   Para Apache, certifique-se de que o módulo PHP está habilitado:
   ```bash
   sudo a2enmod php8.1
   sudo systemctl restart apache2
   ```

3. **Configure as permissões**
   ```bash
   sudo chown -R www-data:www-data /var/www/html/ecommerce_project
   sudo chmod -R 755 /var/www/html/ecommerce_project
   ```

4. **Acesse a aplicação**
   
   Abra o navegador e acesse: `http://localhost/ecommerce_project/`

### Configuração de Desenvolvimento

Para desenvolvimento local, você pode usar o servidor embutido do PHP:

```bash
cd /caminho/para/ecommerce_project
php -S localhost:8000
```

Então acesse: `http://localhost:8000`

## 📁 Estrutura do Projeto

```
ecommerce_project/
├── index.php              # Página inicial
├── config.php             # Configurações e dados dos produtos
├── style.css              # Estilos CSS principais
├── produto.php             # Página de detalhes do produto
├── produtos.php            # Listagem de todos os produtos
├── carrinho.php            # Página do carrinho de compras
├── checkout.php            # Página de finalização da compra
├── sucesso.php             # Página de confirmação de pedido
├── sobre.php               # Página institucional
├── contato.php             # Página de contato
├── README.md               # Documentação principal
└── docs/                   # Documentação adicional
    ├── INSTALL.md          # Guia de instalação detalhado
    ├── API.md              # Documentação das funções
    └── CHANGELOG.md        # Histórico de versões
```

### Descrição dos Arquivos Principais

#### `config.php`
Arquivo central de configuração contendo:
- Array de produtos com informações completas
- Funções auxiliares para manipulação de dados
- Configurações globais da aplicação

#### `style.css`
Folha de estilos principal com:
- Reset CSS básico
- Estilos para layout responsivo
- Componentes reutilizáveis
- Media queries para dispositivos móveis

#### Páginas PHP
Cada página PHP segue a estrutura:
- Inicialização de sessão
- Inclusão do arquivo de configuração
- Lógica de processamento
- Template HTML com dados dinâmicos

## 🎮 Como Usar

### Para Usuários Finais

1. **Navegação**: Use o menu superior para navegar entre as seções
2. **Produtos**: Clique em "Ver Detalhes" para informações completas
3. **Carrinho**: Adicione produtos e gerencie quantidades
4. **Checkout**: Preencha os dados e finalize a compra

### Para Desenvolvedores

#### Adicionando Novos Produtos

Edite o arquivo `config.php` e adicione um novo item ao array `$produtos`:

```php
$produtos[7] = [
    'id' => 7,
    'nome' => 'Novo Produto',
    'preco' => 299.99,
    'descricao' => 'Descrição do produto',
    'categoria' => 'Categoria'
];
```

#### Modificando Estilos

Os estilos estão organizados em seções no arquivo `style.css`:
- Reset e configurações globais
- Header e navegação
- Conteúdo principal
- Produtos e carrinho
- Footer
- Media queries responsivas

#### Personalizando Funcionalidades

As principais funções estão em `config.php`:
- `obterProduto($id)`: Busca produto por ID
- `calcularTotalCarrinho($carrinho)`: Calcula total do carrinho
- `formatarPreco($preco)`: Formata valores monetários

## 🤝 Contribuição

Contribuições são bem-vindas! Para contribuir:

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

### Diretrizes de Contribuição

- Mantenha o código limpo e bem documentado
- Siga as convenções de nomenclatura existentes
- Teste suas alterações antes de submeter
- Atualize a documentação quando necessário

## 📄 Licença

Este projeto é desenvolvido para fins educacionais e de demonstração. Sinta-se livre para usar como base para seus próprios projetos.

## 📞 Contato

- **Desenvolvedor**: Manus AI
- **Repositório**: [https://github.com/jotave1310/ecommerce_project](https://github.com/jotave1310/ecommerce_project)
- **Email**: contato@ecommerceproject.com

---

**Desenvolvido com ❤️ para demonstrar conhecimentos em desenvolvimento web**

