<? include_once("includes/database.php"); ?>

<?
$Gdate = $_GET['Gdate'];
$invoiceno = $_GET['invoiceno'];
$name = $_GET['name'];
$qry = "SELECT * FROM Invoice where Gdate = '$Gdate' and Invoiceno = '$invoiceno'"; // problem
$result = mysql_query($qry) or die ("error");

?>

<?
while($row = mysql_fetch_array($result, MYSQL_ASSOC)){

$Gdate_array = explode("-",$row['Gdate']);
$Gyear  = $Gdate_array[0];
$Gmonth = $Gdate_array[1];

if($Gmonth<=6) $Gyear = $Gyear-1;

$original_status = $row['Status'];
$orignial_PO = $row['PO'];

echo '<form id="form3" name="form3">';
echo '<table width="300" class = "content" align="center" style="border:thin, #993300" >';
echo '<tr class="table1bg">';
echo '<td width = "150">Invoice no</td>';
echo '<td  class = "left">MO '.substr($Gyear,2,2).'/'.$row['Invoiceno'].'</td>';
echo '</tr>';
echo '<tr>';
echo '<td width = "150">Customer Name</td>';
echo '<td  class = "left">'.$row['Name'].'</td>';
echo '</tr>';
echo '<tr class="table1bg"><td width = "150">From (mm/dd/yyyy)</td>';
echo '<td  class = "left">';

$date_array = explode("-",$row['Fromdate']);
$var_year = $date_array[0];
$var_month = $date_array[1];
$var_day = $date_array[2];	

echo $var_month.'/'.$var_day.'/'.$var_year;
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td width = "150">To (mm/dd/yyyy)</td>';
echo '<td  class = "left">';

$date_array = explode("-",$row['Todate']);
$var_year = $date_array[0];
$var_month = $date_array[1];
$var_day = $date_array[2];	


echo $var_month.'/'.$var_day.'/'.$var_year.'</td>';
echo '</tr>';
echo '<tr class="table1bg"><td width = "150">Total</td>';
echo '<td  class = "left">'.$row['Total'].'</td>';
echo '</tr>';
echo '<tr><td width = "150">PO/Req</td>';
echo '<td  class = "left"><input type = "text" name = "PO" size = "14" value = "'.$row['PO'].'" ></td></tr>';
echo '<tr class="table1bg"><td width = "150">Status</td>';
echo '<td  class = "left"><select id = "status" name = "status" style="width:30mm">';
echo '<option value="'.$row['Status'].'">'.$row['Status'].'</option>';
 if ($row['Status'] == "Unpaid") 
echo '<option value = "Paid">Paid</option>';
else
echo '<option value = "Unpaid">Unpaid</option>';
echo '</select>';
echo '</td></tr>';
echo '<tr><td colspan="2">&nbsp;</td></tr>';
echo '<tr><td colspan = "2" align="center">';
echo '<input type = "button" align="center" name = "change" value = "Change" style="cursor:pointer;background:transparent url(images/mini/action_go.gif) no-repeat scroll left center;color:#996600;font-size:11px;font-weight:bold;padding-left:20px;text-decoration:none;" onClick = javascript:makeChanges("'.$invoiceno.'","'.$Gdate.'")>';
echo '<input type = "hidden" name="originalStatus" value = "'.$original_status.'">';
echo '<input type = "hidden" name="originalPO" value = "'.$orignial_PO.'">';
echo '</td></tr>';
echo '</table>';
echo '</form>';

}
	
mysql_close($connection);
?>














						
						
				