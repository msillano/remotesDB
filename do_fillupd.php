<?php
/*
do_fillupd - 
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
	$d=dirname(__FILE__);
	require_once ("$d/irp_commonSQL.php");
	require_once ("$d/irp_remotedb_tools.php");
    require_once ("$d/../phpIRPlib/irp_classes.php");
	require_once ("$d/irp_remotedb_stream.php");
//	
// functions:
// fillStreamData() updates streams using irp_classes. Set CRCRAW as flag of record processed
// updateDeviceData() updates irp_devcommands table from tables for remote data.
//

echo '<html><head><meta "charset=utf-8">';
echo StyleSheet();
echo '</head><body>';

$idremote = $_GET['remote'];
	/* 
 echo '<pre>';
 print_r($_GET);
 echo '</pre>';
  */  
// test for code
$code ='0';
if(isset($_GET['code'])){
     $code =$_GET['code'];
} else{
  $codes = getCodesOptionList4Rem($idremote);
  echo $codes;
  if(strpos($codes,"value='0'") === false){  //  to test if are codes
	// codes
		echo "<div class='note'><form action = 'do_fillupd.php' mode='GET'>";
		echo 'The <b>IR Remote Control</b> you choosed is  multiple. You must select a code:' ;
		echo '<input type="hidden" name ="remote" value="'.$idremote.'">';
		echo '<input type="hidden" name ="do" value="'.$_GET['do'].'">';
		echo	'&nbsp;';
		echo	"<select name='code'>";
	  echo  "<option value='0'  selected = 'selected' >0 - default </option>";
   	echo	$codes; 
		echo	"</select><br><hr><input type='submit' value=' Done '><br> </form></div></body></html>";
		exit;		
	}
}

 if ( $_GET['do'] == 'streams' || $_GET['do'] == 'both') 
    fillStreamData($idremote, $code);
 if ( $_GET['do'] == 'device' ||  $_GET['do'] == 'both') 
    updateDeviceData($idremote, $code);
	
// =========================================== functions
 
 function fillStreamData($idremote, $code = '0'){
 // uses  view_remotesheet to simplify the query
	  $query = "SELECT DISTINCT idprotocol, `row`, keyname, idstream, `repeat`, HEX, CRCRAW, RAW1, dataProtocol, dataDevice from
             view_remotesheet WHERE idremote = $idremote AND idstream IS NOT NULL ".((int)$code == '0'?'':"AND code = '".((string)$code)."'").
	         " ORDER BY idprotocol, code, idstream;";
// echo $query .'<br>';			 
 	  $remotedata = sqlArrayTot($query);
// echo 'found '.count($remotedata).'<br>';		  
     $useProtocol = -1;
	  $totCount = 0;
	  $updCount = 0;
	  $delCount = 0;
	  $errorCount = 0;
	  $okCount = 0;
	  $nullCount = 0;
	  echo "<h4>UPDATING <code>irp_streams</code>: HEX, DATA, RAW for ".getRemoteName($idremote)." remote command</h4><pre>";
	  foreach($remotedata AS $acommand){
     	 $totCount++;
	     $idstream = $acommand['idstream'];	  
	// test: CRCRAW present? ok, processed
		 if ($acommand['CRCRAW'] != '') {
			echo strspace("stream #$idstream",14 ).strspace($acommand['keyname'],22).' ok, nothing to do. <BR>';
			 $okCount++;			 
			 continue; // good, go next
			 }
		 if ($acommand['row'] == 0) {
			echo strspace("stream #$idstream",14 ).strspace($acommand['keyname'],22).' storage, nothing to do. <BR>';
			 $okCount++;			 
			 continue; // good, go next
			 }
    // test: has HEX or RAW ?			 
		 if (($acommand['HEX'] == '') && ($acommand['RAW1'] == '')&& ($acommand['dataDevice'] == '')){
		     if ($idstream > 0){
            $delCount++;
            echo strspace("stream #$idstream",14 ).strspace($acommand['keyname'],22).' no data! deleted. <BR>';
            doLimitDeleteStream($idstream);			 
				 }
			 continue; // bad, deleted, next
			 }
	     $thisProtocol = $acommand['idprotocol'];
    // test: changed protocol? Only RAW?
	     if ($useProtocol != $thisProtocol ){
			 if ($thisProtocol == NULL){
	              echo strspace("stream #$idstream",14 ).strspace($acommand['keyname'],22).' UNKNOWN protocol: ';
			      $nullCount++;
				  processNewStream($acommand);
   			      continue;
				 }
             $useProtocol = $thisProtocol;
			 echo "============================ PROTOCOL ".getProtocolName($useProtocol)."<br>";
		     }
	// preference for dataDevice, 
		if ($acommand['dataDevice'] != ''){
		       	echo strspace("stream #$idstream",14 ).strspace($acommand['keyname'],22).' DATA Device processing: '; 
				}
		else if ($acommand['dataProtocol'] != ''){
		       	echo strspace("stream #$idstream",14 ).strspace($acommand['keyname'],22).' DATA Protocol processing: '; 
				}
	  else if ($acommand['HEX'] != ''){
			      echo strspace("stream #$idstream",14 ).strspace($acommand['keyname'],22).' HEX processing: ';
		    } 
		else if ($acommand['RAW1'] != ''){
		       	echo strspace("stream #$idstream",14 ).strspace($acommand['keyname'],22).' RAW processing: '; 
				}
			
	 if ( processNewStream($acommand) == false){
        echo ' *** NOT SAVED **** <br>'; 
        $errorCount++;
        continue;
		 }else {		 
        echo " ok <br>";					
        $updCount++;
        continue;  }       
			} // foreach
	  echo "</pre><br><hr> TOTAL $totCount STREAMS - BAD: $delCount, RAW (no IRP): $nullCount, OK: $okCount, UPDATE:$updCount, ERRORS: $errorCount <br>";	 
	 }
 // ======================================
  
 function updateDeviceData($idremote, $code = '0'){
	  $tot = getDevices4Rem($idremote, $code);  // code == '0' minds ALL
	  foreach($tot AS $adevice){	  
        echo ' Device: processing '.$adevice[1].' (code:'. $code.') <br>';
        doRemote2Device($idremote, $adevice[0], $code);  // uses a stored procedure
        }
    }
?>
	 <hr> 
		 <center><<<  <a  href="test_fillUpd.php" >Back</a>	</center>
	</body>
</html>
