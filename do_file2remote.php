<!--
  do_file2remote - 
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
-->
<htmal><head>
<?php
$d = dirname(__FILE__);
require_once("$d/irp_commonSQL.php");
require_once("$d/irp_remotedb_tools.php");

// functions:
// import_from_lirc() populates the tables irp_actions, irp_remkeys, irp_remcommands, irp_streams using a lirc file.
// import_remote_from_sheet() populates the tables irp_actions, irp_remkeys, irp_remcommands, irp_streams using a 'remote sheet' text file.
// export_remote_to_sheet() exports from irp_actions, irp_remkeys, irp_remcommands, irp_streams tables to a 'remote sheet' text file.
echo StyleSheet();
echo '</head><body>';

$idremote   = $_GET['remote'];
$idprotocol = $_GET['protocol'];
/*
echo '<pre>'; print_r($_GET); echo '</pre>';
*/
// test for code
$code       = '0';
if (isset($_GET['code'])) {
    $code = $_GET['code'];
} else {
    $codes = getCodesOptionList4Rem($idremote);
 // no codes   
    if ((isset($_GET['toFile'])) && ($codes == '')) {
        echo "<div class='error'>";
        echo 'WARNING: This Remote control as not code association in remotesDB <br>';
        echo ' </div>';
        //    echo 'Nothing to do.';
        //		echo ' </div></body></html><hr><center><<< <a  href="test_file2remote.php" >Back</a></center></body></html>' ;
        //		exit;		
    }
// test for code    
    if ((strpos($codes, "value='0'") === false) && (strpos($codes, "value=") !== false)) { //  to test if are codes
        echo "<div class='note'><form action = 'do_file2remote.php' mode='GET'>";
        echo 'This <b>IR Remote Control</b> is  multiple. You must select a code:';
        echo '<input type="hidden" name ="remote" value="' . $idremote . '">';
        echo '<input type="hidden" name ="protocol" value="' . $idprotocol . '">';
        echo '<input type="hidden" name ="fname" value="' . $_GET['fname'] . '">';
        if (isset($_GET['lircm']))
            echo '<input type="hidden" name ="lircm" value="go">';
        if (isset($_GET['toFile']))
            echo '<input type="hidden" name ="toFile" value="go">';
        if (isset($_GET['merge']))
            echo '<input type="hidden" name ="merge" value="go">';
        if (isset($_GET['copy']))
            echo '<input type="hidden" name ="copy" value="go">';
        echo '&nbsp;';
        echo "<select name='code' value='0' >";
        echo $codes;
        echo "</select><br><hr><input type='submit' value=' Done '><br> </form>";
        echo '</div></body></html><hr><center><<< <a  href="test_file2remote.php" >Back</a></center></body></html>';
        exit;
    }
}
// test for lirc file
$lircfile = '';
if (isset($_GET['lircm']) || isset($_GET['lircc'])) {
    $lircfile = $_GET['fname'];
    if (!file_exists($lircfile)) {
        $lircfile = dirname(__FILE__) . '\\sheet\\' . $_GET['fname'];
    }
    if (!file_exists($lircfile) || $_GET['fname'] == '') {
        echo "<div class='Error'>";
        echo "ERROR: lirc file not found!:<br>";
        echo '<code>' . $lircfile . '</code><br>';
        echo '</div></body></html><hr><center><<< <a  href="test_file2remote.php" >Back</a></center></body></html>';
        exit;
    }
}
// test for import file
if (isset($_GET['merge']) || isset($_GET['copy'])) {
    $infile = getRemoteFileSheetPath($idremote, $code);
    if (!file_exists($infile)) {
        echo "<div class=Error>";
        echo "ERROR: file not found! Export it before.<br>";
        echo '<code>' . $infile . '</code><br>';
        echo '</div></body></html><hr><center><<< <a  href="test_file2remote.php" >Back</a></center></body></html>';
        exit;
    }
 }
