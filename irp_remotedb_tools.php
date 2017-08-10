<?php
/*
irp_remotedb_tools - 
  Copyright (c) 2017 Marco Sillano.  All right reserved.

  This library is free software; you can redistribute it and/or
  modify it under the terms of the GNU Lesser General Public
  License as published by the Free Software Foundation; either
  version 2.1 of the License, or (at your option) any later version.

  This library is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
  Lesser General Public License for more details.

  You should have received a copy of the GNU Lesser General Public
  License along with this library; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/*
Library: A tool-set of common operations on remotesDB, like setters, getters, delete (sql collection).
Also operations using conventional defaults are grouped here.
Note that the 3 views in remotesDB offers a 'flat' access to data: 'view_remotesheet', 'view_devicesheet','view_protocolsheet'.
The main PKs are: idremote (+ code), iddevice (+ role), idprotocol, keynane, idstream
code default = 0, role default = 'USE'
TRACE: use esql() in place of sql(). see next.

main functions for applications:
     setKeyRemote () sets/updates irp_actions, irp_remkeys
     setUpdateStream()  sets/updates irp_streams
	 setStreamKeyRemote() add to DB a new stream (RAW/HEX) and insert/updates  all links: irp_actions, irp_remkeys,
         	 irp_remcommands, irp_streams. After it you must do processNewStream() and doRemote2Device().
*/
	$d=dirname(__FILE__);
	require_once ("$d/irp_config.php");
	require_once ("$d/irp_commonSQL.php");
	require_once ("$d/irp_remotedb_raw.php");
//---------------------------------------------  DEBUG MODE: esql()  
//you can use sql(): no debug, or esql(): this can echoes the SQL for debug/trace
function esql($query){
// TODO: comment/uncomment next line to off/on the SQL TRACE
//   echo $query.'<br>';
   sql($query);
}
//=============================================  getters from irp_actions

function isKeyPresent($keyname){
    return (sqlValue("SELECT COUNT(*) FROM irp_actions WHERE keyname = '$keyname';") > 0);
}

//=============================================  getters from idremote (+ code)
function getRemotesOptionList($status = NULL){  // NULL = any
// returns HTML code for a SELECT to choose idremote from a list of remote controls
     return  optionsList("SELECT idremote, CONCAT(brand,' ',rem_model) from irp_remotes WHERE idremote IS NOT NULL".
	    ($status == NULL?'':" AND status ='$status'")." ORDER by brand, rem_model;", $selected = -1);
}

function getRemoteName($idremote){
// returns remote command name (brand + model) from idremote
    return sqlValue("SELECT CONCAT(brand,'_',rem_model) AS 'name' FROM irp_remotes WHERE idremote = $idremote;");
}

function getRemoteId($brand, $model){
// returns idremote from  remote command name (brand + model) 
    return sqlValue("SELECT idremote FROM irp_remotes WHERE brand ='$brand' AND rem_model = '$model'  LIMIT 1;");
}

function getDevices4Rem($idremote, $code='0'){
// returns devices for a Remote control, as array of array: [0] iddevice, [1] name, [2] code
// $code=0 => ALL, else only for $code
    return sqlArrayTot("SELECT DISTINCT irp_devices.iddevice, CONCAT(brand,' ',dev_model) AS 'name', code FROM  irp_devices NATURAL JOIN irp_devrem WHERE idremote = $idremote ".(( $code == '0')?'':" AND code = '$code'")." ORDER BY brand, dev_model;");
}

function getProtocols4Rem($idremote, $code ='0'){
// returns protocols  for a Remote control, as array of array: [0] idprotocol, [1] name, [2] code
// $code=0 => ALL,  else only for  $code
     return sqlArrayTot("SELECT DISTINCT irp_protocols.idprotocol, name, code  FROM irp_protocols JOIN irp_devrem ON irp_protocols.idprotocol = irp_devrem.idprotocol WHERE idremote = $idremote ".(( $code == '0')?'':" AND code = '$code'")." ORDER BY name;");
}

function getCodesOptionList4Rem($idremote){
// returns HTML code for SELECT, to choose a CODE for a Remote, using a list of Devices
// use  if(strpos($optionList,"value='0'") === false) to test if are codes
     return  optionsList("SELECT DISTINCT code, CONCAT(' ',code,' => ',brand,' ',dev_model,' ')  FROM irp_devices NATURAL JOIN irp_devrem WHERE idremote = $idremote ORDER by brand, dev_model;", $selected = -1);
}

