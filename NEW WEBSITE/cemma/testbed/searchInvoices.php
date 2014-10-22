<?
include_once ('constants.php');
include_once (DOCUMENT_ROOT . "includes/checklogin.php");
include_once (DOCUMENT_ROOT . "includes/checkadmin.php");
if ($class != 1) {
	header('Location: login.php');
}

	$id =  $_GET['id'];

if (!isset($_POST['invoiceNo'])) {
	 	header('Location: statistics.php?id=$id');
}

include (DOCUMENT_ROOT . 'tpl/header.php');

include_once (DOCUMENT_ROOT . "includes/action.php");

$invoiceNo = $_POST['invoiceNo'];
$invoiceYear = $_POST['invoiceYear'];

	$fromDatePost = isset($_REQUEST["fromDateInv"]) ? $_REQUEST["fromDateInv"] : "";
	$dateArray = explode('/',$fromDatePost);
	$fromDay = 	$dateArray[2];
	$fromMonth = $dateArray[1];
	$fromYear = $dateArray[0];
	
	$toDatePost = isset($_REQUEST["toDateInv"]) ? $_REQUEST["toDateInv"] : "";
	$dateArray = explode('/',$toDatePost);
	$toDay = $dateArray[2];
	$toMonth = $dateArray[1];
	$toYear = $dateArray[0];
	
$customerName = $_POST['CustomerNameI'];
$schoolName = $_POST['SchoolNameI'];
$searchCriteria = $_POST['searchCriteria'];

$ctype1 = $_POST['customers_type1'];
$ctype2 = $_POST['customers_type2'];
$ctype3 = $_POST['customers_type3'];

$minTotal = $_POST['minTotalI'];
$maxTotal = $_POST['maxTotalI'];
$status = $_POST['statusI'];

#$pagenum = $_GET['pageId'];
$pagenum = $_GET['resultpage'];
$year = "20" . $invoiceYear;

