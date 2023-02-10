-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 10 fév. 2023 à 07:48
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dblogin8060`
--

-- --------------------------------------------------------

--
-- Structure de la table `shop_adresse`
--

DROP TABLE IF EXISTS `shop_adresse`;
CREATE TABLE IF NOT EXISTS `shop_adresse` (
  `idshop_adresse` int NOT NULL AUTO_INCREMENT,
  `adresse` varchar(45) DEFAULT NULL,
  `numero_rue` int DEFAULT NULL,
  `ville` varchar(45) DEFAULT NULL,
  `code postal` int DEFAULT NULL,
  `pays` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idshop_adresse`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `shop_category`
--

DROP TABLE IF EXISTS `shop_category`;
CREATE TABLE IF NOT EXISTS `shop_category` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `label` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `shop_category`
--

INSERT INTO `shop_category` (`Id`, `label`) VALUES
(1, 'souris'),
(2, 'casques'),
(3, 'claviers');

-- --------------------------------------------------------

--
-- Structure de la table `shop_commande`
--

DROP TABLE IF EXISTS `shop_commande`;
CREATE TABLE IF NOT EXISTS `shop_commande` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Nom_commande` varchar(255) NOT NULL,
  `lable_produit` varchar(255) NOT NULL,
  `prix` int NOT NULL,
  `label_adresse` int NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `shop_product`
--

DROP TABLE IF EXISTS `shop_product`;
CREATE TABLE IF NOT EXISTS `shop_product` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `label` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `description` int NOT NULL,
  `idcategory` int NOT NULL,
  `image` int NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `idcategory` (`idcategory`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `shop_roles`
--

DROP TABLE IF EXISTS `shop_roles`;
CREATE TABLE IF NOT EXISTS `shop_roles` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Label` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `shop_roles`
--

INSERT INTO `shop_roles` (`Id`, `Label`) VALUES
(1, '1-client'),
(2, '2-admin');

-- --------------------------------------------------------

--
-- Structure de la table `shop_type`
--

DROP TABLE IF EXISTS `shop_type`;
CREATE TABLE IF NOT EXISTS `shop_type` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `shop_users`
--

DROP TABLE IF EXISTS `shop_users`;
CREATE TABLE IF NOT EXISTS `shop_users` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `Idrole` int NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `email` (`email`),
  KEY `idRole` (`Idrole`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `shop_users`
--

INSERT INTO `shop_users` (`Id`, `email`, `password`, `lastname`, `firstname`, `Idrole`, `active`) VALUES
(3, 'root@gmail.com', '$2y$10$M/kCByBDnNHa975.oFm.ReA4U5UAIGfAgRDHRfn2vnLuKBl.r9PVi', 'delobelle', 'emilie', 2, 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `shop_product`
--
ALTER TABLE `shop_product`
  ADD CONSTRAINT `shop_product_ibfk_1` FOREIGN KEY (`idcategory`) REFERENCES `shop_category` (`Id`);

--
-- Contraintes pour la table `shop_users`
--
ALTER TABLE `shop_users`
  ADD CONSTRAINT `idRole` FOREIGN KEY (`Idrole`) REFERENCES `shop_roles` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
