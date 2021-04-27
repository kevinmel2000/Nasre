-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 07, 2019 at 01:47 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `urbem_digital`
--

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE `timezones` (
  `id` varchar(9) NOT NULL,
  `name` varchar(31) DEFAULT NULL,
  `utc` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`id`, `name`, `utc`) VALUES
('1', 'Dateline Standard Time', '-12:00'),
('10', 'Pacific Standard Time', '-07:00'),
('100', 'China Standard Time', '+08:00'),
('101', 'North Asia East Standard Time', '+08:00'),
('102', 'Singapore Standard Time', '+08:00'),
('103', 'W. Australia Standard Time', '+08:00'),
('104', 'Taipei Standard Time', '+08:00'),
('105', 'Ulaanbaatar Standard Time', '+08:00'),
('106', 'North Korea Standard Time', '+08:30'),
('107', 'Aus Central W. Standard Time', '+08:45'),
('108', 'Transbaikal Standard Time', '+09:00'),
('109', 'Tokyo Standard Time', '+09:00'),
('11', 'US Mountain Standard Time', '-07:00'),
('110', 'Korea Standard Time', '+09:00'),
('111', 'Yakutsk Standard Time', '+09:00'),
('112', 'Cen. Australia Standard Time', '+09:30'),
('113', 'AUS Central Standard Time', '+09:30'),
('114', 'E. Australia Standard Time', '+10:00'),
('115', 'AUS Eastern Standard Time', '+10:00'),
('116', 'West Pacific Standard Time', '+10:00'),
('117', 'Tasmania Standard Time', '+10:00'),
('118', 'Vladivostok Standard Time', '+10:00'),
('119', 'Lord Howe Standard Time', '+10:30'),
('12', 'Mountain Standard Time (Mexico)', '-06:00'),
('120', 'Bougainville Standard Time', '+11:00'),
('121', 'Russia Time Zone 10', '+11:00'),
('122', 'Magadan Standard Time', '+11:00'),
('123', 'Norfolk Standard Time', '+11:00'),
('124', 'Sakhalin Standard Time', '+11:00'),
('125', 'Central Pacific Standard Time', '+11:00'),
('126', 'Russia Time Zone 11', '+12:00'),
('127', 'New Zealand Standard Time', '+12:00'),
('128', 'UTC+12', '+12:00'),
('129', 'Fiji Standard Time', '+12:00'),
('13', 'Mountain Standard Time', '-06:00'),
('130', 'Kamchatka Standard Time', '+13:00'),
('131', 'Chatham Islands Standard Time', '+12:45'),
('132', 'UTC+13', '+13:00'),
('133', 'Tonga Standard Time', '+13:00'),
('134', 'Samoa Standard Time', '+13:00'),
('135', 'Line Islands Standard Time', '+14:00'),
('14', 'Central America Standard Time', '-06:00'),
('15', 'Central Standard Time', '-05:00'),
('16', 'Easter Island Standard Time', '-05:00'),
('17', 'Central Standard Time (Mexico)', '-05:00'),
('18', 'Canada Central Standard Time', '-06:00'),
('19', 'SA Pacific Standard Time', '-05:00'),
('2', 'UTC-11', '-11:00'),
('20', 'Eastern Standard Time (Mexico)', '-05:00'),
('21', 'Eastern Standard Time', '-04:00'),
('22', 'Haiti Standard Time', '-04:00'),
('23', 'Cuba Standard Time', '-04:00'),
('24', 'US Eastern Standard Time', '-04:00'),
('25', 'Paraguay Standard Time', '-04:00'),
('26', 'Atlantic Standard Time', '-03:00'),
('27', 'Venezuela Standard Time', '-04:00'),
('28', 'Central Brazilian Standard Time', '-04:00'),
('29', 'SA Western Standard Time', '-04:00'),
('3', 'Aleutian Standard Time', '-09:00'),
('30', 'Pacific SA Standard Time', '-03:00'),
('31', 'Turks And Caicos Standard Time', '-04:00'),
('32', 'Newfoundland Standard Time', '-02:30'),
('33', 'Tocantins Standard Time', '-03:00'),
('34', 'E. South America Standard Time', '-03:00'),
('35', 'SA Eastern Standard Time', '-03:00'),
('36', 'Argentina Standard Time', '-03:00'),
('37', 'Greenland Standard Time', '-02:00'),
('38', 'Montevideo Standard Time', '-03:00'),
('39', 'Magallanes Standard Time', '-03:00'),
('4', 'Hawaiian Standard Time', '-10:00'),
('40', 'Saint Pierre Standard Time', '-02:00'),
('41', 'Bahia Standard Time', '-03:00'),
('42', 'UTC-02', '-02:00'),
('43', 'Mid-Atlantic Standard Time', '-01:00'),
('44', 'Azores Standard Time', '+00:00'),
('45', 'Cape Verde Standard Time', '-01:00'),
('46', 'UTC', '+00:00'),
('47', 'Morocco Standard Time', '+01:00'),
('48', 'GMT Standard Time', '+01:00'),
('49', 'Greenwich Standard Time', '+00:00'),
('5', 'Marquesas Standard Time', '-09:30'),
('50', 'W. Europe Standard Time', '+02:00'),
('51', 'Central Europe Standard Time', '+02:00'),
('52', 'Romance Standard Time', '+02:00'),
('53', 'Central European Standard Time', '+02:00'),
('54', 'W. Central Africa Standard Time', '+01:00'),
('55', 'Namibia Standard Time', '+01:00'),
('56', 'Jordan Standard Time', '+03:00'),
('57', 'GTB Standard Time', '+03:00'),
('58', 'Middle East Standard Time', '+03:00'),
('59', 'Egypt Standard Time', '+02:00'),
('6', 'Alaskan Standard Time', '-08:00'),
('60', 'E. Europe Standard Time', '+03:00'),
('61', 'Syria Standard Time', '+03:00'),
('62', 'West Bank Standard Time', '+03:00'),
('63', 'South Africa Standard Time', '+02:00'),
('64', 'FLE Standard Time', '+03:00'),
('65', 'Israel Standard Time', '+03:00'),
('66', 'Kaliningrad Standard Time', '+02:00'),
('67', 'Libya Standard Time', '+02:00'),
('68', 'Arabic Standard Time', '+03:00'),
('69', 'Turkey Standard Time', '+03:00'),
('7', 'UTC-09', '-09:00'),
('70', 'Arab Standard Time', '+03:00'),
('71', 'Belarus Standard Time', '+03:00'),
('72', 'Russian Standard Time', '+03:00'),
('73', 'E. Africa Standard Time', '+03:00'),
('74', 'Iran Standard Time', '+04:30'),
('75', 'Arabian Standard Time', '+04:00'),
('76', 'Astrakhan Standard Time', '+04:00'),
('77', 'Azerbaijan Standard Time', '+04:00'),
('78', 'Russia Time Zone 3', '+04:00'),
('79', 'Mauritius Standard Time', '+04:00'),
('8', 'Pacific Standard Time (Mexico)', '-07:00'),
('80', 'Saratov Standard Time', '+04:00'),
('81', 'Georgian Standard Time', '+04:00'),
('82', 'Caucasus Standard Time', '+04:00'),
('83', 'Afghanistan Standard Time', '+04:30'),
('84', 'West Asia Standard Time', '+05:00'),
('85', 'Ekaterinburg Standard Time', '+05:00'),
('86', 'Pakistan Standard Time', '+05:00'),
('87', 'India Standard Time', '+05:30'),
('88', 'Sri Lanka Standard Time', '+05:30'),
('89', 'Nepal Standard Time', '+05:45'),
('9', 'UTC-08', '-08:00'),
('90', 'Central Asia Standard Time', '+06:00'),
('91', 'Bangladesh Standard Time', '+06:00'),
('92', 'Omsk Standard Time', '+06:00'),
('93', 'Myanmar Standard Time', '+06:30'),
('94', 'SE Asia Standard Time', '+07:00'),
('95', 'Altai Standard Time', '+07:00'),
('96', 'W. Mongolia Standard Time', '+07:00'),
('97', 'North Asia Standard Time', '+07:00'),
('98', 'N. Central Asia Standard Time', '+07:00'),
('99', 'Tomsk Standard Time', '+07:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `timezones`
--
ALTER TABLE `timezones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `COL 1` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
