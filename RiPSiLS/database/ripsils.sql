-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2015 at 03:32 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `challenges`
--

CREATE TABLE IF NOT EXISTS `challenges` (
`ID` int(11) unsigned NOT NULL,
  `create_date` datetime NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  `expiration_date` datetime DEFAULT NULL,
  `challenger_user_ID` int(11) unsigned NOT NULL,
  `challenger_move` tinyint(1) unsigned NOT NULL,
  `challenged_user_ID` int(11) unsigned NOT NULL,
  `challenged_move` tinyint(1) unsigned DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `challenges`
--

INSERT INTO `challenges` (`ID`, `create_date`, `active`, `expiration_date`, `challenger_user_ID`, `challenger_move`, `challenged_user_ID`, `challenged_move`) VALUES
(1, '0000-00-00 00:00:00', 0, NULL, 1, 1, 2, 2),
(2, '0000-00-00 00:00:00', 1, NULL, 2, 3, 1, 4),
(3, '0000-00-00 00:00:00', 0, NULL, 3, 2, 2, 2),
(4, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 1, 3, 2, 2),
(5, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 1, 4, 2, 5),
(6, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 1, 5, 2, 4),
(7, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 1, 2, 2, 0),
(8, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 1, 2, 2, 0),
(9, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 1, 3, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
`ID` int(11) unsigned NOT NULL,
  `create_date` datetime NOT NULL,
  `user_ID` int(11) unsigned NOT NULL,
  `friend_ID` int(11) unsigned NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`ID`, `create_date`, `user_ID`, `friend_ID`) VALUES
(9, '0000-00-00 00:00:00', 1, 2),
(10, '0000-00-00 00:00:00', 1, 5),
(14, '0000-00-00 00:00:00', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `friend_invitations`
--

CREATE TABLE IF NOT EXISTS `friend_invitations` (
`ID` int(11) unsigned NOT NULL,
  `create_date` datetime NOT NULL,
  `user_ID` int(11) unsigned NOT NULL,
  `friend_ID` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
`ID` int(11) unsigned NOT NULL,
  `challenger_user_ID` int(11) unsigned NOT NULL,
  `challenged_user_ID` int(11) unsigned NOT NULL,
  `winner_user_ID` int(11) unsigned DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`ID`, `challenger_user_ID`, `challenged_user_ID`, `winner_user_ID`) VALUES
(1, 1, 2, 2),
(2, 2, 1, 1),
(3, 1, 2, 1),
(4, 1, 2, 2),
(5, 3, 2, NULL),
(6, 1, 2, 1),
(7, 1, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `moves`
--

CREATE TABLE IF NOT EXISTS `moves` (
`ID` int(11) unsigned NOT NULL,
  `datetime` datetime NOT NULL,
  `move` tinyint(1) unsigned NOT NULL,
  `user_ID` int(11) unsigned NOT NULL,
  `game_ID` int(11) unsigned NOT NULL,
  `turn` smallint(2) unsigned NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `moves`
--

INSERT INTO `moves` (`ID`, `datetime`, `move`, `user_ID`, `game_ID`, `turn`) VALUES
(1, '2014-01-01 17:30:00', 1, 1, 1, 1),
(2, '2014-01-01 17:30:00', 2, 2, 1, 1),
(3, '2014-01-01 17:30:00', 3, 1, 2, 1),
(4, '2014-01-01 17:30:00', 4, 2, 2, 1),
(5, '2015-01-19 15:11:05', 4, 1, 3, 1),
(6, '2015-01-19 15:11:05', 5, 2, 3, 1),
(7, '2015-01-19 15:11:31', 1, 1, 4, 1),
(8, '2015-01-19 15:11:31', 2, 2, 4, 1),
(9, '2015-01-19 15:37:46', 2, 3, 5, 1),
(10, '2015-01-19 15:37:46', 2, 2, 5, 1),
(11, '2015-01-19 15:54:06', 3, 1, 6, 1),
(12, '2015-01-19 15:54:06', 2, 2, 6, 1),
(13, '2015-01-20 16:58:18', 5, 1, 7, 1),
(14, '2015-01-20 16:58:18', 4, 2, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`ID` int(11) unsigned NOT NULL,
  `create_date` datetime NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `create_date`, `username`, `password`) VALUES
(1, '2014-01-01 17:00:00', 'Bob', '$2y$10$askTJQK09uKFFgSUKOJ9QO/1MSunJIhmnx3RDeQkTA9bW3.JXaCka'),
(2, '2014-01-01 17:00:00', 'Jan', '$2y$10$askTJQK09uKFFgSUKOJ9QO/1MSunJIhmnx3RDeQkTA9bW3.JXaCka'),
(3, '2014-01-01 17:00:00', 'Pieter', '$2y$10$askTJQK09uKFFgSUKOJ9QO/1MSunJIhmnx3RDeQkTA9bW3.JXaCka'),
(4, '2014-01-01 17:00:00', '12345', '$2y$10$askTJQK09uKFFgSUKOJ9QO/1MSunJIhmnx3RDeQkTA9bW3.JXaCka'),
(5, '0000-00-00 00:00:00', 'janno', '$2y$10$askTJQK09uKFFgSUKOJ9QO/1MSunJIhmnx3RDeQkTA9bW3.JXaCka');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `challenges`
--
ALTER TABLE `challenges`
 ADD PRIMARY KEY (`ID`), ADD KEY `fk_challenges_users_idx` (`challenger_user_ID`), ADD KEY `fk_challenges_users1_idx` (`challenged_user_ID`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
 ADD PRIMARY KEY (`ID`), ADD KEY `fk_friends_users1_idx` (`user_ID`), ADD KEY `fk_friends_users2_idx` (`friend_ID`);

--
-- Indexes for table `friend_invitations`
--
ALTER TABLE `friend_invitations`
 ADD PRIMARY KEY (`ID`), ADD KEY `fk_friend_invitations_users1_idx` (`user_ID`), ADD KEY `fk_friend_invitations_users2_idx` (`friend_ID`);

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
MODIFY `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
MODIFY `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `friend_invitations`
--
ALTER TABLE `friend_invitations`
MODIFY `ID` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
MODIFY `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `moves`
--
ALTER TABLE `moves`
MODIFY `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
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
-- Constraints for table `friends`
--
ALTER TABLE `friends`
ADD CONSTRAINT `fk_friends_users1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_friends_users2` FOREIGN KEY (`friend_ID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `friend_invitations`
--
ALTER TABLE `friend_invitations`
ADD CONSTRAINT `fk_friend_invitations_users1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_friend_invitations_users2` FOREIGN KEY (`friend_ID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
