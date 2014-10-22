<?

include_once ('constants.php');
include_once (DOCUMENT_ROOT . "includes/database.php");
include_once (DOCUMENT_ROOT . "includes/checklogin.php");
include_once (DOCUMENT_ROOT . "includes/checkadmin.php");

$Gdate = $_GET['Gdate'];
$invoiceno = $_GET['invoiceno'];
$name = $_GET['name'];
$pagenum = $_GET['pagenum'];

$Gtime = strtotime($Gdate);
$Gdate_array = explode("-", $Gdate);
$Gyear = $Gdate_array[0];
$Gmonth = $Gdate_array[1];

if ($Gmonth > 6)
	$Gyear = $Gyear + 1;

$sql = "SELECT * FROM Customer where Name='$name'";
$result = mysql_query($sql) or die("error");
while ($row = mysql_fetch_array($result)) {
	$firstname = $row['FirstName'];
	$lastname = $row['LastName'];
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
	$department = $row['Department'];
}

$qry = "SELECT PO, BegBalance, RemBalance FROM Invoice where Gdate = '$Gdate' and Invoiceno = '$invoiceno'";
$result = mysql_query($qry) or die("error");
while ($row = mysql_fetch_array($result)) {
	$pq = $row['PO'];
	$begBalance = $row['BegBalance'];
	$remBalance = $row['RemBalance'];
}

// Retrieve Payment type from Enrolled_Payment_Types
$paytypelist = Array();
$payment_type = 0;
$sql_ptype = "SELECT Payment_Type_ID FROM Enrolled_Payment_Types where Customer_Name='$name' ";
$result = mysql_query($sql_ptype) or die("An error has ocured in query1: " . mysql_error() . ":" . mysql_errno());

while ($row = mysql_fetch_array($result)) {
	$paytypelist[$paytypetotal] = $row[0];
	$paytypetotal++;
}

if ($paytypelist[0] == 3 || $paytypelist[1] == 3 || $paytypelist[2] == 3) {
	$payment_type = 3;
	// Retrieve Balance from Advance_Payment
	$sql_advpmt = "SELECT Balance FROM Advance_Payment where Customer_Name='$name' ";
	$result_advpmt = mysql_query($sql_advpmt) or die("An error has ocured in query1: " . mysql_error() . ":" . mysql_errno());
	$row = mysql_fetch_array($result_advpmt);
	$rmBalance = $row[0];
} else if ($paytypelist[0] == 2 || $paytypelist[1] == 2 || $paytypelist[2] == 2) {
	$payment_type = 2;
}
?>
<head>
	<title>MO <?  echo substr($Gyear, 2, 2) . '/' . $invoiceno;?></title>
	<style>
		@media print {
			.printImg {
				display: none;
			}
			.paginationRow {
				display: none;
			}
		}
		.break {
			page-break-before: always;
		}

	</style>
	<script type="text/javascript">
		function loadXMLDoc()
		{
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}
			else
			{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
		}
		function sendInvoiceEmail()
		{
			if(confirm("Are you sure to send this invoice by Email?"))
			{
				var html = "<html><body>"+document.documentElement.getElementsByTagName("body")[0].innerHTML+"</body></html>";
				xmlhttp.onreadystatechange=function()
				{
					if (xmlhttp.readyState==4 && xmlhttp.status==200)
					{
						alert("Email was sent!");
						alert("Response: "+xmlhttp.responseText);
		   			}
				}
				alert(document.documentElement.getElementsByTagName("body")[0].innerHTML);
				//html = '<html><body><p>Put your html here, or generate it with your favourite templating system.</p><table><tr><td>111</td></tr></table></body></html>';
				xmlhttp.open("POST","sendInvoiceEmail.php",false);
				xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				xmlhttp.send("html="+escape(html));
			}
		}
		loadXMLDoc();</script>
</head>
<body>
	<?php

$sql = "SELECT * FROM Customer_data WHERE Gdate = '$Gdate' and  invoiceno = '$invoiceno' and Generated = '1' order by Date";

$result = mysql_query($sql) or die( "An error has ocured in query_usedbalance: ");

$rows = mysql_num_rows($result);
$usedBalance = 0.0;

while($row = mysql_fetch_array($result))
{
$usedBalance += $row['Balance_Used'];
}

