
<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include (DOCUMENT_ROOT.'tpl/header.php');
	 
	include_once("includes/action.php");
	include_once(DOCUMENT_ROOT."Objects/customer.php");
	include_once("includes/instrument_action.php");

	if(isset($_POST['Name'])){
		foreach($_POST as $key=>$value){
			//echo $key." => ".$value."<br/>";
		}
		$rs = new CustomerDAO();
		if($_GET['submit_mode'] != 'add'){
			echo($rs->update($_GET['id'],$_POST));
			$mode = "Update";
		}
		else{
			echo($rs->add($_POST));
			$mode = "Add"; 
		}
	}
	
	//Getting Instrument Details
	$ri = new InstrumentDAO();
	$ri->getList(10,$_POST['orderby'],$_POST['o']);
	$currentRowNum = $ri->getStartRecord()*1; 
	
	// Store Instrument name in $arr array and total number of instruments in $p
	$p=0;
	 while ($row2=$ri->fetchArray())
	{
		$arr[$p]=$row2['InstrumentName'];
	//	echo $arr[$p];
		$p++;
	}
?>
<script type="text/javascript">
var xmlHttp;
try {
	// Firefox, Opera 8.0+, Safari
	xmlHttp=new XMLHttpRequest();
 } catch (e) {
	// Internet Explorer
	try {
	  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
   } catch (e) {
	  try {
		   xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		} catch (e) {
		   alert("Your browser does not support AJAX!");
		}
   }
}
function updateGroupAccountNum(){
	if(null==xmlHttp){
		alert("Your browser does not support AJAX!");
		return;
	}
   var cust_name = document.getElementById('cust_name').value;
   var acc_num = document.getElementById('reg_user_acc_num').value;
	if(acc_num=="" || acc_num==" "){
	   alert("Please enter a valid account number");
	   return;
   }
   xmlHttp.onreadystatechange=function() {
		if(xmlHttp.readyState==4) {
			alert(xmlHttp.responseText);
		}
	}

	xmlHttp.open("GET","GetRegUserAccountNum.php?type=update_grp&reg_user="+cust_name+"&acc_num="+acc_num,true);
	xmlHttp.send(null);
}
function updateAccountNum(){
	if(null==xmlHttp){
		alert("Your browser does not support AJAX!");
		return;
	}
   var regUser = document.getElementById('regUser').value;
   var acc_num = document.getElementById('reg_user_acc_num').value;
   if(regUser=="select_one"){
		alert("Please select a registered user");
		return;
   }
   if(acc_num=="" || acc_num==" "){
	   alert("Please enter a valid account number");
	   return;
   }
   xmlHttp.onreadystatechange=function() {
		if(xmlHttp.readyState==4) {
			alert(xmlHttp.responseText);
		}
	}

	xmlHttp.open("GET","GetRegUserAccountNum.php?type=update&reg_user="+regUser+"&acc_num="+acc_num,true);
	xmlHttp.send(null);
}
function loadAccountNum(){
	if(null==xmlHttp){
		alert("Your browser does not support AJAX!");
		return;
	}
   var regUser = document.getElementById('regUser').value;
	if(regUser=="select_one"){
		document.getElementById('reg_user_acc_num').value = '';
		return;
   } 
	xmlHttp.onreadystatechange=function() {
		if(xmlHttp.readyState==4) {
			document.getElementById('reg_user_acc_num').value = String.trim(xmlHttp.responseText);
		}
	}

	xmlHttp.open("GET","GetRegUserAccountNum.php?type=load&reg_user="+regUser,true);
	xmlHttp.send(null);
}
</script>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
    		<td class="body" valign="top" align="center">
            <? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?>
			<table border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td class="body_resize">
						<table border="0" cellpadding="0" cellspacing="0" align="center">
							<tr>
								<td>
									<?php
										/*
										echo "*activated=".$_POST['Activated']."<br>";
										echo "*mode=".$mode."<br>";
										echo "*submot_mode=".$_GET['submit_mode']."<br>";
										echo "*AdvanceAmt=".$_POST['AdvanceAmt']."<br>";
										echo "*RmBalance=".$_POST['RmBalance']."<br>";
										echo "*NewBalance=".($_POST['AdvanceAmt']+$_POST['RmBalance'])."<br>";
										*/
										if($_GET['submit_mode'] == 'add')
										{
 											$row['Phone'] = '';
											$row['Name'] = '';
											$row['Uname'] = '';
											//$row['AccountNum'] = '';
											$row['Address1'] = '';
											$row['Address2'] = '';
											$row['City'] = 'Los Angeles';
											$row['State'] = 'CA';
											$row['Zip'] = '';
											$row['Zip2'] = '';
											$row['EmailId'] = '';
											$row['Fax'] = '';
											$row['Activated'] = '';
											$row['Building'] = '';
											$row['MailCode'] = '';
											$row['Room'] = '';
											$row['Department'] = '';
											$row['Room'] = '';
											$row['AddressSelected'] = '';
											$row['ClassLevel'] = 4;
											$row['LastName'] = '';
											$row['FirstName'] = '';
											
											$row['Manager_ID'] = $_SESSION['mid'];
											$AdvanceAmount="";
											
										} 
										else
										{
											$rs = new CustomerDAO();
											$rs->getSingleRecord($_GET['id']);
											while($row1 = $rs->fetchSingleRecord()){
												$row = $row1;
												$ph = $row1['Phone'];
												$phone3 = substr($ph, 9,4);
												$phone2 = substr($ph, 5, 3);
												$phone1 = substr($ph, 1,3);
												$fax = $row1['Fax'];
												$fax3 = substr($fax, 9,4);
												$fax2 = substr($fax, 5, 3);
												$fax1 = substr($fax, 1,3);
											}
							
											$customer = new Customer();
											$enrolledPayments = $customer->getEnrolledPayments($_GET['id']);
											/*
											$temp=$row['Name'];
											$pos = strpos($temp,"*");
											if ($pos === false){

												$pieces = explode(" ", $temp);
												$row['FirstName']=$pieces[0]; // piece1
												$row['LastName']=$pieces[1];
												$row['LastName']=$row['LastName']." ".$pieces[2];// piece2
												$row['LastName']=$row['LastName']." ".$pieces[3];
												$row['LastName']=$row['LastName']." ".$pieces[4];
											}
											else
											{
												$pieces = explode("*", $temp);
												$row['FirstName']=$pieces[0]; // piece1
												$row['LastName']=$pieces[1];
											}
											 */
											
											if(isset($_POST['AdvanceAmt']))
											{
												$advance_amount = $_POST['AdvanceAmt'];
												if($advance_amount > 0)
												{
													$name=$_POST['Name'];												
													$rmbalance = $_POST['RmBalance'];
													$newbalance = $advance_amount + $rmbalance;
													echo "New Balance=".$newbalance."<br>";
													
													mysql_query("UPDATE Advance_Payment SET Balance = $newbalance WHERE Customer_Name = '$name'") or die ("An error has occurred in Advance Payment query");
												}
												
											}
										}

										$paytypelist= Array();
										$paytypetotal=0;
										$countinsttotal=0;
										$instsellist= Array(); //'','','','','','','','','','',''
										$AllSelected=0; 
										$Amtlist= Array();
										$check= Array();
										$check[0]='';
										$check[1]='';
										$check[2]='';
										$Duration='';
										$Balance=0;
										$IsNewAdvPayment='False';


										if($_GET['submit_mode'] == 'add')
										{
											$check[0]='checked="yes"';
										}
										else
										{
											$name=$row['Name'];
											// Retrieve Payment type from Enrolled_Payment_Types
											$sql1 = "SELECT Payment_Type_ID FROM Enrolled_Payment_Types where Customer_Name='$name' ";
											$result=mysql_query($sql1) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 

											while($row111 = mysql_fetch_array($result))
											{
												$paytypelist[$paytypetotal]=$row111[0];
												if($paytypelist[$paytypetotal]==1)
												{
													$check[0]='checked="yes"';
												}
												if($paytypelist[$paytypetotal]==2)
												{
													$check[1]='checked="yes"';
												}
												if($paytypelist[$paytypetotal]==3)
												{
													$check[2]='checked="yes"';
												}
												//commented 12-22	echo "type:: ".$row111[0];
												//commented 12-22	echo "<br />";
												$paytypetotal++;
											}
											
											// Retrieve Membership details
											$sql1 = "SELECT Duration,All_Selected,Instrument_Name, Amount FROM Membership where Customer_Name='$name' ";
											$result=mysql_query($sql1) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
					
											while($row222 = mysql_fetch_array($result))
											{
												$instsellist[$countinsttotal]=$row222['Instrument_Name'];
												$Amtlist[$countinsttotal]=$row222['Amount'];
												$AllSelected=$row222['All_Selected'];
												$Duration=$row222['Duration'];
												//commented 12-22	echo $row222['Duration'] . ", " . $row222['All_Selected']. ", " . $row222['Instrument_Name']. ", " . $row222['Amount'];
												//commented 12-22	echo "<br />";
												$countinsttotal++;
											}

											// Retrieve Balance from Advance_Payment
											$sql1 = "SELECT Balance, Advance_Amount_ID FROM Advance_Payment where Customer_Name='$name' ";
											$Bal=mysql_query($sql1) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ());
											if(mysql_num_rows($Bal)<1)
											{
												$IsNewAdvPayment = 'True';
											}
											$row333 = mysql_fetch_array($Bal); 
											$RmBalance=$row333[0];
											$AdPayId = $row333[1];
											//echo "BALANCE: ".$Balance." / ";
											//echo "RmBALANCE: ".$Balance." / ";
											//echo "AdPayId: ".$AdPayId."<br>";
											if($paytypelist[0]==3 || $paytypelist[1]==3 || $paytypelist[2]==3)
											{
												//commented 12-22	echo "Balance is:".$Balance;
												//	echo "<script type='text/javascript'> advancePayment(); </script>";
											}
											
											// Retrieve PO Internal # from Invoice
											$sql1 = "SELECT PO FROM Invoice where Name='$name' ";
											$PoNum=mysql_query($sql1) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
											$row444 = mysql_fetch_array($PoNum); 
											$PoNumber=$row444[0];
											
											// Retrieve Remaining # from Invoice
											/*$sql1 = "SELECT PO FROM Invoice where Name='$name' ";
											$RmBal=mysql_query($sql1) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
											$row555 = mysql_fetch_array($PoNum); 
											$RmBalance=$row555[0];*/
										}

									?>
	   
									<table border="0" cellpadding="5" cellspacing="0">
										<tr>
											<td class="t-top"><div class="title2"><?php echo (($_GET['submit_mode'] == 'add') ? 'Add ': 'Edit ');?> <?php echo $_GET['mode']." " ?>  Customer</div></td>
										</tr>
										<tr>
											<td class="t-mid">	<form id="myForm" name="myForm" method="post" action="editCustomer.php?id=<?=$_GET['id']?>&submit_mode=<?php echo $_GET['submit_mode'];?>">
													<input type="hidden" id="Manager_ID" name="Manager_ID" value="<? echo $_SESSION['mid'] ?>" />
										<table class="content" align="left" border = "0" style="margin-left:10px">
														<tr valign="top">
															<td colspan = "4"><div align="center" class="err" id="error" style="display:none"></div>
															<div align="center" class="alert" style="font-size:13;display:none" id="alert"></div></td>
														</tr>
														 
														<tr class="Trow">
                                                             <td>
                                             Customer Name: <?php echo (($_GET['submit_mode'] == 'add') ? "*" : '');?>
                                                              </td>
															<td>                                                            	                                                          
																<input id="cust_name" type="text" size="30" name="Name" <?php echo (($_GET['submit_mode'] == 'add') ? '': 'readonly="true"');?> class="text"  value="<?=$row['Name']?>">
                                                                &nbsp;&nbsp;
															</td>
                                                            <td >Department / Company: </td>
															<td><input type="text" size="30" name="Department" class="text"  value="<?=$row['Department']?>"></td>
														</tr>
														<tr class="Trow">
														  <td >First Name: <?php echo (($_GET['submit_mode'] == 'add') ? "*" : '');?></td>
														  <td><input type="text" size="30" name="FirstName" <?php echo (($_GET['submit_mode'] == 'add') ? '': 'readonly="true"');?> class="text"  value="<?=$row['FirstName']?>"></td>
                                                          
                                                           <td >Last Name: <?php echo (($_GET['submit_mode'] == 'add') ? "*" : '');?></td>
														  <td><input type="text" size="30" name="LastName" <?php echo (($_GET['submit_mode'] == 'add') ? '': 'readonly="true"');?> class="text"  value="<?=$row['LastName']?>"></td>
                                                          
														</tr>
										 
														<tr class="Trow">
															<td > School: </td>
															<td>
																<select id="School" class="text" name="School" style="height:25px;">
																	<option>Select School Name...</option>
																	<?
																	$sql_fs = "SELECT SchoolNo, SchoolName FROM Schools";
																	$result_fs=mysql_query($sql_fs) or die( "An error has occurred in query: " .mysql_error (). ":" .mysql_errno ()); 
																	while($row_fs = mysql_fetch_array($result_fs))
																	{
																		echo "<option value='".$row_fs['SchoolNo']."'";
																		echo ($row_fs['SchoolNo']==$row['School']? "selected=true":"").">"; 
																		echo $row_fs['SchoolName']."</option>";
																	}
																	?>
																</select>
															</td>
                                                            
                                                            <td >Customer Type:</td>
															<td>
																<select id="Type" class="text" name="Type" style="height:25px;">
																	<option value="On-Campus" <?echo (($row['Type']=="On-Campus")? "selected=true":""); ?>>USC Campus Users</option>
																	<option value="Off-Campus" <?echo (($row['Type']=="Off-Campus")? "selected=true":""); ?>>Off Campus Academic</option>
																	<option value="Industry" <?echo (($row['Type']=="Industry")? "selected=true":""); ?>>Industry</option>
																</select>
																
															</td>
                                                            
														</tr>																																			                                                        
														<?
														$sql = "SELECT Name, UserName FROM user where Advisor = '$name' and ( ActiveUser='active' OR ActiveUser IS NULL ) order by FirstName";
														$result = mysql_query($sql);
														//get the people from user
														//echo $sql;
														?>
                                                        
                                                        <tr class="Trow">
                                                            <td>Registered User: </td>
                                                            <td>
                                                             	<select onchange="loadAccountNum()" id="regUser" class="text" name="regUser" style="height:25px;">
																	<option value="select_one" >--Select a user--</option>
														<? if(mysql_num_rows($result)>0){
															while ($row222 = mysql_fetch_array($result)) {
                                                        ?>
                                                        <option  value="<?=$row222["UserName"];?>" ><?=$row222["Name"];?></option>
														<?	}
														}
                                                        ?>		</select> </td>
                                                        &emsp;
                                                        <td colspan="2">
                                                        <input size="25" type="text" value="" id="reg_user_acc_num" />
                                                        <input type="button" value="Update" onclick="updateAccountNum()" />
                                                         <input type="button" value="Update Grp" onclick="updateGroupAccountNum()" />
