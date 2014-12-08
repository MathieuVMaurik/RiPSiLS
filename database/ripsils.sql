-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server versie:                5.6.20 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Versie:              9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Databasestructuur van ripsils wordt geschreven
CREATE DATABASE IF NOT EXISTS `ripsils` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `ripsils`;


-- Structuur van  tabel ripsils.challenges wordt geschreven
CREATE TABLE IF NOT EXISTS `challenges` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `create_date` datetime NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  `expiration_date` datetime DEFAULT NULL,
  `challenger_user_ID` int(11) unsigned NOT NULL,
  `challenger_move` tinyint(1) unsigned NOT NULL,
  `challenged_user_ID` int(11) unsigned NOT NULL,
  `challenged_move` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_challenges_users_idx` (`challenger_user_ID`),
  KEY `fk_challenges_users1_idx` (`challenged_user_ID`),
  CONSTRAINT `fk_challenges_users` FOREIGN KEY (`challenger_user_ID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_challenges_users1` FOREIGN KEY (`challenged_user_ID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumpen data van tabel ripsils.challenges: ~3 rows (ongeveer)
/*!40000 ALTER TABLE `challenges` DISABLE KEYS */;
INSERT INTO `challenges` (`ID`, `create_date`, `active`, `expiration_date`, `challenger_user_ID`, `challenger_move`, `challenged_user_ID`, `challenged_move`) VALUES
	(1, '0000-00-00 00:00:00', 1, NULL, 1, 1, 2, 2),
	(2, '0000-00-00 00:00:00', 1, NULL, 2, 3, 1, 4),
	(3, '0000-00-00 00:00:00', 1, NULL, 3, 2, 2, 5);
/*!40000 ALTER TABLE `challenges` ENABLE KEYS */;


-- Structuur van  tabel ripsils.games wordt geschreven
CREATE TABLE IF NOT EXISTS `games` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `challenger_user_ID` int(11) unsigned NOT NULL,
  `challenged_user_ID` int(11) unsigned NOT NULL,
  `winner_user_ID` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_games_users1_idx` (`challenger_user_ID`),
  KEY `fk_games_users2_idx` (`challenged_user_ID`),
  KEY `fk_games_users3_idx` (`winner_user_ID`),
  CONSTRAINT `fk_games_users1` FOREIGN KEY (`challenger_user_ID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_games_users2` FOREIGN KEY (`challenged_user_ID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_games_users3` FOREIGN KEY (`winner_user_ID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumpen data van tabel ripsils.games: ~2 rows (ongeveer)
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` (`ID`, `challenger_user_ID`, `challenged_user_ID`, `winner_user_ID`) VALUES
	(1, 1, 2, 2),
	(2, 2, 1, 1);
/*!40000 ALTER TABLE `games` ENABLE KEYS */;


-- Structuur van  tabel ripsils.moves wordt geschreven
CREATE TABLE IF NOT EXISTS `moves` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `move` tinyint(1) unsigned NOT NULL,
  `user_ID` int(11) unsigned NOT NULL,
  `game_ID` int(11) unsigned NOT NULL,
  `turn` smallint(2) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_moves_users1_idx` (`user_ID`),
  KEY `fk_moves_games1_idx` (`game_ID`),
  CONSTRAINT `fk_moves_games1` FOREIGN KEY (`game_ID`) REFERENCES `games` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_moves_users1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumpen data van tabel ripsils.moves: ~4 rows (ongeveer)
/*!40000 ALTER TABLE `moves` DISABLE KEYS */;
INSERT INTO `moves` (`ID`, `datetime`, `move`, `user_ID`, `game_ID`, `turn`) VALUES
	(1, '2014-01-01 17:30:00', 1, 1, 1, 1),
	(2, '2014-01-01 17:30:00', 2, 2, 1, 1),
	(3, '2014-01-01 17:30:00', 3, 1, 2, 1),
	(4, '2014-01-01 17:30:00', 4, 2, 2, 1);
/*!40000 ALTER TABLE `moves` ENABLE KEYS */;


-- Structuur van  tabel ripsils.users wordt geschreven
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `create_date` datetime NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumpen data van tabel ripsils.users: ~4 rows (ongeveer)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`ID`, `create_date`, `username`, `password`) VALUES
	(1, '2014-01-01 17:00:00', 'Bob', '$2y$10$askTJQK09uKFFgSUKOJ9QO/1MSunJIhmnx3RDeQkTA9bW3.JXaCka'),
	(2, '2014-01-01 17:00:00', 'Jan', '$2y$10$askTJQK09uKFFgSUKOJ9QO/1MSunJIhmnx3RDeQkTA9bW3.JXaCka'),
	(3, '2014-01-01 17:00:00', 'Pieter', '$2y$10$askTJQK09uKFFgSUKOJ9QO/1MSunJIhmnx3RDeQkTA9bW3.JXaCka'),
	(4, '2014-01-01 17:00:00', '12345', '$2y$10$askTJQK09uKFFgSUKOJ9QO/1MSunJIhmnx3RDeQkTA9bW3.JXaCka');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

-- MySQL Script generated by MySQL Workbench
-- 12/08/14 10:08:17
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema ripsils
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `ripsils` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `ripsils` ;

-- -----------------------------------------------------
-- Table `ripsils`.`friends`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ripsils`.`friends` ;

CREATE TABLE IF NOT EXISTS `ripsils`.`friends` (
  `ID` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `create_date` DATETIME NOT NULL,
  `user_ID` INT(11) UNSIGNED NOT NULL,
  `friend_ID` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_friends_users1_idx` (`user_ID` ASC),
  INDEX `fk_friends_users2_idx` (`friend_ID` ASC),
  CONSTRAINT `fk_friends_users1`
    FOREIGN KEY (`user_ID`)
    REFERENCES `ripsils`.`users` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_friends_users2`
    FOREIGN KEY (`friend_ID`)
    REFERENCES `ripsils`.`users` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ripsils`.`friend_invitations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ripsils`.`friend_invitations` ;

CREATE TABLE IF NOT EXISTS `ripsils`.`friend_invitations` (
  `ID` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `create_date` DATETIME NOT NULL,
  `user_ID` INT(11) UNSIGNED NOT NULL,
  `friend_ID` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_friend_invitations_users1_idx` (`user_ID` ASC),
  INDEX `fk_friend_invitations_users2_idx` (`friend_ID` ASC),
  CONSTRAINT `fk_friend_invitations_users1`
    FOREIGN KEY (`user_ID`)
    REFERENCES `ripsils`.`users` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_friend_invitations_users2`
    FOREIGN KEY (`friend_ID`)
    REFERENCES `ripsils`.`users` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