function getCodes4Rem($idremote){
// returns a list of codes for a Remote
     return sqlArray("SELECT DISTINCT code FROM irp_devrem WHERE idremote = $idremote;");
}

function getModes4Rem($idremote){
// returns an array of modes as key=>value:  'A'=>'All'
$codes = array();
   $modes = sqlValue("SELECT modes FROM irp_remotes WHERE idremote = $idremote;");
   // irp_remotes.modes format: Z=some|Y=other|A=all
   $parts = explode('|', $modes);
   foreach($parts AS $mode){
	   list($key, $value) = explode('=', trim($mode));
	   $codes[$key]=$value;
   }
 return $codes;
}
//=============================================  getters from idprotocol
function getProtocolsOptionList(){
// returns HTML code for SELECT idprotocol from a list of protocol names
    return optionsList('SELECT idprotocol, name from irp_protocols ORDER by name;', $selected = -1);
	}

function getProtocolName($idprotocol){
// returns protocol name from idprotocol
    return sqlValue("SELECT name FROM irp_protocols WHERE idprotocol = $idprotocol;");
}

function getProtocolId($name){
// returns id protocol from name 
    return sqlValue("SELECT idprotocol FROM irp_protocols WHERE name = '$name' LIMIT 1;");
}


function getRemotes4prt($idprotocol){
// returns Remotes as array of array: [0] idremote, [1] name, [2] code
    return sqlArrayTot("SELECT DISTINCT irp_remotes.idremote,  CONCAT(brand,' ',rem_model) AS 'name', code FROM irp_remotes NATURAL JOIN irp_remkeys WHERE idprotocol = $idprotocol ORDER BY brand, rem_model;");
}

function getDevices4prt($idprotocol){
// returns an array of arrays[]  ([0] iddevice, [1] name, [2] role) 
    return sqlArrayTot("SELECT DISTINCT iddevice, CONCAT(brand,' ',dev_model) AS 'name', role FROM irp_devices NATURAL JOIN irp_devrem WHERE idprotocol = $idprotocol ORDER BY brand, dev_model;");
}

//=============================================  getters from iddevice
function getDevicesOptionList( $kind= NULL, $group= NULL, $status = NULL){  // NULL = all
// returns HTML code for SELECT iddevice from a list of device names (brand + dev_model)
    return optionsList("SELECT iddevice, CONCAT(brand,' ',dev_model)  from irp_devices WHERE iddevice IS NOT NULL". 
	       ($kind == NULL?'':" AND kind ='$kind'").
			   ($group == NULL?'':" AND group ='$group'").
			   ($status == NULL?'':" AND status ='$status'")." ORDER by brand, dev_model;", $selected = -1);
	}

function getRemotesOptionList4dev($iddevice){ 
// returns HTML code for SELECT remote from a list of remotes names (brand + rem_model) for same device
    return optionsList("SELECT DISTINCT CONCAT(irp_devrem.idremote, '|', code), CONCAT(brand,' ',rem_model)  from irp_devrem natural join irp_remotes WHERE irp_devrem.iddevice = $iddevice ");
	}

function getDeviceName($iddevice){
// return Device command name from iddevice
    return sqlValue("SELECT CONCAT(brand,'_',dev_model) FROM irp_devices WHERE iddevice = $iddevice;");
}


//=============================================  functions from idstreams

// test: exist processed streams (i.e. streams with CRCRAW field not NULL) like this?
function getProcessedStream($idprotocol, $hex, $raw = NULL){
  $id = sqlValue("SELECT idstream FROM irp_streams WHERE HEX = '$hex' AND idprotocol = $idprotocol AND CRCRAW IS NOT NULL LIMIT 1;");
  if (($id == NULL) && ($raw != NULL)){
    $id = getSameStream4Raw($raw);
	}
  return $id;
  }
  
// ===================== dynamic keys


function getStoreStream($idremote, $iddevice){
  $key = 'STATUS_D'.$iddevice.'_KEY';
  $storeid = sqlValue("SELECT idstream FROM view_remotesheet WHERE idremote = $idremote AND keyname = '$key' AND row = 0 AND col = 0 LIMIT 1" );
// echo "getStoreStream($idremote, $iddevice) = $storeid; <br>";
   return $storeid;
}

