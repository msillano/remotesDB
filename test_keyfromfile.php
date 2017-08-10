<?php 
/* this page is for local DB management 
 requires the file 'icons/_black.png (see conventions in irp_remotedb_tools.php)
 
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
// library
 require_once("$d/irp_commonSQL.php");
// here read/write functions:
 require_once("$d/do_keyfromfile.php");
// for test
/*
echo '<pre>';  print_r($_GET); echo '</pre>'; 
*/ 
echo '<html><head>'; 
echo StyleSheet(); 
$message =''; 
$page='-1'; 
$myfile = '';
if (isset($_GET['read'])){ 
    $myfile = $_GET['keyfile']; 
    if (!file_exists( $myfile )){
        $myfile =dirname(__FILE__)."\\sheet\\".$_GET['keyfile']; 
        if (!file_exists( $myfile ) || $_GET['keyfile'] == ''){ 
            echo " <div class=error> ERROR: file [".$_GET['keyfile']."] not found. </div>";
            exit; 
            } 
        } 
    readKeyFile($myfile); 
    $message=' <hr> <h3><i>Database updated.</i></h3>'; 
    $page='-2'; 
    } 
if (isset($_GET['save'])){
    $myfile = $_GET['keyfile']; 
    if (!is_writable($myfile)){ 
         $myfile =dirname(__FILE__)."\\sheet\\".$_GET['keyfile']; 
         if (!is_writable($myfile) ||$_GET['keyfile'] == ''){
             echo "<div class=error> ERROR: file [".$_GET['keyfile']."] is not writable. </div>";
             exit; 
             } 
         } 
     saveKeyFile($myfile); 
     $message='<hr><h3><i>File updated.</i></h3>';
     $page='-2'; 
     } 
?> 
</head>
<body>
    <h1>Import/Export standard KEY list files</h1>
    <?php echo $message; ?>
    <div class='note'> Here you can found the complete list of <a href='http://madaboutbrighton.net/articles/2015/remote-control-media-player-without-lirc-using-ir-keymap'>standard keys </a>(at end). For standard remote keys semantics <a href='https://linuxtv.org/downloads/v4l-dvb-apis/uapi/rc/rc-tables.html'>see also linuxtv.org</a>. <i>In this project, the </i>modal key<i> concept make obsolete the final 'note' in that page.</i>
        <br> To have fast downloads the demo is with a limited set of keys.
        <ul type="disc">
            <li> Choose a key list file (<i> in /sheet/</i>) to update table <b>irp_actions</b> (all KEY will be updates, new keys and dummy icon files added).
                <br> </li>
            <li> Full set file: see <code><?php echo $d; ?>/sheet/key_full.txt</code>
                <br> </li>
            <li> File format: one KEY NAME for line, optionally followed by screen name and definition. No separators. Comments starting with '#'
                <br> </li>
            <li> Export: really a rewrite, the file must exist (<i> in /sheet/</i>).
                <br> </li>
        </ul> note: the KEY_NAME is used as PK in remoteDB, so don't change it. Instead you are free to change the 'screen name', used in UI. </div>
    <hr>
    <form name="key" keyname="test_keyfromfile.php" method="get"> select :
        <input type="file" size=60 name="keyfile" value=".\sheet\key_full.txt">
        <br><br> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        <input type="submit" name='read' value="Import"  title='choose here to import file'> &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" name='save' value="Export"  title='choose here to export file'> </form>
    <hr>
    <center>
        <<< <a href="index.html">Back</a>
    </center>
</body>
</html>