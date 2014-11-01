 
<?
 session_start();
	$dbhost="db1661.perfora.net";
	$dbname="db260244667";
	$dbusername="dbo260244667";
	$dbpass="curu11i";

	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
  	 
	 $firstname = $_GET['firstname'];  
	 $lastname = $_GET['lastname'];  
	  
	 $email = $_GET['email'];
  	 $phonenumber = $_GET['phonenumber'];
   	 $designation = $_GET['designation'];
   
   	 $fileName = $_FILES["file"]["name"];
   
	 $sql = "insert into PROFESSIONAL_STAFF (firstname, lastname, email, phonenumber, designation) VALUES ('$firstname','$lastname','$email', '$phonenumber', '$designation' );";
	 $result = mysql_query($sql);
	 
	 $numRows =  mysql_affected_rows();
	$outputStr="";
	echo $sql;
	if($numRows > 0)
	{
		 $outputStr = "{'recordupdated':'Record Added Successfully !'}";
 	}else{
	 	$outputStr = "{'recordupdated':'Error inserting record in database!$fileName'}";
	}
	echo $outputStr;
  
  
 mysql_close();
session_write_close();
?> 
 