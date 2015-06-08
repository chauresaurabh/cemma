
<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include (DOCUMENT_ROOT.'tpl/header.php'); 
	
	include_once("includes/action.php");
	include_once(DOCUMENT_ROOT."Objects/customer.php");

	include_once("includes/instrument_action.php");
	$username =  $_GET['id'];
	$submit =  $_GET['submit'];
	//echo "s".$submit;

	if($submit=='true')
	{		
		$password=$_POST['password'];
		$LastName=$_POST['LastName'];
		$FirstName=$_POST['FirstName'];
		$Email=$_POST['Email'];
		$Telephone=$_POST['Telephone'];
		$Advisor=$_POST['Advisor'];
		$GradYear=$_POST['GradYear'];
		$Comments=$_POST['Comments'];

		$adminclass=$_POST['adminclass'];

		$Dept=$_POST['Dept'];

		$position=$_POST['Position'];
		$fieldofinterest=$_POST['fieldofinterest'];
		$countfieldofinterest = count($fieldofinterest);
		$fieldofinteresttosave="";

		for ($i=0;$i<$countfieldofinterest ; $i++)
		{
			if ($i==0)
			{	
				$fieldofinteresttosave=$fieldofinterest[$i];
			}
			else
			{	
				$fieldofinteresttosave=$fieldofinteresttosave.",".$fieldofinterest[$i];
			}
		}

		include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
		$sql3 = "UPDATE UsersInQuery SET Passwd = '$password', Email='$Email', FirstName='$FirstName', LastName='$LastName', Telephone='$Telephone', Dept='$Dept', Advisor='$Advisor',GradYear='$GradYear' ,Position='$position', FieldofInterest='$fieldofinteresttosave' WHERE UserName = '$username'";
		mysql_query($sql3) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 

		$InstrumentName=$_POST['InstrumentName'];

		$countInstrumentName = count($InstrumentName);

		include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
		//$sql3 = "DELETE FROM UsersInQuery_instr_group WHERE Email='$Email'";  
		//mysql_query($sql3) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 

		for ($i=0;$i<$countInstrumentName ; $i++)
		{ 
			//echo " pop".$InstrumentName[$i]." count-".$countInstrumentName;
			$pieces = explode("_", $InstrumentName[$i]);
			$intruments[$i]=$pieces[0];
			$k=$pieces[1];

			//echo " instr-".$intruments[$i];
			$instrno=$intruments[$i];
				//echo " name-".$InstrumentName[$i];

				$t1="yy".$k;
				$t2="mm".$k;
				$t3="dd".$k;
				//echo " yy-mm-dd ".$_POST[$t1]." ".$_POST[$t2]." ".$_POST[$t3];
				$yy=$_POST[$t1];
				$mm=$_POST[$t2];
				$dd=$_POST[$t3];
				$datetoput=$yy."-".$mm."-".$dd;
				include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
			$sql3 = "INSERT INTO UsersInQuery_instr_group (InstrNo,  Email , InstrSigned, UserName) VALUES ('$instrno', '$Email', '$datetoput','$username')";  
			mysql_query($sql3) or die( "An error has occurred in query2: " .mysql_error (). ":" .mysql_errno ()); 
		}
	echo "<center>You have successfully updated the User in Query</center>";
}

//echo "idd".$username;
//echo "id-".$_SESSION['Customer_ID'];
//echo "name-".$_SESSION['login'];
//editCustomer.php?id
	// echo "<script language='javascript'>alert('hi'); </script>";  // alert here pops up window but doesnt go further



			
	

?>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td class="body" valign="top" align="center"><?	include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?><table border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td class="body_resize"><table border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td>

		
	
	

		<?
		
