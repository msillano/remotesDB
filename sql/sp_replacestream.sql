-- replaces oldstream with newstream  the delete oldstream
-- use: import it
delimiter //
DROP PROCEDURE IF EXISTS `replacestream` //

CREATE DEFINER=`root`@`localhost` PROCEDURE `replacestream`(IN newstr INT, IN oldstr INT)
    MODIFIES SQL DATA
    DETERMINISTIC
    COMMENT 'replaces oldstream with newstream. Delete oldstream'
BEGIN
  UPDATE irp_remcommands SET idstream = newstr WHERE idstream = oldstr;
  UPDATE irp_devcommands SET idstream = newstr WHERE idstream = oldstr;
  DELETE FROM irp_streams WHERE idstream = oldstr LIMIT 1;
END//

 