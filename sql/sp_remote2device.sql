
-- updates links to streams for a device, from a remote
-- modal remote command keys: this function can update also only a subset of keys
-- key modes (in irp_remkeys) must match one of device modes: mode1, mode2, mode3 in irp_devrem.
-- pre-condition: 
--      irp_device contains the device
--      irp_devrem links the remote and the device:
--     	  - with corrects mode1, mode2, mode3 (from irp_remotes.modes or default 'A' for 'all')
--		  - mode2, mode3 are optionals.
--	  irp_remcommands defines some streams (verify on view_remotesheet) for the remote.
-- post-condition:
--      the table irp_devcommands contains links to the streams that the device can receive.
-- idrem, xcode : to select starting remote command
-- idev: the target device
-- update: import this modified

delimiter //
DROP PROCEDURE IF EXISTS  `remote2device`//

CREATE DEFINER=`root`@`localhost` PROCEDURE `remote2device`(IN idrem INT, IN xcode CHAR(10), IN idev INT)
    MODIFIES SQL DATA
    DETERMINISTIC
    COMMENT 'Updates irp_devcommands using remote commands and irp_devrem.'
BEGIN
 DECLARE xmod1, xmod2, xmod3 CHAR(2);
 SELECT `mode1`, `mode2`, `mode2` INTO xmod1, xmod2, xmod3 FROM `irp_devrem` 
    WHERE `iddevice` = idev AND `idremote` = idrem AND (xcode = '0' OR `irp_devrem`.`code` = xcode) LIMIT 1;
 INSERT INTO irp_devcommands SELECT idev, `irp_remkeys`.`keyname`, 'USE', `irp_remcommands`.`idstream`, 1, NULL 
     FROM irp_remkeys NATURAL LEFT JOIN irp_remcommands 
	 WHERE `irp_remkeys`.`idremote`=idrem AND (xcode = '0' OR `irp_remcommands`.`code` = xcode OR `irp_remcommands`.`code` IS NULL ) AND
	 ((xmod1='A') OR (`irp_remkeys`.`mode`='A') OR (FIND_IN_SET(xmod1, `irp_remkeys`.`mode`)>0) OR (FIND_IN_SET(xmod2, `irp_remkeys`.`mode`)>0) OR (FIND_IN_SET(xmod3, `irp_remkeys`.`mode`)>0))  
	 ON DUPLICATE KEY UPDATE `irp_devcommands`.`idstream` =  `irp_remcommands`.`idstream`;
END//
