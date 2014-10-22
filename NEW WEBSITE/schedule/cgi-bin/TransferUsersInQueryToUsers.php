<?
/*if(!isset($_SESSION))
		session_start();
$dbhost="db948.perfora.net";
$dbname="db210021972";
$dbusername="dbo210021972";
$dbpass="XhYpxT5v";

$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connectionnn");
$SelectedDB = mysql_select_db($dbname) or die ("Error in Old DB");

$username =  $_POST['userselected'];

$todaydate=date("y").'-'.date("m").'-'.date("d");

$sql1 = "select AccountNum, Passwd, Class, Email, FirstName, LastName, Telephone, Dept, Advisor, GradYear, GradTerm, FieldofInterest,Comments  from UsersInQuery where UserName = '$username'";
$result=mysql_query($sql1) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
$row = mysql_fetch_array($result);

$FirstnameLastname=$row['FirstName'].$row['LastName'];
$Email=$row['Email'];

$sql3 = "insert into user (UserName, Passwd, AccountNum, Class, FirstName, LastName, Name, Email, Telephone, Dept,Advisor, GradYear, GradTerm, FieldofInterest, Comments, MemberSince,LastEmailSentOn,LastStatusUpdate) values ('$username', '".$row['Passwd']."', '".$row['AccountNum']."', '".$row['Class']."', '".$row['FirstName']."','".$row['LastName']."','".$FirstnameLastname."','".$row['Email']."', '".$row['Telephone']."', '".$row['Dept']."', '".$row['Advisor']."', '".$row['GradYear']."', '".$row['GradTerm']."', '".$row['FieldofInterest']."', '".$row['Comments']."', '$todaydate', '$todaydate', '$todaydate') ";  
//$sql3 = "insert into user (UserName, Passwd,LastStatusUpdate) values ('$username', ".$row['Passwd'].", '$todaydate') "; 
mysql_query($sql3) or die( "An error has ocured in query2: " .mysql_error (). ":" .mysql_errno ()); 


$sql13 = "select InstrNo, Email, InstrSigned from UsersInQuery_instr_group where Email = '$Email' and UserName='$username' ";
$values=mysql_query($sql13) or die("An error has ocured in query11: " .mysql_error (). ":" .mysql_errno ()); 
while($row = mysql_fetch_array($values)) {

$sql2 = "insert into instr_group (InstrNo, Email, InstrSigned) values ('".$row['InstrNo']."', '".$Email."', '".$todaydate."') "; 
mysql_query($sql2) or die( "An error has ocured in query2: " .mysql_error (). ":" .mysql_errno ()); 
}
			

$sql3 = "UPDATE UsersInQuery set TransferredToUsers = 1 where UserName = '$username'";  
mysql_query($sql3) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
mysql_close();

print $username." has been successfully Added to 'Users'";
*/
echo "clicked";
?>