$fromDate = "$fromYear-$fromMonth-$fromDay";
$toDate = "$toYear-$toMonth-$toDay";
#echo "cname:".$customerName;
?><head>
	<!-- .printcontent1 { position: absolute; top: 10px; left: 10px; }
	position:absolute;
	left:10px;
	top:15px;

	.printcontent2 * { visibility: visible; }
	.printcontent2 { position: absolute; top: 150px; left: 10px; }

	.dont2 {
	visibility: hidden;
	}
	.dont3{
	display:none;
	}
	.dont4* {
	display:none;
	}

	-->
	<style>
		@media print {

		body * { visibility: hidden; }

		.printcontent1 * { visibility: visible; }
		.printcontent1 { position: absolute; top: 40px; left: 235px; }

		.printcontent2 * { visibility: visible; }
		.printcontent2 {
		position:absolute;
		left:225px;
		top:200px; }

		.dont1 {
		visibility: hidden;

		}
		black  {color:black;}
		a:link {color:black;}
		table  {width:573px; height:43px; vertical-align:top; background:url(../images/table-top-bg.gif) no-repeat top left; padding:14px 15px 12px 12px; }
		td
		{
		border: 1px solid black;
		width: 250;

		}

		.break { page-break-before: always; }
	</style>
</head>
<?
//echo $ctype1."<br>";
//echo $ctype2."<br>";
//echo $ctype3."<br>";
?>


<div class="printcontent1">
	<div class="hide">
		<?
		echo "<center>INVOICES</center>";

		echo "From: $fromMonth/$fromYear To: $toMonth/$toYear";

		if ($invoiceNo == "") {echo " Invoice No. = None , ";
		} else {echo " Invoice No. =$invoiceNo , ";
		}

		if ($invoiceYear == "") {echo " Invoice Year = Any , ";
		} else {echo " Invoice Year =20$invoiceYear , ";
		}

		if ($customerName == -1) {echo " Customer Name = All Customers , ";
		} else {echo " Customer Name =$customerName , ";
		}

		if ($minTotal == "") {echo " Min Total = NULL , ";
		} else {echo " Min Total =$minTotal , ";
		}

		if ($maxTotal == '') {echo " Max Total = NULL , ";
		} else {echo " Max Total =$maxTotal , ";
		}

		if ($status == -1) {echo " Status = Any";
		} else {echo " Status =$status";
		}
		?>
	</div>
</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td class="body" valign="top" align="center">
        <? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?>
		<table border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td class="body_resize">
				<table border="0" cellpadding="0" cellspacing="0" align="left">
					<tr>
						<td><h2 class = "Our"><img src = "images/h2_servises.gif" style="margin-right:10px; vertical-align:middle">Find Invoices</h2>
						<form action = "searchInvoices.php" method="post" name="myForm">
							<input type="hidden" name = "o" id = "o" value = "<?=$_POST['o']?>">
							<input type = "hidden" name="orderby" id = "orderby" value = "<?=$_POST['orderby']?>">
							<? //Check if user has asked to remove a record

								$msg = '';
								if (isset($_GET['action']) && $_GET['action'] == 3) {
									$rm = new InvoiceDAO();
									$rm -> remove($_GET['id']);
									$msg = "Invoice has been deleted successfully";
								}
							?>

							<?
							foreach ($_POST as $field => $value) {
								if ($field != 'orderby' && $field != 'o')
									echo "<input type=\"hidden\" name=\"" . $field . "\" value=\"" . $value . "\" />";
							}
							?>

							<table width="100%" border="0" cellpadding="5" cellspacing="0">
								<tr valign="top">
									<td width="100%">
									<div align="center" class="err" id="error" style="display:none">
										Error Detected
									</div><?
											if ($msg != '')
												echo '<div align="center" class="alert" style="font-size:13; id="error1">' . $msg . '</div>';
									?>
									<div id = "div1" style="display:none"><p>&nbsp;</p></div>
									</td>
									</tr>
									</table>

									<table width="100%" border="0" cellpadding="5" cellspacing="0">
									<tr><td class="t-top">

									<?
									//Getting Invoice Details

									$rs = new InvoiceDAO();
									if($searchCriteria == "customer")
									{
										$rs -> searchInvoices($pagenum, 50, $_POST['orderby'], $_POST['o'], $invoiceNo, $year, $fromDate, $toDate, "customer", $customerName, $minTotal, $maxTotal, $status, $ctype1, $ctype2, $ctype3);
									}
									else if($searchCriteria == "school")
									{
										$customerNameBySchool = "''";
										$sql_sch = "SELECT Name FROM Customer WHERE School='".$schoolName."'";
										$result_sch = mysql_query($sql_sch) or die( "An error has ocured in query: " .mysql_error (). ":" .mysql_errno ());
										$first_flag = true; 
										while($row_sch = mysql_fetch_array($result_sch))
										{
											if($first_flag==true) {
												$customerNameBySchool .= "'".$row_sch['Name']."'";
												$first_flag = false;
											} else {
												$customerNameBySchool .= ",'".$row_sch['Name']."'";
											}
										}
										$rs -> searchInvoices($pagenum, 50, $_POST['orderby'], $_POST['o'], $invoiceNo, $year, $fromDate, $toDate, "school", $customerNameBySchool, $minTotal, $maxTotal, $status, $ctype1, $ctype2, $ctype3);
									}
									$currentRowNum = $rs -> getStartRecord() * 1;
									?>

									<div class="title">Invoice Details	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									Print<img src = "images/printer.png" class = "printImg"onClick="window.print();return false;" value=" Print  " height = "16" width = "20" style="cursor:pointer"/></div>
									<div class="details"><?=$rs->getRecordsBar()?></div>
									<div class="pagin"><?=$rs->getPageNav()?></div>

									</div>
									</td></tr>
									<tr><td class="t-mid">
									<div class="printcontent2">
									<table align="center" cellpadding="0" cellspacing="0" border="0" class="Tcontent" width = "100%">
									<tbody>
									<tr bgcolor="#F4F4F4" align="center" class="Ttitle">
									<td  onclick="javascript:doAction(1, 7)" style="cursor:pointer">Entry</td>
									<td  onclick="javascript:doAction(1, 7)" style="cursor:pointer">Invoice No</td>
									<td  onclick="javascript:doAction(1, 1)" style="cursor:pointer">Customer Name</td>
									<td  onclick="javascript:doAction(1, 7)" style="cursor:pointer">Generated Dt</td>
									<td  onclick="javascript:doAction(1, 4)" style="cursor:pointer">Total</td>
									<td  onclick="javascript:doAction(1, 5)" style="cursor:pointer">PO/Req</td>
									<td  onclick="javascript:doAction(1, 6)" style="cursor:pointer">Status</td>
									<td class="dont1">Remove</td>
                                    <td >PDF Test</td>
									</tr>
									<?php

									// If there are no records
									$count1=$rs->getStartRecord();
									if($rs->getTotalRecords() == 0){

									?>

									<tr align="center">
									<td colspan = "7">No Records Found</td>
									</tr>

									<?php
									}

									else{

									// There are some records

									while ($row = $rs->fetchArray()){
									?>
									<tr class = "Trow" align = "center" style="font-size:12px">

									<?php
									$date_array = explode("-", $row['Gdate']);
									$var_year = $date_array[0];
									$var_month = $date_array[1];
									$var_day = $date_array[2];
									$var_year = substr($var_year, 2, 4);

									$Gyear = $var_year;
									if ($var_month > 6) {
										$Gyear = $Gyear + 1;
									}
									?>
									<td><? echo $count1 ?>
									<td><a href ="view_invoice2.php?invoiceno=<? echo $row['Invoiceno'] ?>&Gdate=<? echo $row['Gdate'] ?>&name=<? echo $row['Name'] ?>&pagenum=1"  target="_blank" class="black"><font class="black"><? echo 'MO ' . $Gyear . '/' . $row['Invoiceno'];?></font></a></td>
									<td><? echo $row['Name'] ?>
									<td> <? echo "$var_month/$var_day/$var_year";?></td>

									<td><? echo $row['Total'] ?></td>
									<?php if($row['PO']!= "") { ?>
									<td><a href = 'editInvoice.php?id=<?php echo $row['Number'] ?>'><? echo $row['PO'] ?></a></td>
									<?php } else {?>
									<td><a href = 'editInvoice.php?id=<?php echo $row['Number'] ?>' >PO/Req</a></td>
									<?php }?>
									<td><a href = 'editInvoice.php?id=<?php echo $row['Number'] ?>' ><? echo $row['Status'] ?></a></td>
									<td class="dont1"><a href="javascript:doAction(3,<?=$row['Number']?>)" class="dont1"><img src = "images/trash_icon.gif" border = "0" alt = "Remove" class="dont1"></a></td>

									<!--  PDF Test with dompdf -->
									<td><a href ="view_invoice2_test.php?invoiceno=<? echo $row['Invoiceno'] ?>&Gdate=<? echo $row['Gdate'] ?>&name=<? echo $row['Name'] ?>&pagenum=1"  target="_blank" class="black"><font class="black">PDF Test1</font></a></td>

									</tr>

									<?
									$currentRowNum++;
									$count1++;
									}

									}
									?>

									</tbody>
									</table>
									</div>
									</td>
									</tr>
									<tr>
									<td class="t-bot2-800">

									<a href = "statistics.php?open=invoice">Return to Query&nbsp&nbsp</a>
									</td>
									</tr>
									</table>
									</form>

									</td></tr></table>
									<div class="clr"></div>
									</td></tr></table>

									</td></tr></table>

									</td></tr></table>
									<?
										include ('tpl/footer.php');
 ?>