</td>
 														</tr>
                                                        
														 
														<tr class="Trow">
															<td>
																<input type="checkbox" name="AddressSelected" id="AddressSelected1" value="1" onClick="AddressSelected11()" <? if($row['AddressSelected'] ==1) {echo 'checked="yes"';} ?>>
																Contact Details: 
															</td>
															<td colspan="3">
																<fieldset>
																	<table>
																		<tr>
																			<td>Building:</td>
																			<td><input type="text" class="text" maxlength="15" size = "15"  name="Building" value='<?=$row['Building']?>'></td>
                                                                            <td>Room:</td>
																			<td><input type="text" class="text"  maxlength="15" size = "15"  name="Room"  value='<?=$row['Room']?>'></td>
																		</tr>
																		 
																		
                                                                        
																		<tr>
                                                                         <td>Street:</td>
																			<td><input type="text" size="30" name="Address1" class="text"  value="<?=$row['Address1']?>"></td>
                                                                            
																			<td></td>
																			<td><input type="text" size="30" name="Address2" class="text"  value="<?=$row['Address2']?>"></td>
																		</tr>
																		<tr>
																			<td>City <?php echo (($_GET['submit_mode'] == 'add') ? "*" : '');?>:</td>
                                                                            
																			<td><input type="text" size="30" name="City" class="text"  value="<?=$row['City']?>"></td>
                                                                            <td>State <?php echo (($_GET['submit_mode'] == 'add') ? "*" : '');?>:</td>
																			<td><input type="text" size="30" name="State" class="text"  value="<?=$row['State']?>"></td>
																		</tr>
                                                   <tr>
																			<td>Mail Code:</td>
																			<td><input type="text" class="text" maxlength="15"  size = "15"  name="MailCode" value='<?=$row['MailCode']?>'></td>
                                                                            
                                                                            <td>Zip <?php echo (($_GET['submit_mode'] == 'add') ? "*" : '');?>:</td>
																			<td><input type="text" class="text"  maxlength = "5" size = "10" name="Zip" style = "width: 10mm" onKeyup="autotab(this,document.myForm.Zip2)" value='<?=$row['Zip']?>'>-
																				<input type="text" class="text"  maxlength = "4" size = "10" name="Zip2" style = "width: 10mm" onKeyup="autotab(this,document.myForm.Phone1)" value='<?=$row['Zip2']?>'></td>
 																		</tr>                     
                                                                        
												 <tr>
                                                 	<td>Phone: </td>
															<td>
																<b>(</b>
																<input type="text" class="text"  maxlength = "3" size = "3" name="Phone1" style = "width: 10mm" onKeyup="autotab(this,document.myForm.Phone2)" value='<?=$phone1?>'>
																<b>)</b>
																<input class="text"  type="text" maxlength = "3" size = "3" name="Phone2" style = "width: 10mm" onKeyup="autotab(this,document.myForm.Phone3)"value ='<?=$phone2?>'>
																<b>-</b>
																<input  class="text"  type="text" maxlength = "4" size = "4" name="Phone3" style = "width: 10mm" value='<?=$phone3?>'>
																<input type="hidden" name = "Phone">
															</td>
                                                            
                                                            <td>Fax: </td>
															<td>
																<b>(</b>
																<input type="text" class="text"  maxlength = "3" size = "3" name="Fax1" style = "width: 10mm" onKeyup="autotab(this,document.myForm.Fax2)" value='<?=$fax1?>'>
																<b>)</b>
																<input class="text"  type="text" maxlength = "3" size = "3" name="Fax2" style = "width: 10mm" onKeyup="autotab(this,document.myForm.Fax3)"value ='<?=$fax2?>'>
																<b>-</b>
																<input  class="text"  type="text" maxlength = "4" size = "4" name="Fax3" style = "width: 10mm" value='<?=$fax3?>'>
																<input type="hidden" name = "Fax">
															</td>
                                                            
                                                 </tr>
                                                 <tr class="Trow">
															<td>Email-Id:</td>
															<td><input type="text" size="30"  class="text" name="EmailId" value="<?=$row['EmailId']?>"></td>
														</tr>
																	</table>
																</fieldset>
															</td>
														</tr>
														  
														<tr class="Trow">
															<td>Assistant Details:</td>
															<td colspan="3">
																<fieldset>
 																	<table>
																	<tr>
																		<td>Name: </td>
																		<td><input type="text" size="20"  class="text3" name="AssistantName1" value="<?=$row['AssistantName1']?>"> &nbsp;</td>
                                                                        <td>Email: </td>
																		<td><input type="text" size="20"  class="text3" name="AssistantEmail1" value="<?=$row['AssistantEmail1']?>"> &nbsp;</td> 
                                                                        <td>Phone: </td>
																		<td><input type="text" size="20"  class="text3" name="AssistantPhone1" value="<?=$row['AssistantPhone1']?>"></td>
																	</tr>																 																 
																</table>
																</fieldset>
																 
															</td>
														</tr>
														
														<!--
														<?
															if ($_SESSION['ClassLevel']==1 || $_SESSION['ClassLevel']==2)
															{
														?>
														<tr class="Trow">
															<td>Class:</td>
															<td>
																<select  name="ClassLevel" id="ClassLevel" value="<?=$row['EmailId']?>">
																<?
																	if($row['ClassLevel']=="")
																	{
																		$row['ClassLevel']=4;
																	}
																	if($row['ClassLevel']==1 || $row['ClassLevel']==2)
																	{
																?>
																<option value="2" selected="selected">Admin</option>
																<?
																	}
																	else
																	{
																?>
																<option value="2">Admin</option>
																<?
																	}

																	if($row['ClassLevel']==3)
																	{
																?>
																<option value="3" selected="selected">Super User</option>
																<?
																	}
																	else
																	{
																?>
																<option value="3">Super User</option>
																<?
																	}

																	if($row['ClassLevel']==4)
																	{
																?>
																<option value="4" selected="selected">User</option>
																<?
																	}
																	else
																	{
																?>
																<option value="4">User</option>
																<?
																	}
														
																?>
																</select>
															</td>
														</tr>
														<?
															}
														?>
														-->
														<tr class="Trow">
															<td>Payment Types</td>
															<!-- <td><?=$enrolledPayments?></td>  --> 
															<td colspan="3">
																<input type="checkbox" name="Payment[]" id="Payment" value="Regular" <? echo $check[0]; ?> />&nbsp; Regular
															 <input type="checkbox" name="Payment[]" id="Payment" value="Membership" <? echo $check[1]; ?> onClick="membership()" onChange="membership()"/>&nbsp; Membership	
															 
														 
																<input type="checkbox" name="Payment[]" id="Payment" value="AdvancePayment" onClick="advancePayment()" onChange="advancePayment()" <? echo $check[2]; ?> />&nbsp; Advance Payment
															</td>
														</tr>

													 
														<input type="hidden" name = "HiddenInstSelected">
														<input type="hidden" name = "Add1">
														<input type="hidden" name = "AddAll">
 
														<tr class="Trow">
															<td>Activated: <?php echo (($_GET['submit_mode'] == 'add') ? "*" : '');?></td>
															<td colspan="3">
																<input type="radio" name="Activated" value="1" checked = "checked">Current
																<input type="radio" name="Activated" value="0">Archived
															</td>
														</tr>

														<!-- hiiden link to addcustomer()-->
													<!--	<tr>
															<td></td>
														<!-- 	<td>
																<a href = "javascript: tp()">..</a>
															</td> 
														</tr> -->
													</table>
													 
												</form>
											</td>
										</tr>
										<tr>
											<td class="t-botcustomer"><a href = "javascript: validate()"><?php echo (($_GET['submit_mode'] == 'add') ? 'Add': 'Modify');?> Customer</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                            
                                            <a href= <?php echo (($_GET['mode'] == 'Archived') ? "archived_customers.php" : 'current_customers.php');?> >Return</a> <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<div class="clr"></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<? if($paytypelist[0]==3 || $paytypelist[1]==3 || $paytypelist[2]==3)
	{
		//echo "Balancee is:".$Balance;
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


var radioActivated = document.forms['myForm'].elements['Activated'];
<? if ($_GET['submit_mode'] == 'add') { ?>
	 
		radioActivated[0].checked = true;
<? }
	else {
		if($row['Activated'] == 1)
		{
		?>
			radioActivated[0].checked = true;
		<?}
		else
		{
		?>
			radioActivated[1].checked = true;
		<?}
	
	}
	
?>

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

function validate()
{
	if(!confirm("Are you sure you want to proceed?"))  return;
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
	
	var fax1 = theform.Fax1.value;
	var fax2 = theform.Fax2.value;
	var fax3 = theform.Fax3.value;
	
	fax = "("+fax1+")"+fax2+"-"+fax3;
	document.myForm.Fax.value = fax;

 	if(phone1!='')
	{
		phone = "("+phone1+")"+phone2+"-"+phone3;
	}
	
//	var membershipAmt=theform.MembershipAmt.value;
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
 
	/* if(document.myForm.Payment[2].checked==true)
	{
 		var advpayment_amount = theform.AdvanceAmt.value;
 		if(advpayment_amount < 0)
		{
			error += "<br>Invalid amount of advance payment";
		}
	} */
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
		
		
		document.myForm.Fax.value = fax;

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
	//var divtext="<td></td><tr class='Trow' id='a1'><td></td><td>1</td></tr>";
	//divtext+="<tr class='Trow' id='a2'><td></td><td>2</td></tr>";
	//divtext+="<tr class='Trow' id='a3'><td></td><td>3</td></tr>";

	var AdvanceAmt="<td></td>";
	AdvanceAmt+="<td class='hide' id='Advancetd1'>&nbsp;&nbsp;&nbsp; Amount to add: &nbsp; &nbsp; &nbsp;";
	AdvanceAmt+="<input  class='texthidden'  type='text' maxlength = '10' size = '10' name='AdvanceAmt' id='AdvanceAmt' style = 'width: 20mm'"; 
	AdvanceAmt+="value='<?=$Balance?>'><br>";
	
	AdvanceAmt+="&nbsp;&nbsp;&nbsp; PO Internal #: "; 
	AdvanceAmt+="<input  class='texthidden'  type='text' maxlength = '10' size = '10' name='PoInternal' id='PoInternal' style = 'width: 20mm'"; 
	AdvanceAmt+="value='<?=$PoNumber?>'><br>";
	
	AdvanceAmt+="&nbsp;&nbsp;&nbsp; Remaining Balance: "; 
	//AdvanceAmt+="<input  class='texthidden'  type='text' maxlength = '10' size = '10' name='AdvanceAmt' id='RmBalance' style = 'width: 20mm'"; 
	//AdvanceAmt+="value='<?=$RmBalance?>'><br>";
	AdvanceAmt+="<span  class='texthidden'  type='text' maxlength = '10' size = '10' name='RmBalance' id='RmBalance' style = 'width: 20mm'>"; 
	AdvanceAmt+="<?=$RmBalance?><br>";
	AdvanceAmt+="<input type='hidden' name = 'RmBalance' value='<?=$RmBalance?>'/>";
	AdvanceAmt+="<input type='hidden' name = 'IsNewAdvPayment' value='<?=$IsNewAdvPayment?>'/>";
	
	AdvanceAmt+="</td>";
	

	if(document.myForm.Payment[2].checked==true)
	{
		document.getElementById("AdvanceAmtRow").innerHTML=AdvanceAmt;
	
		document.getElementById("Advancetd1").style.visibility="visible";
		document.getElementById("AdvanceAmt").style.visibility="visible";
		document.getElementById("PoInternal").style.visibility="visible";
		document.getElementById("RmBalance").style.visibility="visible";
	
	}
	else
		if(document.myForm.Payment[2].checked==false)
	{
		document.getElementById("AdvanceAmtRow").innerHTML="";

		document.getElementById("Advancetd1").style.visibility="hidden";
		document.getElementById("AdvanceAmt").style.visibility="hidden";
		document.getElementById("PoInternal").style.visibility="hidden";
		document.getElementById("RmBalance").style.visibility="hidden";
	
	}

}
advancePayment();


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

function addCustomer()
{
	var temp;
	var temp1;
	var count;

	<? $advamt=$_POST['DurationList']; ?>
	<? $InstSelected=$_POST['InstrumentList']; ?>
	temp="<?=$InstSelected?>";
	
	<?	$PaymenttypeSelected = $_POST['Payment'];  ?> 
	<?	$countcheckbox = count($PaymenttypeSelected); ?>

	// Call respective Insertinto advancepayment or membership

		insertintoEnrolledPaymentPype();
	<?
		for ($i=0;$i<$countcheckbox ; $i++)
		{
			if ($PaymenttypeSelected[$i]=='Regular')
			{	
	?>
			// alert("Regular selected");
	<?
			}

			if ($PaymenttypeSelected[$i]=='Membership')
			{	
	?>
			//	alert("membership selected");
				insertintomembership()
	<?
			}

			if ($PaymenttypeSelected[$i]=='AdvancePayment')
			{	
	?>	
				//alert("AdvancePayment selected");
				insertintoadvancepayment();
	<?
			}

				
		}
	?>
}


function tp()
{
//echo "inoiceno-".$invoiceno;
	//Declare retrieving data


}

function insertintomembership()
{ 
	var instlist = new Array();
	var amtlist = new Array();
	var i;
	var k;
	var durationSelected;
	var temp;


	// retrieve values
	<? $custname=$_POST['Name']; ?>
	<? $dur=$_POST['DurationList']; ?>
	<? $memAmt=$_POST['MembershipAmt']; ?>
	<? $instSelected=$_POST['InstrumentList']; ?>
	<? $TotalInstSelected=$_POST['HiddenInstSelected']; ?>

	<? $AddAnotherInstrumentOptionSelected=$_POST['Add1']; ?>
	<? $AddAllInstrumentOptionSelected=$_POST['AddAll']; ?>

	AddAnotherInstrumentOptionSelected="<?=$AddAnotherInstrumentOptionSelected?>";
	AddAllInstrumentOptionSelected="<?=$AddAllInstrumentOptionSelected?>";

//	alert(" add1/all: "+AddAnotherInstrumentOptionSelected+", "+AddAllInstrumentOptionSelected);

	temp="<?=$custname?>";
//	alert("post name value "+temp);
	temp="<?=$dur?>";
//	alert("post Dur value "+temp);
	temp="<?=$memAmt?>";
//	alert("post memAmt value "+temp);
	temp="<?=$instSelected?>";
//	alert("post InstSel value "+temp);
	temp="<?=$TotalInstSelected?>";
//	alert("Total InstSelected value "+temp);



	// Retrieve Cust_ID from Name
	<? $sql = "SELECT Customer_ID FROM Customer where Name='$custname' ";?>
	<? $LastID=mysql_query($sql) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); ?>
	<? $row = mysql_fetch_array($LastID); ?>
	<? $custid=$row[0];?>

	// Retrieve Inst_ID from Name
	<? $sql = "SELECT InstrumentNo FROM instrument where InstrumentName='$instSelected' ";?>
	<? $LastID=mysql_query($sql) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); ?>
	<? $row = mysql_fetch_array($LastID); ?>
	<? $instid=$row[0];?>
	


	// insert into database either 1/More instruments OR all instruments
	
