<?

	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/database.php");
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");

	$name = $_GET['name'];
	$fromdate = $_GET['fromdate'];
	$todate = $_GET['todate'];
	$pq = $_GET['pq'];
	$checkbox  = $_GET['checkbox'];
	$managername=$_SESSION['login'];
	$paytypelist = $_GET['types'];

	$BalanceArray= $_GET['BalanceArray'];

	$sql = "SELECT * FROM Customer where Name='$name' AND Manager_ID = ".$_SESSION['mid'];
	$result = mysql_query($sql) or die ("error in selecting customer");
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
	
	#mysql_query("UPDATE Advance_Payment SET Balance = '$Balnew' WHERE Customer_Name = '$name'") or die( "An error has occurred in query1: ");
	
	// Retrieve Balance from Advance_Payment
	$sql1 = "SELECT Balance FROM Advance_Payment where Customer_Name='$name' ";
	$Bal=mysql_query($sql1) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
	$row1 = mysql_fetch_array($Bal); 
	$Balance=$row1[0];

	$total = 0;
	$curryear = Date("Y"); //For current year
	$currmonth = Date("M"); // For current month
	$numCurrMonth = Date("m");

if($numCurrMonth>6) $curryear = $curryear+1;

if ($managername=='John')
{
$qry = "SELECT * FROM Invoice where Year = '$curryear' AND ( Manager_Name ='John' OR ISNULL(Manager_Name)) AND Manager_ID = ".$_SESSION['mid']." ORDER BY  invoiceno DESC LIMIT 1";
$result = mysql_query($qry) or die ("error in selecting from Invoice");
$num_rows = mysql_num_rows($result);
//echo 'j';
}
else
{
if($managername=='Alicia')
{
$qry = "SELECT * FROM Invoice where Year = '$curryear' AND Manager_Name = '$managername' AND Manager_ID = ".$_SESSION['mid']." ORDER BY  invoiceno DESC LIMIT 1";
$result = mysql_query($qry) or die ("error in selecting from Invoice");
$num_rows = mysql_num_rows($result);
//echo 'a';
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


$getString = "invoiceno=".$invoiceno."&Gdate=".Date("Y-m-d")."&name=".$name."&pagenum=1";

?>

<style>

	@media print {

		.printImg{
			display:none;

		}



		.paginationRow{
			display:none;
		}

	}
	
	.break { page-break-before: always; }

	</style>


	<table bgcolor="white" border="0" cellpadding="5" cellspacing="0" width="760">
		<td width="700"><tbody><tr>
		<td align="right">
			<div>
				<span id = "inv_num">
					<input type="button" name="Print Invoice" onclick="window.open('view_invoice2.php?<?=$getString?>')" value="Print Invoice" />
					<input type="button" name="Return" onclick="window.location = 'generate_invoice.php'" value="Return" />
					<b> MO <?  echo substr($curryear,2,2); echo '/'; echo $invoiceno; ?></b>
				</span>
			</div>
		</td>
		</tr>
			<!---------start of header  ------------>
			<tr>
				<td>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tbody><tr>
							<td valign="top">
								<img src="images/usc-logo.jpg">							</td>
							<td width="40">							</td>
							<td valign="top">
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
									<tbody><tr>
										<td height="15">										</td>
									</tr>
									<tr>
										<td colspan="3" valign="top">
											
											<h2><font color="#000000">Center for Electron Microscopy and Microanalysis</font></h2>
											<font color="#000000">University of Southern California<br>
											CEM 200, CA 90089-0101<br>
											(213)740-1990, Fax (213)821-0458</font>										</td>
									</tr>
									<tr>
										<td height="10">										</td>
									</tr>
									<tr>
										<td valign="center" width="650">
																					</td>				
										<td height="5" valign="bottom">
											<font color="#000000" size="4"> &nbsp;&nbsp;<b><i>INVOICE</i></b>&nbsp;&nbsp;</font>										</td>
									
									</tr>
					</tbody></table>				</td>
			</tr>
		
			<!---------end of header  ------------>
			
			<tr>
			<!---------invoice goes here  ------------>
			<td colspan="3">
				<table border="0" cellpadding="0" cellspacing="0">
					<tbody><tr>
						<td width="59%">
							
							<fieldset> 
								<legend> Customer</legend>
									<table border="0" cellpadding="0" cellspacing="0">
									<tbody><tr>
									<td height="130" width="55%">
									<table border="0" cellpadding="0" cellspacing="10">
										<tbody><tr>
											<td>
												<b>Name</b>											</td>
											<td colspan="5">
												<div id="name"><? echo $name ?></div>											</td>
										</tr>
										<tr>
											<td>
												<b>Address</b>											
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
												<b>City</b>											</td>
											<td width="150">
												<div id="city"><? echo $city ?></div>											</td>
											<td>
												<b>State</b>											</td>
											<td width="150">
												<div id="state"><? echo $state ?></div>											</td>
											<td>
												<b>Zip</b>											</td>
											<td width="150">
												<div id="zip"><? echo $zip ?></div>											</td>
										</tr>
										<tr>
											<td>
												<b>Phone</b>											</td>
											<td>
												<div id="phone"><? echo $phone ?></div>											</td>
											<td>
												<b>Fax</b>											</td>
											<td>
												<div id="fax"><? echo $fax ?></div>											</td>
											
										</tr>
									</tbody></table>									</td>
									</tr>
									</tbody></table>
							</fieldset>					  </td>
						<td width="3%">&nbsp;						</td>
						<td align="right" width="38%">
							<fieldset>
							
								<table height="145" border="0" cellpadding="0" cellspacing="0">
									<tbody><tr>
									<td width="290" height="140">
								<table border="0" cellpadding="5" cellspacing="5">
									<tbody><tr>
										<td width="90">
											<b>Invoice Date </b>										</td>
										<td width="115">
											<div id="date"><? echo(Date("F d, Y")); ?></div>									  </td>
									</tr>
									<tr>
										<td>
											<b>PO / Req #</b>
										</td>
										<td>
											<div id="req">
												<? echo $pq; ?>
											</div>		
										</td>
									</tr>
									<tr>
										<td>
											<b>Remaining Balance</b>
										</td>
										<td>
											<div id="AvailableBalance"><?// echo "$".number_format(($Balance), 2) ?></div>						
												<? for($i=0;$i<$paytypetotal;$i++)
													{ if ($paytypelist[$i]==3) 
														{
												?>
												<?		 }
													} 
													#echo '<br>';
													echo '$'.$Balance;
												?>
										</td>
									</tr>
								</tbody></table>								</td>
									</tr>
							</tbody></table>
							</fieldset>					  </td>
					</tr>
				
				
				
			
			<tr>
				<td height="20">
					
				</td>
			</tr>
			<tr>
				<td colspan="3" width="100%">
					<table width=100% class="invoice" border="1" style="border-collapse:collapse" cellpadding="2"> 
						<tbody><tr>
							<td align="center" height="20" width="9%">
								<b>Qt.</b>
							</td>
							<td align="center" nowrap="nowrap" width="10%">
								<b>Date</b><br>(mm/dd/yyyy)
							</td>
							<td align="center" width="55%">
								<b>Description</b>
							</td>
							<td align="center" width="5%">
								<b>With Operator</b>
							</td>
							<td align="center" width="9%">
								<b>Unit Price</b>
							</td>
							<td align="center" width="5%">
								<b>Payment-<br/>Types</b>
							</td>
							<td align="center" width="8%">
								<b>Sub-<br/>Total</b>
							</td>
							</tr>
											
<?
$sql1 = "SELECT * FROM Customer_data WHERE Date between '$fromdate' and '$todate' and Generated = '0' and Name = '$name' and Manager_ID = ". $_SESSION['mid']." order by Date";
$result1 = mysql_query($sql1) or die("error2");

$cnt = 0;
$ii=0;

while($row = mysql_fetch_array($result1, MYSQL_ASSOC)){

if($checkbox[$cnt] == 0){
	$cnt++;
	continue;
}
else{
	$cnt++;
}
	
$number = $row['Number'];

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
	if($row['DiscountFlag'] == 1 ) // 
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
?>
			
		<? echo '</td><td>'; ?>
		<? echo $paytypelist[$ii]; ?>
		<? echo '</td><td>'; ?>
		<? echo $row['Total']; ?><? echo '</td></tr>';?>
		

					
<? 
$rowcounter++;
$total = $total + $row['Total'];
$sql3 = "UPDATE Customer_data SET Generated = '1', Gdate = curdate(), invoiceno = '$invoiceno' WHERE Number = '$number'";
mysql_query($sql3) or die ("Error3");
$ii++;
}


for($i=0;$i<11-$rowcounter;$i++) // For adding additional blank rows.
echo '<tr style= "border-bottom-color:#FFFFFF" align="center"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>'; 


?>
					</table>
					<p><i>* Indicates discounted items <br>H-Hourly, M-Membership, A-Advance Payment </i></p>
					<table width="100%">
					<tbody><tr>
						<td width="25%">
							<div id="add"> </div>
						</td>
						<td align="center" width="50%">
							<div id="grand_total"><font size="5"><b>TOTAL: $<? echo number_format(($total), 2); ?></b></font></div>
						</td>
						<td align="right" width="25%">
							
							</div>
						</td>
					</tr>
					</tbody></table>
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
						<br><br>Please return a Requisition or Check for the total shown above to:<br><br>
						Attn: 
                        <? 		$rs = new CustomerDAO();
								echo $rs->getManagerName($_SESSION['mid'],$_SESSION['login']);
						?>
						<br>University of Southern California
						<br>Univeristy Park
						<br>CEM 200, MC 0101
						<br>Los Angeles, CA 90089-0101
						<br>Checks should be payable to:
						<br>University of Southern California		
					</font>
				</center></td>
			</tr>
		</tbody></table>
		</td>
		</tr>
		</tbody></table>
		
		
	<noscript></noscript>
	</td></tr></tbody></table>
	
	<? 
	/* Solve for Manager_ID */ 
	//echo "pop".$curryear;
	$sql2 = "insert into Invoice values ('', ". $_SESSION['mid'].", curdate(), '$invoiceno', '$curryear', '$name', '$fromdate', '$todate', '$total', '$pq', 'Unpaid', '$managername')";
	mysql_query($sql2) or die("Error in inserting the Invoice in the database");
	
	writeLog("Invoice MO ".substr($curryear,2,2). '/' .$invoiceno. " generated for $name of  $$total");

	$Gdate = Date("Y-m-d");
	$host = "http://cemma-usc.net/cemma/testbed";
	$filename = "view_invoice2.php";
	
	$params = "invoiceno=$invoiceno&Gdate=$Gdate&name=".urlencode($name)."&pagenum=1";
	$content = "The invoice has been generated for $name\n\nTo see the detailed invoice, please click on the link given below\n\n".$host."/".$filename."?".$params."\n\n\ Thank You,\nCEMMA Admin";
	
	//mail( "curulli@usc.edu", "Invoice Generated for $name", $content, "From: CEMMA" );



	mysql_close($connection);
	
	?>
	
<?php  	
function writeLog($string){
/*
$xdoc = new DomDocument;
$xdoc->Load('activities/JohnCurulli123.xml');
$activities = $xdoc->getElementsByTagName('Activities')->item(0);

$activityElement = $xdoc->createElement('Activity');
$titleElement = $xdoc->createElement('Title');
$dateElement = $xdoc->createElement('Date');
$titleTxt = $xdoc->createTextNode("$string");
$dateTxt = $xdoc->createTextNode(date('F d, H:i'));

$dateElement->appendChild($dateTxt);
$titleElement->appendChild($titleTxt);

$activityElement->appendChild($titleElement);
$activityElement->appendChild($dateElement);

$x = $xdoc->getElementsByTagName('Activity')->item(0); 

$activities -> insertBefore($activityElement, $x);

$test = $xdoc->save('activities/JohnCurulli123.xml');
*/
}
	
	
?>