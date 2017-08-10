-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 18 Lug, 2017 at 01:36 AM
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
DROP VIEW IF EXISTS `view_dev_rem`;

--
-- Struttura per la vista `view_devicesheet`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `remotesdb`.`view_dev_rem` AS select distinct `remotesdb`.`irp_devices`.`iddevice` AS `iddevice`,`remotesdb`.`irp_devices`.`kind` AS `kind`,`remotesdb`.`irp_devices`.`brand` AS `dev_brand`,`remotesdb`.`irp_devices`.`dev_model` AS `dev_model`,`remotesdb`.`irp_devices`.`status` AS `dev_status`,`remotesdb`.`irp_devices`.`group` AS `group`,`remotesdb`.`irp_devrem`.`mode1` AS `mode1`,`remotesdb`.`irp_devrem`.`mode2` AS `mode2`,`remotesdb`.`irp_devrem`.`mode3` AS `mode3`,`remotesdb`.`irp_devrem`.`idprotocol` AS `idprotocol`,`remotesdb`.`irp_devrem`.`code` AS `code`,`remotesdb`.`irp_remotes`.`idremote` AS `idremote`,`remotesdb`.`irp_remotes`.`brand` AS `rem_brand`,`remotesdb`.`irp_remotes`.`rem_model` AS `rem_model`,`remotesdb`.`irp_remotes`.`status` AS `rem_status`,`remotesdb`.`irp_remotes`.`modes` AS `modes` from ((`remotesdb`.`irp_devices` join `remotesdb`.`irp_devrem` on((`remotesdb`.`irp_devices`.`iddevice` = `remotesdb`.`irp_devrem`.`iddevice`))) join `remotesdb`.`irp_remotes` on((`remotesdb`.`irp_devrem`.`idremote` = `remotesdb`.`irp_remotes`.`idremote`)));
