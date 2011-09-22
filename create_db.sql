-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 173.201.136.224
-- Generation Time: Sep 22, 2011 at 03:08 PM
-- Server version: 5.0.91
-- PHP Version: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `mentalworkout`
--

-- --------------------------------------------------------

--
-- Table structure for table `exercise`
--

CREATE TABLE `exercise` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `exercise`
--

INSERT INTO `exercise` VALUES(1, 'Bench Press (free)', 'Chest');
INSERT INTO `exercise` VALUES(2, 'Dumbbell Shoulder Press', 'Shoulders');
INSERT INTO `exercise` VALUES(3, 'Preacher Curl (sitting)', 'Biceps');
INSERT INTO `exercise` VALUES(9, 'Preacher Curl (standing)', 'Biceps');
INSERT INTO `exercise` VALUES(10, 'Squats (free)', 'Legs');
INSERT INTO `exercise` VALUES(18, 'Single Curl (sitting)', 'Biceps');
INSERT INTO `exercise` VALUES(19, 'Straight Bar Pulldown', 'Triceps');
INSERT INTO `exercise` VALUES(20, 'Skull Press', 'Triceps');
INSERT INTO `exercise` VALUES(21, 'Dumbbell Press', 'Chest');
INSERT INTO `exercise` VALUES(22, 'Straight Flys', 'Chest');
INSERT INTO `exercise` VALUES(23, 'Inclined Flys', 'Chest');
INSERT INTO `exercise` VALUES(24, 'Leg Press', 'Legs');
INSERT INTO `exercise` VALUES(25, 'Angled Bar Pulldown', 'Triceps');
INSERT INTO `exercise` VALUES(26, 'Military Press', 'Shoulders');
INSERT INTO `exercise` VALUES(27, 'Pec Deck', 'Chest');

-- --------------------------------------------------------

--
-- Table structure for table `weights_set`
--

CREATE TABLE `weights_set` (
  `id` int(11) NOT NULL,
  `workout_exercise_id` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  `reps` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `workout_exercise_id` (`workout_exercise_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `weights_set`
--

INSERT INTO `weights_set` VALUES(0, 1, 'planned', 10, 25);
INSERT INTO `weights_set` VALUES(1, 1, 'planned', 10, 25);
INSERT INTO `weights_set` VALUES(2, 1, 'planned', 10, 25);
INSERT INTO `weights_set` VALUES(3, 1, 'planned', 10, 25);
INSERT INTO `weights_set` VALUES(4, 1, 'planned', 10, 25);
INSERT INTO `weights_set` VALUES(5, 2, 'planned', 10, 28);
INSERT INTO `weights_set` VALUES(6, 2, 'planned', 10, 28);
INSERT INTO `weights_set` VALUES(7, 2, 'planned', 10, 30);
INSERT INTO `weights_set` VALUES(8, 2, 'planned', 10, 30);

-- --------------------------------------------------------

--
-- Table structure for table `workout`
--

CREATE TABLE `workout` (
  `id` int(11) NOT NULL auto_increment,
  `date` timestamp NULL default NULL,
  `location` varchar(30) NOT NULL,
  `duration` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `workout`
--

INSERT INTO `workout` VALUES(1, '2011-09-23 19:30:00', 'Virgin Active Epsom', 90);

-- --------------------------------------------------------

--
-- Table structure for table `workout_exercise`
--

CREATE TABLE `workout_exercise` (
  `id` int(11) NOT NULL auto_increment,
  `workout_id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL,
  `date` timestamp NULL default NULL,
  PRIMARY KEY  (`id`),
  KEY `workout_id` (`workout_id`),
  KEY `exercise_id` (`exercise_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `workout_exercise`
--

INSERT INTO `workout_exercise` VALUES(1, 1, 3, '2011-09-23 19:30:00');
INSERT INTO `workout_exercise` VALUES(2, 1, 2, '2011-09-23 20:00:00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `weights_set`
--
ALTER TABLE `weights_set`
  ADD CONSTRAINT `weights_set_ibfk_1` FOREIGN KEY (`workout_exercise_id`) REFERENCES `workout_exercise` (`id`);

--
-- Constraints for table `workout_exercise`
--
ALTER TABLE `workout_exercise`
  ADD CONSTRAINT `workout_exercise_ibfk_1` FOREIGN KEY (`workout_id`) REFERENCES `workout` (`id`),
  ADD CONSTRAINT `workout_exercise_ibfk_2` FOREIGN KEY (`exercise_id`) REFERENCES `exercise` (`id`);
