
<? include_once("includes/database.php"); ?>

<?
$Gdate = $_GET['Gdate'];
$invoiceno = $_GET['invoiceno'];
$number = $_GET['number'];

$qry = "SELECT * FROM Customer_data where Number = '$number'";
$result = mysql_query($qry) or die ("error");

while($row = mysql_fetch_array($result, MYSQL_ASSOC)){

$date_array = explode("-",$row['Date']);
$year  = $date_array[0];
$month = $date_array[1];
$day = $date_array[2];
$name = $row['Name'];
$qty = $row['Qty'];
$name = $row['Name'];
$machine = $row['Machine'];
$type = $row['Type'];
$operator = $row['Operator'];
$withoperator = $row['WithOperator'];
$test = 1;

}

echo $test."&".$name."&".$qty."&".$machine."&".$type."&".$operator."&".$day."&".$month."&".$year."&".$withoperator;
mysql_close($connection);
?>