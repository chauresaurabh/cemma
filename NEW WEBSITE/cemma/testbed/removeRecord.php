<?
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."util.php");
	include_once (DOCUMENT_ROOT.'DAO/recordDAO.php'); 

?>

<?php

$number = $_GET['number'];

$films = array();
$films = array("Film - EM Film TEM");

$rs = new RecordDAO();
$rs->getSingleRecord($number);


while($row = $rs->fetchSingleRecord()){

	$date =$row['Date'];
	$name = $row['Name'];
	$machine = $row['Machine'];
	$invoiceno = $row['invoiceno'];
	$Gdate = $row['Gdate'];

}

$date_array = explode("-",$date);
$year  = $date_array[0];
$month = $date_array[1];

$fromdate = "$year-$month-01";
$todate = "$year-$month-31";


//updateFurtherDiscounts($fromdate, $todate, $name, $machine, $films);

$sql = "select Total from Customer_data where Invoiceno = '$invoiceno' AND Gdate = '$Gdate'";
$result = mysql_query($sql) or die ("Error in Total");
$edit_total = 0;
while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$edit_total += $row['Total'];
}
$sql = "UPDATE Invoice SET Total = '$edit_total' WHERE invoiceno = '$invoiceno' AND Gdate = '$Gdate'";
mysql_query($sql) or die ("Error in Updating Total");

// Removing the record

$rm = new RecordDAO();
$rm->remove($number);
		


mysql_close($connection);

?>

