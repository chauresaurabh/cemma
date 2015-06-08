<?
	include_once("../includes/databaseOld.php");
	$instrument = $_GET["instr"];
	$year = $_GET["yr"];
	$month = $_GET["mth"];
	$date_from = $year.'-'.$month.'-1'
	$date_to = $year.'-'.$month.'-31'
	
	$sql = "SELECT Date, UsedBy, Slot FROM schedule WHERE Instrumentname = '$instrument' AND Date >= '$date_from' and Date < '$date_to' ");
	$result=mysql_query($sql) or die( "An error has occurred in query2: " .mysql_error (). ":" .mysql_errno ()); 
	$row = mysql_fetch_array($result);
	
	$html.='<option value="Select the Customer">Select the Customer</option>';
	while($row = mysql_fetch_array($result))
	{
		$html.='<option value="'.$row['Name'].'">'.$row['Name'].'</option>';
	}
	
	echo $html;
	mysql_close($connection);
?>