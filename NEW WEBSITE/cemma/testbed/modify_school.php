
<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include (DOCUMENT_ROOT.'tpl/header.php'); 
	
	include_once("includes/action.php");
	include_once(DOCUMENT_ROOT."Objects/customer.php");

	#include_once("includes/instrument_action.php");
$school_no =  $_GET['id'];
$submit =  $_GET['submit'];

if($submit=='true')
{
	
$school_name=$_POST['schoolname'];
include_once(DOCUMENT_ROOT."includes/database.php");
$sql3 = "UPDATE Schools SET SchoolName = '$school_name' WHERE SchoolNo = '$school_no'";
mysql_query($sql3) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 

echo "<center>You have successfully updated the School</center>";

?>
<script type="text/javascript">
//	alert("alert");
document.getElementById("alert").innerHTML = "School Name has been updated successfully";
document.getElementById("alert").style.display = "";
</script>
<?

}

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
		<?

	include_once(DOCUMENT_ROOT."includes/database.php");
	$sql1 = "SELECT SchoolName from Schools WHERE SchoolNo = '$school_no'";
	$result=mysql_query($sql1) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
	$row = mysql_fetch_array($result);
		?>
	   
                 <table width="100%" border="0" cellpadding="5" cellspacing="0">
                    <tr>
                      <td class="t-top"><div class="title2"><?php //echo (($_GET['submit_mode'] == 'add') ? 'Add ': 'Edit ');?> School Name Details</div></td>
                    </tr>
                    <tr>
                      <td class="t-mid"><br />
                        <br />
                        <form id="myForm" name="myForm" method="post" action="modify_school.php?id=<?=$school_no?>&submit=true">
                        <input type="hidden" id="Manager_ID" name="Manager_ID" value=""/>
                          <table class="content" align="center" width="450" border = "0">
                            <tr valign="top">
								<td colspan = "2" width="100%"><div align="center" class="err" id="error" style="display:none"></div>
								<div align="center" class="alert" style="font-size:13;display:none" id="alert"></div></td>
							</tr>
							
							<tr class="Trow">
                              <td width = "40%">*School Name: </td>
                              <td><input type="text" size="30" name="schoolname" id="schoolname" class="text"  value="<?=$row['SchoolName']?>" /></td>
                            </tr>

							<tr><td></td>
							<td>
<!-- <input type="submit" value="Submit" align="center"> -->
                         
							</td>




		<!-- hiiden link to addcustomer()--><tr> <td></td><td><a href = "javascript: tp()"></a></td></tr>
                          </table>
                          <br />
                          <br />
                        </form>
                       
                      </td>
                    </tr>
                    <tr>
                      <td class="t-bot2"><a href = "javascript:submitclicked()">Modify School Name</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="schools.php">Return</a></td>
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
<? if($paytypelist[0]==3 || $paytypelist[1]==3 || $paytypelist[2]==3)
	{
		
		//echo "Balancee is:".$Balance;
	//	echo "<script type='text/javascript'> alert('hii') </script>";
	}
?>
<? include ('tpl/footer.php'); ?>



<script type="text/javascript">


// Global variables

var TotalInstrumentAdded=0;
var Additionaltext="<td></td>";
var AddAnotherInstrumentOptionSelected=0;
var AddAllInstrumentOptionSelected=0;


function submitclicked()
{
document.myForm.submit();
}

var radioActivated = document.forms['myForm'].elements['Activated'];
<? if ($_GET['submit_mode'] == 'add' && $row['Activated'] != 1) { ?>
	 
		radioActivated[1].checked = true;
<? } ?>

<?php if(isset($mode)){
		if($mode === "Update"){
?>
			document.getElementById("alert").innerHTML = "Customer has been updated successfully";
			showRow("alert");
<?php
		}
		else if($mode === "Add"){
?>
			addCustomer();
			document.getElementById("alert").innerHTML = "Customer has been Added successfully";
			showRow("alert");
<?php

		}
}
?>



function validate(){
	//alert("hee");
	
	if(!confirm("Are you sure you want to continue?"))  return;
	
//	alert("pop");
	var theform = document.myForm;
	var name = theform.Name.value;
	var address1 = theform.Address1.value;
	var address2 = theform.Address2.value;
	var city = theform.City.value;
	var state= theform.State.value;
	var zip = theform.Zip.value;
	var phone1 = theform.Phone1.value;
	var phone2 = theform.Phone2.value;
	var phone3 = theform.Phone3.value;
	var eid = theform.EmailId.value;
	var fax = theform.Fax.value;
	var phone='';
	if(phone1!='')
	{
	phone = "("+phone1+")"+phone2+"-"+phone3;
	}

//	var membershipAmt=theform.MembershipAmt.value;


	//alert("pop");
//	alert(theform.paymentType3.value);	
//alert("pop");
	var error = "";
	
	// Error Checking

	if(name == "" || city == "" || state == "" || zip == "")  {
		error += "<br>Required fields cannot be left blank";
	}
	
	
	if(isNaN(zip)){
		error += "<br>Invalid Zip Code";
	}
	
	//if(!checkEmail(eid)){
	 //  error += "<br>Invalid Email-id";
//	}
	
	//if(!checkPhone(phone)){
	//	if(phone!= "()-"){
	//		error += "<br>Invalid Phone Number";	
	//	}
	//}
	
//	if(!checkPhone(fax)){
//		if(fax!= ""){
//		error += "<br>Invalid Fax Number";
//	
//		}
//	}
	
	if(error!=""){
		document.getElementById("error").innerHTML = "Please correct the following errors<br>" + error;
		showRow("error");
	}	
	else{
		// send data in hidden values to $_POST
		document.myForm.Phone.value = phone;
		document.myForm.HiddenInstSelected.value = TotalInstrumentAdded;
		document.myForm.Add1.value = AddAnotherInstrumentOptionSelected;
		document.myForm.AddAll.value = AddAllInstrumentOptionSelected;


		
	//	alert("about to submit");
	//	addCustomer();

		
		document.myForm.submit();
	}	
//alert("done validate");
}

function checkPhone(string){
	phoneRegex = /^\(\d\d\d\)\d\d\d-\d\d\d\d$/;
	if( !string.match(phoneRegex) ) {
	  return false;
	 }
	 return true;
}

function autotab(original,destination){
	if (original.value.length==original.getAttribute("maxlength"))
		destination.focus()

}

function checkEmail(eid){  

   var len = eid.length;
   var pos = eid.lastIndexOf ( '.', len - 1 ) + 1;
   if ( eid.length <= 1 || eid.indexOf ('@', 0) == -1 || eid.indexOf ( '@', 0 ) < 1 || eid.indexOf ( '.', 0 ) == -1 || (( len - pos ) < 2 || ( len - pos ) > 4)){   
		return false;
	}
   else {
	return true;
	}
}

function showRow(id){
	document.getElementById(id).style.display = "";
}

function hideRow(id){
	document.getElementById(id).style.display = "none";

}

var Instruments="";

</script>
