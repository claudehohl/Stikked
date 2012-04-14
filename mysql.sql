-- phpMyAdmin SQL Dump
-- version 2.11.7-rc1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 05, 2008 at 10:49 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `stikked`
--

-- --------------------------------------------------------

--
-- Table structure for table `pastes`
--

CREATE TABLE IF NOT EXISTS `pastes` (
  `id` int(10) NOT NULL auto_increment,
  `pid` varchar(8) character set utf8 collate utf8_unicode_ci NOT NULL,
  `title` varchar(32) character set utf8 collate utf8_unicode_ci NOT NULL,
  `name` varchar(32) character set utf8 collate utf8_unicode_ci NOT NULL,
  `lang` varchar(32) character set utf8 collate utf8_unicode_ci NOT NULL,
  `private` tinyint(1) NOT NULL,
  `paste` longtext character set utf8 collate utf8_unicode_ci NOT NULL,
  `raw` longtext character set utf8 collate utf8_unicode_ci NOT NULL,
  `created` int(10) NOT NULL,
  `expire` int(10) NOT NULL default '0',
  `toexpire` tinyint(1) unsigned NOT NULL,
  `snipurl` varchar(64) character set utf8 collate utf8_unicode_ci NOT NULL default '0',
  `replyto` varchar(8) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=154 ;
