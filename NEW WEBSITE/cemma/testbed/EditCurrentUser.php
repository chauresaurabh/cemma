
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
 
	if($submit=='true')
	{		
		$prevent = $_POST['prevent'];
		$password=$_POST['password'];
		$LastName=$_POST['LastName'];
		$FirstName=$_POST['FirstName'];
		$Email=$_POST['Email'];
		$Telephone=$_POST['Telephone'];
		$Comments=$_POST['Comments'];
		$Advisor=$_POST['Advisor'];
		$GradYear=$_POST['GradYear'];
		$adminclass=$_POST['adminclass'];
		$UserClass=$_POST['UserClass'];
		$AccountNum = $_POST['AccountNum'];
		$uscid = $_POST['uscid'];
		
		$TotalTrainingHrs = $_POST['TotalTrainingHrs'];
		$UsedTrainingHrs = $_POST['UsedTrainingHrs'];

		if($username=='John')
		{
			$UserClass=1;
			$adminclass=1;
		}
		/*
		if ($adminclass=="")
		{
			$adminclass=2;
		}
		else
		{
			$adminclass=1;
		}
		*/
		if ($UserClass == 1 || $UserClass == 2 || $UserClass == 5)
		{
			$adminclass=1;
		}
		else
		{
			$adminclass=2;
		}
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
		$InstrumentName=$_POST['InstrumentName'];
		$countInstrumentName = count($InstrumentName);
		$permission = $_POST['Permission'];		

		include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
		$sql3 = "DELETE FROM instr_group WHERE Email='$Email'";  
		//mysql_query($sql3) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
		
		for ($i=0;$i<0 ; $i++)
		{ 
			//echo "pop".$InstrumentName[$i];
			$pieces = explode("_", $InstrumentName[$i]);
			$intruments[$i]=$pieces[0];
			$k=$pieces[1];

			//echo " instr-".$intruments[$i];
			$instrno=$intruments[$i];
			//	echo " name-".$InstrumentName[$i];

				$t1="yy".$k;
				$t2="mm".$k;
				$t3="dd".$k;
				//echo " yy-mm-dd ".$_POST[$t1]." ".$_POST[$t2]." ".$_POST[$t3];
				$yy=$_POST[$t1];
				$mm=$_POST[$t2];
				$dd=$_POST[$t3];
				$datetoput=$yy."-".$mm."-".$dd;
				
				include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
			$sql3 = "INSERT INTO instr_group (InstrNo,  Email , InstrSigned, Permission) VALUES ('$instrno', '$Email', '$datetoput', '$permission[$k]')";  
			#echo $permission[$k]."<br>";
			#echo $sql3."<br>";
			mysql_query($sql3) or die( "An error has occurred in query2: " .mysql_error (). ":" .mysql_errno ()); 
		}

		$Dept=$_POST['Dept'];
		include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
		$sql3 = "UPDATE user SET Passwd = '$password', Email='$Email',Class='$adminclass', FirstName='$FirstName', LastName='$LastName',Name = '".$FirstName." ".$LastName."', Telephone='$Telephone', Dept='$Dept', Advisor='$Advisor',GradYear='$GradYear', Position='$position',Prevent='$prevent', FieldofInterest ='$fieldofinteresttosave',UserClass='$UserClass',Comments='$Comments', AccountNum='$AccountNum', uscid='$uscid'  WHERE UserName = '$username'";
		
		#echo $sql3;
		mysql_query($sql3) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 

		
		
		echo "<center>You have successfully updated the User</center>";
		?>
		<script type="text/javascript">
		document.getElementById("alert").innerHTML = "User has been updated successfully";
		document.getElementById("alert").style.display = "";
		</script>
		<?
	}
?>
<style type="text/css">
 
</style>
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
		
//Retrieve current details
/*

$dbhost="db948.perfora.net";
$dbname="db210021972";
$dbusername="dbo210021972";
$dbpass="curu11i";

$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
$SelectedDB = mysql_select_db($dbname) or die ("Error in DBbb");
*/

	include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
	$sql1 = "select Passwd, Class, Email, FirstName, LastName, Telephone, Dept, Advisor, GradYear, GradTerm, Position, FieldofInterest, LastStatusUpdate, Comments, MemberSince,UserClass, AccountNum, Prevent, TotalTrainingHrs, UsedTrainingHrs , uscid   from user where UserName = '$username'";
	$result=mysql_query($sql1) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
	$row = mysql_fetch_array($result);
 
	//	echo $row222['Email']." ".$row222['FirstName']." ".$row222['LastName']." ".$row222['Telephone'];
	
	
