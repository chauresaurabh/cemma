<?php

 	 if(!isset($_SESSION))
		session_start();
	if ($_GET['captcha_code'] != $_SESSION['captcha']) {
		echo 0;
	}else{
		echo 1;
	}
	
?>