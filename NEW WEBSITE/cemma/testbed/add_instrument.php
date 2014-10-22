<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include (DOCUMENT_ROOT.'tpl/header.php'); 
	
	include_once("includes/action.php");
	
	
	if(isset($_POST['machine_name'])){

		$machine =  $_POST['machine_name'];
		$usc_with_cemma = $_POST['usc_with_cemma'];
		$cemma_unit = $_POST['cemma_unit'];
		$usc_without_cemma = $_POST['usc_without_cemma'];
		$off_with_cemma = $_POST['off_with_cemma'];
		$off_without_cemma = $_POST['off_without_cemma'];
		$commerical = $_POST['commerical'];
		$commerical_without_operator = $_POST['commerical_without_operator'];
		
		$comments = $_POST['comments'];
		$availibility = $_POST['availibility'];
		$DisplayOnStatusPage = $_POST['DisplayOnStatusPage'];
		$DisplayOnPricingPage = $_POST['DisplayOnPricingPage'];
 		
		$trainingRate = $_POST['trainingRate'];
		
		if($DisplayOnPricingPage=='Yes'){
			$DisplayOnPricingPage = 1;
		}else{
			$DisplayOnPricingPage = 0;
		}
		
 		$InstrumentType = $_POST['InstrumentType'];
		$OtherType = $_POST['OtherType'];
		//echo "OtherType-".$OtherType;
		

if($availibility=='yes')
	$availibilityvalue=1;
else
	$availibilityvalue=0;

		
		
		$flag = 0;
		
		$sql = "SELECT machine_name FROM rates";
		$result = mysql_query($sql) or die("Error in Select");
		
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			if($machine == $row['machine_name']){
				$flag = 1;
				break;
			}
						
		}
		if($flag == 1)
			echo 'Instrument already exists. Please select another Instrument';
		else{
			$sql = "INSERT INTO rates VALUES ('', '', '$machine', '$usc_with_cemma', '$cemma_unit', '$usc_without_cemma', '$off_with_cemma', '$off_without_cemma', '$commerical', '$commerical_without_operator','', $trainingRate )";
			mysql_query($sql) or die("Error in Adding Instrument");
			$last_rate = mysql_insert_id();
			
			$sql = "INSERT INTO instrument VALUES ('', '$machine', '$comments', '$availibilityvalue','$DisplayOnStatusPage','$DisplayOnPricingPage','$InstrumentType')";
			mysql_query($sql) or die("Error in Adding comments");
			$last_instr = mysql_insert_id();

			if($OtherType !="")
			{
				$sql = "INSERT INTO Instrument_Types VALUES ('', '$OtherType')";
				mysql_query($sql) or die("Error in Adding Instrument");
			}
			
			mysql_query('UPDATE rates SET InstrumentNo = '.$last_instr.' WHERE ID = '.$last_rate) or die("Error in Adding comments2");
			echo "Instrument Added Successfully";
		}
	}
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td class="body" valign="top" align="center">
        <?	include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?>
        <table border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td class="body_resize"><table border="0" cellpadding="0" cellspacing="0" align="left">
                            <tr>
                                <td><table width="100%" border="0" cellpadding="5" cellspacing="0">
                                        <tr valign="top">
                                            <td width="100%"><div align="center" class="err" id="error" style="display:none"></div>
                                                <div align="center" class="alert" style="font-size:13;display:none" id="alert"></div></td>
                                        </tr>
                                    </table>
                                    <table width="100%" border="0" cellpadding="5" cellspacing="0">
                                        <tr>
                                            <td class="t-top"><h2 class="Our">Add Instrument</h2></td>
                                        </tr>
                                        <tr>
                                            <td class="t-mid"><br />
                                                <br />
                                                <form id="myform" name="myform" method="post" action="add_instrument.php">
                                                    <table width="450" class="content" align="center" style="border: thin, #993300">
                                                        <tr class= "Trow">
                                                            <td width="250">Name of the Instrument :</td>
                                                            <td width="200"><input type="text" size="20" class="text" name="machine_name"></td>
                                                        </tr>
                                                        <tr class= "Trow">
                                                            <td>Availibility:</td>
                                                            <td><input type="radio" name="availibility" id="availibility" value="yes" checked="checked">
                                                                Available&nbsp;&nbsp;&nbsp;
                                                                <input type="radio" name="availibility" id="availibility" value="no">
                                                                Unavailable</td>
                                                        </tr>
														 <tr class= "Trow">
                                                            <td>Dispay on Status Page:</td>
                                                            <td><input type="radio" name="DisplayOnStatusPage" id="DisplayOnStatusPage" value="Yes" checked="checked">
                                                                Yes&nbsp;&nbsp;&nbsp;
                                                                <input type="radio" name="DisplayOnStatusPage" id="DisplayOnStatusPage" value="No">
                                                                No</td>
                                                         </tr>
                                                          <tr class= "Trow">
                                                            <td>Dispay on Pricing Page:</td>
                                                            <td><input type="radio" name="DisplayOnPricingPage" id="DisplayOnStatusPage" value="Yes" checked="checked">
                                                                Yes&nbsp;&nbsp;&nbsp;
                                                                <input type="radio" name="DisplayOnPricingPage" id="DisplayOnStatusPage" value="No">
                                                                No</td>
                                                         </tr>
														<tr class= "Trow">
