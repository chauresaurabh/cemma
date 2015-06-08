<?php
	include_once ("database.php");
	date_default_timezone_set("America/Los_Angeles");
	/*$dbhost="db1661.perfora.net";
	$dbname="db260244667";
	$dbusername="dbo260244667";
	$dbpass="curu11i";
	$conn = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
    */
	
	$userName = $_POST['usr'];
	$instrument = $_POST['inst'];
	$remarks = $_POST['rem'];
	$loginDate = $_POST['date'];
	
	$dtArr = explode(":", $loginDate);
	$loginDate = trim($dtArr[2]).":".trim($dtArr[0]).":".trim($dtArr[1]);
	
	$loginTime = $_POST['time'];
	$status = "OK";
	
	
	//Parameter Check
	
	if($userName=="" || $remarks=="" || $loginDate=="" || $loginTime=="")
			{
			$status = "ERROR";
			$msg = "Incorrect parameters!";
			}	
/*	//Copied from the file "/cemma/testbed/add_record.php"
	$sql = "INSERT INTO Customer_data (Name, Machine, Qty, Date, Time, Operator, Type, WithOperator, Unit, Total, Manager_ID, Customer_ID, OverriddenFlag) 
				VALUES ('$customerName', '$instrument', '$qty', '$loginYear-$loginMonth-$loginDay', '$loginTime', '$operator', '$type', '$withOperator', '$unit', '$total', '$mid', '$cid', '$overriddenFlag')";
			
	*/
   $sql = "INSERT INTO Remarks(username,instrument,remarks, date, time) 
		VALUES('$userName', '$instrument','$remarks', '$loginDate', '$loginTime')";
		 mysql_query($sql,$connection) or die( "An error has occurred: " .mysql_error (). ":" .mysql_errno ());
		
	
	if ($status == "ERROR")
			{
				echo '{status:"'.$status.'", msg:"'.$msg.'"}';
				
			}
	else
	{
		echo '{status:"'.$status.'"}';
	}
	  
	  

	
	
	
		
	


?>