<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta http-equiv="Content-Language" content="en-us">
<title>Login</title>
<link rel="stylesheet" href="./css/masc.css" type="text/css">
<script type="text/javascript">
function forgotUsername() {
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
	 
	login = document.getElementById('login').value; 
	 
	xmlHttp.onreadystatechange=function() {
		if(xmlHttp.readyState==4) {
			document.getElementById('msg').innerHTML = xmlHttp.responseText;
		}
	}

	xmlHttp.open("GET","forgotPassword.php?username="+login,true);
	xmlHttp.send(null);
}
</script>
</head>

<body background="_image/valtxtr.gif">


	<!-- LOG IN - CONTENT -->
	<div class="content" style="padding:30px">
		<center>
		<p>
			<span style="color:#F00;font-size:16px">Please don't use the below form to login.<br/>Please click LOGIN on the menu above to login to the new website</span>
		</p>
		<form method="POST" action="cgi-bin/verify.pl"> 
			<p>&nbsp;&nbsp;&nbsp; Username: <input type="text" id="login" name="login" size="20"></p> 
			<p>&nbsp;&nbsp;&nbsp; Password: <input type="password" name="password" size="20"></p> 
			
			<p>
				<input type="submit" value="Login" name="B1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="reset" value="Clear" name="B2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" value="Forgot Password" onClick="forgotPassword()">
			</p>
            <p id="enterEmail" style="display:none">
            	&nbsp;&nbsp;&nbsp; Email: <input id="email" name="email" type="text" class="text"/>
            </p>
            <p><input  type="button" value="Forgot Username" onClick="forgotUsername();"></p>
            <p>
            <span id="msg"></span>
            </p>
		</form> 
	
	<!-- END LOG IN - CONTENT -->

	<hr>

	<p>
	If you don't have an account, <a href="http://www.usc.edu/dept/CEMMA/account-set-up.htm" target="_parent">click here</a>.
	
	<!--or have forgetten your password, please contact
	the director of CEMMA: </p>

	<p>John Curulli.</p>
	<p>Email to : <img height="12" alt="" width="113" src="./_image/64942.jpg" /></p>
	<p>Tel:&nbsp;&nbsp;&nbsp;&nbsp; 213-740-1990</p>
	<p>Fax:&nbsp;&nbsp;&nbsp;&nbsp; 213-821-0458</p>
	-->
	
	<!-- Counter PHP script -->
	<hr/>
	<p>
		<?php @include_once("counter.php");?>
	</p>
	</center>
	</div>
</body>  
</html> 
