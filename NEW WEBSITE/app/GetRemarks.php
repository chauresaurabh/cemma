<?php
	include_once ("database.php");
	date_default_timezone_set("America/Los_Angeles");
	//echo $instrument;
	$instrument = $_POST['inst'];
	$usr = array() ;
	$inst = array();
	$rema = array();
	$dt = array();
	$tme = array();
	$status = "OK";

if(! $connection )
{
	die('Could not connect: ' . mysql_error());
}
else{
			$sql2 = "SELECT username, remarks, date, time FROM `Remarks` WHERE instrument = '".$instrument."'
			 order by date desc, time desc";
			$result1 = mysql_query($sql2,$connection);
			$count = mysql_num_rows($result1)==0;
			if(mysql_num_rows($result1)==0){
			$status = "ERROR";
			$msg = "No remarks found!";
			}
			$index = 0; $values = array();
			while($row = mysql_fetch_array($result1)){
					$usr[] = $row ['username'];
					$rema[] =$row ['remarks'];
					$dt[] = $row ['date'];
					$tme[] = $row['time'];
					//$values[] = $row ;
					array_push($values, $row);
					//print "{\"remarks\":"+json_encode($values)."}";
				 	//$index++;
			}
			//print "{\"hi\":\"hello\"}";
			
		if ($status == "ERROR")
			{
				echo '{status:"'.$status.'", msg:"'.$msg.'"}';
				
			}
			else
			{
			//echo '{status:"'.$status.'", user:"'.$usr.'", date:"'.$dt.'", time:"'.$tme.'", remarks:"'.$rema.'" }';
			//echo '{status:"'.$status.'"}';

				print "{remarks:".json_encode($values)."}";
			}
	}
mysql_close();	
?>