//echo "ppppo".$row222['Email'];
		?>
	   
                 <table width="90%" border="0" cellpadding="5" cellspacing="0">
                    <tr>
                      <td class="t-top"><div class="title2" id="userDetailsId">User Details : <?=$username?></div></td>
                    </tr>
                    <tr>
                      <td class="t-mid"> 
                        <form id="myForm" name="myForm" method="post" action="EditCurrentUser.php?id=<?=$username?>&submit=true">
                        <input type="hidden" id="userDetailsIdHidden" value=<?=$username?> />

                        <input type="hidden" id="userEmailIdHidden" value=<?=$row['Email']?> />
						<input type="hidden" id="adminclass" name="adminclass" value=""/>
                        <input type="hidden" id="Manager_ID" name="Manager_ID" value=""/>
                          <table class="content" align="center" border = "0" style="margin-left:10px">
                        <!--    <tr valign="top">
								<td colspan = "2" width="100%"><div align="center" class="err" id="error" style="display:none"></div>
								<div align="center" class="alert" style="font-size:13;display:none" id="alert"></div></td>
							</tr> -->
							
							<tr class="Trow">
                                
                               <td >*Password:  </td>
                              <td>
                              <? if($_SESSION['ClassLevel']==1){?>
                              <input type="text" size="30" name="password" class="text"  value="<?=$row['Passwd']?>">
                              <? } else { ?>
                              <input readonly="readonly" type="password" size="30" name="password" class="text"  value="<?=$row['Passwd']?>" <? echo $disablePwdChange?> >
                              <? } ?>
							 </td>
                             
                             <td >&nbsp;</td>
                              <td> <? $prevent = $row['Prevent'];
							  if($prevent == 1) {
									$preventChecked = 'checked';
									$disablePwdChange = 'readonly';
								} else {
									$preventChecked = '';
									$disablePwdChange = '';
								}
							  if($_SESSION['ClassLevel']==1){?>
		&nbsp;&nbsp;<input type="checkbox" name="prevent" value="1" <? echo $preventChecked?>>Prevent from changing password
	<? }?></td>
     
                            </tr>
 
							<tr class="Trow">
                              <td>Last Name:  </td>
                        <td>
                        <? if($_SESSION['ClassLevel']==1){?> 
                        	<input type="text" size="30" style="font-weight:bold"  name="LastName" class="text"  value="<?=$row['LastName']?>">
                        <? } else {?>
                        	<input readonly type="text" size="30" style="font-weight:bold"  name="LastName" class="text"  value="<?=$row['LastName']?>">
                        <? } ?>
                        </td>
                         <td>Email:</td>
                              <td>
                              	<? if($_SESSION['ClassLevel']==1){?> 
                                	<input type="text" size="30" name="Email" class="text"  value="<?=$row['Email']?>">
                                <? } else {?>
                                	<input readonly="readonly" type="text" size="30" name="Email" class="text"  value="<?=$row['Email']?>">
                                <? } ?>
                              </td>
                            </tr>
 
							<tr class="Trow">
                             <td>First Name:  </td>
                              <td>
                              	<? if($_SESSION['ClassLevel']==1){?> 
                              		<input type="text" style="font-weight:bold" size="30" name="FirstName" class="text"  value="<?=$row['FirstName']?>">
                                <? } else {?>
                                	<input readonly="readonly" type="text" style="font-weight:bold" size="30" name="FirstName" class="text"  value="<?=$row['FirstName']?>">
                                <? } ?>
                              </td>
                              
                             
                              <td>Telephone: </td>
                              <td>
                              	<? if($_SESSION['ClassLevel']==1){?> 
                              		<input type="text" size="30" name="Telephone" class="text"  value="<?=$row['Telephone']?>">
                                <? } else {?>
                                	<input readonly="readonly" type="text" size="30" name="Telephone" class="text"  value="<?=$row['Telephone']?>">
                                <? } ?>
                              </td>
                            </tr>
							 
							<tr class="Trow">
                              <td>Department: </td>
                              <td><input type="text" style="background:#FFFFFF" size="30" name="Dept" class="text"  value="<?=$row['Dept']?>"></td>
                                <td>Advisor: </td>
                              <td>
                              <?
							  if($_SESSION['ClassLevel']==1){
							  	include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
								$sqlName = "select Name from Customer order by name";
								$resultName=mysql_query($sqlName) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ());
								?>
								
								<select  name="Advisor" id="Advisor">
								
								<?
								while($rowName = mysql_fetch_array($resultName))
								{
									if(strcmp($rowName['Name'], $row['Advisor'])==0){?>
										<option value="<?=$row['Advisor'];?>" selected><?=$row['Advisor'];?></option>
									<? } else { ?>
										<option value="<?=$rowName['Name'];?>"><?=$rowName['Name'];?></option>
								<? }
								
								}
								
							  } else {?>
                              	<input readonly="readonly" style="background:#EEEEEE" type="text" size="30" name="Advisor" id="Advisor" value="<?=$row['Advisor']?>" />
                              <? } ?>
								</select>
                              </td>
                            </tr>
 
							<tr class="Trow">
                              <td>Account Number: </td>
                              <td><input type="text" style="background:#FFFFFF" size="30" name="AccountNum" class="text"  value="<?=$row['AccountNum']?>"></td>
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
                                 
                            <? if($_SESSION['ClassLevel']==1){?> 
							  <input type="checkbox" name="fieldofinterest[]" id="fieldofinterest" <? echo $LifeScience; ?> value="Life Science" <? //echo $row['FieldofInterest']; ?> />&nbsp; Life Science
							  <input type="checkbox" name="fieldofinterest[]" id="fieldofinterest" <? echo $PhysicalScience; ?> value="Physical Science" <? //echo $row['FieldofInterest']; ?> />&nbsp;  Physical Science 
                            <? } else  {?>
                            	<input disabled type="checkbox" name="fieldofinterest[]" id="fieldofinterest" <? echo $LifeScience; ?> value="Life Science" <? //echo $row['FieldofInterest']; ?> />&nbsp; Life Science
							  <input disabled type="checkbox" name="fieldofinterest[]" id="fieldofinterest" <? echo $PhysicalScience; ?> value="Physical Science" <? //echo $row['FieldofInterest']; ?> />&nbsp;  Physical Science
                              <? if(strcmp($LifeScience,"checked")==0) {?>
                              <input type="hidden" name="fieldofinterest[]" id="fieldofinterest" value="Life Science" />
                              <? } 
							  if(strcmp($PhysicalScience,"checked")==0) {?>
                              	<input type="hidden" name="fieldofinterest[]" id="fieldofinterest" value="Physical Science" />
                              <? } ?>
                            <? } ?>
							  </td>    
                           <tr class="Trow">   
                               <td> USC ID: </td>
                                <td><input type="text" style="background:#FFFFFF" size="30" name="uscid" class="text"
                                  value="<?= $row['uscid']?>"></td>
                            </tr> 
							<tr class="Trow">
								<td rowspan="2">Position: </td>
									<td rowspan="2">
										<input type="radio" name="Position" id="pos_US" value="US">Undergraduate Student<br>
										<input type="radio" name="Position" id="pos_GS" value="GS">Graduate Student<br>
										<input type="radio" name="Position" id="pos_PD" value="PD">Post Doctor<br>
										<input type="radio" name="Position" id="pos_PI" value="PI">Principal Investigator<br>
										<?php 
											if($row['Position']=="US")		{
													echo "			<script>document.getElementById(\"pos_US\").checked=true;</script>";
												if($_SESSION['ClassLevel']!=1){
													echo "			<script>document.getElementById(\"pos_GS\").disabled=true;</script>";
													echo "			<script>document.getElementById(\"pos_PD\").disabled=true;</script>";
													echo "			<script>document.getElementById(\"pos_PI\").disabled=true;</script>";
												}
											}
											else if($row['Position']=="GS")	{	echo "			<script>document.getElementById(\"pos_GS\").checked=true;</script>";
												if($_SESSION['ClassLevel']!=1){
													echo "			<script>document.getElementById(\"pos_US\").disabled=true;</script>";
													echo "			<script>document.getElementById(\"pos_PD\").disabled=true;</script>";
													echo "			<script>document.getElementById(\"pos_PI\").disabled=true;</script>";
												}
											
											}
											else if($row['Position']=="PD")	{	echo "			<script>document.getElementById(\"pos_PD\").checked=true;</script>";
												if($_SESSION['ClassLevel']!=1){
													echo "			<script>document.getElementById(\"pos_GS\").disabled=true;</script>";
													echo "			<script>document.getElementById(\"pos_US\").disabled=true;</script>";
													echo "			<script>document.getElementById(\"pos_PI\").disabled=true;</script>";
												}
											}
											else if($row['Position']=="PI")	{	echo "			<script>document.getElementById(\"pos_PI\").checked=true;</script>";
												if($_SESSION['ClassLevel']!=1){
													echo "			<script>document.getElementById(\"pos_GS\").disabled=true;</script>";
													echo "			<script>document.getElementById(\"pos_PD\").disabled=true;</script>";
													echo "			<script>document.getElementById(\"pos_US\").disabled=true;</script>";
												}
											}
										?>
									</td>
                                    
                                      <td>User Access Rights:</td>
                              <td>
                              <? if($_SESSION['ClassLevel']==1){?> 
                              	<select  name="UserClass" id="UserClass">
                              <? } else {?>
                              	<select  disabled="disabled" style="background:#EEEEEE">
                              <? }?>
								<?
								if($row['UserClass']==NULL)
								{
									$row['UserClass']=4;
								}
								if ($_SESSION['ClassLevel']==1)
								{
									if($row['UserClass']==1)
									{
								?>
								<option value="1" selected="selected">Administrator</option>
								<?
									}
									else
									{
								?>
								<option value="1">Administrator</option>
								<?
									}
								}

								if($row['UserClass']==2)
								{
								?>
								<option value="2" selected="selected">Cemma Staff</option>
								<?
								}
								else
								{
								?>
								<option value="2">Cemma Staff</option>
								<?
								}

								if($row['UserClass']==3)
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

								if($row['UserClass']==4)
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
								if($row['UserClass']==5){
									?><option value="5" selected="selected">Lab/Class</option><?
								} else {
									?><option value="5">Lab/Class</option><?
								}
								?>

							  </select>
                              <? if($_SESSION['ClassLevel']!=1){?> 
                              	<input type="hidden" name="UserClass" id="UserClass" value="<?=$row['UserClass']?>"/>
                              <? } ?>
							  </td>
                            
                             </tr>

 							  <? if($row['Class']=='1') { $adminclass='checked'; }  ?>
 <!--User Class -->
                             <tr class="Trow">
                                
                            <td>Comments: </td>
							<td > 
                            	<p style="border-style:solid;border-width:1px">&nbsp; <? echo $row['Comments']?> </p>
                                <input type="button"  value="Add Comment" onclick="openComments()" /> 
                               </td>
                             </tr>

