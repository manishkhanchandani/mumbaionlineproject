-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 17, 2008 at 06:09 AM
-- Server version: 5.0.51
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `december2008`
--

-- --------------------------------------------------------

--
-- Table structure for table `phonebook`
--

CREATE TABLE IF NOT EXISTS `phonebook` (
  `phonebook_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `name` varchar(100) default NULL,
  `phone` varchar(100) default NULL,
  `email` varchar(200) default NULL,
  `comments` text,
  `public` int(1) NOT NULL default '0',
  `created` datetime default NULL,
  PRIMARY KEY  (`phonebook_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;
