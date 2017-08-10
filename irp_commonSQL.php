<?php	  
/*
irp_commonSQL - 
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
	
// ====================  GENERAL DB access for odtphp
// here all SQL functions.
// Implementation using mysql_xxxx 
// License LGPL 

function sql($statment){
// print($statment.'<BR>');
//====================================================    
   static $connected=false;
    // connection data
   include(dirname(__FILE__)."/irp_config.php");	

   if(!$connected){
		/****** Connect to MySQL ******/
		if(!extension_loaded('mysql')){
			echo "<div class=error>ERROR: PHP is not configured to connect to MySQL on this machine.
             Please see <a href=http://www.php.net/manual/en/ref.mysql.php>this page</a> for help 
             on how to configure MySQL.</div>";
		    exit;
		}

		if(!mysql_connect($dbServer, $dbUsername, $dbPassword)){
		    echo "<div class=error>";
			echo  'ERROR: Connection error: see $dbServer, $dbUsername, $dbPassword on irp_config.php <br />'.mysql_error();;
			echo "</div>";
	        exit;
			}

		/****** Connection Charset ********/
		@mysql_query("SET NAMES 'utf8'");

		/****** Select DB ********/
		if(!mysql_select_db($dbDatabase)){
		    echo "<div class=error>";
			echo  'ERROR: Errore in select DB: see $dbDatabase on irp_config.php <br />'.mysql_error();
			echo "</div>";
			exit;
		}
		$connected=true;
	 } // ends if not connected

	if(!$result = @mysql_query($statment)){
	        echo "<div class=error>";
			echo  "ERROR: Query error in  ['$statment'] <br />".mysql_error();
			echo "</div>";
			exit;
		}
	return $result;
}

// ================================== sql to arrays	 
 
// low-level DB read using SQL.
// return only a  value
function sqlValue($query) {
  $result =  sql($query);
  $row = mysql_fetch_row($result);	   
  mysql_free_result ($result );
  if (isset($row[0]))
      return $row[0];
  return NULL;
}

// low-level DB read using SQL.
// return an array of values: array =row[][0]
function sqlArray($query) {
  $result =  sql($query);
  $dats = array();
  while( $row = mysql_fetch_row($result)){
      $dats[] = $row[0];
  }
  mysql_free_result ($result );
  return $dats;
}
			
/*
 *	low-level DB read using SQL.
 *  return a rows array: array[] = (row(0), row(1), row(2)...)
 */	 
 
function sqlArrayTot($query){	   
	   $r=sql($query );			        
	   $arrayData= array();
       while ( $sub = mysql_fetch_array($r)) {	  
					array_push($arrayData, $sub);  
 					}			
       mysql_free_result ($r);          
	 return $arrayData ;	   
 }

// low-level DB read using SQL.
// return an array of values: array[] = row[0]
function sqlRecord($query) {
  $result =  sql($query);
  $dats =  mysql_fetch_array($result);
  mysql_free_result ($result );
  return $dats;
}

// low-level DB read using SQL.
// return an associative lookup: array[row[0]] = row[1]]
function sqlLookup($query) {
  $result =  sql($query);
  $dats = array();
  while( $row = mysql_fetch_row($result)){
      $dats[$row[0]] = $row[1];
  }
  mysql_free_result ($result );
  return $dats;
}    
 
// HTML from DB read using SQL.
// for combo input, options from a query (id, value), optional select key
//  return HTML option list
function optionsList($query, $selected = -1){     		
     $options = '';
     $ops = sqlLookup($query);    
     while (list($chiave, $valore) = each($ops)) {   
        $options .= "<option value='$chiave' ".($chiave == $selected ? ' selected = "selected"':'')." >$valore</option>\n";
     }
     return $options;
}               
                
// HTML from DB read using SQL.
// for checklist, return complete HTML
// from a query (key, value), checkbox_name, list_of_keys|true|false*)                      
function checkList($query,$name,$checked = false){     
     $check = '';
     $ops = sqlLookup($query);   
     $i = 1; 
     while (list($chiave, $valore) = each($ops)) {
        if ( is_array($checked )){
        $check .= "<input type='checkbox' name='$name".$i++."' value='$chiave' ".(
        array_search($chiave,$checked)!== false ?"checked='checked'":'')." />$valore<br />"; 
         } else {
        $check .= "<input type='checkbox' name='$name".$i++."' value='$chiave' ".($checked?"checked='checked'":'')." />$valore<br />"; 
         } 
     }
     return $check;
}     
//===================================== more functions 

// HTML numerical combo.
// for combo input, numerical, return HTML option list
function optionsNList($from, $to, $selected){     
     $options = '';
     for($i = $from; $i < $to; $i++) {        
        $options .= "<option value='$i'".($i == $selected ? ' selected = "selected"':'')." >$i</option>\n" ;
        }
     return $options;
}        
 
 function StyleSheet(){
	return '<link rel="stylesheet" type="text/css" href="./css/style.css">';
}

// redirect to a different  page
function movePage($num,$url){
   static $http = array (
       100 => "HTTP/1.1 100 Continue",
       101 => "HTTP/1.1 101 Switching Protocols",
       200 => "HTTP/1.1 200 OK",
       201 => "HTTP/1.1 201 Created",
       202 => "HTTP/1.1 202 Accepted",
       203 => "HTTP/1.1 203 Non-Authoritative Information",
       204 => "HTTP/1.1 204 No Content",
       205 => "HTTP/1.1 205 Reset Content",
       206 => "HTTP/1.1 206 Partial Content",
       300 => "HTTP/1.1 300 Multiple Choices",
       301 => "HTTP/1.1 301 Moved Permanently",
       302 => "HTTP/1.1 302 Found",
       303 => "HTTP/1.1 303 See Other",
       304 => "HTTP/1.1 304 Not Modified",
       305 => "HTTP/1.1 305 Use Proxy",
       307 => "HTTP/1.1 307 Temporary Redirect",
       400 => "HTTP/1.1 400 Bad Request",
       401 => "HTTP/1.1 401 Unauthorized",
       402 => "HTTP/1.1 402 Payment Required",
       403 => "HTTP/1.1 403 Forbidden",
       404 => "HTTP/1.1 404 Not Found",
       405 => "HTTP/1.1 405 Method Not Allowed",
       406 => "HTTP/1.1 406 Not Acceptable",
       407 => "HTTP/1.1 407 Proxy Authentication Required",
       408 => "HTTP/1.1 408 Request Time-out",
       409 => "HTTP/1.1 409 Conflict",
       410 => "HTTP/1.1 410 Gone",
       411 => "HTTP/1.1 411 Length Required",
       412 => "HTTP/1.1 412 Precondition Failed",
       413 => "HTTP/1.1 413 Request Entity Too Large",
       414 => "HTTP/1.1 414 Request-URI Too Large",
       415 => "HTTP/1.1 415 Unsupported Media Type",
       416 => "HTTP/1.1 416 Requested range not satisfiable",
       417 => "HTTP/1.1 417 Expectation Failed",
       500 => "HTTP/1.1 500 Internal Server Error",
       501 => "HTTP/1.1 501 Not Implemented",
       502 => "HTTP/1.1 502 Bad Gateway",
       503 => "HTTP/1.1 503 Service Unavailable",
       504 => "HTTP/1.1 504 Gateway Time-out"
   );
   header($http[$num]);
   header ("Location: $url");		
   exit;
}                            

?>