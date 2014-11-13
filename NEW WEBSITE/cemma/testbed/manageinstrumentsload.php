<? 
	 $dbhost="db1661.perfora.net";
	$dbname="db260244667";
	$dbusername="dbo260244667";
	$dbpass="curu11i";

	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
	$sql2 = "select instrumentname from INSTRUMENTS_WEB_PAGE order by instrumentname asc";
	$result2 = mysql_query($sql2);
	
	$outputstr="[";
	
	while($row2=mysql_fetch_array($result2)){
		
		$outputstr = $outputstr . "{ 'instrumentname' : '" . $row2['instrumentname'] ."' },";
	}
	$outputstr=$outputstr."]";
	
	echo $outputstr;
?>