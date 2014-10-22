<?
	include_once("../includes/database.php"); 
	$name = $_GET['name'];

	$sql = "SELECT Customer_ID, Type FROM Customer WHERE Name = '$name' " ;
	$result = mysql_query($sql);

	if(mysql_num_rows($result)==0){
		echo "Error";
	} else {
		$row = mysql_fetch_array($result);
		echo "OK".'|'.$row['Customer_ID'].'|'.$row['Type'];
	}
	mysql_close($connection);

?>