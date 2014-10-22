<?
if(!isset($_SESSION))
		session_start();
	if(!$_SESSION['login']){
		header('Location: login.php');
	}
$table = 'table_name'; // table you want to export
$file = 'Export'; // csv name.
$fields = "date, name, time, inbset";
$today = date("M_d_Y");
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=Instrument_Logs_$today.csv");
header("Pragma: no-cache");
header("Expires: 0");
$result = $_SESSION["testSbcReport"];
$total = count($result);

echo "Entry, User, Instrument, Remark, Date, Time"."\n";

$count=1;
foreach($result as $row){
	echo $count.",", $row['username'].",".$row['instrument'].",".$row['remarks'].",".$row['date'].",".$row['time']."\n";
	$count++;
}
session_write_close();
exit;
?>