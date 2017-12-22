<?php
/* 
  usr_simplerawRX.php - This file is part of remoteDB.

  remoteDB is free software; you can redistribute it and/or
  modify it under the terms of the GNU Lesser General Public
  License as published by the Free Software Foundation; either
  version 2.1 of the License, or (at your option) any later version.

  remoteDB is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
  Lesser General Public License for more details.

  You should have received a copy of the GNU Lesser General Public
  License along with this library; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  -----
  Copyright (c) 2017 Marco Sillano.  All right reserved.
*/

$d=dirname(__FILE__);
// uncomment only one of following 3:
// 1) without ARDUINO (simulation)
// require_once ("$d/irp_rxtxZero.php");

// 2) using ARDUINO with serial extension on Windows
//     this implementation requires Arduino and 'PHP Serial extension' free
//     ver.(http://www.thebyteworks.com) to send RAW compresses data. 
//     The free serial communication fails after 1024 bytes... you must restart
//     the server after 1 or 2 tests! But it is ok for test purposes. 
// require_once ("$d/../phpIRPlib/irp_rxtxArduino.php");

// 3) using ARDUINO with USBphpTunnel on Android
//     this implementation requires USBphpTunnel ()
//     and USBphpTunnel_fifo.
require_once("$d/../upt_fifo/upt_fifo.php");
//
// ---------------- general
require_once("$d/irp_commonSQL.php");
require_once("$d/../phpIRPlib/irp_classes.php");	
require_once("$d/irp_remotedb_tools.php");

$idprotocol = $_GET['protocol'] ;
$idremote = $_GET['remote'] ;
$code = $_GET['code'] ;
$key = $_GET['key'] ;
$mode = $_GET['mode'] ;
$CAPTURE_RAW = "*";

//   ===============  start Arduino
if (function_exists('pushGETrequest')) {    
//   ===============  start USBphpTunnel Arduino
	if (!isset($_GET['id']))
	  {
		$id  =  pushGETrequest(1);
		movePage(100,"./wait_rx.php?protocol=$idprotocol&id=$id&remote=$idremote&code=$code&key=$key&mode=$mode");    
	  }  
	if (isset($_GET['id']))
	   {
	   $id = $_GET['id'];
	   $r = popGETrequest($id );
	   if (($r == NULL)|| strlen($r) <4)
		  $r ='*** ERROR serial link';
	   $CAPTURE_RAW = irp_onion($r,'(',')');
	   }
} else {
//   ===============  start serial/simulated arduino
    $CAPTURE_RAW = rxArduino($idprotocol);
	if (function_exists('ser_version')){       // only serial
	   echo '+++ from Serial after: '.ser_version().'<br>----------------<br>';
	}
}
//   ===============  end Arduino

echo '<body><head>'.StyleSheet().'</head><body>';
/*
// for test
echo '<pre>';
print_r($_GET);
echo '</pre><br>';
*/

$nameremote = sqlValue("SELECT CONCAT(brand,' ',rem_model) FROM irp_remotes WHERE idremote = $idremote;");
echo "<h3><i>Capture RAW from $nameremote</i>".(($code=='0')?'':" code $code").": $key</h3><br><hr>";
 
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
	  $olddata = sqlRecord("SELECT * FROM view_protocolsheet  WHERE idprotocol = $idprotocol AND idremote = $idremote AND( code = '0' OR code = '$code') AND keyname ='$key' LIMIT 1;");
