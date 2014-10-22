<?
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."util.php");
	include_once (DOCUMENT_ROOT.'DAO/recordDAO.php'); 

?><?php

$number = $_GET['number'];

$sql = "SELECT * FROM Invoice WHERE Number = '$number'";
$result = mysql_query($sql) or die ("Error in Retrieving Invoice");

while($row = mysql_fetch_array($result, MYSQL_ASSOC)){

$invoiceno = $row['Invoiceno'];
$Gdate = $row['Gdate'];

}

$sql = "delete from Invoice where Number = '$number'";
mysql_query($sql) or die ("Error in Removing Invoice");

updateRecords($invoiceno, $Gdate);

echo "Invoice deleted successfully";

?>
<?php

function updateRecords($invoiceno, $Gdate){

//Retrieve BalanceUsed from Customer_Data
	$BalUsed=0;
	$counter=0;
  	$sql11 = "SELECT Balance_Used,Name FROM Customer_data WHERE invoiceno = '$invoiceno' and Gdate = '$Gdate'";
	$result11=mysql_query($sql11) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
	


	while($row11 = mysql_fetch_array($result11))
  {
  $BalUsed=$row11['Balance_Used'];
$CustName=$row11['Name'];
  
	//Update Advance_Payment
	if($BalUsed==NULL)
	{
	}
	else
	{
	$sql = "UPDATE Advance_Payment SET Balance=Balance+'$BalUsed' WHERE Customer_Name = '$CustName' ";
	mysql_query($sql) or die ("Error in Updating Record in A");
	//End Update Advance_Payment
	}
	 $counter++;
	
  }
//End Retrieve BalanceUsed from Customer_Data




$sql = "UPDATE Customer_data SET Generated = '0', Gdate = '0000-00-00', invoiceno = 0, Balance_Used=0 WHERE invoiceno = '$invoiceno' and Gdate = '$Gdate'";

mysql_query($sql) or die ("Error in Updating Record");

}

?>