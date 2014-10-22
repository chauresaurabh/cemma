<? include_once("includes/database.php");
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");

if(isset($_GET['submit'])){
$machine = $_GET['MachineName'];
$sql = "SELECT * FROM rates,instrument where machine_name = '$machine' and machine_name = InstrumentName";
$result1 = mysql_query($sql);
echo '</br>';

while($row = mysql_fetch_array($result1, MYSQL_ASSOC)){

//echo 'pop-'.$row['Type'];
echo '<form id="myform_sub" name="myform_sub">';
echo  '<table class="content" align="center" width="450" border = "0">';

echo '<tr class = "Trow">';
echo '      <td>Name of the Instrument : </td>';
if($_SESSION['ClassLevel']==1){
	echo '    <td><input type="text" size="20" name="machine_name" value="';
} else {
	echo '    <td><input type="text" size="20" name="machine_name" readonly="true" style="background:#EEEEEE" value="';
}
echo $row['machine_name'];
echo '"></td>';
echo '  </tr >';
echo '  <tr class = "Trow">';
echo '    <td>Availibility:</td>';

if($row['Availablity'] == 1){

echo '    <td><input type="radio" name="availibility" id="availibility" value="1" checked = "checked">Available&nbsp;&nbsp;&nbsp;';
echo '	<input type="radio" name="availibility" id="availibility" value="0">Not Available</td>';
}


else{
echo '    <td><input type="radio" name="availibility" id="availibility" value="1">Available&nbsp;&nbsp;&nbsp;';
echo '	<input type="radio" name="availibility" id="availibility" value="0" checked="checked">Not Available</td>';

}
echo '  </tr>';


echo '  <tr class = "Trow">';
echo '    <td>Display on Status Page:</td>';
if($row['DisplayOnStatusPage'] == 'Yes' || $row['DisplayOnStatusPage'] == '')
{
	if($_SESSION['ClassLevel']==1){
		echo '    <td><input type="radio" name="DisplayOnStatusPage" id="DisplayOnStatusPage" value="Yes" checked = "checked">Yes&nbsp;&nbsp;&nbsp;';
		echo '	<input type="radio" name="DisplayOnStatusPage" id="DisplayOnStatusPage" value="No">No</td>';
	} else {
		echo '    <td><input type="radio" name="DisplayOnStatusPage" id="DisplayOnStatusPage" value="Yes" checked = "checked">Yes&nbsp;&nbsp;&nbsp;';
		echo '	<input disabled type="radio" name="DisplayOnStatusPage" id="DisplayOnStatusPage" value="No">No</td>';
	}
}
else
{
	if($_SESSION['ClassLevel']==1){
		echo '    <td><input type="radio" name="DisplayOnStatusPage" id="DisplayOnStatusPage" value="Yes">Yes&nbsp;&nbsp;&nbsp;';
		echo '	<input type="radio" name="DisplayOnStatusPage" id="DisplayOnStatusPage" value="No" checked="checked">No</td>';
	} else {
		echo '    <td><input disabled type="radio" name="DisplayOnStatusPage" id="DisplayOnStatusPage" value="Yes">Yes&nbsp;&nbsp;&nbsp;';
		echo '	<input type="radio" name="DisplayOnStatusPage" id="DisplayOnStatusPage" value="No" checked="checked">No</td>';
	}
}
echo '  </tr>';
// For pricing page
echo '  <tr class = "Trow">';
echo '    <td>Display on Pricing Page:</td>';
if($row['DisplayOnPricingPage'] == 1)
{
	if($_SESSION['ClassLevel']==1){
		echo '    <td><input type="radio" name="DisplayOnPricingPage" id="DisplayOnPricingPage" value="1" checked = "checked">Yes&nbsp;&nbsp;&nbsp;';
		echo '	<input type="radio" name="DisplayOnPricingPage" id="DisplayOnPricingPage" value="0">No</td>';
	} else {
		echo '    <td><input type="radio" name="DisplayOnPricingPage" id="DisplayOnPricingPage" value="1" checked = "checked">Yes&nbsp;&nbsp;&nbsp;';
		echo '	<input disabled type="radio" name="DisplayOnPricingPage" id="DisplayOnPricingPage" value="0">No</td>';
	}
}
else if($row['DisplayOnPricingPage'] == 0)
	{
		if($_SESSION['ClassLevel']==1){
			echo '    <td><input type="radio" name="DisplayOnPricingPage" id="DisplayOnPricingPage" value="1">Yes&nbsp;&nbsp;&nbsp;';
			echo '	<input type="radio" name="DisplayOnPricingPage" id="DisplayOnPricingPage" value="0" checked="checked">No</td>';
		} else {
			echo '    <td><input disabled type="radio" name="DisplayOnPricingPage" id="DisplayOnPricingPage" value="1">Yes&nbsp;&nbsp;&nbsp;';
			echo '	<input type="radio" name="DisplayOnPricingPage" id="DisplayOnPricingPage" value="0" checked="checked">No</td>';
		}
	}
 

echo '  </tr>';
// pricing ends

 //Types
echo '  <tr class = "Trow">';
echo '    <td>Type:</td>';
if($_SESSION['ClassLevel']==1){
	echo '    <td><select name="InstrumentType" id="InstrumentType">';
} else {
	echo '    <td><select disabled style="background:#EEEEEE">';
}
	   if($row['Type']=="")
		{echo '	<option value="" selected="selected"></option>';
		}
		else
		{
			echo '	<option value="" ></option>';
		}
	$sql12 = "SELECT TypeNumber,Type FROM Instrument_Types ORDER BY Type ";
	$values1=mysql_query($sql12) or die("An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
  while($row2 = mysql_fetch_array($values1))
	{

	  if($row2['Type']==$row['Type'])
		{
		  	echo '	<option value="'.$row2['Type'].'" selected="selected">'.$row2['Type'].'</option>';
		}
		else
		{
			echo '	<option value="'.$row2['Type'].'" >'.$row2['Type'].'</option>';
		}
	}
	
	
/*
echo '         <option value="" '.$None.'></option>';
echo '         <option value="TEM" '.$TEM.'>TEM</option>';
echo '  	  <option value="SEM" '.$SEM.'>SEM</option>';
echo '		  <option value="FIB" '.$FIB.'>FIB</option>';
echo '    	  <option value="PREP Equipment" '.$PREPEquipment.'>PREP Equipment</option>';
echo '    	  <option value="Surface Analysis" '.$SurfaceAnalysis.'>Surface Analysis</option>';
*/
echo '     	</select>';

if($_SESSION['ClassLevel']!=1){
	echo '<input type="hidden" name="InstrumentType" id="InstrumentType" value="'.$row['Type'].'">';
}

echo '</td>';

echo '  </tr>';


echo '  <tr class = "Trow">';
echo '    <td>Rates:	</td>'; 
echo '    <td>&nbsp;</td>';
//echo '    <td>&nbsp;</td>';
echo '  </tr>';

echo '  <tr class = "Trow">';
echo '    <td>Training Rate </td>';

if($_SESSION['ClassLevel'] == 1){
	echo '    <td> <input type="text" size="4" name="trainingRate" value="';
} else {
	echo '    <td> <input type="text" style="background:#EEEEEE" size="4" disabled=true name="trainingRate" value="';
}

echo  $row['trainingRate'];
echo '"></td>';
echo '  </tr>';

echo '  <tr class = "Trow">';
echo '    <td>USC Campus Users with staff  </td>';
if($_SESSION['ClassLevel'] == 1){
	echo '    <td> <input type="text" size="4" name="usc_with_cemma" value="';
} else {
	echo '    <td> <input type="text" size="4" style="background:#EEEEEE" disabled=true name="usc_with_cemma" value="';
}

echo  $row['On-Campus_With_Operator'];
echo '"></td>';
echo '  </tr>';
echo '  <tr class = "Trow">';
echo '    <td>USC Campus Users without staff </td>';

if($_SESSION['ClassLevel'] == 1){
	echo '    <td><input type="text" size="4" name="usc_without_cemma" value="';
} else {
	echo '    <td><input type="text" size="4" style="background:#EEEEEE" disabled=true name="usc_without_cemma" value="';
}

echo $row['On-Campus_Without_Operator'];
echo '"></td>';
//echo '    <td> <input disabled="true" type="text" size="10" name="usc_without_cemma_unit" value="'.$row['cemma_unit'].'"/></td>';
echo '  </tr>';
echo '  <tr class = "Trow">';
echo '    <td>Other academic users with staff </td>';

if($_SESSION['ClassLevel'] == 1){
	echo '    <td><input type="text" size="4" name="off_with_cemma" value="';
} else {
	echo '    <td><input type="text" size="4" style="background:#EEEEEE" disabled=true name="off_with_cemma" value="';	
}

echo $row['Off-Campus_With_Operator']; 
echo '"></td>';
//echo '    <td> <input disabled="true" type="text" size="10" name="off_with_cemma_unit" value="'.$row['cemma_unit'].'"/></td>';
echo '  </tr>';
echo '  <tr class = "Trow">';
echo '    <td>Other academic users without staff </td>';

if($_SESSION['ClassLevel'] == 1){
	echo '    <td><input type="text" size="4" name="off_without_cemma" value ="';
} else {
	echo '    <td><input type="text" size="4" style="background:#EEEEEE" disabled=true name="off_without_cemma" value ="';
}

echo $row['Off-Campus_Without_Operator'];
echo '"></td>';
//echo '    <td> <input type="text" disabled="true" size="10" name="off_without_cemma_unit" value="'.$row['cemma_unit'].'"/></td>';
echo '  </tr>';
echo '  <tr class = "Trow">';
echo '   <td>Industry With CEMMA Operator</td>';

if($_SESSION['ClassLevel'] == 1){
	echo '    <td><input type="text" size="4" name="industry_with_cemma" value="';
} else {
	echo '    <td><input type="text" size="4" style="background:#EEEEEE" disabled=true name="industry_with_cemma" value="';
}

echo $row['Industry_With_Operator'];
echo '"></td>';
/*echo '    <td> <input type="text" size="10" disabled="true" name="commerical_unit" value="'.$row['cemma_unit'].'"/></td>';
*/echo '  </tr>';

echo '  <tr class = "Trow">';
echo '   <td>Industry Without CEMMA Operator</td>';

if($_SESSION['ClassLevel'] == 1){
	echo '    <td><input type="text" size="4" name="industry_without_cemma" value="';
} else {
	echo '    <td><input type="text" size="4" style="background:#EEEEEE" disabled=true name="industry_without_cemma" value="';
}

echo $row['Industry_Without_Operator'];
echo '"></td>';
/*echo '    <td> <input type="text" size="10" disabled="true" name="commerical_unit" value="'.$row['cemma_unit'].'"/></td>';
*/echo '  </tr>';


echo '<tr class="Trow">';
echo '    <td>Unit :</td>';
if($_SESSION['ClassLevel']==1){
	echo '    <td> <input type="text" size="10" name="cemma_unit" value="';
} else {
	echo '    <td> <input readonly style="background:#EEEEEE" type="text" size="10" name="cemma_unit" value="';
}
echo  $row['cemma_unit'].'"/></td>';

echo '  </tr>';

echo '  <tr class = "Trow">';
echo '    <td valign="top">Comments :</td>';
echo '    <td><textarea name="comments" style = "font-size : 11px; font-family : Tahoma,Verdana,Arial;" cols="20" rows="3" wrap="hard">'.$row['Comment'].'</textarea></td>';
echo '<td style="display:none"><input type="text" name="instrument_no" value="'.$row['InstrumentNo'].'"/></td>';
echo '  </tr>';
echo '  </table>';
echo '</form>';


}

}

if(isset($_GET['submit1'])){


$machine_number = $_GET['machine_number'];
$machine = $_GET['machine_name'];
$instrumentNo = $_GET['instrument_no'];
$trainingRate = $_GET['trainingRate'];
$usc_with_cemma = $_GET['usc_with_cemma'];
$cemma_unit = $_GET['cemma_unit'];

$usc_without_cemma = $_GET['usc_without_cemma'];
//$usc_without_cemma_unit = $_GET['usc_without_cemma_unit'];

$off_with_cemma = $_GET['off_with_cemma'];
//$off_with_cemma_unit = $_GET['off_with_cemma_unit'];

$off_without_cemma = $_GET['off_without_cemma'];
//$off_without_cemma_unit = $_GET['off_without_cemma_unit'];

$industry_with_cemma = $_GET['industry_with_cemma'];
$industry_without_cemma = $_GET['industry_without_cemma'];
//$commerical_unit = $_GET['commerical_unit'];

$comments = $_GET['comments'];
$availibility = $_GET['availibility'];
$DisplayOnStatusPage = $_GET['DisplayOnStatusPage'];
$DisplayOnPricingPage = $_GET['DisplayOnPricingPage'];
$InstrumentType = $_GET['InstrumentType'];
//echo " dis";//.$DisplayOnStatusPage;

echo $comments;

$sql = "DELETE FROM rates WHERE machine_name = '$machine'";
$result = mysql_query($sql) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ());  

$sql = "insert into rates values ('','$instrumentNo', '$machine', '$usc_with_cemma', '$cemma_unit', '$usc_without_cemma', '$off_with_cemma', '$off_without_cemma', '$industry_with_cemma','$industry_without_cemma','','$trainingRate')";
$result = mysql_query($sql) or die( "An error has ocured in query2: " .mysql_error (). ":" .mysql_errno ());  

$sql = "update instrument SET Availablity = '$availibility', DisplayOnStatusPage='$DisplayOnStatusPage', Comment = '$comments',Type='$InstrumentType', DisplayOnPricingPage='$DisplayOnPricingPage' where InstrumentName = '$machine'";
$result = mysql_query($sql) or die( "An error has ocured in query3: " .mysql_error (). ":" .mysql_errno ());  

//echo "Instrument Modified Successfullyy".$DisplayOnStatusPage;

}

else if(isset($_GET['submit2'])){

$machine_name = $_GET['MachineName'];

$sql = "DELETE FROM rates WHERE machine_name = '$machine_name'";
$result = mysql_query($sql) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());  

$sql = "DELETE FROM instrument WHERE InstrumentName = '$machine_name'";
$result = mysql_query($sql) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());  

echo "Instrument Deleted Successfully";


}



mysql_close($connection); 



?>
