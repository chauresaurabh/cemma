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

$qry = "SELECT PO FROM Invoice where Gdate = '$Gdate' and Invoiceno = '$invoiceno'";
$result = mysql_query($qry) or die("error");
while ($row = mysql_fetch_array($result)) {
	$pq = $row['PO'];
}

// Retrieve Payment type from Enrolled_Payment_Types
$paytypelist = Array();
$payment_type = 0;
$sql_ptype = "SELECT Payment_Type_ID FROM Enrolled_Payment_Types where Customer_Name='$name' ";
$result = mysql_query($sql_ptype) or die("An error has occurred in query1: " . mysql_error() . ":" . mysql_errno());

while ($row = mysql_fetch_array($result)) {
	$paytypelist[$paytypetotal] = $row[0];
	$paytypetotal++;
}

if ($paytypelist[0] == 3 || $paytypelist[1] == 3 || $paytypelist[2] == 3) {
	$payment_type = 3;
	// Retrieve Balance from Advance_Payment
	$sql_advpmt = "SELECT Balance FROM Advance_Payment where Customer_Name='$name' ";
	$result_advpmt = mysql_query($sql_advpmt) or die("An error has occurred in query1: " . mysql_error() . ":" . mysql_errno());
	$row = mysql_fetch_array($result_advpmt);
	$rmBalance = $row[0];
} else if ($paytypelist[0] == 2 || $paytypelist[1] == 2 || $paytypelist[2] == 2) {
	$payment_type = 2;
}
?>
<html>
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
					//var html = document.documentElement.getElementsByTagName('body')[0].innerHTML;
					alert(document.getElementById('invoice_content').innerHTML);
					var html = '<html><body>';
					html += document.getElementById('invoice_content').innerHTML;
					html += '</body></html>';
					//html = '<html><body><table><tr><td><table><tr><td>11<td><tr></table></td></tr></table></body></html>';
					xmlhttp.onreadystatechange=function()
					{
						if (xmlhttp.readyState==4)
						{
							if(xmlhttp.status==200)
							{
								alert("Email was sent!");
								alert("Response: "+xmlhttp.responseText);
							}
							else
							{
								alert("[Error] Failed to send an Email!")
							}
		   				}
					}
					alert(html);
					//html = '<html><body><p>Put your html here, or generate it with your favourite templating system.</p><table><tr><td>111</td></tr></table></body></html>';
					//html = '<p>Put your html here, or generate it with your favourite templating system.http://www.naver.com</p><table><tr><td><img src="images/usc-logo.jpg"/></td><td>111</td></tr></table>';
					html = '<p>Put your html here, or generate it with your favourite templating system.http://www.naver.com</p><table><tr><td><img src="/kunden/homepages/40/d209127057/htdocs/cemma/testbed/images/usc-logo.jpg"/></td><td>111</td></tr></table>';
					xmlhttp.open("POST","sendInvoiceEmail.php",false);
					xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
					xmlhttp.send("html="+escape(html));
				}
			}
			function sendInvoiceEmail2()
			{
				alert("HTML2PDF");
				if(confirm("Are you sure to send this invoice by Email?"))
				{
					var html = document.documentElement.getElementsByTagName("body")[0].innerHTML;
					xmlhttp.onreadystatechange=function()
					{
						if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
							alert("Email was sent!");
							alert("Response: "+xmlhttp.responseText);
			   			}
					}
					alert(document.documentElement.getElementsByTagName("body")[0].innerHTML);
					html = '<p>Put your html here, or generate it with your favourite templating system.[[http://www.naver.com]]</p><table><tr><td>[[{{images/usc-logo.jpg}}]]</td><td>111</td></tr></table>';
					xmlhttp.open("POST","sendInvoiceEmail2.php",false);
					xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
					xmlhttp.send("html="+escape(html));
				}
			}
			loadXMLDoc();</script>
	</head>
	<body>
		<?php

$sql = "SELECT * FROM Customer_data WHERE Gdate = '$Gdate' and  invoiceno = '$invoiceno' and Generated = '1' order by Date";

