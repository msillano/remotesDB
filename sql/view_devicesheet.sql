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
-- Database: `remotesdb`
--

-- --------------------------------------------------------
DROP VIEW IF EXISTS `view_devicesheet`;

--
-- Struttura per la vista `view_devicesheet`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `remotesdb`.`view_devicesheet` AS select `remotesdb`.`irp_devcommands`.`iddevice` AS `iddevice`,`remotesdb`.`irp_devcommands`.`role` AS `role`,`remotesdb`.`irp_devrem`.`idprotocol` AS `idprotocol`,`remotesdb`.`irp_devcommands`.`keyname` AS `keyname`,`remotesdb`.`irp_actions`.`screen` AS `screen`,`remotesdb`.`irp_devcommands`.`drepeat` AS `drepeat`,`remotesdb`.`irp_streams`.`idstream` AS `idstream`,`remotesdb`.`irp_streams`.`repeat` AS `repeat`,`remotesdb`.`irp_remkeys`.`clickAction` AS `clickAction`,`remotesdb`.`irp_streams`.`HEX` AS `HEX`,`remotesdb`.`irp_streams`.`dataProtocol` AS `dataProtocol`,`remotesdb`.`irp_streams`.`dataDevice` AS `dataDevice`,`remotesdb`.`irp_streams`.`CRCRAW` AS `CRCRAW`,`remotesdb`.`irp_streams`.`RAW1` AS `RAW1` from (((`remotesdb`.`irp_devcommands` join `remotesdb`.`irp_actions`) join `remotesdb`.`irp_devrem` on(((`remotesdb`.`irp_devcommands`.`keyname` = `remotesdb`.`irp_actions`.`keyname`) and (`remotesdb`.`irp_devcommands`.`iddevice` = `remotesdb`.`irp_devrem`.`iddevice`)))) left join (`remotesdb`.`irp_remkeys` left join (`remotesdb`.`irp_remcommands` join `remotesdb`.`irp_streams` on((`remotesdb`.`irp_remcommands`.`idstream` = `remotesdb`.`irp_streams`.`idstream`))) on((`remotesdb`.`irp_remkeys`.`idremkey` = `remotesdb`.`irp_remcommands`.`idremkey`))) on(((`remotesdb`.`irp_remkeys`.`keyname` = `remotesdb`.`irp_devcommands`.`keyname`) and (`remotesdb`.`irp_devcommands`.`idstream` <=> `remotesdb`.`irp_streams`.`idstream`) and ((`remotesdb`.`irp_devcommands`.`idstream` is not null) or (`remotesdb`.`irp_remkeys`.`clickAction` is not null)) and (`remotesdb`.`irp_remkeys`.`idremote` = `remotesdb`.`irp_devrem`.`idremote`))));
 


  