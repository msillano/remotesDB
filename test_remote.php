<html>
<head>
<?php
/* this page is for test local DB
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
 
	$devices = getDevicesOptionList(null,null,'visible');
	echo StyleSheet();
    $message ='';
	$page='-1';
    
?>
</head>
<body>
<h1> Simulate remote control </h1>
 <hr>

<div class='note'>
This 'proof of concept' can simulate any remote control present on remoteDB, sending the commands you choose.
It requires an Arduino, talking via serial to php: I use here the free version of <a href='http://www.thebyteworks.com'>PHP Serial extension</a>, ok to do tests, but having some limits:
<ul><li>random delays on function calls: <i>you must wait.</i>
    <li>limit to 1000 bytes: <i>shutdown and restart the server before any test.</i>
</ul>	
For real applications you must use a better communication tool: I use the USBphpTunnel  (<a href='https://sourceforge.net/projects/usbphptunnel/'>sourceforge</a>) that solves all connection problems, or you can use an Arduino-yun.
</div>

<hr>
<form action = 'USR_simremote.php' mode='GET'>
	Device:&nbsp;&nbsp;&nbsp;
	<select name='device'>
	<?php echo $devices; ?>
	</select><br><br>
		<hr>
	<input type ='submit' name= 'toRemote' value='Go >> '>
</form>
		 <hr> 
		 <center><<<  <a  href="javascript:history.go(<?php echo $page; ?>)" >Back</a>	</center>

</body></head>