$page_rows = 11; // Number of records per page
$last = ceil($rows/$page_rows);

while($pagenum <= $last){
$max = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows; // Limit Query
$sql = "SELECT * FROM Customer_data WHERE Gdate = '$Gdate' and  invoiceno = '$invoiceno' and Generated = '1' order by Date ".$max;

$result = mysql_query($sql) or die("Error in Viewing");
if($pagenum == 1){
echo '<span id = "page'.$pagenum.'">';
}
else{
echo '<span id = "page'.$pagenum.'" class = "break">';
}
	?>

	<table bgcolor="white" border="0" cellpadding="5" width="760">
		
		<tr>
			<td align="right">
			<div id="inv_num">
				<img src = "images/printer.png" class = "printImg" onClick="window.print();return false;" value=" Print  " height = "50" width = "50" style="cursor:pointer"/>
				<img src = "images/outgoing-email-icon.jpg" class = "printImg" onClick="sendInvoiceEmail();" value=" Email  " height = "50" width = "60" style="cursor:pointer"/>
				<img src = "images/close.png" class = "printImg"  value="Close" height = "50" onClick="window.close()"/>
			</div></td>
		</tr><!---------start of header  ------------>
		<tr>
			<td>
			<table border="0" cellpadding="0" width="100%">
				<tr>
					<td valign="top"><img src="images/usc-logo.jpg"></td>
					<td width="40"></td>
					<td valign="top">
					<table border="0" cellpadding="0" width="100%">
						<tbody>
							<tr>
								<td height="15"></td>
							</tr>
							<tr>
								<td colspan="3" valign="top"><h2><font color="#000000">Center for Electron Microscopy and Microanalysis</font></h2><font color="#000000"> University of Southern California<br>
									Los Angeles, CA 90089-0101<br>
									(213)740-1990, Fax (213)821-0458</font> </font> </td>
							</tr>
							<tr>
								<td height="10" border='1'></td>
							</tr>
							<tr>
								<td align="right" width="650"><b>INVOICE NUMBER <?  echo substr($Gyear, 2, 2) . '/' . $invoiceno;?></b></td>
								<td height="5" valign="bottom"><!--
								<font color="#000000" size="4"> &nbsp;&nbsp;<b><i>INVOICE</i></b>&nbsp;&nbsp;</font>
								--></td>
							</tr>
						</tbody>
					</table></td>
				</tr>
				<!---------end of header  ------------>
				<tr>
					<!---------invoice goes here  ------------>
					<td colspan="3">
					<table border="0" cellpadding="0">
						<tbody>
							<tr>
								<td width="59%">
								<fieldset>
									<legend>
										Customer
									</legend>
									<table border="0" cellpadding="0">
										<tbody>
											<tr>
												<td height="130" width="55%">
												<table border="0" width="400"cellpadding="0">
													<tbody>
														<tr>
															<td width="30%"><b>Name</b></td>
															<td colspan="5"><!--<div id="name"><? echo $name ?></div>-->
															<div id="name">
																<? echo $firstname.' '.$lastname?>
															</div></td>
														</tr>
														<tr>
															<td><b>Dept./Company</b></td>
															<td colspan="5">
															<div id="name">
																<? echo $department?>
															</div></td>
														</tr>
														<tr>
															<td><b>Address</b></td>
															<td colspan="5">
															<div id="address">
																<?
																if ($AddressSelected == 1) {
																	echo $Building . " " . $Room . ", " . $MailCode;

																} else {
																	echo $address1;
																	if ($address2 != "")
																		echo ", " . $address2;
																}
																?>
															</div></td>
														</tr>
														<tr>
															<td colspan="6">
															<table width="100%">
																<tr>
																	<td width="13%"><b>City</b></td>
																	<td width="45%">
																	<div id="ciry">
																		<? echo $city
																		?>
																	</div></td>
																	<td width="13%"><b>State</b></td>
																	<td width="20%">
																	<div id="ciry">
																		<? echo $state
																		?>
																	</div></td>
																	<td width="13%"><b>Zip</b></td>
																	<td width="16%">
																	<div id="ciry">
																		<? echo $zip
																		?>
																	</div></td>
																</tr>
															</table></td>
														</tr>
														<tr>
															<td colspan="6">
															<table width="100%">
																<tr>
																	<td width="15%"><b>Phone</b></td>
																	<td width="35%">
																	<div id="phone">
																		<? echo $phone
																		?>
																	</div></td>
																	<td width="15%"><b>Fax</b></td>
																	<td width="35%">
																	<div id="fax">
																		<? echo $fax
																		?>
																	</div></td>
																</tr>
															</table></td>
														</tr>
													</tbody>
												</table></td>
											</tr>
										</tbody>
									</table>
								</fieldset></td>
								<td width="2%">&nbsp; </td>
								<td align="right" width="43%">
								<fieldset>
									<table height="130" border="0" cellpadding="0">
										<tbody>
											<tr>
												<td width="290px" height="130">
												<table border="0" cellpadding="0">
													<tbody>
														<tr>
															<td width="90px"><b>Invoice Date </b></td>
															<td width="115px">
																<div id="date"><? echo(Date("F d, Y", $Gtime));?></div>
															</td>
														</tr>
														<tr>
															<td><b>PO / Req</b></td>
															<td>
																<div id="req"><? echo $pq?></div>
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
															echo '		<div id="BegBalance">' . "$" . number_format(($begBalance), 2) . '</div>';
															echo '	</td>';
															echo '</tr>';
															echo '<tr>';
															echo '	<td>';
															echo '		&nbsp;&nbsp;&nbsp;&nbsp;Remaining';
															echo '	</td>';
															echo '	<td>';
															echo '		<div id="RemBalance">' . "$" . number_format(($remBalance), 2) . '</div>';
															echo '	</td>';
															echo '</tr>';
														}
														?>
													</tbody>
												</table></td>
											</tr>
										</tbody>
									</table>
								</fieldset></td>
							</tr>
							<tr>
								<td height="20"></td>
							</tr>
							<tr>
								<td colspan="3">
								<table width=100% class="invoice" border="1" style="border-collapse:collapse" cellpadding="2">
									<tr>
										<td align="center" height="20" width="9%"><b>Qt.</b></td>
										<td align="center" nowrap="nowrap" width="10%"><b>Date</b>
										<br>
										(mm/dd/yyyy) </td>
										<td align="center" width="40%"><b>Description</b></td>
										<td align="center" width="5%"><!--<b>With Operator</b>--><b>CEMMA STAFF</b></td>
										<td align="center" width="9%"><b>Unit Price</b></td>
										<!-- <td align="center" width="5%"><b>Payment-
										<br/>
										Types</b></td> -->
										<td align="center" width="8%"><b>Sub-
										<br/>
										Total</b></td>
									</tr>
									<?

									$rowcounter = 0;
									$ii = 0;
									while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
										$date_array = explode("-", $row['Date']);
										$var_year = $date_array[0];
										$var_month = $date_array[1];
										$var_day = $date_array[2];
										if ($row['WithOperator'] == 1) {
											$withoperator = "Yes";
											#$string = "CEMMA Operator with ".$row['Operator'];
											$string = $row['Operator'];
										} else {
											$withoperator = "No";
											#$string = $row['Operator']." Operator";
											$string = $row['Operator'];
										}
										echo '<tr style= "border-bottom-color:#FFFFFF" align="center"><td>';
										echo $row['Qty'];
										echo '</td><td>';
										echo "$var_month/$var_day/$var_year";
										echo '</td><td>';
										echo $row['Machine'];
										echo ", $string";
										echo '</td><td>';
										echo $withoperator;
										echo '</td><td>';

										/*

										 echo '<tr style= "border-bottom-color:#FFFFFF" align="center"><td>';
										 echo $row['Qty'];
										 echo '</td><td>';
										 echo "$var_month/$var_day/$var_year";
										 echo '</td><td>';
										 echo $row['Machine'];
										 echo ", $string";
										 echo '</td><td>';
										 echo $withoperator;
										 echo '</td><td>';
										 */
										if ($row['DiscountFlag'] == 1)//
										{
											printf("%.2f", $row['Unit'] / 2);
											echo "<sup>*</sup>";
										} else {
											if ($row['OverriddenFlag'] == 1)
												echo $row['Unit'] . "<sup>*</sup>";
											else
												echo $row['Unit'];
										}
										echo '</td>';
										 
			 			$TotalAfterMem = $TotalAfterMem + $row['Total'];

										echo '<td>';

										if ($match == 0) {
											if ($BalanceDue >= $row['Total']) {
												$BalanceDue = $BalanceDue - $row['Total'];
												$BalanceArray[$ii] = $row['Total'];
												$TotalAdvAmtUsed = $TotalAdvAmtUsed + $row['Total'];
												echo $row['Total'];
											} else {   $BalanceArray[$ii] = $BalanceDue;
												$TotalAdvAmtUsed = $TotalAdvAmtUsed + $BalanceDue;
												echo $row['Total'];
											}
										} else {
											echo "0.00";
										}
										echo '</td></tr>';

										$ii++;

										$rowcounter++;
										$total = $total + $row['Total'];
									}
									if (($payment_type == 3) && ($pagenum == $last)) {
										echo '<tr style= "border-bottom-color:#FFFFFF" align="center"><td>&nbsp;</td><td>&nbsp;</td><td>Advance Payment Adjustment</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>';
										echo '- ' . number_format($usedBalance, 2);
										echo '</td></tr>';
										$rowcounter++;
									}

									for ($i = 0; $i < 11 - $rowcounter; $i++)// For adding additional blank rows.
										echo '<tr style= "border-bottom-color:#FFFFFF" align="center"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td> <td>&nbsp;</td><td>&nbsp;</td></tr>';
									?>
								</table>
								<table width="100%">
								 
								</table>
								<br>
								<table width="100%">
									<tbody>
										<tr>
											<?
											if ($pagenum != $last){
											?>
											<td align="right" width="60%">
											<div id="sub_total" align="right">
												<font size="3"><b>Sub-Total: $<? echo number_format(($total), 2);?></b></font>
											</div></td>
											<?php

											}

											else{

											$sql = "SELECT * FROM Customer_data WHERE Gdate = '$Gdate' and  invoiceno = '$invoiceno' and Generated = '1' order by Date";
											$total = 0;
											$result = mysql_query($sql) or die("Error in Viewing");

											while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
											$total = $total + $row['Total'];
											}
											$totalNew = $total - $usedBalance;
											?>

											<td align="right" width="60%"><!--<div id="Total" align="right"><font size="5"><b>Total: $<? echo number_format(($totalNew), 2); ?></b></font></div>-->
											<div id="Total" align="right">
												<font size="5"><b>Amount Due: $<? echo number_format(($totalNew), 2);?></b></font>
											</div></td>
											<?php

											}
											?>
											<td align = "right" width="40%"><?php
