<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CEMMA</title>
<meta http-equiv="imagetoolbar" content="no" /> 
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="scripts/menuScript.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/easySlider1.5.js"></script>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function(){	
	$("#slider").easySlider({
		controlsBefore:	'<p id="controls">',
		controlsAfter:	'</p>',
		auto: true, 
		continuous: true
	});	
});
// ]]>
</script>


</head>
<?
function getfilename()
{
	$x= explode("/",$_SERVER['SCRIPT_NAME']);
	$f=count($x)-1;
	return $x[$f];
}
?>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td class="main">


  <table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td class="header" align="center">
    <table border="0" cellpadding="0" cellspacing="0"><tr><td class="block_header">
      <div class="logo"><a href="index.html"><img src="images/logo.png"  height="124" border="0" alt="logo" /></a></div>
      <div class="search">
        <form id="form1" name="form1" method="post" action="">
          <label>
            <input name="q" type="text" class="keywords" id="textfield" maxlength="50" />
            <input name="b" type="image" src="images/search.gif" class="button" />
          </label>
        </form>
      </div>
      <div class="clr"></div>
      		<div class="association"><img src="images/association-logo.jpg" /></div>
          <div style="float:right;">
            <div class="clr"></div>
                <div class="menu">
                  <ul>
                    <li><a href="index.php">Home</a></li>                                   
                    <li><a href="contact.html">About Us</a></li>
                    <li><a href="services.html">Services</a></li>
                    <li><a href="login.php">Members</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
					<?php if(isset($_SESSION["login"]) && isset($_SESSION["password"])){ ?>
					<li><a href="logout.html">LogOut</a></li>
					<?php } ?>
					
					
					
					</ul>
                </div>
          </div>
      <div class="clr"></div>
    </td></tr></table>
  </td></tr></table>
  
  
  
    
      