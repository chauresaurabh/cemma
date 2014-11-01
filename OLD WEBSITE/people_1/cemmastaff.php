<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>CEMMA - Professional Staff</title>
<link rel="stylesheet" href="/dept/CEMMA/css/masc.css" type="text/css">
<link rel="stylesheet" href="/dept/CEMMA/css/usclogo.css" type="text/css">

</head>
<body bgcolor="#eeeeee"><center>
<table width="1024px" border="0" cellspacing="0" cellpadding="0" valign="top" style="table-layout:fixed:">
	<tr>
		<td>
			<table class="gold" width="100%" border="0" cellspacing="0" cellpadding="0" valign="top">
				<tr>
					<td colspan="5" id="usclogo" bgcolor="#000000">
                    <a href="http://www.usc.edu/" id="anchorlogo" target="_blank"> </a></td>
				</tr>
				<tr>
					<td align="center" height="100">
						  <span style="font-size:40px;  ">Center for Electron Microscopy and Microanalysis</span>
 						<!--<img src="/dept/CEMMA/images/cemmab.gif" width="200" height="115" align="right">-->
					</td>
				</tr>
				<tr>
					<td valign="bottom" align="right">
						
						<a href="http://cemma-usc.net/cemma/testbed/login.php"><img src="/dept/CEMMA/images/login_black.gif" BORDER=0></a>
						<a href="/dept/CEMMA/account-set-up.htm"><img src="/dept/CEMMA/images/new_user_black.gif" BORDER=0></a>
						<a href="/dept/CEMMA/policy/"><img src="/dept/CEMMA/images/user_policy_black.gif" BORDER=0></a>
						<a href="/dept/CEMMA/instruments/status.html"><img src="/dept/CEMMA/images/instrument_availability.gif" BORDER=0></a>
						<!--<a href="/dept/CEMMA/sign_up.htm">Log In</a>
						<a href="/dept/CEMMA/account-set-up.htm">New User</a>-->
					</td>
				</tr>
			</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" width="180" align="left" class="gold">
												
						<div class="content">
							<center>In Association with:<br>
							<a href="http://viterbi.usc.edu/"><img src="/dept/CEMMA/images/viterbi.gif" width="140" style="margin:2px"></a><br>
							<a href="http://www.usc.edu/schools/college/" border="0"><img src="/dept/CEMMA/images/Dornsife_Logo.jpg" width="140"style="margin:2px"></a>
							</center>
						</div>
						
						<div class="menu-button"><a href="/dept/CEMMA/"><img src="/dept/CEMMA/images/home_180.gif" BORDER=0></a></div>
						<div class="menu-button"><a href="/dept/CEMMA/mission"><img src="/dept/CEMMA/images/mission_statement_180.jpg" BORDER=0></a></div>
						<div class="menu-button"><a href="/dept/CEMMA/instruments/"><img src="/dept/CEMMA/images/instruments_180.jpg" BORDER=0></a></div>
						<div class="menu-button"><a href="http://cemma-usc.net/cemma/testbed/cemmastaff.php"><img src="/dept/CEMMA/images/professional_staff_180.jpg" BORDER=0></a></div>
						<div class="menu-button"><a href="/dept/CEMMA/people_2/"><img src="/dept/CEMMA/images/oversight_committee_180.gif" BORDER=0></a></div>
						<div class="menu-button"><a href="/dept/CEMMA/gallery/"><img src="/dept/CEMMA/images/gallery.jpg" BORDER=0></a></div>
						<div class="menu-button"><a href="/dept/CEMMA/publication/"><img src="/dept/CEMMA/images/publications.jpg" BORDER=0></a></div>
						<!--<div class="menu-button"><a href="/dept/CEMMA/policy/"><img src="/dept/CEMMA/images/policy_180.gif" BORDER=0></a></div>-->
						<div class="menu-button"><a href="/dept/CEMMA/location/"><img src="/dept/CEMMA/images/visit_us_180.jpg" BORDER=0></a></div>
					</td>

					<td class="silver" height="100%" valign="top">

						<!-- PAGE TITLE -->
						<div align="center">
							<h3 class="page-title">PROFESSIONAL STAFF</h3>
						</div>
						<!-- END PAGE TITLE -->
						
						<!-- TEMPLATE - CONTENT -->
						<div class="content">
							<!--<h3 class="page-title"><span>PROFESSIONAL STAFF</span></h3>-->
							<table border="0" cellpadding="10" style="margin-left:30px">
								<tbody>	
                                <?
										
 										$dbhost="db1661.perfora.net";
										$dbname="db260244667";
										$dbusername="dbo260244667";
										$dbpass="curu11i";
									
									 $connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
										$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
										 $instrumentNo = $_GET['instrumentNo'];  
									
										 $sql = "SELECT * from PROFESSIONAL_STAFF";
 										 $result = mysql_query($sql);
										 while($row=mysql_fetch_array($result)){ 
										 ?>
									<tr>
                                   		<td><img alt="" src="<? echo $row['image'] ; ?>" width="100"></td>
  										<td>
											<font size="4" color="#990000" ><b>
											<? echo $row['name'] ; ?></b></font><br>
											<font size="2" color="#990000">
											<? echo $row['designation'] ; ?><br>
											<? echo $row['email'] ; ?>
											</font>												
										</td>
									</tr>
                                    
                                    <? } ?>
 									
								</tbody>
							</table>
							
						</div>
							<!-- END TEMPLATE - CONTENT -->
					</td>

				</tr>

				<tr>
					<td class="gold" align="center"></td>

					<td class="silver" height="100%" valign="top">

						<!-- footer  -->
						<center>
						<hr width="100%">

						  <h3> <span class="content-link">
						  <!-- footer  -->
													 
								<a href="/dept/CEMMA/">Home</a> | 
								<a href="/dept/CEMMA/mission/">Mission Statement</a> |
								<a href="/dept/CEMMA/instruments/">Instruments</a> | 
								Professional Staff |        
								<a href="/dept/CEMMA/people_2/">Advisery Committee</a> |        
								<a href="/dept/CEMMA/policy/">Policy</a> |        
								<a href="/dept/CEMMA/location/">Visit Us</a>
						  <!-- END FOOTER -->
							</span>
							</h3>
						</center>
					</td>
				</tr>
</table>
</body>
</html>