if ((count($olddata) > 0) && ($olddata['keyname'] == $key)){
	  $reference .= "<div class='error'>This key <B>$key</B> stream already exists in DB:<br><pre>";
	  $reference .= "<br> - ".strspace('stream ID:',18).$olddata['idstream'];
	  $reference .= "<br> - ".strspace('HEX:',18).$olddata['HEX'];
	  $reference .= "<br> - ".strspace('Data Protocol:',18).$olddata['dataProtocol'];
	  $reference .= "<br> - ".strspace('CRCRAW:',18).$olddata['CRCRAW'];
	  $reference .= "</pre></div>";
	  $rawold =  "<span style='color: red'>".' RAW in DB   = '.$olddata['RAW1'].'</span><br>';
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
   	    $reference .= "<div class='error'>Info: this RAW stream already exists in DB :<br><pre>";
		$reference .= "<br> - ".strspace('stream ID:',18).$idstream;
		$reference .= "<br> - ".strspace('CRCRAW:',18).$olddata['CRCRAW'];
		$reference .= "</pre></div>";
		$rawold =  "<span style='color: red'> RAW in DB   = ".$olddata['RAW1']."</span><br>";
	    }	
	}
 echo "<br>==== Verify received RAW stream ======== <br>";
 echo  $values.'<pre>';
 echo  ' CAPTURED    = '.$CAPTURE_RAW.'<br>';
 echo  ' NORMALIZED  = '.$rawn2.'<br>';
 echo  ' RAW-1       = '.$rawn3.'<br>';
 if ($rawold  != ''){
	 $r1 = $olddata['RAW1'];
	 $l = min(strlen($rawn3),strlen($r1));
   $sr1 = strpos($rawn3,"}");
   $sr2 = strpos($r1,"}");
 //  echo "1: $sr1 2: $sr2  diff ".($sr1-$sr2)."<br> ";
   if (($sr1-$sr2) == -2)
            $rawn3 = str_replace ("}","  }",$rawn3); 
    if (($sr1-$sr2) == -1)
            $rawn3 = str_replace ("}"," }",$rawn3); 
   if (($sr1-$sr2) == 1){
         $rawold = str_replace ("}"," }",$rawold); 
         $r1 = str_replace ("}"," }",$r1); 
   }
   if (($sr1-$sr2) == 2){
         $rawold = str_replace ("}","  }",$rawold); 
         $r1 = str_replace ("}","  }",$r1);  
   }
   echo $rawold ;
	 $diff = ' DIFFERENCE  = ';  
	 for ($i = 0; $i < $l; $i++){
		  if ( $r1[$i] == $rawn3[$i]) {
			 $diff .='-';
		  } else {
			 $diff .='^';
		  }
	   }
    echo "<span style='color: blue'>".$diff.'</span><br>';   
}
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
echo "<input type='submit' name='save' value='OK SAVE IT'>&nbsp; <i> note: You must run the tool 'fill/update' for the saved keys</i>.";
echo "&nbsp;&nbsp;&nbsp;<input type='submit' name='none' value='KO CANCEL IT'></form><hr>";
//

if (function_exists('pushGETrequest')) {
echo "<form action='wait_set.php' mode='GET'>";
echo "&nbsp;&nbsp;&nbsp;<input type='submit' name='none' value='CHANGE'>";
echo "<input type='hidden' name='remote' value= $idremote>";
echo "<input type='hidden' name='protocol' value= $idprotocol>";
echo "<input type='hidden' name='code' value='$code'>";
echo "<input type='hidden' name='mode' value='$mode'>";
echo "<input type='hidden' name='value' value='2'>";
echo "&nbsp;&nbsp;FrameTimeout [&mu;s]: &nbsp;<input type='text' name='data' value='7000'> (standard = 7800 &mu;s, infinite > 64000 &mu;s)";
echo "</form><hr>";
echo "<form action='wait_set.php' mode='GET'>";
echo "&nbsp;&nbsp;&nbsp;<input type='submit' name='none' value='CHANGE'>";
echo "<input type='hidden' name='remote' value= $idremote>";
echo "<input type='hidden' name='protocol' value= $idprotocol>";
echo "<input type='hidden' name='code' value='$code'>";
echo "<input type='hidden' name='mode' value='$mode'>";
echo "<input type='hidden' name='value' value='3'>";
echo "&nbsp;&nbsp;PollingPeriod: &nbsp;<input type='text' name='data' value='350'> (default = 350, fastest = 120)";
echo "</form>";
}

echo '<hr><center> <a href="javascript:history.go(-1)"><<< back </a></center><br>';  
echo "</body></html>";
?>