<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta http-equiv="Content-Language" content="en-us">
<title>Can not login</title>
</head>

<body background="_image/valtxtr.gif">

<p><font color="#FF0000" size="4"><b>Can not login :</b></font></p>
<?
$type=$_GET['type'];
//echo "type-".$type;

if ($type == "pending")
{
	$status="Pending Account Activation...";
}

if ($type =="inactive")
{
	$status="Your account is in-activated";
}


?>
<p><font color="#FF0000" size="4"><? echo $status;?></font></p>
<p><font color="#FF0000" size="4">Please Activate your account by clicking on the following link</font></p>
<?
$Email=$_GET['email'];

//echo "type-".$type;

$url="http://cemma-usc.net/cemma/testbed/UpdateStatus.php?email=".$Email."&first=true&showlogin=true";
echo "<a href='".$url."'>".$url."</a>";

?>
<hr>
<p>&nbsp;</p>
<p><b><font size="4">Enter your username and password again. </font></b></p>
<form method="POST" action="cgi-bin/verify.pl"> 
<p>&nbsp;&nbsp;&nbsp; Username: <input type="text" name="login" size="20"></p>
<p>&nbsp;&nbsp;&nbsp; Password: <input type="password" name="password" size="20"></p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="submit" value="Login" name="B1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="reset" value="Clear" name="B2"></p>
</form> 
<p>&nbsp;</p>
<hr>
<p>If you forget your password, please contact the director of Lab:&nbsp; John Curulli.</p>
<p>Email to : <a href="mailto:curulli@usc.edu">curulli@usc.edu</a></p>
<p>Tel:&nbsp;&nbsp;&nbsp;&nbsp; 213-740-1990</p>
<p>Fax:&nbsp;&nbsp;&nbsp;&nbsp; 213-821-0458</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

</body>

</html>