<?	if($AddAllInstrumentOptionSelected==1) 
	{
	//	alert("add all");
		 $query = "INSERT INTO Membership (Customer_ID,Customer_Name, Duration, All_Selected, Instrument_ID, Instrument_Name, Amount)"; 
		 $query.=" VALUES ('$custid','$custname','$dur',1,'99','N','$memAmt')";  
			mysql_query($query) or die( "An error has occurred in query1: ");  
	
	}
	else
	{
		if($AddAnotherInstrumentOptionSelected==1)
		{
		//	alert("add l");
		
			 $query = "INSERT INTO Membership (Customer_ID,Customer_Name, Duration, All_Selected, Instrument_ID, Instrument_Name, Amount)"; 
			 $query.=" VALUES ('$custid','$custname','$dur',0,'instid','$instSelected','$memAmt')";  
			 mysql_query($query) or die( "An error has occurred in query1: "); 
		


			for ($i=1;$i<=$TotalInstSelected ; $i++)
		{

			$k1='MembershipAdditionalAmt'.$i;
			$k2='InstrumentList'.$i;
			$memAmt=$_POST[$k1]; 
			$instSelected=$_POST[$k2]; 
			
			// Retrieve Inst_ID from Name
			$sql = "SELECT InstrumentNo FROM instrument where InstrumentName='$instSelected' ";
			$LastID=mysql_query($sql) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
			$row = mysql_fetch_array($LastID); 
			$instid=$row[0];
					
			$query = "INSERT INTO Membership (Customer_ID,Customer_Name, Duration, All_Selected, Instrument_ID, Instrument_Name, Amount)"; 
			$query.=" VALUES ('$custid','$custname','$dur',0,'instid','$instSelected','$memAmt')";  
			mysql_query($query) or die( "An error has occurred in query1: ");  
	
		}
		
		}
	}
