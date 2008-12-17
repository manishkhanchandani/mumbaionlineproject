-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 17, 2008 at 06:08 AM
-- Server version: 5.0.51
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `december2008`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seq`
--

CREATE TABLE IF NOT EXISTS `tbl_seq` (
  `id` int(11) NOT NULL auto_increment,
  `tablename` varchar(100) default NULL,
  `seq` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_seq`
--

INSERT INTO `tbl_seq` (`id`, `tablename`, `seq`) VALUES
(1, 'cg_short_keywords', 183625),
(2, 'history', 0),
(3, 'phonebook', 0),
(4, 'user', 0);
