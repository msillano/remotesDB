 <?php
 /*
  usr_rawremote
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
//
// This is an example of 'learning' strategy. Choose and press a key on simulate remote.
// Wait...When Arduino red led  stop blinking and it is on, you press same key on simulated remote control.
// You see the captured code: if you press 'OK SAVE' the raw code will be associated to key, without any more control.
//
// functions:
//     getSimulateRemote() generates HTML code for remote control simulation (to capture RAW)
//
// NOTE: this simulation do not uses phpGUI/dynamic key/status because only static key can be learn
//
ob_clean();
echo '<html><head><meta "charset=utf-8">';
echo StyleSheet();
// special link look for keyboard, only here
echo'<style type="text/css">
<!--
A { COLOR: black; TEXT-DECORATION: none; font-weight: bold }
A:link { COLOR: black; TEXT-DECORATION: none; font-weight: bold }
A:visited { COLOR: black; TEXT-DECORATION: none; font-weight: bold }
A:active { COLOR: black; TEXT-DECORATION: none; font-weight: bold }
A:hover { COLOR: blue; TEXT-DECORATION: none; font-weight: bold }
-->
</style>';
echo '</head><body>';
if (!(isset($_GET['protocol']) && isset($_GET['remote'])&& isset($_GET['code']))){
	 	  echo "<div class=Error>";
			echo  "ERROR: missed values...";
			echo "</div>";
			exit;
}
//
$idremote = $_GET['remote'];
$idprotocol =  $_GET['protocol']; 
$code =  $_GET['code']; 
//
if($idprotocol=='none'){
    $allPrt = getProtocols4Rem($idremote, $code);
    if (isset($allPrt[0][0])) {
        $idprotocol = $allPrt[0][0];
        }
}

$key ='';
if (isset($_GET['save'])){
// ========= update remotesDB using RAW
	setStreamKeyRemote($idremote, $code, $_GET['key'],  $_GET['raw'], $idprotocol,  NULL, 1 );
	}  // end save

//============== now build simulate remote command
//
$nameremote = getRemoteName($idremote);
if (isset($_GET['save'])){
   echo "<h3><i>Updated </i>$key</h3><hr>";
} else {
   echo "<h3><i>Capture RAW from $nameremote</i>".(($code=='0')?'':" code $code")."</h3><hr>";
}
//
$actualmode='A';
if (isset($_GET['mode'])){
   $actualmode= $_GET['mode'];
   } 
	$modes =  getModes4Rem($idremote);
if (count($modes) > 1){
// modes management
	echo '<form action = "usr_rawremote.php" mode="GET">';
	echo "<input type='hidden' name ='remote' value='$idremote' >";
	echo "<input type='hidden' name ='protocol' value='$idprotocol' >";
	echo "<input type='hidden' name ='code' value='$code' >";
	echo "&nbsp;&nbsp;mode:&nbsp;&nbsp;&nbsp;"; 
	$xmode = array_keys($modes);
	if ($actualmode=='A') $actualmode= $xmode[0];
	foreach($xmode as $key){
	  if ($actualmode==$key)
	  {
		echo "<input type='radio' name='mode' CHECKED=TRUE value='$key'> &nbsp;".$modes[$key]."&nbsp;&nbsp;&nbsp;&nbsp;";
	  } else {
		echo "<input type='radio' name='mode' value='$key' > &nbsp;".$modes[$key]."&nbsp;&nbsp;&nbsp;&nbsp;";
	  }
	}
	echo "<input type='SUBMIT' name='changemode' value='CANGE'></form> ";
}
//
 echo getSimulateRemote($idremote,$idprotocol, $code, $actualmode );
// page done
 echo '<center><<<  <a  href="test_captureraw.php" >Back</a>	</center><br>
 </body>
</html>';

// ----------------------------------
function getSimulateRemote($idremote, $idprotocol, $code='0', $mode='A'){

$remotekeys = sqlArrayTot("SELECT row, col, keyname AS 'key', screen, idstream, idremkey,
            IF(idstream <=> NULL, 'keyx', 'key') AS 'class'
            FROM view_remotesheet  WHERE (code = '$code' OR code IS NULL)
			      AND idremote = $idremote AND (('$mode'='A') OR (mode='A') OR (INSTR(mode,'$mode') >0)) ORDER BY row, col ;");

list($numcol,$numrow) = sqlRecord("SELECT max(col), max(row) FROM irp_remkeys WHERE idremote = $idremote ;");
				   
$table ='<table border=0 style= "border: solid 1px #8064a2;">';
$i =0;
for ($r=1; $r <= $numrow; $r++){
	$table .='<tr style="height:48px;">';
	for ($c=1; $c <= $numcol; $c++){
// in case of error (2 keys with same row/col) try to fix   
	   if (($remotekeys[$i]['row']<$r)  && ($i <(count($remotekeys) -1)))$i++; // skips duplicate
       if (($remotekeys[$i]['row']==$r) && ($remotekeys[$i]['col']< $c)  && ($i <(count($remotekeys) -1)) ) $i++;  // skips duplicate
	   if ($remotekeys[$i]['row']==$r && $remotekeys[$i]['col']==$c ){
	        $ks  = trim($remotekeys[$i]['screen']);
	        $key = $remotekeys[$i]['key'];
			$table .='<td class=\''.$remotekeys[$i]['class'].'\'><a href="usr_simplerawRX.php?protocol='.($idprotocol == NULL ? 'none': $idprotocol).'&remote='.$idremote.'&code='.$code.'&mode='.$mode.'&key='.$key.'">'.$ks."</a></td>";
			if ($i <(count($remotekeys) -1)) $i++;
	   }else{
			$table .='<td>&nbsp;</td>';
	   }
	}
	$table .="<td  class='nokey' >&nbsp;</td>";
	}
return $table.'</table>';
}
?>
