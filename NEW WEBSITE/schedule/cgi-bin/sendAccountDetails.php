<?
 
$dbhost="db1661.perfora.net";
$dbname="db260244667";
$dbusername="dbo260244667";
$dbpass="curu11i";

$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
$SelectedDB = mysql_select_db($dbname) or die ("Error in Old DB");

$username = $_GET['username'];
 
$pos = stripos($username, "drop ");
$email;

$firstName = "";
$lastName = "";

if($pos === false){
	$pos = stripos($username, "drop&nbsp;");
	if($pos === false){
		$pos = stripos($email, "drop ");
		if($pos == false) {
			$pos = stripos($email, "drop&nbsp;");
			if($pos == true) {
				echo "Invalid Data!";
				return;
			}
		}
		$pwd="";
		$to="";
 		if($username=='') {
			$email = $_GET['email'];
			if($email == '') {
				echo "User email address not found!";
				return;
			}
		}
		if($username == '') {
			$sql = "SELECT FirstName, LastName, Uname, Passwd, EmailId FROM Customer WHERE EmailId = '$email'";
		} else {
			$sql = "SELECT  FirstName, LastName, Uname, Passwd, EmailId FROM Customer WHERE Uname = '$username'";
		}
		$result = mysql_query($sql,$connection) or die("Some error occurred. Please contact the Administrator.");
		if(mysql_num_rows($result)==0){
 			if($username == '') {
				$sql = "SELECT  FirstName, LastName, Username, Passwd, Email FROM user WHERE Email = '$email'";
 			} else {
				$sql = "SELECT FirstName, LastName,  Username, Passwd, Email FROM user WHERE username = '$username'";
			}
			$result = mysql_query($sql,$connection) or die("Some error occurred. Please contact the Administrator.");
			 
 			if(mysql_num_rows($result)==0){
				echo "User details not found for '$email' !";
				return;
			} else {
				$row = mysql_fetch_array($result);
				$uname = $row["Username"];
				$pwd = $row["Passwd"];
				$to = $row["Email"];
				$firstName = $row["FirstName"];
				$lastName = $row["LastName"];

			}
		} else {
			$row = mysql_fetch_array($result);
			$uname = $row["Uname"];
			$pwd = $row["Passwd"];
			$to = $row["EmailId"];
 			$firstName = $row["FirstName"];
			$lastName = $row["LastName"];
 		}

 		$sql = "SELECT Prevent FROM user WHERE Username='$uname'";
		$result = mysql_query($sql, $connection) or die("Some error occurred. Please contact the Administrator.");
		if(mysql_num_rows($result)==0){
			echo "User details not found!";
			return;
		} else {
			$row = mysql_fetch_array($result);
			$prevent = $row["Prevent"];
		}
		if($prevent == 1) {
			echo "Please contact the administrator.";
			return;
		}
		//echo "Your password is: ".$pwd;
		$from = "cemma@usc.edu";
		
		$subject = "Your CEMMA Account Details";
		
		
		$body = "Hello ".$firstName." ".$lastName . ", <br><br>";
		$body = $body ."Your Username is: <b> ".$uname."</b><br>Your Password is: <b>".$pwd."</b>";
			
			$body = $body."<br><br> Center for Electron Microscopy and Microanalysis<br> 
	<span style='color:#980F07;'>University of Southern California</span><br>814 Bloom Walk<br>CEM Building<br>Los Angeles, CA 90089-1010
	<br>Tel:   &nbsp;&nbsp;213.740.1990<br>Fax: 213.821.0458";

$body = $body ."<br><br>You are receiving this e-mail because you have an active account with the Center for Electron Microscopy and Microanalysis (CEMMA).";
 $body = $body."<br><br>Note: This is an auto generated mail. Please do not reply.";

 		$headers = "From:" . $from;
		$headers .=  "\r\n". 'MIME-Version: 1.0'	. "\r\n" ."Content-type: text/html; charset=iso-8859-1";

		$body = nl2br($body);
		
		mail($to, $subject, $body, $headers);
		mysql_client_encoding($connection);
		echo "Your Account Details have been Emailed to you! ";
		
		
	} else {
		echo "Invalid user details!";
	}
} else {
	echo "Invalid user details!";
}
?>
