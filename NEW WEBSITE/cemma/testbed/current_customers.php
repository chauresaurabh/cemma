<?
include_once('constants.php');
include_once(DOCUMENT_ROOT."includes/database.php");
include_once(DOCUMENT_ROOT."includes/checklogin.php");
include_once(DOCUMENT_ROOT."includes/checkadmin.php");
if($class != 1 || $ClassLevel==3 || $ClassLevel==4){
	//	header('Location: login.php');
}
include (DOCUMENT_ROOT.'tpl/header.php');

include_once("includes/action.php");
include_once(DOCUMENT_ROOT."includes/buildViewComponent.class.php");

?>

<script type="text/javascript">
		var daoClassName = "CustomerDAO";	
	</script>
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
										 Manage Current Customers
									</h2> 
                                 
									<!-- <input type="hidden" name = "o" id = "o" value = "<?=$_POST['o']?>">
									<input type = "hidden" name="orderby" id = "orderby" value = "<?=$_POST['orderby']?>"> -->
									<? //Check if user has asked to remove a record
									$msg = '';
									if(isset($_GET['action']) && $_GET['action'] == 3){
										$rm = new CustomerDAO();
										$rm->remove($_GET['id']);
										$msg = "Customer has been removed successfully";
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
                                            	<td align="center"><b> Search by Last Name </b></td>
                                            </tr>
											<tr>
												<td>
													<table width="90%" border="0" cellpadding="5" cellspacing="0">
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
														$deleteFlag = $_GET['deleteCustomer'];
														$customerId = $_GET['id'];
														if($deleteFlag==1)
														{
														$sql13 = "DELETE from Customer where Customer_ID=".$customerId;
														mysql_query($sql13) or die("An error has occurred in query11: " .mysql_error (). ":" .mysql_errno ());	
															echo "Customer deleted";
														}		
																$sql13 = "SELECT * FROM Customer where Activated = 1 AND ( LastName like '".$usersa."%' OR LastName like '".$usersb."%' ) order by LastName ";
																$values=mysql_query($sql13) or die("An error has occurred in query11: " .mysql_error (). ":" .mysql_errno ());
																$totalRows = mysql_num_rows ( $values  )
																?>
   									
																	<div class="title"> 
                                                                
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
                                                            
                                                            
                                                            <br />
                                                            <br />
                                                           <a href="javascript: EmailAll()">Email All &nbsp;</a>
                                                           <a href="javascript: EmailInstr()">Email Instrument List &nbsp;</a>
                <span style="margin-left:60%"> <? echo "Total Records ". $totalRows ?>	</span>
                                                             	                                                                   </div>
																	<div class="details"><?#$rs->getRecordsBar()?></div>
																	<div class="pagin"><?#$rs->getPageNav()?></div>
																</td>
															</tr>
															<tr>
																<td class="t-mid">
																	<table align="center" cellpadding="0" cellspacing="0"
																		border="0" class="Tcontent" width="100%">
																		<tbody>
																		 <tr bgcolor="#F4F4F4" align="center" class="Ttitle">
																				<td width="30">No</td>
 									<td width="50">Name</td>

										<td width="200" >Email</td>
				 
																				<td width="55">Edit</td>
																				<td width="55">Delete Customer</td>
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
																			else{		// There are some records
																				while($row = mysql_fetch_array($values))
																				{
																					$temp=$row['Name'];
																					#echo "god ".$temp;
																					if ($currentRowNum%2==0) {
																						?>
																			<tr class="TrowAlt"
																				id="datarow<? echo $currentRowNum; ?>">
																				<? } else { ?>
																			
																			
																			<tr class="Trow" id="datarow<? echo $currentRowNum; ?>">
																				<? }?>
																				<td align="center" valign="top"><?=$currentRowNum?>
																				</td>
																				<td align="center" valign="top"
																					id="usertd<?echo $currentRowNum; ?>">
																					<?=$row['LastName'].", ".$row['FirstName']?>
																				</td>
																				
                                                                                <td align="center" valign="top" >
																					<?=$row['EmailId']?>
																				</td>
                                                                                
																				<td align="center" valign="top">
                                                                                <? if($row['UserName']!='John'){?>
                                                                                <a
																					href="editCustomer.php?mode=Current&id=<?=$row['Customer_ID']?>">
                                                                                    <? }?>
																						<img src="images/edit_icon.png" alt="Edit"
																						width="13" height="13" border="0" class="tableimg" />
                                                                                <? if($row['UserName']!='John'){?>
																				</a>
                                                                                <? }?>
																				</td>
																				<td align="center" valign="top">
                                                                                <? if($row['UserName']!='John'){?>
  <a href="#" onclick="deleteCustomer(<?=$row['Customer_ID']?> , '<?=$row['Name']?>' )" />
                                                                                <? }?>
                                                                                    <img
																						src="images/trash_icon.gif" alt="Remove" width="10" border="0" />
                                                                                <? if($row['UserName']!='John'){?>
                                                                                </a>
                                                                                <? } ?>
																				</td>
																			</tr>
																			<?
																			$currentRowNum++;
																				}
																			}
																			?>
																		</tbody>
																	</table>
																</td>
															</tr>
															<tr>
																<!--</td>-->
																<td class="t-bot2">
																	<!-- <a href="add_instrument.php?id=&submit_mode=add">New Instrument</a>&nbsp;&nbsp; -->
																</td>
															</tr>
														</tbody>
													</table>
												</td>
												 
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

<script language='javascript'>

function EmailAll(){
	window.open ('Email.php?all=1', 'newwindow', config='fullscreen=yes, toolbar=no, scrollbars=1, menubar=no,location=no, directories=no, status=no');
}

function EmailInstr(){
	window.open ('Email.php?all=2', 'newwindow', config='fullscreen=yes, toolbar=no, scrollbars=1, menubar=no,location=no, directories=no, status=no');
}

function deleteCustomer(customerId, usera){
			    
		    var res = usera.substring(0, 1);
  			var value = confirm("Are you sure you want to Delete this Customer?");
		if (value == true) {
			 window.location = "current_customers.php?deleteCustomer=1&id="+customerId+"&usersa="+res.toLowerCase()+"&usersb="+res;
 		}  
}

function redirect(usera) {
	window.location = "current_customers.php?usersa="+usera+"&usersb="+usera.toUpperCase();
}

</script>
<? include ('tpl/footer.php'); ?>