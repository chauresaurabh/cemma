<?php 
//header('Location: http://cemma-usc.net/schedule/cgi-bin/manuser.pl?SID=j51Db605eHGHf8G309ejA2gf&adminlogin=John');


$Emailid=$_GET['email'];
$first=$_GET['first'];
$showlogin=$_GET['showlogin'];
$status=$_POST['status'];
$statusselected=$status[0];
$newsystem=$_GET['newsystem'];

/*
echo "<script type='text/javascript'>var answer=confirm('Do you really want to go here?')";
echo "if (answer) { window.location ='http://cemma-usc.net/cemma/testbed/EmailOptOut.php?email=f'; }";
echo "</script>";
*/
	
if($first=="true")
{
	if ($showlogin=="true")
	{
		echo "<form action= 'http://cemma-usc.net/schedule/cgi-bin/UpdateStatus.php?email=$Emailid&first=false&showlogin=true'  method='post'>";
	}
	else
	{
		echo "<form action= 'http://cemma-usc.net/schedule/cgi-bin/UpdateStatus.php?email=$Emailid&first=false'  method='post'>";
	}
	echo "<center><br>Update the Status of your \"Center for Electron Microscopy and Microanalysis (CEMMA)\" <br><br>";
	echo "<input type='radio' name='status[]' id='status' value='active'>Active&nbsp;";
	echo "<input type='radio' name='status[]' id='status' value='inactive'>Inactive\n<br/><br/>";
	echo "<input type='submit' value='Submit'>";
	echo "</center></form>";
}
else
{
	$today = date("Y-n-j"); 
	//echo " today-".$today;
	/*
	$dbhost="db948.perfora.net";
	$dbname="db210021972";
	$dbusername="dbo210021972";
	$dbpass="XhYpxT5v";

	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connectionnn");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DBbb");
	*/
	$dbhost="db948.perfora.net";
	$dbname="db210021972";
	$dbusername="dbo210021972";
	$dbpass="XhYpxT5v";
	
	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connectionnn");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in Old DB");
	
	$sql23 = "SELECT Email FROM user  WHERE Email = '$Emailid'";
	$values1=mysql_query($sql23) or die("An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
	//$row33 = mysql_fetch_array($values1); 
	$totalemailcountcustomer=0;
	
	while($row23 = mysql_fetch_array($values1))
	{
		if ($row23['Email']==NULL)
		{
			echo "Email ID not found";
		}
		$sql3 = "UPDATE user SET ActiveUser = '$statusselected', LastStatusUpdate='$today',ResponseEmail='Updated',LastEmailSentOn='$today' WHERE Email = '$Emailid'";
		mysql_query($sql3) or die ("Error3");
		
		echo "<center>You have successfully updated the Status to $statusselected</center>";
	}
	$sql="SELECT UserName ,Passwd  FROM user WHERE Email = '".$Emailid."'";
	mysql_query($sql) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);


	echo " <form name='myForm' method='POST' action='http://cemma-usc.net/schedule/cgi-bin/verify.pl'><input type='hidden' id='login' name='login' value='".$row['UserName']."' />";
	echo " <input type='hidden' id='password' name='password' value='".$row['Passwd']."' />";
	echo "</form>";
	if ($showlogin=='true')
	{

	?>
	<script language='javascript'>
	//  window.location = 'http://cemma-usc.net/schedule/cgi-bin/verify.pl';
	document.myForm.submit();
	</script>
	<?
	}
}

?> 