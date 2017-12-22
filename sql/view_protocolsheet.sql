-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 18 Lug, 2017 at 01:37 AM
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
DROP VIEW IF EXISTS `view_protocolsheet`;
--
-- Struttura per la vista `view_protocolsheet`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_protocolsheet` AS select distinct `irp_streams`.`idprotocol` AS `idprotocol`,`irp_protocols`.`name` AS `name`,`irp_remkeys`.`idremote` AS `idremote`,`irp_remotes`.`phpgui` AS `phpgui`,`irp_remkeys`.`keyname` AS `keyname`,`irp_actions`.`screen` AS `screen`,`irp_devcommands`.`drepeat` AS `drepeat`,`irp_streams`.`idstream` AS `idstream`,`irp_streams`.`repeat` AS `repeat`,`irp_streams`.`HEX` AS `HEX`,`irp_streams`.`dataProtocol` AS `dataProtocol`,`irp_streams`.`dataDevice` AS `dataDevice`,`irp_protocols`.`phpadapter` AS `phpadapter`,`irp_streams`.`CRCRAW` AS `CRCRAW`,`irp_streams`.`RAW1` AS `RAW1` from (((`irp_streams` join `irp_protocols` on((`irp_streams`.`idprotocol` = `irp_protocols`.`idprotocol`))) left join `irp_devcommands` on((`irp_devcommands`.`idstream` = `irp_streams`.`idstream`))) left join (((`irp_remotes` join `irp_remkeys` on((`irp_remotes`.`idremote` = `irp_remkeys`.`idremote`))) join `irp_remcommands` on((`irp_remkeys`.`idremkey` = `irp_remcommands`.`idremkey`))) join `irp_actions` on((`irp_remkeys`.`keyname` = `irp_actions`.`keyname`))) on(((`irp_remcommands`.`idstream` = `irp_streams`.`idstream`)))) ;