// test for protocol
if (isset($_GET['merge']) || isset($_GET['copy']) || isset($_GET['toFile'])){
   $idprotocol = NULL;
   $allPrt = getProtocols4Rem($idremote, $code);
   if (isset($allPrt[0][0])) {
      $idprotocol = $allPrt[0][0];
      }
   if ($idprotocol == NULL){
      echo "<div class=Error>";
      echo "ERROR: Unknown protocol.<br>For the control#$idremote and the code '$code' do not exist a record on <code>irp_remdev</code> table.<BR>";
      echo '</div></body></html><hr><center><<< <a  href="test_file2remote.php" >Back</a></center></body></html>';
      exit;
   }
}
// echo " idremote: $idremote, idprotocol:  $idprotocol, code: $code <br>"; 
// ok go
$listkeys = array();
if (isset($_GET['merge']) || isset($_GET['copy'])) { // from sheet
    $listkeys = import_remote_from_sheet($idremote, $idprotocol, $code);
}
if (isset($_GET['lircm'])) { // from lirc
    $listkeys = import_from_lirc($lircfile, $idremote, $idprotocol, $code);
}
if (isset($_GET['toFile'])) { // to file sheet
    export_remote_to_sheet($idremote, $idprotocol, $code);
}
if (isset($_GET['copy'])) { // II  pass
    delete_remkeys_extra_force($listkeys, $idremote, $code);
}
echo '<hr> 
		 <center><<<  <a  href="test_file2remote.php" >Back</a>	</center>
	</body>
</html>';
exit;

// ================================================== import/export functions

function export_remote_to_sheet($idremote, $idprotocol, $code)
{
    //  general
    $remotetable = sqlArrayTot("SELECT * FROM view_remotesheet WHERE idremote = $idremote AND (code = '$code'  OR code IS NULL) ORDER BY row, col;");
    if (count($remotetable) < 1) {
        echo "<div class=Error>";
        echo "WARNING: no KEY for this remote control<br>";
        echo "</div>";
        //			exit;
    }
    
    $dataout = "#\r\n";
    $dataout .= "# " . date('d/m/Y') . "\r\n";
    $dataout .= "#\r\n";
    
    $datarem = sqlRecord("SELECT * FROM irp_remotes WHERE idremote =$idremote;");
    $dataout .= strspace('# remote control brand:', 33) . $datarem['brand'] . "\r\n";
    $dataout .= strspace('# model no. of remote control:', 33) . $datarem['rem_model'] . "\r\n";
    //
    if ($datarem['modes'] != '')
        $dataout .= strspace('# remote control modes:', 33) . $datarem['modes'] . "\r\n";
    if ($code != '0') {
        $codes = getCodes4Rem($idremote);
        $dataout .= strspace('# multi-remote codes:', 33) . "stored " . count($codes) . "\r\n";
    }
    $dataout .= strspace('# control documentation:', 33) . $datarem['rem_url'] . "\r\n";
    $dataout .= "# \r\n";
    //
    $purl  = sqlValue("SELECT prt_url FROM irp_protocols WHERE idprotocol = $idprotocol");
    $dataout .= strspace('# protocol:', 33) . getProtocolName($idprotocol) . "\r\n";
    $dataout .= strspace('# protocol documentation:', 33) . "$purl\r\n";
    $dataout .= "# \r\n";
    //	
    $devices = getDevices4Rem($idremote);
    if (count($devices) > 0) {
        $dataout .= "# devices being controlled by this remote:\r\n";
        foreach ($devices AS $adev) {
            $dataout .= "#     " . (($adev['code'] == '0') ? strspace('', 16) : strspace("code = " . $adev['code'], 16));
            $dataout .= "           " . $adev['name'] . "\r\n";
        }
        $dataout .= "# \r\n";
    }
    //
    $keyout = array();
    $dataout .= "#-------NAME------------------ROW---COL---MODE--------[action]|[[repeat] --- [[dataP]----[dataD]----[***]]|[raw]]\r\n";
    $dataout .= " \r\n";
    $dataout .= "\r\n";
    if ($code != '0') {
        $dataout .= '  remote command code:  ' . ((string) $code) . "\r\n\r\n";
    }
    $dataout .= "  begin codes \r\n";
    foreach ($remotetable AS $remkey) {
        if ($remkey['col'] == '')
            $remkey['col'] = '?';
        if ($remkey['row'] == '')
            $remkey['row'] = '?';
        $dataout .= "        " . strspace(trim($remkey['keyname']), 22);
        $dataout .= strspace(trim($remkey['row']), 6);
        $dataout .= strspace(trim($remkey['col']), 6);
        $dataout .= strspace(trim($remkey['mode']), 12);
        if ($remkey['clickAction'] != '') {
            $dataout .= $remkey['clickAction'];
        } else {
            $dataout .= strspace('  ' . trim($remkey['repeat']), 8);
            if ($remkey['HEX'] == '' && $remkey['dataProtocol'] == '' && $remkey['dataDevice'] == '' && $remkey['RAW1'] != '') {
                $dataout .= $remkey['RAW1'];
            } else {
                $dataout .= strspace(trim($remkey['HEX']), 18);
                $dataout .= strspace(trim($remkey['dataProtocol']), 18);
                if ($remkey['dataDevice'] != '')
                    $dataout .= strspace($remkey['dataDevice'], 18);
                if ($remkey['RAW1'] != '')
                    $dataout .= '***';
            }
        }
        $keyout[] = trim($remkey['keyname']);
        $dataout .= " \r\n";
    } // foreach
    
    $dataout .= "    end codes \r\n";
    $outfile = getRemoteFileSheetPath($idremote, $code);
    file_put_contents($outfile, $dataout);
    echo '<BR> ====== Output sheet: <A target="new" href ="' . getRemoteFileSheetURL($idremote, $code) . '"><code>' . basename($outfile) . ' </code></A><br><br>';
    echo ' ====== saved keys in sheet: ' . count($keyout) . ' <br>';
    return $keyout;
}


