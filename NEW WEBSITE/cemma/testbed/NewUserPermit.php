<?
include_once('constants.php');
include_once(DOCUMENT_ROOT."includes/checklogin.php");
include_once(DOCUMENT_ROOT."includes/checkadmin.php");
if($class != 1 || $ClassLevel==3 || $ClassLevel==4){
	//header('Location: login.php');
}
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
                      <td class="t-top"><div class="title2">View Permit</div></td>
                    </tr>
                    <tr>
                      <td class="t-mid"><br />
                        <br />
 
                           <table class="content" align="center" width="650" border = "0">
                          <tr class="Trow">
           <td  ><center><select id="user_name" name="user_name" style="font-weight:normal" ></select></center></td>
         <td ><center><select id="instrument_name" name="instrument_name" style="font-weight:normal" ></select></center></td>
                          </tr>
                             	<tr class="Trow">
                               <td>   
  									 <input type="submit" value="View Permit" onClick="showPermit()"  >
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
 
	 	 include_once('constants.php');
		include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
		
		$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
		$SelectedDB = mysql_select_db($dbname) or die ("Error in Old DB");
	 
	$sql = "SELECT UserName, Advisor FROM user where ActiveUser in ('', 'active') order by UserName";
	$result = mysql_query($sql);
	 
	$i=1;
 	?>
document.getElementById("user_name").options[0]=new Option("<? echo "-- Select User to View Permit --" ?>");
document.getElementById("user_name").options[0].value=0;

	<?
	while($row=mysql_fetch_array($result)){?>
	//bug here .. because if a policy is deleted completely .. then a blank row in drop down will be created
		document.getElementById("user_name").options[<? echo $i?>] = new Option("<? echo $row['UserName']?>");
		document.getElementById("user_name").options[<? echo $i?>].value = "<? echo $row['Advisor']?>";
 	<?	
	$i+=1;
	}
	

	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
	
	// FOR INSTRUMENTS
	$sql2 = "select InstrumentNo, InstrumentName from instrument where InstrumentNo in(11,12,13,14,15,17) order by InstrumentNo";
	$result2 = mysql_query($sql2);
	//$value = mysql_num_rows($result);
	$j=1;
 	?>
document.getElementById("instrument_name").options[0]=new Option("<? echo "-- Select Instrument --" ?>");
document.getElementById("instrument_name").options[0].value=0;

	<?
	while($row2=mysql_fetch_array($result2)){?>
	//bug here .. because if a policy is deleted completely .. then a blank row in drop down will be created
 document.getElementById("instrument_name").options[<? echo $j?>] = new Option("<? echo $row2['InstrumentName']?>");
 document.getElementById("instrument_name").options[<? echo $j?>].value = "<? echo $row2['InstrumentName']?>";
 	<?	
		$j+=1;
	}
 	
	mysql_close();
?>
</script>
  

