


<link rel="stylesheet" type="text/css" href="style.css">
<?

include_once ("includes/database.php"); 



$machine = $_GET['MachineName'];
$sql = "SELECT * FROM rates,instrument where machine_name = '$machine' and machine_name = InstrumentName";
$result1 = mysql_query($sql) or die ("Error in Retrieving");
while($row = mysql_fetch_array($result1, MYSQL_ASSOC)){


echo '<p>&nbsp;</p>';
echo  '<table class="content" align="center" width="420" border="0" cellspacing = "0" cellpadding="5">';
echo '<tr class="table1bg">';
echo  '<td  class="table1bg" width="300"><strong>Name of the Instrument : </strong></td>';
echo  '<td width="120">';
echo $row['machine_name'];
echo '</td></tr><tr><td><strong>Availibility:</strong></td><td>';
if($row['Availablity'] == "1")
echo 'Yes';
else
echo 'No';
echo '</td></tr><tr class="table1bg">';
echo  '<td><strong>USC Campus Users with Cemma Operator </strong></td>';
echo  '<td>';
echo $row['On-Campus_With_Operator'];
echo '</td></tr>';
echo   '<tr><td><strong>USC Campus Users without Cemma Operator</strong> </td><td>';
echo $row['On-Campus_Without_Operator']; 
echo '</td></tr><tr class="table1bg"><td><strong>Off Campus Academic With Cemma Operator </strong></td>';
echo    '<td>';
echo $row['Off-Campus_With_Operator']; 
echo '</td>';
echo  '</tr>';
echo   '<tr>';
echo     '<td><strong>Off Campus Academic Without Cemma Operator</strong> </td>';
echo    '<td>';
echo $row['Off-Campus_Without_Operator']; 
echo '</td>';
echo  '</tr>';
echo  '<tr class="table1bg">';
echo    '<td><strong>Commercial - Industry</strong> </td>';
echo     '<td>';
echo $row['Commerical_With_Operator']; 
echo '</td>';
echo  '</tr>';
echo   '<tr>';
echo    '<td><strong>Comments:</strong></td>';
echo    '<td>'.$row['Comment'].'</td>';
echo  '</tr>';
echo '</table>';



}

mysql_close($connection); 
?>

