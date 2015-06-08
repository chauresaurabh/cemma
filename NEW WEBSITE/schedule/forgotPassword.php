<?

$dbhost="db948.perfora.net";
$dbname="db210021972";
$dbusername="dbo210021972";
$dbpass="XhYpxT5v";

$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
$SelectedDB = mysql_select_db($dbname) or die ("Error in Old DB");

$username = $_GET['username'];
$pos = stripos($username, "drop ");
$email;

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
		
		if($username=='') {
			$email = $_GET['email'];
			if($email == '') {
				echo "User details not found!";
				return;
			}
		}
		
		if($username == '') {
			$sql = "SELECT Username, Passwd, Email, Prevent FROM user WHERE Email = '$email'";
		} else {
			$sql = "SELECT Username, Passwd, Email, Prevent FROM user WHERE username = '$username'";
		}
		
		$result = mysql_query($sql) or die( "An error has occurred: " .mysql_error (). ":" .mysql_errno ());
	
		if(mysql_num_rows($result)==0){
			echo "Invalid user details!";
		} else {
			$row = mysql_fetch_array($result);
			$pwd = $row["Passwd"];
			$to = $row["Email"];
			$uname = $row["Username"];
			$prevent = $row["Prevent"];
			
			if($prevent == 1) {
				echo "Please contact the administrator.";
				return;
			}
			//echo "Your password is: ".$pwd;
			$from = "cemma@usc.edu";
			
			$subject = "Password Request";
			$body = "Your username is: ".$uname."\nYour password is: ".$pwd;
				
			$headers = "From:" . $from;
			
			mail($to, $subject, $body, $headers);
			echo "Please check your email for your password!";
		}
	} else {
		echo "Invalid user details!";
	}
} else {
	echo "Invalid user details!";
}
?>