<!--User Class End-->
 <tr class="Trow">    <td colspan="4"> 
   	 <input type="button"  value="Add Training Time" onclick="addTrainingHours()" /> 
 
                    </td>                          </tr>

							<tr class="Trow">
 
							<td colspan="3"> 
                                 <fieldset>
                            	<legend>Training Requests</legend>
						 	<table cellpadding="10">
								<tr>
                                	<th> Instrument</th>
                             		<th> Remaining Hrs</th>
                                    <th> Total Hrs</th>
                                    <th> Staff</th>
                                    <th> Date</th>
                                </tr>
						  <?
							include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
							$sql1 = "select * from instr_group where Email ='".$row['Email']."' and TotalTrainingHrs > 0 ";
							$result=mysql_query($sql1) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
 							$i=0;
							while($row3 = mysql_fetch_array($result))
							{
								$instrnos[$i]=$row3['InstrNo'];
								$instrsigned[$i]=$row3['InstrSigned'];
								$permission[$i] = $row3['Permission'];
								
								$totalHrs[$i] = $row3['TotalTrainingHrs'];
								$usedHrs[$i] = $row3['UsedTrainingHrs'];
								
								
								
							//	echo "N".$instrnos[$i];
							//	echo 'lol';
								$i++;
							}
							include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
							$sql1 = "select DATE_FORMAT(requested_date, '%m-%d-%Y') as requested_date , personLoggedIn, TotalTrainingHrs, UsedTrainingHrs, InstrumentNo,  InstrumentName from instrument , instr_group where InstrNo = InstrumentNo and Email ='".$row['Email']."' ";
							$result=mysql_query($sql1) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
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
                          	
                            	<tr>
                                     <td > <? echo $row2['InstrumentName']    ?>  </td>	
                                     <td align="center"> <? echo  $row2['UsedTrainingHrs']    ?>  </td>	
                                     <td align="center"> <? echo $row2['TotalTrainingHrs']   ?>  </td>	
                                    <td align="center"> <? echo $row2['personLoggedIn']   ?>  </td>	
                                    <td align="center"> <? echo $row2['requested_date']   ?>  </td>	
                                </tr>							 
							
						<?
 							}
						?>

 								 </table>
                                 </fieldset>
                                
                                
                                <!--------  FIELDSET FOR APPROVED INSTRUMENTS ENDS HERE ------->
                                
                            <fieldset>
                            	<legend>Approved Instruments</legend>
						 	<table cellpadding="10">

						  <?
							include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
							$sql1 = "select * from instr_group where Email ='".$row['Email']."'";
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
                                            echo "Peak & Off-peak time&nbsp;&nbsp;&nbsp;&nbsp;";
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
                              
                         	<td>
                            
                                  <fieldset>
                            			<legend>Training Requested</legend>
                                        
                                         <?
							include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
							$sql1 = "select InstrumentName ,Email from INSTRUMENT_REQUEST_STATUS where Email ='".$row['Email']."'";
							$result=mysql_query($sql1) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
 							while($row55 = mysql_fetch_array($result))
							{
								echo $row55['InstrumentName']."<br>";
							}
							
							?>
                                </fieldset>
                    <input type="button" value="Request Training" onclick="requestTraining()" />

                            </td>
                            </tr>
 							 
		<!-- hiiden link to addcustomer()--> 
                          </table>
                          <br />
                          <br />
                        </form>
                      </td>
                  
                    </tr>
                    
                    <tr>
                      <td class="t-bot2"> 
                    <a href = "javascript:submitclicked()">Modify User</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="currentusers.php">Return</a></td>
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


