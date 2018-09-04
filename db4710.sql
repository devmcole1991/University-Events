-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 18, 2017 at 03:38 AM
-- Server version: 5.6.34-log
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db4710`
--

-- --------------------------------------------------------

--
-- Table structure for table `affiliated`
--

CREATE TABLE IF NOT EXISTS `affiliated` (
  `userID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `approvespriv`
--

CREATE TABLE IF NOT EXISTS `approvespriv` (
  `eventId` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `approvespub`
--

CREATE TABLE IF NOT EXISTS `approvespub` (
  `eventId` int(11) NOT NULL DEFAULT '0',
  `userID` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `commentinfo`
--

CREATE TABLE IF NOT EXISTS `commentinfo` (
  `commentId` int(11) NOT NULL,
  `commentString` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `userID` int(11) NOT NULL,
  `commentId` int(11) NOT NULL,
  `eventId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `creates`
--

CREATE TABLE IF NOT EXISTS `creates` (
  `name` varchar(100) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `eventId` int(11) NOT NULL,
  `eventName` varchar(100) DEFAULT NULL,
  `category` varchar(20) DEFAULT NULL,
  `eventDescription` varchar(1000) DEFAULT NULL,
  `time` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  `phoneNo` varchar(13) DEFAULT NULL,
  `eventEmail` varchar(50) DEFAULT NULL,
  `privacy` varchar(15) DEFAULT NULL,
  `locationName` varchar(50) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(10,8) DEFAULT NULL,
  `eventImage` longblob,
  `uName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `hosts`
--

CREATE TABLE IF NOT EXISTS `hosts` (
  `userID` int(11) NOT NULL,
  `eventId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `joins`
--

CREATE TABLE IF NOT EXISTS `joins` (
  `userID` int(11) NOT NULL,
  `RSOId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `looksup`
--

CREATE TABLE IF NOT EXISTS `looksup` (
  `userID` int(11) NOT NULL,
  `eventId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `makes`
--

CREATE TABLE IF NOT EXISTS `makes` (
  `userID` int(11) NOT NULL,
  `RSOId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `owns`
--

CREATE TABLE IF NOT EXISTS `owns` (
  `userID` int(11) NOT NULL,
  `RSOId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `privateevent`
--

CREATE TABLE IF NOT EXISTS `privateevent` (
  `eventId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `publicevent`
--

CREATE TABLE IF NOT EXISTS `publicevent` (
  `eventId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rso`
--

CREATE TABLE IF NOT EXISTS `rso` (
  `RSOId` int(11) NOT NULL,
  `RSOName` varchar(30) DEFAULT NULL,
  `RSODescription` varchar(1000) DEFAULT NULL,
  `membersNo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rsoevent`
--

CREATE TABLE IF NOT EXISTS `rsoevent` (
  `eventId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `universityprofile`
--

CREATE TABLE IF NOT EXISTS `universityprofile` (
  `name` varchar(100) NOT NULL,
  `location` varchar(50) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `studentNo` int(11) DEFAULT NULL,
  `image` longblob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `useradmin`
--

CREATE TABLE IF NOT EXISTS `useradmin` (
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userPass` varchar(50) DEFAULT NULL,
  `userStatus` enum('Y','N') NOT NULL DEFAULT 'N',
  `tokenCode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `userstudent`
--

CREATE TABLE IF NOT EXISTS `userstudent` (
  `userID` int(11) NOT NULL,
  `university` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usersuperadmin`
--

CREATE TABLE IF NOT EXISTS `usersuperadmin` (
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `affiliated`
--
ALTER TABLE `affiliated`
  ADD PRIMARY KEY (`userID`,`name`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `approvespriv`
--
ALTER TABLE `approvespriv`
  ADD PRIMARY KEY (`eventId`,`userID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `approvespub`
--
ALTER TABLE `approvespub`
  ADD PRIMARY KEY (`eventId`,`userID`),
  ADD KEY `userId` (`userID`);

--
-- Indexes for table `commentinfo`
--
ALTER TABLE `commentinfo`
  ADD PRIMARY KEY (`commentId`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`userID`,`commentId`,`eventId`),
  ADD KEY `commentId` (`commentId`),
  ADD KEY `eventId` (`eventId`);

--
-- Indexes for table `creates`
--
ALTER TABLE `creates`
  ADD PRIMARY KEY (`name`,`userID`),
  ADD KEY `userId` (`userID`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`eventId`);

--
-- Indexes for table `hosts`
--
ALTER TABLE `hosts`
  ADD PRIMARY KEY (`userID`,`eventId`),
  ADD KEY `eventId` (`eventId`);

--
-- Indexes for table `joins`
--
ALTER TABLE `joins`
  ADD PRIMARY KEY (`userID`,`RSOId`),
  ADD KEY `RSOId` (`RSOId`);

--
-- Indexes for table `looksup`
--
ALTER TABLE `looksup`
  ADD PRIMARY KEY (`userID`,`eventId`),
  ADD KEY `eventId` (`eventId`);

--
-- Indexes for table `makes`
--
ALTER TABLE `makes`
  ADD PRIMARY KEY (`userID`,`RSOId`),
  ADD KEY `RSOId` (`RSOId`);

--
-- Indexes for table `owns`
--
ALTER TABLE `owns`
  ADD PRIMARY KEY (`userID`,`RSOId`),
  ADD KEY `owns_ibfk_2` (`RSOId`);

--
-- Indexes for table `privateevent`
--
ALTER TABLE `privateevent`
  ADD PRIMARY KEY (`eventId`);

--
-- Indexes for table `publicevent`
--
ALTER TABLE `publicevent`
  ADD PRIMARY KEY (`eventId`);

--
-- Indexes for table `rso`
--
ALTER TABLE `rso`
  ADD PRIMARY KEY (`RSOId`),
  ADD UNIQUE KEY `RSOName` (`RSOName`);

--
-- Indexes for table `rsoevent`
--
ALTER TABLE `rsoevent`
  ADD PRIMARY KEY (`eventId`);

--
-- Indexes for table `universityprofile`
--
ALTER TABLE `universityprofile`
  ADD PRIMARY KEY (`name`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `useradmin`
--
ALTER TABLE `useradmin`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userName` (`userName`),
  ADD UNIQUE KEY `userEmail` (`userEmail`);

--
-- Indexes for table `userstudent`
--
ALTER TABLE `userstudent`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `usersuperadmin`
--
ALTER TABLE `usersuperadmin`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commentinfo`
--
ALTER TABLE `commentinfo`
  MODIFY `commentId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `eventId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rso`
--
ALTER TABLE `rso`
  MODIFY `RSOId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `affiliated`
--
ALTER TABLE `affiliated`
  ADD CONSTRAINT `affiliated_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `useradmin` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `affiliated_ibfk_2` FOREIGN KEY (`name`) REFERENCES `universityprofile` (`name`) ON DELETE CASCADE;

--
-- Constraints for table `approvespriv`
--
ALTER TABLE `approvespriv`
  ADD CONSTRAINT `approvespriv_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `privateevent` (`eventId`) ON DELETE CASCADE,
  ADD CONSTRAINT `approvespriv_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `usersuperadmin` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `approvespub`
--
ALTER TABLE `approvespub`
  ADD CONSTRAINT `approvespub_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `publicevent` (`eventId`) ON DELETE CASCADE,
  ADD CONSTRAINT `approvespub_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `usersuperadmin` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`commentId`) REFERENCES `commentinfo` (`commentId`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`eventId`) REFERENCES `event` (`eventId`) ON DELETE CASCADE;

--
-- Constraints for table `creates`
--
ALTER TABLE `creates`
  ADD CONSTRAINT `creates_ibfk_1` FOREIGN KEY (`name`) REFERENCES `universityprofile` (`name`) ON DELETE CASCADE,
  ADD CONSTRAINT `creates_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `usersuperadmin` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `hosts`
--
ALTER TABLE `hosts`
  ADD CONSTRAINT `hosts_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `useradmin` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `hosts_ibfk_2` FOREIGN KEY (`eventId`) REFERENCES `event` (`eventId`) ON DELETE CASCADE;

--
-- Constraints for table `joins`
--
ALTER TABLE `joins`
  ADD CONSTRAINT `joins_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `userstudent` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `joins_ibfk_2` FOREIGN KEY (`RSOId`) REFERENCES `rso` (`RSOId`) ON DELETE CASCADE;

--
-- Constraints for table `looksup`
--
ALTER TABLE `looksup`
  ADD CONSTRAINT `looksup_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `userstudent` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `looksup_ibfk_2` FOREIGN KEY (`eventId`) REFERENCES `event` (`eventId`) ON DELETE CASCADE;

--
-- Constraints for table `makes`
--
ALTER TABLE `makes`
  ADD CONSTRAINT `makes_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `userstudent` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `makes_ibfk_2` FOREIGN KEY (`RSOId`) REFERENCES `rso` (`RSOId`) ON DELETE CASCADE;

--
-- Constraints for table `owns`
--
ALTER TABLE `owns`
  ADD CONSTRAINT `owns_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `useradmin` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `owns_ibfk_2` FOREIGN KEY (`RSOId`) REFERENCES `rso` (`RSOId`) ON DELETE CASCADE;

--
-- Constraints for table `privateevent`
--
ALTER TABLE `privateevent`
  ADD CONSTRAINT `privateevent_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `event` (`eventId`) ON DELETE CASCADE;

--
-- Constraints for table `publicevent`
--
ALTER TABLE `publicevent`
  ADD CONSTRAINT `publicevent_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `event` (`eventId`) ON DELETE CASCADE;

--
-- Constraints for table `rsoevent`
--
ALTER TABLE `rsoevent`
  ADD CONSTRAINT `rsoevent_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `event` (`eventId`) ON DELETE CASCADE;

--
-- Constraints for table `useradmin`
--
ALTER TABLE `useradmin`
  ADD CONSTRAINT `useradmin_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `userstudent`
--
ALTER TABLE `userstudent`
  ADD CONSTRAINT `userstudent_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `usersuperadmin`
--
ALTER TABLE `usersuperadmin`
  ADD CONSTRAINT `usersuperadmin_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
