<?
include_once('constants.php');
include_once(DOCUMENT_ROOT."includes/checklogin.php");
include_once(DOCUMENT_ROOT."includes/checkadmin.php");

include (DOCUMENT_ROOT.'tpl/header.php');

include_once("includes/instrument_action.php");

?>
 
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td class="body" valign="top" align="center">
    <? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?>
    <table border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td class="body_resize"><table border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td>
                <table width="100%" border="0" cellpadding="5" cellspacing="0">
                    <tr>
                      <td class="t-top"><div class="title2">View Manual</div></td>
                    </tr>
                    <tr>
                      <td class="t-mid"><br />
                        <br />
 
                           <table class="content" align="center" width="650" border = "0">
                          <tr class="Trow">
          <td ><center><select id="instrument_name" name="instrument_name" style="font-weight:normal" ></select></center></td>
                          </tr>
                             	<tr class="Trow">
                               <td>   
  									 <input type="submit" value="View Manual" onClick="showManuals()"  >
  								</td>
                
                            </tr>
                           </table>
                             
                        </td>
                    </tr>
                    <tr>
                      <td class="t-bot2"></td>
                    </tr>
                 </table>
               </td>
             </tr>
           </table>
         </td>
       </tr>
    </table>
<script type="text/javascript">

 <? 
    $dbhost="db1661.perfora.net";
	$dbname="db260244667";
	$dbusername="dbo260244667";
	$dbpass="curu11i";

	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
	
	// FOR INSTRUMENTS
	$sql2 = "select a.InstrumentNo, a.InstrumentName from instrument a where a.InstrumentNo in ( select distinct instrument_num from MANUAL, instr_group, user where instrument_num=instr_group.InstrNo AND user.email = instr_group.email AND user.UserName='".$_SESSION['login']."' ) order by a.InstrumentNo";
	$result2 = mysql_query($sql2);
	//$value = mysql_num_rows($result);
	$j=1;
 	?>
document.getElementById("instrument_name").options[0]=new Option("<? echo "-- Select Instrument to view Manual --" ?>");
document.getElementById("instrument_name").options[0].value=0;

	<?
	while($row2=mysql_fetch_array($result2)){?>
	//bug here .. because if a policy is deleted completely .. then a blank row in drop down will be created
 document.getElementById("instrument_name").options[<? echo $j?>] = new Option("<? echo $row2['InstrumentName']?>");
 document.getElementById("instrument_name").options[<? echo $j?>].value = "<? echo $row2['InstrumentNo']?>";
 	<?	
		$j+=1;
	}
 	
	mysql_close();
?>
</script> 


<script type="text/javascript">

function showManuals(){
 		
 	   var e = document.getElementById("instrument_name");
 	     instrumentNo = e.options[e.selectedIndex].value;
      instrumentName = e.options[e.selectedIndex].text;
			if (window.XMLHttpRequest) {
						try {
							req = new XMLHttpRequest();
						} catch (e) {
							req = false;
						}
					} else if (window.ActiveXObject) {
						try {
							req = new ActiveXObject("Msxml2.XMLHTTP");
						} catch (e) {
							try {
								req = new ActiveXObject("Microsoft.XMLHTTP");
							} catch (e) {
								req = false;
							}
						}
					}
					if (req) {
   						req.onreadystatechange = showManualData;
						req.open("GET", "loadManualData.php?instrumentNo="+instrumentNo, true);
						req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
						req.send("");
 					} else {
						alert("Please enable Javascript");
					}
		}
	function showManualData(){
			if (req.readyState == 4 && req.status == 200) {         																              
				 var doc = eval("(" + req.responseText + ")");
 				 var writeToMyWindow = "<center><b>Select one of the below manuals...</b><br/><br/></center>";
				for ( i=0; i<doc.length ; i++){
				writeToMyWindow = writeToMyWindow + 
				" <center><input type='button' onclick=\"window.open('./manuals/"+doc[i].manual_filename+"', '_blank', 'fullscreen=no,location=no'); return false;\" value='"+doc[i].manual_name+"'/></center><br/>";
		 		} 	
				
			var myWindow=window.open('',instrumentName ,'menubar=yes,scrollbars=yes,width=700,height=200;');
			myWindow.document.write(writeToMyWindow);			  				
			}
	}
	 