//Retrieve current details

	include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
	$sql1 = "select Passwd, Class, Email, FirstName, LastName, Telephone, Dept, Advisor, GradYear, GradTerm, Position, FieldofInterest,Comments  from UsersInQuery where UserName = '$username'";
	$result=mysql_query($sql1) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
	$row = mysql_fetch_array($result);
		?>
	   
                 <table width="90%" border="0" cellpadding="5" cellspacing="0">
                    <tr>
                      <td class="t-top"><div class="title2"><?php //echo (($_GET['submit_mode'] == 'add') ? 'Add ': 'Edit ');?> New Requests User Details :  <?=$username?></div></td>
                    </tr>
                    <tr>
                      <td class="t-mid"> 
                        <form id="myForm" name="myForm" method="post" action="EditQueryUsers.php?id=<?=$username?>&submit=true">
                        <input type="hidden" id="Manager_ID" name="Manager_ID" value=""/>
                        
                         <input type="hidden" id="userDetailsIdHidden" value=<?=$username?> />
                            <input type="hidden" id="userEmailIdHidden" value=<?=$row['Email']?> />
                            
                          <table class="content" align="center" width="650" border = "0" cellpadding="5" cellspacing="0">
                            <tr valign="top">
								<td colspan = "2" width="100%"><div align="center" class="err" id="error" style="display:none"></div>
								<div align="center" class="alert" style="font-size:13;display:none" id="alert"></div></td>
							</tr>
					 
							<tr class="Trow">
                              <td width = "40%">*Password: </td>
                              <td colspan="3"><input type="password" size="30" name="password" class="text"  value="<?=$row['Passwd']?>"></td>
                       </tr>        
                               <td>Last Name: </td>
                              <td><input type="text" size="30" name="LastName" class="text"  value="<?=$row['LastName']?>"></td>
                              
                               <td>Email:</td>
                              <td><input type="text" size="30" name="Email" class="text"  value="<?=$row['Email']?>"></td>
                            </tr>

						   
							<tr class="Trow">
                              <td>First Name:  </td>
                              <td><input type="text" size="30" name="FirstName" class="text"  value="<?=$row['FirstName']?>"></td>
                              
                               <td>Telephone: </td>
                              <td><input type="text" size="30" name="Telephone" class="text"  value="<?=$row['Telephone']?>"></td>
                            </tr>

						 
							<tr class="Trow">
                              <td>Department: </td>
                              <td><input type="text" size="30" name="Dept" class="text"  value="<?=$row['Dept']?>"></td>
                             
                               <td>Advisor: </td>
                              <td><input type="text" size="30" name="Advisor" class="text"  value="<?=$row['Advisor']?>"></td>
                             
                            </tr>
 
							<tr class="Trow">
								<td>Position: </td>
									<td>
										<input type="radio" name="Position" id="pos_US" value="US">Undergraduate Student<br>
										<input type="radio" name="Position" id="pos_GS" value="GS">Graduate Student<br>
										<input type="radio" name="Position" id="pos_PD" value="PD">Post Doctor<br>
										<input type="radio" name="Position" id="pos_PI" value="PI">Private Investigator<br>
										
										<?php 
											if($row['Position']=="US")		{	echo "			<script>document.getElementById(\"pos_US\").checked=true;</script>";	}
											else if($row['Position']=="GS")	{	echo "			<script>document.getElementById(\"pos_GS\").checked=true;</script>";	}
											else if($row['Position']=="PD")	{	echo "			<script>document.getElementById(\"pos_PD\").checked=true;</script>";	}
											else if($row['Position']=="PI")	{	echo "			<script>document.getElementById(\"pos_PI\").checked=true;</script>";	}
										?>
									</td>
                                    
                                     <td>User Access Rights:</td>
                            <!-- <td><?=$enrolledPayments?></td>  --> 
							

							  <td> 
							  <? if($row['Class']=='1') { $adminclass='checked'; }  ?>

							  <input type="checkbox" name="adminclass" id="adminclass" <?echo $adminclass;?> value="check" />&nbsp; Set this user as administrator
							
							  </td>
                              
                            </tr>
 
                            <tr class="Trow">
                              <td>*Field of Interest: </td>
                            <!-- <td><?=$enrolledPayments?></td>  --> 
							
							  <td> 
							  <? 		
							  $pieces = explode(",", $row['FieldofInterest']);
							//  echo "full".$row['FieldofInterest'].".";
							//  $PhysicalScience1=$pieces[1]; // piece1
							 // $LifeScience1=$pieces[0];  // first is Life and 2nd is Physical
							// echo " 00-".$pieces[0]." 11-".$pieces[1].".";

							  if($pieces[1]=="Physical Science" || $row['FieldofInterest']=="Physical Science") { $PhysicalScience='checked'; }  
							  if($pieces[0]=='Life Science' || $pieces[1]=='Life Science' || $row['FieldofInterest']=='Life Science') 
							  { $LifeScience='checked'; }  
							//   echo " phy-".$PhysicalScience." lif-".$LifeScience;
								 ?>
							  <input type="checkbox" name="fieldofinterest[]" id="fieldofinterest" <? echo $LifeScience; ?> value="Life Science" <? //echo $row['FieldofInterest']; ?> />&nbsp; Life Science
							  <input type="checkbox" name="fieldofinterest[]" id="fieldofinterest" <? echo $PhysicalScience; ?> value="Physical Science" <? //echo $row['FieldofInterest']; ?> />&nbsp;  Physical Science 
							  </td>
						
                       <td>Comments: </td>
							<td > 
                            	<p style="border-style:solid;border-width:1px">&nbsp; <? echo $row['Comments']?> </p>
                                <input type="button"  value="Add Comment" onclick="openComments()" /> 
                               </td>

                            </tr>
	<tr class="Trow">
 						 	 <td colspan="4"> 
								   <fieldset>
                            	<legend>Approved Instruments</legend>
						 	<table cellpadding="10">

						  <?
							include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
							$sql1 = "select * from UsersInQuery_instr_group where Email ='".$row['Email']."'";
							$result=mysql_query($sql1) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
 							$i=0;
							while($row3 = mysql_fetch_array($result))
							{
								$instrnos[$i]=$row3['InstrNo'];
								$instrsigned[$i]=$row3['InstrSigned'];
								$permission[$i] = $row3['Permission'];
							//	echo "N".$instrnos[$i];
							//	echo 'lol';
								$i++;
							}
							include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
							$sql1 = "select InstrumentNo, InstrumentName from instrument";
							$result=mysql_query($sql1) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
 							$no=0;
							$testCount=0;
							while($row2 = mysql_fetch_array($result))
							{
								$checked1='';
								//echo "-";
								for($j=0;$j<$i;$j++)
								{
									if($row2['InstrumentNo']==$instrnos[$j])
									{
										$checked1='checked';
										break;
 									}
								}	
								 if($checked1=='')
									 continue;	
							?>	
                            <? if($testCount==0) { ?>
							<tr>
                            <? } ?>
                             <? if($testCount%2 == 0) {
								 	
								  ?>
                                  </tr> <tr>
                                  <? } ?>
                                  
                                    <td> <? echo "<b>".$row2['InstrumentName']  ."</b>" ?>   
                                    <?
                                    /*	$pieces = explode("-", $instrsigned[$j]);
                                        $yy=$pieces[0]; //yy
                                        $mm=$pieces[1]; //mm
                                        $dd=$pieces[2]; //dd
                                         echo $yy."-".$mm."-".$dd; */
                                    ?>
                                    <? 
                                        if($permission[$j]=="Peak") 
                                            echo "Peak time only&nbsp;&nbsp;&nbsp;&nbsp;";
                                        else
                                            echo "Peak time only&nbsp;&nbsp;&nbsp;&nbsp;";
                                        ?>	
                                    </td>								 
							
						<?
								$no++;
								$testCount++;
							}
						?>

							</tr>
  	
								 </table>
                                 </fieldset>
     <input type="button" value="Add Instrument" onclick="addInstruments()" />


							  </td>


                            </tr>
							<tr><td></td>
							 <? if($_SESSION['ClassLevel']==1) {?>
                             <td>
<input type="submit" value="Submit" align="center"> 
                         
							</td>
                            	<? } ?>




		<!-- hiiden link to addcustomer()--><tr> <td></td><td><a href = "javascript: tp()"></a></td></tr>
                          </table>
                          <br />
                          <br />
                        </form>
                       
                      </td>
                    </tr>
                    <tr>
                      <td class="t-bot2"><!--<a href = "javascript: validate()">Modify Customer </a>&nbsp;&nbsp;|&nbsp;&nbsp; --><a href="NewRequestsUsers.php">Return &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </a></td>
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
//var AdditionalAmt="";
//var AdditionalInstruments="";
var TotalInstrumentAdded=0;
var Additionaltext="<td></td>";
var AddAnotherInstrumentOptionSelected=0;
var AddAllInstrumentOptionSelected=0;

 function openComments()
{
 	var userId = document.getElementById('userDetailsIdHidden').value;
  	var popup = window.open("AddUserCommentsQuery.php?userId="+userId, "_blank", "width=500, height=500") ;
}

