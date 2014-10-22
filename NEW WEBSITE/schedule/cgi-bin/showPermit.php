<?
session_start();
$dbhost="db948.perfora.net";
		$dbname="db210021972";
		$dbusername="dbo210021972";
		$dbpass="XhYpxT5v";
		$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connectionnn");
		$SelectedDB = mysql_select_db($dbname) or die ("Error in Old DB");
		
		$instrNum=$_GET['instrNum'];
		
$sql = "select * from permit_forms where instrument_name='".$instrNum."'";
$result = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($result);
echo "{'title':'".$row['title']."', 'para1': '".$row['para1']."', 'para2': '".$row['para2']."'}";
mysql_close();
session_write_close();
?>
