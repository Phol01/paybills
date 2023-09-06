-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2023 at 09:31 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `biller`
--

CREATE TABLE `biller` (
  `billerID` int(11) NOT NULL,
  `billerCategory` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `biller`
--

INSERT INTO `biller` (`billerID`, `billerCategory`) VALUES
(1, 'Electric Utility'),
(2, 'Water Utility');

-- --------------------------------------------------------

--
-- Table structure for table `merchant`
--

CREATE TABLE `merchant` (
  `merchantID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `merchant`
--

INSERT INTO `merchant` (`merchantID`, `name`) VALUES
(1, 'Batangas Electric 1'),
(2, 'Prime Water Nasugbu');

-- --------------------------------------------------------

--
-- Table structure for table `trx_electricity`
--

CREATE TABLE `trx_electricity` (
  `trxID` int(11) NOT NULL,
  `billerID` int(11) NOT NULL,
  `merchantID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `accNum` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `billMonth` varchar(255) NOT NULL,
  `consumer` varchar(255) NOT NULL,
  `dueDate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trx_water`
--

CREATE TABLE `trx_water` (
  `trxID` int(11) NOT NULL,
  `billerID` int(11) NOT NULL,
  `merchantID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `accNum` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `accName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `balance` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `balance`) VALUES
(5, 'canes', 'canes@gmail.com', '$2y$10$LZKy4/AazTjC0lhgmlKQluFRMRsta7rNxSeZwuYEHCFmz41PSD4zm', NULL),
(8, 'kim', 'kim@gmail.com', '$2y$10$wo10jL/xUQ.WUliZOg3OW.FPpJMLASlEXSX5dIVgrqB576APm3QOy', 584.00),
(9, 'ff', 'ff@gmail.com', '$2y$10$cZD93Ak6bcnoHBZi5l/2ieui1rlCrZ5WNTns12C.0lCWM2bupe3Ci', 999.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `biller`
--
ALTER TABLE `biller`
  ADD PRIMARY KEY (`billerID`);

--
-- Indexes for table `merchant`
--
ALTER TABLE `merchant`
  ADD PRIMARY KEY (`merchantID`);

--
-- Indexes for table `trx_electricity`
--
ALTER TABLE `trx_electricity`
  ADD PRIMARY KEY (`trxID`),
  ADD KEY `billerID` (`billerID`),
  ADD KEY `merchantID` (`merchantID`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `trx_water`
--
ALTER TABLE `trx_water`
  ADD PRIMARY KEY (`trxID`),
  ADD UNIQUE KEY `user_id` (`user_ID`),
  ADD KEY `billerID` (`billerID`),
  ADD KEY `merchantID` (`merchantID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `biller`
--
ALTER TABLE `biller`
  MODIFY `billerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `merchant`
--
ALTER TABLE `merchant`
  MODIFY `merchantID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `trx_electricity`
--
ALTER TABLE `trx_electricity`
  MODIFY `trxID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trx_water`
--
ALTER TABLE `trx_water`
  MODIFY `trxID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `trx_electricity`
--
ALTER TABLE `trx_electricity`
  ADD CONSTRAINT `trx_electricity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trx_electricity_ibfk_2` FOREIGN KEY (`billerID`) REFERENCES `biller` (`billerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trx_electricity_ibfk_3` FOREIGN KEY (`merchantID`) REFERENCES `merchant` (`merchantID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trx_water`
--
ALTER TABLE `trx_water`
  ADD CONSTRAINT `trx_water_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trx_water_ibfk_2` FOREIGN KEY (`billerID`) REFERENCES `biller` (`billerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trx_water_ibfk_3` FOREIGN KEY (`merchantID`) REFERENCES `merchant` (`merchantID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
