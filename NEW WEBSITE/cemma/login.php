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
        
                    <form action = "/authentication/authentication.php" method = "post">
						
                        <table border="0" cellpadding="0" cellspacing="7" align="center">
											
							<tr><td align="right" class="lg-txt">Username:</td><td><input name="username" type="text" class="text" id="username" /></td></tr>
                            <tr><td align="right" class="lg-txt">Password:</td><td><input name="password" type="password" class="text" id="password" /></td></tr>
                            <tr><td></td><td class="red" align="left"><!--Error in username --></td></tr>
							<tr><td></td><td align="center"><input name="login" type="submit" id="login" value="" class="btnlogin"></td></tr>
                            <tr><td></td><td align="center"><a href="#" style="font-size:12px;">Forgot password ?</a> | <a href="#" style="font-size:12px;">New User</a></td></tr>
						</table>
                        
					</form>

        </div>
        
        
        <h2 class="horline"></h2>
        
      </td></tr></table>
      <div class="clr"></div>
</td></tr></table>

  </td></tr></table>

   <? include ('tpl/footer.php'); ?>