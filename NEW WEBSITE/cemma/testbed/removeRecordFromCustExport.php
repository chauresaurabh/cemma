<?php
	include_once('constants.php');

	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");

if(strcmp($_GET["exportType"], "usersReport")==0) {
	$result = $_SESSION["usersReport"];
} else {
	$result = $_SESSION["customersReport"];
}

$remove = $_GET['remove'];
if($remove == '1'){
	$result[$_GET['recordNum']]['removed'] = 1;
	if(strcmp($_GET["exportType"], "usersReport")==0) {
		$_SESSION["usersReport"]=$result;
	} else {
		$_SESSION["customersReport"]=$result;
	}
	
	session_write_close();
#	echo 'true-'.$result[$_GET['recordNum']]['removed'];
	echo $_GET['recordNum'];
} else {
	$result[$_GET['recordNum']]['removed'] = 0;
	
	if(strcmp($_GET["exportType"], "usersReport")==0) {
		$_SESSION["usersReport"]=$result;
	} else {
		$_SESSION["customersReport"]=$result;
	}
	
	session_write_close();
	echo $_GET['recordNum'];
}

/*unset($result[$recordNum]);

$result = array_values($result);*/
?>