// like setStreamKey, but for storage pseudo key (row = 0, col = 0)
  function setStreamKeyStorage($idrem, $code, $key, $idprot){
// forces some values:
     setKeyRemote ($key, NULL, 'fake_key,storage;', $idrem, 0, 0, 'A', 'fake_key,storage;');		
 	   $idstream = sqlValue("SELECT fnsetupdatestream($idprot,NULL,'".rand()."',NULL)"); //  rand, forces new
//echo "storage id = $idstream  <br>";	   
	   linkStreamKey($idstream, $idrem, $code, $key);
}

// ============================================  setters

// insert/updates keys in  irp_actions and irp_remkeys
// in any case, insert a new record in irp_actions  if key don't exist (generates also default icon)
// if $idrem != NULL, insert/updates also on irp_remkeys
// NULL => do not update;
// use: setKeyRemote ($key, $ui , $notes ) to insert/update only irp_actions (returns NULL))
// use: setKeyRemote ($key, $ui, $tooltip, $idrem, $row , $col, $mode) to insert (no update) 
//    irp_action, insert/update irp_remkeys (returns idremkey)
// 


function setKeyRemote ($key, $ui = NULL, $notes = NULL, $idrem = NULL, $row = NULL, $col = NULL, $mode = NULL, $click = NULL){
 global $ICONDIR;
// this key exists in irp_action?
   $flag = sqlValue(" SELECT COUNT(*) FROM irp_actions WHERE keyname = '$key';");
   if ($flag == 0){
// not exists: adds new key record
       if ($ui == NULL)
	      $ui = shortKey($key);
	   $query ="INSERT INTO irp_actions VALUES('$key','$ui','".getIconName($key)."',".(($notes == NULL)?'NULL':"'$notes'").');';
       esql($query);   
// updates icons
	   $iconfile  = getIconFilePath($key);
	   if (!file_exists($iconfile) && ($row != 0) && ($col != 0)) {		 
	        $blankfile = dirname(__FILE__).$ICONDIR.'_blank.png';
			if (file_exists($blankfile)){		   
//	   echo " copy $blankfile to $iconfile <br>";
				copy ($blankfile,$iconfile);
				}	   
            }
       }
	   else {
// exist: so update  irp_action only if idrem == NULL
      if ((($ui != NULL) || ($notes != NULL)) && ($idrem == NULL)) {  
		   $query = 'UPDATE irp_actions SET';
		   if ($ui != NULL)
			   $query .= " screen = '$ui',"; 	 
		   if ($notes != NULL)
			   $query .= " definition = '$notes'";
		   $query = rtrim($query,',')." WHERE keyname = '$key';";	 
		   esql($query);
		   }
	   }
	   
//now creates / updates irp_remkeys, but only if $idrem != NULL	   
    if ($idrem != NULL) {
	    if ($row == NULL && $col == NULL && $mode == NULL){   // no update, if it exists done
		    $idremkey = sqlValue("SELECT idremkey FROM irp_remkeys WHERE idremote = $idrem AND keyname ='$key' LIMIT 1;");
			if ( $idremkey =! NULL)
     			return $idremkey;
			}			
		
		// do not exist, or must update irp_remkeys
	    $tooltip = sqlValue(" SELECT definition FROM irp_actions WHERE keyname = '$key';");	     
		$query =  "INSERT IGNORE INTO irp_remkeys VALUES(NULL, $idrem, '$key', ".($row === NULL?'NULL':"$row").
		", ".($col === NULL?'NULL':"$col").", ".($mode == NULL?'A':"'$mode'").", ".($click == NULL?'NULL':"'$click'").",'".($notes == NULL?$tooltip:$notes)."' )";
		if (($row != NULL) ||  ($col != NULL) || ($mode != NULL)|| ($notes != NULL)){
			$query .= ' ON DUPLICATE KEY UPDATE idremkey=LAST_INSERT_ID(idremkey),';
			if   ($row != NULL) $query .= " row = $row,";
			if   ($col != NULL) $query .= " col = $col,";
			if  ($mode != NULL) $query .= " mode = '$mode',";
			if  ($click != NULL) $query .= " clickAction = '$click',";
			if ($notes != NULL) $query .= " tooltip = '$notes'";
			}
		$query = rtrim($query, ',').';';
 		esql($query);
		$idremkey =	sqlValue("SELECT LAST_INSERT_ID();");
		return ($idremkey);
		}
	return NULL;	
   }
 