function setInstrDate(obj, num) {
	var d = new Date();
	var m = d.getMonth();
	m+=1;
	if(m<10)
		m="0"+m;
	var y = d.getFullYear();
	var day = d.getDate();
	if(day<10)
		day="0"+day;
	if (obj.checked == true) {;
		document.getElementById("yy"+num).value = y;
		document.getElementById("mm"+num).value = m;
		document.getElementById("dd"+num).value = day;
	}
	else {
		document.getElementById("yy"+num).value = "";
		document.getElementById("mm"+num).value = "";
		document.getElementById("dd"+num).value = "";
	}
}

 function openComments()
{
 	var userId = document.getElementById('userDetailsIdHidden').value;
  	var popup = window.open("AddUserComments.php?userId="+userId, "_blank", "width=500, height=500") ;
}
 
function addInstruments(){
	 	var userId = document.getElementById('userEmailIdHidden').value;
	  	var popup = window.open("AddInstruments.php?userId="+userId, "_blank", "scrollbars=1, width=500, height=500") ;
}
function addTrainingHours(){
	var personLoggedIn = '<?=$_SESSION['login']?>'; 
 	var username = document.getElementById('userDetailsIdHidden').value;
	var email = '<?=$row['Email']?>';
	var popup = window.open("UpdateTrainingTime.php?email="+email+"&username="+username+"&personLoggedIn="+personLoggedIn, "_blank", "scrollbars=1, width=500, height=500") ;

}

function requestTraining(){
		 	var email = document.getElementById('userEmailIdHidden').value;
		 	var username = document.getElementById('userDetailsIdHidden').value;
 		  	var popup = window.open("UserTraining.php?email="+email+"&username="+username, "_blank", "scrollbars=1, width=500, height=500") ;
}
</script>
