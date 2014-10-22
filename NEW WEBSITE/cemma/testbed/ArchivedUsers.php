<?
include_once('constants.php');
include_once(DOCUMENT_ROOT."includes/checklogin.php");
include_once(DOCUMENT_ROOT."includes/checkadmin.php");
if($class != 1 || $ClassLevel==3 || $ClassLevel==4){
	//header('Location: login.php');
}
include (DOCUMENT_ROOT.'tpl/header.php');

include_once("includes/instrument_action.php")
?>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td class="body" valign="top" align="center">
        	<? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?>
			<table border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td class="body_resize">
						<table border="0" cellpadding="0" cellspacing="0" align="left">
							<tr>
								<td>
									<h2 class="Our">
										 Archived Users
									</h2>
									<form action="instruments.php" method="post" name="myForm">
										<input type="hidden" name="o" id="o" value="<?=$_POST['o']?>">
										<input type="hidden" name="orderby" id="orderby" value="<?=$_POST['orderby']?>">
											<? //Check if user has asked to remove a record
											$msg = '';
											if(isset($_GET['action']) && $_GET['action'] == 3){
												$rm = new userDAO();
												$rm->remove($_GET['id']);
												$msg = "Instrument has been removed successfully";
											}
											?>
										<table width="100%" border="0" cellpadding="5" cellspacing="0">
											<tr valign="top">
												<td width="100%">
													<div align="center" class="err" id="error"
														style="display: none">Error Detected</div> <? if($msg != '')
														echo '<div align="center" class="alert" style="font-size:13; id="error1">'.$msg.'</div>';
														?>
													<div id="div1" style="display: none">
														<p>&nbsp;</p>
													</div>
												</td>
											</tr>
										</table>
										<table border="0" width="100%">
											
                                            <tr>
                                            	<td align="left"><b> Search by First Name </b></td>
                                            </tr>
                                            
                                            <tr>
												<td>
													<table width="65%" border="0" cellpadding="5" cellspacing="0">
														<tbody>
															<tr>
																<td class="t-top"><? 
																//Getting Instrument Details
																	
																//$rs = new userDAO();
																//$rs->getList(10,$_POST['orderby'],$_POST['o']);
																//$currentRowNum = $rs->getStartRecord()*1;

																$usersa= $_GET['usersa'];
																$usersb= $_GET['usersb'];
																if($usersa=='')
																{
																	$usersa="#";
																	$usersb="#";
																}else if($usersa=="ALL"){
																	$usersa='';	
																	$usersb='';
																}
																
																include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
																$sql13 = "SELECT UserName,LastName,Email, FirstName,FieldofInterest FROM user where ActiveUser='inactive'
 AND ( UserName like '".$usersa."%' OR UserName like '".$usersb."%' ) ORDER BY UserName";
																$values=mysql_query($sql13) or die("An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ());
																?>

																	<div class="title">Archived Users
    	 							<br />
                                <input type="button" value="A" onclick="redirect('a')"/>|
                               <input type="button" value="B" onclick="redirect('b')"/>|
                               <input type="button" value="C" onclick="redirect('c')"/>|
                               <input type="button" value="D" onclick="redirect('d')"/>|
                               <input type="button" value="E" onclick="redirect('e')"/>|
                               <input type="button" value="F" onclick="redirect('f')"/>|
                               <input type="button" value="G" onclick="redirect('g')"/>|
                               <input type="button" value="H" onclick="redirect('h')"/>|
                               <input type="button" value="I" onclick="redirect('i')"/>|
                               <input type="button" value="J" onclick="redirect('j')"/>|
                               <input type="button" value="K" onclick="redirect('k')"/>|
                               <input type="button" value="L" onclick="redirect('l')"/>|
                               <input type="button" value="M" onclick="redirect('m')"/>|
                               <input type="button" value="N" onclick="redirect('n')"/>|
                               <input type="button" value="O" onclick="redirect('o')"/>|
                               <input type="button" value="P" onclick="redirect('p')"/>|
                               <input type="button" value="Q" onclick="redirect('q')"/>|
                               <input type="button" value="R" onclick="redirect('r')"/>|
                               <input type="button" value="S" onclick="redirect('s')"/>|
                               <input type="button" value="T" onclick="redirect('t')"/>|
                               <input type="button" value="U" onclick="redirect('u')"/>|
                               <input type="button" value="V" onclick="redirect('v')"/>|
                               <input type="button" value="W" onclick="redirect('w')"/>|
                               <input type="button" value="X" onclick="redirect('x')"/>|
                               <input type="button" value="Y" onclick="redirect('y')"/>|
                               <input type="button" value="Z" onclick="redirect('z')"/>|
                               <input type="button" value="ALL" onclick="redirect('ALL')"/>
                               
									</div>
																	<div class="details"><?#$rs->getRecordsBar()?></div>
																	<div class="pagin"><?#$rs->getPageNav()?></div>

																	</div>
																</td>
															</tr>
															<tr>
																<td class="t-mid">

									  <?php if( mysql_num_rows($values)>0 ) { ?>
																	<table align="center" cellpadding="0" cellspacing="0"
																		border="0" class="Tcontent" width="100%">
																		<tbody>
																			<tr bgcolor="#F4F4F4" align="center" class="Ttitle">
																				<td width="30">No</td>
																				<td width="200" onClick="javascript:doAction(1, 1)">User
																					Name</td>
																				<!--        <td width="200"  onclick="javascript:doAction(1, 2)">Last Name</td>
					<td width="200"  onclick="javascript:doAction(1, 
2)">Email</td>
                    <td width="350" onClick="javascript:doAction(1, 3)">Field of Interest</td>
			-->

																				<td width="55">Edit</td>
																				<td width="55">Activate</td>

																				<td width="55">Delete User</td>
																			</tr>

																			<?php
																			$currentRowNum=1;
																			// If there are no records
																			$temp=0;
																			if($temp==1){

																				?>

																			<tr align="center">
																				<td colspan="7">No Records Found</td>
																			</tr>

																			<?php
																			}

																			else{

																				// There are some records

																				while($row = mysql_fetch_array($values))
																				{
																					$temp=$row['UserName'];
																					?>
																					<?if ($currentRowNum%2==0) {?>
																			<tr class="TrowAlt"
																				id="datarow<? echo $currentRowNum; ?>">

																				<? } else { ?>
																			
																			
																			<tr class="Trow"
																				id="datarow<? echo $currentRowNum; ?>">
																				<? }?>



																				<td align="center" valign="top"><?=$currentRowNum?>
																				</td>
																				<td align="center" valign="top"
																					id="usertd<?echo $currentRowNum; ?>"
																					onMouseOver="document.getElementById('txtHint').style.display='';document.getElementById
('UserDetails').style.display='none'; hover1(<? echo $currentRowNum.",'".$temp."'"; ?>)"
																					onmouseout=" this.style.color='#666666';this.style.border='0'; document.getElementById
('txtHint').style.display='none'; document.getElementById('UserDetails').style.display='';"><?=$row['UserName']?>
																				</td>
																				<!--         <td align="center" valign="top"><?=$row['LastName']?></td>
					<td align="center" valign="top"><?=$row['Email']?>
			
					</td>
                    <td align="center" valign="top"><?=$row['FieldofInterest']?></td>
			-->

																				<td align="center" valign="top"><a
																					href="EditArchivedUser.php?id=<?=$row['UserName']?>">
																						<img src="images/edit_icon.png" alt="Edit"
																						width="13" height="13" border="0" class="tableimg" />
																				</a>
																				</td>
																				<td align="center" valign="top"><a
																					href="ActivateArchivedUser.php?id=<?=$row['UserName']?>&usersa=<? echo $usersa; ?>&usersb=<? echo $usersb; ?>">
																						<img src="images/archive8.png" alt="Edit"
																						width="13" height="13" border="0" class="tableimg" />
																				</a>
																				</td>

																				<td align="center" valign="top"><a
																					href="RemoveArchivedUsers.php?id=<?=$row['UserName']?>&usersa=<? echo $usersa; ?>&usersb=<? echo $usersb; ?>"  onclick="return checkBeforeDelete('<?=$row['UserName']?>');">
																						<img src="images/trash_icon.gif" alt="Remove"
																						width="10" border="0" /> </a>
																				</td>
																			</tr>

																			<?
																			$currentRowNum++;
																				}

																					
																			}

																			?>

																		</tbody>
																	</table>
                                                                    <?php } ?>
																</td>
															</tr>
															<tr>
																</td>
																<td class="t-bot2">
																	<!--	 <a href="javascript:wopen()">New Instrument</a>&nbsp;&nbsp; 
 -->
																</td>
															</tr>
														</tbody>
													</table>
												</td>

												<td>
													<table>
														<tr>
															<div id="txtHint"
																style="background-color: white; position: fixed; top: 130px; right: 15px;"
																BGCOLOR='#FF00FF'></div>
															<div id="UserDetails"
																style="background-color: white; position: fixed; top: 300px; right: 55px;"
																BGCOLOR='#FF00FF'>
																<b><u>
                                                                <?php echo (($_GET['usersa'] != '') ? "Hover over Usernames to display details here" : '');?>
                                                                </u> </b>
															</div>
													
													</table>

													</form>
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
		</td>
	</tr>
</table>

<script language='javascript'>

function redirect(usera) {
	window.location = "ArchivedUsers.php?usersa="+usera+"&usersb="+usera.toUpperCase();
}

function showUser(temp1)
{
//alert("hi2");
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","GetCurrentUserDetails.php?username="+temp1,true);
xmlhttp.send();
}
/*
function ActivateArchivedUser(user1)
{
//alert("hi2");
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
 //   document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
 window.location="ArchivedUsers.php";
    }
  }
xmlhttp.open("GET","ActivateArchivedUser.php?username="+user1,true);
xmlhttp.send();
}
*/
function hover1(no,temp2)
{
//alert("hi");
document.getElementById("usertd"+no).style.color="blue";
document.getElementById("usertd"+no).style.border="thin solid #0000FF"; //0000FF";
document.getElementById("usertd"+no).style.bgColor="thin solid #B3E0FF"; //0000FF";
showUser(temp2);

}

function checkBeforeDelete(username){
		var value = confirm('Are you sure you want to delete account for User : ' + username);
		if(value == true ){
			return true;
		}else{
			return false;
		}
}

</script>
<? include ('tpl/footer.php'); ?>


