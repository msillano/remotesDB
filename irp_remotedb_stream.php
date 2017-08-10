<?php
/*
irp_remotedb_stream - 
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
Library: get/set on remotesDB, involving streams and irp_classes, for hi level applications
small footprint  (this do not requires irp_remotedb_tools), direct calls to stored procedures
funtions: 
    getRAWtoSend(), to get raw data to send, for applications.
	processNewStream(), completes a new record in irp_streams, sets CRCRAW 
	doRemote2Device(), updates irp_devcommaders from remote (stored procedure)
*/
	$d=dirname(__FILE__);
// libraries: 
	require_once ("$d/irp_commonSQL.php");
	require_once ("$d/irp_remotedb_raw.php");
  require_once ("$d/../phpIRPlib/irp_classes.php");
//	
// this is the the main function for sending user applications
// returns raw to send to device
// see demo: usr_simpleSerialTX.php
function getRAWtoSend($iddevice, $keyname, $idstream, $dataDevice=NULL, $role='USE')	{
	if ($dataDevice != NULL){
// dynamic key	
		list($useIRP, $drepeat) = sqlRecord("SELECT IRP, drepeat FROM  irp_protocols, view_devicesheet WHERE  irp_protocols.idprotocol  =  view_devicesheet.idprotocol AND view_devicesheet.idstream <=> ".($idstream == NULL?'NULL':$idstream)." AND iddevice = $iddevice AND role='$role' LIMIT 1");

 // list($useIRP, $drepeat) = sqlRecord("SELECT IRP, drepeat FROM ((irp_protocols JOIN irp_devrem ON  irp_protocols.idprotocol  =  irp_devrem.idprotocol) JOIN irp_devcommands ON irp_devrem.iddevice =  irp_devcommands.iddevice)  WHERE irp_devcommands.idstream = $idstream  AND irp_devcommands.iddevice = $iddevice AND role='$role' LIMIT 1");
     
		 $theProtocol = new irp_protocol($useIRP);
		 $raw  = $theProtocol->encodeRaw($dataDevice, $drepeat);  //drepeat times
		 return $theProtocol->RAWprocess($raw, 1);     // RAW -> RAW1
		 }
// static key case
     $devicesheet = sqlRecord("SELECT * FROM view_devicesheet WHERE iddevice=$iddevice AND idstream='$idstream' AND role='$role' ;");
     if ($devicesheet['drepeat'] == $devicesheet['repeat'])  //repeat: times stored; drepeat: times required
// simplest and fastest case, sends RAW1 stored as is
	    return $devicesheet['RAW1'];
     if ($devicesheet['HEX'] != NULL){
// case with IRP, preference to HEX (or dataProtocol)
		$useIRP = sqlValue("SELECT IRP FROM irp_protocols WHERE idprotocol = ".$devicesheet['idprotocol']);
		$theProtocol = new irp_protocol($useIRP);
		$raw  = $theProtocol->encodeRaw($devicesheet['HEX'], $devicesheet['drepeat']);  //drepeat times
		return $theProtocol->RAWprocess($raw, 1);     // RAW -> RAW1
		}
// only RAW: must replicate it
     $exraw = irp_explodeRAW1($devicesheet['RAW1']);
// now builds	
   $srepeat = $devicesheet['repeat']; // jost in case of repeat == 0
   if ($srepeat < 1)
       $srepeat = 1;
	 $newraw  = $exraw;
     for($i = $srepeat; $i < $devicesheet['drepeat']; $i += $srepeat)	{
	    $newraw['count'] += $exraw['count'];
	    $newraw['raw'] .= '|'.$exraw['raw'];
        }
	$rawok = irp_implodeRAW1($newraw);
	return $rawok;
    }

