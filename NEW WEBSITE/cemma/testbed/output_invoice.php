<?
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/database.php");
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");

	//Integrated output_invoice.php and generatedinvoice.php
	
	//Common
	$name = $_GET['name'];	
	$frommonth = $_GET['frommonth'];
	$tomonth = $_GET['tomonth'];
	$fromyear = $_GET['fromyear'];
	$toyear = $_GET['toyear'];
	$fromdate = "$fromyear-$frommonth-01";
	$rowcounter = 0;
	
	$fromdate = "$fromyear-$frommonth-01";
	$todate = "$toyear-$tomonth-31";

	$checked_numbers = "";

	$sql = "SELECT * FROM Customer where Name='$name' AND Manager_ID = ".$_SESSION['mid'];
	$result = mysql_query($sql) or die ("error in selecting customer");
	$num_rows = mysql_num_rows($result);

	$checkbox = array();
	$checkbox = $_POST['checkbox'];
	$managername=$_SESSION['login'];

	while($row = mysql_fetch_array($result))
	{
		$address1 = $row['Address1'];
		$address2 = $row['Address2'];
		$city = $row['City'];	
		$state = $row['State'];
		$zip = $row['Zip'];
		$phone = $row['Phone'];
		$fax = $row['Fax'];
		$AddressSelected = $row['AddressSelected'];
		$Building = $row['Building'];
		$MailCode = $row['MailCode'];
		$Room = $row['Room'];	 
	}
	
	$total = 0;
	$curryear = Date("Y"); //For current year
	$currmonth = Date("M"); // For current month
	$numCurrMonth = Date("m");

	if ($numCurrMonth>=1 && $numCurrMonth<=4)
	{ 
		$CurrDuration='A';	
	}
	else if ($numCurrMonth>=5 && $numCurrMonth<=8)
	{
		$CurrDuration='B';	
	}
	else if ($numCurrMonth>=9 && $numCurrMonth<=12)
	{
		$CurrDuration='C';	
	}

	if($numCurrMonth>6)	$curryear = $curryear+1;

	if ($managername=='John')
	{
		//	echo " in John-";
		$qry = "SELECT Invoiceno FROM Invoice where Year = '$curryear' AND ( Manager_Name ='John' OR ISNULL(Manager_Name))  AND  Manager_ID = ".$_SESSION['mid']." ORDER BY  Gdate DESC LIMIT 1";
		$result = mysql_query($qry) or die ("error in selecting from Invoice");
		$num_rows = mysql_num_rows($result);
	}
	else
	{
		if($managername=='Alicia')
		{
			//	echo "in Alicia-";
			$qry = "SELECT Invoiceno FROM Invoice where Year = '$curryear' AND Manager_Name = '$managername' AND Manager_ID = ".$_SESSION['mid']." ORDER BY  Gdate DESC LIMIT 1";
			$result = mysql_query($qry) or die ("error in selecting from Invoice");
			$num_rows = mysql_num_rows($result);
		}
	}

	if($num_rows == 0){
		if($managername=='John'){
			$invoiceno = 1;
		}
		else if($managername=='Alicia'){
			$invoiceno = 501;
		}
	}
	else{
		while($row = mysql_fetch_array($result)){
			$invoiceno = $row['Invoiceno'] + 1;
		}
	}
	
	$paytypelist= Array();
	$payment_type = 0;
	$BalanceArray= Array();
	$BalanceDue=0;
	$paytypetotal=0;
	$countinsttotal=0;
	$instsellist= Array();
	$AllSelected=0; 
	$MemAmtlist= Array();
	$Duration= Array();
	$BegBalance=0;
	$Balance=0;
	$Balnew=0;
	$TotalAfterMem=0;
	$ToMail=0;
	$TotalNew=0;
	$TotalAdvAmtUsed=0;

	// Retrieve Payment type from Enrolled_Payment_Types
	$sql_ptype = "SELECT Payment_Type_ID FROM Enrolled_Payment_Types where Customer_Name='$name' ";
	$result=mysql_query($sql_ptype) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 

	while($row = mysql_fetch_array($result))
	{
		$paytypelist[$paytypetotal]=$row[0];
		$paytypetotal++;
	}
	
	
	if($paytypelist[0]==3 || $paytypelist[1]==3 || $paytypelist[2]==3)
	{
		$payment_type=3;
	}
	else if($paytypelist[0]==2 || $paytypelist[1]==2 || $paytypelist[2]==2)
	{
		$payment_type=2;
	}
	
	// Retrieve Membership details
	$sql1 = "SELECT Duration,All_Selected,Instrument_Name, Amount FROM Membership where Customer_Name='$name' ";
	$result=mysql_query($sql1) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
	
	while($row = mysql_fetch_array($result))
	{
		$instsellist[$countinsttotal]=$row['Instrument_Name'];
		$MemAmtlist[$countinsttotal]=$row['Amount'];
		$AllSelected=$row['All_Selected'];
		$Duration[$countinsttotal]=$row['Duration'];

		$countinsttotal++;
	}

	// Retrieve Balance from Advance_Payment
	$sql1 = "SELECT Balance FROM Advance_Payment where Customer_Name='$name' ";
	$Bal=mysql_query($sql1) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
	$row1 = mysql_fetch_array($Bal); 
	$Balance=$row1[0];
	#if($paytypelist[0]==3 || $paytypelist[1]==3 || $paytypelist[2]==3)
	if($payment_type==3)
	{	
		$BalanceDue=$Balance;
		$BegBalance=$Balance;
	}
	
