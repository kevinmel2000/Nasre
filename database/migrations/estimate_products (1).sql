-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 22, 2020 at 05:09 AM
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

--
-- Dumping data for table `estimate_products`
--

INSERT INTO `estimate_products` (`id`, `estimate_id`, `product_name`, `product_price`, `product_qty`, `product_tax`, `product_amount`, `created_at`, `updated_at`) VALUES
(1, 1, 'Product Two', '990', '1', '0', '990.00', '2020-07-21 06:17:38', '2020-07-21 06:17:38'),
(2, 1, 'Product One', '99', '1', '0', '99.00', '2020-07-21 06:17:38', '2020-07-21 06:17:38'),
(3, 2, 'Product One', '99', '1', '0', '99.00', '2020-07-22 05:08:39', '2020-07-22 05:08:39');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
