<?
	include_once("connectOldDB.php");
	
	$sql = "SELECT UserName FROM user WHERE ActiveUser='active' ORDER BY UserName";
		
	$result=mysql_query($sql) or die( "An error has occurred in query2: " .mysql_error (). ":" .mysql_errno ()); 
	$row = mysql_fetch_array($result);
	
	#$html = '<select style="width:100px">';
	$html ='<option value="None">Select User</option>';
	while($row = mysql_fetch_array($result))
	{
		$html.='<option value="'.$row['UserName'].'">'.$row['UserName'].'</option>';
	}
	#$html .= '</select>';
	echo $html;
	mysql_close($connection);
?>