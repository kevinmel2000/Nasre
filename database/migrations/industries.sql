-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 18, 2020 at 04:25 AM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shinoycrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `industries`
--

CREATE TABLE `industries` (
  `id` int(255) NOT NULL,
  `name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `industries`
--

INSERT INTO `industries` (`id`, `name`) VALUES
(1, 'AEROSPACE'),
(2, 'AGRICULTURE AND ALLIED INDUSTRIES'),
(3, 'AUTOMOBILES'),
(4, 'AUTO COMPONENTS'),
(5, 'AVIATION'),
(6, 'BANKING'),
(7, 'CEMENT'),
(8, 'CONSUMER DURABLES'),
(9, 'ECOMMERCE'),
(10, 'EDUCATION AND TRAINING'),
(11, 'ENERGY'),
(12, 'ENGINEERING AND CAPITAL GOODS'),
(13, 'FINANCIAL SERVICES'),
(14, 'FOOD'),
(15, 'GEMS AND JEWELLERY'),
(16, 'HEALTHCARE'),
(17, 'INFRASTRUCTURE'),
(18, 'INSURANCE'),
(19, 'IT HARDWARE'),
(20, 'IT SOFTWARE'),
(21, 'MANUFACTURING'),
(22, 'MEDIA AND ENTERTAINMENT'),
(23, 'METALS AND MINING'),
(24, 'OIL AND GAS'),
(25, 'PHARMACEUTICALS'),
(26, 'PORTS'),
(27, 'POWER'),
(28, 'RAILWAYS'),
(29, 'REAL ESTATE'),
(30, 'RENEWABLE ENERGY'),
(31, 'RETAIL'),
(32, 'ROADS'),
(33, 'SCIENCE AND TECHNOLOGY'),
(34, 'SERVICES'),
(35, 'STEEL'),
(36, 'TELECOMMUNICATIONS'),
(37, 'TEXTILES'),
(38, 'TOURISM AND HOSPITALITY'),
(39, 'TRANSPORT'),
(40, 'OTHER');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `industries`
--
ALTER TABLE `industries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `industries`
--
ALTER TABLE `industries`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
