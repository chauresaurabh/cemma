<?php
 	include_once ("database_old.php");
	date_default_timezone_set("America/Los_Angeles");
	#$username = $_POST['usr'];
    #$password = $_POST['pw'];
	$instrument = $_POST['inst'];
	#$operator = $_POST['op'];
	
	$status = "";
	$msg = "";
	
	$output = "";
	
	$sql1 = "SELECT * FROM instrument WHERE InstrumentName='$instrument'";
	#echo $sql1;
	$result1 = mysql_query($sql1,$connection);
	
	if(mysql_num_rows($result1)==0){
		$status = "ERROR";
		$msg = "Invalid Instrument!";
	} else {
		$status = "OK";
		while ($row1=mysql_fetch_array($result1))
		{	
			$instlist .=$row1['InstrumentName'].'|';
		}
		
	}
	if ($status == "ERROR")
	{
		echo "status=".$status."&msg=".$msg;
	}
	elseif ($status == "OK")
	{
		echo "status=".$status."&instlist=".$instlist;
	}
	
?>