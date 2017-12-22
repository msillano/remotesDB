-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 02 Ago, 2017 at 01:19 PM
-- Versione MySQL: 5.0.45
-- Versione PHP: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `remotesmxq`
--

-- --------------------------------------------------------
DROP VIEW IF EXISTS `view_devicesheet`;

--
-- Struttura per la vista `view_devicesheet`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_devicesheet` AS select `irp_devcommands`.`iddevice` AS `iddevice`,`irp_devcommands`.`role` AS `role`,`irp_devrem`.`idprotocol` AS `idprotocol`,`irp_devcommands`.`keyname` AS `keyname`,`irp_actions`.`screen` AS `screen`,`irp_devcommands`.`drepeat` AS `drepeat`,`irp_streams`.`idstream` AS `idstream`,`irp_streams`.`repeat` AS `repeat`,`irp_remkeys`.`clickAction` AS `clickAction`,`irp_streams`.`HEX` AS `HEX`,`irp_streams`.`dataProtocol` AS `dataProtocol`,`irp_streams`.`dataDevice` AS `dataDevice`,`irp_streams`.`CRCRAW` AS `CRCRAW`,`irp_streams`.`RAW1` AS `RAW1` from (((`irp_devcommands` join `irp_actions`) join `irp_devrem` on(((`irp_devcommands`.`keyname` = `irp_actions`.`keyname`) and (`irp_devcommands`.`iddevice` = `irp_devrem`.`iddevice`)))) left join (`irp_remkeys` left join (`irp_remcommands` join `irp_streams` on((`irp_remcommands`.`idstream` = `irp_streams`.`idstream`))) on((`irp_remkeys`.`idremkey` = `irp_remcommands`.`idremkey`))) on(((`irp_remkeys`.`keyname` = `irp_devcommands`.`keyname`) and (`irp_devcommands`.`idstream` <=> `irp_streams`.`idstream`) and ((`irp_devcommands`.`idstream` is not null) or (`irp_remkeys`.`clickAction` is not null)) and (`irp_remkeys`.`idremote` = `irp_devrem`.`idremote`))));
 


  