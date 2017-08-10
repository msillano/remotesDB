<?php
/*
Library irp_remotedb_raw: handling RAW simple functions
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
//=============================================  functions 
function getCRCRAW($raw){
// for RAW, RAW0, RAW1, RAW2
// gets and format the CRC32 of RAW 
// excludes last 3 numbers, to get better results with captured RAW
   $xraw = substr($raw, 0, strrpos($raw,'|'));
   $xraw = substr($xraw, 0, strrpos($xraw,'|'));
   $xraw = substr($xraw, 0, strrpos($xraw,'|'));
   return  substr('00000000'.strtoupper(dechex(crc32($xraw))),-8);
}

function  equalsRaws($raw1, $raw2){
// for RAW, RAW0, RAW1, RAW2
// excludes last 3 numbers, to get better results with captured RAW
   $xraw = substr($raw1, 0, strrpos($raw1,'|'));
   $xraw = substr($xraw, 0, strrpos($xraw,'|'));
   $xraw = substr($xraw, 0, strrpos($xraw,'|'));
   $xraw2 =  substr($raw2, 0, strlen($xraw));
   return ($xraw == $xraw2);
}

// anti collisions test, limited to processed streams (i.e. streams with CRCRAW field not NULL)
// returns NULL (not found) or idstream
// for RAW, RAW0, RAW1, RAW2
function getSameStream4Raw($raw){
   $crc  = getCRCRAW($raw);
   $streams = sqlArrayTot("SELECT idstream, RAW1 FROM irp_streams WHERE CRCRAW = '$crc';");
   foreach($streams AS $stream){
         if (equalsRaws($stream[1], $raw)) return  $stream[0];
         }
   return NULL;
}



?>