function import_from_lirc($infile, $idremote, $idprotocol, $code)
{
    echo '<br> ====== Input lirc: <code>' . $infile . '</code><pre>';
    $dbRemote = sqlRecord('SELECT brand, rem_model FROM irp_remotes WHERE idremote =' . $idremote . ';');
    $data     = file($infile);
    $bits     = 64;
    $brand    = 'not found';
    $model    = 'not found';
    $go       = false;
    $ncode    = 0;
    $lirklist = array();
    foreach ($data as $line) {
        //	# brand:                       HITACHI
        //  # model no. of remote control: CLE-941
        if ((!$go) && (strpos($line, 'brand:') !== false)) {
            $brand = trim(substr($line, 10));
            continue;
        }
        if ((!$go) && (strpos($line, 'model no. of remote') !== false)) {
            $model = trim(substr($line, 30));
            continue;
        }
        
        if ((!$go) && (strpos($line, ' bits ') !== false)) {
            strtok($line, " \n\t");
            $bits = strtok(" \n\t");
            continue;
        }
        if (strpos($line, 'command code:') !== false) {
            $ncode = trim(substr($line, 23));
            continue;
        }
        if (strpos($line, 'end codes') !== false) {
            $go = false;
            continue;
        }
        // line with key codes: process	
        if ($go) {
            //   echo $line.'<br>';
            $key = strtok($line, " \n\t");
            if (trim($key) == '')
                continue;
            $hex = trim(strtok(" \n\t"));
            if (strpos($key, 'KEY') === false) {
                $key .= '_KEY';
            }
            if (isKeyPresent($key)) {
                setStreamKeyRemote($idremote, $code, $key, NULL, $idprotocol, substr($hex, -ceil($bits / 4)));
                $lirklist[] = $key;
                echo " " . strspace($key, 22) . "added/updated<br>";
            } else {
                echo " " . strspace($key, 22) . "unknown: skipped<br>";
            }
            continue;
        }
        if (strpos($line, 'begin codes') !== false) {
            $go = true;
            if (strtoupper($dbRemote['brand']) != strtoupper($brand))
                echo '+++ WARNING Remote Brand difference: ' . $brand . ' vs ' . $dbRemote['brand'] . '<br><br>';
            if (strtoupper($dbRemote['rem_model']) != strtoupper($model))
                echo '+++ WARNING Remote Model difference: ' . $model . ' vs ' . $dbRemote['rem_model'] . '<br><br>';
            if ($code != $ncode) {
                echo "+++ WARNING found new Remote code $ncode (old $code). Using the lirc code!<br><br>";
                $code = $ncode;
            }
        }
    }
    echo '</pre>';
    return $lirklist;
}

