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
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL default '0',
  `ip_address` varchar(16) NOT NULL default '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `session_data` text NOT NULL,
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `code` varchar(12) character set utf8 collate utf8_unicode_ci NOT NULL,
  `description` varchar(32) character set utf8 collate utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`code`, `description`) VALUES
('c', 'C'),
('css', 'CSS'),
('cpp', 'C++'),
('html4strict', 'HTML (4 Strict)'),
('java', 'Java'),
('perl', 'Perl'),
('php', 'PHP'),
('python', 'Python'),
('ruby', 'Ruby'),
('text', 'Plain Text'),
('asm', 'ASM (Nasm Syntax)'),
('xhtml', 'XHTML'),
('actionscript', 'Actionscript'),
('ada', 'ADA'),
('apache', 'Apache Log'),
('applescript', 'AppleScript'),
('autoit', 'AutoIT'),
('bash', 'Bash'),
('bptzbasic', 'BptzBasic'),
('c_mac', 'C for Macs'),
('csharp', 'C#'),
('ColdFusion', 'coldfusion'),
('delphi', 'Delphi'),
('eiffel', 'Eiffel'),
('fortran', 'Fortran'),
('freebasic', 'FreeBasic'),
('gml', 'GML'),
('groovy', 'Groovy'),
('inno', 'Inno'),
('java5', 'Java 5'),
('javascript', 'Javascript'),
('latex', 'LaTeX'),
('mirc', 'mIRC'),
('mysql', 'MySQL'),
('nsis', 'NSIS'),
('objc', 'Objective C'),
('ocaml', 'OCaml'),
('oobas', 'OpenOffice BASIC'),
('orcale8', 'Orcale 8 SQL'),
('pascal', 'Pascal'),
('plsql', 'PL/SQL'),
('qbasic', 'Q(uick)BASIC'),
('robots', 'robots.txt'),
('scheme', 'Scheme'),
('sdlbasic', 'SDLBasic'),
('smalltalk', 'Smalltalk'),
('smarty', 'Smarty'),
('sql', 'SQL'),
('tcl', 'TCL'),
('vbnet', 'VB.NET'),
('vb', 'Visual BASIC'),
('winbatch', 'Winbatch'),
('xml', 'XML'),
('z80', 'z80 ASM');


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
