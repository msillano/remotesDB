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
require_once ("$d/../phpIRPlib/irp_classes.php");
require_once ("$d/irp_remotedb_stream.php");


echo '<body><head>'.StyleSheet().'</head><body>';
$idsendstream = NULL;
if(isset($_GET['idstream'])) $idsendstream = $_GET['idstream'];
$iddevice   = $_GET['iddevice'];
$idremote   = $_GET['idremote'];
$keyname    = $_GET['key'];
// test
/*
 echo '<pre>';
 print_r($_GET);
 echo '</pre>';
 */
$idstorestream = NULL;
$dataDevice = NULL;
// if idstorestream stores data on idstore
 if(isset($_GET['idstore']))    $idstorestream = $_GET['idstore'];
 if(isset($_GET['dataDevice']))  $dataDevice = $_GET['dataDevice'];
 if ($idstorestream != NULL){
      if ($dataDevice == NULL)
           $dataDevice = sqlValue("SELECT dataDevice FROM irp_streams WHERE idstream = $idsendstream");
      sql("UPDATE irp_streams SET dataDevice = '$dataDevice' WHERE  idstream = $idstorestream");
      }
// now sends
 $raw = getRAWtoSend( $iddevice, $keyname, $idsendstream, $dataDevice);
 echo "<h2>Sending serial IR  for $keyname </h2>";
 // echo "RAW:: $raw";
 // echo '<center><<<  <a  href="usr_simremote.php?device='.$iddevice.'" >Back</a>	</center><br></body></html>';
 // exit;
 
//   ===============  start Arduino
 echo "sending: $raw <br>";
echo '<hr>'; 
 echo '<center><<<  <a  href="usr_simremote.php?device='.$iddevice.'" >Back</a>	</center><br></body></html>';

if (function_exists('pushGETrequest')) {    
//   ===============  start USBphpTunnel Arduino
     pushSETrequest(1, $raw);
} else {
//   ===============  start serial/simulated arduino
    txArduino($raw);
	if (function_exists('ser_version')){       // only serial
	   echo '+++ from Serial after: '.ser_version().'<br>----------------<br>';
	}
}
//   ===============  end Arduino
 
 echo '<hr>'; 
 echo '<center><<<  <a  href="usr_simremote.php?device='.$iddevice.'" >Back</a>	</center><br></body></html>';
?>