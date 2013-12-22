-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 21, 2013 at 07:32 PM
-- Server version: 5.5.29
-- PHP Version: 5.4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `alpanaba_p4_mywebprojects_biz`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Foreign key',
  `activitytype` text NOT NULL,
  `activitytime` int(11) NOT NULL,
  `caloriesburned` int(11) NOT NULL,
  `date` text NOT NULL,
  `day` text NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`activity_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`activity_id`, `created`, `modified`, `user_id`, `activitytype`, `activitytime`, `caloriesburned`, `date`, `day`, `notes`) VALUES
(8, 1387642776, 1387642776, 33, 'Walk', 30, 200, 'Tuesday,10 December, 2013', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'foreign key',
  `content` text NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `created`, `modified`, `user_id`, `content`) VALUES
(1, 1387433568, 1387433568, 32, 'I planning to go on a hike'),
(2, 1387433854, 1387433854, 33, 'test2'),
(3, 1387642970, 1387642970, 33, 'test2');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` int(11) NOT NULL,
  `timezone` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `created`, `modified`, `token`, `password`, `last_login`, `timezone`, `first_name`, `last_name`, `email`, `avatar`) VALUES
(32, 1387317208, 1387317208, '13cd1c56e0ddd1352a456b35a983ad95460fff20', '7842179de626fac1d87af422489f194eb96b9e9c', 0, '', 'test1', 'test1', 'test1@aol.com', '32.jpeg'),
(33, 1387321723, 1387321723, 'b248632ec9cd29fb6132a9918482d28b709f6225', '39d6acd8cdb9d967e319241c4a5d861ff1515c64', 0, '', 'test2', 'test2', 'test2@aol.com', '33.JPG'),
(34, 1387511464, 1387511464, 'b8efc75e23d5b312475db2ed256c33f64cef7757', '7842179de626fac1d87af422489f194eb96b9e9c', 0, '', 'test1', 'test1', 'test@aol.com', 'defaultimage.jpeg'),
(36, 1387512350, 1387512350, 'db69a303b04f6925792b36b965a2fb539b90ec9d', '391fe9d062251d9143d4c51fdb11aa95eeb2fcc6', 0, '', 'Jane', 'Waters', 'waters@aol.com', 'defaultimage.jpeg'),
(37, 1387512514, 1387512514, 'e49550a49366aaaf0d0385f85e50944cdba80ba7', '31e0a212e5052136f0a017a856a319974fa63038', 0, '', 'Ella', 'Rose', 'rose@aol.com', 'defaultimage.jpeg'),
(38, 1387513762, 1387513762, 'dbcb4c48390bae6ea8827ca069ffe8599451b14f', '3bc646b1e8ce929eab0fd7cb9c57ffa715c8c886', 0, '', 'Dan', 'Mason', 'mason@aol.com', 'defaultimage.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `users_users`
--

CREATE TABLE `users_users` (
  `user_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'fk Follower',
  `user_id_followed` int(11) NOT NULL COMMENT 'Followed',
  PRIMARY KEY (`user_user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users_users`
--

INSERT INTO `users_users` (`user_user_id`, `created`, `user_id`, `user_id_followed`) VALUES
(1, 1387434234, 33, 32),
(2, 1387514125, 33, 36);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
