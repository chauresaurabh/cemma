<?php
	include_once('constants.php');
include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
	session_start();

	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connectionnn");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in Old DB");

	$instrName = $_GET['instrName'];
	$instrNo = $_GET['instrNo'];

	$username = $_GET['userName'];
	$email=$_GET['email'];
	
	$date = date('Y-m-d H:i:s');
 
 	 $sql="insert into INSTRUMENT_REQUEST_STATUS( UserName, Email , InstrNo, InstrumentName , requested_date ) values('$username','$email','$instrNo','$instrName', '$date') ";
 	 mysql_query($sql) or die(mysql_error());
			 
	$from = "cemma@usc.edu";
	$subject = "Instrument Training Requested";
	$body = "Instrument Training Request:\n\n".$username." (".$email.") has requested training for ".$instrName;
		
	$to = "curulli@usc.edu";
		
	$headers = "From:" . $from;
	
	mail($to, $subject, $body, $headers);
	
	session_write_close();
?>