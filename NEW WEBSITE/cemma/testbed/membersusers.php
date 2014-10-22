
<?php
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadminuser.php");
	
	echo "class-".$class;
	if($_SESSION['ClassLevel'] > 0 && $_SESSION['ClassLevel']<6)
		header('Location: administration.php');
	else if($_SESSION['ClassLevel'] == 2 || $_SESSION['ClassLevel']==5)
		header('Location: EditMyAccountUser.php?id='.$_SESSION['login'].'');
	else if($_SESSION['ClassLevel'] == 3 || $_SESSION['ClassLevel'] == 4)
	//		header('Location: MyAccount.php?id='.$_SESSION['Customer_ID'].'');
		header('Location: EditMyAccountUser.php?id='.$_SESSION['login'].'');

	//header('Location: administration.php');
	include (DOCUMENT_ROOT.'tpl/header.php');
	
?>

    <table border="0" cellpadding="0" cellspacing="0" width="100%">   
	
	<tr><td class="body" valign="top" align="center">
    <table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="body_resize">
    	<table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="left" valign="top">
		<br/><br/>

         <? include (DOCUMENT_ROOT.'tpl/menu-loged-in.php'); ?> 
		 
      </td>
      
      <td class="right">
	  
	  
	  
	  
	  
	  </td></tr></table>
      <div class="clr"></div>
</td></tr></table>

  </td></tr></table>
  
</td></tr></table>
   <? include (DOCUMENT_ROOT.'tpl/footer.php'); ?>

  
