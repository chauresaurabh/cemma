<?
	include_once('../constants.php');
	include_once(DOCUMENT_ROOT."includes/database.php");
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	
	$name = $_POST['name'];
	$curyear = $_POST['yr'];
	$fromdate = $_POST['fromdate'];
	$todate = $_POST['todate'];
	$pq = $_POST['pq'];
	$manager_name = $_SESSION['login'];
	$manager_id=$_SESSION['mid'];
	$invoiceno = $_POST['invno'];
	$payment_type = $_POST['ptype'];
	$total_amount = $_POST['tamt'];
	$begbalance = $_POST['begbal'];
	$balance = $_POST['rembal'];
	
	$checkbox = array();
	$checkbox = $_POST['checkbox'];
	
	$checked_numbers_arr = array();
	$checked_numbers_str = $_POST['chknbs'];
	$checked_numbers_token = strtok($checked_numbers_str, "|");

	$i = 0;
	while ($checked_numbers_token != false)
	{ 
		$checked_numbers_arr[$i] = $checked_numbers_token;
		$checked_numbers_token = strtok("|");
		//$output .= $checked_numbers_arr[$i].'_';
		$i++;
	}	
	
	if ($manager_name=="")
	{
		echo "ERROR|Sign in please!!";
		return;
	}
	else
	{
		$sql1 = "INSERT INTO Invoice VALUES ('', ". $_SESSION['mid'].", curdate(), '$invoiceno', '$curyear', '$name', '$fromdate', '$todate', '$total_amount', '$pq', 'Unpaid', '$manager_name', '$begbalance', '$balance')";
		mysql_query($sql1) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 		
		#mysql_query("UPDATE Customer_data SET Generated = '1', Gdate = curdate(), invoiceno = '$invoiceno' WHERE Number = '$number'") or die( "An error has ocured in query2: ");
		
		/*
		$output='name='.$name.' | ';
		$output.='curyear='.$curyear.' | ';
		$output.='fromdate='.$fromdate.' | ';
		$output.='todate='.$todate.' | ';
		$output.='pq='.$pq.' | ';
		$output.='manager_name='.$manager_name.' | ';
		$output.='manager_id='.$manager_id.' | ';
		$output.='invoiceno='.$invoiceno.' | ';
		$output.='payment_type='.$payment_type.' | ';
		$output.='total_amount='.$total_amount.' | ';
		$output.='balance='.$balance.' | ';
		*/
		$output = $invoiceno;
		
		if($payment_type=='3')
		{
			mysql_query("UPDATE Advance_Payment SET Balance = '$balance' WHERE Customer_Name = '$name'") or die( "An error has ocured in query3: ");
		}
	}
	
	for($i=0; $i<count($checked_numbers_arr); $i++)
	{
		$number = $checked_numbers_arr[$i];
		mysql_query("UPDATE Customer_data SET Generated = '1', Gdate = curdate(), invoiceno = '$invoiceno' WHERE Number = '$number'")  or die ("An error has ocured in query5");
		#$output .= $number.',';
	}
	/*
	$sql2 = "SELECT * FROM Customer_data WHERE Date between '$fromdate' and '$todate' and Generated = '0' and Name = '$name' and Manager_ID = ". $_SESSION['mid']." order by Date";
	$result2 = mysql_query($sql2) or die("An error has ocured in query4");

	$cnt = 0;
	$cc = 0;
	while($row = mysql_fetch_array($result2, MYSQL_ASSOC))
	{	
		if($checkbox[$cnt] == 0){
			$cnt++;
			continue;
		}
		else{
			$cnt++;
		}
		$number = $row['Number'];
		$sql3 = "UPDATE Customer_data SET Generated = '1', Gdate = curdate(), invoiceno = '$invoiceno' WHERE Number = '$number'";
		mysql_query($sql3)
		
		$cc++;
		$output .= $sql3;
		$output .= ' | ';
	}
	
	mysql_close($connection);
	
	echo $cc.' | '.$output;
	*/
	echo "OK|".$output;
?>
