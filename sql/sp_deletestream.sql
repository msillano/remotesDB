
-- delete a stream and all xxcommand that reference it, with bounds.
-- note: procedural wrapper to fnlimitdeletestream function.
-- Remote limits: idremote  < 0  DO NOT delete remcommands
--                idremote = NULL delete all remcommands
--                idremote = N  ONLY one remote
--                    code = NULL   ALL codes
--                    code = N  ONLY one code  
-- Device limits: iddevice  < 0  DO NOT delete devcommands
--                iddevice = NULL delete all devcommands
--                iddevice = N  ONLY one device
--                    role = NULL   ALL roles
--                    role = '<role>'  ONLY one role      
-- Stream: deleted only if 'free' i.e without xxxcommands references it.  
-- update: import this modified

delimiter //
DROP PROCEDURE IF EXISTS `limitdeletestream` //

CREATE DEFINER=`root`@`localhost` PROCEDURE `limitdeletestream`(IN idstr INT, IN idrem INT, IN rcode CHAR(10), IN iddev INT, IN drole CHAR(10))
    MODIFIES SQL DATA
    DETERMINISTIC
    COMMENT 'Try to delete a stream, and related remcommands, devcommands.'
BEGIN
   DECLARE dummy INT;
   SELECT fnlimitdeletestream(idstr, idrem, rcode, iddev, drole) INTO dummy ;
 END//