?>
}

function insertintoadvancepayment()
{
	var temp;
	alert("in advance payment");

	//Retrieve values from $_POST
	<? $advamt=$_POST['AdvanceAmt']; ?>
	<? $custname=$_POST['Name']; ?>

	temp="<?=$custname?>";
	//alert("post name value "+temp);


	//<? $LastCustId= mysql_insert_id(); ?>

	// Retrieve name from ID
	<? $sql = "SELECT Name FROM Customer where Customer_ID=50";?>
	<?	$name=mysql_query($sql) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); ?>
	<? $row = mysql_fetch_array($name); ?>
	var whatever="<?=$row[0]?>";
	//alert("Name"+whatever);

	// Retrieve ID from Name
	<? $sql = "SELECT Customer_ID FROM Customer where Name='$custname' ";?>
	<? $LastID=mysql_query($sql) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); ?>
	<? $row = mysql_fetch_array($LastID); ?>
	<? $custidd=$row[0];?>

	var idd="<?=$custidd?>";
	//alert("ID :"+idd);


	// Insert into Advance Payment table
	<?
		if ($mode=='Add')
		{
			$query = "INSERT INTO Advance_Payment (Customer_ID,Customer_Name,Balance) VALUES ('$custidd','$custname','$advamt')";
			mysql_query($query) or die( "An error has occurred in query1: "); 
		}
		
	?>
}