// processes a irp_stream record, sets CRCRAW, delete if duplicate - used by fill/update tool.
// input like sqlRecord("SELECT * FROM irp_streams....") 
// return, true: ok, processed. false: bad, error,  deleted.
function processNewStream($streamRecord){
 if ($streamRecord['CRCRAW'] !=  NULL){
		  return true;   // a processed stream, nothing to do
		  }
 $idstream = $streamRecord['idstream']; 
  // test: has HEX or RAW or DATA ? else delete		 
 if (($streamRecord['HEX'] == '') && ($streamRecord['RAW1'] == '')&&
     ($streamRecord['dataDevice'] == '')&& ($streamRecord['dataProtocol'] == '')){
          sql("CALL limitdeletestream($idstream,NULL,NULL,NULL,NULL)");   
		  return false;
		  }
 $idprotocol = $streamRecord['idprotocol']; 
 $useIRP = sqlValue("SELECT IRP FROM irp_protocols WHERE idprotocol = ".($idprotocol == NULL?'NULL':$idprotocol));
 if ($useIRP == ''){
 //------- no IRP, only RAW
 		   $oldstream = getSameStream4Raw($streamRecord['RAW1']);
       if (((int)$oldstream > 0) && ($oldstream != $idstream)) {
// exist?  replace			   
		        sql("CALL replacestream($oldstream, $idstream)");  // stored procedure
            return true;
            }
      $crc  = getCRCRAW($streamRecord['RAW1']);
		  sql("UPDATE irp_streams SET CRCRAW='$crc',idprotocol=$idprotocol,dataDevice=NULL,dataProtocol=NULL,HEX=NULL WHERE idstream=$idstream");
		  return true;
	 }
//-------- with IRP	
	 $theProtocol = new irp_protocol($useIRP);
   $hex   = NULL;
	 $raw1  = NULL;
	 $dataP = NULL;
	 $data  = array();
	 $useData = NULL;
	// preference for DATA
	 if ($streamRecord['dataProtocol'] != ''){
			         $useData = 	$streamRecord['dataProtocol']; 
					 }
	 if ($streamRecord['dataDevice'] != ''){
			         $useData = 	$streamRecord['dataDevice']; 
					 }
	 if ($useData != NULL){
			$raw  = $theProtocol->encodeRaw($useData,1);       // DATA  -> RAW0				 
			$theProtocol->decodeRaw($raw);                     // RAW0 -> DATASET
			$result = $theProtocol->dataVerify(false);     					 
			$data = irp_explodeVerify($result);
// echo "result = $result <br>";			
			if ($data['dataOK'] != 'true'){  // error in data
				sql("CALL limitdeletestream($idstream,NULL,NULL,NULL,NULL)");   
				return false;
				}	
			$dataP = $data['dataProtocol'];
			$raw  = $theProtocol->encodeRaw($dataP, $streamRecord['repeat']);
			$raw1 = $theProtocol->RAWprocess($raw, 1);     // DATASET -> RAW1
			$theProtocol->setOutputBin();
			$bindata = $theProtocol->encodeRaw($dataP, 1);
			$hex = $theProtocol->RAWprocess($bindata, 1);  // DATASET-> HEX
			$oldstream = getSameStream4Raw($raw1);
			if (((int)$oldstream > 0) && ($oldstream != $idstream)) {
				// exist?  replace			   
				sql("CALL replacestream($oldstream, $idstream)");
				return true;
				}			 
			}	
    else if ($streamRecord['HEX'] != ''){ 
		// fill starting from HEX (encode)
			 $theProtocol->setOutputRaw();
			 $hex  = $streamRecord['HEX'];
			 $raw  = $theProtocol->encodeRaw($hex,1);       // HEX  -> RAW0
			 $theProtocol->decodeRaw($raw);                 // RAW0 -> DATASET
			 $result = $theProtocol->dataVerify(false);
             $data = irp_explodeVerify($result);			 
			 if ($data['dataOK'] != 'true'){  // error in data
                     sql("CALL limitdeletestream($idstream,NULL,NULL,NULL,NULL)");   
			         return false;
			         }	
		     $dataP = $data['dataProtocol'];
			 $raw  = $theProtocol->encodeRaw($dataP, $streamRecord['repeat']);
			 $raw1 = $theProtocol->RAWprocess($raw, 1);     // DATASET -> RAW1
			 $oldstream = getSameStream4Raw($raw1);
             if (((int)$oldstream > 0) && ($oldstream != $idstream)) {
// exist?  replace			   
				sql("CALL replacestream($oldstream, $idstream)");
				return true;
				}
		 }
	 else if ($streamRecord['RAW1'] != ''){			 
			// fill starting from RAW
			$theProtocol->setOutputRaw();
			$theProtocol->decodeRaw($streamRecord['RAW1']);  // RAW -> DATASET
			$result = $theProtocol->dataVerify(false);     
			$data = irp_explodeVerify($result);			 
			if ($data['dataOK'] != 'true'){  // error in data
				sql("CALL limitdeletestream($idstream,NULL,NULL,NULL,NULL)");   
				return false;
				}	
			$dataP = $data['dataProtocol'];
			$raw  = $theProtocol->encodeRaw($dataP,$streamRecord['repeat']);
			$raw1 = $theProtocol->RAWprocess($raw, 1);      // DATASET -> RAW1
			$oldstream = getSameStream4Raw($raw1);
			if (((int)$oldstream > 0) && ($oldstream != $idstream)) {
				// exist?  replace			   
				sql("CALL replacestream($oldstream, $idstream)");
				return true;
				}
			$theProtocol->setOutputBin();
			$bindata = $theProtocol->encodeRaw($dataP, 1);
			$hex = $theProtocol->RAWprocess($bindata, 1);  // DATASET-> HEX
			 }		 
// updates		 
       	$crc   = getCRCRAW($raw1);
		sql("UPDATE irp_streams SET HEX='$hex',dataProtocol='$dataP',dataDevice=".($data['dataDevice']=='{}'?'NULL':"'".$data['dataDevice']."'").",CRCRAW='$crc',RAW1='$raw1' WHERE idstream=$idstream");
		return true;
}	
// ------------------------------------------  wrappers to stored procedures
/* 
-- updates links to streams for a device, from a remote (used by fill/update tool.)
-- modal remote command keys: this function can update only a subset of keys
-- key modes (in irp_remkeys) must match one of device modes: mode1, mode2, mode3 in irp_devrem.
-- pre-condition: 
--      irp_device contains the device
--      irp_devrem links the remote and the device:
--     	  - with corrects mode1, mode2, mode3 (from irp_remotes.modes or default 'A' for 'all')
--		  - mode2, mode3 are optionals.
--	    irp_remcommands defines some streams (verify on view_remotesheet) for the remote.
-- post-condition:
--      the table irp_devcommands contains links to the streams that the device can receive.
-- idremote, code : to select starting remote command
-- iddevice : the target device
see: file sql/sp_remote2device.sql	  
*/	  
function doRemote2Device($idremote, $iddevice, $code = '0'){
       sql("CALL remote2device($idremote, '$code', $iddevice)");
}
		 			 
?>