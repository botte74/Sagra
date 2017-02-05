-- phpMyAdmin SQL Dump
-- version 4.6.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 22, 2016 at 11:55 AM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rqslpelw_sagra`
--

-- --------------------------------------------------------

--
-- Table structure for table `c71po_alimentari`
--

CREATE TABLE `c71po_alimentari` (
  `codice` int(3) UNSIGNED NOT NULL,
  `nome` varchar(25) NOT NULL,
  `tipo` tinyint(1) NOT NULL COMMENT '0 mangiare - 1 bere',
  `descrizione` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `c71po_alimentari`
--

INSERT INTO `c71po_alimentari` (`codice`, `nome`, `tipo`, `descrizione`) VALUES
(1, 'Costicina', 0, NULL),
(2, 'Salsiccia', 0, NULL),
(3, 'Pancetta', 0, NULL),
(4, '1/2 Pollo', 0, 'Mezzo Pollo'),
(5, 'Vino Rabosello', 1, 'Unità di misura espressa in litri.'),
(6, 'Birra Bionda', 1, 'Unità di misura espressa in litri.'),
(7, 'Vino Bianco', 1, 'Unità di misura espressa in litri.'),
(8, 'Vino Merlot', 1, 'Unità di misura espressa in litri.'),
(9, 'Acqua Naturale', 1, '1/2 Litro'),
(10, 'Acqua Frizzante', 1, '1/2 Litro'),
(11, 'Coca Cola', 1, 'Lattina da 0.33L'),
(12, 'Fanta', 1, 'Lattina da 0.33L'),
(13, 'Polenta', 0, NULL),
(14, 'Bigoli', 0, NULL),
(15, 'Gnocchi', 0, NULL),
(16, 'Ragu', 0, NULL),
(17, 'Pomodoro', 0, NULL),
(18, '1/4 Pollo', 0, 'Un quarto di pollo'),
(19, 'Amatriciana', 0, 'Condimento all\'amatriciana'),
(20, 'Olio d\'oliva', 0, 'Condimento per primo'),
(21, 'Cozze (Pesce)', 0, 'Condimento per primo'),
(22, 'Frittura mista di pesce', 0, NULL),
(23, 'Baccala alla vicentina', 0, NULL),
(24, 'Seppie in umido', 0, NULL),
(25, 'Bistecca di cavallo', 0, NULL),
(26, 'Spezzatino di cavallo', 0, NULL),
(27, 'Cotoletta di Pollo', 0, NULL),
(28, 'Patatine Fritte', 0, NULL),
(29, 'Formaggio Asiago', 0, NULL),
(30, 'Formaggio Grana', 0, 'Fetta da tavola'),
(31, 'Porchetta', 0, NULL),
(32, 'Fagioli', 0, NULL),
(33, 'Cipolla', 0, 'Per fagioli con cipolla'),
(34, 'Sedano', 0, 'Per verdura Mista'),
(35, 'Pomodoro', 0, 'Per verdura mista'),
(36, 'Carota', 0, 'Per verdura mista'),
(37, 'Peperoni', 0, ''),
(38, 'Prosecco', 1, 'Bottiglia da 0,7L'),
(39, 'Prosecco', 1, 'Bicchiere da ombra'),
(40, 'Moscato Fior d\'Arancio', 1, 'Bottiglia da 0,7L'),
(41, 'Moscato Fior d\'Arancio', 1, 'Bicchiera da ombra'),
(42, 'Birra Rossa', 1, 'Unità di misura espressa in Litri'),
(43, 'variante', 0, 'Fittizia. Solo per uso interno'),
(44, 'Tagliolini', 0, NULL),
(45, 'Verdure Grigliate', 0, NULL),
(46, 'Ketchup', 0, 'Patatine Fritte - Bustina'),
(48, 'Tagliata Rucola', 0, 'tagliata'),
(50, 'Tagliata Ac Balsamico', 0, 'tagliata aceto balsamico');

-- --------------------------------------------------------

--
-- Table structure for table `c71po_bevande`
--

CREATE TABLE `c71po_bevande` (
  `tipo` varchar(15) NOT NULL,
  `quantita` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `c71po_bevande`
--

INSERT INTO `c71po_bevande` (`tipo`, `quantita`) VALUES
('Bianco-0.5', 0),
('Bianco-1', 0),
('Rabos-0.5', 0),
('Rabos-1', 0),
('Rosso-0.5', 0),
('Rosso-1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `c71po_bist_tagl`
--

CREATE TABLE `c71po_bist_tagl` (
  `id_ordine` int(11) NOT NULL,
  `id_piatto` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `quantita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `c71po_bist_tagl`
--

INSERT INTO `c71po_bist_tagl` (`id_ordine`, `id_piatto`, `nome`, `quantita`) VALUES
(23, 11, 'Bistecca di cavallo', 4),
(23, 112, 'Tagliata con Rucola', 1),
(23, 114, 'Tagliata Aceto Balsamico', 1);

-- --------------------------------------------------------

--
-- Table structure for table `c71po_casse`
--

