-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2019 at 12:07 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `logilotto_game`
--

-- --------------------------------------------------------

--
-- Table structure for table `bets`
--

CREATE TABLE `bets` (
  `betID` int(11) NOT NULL,
  `placedDate` datetime NOT NULL,
  `clientID` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `stakeAmount` float NOT NULL,
  `winAmount` float DEFAULT NULL,
  `numbers` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bets`
--

INSERT INTO `bets` (`betID`, `placedDate`, `clientID`, `status`, `stakeAmount`, `winAmount`, `numbers`) VALUES
(23, '2019-03-01 11:49:08', 1, -1, 34, -34, '1 2 3 4 5 6 7'),
(24, '2019-03-01 11:54:17', 1, -1, 34, -34, '1 2 3 4 5 6 7'),
(25, '2019-03-01 11:54:21', 1, -1, 66, -66, '1 2 3 4 5 6 7');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `clientID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `balance` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`clientID`, `name`, `balance`) VALUES
(1, 'Djordje', 737),
(3, 'Jovica', 50),
(4, 'Pera', 110);

-- --------------------------------------------------------

--
-- Table structure for table `draws`
--

CREATE TABLE `draws` (
  `drawID` int(11) NOT NULL,
  `number_01` int(11) NOT NULL,
  `number_02` int(11) NOT NULL,
  `number_03` int(11) NOT NULL,
  `number_04` int(11) NOT NULL,
  `number_05` int(11) NOT NULL,
  `number_06` int(11) NOT NULL,
  `number_07` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `draws`
--

INSERT INTO `draws` (`drawID`, `number_01`, `number_02`, `number_03`, `number_04`, `number_05`, `number_06`, `number_07`) VALUES
(38, 12, 30, 11, 54, 56, 39, 37),
(39, 26, 36, 52, 34, 14, 55, 29),
(40, 38, 29, 22, 39, 16, 44, 40),
(41, 46, 12, 13, 27, 40, 7, 34),
(42, 14, 32, 56, 39, 35, 27, 36),
(43, 53, 52, 23, 2, 35, 42, 15),
(44, 7, 35, 10, 46, 59, 44, 15),
(45, 44, 40, 46, 12, 54, 5, 8),
(46, 30, 9, 15, 35, 40, 26, 45),
(47, 12, 12, 11, 28, 21, 8, 12);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `betID` int(11) NOT NULL,
  `drawID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`betID`, `drawID`) VALUES
(3, 0),
(4, 0),
(5, 0),
(6, 1),
(7, 2),
(8, 3),
(9, 4),
(10, 5),
(11, 6),
(11, 25),
(11, 26),
(11, 27),
(12, 7),
(12, 25),
(12, 26),
(12, 27),
(13, 8),
(14, 24),
(23, 40),
(24, 45),
(24, 46),
(24, 47),
(25, 45),
(25, 46),
(25, 47);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bets`
--
ALTER TABLE `bets`
  ADD PRIMARY KEY (`betID`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`clientID`);

--
-- Indexes for table `draws`
--
ALTER TABLE `draws`
  ADD PRIMARY KEY (`drawID`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`betID`,`drawID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bets`
--
ALTER TABLE `bets`
  MODIFY `betID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `clientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `draws`
--
ALTER TABLE `draws`
  MODIFY `drawID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
