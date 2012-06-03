-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 03. Jun 2012 um 09:46
-- Server Version: 5.5.22
-- PHP-Version: 5.3.10-1ubuntu3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `mybbdev_16`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mybb_awaylist`
--

DROP TABLE IF EXISTS `mybb_awaylist`;
CREATE TABLE IF NOT EXISTS `mybb_awaylist` (
  `uid` int(10) unsigned DEFAULT NULL,
  `username` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `arrival` int(11) DEFAULT NULL,
  `departure` int(11) DEFAULT NULL,
  `airline` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `place` varchar(255) COLLATE utf8_bin NOT NULL,
  `hotel` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_bin NOT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sort_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=9 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
