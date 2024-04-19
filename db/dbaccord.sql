-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2024 at 03:42 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbaccord`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblaccount`
--

CREATE TABLE `tblaccount` (
  `accountID` int(7) NOT NULL,
  `emailadd` varchar(60) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` varchar(60) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblaccount`
--

INSERT INTO `tblaccount` (`accountID`, `emailadd`, `username`, `password`, `usertype`) VALUES
(1, 'rentillosa90@gmail.com', 'pokemau', '$2y$10$JksoIDI/X3wceJJ43uNu0O.Ibmrx2GLXN/hmmGx4zq/gkpwzkOiIi', 'user'),
(2, 'jorash@gmail.com', 'Jorash', '$2y$10$LlSMMDXp6YPxQtxdTvMuiewAY9c2rgmts9wyYwvQdIdPxUY8/pB1O', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `tblserver`
--

CREATE TABLE `tblserver` (
  `serverID` int(10) NOT NULL,
  `ownerID` int(10) NOT NULL,
  `servername` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblserver`
--

INSERT INTO `tblserver` (`serverID`, `ownerID`, `servername`) VALUES
(1, 1, 'mau_server'),
(2, 1, 'new mau server'),
(4, 2, 'Yahallo');

-- --------------------------------------------------------

--
-- Table structure for table `tblserverchannel`
--

CREATE TABLE `tblserverchannel` (
  `channelID` int(10) NOT NULL,
  `serverID` int(10) NOT NULL,
  `channelname` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblserverchannel`
--

INSERT INTO `tblserverchannel` (`channelID`, `serverID`, `channelname`) VALUES
(1, 1, 'general'),
(2, 1, 'all-csit'),
(3, 1, 'test'),
(4, 2, 'general'),
(7, 4, 'general'),
(8, 4, 'chat-here'),
(10, 4, 'mudae23');

-- --------------------------------------------------------

--
-- Table structure for table `tblserverrole`
--

CREATE TABLE `tblserverrole` (
  `roleID` int(7) NOT NULL,
  `serverID` int(7) NOT NULL,
  `roleName` varchar(60) NOT NULL,
  `canEditServer` int(1) NOT NULL,
  `canDeleteServer` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblserverrole`
--

INSERT INTO `tblserverrole` (`roleID`, `serverID`, `roleName`, `canEditServer`, `canDeleteServer`) VALUES
(1, 1, 'tset', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `userID` int(7) NOT NULL,
  `accountID` int(7) NOT NULL,
  `displayname` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL DEFAULT 'none',
  `birthdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`userID`, `accountID`, `displayname`, `gender`, `birthdate`) VALUES
(1, 1, 'pokemau', 'none', '2003-11-08'),
(2, 2, 'Jorash', 'none', '2024-04-01');

-- --------------------------------------------------------

--
-- Table structure for table `tbluserserver`
--

CREATE TABLE `tbluserserver` (
  `userServerID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `serverID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluserserver`
--

INSERT INTO `tbluserserver` (`userServerID`, `userID`, `serverID`) VALUES
(1, 1, 1),
(2, 1, 2),
(4, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbluserserverchannel`
--

CREATE TABLE `tbluserserverchannel` (
  `user-serverchannelID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `serverchannelID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluserserverchannel`
--

INSERT INTO `tbluserserverchannel` (`user-serverchannelID`, `userID`, `serverchannelID`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(7, 2, 7),
(8, 2, 8),
(10, 2, 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblaccount`
--
ALTER TABLE `tblaccount`
  ADD PRIMARY KEY (`accountID`);

--
-- Indexes for table `tblserver`
--
ALTER TABLE `tblserver`
  ADD PRIMARY KEY (`serverID`),
  ADD KEY `server-owner` (`ownerID`);

--
-- Indexes for table `tblserverchannel`
--
ALTER TABLE `tblserverchannel`
  ADD PRIMARY KEY (`channelID`),
  ADD KEY `server-channel` (`serverID`);

--
-- Indexes for table `tblserverrole`
--
ALTER TABLE `tblserverrole`
  ADD PRIMARY KEY (`roleID`),
  ADD KEY `fk_Server_Role` (`serverID`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `fk_user` (`accountID`);

--
-- Indexes for table `tbluserserver`
--
ALTER TABLE `tbluserserver`
  ADD PRIMARY KEY (`userServerID`),
  ADD KEY `userserver-user` (`userID`),
  ADD KEY `userserver-server` (`serverID`);

--
-- Indexes for table `tbluserserverchannel`
--
ALTER TABLE `tbluserserverchannel`
  ADD PRIMARY KEY (`user-serverchannelID`),
  ADD KEY `fk-user` (`userID`),
  ADD KEY `fk-serverchannel` (`serverchannelID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblaccount`
--
ALTER TABLE `tblaccount`
  MODIFY `accountID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblserver`
--
ALTER TABLE `tblserver`
  MODIFY `serverID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblserverchannel`
--
ALTER TABLE `tblserverchannel`
  MODIFY `channelID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tblserverrole`
--
ALTER TABLE `tblserverrole`
  MODIFY `roleID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `userID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbluserserver`
--
ALTER TABLE `tbluserserver`
  MODIFY `userServerID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbluserserverchannel`
--
ALTER TABLE `tbluserserverchannel`
  MODIFY `user-serverchannelID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblserver`
--
ALTER TABLE `tblserver`
  ADD CONSTRAINT `server-owner` FOREIGN KEY (`ownerID`) REFERENCES `tbluser` (`userID`);

--
-- Constraints for table `tblserverchannel`
--
ALTER TABLE `tblserverchannel`
  ADD CONSTRAINT `server-channel` FOREIGN KEY (`serverID`) REFERENCES `tblserver` (`serverID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblserverrole`
--
ALTER TABLE `tblserverrole`
  ADD CONSTRAINT `fk_Server_Role` FOREIGN KEY (`serverID`) REFERENCES `tblserver` (`serverID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`accountID`) REFERENCES `tblaccount` (`accountID`);

--
-- Constraints for table `tbluserserver`
--
ALTER TABLE `tbluserserver`
  ADD CONSTRAINT `userserver-server` FOREIGN KEY (`serverID`) REFERENCES `tblserver` (`serverID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userserver-user` FOREIGN KEY (`userID`) REFERENCES `tblaccount` (`accountID`);

--
-- Constraints for table `tbluserserverchannel`
--
ALTER TABLE `tbluserserverchannel`
  ADD CONSTRAINT `fk-serverchannel` FOREIGN KEY (`serverchannelID`) REFERENCES `tblserverchannel` (`channelID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-user` FOREIGN KEY (`userID`) REFERENCES `tblaccount` (`accountID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
