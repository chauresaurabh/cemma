<?php
	if(!isset($_SESSION))
			session_start();
	if(!$_SESSION['login']){
		header('Location: login.php');
	}
	else{

		include("DAO/customerDAO.php");
	
		$customerDAO = new CustomerDAO();
		
		$class = $customerDAO->getRoleID($_SESSION['login']);
	
		if($class == 1){
			header('Location: index.php');
		}
		else{
			echo $class;	
		}
	}
	
?>