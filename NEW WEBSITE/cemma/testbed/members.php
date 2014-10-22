
<?php
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	
echo "class-".$class;
if($class == 1)
		header('Location: administration.php');
		/*
	if($class == 2)
		header('Location: customers.php');
	if($class == 3 || $class == 4)
		header('Location: customers.php');
	*/
	//header('Location: administration.php');
	include (DOCUMENT_ROOT.'tpl/header.php');
	
?>

    <table border="0" cellpadding="0" cellspacing="0" width="100%">   
	
	<tr><td class="body" valign="top" align="center">
    <table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="body_resize">
    	<table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="left" valign="top">
		<br/><br/>

         <? #include (DOCUMENT_ROOT.'tpl/menu-loged-in.php'); ?> 
		 
      </td>
      
      <td class="right">
	  </td></tr></table>
      <div class="clr"></div>
</td></tr></table>

  </td></tr></table>
  
</td></tr></table>
   <? include (DOCUMENT_ROOT.'tpl/footer.php'); ?>

  