// this read from sheet all data and insert/updates in remotesDB
function import_remote_from_sheet($idremote, $idprotocol, $code)
{
    $infile = getRemoteFileSheetPath($idremote, $code);
    echo '<br> ====== Input sheet: <code>' . $infile . '</code><br><pre>';
    $rddata     = file($infile);
    $goK        = false;
    $goD        = false;
    $valPro     = '';
    $valDev     = '';
    $rbrand     = '';
    $rmodel     = '';
    $dbrand     = array();
    $dmodel     = array();
    $pname      = '';
    $modes      = '';
    $iddevice   = 0;
    $iddevprt   = 0;
    $ncode      = 0;
    $keylist    = array();
    foreach ($rddata as $aline) {
        if ($goD) {
            $parts = explode(' ', $aline);
            if (!isset($parts[2])) {
                $doD = false;
                continue;
            }
            $dbrand[] = trim($parts[1]);
            $dmodel[] = trim($parts[2]);
        }
        //	echo 'line = '.$aline.'<br>';
        if ($p = strpos($aline, 'control brand:')) {
            $rbrand = trim(substr($aline, $p + 16));
            continue;
        }
        if ($p = strpos($aline, 'of remote control:')) {
            $rmodel = trim(substr($aline, $p + 20));
            $idr    = getRemoteId($rbrand, $rmodel);
            if ($idr != $idremote) {
                echo "<div class=Error>";
                echo "ERROR found bad Control name on sheet: '$rbrand $rmodel' id#$idr <br>good: id#$idremote.<br><br>";
                echo "</div>";
                exit;
            }
            continue;
        }
        if ($p = strpos($aline, 'control modes:')) {
            $modes = trim(substr($aline, $p + 31));
            continue;
        }
        if ($p = strpos($aline, 'controlled by')) {
            $goD = true;
            continue;
        }
        if ($p = strpos($aline, 'protocol:')) {
            $pname      = trim(substr($aline, $p + 10));
            $ndprotocol = getProtocolId($pname);
            if ($idprotocol != $ndprotocol) {
                echo "<div class=Error>";
                echo "ERROR: found bad Protocol on sheet: '$pname' id#$ndprotocol <br>good: id#$idprotocol<br><br>";
                echo "</div>";
                exit;
            }
            continue;
        }
        if (strpos($aline, 'end codes')) {
            $goK = false;
            continue;
        }
        // line with key codes: process	
        if ($goK) {
            //		   echo ' go >> '. $aline.'<br>';
            $new = saveDataFromSheet($aline, $idremote, $code, $idprotocol);
            if ($new === false)
                continue;
            echo " " . strspace($new, 22) . "added/updated<br>";
            $keylist[] = $new;
            continue;
        }
        if (strpos($aline, 'begin codes')) {
            $goK = true;
        }
    }
    echo '</pre>';
    return $keylist;
}

