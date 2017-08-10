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

// with ARDUINO
require_once ("$d/../phpIRPlib/irp_rxtxArduino.php");
// without ARDUINO (simulation)
// require_once ("$d/irp_rxtxZero.php");

require_once ("$d/irp_remotedb_stream.php");
require_once ("$d/../phpIRPlib/irp_classes.php");


echo '<body><head>'.StyleSheet().'</head><body>';
$idsendstream = NULL;
if(isset($_GET['idstream'])) $idsendstream = $_GET['idstream'];
$iddevice   = $_GET['iddevice'];
$idremote   = $_GET['idremote'];
$keyname    = $_GET['key'];
 
$idstorestream = NULL;
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
// ----------------------- serial send code
 echo "sending: $raw <br>";
 txArduino($raw);
 echo '+++ from Serial after: '.ser_version().'<br>';             // verify serial after
 echo '<hr>'; 
 echo '<center><<<  <a  href="usr_simremote.php?device='.$iddevice.'" >Back</a>	</center><br></body></html>';
?>