?>

<!--<form id="form1" action = "commit_invoice.php" method = "GET">-->
<table bgcolor="white" border="0" cellpadding="5" cellspacing="0" width="760">
	<tbody>
		<tr>
			<td align="right">
				<div id="inv_num">
					<div id="inv_btns" style="margin:0px 5px 0px 10px">
						<input type = "button" value = "Commit" onclick="validate_invoice()">
						<input type="button" name="Cancel" value="Cancel" onclick="window.location=\'generate_invoice.php\'" />
						<!--<img src = "images/close.png" class = "printImg"  value="Close" height = "50" onclick="window.close()"/>-->
					</div>
					<?php echo '<b> MO '.substr($curryear,2,2).'/'.$invoiceno.'</b>';	?>
				</div>
			</td>
		</tr>
		<!---------start of header  ------------>
		<tr>
			<td>	
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tbody>
						<tr>
							<td valign="top">
								<img src="images/usc-logo.jpg">
							</td>
							<td width="40"></td>
							<td valign="top">
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
									<tbody>
										<tr>
											<td height="15">										</td>
										</tr>
										<tr>
											<td colspan="3" valign="top">
												
												<h2><font color="#000000">Center for Electron Microscopy and Microanalysis</font></h2>
												<font color="#000000">
													University of Southern California<br>
													Los Angeles, CA 90089-0101<br>
													(213)740-1990, Fax (213)821-0458</font>							
												</font>	
											</td>
										</tr>
										<tr>
											<td height="10"></td>
										</tr>
										<tr>
											<td valign="center" width="650">
											</td>				
											<td height="5" valign="bottom">
												<font color="#000000" size="4"> &nbsp;&nbsp;<b><i>INVOICE</i></b>&nbsp;&nbsp;</font>
											</td>
								
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<!---------end of header  ------------>
			
						<tr>
						<!---------invoice goes here  ------------>
							<td colspan="3">
								<table border="0" cellpadding="0" cellspacing="0">
									<tbody>
										<tr>
											<td width="59%">
												<fieldset> 
													<legend> Customer</legend>
													<table border="0" cellpadding="0" cellspacing="0">
														<tbody>
															<tr>
																<td height="130" width="600">
																	<table border="0" cellpadding="0" cellspacing="10">
																		<tbody>
																			<tr>
																				<td>
																					<b>Name</b>
																				</td>
																				<td colspan="5">
																					<div id="name"><? echo $name ?></div>
																				</td>
																			</tr>
																			<tr>
																				<td>
																					<b>Address</b>											</td>
																				<td colspan="5">
																					<div id="address">
																					<? 
																						if($AddressSelected==1)
																						{
																							echo $Building." ".$Room.", ".$MailCode;
																							
																						}
																						else 
																						{
																							echo $address1;
																							if($address2 != "") 
																								echo ", ".$address2;
																						}
																						 
																					?>
																					</div>
																				</td>
																			</tr>
																			<tr>
																				<td>
																					<b>City</b>
																				</td>
																				<td width="150">
																					<div id="city"><? echo $city ?></div>
																				</td>
																				<td>
																					<b>State</b>
																				</td>
																				<td width="150">
																					<div id="state"><? echo $state ?></div>	
																				</td>
																				<td>
																					<b>Zip</b>
																				</td>
																				<td width="150">
																					<div id="zip"><? echo $zip ?></div>
																				</td>
																			</tr>
																			<tr>
																				<td>
																					<b>Phone</b>
																				</td>
																				<td>
																					<div id="phone"><? echo $phone ?></div>
																				</td>
																				<td>
																					<b>Fax</b>
																				</td>
																				<td>
																					<div id="fax"><? echo $fax ?></div>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</fieldset>
											</td>
											<td width="3%">&nbsp;</td>
											<td align="right" width="38%">
												<fieldset>
													<table height="145" border="0" cellpadding="0" cellspacing="0">
														<tbody>
															<tr>
																<td width="290" height="130">
																	<table border="0" cellpadding="5" cellspacing="5">
																		<tbody>
																			<tr>
																				<td width="90">
																					<b>Invoice Date </b>
																				</td>
																				<td width="115">
																					<div id="date"><? echo(Date("F d, Y")); ?></div>
																				</td>
																			</tr>
																			<tr>
																				<td>
																					<b>PO / Req #</b>
																				</td>
																				<td>
																					<div id="req">
																						<?
																							echo '<input type="text" id="pq" name="pq" size="15" />';
																						?>
																					</div>
																				</td>
																			</tr>
																			<?
																				if ($payment_type == 3) {
																					echo '<tr>';
																					echo '	<td>';
																					echo '		<b>Balance</b>';
																					echo '	</td>';
																					echo '	<td></td>';
																					echo '</tr>';
																					echo '<tr>';
																					echo '	<td>';
																					echo '		&nbsp;&nbsp;&nbsp;&nbsp;Beginning';
																					echo '	</td>';
																					echo '	<td>';
																					echo '		<div id="BegBalance">' . "$" . number_format(($BegBalance), 2) . '</div>';
																					echo '	</td>';
																					echo '</tr>';
																					echo '<tr>';
																					echo '	<td>';
																					echo '		&nbsp;&nbsp;&nbsp;&nbsp;Remaining';
																					echo '	</td>';
																					echo '	<td>';
																					echo '		<div id="RemBalance">' . '</div>';
																					echo '	</td>';
																					echo '</tr>';
																				}
																			?>
																		</tbody>
																	</table>								
																</td>
															</tr>
														</tbody>
													</table>
												</fieldset>
											</td>
										</tr>
										<tr>
											<td height="20">
											</td>
										</tr>
										<tr>
											<td colspan="3" width="100%">
												<table width=100% class="invoice" border="1" style="border-collapse:collapse" cellpadding="2"> 
													<tbody>
														<tr>
															<td align="center" height="20" width="9%">
																<b>Qt.</b>
															</td>
															<td align="center" nowrap="nowrap" width="10%">
																<b>Date</b><br>(mm/dd/yyyy)
															</td>
															<td align="center" width="40%">
																<b>Description</b>
															</td>
															<td align="center" width="5%">
																<b>With Operator</b>
															</td>
															<td align="center" width="9%">
																<b>Unit Price</b>
															</td>
														<!--	<td align="center" width="5%">
																<b>Payment-<br/>Types</b>
															</td> -->
															<td align="center" width="8%">
																<b>Sub-<br/>Total</b>
															</td>
														</tr>
														<?
															$types[10];
															$sql1 = "SELECT * FROM Customer_data WHERE Date between '$fromdate' and '$todate' and Generated = '0' and Name = '$name' and Manager_ID = ".$_SESSION['mid']." order by Date";
															$result1 = mysql_query($sql1) or die("error2");

															$cnt = 0;
															$ii=0;

															while($row = mysql_fetch_array($result1, MYSQL_ASSOC))
															{
																if(!isset($checkbox[$cnt]))
																{
																	$cnt++;
														?>
															<input type = "hidden" name = "checkbox[<? echo $cnt -1 ?>]" value = "0">
														<?
															continue;
																}
																else{
																	$cnt++;
														?>
															<input type = "hidden" name = "checkbox[<? echo $cnt -1 ?>]" value = "1">
														<?
																	$checked_numbers .= $row['Number'].'|';
																}
																
																if ($row['WithOperator'] == 1){

																$withoperator = "Yes";
																$string = "CEMMA Operator with ".$row['Operator'];
																}
																else {
																$withoperator = "No";
																$string = $row['Operator']." Operator";
																}

																$date_array = explode("-",$row['Date']);
																$var_year = $date_array[0];	
																$var_month = $date_array[1];
																$var_day = $date_array[2];
														?>
														<?php echo '<tr style= "border-bottom-color:#FFFFFF" align="center"><td>'; ?><? echo $row['Qty']; ?><? echo '</td><td>'; ?><? echo "$var_month/$var_day/$var_year"; ?><? echo '</td><td>'; ?><? echo $row['Machine']; echo ", $string"; ?> <? echo '</td><td>'; ?><? echo $withoperator; ?><? echo '</td><td>'; ?>
														<?
															if($row['DiscountFlag'] == 1 )
															{
																printf("%.2f", $row['Unit']/2);
																echo "<sup>*</sup>"; 
															}
															else
															{
																if ($row['OverriddenFlag'] == 1 )
																	echo $row['Unit']."*";		
																else
																	echo $row['Unit'];
															}
															
															echo '</td>';
															//echo '<td>';

															if($payment_type==2)
															{
																$match=0;
																for($i=0;$i<$countinsttotal;$i++)
																{
																	if((($instsellist[$i]==$row['Machine']) || $AllSelected==1) && ($Duration[$i]==$CurrDuration))  
																	{ 
																		//echo 'M';// .$TotalAfterMem; //y
																		$types[$ii]='M';
																		$match=1;
																		break;		
																	}
																	else
																	{
																	}
																}
															}
															//compute if advance payment
															if($match==0)
															{
																#if(($paytypelist[0]==3 || $paytypelist[1]==3 || $paytypelist[2]==3) && $Balance>0)
																if($payment_type==3)
																{
																	//echo "A"; //y
																	$types[$ii]='A';
																}
																else
																{
																	//echo "H";  //y	 //change - take out -N
																	$types[$ii]='H';
																}
																$TotalAfterMem=$TotalAfterMem+$row['Total'];
																//echo $TotalAfterMem; //y	//change - comment full line
															}
															//end Compute Membership
															//echo '</td>';
															echo '<td>';

															if ($match==0) 
															{
																if ($BalanceDue>=$row['Total'])
																{    
																	$BalanceDue=$BalanceDue-$row['Total'];
																	$BalanceArray[$ii]=$row['Total'];
																	#echo $TotalAdvAmtUsed;
																	$TotalAdvAmtUsed=$TotalAdvAmtUsed+$row['Total'];
																	#echo '>'.$TotalAdvAmtUsed."<br>";
																//	echo "#".$BalanceArray[$ii];
																	// echo '0';  // 30/7
																	echo $row['Total'];
																} /*echo $row['Total']; */ 
																else
																{   $BalanceArray[$ii]=$BalanceDue;
																	#echo $TotalAdvAmtUsed;
																	$TotalAdvAmtUsed=$TotalAdvAmtUsed+$BalanceDue;
																	$BalanceDue = 0;
																	#echo '>>'.$TotalAdvAmtUsed."<br>";
																	//	echo number_format(($row['Total']-$BalanceArray[$ii]),2);  //30/7
																	echo $row['Total'];
																	//	echo "#".$BalanceArray[$ii]; 
														?>
															<input type="hidden" value="<? echo $BalanceArray[$ii]; ?>" name="BalanceArray">
														<?
																}
																$number1=$row['Number'];
																$sql3 = "UPDATE Customer_data SET Balance_Used = $BalanceArray[$ii] WHERE Name = '$name' and Number='$number1'";
																mysql_query($sql3) or die ("Error3");
															}	
															else
															{
																echo "0.00";
															}
															echo '</td></tr>';
														?>
														<? 
															$rowcounter++;
															$total = $total + $row['Total'];
														?>
															<input type="hidden" value="<? echo $types[$ii]; ?>" name="types[]">
														<?
															$ii++;
														} //end while


														#if(($paytypelist[0]==3 || $paytypelist[1]==3 || $paytypelist[2]==3) && $Balance>0)
														if(($payment_type==3) && $Balance>0)
														{
															echo '<tr style= "border-bottom-color:#FFFFFF" align="center"><td>&nbsp;</td><td>&nbsp;</td><td>Advance Payment Adjustment</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>'; 
															echo '- '.number_format($TotalAdvAmtUsed,2); 
															echo'</td></tr>';
														}


														for($i=0;$i<11-$rowcounter;$i++) // For adding additional blank rows.
															echo '<tr style= "border-bottom-color:#FFFFFF" align="center"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';

														//Compute Advance Payment
														#if($paytypelist[0]==3 || $paytypelist[1]==3 || $paytypelist[2]==3)
														if($payment_type==3)
														{	
															if($Balance>=$TotalAfterMem)
															{
																$Balnew=$Balance-$TotalAfterMem;
																$TotalNew=0;
																if($Balnew<=100)
																{
																	$ToMail=1;
																}
															}
															else
															{
																$Balnew=0;
																$ToMail=1;
																$TotalNew=$TotalAfterMem-$Balance;
															}
															if ($ToMail==1) // mail if Bal is below $100
															{
																//	BalLowMail();
															}

															/*
															echo " bal before :".$Balance;
															echo " bal new :".$Balnew;
															echo " total aftr mem :".$TotalAfterMem;	
															echo " to mail:".$ToMail;
															*/
														}
														else //if no advance payment type,then make totalafterMem=new total
														{
															$TotalNew=$TotalAfterMem;
														}	

														// echo " total new :".$TotalNew;
														//end Compute Advance Payment
														?>

														<script type="text/javascript">
															var newbal="<?=$Balnew?>";
															document.getElementById("BeginningBalance").innerHTML='$'+newbal;
														</script>
													</tbody>
												</table>
												 
												<table width="100%">	
													<tbody>
														<tr>
															<td width="25%">
																<div id="add"> </div>
															</td>
															<td align="center" width="50%">
																<div id="grand_total">
																<font size="5">
																<b>Amount Due: $<? //uncomment echo number_format(($total), 2); ?> <? echo number_format(($TotalNew), 2); //y ?>
																<!-- change to just $total -->
																</b>
																</font>
																</div>
															</td>
															<!-- <td>&nbsp; &nbsp;TotalNew <? echo number_format(($totalnew), 2); ?> </td>
															<td>&nbsp; &nbsp; Bal: <? echo number_format(($Balance), 2); ?> </td>
															-->
															<td align="right" width="25%">
																<div id="submit">
																	<input type="hidden" value="<? echo $name; ?>" name = "name">
																	<input type="hidden" value="<? echo $fromdate; ?>" name="fromdate">
																	<input type="hidden" value="<? echo $todate; ?>" name="todate">
																	<!--<input type="hidden" value="<? echo $types; ?>" name="types[]"> -->
																	<input type="hidden" value="<? echo $payment_type; ?>" name="payment_type">
																	<input type="hidden" value="<? echo $TotalNew; ?>" name="total_amount">
																</div>
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
										<tr>
											<td colspan="3" height="20"></td>
										</tr>
										<tr>
											<td colspan="3" bgcolor="#000000" height="5"></td>
										</tr>
										<tr>
											<td colspan="3">
												<center>
												<font color="#000000">
													Please return a Requisition or Check for the total shown above to:<br><br>
													Attn: 
													<? 		$rs = new CustomerDAO();
															$room  = "";
															//echo $_SESSION['mid'];
															$retreiveName=$rs->getManagerName($_SESSION['mid'],$_SESSION['login']);
															echo $retreiveName;
															if($_SESSION['mid'] == 1 && $_SESSION['login']=='John' ){
																$room = "CEM 101B, MC 0101";
															}
															else if($_SESSION['mid'] == 1 && $_SESSION['login']=='Alicia' ){  //mid was 2 earlier,AP =1
																$room = "CEM 100, MC 0101";
															}
													?>
													
													<br>University of Southern California
													<br>Univeristy Park Campus
													
													<br>814 Bloom Walk, <?=$room?>
													<br>Los Angeles, CA 90089-0101
													<br>Checks should be payable to:
													<br>University of Southern California
												</font>
												</center>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				<noscript></noscript>
			</td>
		</tr>
	</tbody>
