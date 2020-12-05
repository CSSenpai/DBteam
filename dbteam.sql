-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 05. Dez 2020 um 17:26
-- Server-Version: 10.1.35-MariaDB
-- PHP-Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `dbteam`
--
CREATE DATABASE IF NOT EXISTS `dbteam` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `dbteam`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `coupon`
--

CREATE TABLE `coupon` (
  `cou_id` int(11) NOT NULL,
  `cou_name` varchar(255) NOT NULL,
  `cou_percent` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `coupon`
--

INSERT INTO `coupon` (`cou_id`, `cou_name`, `cou_percent`) VALUES
(1, 'FORTNITE', '0.10'),
(2, 'JONAS', '0.30'),
(3, 'NICOLAS', '0.69');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `info`
--

CREATE TABLE `info` (
  `inf_id` int(11) NOT NULL,
  `inf_name` varchar(255) DEFAULT NULL,
  `inf_surname` varchar(255) DEFAULT NULL,
  `inf_street` varchar(255) DEFAULT NULL,
  `inf_plz` int(10) DEFAULT NULL,
  `inf_location` varchar(255) DEFAULT NULL,
  `inf_country` varchar(255) DEFAULT NULL,
  `inf_usr_id` int(10) NOT NULL,
  `inf_konto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `info`
--

INSERT INTO `info` (`inf_id`, `inf_name`, `inf_surname`, `inf_street`, `inf_plz`, `inf_location`, `inf_country`, `inf_usr_id`, `inf_konto`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `material`
--

CREATE TABLE `material` (
  `mat_id` int(11) NOT NULL,
  `mat_name` varchar(255) NOT NULL,
  `mat_brand` varchar(255) NOT NULL,
  `mat_size` varchar(10) NOT NULL,
  `mat_concave` varchar(255) DEFAULT NULL,
  `mat_height` varchar(10) DEFAULT NULL,
  `mat_hardness` int(11) DEFAULT NULL,
  `mat_stock` int(11) NOT NULL,
  `mat_price` varchar(11) NOT NULL,
  `mat_rating` int(11) NOT NULL,
  `mat_categorie` varchar(255) NOT NULL,
  `mat_img_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `material`
--

INSERT INTO `material` (`mat_id`, `mat_name`, `mat_brand`, `mat_size`, `mat_concave`, `mat_height`, `mat_hardness`, `mat_stock`, `mat_price`, `mat_rating`, `mat_categorie`, `mat_img_id`) VALUES
(1, 'Reynolds Bakervca', 'BAKER', '8.5', 'Mellow', NULL, NULL, 12, '68', 4, 'deck', 1),
(2, 'Spanjy Bakervca', 'BAKER', '8.25', 'Mellow', NULL, NULL, 8, '65', 4, 'deck', 2),
(3, 'Rowan Ribbon Pink', 'BAKER', '8.25', 'Mellow', NULL, NULL, 15, '65', 4, 'deck', 3),
(4, 'Tyson Brand Name Green', 'BAKER', '8', 'Mellow', NULL, NULL, 23, '65', 4, 'deck', 4),
(5, 'Cash is Queen, Green', 'Polar', '8.75', 'Steep', NULL, NULL, 7, '67', 4, 'deck', 5),
(6, 'Skyscraper, Blue', 'Polar', '8.5', 'Mellow', NULL, NULL, 7, '67', 4, 'deck', 6),
(7, 'Trey Bandage', 'Madness', '8.25', 'Medium', NULL, NULL, 28, '75', 4, 'deck', 7),
(8, 'Clay Kreiner Inside out', 'Madness', '8.25', 'Medium', NULL, NULL, 26, '75', 4, 'deck', 8),
(9, 'Stage 11 Polished Standard', 'Independent', '8.25', NULL, 'Mid', NULL, 10, '79', 4, 'truck', 9),
(10, 'Stage 11 Forged Silver', 'Independent', '8.5', NULL, 'Mid', NULL, 12, '79', 4, 'truck', 10),
(11, 'Stage 11 Froged Hollow', 'Independent', '8.25', NULL, 'Mid', NULL, 8, '89', 4, 'truck', 11),
(12, 'Stage 11 Pro Milto', 'Independent', '8.5', NULL, 'Mid', NULL, 13, '89', 4, 'truck', 12),
(13, 'Stage 11 Hollow Lopez', 'Independent', '8.25', NULL, 'Low', NULL, 13, '89', 4, 'truck', 13),
(14, 'Nora Vasconcellos Animal', 'Krux', '8.25', NULL, 'Low', NULL, 12, '75', 4, 'truck', 14),
(15, 'Polished Silver Standard', 'Krux', '8.5', NULL, 'Mid', NULL, 9, '75', 4, 'truck', 15),
(16, 'Polished Silver Hollow', 'Krux', '8.25', NULL, 'Mid', NULL, 15, '75', 4, 'truck', 16),
(17, 'Formular Four Tablet', 'Spitfire', '54', NULL, NULL, 101, 36, '42', 4, 'wheel', 17),
(18, 'Formular Four Classics', 'Spitfire', '56', NULL, NULL, 99, 22, '42', 4, 'wheel', 18),
(19, 'Formular Four Classics', 'Spitfire', '54', NULL, NULL, 99, 18, '42', 4, 'wheel', 19),
(20, 'Formular Four Classics', 'Spitfire', '51', NULL, NULL, 99, 26, '42', 4, 'wheel', 20),
(21, 'Formular Four Classics', 'Spitfire', '52', NULL, NULL, 99, 28, '42', 4, 'wheel', 21),
(22, 'Formular Four Tablet', 'Spitfire', '51', NULL, NULL, 101, 19, '42', 4, 'wheel', 22),
(23, 'STF Desert Horns', 'Bones', '53', NULL, NULL, 99, 26, '12', 4, 'wheel', 23),
(24, 'STF Lockwood Expri', 'Bones ', '56', NULL, NULL, 103, 15, '45', 4, 'wheel', 24);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `notes`
--

CREATE TABLE `notes` (
  `note_id` int(11) NOT NULL,
  `note_usr_name` varchar(255) NOT NULL,
  `note_mat_id` int(11) NOT NULL,
  `note_message` text NOT NULL COMMENT '3',
  `note_create_date` date NOT NULL,
  `note_rating` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `usr_id` int(11) NOT NULL,
  `usr_name` varchar(255) NOT NULL,
  `usr_mail` varchar(255) NOT NULL,
  `usr_password` varchar(255) NOT NULL,
  `aut_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`usr_id`, `usr_name`, `usr_mail`, `usr_password`, `aut_id`) VALUES
(1, 'admin', 'admin@gmail.com', '202cb962ac59075b964b07152d234b70', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_has_mat`
--

CREATE TABLE `user_has_mat` (
  `user_usr_name` varchar(50) NOT NULL,
  `mats_mat_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`cou_id`);

--
-- Indizes für die Tabelle `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`inf_id`);

--
-- Indizes für die Tabelle `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`mat_id`);

--
-- Indizes für die Tabelle `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`note_id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`usr_id`),
  ADD UNIQUE KEY `usr_name` (`usr_name`),
  ADD UNIQUE KEY `usr_mail` (`usr_mail`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `coupon`
--
ALTER TABLE `coupon`
  MODIFY `cou_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `info`
--
ALTER TABLE `info`
  MODIFY `inf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `material`
--
ALTER TABLE `material`
  MODIFY `mat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT für Tabelle `notes`
--
ALTER TABLE `notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
