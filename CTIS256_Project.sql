-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 14, 2022 at 06:34 PM
-- Server version: 5.7.34
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `CTIS256_Project`
--

-- --------------------------------------------------------

--
-- Table structure for table `Cart`
--

CREATE TABLE `Cart` (
  `id` int(3) NOT NULL,
  `title` varchar(100) NOT NULL,
  `count` int(3) NOT NULL,
  `normalPrice` decimal(5,2) NOT NULL,
  `expirationDate` date NOT NULL,
  `expirationImage` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE `Products` (
  `id` int(4) NOT NULL,
  `title` varchar(100) NOT NULL,
  `stock` int(7) NOT NULL,
  `normalPrice` decimal(5,2) NOT NULL,
  `expirationDate` date NOT NULL,
  `expirationImage` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Products`
--

INSERT INTO `Products` (`id`, `title`, `stock`, `normalPrice`, `expirationDate`, `expirationImage`) VALUES
(1, 'Cucumbers', 5192, '0.43', '2022-05-30', 'cucumber.png'),
(2, 'Dimes Ananas Suyu', 40, '4.35', '2022-05-25', 'ananas.png'),
(3, 'GOLD STANDARD SHAKER', 19, '49.00', '2032-05-31', 'shaker.png'),
(4, 'LG AKB73715686 - TV Remote', 219, '49.99', '2028-05-10', 'remote.png'),
(5, 'Logitech M238 Wireless Mouse', 99, '99.99', '2031-12-18', 'logi.png'),
(6, 'Milka Oreo 130g', 13, '13.99', '2022-06-15', 'milkaOreo.png'),
(7, 'Toblerone 100g', 5123, '12.50', '2022-06-19', 'toblerone.png'),
(8, 'ETİ Kakaolu Bisküvi 125g', 41, '4.50', '2023-03-16', 'kakaolu.png'),
(9, 'PETRA Çekirdek Kahve - Acme 250g', 7, '89.90', '2022-05-28', 'petra.png'),
(10, 'Starbucks Çekirdek Kahve - Atitlan 250g', 4, '35.00', '2023-05-03', 'starbucks.jpeg'),
(11, 'JACOBS Barista Serisi Tanışma Paketi Filtre Kahve 225g x 3', 19, '99.00', '2022-11-16', 'jacobs.png'),
(12, 'SPADA COFFEE Çekirdek Kahve - Colombia/Huila 250g', 4, '92.00', '2026-10-14', 'spada.png'),
(13, 'MSI Vigor GK30 Mekanik Klavye', 3, '219.50', '2032-05-31', 'vigor.png'),
(17, 'NFL LOGO Hoodie', 6, '360.00', '2032-05-31', 'nflHoodie.png');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int(3) NOT NULL,
  `name` varchar(75) NOT NULL,
  `address` varchar(150) NOT NULL,
  `district` varchar(25) NOT NULL,
  `city` varchar(25) NOT NULL,
  `userType` varchar(15) NOT NULL,
  `email` varchar(75) NOT NULL,
  `hashPassword` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `name`, `address`, `district`, `city`, `userType`, `email`, `hashPassword`) VALUES
(5, 'Altınkaya', 'Hasemek, 1469. Sokak, İvedik OSB', 'Yenimahalle', 'Ankara', 'marketStaff', 'mustafa@altinisik.net', '$2y$10$WCxolUBAS1MfRR41ITWN5uRx6F2y4yoN.ceM0UDmNRjvBPu4jKse2'),
(6, 'Suphi Erkin Karaçay', 'Aşağı Öveçler Mahallesi, Lizbon Caddesi, 1292. Sokak, 5/15', 'Çankaya', 'Ankara', 'customer', 'serkinkaracay@gmail.com', '$2y$10$WgWlIWgwOFrEFlvWsgoaGuPM.CuTmnBmDfq9TQvRIJTuJJIli0swW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Cart`
--
ALTER TABLE `Cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Products`
--
ALTER TABLE `Products`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
