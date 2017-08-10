<?php
/* usr_simremote
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
	
// this is a simple implementation, using text mode and links, but this can be used with any remote in remoteDB.
// For a more realistic simulations, in remoteDB are a photo, and  keys images (available in 'icons' dir). TODO.
// this remote control accepts following customizations:
// 1) standard static keys: any key is associated to an IR command. The default.
// 2) dynamyc keys: in irp_remkeys.clickAction is an HTML attribute fragment
// 3) custom HTML interface, a php include file in /extra/ and in irp_remotes.phpgui.
// 4) custom action and methods (in javascript) in a file  in /extra/ and in irp_protocols.phpadapter.
// 5) status storage and restore, if exist a special fake key, with row and col == 0. (see getStoreStream() )
// You can see all in demo '
//
// functions:
//     getSimulateRemote() returns the HTML for a simulated control (for final user)
// 
//  This simulation is enabled for STATUS restore, dynamic keys, phpGUI amd phpAdapter (test case with Fujitsu aircon_test)

echo '<html><head><meta "charset=utf-8">';
echo StyleSheet();
if (!isset($_GET['device'])){
	 	  echo "</head><body><div class=Error>";
			echo  "ERROR: missed value 'device' ";
			echo "</div></body></html>";
			exit;
      }
      
// test for idremote
$iddevice = $_GET['device'];
if (!isset( $_GET['rem_code'])){
    $nremote = sqlValue("SELECT COUNT(*) FROM irp_devrem WHERE iddevice = $iddevice");
    if ($nremote > 1){
          $remotes = getRemotesOptionList4dev($iddevice);
          echo "</head><body><div class='note'><form action = 'usr_simremote.php' mode='GET'>";
          echo 'This device can be controlled by may Remote Controls. <BR> You must select a control:';
          echo '<input type="hidden" name ="device" value="' . $iddevice . '">';
          echo '&nbsp;';
          echo "<select name='rem_code' value='0' >";
          echo $remotes;
          echo "</select><br><hr><input type='submit' value=' Done '><br> </form>";
          echo '</div></body></html><hr><center><<< <a  href="test_file2remote.php" >Back</a></center></body></html>';
          exit;
        }
  }
 
 if (isset( $_GET['rem_code'])){
      list($idremote, $code) = explode('|',$_GET['rem_code']);
  }

$devicerecord = sqlRecord("SELECT * FROM view_dev_rem WHERE iddevice = $iddevice ".(isset($idremote)?" AND idremote = $idremote AND code = '$code' ":'')."  LIMIT 1");
$topline  = "<i>Remote Command for ".$devicerecord['kind'].":</i>  ".$devicerecord['dev_brand']." ".$devicerecord['dev_model'];
$idremote = $devicerecord['idremote'];
$mode1 = $devicerecord['mode1']; 
$mode2 = $devicerecord['mode2']; 
$mode3 = $devicerecord['mode3']; 
$allprot = getProtocols4Rem($idremote, $devicerecord['code']);
if (count($allprot) < 1){
	 	  echo "</head><body><div class=Error>";
			echo  "ERROR: no data for the device in <i>remotesDB</i><br> ";
			echo "</div>";
			exit;
      }
$idprotocol = $allprot[0][0];
//
//  include phpGUI
$phpGui = sqlValue("SELECT phpgui FROM irp_remotes WHERE idremote = $idremote"); 
if ($phpGui !== NULL){
	include("$d/extra/$phpGui");
  }
// include phpADAPTER
$phpAdapter = sqlValue("SELECT phpadapter FROM irp_protocols WHERE idprotocol = $idprotocol");
if ($phpAdapter !== NULL){
	include("$d/extra/$phpAdapter");
  }
//
echo'<style type="text/css">
// special link look for keyboard, only here
<!--
A { COLOR: black; TEXT-DECORATION: none; font-weight: bold }
A:link { COLOR: black; TEXT-DECORATION: none; font-weight: bold }
A:visited { COLOR: black; TEXT-DECORATION: none; font-weight: bold }
A:active { COLOR: black; TEXT-DECORATION: none; font-weight: bold }
A:hover { COLOR: blue; TEXT-DECORATION: none; font-weight: bold }
-->
</style>';
// javascript from phpadapter
if (function_exists ('getjscript')){
    echo getjscript();
	}
echo getSimulateRemote($idremote, $iddevice, $idprotocol, $devicerecord['code'], $mode1, $mode2, $mode3, $topline);
//			
echo '<hr><center><<<  <a  href="test_remote.php" >Back</a>	</center><br></body></html>';

exit;
//----------------------------------------------------------------  functions
function getSimulateRemote($idremote, $iddevice, $idprotocol, $code='0', $mode1='A', $mode2='?', $mode3='?', $topline){
//	key list
$remote = sqlArrayTot("SELECT row, col, keyname AS 'key', screen, idstream, idremkey, clickAction, dataDevice,
            IF( screen  REGEXP '^[[:digit:]]+$','keyn','key') AS 'class'
            FROM view_remotesheet  WHERE (code IS NULL OR code = '$code') AND ( idstream IS NOT NULL  OR clickAction IS NOT NULL) AND idremote = $idremote 
            AND ((mode ='A')  OR ('$mode1'='A')  OR(INSTR(mode,'$mode1') >0) OR(INSTR(mode, '$mode2') >0) OR(INSTR(mode,'$mode3') >0)) ORDER BY row, col ;");
$i = 0;
// table size
list($numcol,$numrow) = sqlRecord('SELECT max(col), max(row) FROM irp_remkeys WHERE idremote ='.$idremote.';');
$i =0;
$imax = count($remote);
if ($imax <1){
	 	  echo  "</head><body><div class=Error>";
			echo  "ERROR: no keys defined for the remote in <i>remotesDB</i><br> ";
			echo  "</div><br></body></html>";
			exit;
    }
$table='';
// read status and set javacode to restore it
$idStrStatus = 0;
   $idStrStatus = getStoreStream($idremote, $iddevice);  // exist special store key?
 if ( $idStrStatus != NULL){
    $status = sqlValue("SELECT dataDevice FROM irp_streams WHERE idstream = $idStrStatus"); // yes, get status
	  $table .=  "</head><body" ." onload='setData(\"".$status.'");\' >';	  // status is set in body.obload
 	}
else {
// no status, no onload
	$table .= '</head><body>';
 	}
 $table .= "<h3><i>$topline</h3><br>";	
 
 $table .='<table border=0 style= "border: solid 1px #8064a2;"><tr><td>';
 
 $table .='<table border=0 style= "border: solid 1px #8064a2;">';
 
// adds custom pad to remote control	(from phpGUI)
if (function_exists ('getpad')){
    $table .= getpad($numcol);  // if exist phpGUI
    }
// echo " imax, row, col: $imax, $numcol,$numrow <br>"; 
//  loop for keys
for ($r=1; $r <= $numrow; $r++){
	$table .='<tr style="height:48px;\n">';
	for ($c=1; $c <= $numcol; $c++){
// in case of error (2 keys with same row/col) try to fix   
	    if ($i<$imax && $remote[$i]['row'] < $r) $i++; // skips duplicate
      if ($i<$imax && $remote[$i]['row']== $r && $remote[$i]['col'] < $c) $i++;  // skips duplicate
		  if ($i<$imax &&($remote[$i]['row']== $r)&&($remote[$i]['col']== $c)){
			$tooltip = '';
			if ($remote[$i]['class'] == 'key'){   //  tooltip for not numerical keys
				$tooltip = sqlValue("SELECT tooltip FROM irp_remkeys WHERE idremkey = ".$remote[$i]['idremkey']);
				}
			$ks  = trim($remote[$i]['screen']);
			$key = $remote[$i]['key'];
			$table .='<td class=\''.$remote[$i]['class'].'\' title=\''.$tooltip.'\'>';
// the url to send this key      
	    $starturl  = "usr_simpleSerialTX.php?iddevice=$iddevice&idremote=$idremote&key=$key";
	    if ($idStrStatus != NULL) $starturl .= "&idstore=$idStrStatus";   // if status add status idstream
      if ($remote[$i]['clickAction'] == NULL) {
           // is a stic key? add idstream
            $starturl .= "&idstream=".$remote[$i]['idstream'];  
	     // add it: id= 'key23' (key+row+col), name = keyname
           $table .= "<A id='key$r$c' name='$key' href='$starturl'>$ks</A>";
      } else{
           // dynamic key with clickAction 
          $click = $remote[$i]['clickAction'];
          // updates '$url' if any
          $click = str_replace('$url',"\"$starturl\"",$click);
          $table .= "<A  id='key$r$c' name='$key' href='#' $click >$ks</A>";
       } 
			$table .="</td>\n";
			$i++;
		}else{
      // no key
			$table .="<td  class='nokey' >&nbsp;</td>\n";
			}
		}
	$table .='</tr>';
	}
  $photo='./photo/'. sqlValue("SELECT photo FROM irp_remotes WHERE idremote= $idremote");
return $table."</table></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<img src='$photo'> &nbsp;&nbsp; &nbsp;&nbsp;</td></tr></table>";
}
?>