function insertintoEnrolledPaymentPype()
{
	//alert ("in enrolled tpye");
	<? $custname=$_POST['Name']; ?>
	<?	$PaymenttypeSelected = $_POST['Payment'];  ?> 
	<?	$countcheckbox = count($PaymenttypeSelected); ?>


	// Retrieve ID from Name
	<? $sql = "SELECT Customer_ID FROM Customer where Name='$custname' ";?>
	<? $LastID=mysql_query($sql) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); ?>
	<? $row = mysql_fetch_array($LastID); ?>
	<? $custidd=$row[0];?>
	<?
		for ($i=0;$i<$countcheckbox ; $i++)
		{
			if ($PaymenttypeSelected[$i]=='Regular')
			{
				$query = "INSERT INTO Enrolled_Payment_Types (Customer_ID,Customer_Name,Payment_Type_ID) VALUES ('$custidd','$custname',1)";  
				mysql_query($query) or die( "An error has occurred in query1: ");  
			}
			if ($PaymenttypeSelected[$i]=='Membership')
			{
				$query = "INSERT INTO Enrolled_Payment_Types (Customer_ID,Customer_Name,Payment_Type_ID) VALUES ('$custidd','$custname',2)";  
				mysql_query($query) or die( "An error has occurred in query1: ");   
			}
			if ($PaymenttypeSelected[$i]=='AdvancePayment')
			{
				$query = "INSERT INTO Enrolled_Payment_Types (Customer_ID,Customer_Name,Payment_Type_ID) VALUES ('$custidd','$custname',3)";  
				mysql_query($query) or die( "An error has occurred in query1: ");  
			}

			
		}

	?>
}

function AddressSelected11()
{
	if (document.getElementById("AddressSelected2").checked==true)
	{
	
		if(!confirm("US Mail Address will be De-Selected, Continue ?")) 
		{
			document.getElementById("AddressSelected1").checked=false;
			return;
		}
		document.getElementById("AddressSelected2").checked=false;
	}
	
}
function AddressSelected22()
{
	if (document.getElementById("AddressSelected1").checked==true)
	{
	
		if(!confirm("Campus Address will be De-Selected, Continue ?")) 
		{
			document.getElementById("AddressSelected2").checked=false;
			return;
		}
		document.getElementById("AddressSelected1").checked=false;
	}
}
</script>
