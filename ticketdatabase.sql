-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2022 at 09:38 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticketdatabase`
--
CREATE DATABASE IF NOT EXISTS `ticketdatabase` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ticketdatabase`;

-- --------------------------------------------------------

--
-- Table structure for table `counter`
--

CREATE TABLE `counter` (
  `counter` varchar(20) NOT NULL,
  `counter_status` varchar(20) DEFAULT NULL CHECK (`counter_status` = 'on' or `counter_status` = 'off' or `counter_status` = 'busy')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `counter`
--

INSERT INTO `counter` (`counter`, `counter_status`) VALUES
('Counter1', 'busy'),
('Counter2', 'on'),
('Counter3', 'off'),
('Counter4', 'off');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `NUM` int(11) NOT NULL,
  `NUM_status` varchar(20) DEFAULT NULL CHECK (`NUM_status` = 'pending' or `NUM_status` = 'serving' or `NUM_status` = 'complete'),
  `counter` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`NUM`, `NUM_status`, `counter`) VALUES
(1, 'complete', 'Counter1'),
(2, 'complete', 'Counter1'),
(3, 'complete', 'Counter1'),
(4, 'complete', 'Counter1'),
(5, 'complete', 'Counter3'),
(6, 'complete', 'Counter4'),
(7, 'complete', 'Counter3'),
(8, 'complete', 'Counter3'),
(9, 'complete', 'Counter1'),
(10, 'complete', 'Counter4'),
(11, 'complete', 'Counter1'),
(12, 'complete', 'Counter1'),
(13, 'serving', 'Counter1'),
(14, 'complete', 'Counter2'),
(15, 'complete', 'Counter2'),
(16, 'pending', NULL),
(17, 'pending', NULL),
(18, 'pending', NULL),
(19, 'pending', NULL),
(20, 'pending', NULL),
(21, 'pending', NULL),
(22, 'pending', NULL),
(23, 'pending', NULL),
(24, 'pending', NULL),
(25, 'pending', NULL),
(26, 'pending', NULL),
(27, 'pending', NULL),
(28, 'pending', NULL),
(29, 'pending', NULL),
(30, 'pending', NULL),
(31, 'pending', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `counter`
--
ALTER TABLE `counter`
  ADD PRIMARY KEY (`counter`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`NUM`),
  ADD KEY `ticket_counter_FK` (`counter`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `NUM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_counter_FK` FOREIGN KEY (`counter`) REFERENCES `counter` (`counter`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