<script type="text/javascript">
 
    var req;
	var username;
	var advisor;
	 function showPermit(){
 
      var e = document.getElementById("user_name");
	   
	  if(e.selectedIndex == 0){
		alert('Please select a User to View Permit');
		return false;
	  }

 	  username = e.options[e.selectedIndex].text;
   	  advisor = e.options[e.selectedIndex].value;

		var e2 = document.getElementById("instrument_name");
 	   var instrument_name = e2.options[e2.selectedIndex].value;
      if(e2.selectedIndex == 0){
		alert('Please select an Instrument to View Permit');
		return false;
	  }

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
   						req.onreadystatechange = showPermitData;
						req.open("GET", "showPermit.php?instrNum="+instrument_name, true);
						req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
						req.send("");
 					} else {
						alert("Please enable Javascript");
					}
		}
	function showPermitData(){
			if (req.readyState == 4 && req.status == 200) {         																             var month=new Array();month[0]="Jan";month[1]="Feb";month[2]="Mar";month[3]="Apr";month[4]="May";            	month[5]="Jun"; month[6]="Jul";month[7]="Aug";month[8]="Sep";month[9]="Oct";month[10]="Nov"; month[11]="Dec";
			
  	 var doc = eval('(' + req.responseText + ')');
 
 	var writeToMyWindow = "<b><center><span style='text-align:center;font-weight:700;font-size:22px;'>";
	writeToMyWindow += doc.title+"<br/>User\'s Permit</span></center><br/><br/>";
	writeToMyWindow += "<b>"+doc.para1+"</b><br/><br/>";

	writeToMyWindow += "<b>"+doc.para2+"</b>";
	
	writeToMyWindow += "<br/><br/><div><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+username+"</span><span style='float:right'>"+advisor+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div><hr/>";
	
	writeToMyWindow += "<div><span style='float:left;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(User's name)</span><span style='float:right;'>(Advisor's name)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>";

	writeToMyWindow +="<br/><br/><table BORDER=1 RULES=NONE FRAME=BOX align='center'> ";
	writeToMyWindow +="<tr><td>Trainer Sign off:  <b><? echo $_SESSION['login'] ?></b></td><td style='width:400px'></td></tr> ";
	writeToMyWindow +="</table>";
	
	writeToMyWindow +="<br/>Has passed the initial training course and is allowed to use the SEM during peak hours only (9:00 am - 4:30 pm M-F). ";
	writeToMyWindow +="<br/><br/><table BORDER=1 RULES=NONE FRAME=BOX align='center'> ";
	writeToMyWindow +="<tr><td colspan='4' align='center'>Peak Time Approval</td></tr>";
	writeToMyWindow +="<tr><td>Session 1:</td><td>______________________</td><td>Trainer Sign-off:</td><td>______________________</td></tr> ";
	writeToMyWindow +="<tr><td></td><td align='center'>(Date)</td></tr> ";
	writeToMyWindow +="<tr><td>Session 2:</td><td>______________________</td><td>Trainer Sign-off:</td><td>______________________</td></tr> ";
	writeToMyWindow +="<tr><td></td><td align='center'>(Date)</td></tr> ";
	writeToMyWindow +="<tr><td>Session 3:</td><td>______________________</td><td>Trainer Sign-off:</td><td>______________________</td></tr> ";
	writeToMyWindow +="<tr><td></td><td align='center'>(Date)</td></tr> ";
	writeToMyWindow +="</table> ";

	writeToMyWindow +="<br/><table BORDER=1 FRAME=BOX align='center'> ";
	writeToMyWindow +="<tr><td colspan='3' align='center'>Off-Peak Time Approval (5:00 pm - 9:00 am M-F, 24 hours for Sat and Sun):<br/>Fifteen (15) peak hours logged within a six (6) month period.</td></tr>";
	writeToMyWindow +="<tr><th align='center'>Date</th><th align='center'>Time</th><th align='center'>Total Hours</td></tr> ";
	writeToMyWindow +="<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr> ";
	writeToMyWindow +="<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr> ";
	writeToMyWindow +="<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr> ";
	writeToMyWindow +="</table>";

	writeToMyWindow +="<br/><table BORDER=1 RULES=NONE FRAME=BOX align='center'> ";
	writeToMyWindow +="<tr><td>OFF-PEAK Sign off:</td><td style='width:450px'></td></tr> ";
	writeToMyWindow +="</table><br/>";
 	var d = new Date();
	var todayDate = month[d.getMonth()]+'-'+d.getUTCDate()+'-'+d.getFullYear();
	 writeToMyWindow += todayDate;
 
	writeToMyWindow +="<span style='float:right'>Log-on User's Name: "+username+"</span>";
 
	var myWindow=window.open('','JEOL JSM-7001F','menubar=yes,scrollbars=yes,width=700,height=900;');
	myWindow.document.write(writeToMyWindow);
		}
	}
		 
</script>
 