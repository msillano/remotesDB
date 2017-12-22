-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 18 Lug, 2017 at 01:39 AM
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
DROP VIEW IF EXISTS `view_remotesheet`;
--
-- Struttura per la vista `view_remotesheet`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_remotesheet` AS select 
`irp_devrem`.`idremote` AS `idremote`,
`irp_devrem`.`code` AS `code`,
`irp_devrem`.`idprotocol` AS `idprotocol`,
`irp_remkeys`.`keyname` AS `keyname`,
`irp_actions`.`screen` AS `screen`,
`irp_remkeys`.`idremkey` AS `idremkey`,
`irp_remkeys`.`row` AS `row`,
`irp_remkeys`.`col` AS `col`,
`irp_remkeys`.`mode` AS `mode`,
`irp_devcommands`.`iddevice` AS `iddevice`,
`irp_devcommands`.`role` AS `role`,
`irp_devcommands`.`drepeat` AS `drepeat`,
`irp_streams`.`idstream` AS `idstream`,
`irp_streams`.`repeat` AS `repeat`,
`irp_remkeys`.`clickAction` AS `clickAction`,
`irp_streams`.`HEX` AS `HEX`,
`irp_streams`.`dataProtocol` AS `dataProtocol`,
`irp_streams`.`dataDevice` AS `dataDevice`,
`irp_streams`.`CRCRAW` AS `CRCRAW`,
`irp_streams`.`RAW1` AS `RAW1` from 
(((((`irp_actions` join `irp_remkeys`) join `irp_devrem` on(((`irp_actions`.`keyname` = `irp_remkeys`.`keyname`) and (`irp_remkeys`.`idremote` = `irp_devrem`.`idremote`))))
    left join `irp_remcommands` on((`irp_remkeys`.`idremkey` = `irp_remcommands`.`idremkey`)))
        left join `irp_streams` on((`irp_remcommands`.`idstream` = `irp_streams`.`idstream` AND `irp_remcommands`.`code` = `irp_devrem`.`code`))) 
		   left join `irp_devcommands` on(((`irp_devcommands`.`idstream` <=> `irp_remcommands`.`idstream`) and (`irp_devcommands`.`keyname` = `irp_remkeys`.`keyname`) and (`irp_devcommands`.`iddevice` = `irp_devrem`.`iddevice`))))
  order by `irp_remkeys`.`idremote`,`irp_remcommands`.`code`,`irp_remkeys`.`row`,`irp_remkeys`.`col`,`irp_remkeys`.`mode`;
