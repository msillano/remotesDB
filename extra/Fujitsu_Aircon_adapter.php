<?php
/*
* Returns an include javascript for the simulated remote control page: see related ipr_remotes.phpgui.
* You can use same phpgui for different protocols, changing this file to build different dataDevice
* jscript code contains setter and getter functions for UI.
* This example is for the 'aircon_std.php' phpgui and for Fujitsu_Aircon protocol.
* Details about the code are here: remoteDB/documents/remotes/FujitsuIR.pdf
* Mandatory: (fixed names, used by usr_simremote.php): 
*    In php:
*       getjscript(): php function, returns the full tag <script>
*    In javascript (inside the tag <script>): 
*       getUrl(baseUrl): add to baseUrl '&dataDevice={<dataDevice>}' from UI, to send to Arduino
*       setData(dataDevice): restore stored status (dataDevice) at 
* Optional (names and functions can change, used in custom irp_remkeys.clickAction):
*     send(baseUrl): send dataDevice to Arduino
*     setValue(input, value) or  nextValue(input)...etc..
*        to be used on 'onClick' to allow remote control buttons interact with phpgui interface
*        the 'onClick' attribute is on remoteDB, in field irp_remkeys.clickAction
* NOTE on irp_remkeys.clickAction action attributes:
*     - you must set baseUlr => $url : this will be macro-replaced at runtime.
*     - use  (') for the value, (") internal (see examples) Do not forget the final (;).
* Optional
*      internal functions
*/
function getjscript() {
// {A=0,wOn=1,B=2, C=3,D=4,E=5,tOff=0x10,tOn=0x20,fOff=0,fOn=0}
//
$code =	"<script>
// ---  internal
function findValue(radio){
	 var selector = document.querySelector('input[name='+radio+']:checked'); 
	 if(selector) return selector.value;
//	 alert(' query selector null ');
	 return '';
	 }
//  get Status: here status = dataDevice, used by getUrl(baseUrl) 
function getDeviceData(){
// fields names must match with phpgui	
	 amode = findValue('amode');
	 afan  = findValue('fan');
	 adir  = findValue('dir');
	 aswin = findValue('swing');
	 tmode = findValue('time');
// set temperature for dataDevice		 
	 atemp = parseInt(document.getElementById('temp').innerHTML);
	 if (atemp < 40){   // C/F conversion
		ftemp =  1.8 * atemp + 32;
	 } else {
		ftemp = atemp;
	 }
	 ntemp = Math.round((ftemp - 60) /2);  // aircon param value
	 if (ntemp < 2 ) ntemp = 2;
	 if (ntemp >  14) ntemp = 14;
// set time for dataDevice		 
	 atime = parseInt(document.getElementById('min').innerHTML);
	 if (atime > 595) atime = 595; //?? 11 bit= 2048, some doc=1024, other doc=595 ! see aircon_std.php
// set tOff, tOn for dataDevice	 
	 foff = 0;
	 fon  = 0;
	 if ((tmode == 1) || (tmode == 2)) foff  = 1;
	 if (tmode == 3) fon  = 1;
// buids dataDevice
 	 data  = '{'+'A='+ntemp+',wOn='+(ison?'1':'0')+',B='+amode+',C='+tmode+',D='+afan+',E='+aswin;
	 data += ',tOff='+atime+',tOn='+atime+',fOff='+foff+',fOn='+fon+'}';
//	 alert(' get dataDevice ='+data);
	 return data;
	 }

   
//================= mandatory	 	 
 function  getUrl(baseUrl){
	  return baseUrl+'&dataDevice='+encodeURIComponent(getDeviceData());
      }
	  
//	set Status:  here status = dataDevice  
 function setData(dataDevice){
 // alert ('SET data = '+ dataDevice);
   var data = dataDevice.substr(1, dataDevice.length -2);
   var params = data.split(',');
   for(var i=0; i<params.length;i++){
        var parts = params[i].split('=');
		switch (parts[0]){
		case 'A':
		    tf = Math.round((2*parts[1] + 28)/ 1.8);
		    document.getElementById('temp').innerHTML = tf;
		    document.getElementById('degreC').click();
			break;
		case 'wOn':
	        if ((parts[1] == '0') && ison) toggleOnOff() ;
		      if ((parts[1] == '1') && !ison) toggleOnOff() ;
			    break;
		 case 'B':setValue('amode', parseInt(parts[1]));break;
		 case 'C':
              var timex = parseInt(parts[1]);
              if ((timex == 2) ||(timex == 3)) setValue('time', 0);
              else setValue('time', timex);
              break;
		 case 'D':setValue('fan', parseInt(parts[1]));break;
		 case 'E':setValue('swing', parseInt(parts[1]));break;
		 case 'tOn':
		 case 'tOff':
		    document.getElementById('min').innerHTML = parts[1];
		    }
       }
   }
//============ optional, to be used in clickAction field	 
// action: this will send all data in UI display 
//".' note: on irp_remkeys.clickAction you must write: send($url);'."
//".' $url will be replaced with the true value at runtime.'."
// standard key  (e.g. FASTHEAT_KEY) will send only the fixed DATA SET stored on irp_streams

 function send(baseUlr){
 	  fullurl = getUrl(baseUlr);
// alert('send to '+fullurl);
	  document.location.href= fullurl;
      }
	  
 // action: round robin all options	  
 function nextValue(radio){
	 var ele = document.getElementsByName(radio);
	 var k = 0;
	 for(var i=0; i<ele.length; i++){
	    if(ele[i].checked) 
		      ele[k=i].checked = false;
		}
	 k = (k+1)%ele.length;
	 ele[k].checked = true;
	 }

// action: like the user click on option
function setValue(radio, avalue){
	 var ele = document.getElementsByName(radio);
	 for(var i=0; i<ele.length;i++){
	      ele[i].checked = false;
	      if(ele[i].value == avalue) 
		       ele[i].checked = true;
	 }
 }
 
 ison = true; 
 
 // action: on/off button effect
 function toggleOnOff()
 {
  ison = !ison;
  document.getElementById('aircon').style.visibility= (ison?'visible':'hidden');
 }
 
// action: toggleOnOff + send
 function sendOnOff(baseUrl){
  toggleOnOff();
  send(baseUrl);
 }
</script>";
 // {A=0,wOn=1,B=2, C=3,D=4,E=5,tOff=0x10,tOn=0x20,fOff=0,fOn=0}
  return $code;
}
?>
	