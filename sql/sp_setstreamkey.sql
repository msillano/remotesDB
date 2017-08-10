-- delete a remkay and cascade all links that reference it, with bounds.
-- Stream: autodeleted only if 'free', without link.  
-- use: import it

delimiter //
DROP PROCEDURE IF EXISTS `setstreamkey` //

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
 
END//

 