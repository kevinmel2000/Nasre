-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 24, 2020 at 12:52 PM
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
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `short_description`, `long_description`, `price`, `sku`, `discount`, `units`, `tax_type_1`, `tax_type_2`, `tax_type_3`, `product_group_id`, `status`, `created_by_id`, `created_at`, `updated_at`) VALUES
(1, 'Product One', 'Some short description', 'long description', '99', 'DEV34341', '10', '2', '1', '2', '3', 3, 'active', 1, '2020-06-30 02:27:59', '2020-06-30 02:27:59'),
(2, 'Product Two', 'Some short description', 'long description', '99', 'DEV34344', '10', '2', '1', '2', '3', 2, 'active', 1, '2020-06-30 02:27:59', '2020-06-30 02:30:22'),
(3, 'Product Three', 'Some short description', 'long description', '1091', 'DEV34343', '9', '10', '2', '3', '1', 2, 'active', 1, '2020-06-30 02:27:59', '2020-06-30 02:41:08');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
