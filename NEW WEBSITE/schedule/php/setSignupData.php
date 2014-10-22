<?
	include_once("connectOldDB.php");
	$usedby = $_GET["usedby"];
	$instr_name = $_GET["instr"];
	$date = $_GET["date"];
	$slot = $_GET["slot"];
	#cemma-usc.net/schedule/php/setSignupData.php?usedby=dh&instr=JEOL JIB-4500 - FIB SEM&date=2012-02-03&slot=4
	#$sql = "SELECT UserName FROM user WHERE ActiveUser='active' ORDER BY UserName";
	$sql = "UPDATE schedule SET Usedby='$usedby' WHERE InstrumentName='$instr_name' AND Date='$date' AND Slot='$slot' AND Status='1'"	;
	$result=mysql_query($sql) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
		
	$sql = "SELECT Usedby FROM schedule WHERE InstrumentName='$instr_name' AND Date='$date' AND Slot='$slot' AND Status='1'";
	$result=mysql_query($sql) or die( "An error has ocured in query2: " .mysql_error (). ":" .mysql_errno ()); 
	$row = mysql_fetch_array($result);
	
	$output = "";
	while($row = mysql_fetch_array($result))
	{
		$output.=$row['Usedby'];
	}
	echo $output;
	mysql_close($connection);
?>