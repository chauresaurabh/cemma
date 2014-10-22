<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	if($class==4){
		header('Location: login.php');
	}
	$send = $_GET['send'];
	
		$emailIds = explode(";",$_POST['to']);
		
		$from = "cemma@usc.edu";
		$headers = "From: $from";
		
		for($i=0; $i < count($emailIds); $i++) {
			$subject = $_POST['Subject'];
			$to = trim($emailIds[$i]);
			$message= $_POST['Message'];
			mail($to,$subject,$message,$headers);
		}
		mysql_close($connection);
		echo "Email sent to today's customers";
?>
<script type="text/javascript">
CloseModelWindow();
</script>