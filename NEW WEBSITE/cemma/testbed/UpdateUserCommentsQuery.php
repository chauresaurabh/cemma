<?
 	
	$user_comments = $_GET['user_comments'];
    $userId = $_GET['userId'];

	session_start();

				include_once('constants.php');
			//	include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
$dbhost="db1661.perfora.net";
$dbname="db260244667";
$dbusername="dbo260244667";
$dbpass="curu11i";


	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
 	
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
 
 	$sql= "update UsersInQuery set Comments='".$user_comments ."' where UserName='".$userId."'";
 
  	mysql_query($sql) or die("Error in Connection");
 
	echo "Comments Updated for User ". $userId;
	
?>
	
    