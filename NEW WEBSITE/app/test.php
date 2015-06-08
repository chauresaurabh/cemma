<?php

	
	//include_once("util.php");
	date_default_timezone_set("America/Los_Angeles");
	$userName = $_GET['usr'];
	$instrument = $_GET['inst'];
	$loginDate = $_GET['date'];
	$loginTime = $_GET['time'];
	
	/*	
	$overriddenFlag = $_POST['orflag' ];

	$operator = $_POST['Operator'];
	$invoiceno = $_POST['invoiceno'];
	$mid = $_SESSION['mid'];
	$actualUnitPrice = $_POST['actualUnitPrice'];
	$unitPrice = $_POST['unit'];
	$total = $_POST['total'];
	$overriddenFlag = $_POST['overriddenFlag' ];
	*/
	$status = "OK";
	
	//Parameter Check
	if($userName=="" || $instrument=="" || $loginDate=="" || $loginTime=="")
	{
		$status = "ERROR";
		$msg = "Incorrect parameters!";
	}
	//Get WithOperator option
	if($_POST['wop']=="Yes")	{
		$withOperator = '1';
		$strWithOperator = "With_Operator";	
	} else 	{
		$withOperator = '0';
		$strWithOperator = "Without_Operator";	
	}

	//Get LogIn Date/Time
	$loginMonth = strtok($loginDate, '/');
	$loginDay = strtok('/');
	$loginYear = strtok('/');
	$loginHour = strtok($loginTime,':');
	$loginMinute = strtok(':');
	$loginSecond = strtok(':');

	//Set LogOut Date/Time params
	$logoutDate = date("m/d/Y");
	$logoutMonth = date("m");
	$logoutDay = date("d");
	$logoutTime = date("H:i:s");
	$logoutHour = date("H");
	$logoutMinute = date("i");
	$logoutSecond = date("s");
	
	$year= date("Y");
	$fromdate = "$year-$month-01";
	$todate = "$year-$month-31";

	//Get Users's Customer (Advisor)
	include_once ("database_old.php");
	$sql = " SELECT UserName, Name, Advisor  FROM user WHERE UserName='".$userName."'";
	$result1 = mysql_query($sql,$connection);
	
	if(mysql_num_rows($result1)==0){
		$status = "ERROR";
		$msg = "Invalid User!";
	} else {
		$row1 = mysql_fetch_array($result1);
		$customerName = $row1['Advisor'];
		$operator = $row1['Name'];
	}

	//Get Customer's type
	include_once ("database.php");
	$sql = " SELECT Name, Type, Customer_ID, Manager_ID  FROM Customer WHERE Name='".$customerName."'";
	$result2 = mysql_query($sql,$connection);	

	if(mysql_num_rows($result2)==0){
		$status = "ERROR";
		$msg = "Invalid Customer!";
	} else {
		$row2 = mysql_fetch_array($result2);
		$type = $row2['Type'];
		$cid = $row2['Customer_ID'];
		$mid = $row2['Manager_ID'];
	}
	
	//Calculate Quantity of the time
	$diffDay = (int)$logoutDay - (int)$loginDay;
	$diffHour = (int)$logoutHour - (int)$loginHour;
	$diffMinute = (int)$logoutMinute - (int)$loginMinute;
	$diffSecond = (int)$logoutSecond - (int)$loginSecond;
	
	$qty = $diffDay*24 + $diffHour;
	$diffMinute = (int)$logoutMinute - (int)$loginMinute;
	$diffSecond = (int)$logoutSecond - (int)$loginSecond;
	if($diffMinute < 0)
	{
		$qty = $qty - 1;
		$diffMinute = $diffMinute + 60;
	}
	if($diffSecond < 0)
	{
		$diffMinute = $diffMinute - 1;
		$diffSecond = $diffSecond + 60;	//not in use
	}
	
	
	
	if($qty > 0)
	{
		//more than or equal 1hour of time Qty (1 hour~):
		// add 0.25hr in every 15min
		$qty = $qty + 0.25*(int)($diffMinute/15+1);
		
	} else {
		//less than 1 hour of time Qty (0.xx hour): 
		// add 0.5hr in first 30min, or add 0.25 in every next 15min
		if($diffMinute >= 0 && $diffMinute < 30)
			$qty = $qty + 0.5;
		elseif($diffMinute >= 30 && $diffMinute < 45)
			$qty = $qty + 0.75;
		elseif($diffMinute >= 45)
			$qty = $qty + 1.0;
	}
	echo $diffMinute.'/'.$qty;
	//END Calculate time Qty
	
	//Get Rate(UnitPrice) of Instrument
	$sql = "SELECT * FROM rates WHERE machine_name = '$instrument'";
	$result3 = mysql_query($sql) or die( "An error has occurred: " .mysql_error (). ":" .mysql_errno ());
	
	if(mysql_num_rows($result3)==0){
		$status = "ERROR";
		$msg = "Invalid Instrument Rate!";
	} else {
		$row = mysql_fetch_array($result3);
		$unit = $row[$type."_".$strWithOperator];
	}
	
	//Calculate Total price
	$total = $unit * $qty;
	
	//Set OverriddenFlag as default 0
	$overriddenFlag = '0';
	
	//Add Records to Customer_data table
	$sql = "INSERT INTO Customer_data (Name, Machine, Qty, Date, Operator, Type, WithOperator, Unit, Total, Manager_ID, Customer_ID, OverriddenFlag) 
				VALUES ('$customerName', '$instrument', '$qty', '$loginYear-$loginMonth-$loginDay', '$operator', '$type', '$woperator', '$unit', '$total', '$mid', '$cid', '$overriddenFlag')";
	
	mysql_query($sql) or die( "An error has occurred: " .mysql_error (). ":" .mysql_errno ());
	
	//updateFurtherDiscounts($fromdate, $todate, $name, $machine, $films);
	
	/*
	
	//Update other record in the same month
	$sql = "select Total from Customer_data where invoiceno = '$invoiceno' AND Gdate = '$Gdate' AND Manager_ID = '$mid'";
	$result = mysql_query($sql) or die ("Error in Total");
	$edit_total = 0;
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		$edit_total += $row['Total'];
	}
	$sql = "UPDATE Invoice SET Total = '$edit_total' WHERE invoiceno = '$invoiceno' AND Gdate = '$Gdate'";
	mysql_query($sql) or die ("Error in Updating Total");
	 * 
	 */

	if ($status == "ERROR")
	{
		echo '{status:"'.$status.'", msg:"'.$msg.'"}';
		
	}
	else
	{
		echo '{status:"'.$status.'", operator:"'.$operator.'", date:"'.$loginDate.'", login:"'.$loginTime.'", logout:"'.$logoutTime.'", qty:"'.$qty.'", inst:"'.$instrument.'", customer:"'.$customerName.'", total:"'.$total.'"}';
	}
	
	
?>