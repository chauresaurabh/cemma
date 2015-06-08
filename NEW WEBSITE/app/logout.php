<?php 	
	
	date_default_timezone_set("America/Los_Angeles");
	$userName = $_POST['usr'];
	$instrument = $_POST['inst'];
	$loginDate = $_POST['date'];
	$loginTime = $_POST['time'];

	$status = "OK";
	$userCharged = "";
	$userCharged = $_POST['userCharged'];
	$operatorSelected = $_POST['operatorSelected'];
	
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
	
	$loginLogoutMinuteDifference = ($logoutHour*60+$logoutMinute)-($loginHour*60+$loginMinute);
	
	$year = date("Y");
	$month = date("m");
	$fromdate = "$year-$month-01";
	$todate = "$year-$month-31";
 	
	$TotalTrainingHrs=0.0;
	$UsedTrainingHrs=0.0;
	$BillUserName="";
	
	$isTraining=1;
	
	$userEmail = "";
	//Get Users's Customer (Advisor)
	include_once ("database.php");
	$sql = " SELECT UserName, Email, Name, Advisor , TotalTrainingHrs	, UsedTrainingHrs  FROM user WHERE UserName='".$userName."'";
	$result1 = mysql_query($sql,$connection);
	
	if(mysql_num_rows($result1)==0){
		$status = "ERROR";
		$msg = "Invalid User!";
	} else {
		$row1 = mysql_fetch_array($result1);
		$customerName = $row1['Advisor'];
		$operator = $row1['Name'];
 		$BillUserName = $row1['BillUserName'];
	
 		$TotalTrainingHrs= $row1['TotalTrainingHrs'];
		$UsedTrainingHrs= $row1['UsedTrainingHrs'];
		$userEmail = $row1['Email'];
		
		if($userCharged!="" && $userCharged!=$userName){
			$userChargedSql = "select Name from user where UserName = '".$userCharged."'";
			$userChargedResult = mysql_query($userChargedSql);
			$userChargedRow = mysql_fetch_array($userChargedResult);
			$userCharged = $userChargedRow['Name'];
		} else {
			$userCharged = $row1['Name'];
		}
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
	//echo $diffMinute.'/'.$qty;
	//END Calculate time Qty
	
	//Get Rate(UnitPrice) of Instrument
	$sql = "SELECT * FROM rates WHERE machine_name = '$instrument'";
	$result3 = mysql_query($sql) or die( "An error has occurred: " .mysql_error (). ":" .mysql_errno ());
	
	$instrNo  = 0 ;
	$trainingRate = 0;
	if(mysql_num_rows($result3)==0){
		$status = "ERROR";
		$msg = "Invalid Instrument Rate!";
	} else {
		$row = mysql_fetch_array($result3);
		$unit = $row[$type."_".$strWithOperator];
		
		$instrNo = $row['InstrumentNo'];
		
		$trainingRate = $row['trainingRate'];

	}
	
	//Get Training Rate
	$sqlInstr = "SELECT * FROM instr_group WHERE InstrNo = '$instrNo' and Email='$userEmail' ";
	$resultInstr = mysql_query($sqlInstr) or die( "An error has occurred: " .mysql_error (). ":" .mysql_errno ());
		
	if(mysql_num_rows($resultInstr)==0){
		$status = "ERROR";
		$msg = "Invalid Training Instrument Rate!";
	} else {
		$rowInstr = mysql_fetch_array($resultInstr);
		$UsedTrainingHrs = $rowInstr['UsedTrainingHrs'];
	}
	
	//Calculate Total price
	$total = $unit * $qty;
	
	//Set OverriddenFlag as default 0
	$overriddenFlag = '0';
	
	//Add Records to Customer_data table
	//Copied from the file "/cemma/testbed/add_record.php"
	
		if($loginLogoutMinuteDifference > 10){
			 
			if($UsedTrainingHrs > 0){
						$finalQty =  $UsedTrainingHrs-$qty ;
							if(  $finalQty  >= 0  ){
 								$sqlss = "UPDATE instr_group SET UsedTrainingHrs = '$finalQty' where InstrNo = '$instrNo' and Email='$userEmail' ";	
 								mysql_query($sqlss) or die( "An error has occurred: " .mysql_error (). ":" .mysql_errno ());
 						
						$finalTotal = $trainingRate * $qty;
	$sql = "INSERT INTO Customer_data (Name, Machine, Qty, Date, Time, Operator, UserCharged, Type, WithOperator, CemmaStaffMember, Unit, Total, Manager_ID, Customer_ID, OverriddenFlag, DiscountQty, isTraining, logouttime ) 
				VALUES ('$customerName', '$instrument', '$qty', '$loginYear-$loginMonth-$loginDay', '$loginTime', '$operator','$userCharged', '$type', '$withOperator', '$operatorSelected', '$trainingRate', '$finalTotal', '$mid', '$cid', '$overriddenFlag', '$unit' , '$isTraining' ,'$logoutTime' )";
			mysql_query($sql) or die( "An error has occurred: " .mysql_error (). ":" .mysql_errno ());
			
							}else if( $finalQty < 0 ){
								// insert flag for training check
								$finalQty123 = 0.0;
 $sqlss123 = "UPDATE instr_group SET UsedTrainingHrs = '$finalQty123' where InstrNo = '$instrNo' and Email='$userEmail' ";	
 								mysql_query($sqlss123) or die( "An error has occurred: " .mysql_error (). ":" .mysql_errno ());
 						
								$finalTotal = $trainingRate * $UsedTrainingHrs;
	$sql = "INSERT INTO Customer_data (Name, Machine, Qty, Date, Time, Operator, UserCharged, Type, WithOperator, CemmaStaffMember, Unit, Total, Manager_ID, Customer_ID, OverriddenFlag, DiscountQty, isTraining , logouttime) 
				VALUES ('$customerName', '$instrument', '$UsedTrainingHrs', '$loginYear-$loginMonth-$loginDay', '$loginTime', '$operator','$userCharged', '$type', '$withOperator', '$operatorSelected', '$trainingRate', '$finalTotal', '$mid', '$cid', '$overriddenFlag', '$unit', '$isTraining' , '$logoutTime' )";
			mysql_query($sql) or die( "An error has occurred: " .mysql_error (). ":" .mysql_errno ());
						
								$finalQty = abs($finalQty);
								$finalTotal = $unit * $finalQty;

								$sql = "INSERT INTO Customer_data (Name, Machine, Qty, Date, Time, Operator, UserCharged, Type, WithOperator, CemmaStaffMember, Unit, Total, Manager_ID, Customer_ID, OverriddenFlag, DiscountQty , logouttime) 
				VALUES ('$customerName', '$instrument', '$finalQty', '$loginYear-$loginMonth-$loginDay', '$loginTime', '$operator','$userCharged', '$type', '$withOperator', '$operatorSelected', '$unit', '$finalTotal', '$mid', '$cid', '$overriddenFlag', '$unit' , '$logoutTime' )";
			mysql_query($sql) or die( "An error has occurred: " .mysql_error (). ":" .mysql_errno ());
			
							}
			}else{
				$sql = "INSERT INTO Customer_data (Name, Machine, Qty, Date, Time, Operator, UserCharged, Type, WithOperator, CemmaStaffMember, Unit, Total, Manager_ID, Customer_ID, OverriddenFlag, DiscountQty , logouttime) 
				VALUES ('$customerName', '$instrument', '$qty', '$loginYear-$loginMonth-$loginDay', '$loginTime', '$operator','$userCharged', '$type', '$withOperator', '$operatorSelected', '$unit', '$total', '$mid', '$cid', '$overriddenFlag', '$unit' , '$logoutTime' )";
			mysql_query($sql) or die( "An error has occurred: " .mysql_error (). ":" .mysql_errno ());
			}
		}
	
	$film = array();	//empty array; actually film is out of use in the function
	updateFurtherDiscounts($fromdate, $todate, $customerName, $instrument, $film);
	
	
	if ($status == "ERROR")
	{
		echo '{status:"'.$status.'", msg:"'.$msg.'"}';
		
	}
	else
	{
		echo '{status:"'.$status.'", operator:"'.$operator.'", date:"'.$loginDate.'", login:"'.$loginTime.'", logout:"'.$logoutTime.'", qty:"'.$qty.'", inst:"'.$instrument.'", discount: "'.$discountUnit.'", customer:"'.$customerName.'", total:"'.$total.'"}';
	}
	
	
function updateFurtherDiscounts($fromdate, $todate, $name, $machine, $films){
	//Copied from the file "/cemma/testbed/add_record.php"
	$sql = "select * from Customer_data where Name = '$name' and Date between '$fromdate' and '$todate' order by Number";
	//$sql = "select * from Customer_data where Name = '$name' order by Number desc";
	#echo '<br>'.$sql.'<br>'; 
	$result = mysql_query($sql) or die ("Error in sql5");
	
 	$currQty = 0;
	$count = 0;
	
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		$total = $row['Qty']*$row['Unit'];
		$number = $row['Number'];
		$discountFlag = 0;
		$overriddenFlag = $row['OverriddenFlag'];
		$unit = $row['Unit'];
	
		/*echo "Record number = ".$count."<Br>";
		echo "Qty is ".$row['Qty']."<br>";
		echo "Original Price = ".$total."<Br>";
		echo "Current Quantity is = ".$currQty."<br>";*/
	
		$type = $row['Type'];
		if($row['WithOperator'] == 1)
			$string = "With_Operator";
		else
			$string = "Without_Operator";
	
		$final = $type."_".$string;
	
		#echo "<br>Type is ".$final."<BR>";
		#echo "CurrQty:".$currQty."<br>";
		
		if($currQty>=10 && $final == 'On-Campus_Without_Operator'){
			$total = $total/2;
			//echo "Discount applied<br>";
			$discountFlag = 1;
	
		}
	
		$filmMachine = false;
	
		for($i=0;$i<=count($films);$i++){
	
			//echo "<BR>machine is ". $row['Machine'];
			//echo "<BR>Film is ".$films[$i];
			if($row['Machine'] == $films[$i]){
				$total = $row['Qty']*$row['Unit'];
				#echo "total UPDATED";
				$discountFlag = 0;
				$filmMachine = true;
				break;
			}
	
		}
	
	
		if($row['WithOperator'] == 0 && $filmMachine == false)
			$currQty += $row['Qty'];
			
		if($overriddenFlag != 1){
			if($discountFlag==1){
				$unit=$unit*0.5;
			}
			$sql = "UPDATE Customer_data SET Total = '$total', DiscountFlag = '$discountFlag', DiscountQty = '$unit' where Name = '$name' AND Number= '$number' ";			
		}
	
		$count++;
	
		#echo $sql;
		mysql_query($sql) or die ("Error in Edit Data");
	}

}
?>