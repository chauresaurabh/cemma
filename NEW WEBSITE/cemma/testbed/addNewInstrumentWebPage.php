 <?  
     session_start();
	$dbhost="db1661.perfora.net";
	$dbname="db260244667";
	$dbusername="dbo260244667";
	$dbpass="curu11i";

	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
 	
	$instrumentname = $_POST['instrumentname'];
	$description = $_POST['description'];
 	
	$primaryfirstname = $_POST['primaryfirstname'];
	$primarylastname = $_POST['primarylastname'];
	$primaryemail = $_POST['primaryemail'];
	$primaryphonenumber = $_POST['primaryphonenumber'];
	
	$secondaryfirstname1 = $_POST['secondaryfirstname1'];
	$secondarylastname1 = $_POST['secondarylastname1'];
	$secondaryemail1 = $_POST['secondaryemail1'];
	$secondaryphonenumber1 = $_POST['secondaryphonenumber1'];
	 
	$secondaryfirstname2 = $_POST['secondaryfirstname2'];
	$secondarylastname2 = $_POST['secondarylastname2'];
	$secondaryemail2 = $_POST['secondaryemail2'];
	$secondaryphonenumber2 = $_POST['secondaryphonenumber2'];
 	
 	$fileName = $_FILES['file']['name'];
 	if ( $_FILES['file']['error'] == 0 ) {
        	 move_uploaded_file($_FILES['file']['tmp_name'], 'instrumentimages/' .$fileName);
     }
	
	 $sql="";
	 $image="";
	 if($fileName==''){
			 		  $image = "staffmembers/nophoto.jpg";	  
 	 }else{
		 			 $image = "instrumentimages/".$fileName;	
 	 }
	 
	   $sql = "insert into INSTRUMENTS_WEB_PAGE (instrumentname, description, image, primaryfirstname, primarylastname, primaryemail, primaryphonenumber , secondaryfirstname1 , secondarylastname1, secondaryemail1, secondaryphonenumber1, secondaryfirstname2 , secondarylastname2, secondaryemail2, secondaryphonenumber2) 
	  VALUES ('$instrumentname', '$description', '$image', '$primaryfirstname', '$primarylastname', '$primaryemail', '$primaryphonenumber' , '$secondaryfirstname1' , '$secondarylastname1', '$secondaryemail1', '$secondaryphonenumber1', '$secondaryfirstname2' , '$secondarylastname2', '$secondaryemail2', '$secondaryphonenumber2');";
	  
	 $result = mysql_query($sql);
	 
	 $numRows =  mysql_affected_rows();
	$outputStr="";
	 
	if($numRows > 0)
	{
		 $outputStr = " { result : 1 }";	// success
 	}else{
	 	$outputStr = " { result : 0 }";		//error
	}
	echo $outputStr;
   
	 mysql_close();
	session_write_close();
 
?>   						
  
 