-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 26 Février 2017 à 01:16
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `db_examen`
--

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `buy_price` float NOT NULL,
  `sell_price` float NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `product_transaction`
--

CREATE TABLE `product_transaction` (
  `id` int(11) NOT NULL,
  `date_transaction` date NOT NULL,
  `type_transaction_id` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `sell_price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` double NOT NULL,
  `code` varchar(50) NOT NULL,
  `notes` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `product_transaction_type`
--

CREATE TABLE `product_transaction_type` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`);

--
-- Index pour la table `product_transaction`
--
ALTER TABLE `product_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `product_transaction_type`
--
ALTER TABLE `product_transaction_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT pour la table `product_transaction`
--
ALTER TABLE `product_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT pour la table `product_transaction_type`
--
ALTER TABLE `product_transaction_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
