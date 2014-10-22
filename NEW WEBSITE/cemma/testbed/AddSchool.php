<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include (DOCUMENT_ROOT.'tpl/header.php'); 
	
	include_once("includes/action.php");
	
	
	if(isset($_POST['NewSchoolName'])){

		$new_school_name =  $_POST['NewSchoolName'];
		$sql = "INSERT INTO Schools VALUES ('', '$new_school_name')";
		mysql_query($sql) or die("Error in Adding Instrument!");
		//echo "Instrument Type Added Successfully";
	}
	
?>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td class="body" valign="top" align="center">
        <? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?>
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
                                            <td class="t-top"><h2 class="Our">Add School</h2></td>
                                        </tr>
                                        <tr>
                                            <td class="t-mid"><br />
                                                <br />
                                                <form id="myform" name="myform" method="post" action="AddSchool.php">
                                                    <table width="450" class="content" align="center" style="border: thin, #993300">
                                                
														<tr class= "Trow">
														<td><div align="center" class="alert" style="font-size:13;display:none" id="alert"></div></td>
														</tr>
														<tr name="OtherTypeRow" id="OtherTypeRow" class= "Trow" >
                                                            <td>Enter School Name:</td>
                                                            <td><input type="text" class="text" size="4" name="NewSchoolName" id="NewSchoolName" value="">
															</td>
	                                                   </tr>

                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </form>
                                        </tr>
                                        <tr>
                                            <td class="t-bot2"><a href="#"  onClick = "addMachine()">Add School Name</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="schools.php">Return</a></td>
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