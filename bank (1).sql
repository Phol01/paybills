-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2023 at 11:44 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `userID` int(11) NOT NULL,
  `accNum` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `billMonth` varchar(255) NOT NULL,
  `consumer` varchar(255) NOT NULL,
  `dueDate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `trx_water`
--

CREATE TABLE `trx_water` (
  `trxID` int(11) NOT NULL,
  `billerID` int(11) NOT NULL,
  `merchantID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `accNum` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `accName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `balance` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `name`, `balance`) VALUES
(1, 'Taylor Sheesh', 25000);

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
  ADD PRIMARY KEY (`trxID`);

--
-- Indexes for table `trx_water`
--
ALTER TABLE `trx_water`
  ADD PRIMARY KEY (`trxID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

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
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
