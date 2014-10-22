<?php



$fname  = $_GET['fname'];
$lname  = $_GET['lname'];
$email  = $_GET['email'];

$returnvalue = 0;
 //echo "received message from ". $fname." .. ".$lname." .. ".$email;
 
	$dbhost="db1661.perfora.net";
	$dbname="db260244667";
	$dbusername="dbo260244667";
	$dbpass="curu11i";
	
	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
	
 	$sql = "select * FROM user WHERE Email='$email' and FirstName='$fname' and LastName='$lname' ";  
	$result = mysql_query($sql);
	 
	if(	mysql_num_rows($result)>0	){
		$returnvalue = 1;
	}else{
		$sql2 = "select * FROM user WHERE Email='$email'  ";  
		$result2 = mysql_query($sql2);
 		if(	mysql_num_rows($result2)>0	){
			$returnvalue = 2;
		}else{
				$sql3 = " select * FROM user WHERE FirstName='$fname' and LastName='$lname'  ";  
				$result3 = mysql_query($sql3);
				if(	mysql_num_rows($result3)>0	){
					$returnvalue = 3;
				}
 		}
  	}
	
	echo $returnvalue;
?>