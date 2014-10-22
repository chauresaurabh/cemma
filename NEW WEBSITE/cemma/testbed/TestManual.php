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
    <td class="body" valign="top" align="center"><table border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td class="body_resize"><table border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td class="left" valign="top"><?	include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?>
                </td>
                <td>
                <table width="100%" border="0" cellpadding="5" cellspacing="0">
                    <tr>
                      <td class="t-top"><div class="title2">Manage Manuals.. Page Under Construction</div></td>
                    </tr>
                    <tr>
                      <td class="t-mid"><br />
                        <br />
 
                           <table class="content" align="center" width="650" border = "0">
                          <tr class="Trow">
          <td ><center><select id="instrument_name" name="instrument_name" style="font-weight:normal" ></select></center></td>
                          </tr>
                          	<tr>
                             <td>
                             	<div id="manualsDisplayArea"></div>

                            	</td>
                            </tr>
                            
                             	<tr class="Trow">
                               <td>   
  									 <input type="submit" value="View Manuals" onClick="showManuals()"  >

  									 <input type="button" value="Add Manual" onClick="addNewManual()"  >
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
	$sql2 = "select InstrumentNo, InstrumentName from instrument order by InstrumentNo";
	$result2 = mysql_query($sql2);
	//$value = mysql_num_rows($result);
	$j=1;
 	?>
document.getElementById("instrument_name").options[0]=new Option("<? echo "-- Select Instrument to View Manual --" ?>");
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
 
 
 function addNewManual(){
	 
	   var e = document.getElementById("instrument_name");
 	   var instrumentNo = e.options[e.selectedIndex].value;
	   
	 	 var foo = document.getElementById("manualsDisplayArea");
		 foo.innerHTML = "<form action='ManualUploader.php' method='post'  enctype='multipart/form-data'> " 
 			 			  + "    Manual Name :  " 
						   + "    <input type='text'  name='manualName' />  " 
						 + "    <input type='hidden' id='hiddenInstrumentNo' name='hiddenInstrumentNo' value='"+instrumentNo+"' />  " 
	  + " <input type='hidden' id='updateValue' name='updateValue' value='false' />  " 

						 + "    <input type='file' name='file' id='file'>  " 
 					     +"    <input type='submit' value='Upload New Manual' />  " 
 						 +"    </form>";
 

	 
	 }
    var req;
	var username;
	var advisor;
	instrumentName=""
	 
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
			if (req.readyState == 4 && req.status == 200) {         																              //alert('chaure got repsosne' + req.responseText);
				 var doc = eval("(" + req.responseText + ")");
				 if(doc.notfound){
					 document.getElementById("manualsDisplayArea").innerHTML= ' Manuals have not been uploaded for the Selected instrument : '+ instrumentName;
				 }else{
 
 					var str = "<table>";
 					for ( i=0; i<doc.length ; i++){
						str = str +"  <tr> " 
						  +"  <td>  <form action='ManualUploader.php' method='post' enctype='multipart/form-data'> " 
						  + "  "
			 			  + " <a style='display:block;width:200px' href='./manuals/"+ doc[i].manual_filename +"' download>"+doc[i].manual_filename+"</a> " 
						   + " Manual Name : <input type='text'  name='manualName' value='"+doc[i].manual_name+"' />  " 
						    + "    <input type='hidden' id='hiddenInstrumentNo' name='hiddenInstrumentNo' value='"+instrumentNo+"' />  " 
 			+ "    <input type='hidden'  name='manualNumber' value='"+doc[i].manual_num+"' />  " 

			  + " <input type='hidden' id='updateValue' name='updateValue' value='true' />  " 

						 + "    <input type='file' name='file' id='file'>  " 
 					     +"    <input type='submit' value='Update Manual' />  " 
 						 +"    </form> <br>    </td> </tr> ";
 
 					} 
 						 
					str = str + "</table>";
 	
 				  document.getElementById("manualsDisplayArea").innerHTML=str;

				}
  	 	
		}
	}
		 
</script>
 