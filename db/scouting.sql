-- phpMyAdmin SQL Dump
-- version 4.1.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 23, 2013 at 05:06 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `scouting`
--

-- --------------------------------------------------------

--
-- Table structure for table `alliances`
--

CREATE TABLE IF NOT EXISTS `alliances` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Color` enum('red','blue') DEFAULT NULL,
  `TeamOne` int(11) NOT NULL,
  `TeamTwo` int(11) NOT NULL,
  `TeamThree` int(11) NOT NULL,
  `Points` int(11) NOT NULL,
  `Won` tinyint(1) NOT NULL,
  `QualificationPoints` int(11) NOT NULL,
  `AutonomousPoints` int(11) NOT NULL,
  `ClimbingPoints` int(11) NOT NULL,
  `TeleopPoints` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=382 ;

-- --------------------------------------------------------

--
-- Table structure for table `competitions`
--

CREATE TABLE IF NOT EXISTS `competitions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `City` varchar(64) NOT NULL,
  `State` varchar(20) NOT NULL,
  `Start` date NOT NULL,
  `End` date NOT NULL,
  `Type` enum('district','regional','worlds') NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `competitionteams`
--

CREATE TABLE IF NOT EXISTS `competitionteams` (
  `CompetitionID` int(11) NOT NULL,
  `TeamNumber` smallint(11) unsigned NOT NULL,
  KEY `CompetitionID` (`CompetitionID`),
  KEY `competitionteams_team` (`TeamNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `compteams_view`
--
CREATE TABLE IF NOT EXISTS `compteams_view` (
`Number` smallint(11) unsigned
,`Name` text
,`City` text
,`State` text
,`Country` varchar(50)
,`CompetitionID` int(11)
,`TeamNumber` smallint(11) unsigned
);
-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE IF NOT EXISTS `matches` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CompetitionID` int(11) NOT NULL,
  `Time` varchar(32) NOT NULL,
  `Number` int(11) NOT NULL,
  `RedID` int(11) NOT NULL COMMENT 'red alliance ID',
  `BlueID` int(11) NOT NULL COMMENT 'blue alliance ID',
  `Round` enum('qualification','quarters','semis','finals') NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `CompetitionID` (`CompetitionID`),
  KEY `matches_red` (`RedID`),
  KEY `matches_blue` (`BlueID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `Number` smallint(11) unsigned NOT NULL,
  `Name` text NOT NULL,
  `City` text NOT NULL,
  `State` text NOT NULL,
  `Country` varchar(50) NOT NULL,
  PRIMARY KEY (`Number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure for view `compteams_view`
--
DROP TABLE IF EXISTS `compteams_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `compteams_view` AS select `teams`.`Number` AS `Number`,`teams`.`Name` AS `Name`,`teams`.`City` AS `City`,`teams`.`State` AS `State`,`teams`.`Country` AS `Country`,`competitionteams`.`CompetitionID` AS `CompetitionID`,`competitionteams`.`TeamNumber` AS `TeamNumber` from (`teams` join `competitionteams` on((`competitionteams`.`TeamNumber` = `teams`.`Number`)));

--
-- Constraints for dumped tables
--

--
-- Constraints for table `competitionteams`
--
ALTER TABLE `competitionteams`
  ADD CONSTRAINT `competitionteams_competition` FOREIGN KEY (`CompetitionID`) REFERENCES `competitions` (`ID`),
  ADD CONSTRAINT `competitionteams_team` FOREIGN KEY (`TeamNumber`) REFERENCES `teams` (`Number`);

--
-- Constraints for table `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `matches_blue` FOREIGN KEY (`BlueID`) REFERENCES `alliances` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `matches_competition` FOREIGN KEY (`CompetitionID`) REFERENCES `competitions` (`ID`),
  ADD CONSTRAINT `matches_red` FOREIGN KEY (`RedID`) REFERENCES `alliances` (`ID`) ON DELETE CASCADE;
