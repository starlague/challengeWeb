-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 16 jan. 2026 à 13:13
-- Version du serveur : 9.1.0
-- Version de PHP : 8.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `idUser` int NOT NULL,
  `idPost` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idUser` (`idUser`),
  KEY `idPost` (`idPost`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `content`, `idUser`, `idPost`, `created_at`) VALUES
(1, 'test', 7, 1, '2026-01-15 14:01:26'),
(3, 'cool', 2, 5, '2026-01-15 14:01:26'),
(4, 'zefzq', 2, 8, '2026-01-15 14:01:26'),
(5, 'zefz', 2, 7, '2026-01-15 14:02:00'),
(6, 'esfsf', 7, 4, '2026-01-15 19:02:36'),
(7, 'zqfq', 7, 4, '2026-01-15 19:06:04'),
(9, 'efzz', 7, 2, '2026-01-16 07:22:50'),
(13, 'adc', 7, 6, '2026-01-16 07:24:20'),
(14, 'ezf', 7, 6, '2026-01-16 07:24:29'),
(15, 'test', 7, 7, '2026-01-16 07:26:19'),
(16, 'cool', 7, 5, '2026-01-16 07:26:29'),
(18, 'test2', 3, 1, '2026-01-16 08:09:23'),
(19, 'uybh', 3, 8, '2026-01-16 08:26:58');

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `number` int NOT NULL,
  `idUser` int NOT NULL,
  `idPost` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idUser` (`idUser`),
  KEY `idPost` (`idPost`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idUser` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idUser` (`idUser`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `idUser`, `title`, `content`, `image`) VALUES
(1, 1, 'test', 'premier post', ''),
(2, 1, 'jsp', 'js vrmt p\r\n', ''),
(3, 1, 'idk', 'test image', '1768402524_XFriskTeen.webp'),
(4, 1, 'nouveau design', 'j\'essaie des trucs pour embellir la page', NULL),
(5, 1, 'bon...', 'faut que je fasse un truc pour les images', '1768468577_Capture d\'écran 2025-11-18 171614.png'),
(6, 1, 'normalement', 'y a écrit Test1 en auteur pls ', NULL),
(7, 1, 'stp', 'pls fonctionne ', NULL),
(9, 2, 'trgsefdfregt', 'rsgetrerfdg', '6969f7fc9b43e.png'),
(10, 7, 'si j\'ai écrit', 'ceci est un post', NULL),
(11, 7, 'post image', 'juste pour mettre une image', NULL),
(13, 7, 'rsgg', 'qereqeg', '696a184724326.png'),
(14, 7, 'COOL', 'j\'ai rien à dire', '696a2d0c4c245.png');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(100) NOT NULL,
  `bio` text NOT NULL,
  `avatar` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `bio`, `avatar`) VALUES
(1, 'Test', 'test@gmail.com', 'rejsglbhtrjkfnd', 'qfjenrgisbujfnkd,sl', 'frgqgestfg.png'),
(2, 'Test1', 'test1@gmail.com', '$2y$12$Kc978v4Tk3dyp/g2IKXJO.NhbPN.N7V8Dbtxh5aaR2DNTF/t3I2KW', 'frsteyhr', ''),
(3, 'Test2', 'test2@gmail.com', '$2y$12$iu9nYg3cLHazblvlX1RzCepobD0WFTFTUYvO9Dnkz3V1ZGOwDzBtO', 'zdezfregtzrs', ''),
(4, 'Test3', 'test3@gmail.com', '$2y$12$NtJBKwCuWnLtT5bpAeiMGeB1.9g58/ObV.ZPX9uZSeVYuuIvXiUrC', 'rsetyrehthrtg', ''),
(5, 'Test4', 'test4@gmail.com', '$2y$12$AXkOsQe4dksXmJzNeqbrVOmBVyU7lVHfHrSBkIghA753ZCGs4sKnu', 'regtgdgf', ''),
(6, 'Test5.1', 'test5.1@gmail.com', '$2y$12$EcOD1GKMboVhMyP.k3T7S.2irWMNcDi59PtEYtyej9NaLYaK4evo.', 'ça ne supprime plus tout', ''),
(7, 'starlague', 'nathalie.tuernal@gmail.com', '$2y$12$U.LmuLwEU650GitqMzN/4ef7hqNb4smqcOpGsPppfpPRNy2tJpjKa', 'c\'est compliqué', ''),
(8, 'Test6', 'test6@gmail.com', '$2y$12$IrHNuNtJ5nAqk7FPMW62RechYqxkDaSYlpz.S6Z1lchZEPvznmirK', 'fait que trim &#039;règle le problème', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