//  to add to DB a new RAW/HEX: insert/updates  all: irp_actions, irp_remkeys, irp_remcommands, irp_streams 
//  If ( $hex == NULL) && ($raw == NULL) returns.
//  If one of $hex, $raw  is updated, the CRCRAW becomes NULL
//  no protocol, protocol unknown =>  idprotocol = NULL (but it try to fix it)
function setStreamKeyRemote($idrem, $code, $key, $raw = NULL, $idprot= NULL, $hex = NULL, $repeat = NULL, $dataP = NULL, $dataD = NULL){
 	// stops here if no data
	echo "setStreamKeyRemote($idrem, $code, $key, $raw , $idprot, $hex, $repeat , $dataP , $dataD ) <br>";
	if (( $hex == NULL) && ($raw == NULL)) return;
    setKeyRemote ($key, NULL, NULL, $idrem);  // inserts (if it is the case) irp_actions, irp_remkeys, no update
   //try to fix idprot, if NULL, forcing
    if ($idprot == NULL){
         $prots = getProtocols4Rem($idrem, $code);	
         if ((count($prots) == 1) && ((int)$prots[0][0] >0)){
			       $idprot= $prots[0][0];   // only one, valid, it is ok
			}
    }
  $idstream = setUpdateStream($idprot, $hex, $raw, $repeat);  // updates/creates 
	linkStreamKey($idstream, $idrem, $code, $key);             // links it
	if ($dataP != NULL || $dataD != NULL){
			$query = "UPDATE irp_streams SET ".($dataP == null?'': "dataProtocol ='$dataP',").($dataD == null?'': "dataDevice ='$dataD'");
			$query = rtrim($query,',');
			$query .=" WHERE idstream = $idstream";
			sql($query);
			}
	return;
}	 
//=============================================  Stored procedures php wrappers
// oldstream is deleted, replaced by newstream, links are updated to new
function replaceStream($newstream, $oldstream){
    sql("CALL replacestream($newstream, $oldstream)");
    return $newstream;
    }
	
// creates/updates remcommand to link a stream to the key
// do not set devcammands: requires after doRemote2Device
function linkStreamKey($idstream, $idremote, $code, $keyname){
// echo "linkStreamKey($idstream, $idremote, '$code', '$keyname')";
       sql("CALL setstreamkey($idstream, $idremote, '$code', '$keyname')");	
}
/*
// insert/updates a record in irp_streams with (captured?) data
// after, you must run processNewStream(), to use IRP infos.
// $hex != NULL OR  $raw!= NULL (must)
// if $hex != NULL => $idprotocol != NULL (must)
// if $raw != NULL && $idprotocol == NULL ==> protocol unknown (?),
// It tests only $hex or $raw for difference! (because this is known in captured streams)
// returns idstream (new or updated or old)  
*/
function setUpdateStream( $idprotocol, $hex, $raw = NULL, $repeat = NULL){
	if (( $hex == NULL) && ($raw == NULL)) return NULL;
	if (( $hex != NULL) && ($idprotocol == NULL)) return NULL;
	$idstream = sqlValue("SELECT fnsetupdatestream(".($idprotocol == NULL?'NULL':"$idprotocol").($hex == NULL?',NULL':",'$hex'").($raw == NULL?',NULL':",'$raw'").($repeat == NULL?',NULL':",$repeat").")");
	return $idstream;
}
/*
-- delete a remkey and cascade all links that reference it, with bounds.
-- Remote limits:     code = NULL   ALL codes (idremote is derived by idremkey)
--                    code = N  ONLY this code  
-- Device limits: iddevice = <0  DO NOT delete links to stream
--                iddevice = NULL delete all links
--                iddevice = N  delete ONLY for this device
--                    role = NULL   ALL roles
--                    role = '<role>'  ONLY this role      
-- Stream: autodeleted only if 'free' i.e. without link.  
-- see: file sql/sp_deleteremkey.sql	  
*/
function limitdeleteremkey($idremkey, $iddevice=NULL, $code=NULL, $role=NULL){
  if ($code=='0') $code = NULL;
  sql("CALL limitdeleteremkey($idremkey".($code == NULL?',NULL':",$code").($iddevice == NULL?',NULL':",$iddevice").($role  == NULL?',NULL':",$role").')');
  return mysql_affected_rows();  // 0 = remkey not deleted, 1 = deleted remkey
}

