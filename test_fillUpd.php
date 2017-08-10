	   
<html>
	<head>
<?php	
/* this page is for local DB management
 requires the file 'icons/Black.png'

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
/*
echo '<pre>';  // for test
print_r($_GET);				
echo '</pre>';
*/
ob_clean();
echo '<html><head><meta "charset=utf-8">';
echo StyleSheet();
 $message ='';
 $page = -1;
 $remotes = getRemotesOptionList();
  	   	
?>	  
	</head>		
	<body>
		 <h1>Fill IR stream data, update devices</h1>  
		 <?php echo $message; ?>
		 <div class='note'>
		 You started updating Keys in irp_action. Then you add a new Remote Control.
		 If you use a Lirc file, u have only HEX data. If you capture  the stream for keys missed in lirc, you have
		 only RAW1. Now you finish, all keys are ok, the modes set and rows and cols ok.<br>
		 If the IRP is unknown (field IRP NULL), you can use only the captured RAWs, but, if you know the IRP, using <code>irp_classes</code> you can:
		 <ul> <li> Complete all fields <code>HEX, dataProtocol, dataDevice, RAW1</code> starting from HEX or RAW.
              <li> Replace a RAW1 captured from HW with a RAW1 calculated, more precise.
			  </ul>
	     In any case this tool calculates the CRCRAW, used as 'flag' for processed streams and as fast key.<br>

		 If exist some Device linked with the this Remote Control (table <code>irp_devrem</code>), this tool can also updates all Device fields from the Remote Command data selecting only compatible commands: if some keys of a Remote Command are not accepted by a Device, you can set before the <i>modal</i> structure (you can use phpMyAdmin or sheet): the default mode is 'A' for 'all'.		 
			  
</div><hr>
	<form action = 'do_fillupd.php' mode='GET'>
	Remote Control: &nbsp;
	<select name='remote'>
	<?php echo $remotes; ?>
	</select><br><br>
	<input type='radio' name = 'do' value='streams'> &nbsp; Stream processing &nbsp; &nbsp; &nbsp; &nbsp; 
	<input type='radio' name = 'do' value='device'> &nbsp; Devices update &nbsp; &nbsp; &nbsp; &nbsp; 
	<input type='radio' name = 'do' value='both' checked > &nbsp; Both tasks &nbsp; &nbsp; &nbsp; &nbsp;
	<input type ='submit'  value='Execute'> <br>
    </form>		
	<hr> 
    <center><<<  <a  href="index.html" >Back</a>	</center>
	</body>
</html>