if($last != 1){
											?>

											<?php

											echo "<div class = 'paginationRow'>Page ";
											for ($k = 1; $k <= $last; $k++) {

												if ($pagenum == $k) {

													echo $k . " | ";
												} else {
													echo "<a href = #page" . $k . ">" . $k . "</a> | ";
												}
											}
											echo '</div>';

											}
											?></td>
											<td align="right" width="25%"><div id="submit"></div></td>
										</tr>
									</tbody>
								</table></td>
							</tr>
							<tr>
								<td colspan="3">
								<center>
									<br>
									<br>
									<font color="#000000"> Please return a Requisition or Check for the total shown above to:
										<br>
										Attn: <? 		$rs = new CustomerDAO();
											$room = "";
											//echo " login: ".$_SESSION['login']."-".$_SESSION['mid'];
											//	echo " cust: ".$_SESSION['Cust_ID_of_Manager'];
											echo $rs -> getManagerName($_SESSION['mid'], $_SESSION['login']);

											if ($_SESSION['mid'] == 1 && $_SESSION['login'] == 'John') {
												$room = "CEM 101B, MC 0101";
											} else if ($_SESSION['mid'] == 1 && $_SESSION['login'] == 'Alicia') {//mid was 2 earlier,AP =1
												$room = "CEM 100, MC 0101";
											}
										?>

										<br>
										University of Southern California<br>
										Univeristy Park Campus<br>
										814 Bloom Walk, <?=$room?><br>
										Los Angeles, CA 90089-0101<br>
										Checks should be payable to: University of Southern California </font>
								</center></td>
							</tr>
						</tbody>
					</table></td>
				</tr>
				</tbody>
			</table><noscript></noscript></td>
		</tr></tbody>
	</table>
	<?
	echo '</span>';
	$pagenum++;
	}
	mysql_close($connection);
	?>
</body>