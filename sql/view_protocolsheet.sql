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
-- Database: `remotesdb`
--

-- --------------------------------------------------------
DROP VIEW IF EXISTS `view_protocolsheet`;
--
-- Struttura per la vista `view_protocolsheet`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `remotesdb`.`view_protocolsheet` AS select distinct `remotesdb`.`irp_streams`.`idprotocol` AS `idprotocol`,`remotesdb`.`irp_protocols`.`name` AS `name`,`remotesdb`.`irp_remkeys`.`idremote` AS `idremote`,`remotesdb`.`irp_remotes`.`phpgui` AS `phpgui`,`remotesdb`.`irp_remkeys`.`keyname` AS `keyname`,`remotesdb`.`irp_actions`.`screen` AS `screen`,`remotesdb`.`irp_devcommands`.`drepeat` AS `drepeat`,`remotesdb`.`irp_streams`.`idstream` AS `idstream`,`remotesdb`.`irp_streams`.`repeat` AS `repeat`,`remotesdb`.`irp_streams`.`HEX` AS `HEX`,`remotesdb`.`irp_streams`.`dataProtocol` AS `dataProtocol`,`remotesdb`.`irp_streams`.`dataDevice` AS `dataDevice`,`remotesdb`.`irp_protocols`.`phpadapter` AS `phpadapter`,`remotesdb`.`irp_streams`.`CRCRAW` AS `CRCRAW`,`remotesdb`.`irp_streams`.`RAW1` AS `RAW1` from (((`remotesdb`.`irp_streams` join `remotesdb`.`irp_protocols` on((`remotesdb`.`irp_streams`.`idprotocol` = `remotesdb`.`irp_protocols`.`idprotocol`))) left join `remotesdb`.`irp_devcommands` on((`remotesdb`.`irp_devcommands`.`idstream` = `remotesdb`.`irp_streams`.`idstream`))) left join (((`remotesdb`.`irp_remotes` join `remotesdb`.`irp_remkeys` on((`remotesdb`.`irp_remotes`.`idremote` = `remotesdb`.`irp_remkeys`.`idremote`))) join `remotesdb`.`irp_remcommands` on((`remotesdb`.`irp_remkeys`.`idremkey` = `remotesdb`.`irp_remcommands`.`idremkey`))) join `remotesdb`.`irp_actions` on((`remotesdb`.`irp_remkeys`.`keyname` = `remotesdb`.`irp_actions`.`keyname`))) on(((`remotesdb`.`irp_remcommands`.`idstream` = `remotesdb`.`irp_streams`.`idstream`)))) ;
