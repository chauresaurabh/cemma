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
header("Content-Disposition: attachment; filename=$today.csv");
header("Pragma: no-cache");
header("Expires: 0");
$result = $_SESSION[$_GET["exportType"]];
$total = count($result);
if(strcmp($_GET["exportType"],"recordsReport")==0) {
	echo "Primary Comments,Customer Account Number,Transaction Date,Service Description,Quantity,Unit,Price,Service Category, Secondary Comments, PI's Name,Purchaser's Last Name, Short Contributing Center Name, Resource Name, Line Item Assistant, Line Item Comments, Project ID\n";
	foreach($result as $row){
		if($row['removed'] != 1){
			$surname = explode(" ", $row['UserCharged']);
			$containsHyphen = preg_match("/[-]/",$row['AccountNum']);
			if($containsHyphen>0){
				$row['AccountNum']=str_replace("-", "", $row['AccountNum']);
			}
			$row['Name'] = "\"".$row['Name']."\"";
			$dateArray = explode('-', $row['Date']);
			$date = date("M", mktime(0, 0, 0, $dateArray[1]+1, 0));
			$rates = $row['rates'];
		//	$row = $result[$total];//"record1,record2,record3\n";
			echo $row['Comments'].",".$row['AccountNum'].",".$dateArray[2]."-".$date."-".substr($dateArray[0],2,4).",".$row['ServiceDesc'].",".$row['Qty'].",".$row['rates'].",".$row['UnitPrice'].",".$row['InsType'].",".",".$row['Name'].",".$surname[count($surname)-1]."\n";
			$total=$total-1;
		}
	}
} else if(strcmp($_GET["exportType"],"customersReport")==0){
	echo "Customer,Department,School,Customer Type\n";
	foreach($result as $row){
		if($row['removed'] != 1){
			echo str_replace(","," ",$row['Name']).",".str_replace(","," ",$row['Department']).",".str_replace(","," ",$row['School']).",".$row['Type']."\n";
		}
	}
} else if(strcmp($_GET["exportType"], "usersReport")==0) {
	echo "User,Department,Adviser,Position,Approved Instrument\n";
	foreach($result as $row){
		if($row['removed'] != 1){
			echo str_replace(","," ",$row['UserName']).",".str_replace(","," ",$row['Dept']).",".str_replace(","," ",$row['Advisor']).",".$row['Position'].",".$row['Instrument']."\n";
		}
	}
}
session_write_close();
exit;
?>