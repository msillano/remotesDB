<?php
/*
  irp_rxtxZero - Example for irp_classes (https://github.com/msillano/irp_classes)
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
// dummy rx/tx without hardware, replaces irp_rxtxArduino.php
// 
function txArduino($raw)
  {
  echo "<script type='text/javascript'>alert(".'"WITHOUT ARDUINO\n Transmission simulation of RAW command"'.");</script>";
  }
//  receive RAW fron Arduino
function rxArduino($idprotocol = 2)
  {
  echo "<script type='text/javascript'>alert(".'"WITHOUT ARDUINO\n Receive simulation of IR command\n do not save it"'.");</script>";
  switch($idprotocol) {
   case 2:
        return       '8934|-4570|486|-638|486|-638|482|-642|486|-638|482|-1762|490|-634|486|-1762|486|-638|486|-1758|462|-1786|486|-1762|486|-1762|486|-634|486|-1762|486|-638|486|-1762|482|-638|486|-1762|486|-638|486|-638|482|-1766|482|-638|486|-638|486|-638|482|-1766|482|-642|486|-1762|482|-1762|462|-662|486|-1758|462|-1786|486|-1762|486|-1000';
   case 3:
        return '3304|-1652|413|-413|413|-413|413|-1239|413|-413|413|-1239|413|-413|413|-413|413|-413|413|-1239|413|-1239|413|-413|413|-413|413|-413|413|-1239|413|-1239|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-1239|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-1239|413|-413|413|-413|413|-413|413|-413|413|-1239|413|-1239|413|-1239|413|-1239|413|-1239|413|-1239|413|-1239|413|-1239|413|-413|413|-413|413|-1239|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-1239|413|-1239|413|-413|413|-413|413|-1239|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-1239|413|-413|413|-413|413|-1239|413|-1239|413|-413|413|-413|413|-413|413|-413|413|-1239|413|-413|413|-1239|413|-413|413|-1239|413|-413|413|-413|413|-413|413|-413|413|-413|413|-1239|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-1239|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-413|413|-1239|413|-413|413|-413|413|-1239|413|-1239|413|-1239|413|-413|413|-1239|413|-413|413|-413|413|-413|413|-104300';
  case 4:
        return '8914|-4570|486|-638|486|-638|486|-638|482|-642|486|-1758|486|-638|486|-1762|486|-638|482|-1762|486|-1762|486|-1762|486|-1762|514|-610|482|-1762|486|-638|486|-1762|482|-1766|486|-1758|486|-638|486|-638|486|-638|486|-638|486|-1762|482|-642|482|-638|486|-638|486|-1762|482|-1762|462|-1786|486|-1762|486|-638|486|-1762|482|-1000';
  default:
         echo 'Unknown protocol! Modify irp_rxtxZero.php <br>';
       }
   }
?>