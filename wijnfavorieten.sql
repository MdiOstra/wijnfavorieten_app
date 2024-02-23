-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 22 feb 2024 om 15:44
-- Serverversie: 10.4.28-MariaDB
-- PHP-versie: 8.0.28

CREATE DATABASE IF NOT EXISTS `wijnfavorieten`;

USE `wijnfavorieten`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wijnfavorieten`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE `gebruikers` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `wachtwoord` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `username`, `wachtwoord`) VALUES
(1, 'test-user', 'w@chtwOOrd');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `wine_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `images`
--

INSERT INTO `images` (`id`, `wine_id`, `filename`) VALUES
(1, 1, '65d7587b8e65e_IMG_6507.JPG'),
(2, 2, '65d759441527c_IMG_6505.JPG'),
(3, 3, '65d759fa8c3cc_IMG_6506.JPG'),
(4, 4, '65d75a9daab8d_IMG_6503.JPG'),
(5, 5, '65d75b3034750_IMG_6501.JPG'),
(6, 6, '65d75bbd3e008_IMG_6502.JPG'),
(7, 7, '65d75c41a4cb4_IMG_6504.JPG');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `wines`
--

CREATE TABLE `wines` (
  `id` int(11) NOT NULL,
  `merk` varchar(255) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `kleur` enum('rood','wit','rosé','mousserend') NOT NULL,
  `wprijs` decimal(10,2) NOT NULL,
  `rprijs` decimal(10,2) NOT NULL,
  `land` varchar(255) NOT NULL,
  `streek` text NOT NULL,
  `info` text NOT NULL,
  `rating` decimal(2,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `wines`
--

INSERT INTO `wines` (`id`, `merk`, `naam`, `kleur`, `wprijs`, `rprijs`, `land`, `streek`, `info`, `rating`) VALUES
(1, 'Luigi Togni', 'Rocca dei Forti', 'mousserend', 6.35, 13.00, 'Italië', 'Le Marche', 'Brut 11,5%', 3.0),
(2, 'Jean Dumont', 'Pouilly-Fumé', 'wit', 16.99, 28.00, 'Frankrijk', 'Marnes', '2021 \r\n', 5.0),
(3, 'Terre Sovrane', 'Barolo', 'rood', 16.50, 32.00, 'Italië', 'Piemonte', '13,5%', 4.0),
(4, 'Solatio', 'Prosecco', 'mousserend', 5.24, 12.00, 'Italië', 'Onbekend', 'Extra Dry', 1.0),
(5, 'Notte Rosa', 'Primitivo di Manduria', 'rood', 7.90, 19.00, 'Italië', 'Puglia', 'DOP', 5.0),
(6, 'Veiga da Princesa', 'Albarino', 'wit', 14.70, 26.00, 'Spanje', 'Rias Baixas', 'Nog geen informatie', 4.0),
(7, 'Sette Soli', 'Pinot Grigio', 'wit', 5.99, 17.00, 'Italië', 'Sicilië', 'Goede prijs/kwaliteit verhouding', 3.0);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wine_id` (`wine_id`);

--
-- Indexen voor tabel `wines`
--
ALTER TABLE `wines`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT voor een tabel `wines`
--
ALTER TABLE `wines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`wine_id`) REFERENCES `wines` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
