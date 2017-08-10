-- delete a remkey and cascade all links that reference it, with bounds.
-- Stream: autodeleted only if 'free', without links.  
-- use: import it

delimiter //
DROP PROCEDURE IF EXISTS `limitdeleteremkey` //

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
END//

 