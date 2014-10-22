<?php
 	include_once ("database_old.php");
	date_default_timezone_set("America/Los_Angeles");
	$username = $_POST['usr'];
    $password = $_POST['pw'];

	$status = "";
	$userclass = "";
	$msg = "";
	
	$output = "";
	
	$sql1 = "SELECT Name, Email, ActiveUser, UserClass FROM user WHERE UserName = '$username' AND Passwd = '$password'";
	//echo $sql1;
	$result1 = mysql_query($sql1,$connection);
	
	if(mysql_num_rows($result1)==0){
		$status = "ERROR";
		$msg = "Username or Password is invalid.";
	} else {
		$row1 = mysql_fetch_array($result1);
		if($row1['ActiveUser']=='inactive') {
			#$output = "ERROR|Inactiavted User!|";
			$status = "ERROR";
			$msg = "Inactiavted User!";
		} else {
			$userclass = $row1['UserClass'];

			$dbhost="db1661.perfora.net";
			$dbname="db260244667";
			$dbusername="dbo260244667";
			$dbpass="curu11i";
			
			$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
			$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
			
			$sql1 = "select Role_ID from Customer where Uname = '$username'";
			$result1 = mysql_query($sql1, $connection);
			if(mysql_num_rows($result1)==0){
				$status = "OK";
			} else {
				$row1 = mysql_fetch_array($result1);
				$status="OK";
				$userclass = $row1['Role_ID'];
			}
		}
	}
	if ($status == "ERROR")
	{
		echo '{status:"'.$status.'", msg:"'.$msg.'"}';
		
	}
	elseif ($status == "OK")
	{
		echo '{status:"'.$status.'", usr:"'.$username.'", class:"'.$userclass.'"}';
	}
	
?>	