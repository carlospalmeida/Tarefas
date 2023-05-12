-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12-Maio-2023 às 19:11
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dbtarefas`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tab_tarefas`
--

CREATE TABLE `tab_tarefas` (
  `id` int(11) NOT NULL,
  `nomeTarefa` varchar(50) NOT NULL,
  `descTarefa` varchar(200) NOT NULL,
  `prazoTarefa` datetime NOT NULL,
  `priorTarefa` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tab_tarefas`
--

INSERT INTO `tab_tarefas` (`id`, `nomeTarefa`, `descTarefa`, `prazoTarefa`, `priorTarefa`, `idUsuario`) VALUES
(54, 'ok', 'hjhgj', '2023-05-10 21:27:20', 3, 1),
(61, 'kçkç', 'kç', '2023-05-10 22:19:41', 1, 1),
(62, 'fdf', 'tarefda', '2023-05-12 18:40:43', 1, 1),
(63, 'Tarefa da ana', 'ana', '2023-05-12 18:44:21', 1, 2),
(66, 'teste', 'etet', '2023-05-12 19:07:03', 1, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tab_usuarios`
--

CREATE TABLE `tab_usuarios` (
  `idUser` int(11) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `senha` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tab_usuarios`
--

INSERT INTO `tab_usuarios` (`idUser`, `usuario`, `senha`) VALUES
(1, 'adm', '123'),
(2, 'Ana', '123');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tab_tarefas`
--
ALTER TABLE `tab_tarefas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario` (`idUsuario`);

--
-- Índices para tabela `tab_usuarios`
--
ALTER TABLE `tab_usuarios`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tab_tarefas`
--
ALTER TABLE `tab_tarefas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de tabela `tab_usuarios`
--
ALTER TABLE `tab_usuarios`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tab_tarefas`
--
ALTER TABLE `tab_tarefas`
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `tab_usuarios` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