</table>
<!--</form>-->
<script>
function validate_invoice()
{
	var pq_value= document.getElementById("pq").value
	if (document.getElementById("pq").value == "")
	{
		alert("Please input PO#.");
	}
	else
	{
		document.getElementById("req").innerHTML = pq_value;
		submit_invoice(pq_value);
	}
}
function submit_invoice(pq_value)
{
	var xmlhttp;
	if (window.XMLHttpRequest)
	{	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{	// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			//alert(xmlhttp.responseText);
			var result = xmlhttp.responseText.trim();
			//alert("["+result.split("|")[0]+"]");
			if(result.split("|")[0]=="OK")
			{			
				alert("The invoce was submitted successfully! (Invoice#: "+result.split("|")[1]+")");
				//Change Button to Print
				show_print_btn();
			}
			else
			{
				alert("Submittion Failed!");
			}
		}
	}
	alert('<?echo $TotalNew;?>');
	xmlhttp.open("POST","php/addInvoice.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	var param = "invno=<?=$invoiceno?>&yr=<?=$curryear?>&name=<?=$name?>&fromdate=<?=$fromdate?>&todate=<?=$todate?>&tamt=<?=$TotalNew?>&pq="+pq_value+"&mng=<?=$managername?>";
	param += "&ptype=<?=$payment_type;?>";
	if (<?=$payment_type;?>==3)
	{
		param += "&begbal=<?=$BegBalance;?>";
		param += "&rembal=<?=$Balnew?>"
	}
	param += "&chknbs=<?=$checked_numbers?>"
	xmlhttp.send(param);
}

function show_print_btn()
{
	<?
		$getString = "invoiceno=".$invoiceno."&Gdate=".Date("Y-m-d")."&name=".$name."&pagenum=1";
	?>
	var html = '<input type="button" name="Print Invoice" onclick="window.open(\'view_invoice2.php?<?=$getString?>\')" value="Print Invoice" />';
	html += '<input type="button" name="Return" onclick="window.location = \'generate_invoice.php\'" value="Return" />'
	
	document.getElementById("inv_btns").innerHTML = html;
}
document.getElementById("RemBalance").innerHTML = '<?="$" . number_format(($Balnew), 2)?>';
</script>
<?
	function BalLowMail()
	{		
		$to = "a@usc.edu";
		$subject = "Balance below $100";
		$message = "This is to notify that Balance has gone below $100";
		$from = "koolamay_99@yahoo.com";
		$headers = "From: $from";
		mail($to,$subject,$message,$headers);
		//echo "Mail Sent.";
	}
	mysql_close($connection);
?>