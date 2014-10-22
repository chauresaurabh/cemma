<?
include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include (DOCUMENT_ROOT.'tpl/header.php'); 
	
	include_once("includes/action.php");
	include_once(DOCUMENT_ROOT."Objects/customer.php");

	include_once("includes/instrument_action.php");


$username =  $_GET['id'];

//echo "username -".$username."=";
$todaydate=date("y").'-'.date("m").'-'.date("d");
//echo $todaydate;

include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
$sql1 = "select AccountNum, Passwd, Class, Email, FirstName, LastName, Telephone, Dept, Advisor, GradYear, GradTerm, FieldofInterest,Comments, Position , uscid from UsersInQuery where UserName = '$username'";
$result=mysql_query($sql1) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
$row = mysql_fetch_array($result);

$FirstnameLastname=$row['FirstName']." ".$row['LastName'];
$Email=$row['Email'];
$row['Comments']=str_replace("'","\'",$row['Comments']);

$uscidnumber = $row['uscid'];

 //header("refresh:0; currentusers.php");
include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
$sql3 = "insert into user (UserName, Passwd, AccountNum, Class, FirstName, LastName, Name, Email, Telephone, Dept,Advisor, GradYear, GradTerm, FieldofInterest, Comments, MemberSince,LastEmailSentOn,LastStatusUpdate, Position , uscid ) values ('$username', '".$row['Passwd']."', '".$row['AccountNum']."', '".$row['Class']."', '".$row['FirstName']."','".$row['LastName']."','".$FirstnameLastname."','".$row['Email']."', '".$row['Telephone']."', '".$row['Dept']."', '".$row['Advisor']."', '".$row['GradYear']."', '".$row['GradTerm']."', '".$row['FieldofInterest']."', '".$row['Comments']."', '$todaydate', '$todaydate', '$todaydate', '".$row['Position']."' , '". $uscidnumber . "' ) ";  
//$sql3 = "insert into user (UserName, Passwd,LastStatusUpdate) values ('$username', ".$row['Passwd'].", '$todaydate') "; 
mysql_query($sql3) or die( "An error has ocured in insert user query : " .mysql_error (). ":" .mysql_errno ()); 


include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
$sql13 = "select InstrNo, Email, InstrSigned from UsersInQuery_instr_group where Email = '$Email' and UserName='$username' ";
$values=mysql_query($sql13) or die("An error has ocured in query11: " .mysql_error (). ":" .mysql_errno ()); 
while($row = mysql_fetch_array($values)) {

$sql2 = "insert into instr_group (InstrNo, Email, InstrSigned, Permission) values ('".$row['InstrNo']."', '".$Email."', '".$todaydate."','Peak') "; 
mysql_query($sql2) or die( "An error has ocured in query2: " .mysql_error (). ":" .mysql_errno ()); 
}
			



include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
$sql3 = "UPDATE UsersInQuery set TransferredToUsers = 1 where UserName = '$username'";  
mysql_query($sql3) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
?>
<script>
window.location.replace("NewRequestsUsers.php" ) ;
</script>
