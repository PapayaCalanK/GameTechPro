-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 25 mars 2025 à 14:02
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecommerce`
--

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `marque` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `description`, `prix`, `image`, `marque`) VALUES
(1, 'HP Omen', 'PC gaming performant avec RTX 4080', 2800.00, 'hp-omen.png', 'HP'),
(2, 'HP Pavilion Gaming', 'PC portable gaming léger et performant', 1200.00, 'hp-pavilion.png', 'HP'),
(3, 'HP Envy', 'Ordinateur portable professionnel puissant', 1500.00, 'hp-envy.png', 'HP'),
(4, 'Apple MacBook Pro M2', 'MacBook puissant avec puce M2 Pro', 2500.00, 'macbook-pro.png', 'Apple'),
(5, 'Apple Magic Keyboard', 'Clavier sans fil élégant et ergonomique', 120.00, 'magic-keyboard.png', 'Apple'),
(6, 'Acer Predator Helios', 'PC portable gaming avec RTX 3070', 1700.00, 'acer-predator.png', 'Acer'),
(7, 'Apple MacBook Pro', 'MacBook Pro M2 Max, 32Go RAM', 3200.00, 'macbook-pro-M2.png', 'Apple'),
(8, 'Acer Predator Helios', 'PC portable gaming avec RTX 4070', 1700.00, 'acer-predator4070.png', 'Acer'),
(9, 'Acer Nitro 5', 'PC gaming puissant et abordable', 1400.00, 'acer-nitro5.png', 'Acer'),
(10, 'Asus ROG Strix', 'PC gaming ultra performant avec RTX 4080', 2800.00, 'asus-rog-strix.png', 'Asus'),
(11, 'Asus TUF Gaming', 'PC gaming robuste et fiable', 1600.00, 'asus-tuf-gaming.png', 'Asus'),
(12, 'Asus ZenBook Pro', 'Ordinateur portable puissant et léger', 2000.00, 'asus-zenbook-pro.png', 'Asus'),
(13, 'Lenovo Legion 5', 'PC gaming équilibré avec RTX 3060', 1500.00, 'lenovo-legion5.png', 'Lenovo'),
(14, 'Lenovo IdeaPad Gaming 3', 'Ordinateur gaming performant et abordable', 1300.00, 'lenovo-ideapad-gaming3.png', 'Lenovo'),
(15, 'Lenovo ThinkPad X1', 'PC professionnel haute performance', 2200.00, 'lenovo-thinkpad-x1.png', 'Lenovo');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `created_at`) VALUES
(1, 'test@gmail.com', '$2y$10$0H1BKtjQ1Hrjgoy..h4r0.8uWnI2ualj./7.Q.qhY7CfFoW4MxlD6', '2025-02-15 15:51:04'),
(2, 'test1@gmail.com', '$2y$10$EGuTs6rUa9vdrfLJtpZngOEYf4bDkB54U5T.y1oSLwOH9ljPg0AwC', '2025-03-11 07:55:16'),
(3, 'anis@gmail.com', '$2y$10$HDaDmrgRkKABvBkxk6VXoe5yE4DcSuoJzI44XNwdDil2JZcje59ly', '2025-03-11 09:45:00'),
(4, 'tesmtest@gmail.com', '$2y$10$KynZYyuGB2yTZG3xSxtUXe/AV2dvoVu6g0R4LUChNhDBlWsyJKpyK', '2025-03-11 11:36:09');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
