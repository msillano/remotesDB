-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 26 Lug, 2017 at 07:32 PM
-- Versione MySQL: 5.0.45
-- Versione PHP: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `remotesdb`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `irp_devtypes`
--

CREATE TABLE IF NOT EXISTS `irp_devtypes` (
  `kind` char(30) NOT NULL COMMENT 'devices type',
  `ticon` char(30) default NULL COMMENT 'type icon for UI (in ./icons)',
  PRIMARY KEY  (`kind`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='lookup for device types';

--
-- Dump dei dati per la tabella `irp_devtypes`
--

INSERT INTO `irp_devtypes` (`kind`, `ticon`) VALUES
('TVset', 'tvset.png'),
('TV/DVD_Combo', NULL),
('TV/DVD/VCR_Combo', NULL),
('Projector', NULL),
('Set_Top_Box', NULL),
('CD', NULL),
('DVD', NULL),
('Bl_Ray', NULL),
('VCR', NULL),
('DVD/VCR_Combo', NULL),
('Laser Disk', NULL),
('Tuner', NULL),
('Receiver/Preamp', NULL),
('Home_Theater_System', NULL),
('AV_System', NULL),
('Subwoofer', NULL),
('Soundbar', NULL),
('Media Manager', NULL),
('Switcher', NULL),
('Lighting', NULL),
('Climate_Control', NULL);
