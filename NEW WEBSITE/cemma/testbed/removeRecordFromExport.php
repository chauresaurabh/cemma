<?php
	include_once('constants.php');

	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");

$result = $_SESSION["exportData"];

$remove = $_GET['remove'];
if($remove == '1'){
	$result[$_GET['recordNum']]['removed'] = 1;
	$_SESSION["exportData"]=$result;
	session_write_close();
#	echo 'true-'.$result[$_GET['recordNum']]['removed'];
	echo 'success';
} else {
	$result[$_GET['recordNum']]['removed'] = 0;
	$_SESSION["exportData"]=$result;
	session_write_close();
	echo 'success';
}

/*unset($result[$recordNum]);

$result = array_values($result);*/
?>