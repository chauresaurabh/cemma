<?
	include_once("../includes/database.php");
	$customer_type = $_GET["type"];
	$mode_all = $_GET["mode_all"];
	
	$sql = "SELECT Name FROM Customer";
	if($customer_type=="curr")
	{
		$sql .= " WHERE Activated=1";
	}
	else if($customer_type=="arch")
	{
		$sql .= " WHERE Activated=0";
	}
	
	if (isset($_GET['school']))
	{
		$sql .= " AND FormerSchool=".$_GET['school'];
	}
	
	$sql .= " ORDER BY Name";
	$result=mysql_query($sql) or die( "An error has occurred in query2: " .mysql_error (). ":" .mysql_errno ()); 
	#$row = mysql_fetch_array($result);
	
	//$html.='<option value="Select a Customer">Select the Customer</option>';
	if ($mode_all=="on")
	{
		$html.='<option value="-1">All Customers</option>';
	}
	
	while($row = mysql_fetch_array($result))
	{
		$html.='<option value="'.$row['Name'].'">'.$row['Name'].'</option>';
	}
	
	echo $html;
	mysql_close($connection);
?>