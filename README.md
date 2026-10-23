# BalanceQ - Balanceamento de Equações Químicas

![BalanceQ](https://img.shields.io/badge/Status-100%25%20Funcional-success?style=for-the-badge)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-PDO-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

Aplicação web moderna, intuitiva e educativa desenvolvida para o balanceamento estequiométrico de equações químicas com rigor científico, preservação de fórmulas moleculares e demonstração pedagógica baseada na **Lei de Lavoisier** e na **Regra M.A.C.H.O.** (Metais, Ametais, Carbono, Hidrogênio, Oxigênio).

---

## 🧪 Funcionalidades e Regras de Negócio (CORE)

- [x] **Identidade Visual Química**: Interface moderna utilizando paleta de cores científicas (azul, verde esmeralda e branco), com elementos visuais de laboratório, átomos e moléculas.
- [x] **Página Inicial Completa**: Apresentação da plataforma e botão direto de chamada para ação (*Call To Action*).
- [x] **Entrada Inteligente de Equações**: Suporte a digitação natural (`H2 + O2 -> H2O`), subscritos Unicode (`H₂ + O₂ → H₂O`), múltiplos reagentes/produtos, grupos complexos entre parênteses (`Al2(SO4)3`, `Ca(OH)2`) e teclado rápido com botões de índices químicos (`₀` a `₉`, `→`, `+`, `(`, `)`).
- [x] **Modo Automático**: Apresenta instantaneamente a equação balanceada com coeficientes estequiométricos destacados em verde e tabela de conservação atômica.
- [x] **Modo Manual (Passo a Passo Didático)**:
  1. Identificação de Reagentes e Produtos.
  2. Inventário inicial de átomos (antes do balanceamento) identificando elementos desequilibrados.
  3. Aplicação da **Regra M.A.C.H.O.** (Metais → Ametais → Carbono → Hidrogênio → Oxigênio).
  4. Comprovação da Lei de Conservação da Massa de Antoine Lavoisier (*"Na natureza nada se cria, nada se perde, tudo se transforma"*).
- [x] **Login Obrigatório com Gmail (Regra de Negócio CORE)**:
  - Autenticação e persistência via sessões nativas do PHP (`$_SESSION['balanceq_user']`).
  - Validação estrita de domínio `@gmail.com`.
  - Perfis rápidos de teste (Aluno Demo e Professor Demo) para avaliação imediata.
- [x] **Histórico e Equações Salvas**:
  - Registro automático de cada balanceamento realizado pelo usuário.
  - Seção de **Equações Salvas / Favoritas** com alternância de estrela (`⭐`).
  - Opções para recarregar no balanceador, copiar resultado e limpar histórico recente.
- [x] **Área de Exercícios Interativos**:
  - Níveis **Fácil**, **Médio** e **Difícil** (incluindo oxirreduções e reações orgânicas).
  - Campos de inserção de coeficientes diretamente na fórmula química.
  - Verificação imediata com dicas estequiométricas pedagógicas e link para resolução passo a passo.
- [x] **Seção de Estudos Teóricos**:
  - Explicações claras e acessíveis sobre Reações Químicas, Reagentes vs Produtos, Coeficientes vs Índices (alerta visual sobre por que nunca alterar o índice) e a Lei de Lavoisier.
- [x] **Mensagens de Erro Científicas**: Diagnóstico educativo para equações sem seta, fórmulas incorretas ou elementos que violam a conservação de massas.
- [x] **Utilitários**: Botões de limpar campos, copiar para área de transferência com notificação *Toast* e exemplos de reações prontas com 1 clique.

---

## 🛠️ Stack Tecnológico

- **Backend**: PHP 8+ estruturado em sessões nativas (`auth.php`, `balancer.php`, `api.php`).
- **Banco de Dados**: MySQL via **PDO Seguro** com *Prepared Statements* (prevenção contra SQL Injection). Conta com auto-fallback inteligente para SQLite local (`balanceq.sqlite`), permitindo testar a aplicação imediatamente em qualquer ambiente sem necessidade de configurar previamente o MySQL.
- **Frontend**: HTML5 semântico, JavaScript moderno (Fetch API assíncrono) e Tailwind CSS 3.x (Mobile First e altamente responsivo).

---

## 📁 Estrutura de Arquivos

```text
balanceq/
├── bd.php                  # Conexão PDO segura (MySQL e fallback SQLite)
├── database.sql            # Script SQL oficial de criação do banco e tabelas MySQL
├── auth.php                # Gerenciador de autenticação com Gmail e sessões nativas
├── balancer.php            # Algoritmo de Álgebra Linear (Gauss-Jordan) e Regra MACHO
├── api.php                 # Endpoint assíncrono para balancear, salvar e consultar
├── index.php               # Aplicação principal (Hero, Teclado Químico e Resultados)
├── login.php               # Tela de autenticação exclusiva com conta Gmail
├── historico.php           # Gestão do Histórico e Equações Favoritas
├── exercicios.php          # Quiz interativo nos níveis Fácil, Médio e Difícil
├── estudos.php             # Material didático sobre Lavoisier e estequiometria
├── components/
│   ├── header.php          # Barra de navegação e status do usuário logado
│   └── footer.php          # Rodapé com citações científicas e badges
├── assets/
│   ├── css/
│   │   └── custom.css      # Animações de moléculas e brilho químico
│   └── js/
│       └── app.js          # Lógica interativa, clipboard e notificações toast
├── requisitos.md           # Especificação original de requisitos do projeto
└── README.md               # Documentação técnica do projeto
```

---

## 🚀 Como Executar o Projeto

### Opção 1: Servidor Embutido do PHP (Mais Rápido)
Abra o terminal na pasta do projeto e execute:
```bash
php -S localhost:8000
```
Em seguida, abra seu navegador em: `http://localhost:8000`

*(O sistema inicializa automaticamente o banco de dados e cria as tabelas de usuários e histórico).*

### Opção 2: XAMPP / WampServer / Servidor Apache + MySQL
1. Copie a pasta `balanceq` para o diretório web (ex: `c:\xampp\htdocs\balanceq`).
2. Abra o phpMyAdmin ou terminal MySQL e importe o arquivo `database.sql`.
3. Inicie os serviços do Apache e MySQL no painel de controle do XAMPP.
4. Acesse no navegador: `http://localhost/balanceq`

---

## 🔐 Segurança e Boas Práticas Implementadas

- **Proteção contra SQL Injection**: Todas as consultas e gravações no banco utilizam PDO com *Prepared Statements* e parâmetros vinculados (`:uid`, `:orig`, etc.).
- **Escapamento XSS**: Uso de `htmlspecialchars()` em todas as saídas geradas por usuários nas views PHP.
- **Validação de Entrada**: Algoritmo rigoroso de validação molecular que analisa o balanceamento de parênteses, maiúsculas/minúsculas e conservação de elementos.
- **Sessões Nativas**: Controle de sessão nativo com destruição limpa e controle de acesso para salvar equações e histórico.

---

Desenvolvido para fins educacionais e estudo de Química e Desenvolvimento Web.
