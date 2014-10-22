<? 	
	include_once('../constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	if($class==4){
		header('Location: login.php');
	}
	$send = $_GET['send'];
	if($send == true){
		$from = "cemma@usc.edu";
		$headers = "From: $from";
		
		$subject = $_POST['Subject'];
		$to = $_POST['to'];
		$message= $_POST['Message'];
		mail($to,$subject,$message,$headers);
		echo "Email sent successfully to: <b>". $to . "</b>";
	} else {
		echo "Some error occurred...". $to;
	}
?>