CREATE TABLE `c71po_casse` (
  `id_cassa` int(7) NOT NULL,
  `cassiere` varchar(30) NOT NULL,
  `cassa` varchar(15) NOT NULL,
  `saldo_iniziale` decimal(5,2) NOT NULL,
  `saldo_finale` decimal(10,2) NOT NULL,
  `ora_inizio` datetime NOT NULL,
  `ora_fine` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `c71po_casse`
--

INSERT INTO `c71po_casse` (`id_cassa`, `cassiere`, `cassa`, `saldo_iniziale`, `saldo_finale`, `ora_inizio`, `ora_fine`) VALUES
(34, 'ciao', '1', 50.00, 0.00, '2015-05-22 15:11:35', '0000-00-00 00:00:00'),
(35, 'Santo', '1', 400.00, 0.00, '2015-05-26 22:35:44', '2015-05-26 22:57:48'),
(36, 'Santo', '1', 400.00, 0.00, '2015-05-26 22:59:13', '2015-05-26 22:59:21'),
(37, 'Santo', '1', 400.00, 0.00, '2015-05-27 18:59:50', '0000-00-00 00:00:00'),
(38, 'Santo', '1', 400.00, 0.00, '2015-05-27 19:04:34', '0000-00-00 00:00:00'),
(39, 'Santo', '1', 150.00, 0.00, '2015-05-27 19:06:39', '0000-00-00 00:00:00'),
(40, 'Santo', '1', 150.00, 0.00, '2015-05-27 19:11:47', '0000-00-00 00:00:00'),
(41, 'ciao', '1', 20.00, 0.00, '2015-05-29 11:20:50', '0000-00-00 00:00:00'),
(42, 'Santo', '1', 400.00, 0.00, '2015-05-30 08:41:30', '0000-00-00 00:00:00'),
(43, 'santo', '1', 400.00, 0.00, '2015-06-02 19:08:55', '0000-00-00 00:00:00'),
(44, 'provaPoli', '1', 50.00, 0.00, '2015-06-05 09:10:38', '0000-00-00 00:00:00'),
(45, 'Santo', '1', 375.00, 0.00, '2015-06-06 12:27:38', '0000-00-00 00:00:00'),
(46, 'Santo', '1', 375.00, 0.00, '2015-06-07 18:44:59', '0000-00-00 00:00:00'),
(47, 'ciao', '1', 10.00, 0.00, '2015-06-08 15:53:13', '0000-00-00 00:00:00'),
(48, 'davide', '1', 999.99, 0.00, '2015-06-09 19:47:15', '0000-00-00 00:00:00'),
(49, 'santo', '1', 315.00, 0.00, '2015-06-13 14:31:48', '0000-00-00 00:00:00'),
(50, 'Costa', '1', 300.00, 0.00, '2015-07-02 17:36:33', '0000-00-00 00:00:00'),
(51, 'prova', '1', 50.00, 0.00, '2015-09-01 07:45:17', '0000-00-00 00:00:00'),
(52, 'ciao', '1', 50.00, 0.00, '2015-09-02 08:50:45', '0000-00-00 00:00:00'),
(53, 'provaPoli', '1', 10.00, 0.00, '2015-09-02 10:16:48', '0000-00-00 00:00:00'),
(54, 'provaPoli', '1', 50.00, 0.00, '2015-09-02 13:31:59', '0000-00-00 00:00:00'),
(55, 'provaPoli', '1', 50.00, 0.00, '2015-09-03 09:11:53', '0000-00-00 00:00:00'),
(56, 'ciao', '1', 50.00, 0.00, '2015-09-03 10:18:24', '2015-09-03 10:25:12'),
(57, 'provaPoli', '1', 50.00, 0.00, '2015-09-03 10:25:19', '0000-00-00 00:00:00'),
(58, 'prova', '1', 50.00, 0.00, '2015-09-04 15:39:16', '0000-00-00 00:00:00'),
(59, 'prova', '1', 50.00, 0.00, '2015-09-04 16:23:13', '0000-00-00 00:00:00'),
(60, 'prova', '1', 50.00, 0.00, '2015-09-04 16:58:08', '0000-00-00 00:00:00'),
(61, 'Federica', '1', 0.00, 0.00, '2015-09-04 19:05:54', '0000-00-00 00:00:00'),
(62, 'prova', '1', 50.00, 0.00, '2015-09-04 19:10:46', '2015-09-04 19:13:01'),
(63, 'Federica', '2', 255.00, 0.00, '2015-09-04 19:13:45', '0000-00-00 00:00:00'),
(64, 'Alessia', '1', 255.00, 0.00, '2015-09-04 19:38:30', '0000-00-00 00:00:00'),
(65, 'Alessia', '1', 255.00, 0.00, '2015-09-04 20:04:44', '0000-00-00 00:00:00'),
(66, 'prova', '1', 50.00, 0.00, '2015-09-05 17:42:01', '0000-00-00 00:00:00'),
(67, 'prova', '1', 49.00, 0.00, '2015-09-05 17:47:23', '0000-00-00 00:00:00'),
(68, 'prova', '1', 49.00, 0.00, '2015-09-05 17:56:46', '0000-00-00 00:00:00'),
(69, 'Davide', '1', 255.00, 0.00, '2015-09-05 19:17:06', '0000-00-00 00:00:00'),
(70, 'enrico', '2', 255.00, 0.00, '2015-09-05 19:17:58', '0000-00-00 00:00:00'),
(71, 'elimina', '1', 50.00, 0.00, '2015-09-06 11:35:37', '0000-00-00 00:00:00'),
(72, 'prova', '1', 50.00, 0.00, '2015-09-06 16:53:24', '0000-00-00 00:00:00'),
(73, 'prova1', '2', 100.00, 0.00, '2015-09-06 17:34:32', '2015-09-06 18:28:25'),
(74, 'Costa Prova', '1', 0.00, 0.00, '2015-09-06 17:50:39', '0000-00-00 00:00:00'),
(75, 'paninoteca', '1', 0.00, 0.00, '2015-09-06 18:09:07', '2015-09-06 18:49:17'),
(76, 'davide', '1', 0.00, 0.00, '2015-09-06 18:40:09', '2015-09-06 19:17:43'),
(77, 'Stefano', '3', 0.00, 0.00, '2015-09-06 18:49:37', '0000-00-00 00:00:00'),
(78, 'Chiara', '2', 0.00, 0.00, '2015-09-06 19:12:11', '0000-00-00 00:00:00'),
(79, 'Chiara Botton', '1', 274.00, 2557.00, '2015-09-06 19:19:08', '2015-09-06 21:28:01'),
(80, 'Enrico DallArmi', '2', 271.00, 2275.00, '2015-09-06 19:20:02', '2015-09-06 21:49:41'),
(81, 'davide', '3', 0.00, 15.00, '2015-09-06 21:28:56', '2015-09-06 21:34:02'),
(82, 'Chiara Botton', '1', 0.00, 0.00, '2015-09-06 21:34:52', '2015-09-06 22:33:56'),
(83, 'paninoteca', '3', 0.00, 0.00, '2015-09-07 17:13:01', '0000-00-00 00:00:00'),
(84, 'prova', '1', 49.00, 0.00, '2015-09-07 17:29:54', '0000-00-00 00:00:00'),
(85, 'Manuela', '1', 271.00, 0.00, '2015-09-07 19:21:26', '0000-00-00 00:00:00'),
(86, 'alessia', '2', 255.00, 0.00, '2015-09-07 19:26:28', '0000-00-00 00:00:00'),
(87, 'Paninoteca', '3', 0.00, 0.00, '2015-09-08 18:38:38', '0000-00-00 00:00:00'),
(88, 'Alessia', '2', 271.00, 0.00, '2015-09-08 19:28:06', '0000-00-00 00:00:00'),
(89, 'Chiara', '1', 256.00, 0.00, '2015-09-08 19:30:26', '2015-09-08 19:38:32'),
(90, 'chiara', '1', 309.00, 0.00, '2015-09-08 19:38:53', '0000-00-00 00:00:00'),
(91, 'Chiara', '1', 309.00, 0.00, '2015-09-08 19:41:07', '0000-00-00 00:00:00'),
(92, 'Francesco', '1', 200.00, 0.00, '2015-10-05 18:53:58', '2015-10-05 18:55:48'),
(93, 'cassa', '22', 67.00, 0.00, '2016-01-22 11:30:38', '0000-00-00 00:00:00'),
(94, 'Giaco', '1', 50.00, 0.00, '2016-05-14 15:08:10', '0000-00-00 00:00:00'),
(95, 'Giac', '1', 50.00, 0.00, '2016-05-15 17:09:29', '2016-05-15 17:20:30'),
(96, 'Enrico DallArmi', '1', 150.00, 0.00, '2016-05-17 17:29:34', '0000-00-00 00:00:00'),
(97, 'Chiara', '1', 309.00, 0.00, '2016-05-17 17:41:53', '0000-00-00 00:00:00'),
(98, 'G', '1', 50.00, 0.00, '2016-05-17 17:43:48', '0000-00-00 00:00:00'),
(99, 'giaco', '4', 50.00, 0.00, '2016-05-31 12:41:18', '0000-00-00 00:00:00'),
(100, 'provs', '1', 50.00, 0.00, '2016-06-12 12:01:27', '0000-00-00 00:00:00'),
(101, 'sagra', '1', 350.00, 0.00, '2016-06-12 17:49:58', '0000-00-00 00:00:00'),
(102, 'provs', '1', 50.00, 0.00, '2016-06-20 18:25:08', '0000-00-00 00:00:00'),
(103, 'provs', '1', 50.00, 0.00, '2016-07-25 09:50:45', '0000-00-00 00:00:00'),
(104, 'giaco', '4', 50.00, 0.00, '2016-07-25 10:28:51', '0000-00-00 00:00:00'),
(105, 'giaco', '4', 50.00, 0.00, '2016-07-26 15:37:52', '2016-07-26 15:47:36'),
(106, 'giaco', '4', 50.00, 0.00, '2016-07-26 15:52:02', '2016-07-26 15:52:24'),
(107, 'prova', '2', 50.00, 0.00, '2016-07-26 15:52:35', '0000-00-00 00:00:00'),
(108, 'giaco', '4', 50.00, 0.00, '2016-07-26 15:52:40', '0000-00-00 00:00:00'),
(109, 'prova', '2', 50.00, 0.00, '2016-07-26 18:10:39', '0000-00-00 00:00:00'),
(110, 'prova', '2', 50.00, 0.00, '2016-07-26 18:21:27', '0000-00-00 00:00:00'),
(111, 'prova', '2', 50.00, 0.00, '2016-07-26 18:22:50', '0000-00-00 00:00:00'),
(112, 'prova', '2', 50.00, 0.00, '2016-07-26 18:23:27', '0000-00-00 00:00:00'),
(113, 'prova', '2', 50.00, 0.00, '2016-07-26 18:24:30', '0000-00-00 00:00:00'),
(114, 'prova', '2', 50.00, 0.00, '2016-07-26 18:26:01', '0000-00-00 00:00:00'),
(115, 'prova', '2', 50.00, 0.00, '2016-07-27 08:39:33', '0000-00-00 00:00:00'),
(116, 'giaco', '4', 50.00, 0.00, '2016-07-27 16:32:13', '0000-00-00 00:00:00'),
(117, 'prova', '2', 50.00, 0.00, '2016-07-28 15:43:18', '0000-00-00 00:00:00'),
(118, 'prova', '2', 50.00, 0.00, '2016-07-28 17:42:17', '0000-00-00 00:00:00'),
(119, 'prova', '2', 50.00, 0.00, '2016-08-03 11:33:13', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `c71po_cucina_fredda`
--

CREATE TABLE `c71po_cucina_fredda` (
  `tipo` varchar(15) NOT NULL,
  `quantita` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `c71po_cucina_fredda`
--

INSERT INTO `c71po_cucina_fredda` (`tipo`, `quantita`) VALUES
('asiago', 0),
('grana', 0),
('grana_porchetta', 0),
('fagioli', 0),
('fagioli_cipolla', 0),
('verdura_mista', 0);

-- --------------------------------------------------------

--
-- Table structure for table `c71po_griglie`
--

CREATE TABLE `c71po_griglie` (
  `tipo` varchar(15) NOT NULL,
  `quantita` int(5) NOT NULL DEFAULT '0',
  `richiesta` int(3) NOT NULL DEFAULT '0' COMMENT '0: non richiesto - 1:richiesto'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `c71po_griglie`
--

INSERT INTO `c71po_griglie` (`tipo`, `quantita`, `richiesta`) VALUES
('Bigoli', 0, 0),
('Costine', 0, 0),
('Pancetta', 0, 0),
('Patatine', 0, 0),
('Polenta', 0, 0),
('Pollo', 0, 0),
('Pollo 1/2', 0, 0),
('Pollo 1/4', 0, 0),
('Salsicce', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `c71po_ordini`
--

CREATE TABLE `c71po_ordini` (
  `id_ordine` int(8) UNSIGNED NOT NULL,
  `nome_cliente` varchar(25) DEFAULT NULL,
  `tavolo` varchar(8) DEFAULT NULL,
  `coperto` int(2) DEFAULT NULL,
  `giorno` varchar(10) DEFAULT NULL,
  `data_ordine` datetime DEFAULT NULL,
  `fine` datetime DEFAULT NULL,
  `stato` varchar(20) NOT NULL,
  `prezzo_totale` decimal(8,2) NOT NULL,
  `speciale` varchar(25) DEFAULT NULL,
  `cassa` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `c71po_ordini`
--

INSERT INTO `c71po_ordini` (`id_ordine`, `nome_cliente`, `tavolo`, `coperto`, `giorno`, `data_ordine`, `fine`, `stato`, `prezzo_totale`, `speciale`, `cassa`) VALUES
(1, 'giaco', NULL, 2, NULL, NULL, NULL, '', 50.00, NULL, 4),
(2, NULL, NULL, NULL, NULL, NULL, NULL, 'ibernato', 0.00, NULL, 108),
(3, NULL, NULL, NULL, NULL, NULL, NULL, 'ibernato', 0.00, NULL, 114),
(4, NULL, NULL, NULL, NULL, NULL, NULL, 'ibernato', 0.00, NULL, 115),
(5, 'Stampa', 'tavolo', 2, NULL, '2016-07-27 09:13:03', '2016-07-27 09:19:50', 'evaso', 2.00, NULL, 115),
(6, NULL, NULL, NULL, NULL, NULL, NULL, 'ibernato', 0.00, NULL, 115),
(7, 'Stampa', 'tavolo', 2, NULL, '2016-07-27 09:22:59', '2016-07-27 16:14:45', 'evaso', 85.00, NULL, 115),
(8, 'Stampa', 'tavolo', 2, NULL, '2016-07-27 09:48:46', NULL, 'pagato', 127.50, NULL, 115),
(9, NULL, NULL, NULL, NULL, NULL, NULL, 'ibernato', 0.00, NULL, 115),
(10, 'Stampa', 'tavolo', 2, NULL, '2016-07-27 10:09:45', NULL, 'pagato', 170.50, NULL, 115),
(11, 'Stampa', 'tavolo', 2, NULL, '2016-07-27 11:18:03', NULL, 'pagato', 235.00, NULL, 115),
(12, 'Stampa', 'tavolo', 2, NULL, '2016-07-27 11:29:18', NULL, 'pagato', 225.00, NULL, 115),
(13, 'giaco', 'tavolo', 2, NULL, '2016-07-27 16:32:31', NULL, 'pagato', 254.50, NULL, 116),
(14, NULL, NULL, NULL, NULL, NULL, NULL, 'ibernato', 0.00, NULL, 117),
(15, NULL, NULL, NULL, NULL, NULL, NULL, 'ibernato', 0.00, NULL, 0),
(16, 'Stampa', 'tavolo', 2, NULL, '2016-07-28 17:46:58', NULL, 'pagato', 55.00, NULL, 118),
(17, 'Stampa', 'tavolo', 2, NULL, '2016-07-28 17:47:30', NULL, 'pagato', 165.00, NULL, 118),
(18, NULL, NULL, NULL, NULL, NULL, NULL, 'ibernato', 0.00, NULL, 118),
(19, NULL, NULL, NULL, NULL, NULL, NULL, 'ibernato', 0.00, NULL, 118),
(20, NULL, NULL, NULL, NULL, NULL, NULL, 'ibernato', 0.00, NULL, 118),
(21, NULL, NULL, NULL, NULL, NULL, NULL, 'ibernato', 0.00, NULL, 118),
(22, NULL, NULL, NULL, NULL, NULL, NULL, 'ibernato', 0.00, NULL, 118),
(23, 'Stampa', 'tavolo', 2, NULL, '2016-08-03 11:33:32', NULL, 'pagato', 72.00, NULL, 119);

-- --------------------------------------------------------

--
-- Table structure for table `c71po_ordini_composizione`
--

CREATE TABLE `c71po_ordini_composizione` (
  `id_ordine` int(8) UNSIGNED NOT NULL,
  `id_piatto` int(3) UNSIGNED NOT NULL,
  `var` int(3) NOT NULL DEFAULT '0' COMMENT '0: no varianti; altro: codice varianti',
  `quantita` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `c71po_ordini_composizione`
--

INSERT INTO `c71po_ordini_composizione` (`id_ordine`, `id_piatto`, `var`, `quantita`) VALUES
(5, 15, 0, 100),
(5, 18, 0, 100),
(5, 19, 0, 100),
(5, 20, 0, 100),
(5, 21, 0, 100),
(7, 112, 0, 5),
(7, 114, 0, 5),
(8, 112, 0, 5),
(8, 113, 0, 5),
(8, 114, 0, 5),
(10, 11, 0, 15),
(10, 12, 0, 1),
(10, 14, 0, 1),
(10, 15, 0, 1),
(10, 18, 0, 1),
(10, 19, 0, 1),
(10, 20, 0, 1),
(10, 21, 0, 1),
(10, 22, 0, 1),
(10, 112, 0, 1),
(10, 113, 0, 1),
(10, 114, 0, 1),
(11, 11, 0, 10),
(11, 112, 0, 10),
(11, 114, 0, 10),
(12, 11, 0, 15),
(12, 112, 0, 5),
(12, 114, 0, 10),
(13, 11, 0, 4),
(13, 12, 0, 4),
(13, 14, 0, 4),
(13, 15, 0, 4),
(13, 18, 0, 4),
(13, 19, 0, 5),
(13, 20, 0, 1),
(13, 21, 0, 6),
(13, 22, 0, 4),
(13, 25, 0, 5),
(13, 70, 0, 8),
(16, 120, 0, 10),
(17, 121, 0, 30),
(23, 11, 0, 4),
(23, 20, 0, 1),
(23, 21, 0, 1),
(23, 22, 0, 1),
(23, 112, 0, 1),
(23, 114, 0, 1),
(23, 119, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `c71po_paninoteca`
--

CREATE TABLE `c71po_paninoteca` (
  `tipo` varchar(30) NOT NULL,
  `quantita` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `c71po_paninoteca`
--

INSERT INTO `c71po_paninoteca` (`tipo`, `quantita`) VALUES
('Acqua Naturale', 0),
('Acqua Frizzante', 0),
('Fanta', 0),
('Coca Cola', 0),
('Prosecco', 0),
('Prosecco Bicchiere', 0),
('Fior Arancio', 0),
('Fior Arancio Bicchiere', 0),
('Bionda Piccola', 0),
('Bionda Media', 0),
('Rossa Piccola', 0),
('Rossa Media', 0),
('Rabosello 0.5', 0),
('Rosso 0.5', 0),
('Bianco 0.5', 0),
('Rabosello 1.0', 0),
('Rosso 1.0', 0),
('Bianco 1.0', 0),
('Rabosello Bicchiere', 0),
('Rosso Bicchiere', 0),
('Bianco Bicchiere', 0),
('Spritz Campari', 0),
('Spritz Aperol', 0),
('Mojito', 0),
('Cuba Libre', 0),
('Rum e Pera', 0),
('Panino Porchetta', 0),
('Hot Dog', 0),
('Piatto Porchetta', 0),
('Peperoni Grigliati', 0),
('Salse', 0),
('Bianco Frizz. 0.5L', 0),
('Bianco Frizz. 1L', 0);

-- --------------------------------------------------------

--
-- Table structure for table `c71po_piatti`
--

CREATE TABLE `c71po_piatti` (
  `codice` int(3) UNSIGNED NOT NULL,
  `nome` varchar(90) NOT NULL,
  `prezzo` decimal(6,2) NOT NULL,
  `descrizione` text NOT NULL,
  `tipologia` varchar(25) DEFAULT NULL,
  `ordine` int(3) DEFAULT NULL,
  `ordinabile` tinyint(1) DEFAULT NULL,
  `varianti` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 No Varianti - 1 Varianti',
  `immagine` varchar(30) NOT NULL DEFAULT 'immagine-non-disponibile.jpg',
  `giovedi` tinyint(1) NOT NULL,
  `venerdi` tinyint(1) NOT NULL,
  `sabato` tinyint(1) NOT NULL,
  `domenica` tinyint(1) NOT NULL,
  `lunedi` tinyint(1) NOT NULL,
  `martedi` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `c71po_piatti`
--

INSERT INTO `c71po_piatti` (`codice`, `nome`, `prezzo`, `descrizione`, `tipologia`, `ordine`, `ordinabile`, `varianti`, `immagine`, `giovedi`, `venerdi`, `sabato`, `domenica`, `lunedi`, `martedi`) VALUES
(1, 'Gnocchi', 4.00, 'Gnocchi al ', '1-Primo', NULL, 1, 1, 'gnocchi.jpg', 0, 1, 1, 0, 1, 1),
(5, 'Bigoli', 4.00, 'Bigoli al', '1-Primo', NULL, 1, 1, 'bigoli.jpg', 0, 1, 1, 1, 1, 1),
(9, 'Tagliolini allo scoglio', 5.50, '', '1-Primo', NULL, 0, 0, 'tagliolini-allo-scoglio.jpg', 0, 0, 0, 1, 0, 0),
(10, 'Frittura mista di pesce', 9.00, '+ Polenta. Surgelato.', '2-Secondo', NULL, 1, 0, 'frittura-pesce.jpg', 0, 0, 0, 1, 1, 0),
(11, 'Bistecca di cavallo', 7.00, '+ Polenta', '2-Secondo', NULL, 1, 0, 'straecca.jpg', 0, 1, 1, 1, 1, 1),
(12, 'Seppie in umido', 6.00, '+ Polenta', '2-Secondo', NULL, 1, 0, 'seppie.jpg', 0, 1, 1, 1, 1, 0),
(13, 'Straecca di cavallo', 6.50, '+ Polenta', '2-Secondo', NULL, 0, 0, 'straecca.jpg', 1, 1, 1, 1, 1, 1),
(14, 'Spezzatino di cavallo', 6.00, '+ Polenta', '2-Secondo', NULL, 0, 0, 'spezzatino-di-cavallo.jpg', 0, 1, 1, 0, 1, 0),
(15, '1/2 Galletto', 6.00, '+ Polenta', '2-Secondo', NULL, 1, 0, 'galletto.jpg', 0, 1, 1, 0, 1, 1),
(16, '2 Salsicce', 4.50, '+ 2 Polenta', '2-Secondo', NULL, 0, 0, 'salsicce.jpg', 1, 1, 1, 1, 1, 1),
(17, '2 Costine', 4.50, '+ Polenta', '2-Secondo', NULL, 0, 0, 'costine.jpg', 1, 1, 1, 1, 1, 1),
(18, '2 Costine + 1 Salsiccia', 5.50, '+ Polenta', '2-Secondo', NULL, 1, 0, 'costine-salsiccia.jpg', 0, 1, 1, 0, 1, 1),
(19, '2 Salsicce + 1 Costina', 5.50, '+ Polenta', '2-Secondo', NULL, 1, 0, 'costine-salsiccia.jpg', 0, 1, 1, 0, 1, 1),
(20, 'Di tutt\'un po\'', 5.00, '1 pancetta + 1 costina + 1 salsiccia + 2 Polente', '2-Secondo', NULL, 1, 0, 'grigliata-mista.jpg', 0, 1, 1, 0, 1, 1),
(21, 'Grigliata Mista', 8.00, '1/4 pollo + 1 salsiccia + 1 costina + 1 pancetta + 2 Polente', '2-Secondo', NULL, 1, 0, 'grigliata-mista.jpg', 0, 1, 1, 0, 1, 1),
(22, 'Baccala alla vicentina', 8.00, '+ Polenta', '2-Secondo', NULL, 1, 0, 'baccala-alla-vicentina.jpg', 0, 1, 1, 1, 1, 1),
(23, 'Menu BAMBINI', 5.50, 'Bocconcini di pollo + patatine + ', '0-Menu', NULL, 1, 1, 'menu-bimbi.jpg', 0, 1, 1, 1, 1, 1),
(25, 'Formaggio grana da tavola', 3.00, 'Fetta grande', '3-Contorno', NULL, 1, 0, 'fetta-grana.jpg', 0, 1, 1, 1, 1, 1),
(26, 'Formaggio Grana da tavola + Porchetta', 6.00, 'Formaggio grana da tavola + porchetta', '3-Contorno', NULL, 0, 0, 'fetta-grana.jpg', 0, 1, 1, 1, 1, 1),
(28, 'Faglioli con Cipolla', 2.00, '', '3-Contorno', NULL, 0, 0, 'fagioli-cipolla.jpg', 1, 1, 1, 1, 1, 1),
(29, 'Verdura Fresca Mista', 2.00, 'insalata, carote, pomodori', '3-Contorno', NULL, 0, 0, 'verdura-mista.jpg', 1, 1, 1, 1, 1, 1),
(30, 'Patatine Fritte', 2.00, '', '3-Contorno', NULL, 0, 0, 'patatine.jpg', 1, 1, 1, 1, 1, 1),
(32, 'Bianco 1 Litro', 4.50, '', '4-Bevanda', NULL, 1, 0, 'vino-bianco.jpg', 1, 1, 1, 1, 1, 1),
(33, 'Rosso 1 Litro', 4.50, '', '4-Bevanda', NULL, 1, 0, 'vino-rosso.jpg', 1, 1, 1, 1, 1, 1),
(34, 'Bianco 1/2 Litro', 2.50, '', '4-Bevanda', NULL, 1, 0, 'vino-bianco.jpg', 1, 1, 1, 1, 1, 1),
(35, 'Rosso 1/2 Litro', 2.50, '', '4-Bevanda', NULL, 1, 0, 'vino-rosso.jpg', 1, 1, 1, 1, 1, 1),
(36, 'Rabosello 1 Litro', 5.00, '', '4-Bevanda', NULL, 1, 0, 'vino-rosso.jpg', 1, 1, 1, 1, 1, 1),
(37, 'Rabosello 1/2 Litro', 3.00, '', '4-Bevanda', NULL, 1, 0, 'vino-rosso.jpg', 1, 1, 1, 1, 1, 1),
(38, 'Bianco Frizzante 1L', 4.50, '', '4-Bevanda', NULL, 1, 0, 'vino-bianco.jpg', 1, 1, 1, 1, 1, 1),
(39, 'Bianco Frizzante 1/2L', 2.50, '', '4-Bevanda', NULL, 1, 0, 'vino-bianco.jpg', 1, 1, 1, 1, 1, 1),
(44, 'Bianco bicchiere', 1.00, '', '4-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(45, 'Rosso bicchiere', 1.00, '', '4-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(46, 'Rabosello Bicchiere', 1.00, '', '4-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(47, 'Fior d\'Arancio Bicchiere', 1.50, '', '4-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(48, 'Prosecco Bicchiere', 1.50, '', '4-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(49, 'Birra Bionda Piccola', 3.00, 'Birra bionda da 0.3 cl', '4-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(50, 'Birra Bionda Media', 3.50, 'Birra bionda da 0.4 cl', '4-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(51, 'Birra Rossa Piccola', 3.00, 'Birra rossa da 0.3 cl', '4-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(52, 'Birra Rossa Media', 3.50, 'Birra rossa da 0.4 cl', '4-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(53, 'Mojito', 4.00, 'mojito', '4-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(54, 'Cuba Libre', 4.00, 'cuba libre', '4-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(55, 'Rum e Pera', 1.50, 'bicchierino di rum e pera', '4-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(56, 'Spritz Campari', 2.00, 'spritz al campari', '4-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(57, 'Spritz Aperol', 2.00, 'Spritz aperol', '4-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(58, 'Panino con Porchetta', 3.00, 'panino con la porchetta', '5-Altro', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(59, 'Hot Dog', 2.50, 'hot dog', '5-Altro', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(60, 'Piatto di Porchetta', 5.00, 'piatto di porchetta', '5-Altro', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(61, 'Peperoni grigliati in aggiunta', 0.50, 'peperoni grigliati in aggiunta', '5-Altro', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(62, 'Salse in aggiunta', 0.50, 'ketchup e maionese', '5-Altro', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(64, '1/4 di pollo', 0.00, '', '2-Secondo', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(65, '1 Costina + 1 Salsiccia', 0.00, '', '2-Secondo', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(66, '2 Costine + 2 Salsicce + 2 Pancette', 0.00, '', '2-Secondo', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(67, 'Aggiunta Salsiccia', 2.00, '', '2-Secondo', NULL, 0, 0, 'salsicce.jpg', 1, 1, 1, 1, 1, 1),
(68, 'Aggiunta Costicina', 2.00, '', '2-Secondo', NULL, 0, 0, 'costine.jpg', 1, 1, 1, 1, 1, 1),
(70, 'Patatine fritte', 2.00, '+ Ketchup', '3-Contorno', NULL, 0, 0, 'patatine.jpg', 0, 1, 1, 1, 1, 1),
(71, 'Tagliolini', 4.00, 'Tagliolini al ', '1-Primo', NULL, 0, 1, 'tagliolini-allo-scoglio.jpg', 0, 0, 0, 1, 0, 0),
(72, 'Gnocchi ', 4.50, 'Gnocchi al Ragù di Carne', '1-Primo', NULL, 1, 0, 'gnocchi.jpg', 0, 1, 1, 0, 1, 1),
(73, 'Bigoli', 4.50, 'Bigoli al Ragù di Carne', '1-Primo', NULL, 1, 0, 'bigoli.jpg', 0, 1, 1, 0, 1, 1),
(74, 'Gnocchi al Ragu d\'Anitra', 5.00, '', '1-Primo', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(75, 'Bigoli al Ragu d\'Anitra', 5.00, '', '1-Primo', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(77, 'Fetta di Dolce', 2.50, 'Mandorle, Crema e Pinoli, Torta al Limone, Salame di Cioccolata', '5-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(78, 'Spaghetti al pomodoro', 3.50, '', '1-Primo', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(79, 'Spaghetti ai frutti di mare', 5.00, '', '1-Primo', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(80, 'Frittura mista di pesce con polenta', 9.00, '', '2-Secondo', NULL, 0, 0, 'frittura-pesce.jpg', 1, 1, 1, 1, 1, 1),
(81, 'Bistecca di manzo', 6.00, '', '2-Secondo', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(82, 'Seppie in umido', 6.00, '', '2-Secondo', NULL, 0, 0, 'seppie.jpg', 1, 1, 1, 1, 1, 1),
(83, 'Formaggio asiago fresco', 3.00, '', '3-Contorno', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(84, 'Fagioli', 2.00, '', '3-Contorno', NULL, 0, 0, 'fagioli.jpg', 0, 1, 1, 1, 1, 1),
(85, 'Fagioli con cipolla', 2.00, '', '3-Contorno', NULL, 1, 0, 'fagioli-cipolla.jpg', 1, 1, 1, 1, 1, 1),
(87, 'Patatine fritte', 2.50, ' con o senza Ketchup', '3-Contorno', NULL, 1, 0, 'patatine.jpg', 1, 1, 1, 1, 1, 1),
(88, 'Patatine fritte + ketchup', 2.50, '', '3-Contorno', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(89, 'Bianco 1L', 4.50, '', '4-Bevanda', NULL, 0, 0, 'vino-bianco.jpg', 1, 1, 1, 1, 1, 1),
(90, 'Rosso 1L', 4.50, '', '4-Bevanda', NULL, 0, 0, 'vino-rosso.jpg', 1, 1, 1, 1, 1, 1),
(91, 'Rabosello 1/2 Litro', 3.00, '', '4-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(92, 'Bianco 0.5', 3.00, '', '4-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(93, 'Rosso 0.5', 2.50, '', '4-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(94, 'Prosecco DOC Voldobbiadene', 6.00, '', '4-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(95, 'Moscato', 6.50, 'Fior D\'arancio', '4-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(96, 'Acqua Naturale 0.5', 1.00, '', '4-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(97, 'Acqua Frizzante 0.5', 1.00, '', '4-Bevanda', NULL, 0, 0, 'acqua-naturale.jpg', 1, 1, 1, 1, 1, 1),
(98, 'Birra alla spina', 3.00, 'Marca: Spaten', '4-Bevanda', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(99, 'Coca Cola', 1.50, 'lattina', '4-Bevanda', NULL, 0, 0, 'cocacola.jpg', 1, 1, 1, 1, 1, 1),
(100, 'Aranciata', 1.50, 'lattina', '4-Bevanda', NULL, 0, 0, 'aranciata.jpg', 1, 1, 1, 1, 1, 1),
(101, 'Dolce', 2.50, 'carrello dei dolci', '5-Altro', NULL, 0, 0, 'immagine-non-disponibile.jpg', 1, 1, 1, 1, 1, 1),
(103, 'Verdura Fresca Mista', 2.00, 'insalata, carote, pomodori', '3-Contorno', NULL, 1, 0, 'verdura-mista.jpg', 0, 1, 1, 1, 1, 1),
(104, 'Verdure Grigliate', 3.00, '', '3-Contorno', NULL, 1, 0, 'verdure-grigliate.jpg', 0, 1, 1, 1, 1, 1),
(105, 'Polenta', 0.00, 'Polenta in aggiunta', '3-Contorno', NULL, 1, 0, 'polenta.jpg', 0, 1, 1, 1, 1, 1),
(106, 'Prosecco', 6.00, 'Bottiglia 0.7', '4-Bevanda', NULL, 1, 0, 'prosecco.jpg', 1, 1, 1, 1, 1, 1),
(107, 'Fior d\'Arancio', 6.00, 'Bottiglia 0.7', '4-Bevanda', NULL, 1, 0, 'fior-arancio.jpg', 1, 1, 1, 1, 1, 1),
(108, 'Acqua Naturale 1/2 litr0', 1.00, '', '4-Bevanda', NULL, 1, 0, 'acqua-naturale.jpg', 1, 1, 1, 1, 1, 1),
(109, 'Acqua Gasata 1/2 litro', 1.00, '', '4-Bevanda', NULL, 1, 0, 'acqua-naturale.jpg', 1, 1, 1, 1, 1, 1),
(110, 'Coca Cola', 1.50, 'Lattina 0.33', '4-Bevanda', NULL, 1, 0, 'cocacola.jpg', 1, 1, 1, 1, 1, 1),
(111, 'Aranciata ', 1.50, 'Lattina 0.33', '4-Bevanda', NULL, 1, 0, 'aranciata.jpg', 1, 1, 1, 1, 1, 1),
(112, 'Tagliata con Rucola', 8.50, '+ Polenta', '2-Secondo', NULL, 1, 0, 'tagliata.jpg', 0, 1, 1, 1, 1, 0),
(113, 'Tagliata al rosmarino', 8.50, '+ Polenta', '2-Secondo', NULL, 0, 0, 'tagliata.jpg', 0, 0, 0, 1, 1, 1),
(114, 'Tagliata Aceto Balsamico', 8.50, '+ Polenta', '2-Secondo', NULL, 1, 0, 'tagliata.jpg', 0, 1, 1, 1, 1, 0),
(115, 'BIGLIETTO GONFIABILI (15 min)', 1.50, 'durata 15 minuti', '4-Bevanda', NULL, 1, 0, 'immagine-non-disponibile.jpg', 0, 0, 0, 1, 1, 1),
(117, 'Piatto Del Giorno', 5.50, '', '1-Primo', NULL, 1, 0, 'immagine-non-disponibile.jpg', 0, 1, 1, 0, 0, 0),
(118, 'Cus Cus di Verdure', 4.00, '', '1-Primo', NULL, 1, 0, 'immagine-non-disponibile.jpg', 0, 1, 1, 1, 1, 0),
(119, 'Trippa Alla Parmigiana', 6.00, '', '2-Secondo', NULL, 1, 0, 'immagine-non-disponibile.jpg', 0, 1, 1, 0, 1, 0),
(120, '3 Costine', 5.50, '+ Polenta', '2-Secondo', NULL, 1, 0, 'immagine-non-disponibile.jpg', 0, 1, 1, 0, 1, 0),
(121, '3 Salsicce', 5.50, '+ Polenta', '2-Secondo', NULL, 1, 0, 'immagine-non-disponibile.jpg', 0, 1, 1, 0, 1, 0),
(122, 'Bigoli', 5.00, 'Bigoli in Salsa', '1-Primo', NULL, 1, 0, 'immagine-non-disponibile.jpg', 0, 0, 0, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `c71po_piatti_composizione`
--

CREATE TABLE `c71po_piatti_composizione` (
  `cod_alimentari` int(3) UNSIGNED NOT NULL,
  `cod_piatto` int(3) UNSIGNED NOT NULL,
  `quantita_alimento` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `c71po_piatti_composizione`
--

INSERT INTO `c71po_piatti_composizione` (`cod_alimentari`, `cod_piatto`, `quantita_alimento`) VALUES
(1, 17, 2),
(1, 18, 2),
(1, 19, 1),
(1, 20, 1),
(1, 21, 1),
(1, 68, 1),
(1, 120, 3),
(2, 16, 2),
(2, 18, 1),
(2, 19, 2),
(2, 20, 1),
(2, 21, 1),
(2, 67, 1),
(2, 121, 3),
(3, 20, 1),
(3, 21, 1),
(4, 15, 1),
(5, 36, 1),
(5, 37, 1),
(7, 32, 1),
(7, 34, 1),
(8, 33, 1),
(8, 35, 1),
(9, 23, 1),
(9, 40, 1),
(10, 23, 1),
(10, 41, 1),
(11, 23, 1),
(11, 42, 1),
(12, 23, 1),
(12, 43, 1),
(13, 10, 1),
(13, 11, 1),
(13, 12, 1),
(13, 13, 1),
(13, 14, 1),
(13, 15, 1),
(13, 18, 1),
(13, 19, 1),
(13, 20, 1),
(13, 21, 2),
(13, 22, 1),
(13, 25, 1),
(13, 31, 1),
(13, 112, 1),
(13, 113, 1),
(13, 114, 1),
(13, 120, 1),
(13, 121, 1),
(14, 5, 1),
(14, 73, 1),
(15, 1, 1),
(15, 72, 1),
(16, 1, 1),
(16, 5, 1),
(16, 71, 1),
(16, 72, 1),
(16, 73, 1),
(17, 1, 1),
(17, 5, 1),
(17, 71, 1),
(17, 72, 1),
(18, 21, 1),
(19, 1, 1),
(19, 5, 1),
(19, 71, 1),
(19, 72, 1),
(19, 73, 1),
(20, 1, 1),
(20, 5, 1),
(20, 71, 1),
(20, 72, 1),
(21, 9, 1),
(22, 10, 1),
(23, 22, 1),
(24, 12, 1),
(25, 11, 1),
(25, 13, 1),
(26, 14, 1),
(27, 23, 1),
(28, 23, 1),
(28, 30, 1),
(28, 70, 1),
(30, 25, 1),
(32, 28, 1),
(32, 29, 1),
(33, 28, 1),
(34, 29, 1),
(35, 29, 1),
(36, 29, 1),
(38, 38, 1),
(40, 39, 1),
(44, 9, 1),
(44, 71, 1),
(45, 69, 1),
(46, 70, 1),
(48, 112, 1),
(49, 113, 1),
(50, 114, 1);

-- --------------------------------------------------------

--
-- Table structure for table `c71po_users`
--

CREATE TABLE `c71po_users` (
  `username` varchar(25) NOT NULL,
  `password` char(32) NOT NULL,
  `privileges` varchar(25) NOT NULL,
  `homepage` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `c71po_users`
--

INSERT INTO `c71po_users` (`username`, `password`, `privileges`, `homepage`) VALUES
('admin', '031a0911b5e1154f2a9395d1f478a9db', 'admin', 'EG256AM-AZ137PW.php'),
('attilio', 'bf15c525d90baf4f1a7ad47e63bb2e28', '', 'EG256AM-AZ137PW.php'),
('bevande', '023a0c5e7fa7aedc36fa6bedb68ab15d', 'bevande', 'bevande.php'),
('cassa', '117fdffa6a474d6ed8c3453a99a3afea', 'cassa', 'index-cassa.php'),
('cucina', '0229dba2504cab44208d1097a2527f95', 'cucina', 'cucina.php'),
('distribuzione', '5fe3382afd6c8de58ab4361da3d43ad1', 'distribuzione', 'distribuzione.php'),
('fredda', 'cc8db6212ab90ff953aed9ac446ec0fd', 'fredda', 'cucina-fredda.php'),
('griglia', '061da95281bdf422c53ae632ea22d570', 'griglia', 'griglie.php'),
('paninoteca', 'd2e279fba797750c7c820fdaad4544c3', 'paninoteca', 'paninoteca.php'),
('sara', 'e19f878e7e9ec3e4bc8be110c90e2c43', 'sara', 'sara.php');

-- --------------------------------------------------------

--
-- Table structure for table `c71po_varianti`
--

CREATE TABLE `c71po_varianti` (
  `codice_alimento` int(3) UNSIGNED NOT NULL,
  `codice_piatto` int(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `c71po_varianti`
--

INSERT INTO `c71po_varianti` (`codice_alimento`, `codice_piatto`) VALUES
(9, 23),
(10, 23),
(11, 23),
(12, 23),
(16, 72),
(16, 73),
(17, 1),
(17, 5),
(17, 71),
(19, 71),
(19, 72),
(19, 73),
(20, 1),
(20, 5),
(20, 71);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `c71po_alimentari`
--
ALTER TABLE `c71po_alimentari`
  ADD PRIMARY KEY (`codice`);

--
-- Indexes for table `c71po_bevande`
--
ALTER TABLE `c71po_bevande`
  ADD PRIMARY KEY (`tipo`);

--
-- Indexes for table `c71po_casse`
--
ALTER TABLE `c71po_casse`
  ADD PRIMARY KEY (`id_cassa`);

--
-- Indexes for table `c71po_griglie`
--
ALTER TABLE `c71po_griglie`
  ADD PRIMARY KEY (`tipo`);

--
-- Indexes for table `c71po_ordini`
--
ALTER TABLE `c71po_ordini`
  ADD PRIMARY KEY (`id_ordine`),
  ADD KEY `cassa` (`cassa`);

--
-- Indexes for table `c71po_ordini_composizione`
--
ALTER TABLE `c71po_ordini_composizione`
  ADD PRIMARY KEY (`id_ordine`,`id_piatto`,`var`),
  ADD KEY `id_piatto` (`id_piatto`);

--
-- Indexes for table `c71po_piatti`
--
ALTER TABLE `c71po_piatti`
  ADD PRIMARY KEY (`codice`);

--
-- Indexes for table `c71po_piatti_composizione`
--
ALTER TABLE `c71po_piatti_composizione`
  ADD PRIMARY KEY (`cod_alimentari`,`cod_piatto`),
  ADD KEY `cod_piatto` (`cod_piatto`);

--
-- Indexes for table `c71po_users`
--
ALTER TABLE `c71po_users`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `c71po_varianti`
--
ALTER TABLE `c71po_varianti`
  ADD PRIMARY KEY (`codice_alimento`,`codice_piatto`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `c71po_alimentari`
--
ALTER TABLE `c71po_alimentari`
  MODIFY `codice` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `c71po_casse`
--
ALTER TABLE `c71po_casse`
  MODIFY `id_cassa` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;
--
-- AUTO_INCREMENT for table `c71po_ordini`
--
ALTER TABLE `c71po_ordini`
  MODIFY `id_ordine` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `c71po_piatti`
--
ALTER TABLE `c71po_piatti`
  MODIFY `codice` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
