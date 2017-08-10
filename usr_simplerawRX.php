<?php
/* this implementation requires Arduino and 'PHP Serial extension' free ver.(http://www.thebyteworks.com) to send RAW compresses data. 
   The free serial communication fails after 1024 bytes... you must restart the server before any test! But it is ok for test purposes. 
  download https://github.com/msillano/irp_classes and copy it in .../www/phpIRPlib/
  No Arduino? include"$d/irp_rxtxZero.php" !

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

// using ARDUINO
 require_once ("$d/../phpIRPlib/irp_rxtxArduino.php");
// without ARDUINO (simulation)
// require_once ("$d/irp_rxtxZero.php");

require_once ("$d/../phpIRPlib/irp_classes.php");	
require_once ("$d/irp_remotedb_tools.php");

echo '<body><head>'.StyleSheet().'</head><body>';
/*
// for test
echo '<pre>';
print_r($_GET);
echo '</pre><br>';
*/
$idprotocol = $_GET['protocol'] ;
$idremote = $_GET['remote'] ;
$code = $_GET['code'] ;
$key = $_GET['key'] ;
$mode = $_GET['mode'] ;

$nameremote = sqlValue("SELECT CONCAT(brand,' ',rem_model) FROM irp_remotes WHERE idremote = $idremote;");
echo "<h3><i>Captured RAW from $nameremote</i>".(($code=='0')?'':" code $code").": $key</h3><br><hr>";

//   ===============  start serial arduino
$CAPTURE_RAW = rxArduino($idprotocol);
if (function_exists('ser_version')){
   echo '+++ from Serial after: '.ser_version().'<br>----------------<br>';
}
//   ===============  end serial arduino
$reference='';
$rawold = '';
$prtname = '';
$irp = '';
$click = sqlValue("SELECT clickAction FROM view_remotesheet  WHERE idremote = $idremote AND keyname ='$key' AND code IS NULL ");
         if ($click != NULL){
          $reference .= "<div class='error'>The key <B>$key</B> already exists in DB:<br>";
          $reference .= "<br> It is a <i>dynamic key</i>:<pre>";
          $reference .= "<br> - ".strspace('clickAction :',18).$click;
          $reference .= "</pre></div>"; 
          }
 if ($idprotocol != 'none') {
// uses IRP
    list($irp,$prtname)=sqlRecord("SELECT IRP, name FROM irp_protocols WHERE idprotocol=$idprotocol ;");
    }
if ($irp != '')   { 
  $aProtocol = new irp_protocol($irp);   
	$result = $aProtocol->decodeRaw($CAPTURE_RAW );
  $values = $prtname.' '.$result.'<br>';
  $rawn2  = $aProtocol->getNormRAW();
	$verify = '<div class="note"><pre>'.$aProtocol->dataVerify(true).'</pre></div>';
	$rawn3 = $aProtocol->RAWprocess($rawn2, 1);
  $olddata = sqlRecord("SELECT * FROM view_protocolsheet  WHERE idprotocol = $idprotocol AND keyname ='$key' LIMIT 1;");
	If ((count($olddata) > 0) && ($olddata['keyname'] == $key)){
          $reference .= "<div class='error'>The key <B>$key</B> already exists in DB:<br><pre>";
          $reference .= "<br> - ".strspace('stream ID:',18).$olddata['idstream'];
          $reference .= "<br> - ".strspace('HEX:',18).$olddata['HEX'];
          $reference .= "<br> - ".strspace('Data Protocol:',18).$olddata['dataProtocol'];
            $reference .= "<br> - ".strspace('CRCRAW:',18).$olddata['CRCRAW'];
            $reference .= "</pre></div>";
            $rawold =  "<span style='color: red'>".' old RAW     = '.$olddata['RAW1'].'</span><br>';
          } 
 } else {
// IRP unknown
// using only no IRP functions, so use NULL as protocol
// don't use encodeRaw(), decodeRaw() etc..
    $aProtocol = new irp_protocol(NULL); 
    $rawn2 = $aProtocol->RAWnormalize($CAPTURE_RAW );
	  $rawn3 = $aProtocol->RAWprocess($rawn2, 1, 38);
	  $values = 'Unknown IRP';
  	$verify = '';
	$stream = getSameStream4Raw($rawn3);
	if ($stream  != NULL) {
	    $idstream = $stream;
		$olddata = sqlRecord("SELECT * FROM irp_streams WHERE idstream = $idstream;");
   	$reference .= "<div class='error'>The key <B>$key</B> already exists in DB (learned RAW only):<br><pre>";
		$reference .= "<br> - ".strspace('stream ID:',18).$idstream;
		$reference .= "<br> - ".strspace('CRCRAW:',18).$olddata['CRCRAW'];
		$reference .= "</pre></div>";
		$rawold =  "<span style='color: red'> old RAW     = ".$olddata['RAW1']."</span><br>";
	    }	
	}
 echo "<br>==== Verify received RAW stream ======== <br>";
 echo  $values.'<pre>';
 echo  ' CAPTURED    = '.$CAPTURE_RAW.'<br>';
 echo  ' NORMALIZED  = '.$rawn2.'<br>';
 echo  ' RAW-1       = '.$rawn3.'<br>';
 if ($rawold  != '') echo $rawold ;
 echo  '</pre>';
 echo  $verify.'<hr>';
 echo  $reference.'<hr>';
echo "<form action='usr_rawremote.php' mode='GET'>";
echo "<input type='hidden' name='raw' value='$rawn3'>";
echo "<input type='hidden' name='key' value='$key'>";
echo "<input type='hidden' name='remote' value= $idremote>";
echo "<input type='hidden' name='protocol' value= $idprotocol>";
echo "<input type='hidden' name='code' value='$code'>";
echo "<input type='hidden' name='mode' value='$mode'>";
echo "<input type='submit' name='save' value='OK SAVE IT'>&nbsp; <i> You must run the tool 'fill/update' for the saved keys</i>.</form>";
//
echo "<form action='usr_rawremote.php' mode='GET'>";
echo "<input type='hidden' name='key' value='$key'>";
echo "<input type='hidden' name='remote' value= $idremote>";
echo "<input type='hidden' name='protocol' value= $idprotocol>";
echo "<input type='hidden' name='code' value='$code'>";
echo "<input type='hidden' name='mode' value='$mode'>";
echo "<input type='submit' name='none' value='CANCEL'></form>";
 echo '<hr>'; 
 echo '<center><<<  <a  href="test_captureraw.php" >Back</a>	</center><br></body></html>';

?>