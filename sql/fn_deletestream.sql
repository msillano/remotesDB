
-- delete a stream and all xxcommand that reference it, with bounds.
-- Remote limits: idremote = <0  DO NOT delete remcommands
--                idremote = NULL delete all remcommands
--                idremote = N  ONLY this remote
--                    code = NULL   ALL codes
--                    code = N  ONLY this code  
-- Device limits: iddevice = <0  DO NOT delete devcommands
--                iddevice = NULL delete all devcommands
--                iddevice = N  ONLY this device
--                    role = NULL   ALL roles
--                    role = '<role>'  ONLY this role      
-- Stream: deleted only if 'free', without xxxcommands references it.  
-- return: links count: 0 = stream deleted
-- update: import this modified

delimiter //

DROP FUNCTION IF EXISTS `fnlimitdeletestream` //

CREATE DEFINER=`root`@`localhost` FUNCTION `fnlimitdeletestream`(idstr INT, idrem INT, rcode CHAR(10), iddev INT, drole CHAR(10)) RETURNS int(11)
    MODIFIES SQL DATA
    DETERMINISTIC
    COMMENT 'Try to delete a stream, and related remcommands, devcommands.'
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
 END//
