-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 17, 2020 alle 10:42
-- Versione del server: 10.4.11-MariaDB
-- Versione PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accesso`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `thing`
--

CREATE TABLE `thing` (
  `id` varchar(4) NOT NULL,
  `description` varchar(80) NOT NULL,
  `type` varchar(1) NOT NULL,
  `status` int(11) NOT NULL,
  `sensor` int(11) DEFAULT NULL,
  `timestamp` bigint(20) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `thing`
--

INSERT INTO `thing` (`id`, `description`, `type`, `status`, `sensor`, `timestamp`) VALUES
('B001', 'Bagno maschi piano terra', 'M', 0, 0, 1592383023),
('B002', 'Bagno femmine piano terra', 'W', 0, 0, 1592383025),
('B003', 'Bagno handicap piano terra', 'D', 0, 0, 1592383027),
('B004', 'Bagno docenti primo piano', 'A', 0, 0, 1592383029);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `thing`
--
ALTER TABLE `thing`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
