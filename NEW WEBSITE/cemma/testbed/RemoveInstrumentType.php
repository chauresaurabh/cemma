<?
header('Location: InstrumentTypes.php');
include_once ('constants.php');
include_once (DOCUMENT_ROOT."includes/checklogin.php");
include_once (DOCUMENT_ROOT."includes/checkadmin.php");
include (DOCUMENT_ROOT.'tpl/header.php');
include_once ("includes/action.php");
include_once (DOCUMENT_ROOT."Objects/customer.php");
include_once ("includes/instrument_action.php");
$InstrumentTypeNumber=$_GET['id'];
include_once (DOCUMENT_ROOT."includes/database.php");
$sql3="DELETE FROM Instrument_Types WHERE TypeNumber = '$InstrumentTypeNumber'";
mysql_query($sql3) or die("An error has occured in query1: ".mysql_error().":".mysql_errno());
//header("refresh:0; currentusers.php");
?>