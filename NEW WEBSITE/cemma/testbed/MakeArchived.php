<?

$username =  $_GET['id'];
$usersa =  $_GET['usersa'];
$usersb =  $_GET['usersb'];
 
if($usersa=='')
 {
	 $usersa="ALL";
	 $usersb="ALL";
 } 
																
header( "Location: currentusers.php?usersa=$usersa&usersb=$usersb" ) ;

include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include (DOCUMENT_ROOT.'tpl/header.php'); 
	
	include_once("includes/action.php");
	include_once(DOCUMENT_ROOT."Objects/customer.php");

	include_once("includes/instrument_action.php");


echo "username-".$username;

include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
$sql3 = "UPDATE user SET ActiveUser = 'inactive' WHERE UserName = '$username'";  
mysql_query($sql3) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 

//header("refresh:0; currentusers.php");



?>