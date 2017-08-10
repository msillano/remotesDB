-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 10 Ago, 2017 at 01:56 PM
-- Versione MySQL: 5.0.45
-- Versione PHP: 5.2.5
--
-- ver 1.3
--

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
-- Struttura della tabella `irp_actions`
--

DROP TABLE IF EXISTS `irp_actions`;
CREATE TABLE IF NOT EXISTS `irp_actions` (
  `keyname` char(30) NOT NULL COMMENT 'Key-action name (pk, dont''change)',
  `screen` char(30) default NULL COMMENT 'the UI key label (e.g. translated)',
  `kicon` char(100) default NULL COMMENT 'key icon (in ./icons/)',
  `definition` varchar(200) default NULL COMMENT 'comments on key',
  PRIMARY KEY  (`keyname`),
  UNIQUE KEY `screen` (`screen`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='lookup for KEY, standard: ''KEY_xxx'', custom: ''yyy_KEY''';

--
-- Dump dei dati per la tabella `irp_actions`
--

INSERT INTO `irp_actions` (`keyname`, `screen`, `kicon`, `definition`) VALUES
('KEY_0', '0', 'key_0.png', 'Keyboard digit 0'),
('KEY_1', '1', 'key_1.png', 'Keyboard digit 1'),
('KEY_2', '2', 'key_2.png', 'Keyboard digit 2'),
('KEY_3', '3', 'key_3.png', 'Keyboard digit 3'),
('KEY_4', '4', 'key_4.png', 'Keyboard digit 4'),
('KEY_5', '5', 'key_5.png', 'Keyboard digit 5'),
('KEY_6', '6', 'key_6.png', 'Keyboard digit 6'),
('KEY_7', '7', 'key_7.png', 'Keyboard digit 7'),
('KEY_8', '8', 'key_8.png', 'Keyboard digit 8'),
('KEY_9', '9', 'key_9.png', 'Keyboard digit 9'),
('KEY_BACK', 'BACK', 'key_back.png', 'Instantly go back in time'),
('KEY_BLUE', 'BLUE', 'key_blue.png', 'IR Blue key'),
('KEY_CHANNEL', 'CHANNEL', 'key_channel.png', 'Change program/channel'),
('KEY_CHANNELDOWN', 'CHANNELDOWN', 'key_channeldown.png', 'Decrease channel sequencially'),
('KEY_CHANNELUP', 'CHANNELUP', 'key_channelup.png', 'Increase channel sequencially'),
('KEY_DOWN', 'DOWN', 'key_down.png', 'Down key'),
('KEY_ESC', 'ESC', 'key_esc.png', 'Cancel current operation'),
('KEY_EXIT', 'EXIT', 'key_exit.png', 'Exit application,'),
('KEY_FORWARD', 'FORWARD', 'key_forward.png', 'Instantly advance in time'),
('KEY_GREEN', 'GREEN', 'key_green.png', 'IR Green Key'),
('KEY_HOMEPAGE', 'HOMEPAGE', 'key_homepage.png', 'Navigate to Homepage'),
('KEY_INFO', 'INFO', 'key_info.png', 'Open On Screen Display (OSD)'),
('KEY_LANGUAGE', 'LANGUAGE', 'key_language.png', 'Select Language'),
('KEY_LEFT', 'LEFT', 'key_left.png', 'Left key'),
('KEY_MENU', 'MENU', 'key_menu.png', 'Call application menu'),
('KEY_MODE', 'MODE', 'key_mode.png', 'Change sound mode (MONO/STEREO/3DS)'),
('KEY_MUTE', 'MUTE', 'key_mute.png', 'Mute/unmute audio'),
('KEY_OK', 'OK', 'key_ok.png', 'Send a confirmation code to application'),
('KEY_PAUSE', 'PAUSE', 'key_pause.png', 'Pause sroweam'),
('KEY_PLAY', 'PLAY', 'key_play.png', 'Play movie at the normal timeshift'),
('KEY_POWER', 'POWER', 'key_power.png', 'Turn on/off system (computer)'),
('KEY_POWER2', 'POWER2', 'key_power2.png', 'Turn on/off application (TV,DVD..)'),
('KEY_RED', 'RED', 'key_red.png', 'IR Red key'),
('KEY_REPLY', 'REPLY', 'key_reply.png', 'Show hidden text'),
('KEY_RIGHT', 'RIGHT', 'key_right.png', 'Right key'),
('KEY_STOP', 'STOP', 'key_stop.png', 'Stop sroweam'),
('KEY_SUBTITLE', 'SUBTITLE', 'key_subtitle.png', 'Turn on/off the subtitle (TELETEXT)'),
('KEY_SCREEN', 'SCREEN', 'key_screen.png', 'Select screen aspect ratio (4:3/16:9)'),
('KEY_TEXT', 'TEXT', 'key_text.png', 'Activate/change closed caption mode (TELETEXT)'),
('KEY_TIME', 'TIME', 'key_time.png', 'Activate time shift mode'),
('KEY_TV', 'TV', 'key_tv.png', 'Select tv mode'),
('KEY_UP', 'UP', 'key_up.png', 'Up key'),
('KEY_VCR', 'VCR', 'key_vcr.png', 'Select VCR mode'),
('KEY_VIDEO', 'VIDEO', 'key_video.png', 'Alternate between input modes'),
('KEY_VIDEO_PREV', 'VIDEO_PREV', 'key_video_prev.png', 'TV background on TELETEXT'),
('KEY_VOLUMEDOWN', 'VOLUMEDOWN', 'key_volumedown.png', 'Decrease volume'),
('KEY_VOLUMEUP', 'VOLUMEUP', 'key_volumeup.png', 'Increase volume'),
('KEY_YELLOW', 'YELLOW', 'key_yellow.png', 'IR Blue keyIR Yellow key'),
('KEY_ZOOM', 'ZOOM', 'key_zoom.png', 'Put device into zoom/full screen mode'),
('HOLD_KEY', 'HOLD', 'hold_key.png', '&#039;freeze&#039; actual TELETEXT page'),
('FAV_PAGES_KEY', 'FAV_PAGES', 'fav_pages_key.png', 'Set favourite pages (TELETEXT)'),
('PSCAN100HZ_KEY', '100HZ', 'pscan100hz_key.png', '100 Hz scan mode on/off'),
('SWAP_KEY', 'SWAP', 'swap_key.png', 'swap to previous channel/page'),
('UNK1_KEY', 'UNK1', 'unk1_key.png', 'undocumented key'),
('UNK2_KEY', 'UNK2', 'unk2_key.png', 'undocumented key'),
('SHOWTIME_KEY', 'SHOWTIME', 'showtime_key.png', 'Show time on screen'),
('STATUS_D2_KEY', 'STATUS_D2', 'status_d2_key.png', 'fake_key,storage;'),
('FAN_KEY', 'FAN', 'fan_key.png', NULL),
('TIMEON_KEY', 'TIMEON', 'timeon_key.png', NULL),
('SWINGOFF_KEY', 'SWINGOFF', 'swingoff_key.png', NULL),
('FASTCOLD_KEY', 'FASTCOLD', 'fastcold_key.png', NULL),
('TIMEOFF_KEY', 'TIMEOFF', 'timeoff_key.png', NULL),
('SWINGON_KEY', 'SWINGON', 'swingon_key.png', NULL),
('FASTHEAT_KEY', 'FASTHEAT', 'fastheat_key.png', NULL),
('KEY_SETUP', 'SETUP', 'key_setup.png', NULL),
('KEY_SAT', 'SAT', 'key_sat.png', NULL),
('KEY_DVR', 'DVR', 'key_dvr.png', NULL),
('KEY_DVD', 'DVD', 'key_dvd.png', NULL),
('KEY_AUX', 'AUX', 'key_aux.png', NULL),
('KEY_PREVIOUS', 'PREVIOUS', 'key_previous.png', NULL),
('KEY_NEXT', 'NEXT', 'key_next.png', NULL),
('KEY_AUDIO', 'AUDIO', 'key_audio.png', NULL),
('KEY_EPG', 'EPG', 'key_epg.png', NULL),
('KEY_FAVORITES', 'FAVORITES', 'key_favorites.png', NULL),
('KEY_DIGITS', 'DIGITS', 'key_digits.png', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `irp_brands`
--

DROP TABLE IF EXISTS `irp_brands`;
CREATE TABLE IF NOT EXISTS `irp_brands` (
  `brand` char(30) NOT NULL COMMENT 'brand name (no spaces)',
  `brn_url` varchar(100) default NULL COMMENT 'reference',
  `bicon` char(100) default NULL COMMENT 'brand icon for UI (in ./icons)',
  PRIMARY KEY  (`brand`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='lookup for brands';

--
-- Dump dei dati per la tabella `irp_brands`
--

INSERT INTO `irp_brands` (`brand`, `brn_url`, `bicon`) VALUES
('HITACHI', 'http://www.hitachi.com/', 'hitachi.gif'),
('CHUNGHOP', 'http://www.chunghop.com/en/index.php', 'chunghop.png'),
('Fujitsu', 'http://www.fujitsu.com', 'fujitsu.gif'),
('united', 'http://www.recospa.com/index.php', 'united_trademark_logo.jpg');

-- --------------------------------------------------------

--
-- Struttura della tabella `irp_devcommands`
--

DROP TABLE IF EXISTS `irp_devcommands`;
CREATE TABLE IF NOT EXISTS `irp_devcommands` (
  `iddevice` int(11) NOT NULL COMMENT 'fk device',
  `keyname` char(30) NOT NULL COMMENT 'fk key',
  `role` enum('USE','primary','broadcast','unused') NOT NULL default 'USE' COMMENT 'for devices accepting multiple IR codes, max 10 char',
  `idstream` int(11) default NULL COMMENT 'fk stream',
  `drepeat` int(2) NOT NULL default '1' COMMENT 'required send repetions',
  `notes` char(100) default NULL COMMENT 'notes on key use',
  PRIMARY KEY  (`iddevice`,`keyname`,`role`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='device - stream definitions';

--
-- Dump dei dati per la tabella `irp_devcommands`
--

INSERT INTO `irp_devcommands` (`iddevice`, `keyname`, `role`, `idstream`, `drepeat`, `notes`) VALUES
(1, 'KEY_0', 'USE', 31, 1, NULL),
(1, 'KEY_1', 'USE', 21, 1, NULL),
(1, 'KEY_2', 'USE', 22, 1, NULL),
(1, 'KEY_3', 'USE', 23, 1, NULL),
(1, 'KEY_4', 'USE', 24, 1, NULL),
(1, 'KEY_5', 'USE', 25, 1, NULL),
(1, 'KEY_6', 'USE', 26, 1, NULL),
(1, 'KEY_7', 'USE', 27, 1, NULL),
(1, 'KEY_8', 'USE', 28, 1, NULL),
(1, 'KEY_9', 'USE', 29, 1, NULL),
(1, 'KEY_BLUE', 'USE', 7, 1, NULL),
(1, 'KEY_CHANNEL', 'USE', 32, 1, NULL),
(1, 'KEY_CHANNELDOWN', 'USE', 20, 1, NULL),
(1, 'KEY_CHANNELUP', 'USE', 18, 1, NULL),
(1, 'KEY_DOWN', 'USE', 13, 1, NULL),
(1, 'KEY_ESC', 'USE', 14, 1, NULL),
(1, 'KEY_EXIT', 'USE', 33, 1, NULL),
(1, 'KEY_GREEN', 'USE', 5, 1, NULL),
(1, 'KEY_INFO', 'USE', 37, 1, NULL),
(1, 'KEY_LANGUAGE', 'USE', 38, 1, NULL),
(1, 'KEY_LEFT', 'USE', 10, 1, NULL),
(1, 'KEY_MENU', 'USE', 16, 1, NULL),
(1, 'KEY_MODE', 'USE', 35, 1, NULL),
(1, 'KEY_MUTE', 'USE', 3, 1, NULL),
(1, 'KEY_OK', 'USE', 11, 1, NULL),
(1, 'KEY_POWER2', 'USE', 1, 1, NULL),
(1, 'KEY_RED', 'USE', 4, 1, NULL),
(1, 'KEY_RIGHT', 'USE', 12, 1, NULL),
(1, 'KEY_SCREEN', 'USE', 2, 1, NULL),
(1, 'KEY_TIME', 'USE', 36, 1, NULL),
(1, 'KEY_UP', 'USE', 9, 1, NULL),
(1, 'KEY_VCR', 'USE', NULL, 1, NULL),
(1, 'KEY_VOLUMEDOWN', 'USE', 19, 1, NULL),
(1, 'KEY_VOLUMEUP', 'USE', 17, 1, NULL),
(1, 'KEY_YELLOW', 'USE', 6, 1, NULL),
(1, 'PSCAN100HZ_KEY', 'USE', 15, 1, NULL),
(1, 'SWAP_KEY', 'USE', 30, 1, NULL),
(1, 'UNK1_KEY', 'USE', 8, 1, NULL),
(1, 'UNK2_KEY', 'USE', NULL, 1, NULL),
(2, 'KEY_DOWN', 'USE', NULL, 1, NULL),
(2, 'KEY_POWER2', 'USE', NULL, 1, NULL),
(2, 'KEY_UP', 'USE', NULL, 1, NULL),
(2, 'KEY_MODE', 'USE', NULL, 1, NULL),
(2, 'STATUS_D2_KEY', 'USE', 87, 1, NULL),
(2, 'FAN_KEY', 'USE', NULL, 1, NULL),
(2, 'TIMEON_KEY', 'USE', NULL, 1, NULL),
(2, 'SWINGOFF_KEY', 'USE', NULL, 1, NULL),
(2, 'FASTCOLD_KEY', 'USE', 40, 1, NULL),
(2, 'TIMEOFF_KEY', 'USE', NULL, 1, NULL),
(2, 'SWINGON_KEY', 'USE', NULL, 1, NULL),
(2, 'FASTHEAT_KEY', 'USE', 41, 1, NULL),
(3, 'KEY_0', 'USE', NULL, 1, NULL),
(3, 'KEY_VIDEO', 'USE', 82, 1, NULL),
(3, 'KEY_UP', 'USE', 84, 1, NULL),
(3, 'KEY_6', 'USE', 81, 1, NULL),
(3, 'KEY_4', 'USE', NULL, 1, NULL),
(3, 'KEY_5', 'USE', 80, 1, NULL),
(3, 'KEY_2', 'USE', 78, 1, NULL),
(3, 'KEY_7', 'USE', NULL, 1, NULL),
(3, 'KEY_8', 'USE', NULL, 1, NULL),
(3, 'KEY_9', 'USE', NULL, 1, NULL),
(3, 'KEY_INFO', 'USE', NULL, 1, NULL),
(3, 'KEY_3', 'USE', 79, 1, NULL),
(3, 'KEY_MUTE', 'USE', NULL, 1, NULL),
(3, 'KEY_POWER2', 'USE', NULL, 1, NULL),
(3, 'KEY_1', 'USE', 77, 1, NULL),
(3, 'KEY_MODE', 'USE', 83, 1, NULL),
(1, 'KEY_AUDIO', 'USE', 38, 1, NULL),
(1, 'KEY_BACK', 'USE', 58, 1, NULL),
(1, 'KEY_DIGITS', 'USE', 30, 1, NULL),
(1, 'KEY_FAVORITES', 'USE', 57, 1, NULL),
(1, 'KEY_FORWARD', 'USE', 36, 1, NULL),
(1, 'KEY_PAUSE', 'USE', 32, 1, NULL),
(1, 'KEY_PLAY', 'USE', 60, 1, NULL),
(1, 'KEY_STOP', 'USE', 37, 1, NULL),
(1, 'KEY_TEXT', 'USE', 34, 1, NULL),
(1, 'KEY_VIDEO', 'USE', 58, 1, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `irp_devices`
--

DROP TABLE IF EXISTS `irp_devices`;
CREATE TABLE IF NOT EXISTS `irp_devices` (
  `iddevice` int(11) NOT NULL auto_increment,
  `brand` char(30) NOT NULL COMMENT 'from brand table',
  `dev_model` char(30) NOT NULL,
  `kind` char(30) NOT NULL COMMENT 'The kind of equipment, from devtypes',
  `dev_url` varchar(100) default NULL COMMENT 'link to infos (in ./documents/<type> or remote)',
  `group` char(30) NOT NULL COMMENT 'for UI: from mygroups table',
  `status` enum('visible','hidden') NOT NULL default 'visible' COMMENT 'fot UI',
  `photo` char(100) default NULL COMMENT 'device img (in ./photo/)',
  `dicon` char(100) default NULL COMMENT 'device picture (in ./icons/)',
  `description` varchar(1000) default NULL COMMENT 'free',
  PRIMARY KEY  (`iddevice`),
  UNIQUE KEY `devicename` (`brand`,`dev_model`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='device definitions' AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `irp_devices`
--

INSERT INTO `irp_devices` (`iddevice`, `brand`, `dev_model`, `kind`, `dev_url`, `group`, `status`, `photo`, `dicon`, `description`) VALUES
(1, 'HITACHI', 'CL32WF740AN', 'TVset', './documents/remotes/c28wf523n_instruction_manual.pdf', 'livingroom', 'visible', 'TV_CL32WF740AN.jpg', 'TV_CRT.png', '32" CRT TV set, with DVB-S'),
(2, 'Fujitsu', 'aircon_test', 'aircon', NULL, 'bedroom', 'visible', NULL, NULL, 'only for test custom gui'),
(3, 'united', 'LED22H26', 'TVset', NULL, 'studio', 'visible', NULL, NULL, 'for test RAW learning');

-- --------------------------------------------------------

--
-- Struttura della tabella `irp_devrem`
--

DROP TABLE IF EXISTS `irp_devrem`;
CREATE TABLE IF NOT EXISTS `irp_devrem` (
  `iddevice` int(11) NOT NULL COMMENT 'fk device',
  `idremote` int(11) NOT NULL COMMENT 'fk remote',
  `code` char(10) NOT NULL default '0' COMMENT 'for multi remotes, first char alpha',
  `idprotocol` int(11) default NULL COMMENT 'fk protocol',
  `mode1` char(1) NOT NULL default 'A' COMMENT 'for modal keys (A=all)',
  `mode2` char(1) default NULL,
  `mode3` char(1) default NULL,
  `notes` char(200) default NULL,
  PRIMARY KEY  (`iddevice`,`idremote`,`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='device - remote association';

--
-- Dump dei dati per la tabella `irp_devrem`
--

INSERT INTO `irp_devrem` (`iddevice`, `idremote`, `code`, `idprotocol`, `mode1`, `mode2`, `mode3`, `notes`) VALUES
(1, 1, '0', 2, 'T', NULL, NULL, 'only T mode, I use a DVB-S, so no TELETEXT keys'),
(2, 4, 'A695', 3, 'F', NULL, NULL, NULL),
(3, 5, '0', 4, 'T', NULL, NULL, NULL),
(1, 2, 'C0023', 2, 'T', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `irp_devtypes`
--

DROP TABLE IF EXISTS `irp_devtypes`;
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
('SAT', 'satico01.png'),
('HiFi', 'HiFiico01.png'),
('DVR', 'DVRico01.png'),
('DVD', 'DVDico01.png');

-- --------------------------------------------------------

--
-- Struttura della tabella `irp_mygroups`
--

DROP TABLE IF EXISTS `irp_mygroups`;
CREATE TABLE IF NOT EXISTS `irp_mygroups` (
  `group` char(30) NOT NULL COMMENT 'to group devices on UI',
  `icon` char(30) NOT NULL COMMENT 'group icon for UI (in ./icons)',
  PRIMARY KEY  (`group`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='lookup for groups, e.g. location (for UI)';

--
-- Dump dei dati per la tabella `irp_mygroups`
--

INSERT INTO `irp_mygroups` (`group`, `icon`) VALUES
('livingroom', ''),
('bedroom', ''),
('extra', ''),
('studio', '');

-- --------------------------------------------------------

--
-- Struttura della tabella `irp_protocols`
--

DROP TABLE IF EXISTS `irp_protocols`;
CREATE TABLE IF NOT EXISTS `irp_protocols` (
  `idprotocol` int(11) NOT NULL auto_increment,
  `name` char(30) NOT NULL COMMENT 'protocol name (no spaces, valid php label)',
  `IRP` varchar(1000) default NULL COMMENT 'IRP notation',
  `prt_url` varchar(100) default NULL COMMENT 'reference (in ./documents/protocols or remote)',
  `phpadapter` char(30) default NULL,
  `notes` varchar(1000) default NULL COMMENT 'tech notes on protocol',
  PRIMARY KEY  (`idprotocol`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='protocol definitions, with IRP' AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `irp_protocols`
--

INSERT INTO `irp_protocols` (`idprotocol`, `name`, `IRP`, `prt_url`, `phpadapter`, `notes`) VALUES
(2, 'NEC1_16', '{38.0k,562}<1,-1|1,-3>(16,-8,D:8,~D:8,F:8,~F:8,1,^110m,(16,-4,1,^110m)*)', './documents/protocols/NEC1_16.html', NULL, 'new IRP (2017 m.sillano)'),
(3, 'Fujitsu_Aircon', '{38.4k,413}<1,-1|1,-3>(8,-4,20:8,99:8,0:8,16:8,16:8,254:8,9:8,48:8,H:8,J:8, K:8, L:8, M:8,N:8,32:8,Z:8,1,-104.3m)+ {H=16*A + wOn, J=16*C + B, K=16*E:4 + D:4, L=tOff:8, M=tOff:3:8+fOff*8+16*tOn:4, N=tOn:7:4+128*fOn,Z=256-(H+J+K+L+M+N+80)%256, A=H:4:4,wOn=H:1,B=J:4,C=J:4:4,D=K:4,E=K:4:4,tOff=L+256*M:3, tOn=M:4:4+16*N:7,fOn=N:1:7,fOff=M:1:3}', './documents/protocols/FujitsuIR.pdf', 'Fujitsu_Aircon_adapter.php', 'only for testing dynamic keys and phpgui'),
(4, 'unknown01', NULL, NULL, NULL, 'test for learning RAW');

-- --------------------------------------------------------

--
-- Struttura della tabella `irp_remcommands`
--

DROP TABLE IF EXISTS `irp_remcommands`;
CREATE TABLE IF NOT EXISTS `irp_remcommands` (
  `idremkey` int(11) NOT NULL COMMENT 'fk remkey',
  `code` char(10) NOT NULL default '0' COMMENT 'for multi remote, first char alpha',
  `idstream` int(11) default NULL COMMENT 'fk stream',
  PRIMARY KEY  (`idremkey`,`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `irp_remcommands`
--

INSERT INTO `irp_remcommands` (`idremkey`, `code`, `idstream`) VALUES
(1, '0', 1),
(2, '0', 2),
(3, '0', 3),
(4, '0', 4),
(5, '0', 5),
(6, '0', 6),
(7, '0', 7),
(9, '0', 8),
(11, '0', 9),
(12, '0', 9),
(13, '0', 10),
(14, '0', 10),
(15, '0', 11),
(16, '0', 11),
(17, '0', 12),
(18, '0', 12),
(19, '0', 13),
(20, '0', 13),
(21, '0', 14),
(22, '0', 15),
(23, '0', 16),
(24, '0', 16),
(25, '0', 17),
(26, '0', 18),
(27, '0', 19),
(28, '0', 20),
(29, '0', 21),
(30, '0', 22),
(31, '0', 23),
(32, '0', 24),
(33, '0', 25),
(34, '0', 26),
(35, '0', 27),
(36, '0', 28),
(37, '0', 29),
(38, '0', 30),
(39, '0', 31),
(40, '0', 32),
(41, '0', 32),
(45, '0', 33),
(46, '0', 34),
(48, '0', 35),
(50, '0', 36),
(52, '0', 37),
(53, '0', 38),
(54, 'A695', 87),
(63, 'A695', 40),
(66, 'A695', 41),
(73, '0', 77),
(74, '0', 78),
(75, '0', 79),
(77, '0', 80),
(78, '0', 81),
(82, '0', 82),
(84, '0', 83),
(85, '0', 84),
(87, 'C0023', 1),
(95, 'C0023', 33),
(97, 'C0023', 34),
(98, 'C0023', 38),
(100, 'C0023', 57),
(101, 'C0023', 16),
(102, 'C0023', 9),
(103, 'C0023', 33),
(104, 'C0023', 10),
(105, 'C0023', 11),
(106, 'C0023', 12),
(107, 'C0023', 13),
(108, 'C0023', 36),
(109, 'C0023', 5),
(110, 'C0023', 6),
(111, 'C0023', 7),
(112, 'C0023', 17),
(113, 'C0023', 3),
(114, 'C0023', 18),
(115, 'C0023', 19),
(116, 'C0023', 37),
(117, 'C0023', 20),
(118, 'C0023', 58),
(119, 'C0023', 37),
(120, 'C0023', 36),
(121, 'C0023', 59),
(122, 'C0023', 60),
(123, 'C0023', 32),
(124, 'C0023', 21),
(125, 'C0023', 22),
(126, 'C0023', 23),
(127, 'C0023', 24),
(128, 'C0023', 25),
(129, 'C0023', 26),
(130, 'C0023', 27),
(131, 'C0023', 28),
(132, 'C0023', 29),
(133, 'C0023', 58),
(134, 'C0023', 31),
(135, 'C0023', 30);

-- --------------------------------------------------------

--
-- Struttura della tabella `irp_remkeys`
--

DROP TABLE IF EXISTS `irp_remkeys`;
CREATE TABLE IF NOT EXISTS `irp_remkeys` (
  `idremkey` int(11) NOT NULL auto_increment,
  `idremote` int(11) NOT NULL COMMENT 'fk remote',
  `keyname` char(30) NOT NULL COMMENT 'fk key',
  `row` int(2) default NULL COMMENT 'position',
  `col` int(2) default NULL COMMENT 'position',
  `mode` char(30) default 'A' COMMENT 'to handle multiple modal keys',
  `clickAction` varchar(300) default NULL COMMENT 'jscript for ''onClick''. use doublequotes (") and (;)!',
  `tooltip` char(100) default NULL COMMENT 'tooltip',
  PRIMARY KEY  (`idremkey`),
  UNIQUE KEY `remkey` (`idremote`,`keyname`),
  KEY `position` (`idremote`,`row`,`col`,`mode`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='modal virtual keys and layout definition' AUTO_INCREMENT=136 ;

--
-- Dump dei dati per la tabella `irp_remkeys`
--

INSERT INTO `irp_remkeys` (`idremkey`, `idremote`, `keyname`, `row`, `col`, `mode`, `clickAction`, `tooltip`) VALUES
(1, 1, 'KEY_POWER2', 1, 1, 'T,X,V', NULL, 'Turn on/off application (TV,DVD..)'),
(2, 1, 'KEY_SCREEN', 2, 2, 'T,V', NULL, 'Select screen aspect ratio (4:3/16:9)'),
(3, 1, 'KEY_MUTE', 2, 3, 'T,X,V', NULL, 'Mute/unmute audio'),
(4, 1, 'KEY_RED', 3, 1, 'T,X,V', NULL, 'IR Red key'),
(5, 1, 'KEY_GREEN', 3, 2, 'T,X,V', NULL, 'IR Green Key'),
(6, 1, 'KEY_YELLOW', 3, 3, 'T,X,V', NULL, 'IR Blue keyIR Yellow key'),
(7, 1, 'KEY_BLUE', 3, 4, 'T,X,V', NULL, 'IR Blue key'),
(8, 1, 'KEY_VCR', 4, 1, 'T,X,V', NULL, 'Select VCR mode'),
(9, 1, 'UNK1_KEY', 4, 2, 'T,X,V', NULL, 'undocumented key'),
(10, 1, 'UNK2_KEY', 4, 3, 'T,X,V', NULL, 'undocumented key'),
(11, 1, 'KEY_UP', 5, 2, 'T,X', NULL, 'Up key'),
(12, 1, 'KEY_PLAY', 5, 2, 'V', NULL, 'Play movie at the normal timeshift'),
(13, 1, 'KEY_LEFT', 6, 1, 'T,X', NULL, 'Left key'),
(14, 1, 'KEY_BACK', 6, 1, 'V', NULL, 'Instantly go back in time'),
(15, 1, 'KEY_OK', 6, 2, 'T,X', NULL, 'Send a confirmation code to application'),
(16, 1, 'KEY_PAUSE', 6, 2, 'V', NULL, 'Pause sroweam'),
(17, 1, 'KEY_RIGHT', 6, 3, 'T,X', NULL, 'Right key'),
(18, 1, 'KEY_FORWARD', 6, 3, 'V', NULL, 'Instantly advance in time'),
(19, 1, 'KEY_DOWN', 7, 2, 'T,X', NULL, 'Down key'),
(20, 1, 'KEY_STOP', 7, 2, 'V', NULL, 'Stop sroweam'),
(21, 1, 'KEY_ESC', 8, 1, 'T,X,V', NULL, 'Cancel current operation'),
(22, 1, 'PSCAN100HZ_KEY', 8, 2, 'T,X,V', NULL, '100 Hz scan mode on/off'),
(23, 1, 'KEY_MENU', 8, 3, 'T,V', NULL, 'Call application menu'),
(24, 1, 'FAV_PAGES_KEY', 8, 3, 'X', NULL, 'Set favourite pages (TELETEXT)'),
(25, 1, 'KEY_VOLUMEUP', 9, 1, 'T,X,V', NULL, 'Increase volume'),
(26, 1, 'KEY_CHANNELUP', 9, 3, 'T,X,V', NULL, 'Increase channel sequencially'),
(27, 1, 'KEY_VOLUMEDOWN', 10, 1, 'T,X,V', NULL, 'Decrease volume'),
(28, 1, 'KEY_CHANNELDOWN', 10, 3, 'T,X,V', NULL, 'Decrease channel sequencially'),
(29, 1, 'KEY_1', 11, 1, 'A', NULL, 'Keyboard digit 1'),
(30, 1, 'KEY_2', 11, 2, 'A', NULL, 'Keyboard digit 2'),
(31, 1, 'KEY_3', 11, 3, 'T,X,V', NULL, 'Keyboard digit 3'),
(32, 1, 'KEY_4', 12, 1, 'T,X,V', NULL, 'Keyboard digit 4'),
(33, 1, 'KEY_5', 12, 2, 'T,X,V', NULL, 'Keyboard digit 5'),
(34, 1, 'KEY_6', 12, 3, 'T,X,V', NULL, 'Keyboard digit 6'),
(35, 1, 'KEY_7', 13, 1, 'T,X,V', NULL, 'Keyboard digit 7'),
(36, 1, 'KEY_8', 13, 2, 'T,X,V', NULL, 'Keyboard digit 8'),
(37, 1, 'KEY_9', 13, 3, 'T,X,V', NULL, 'Keyboard digit 9'),
(38, 1, 'SWAP_KEY', 14, 1, 'T,X,V', NULL, 'swap to previous channel/page'),
(39, 1, 'KEY_0', 14, 2, 'A', NULL, 'Keyboard digit 0'),
(40, 1, 'KEY_CHANNEL', 14, 3, 'T,V', NULL, 'Change program/channel'),
(41, 1, 'HOLD_KEY', 14, 3, 'X', NULL, '&#039;freeze&#039; actual TELETEXT page'),
(42, 1, 'KEY_HOMEPAGE', 15, 1, 'X', NULL, 'Navigate to Homepage'),
(43, 1, 'KEY_SUBTITLE', 15, 2, 'X', NULL, 'Turn on/off the subtitle (TELETEXT)'),
(44, 1, 'KEY_TV', 15, 3, 'X', NULL, 'Select tv mode'),
(45, 1, 'KEY_EXIT', 15, 3, 'T,V', NULL, 'Exit application,'),
(46, 1, 'KEY_TEXT', 15, 4, 'X', NULL, 'Activate/change closed caption mode (TELETEXT)'),
(47, 1, 'KEY_REPLY', 16, 1, 'X', NULL, 'Show hidden text'),
(48, 1, 'KEY_MODE', 16, 1, 'T,V', NULL, 'Change sound mode (MONO/STEREO/3DS)'),
(49, 1, 'KEY_VIDEO_PREV', 16, 2, 'X', NULL, 'TV background on TELETEXT'),
(50, 1, 'KEY_TIME', 16, 2, 'T,V', NULL, 'Activate time shift mode'),
(51, 1, 'KEY_ZOOM', 16, 3, 'X', NULL, 'Put device into zoom/full screen mode'),
(52, 1, 'KEY_INFO', 16, 3, 'T,V', NULL, 'Open On Screen Display (OSD)'),
(53, 1, 'KEY_LANGUAGE', 16, 4, 'T,X,V', NULL, 'Select Language'),
(54, 4, 'STATUS_D2_KEY', 0, 0, 'A', '', 'fake_key,storage;'),
(55, 4, 'KEY_POWER2', 1, 1, 'F', 'onClick=''sendOnOff($url);''', 'Sends on/off'),
(56, 4, 'KEY_UP', 1, 2, 'F', 'onClick=''document.getElementById("tempplus").click();''', 'Up temperature'),
(57, 4, 'KEY_MODE', 1, 3, 'F', 'onClick=''nextValue("amode");''', 'Change mode'),
(58, 4, 'UNK1_KEY', 2, 1, 'S', NULL, 'undocumented key'),
(59, 4, 'KEY_DOWN', 2, 2, 'F', 'onClick=''document.getElementById("tempminus").click();''', 'Down Temperature'),
(60, 4, 'FAN_KEY', 2, 3, 'F', 'onClick=''nextValue("fan");''', 'Round robin fan'),
(61, 4, 'TIMEON_KEY', 3, 1, 'F', 'onClick=''setValue("time",3);send($url);''', 'Sends time as ON time'),
(62, 4, 'SWINGOFF_KEY', 3, 2, 'F', 'onClick=''setValue("swing",0);send($url);''', 'Sends OFF swing'),
(63, 4, 'FASTCOLD_KEY', 3, 3, 'F', NULL, 'Static, sends max cold'),
(64, 4, 'TIMEOFF_KEY', 4, 1, 'F', 'onClick=''setValue("time",2);send($url);''', 'Send time as OFF time'),
(65, 4, 'SWINGON_KEY', 4, 2, 'F', 'onClick=''setValue("swing",3);send($url);''', 'Send ON swing'),
(66, 4, 'FASTHEAT_KEY', 4, 3, 'F', NULL, 'Static, sends max heat'),
(67, 4, 'KEY_TIME', 5, 1, 'S', NULL, 'not set'),
(68, 4, 'KEY_SETUP', 6, 1, 'S', NULL, 'not set'),
(69, 4, 'KEY_OK', 6, 3, 'S', NULL, 'not set'),
(70, 5, 'KEY_POWER2', 1, 1, 'T,X', NULL, 'Turn on/off application (TV,DVD..)'),
(71, 5, 'KEY_INFO', 1, 3, 'T', NULL, 'Open On Screen Display (OSD)'),
(72, 5, 'KEY_MUTE', 1, 4, 'T,X', NULL, 'Mute/unmute audio'),
(73, 5, 'KEY_1', 2, 1, 'T,X', NULL, 'Keyboard digit 1'),
(74, 5, 'KEY_2', 2, 2, 'T,X', NULL, 'Keyboard digit 2'),
(75, 5, 'KEY_3', 2, 3, 'T,X', NULL, 'Keyboard digit 3'),
(76, 5, 'KEY_4', 3, 1, 'T,X', NULL, 'Keyboard digit 4'),
(77, 5, 'KEY_5', 3, 2, 'T,X', NULL, 'Keyboard digit 5'),
(78, 5, 'KEY_6', 3, 3, 'T,X', NULL, 'Keyboard digit 6'),
(79, 5, 'KEY_7', 4, 1, 'T,X', NULL, 'Keyboard digit 7'),
(80, 5, 'KEY_8', 4, 2, 'T,X', NULL, 'Keyboard digit 8'),
(81, 5, 'KEY_9', 4, 3, 'T,X', NULL, 'Keyboard digit 9'),
(82, 5, 'KEY_VIDEO', 5, 1, 'T', NULL, 'Alternate between input modes'),
(83, 5, 'KEY_0', 5, 2, 'T,X', NULL, 'Keyboard digit 0'),
(84, 5, 'KEY_MODE', 5, 3, 'T', NULL, 'Change sound mode (MONO/STEREO/3DS)'),
(85, 5, 'KEY_UP', 6, 2, 'T', NULL, 'Up key'),
(86, 2, 'KEY_SETUP', 1, 1, 'S', NULL, ''),
(87, 2, 'KEY_POWER2', 1, 3, 'T', NULL, 'Turn on/off application (TV,DVD..)'),
(88, 2, 'KEY_TV', 2, 1, 'S', NULL, 'Select tv mode'),
(89, 2, 'KEY_SAT', 2, 2, 'S', NULL, ''),
(90, 2, 'KEY_DVR', 2, 3, 'S', NULL, ''),
(91, 2, 'KEY_DVD', 3, 2, 'S', NULL, ''),
(92, 2, 'KEY_AUX', 3, 3, 'S', NULL, ''),
(93, 2, 'KEY_PREVIOUS', 4, 1, 'D', NULL, ''),
(94, 2, 'KEY_NEXT', 4, 2, 'D', NULL, ''),
(95, 2, 'UNK1_KEY', 4, 3, 'T', NULL, 'undocumented key'),
(96, 2, 'KEY_SUBTITLE', 4, 4, 'D', NULL, 'Turn on/off the subtitle (TELETEXT)'),
(97, 2, 'KEY_TEXT', 5, 1, 'T', NULL, 'Activate/change closed caption mode (TELETEXT)'),
(98, 2, 'KEY_AUDIO', 5, 2, 'T', NULL, ''),
(99, 2, 'KEY_EPG', 5, 3, 'D', NULL, ''),
(100, 2, 'KEY_FAVORITES', 5, 4, 'T', NULL, ''),
(101, 2, 'KEY_MENU', 6, 1, 'T', NULL, 'Call application menu'),
(102, 2, 'KEY_UP', 6, 2, 'T,X', NULL, 'Up key'),
(103, 2, 'KEY_EXIT', 6, 3, 'T,V', NULL, 'Exit application,'),
(104, 2, 'KEY_LEFT', 7, 1, 'T,X', NULL, 'Left key'),
(105, 2, 'KEY_OK', 7, 2, 'T,X', NULL, 'Send a confirmation code to application'),
(106, 2, 'KEY_RIGHT', 7, 3, 'T,X', NULL, 'Right key'),
(107, 2, 'KEY_DOWN', 8, 2, 'T,X', NULL, 'Down key'),
(108, 2, 'KEY_RED', 9, 1, 'T', NULL, 'IR Red key'),
(109, 2, 'KEY_GREEN', 9, 2, 'X', NULL, 'IR Green Key'),
(110, 2, 'KEY_YELLOW', 9, 3, 'X', NULL, 'IR Blue keyIR Yellow key'),
(111, 2, 'KEY_BLUE', 9, 4, 'X', NULL, 'IR Blue key'),
(112, 2, 'KEY_VOLUMEUP', 10, 1, 'T,X,V', NULL, 'Increase volume'),
(113, 2, 'KEY_MUTE', 10, 2, 'T,X,V', NULL, 'Mute/unmute audio'),
(114, 2, 'KEY_CHANNELUP', 10, 3, 'T,X,V', NULL, 'Increase channel sequencially'),
(115, 2, 'KEY_VOLUMEDOWN', 11, 1, 'T,X,V', NULL, 'Decrease volume'),
(116, 2, 'KEY_INFO', 11, 2, 'T', NULL, 'Open On Screen Display (OSD)'),
(117, 2, 'KEY_CHANNELDOWN', 11, 3, 'T,X,V', NULL, 'Decrease channel sequencially'),
(118, 2, 'KEY_BACK', 12, 1, 'T', NULL, 'Instantly go back in time'),
(119, 2, 'KEY_STOP', 12, 2, 'T', NULL, 'Stop sroweam'),
(120, 2, 'KEY_FORWARD', 12, 3, 'T', NULL, 'Instantly advance in time'),
(121, 2, 'UNK2_KEY', 13, 1, 'T', NULL, 'undocumented key'),
(122, 2, 'KEY_PLAY', 13, 2, 'T', NULL, 'Play movie at the normal timeshift'),
(123, 2, 'KEY_PAUSE', 13, 3, 'T', NULL, 'Pause sroweam'),
(124, 2, 'KEY_1', 14, 1, 'T,X,V', NULL, 'Keyboard digit 1'),
(125, 2, 'KEY_2', 14, 2, 'T,X,V', NULL, 'Keyboard digit 2'),
(126, 2, 'KEY_3', 14, 3, 'T,X,V', NULL, 'Keyboard digit 3'),
(127, 2, 'KEY_4', 15, 1, 'T,X,V', NULL, 'Keyboard digit 4'),
(128, 2, 'KEY_5', 15, 2, 'T,X,V', NULL, 'Keyboard digit 5'),
(129, 2, 'KEY_6', 15, 3, 'T,X,V', NULL, 'Keyboard digit 6'),
(130, 2, 'KEY_7', 16, 1, 'T,X,V', NULL, 'Keyboard digit 7'),
(131, 2, 'KEY_8', 16, 2, 'T,X,V', NULL, 'Keyboard digit 8'),
(132, 2, 'KEY_9', 16, 3, 'T,X,V', NULL, 'Keyboard digit 9'),
(133, 2, 'KEY_VIDEO', 17, 1, 'T,V', NULL, 'Alternate between input modes'),
(134, 2, 'KEY_0', 17, 2, 'T,X,V', NULL, 'Keyboard digit 0'),
(135, 2, 'KEY_DIGITS', 17, 3, 'T,V', NULL, '');

-- --------------------------------------------------------

--
-- Struttura della tabella `irp_remotes`
--

DROP TABLE IF EXISTS `irp_remotes`;
CREATE TABLE IF NOT EXISTS `irp_remotes` (
  `idremote` int(11) NOT NULL auto_increment,
  `brand` char(30) NOT NULL COMMENT 'fk brand',
  `rem_model` char(30) NOT NULL COMMENT 'no spaces',
  `rem_url` varchar(100) default NULL COMMENT 'link to infos (in ./documents/remotes or web)',
  `status` enum('visible','hidden') NOT NULL default 'visible' COMMENT 'for UI',
  `modes` char(60) default 'A=all' COMMENT 'to  handle multiple modal keys',
  `photo` char(100) default NULL COMMENT 'IR remote command picture (in ./photo/)',
  `phpgui` char(30) default NULL COMMENT 'template for UI',
  `description` varchar(1000) default NULL COMMENT 'free',
  PRIMARY KEY  (`idremote`),
  UNIQUE KEY `brandmodel` (`brand`,`rem_model`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='remote definitions' AUTO_INCREMENT=6 ;

--
-- Dump dei dati per la tabella `irp_remotes`
--

INSERT INTO `irp_remotes` (`idremote`, `brand`, `rem_model`, `rem_url`, `status`, `modes`, `photo`, `phpgui`, `description`) VALUES
(1, 'HITACHI', 'CLE941', './documents/remotes/c28wf523n_instruction_manual.pdf', 'visible', 'T=TV|X=TXT|V=VCR', 'RE_CLE941.png', NULL, 'original remote control'),
(2, 'CHUNGHOP', 'E936', 'http://www.chunghop.com/en/product_detail.php?ProId=542', 'visible', 'T=TV|X=TXT|V=VCR|S=self', 'RE_E936.png', NULL, 'universal remote control (TV)'),
(4, 'CHUNGHOP', 'AC188S', 'http://www.chunghop.com/en/product_detail.php?ProId=369', 'visible', 'F=aircon|S=self', 'RE_AC188S.png', 'aircon_std.php', 'only for testing dynamic keys and phpgui'),
(5, 'united', 'unknown', NULL, 'visible', 'T=TV|X=TXT|M=media', 'RE_united_unk1.jpg', NULL, 'for RAW test');

-- --------------------------------------------------------

--
-- Struttura della tabella `irp_streams`
--

DROP TABLE IF EXISTS `irp_streams`;
CREATE TABLE IF NOT EXISTS `irp_streams` (
  `idstream` int(11) NOT NULL auto_increment COMMENT 'pk',
  `idprotocol` int(11) NOT NULL COMMENT 'fk protocol',
  `HEX` varchar(200) default NULL,
  `dataProtocol` varchar(200) default NULL,
  `dataDevice` varchar(200) default NULL,
  `repeat` int(2) NOT NULL default '1' COMMENT 'RAW repetitions',
  `CRCRAW` char(8) default NULL,
  `RAW1` varchar(2000) default NULL COMMENT 'data ready to send to Arduino',
  PRIMARY KEY  (`idstream`),
  UNIQUE KEY `hprotocol` (`idprotocol`,`HEX`),
  KEY `rprotocol` (`idprotocol`,`CRCRAW`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=88 ;

--
-- Dump dei dati per la tabella `irp_streams`
--

INSERT INTO `irp_streams` (`idstream`, `idprotocol`, `HEX`, `dataProtocol`, `dataDevice`, `repeat`, `CRCRAW`, `RAW1`) VALUES
(1, 2, '0AF5E817', '{D=80,F=23}', NULL, 1, '4043B936', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-80'),
(2, 2, '0AF5FA05', '{D=80,F=95}', NULL, 1, '5DBAF40B', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-80'),
(3, 2, '0AF5D02F', '{D=80,F=11}', NULL, 1, '01041E0B', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-80'),
(4, 2, '0AF5728D', '{D=80,F=78}', NULL, 1, '995BBE79', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-1|1|-3|1|-3|1|-1|1|-3|1|-80'),
(5, 2, '0AF57A85', '{D=80,F=94}', NULL, 1, '04B66BB0', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-80'),
(6, 2, '0AF5BA45', '{D=80,F=93}', NULL, 1, '94AA3E75', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-1|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-80'),
(7, 2, '0AF53AC5', '{D=80,F=92}', NULL, 1, 'CDA6A1CE', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-80'),
(8, 2, '0AF5F20D', '{D=80,F=79}', NULL, 1, 'C05721C2', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-3|1|-1|1|-3|1|-80'),
(9, 2, '0AF5D629', '{D=80,F=107}', NULL, 1, 'B5E1F956', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-3|1|-80'),
(10, 2, '0AF5B649', '{D=80,F=109}', NULL, 1, '30013579', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-1|1|-3|1|-3|1|-1|1|-3|1|-3|1|-1|1|-1|1|-3|1|-1|1|-1|1|-3|1|-1|1|-1|1|-3|1|-80'),
(11, 2, '0AF5C23D', '{D=80,F=67}', NULL, 1, '1CFD5336', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-80'),
(12, 2, '0AF5F609', '{D=80,F=111}', NULL, 1, 'F911FF07', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-1|1|-3|1|-80'),
(13, 2, '0AF536C9', '{D=80,F=108}', NULL, 1, '690DAAC2', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-3|1|-3|1|-1|1|-3|1|-3|1|-1|1|-3|1|-3|1|-1|1|-1|1|-3|1|-1|1|-1|1|-3|1|-80'),
(14, 2, '0AF52AD5', '{D=80,F=84}', NULL, 1, '5DFCD56B', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-80'),
(15, 2, '0AF5B24D', '{D=80,F=77}', NULL, 1, '0947EBBC', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-1|1|-3|1|-3|1|-1|1|-1|1|-3|1|-1|1|-1|1|-3|1|-1|1|-1|1|-3|1|-3|1|-1|1|-3|1|-80'),
(16, 2, '0AF502FD', '{D=80,F=64}', NULL, 1, '8CE106F3', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-80'),
(17, 2, '0AF548B7', '{D=80,F=18}', NULL, 1, '55BF20DC', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-3|1|-1|1|-3|1|-3|1|-3|1|-80'),
(18, 2, '0AF59867', '{D=80,F=25}', NULL, 1, '55F901BC', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-1|1|-1|1|-3|1|-3|1|-1|1|-1|1|-1|1|-1|1|-3|1|-3|1|-1|1|-1|1|-3|1|-3|1|-3|1|-80'),
(19, 2, '0AF5A857', '{D=80,F=21}', NULL, 1, '89537348', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-80'),
(20, 2, '0AF518E7', '{D=80,F=24}', NULL, 1, '0CF59E07', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-1|1|-3|1|-3|1|-1|1|-1|1|-1|1|-3|1|-3|1|-3|1|-1|1|-1|1|-3|1|-3|1|-3|1|-80'),
(21, 2, '0AF5B04F', '{D=80,F=13}', NULL, 1, '84E4D224', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-1|1|-3|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-1|1|-3|1|-3|1|-3|1|-3|1|-80'),
(22, 2, '0AF5708F', '{D=80,F=14}', NULL, 1, '14F887E1', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-3|1|-3|1|-3|1|-3|1|-80'),
(23, 2, '0AF5F00F', '{D=80,F=15}', NULL, 1, '4DF4185A', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-3|1|-3|1|-3|1|-80'),
(24, 2, '0AF538C7', '{D=80,F=28}', NULL, 1, '40059856', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-3|1|-3|1|-3|1|-1|1|-1|1|-1|1|-3|1|-3|1|-1|1|-1|1|-1|1|-3|1|-3|1|-3|1|-80'),
(25, 2, '0AF5B847', '{D=80,F=29}', NULL, 1, '190907ED', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-1|1|-3|1|-3|1|-3|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-3|1|-3|1|-3|1|-80'),
(26, 2, '0AF57887', '{D=80,F=30}', NULL, 1, '89155228', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-3|1|-3|1|-3|1|-80'),
(27, 2, '0AF5F807', '{D=80,F=31}', NULL, 1, 'D019CD93', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-3|1|-3|1|-80'),
(28, 2, '0AF520DF', '{D=80,F=4}', NULL, 1, '4DB2393A', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-80'),
(29, 2, '0AF5A05F', '{D=80,F=5}', NULL, 1, '14BEA681', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-80'),
(30, 2, '0AF558A7', '{D=80,F=26}', NULL, 1, 'C5E55479', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-3|1|-3|1|-3|1|-80'),
(31, 2, '0AF530CF', '{D=80,F=12}', NULL, 1, 'DDE84D9F', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-3|1|-3|1|-1|1|-1|1|-1|1|-1|1|-3|1|-3|1|-1|1|-1|1|-3|1|-3|1|-3|1|-3|1|-80'),
(32, 2, '0AF5C837', '{D=80,F=19}', NULL, 1, '0CB3BF67', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-3|1|-1|1|-3|1|-3|1|-3|1|-80'),
(33, 2, '0AF542BD', '{D=80,F=66}', NULL, 1, '45F1CC8D', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-80'),
(34, 2, '0AF5827D', '{D=80,F=65}', NULL, 1, 'D5ED9948', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-80'),
(35, 2, '0AF5A25D', '{D=80,F=69}', NULL, 1, '991D9F19', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-1|1|-3|1|-1|1|-1|1|-1|1|-3|1|-1|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-1|1|-3|1|-80'),
(36, 2, '0AF58877', '{D=80,F=17}', NULL, 1, 'C5A37519', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-1|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-3|1|-3|1|-3|1|-1|1|-3|1|-3|1|-3|1|-80'),
(37, 2, '0AF508F7', '{D=80,F=16}', NULL, 1, '9CAFEAA2', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-3|1|-3|1|-80'),
(38, 2, '0AF5E01F', '{D=80,F=7}', NULL, 1, 'DDAE6CFF', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-80'),
(58, 2, '0AF522DD', '{D=80,F=68}', NULL, 1, 'C01100A2', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-3|1|-1|1|-3|1|-3|1|-3|1|-1|1|-3|1|-80'),
(59, 2, '0AF510EF', '{D=80,F=8}', NULL, 1, '91184BCE', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-3|1|-3|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-80'),
(60, 2, '0AF5629D', '{D=80,F=70}', NULL, 1, '0901CADC', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-3|1|-3|1|-3|1|-1|1|-3|1|-80'),
(57, 2, '0AF526D9', '{D=80,F=100}', NULL, 1, 'F957DE67', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-3|1|-1|1|-1|1|-3|1|-3|1|-1|1|-3|1|-3|1|-1|1|-3|1|-3|1|-1|1|-1|1|-3|1|-80'),
(40, 3, '28C60008087F900C8A808000000004BA', '{H=81,J=1,K=1,L=0,M=0,N=0}', '{A=5,wOn=1,B=1,C=0,D=1,E=0,tOff=0,tOn=0,fOn=0,fOff=0}', 1, '8649E7C5', '{38,413,260}8|-4|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-1|1|-3|1|-3|1|-1|1|-1|1|-1|1|-3|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-3|1|-3|1|-3|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-3|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-260'),
(41, 3, '28C60008087F900C85008C000000047B', '{H=161,J=0,K=49,L=0,M=0,N=0}', '{A=10,wOn=1,B=0,C=0,D=1,E=3,tOff=0,tOn=0,fOn=0,fOff=0}', 1, 'B11BCAD3', '{38,413,260}8|-4|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-1|1|-3|1|-3|1|-1|1|-1|1|-1|1|-3|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-3|1|-3|1|-3|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-3|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-3|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-1|1|-1|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-3|1|-260'),
(82, 4, NULL, NULL, NULL, 1, '485732FD', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-1|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-20'),
(83, 4, NULL, NULL, NULL, 1, '4014C74A', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-20'),
(84, 4, NULL, NULL, NULL, 1, 'CDF1DFB2', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-3|1|-1|1|-1|1|-3|1|-3|1|-1|1|-1|1|-1|1|-1|1|-3|1|-3|1|-1|1|-1|1|-3|1|-3|1|-3|1|-20'),
(79, 4, NULL, NULL, NULL, 1, '0956B4A0', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-3|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-3|1|-20'),
(77, 4, NULL, NULL, NULL, 1, 'C0467EDE', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-3|1|-3|1|-20'),
(78, 4, NULL, NULL, NULL, 1, '505A2B1B', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-3|1|-20'),
(80, 4, NULL, NULL, NULL, 1, '8CB6788F', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-3|1|-1|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-20'),
(81, 4, NULL, NULL, NULL, 1, '1CAA2D4A', '{38,562,68}16|-8|1|-1|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-3|1|-1|1|-3|1|-1|1|-3|1|-3|1|-1|1|-1|1|-1|1|-1|1|-1|1|-3|1|-1|1|-1|1|-3|1|-3|1|-3|1|-3|1|-3|1|-20'),
(87, 3, NULL, NULL, '{A=5,wOn=1,B=1,C=0,D=1,E=3,tOff=0,tOn=0,fOff=0,fOn=0}', 0, NULL, '11226');

-- --------------------------------------------------------

--
-- Struttura Stand-in per le viste `view_devicesheet`
--
DROP VIEW IF EXISTS `view_devicesheet`;
CREATE TABLE IF NOT EXISTS `view_devicesheet` (
`iddevice` int(11)
,`role` enum('USE','primary','broadcast','unused')
,`idprotocol` int(11)
,`keyname` char(30)
,`screen` char(30)
,`drepeat` int(2)
,`idstream` int(11)
,`repeat` int(2)
,`clickAction` varchar(300)
,`HEX` varchar(200)
,`dataProtocol` varchar(200)
,`dataDevice` varchar(200)
,`CRCRAW` char(8)
,`RAW1` varchar(2000)
);
-- --------------------------------------------------------

--
-- Struttura Stand-in per le viste `view_dev_rem`
--
DROP VIEW IF EXISTS `view_dev_rem`;
CREATE TABLE IF NOT EXISTS `view_dev_rem` (
`iddevice` int(11)
,`kind` char(30)
,`dev_brand` char(30)
,`dev_model` char(30)
,`dev_status` enum('visible','hidden')
,`group` char(30)
,`mode1` char(1)
,`mode2` char(1)
,`mode3` char(1)
,`idprotocol` int(11)
,`code` char(10)
,`idremote` int(11)
,`rem_brand` char(30)
,`rem_model` char(30)
,`rem_status` enum('visible','hidden')
,`modes` char(60)
);
-- --------------------------------------------------------

--
-- Struttura Stand-in per le viste `view_protocolsheet`
--
DROP VIEW IF EXISTS `view_protocolsheet`;
CREATE TABLE IF NOT EXISTS `view_protocolsheet` (
`idprotocol` int(11)
,`name` char(30)
,`idremote` int(11)
,`phpgui` char(30)
,`keyname` char(30)
,`screen` char(30)
,`drepeat` int(2)
,`idstream` int(11)
,`repeat` int(2)
,`HEX` varchar(200)
,`dataProtocol` varchar(200)
,`dataDevice` varchar(200)
,`phpadapter` char(30)
,`CRCRAW` char(8)
,`RAW1` varchar(2000)
);
-- --------------------------------------------------------

--
-- Struttura Stand-in per le viste `view_remotesheet`
--
DROP VIEW IF EXISTS `view_remotesheet`;
CREATE TABLE IF NOT EXISTS `view_remotesheet` (
`idremote` int(11)
,`code` char(10)
,`idprotocol` int(11)
,`keyname` char(30)
,`screen` char(30)
,`idremkey` int(11)
,`row` int(2)
,`col` int(2)
,`mode` char(30)
,`iddevice` int(11)
,`role` enum('USE','primary','broadcast','unused')
,`drepeat` int(2)
,`idstream` int(11)
,`repeat` int(2)
,`clickAction` varchar(300)
,`HEX` varchar(200)
,`dataProtocol` varchar(200)
,`dataDevice` varchar(200)
,`CRCRAW` char(8)
,`RAW1` varchar(2000)
);
-- --------------------------------------------------------

--
-- Struttura per la vista `view_devicesheet`
--
DROP TABLE IF EXISTS `view_devicesheet`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `remotesdb`.`view_devicesheet` AS select `remotesdb`.`irp_devcommands`.`iddevice` AS `iddevice`,`remotesdb`.`irp_devcommands`.`role` AS `role`,`remotesdb`.`irp_devrem`.`idprotocol` AS `idprotocol`,`remotesdb`.`irp_devcommands`.`keyname` AS `keyname`,`remotesdb`.`irp_actions`.`screen` AS `screen`,`remotesdb`.`irp_devcommands`.`drepeat` AS `drepeat`,`remotesdb`.`irp_streams`.`idstream` AS `idstream`,`remotesdb`.`irp_streams`.`repeat` AS `repeat`,`remotesdb`.`irp_remkeys`.`clickAction` AS `clickAction`,`remotesdb`.`irp_streams`.`HEX` AS `HEX`,`remotesdb`.`irp_streams`.`dataProtocol` AS `dataProtocol`,`remotesdb`.`irp_streams`.`dataDevice` AS `dataDevice`,`remotesdb`.`irp_streams`.`CRCRAW` AS `CRCRAW`,`remotesdb`.`irp_streams`.`RAW1` AS `RAW1` from (((`remotesdb`.`irp_devcommands` join `remotesdb`.`irp_actions`) join `remotesdb`.`irp_devrem` on(((`remotesdb`.`irp_devcommands`.`keyname` = `remotesdb`.`irp_actions`.`keyname`) and (`remotesdb`.`irp_devcommands`.`iddevice` = `remotesdb`.`irp_devrem`.`iddevice`)))) left join (`remotesdb`.`irp_remkeys` left join (`remotesdb`.`irp_remcommands` join `remotesdb`.`irp_streams` on((`remotesdb`.`irp_remcommands`.`idstream` = `remotesdb`.`irp_streams`.`idstream`))) on((`remotesdb`.`irp_remkeys`.`idremkey` = `remotesdb`.`irp_remcommands`.`idremkey`))) on(((`remotesdb`.`irp_remkeys`.`keyname` = `remotesdb`.`irp_devcommands`.`keyname`) and (`remotesdb`.`irp_devcommands`.`idstream` <=> `remotesdb`.`irp_streams`.`idstream`) and ((`remotesdb`.`irp_devcommands`.`idstream` is not null) or (`remotesdb`.`irp_remkeys`.`clickAction` is not null)) and (`remotesdb`.`irp_remkeys`.`idremote` = `remotesdb`.`irp_devrem`.`idremote`))));

-- --------------------------------------------------------

--
-- Struttura per la vista `view_dev_rem`
--
DROP TABLE IF EXISTS `view_dev_rem`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `remotesdb`.`view_dev_rem` AS select distinct `remotesdb`.`irp_devices`.`iddevice` AS `iddevice`,`remotesdb`.`irp_devices`.`kind` AS `kind`,`remotesdb`.`irp_devices`.`brand` AS `dev_brand`,`remotesdb`.`irp_devices`.`dev_model` AS `dev_model`,`remotesdb`.`irp_devices`.`status` AS `dev_status`,`remotesdb`.`irp_devices`.`group` AS `group`,`remotesdb`.`irp_devrem`.`mode1` AS `mode1`,`remotesdb`.`irp_devrem`.`mode2` AS `mode2`,`remotesdb`.`irp_devrem`.`mode3` AS `mode3`,`remotesdb`.`irp_devrem`.`idprotocol` AS `idprotocol`,`remotesdb`.`irp_devrem`.`code` AS `code`,`remotesdb`.`irp_remotes`.`idremote` AS `idremote`,`remotesdb`.`irp_remotes`.`brand` AS `rem_brand`,`remotesdb`.`irp_remotes`.`rem_model` AS `rem_model`,`remotesdb`.`irp_remotes`.`status` AS `rem_status`,`remotesdb`.`irp_remotes`.`modes` AS `modes` from ((`remotesdb`.`irp_devices` join `remotesdb`.`irp_devrem` on((`remotesdb`.`irp_devices`.`iddevice` = `remotesdb`.`irp_devrem`.`iddevice`))) join `remotesdb`.`irp_remotes` on((`remotesdb`.`irp_devrem`.`idremote` = `remotesdb`.`irp_remotes`.`idremote`)));

-- --------------------------------------------------------

--
-- Struttura per la vista `view_protocolsheet`
--
DROP TABLE IF EXISTS `view_protocolsheet`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `remotesdb`.`view_protocolsheet` AS select distinct `remotesdb`.`irp_streams`.`idprotocol` AS `idprotocol`,`remotesdb`.`irp_protocols`.`name` AS `name`,`remotesdb`.`irp_remkeys`.`idremote` AS `idremote`,`remotesdb`.`irp_remotes`.`phpgui` AS `phpgui`,`remotesdb`.`irp_remkeys`.`keyname` AS `keyname`,`remotesdb`.`irp_actions`.`screen` AS `screen`,`remotesdb`.`irp_devcommands`.`drepeat` AS `drepeat`,`remotesdb`.`irp_streams`.`idstream` AS `idstream`,`remotesdb`.`irp_streams`.`repeat` AS `repeat`,`remotesdb`.`irp_streams`.`HEX` AS `HEX`,`remotesdb`.`irp_streams`.`dataProtocol` AS `dataProtocol`,`remotesdb`.`irp_streams`.`dataDevice` AS `dataDevice`,`remotesdb`.`irp_protocols`.`phpadapter` AS `phpadapter`,`remotesdb`.`irp_streams`.`CRCRAW` AS `CRCRAW`,`remotesdb`.`irp_streams`.`RAW1` AS `RAW1` from (((`remotesdb`.`irp_streams` join `remotesdb`.`irp_protocols` on((`remotesdb`.`irp_streams`.`idprotocol` = `remotesdb`.`irp_protocols`.`idprotocol`))) left join `remotesdb`.`irp_devcommands` on((`remotesdb`.`irp_devcommands`.`idstream` = `remotesdb`.`irp_streams`.`idstream`))) left join (((`remotesdb`.`irp_remotes` join `remotesdb`.`irp_remkeys` on((`remotesdb`.`irp_remotes`.`idremote` = `remotesdb`.`irp_remkeys`.`idremote`))) join `remotesdb`.`irp_remcommands` on((`remotesdb`.`irp_remkeys`.`idremkey` = `remotesdb`.`irp_remcommands`.`idremkey`))) join `remotesdb`.`irp_actions` on((`remotesdb`.`irp_remkeys`.`keyname` = `remotesdb`.`irp_actions`.`keyname`))) on((`remotesdb`.`irp_remcommands`.`idstream` = `remotesdb`.`irp_streams`.`idstream`)));

-- --------------------------------------------------------

--
-- Struttura per la vista `view_remotesheet`
--
DROP TABLE IF EXISTS `view_remotesheet`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `remotesdb`.`view_remotesheet` AS select `remotesdb`.`irp_remkeys`.`idremote` AS `idremote`,`remotesdb`.`irp_remcommands`.`code` AS `code`,`remotesdb`.`irp_devrem`.`idprotocol` AS `idprotocol`,`remotesdb`.`irp_remkeys`.`keyname` AS `keyname`,`remotesdb`.`irp_actions`.`screen` AS `screen`,`remotesdb`.`irp_remkeys`.`idremkey` AS `idremkey`,`remotesdb`.`irp_remkeys`.`row` AS `row`,`remotesdb`.`irp_remkeys`.`col` AS `col`,`remotesdb`.`irp_remkeys`.`mode` AS `mode`,`remotesdb`.`irp_devcommands`.`iddevice` AS `iddevice`,`remotesdb`.`irp_devcommands`.`role` AS `role`,`remotesdb`.`irp_devcommands`.`drepeat` AS `drepeat`,`remotesdb`.`irp_streams`.`idstream` AS `idstream`,`remotesdb`.`irp_streams`.`repeat` AS `repeat`,`remotesdb`.`irp_remkeys`.`clickAction` AS `clickAction`,`remotesdb`.`irp_streams`.`HEX` AS `HEX`,`remotesdb`.`irp_streams`.`dataProtocol` AS `dataProtocol`,`remotesdb`.`irp_streams`.`dataDevice` AS `dataDevice`,`remotesdb`.`irp_streams`.`CRCRAW` AS `CRCRAW`,`remotesdb`.`irp_streams`.`RAW1` AS `RAW1` from (((((`remotesdb`.`irp_actions` join `remotesdb`.`irp_remkeys`) join `remotesdb`.`irp_devrem` on(((`remotesdb`.`irp_actions`.`keyname` = `remotesdb`.`irp_remkeys`.`keyname`) and (`remotesdb`.`irp_remkeys`.`idremote` = `remotesdb`.`irp_devrem`.`idremote`)))) left join `remotesdb`.`irp_remcommands` on((`remotesdb`.`irp_remkeys`.`idremkey` = `remotesdb`.`irp_remcommands`.`idremkey`))) left join `remotesdb`.`irp_streams` on((`remotesdb`.`irp_remcommands`.`idstream` = `remotesdb`.`irp_streams`.`idstream`))) left join `remotesdb`.`irp_devcommands` on(((`remotesdb`.`irp_devcommands`.`idstream` <=> `remotesdb`.`irp_remcommands`.`idstream`) and (`remotesdb`.`irp_devcommands`.`keyname` = `remotesdb`.`irp_remkeys`.`keyname`) and (`remotesdb`.`irp_devcommands`.`iddevice` = `remotesdb`.`irp_devrem`.`iddevice`)))) order by `remotesdb`.`irp_remkeys`.`idremote`,`remotesdb`.`irp_remcommands`.`code`,`remotesdb`.`irp_remkeys`.`row`,`remotesdb`.`irp_remkeys`.`col`,`remotesdb`.`irp_remkeys`.`mode`;

DELIMITER $$
--
-- Procedure
--
DROP PROCEDURE IF EXISTS `limitdeleteremkey`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `limitdeleteremkey`(IN idremk INT, IN rcode CHAR(10), IN iddev INT, IN drole CHAR(10) )
    MODIFIES SQL DATA
    DETERMINISTIC
    COMMENT 'Delete a remkey, and cascade. With limits.'
BEGIN
  DECLARE done INT DEFAULT 0;
  DECLARE idrem, dstream, dummy INT;
  DECLARE curs1 CURSOR FOR  SELECT idstream FROM irp_remcommands WHERE idremkey = idremk  AND ((rcode <=> NULL) OR(`code` = rcode)); 
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

  SELECT idremote INTO idrem FROM irp_remkeys WHERE idremkey = idremk;
  OPEN curs1;
  REPEAT
    FETCH curs1 INTO dstream;
    IF NOT done THEN
 	  SELECT fnlimitdeletestream(dstream, idrem, rcode, iddev, drole) INTO dummy;
    END IF;
  UNTIL done END REPEAT;
  SELECT COUNT(*) INTO dummy FROM `irp_remcommands` WHERE  `idremkey` = idremk ;
  IF dummy < 1 THEN
     DELETE IGNORE FROM irp_remkeys WHERE irp_remkeys.idremkey = idremk ; 
  END IF;
END$$

DROP PROCEDURE IF EXISTS `limitdeletestream`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `limitdeletestream`(IN idstr INT, IN idrem INT, IN rcode CHAR(10), IN iddev INT, IN drole CHAR(10))
    MODIFIES SQL DATA
    DETERMINISTIC
    COMMENT 'Try to delete a stream, and related remcommands, devcommands. Wi'
BEGIN
   DECLARE dummy INT;
   SELECT fnlimitdeletestream(idstr, idrem, rcode, iddev, drole) INTO dummy ;
 END$$

DROP PROCEDURE IF EXISTS `remote2device`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `remote2device`(IN idrem INT, IN xcode CHAR(10), IN idev INT)
    MODIFIES SQL DATA
    DETERMINISTIC
    COMMENT 'Updates irp_devcommands using remote commands and irp_devrem.'
BEGIN
 DECLARE xmod1, xmod2, xmod3 CHAR(2);
 SELECT `mode1`, `mode2`, `mode2` INTO xmod1, xmod2, xmod3 FROM `remotesdb`.`irp_devrem` 
    WHERE `iddevice` = idev AND `idremote` = idrem AND (xcode = '0' OR `remotesdb`.`irp_devrem`.`code` = xcode) LIMIT 1;
 INSERT INTO irp_devcommands SELECT idev, `irp_remkeys`.`keyname`, 'USE', `irp_remcommands`.`idstream`, 1, NULL 
     FROM irp_remkeys NATURAL LEFT JOIN irp_remcommands 
	 WHERE `irp_remkeys`.`idremote`=idrem AND (xcode = '0' OR `irp_remcommands`.`code` = xcode OR `irp_remcommands`.`code` IS NULL ) AND
	 ((xmod1='A') OR (`irp_remkeys`.`mode`='A') OR (FIND_IN_SET(xmod1, `irp_remkeys`.`mode`)>0) OR (FIND_IN_SET(xmod2, `irp_remkeys`.`mode`)>0) OR (FIND_IN_SET(xmod3, `irp_remkeys`.`mode`)>0))  
	 ON DUPLICATE KEY UPDATE `irp_devcommands`.`idstream` =  `irp_remcommands`.`idstream`;
END$$

DROP PROCEDURE IF EXISTS `replacestream`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `replacestream`(IN newstr INT, IN oldstr INT)
    MODIFIES SQL DATA
    DETERMINISTIC
    COMMENT 'replaces oldstream with newstream. Delete oldstream'
BEGIN
  UPDATE irp_remcommands SET idstream = newstr WHERE idstream = oldstr;
  UPDATE irp_devcommands SET idstream = newstr WHERE idstream = oldstr;
  DELETE FROM irp_streams WHERE idstream = oldstr LIMIT 1;
END$$

DROP PROCEDURE IF EXISTS `setstreamkey`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `setstreamkey`( IN idstr2 INT, IN idrem INT, IN rcode CHAR(10), IN akey CHAR(30))
    MODIFIES SQL DATA
    DETERMINISTIC
    COMMENT 'set or replace a link stream - remkey'
BEGIN
  DECLARE idrk, idstr1, dummy INT;
  SELECT idremkey INTO idrk    FROM irp_remkeys WHERE idremote = idrem AND keyname = akey  LIMIT 1;
  SELECT idstream INTO idstr1  FROM irp_remcommands WHERE idremkey = idrk AND code = rcode LIMIT 1;  
  IF  (idstr1 <>  idstr2) AND (idstr1 > 0) THEN 
	  UPDATE irp_remcommands SET idstream = idstr2 WHERE code = rcode AND idremkey = idrk ; 
	  DELETE FROM irp_devcommands WHERE idstream = idstr1 AND keyname = akey ;
	  SELECT fnlimitdeletestream(idstr1, -1, NULL, -1, NULL) INTO dummy ;
  END IF;	  
  INSERT INTO irp_remcommands VALUES (idrk, rcode, idstr2) ON DUPLICATE KEY UPDATE idstream = idstr2 ;	 
 
END$$

--
-- Funzioni
--
DROP FUNCTION IF EXISTS `fnlimitdeletestream`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fnlimitdeletestream`(idstr INT, idrem INT, rcode CHAR(10), iddev INT, drole CHAR(10)) RETURNS int(11)
    MODIFIES SQL DATA
    DETERMINISTIC
    COMMENT 'Try to delete a stream, and related remcommands, devcommands. Wi'
BEGIN
 DECLARE sumR, sumD INT;
 IF ((idrem <=> NULL) OR (idrem > 0)) THEN
     DELETE FROM `irp_remcommands` USING `irp_remcommands` NATURAL JOIN `irp_remkeys` WHERE `idstream` = idstr AND ((idrem <=> NULL) OR (`idremote` = idrem)) AND ((rcode <=> NULL) OR(`code` = rcode));
 END IF;
 IF ((iddev <=> NULL) OR (iddev > 0)) THEN
     DELETE FROM `irp_devcommands` WHERE `idstream` = idstr AND ((iddev <=> NULL) OR (`iddevice` = iddev)) AND ((drole <=> NULL) OR(`role` = drole));
 END IF;
 SELECT COUNT(*) INTO sumR FROM `irp_remcommands` WHERE  `idstream` = idstr ;
 SELECT COUNT(*) INTO sumD FROM `irp_devcommands` WHERE  `idstream` = idstr ;
 SET sumR = (sumR + sumD );
 IF sumR = 0 THEN
      DELETE FROM `irp_streams` WHERE `idstream` = idstr ;
 END IF;
 RETURN sumR;
 END$$

DROP FUNCTION IF EXISTS `fnsetupdatestream`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fnsetupdatestream`( idpro INT, nhex CHAR(200), nraw VARCHAR(2000), rep INT) RETURNS int(11)
    MODIFIES SQL DATA
    DETERMINISTIC
    COMMENT 'set or update stream data.'
BEGIN
     DECLARE dummy INT;
     INSERT IGNORE INTO irp_streams VALUES ( NULL, idpro, nhex, NULL, NULL, rep, NULL, nraw ) ON DUPLICATE KEY UPDATE  idstream=LAST_INSERT_ID(idstream), `HEX` = nhex, RAW1 = nraw, CRCRAW = NULL ;
	 SELECT LAST_INSERT_ID() INTO dummy;
     RETURN dummy;
END$$

DELIMITER ;