function showManual(){
		
		var e = document.getElementById('instrument_name');
		var instrumentNo = e.options[e.selectedIndex].value;
 		if(instrumentNo==0){
			alert('Please select an Instrument to view Manaul');
			return false;
		}
 		if(instrumentNo==36){
			window.open('../../schedule/docs/JSM_6610_V2.1.pdf', '_blank', 'fullscreen=no,location=no');
		} else if(instrumentNo==45){
			var writeToMyWindow = "<center><b>Select one of the below manuals...</b><br/><br/><input type='button' onclick=\"window.open('../../schedule/docs/FIB_JIB_4500_V_2.4.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='FIB JIB 4500'/></center><br/>";
			writeToMyWindow += "<center><input type='button' onclick=\"window.open('../../schedule/docs/OmniProbe_lift_out_V_2.1.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='OmniProbe lift out'/></center><br/>";
			writeToMyWindow += "<center><input type='button' onclick=\"window.open('../../schedule/docs/Omniprobe_tip_exchange.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='OmniProbe tip exchange'/></center><br/>";
			var myWindow=window.open('','FIB JIB-4500','menubar=yes,scrollbars=yes,width=700,height=200;');
			myWindow.document.write(writeToMyWindow);
		} else if(instrumentNo==51){
			var writeToMyWindow = "<center><b>Select one of the below manuals...</b><br/><br/><input type='button' onclick=\"window.open('../../schedule/docs/SEM_Dehydrate.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='SEM Dehydrate'/></center><br/>";
			writeToMyWindow += "<center><input type='button' onclick=\"window.open('../../schedule/docs/Tousimis_815_Critical_Point_Dryer.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='Tousimis 815 Critical Point Dryer'/></center><br/>";
			var myWindow=window.open('','Tousimis 815','menubar=yes,scrollbars=yes,width=700,height=200;');
			myWindow.document.write(writeToMyWindow);
		}
		else if(instrumentNo==37){
			var writeToMyWindow = "<center><b>Select one of the below manuals...</b><br/><br/><input type='button' onclick=\"window.open('../../schedule/docs/JSM_7001.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='JSM 7001 SEM'/></center><br/>";
			writeToMyWindow += "<center><input type='button' onclick=\"window.open('../../schedule/docs/JEOL_7001_Backscatter_and_Low_Vacuum_V2.6.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='Backscatter and Low Vacuum'/></center><br/>";
			writeToMyWindow += "<center><input type='button' onclick=\"window.open('../../schedule/docs/JEOL_7001_EDS_V2.6.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='JEOL EDS'/></center><br/>";
			writeToMyWindow += "<center><input type='button' onclick=\"window.open('../../schedule/docs/JEOL_SEM_Consumables.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='JEOL SEM Consumables'/></center><br/>";
			writeToMyWindow += "<center><input type='button' onclick=\"window.open('../../schedule/docs/EBSD_V_2.1.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='JEOL EBSD'/></center><br/>";
			var myWindow=window.open('','JEOL 7001 SEM','menubar=yes,scrollbars=yes,width=700,height=250;');
			myWindow.document.write(writeToMyWindow);
		} else if(instrumentNo==47){
		//alert(manualNum);
			var writeToMyWindow = "<center><b>Select one of the below manuals...</b><br/><br/><input type='button' onclick=\"window.open('../../schedule/docs/JEOL_2100_TEM_Start_up_and_alignment.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='JEOL 2100 TEM Start up and alignment'/></center><br/>";
			writeToMyWindow += "<center><input type='button' onclick=\"window.open('../../schedule/docs/Single_tilt_Holder.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='Single-tilt Holder'/></center><br/>";
			writeToMyWindow += "<center><input type='button' onclick=\"window.open('../../schedule/docs/JEOL_2100F_STEM.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='JEOL 2100F - STEM'/></center><br/>";
			writeToMyWindow += "<center><input type='button' onclick=\"window.open('../../schedule/docs/JEOL_2100F_Diffraction.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='JEOL 2100F - Diffraction'/></center><br/>";
			var myWindow=window.open('','JEOL JSM-7001F','menubar=yes,scrollbars=yes,width=700,height=230;');
			myWindow.document.write(writeToMyWindow);
		}
	}

</script>