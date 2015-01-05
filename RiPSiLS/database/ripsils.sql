-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2014 at 09:16 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ripsils`
--
CREATE DATABASE IF NOT EXISTS `ripsils` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ripsils`;

-- --------------------------------------------------------

--
-- Table structure for table `challenges`
--

DROP TABLE IF EXISTS `challenges`;
CREATE TABLE IF NOT EXISTS `challenges` (
`ID` int(11) unsigned NOT NULL,
  `create_date` int(11) unsigned NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  `expiration_date` int(11) unsigned DEFAULT NULL,
  `challenger_user_ID` int(11) unsigned NOT NULL,
  `challenger_move` tinyint(1) unsigned NOT NULL,
  `challenged_user_ID` int(11) unsigned NOT NULL,
  `challenged_move` tinyint(1) unsigned DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `challenges`
--

INSERT INTO `challenges` (`ID`, `create_date`, `active`, `expiration_date`, `challenger_user_ID`, `challenger_move`, `challenged_user_ID`, `challenged_move`) VALUES
(1, 23062014, 0, 5, 33, 2, 55, 0),
(9, 4294967295, 1, 5, 55, 2, 33, 0),
(10, 4294967295, 1, 7, 55, 5, 33, 0),
(26, 4294967295, 0, 4, 2, 2, 55, 0),
(27, 4294967295, 1, 2, 4, 5, 3, 0),
(28, 4294967295, 0, 1, 4, 4, 1, 5),
(29, 4294967295, 0, 5, 2, 4, 55, 0),
(30, 4294967295, 0, 2, 1, 3, 55, 2),
(31, 4294967295, 0, 2, 1, 5, 33, 4),
(32, 4294967295, 0, 6, 1, 4, 55, 5),
(33, 4294967295, 3, 2, 2, 2, 1, 0),
(34, 4294967295, 2, 1, 1, 3, 2, 5),
(35, 4294967295, 3, 7, 1, 2, 4, 0),
(36, 4294967295, 0, 3, 1, 2, 55, 0),
(37, 4294967295, 0, 1, 1, 5, 55, 0),
(38, 4294967295, 0, 3, 1, 5, 4, 0),
(39, 4294967295, 0, 3, 1, 5, 4, 0),
(40, 4294967295, 0, 3, 1, 5, 4, 0),
(41, 4294967295, 0, 3, 1, 3, 55, 0),
(42, 4294967295, 0, 3, 1, 1, 55, 0),
(43, 4294967295, 1, 3, 55, 1, 2, 0),
(44, 4294967295, 0, 3, 1, 2, 55, 0),
(45, 4294967295, 1, 3, 4, 3, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
CREATE TABLE IF NOT EXISTS `games` (
`ID` int(11) unsigned NOT NULL,
  `challenger_user_ID` int(11) unsigned NOT NULL,
  `challenged_user_ID` int(11) unsigned NOT NULL,
  `winner_user_ID` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `moves`
--

DROP TABLE IF EXISTS `moves`;
CREATE TABLE IF NOT EXISTS `moves` (
`ID` int(11) unsigned NOT NULL,
  `datetime` int(11) unsigned NOT NULL,
  `move` tinyint(1) unsigned NOT NULL,
  `user_ID` int(11) unsigned NOT NULL,
  `game_ID` int(11) unsigned NOT NULL,
  `turn` smallint(2) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
`ID` int(11) unsigned NOT NULL,
  `create_date` int(11) unsigned NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `create_date`, `username`, `password`) VALUES
(1, 123456789, 'Bob', '$2y$10$askTJQK09uKFFgSUKOJ9QO/1MSunJIhmnx3RDeQkTA9bW3.JXaCka'),
(2, 123456789, 'Jan', '$2y$10$askTJQK09uKFFgSUKOJ9QO/1MSunJIhmnx3RDeQkTA9bW3.JXaCka'),
(3, 123456789, 'Pieter', '$2y$10$askTJQK09uKFFgSUKOJ9QO/1MSunJIhmnx3RDeQkTA9bW3.JXaCka'),
(4, 123456789, '12345', '$2y$10$askTJQK09uKFFgSUKOJ9QO/1MSunJIhmnx3RDeQkTA9bW3.JXaCka'),
(33, 23062014, 'Klaas', '$2y$10$askTJQK09uKFFgSUKOJ9QO/1MSunJIhmnx3RDeQkTA9bW3.JXaCka'),
(55, 23062014, 'Henk', '$2y$10$askTJQK09uKFFgSUKOJ9QO/1MSunJIhmnx3RDeQkTA9bW3.JXaCka');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `challenges`
--
ALTER TABLE `challenges`
 ADD PRIMARY KEY (`ID`), ADD KEY `fk_challenges_users_idx` (`challenger_user_ID`), ADD KEY `fk_challenges_users1_idx` (`challenged_user_ID`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
 ADD PRIMARY KEY (`ID`), ADD KEY `fk_games_users1_idx` (`challenger_user_ID`), ADD KEY `fk_games_users2_idx` (`challenged_user_ID`), ADD KEY `fk_games_users3_idx` (`winner_user_ID`);

--
-- Indexes for table `moves`
--
ALTER TABLE `moves`
 ADD PRIMARY KEY (`ID`), ADD KEY `fk_moves_users1_idx` (`user_ID`), ADD KEY `fk_moves_games1_idx` (`game_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `username_UNIQUE` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `challenges`
--
ALTER TABLE `challenges`
MODIFY `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
MODIFY `ID` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `moves`
--
ALTER TABLE `moves`
MODIFY `ID` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `challenges`
--
ALTER TABLE `challenges`
ADD CONSTRAINT `fk_challenges_users` FOREIGN KEY (`challenger_user_ID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_challenges_users1` FOREIGN KEY (`challenged_user_ID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `games`
--
ALTER TABLE `games`
ADD CONSTRAINT `fk_games_users1` FOREIGN KEY (`challenger_user_ID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_games_users2` FOREIGN KEY (`challenged_user_ID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_games_users3` FOREIGN KEY (`winner_user_ID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `moves`
--
ALTER TABLE `moves`
ADD CONSTRAINT `fk_moves_games1` FOREIGN KEY (`game_ID`) REFERENCES `games` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_moves_users1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
