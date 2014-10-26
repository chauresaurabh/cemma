<?php
if(!isset($_SESSION))
		session_start();
$dbhost="db948.perfora.net";
$dbname="db210021972";
$dbusername="dbo210021972";
$dbpass="XhYpxT5v";

$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connectionnn");
$SelectedDB = mysql_select_db($dbname) or die ("Error in Old DB");

	if ($_POST['captcha_code'] != $_SESSION['captcha']) {
	  // the code was incorrect
	  // you should handle the error so that the form processor doesn't continue
	  // or you can use the following code if there is no validation or you do not know how
	  
	 	$dbhost="db1661.perfora.net";
		$dbname="db260244667";
		$dbusername="dbo260244667";
		$dbpass="curu11i";
		
		$firstname = $_POST["FirstName"];
		$lastname = $_POST["LastName"];
		$login=$firstname.'-'.$lastname;
 	
		$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
		$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
		
		$captcha_entered = $_POST['captcha_code'];
		$captcha_answer = $_SESSION['captcha'];
		
		 $sql = "insert into CAPTCHA_LOGS(username, captcha_entered, captcha_answer) values('$login', '$captcha_entered', '$captcha_answer' )";
		 mysql_query($sql) or die(mysql_error());
		 
	  echo "The security code entered was incorrect.<br /><br />";
	
	  echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
	  exit;
	}
	
	if(strlen($_POST["Comments"])>200) {
		echo "Please do not spam our website.<br/>";
		echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
	  	exit;
	}

	print "<html>\n";
	print "<head>\n";
	print "</head>";
	print "</html>";
	
	$firstname = $_POST["FirstName"];
	$lastname = $_POST["LastName"];
	$login=$firstname.'-'.$lastname;
	$password='123';
	$email= $_POST["Email"];
	
 	$accountNum = $_POST["AccountNum1"].$_POST["AccountNum2"].$_POST["AccountNum3"];

	$advisorfromtext= $_POST["OtherAdvisor"];
	$advisorfromlist= $_POST["Advisorlist"];
	
	$uscid = $_POST["uscbox"];
	
	if( $uscid =="")
		$uscid="N/A";
		
	if($advisorfromlist=="New Advisor")
	{
		$advisor=$advisorfromtext;
		$newadvisor=1;
	}
	else
	{
		$advisor=$advisorfromlist;
		$newadvisor=0;
	}
	$dept = $_POST["Dept"];
	$tel = $_POST["Telephone1"]."-".$_POST["Telephone2"]."-".$_POST["Telephone3"];
	$position = $_POST["Position"];
	$checkbox = $_POST["Class"];
    $gradyear = $_POST["GradYear"];
    $gradterm = $_POST["GradTerm"];

	$fieldofinterest=$_POST['fieldofinterest'];
	$countfieldofinterest = count($fieldofinterest);
	$fieldofinteresttosave="";

	for ($i=0;$i<$countfieldofinterest ; $i++)
	{
		if ($i==0)
		{	
			$fieldofinteresttosave=$fieldofinterest[$i];
		}
		else
		{	
			$fieldofinteresttosave=$fieldofinteresttosave.",".$fieldofinterest[$i];
		}
	}
	if ($checkbox == "")
	{
		$class=2;
	}
	else
	{
		$class=1;
	}
	
	if($gradyear == '') {
		$flag=1;
		$gradyear = 'NULL';
		$gradterm = '';
	}
	else {  
    	$gradyear = "'$gradyear'";
	}
	$Comments = $_POST["Comments"];

	$today = date('Y-m-d H:i:s');
	
	$nameconcat = $firstname." ".$lastname;
 $insertQuery = "insert into UsersInQuery(UserName, Passwd, AccountNum, Class, Email, Name, FirstName, LastName, Telephone, Dept,Advisor, Position, GradYear, GradTerm, FieldofInterest, Comments, SubmittedDate, uscid) values('$login', '$password', '$accountNum', '$class', '$email','$nameconcat','$firstname','$lastname', '$tel', '$dept', '$advisor','$position', $gradyear, '$gradterm' , '$fieldofinteresttosave', '$Comments', '$today' , '$uscid' )";
	mysql_query($insertQuery) or die( "An error has ocured in query11: " .mysql_error (). ":" .mysql_errno ()); 
	
	$instrNum = $_POST["InstrNum"];
	for ($ii=1; $ii <= $instrNum; $ii++)
	{
		$instrNo = $_POST["Instr$ii"];
		if ($instrNo != "")
		{
			
		}
	}
	
	$InstrumentName=$_POST['InstrumentName'];
	$countInstrumentName = count($InstrumentName);
	$sql3 = "DELETE FROM instr_group WHERE Email='$Email'";  
	mysql_query($sql3) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 

	$instrlist="";
	for ($i=0;$i<$countInstrumentName ; $i++)
	{
		$pieces = explode("-", $InstrumentName[$i]);
		
		$intruments[$i]=$pieces[0];
		$instrno=$intruments[$i];
		$result = mysql_query("SELECT InstrumentName FROM instrument WHERE InstrumentNo = '".$instrno."'");
		
		$row = mysql_fetch_array($result);
		$instrlist=$instrlist."\n".$row[0];
		
		$today = date("Y-d-m");
		
		mysql_query("insert into UsersInQuery_instr_group (InstrNo, Email, InstrSigned, UserName) values('$instrno', '$email', '$today','$login')") or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 

/*		$sql3 = "INSERT INTO instr_group (InstrNo,  Email , InstrSigned, Permission) VALUES ('$instrno', '$email', '$today', 'Peak time only')";  
	
		mysql_query($sql3) or die( "An error has ocured in query2: " .mysql_error (). ":" .mysql_errno ()); */
	}
	
	//have to add user in the new database as well
	$dbhost="db1661.perfora.net";
	$dbname="db260244667";
	$dbusername="dbo260244667";
	$dbpass="curu11i";
	
	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
	
	mysql_query($insertQuery, $connection) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ());
	
	$instrNum = $_POST["InstrNum"];
	for ($ii=1; $ii <= $instrNum; $ii++)
	{
		$instrNo = $_POST["Instr$ii"];
		if ($instrNo != "")
		{
			
		}
	}
	
	$InstrumentName=$_POST['InstrumentName'];
	$countInstrumentName = count($InstrumentName);
	$sql3 = "DELETE FROM instr_group WHERE Email='$Email'";  
	mysql_query($sql3, $connection) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 

	$instrlist="";
	for ($i=0;$i<$countInstrumentName ; $i++)
	{
		$pieces = explode("-", $InstrumentName[$i]);
		
		$intruments[$i]=$pieces[0];
		$instrno=$intruments[$i];
		$result = mysql_query("SELECT InstrumentName FROM instrument WHERE InstrumentNo = '".$instrno."'", $connection);
		
		$row = mysql_fetch_array($result);
		$instrlist=$instrlist."\n".$row[0];
		
		$today = date("Y-d-m");
		
		mysql_query("insert into UsersInQuery_instr_group (InstrNo, Email, InstrSigned, UserName) values('$instrno', '$email', '$today','$login')", $connection) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 

/*		$sql3 = "INSERT INTO instr_group (InstrNo,  Email , InstrSigned, Permission) VALUES ('$instrno', '$email', '$today', 'Peak time only')";  
	
		mysql_query($sql3) or die( "An error has ocured in query2: " .mysql_error (). ":" .mysql_errno ()); */
	}
	

	
	print "<h3><center>Entry for \"$login\" has been created successfully on $today </h3>\n";
	print "<h3><center>Click below to add Additional New User</h3>\n";
	print "<center><input type='button' value='Continue' onClick='submitclicked()' /></center>";
	
	print "</body>\n";
	print '<script type="text/javascript">';
	print "function submitclicked() {";
	print "window.location='http://cemma-usc.net/schedule/cgi-bin/AccountSetup.pl';";
	print " } ";
	print "</script>";
	print "</html>\n";

mysql_close();

$from = "cemma@usc.edu";
$subject = "New User Account Request ($login) ";
$body = "New User Account Request:\n\nUser Name : ".$login."\nAccount Number: ".$accountNum."\nUSC ID : ".$uscid."\nFirst Name: ".$firstname." \nLast Name: ".$lastname." \nEmail: ".$email." \nAdvisor: ".$advisor." \nDepartment: ".$dept." \nTelephone: ".$tel." \nField: ".$fieldofinteresttosave." \n\nInstruments List: ".$instrlist." \n\nComments: ".$Comments;
	
$to = "curulli@usc.edu";
	
$headers = "From:" . $from;

mail($to, $subject, $body, $headers);
 
session_write_close();
?>