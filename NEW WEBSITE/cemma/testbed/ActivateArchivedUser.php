<?
 
$username =  $_GET['id'];
$usersa =  $_GET['usersa'];
$usersb =  $_GET['usersb'];
 
if($usersa=='')
 {
	 $usersa="ALL";
	 $usersb="ALL";
 } 
	
header( "Location: ArchivedUsers.php?usersa=$usersa&usersb=$usersb" ) ;
include_once('constants.php');
 
include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
	$sql3 = "UPDATE user SET ActiveUser = 'active' WHERE UserName = '$username'";
	mysql_query($sql3) or die ("Error3");
 
</script>";

	?>