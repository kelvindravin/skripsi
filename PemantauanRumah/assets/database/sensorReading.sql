-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 10, 2021 at 05:55 PM
-- Server version: 10.3.27-MariaDB-0+deb10u1
-- PHP Version: 7.3.27-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pemantaurumah`
--

-- --------------------------------------------------------

--
-- Table structure for table `sensorReading`
--

CREATE TABLE `sensorReading` (
  `idReading` int(11) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `pengukuran` varchar(128) DEFAULT NULL,
  `sensorPengukur` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sensorReading`
--

INSERT INTO `sensorReading` (`idReading`, `timestamp`, `pengukuran`, `sensorPengukur`) VALUES
(52, '2021-05-06 15:27:56', '65.00', 'humidity'),
(53, '2021-05-06 15:27:56', '26.50', 'temperature'),
(54, '2021-05-06 15:27:56', '0.00', 'LPG'),
(55, '2021-05-06 15:27:56', '0.00', 'Carbon'),
(56, '2021-05-06 15:27:56', '0.00', 'Smoke'),
(57, '2021-05-06 15:27:56', '7.45', 'pH'),
(58, '2021-05-06 15:28:06', '65.00', 'humidity'),
(59, '2021-05-06 15:28:06', '26.50', 'temperature'),
(60, '2021-05-06 15:28:06', '0.00', 'LPG'),
(61, '2021-05-06 15:28:06', '0.00', 'Carbon'),
(62, '2021-05-06 15:28:06', '0.00', 'Smoke'),
(63, '2021-05-06 15:28:06', '7.45', 'pH'),
(64, '2021-05-06 15:29:18', '7.49', 'pH'),
(65, '2021-05-06 15:29:18', '66.00', 'humidity'),
(66, '2021-05-06 15:29:18', '26.50', 'temperature'),
(67, '2021-05-06 15:29:18', '0.00', 'LPG'),
(68, '2021-05-06 15:29:18', '0.00', 'Carbon'),
(69, '2021-05-06 15:29:18', '0.00', 'Smoke'),
(70, '2021-05-06 15:29:29', '7.46', 'pH'),
(71, '2021-05-06 15:29:29', '65.00', 'humidity'),
(72, '2021-05-06 15:29:29', '26.50', 'temperature'),
(73, '2021-05-06 15:29:29', '0.00', 'LPG'),
(74, '2021-05-06 15:29:29', '0.00', 'Carbon'),
(75, '2021-05-06 15:29:29', '0.00', 'Smoke'),
(76, '2021-05-06 15:29:39', '7.47', 'pH'),
(77, '2021-05-06 15:29:39', '65.00', 'humidity'),
(78, '2021-05-06 15:29:39', '26.50', 'temperature'),
(79, '2021-05-06 15:29:39', '0.00', 'LPG'),
(80, '2021-05-06 15:29:39', '0.00', 'Carbon'),
(81, '2021-05-06 15:29:39', '0.00', 'Smoke'),
(82, '2021-05-06 15:29:50', '7.46', 'pH'),
(83, '2021-05-06 15:29:50', '65.00', 'humidity'),
(84, '2021-05-06 15:29:50', '26.50', 'temperature'),
(85, '2021-05-06 15:29:50', '0.00', 'LPG'),
(86, '2021-05-06 15:29:50', '0.00', 'Carbon'),
(87, '2021-05-06 15:29:50', '0.00', 'Smoke'),
(88, '2021-05-06 15:30:01', '7.49', 'pH'),
(89, '2021-05-06 15:30:01', '65.00', 'humidity'),
(90, '2021-05-06 15:30:01', '26.50', 'temperature'),
(91, '2021-05-06 15:30:01', '0.00', 'LPG'),
(92, '2021-05-06 15:30:01', '0.00', 'Carbon'),
(93, '2021-05-06 15:30:01', '0.00', 'Smoke');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sensorReading`
--
ALTER TABLE `sensorReading`
  ADD PRIMARY KEY (`idReading`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sensorReading`
--
ALTER TABLE `sensorReading`
  MODIFY `idReading` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
