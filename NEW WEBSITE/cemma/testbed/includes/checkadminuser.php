<?php 
	include(DOCUMENT_ROOT.'DAO/customerDAO.php');
	$customerDAO = new CustomerDAO();
	$class = 1;
/*
if(isset($_SESSION['login'])){
		$class = $customerDAO->getRoleID($_SESSION['login']);
	}
	*/
	include(DOCUMENT_ROOT.'DAO/instrumentDAO.php');
	$customerDAO = new InstrumentDAO();
	include(DOCUMENT_ROOT.'DAO/invoiceDAO.php');
	$customerDAO = new InvoiceDAO();
?>