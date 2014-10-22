<?PHP
//  ------ create table variable ------
// variables for Netscape Navigator 3 & 4 are +4 for compensation of render errors
$Browser_Type  =  strtok($HTTP_ENV_VARS['HTTP_USER_AGENT'],  "/");
if ( ereg( "MSIE", $HTTP_ENV_VARS['HTTP_USER_AGENT']) || ereg( "Mozilla/5.0", $HTTP_ENV_VARS['HTTP_USER_AGENT']) || ereg ("Opera/5.11", $HTTP_ENV_VARS['HTTP_USER_AGENT']) ) {
	$theTable = 'WIDTH="400" HEIGHT="245"';
} else {
	$theTable = 'WIDTH="404" HEIGHT="249"';
}

// ------ create document-location variable ------
if ( ereg("php\.exe", $HTTP_SERVER_VARS['PHP_SELF']) || ereg("php3\.cgi", $HTTP_SERVER_VARS['PHP_SELF']) || ereg("phpts\.exe", $HTTP_SERVER_VARS['PHP_SELF']) ) {
	$documentLocation = $HTTP_ENV_VARS['PATH_INFO'];
} else {
	$documentLocation = $HTTP_SERVER_VARS['PHP_SELF'];
}
if ( $HTTP_ENV_VARS['QUERY_STRING'] ) {
	$documentLocation .= "?" . $HTTP_ENV_VARS['QUERY_STRING'];
}

?>
<html><head>
	<meta name="description" content="<?PHP echo $strLoginInterface; ?>">
	<meta name="keywords" content="<?PHP echo $strLogin; ?>">
	<title><?PHP echo $strLoginInterface; ?></title>

<SCRIPT LANGUAGE="JavaScript">
<!--
//  ------ check form ------
function checkData() {
	var f1 = document.forms[0];
	var wm = "<?PHP echo $strJSHello; ?>\n\r\n";
	var noerror = 1;

	// --- entered_login ---
	var t1 = f1.entered_login;
	if (t1.value == "" || t1.value == " ") {
		wm += "<?PHP echo $strLogin; ?>\r\n";
		noerror = 0;
	}

	// --- entered_password ---
	var t1 = f1.entered_password;
	if (t1.value == "" || t1.value == " ") {
		wm += "<?PHP echo $strPassword; ?>\r\n";
		noerror = 0;
	}

	// --- check if errors occurred ---
	if (noerror == 0) {
		alert(wm);
		return false;
	}
	else return true;
}
//-->
</SCRIPT>

	 <? include ('tpl/header.php'); ?>
 
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    
    
    <? 
	if(getfilename()=='index.php')
	{
		include ('tpl/home-top-slider.php');
	}
	 ?>  
    
    <tr><td class="body" valign="top" align="center">
    <table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="body_resize">
    	<table border="0" cellpadding="0" cellspacing="0" align="center"><tr><br /><br /><br /><br />
      
      <td class="right">
                
        <h2 class="Login">Login</h2>

        <div class="login-area">
    
			<form action='<?PHP echo $documentLocation; ?>' METHOD="post" onSubmit="return checkData()">


			<table border="0" cellpadding="0" cellspacing="7" align="center">
			
			<tr><td align="right" class="lg-txt">Username:</td>
			<td><input name="entered_login" type="text" class="text" id="entered_login" /></td></tr>
			<tr><td align="right" class="lg-txt">Password:</td>
			<td><input name="entered_password" type="password" class="text" id="entered_password" /></td></tr>
			
            <tr><td></td><td class="red" align="left">
			<?php
			// check for error messages
			if ($message) {
				echo $message;
			} ?>
			
			</td></tr>
			<tr><td></td>
			<td align="center"><input name="login" type="submit" id="login" value="" class="btnlogin" tabindex="1"></td></tr>
			<tr><td></td>
			<td align="center"><a href="#" style="font-size:12px;">Forgot password ?</a> | <a href="#" style="font-size:12px;">New User</a></td></tr>
			</table>
			
</form>
 </div>
        
        
        <h2 class="horline"></h2>
        
      </td></tr></table>


      <div class="clr"></div>
</td></tr></table>

  </td></tr></table>

   <? include ('tpl/footer.php'); ?>


<SCRIPT LANGUAGE="JavaScript">
<!--
document.forms[0].entered_login.select();
document.forms[0].entered_login.focus();
//-->
</SCRIPT>
</body></html>
