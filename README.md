# FoxMotors Site Revenda de Veículos

Este é o **FoxMotors**, um site desenvolvido para revenda de veiculos, publicação dos veiculos disponiveis e captação, ideal para projetos que promovem a disseminação de informações de maneira dinâmica e acessível.

## 💖 Proposta do Projeto

O objetivo deste projeto é oferecer uma plataforma simples e eficiente para gerenciar notícias. Ele inclui funcionalidades como:
- Cadastro de notícias com título, conteúdo, autor e imagem.
- Exibição dinâmica das notícias publicadas.
- Estrutura modular para facilitar manutenção e futuras expansões.

O projeto foi desenvolvido em **novembro de 2024** por **Marcelle Neves Sandy**.

## 🔧 Tecnologias Utilizadas

O sistema foi construído utilizando ferramentas modernas para garantir desempenho e escalabilidade:
- **PHP**: Responsável pelo back-end e manipulação de dados.
- **MySQL**: Banco de dados para armazenar as informações.
- **HTML/CSS/JavaScript**: Tecnologias do front-end para a interface do usuário.

📂 site_noticias
│   ├── 📂 css           # Arquivos de estilo (CSS)
│   ├── 📂 imagens       # Imagens do site
│   ├── 📂 script        # Scripts JavaScript
│   ├── 📂 uploads       # Arquivos enviados pelos usuários
│
├── 📂 src
│   ├── 📂 classes     # Classes PHP que implementam a lógica do sistema
│   ├── 📂 config      # Configurações gerais do sistema

├── 📝 Arquivos PHP principais:
│   ├── deletar.php
│   ├── editar.php
│   ├── editarNoticia.php
│   ├── gerenciarNoticias.php
│   ├── gerenciarUsuarios.php
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── portal.php
│   ├── registrar.php
│   └── salvarNoticia.php

## 🚀 Como Funciona

1. **Cadastro de Notícias**:
   - As notícias são adicionadas por meio de um formulário, onde é possível informar título, conteúdo, autor e imagem.
   - As imagens são armazenadas no diretório `src/assets/uploads`.

2. **Exibição de Notícias**:
   - As notícias cadastradas são exibidas na página principal, com um layout limpo e organizado.

3. **Banco de Dados**:
   - A tabela principal é `noticias`, composta pelas seguintes colunas:
     - `id`: Identificador único da notícia.
     - `usuario_id`: Identificador do autor.
     - `titulo`: Título da notícia.
     - `conteudo`: Conteúdo da notícia.
     - `data_publicacao`: Data e hora da publicação.
     - `imagem`: Caminho para a imagem associada à notícia.

## 💡 Possíveis Melhorias

- Implementar sistema de autenticação para gerenciar permissões.
- Adicionar categorias ou tags para organizar melhor as notícias.
- Desenvolver uma API para integração com outras plataformas.
- Melhorar o sistema de upload de imagens, incluindo redimensionamento automático.

## 👩🏻 Autora

Desenvolvido por **Marcelle Neves Sandy** em novembro de 2024.

## ❤️ Contato

Para dúvidas ou sugestões, entre em contato:
- **E-mail**: marcellesandy3@gmail.com
