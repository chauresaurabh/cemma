<?
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."util.php");
	include_once (DOCUMENT_ROOT.'DAO/recordDAO.php'); 

?>
<?

$name = $_GET['CustomerName'];
$machine = $_GET['MachineName'];
$fulldate = split('[/]',$_GET['Date']);
$month = $fulldate[0];
$date = $fulldate[1];
$year = $fulldate[2];
$operator = $_GET['OperatorName'];
$newOperator = $_GET['newOperator'];
$woperator= $_GET['woperator'];
$qty= $_GET['qty'];
$type = $_GET['type'];
$fromdate = "$year-$month-01";
$todate = "$year-$month-31";
$invoiceno = $_GET['invoiceno'];
$Gdate = $_GET['Gdate'];
$number = $_GET['number'];
$invoiceno = $_GET['invoiceno'];
$manager = $_SESSION['mid'];

$unitPrice = $_GET['unit'];
$total = $_GET['total'];
$overriddenFlag = $_GET['overriddenFlag'];

$cemmaStaff = $_GET['CemmaStaff'];

$accountnumber = $_GET['accountnumber'];

$logintime = $_GET['logintime'];
$logouttime = $_GET['logouttime'];

$films = array();
$films = array("Film - EM Film TEM");

$insert_date = "$year-$month-$date";

if($newOperator == "1"){
$sql = "INSERT into operators (Manager_ID, customer, operator) values ('$manager', '$name','$operator')";
mysql_query($sql) or die ("An error has occured. Please try again later");
}

if($woperator == 1){

$string = "With_Operator";
$showstring = "Yes";
}

else{
$string = "Without_Operator";
$showstring = "No";
}

$final = $type."_".$string;

$sql = "select * from rates where machine_name = '$machine'";

$result = mysql_query($sql);

while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{

//$unit = $row[$final];

}

//$total = $unit*$qty;
$discountFlag = 0;

//echo "Qty is " .$qty."<Br>";
//echo "Current Qty before going is " .$currQty."<Br>";
echo 'Record Successfully Updated!!';
$sql = "UPDATE Customer_data SET Qty = '$qty', Machine = '$machine', Unit = '$unitPrice', Total= '$total', Operator = '$operator', Date = '$insert_date', Type = '$type', WithOperator = '$woperator', DiscountFlag = '$discountFlag',OverriddenFlag='$overriddenFlag' , Name='$name' , CemmaStaffMember='$cemmaStaff', Time='$logintime', logouttime='$logouttime' where Number='$number'";
mysql_query($sql) or die ("Error in Edit Data");

updateFurtherDiscounts($fromdate, $todate, $name, $machine, $films);

$sql = "select Total from Customer_data where invoiceno = '$invoiceno' AND Gdate = '$Gdate'";
$result = mysql_query($sql) or die ("Error in Total");
$edit_total = 0;
while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$edit_total += $row['Total'];
}
$sql = "UPDATE Invoice SET Total = '$edit_total' WHERE invoiceno = '$invoiceno' AND Gdate = '$Gdate'";
mysql_query($sql) or die ("Error in Updating Total");



$accountSql = "UPDATE user set AccountNum = '$accountnumber' where ActiveUser='active' AND Name LIKE '".str_replace(" ", "%", $operator )."'";
mysql_query($accountSql) or die ("Error in Updating Account Number");

mysql_close($connection);


?>
