<?
session_start();
 
 include_once('constants.php');
include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");

		$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
		$SelectedDB = mysql_select_db($dbname) or die ("Error in Old DB");
		
$instru = $_GET['instrNum'];
		
$sql = "select * from permit_forms where instrument_name = '".$instru."'";
$result = mysql_query($sql) or die(mysql_error());
if($row = mysql_fetch_array($result)){
	echo "{'title':'".$row['title']."', 'para1': '".$row['para1']."', 'para2': '".$row['para2']."'}";
} else {
	echo "{'notfound':'not found'}";
}
mysql_close();
session_write_close();
?>
