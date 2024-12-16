-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/12/2024 às 06:51
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_revenda`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `data_nascimento` date NOT NULL,
  `cep` varchar(8) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `email`, `telefone`, `cpf`, `data_nascimento`, `cep`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `data_registro`) VALUES
(5, 'Marcelle Sandy', 'marcellesandy3@gmail.com', '51998458940', '04007684022', '2003-08-25', '93022-66', 'Avenida Theodomiro Porto da Fonseca', '2173', 'apto 509', 'Cristo Rei', 'São Leopoldo', 'RS', '2024-12-04 23:22:08'),
(9, 'Anna Cerveira', 'marcellesandy3@gmail.com', '51998458940', '00000000000', '2024-12-18', '93220270', 'Rua Nossa Senhora da Conceição', '45', '45c', 'Centro', 'Sapucaia do Sul', 'RS', '2024-12-16 04:33:15'),
(10, 'Santiago Araujo ', 'santiago.a@gmail.com', '51909090903', '12345673922', '1992-08-24', '93042230', 'Rua Tapera', '23', 'ap 467c', 'Pinheiro', 'São Leopoldo', 'RS', '2024-12-16 04:35:29');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sexo` enum('Masculino','Feminino') NOT NULL,
  `fone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `token_redefinicao` varchar(255) DEFAULT NULL,
  `expiracao_token` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `sexo`, `fone`, `email`, `senha`, `data_registro`, `token_redefinicao`, `expiracao_token`) VALUES
(3, 'Marcelle Sandy', 'Feminino', '51998458940', 'marcellesandy3@gmail.com', '$2y$10$zDa6.e0SqY6uWkiJfT1uLuHNVjVWTRr7DhLm2qyv60scD7I2svUki', '2024-12-04 00:46:51', 'e090bf8b10aa968bb505f4e018fc5e894e52d6ed60aa06558c457c99298dc5f5', '2024-12-15 03:54:09'),
(5, 'Wesley Lima', 'Masculino', '51995645601', 'wlima@gmail.com', '$2y$10$F0gXzRiGC6R95yV3gH86w.cH3lbIREWtihjOVafaGOn8o1Rc7f6SK', '2024-12-16 03:35:54', NULL, NULL),
(6, 'Katia Neves', 'Feminino', '51998129708', 'katia@gmail.com', '$2y$10$KdQJkMI.n4onzcbgqcWXPuEZrd0HE7UTVn7fdnIb/K906cOukInra', '2024-12-16 03:37:30', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `veiculos`
--

CREATE TABLE `veiculos` (
  `id` int(11) NOT NULL,
  `placa` varchar(7) NOT NULL,
  `modelo` varchar(255) NOT NULL,
  `ano_modelo` int(4) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `cor` varchar(50) NOT NULL,
  `observacao` text DEFAULT NULL,
  `status` enum('disponivel','reservado','manutencao','vendido') NOT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `preco` decimal(10,2) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `veiculos`
--

INSERT INTO `veiculos` (`id`, `placa`, `modelo`, `ano_modelo`, `marca`, `cor`, `observacao`, `status`, `data_registro`, `preco`, `imagem`) VALUES
(7, 'iml8i38', 'Golf', 2010, 'Volkswagen', 'Prata', '', 'disponivel', '2024-12-10 00:37:31', 25000.00, 'uploads/67578d4bd1867_golf.jpg'),
(8, 'ghe7i23', 'HB20', 2022, 'Hyundai', 'Prata', '', 'disponivel', '2024-12-10 00:39:20', 60000.00, 'uploads/67578db81377e_hb20.jpg'),
(13, 'rew2u23', 'Uno', 222, 'Fiat', 'Branco', '', 'disponivel', '2024-12-13 22:25:41', 12000.00, 'uploads/675cb46538ced_uno.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

CREATE TABLE `vendas` (
  `id_venda` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_veiculo` int(11) DEFAULT NULL,
  `desconto` decimal(10,2) DEFAULT 0.00,
  `valor_final` decimal(10,2) NOT NULL,
  `data_venda` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vendas`
--

INSERT INTO `vendas` (`id_venda`, `id_cliente`, `id_veiculo`, `desconto`, `valor_final`, `data_venda`) VALUES
(4, 5, 7, 50.00, 12500.00, '2024-12-13 03:53:40'),
(5, 5, 7, 50.00, 12500.00, '2024-12-13 03:53:44'),
(6, 5, 7, 1.00, 24750.00, '2024-12-13 04:21:33'),
(7, 5, 7, 0.00, 25000.00, '2024-12-13 04:23:43'),
(11, 9, 8, 0.00, 60000.00, '2024-12-16 04:35:47');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `veiculos`
--
ALTER TABLE `veiculos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id_venda`),
  ADD KEY `id_veiculo` (`id_veiculo`),
  ADD KEY `vendas_ibfk_1` (`id_cliente`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `veiculos`
--
ALTER TABLE `veiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vendas_ibfk_2` FOREIGN KEY (`id_veiculo`) REFERENCES `veiculos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
