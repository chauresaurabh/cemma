 
<?
 session_start();
	$dbhost="db1661.perfora.net";
	$dbname="db260244667";
	$dbusername="dbo260244667";
	$dbpass="curu11i";

	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
  	 
	 $staffname = $_GET['name'];  
	 
	 $sql = "delete from PROFESSIONAL_STAFF where name='$staffname'";
	 
	 $result = mysql_query($sql);
	 
	 $numRows =  mysql_affected_rows();
	$outputStr="";
	
	if($numRows > 0)
	{
		 $outputStr = "{'recordupdated':'Record Deleted Successfully !'}";
 	}else{
	 	$outputStr = "{'recordupdated':'Record not found!'}";
	}
	echo $outputStr;
  
  
 mysql_close();
session_write_close();
?> 
 