function addInstruments(){
	 	var userId = document.getElementById('userEmailIdHidden').value;
	  	var popup = window.open("AddInstrumentsUsersQuery.php?userId="+userId, "_blank", "scrollbars=1, width=500, height=500") ;
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
function membership()
{
	//alert("j");


	var Duration="<td></td>";
	Duration+="<td class='hide' id='td5'>&nbsp; Duration &nbsp; &nbsp; ";
	Duration+="<select id='DurationList' name='DurationList' height=100 class='hide'>";
	Duration+="<option value='A'>A (Jan 1 - Apr 30)";
	Duration+="</option>";
	Duration+="<option  value='B'>B (May 1 - Aug 31)";
	Duration+="</option>";
	Duration+="<option  value='C'>C (Sept 1 - Dec 31)";
	Duration+="</option>";
	Duration+="</select>";
	Duration+="</td>";

	
		
	var Amt="<td></td>";
	Amt+="<td class='hide' id='td3'>&nbsp; Amount &nbsp; &nbsp; &nbsp;";
	Amt+="<input  class='texthidden'  type='text' maxlength = '10' size = '10' name='MembershipAmt' id='MembershipAmt' style = 'width: 20mm'"; 
	Amt+="value=''>";
	Amt+="</td>";

	Instruments="<td></td>";
	Instruments+="<td class='hide' id='td4'>&nbsp; Instrument &nbsp;";
	Instruments+="<select id='InstrumentList' name='InstrumentList' height=100 class='hide'>";
				<? $kk=0; while ($kk<$p){ ?>
	Instruments+="<option>";
	Instruments+="<?=$arr[$kk]?>";
	Instruments+="</option>";
				<? $kk++;} ?>
	Instruments+="</select>";
	Instruments+="</td>";  

	var AddLink="<td></td>";
	AddLink+="<td class='hide' id='td6'>";
	AddLink+="<a id='link1' style='cursor:pointer;background:transparent url(images/mini/action_go.gif) no-repeat scroll left center;color:#996600;font-size:11px;font-weight:bold;padding-left:20px;text-decoration:none;'  onClick = 'addInstrument()'>Another Instrument</a>&nbsp; ";
	AddLink+="<a id='link2' style='cursor:pointer;background:transparent url(images/mini/action_go.gif) no-repeat scroll left center;color:#996600;font-size:11px;font-weight:bold;padding-left:20px;text-decoration:none;'  onClick = 'addAllInstrument()'>All Instruments</a>";
	AddLink+="</td>";
	

	document.getElementById("DurationRow").innerHTML=Duration;
	document.getElementById("MembershipAmtRow").innerHTML=Amt;
	document.getElementById("MembershipInstrumentRow").innerHTML=Instruments;
	document.getElementById("AddLinkRow").innerHTML=AddLink;


	




	if(document.myForm.Payment[1].checked==true)
	{
	
		document.getElementById("DurationList").style.visibility="visible";
		document.getElementById("MembershipAmt").style.visibility="visible";
		document.getElementById("InstrumentList").style.visibility="visible";


	
		document.getElementById("td3").style.visibility="visible";
		document.getElementById("td4").style.visibility="visible";
		document.getElementById("td5").style.visibility="visible";
		document.getElementById("td6").style.visibility="visible";
		document.getElementById("td7").style.visibility="visible";
	
	}

	else

	{
		if(document.myForm.Payment[1].checked==false)
		{

		document.getElementById("DurationList").style.visibility="hidden";
		document.getElementById("MembershipAmt").style.visibility="hidden";
		document.getElementById("InstrumentList").style.visibility="hidden";
		document.getElementById("link1").style.visibility="hidden";
		document.getElementById("link2").style.visibility="hidden";
			

		document.getElementById("td3").style.visibility="hidden";
		document.getElementById("td4").style.visibility="hidden";
		document.getElementById("td5").style.visibility="hidden";
		
		document.getElementById("DurationRow").innerHTML="";
		document.getElementById("MembershipAmtRow").innerHTML="";
		document.getElementById("MembershipInstrumentRow").innerHTML="";
		document.getElementById("AdditionalRow").innerHTML="";
		document.getElementById("AddLinkRow").innerHTML="";
		
		var i;
		var k1,k2,k3,k4,k5;
			for (i=1;i<=TotalInstrumentAdded ;i++ )
			{
		k1="a"+i;
		k2="id"+i;
		k3="i"+i;
		k4="MembershipAdditionalAmt"+i;
		k5="InstrumentList"+i;
		k6="in"+i;
		document.getElementById(k1).style.visibility="hidden";
		document.getElementById(k2).style.visibility="hidden";
		document.getElementById(k3).style.visibility="hidden";
		document.getElementById(k4).style.visibility="hidden";
		document.getElementById(k5).style.visibility="hidden";
		document.getElementById(k6).style.visibility="hidden";
			}

	}	


	}

//	alert("hi");
//	document.getElementById("tr1").innerHTML="<tr><td>11</td></tr>";

}

function advancePayment()
{
	//alert("hi-a");
	//var divtext="<td></td><tr class='Trow' id='a1'><td></td><td>1</td></tr>";
//	divtext+="<tr class='Trow' id='a2'><td></td><td>2</td></tr>";
//	divtext+="<tr class='Trow' id='a3'><td></td><td>3</td></tr>";

	var AdvanceAmt="<td></td>";
	AdvanceAmt+="<td class='hide' id='Advancetd1'>&nbsp;&nbsp;&nbsp; Amount &nbsp; &nbsp; &nbsp;";
	AdvanceAmt+="<input  class='texthidden'  type='text' maxlength = '10' size = '10' name='AdvanceAmt' id='AdvanceAmt' style = 'width: 20mm'"; 
	AdvanceAmt+="value='<?=$Balance?>'>";
	AdvanceAmt+="</td>";
	

	if(document.myForm.Payment[2].checked==true)
	{
		document.getElementById("AdvanceAmtRow").innerHTML=AdvanceAmt;

	
		document.getElementById("Advancetd1").style.visibility="visible";
		document.getElementById("AdvanceAmt").style.visibility="visible";
	
	}
	else
		if(document.myForm.Payment[2].checked==false)
	{
		document.getElementById("AdvanceAmtRow").innerHTML="";

	
		document.getElementById("Advancetd1").style.visibility="hidden";
		document.getElementById("AdvanceAmt").style.visibility="hidden";
	
	}

}



function addInstrument()
{
	var totalinstruments="<?=$p?>";
	//alert(totalinstruments);



	if(TotalInstrumentAdded>=(totalinstruments-1))
	{		alert("All Instruments Added, Cannot add more Instruments");
	return;
	}
	if (AddAllInstrumentOptionSelected==1)
	{
		//alert("You have selected to Add All Instruments, Do you want to change it ? "+AddAllInstrumentOptionSelected);

		var answer = confirm  ("All Instruments are Selected, Do you want to unselect all and add an Instrument ?")
		if (answer)
			AddAllInstrumentOptionSelected=0;
		else
			AddAllInstrumentOptionSelected=1;
	}

	if (AddAllInstrumentOptionSelected==1)
	{
	return;
	}

	else
	{
		if(addclicked==1)
	{

	document.getElementById("MembershipInstrumentRow").innerHTML=Instruments;
	document.getElementById('InstrumentList').style.visibility="visible";
	document.getElementById('td4').style.visibility="visible";
	addclicked=0;
	return;
	}
	AddAnotherInstrumentOptionSelected=1;
	//alert("add 1"+AddAnotherInstrumentOptionSelected);

	TotalInstrumentAdded++;
	//alert(TotalInstrumentAdded);	

	var AdditionalAmt="";
	var AdditionalInstruments="";
	


	AdditionalAmt+="<tr class='Trow' id='a";
	AdditionalAmt+=TotalInstrumentAdded;
	AdditionalAmt+="'>";
	AdditionalAmt+="<td></td><td class='hide' id='id";
	AdditionalAmt+=TotalInstrumentAdded;
	AdditionalAmt+="'>&nbsp; Amount &nbsp; &nbsp; &nbsp;";
	AdditionalAmt+="<input  class='texthidden'  type='text' maxlength = '10' size = '10' name='MembershipAdditionalAmt";
	AdditionalAmt+=TotalInstrumentAdded;
	AdditionalAmt+="' id='MembershipAdditionalAmt";
	AdditionalAmt+=TotalInstrumentAdded;
	AdditionalAmt+="' style = 'width: 20mm'"; 
	AdditionalAmt+="value=''>";
	AdditionalAmt+="</td></tr>";

	AdditionalInstruments+="<tr class='Trow' id='in";
	AdditionalInstruments+=TotalInstrumentAdded;
	AdditionalInstruments+="'>";
	AdditionalInstruments+="<td></td><td class='hide' id='i";
	AdditionalInstruments+=TotalInstrumentAdded;
	AdditionalInstruments+="'>&nbsp; Instrument &nbsp;";
	AdditionalInstruments+="<select id='InstrumentList";
	AdditionalInstruments+=TotalInstrumentAdded;
	AdditionalInstruments+="' name='InstrumentList";
	AdditionalInstruments+=TotalInstrumentAdded;
	AdditionalInstruments+="' height=100 class='hide'>";
				<? $kk=0; while ($kk<$p){ ?>
	AdditionalInstruments+="<option>";
	AdditionalInstruments+="<?=$arr[$kk]?>";
	AdditionalInstruments+="</option>";
				<? $kk++;} ?>
	AdditionalInstruments+="</select>";
	AdditionalInstruments+="</td></tr>";
	Additionaltext+=AdditionalAmt+AdditionalInstruments;

	document.getElementById("AdditionalRow").innerHTML=Additionaltext;
	
	var i;
	var k1,k2,k3;

	if(document.myForm.Payment[1].checked==true)
	{
	for (i=1;i<=TotalInstrumentAdded ;i++ )
	{
		k1="a"+i;
		k2="id"+i;
		k3="i"+i;
		k4="MembershipAdditionalAmt"+i;
		k5="InstrumentList"+i;
		k6="in"+i;
		
		
		


		document.getElementById(k1).style.visibility="visible";
		document.getElementById(k2).style.visibility="visible";
		document.getElementById(k3).style.visibility="visible";
		document.getElementById(k4).style.visibility="visible";
		document.getElementById(k5).style.visibility="visible";
		document.getElementById(k6).style.visibility="visible";
		
		
		
	}
	}
	else

	{
		if(document.myForm.Payment[1].checked==false)
		{
			
			document.getElementById("AdditionalRow").innerHTML="";
			for (i=1;i<=TotalInstrumentAdded ;i++ )
			{
		k1="a"+i;
		k2="id"+i;
		k3="i"+i;
		k4="MembershipAdditionalAmt"+i;
		k5="InstrumentList"+i;
		k6="in"+i;
		document.getElementById(k1).style.visibility="hidden";
		document.getElementById(k2).style.visibility="hidden";
		document.getElementById(k3).style.visibility="hidden";
		document.getElementById(k4).style.visibility="hidden";
		document.getElementById(k5).style.visibility="hidden";
		document.getElementById(k6).style.visibility="hidden";
			}
		
		}

	}
	}

}
var addclicked=0;

function addAllInstrument()
{
AddAllInstrumentOptionSelected=1;
AddAnotherInstrumentOptionSelected=0;
//alert("all clicked"+AddAllInstrumentOptionSelected);
alert("All Instruments Selected");
hideInstruments();
//TotalInstrumentAdded=0;
addclicked=1;
}

function hideInstruments()
{
		document.getElementById("AdditionalRow").innerHTML="";
		Additionaltext="<td></td>"; //to empty collected string for 
		AdditionalAmt="";
		AdditionalInstruments="";
		TotalInstrumentAdded=0;
		var i;
		var k1,k2,k3,k4,k5;
			for (i=1;i<=TotalInstrumentAdded ;i++ )
			{
		k1="a"+i;
		k2="id"+i;
		k3="i"+i;
		k4="MembershipAdditionalAmt"+i;
		k5="InstrumentList"+i;
		k6="in"+i;
		document.getElementById(k1).style.visibility="hidden";
		document.getElementById(k2).style.visibility="hidden";
		document.getElementById(k3).style.visibility="hidden";
		document.getElementById(k4).style.visibility="hidden";
		document.getElementById(k5).style.visibility="hidden";
		document.getElementById(k6).style.visibility="hidden";
			}

		document.getElementById('InstrumentList').style.visibility="hidden";
		document.getElementById('td4').style.visibility="hidden";
		document.getElementById("MembershipInstrumentRow").innerHTML="";
		document.getElementById('MembershipInstrumentRow').innerHTML="<td></td><td>&nbsp; &nbsp; All Instruments Selected</td>";
		
}












</script>
