<?
header( 'Location: Signup.php' ) ;
include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include (DOCUMENT_ROOT.'tpl/header.php'); 
	
	include_once("includes/action.php");
	include_once(DOCUMENT_ROOT."Objects/customer.php");

	include_once("includes/instrument_action.php");


$instr =  $_GET['instr'];
$usedby =  $_GET['usedby'];
$slot =  $_GET['slot'];
$datesigned =  $_GET['datesigned'];

echo "log-".$_SESSION['login'];


include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
$sql3 = "UPDATE schedule set UsedBy = '".$_SESSION['login']."' where InstrumentName='$instr' and 	Date='$datesigned' and Slot='$slot' and UsedBy='$usedby'";  
mysql_query($sql3) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
			




?>