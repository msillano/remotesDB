<?php
/*
do_keyfromfile - 
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
$d = dirname(__FILE__);
require_once("$d/irp_commonSQL.php");
require_once("$d/irp_remotedb_tools.php");
// functions:
// readKeyFile() populates the table 'irp_actions' using a text file.
// saveKeyFile() exports the table 'irp_actions' to a text file.
function saveKeyFile($keyfile)
{
    $dataout = "#\r\n";
    $dataout .= "# " . date('d/m/Y') . "\r\n";
    $dataout .= "#\r\n";
    $dataout .= "# list of remote key names \r\n";
    $dataout .= "# standard key names like KEY_XXXX \r\n";
    $dataout .= "# custom key names like XXXX_KEY \r\n";
    $dataout .= "#\r\n";
    //
    $keyTable = sqlArrayTot('SELECT * from irp_actions ORDER BY keyname ;');
    foreach ($keyTable AS $row) {
        $dataout .= strspace($row[0], 25);
        $dataout .= strspace($row[1], 20);
        $dataout .= html_entity_decode(trim($row[3]), ENT_QUOTES) . "\r\n";
    }
    file_put_contents($keyfile, $dataout);
}
//
function readKeyFile($keyfile)
{
    $data = file($keyfile);
    foreach ($data as $line) {
        $line = trim($line);
        if ($line != '' && $line[0] != '#') {
            $key = strtok($line, " \n\t");
            $ui  = trim(strtok(" \n\t"));
            if (($ui == '') || ($ui[0] == '#')) {
                setKeyRemote(trim($key));
                continue;
            }
            $note = trim(strtok("\n"));
            if (($note == '') || ($note[0] == '#')) {
                setKeyRemote(trim($key), $ui);
                continue;
            }
            setKeyRemote(trim($key), $ui, htmlspecialchars($note, ENT_QUOTES));
        }
    } // ends foreach
}
?>