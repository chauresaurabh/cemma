<?php 
include_once('constants.php');
//include (DOCUMENT_ROOT.'tpl/header.php');
include_once(DOCUMENT_ROOT."includes/database.php");

$Emailid=$_GET['email'];
//echo $Emailid;

$first=$_GET['first'];
//echo $first;
$optout=$_GET['optout'];
$submit1=$_POST['submit1'];

//echo $submit1;
/*
echo "<script type='text/javascript'>var answer=confirm('Do you really want to go here?')";
echo "if (answer) { window.location ='http://cemma-usc.net/cemma/testbed/EmailOptOut.php?email=f'; }";
echo "</script>";
*/
if($first)
{
echo "<form action='http://cemma-usc.net/cemma/testbed/EmailOptOut.php?email=$Emailid&optout=yes'  method='post'>";
echo "<center><br>Are you sure you want to opt out from the CEMMA mailing list ?<br><br>";
echo "<input type='submit' name='submit1' value='Yes'>";
echo "<input type='submit' name='submit1' onclick='' value='No'></center></form>";

}
else
{/*
$dbhost="db1661.perfora.net";
$dbname="db260244667";
$dbusername="dbo260244667";
$dbpass="curu11i";

$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
*/
if($submit1=='Yes')
	{

$sql3 = "UPDATE Customer SET MailingListCust = 'No'  WHERE EmailId = '$Emailid'";
mysql_query($sql3) or die ("Error33");
//mm

//mm

	 include_once('constants.php');
		include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
		

$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connectionnn");
$SelectedDB = mysql_select_db($dbname) or die ("Error in DBbb");

$sql23 = "SELECT Email FROM user  WHERE Email = '$Emailid'";
	$values1=mysql_query($sql23) or die("An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
	//$row33 = mysql_fetch_array($values1); 
	$totalemailcountcustomer=0;
//	echo "zx";
	
	while($row23 = mysql_fetch_array($values1))
	{
	if ($row23['Email']==NULL)
		{echo "Email ID not found";
	echo 'pop'.$row23['Email'];}
    }

$sql3 = "UPDATE user SET MailingListOpt = 'No' WHERE Email = '$Emailid'";
mysql_query($sql3) or die ("Error3");

echo "<center>You have successfully opted out of the mailing list</center>";
}
else
	{echo "<center>You have successfully opted to stay on the mailing list</center>";
	}

}



?> 