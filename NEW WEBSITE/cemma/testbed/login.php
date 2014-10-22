<script type="text/javascript">
function forgotUsername() {
	var selects = document.getElementsByClassName("loginForm");
	for(var i =0, il = selects.length;i<il;i++){
		selects[i].className += " hideLoginForm";
	}
	if(document.getElementById("enterEmail").style.display=="none") {
		document.getElementById("enterEmail").style.display="";
	} else {
		var xmlHttp;
	var email;
   try {
        // Firefox, Opera 8.0+, Safari
        xmlHttp=new XMLHttpRequest();
     } catch (e) {
        // Internet Explorer
        try {
          xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
       } catch (e) {
          try {
               xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
               alert("Your browser does not support AJAX!");
               return false;
            }
       }
     }
	 
	email = document.getElementById('email').value; 
	 
	xmlHttp.onreadystatechange=function() {
		if(xmlHttp.readyState==4) {
			document.getElementById('msg').innerHTML = xmlHttp.responseText;
		}
	}
	 
	xmlHttp.open("GET","forgotPassword.php?email="+email,true);
	xmlHttp.send(null);
	}
}
function forgotPassword(){
	var xmlHttp;
	var login;
   try {
        // Firefox, Opera 8.0+, Safari
        xmlHttp=new XMLHttpRequest();
     } catch (e) {
        // Internet Explorer
        try {
          xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
       } catch (e) {
          try {
               xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
               alert("Your browser does not support AJAX!");
               return false;
            }
       }
     }
	 
	login = document.getElementById('username').value; 
	 
	xmlHttp.onreadystatechange=function() {
		if(xmlHttp.readyState==4) {
			document.getElementById('msg').innerHTML = xmlHttp.responseText;
		}
	}

	xmlHttp.open("GET","forgotPassword.php?username="+login,true);
	xmlHttp.send(null);
}
</script>

<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");

	if($class>-1 && $class<6){
		header('Location: administration.php');
	}

	include (DOCUMENT_ROOT.'tpl/header.php'); 

 ?>

 
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    
    
    <? 
	if(getfilename()=='index.php')
	{
		include (DOCUMENT_ROOT.'tpl/home-top-slider.php');
	}
	?>  
    <tr><td class="body" valign="top">
    <table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="body_resize">
    	<table border="0" cellpadding="0" cellspacing="0"><tr><br /><br /><br /><br />
      
      <td class="right">
                
        <div class="login-area">
        				<h3 style="text-align:center;background-color: #BBBBBB;font-family: Verdana,Arial,Helvetica,sans-serif;font-size: 18px;font-weight: bold;width:100%;">INSTRUMENT LOGIN</h3><br/>
        
                        <table border="0" cellpadding="0" cellspacing="7" align="center">
							<?
							if(isset($_GET["error_login"]))
							{
								echo "<div><font color='red'>ERROR: Invalid Username or Password!</div>";
							}
							?>
							<form action = "authentication/authentication.php" method = "post">
                                <tr><td align="right" class="lg-txt loginForm">Username:</td><td><input id="username" name="username" type="text" class="text loginForm" /></td></tr>
                                <tr><td align="right" class="lg-txt loginForm">Password:</td><td><input name="password" type="password" class="text loginForm" /></td></tr>
                                <tr><td colspan="2" align="center">
                                <input name="login" type="submit" id="login" value="" class="btnlogin loginForm">                            </form>
                            
                            </td>
                            </tr>
                           <tr style="display:none" id="enterEmail">
                               <td align="right" class="lg-txt">Email:</td>
                               <td><input id="email" name="email" type="text" class="text"/></td>
						   </tr>
                           <tr>
                           		<td colspan="2" align="center">
				 <input type="button" value="" onClick="forgotPassword()"	class="btnForgotPassword loginForm">                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 <input  type="button" value="" class="btnForgotId" onclick="forgotUsername();">
                                 </td>
                           </tr>
                           <tr>
                           <td align="center" colspan="2"><span id="msg"></span></td>
                           </tr>
						</table>
                        
					

        </div>
        
        
        <h2 class="horline"></h2>
        
      </td></tr></table>
      <div class="clr"></div>
</td></tr></table>

  </td></tr></table>

   <? include ('tpl/footer.php'); ?>

