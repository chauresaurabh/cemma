<? 
	 $dbhost="db1661.perfora.net";
	$dbname="db260244667";
	$dbusername="dbo260244667";
	$dbpass="curu11i";

	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
	
	$instrumentname = $_GET['instrument_name'];
	
	$sql2 = "select * from INSTRUMENTS_WEB_PAGE  where instrumentname ='$instrumentname'";
	$result2 = mysql_query($sql2);
	
	$outputstr="";
	
	while($row2=mysql_fetch_array($result2)){
		
		$instrumentname = $row2['instrumentname'];
		$description = $row2['description'];
 		
		$primaryfirstname = $row2['primaryfirstname'];
		$primarylastname = $row2['primarylastname'];
		$primaryemail = $row2['primaryemail'];
		$primaryphonenumber = $row2['primaryphonenumber'];
		
		$secondaryfirstname1 = $row2['secondaryfirstname1'];
		$secondarylastname1 = $row2['secondarylastname1'];
		$secondaryemail1 = $row2['secondaryemail1'];
		$secondaryphonenumber1 = $row2['secondaryphonenumber1'];
		 
		$secondaryfirstname2 = $row2['secondaryfirstname2'];
		$secondarylastname2 = $row2['secondarylastname2'];
		$secondaryemail2 = $row2['secondaryemail2'];
		$secondaryphonenumber2 = $row2['secondaryphonenumber2'];
		
		$outputstr =" { \"instrumentname\" : \"$instrumentname\",
				\"description\" : \"$description\",
				\"primaryfirstname\" : \"$primaryfirstname\",
				\"primarylastname\" : \"$primarylastname\",
				\"primaryemail\" : \"$primaryemail\",
				\"primaryphonenumber\" : \"$primaryphonenumber\",
				\"secondaryfirstname1\" : \"$secondaryfirstname1\",
				\"secondarylastname1\" : \"$secondarylastname1\",
				\"secondaryemail1\" : \"$secondaryemail1\",
				\"secondaryphonenumber1\" : \"$secondaryphonenumber1\",
				\"secondaryfirstname2\" : \"$secondaryfirstname2\",
				\"secondarylastname2\" : \"$secondarylastname2\",
				\"secondaryemail2\" : \"$secondaryemail2\",
				\"secondaryphonenumber2\" : \"$secondaryphonenumber2\"  } ";
	}
 	
	echo $outputstr;
?>