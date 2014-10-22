<?
include_once('constants.php');
include_once(DOCUMENT_ROOT."includes/checklogin.php");
include_once(DOCUMENT_ROOT."includes/checkadmin.php");
include_once(DOCUMENT_ROOT."includes/database.php");

$reg_user = $_GET['reg_user'];
$type = $_GET['type'];
if($type=="load"){
	$sql = "SELECT AccountNum FROM user where UserName = '$reg_user'";
	$result = mysql_query($sql) or die("Some error occurred");
	if(mysql_num_rows($result)>0){
		$row = mysql_fetch_array($result);
		echo trim($row["AccountNum"]);
	} else {
		echo "Account Number not set";
	}
} else if($type=="update"){
	$acc_num = $_GET['acc_num'];
	$sql = "Update user set AccountNum = '$acc_num' where UserName = '$reg_user'";
	$result = mysql_query($sql) or die("Some error occurred");
	echo "Updated successfully";
} else if($type=="update_grp"){
	$acc_num = $_GET['acc_num'];
	$sql = "SELECT UserName FROM user where Advisor = '$reg_user' and ( ActiveUser='active' OR ActiveUser IS NULL )";
	$result = mysql_query($sql);
	//get the people from user
	if(mysql_num_rows($result)>0){
		while ($row = mysql_fetch_array($result)) {
			$username=$row['UserName'];
			mysql_query("UPDATE user set AccountNum='$acc_num' where username='$username'");
		}
		echo 'Updated successfully';
	} else {
		echo 'Customer does not exist';
	}
} else {
	echo "Invalid request";
}
?>