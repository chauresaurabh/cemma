<?php
	if(!isset($_SESSION))
			session_start();
	if(!$_SESSION['login']){
		header('Location: ../login.php');
	}
?>


<? 
	include_once("../includes/database.php");
	include("../DAO/customerDAO.php");
	
		$customerDAO = new CustomerDAO();
		
		$class = $customerDAO->getRoleID($_SESSION['login']);
		
		if($class != 1){
			header('Location: ../login.php');
		}
		
	include ('../tpl/header.php'); ?>
 
    <table border="0" cellpadding="0" cellspacing="0" width="100%">   
	
	<tr><td class="body" valign="top" align="center">
    <table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="body_resize">
    	<table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="left" valign="top">
		<br/><br/>

         <? include ('../tpl/admin-loged-in.php'); ?> 
		 
      </td>
      
      <td class="right">
	  
	  
	  </td></tr></table>
      <div class="clr"></div>
	  </td></tr></table>

  </td></tr></table>
  
</td></tr></table>
   <? include ('tpl/footer.php'); ?>
		
		