<?			
	//include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
	$sql13 = "SELECT TypeNumber,Type FROM Instrument_Types ORDER BY Type ";
	$values=mysql_query($sql13) or die("An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
?>			
                                                            <td>Type:</td>
                                                            <td>
																<select name="InstrumentType" id="InstrumentType">
																<option value="" onClick="ClearOtherType()"></option>
<?  while($row = mysql_fetch_array($values))
	{
	?>
		<option value="<?=$row['Type']?>" onClick="ClearOtherType()"><?=$row['Type']?></option>
<?		
	}
?>
<option value="" onClick="Othertype()">Other</option>
														<tr name="OtherTypeRow" id="OtherTypeRow" class= "Trow" style="display:none; visibility:hidden;">
                                                            <td>Enter New Type:</td>
                                                            <td><input type="text" class="text" size="4" name="OtherType" id="OtherType" value="">
															</td>
	                                                   </tr>

																<!--  <option value="TEM">TEM</option>
																  <option value="SEM">SEM</option>
  																  <option value="FIB">FIB</option>
																  <option value="PREP Equipment">PREP Equipment</option>
																  <option value="Surface Analysis">Surface Analysis</option>
																-->
																
																</select>
															</td>
                                                        </tr>
                                                        <tr class= "Trow">
                                                            <td>Rates</td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                          <tr class= "Trow">
                                                            <td>Training Rate : </td>
                                                            <td><input type="text" class="text" size="4" name="trainingRate"></td>
                                                        </tr>
                                                        
                                                        <tr class= "Trow">
                                                            <td>USC Campus Users with staff</td>
                                                            <td><input type="text" class="text" size="4" name="usc_with_cemma"></td>
                                                        </tr>
                                                        <tr class= "Trow">
                                                            <td>USC Campus Users without staff</td>
                                                            <td><input type="text" class="text" size="4" name="usc_without_cemma"></td>
                                                        </tr>
                                                        <tr class= "Trow">
                                                            <td>Other academic users with staff</td>
                                                            <td><input type="text" class="text" size="4" name="off_with_cemma"></td>
                                                        </tr>
                                                        <tr class= "Trow">
                                                            <td>Other academic users without staff</td>
                                                            <td><input type="text" class="text" size="4" name="off_without_cemma"></td>
                                                        </tr>
                                                        <tr class= "Trow">
                                                            <td>Industry With CEMMA Operator</td>
                                                            <td><input type="text" class="text" size="4" name="commerical"></td>
                                                        </tr>
                                                          <tr class= "Trow">
                                                            <td>Industry Without CEMMA Operator</td>
                                                            <td><input type="text" class="text" size="4" name="commerical_without_operator"></td>
                                                        </tr>
                                                        <tr class= "Trow">
                                                            <td>Unit</td>
                                                            <td><input type="text" class="text" size="4" name="cemma_unit"></td>
                                                        </tr>
                                                        <tr class= "Trow">
                                                            <td valign="top">Comments:</td>
                                                            <td><textarea class="text" style="font-size: 11px; font-family: Tahoma, Verdana, Arial;" name="comments" cols="20" rows="3" wrap="hard" ></textarea></td>
                                                        </tr>
                                                        <tr class= "Trow">
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </form>
                                        </tr>
                                        <tr>
                                            <td class="t-bot2"><a href="#"  onClick = "addMachine()">Add Instrument</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript: history.go(-1);">Cancel</a></td>
                                        </tr>
                                    </table></td>
                            </tr>
                        </table>
                        <div class="clr"></div></td>
                </tr>
            </table></td>
    </tr>
</table>
</td>
</tr>
</table>
<? include ('tpl/footer.php'); ?>

<script type="text/javascript">
function addMachine(){

	if(!confirm("Are you sure you want to continue?"))  return;
	
	// Getting form Values

	var theform = document.myform;
	var machine_name = theform.machine_name.value;
	var usc_with_cemma = theform.usc_with_cemma.value;
	var usc_without_cemma = theform.usc_without_cemma.value;
	var off_with_cemma = theform.off_with_cemma.value;
	var off_without_cemma = theform.off_without_cemma.value;
	var commerical = theform.commerical.value;
	var comments = theform.comments.value;
	var error = "";
	var availibility = 0
	
	var commerical_without_operator = theform.commerical_without_operator.value;
	
	
	if (theform.availibility[0].checked)
	availibility = 1


	// Error Checking
	if(machine_name == ""){
		error += "Machine name cannot be left blank";
	}
	else if(isNaN(usc_with_cemma) ||  isNaN(usc_without_cemma) || isNaN(off_with_cemma) || isNaN(off_without_cemma) || isNaN(commerical)){
		error += "\nInvalid Rates";
	}
	else if(usc_with_cemma < 0 || usc_without_cemma < 0 || off_with_cemma < 0 || off_without_cemma < 0 || commerical < 0){
		error = "\nInvalid Rates";
	}
	else if(usc_with_cemma == "" || usc_without_cemma == "" || off_with_cemma  == "" || off_without_cemma == "" || commerical == ""){
		error += "\nInvalid Rates";
	}
	
	if(error!=""){
		document.getElementById("error").innerHTML = "Please correct the following errors<br>" + error;
		showRow("error");
		return false;
	}	
	else{
		document.myform.submit();
	}
}
function showRow(id){
	document.getElementById(id).style.display = "";
}

function hideRow(id){
	document.getElementById(id).style.display = "none";

}
function Othertype(){
	document.getElementById("OtherTypeRow").style.visibility="visible";
	document.getElementById("OtherTypeRow").style.display="";

}
function ClearOtherType(){
	document.getElementById("OtherTypeRow").style.visibility="hidden";
	document.getElementById("OtherTypeRow").style.display="none";
	document.getElementById("OtherType").value="";
	

}

</script>