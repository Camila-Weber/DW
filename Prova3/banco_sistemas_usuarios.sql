-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           8.0.30 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para sistema_usuarios
CREATE DATABASE IF NOT EXISTS `sistema_usuarios` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sistema_usuarios`;

-- Copiando estrutura para tabela sistema_usuarios.pagina_usuarios
CREATE TABLE IF NOT EXISTS `pagina_usuarios` (
  `id_usuario` int DEFAULT NULL,
  `tema_escolhido` enum('tema1','tema2','tema3','tema4') COLLATE utf8mb4_general_ci NOT NULL,
  `foto_perfil` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `frase_personalizada` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `pagina_usuarios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela sistema_usuarios.pagina_usuarios: ~4 rows (aproximadamente)
INSERT INTO `pagina_usuarios` (`id_usuario`, `tema_escolhido`, `foto_perfil`, `frase_personalizada`) VALUES
	(2, 'tema2', 'fotos/67533a0fbeda5.png', 'A vida é como uma rosa: cada pétala uma lembrança, cada espinho uma realidade.'),
	(1, 'tema1', 'fotos/67533a6b25c0b.png', 'Teste. Testando. 123. Teste. Testando.'),
	(3, 'tema3', 'fotos/6753407720ca9.png', 'Você precisa parar de tentar controlar tudo. Afinal de contas, só um verdadeiro herói pode ver a diferença entre uma batalha que vale a pena lutar e uma que só deve ser evitada.'),
	(4, 'tema4', 'fotos/6753de19c1bfc.png', 'Viva menos do que parece e escute mais do que se fala.');

-- Copiando estrutura para tabela sistema_usuarios.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `ativo` tinyint(1) DEFAULT '1',
  `data_nascimento` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela sistema_usuarios.usuarios: ~4 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `data_criacao`, `ativo`, `data_nascimento`) VALUES
	(1, 'Usuário Teste', 'user@teste.com', '$2y$10$2fUWhfAzq.QFP1GiYNZX2OAMZ9vq3mMLyTDmD1mPnVyBcSukk9TA.', '2024-12-06 10:41:35', 1, '1999-12-07'),
	(2, 'Rosalinda Perreira', 'rosa.linda@perreira.com', '$2y$10$xZa91Ot0THjpps7hOzQP3.Uv2a7mZSjsZ4lity1/ArQ5/t1yECg9u', '2024-12-06 13:29:13', 1, '2002-12-25'),
	(3, 'José Alves Rocha', 'ze.alves@rocha.com', '$2y$10$y/a2BlgXZ0Vym8mIiQBK3ONeIHOX5ciX1VlqMxz7qgvF38KEVvgY2', '2024-12-06 14:14:51', 1, '2001-06-06'),
	(4, 'Pamela Almeida', 'pamela@almeida.com', '$2y$10$yX3BP0s6rwVwdYv23n2qj.Cqm.29tV1hJKJWVXGTCrEWEqaFPeeru', '2024-12-07 01:31:45', 1, '1994-04-20');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