/*	 
-- delete a stream and all xxcommand that reference it, with bounds.
-- note: procedural wrapper to fnlimitdeletestream function.
-- Remote limits: idremote  < 0  DO NOT delete remcommands
--                idremote = NULL delete all remcommands
--                idremote = N  ONLY this remote
--                    code = NULL   ALL codes
--                    code = N  ONLY this code  
-- Device limits: iddevice  < 0  DO NOT delete devcommands
--                iddevice = NULL delete all devcommands
--                iddevice = N  ONLY this device
--                    role = NULL   ALL roles
--                    role = '<role>'  ONLY this role      
-- Stream: autodeleted only if 'free' i.e. without xxxcommands that references it.  
-- see: file sql/sp_deletestream.sql	  
*/
function doLimitDeleteStream($idstream, $idremote=NULL, $iddevice=NULL, $code=NULL, $role=NULL){
  if ($code=='0') $code = NULL;
  sql("CALL limitdeletestream($idstream".($idremote == NULL?',NULL':",$idremote").($code == NULL?',NULL':",$code"). ($iddevice == NULL?',NULL':",$iddevice"). ($role  == NULL?',NULL':",$role").')');
   return mysql_affected_rows();  // 0 = idstream not deleted, 1 = deleted idstream
}
	 
// ============================================  conventions, dir and file names, keyname
 
$SHEETDIR = '\\sheet\\';
$SHEETEXT = '_sheet.txt';
$ICONDIR  = '\\icons\\';
$ICONEXT  = '.png';

function getRemoteFileSheetURL($idremote, $code = '0'){
        global $SHEETDIR, $SHEETEXT;
        return '.'.$SHEETDIR.'rem_'.strtolower(getRemoteName($idremote)).($code=='0'?'':'_'.$code).$SHEETEXT;
}

function getRemoteFileSheetPath($idremote, $code = '0'){
        global $SHEETDIR, $SHEETEXT;
        return dirname(__FILE__).$SHEETDIR.'rem_'.strtolower(getRemoteName($idremote)).($code=='0'?'':'_'.$code).$SHEETEXT;
}

function getDeviceFileSheetURL($iddevice){
        global $SHEETDIR, $SHEETEXT;
        return '.'.$SHEETDIR.'dev_'.strtolower(getDeviceName($iddevice)).$SHEETEXT;
}

function getDeviceFileSheetPath($iddevice){
        global $SHEETDIR, $SHEETEXT;
        return dirname(__FILE__).$SHEETDIR.'dev_'.strtolower(getDeviceName($iddevice)).$SHEETEXT;
}

function getProtocolFileSheetURL($idprotocol){
        global $SHEETDIR, $SHEETEXT;
        return '.'.$SHEETDIR.'irp_'.strtolower(getProtocolName($idprotocol)).$SHEETEXT;
}

function getProtocolFileSheetPath($idprotocol){
        global $SHEETDIR, $SHEETEXT;
        return dirname(__FILE__).$SHEETDIR.'irp_'.strtolower(getProtocolName($idprotocol)).$SHEETEXT;
}

function getIconName($abasename){
       global $ICONEXT;
       return strtolower($abasename).$ICONEXT;
}

function getIconFilePath($abasename){
       global $ICONDIR;
       return dirname(__FILE__).$ICONDIR.getIconName($abasename);
}

function getIconFileURL($abasename){
       global $ICONDIR;
       return '.'.$ICONDIR.getIconName($abasename);
}

function shortKey($keyname){
// gets default screen name for a key
// convention: standard KEY_NAME, custom NAME_KEY
	        if (strpos($keyname,'KEY')== 0){
				return substr($keyname,4);
	        } else {
			    return substr($keyname,0, strlen($keyname)-4);
	        }
}
// ============================================  utilities

// for min size plain txt format.
// $size max 40 char. Never cuts $str
    function strspace($str, $size){
	if (strlen($str) >= $size -2){
	    return $str.'  ';
	    }
	 return substr($str.'                                                ',0,$size);	
    }

?>