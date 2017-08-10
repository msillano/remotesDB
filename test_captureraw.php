<html>
<head>
<?php
/*
   this page is for test local DB
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

	$remotes   = getRemotesOptionList();
	$protocols = getProtocolsOptionList();
	$codes     = optionsList("SELECT DISTINCT code, code FROM irp_remcommands", '0');
	if (strpos($codes, "value='0'") === false)
	    $codes = "<option value='0' selected >0-default</opton>".$codes;
	echo StyleSheet();
    $message ='';
	$page='-1';
    
?>
</head>
<body>
<h1> Capture RAW for any remote </h1>
 <hr>

<div class='note'>
This example page make easy to capture RAW stream from remote controls.
<UL>
<LI>This application fills RAW1 field in <code>irp_streams</code> and link it to remote.
<LI>Click a pink key in simulated remote, then, when Arduino red led is on, click same key on remote control.
<LI>Using free 'serial extension', you have usual limits: to restart server before any test.
<LI>After you must run the <a href='test_fillUpd.php'>fill/update</a> tool.
</UL>	
For real applications you must use a better communication tool: I planned to use the USBphpTunnel  (<a href='https://sourceforge.net/projects/usbphptunnel/'>sourceforge</a>) that solves all connection problems, or you can use an Arduino-yun.
</div>

<hr>
<form action = 'usr_rawremote.php' mode='GET'>
	Remote:&nbsp;&nbsp;&nbsp;
	<select name='remote'>
	<?php echo $remotes; ?>
	</select>
	Code: &nbsp;&nbsp;&nbsp;
	<select name='code'>
	<?php echo $codes; ?>
	</select>&nbsp; 
	<i>for multi protocol programmable remote, select a code.</i> <br>
	Protocol:&nbsp;&nbsp;
	<select name='protocol'>
	<option value='none' selected >default</opton>
	<?php echo $protocols; ?>
	</select><br><br>
	<hr>	
	<input type ='submit' name= 'toRemote' value='Go >> '>
</form>
		 <hr> 
		 <center><<<  <a  href="index.html" >Back</a>	</center>

</body></head>


