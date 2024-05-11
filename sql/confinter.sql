-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 10/05/2024 às 19:46
-- Versão do servidor: 8.2.0
-- Versão do PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `confinter`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `aprovado`
--

DROP TABLE IF EXISTS `aprovado`;
CREATE TABLE IF NOT EXISTS `aprovado` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_cliente` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `mensagem` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `nome` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `status_mod` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `aprovado` tinyint(1) DEFAULT '1',
  `reprovado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `aprovado`
--

INSERT INTO `aprovado` (`id`, `nome_cliente`, `mensagem`, `nome`, `status_mod`, `aprovado`, `reprovado`) VALUES
(12, 'dasdsada', 'asdasdasd', 'Anônimo', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `telefone` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nome`, `data_nascimento`, `email`, `telefone`) VALUES
(35, 'Fernando Aparecido Lopes da Silva', '1970-01-01', 'fnando0506@gmail.com', '(55) 11992-0434'),
(36, 'Fernando Aparecido Lopes da Silva', '1970-01-01', 'fnando0506@gmail.com', '(55) 11992-0434'),
(26, 'Fernando Aparecido Lopes da Silva', '0000-00-00', 'fnando0506@gmail.com', '(55) 11992-0434'),
(30, 'Fernando Aparecido Lopes da Silva', '1970-01-01', 'fnando0506@gmail.com', '(55) 11992-0434'),
(31, 'Fernando Aparecido Lopes da Silva', '1970-01-01', 'fnando0506@gmail.com', '(11) 99204-3469'),
(38, 'Fernando Aparecido Lopes da Silva', '1970-01-01', 'fnando0506@gmail.com', '(11) 99204-3469'),
(39, 'João da Silva', '1955-08-26', 'teste1@gmail.com', '1147459055'),
(40, 'João da Silva', '1955-08-26', 'teste1@gmail.com', '1147459055'),
(41, 'João da Silva', '1954-06-07', 'teste@gmail.com', '11992043469'),
(42, 'João da Silva', '1970-01-01', 'js@gmail.com', '(11) 94567-8909'),
(43, 'João da Silva', '1970-01-01', 'js@gmail.com', '(11) 94567-8909');

-- --------------------------------------------------------

--
-- Estrutura para tabela `contador_visitas`
--

DROP TABLE IF EXISTS `contador_visitas`;
CREATE TABLE IF NOT EXISTS `contador_visitas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data_visita` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `tempo` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `contador_visitas`
--

INSERT INTO `contador_visitas` (`id`, `data_visita`, `tempo`) VALUES
(1, '2024-04-20 19:39:05', NULL),
(2, '2024-04-20 19:42:00', NULL),
(3, '2024-04-20 19:42:01', NULL),
(4, '2024-04-20 19:42:07', NULL),
(5, '2024-04-20 19:42:09', NULL),
(6, '2024-04-20 19:42:23', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `depoimentos`
--

DROP TABLE IF EXISTS `depoimentos`;
CREATE TABLE IF NOT EXISTS `depoimentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_cliente` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `mensagem` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `status_mod` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `nome` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `aprovado` tinyint(1) DEFAULT '0',
  `reprovado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `depoimentos`
--

INSERT INTO `depoimentos` (`id`, `nome_cliente`, `mensagem`, `status_mod`, `nome`, `aprovado`, `reprovado`) VALUES
(14, 'Fernando', 'Muito bom, recomendo!!!', 'aprovado', 'Anônimo', 1, 0),
(13, 'dasdsada', 'asdasdasd', 'reprovado', 'Anônimo', 0, 1),
(19, 'Teste', 'Ainda verificando', 'reprovado', 'Anônimo', 0, 1),
(20, 'Teste', 'Ainda verificando', 'aprovado', 'Anônimo', 1, 0),
(17, 'Fernando', 'Aprovo em todos os sentidos', 'reprovado', 'Anônimo', 0, 1),
(18, 'Fernando', 'Aprovo em todos os sentidos', 'aprovado', 'Anônimo', 1, 0),
(21, 'Fernando Lopes', 'Muito Bom !!!', 'aprovado', NULL, 1, 0),
(22, 'Fernando Lopes', 'Muito Bom !!!', 'aprovado', NULL, 1, 0),
(23, 'Anthony', 'Muito Bom', 'aprovado', NULL, 1, 0),
(24, 'João da Silva', 'Muito Bom', 'aprovado', NULL, 1, 0),
(25, 'João da Silva', 'Muito Bom', 'aprovado', NULL, 1, 0),
(26, 'Teste', 'Recomendo!!!', 'aprovado', NULL, 1, 0),
(30, 'Anônimo', 'cdfdfsddfsfsdfdf', 'pendente', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `empresa`
--

DROP TABLE IF EXISTS `empresa`;
CREATE TABLE IF NOT EXISTS `empresa` (
  `id_empresa` int NOT NULL AUTO_INCREMENT,
  `nome_empresa` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `tel` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `celular` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `email` varchar(65) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `descricao` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  PRIMARY KEY (`id_empresa`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `nome_empresa`, `tel`, `celular`, `email`, `descricao`) VALUES
(1, 'CONFINTER', '----', '----', '----', 'CONFINTER :)');

-- --------------------------------------------------------

--
-- Estrutura para tabela `enderecos`
--

DROP TABLE IF EXISTS `enderecos`;
CREATE TABLE IF NOT EXISTS `enderecos` (
  `id_endereco` int NOT NULL AUTO_INCREMENT,
  `id_empresa` int NOT NULL,
  `logradouro` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `numero` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `bairro` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `cidade` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `estado` varchar(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `cep` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_endereco`),
  KEY `id_empresa` (`id_empresa`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `enderecos`
--

INSERT INTO `enderecos` (`id_endereco`, `id_empresa`, `logradouro`, `numero`, `bairro`, `cidade`, `estado`, `cep`) VALUES
(1, 1, 'Marina La Regina', '203', 'Centro', 'Poá', 'SP', '08550-210');

-- --------------------------------------------------------

--
-- Estrutura para tabela `imagens_carrossel`
--

DROP TABLE IF EXISTS `imagens_carrossel`;
CREATE TABLE IF NOT EXISTS `imagens_carrossel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_arquivo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `imagens_carrossel`
--

INSERT INTO `imagens_carrossel` (`id`, `nome_arquivo`) VALUES
(9, 'slider2.jpg'),
(10, 'slider3.jpg'),
(11, 'slider4.jpg'),
(8, 'slider1.jpg'),
(12, 'slider5.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `requisicoes`
--

DROP TABLE IF EXISTS `requisicoes`;
CREATE TABLE IF NOT EXISTS `requisicoes` (
  `id_requisicao` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `horario_contato` time NOT NULL,
  `cotacao` enum('Sim','Não') NOT NULL,
  `contratacao` enum('Sim','Não') NOT NULL,
  `tipo` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `categoria` enum('Aposentado','Pensionista','Servidor Público') NOT NULL,
  `outros_info` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `data_requisicao` date NOT NULL,
  PRIMARY KEY (`id_requisicao`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `requisicoes`
--

INSERT INTO `requisicoes` (`id_requisicao`, `id_cliente`, `horario_contato`, `cotacao`, `contratacao`, `tipo`, `categoria`, `outros_info`, `data_requisicao`) VALUES
(17, 25, '07:26:00', 'Sim', 'Sim', 'Teste', '', 'Teste', '2024-03-27'),
(18, 26, '08:00:00', 'Sim', 'Sim', 'teste', '', 'Teste', '2024-03-27'),
(19, 29, '09:00:00', 'Sim', 'Sim', 'teste', '', '', '0000-00-00'),
(20, 30, '09:00:00', 'Sim', 'Sim', 'asaS', 'Aposentado', 'asdsdsads', '0000-00-00'),
(21, 31, '08:53:00', 'Sim', 'Sim', 'ssaasdasdasd', '', 'sdasdasdas', '0000-00-00'),
(22, 32, '06:55:00', 'Sim', 'Sim', 'tretree', '', 'ytyyttyrryt', '0000-00-00'),
(23, 33, '04:56:00', 'Sim', 'Sim', 'tfrytrt', '', '', '0000-00-00'),
(24, 34, '09:00:00', 'Sim', 'Sim', 'eqwewq', '', 'wewewqeewqe', '0000-00-00'),
(25, 35, '05:04:00', 'Sim', 'Sim', 'asdsadsad', '', 'sdsadsda', '0000-00-00'),
(26, 36, '09:00:00', 'Sim', 'Sim', 'sdfsdfdfsdf', 'Pensionista', '', '0000-00-00'),
(27, 37, '04:06:00', 'Sim', 'Sim', 'ASdasdsa', '', 'asassas', '0000-00-00'),
(28, 38, '23:19:00', 'Sim', 'Sim', 'teste', 'Servidor Público', '', '0000-00-00'),
(29, 39, '00:56:00', 'Sim', 'Sim', 'Teste 123', 'Aposentado', '', '0000-00-00'),
(30, 40, '01:56:00', 'Sim', 'Sim', 'Teste 123', 'Pensionista', '', '0000-00-00'),
(31, 41, '06:22:00', 'Sim', 'Sim', 'Teste', 'Pensionista', '', '0000-00-00'),
(32, 43, '11:45:00', 'Sim', 'Sim', 'Teste teste', 'Pensionista', '', '2024-05-04');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tempo_visita`
--

DROP TABLE IF EXISTS `tempo_visita`;
CREATE TABLE IF NOT EXISTS `tempo_visita` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_visita` int NOT NULL,
  `tempo` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_visita` (`id_visita`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `usuario` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `senha` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `perfil` enum('usuario','admin') NOT NULL DEFAULT 'usuario',
  `img_perfil` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `usuario`, `senha`, `perfil`, `img_perfil`) VALUES
(1, 'Administrador do sistema', 'admin@example.com', 'admin', 'admin', 'admin', NULL),
(2, 'Fernando Lopes', 'fnando0506@gmail.com', 'fnando', '0m3g4r3d', 'usuario', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
