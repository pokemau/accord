-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2024 at 05:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
(2, 'jorash@gmail.com', 'Jorash', '$2y$10$LlSMMDXp6YPxQtxdTvMuiewAY9c2rgmts9wyYwvQdIdPxUY8/pB1O', 'user'),
(3, 'jorash2@gmail.com', 'Jorash2', '$2y$10$L4QFfdYaFVXnq7lRZeSmfO7mG.s9nPYoONHwUmbmkOGOqdobcPVqi', 'user'),
(4, 'test@gmail.com', 'Test', '$2y$10$PSd5L6IJxRs.CVLka1lipOwuOiGGd.xbmJ.9bPej4okYbMiXxqVHi', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `tblmessage`
--

CREATE TABLE `tblmessage` (
  `messageID` int(10) NOT NULL,
  `senderID` int(10) NOT NULL,
  `channelID` int(10) NOT NULL,
  `messageText` varchar(200) NOT NULL,
  `dateTimeSent` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblmessage`
--

INSERT INTO `tblmessage` (`messageID`, `senderID`, `channelID`, `messageText`, `dateTimeSent`) VALUES
(9, 2, 27, 'sdadasd', '2024-04-28 12:35:13'),
(10, 2, 27, 'asdasdadad', '2024-04-28 12:35:42'),
(12, 2, 28, 'tester', '2024-04-28 12:35:49'),
(13, 3, 27, 'asda', '2024-04-28 23:32:34'),
(14, 2, 27, 'test', '2024-04-28 23:32:53'),
(15, 2, 27, 'sadsadadvxzcxzczc', '2024-04-28 23:32:57'),
(16, 2, 27, 'hihihiha', '2024-04-28 23:34:37'),
(17, 3, 27, 'okay', '2024-04-28 23:34:50'),
(18, 3, 27, 'sure buddy boy', '2024-04-28 23:35:06'),
(19, 3, 28, '2nd\n', '2024-04-28 23:37:25'),
(20, 2, 28, '1st', '2024-04-28 23:37:39'),
(21, 2, 28, 'sdadsadadd', '2024-04-28 23:37:52'),
(22, 2, 28, 'sadasda', '2024-04-28 23:38:00'),
(23, 2, 28, 'sadasdadasd', '2024-04-28 23:38:05'),
(25, 4, 28, 'sadsadda', '2024-04-28 23:52:50');

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
(19, 2, 'Yahallo'),
(25, 2, 'tester');

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
(27, 19, 'general'),
(28, 19, 'chat-here'),
(33, 19, 'tester'),
(37, 25, 'general');

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
(2, 2, 'Jorash', 'none', '2024-04-01'),
(3, 3, 'Jorash2', 'none', '2024-04-01'),
(4, 4, 'Test', 'none', '0000-00-00');

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
(19, 2, 19),
(25, 2, 25),
(26, 3, 19),
(27, 1, 19),
(28, 4, 19);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblaccount`
--
ALTER TABLE `tblaccount`
  ADD PRIMARY KEY (`accountID`);

--
-- Indexes for table `tblmessage`
--
ALTER TABLE `tblmessage`
  ADD PRIMARY KEY (`messageID`),
  ADD KEY `message-channel` (`channelID`),
  ADD KEY `message-sender` (`senderID`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblaccount`
--
ALTER TABLE `tblaccount`
  MODIFY `accountID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblmessage`
--
ALTER TABLE `tblmessage`
  MODIFY `messageID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tblserver`
--
ALTER TABLE `tblserver`
  MODIFY `serverID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tblserverchannel`
--
ALTER TABLE `tblserverchannel`
  MODIFY `channelID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tblserverrole`
--
ALTER TABLE `tblserverrole`
  MODIFY `roleID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `userID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbluserserver`
--
ALTER TABLE `tbluserserver`
  MODIFY `userServerID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblmessage`
--
ALTER TABLE `tblmessage`
  ADD CONSTRAINT `message-channel` FOREIGN KEY (`channelID`) REFERENCES `tblserverchannel` (`channelID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message-sender` FOREIGN KEY (`senderID`) REFERENCES `tbluser` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
