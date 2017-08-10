<html>
<head>
<?php
/* this page is for local DB management
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
// libraries:
	require_once ("$d/irp_commonSQL.php");
	require_once ("$d/irp_remotedb_tools.php");
//	
	$remotes = getRemotesOptionList();
	$protocols = getProtocolsOptionList();
	echo StyleSheet();
 /*
 echo '<pre>';
 print_r($_GET);
 echo '</pre>';
*/
    $message ='';
    if(isset($_GET['done'])){
		$message='<hr><h3><i>Database updated.</i></h3>'; 
		}
 
    if(isset($_GET['clear'])){
	   sql("TRUNCATE TABLE  `irp_remkeys`");
	   sql("TRUNCATE TABLE  `irp_remcommands`");
	   sql("TRUNCATE TABLE  `irp_devcommands`");
	   sql("TRUNCATE TABLE  `irp_streams`");
 	   $message='<hr><h3><i>Database empty: restart.</i></h3>'; 
   }
?>
</head>
<body>
<h1> Update remoteDB using lirc or sheet files </h1>
 <?php echo $message; ?>
<hr>
This allow to update the remoteDB using lirc files (only import) or 'sheet' text files (import/export).
Of course, using lirc, not all field will be update, because some data are unknowns.<br>
Using this tool, long and critical data entry can be avoided, and the referential integrity can be guaranteed.<br>
<i>For <b>lirc</b> files: choose the file in <code>/sheet/</code> dir.<br>
For <b>sheet</b> files: autosave in <code>/sheet/</code> dir.<br>
</i>

<div class='note'>To add a new remote control:
<ol>
<li>You must add a new record on table <code>irp_remotes</code>, and complete it (e.g. using <i>phpMyAdmin</i>)<br>
<i> You can use <a href="./../phpIRPlib/decode-test.php">decode-test</a> to investigate a new remote control and protocol.</i>
<li>If is a new protocol, add it in <code>irp_protocols</code>. Do it also for 'unknown' protocols in RAW learning strategy.
<li>Choose or add a target device, add a record to <code>irp_devrem</code>.
<li>To start, you can import a <a href="http://lirc-remotes.sourceforge.net/remotes-table.html" target='new'>lirc file</a><br>
<i>Before you import the lirc file, you have to check the <code>KEY_NAMES</code>: use as possible only standard names from <b>irp_actions</b> table. For custom key names, use the convention <b>NAME_KEY</b>.</i>
<li>Export now the sheet file.
<li>Update the sheet file, verify all data, add <b>device values</b>, add <b>row</b> and <b>col</b> key positions<br>
<i>The fixed data of protocol (device, subdevice values) can be different from lirc indications. Sometime a device can answer to more than one device code (e.g. for broadcasting): use the 'role' field to differentiate (tools checks for 'USE' role) <br>I found also that many control remote keys are missed in lirc files: you can add it now or after.</i>
<li>Import the updated sheet file, in 'copy' mode.

</ol>
All remote controls tables will be updates (<code>irp_actions, irp_remkeys, irp_remcommands, irp_streams</code>).<br>
After, the tool <a href='test_fillUpd.php'>fill/update</a> can complete the remoteDB structure, setting correct Device links (in <code>irp_devcommands</code>).<br>
Now you can capture the RAW commands for new keys using <a href="test_captureraw.php">RAW capture demo</a><br>
This is fast and it make the sheet files a good backup strategy, at least for the initial phases: at your own risk, <a href ='./test_file2remote.php?clear=yes'  onclick="return confirm('DATABASE TRUNCATE \n\rThis will truncate irp_remkey, irp_remcommands, irps_streams, irp_devcommand tables! \n All data will be lost. You can rebuild it using your sheets. \n Are you sure?')">click here</a> to truncate some tables and do a restart..
<br>note:<i>
 <UL><li>In 'SHEET TO DB' only key data are imported: othere fields - in comments (#) - are only for info: If you like to change it, you must use phpMyAdmin to edit records on remoteDB.
 <LI>  Not all devices uses all keys of a remote control: in <code>irp_remkey</code> table are all keys of a control, while in 
<code>irp_devcommands</code> are only the commands that a device can receive (based on 'modal' infos). In <code>irp_remcommands</code> they are the links <code>irp_remkey</code>  to <code>irp_streams</code>. 
 </UL></i>
This database holds many informations, not only codes and streams: the goal is to enable you to build simulations as closes as possible to real things. Of course you can use only a subset of that in your applications.
</div>
<hr>
<form action = 'do_file2remote.php' mode='GET'>
	Remote: &nbsp;
	<select name='remote'>
	<?php echo $remotes; ?>
	</select> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type ='submit' name= 'toFile' value='DB to SHEET'>&nbsp;&nbsp;&nbsp;<input type ='submit' name='copy' value='SHEET to DB: copy'> &nbsp;&nbsp;&nbsp;<input type ='submit' name='merge' value='SHEET to DB: merge'><br><br>
	<i>For import lirc files, also:</i><br>
	Protocol: &nbsp;
	<select name='protocol'>
	<?php echo $protocols; ?>
	</select>&nbsp;&nbsp;&nbsp;
	File (<i>in /sheet/</i>):
	<input type='file' name = 'fname'/>&nbsp;&nbsp;&nbsp;<input type ='submit' name='lircm' value='LIRC to DB: merge'>
	<hr>
</form>
 <center><<<  <a  href="index.html" >Back</a>	</center>

</body></head>
