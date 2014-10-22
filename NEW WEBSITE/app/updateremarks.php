<?
include_once ("database.php");
$sql = "SELECT id, date FROM `Remarks`";
$result1 = mysql_query($sql,$connection) or die("error: ".mysql_error());
while($row = mysql_fetch_array($result1)){
	$id = $row['id'];
	$dt = $row['date'];
	$dtArr = explode(":", $dt);
	$dt = trim($dtArr[2]).":".trim($dtArr[0]).":".trim($dtArr[1]);
	$update = "update Remarks set date = '".$dt."' where id='".$id."'";
	mysql_query($update) or die("error1: ".mysql_error());
	//echo $dt."<br/>";
}
echo "done";
?>