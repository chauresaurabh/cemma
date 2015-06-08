

<?

	include_once('constants.php');
//	include_once(DOCUMENT_ROOT."includes/checklogin.php");
//	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
$username=$_GET["username"];
include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");

$sql="SELECT * FROM user WHERE UserName = '".$username."'";
mysql_query($sql) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 

$result = mysql_query($sql);

echo "<table border='1' cellpadding='0' cellspacing='0' class='Tcontent' width='300'>";


$row = mysql_fetch_array($result);
  if($row['Class']==1)
    echo "<tr ><th colspan=2 BGCOLOR='#B3E0FF'>Class: Administrator</th></tr>";
  else
	    echo "<tr ><th colspan=2 BGCOLOR='#B3E0FF'>Class: User</th></tr>";
//  echo "<tr  >";
  //echo "<th >Username</th><td width='40%'>" . $username . "</td>";
  //echo "</tr>";


  echo "<tr>";
  echo "<th>FirstName</th><td width='40%'>" . $row['FirstName'] . "</td>";
  echo "</tr>";

  echo "<tr>";
  echo "<th>LastName</th><td width='40%' >" . $row['LastName'] . "</td>";
  echo "</tr>";

  echo "<tr>";
  echo "<th>Email</th><td width='40%' >" . $row['Email'] . "</td>";
  echo "</tr>";

  echo "<tr>";
  echo "<th>Telephone</th><td width='40%'>" . $row['Telephone'] . "</td>";
  echo "</tr>";
  
  echo "<tr>";
  echo "<th>Department</th><td width='40%'>" . $row['Dept'] . "</td>";
  echo "</tr>";

  echo "<tr>";
  echo "<th>Advisor</th><td width='40%'>" . $row['Advisor'] . "</td>";
  echo "</tr>";
  
  echo "<tr>";
  echo "<th>GradYear</th><td width='40%'>" . $row['GradYear'] . "</td>";
  echo "</tr>";

  echo "<tr>";
  echo "<th>Status</th><td width='40%'>" . $row['ResponseEmail'] . "</td>";
  echo "</tr>";

  echo "<tr>";
  echo "<th>FieldofInterest</th><td width='40%'>" . $row['FieldofInterest'] . "</td>";
  echo "</tr>";

	$pieces=explode("-",$row['LastStatusUpdate']);
	$yy=$pieces[0];
	$mm=$pieces[1];
	$dd=$pieces[2];

  echo "<tr>";
  echo "<th>LastStatusUpdate</th><td width='40%'>" . $mm."-".$dd."-".$yy . "</td>";
  echo "</tr>";
 
  echo "<tr>";
  echo "<th>Comments</th><td width='40%'>" . $row['Comments'] . "</td>";
  echo "</tr>";
	$pieces=explode("-",$row['MemberSince']);
	$yy=$pieces[0];
	$mm=$pieces[1];
	$dd=$pieces[2];

  echo "<tr>";
  echo "<th>MemberSince</th><td width='40%'>" . $mm."-".$dd."-".$yy  . "</td>";
  echo "</tr>";
	$pieces=explode("-",$row['LastEmailSentOn']);
	$yy=$pieces[0];
	$mm=$pieces[1];
	$dd=$pieces[2];

  echo "<tr>";
  echo "<th>LastEmailSentOn</th><td width='40%'>" . $mm."-".$dd."-".$yy. "</td>";
  echo "</tr>";

//Fetch Instrument Signed  
include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");

$sql2="SELECT  InstrNo, InstrSigned FROM instr_group WHERE Email = '".$row['Email']."'";
mysql_query($sql2) or die( "An error has occurred in query2: " .mysql_error (). ":" .mysql_errno ()); 
$result2 = mysql_query($sql2);
$rows = mysql_num_rows($result2);
if ($rows==0)
	echo "<tr ><th colspan=2 BGCOLOR='#B3E0FF'>No Instruments Approved to Use</th></tr>";
else
	echo "<tr ><th colspan=2 BGCOLOR='#B3E0FF'>Instruments Approved to Use</th></tr>";

while($row2 = mysql_fetch_array($result2))
{
	$pieces=explode("-",$row2['InstrSigned']);
	$yy=$pieces[0];
	$mm=$pieces[1];
	$dd=$pieces[2];

	$sql3="SELECT  InstrumentName FROM  instrument WHERE  InstrumentNo = '".$row2['InstrNo']."'";
	mysql_query($sql3) or die( "An error has occurred in query2: " .mysql_error (). ":" .mysql_errno ()); 
	$result3 = mysql_query($sql3);
	$row3 = mysql_fetch_array($result3);

	echo "<tr>";
	echo "<th>".$row3['InstrumentName']."</th><td width='40%'>" . $mm."-".$dd."-".$yy."</td>";
    echo "</tr>";

}


echo "</table>";


?> 