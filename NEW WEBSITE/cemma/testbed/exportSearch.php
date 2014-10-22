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
header("Content-Disposition: attachment; filename=Search_Records_$today.csv");
header("Pragma: no-cache");
header("Expires: 0");
$result = $_SESSION["recordsReport"];
$total = count($result);
echo "Entry,Date,Login Time,Customer,Quantity,Instrument,Operator(User),Operator?,Total,Invoice\n";
$count=1;

foreach($result as $row){
	
	 $withOperator="";
	 if($row['WithOperator'] == 1){
		$withOperator="Yes";
	 }
	 else{
		$withOperator="No";
	 }
	 
	 $invoiceNum="-";
	 if($row['Generated']==1){
		 
		 $Gdate_array = explode("-",$row['Gdate']);
		 $Gyear  = $Gdate_array[0];
		 $Gmonth = $Gdate_array[1];

		 if($Gmonth>6) $Gyear = $Gyear+1;
		 $invoiceno = $row['invoiceno'];
					
 		 $invoiceNum = "MO ". substr($Gyear,2,2). '/' .$invoiceno;
	 }
	  
	 $customerName = str_replace(","," ", $row['Name'] );
	 $operatorName = str_replace(","," ", $row['Operator'] );
	 echo $count.",". $row['Date'].",".$row['Time'].",".$customerName.",".$row['Qty'].",".$row['Machine'].",".$operatorName .",".$withOperator.",".$row['Total'].",".$invoiceNum ."\n";
	 $count++;
	 
}
session_write_close();
exit;
?>