<? 

$dbhost="db1661.perfora.net";
$dbname="db260244667";
$dbusername="dbo260244667";
$dbpass="curu11i";

$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");

$curMonth = date("m");

echo "current month is : $curMonth<br/>";

$sql = "SELECT * FROM Customer_data WHERE withoperator = 0 AND (type ='On-Campus' OR type ='Off-Campus') AND date BETWEEN '2013-$curMonth-01' AND '2013-$curMonth-31'";

$result = mysql_query($sql) or die(mysql_error());
$j=0;
	$i=mysql_num_rows($result);
	while($j<$i){
		$row = mysql_fetch_array($result);
		if($row['DiscountFlag']==1){
			$dis= " discounted       unit price=".$row['Unit']."        discounted price=".$row['Unit']*0.5;
			$disc=$row['Unit']*0.5;
			$sql = "UPDATE Customer_data SET DiscountQty = '".$disc."' where Number= '".$row['Number']."' ";
		} else {
			$sql = "UPDATE Customer_data SET DiscountQty = '".$row['Unit']."' where Number= '".$row['Number']."' ";
			$dis= " not discounted"."        unit price=".$row['Unit'];
		}
		echo $row['Number']." ".$row['DiscountFlag']."  ".$row['Unit']."  ".$row['DiscountQty']." ".$dis."     ".$sql;?><br/><?
		$j++;
		mysql_query($sql) or die(mysql_error());
	}
	mysql_close($connection);
?>
