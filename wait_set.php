<?php
$d = dirname(__FILE__);
require_once("$d/../upt_fifo/upt_fifo.php");

$idprotocol = $_GET['protocol'] ;
$idremote = $_GET['remote'] ;
$code = $_GET['code'] ;
$mode = $_GET['mode'] ;

if (!isset($_GET['id'])) {
    $id =  pushSETrequest($_GET['value'], $_GET['data']);
    movePage(100,"./wait_set.php?id=$id&remote=$idremote&code=$code&protocol=$idprotocol&mode=$mode");
	} else {
    $id = $_GET['id'];
}

$status = sqlValue ("SELECT status FROM fifo WHERE id = $id ");
if ($status == 'DONE'){
    movePage(100,"./usr_rawremote.php?remote=$idremote&code=$code&protocol=$idprotocol&mode=$mode");    
  }
  
echo '<HTML><HEAD><meta http-equiv="refresh" content="3"></HEAD><BODY>';
echo " <h2> STATUS $status <h2>";
echo "<form action= 'usr_rawremote.php?remote=$idremote&code=$code&protocol=$idprotocol&mode=$mode'> <input type = 'submit' value='ABORT'></form>";
echo '</BODY></HTML>';

?>