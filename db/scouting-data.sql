-- phpMyAdmin SQL Dump
-- version 4.1.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 22, 2013 at 06:13 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `scouting`
--

--
-- Dumping data for table `competitions`
--

INSERT INTO `competitions` (`ID`, `Name`, `City`, `State`, `Start`, `End`, `Type`) VALUES
(3, 'Wilsonville District', 'Wilsonville', 'OR', '2014-03-20', '2014-03-22', 'district'),
(4, 'Oregon City District', 'Oregon City', 'OR', '2014-03-06', '2014-03-08', 'district'),
(5, 'Oregon State University District ', 'Corvallis', 'OR', '2014-04-04', '2014-04-05', 'district'),
(6, 'Autodesk PNW FRC Championship', 'Portland', 'OR', '2014-04-10', '2014-04-12', 'regional'),
(7, 'FIRST Championship', 'St Louis', 'MI', '2014-04-23', '2014-04-26', 'worlds'),
(10, 'Portland 2013', 'Portland', 'OR', '2013-03-21', '2013-03-23', 'regional');

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`Number`, `Name`, `City`, `State`, `Country`) VALUES
(360, 'The Revolution', 'Tacoma', 'WA', 'USA'),
(488, 'Team XBot', 'Seattle', 'WA', 'USA'),
(753, 'High Desert Droids', 'Bend', 'OR', 'USA'),
(847, 'PHRED', 'Philomath', 'OR', 'USA'),
(955, 'CV Robotics', 'Corvallis', 'OR', 'USA'),
(956, 'Eagle Cybertechnology', 'Adair Village', 'OR', 'USA'),
(957, 'SWARM', 'Albany', 'OR', 'USA'),
(997, 'Spartan Robotics', 'Corvallis', 'OR', 'USA'),
(1318, 'Issaquah Robotics Society', 'Issaquah', 'WA', 'USA'),
(1359, 'Scalawags', 'Lebanon', 'OR', 'USA'),
(1425, 'Error Code Xero', 'Wilsonville', 'OR', 'USA'),
(1432, 'Mahr''s Metal Beavers', 'Portland', 'OR', 'USA'),
(1510, 'Wildcats', 'Beaverton', 'OR', 'USA'),
(1540, 'Flaming Chickens', 'Portland', 'OR', 'USA'),
(1571, 'Error404', 'Gresham', 'OR', 'USA'),
(1700, 'Gatorbotics', 'Palo Alto', 'CA', 'USA'),
(1823, 'The New Victorians', 'Portland', 'OR', 'USA'),
(2002, 'Tualatin Robotics', 'Tualatin', 'OR', 'USA'),
(2046, 'Bear Metal', 'Maple Valley', 'WA', 'USA'),
(2093, 'Bowtie Brigade', 'Portland', 'OR', 'USA'),
(2130, 'Alpha+', 'Bonners Ferry', 'ID', 'USA'),
(2147, 'CHUCK', 'Spokane', 'WA', 'USA'),
(2192, 'YAK Attack', 'Newport', 'OR', 'USA'),
(2374, 'Crusader Bots', 'Portland', 'OR', 'USA'),
(2411, 'Rebel @lliance', 'Portland', 'OR', 'USA'),
(2471, 'Team Mean Machine', 'Camas', 'WA', 'USA'),
(2517, 'Green Wrenches', 'Vancouver', 'WA', 'USA'),
(2521, 'SERT', 'Eugene', 'OR', 'USA'),
(2542, 'Go4bots', 'Gresham', 'OR', 'USA'),
(2550, 'Skynet', 'Oregon City', 'OR', 'USA'),
(2557, 'SOTAbots', 'Tacoma', 'WA', 'USA'),
(2635, 'Lake Monsters ', 'Lake Oswego', 'OR', 'USA'),
(2733, 'Pigmice', 'Portland', 'OR', 'USA'),
(2811, 'StormBots', 'Vancouver', 'WA', 'USA'),
(2915, 'Riverdale Robotics Pandamonium', 'Portland', 'OR', 'USA'),
(2990, 'Hotwire Aumsville', '', 'OR', 'USA'),
(3024, 'My Favorite Team', 'Ashland', 'OR', 'USA'),
(3131, 'Gladiators', 'Gladstone', 'OR', 'USA'),
(3145, 'TeraViks', 'Coeur d''Alene', 'ID', 'USA'),
(3192, 'Tiger Bytes', 'Tigard', 'OR', 'USA'),
(3574, 'HIGH-TEKERZ', 'Burien', 'WA', 'USA'),
(3636, 'Generals', 'Portland', 'OR', 'USA'),
(3673, 'C.Y.B.O.R.G. Seagulls', 'Seaside', 'OR', 'USA'),
(3674, '4-H Clover Bots', 'Battle Ground', 'WA', 'USA'),
(3711, 'Iron Mustang', 'Trout Lake', 'WA', 'USA'),
(3712, 'RoboCats', 'Union', 'OR', ''),
(3787, 'Wild Robotocats', 'Westport', 'WA', 'USA'),
(3812, 'Bits & Bots', 'Longview', 'WA', 'USA'),
(4043, 'NerdHerd', 'McMinnville', 'OR', 'USA'),
(4051, 'Sabin-Sharks', 'Milwaukie', 'OR', 'USA'),
(4057, 'KB Bots', 'Klamath Falls', 'OR', 'USA'),
(4060, 'S.W.A.G.', 'Chehalis', 'WA', 'USA'),
(4106, 'Bots of Prey', 'Caldwell', 'ID', 'USA'),
(4110, 'DEEP SPACE NINERS', 'Brookings', 'OR', 'USA'),
(4125, 'Confidential', 'Umatilla', 'OR', 'USA'),
(4127, 'LoggerBots', 'Vernonia', 'OR', 'USA'),
(4132, 'Scotbots', 'Portland', 'OR', 'USA'),
(4457, 'ACE', 'Portland', 'OR', 'USA'),
(4488, 'Shockwave', 'Hillsboro', 'OR', 'USA'),
(4662, 'Tribal Tech', 'Scappoose', 'OR', 'USA'),
(5085, 'LakerBots', 'Blachly', 'OR', ''),
(5198, 'RoboKnight Force', 'Grants Pass', 'OR', ''),
(5295, 'Aldernating Current', 'Shelton', 'WA', '');
