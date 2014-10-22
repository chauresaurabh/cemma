<?php
	include(DOCUMENT_ROOT.'DAO/customerDAO.php');
	$customerDAO = new CustomerDAO();
	
	if(isset($_SESSION['login'])){
		$class = $customerDAO->getRoleID($_SESSION['login']);
	} else {
		$class = -1;
	}
	include(DOCUMENT_ROOT.'DAO/instrumentDAO.php');
	$customerDAO = new InstrumentDAO();
	include(DOCUMENT_ROOT.'DAO/invoiceDAO.php');
	$customerDAO = new InvoiceDAO();
?>