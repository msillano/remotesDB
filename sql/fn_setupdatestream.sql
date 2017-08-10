-- set or update a stream data
-- returns the idstream
-- use: import it

delimiter //
DROP FUNCTION IF EXISTS `fnsetupdatestream` //

CREATE DEFINER=`root`@`localhost` FUNCTION `fnsetupdatestream`( idpro INT, nhex CHAR(200), nraw VARCHAR(2000), rep INT) RETURNS int(11)
    MODIFIES SQL DATA
    DETERMINISTIC
    COMMENT 'set or update stream data.'
BEGIN
     DECLARE dummy INT;
     INSERT IGNORE INTO irp_streams VALUES ( NULL, idpro, nhex, NULL, NULL, rep, NULL, nraw ) ON DUPLICATE KEY UPDATE  idstream=LAST_INSERT_ID(idstream), `HEX` = nhex, RAW1 = nraw, CRCRAW = NULL ;
	 SELECT LAST_INSERT_ID() INTO dummy;
     RETURN dummy;
END//

 