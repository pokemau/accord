-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2024 at 01:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
(4, 'rentillosa90@gmail.com', 'pokemau', '$2y$10$dkVQoRdVl9uuDB47Ig.13.BQHf0nNw8Tzb5jo3yNK3Q7kFBG.Dm.q', 'user'),
(5, 'jorash@gmail.com', 'Jorash', '$2y$10$pUfnxESxTQJv4QkI.Fg73evCtBvJztn4s5o4dDZwYAekljfo1fbp6', 'user'),
(6, 'jorash2@gmail.com', 'Jorash2', '$2y$10$ExfgYFSIxkZF6kh1sE.XouDZ9GSfHz0lb7z4Mldh0JJEemVYQfAW2', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `tblchannel`
--

CREATE TABLE `tblchannel` (
  `channelID` int(10) NOT NULL,
  `serverID` int(10) NOT NULL,
  `channelname` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblchannel`
--

INSERT INTO `tblchannel` (`channelID`, `serverID`, `channelname`) VALUES
(14, 5, 'general'),
(16, 7, 'general'),
(22, 13, 'general'),
(24, 15, 'general');

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
(5, 5, 'Yahallo'),
(7, 5, 'GameServer'),
(13, 4, 'mau server'),
(15, 4, 'new server');

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
(11, 15, 'new role here', 1, 1),
(12, 15, 'another role', 1, 0);

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
(2, 4, 'pokemau', 'none', '2003-11-08'),
(3, 5, 'Jorash', 'none', '2024-04-01'),
(4, 6, 'Jorash2', 'none', '2024-04-01');

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
(16, 5, 5),
(18, 5, 7),
(24, 4, 13),
(26, 4, 15);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblaccount`
--
ALTER TABLE `tblaccount`
  ADD PRIMARY KEY (`accountID`);

--
-- Indexes for table `tblchannel`
--
ALTER TABLE `tblchannel`
  ADD PRIMARY KEY (`channelID`),
  ADD KEY `server-channel` (`serverID`);

--
-- Indexes for table `tblserver`
--
ALTER TABLE `tblserver`
  ADD PRIMARY KEY (`serverID`),
  ADD KEY `server-owner` (`ownerID`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblaccount`
--
ALTER TABLE `tblaccount`
  MODIFY `accountID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblchannel`
--
ALTER TABLE `tblchannel`
  MODIFY `channelID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tblserver`
--
ALTER TABLE `tblserver`
  MODIFY `serverID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tblserverrole`
--
ALTER TABLE `tblserverrole`
  MODIFY `roleID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `userID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbluserserver`
--
ALTER TABLE `tbluserserver`
  MODIFY `userServerID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblchannel`
--
ALTER TABLE `tblchannel`
  ADD CONSTRAINT `server-channel` FOREIGN KEY (`serverID`) REFERENCES `tblserver` (`serverID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblserver`
--
ALTER TABLE `tblserver`
  ADD CONSTRAINT `server-owner` FOREIGN KEY (`ownerID`) REFERENCES `tblaccount` (`accountID`);

--
-- Constraints for table `tblserverrole`
--
ALTER TABLE `tblserverrole`
  ADD CONSTRAINT `fk_Server_Role` FOREIGN KEY (`serverID`) REFERENCES `tblserver` (`serverID`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
