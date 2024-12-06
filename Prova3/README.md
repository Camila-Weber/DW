


## Banco de Dados

### Comandos CREATE

```SQL
-- Criação do banco de dados
CREATE DATABASE sistema_usuarios;

-- Seleção do banco de dados para uso
USE sistema_usuarios;

-- Criação da tabela de usuários
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  senha VARCHAR(255) NOT NULL,
  data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
  ativo BOOLEAN DEFAULT TRUE,
  data_nascimento DATE
);

-- Criação da tabela de personalização de página do usuário
CREATE TABLE pagina_usuarios (
  id_usuario INT,
  tema_escolhido ENUM('tema1', 'tema2', 'tema3', 'tema4') NOT NULL,
  foto_perfil VARCHAR(255),
  frase_personalizada VARCHAR(255),
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);
```