<?
	include_once("../includes/DatabaseOld.php");
	$instrument = $_GET["instr"];
	$year = $_GET["yr"];
	$month = $_GET["mth"];
	
	if($instrument!='' && $year!='' && $month!='')
	{
		$date_from = $year.'-'.$month.'-01';
		$date_to = $year.'-'.$month.'-31';
			
		#$sql = "SELECT Date, UsedBy, Slot FROM schedule WHERE Instrumentname = '$instrument' AND Date >= '$date_from' and Date < '$date_to' ");
		$sql = "SELECT Date, COUNT(UsedBy) FROM  `schedule` WHERE DATE >= '$date_from' AND DATE <=  '$date_to' GROUP BY Date";
		#echo $sql."<br>";
		
		$result=mysql_query($sql) or die( "An error has ocured in query: " .mysql_error (). ":" .mysql_errno ()); 
		
		$usedCount = array();
		$html='';
		while($row = mysql_fetch_array($result))
		{
			#echo date("Y-m-d", mktime(0,0,0,$m,$d,$y))."<br>";
			#$usedCount[date("Y-m-d", mktime(0,0,0,$m,$d,$y))] = $row['COUNT(UsedBy)'];
			$usedCount[$row['Date']] = $row['COUNT(UsedBy)'];
			
			#$html .= $date[0].'|'.$date[1].'|'.$date[3].'|'.$row[1].''
			#$html.='<option value="'.$row['Name'].'">'.$row['Name'].'</option>';
		}
		for ($i=1; $i<32; $i++)
		{
			$idx = date("Y-m-d", mktime(0,0,0,$month,$i,$year));
			#echo $idx."<br>";
			if ($usedCount[$idx]=='')
			{
				$html .='0|';
			}
			else
			{
				$html .=$usedCount[$idx].'|';
			}
			#echo $i.'-'.($usedCount[$i])."<br>";
			#$html .=$num.'|';
		}
		echo $html;
		mysql_close($connection);
	}
	else
		echo "ERROR|Wrong parameters!";
	
?>