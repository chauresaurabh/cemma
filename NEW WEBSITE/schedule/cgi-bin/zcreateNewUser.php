<?php



$fname  = $_GET['fname'];
$lname  = $_GET['lname'];
$email  = $_GET['email'];

echo "received message from ". $fname." .. ".$lname." .. ".$email;


	$dbhost="db1661.perfora.net";
	$dbname="db260244667";
	$dbusername="dbo260244667";
	$dbpass="curu11i";
	
	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
	
 	$sql = "select * FROM user WHERE Email='$email' and FirstName='$fname' and LastName='$lname' ";  
	$result = mysql_query($sql);
	
	if(	mysql_num_rows($result)>0	){
		echo 1;
	}else{
		echo 0;
	}
	
?>