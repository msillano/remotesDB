<?php
/*
* This is an example of custom UI, using 3 extra structures:
*   1)the HTML for GUI (this file), one for remote control, defined in irp_remotes.phpgui;
*   2)the javascript code to get/set the UI, one for protocol, defined in irp_protocols.phpadapter (file remoteDB/extra/Fujitsu_Aircon_adapter.php);
*   3) javascript fragment, for the 'onclick' event, for single keys. They are defined directly in irp_remkeys.clickaction.
* This change the usual behaviour 'key pressed => send code', in  'key pressed => change GUI and/or send code'.
* This exra file returns an include php that build the HTML code required for a custom UI on the simulated remote
* control page, build by usr_simremote.php.
* This UI shows the dataDevice,  a data set required to control many air conditioners.
* The HTML must be a <TR> TAG placed on top of the table that simulate remote control.
* In 'Fujitsu_Aicon_adapter.php' is the code Javascript to modify this UI at runtime and the code 
* to get dataDevice from the UI in correct format: {A=5,wOn=1,B=0,C=0,D=0,E=0,tOff=30,tOn=30,fOn=0,fOff=0}.
* Some KEY can modify the UI: the code is on 'onclick' event. You put this jscript fragments in
* irp_remkey.clickAction field.
* This example simulate the remote control 'chunghop AC-188S' and is for Fujitsu_Aircon protocol.
* Mandatory: (fixed names):
*    In php:
*       getpad(ncol): php function, returns the full HTML tag <tr> for UI. 
*                ncol is used for colspan DT attribute
*/
function getpad($cols){
 $code ="<tr><td colspan=$cols > 
	  <table name='aircon' id='aircon' WIDTH=100% border=1 style='background-color:#EEEEEE' >
	  <tr><td colspan=2 WIDTH=380>
	     <b>Mode:</b>
		 <input type='radio' name='amode' id='amode0' value = '0' checked>auto</input>
	     <input type='radio' name='amode' id='amode1' value = '1'>cool</input>
     	 <input type='radio' name='amode' id='amode3' value = '2'>dry</input>
	     <input type='radio' name='amode' id='amode4' value = '3'>fan</input></td></tr>
	 <tr><td WIDTH=70%>
	 <b>Fan:</b>
	  <input type='radio' name='fan' id='fan0' value = '0' checked>auto</input> <br>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='fan' id='fan1' value = '1'>high</input>
	  <input type='radio' name='fan' id='fan2' value = '2'>med</input>
	  <input type='radio' name='fan' id='fan3' value = '3'>low</input>	
	  <input type='radio' name='fan' id='fan4' value = '4'>quiet</input></td>	
	 <td rowspan=2>
	 <table  WIDTH=100% border=0 class='noborder'><tr><td class='noborder'  VALIGN='middle' ALIGN='center'>
	 <SPAN name='temp' id='temp' style='font-size:44'>21</SPAN><SPAN style='font-size:44;'>°</SPAN>	 <br></td><td  VALIGN='top' ALIGN='right'  class='noborder'  >
	 <span id='F' style='color:#AAAAAA;'>F</span><input type='radio' id='degreF' name='degre' 
	 onclick=\"if(parseInt(document.getElementById('temp').innerHTML) < 50) {document.getElementById('temp').innerHTML = ''+Math.round(parseInt(document.getElementById('temp').innerHTML)*1.8 + 32); document.getElementById('C').style.color = '#AAAAAA';	
	 document.getElementById('F').style.color = '#000000';}\" 
	 value='F'></input><br>
	<span id='C'>C</span><input type='radio' id='degreC' name='degre' checked  onclick=\"if(parseInt(document.getElementById('temp').innerHTML) > 50) {document.getElementById('temp').innerHTML = ''+Math.round((parseInt(document.getElementById('temp').innerHTML)-32)/1.8);     document.getElementById('C').style.color='#000000';
	 document.getElementById('F').style.color='#AAAAAA';}\"
	 value='C'></input>	
	 </td>
	 
	 </tr><tr><td class='noborder' ALIGN='center' colspan=2 >
     <input type='button' id='tempplus'  name='tempplus' onclick=\"document.getElementById('temp').innerHTML = ''+(parseInt(document.getElementById('temp').innerHTML) +1);
	 if (parseInt(document.getElementById('temp').innerHTML) > 89)
         document.getElementById('temp').innerHTML = '89';	
	 if ((parseInt(document.getElementById('temp').innerHTML) < 50) &&
		 (parseInt(document.getElementById('temp').innerHTML) > 32))
	     document.getElementById('temp').innerHTML = '32';\"
	 value='+'></input>&nbsp;&nbsp;
	 <input type='button' id='tempminus'  name='tempminus' onclick=\"document.getElementById('temp').innerHTML = ''+(parseInt(document.getElementById('temp').innerHTML) -1);
	 if (parseInt(document.getElementById('temp').innerHTML) < 17)
         document.getElementById('temp').innerHTML = '17';
	 if ((parseInt(document.getElementById('temp').innerHTML) > 50) &&
	     (parseInt(document.getElementById('temp').innerHTML) < 63))
	       document.getElementById('temp').innerHTML = '63';\"
     value='-'></input>	</td></tr></table>
    </td></tr>
	<tr><td>  <b>Swing:</b>
	  <input type='radio' name='swing' id='swing0' value = '0' checked>off</input ><br>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='swing' id='swing1' value = '1'>vert</input>
	  <input type='radio' name='swing' id='swing2' value = '2'>hor</input>
	  <input type='radio' name='swing' id='swing3' value = '3'>v+h</input>
	  </td></tr><tr><td colspan=2 style='color:blue;'>Timer min.:
	    
  
	  <input type='button' id='minminus'  name='minminus' onclick=\"document.getElementById('min').innerHTML = ''+(parseInt(document.getElementById('min').innerHTML) -1);
	 if (parseInt(document.getElementById('min').innerHTML) < 0)
         document.getElementById('min').innerHTML = '0';
	 if (parseInt(document.getElementById('min').innerHTML) > 595) 
	       document.getElementById('min').innerHTML = '595';\"
     value='-'></input>	
	 &nbsp;<SPAN name='temp' width=200 id='min' style='font-size:20;color:blue;'>30</SPAN>&nbsp;

		  <input type='button' id='minplus'  name='minplus' onclick=\"document.getElementById('min').innerHTML = ''+(parseInt(document.getElementById('min').innerHTML) +1);
	 if (parseInt(document.getElementById('min').innerHTML) > 595) 
	       document.getElementById('min').innerHTML = '595';\"
     value='+'></input>	
	  <input type='radio' name='time' id='time0' value = '0' checked>none</input><br>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='time' id='time1' value = '1'>sleep</input>
	  <input type='radio' name='time' id='time2' value = '2'>off</input>
	  <input type='radio' name='time' id='time3' value = '3'>on</input>
	  <input type='radio' name='time' id='time4' value = '4'>off=>on</input>
	  </td></tr></table></td></tr>";  
   return $code;
}
?>
	