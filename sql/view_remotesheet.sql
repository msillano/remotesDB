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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `remotesdb`.`view_remotesheet` AS select `remotesdb`.`irp_remkeys`.`idremote` AS `idremote`,`remotesdb`.`irp_remcommands`.`code` AS `code`,`remotesdb`.`irp_devrem`.`idprotocol` AS `idprotocol`,`remotesdb`.`irp_remkeys`.`keyname` AS `keyname`,`remotesdb`.`irp_actions`.`screen` AS `screen`,`remotesdb`.`irp_remkeys`.`idremkey` AS `idremkey`,`remotesdb`.`irp_remkeys`.`row` AS `row`,`remotesdb`.`irp_remkeys`.`col` AS `col`,`remotesdb`.`irp_remkeys`.`mode` AS `mode`,`remotesdb`.`irp_devcommands`.`iddevice` AS `iddevice`,`remotesdb`.`irp_devcommands`.`role` AS `role`,`remotesdb`.`irp_devcommands`.`drepeat` AS `drepeat`,`remotesdb`.`irp_streams`.`idstream` AS `idstream`,`remotesdb`.`irp_streams`.`repeat` AS `repeat`,`remotesdb`.`irp_remkeys`.`clickAction` AS `clickAction`,`remotesdb`.`irp_streams`.`HEX` AS `HEX`,`remotesdb`.`irp_streams`.`dataProtocol` AS `dataProtocol`,`remotesdb`.`irp_streams`.`dataDevice` AS `dataDevice`,`remotesdb`.`irp_streams`.`CRCRAW` AS `CRCRAW`,`remotesdb`.`irp_streams`.`RAW1` AS `RAW1` from (((((`remotesdb`.`irp_actions` join `remotesdb`.`irp_remkeys`) join `remotesdb`.`irp_devrem` on(((`remotesdb`.`irp_actions`.`keyname` = `remotesdb`.`irp_remkeys`.`keyname`) and (`remotesdb`.`irp_remkeys`.`idremote` = `remotesdb`.`irp_devrem`.`idremote`)))) left join `remotesdb`.`irp_remcommands` on((`remotesdb`.`irp_remkeys`.`idremkey` = `remotesdb`.`irp_remcommands`.`idremkey`))) left join `remotesdb`.`irp_streams` on((`remotesdb`.`irp_remcommands`.`idstream` = `remotesdb`.`irp_streams`.`idstream`))) left join `remotesdb`.`irp_devcommands` on(((`remotesdb`.`irp_devcommands`.`idstream` <=> `remotesdb`.`irp_remcommands`.`idstream`) and (`remotesdb`.`irp_devcommands`.`keyname` = `remotesdb`.`irp_remkeys`.`keyname`) and (`remotesdb`.`irp_devcommands`.`iddevice` = `remotesdb`.`irp_devrem`.`iddevice`)))) order by `remotesdb`.`irp_remkeys`.`idremote`,`remotesdb`.`irp_remcommands`.`code`,`remotesdb`.`irp_remkeys`.`row`,`remotesdb`.`irp_remkeys`.`col`,`remotesdb`.`irp_remkeys`.`mode`;
