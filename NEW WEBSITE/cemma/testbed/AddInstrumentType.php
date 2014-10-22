<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include (DOCUMENT_ROOT.'tpl/header.php'); 
	
	include_once("includes/action.php");
	
	
	if(isset($_POST['OtherType'])){

		$OtherType =  $_POST['OtherType'];
		$sql = "INSERT INTO Instrument_Types VALUES ('', '$OtherType')";
		mysql_query($sql) or die("Error in Adding Instrument");
		//echo "Instrument Type Added Successfully";
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
                                            <td class="t-top"><h2 class="Our">Add Type</h2></td>
                                        </tr>
                                        <tr>
                                            <td class="t-mid"><br />
                                                <br />
                                                <form id="myform" name="myform" method="post" action="AddInstrumentType.php">
                                                    <table width="450" class="content" align="center" style="border: thin, #993300">
                                                
														<tr class= "Trow">
														<td><div align="center" class="alert" style="font-size:13;display:none" id="alert"></div></td>
														</tr>
														<tr name="OtherTypeRow" id="OtherTypeRow" class= "Trow" >
                                                            <td>Enter New Type:</td>
                                                            <td><input type="text" class="text" size="4" name="OtherType" id="OtherType" value="">
															</td>
	                                                   </tr>

																
															                                                       

                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </form>
                                        </tr>
                                        <tr>
                                            <td class="t-bot2"><a href="#"  onClick = "addMachine()">Add Type</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript: history.go(-1);">Return</a></td>
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
<?	if(isset($_POST['OtherType'])){

	
?>
<script type="text/javascript">
	document.getElementById("alert").innerHTML = "Type has been added successfully";
	document.getElementById("alert").style.visibility="visible";
	document.getElementById("alert").style.display="";
</script>
<? } ?>


<? include ('tpl/footer.php'); ?>

<script type="text/javascript">
function addMachine(){

	if(!confirm("Are you sure you want to continue?"))  return;
	document.myform.submit();
	/*
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
		
	}*/
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