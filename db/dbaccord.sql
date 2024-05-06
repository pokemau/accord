-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2024 at 05:11 PM
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
(6, 'markbaring@gmail.com', 'Mark', '$2y$10$NzoW/053YEkyZywzWLRbEem8sD//6sg/ksFfNDP4Ouei7GSzx6RE2', 'user'),
(7, 'slammkhelmer@gmail.com', 'Slamm', '$2y$10$3koR1mkkP1WDsMl318vhm.k0xG3mrUUihmQ8R4T0bAkaILyr4Psc6', 'user'),
(8, 'charlesdarwin@gmail.com', 'Charles', '$2y$10$Z6LMLAeneuZxOcCbAZ1m2eW/ZpdfFvVBBKomD9psMJVeyUep7KAou', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `tblchannelid`
--

CREATE TABLE `tblchannelid` (
  `ID` int(11) NOT NULL,
  `channelID` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblchannelid`
--

INSERT INTO `tblchannelid` (`ID`, `channelID`) VALUES
(1, 17);

-- --------------------------------------------------------

--
-- Table structure for table `tblmessage`
--

CREATE TABLE `tblmessage` (
  `messageID` int(10) NOT NULL,
  `senderID` int(10) NOT NULL,
  `channelID` int(10) NOT NULL,
  `messageText` varchar(200) NOT NULL,
  `dateTimeSent` datetime NOT NULL,
  `repliedMessageID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblmessage`
--

INSERT INTO `tblmessage` (`messageID`, `senderID`, `channelID`, `messageText`, `dateTimeSent`, `repliedMessageID`) VALUES
(4, 1, 3, 'hihihiha', '2024-05-01 20:43:48', NULL),
(19, 2, 2, 'test', '2024-05-06 21:10:47', NULL),
(24, 2, 1, 'first message!', '2024-05-06 22:26:19', NULL),
(28, 6, 1, 'naunhan jud ko dah!', '2024-05-06 22:31:16', 24),
(29, 6, 1, 'naa raba koy naibgan classmate nato', '2024-05-06 22:31:24', NULL),
(31, 8, 1, 'uy mark! kinsa kaha na?', '2024-05-06 22:35:17', 29),
(32, 7, 1, 'murag kaybaw lagi ko ana hehe', '2024-05-06 22:35:45', NULL),
(33, 2, 1, 'kinsa?', '2024-05-06 22:36:16', NULL),
(34, 7, 1, 'secret ;P', '2024-05-06 22:36:28', NULL),
(35, 2, 1, 'slamm momints', '2024-05-06 22:36:38', NULL),
(36, 2, 2, 'gasolo rako diri', '2024-05-06 22:39:14', NULL),
(37, 2, 2, 'tan awa unsa kadaghan ako messages', '2024-05-06 22:39:21', NULL),
(38, 2, 2, 'maurice tanyeca', '2024-05-06 22:39:32', NULL),
(39, 2, 2, 'ror', '2024-05-06 22:39:53', NULL),
(40, 2, 2, 'ror\n', '2024-05-06 22:41:40', NULL),
(43, 2, 15, 'ako ra usa diri\n', '2024-05-06 22:57:31', NULL),
(44, 2, 16, 'nothing here\n', '2024-05-06 22:57:44', NULL),
(45, 2, 16, 'dasasdda', '2024-05-06 23:00:31', NULL),
(46, 2, 3, 'test', '2024-05-06 23:00:42', NULL),
(50, 2, 15, 'wala ra ni sud kay di ko naning\n', '2024-05-06 23:08:30', NULL),
(51, 2, 16, 'kalimot kog turn in atong math na assignment pero patan awon raman tog videos so wala ra guro to\n', '2024-05-06 23:09:21', NULL),
(52, 2, 15, 'maurice ayaw ni sudla ang server pls\n', '2024-05-06 23:09:46', NULL),
(53, 2, 3, 'pass na ta uy\n', '2024-05-06 23:09:56', NULL),
(54, 2, 3, 'dugaya na diay ani uy\n', '2024-05-06 23:10:09', 4),
(55, 2, 3, 'May 1? sheesh\n', '2024-05-06 23:11:23', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tblprivatechannel`
--

CREATE TABLE `tblprivatechannel` (
  `channelD` int(11) NOT NULL,
  `userID1` int(11) NOT NULL,
  `userID2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(4, 2, 'Yahallo'),
(5, 1, 'test'),
(6, 1, 'server 2'),
(16, 2, 'SchoolServer');

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
(1, 4, 'general'),
(2, 4, 'chat here'),
(3, 5, 'general'),
(4, 6, 'general'),
(15, 16, 'general'),
(16, 16, 'assignment');

-- --------------------------------------------------------

--
-- Table structure for table `tblserverrole`
--

CREATE TABLE `tblserverrole` (
  `roleID` int(7) NOT NULL,
  `serverID` int(7) NOT NULL,
  `roleName` varchar(60) NOT NULL,
  `canEditServer` int(1) NOT NULL,
  `canDeleteServer` int(1) NOT NULL,
  `canCreateChannel` int(1) NOT NULL,
  `canEditChannel` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblserverrole`
--

INSERT INTO `tblserverrole` (`roleID`, `serverID`, `roleName`, `canEditServer`, `canDeleteServer`, `canCreateChannel`, `canEditChannel`) VALUES
(1, 5, 'role1', 1, 1, 1, 1),
(7, 5, 'role2', 1, 0, 0, 0),
(8, 5, 'new', 1, 1, 1, 1);

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
(6, 6, 'MarkieBaringers', 'none', '2003-11-26'),
(7, 7, 'SlummKhulmir', 'none', '2004-06-04'),
(8, 8, 'CharlesDarwin', 'none', '2003-04-24');

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
(4, 2, 4),
(5, 1, 5),
(6, 1, 6),
(7, 2, 5),
(8, 3, 5),
(10, 6, 4),
(11, 7, 4),
(12, 8, 4),
(21, 2, 16),
(22, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbluserserverrole`
--

CREATE TABLE `tbluserserverrole` (
  `userServerRoleID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `roleID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluserserverrole`
--

INSERT INTO `tbluserserverrole` (`userServerRoleID`, `userID`, `roleID`) VALUES
(2, 1, 1),
(3, 2, 1),
(4, 2, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblaccount`
--
ALTER TABLE `tblaccount`
  ADD PRIMARY KEY (`accountID`);

--
-- Indexes for table `tblchannelid`
--
ALTER TABLE `tblchannelid`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblmessage`
--
ALTER TABLE `tblmessage`
  ADD PRIMARY KEY (`messageID`),
  ADD KEY `message-channel` (`channelID`),
  ADD KEY `message-sender` (`senderID`);

--
-- Indexes for table `tblprivatechannel`
--
ALTER TABLE `tblprivatechannel`
  ADD PRIMARY KEY (`channelD`),
  ADD KEY `fk_userid1` (`userID1`),
  ADD KEY `fk_userid2` (`userID2`);

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
-- Indexes for table `tbluserserverrole`
--
ALTER TABLE `tbluserserverrole`
  ADD PRIMARY KEY (`userServerRoleID`),
  ADD KEY `fk_roleid` (`roleID`),
  ADD KEY `fk_userid` (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblaccount`
--
ALTER TABLE `tblaccount`
  MODIFY `accountID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblmessage`
--
ALTER TABLE `tblmessage`
  MODIFY `messageID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `tblserver`
--
ALTER TABLE `tblserver`
  MODIFY `serverID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tblserverrole`
--
ALTER TABLE `tblserverrole`
  MODIFY `roleID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `userID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbluserserver`
--
ALTER TABLE `tbluserserver`
  MODIFY `userServerID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbluserserverrole`
--
ALTER TABLE `tbluserserverrole`
  MODIFY `userServerRoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- Constraints for table `tblprivatechannel`
--
ALTER TABLE `tblprivatechannel`
  ADD CONSTRAINT `fk_userid1` FOREIGN KEY (`userID1`) REFERENCES `tbluser` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userid2` FOREIGN KEY (`userID2`) REFERENCES `tbluser` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`accountID`) REFERENCES `tblaccount` (`accountID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbluserserver`
--
ALTER TABLE `tbluserserver`
  ADD CONSTRAINT `userserver-server` FOREIGN KEY (`serverID`) REFERENCES `tblserver` (`serverID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userserver-user` FOREIGN KEY (`userID`) REFERENCES `tblaccount` (`accountID`);

--
-- Constraints for table `tbluserserverrole`
--
ALTER TABLE `tbluserserverrole`
  ADD CONSTRAINT `fk_roleid` FOREIGN KEY (`roleID`) REFERENCES `tblserverrole` (`roleID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userid` FOREIGN KEY (`userID`) REFERENCES `tbluser` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
