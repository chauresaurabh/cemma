<?
 	
	$canvasdata = $_GET['imgdefault'];
 
 	 $canvasdata = str_replace( " ", "+", $canvasdata ); 
	
	session_start();

	 include_once('constants.php');
	 $dbhost="db1661.perfora.net";
	$dbname="db260244667";
	$dbusername="dbo260244667";
	$dbpass="curu11i";

	 $username='Neeraj-Narang';
 
	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
 	
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
  	
 	$sql= "update user set signature = '$canvasdata' where UserName='". $username ."'";
   	mysql_query($sql) or die("Error in query");
 
 	$sql2  = "SELECT signature from user where UserName='". $username ."'";
	$values1	=	mysql_query($sql2) or die("An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
  	
	while($row  = mysql_fetch_array($values1))
	{
		$canvasdata = $row['signature'];
	}
 	echo  $canvasdata;
	
?>
	
    