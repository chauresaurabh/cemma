
<?php 

function updateFurtherDiscounts($fromdate, $todate, $name, $machine, $films){

	$sql = "select * from Customer_data where Name = '$name' and Date between '$fromdate' and '$todate' order by Date";
	//echo '<br>'.$sql.'<br>'; 
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
