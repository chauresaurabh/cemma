<?php
	session_start();
	$instrName = $_GET['instrName'];
	$username = $_GET['userName'];
	$email=$_GET['email'];
	
	$from = "cemma@usc.edu";
	$subject = "Instrument Training Request";
	$body = "Instrument Training Request:\n\n".$username." (".$email.") has requested training for ".$instrName;
		
	$to = "curulli@usc.edu";
		
	$headers = "From:" . $from;
	
	mail($to, $subject, $body, $headers);
	
	session_write_close();
?>