$result = mysql_query($sql) or die( "An error has occurred in query_usedbalance: ");

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
		<div id='invoice_content'>
		<table bgcolor="white" border="1"  width="760">
			<tr>
				<td align="right">
					<div id="inv_num">
						<img src = "images/printer.png" class = "printImg" onClick="window.print();return false;" value=" Print  " height = "50" width = "50" style="cursor:pointer"/>
						<img src = "images/outgoing-email-icon.jpg" class = "printImg" onClick="sendInvoiceEmail();" value=" Email  " height = "50" width = "60" style="cursor:pointer"/>
						<img src = "images/outgoing-email-icon.jpg" class = "printImg" onClick="sendInvoiceEmail2();" value=" Email  " height = "50" width = "60" style="cursor:pointer"/>
						<img src = "images/close.png" class = "printImg;"  value="Close" height = "50"/>
					</div>
				</td>
			</tr><!---------start of header  ------------>
			<tr>
				<td>
					<table>
						<tr>
							<td width="40"><img src="images/usc-logo.jpg"/></td>
							<td>
								<table border="0" >
									<tbody>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td valign="top">
												<h2><font color="#000000">Center for Electron Microscopy and Microanalysis</font></h2>
												<font color="#000000"> University of Southern California<br>
												CEM 200, Los Angeles, CA 90089-0101<br>
												(213)740-1990, Fax (213)821-0458</font>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td align="right" width="650">
												<b>INVOICE NUMBER <?  echo substr($Gyear, 2, 2) . '/' . $invoiceno;?></b>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</table>

				</td>
			</tr>
			<!---------end of header  ------------>
			<tr>
				<!---------invoice goes here  ------------>
				<td>
					<table border="1" cellpadding="0">
						<tbody>
							<tr>
								<td width="600px">
									<fieldset>
										<legend>Customer</legend>
										<table border="1" width="300px"cellpadding="0">
											<tbody>
												<tr>
													<td height="130px" width="55%">
													<table border="1" width="400px" cellpadding="0">
														<tbody>
															<tr>
																<td width="30%"><b>Name</b></td>
																<td><div id="name"><? echo $firstname.' '.$lastname?></div></td>
															</tr>
															<tr>
																<td><b>Dept./Company</b></td>
																<td><div id="name"><? echo $department?></div></td>
															</tr>
															<tr>
																<td><b>Address</b></td>
																<td>
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
																	</div>
																</td>
															</tr>
															<tr>
																<td colspan="2">
																<table border="1" width="100%">
																	<tr>
																		<td width="13%"><b>City</b></td>
																		<td width="45%">
																			<div id="city">
																				<? echo $city?>
																			</div>
																		</td>
																		<td width="13%"><b>State</b></td>
																		<td width="20%">
																			<div id="city">
																				<? echo $state?>
																			</div>
																		</td>
																		<td width="13;"><b>Zip</b></td>
																		<td width="16%">
																			<div id="ciry">
																				<? echo $zip?>
																			</div>
																		</td>
																	</tr>
																</table>
																</td>
															</tr>
															<tr>
																<td colspan="2">
																<table border="1" width="100%">
																	<tr>
																		<td width="15%"><b>Phone</b></td>
																		<td width="35%">
																			<div id="phone">
																				<? echo $phone?>
																			</div>
																		</td>
																		<td width="15%"><b>Fax</b></td>
																		<td width="35%">
																			<div id="fax">
																				<? echo $fax?>
																			</div>
																		</td>
																	</tr>
																</table></td>
															</tr>
														</tbody>
													</table></td>
												</tr>
											</tbody>
										</table>
									</fieldset>
								</td>
								
								<td width="2%">&nbsp; </td>
								
								<td align="right" width="43%">
									<fieldset>
										<table height="130px" border="1" cellpadding="0">
											<tbody>
												<tr>
													<td width="290px" height="130px">
														<table border="1" cellpadding="0">
															<tbody>
																<tr>
																	<td width="120px"><b>Invoice Date </b></td>
																	<td width="170px">
																	<div id="date">
																		<? echo(Date("F d, Y", $Gtime));?>
																	</div></td>
																</tr>
																<tr>
																	<td><b>PO / Req</b></td>
																	<td>
																	<div id="req">
																		<? echo $pq
																		?>
																	</div></td>
																</tr>
																<?
																if ($payment_type == 3) {
																	echo '<tr>';
																	echo '	<td>';
																	echo '		<b>Beginning Balance</b>';
																	echo '	</td>';
																	echo '	<td>';
																	echo '		<div id="AvailableBalance">' . "$" . number_format(($rmBalance), 2) . '</div>';
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
							
								<!-- ***********************START************************** -->
								<!-- ************************END************************* -->
															
	
							
						</tbody>
					</table>
				</td>
			</tr>
			
			
			
			</tbody>
		</table>
		</div>
		
		<noscript></noscript></td>
		</tr></tbody>
		</table>
		<?
			echo '</span>';
			$pagenum++;
		}
		mysql_close($connection);
		?>
	</body>
</html>