//  ===========================================  locals
// for every text line saves a key,
// returns key or false
function saveDataFromSheet($aline, $idremote, $code, $idprotocol)
{
    $hex   = '';
    $rep   = 1;
    $valP  = '';
    $valD  = '';
    $key   = '';
    $row   = '!';
    $col   = '!';
    $mode  = 'A';
    $click = '';
    $raw   = '';
    $aline = trim($aline);
    if (($aline == '') || ($aline[0] == '#'))
        return false;
    $pars = explode(' ', $aline);
    foreach ($pars AS $aval) {
        $aval = trim($aval);
        if ($aval == '')
            continue;
        if ($aval[0] == '*')
            continue;
        if ($aval[0] == '#')
            break;
        if (($key == '') && (strpos($aval, 'KEY') !== false)) {
            $key = $aval;
            continue;
        }
        if (($aval == '?') && ($row == '!')) {
            $row = '?';
            continue;
        }
        if (($aval == '?') && ($col == '!')) {
            $col = '?';
            continue;
        }
        if ((strlen($aval) < 3) && (ctype_digit($aval)) && ($row == '!')) {
            $row = $aval;
            continue;
        }
        if ((strlen($aval) < 3) && (ctype_digit($aval)) && ($col == '!')) {
            $col = $aval;
            continue;
        }
        if ((strlen($aval) < 2) && (ctype_digit($aval)) && ($rep == 1)) {
            $rep = $aval;
            continue;
        }
        if ((strlen($aval) > 3) && ($aval[0] == '{') && ($valP == '') && (strpos($aval, '|') === false)) {
            $valP = $aval;
            continue;
        }
        if ((strlen($aval) > 3) && ($aval[0] == '{') && ($valD == '') && (strpos($aval, '|') === false)) {
            $valD = $aval;
            continue;
        }
//        if ((strlen($aval) > 4) && (!ctype_xdigit($aval)) && ($aval[strlen($aval) - 1] == ';')) {
          if ((strlen($aval) > 4) && (!ctype_xdigit($aval)) && ($aval[0] =='o') && ($aval[1] =='n') && (strpos($aval, '=') !== false)) {
            $click .= ' '. $aval;
            continue;
        }
        if ((strlen($aval) >= 2) && (ctype_xdigit($aval))) {
            $hex = $aval;
            continue;
        }
        if ((strlen($aval) < 10) && (ctype_upper($aval) || (strpos($aval, ',') !== false))) {
            $mode = $aval;
            continue;
        }
        if ((strlen($aval) > 10) && ($aval[0] == '{') && (strpos($aval, '|') !== false)) {
            $raw = $aval;
            continue;
        }
    }
    // echo 'data: '.$key.', NULL, NULL,'. $idremote.', r: '.$row.'=>'.($row == '?'?'NULL':$row).', c: '.$col.'=>'.($col == '?'?'NULL':$col).', '.$mode.' )<br>';
    // echo 'data: '.$idremote.', cod: '.$code.', '.$key.', p: '.$idprotocol.', '.($hex == ''?'NULL':$hex).', rep '.$rep.', '.($valP == ''?'NULL':$valP).', '.($valD == ''?'NULL':$valD).', NULL ); <br>';
     if ((string) $row == '0' && (string) $col == '0') {
        setStreamKeyStorage($idremote, $code, $key, $idprotocol);
        return $key;
    } else if ($key != '') {
        if ($row == '!')
            $row = '?';
        if ($col == '!')
            $col = '?';
      $click = trim($click) ;
      $click = addcslashes($click,"\'\"\\");
      $idremkey = setKeyRemote($key, NULL, NULL, $idremote, ($row == '?' ? NULL : $row), ($col == '?' ? NULL : $col), $mode, ($click == '' ? NULL : $click)); //  set/updates
   
       if ($click == '') {
            setStreamKeyRemote($idremote, $code, $key, ($raw == '' ? NULL : $raw), $idprotocol, ($hex == '' ? NULL : $hex), ((int) $rep == 0 ? NULL : $rep), ($valP == '' ? NULL : $valP), ($valD == '' ? NULL : $valD));
        } else {
            // no stream if clickAction, so delete old			
            $idstream = sqlValue("SELECT idstream FROM irp_remcommands WHERE idremkey = $idremkey " . ($code == 0 ? '' : "AND code = $code ") . "LIMIT 1");
            if ($idstream != NULL) {
                //	 echo " found: delete ( $idremkey ): $idstream <br>";
                doLimitDeleteStream($idstream, $idremote, NULL, ($code == 0 ? NULL : $code));
            }
        }
        return $key;
    }
    return false;
}

// keep in DB only oklist keys for ($idremote, $code). All other keys are deleted (not on irp_actions)
function delete_remkeys_extra_force($oklist, $idremote, $code) // code == 0, all
{
    $actualkeys = sqlLookup(" SELECT  keyname, idremkey FROM irp_remkeys WHERE idremote = $idremote ;");
    echo ' ====== key updated: ' . count($oklist) . ' in remoteDB: ' . count($actualkeys) . ' <br><pre>';
    $listok = array_flip($oklist);
    foreach ($actualkeys as $key => $id) {
        if (!array_key_exists($key, $listok)) {
            $n = limitdeleteremkey($id, NULL, $code); // forces
            if ($n == 0)
                echo "  " . strspace(trim($key), 22) . " not deleted<br>";
            if ($n > 0)
                echo "  " . strspace(trim($key), 22) . " deleted<br>";
        }
    }
    echo '</pre>';
    return;
}
?>