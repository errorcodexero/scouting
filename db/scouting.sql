-- phpMyAdmin SQL Dump
-- version 4.1.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 31, 2013 at 11:20 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `scouting`
--
CREATE DATABASE IF NOT EXISTS `scouting` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `scouting`;

-- --------------------------------------------------------

--
-- Table structure for table `alliances`
--

CREATE TABLE IF NOT EXISTS `alliances` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MatchID` int(11) NOT NULL,
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
  PRIMARY KEY (`ID`),
  KEY `MatchID` (`MatchID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=714 ;

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
-- Table structure for table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `MatchID` int(11) NOT NULL,
  `TeamNumber` smallint(11) unsigned NOT NULL,
  `Properties` text NOT NULL,
  `Comment` text NOT NULL,
  PRIMARY KEY (`MatchID`,`TeamNumber`),
  KEY `MatchID` (`MatchID`),
  KEY `TeamxNumber` (`TeamNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE IF NOT EXISTS `matches` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CompetitionID` int(11) NOT NULL,
  `Time` varchar(32) NOT NULL,
  `Number` int(11) NOT NULL,
  `Round` enum('qualification','quarters','semis','finals') NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `CompetitionID` (`CompetitionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=177 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `match_alliances`
--
CREATE TABLE IF NOT EXISTS `match_alliances` (
`CompetitionID` int(11)
,`Time` varchar(32)
,`Number` int(11)
,`Round` enum('qualification','quarters','semis','finals')
,`ID` int(11)
,`MatchID` int(11)
,`Color` enum('red','blue')
,`TeamOne` int(11)
,`TeamTwo` int(11)
,`TeamThree` int(11)
,`Points` int(11)
,`Won` tinyint(1)
,`QualificationPoints` int(11)
,`AutonomousPoints` int(11)
,`ClimbingPoints` int(11)
,`TeleopPoints` int(11)
);
-- --------------------------------------------------------

--
-- Table structure for table `robots`
--

CREATE TABLE IF NOT EXISTS `robots` (
  `TeamNumber` smallint(11) unsigned NOT NULL,
  `Role` enum('offensive','defensive','climber') NOT NULL,
  `ShootingLocation` enum('pyramid','fullcourt','climber') NOT NULL,
  `MaxAutonomous` int(11) NOT NULL,
  `MaxClimb` int(11) NOT NULL,
  `Lifter` tinyint(1) NOT NULL,
  `MaxDefensiveHeight` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `StrategyPartner` text NOT NULL,
  `StrategyOpposition` text NOT NULL,
  PRIMARY KEY (`TeamNumber`),
  KEY `Team` (`TeamNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Structure for view `match_alliances`
--
DROP TABLE IF EXISTS `match_alliances`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `match_alliances` AS select `matches`.`CompetitionID` AS `CompetitionID`,`matches`.`Time` AS `Time`,`matches`.`Number` AS `Number`,`matches`.`Round` AS `Round`,`alliances`.`ID` AS `ID`,`alliances`.`MatchID` AS `MatchID`,`alliances`.`Color` AS `Color`,`alliances`.`TeamOne` AS `TeamOne`,`alliances`.`TeamTwo` AS `TeamTwo`,`alliances`.`TeamThree` AS `TeamThree`,`alliances`.`Points` AS `Points`,`alliances`.`Won` AS `Won`,`alliances`.`QualificationPoints` AS `QualificationPoints`,`alliances`.`AutonomousPoints` AS `AutonomousPoints`,`alliances`.`ClimbingPoints` AS `ClimbingPoints`,`alliances`.`TeleopPoints` AS `TeleopPoints` from (`alliances` join `matches` on((`alliances`.`MatchID` = `matches`.`ID`))) order by `matches`.`CompetitionID`,`matches`.`Number`,`alliances`.`Color`;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alliances`
--
ALTER TABLE `alliances`
  ADD CONSTRAINT `alliances_ibfk_1` FOREIGN KEY (`MatchID`) REFERENCES `matches` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `competitionteams`
--
ALTER TABLE `competitionteams`
  ADD CONSTRAINT `competitionteams_competition` FOREIGN KEY (`CompetitionID`) REFERENCES `competitions` (`ID`),
  ADD CONSTRAINT `competitionteams_team` FOREIGN KEY (`TeamNumber`) REFERENCES `teams` (`Number`);

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_1` FOREIGN KEY (`MatchID`) REFERENCES `matches` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `games_ibfk_2` FOREIGN KEY (`TeamNumber`) REFERENCES `teams` (`Number`);

--
-- Constraints for table `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `matches_competition` FOREIGN KEY (`CompetitionID`) REFERENCES `competitions` (`ID`);

--
-- Constraints for table `robots`
--
ALTER TABLE `robots`
  ADD CONSTRAINT `robots_ibfk_1` FOREIGN KEY (`TeamNumber`) REFERENCES `teams` (`Number`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
