#!/usr/bin/perl
use lib "/kunden/homepages/40/d209127057/htdocs/schedule/cgi-bin/";
use CGI qw/:standard/;
use CGI::kSession;
use DBI;

#---------------------------------------------------------------------------------
# User management script.  Displays page containing a table listing all user 
# accounts.
#---------------------------------------------------------------------------------

$dsn = "DBI:mysql:database=db210021972:host=db948.perfora.net";
$db= DBI->connect($dsn, "dbo210021972", "XhYpxT5v");

my $s = new CGI::kSession(lifetime=>900, path=>"../../var/session/",id=>param("SID"));
$sid=$s->id();
$s->start();
$adminlogin=param("adminlogin");
$spassword=$s->get("$adminlogin");
$sth = $db->prepare("select Passwd, Class,userclass from user where UserName = '$adminlogin'");
$sth->execute();
($passworddb, $ClassAdmin,$userclass) = $sth->fetchrow_array();
$sth->finish();

if($spassword eq $passworddb)
{
	print "Content-type: text/html\r\n\r\n";
	if ($userclass eq 4)
	{
		print "<h3><center>You have no right for this operation!</h3>\n";
		exit;
	}

	# Dict for user info.
	my %users;
			

	$sth = $db->prepare("select UserName, FirstName, LastName, Email, ActiveUser from user where ActiveUser='active' OR ActiveUser IS NULL OR ActiveUser =''");
	$sth->execute();
	$user_no = 0;

	# Populate users dict, prep for sorting.
	my $UserName, $FirstName, $LastName, $Email,$ActiveUser;
	$countusers=0;
	$countarchivedusers=0;
	$countcurrentusers=0;

	while(($UserName, $FirstName, $LastName, $Email, $ActiveUser) = $sth->fetchrow_array) {
		$users{$UserName} = [$LastName, $FirstName, $Email, $ActiveUser];
		$countusers++;

		if($ActiveUser eq 'inactive'){
			$countarchivedusers++; 
		}
		else{
			$countcurrentusers++;
		}
	}
	print "<html>\n";
	print "<head>\n";
	print "<style type='text/css'>";
	print "a:hover {color:#FF0000} ";
	#print "img { filter: Wave(Add=0,  Freq=5,  LightStrength=20,  Phase=220,  Strength=10) }";
	print "</style>";

	print "<script language=\"JavaScript\" src=\"utils.js\"></script>";
	print "<script type = 'text/javascript'>";
	#print "	array = new Array(2)";
	#print "	array[0] = 1";
	#print "	array[1] = 0";
	print "var curr=1;";
	print "var queryuser=1;";
	print "var archiveduser=1;";

	print "function check_button(id) {";
	
	# if current users  expanded,id==0
	print "	 if(id == 0) {"; # minus clicked
	print "		 if(curr == 1) {"; #curr=1 means it is plus.
	print "			curr=0;";
	print "			document.getElementById('showImg' + id).src = '../_image/minus.gif';";
	print "			document.getElementById('currentusers').style.display='block';";
	print "		}";
	print "		else {";
	print "			curr=1;";
	print "			document.getElementById('showImg' + id).src = '../_image/plus.gif';";
	print "			document.getElementById('currentusers').style.display='none';";
	print "		}";
	print "	}";

	# if users in query expanded,id==1
	print "	 if(id == 1) {"; # plus clicked
	print "		 if(queryuser == 1) {"; #minus pressed, 0 passed
	print "			queryuser=0;";
	print "			document.getElementById('showImg' + id).src = '../_image/minus.gif';";
	print "			document.getElementById('usersquery').style.display='block';";
	print "		}";
	print "		else {";
	print "			queryuser=1;";
	print "			document.getElementById('showImg' + id).src = '../_image/plus.gif';";
	print "			document.getElementById('usersquery').style.display='none';";
	print "		}";
	print "	}";

	# if archived users expanded,id==2
	print "	 if(id == 2) {"; # plus clicked
	print "		 if(archiveduser == 1) {"; #minus pressed, 0 passed
	print "			archiveduser=0;";
	print "			document.getElementById('showImg' + id).src = '../_image/minus.gif';";
	print "			document.getElementById('archivedusersid').style.display='block';";
	print "		}";
	print "		else {";
	print "			archiveduser=1;";
	print "			document.getElementById('showImg' + id).src = '../_image/plus.gif';";
	print "			document.getElementById('archivedusersid').style.display='none';";
	print "		}";
	print "	}";
	
	print "	}";


	print "</script></head>\n";
   	print "<body background=\"../_image/valtxtr.gif\">\n";	
	print "<title>\n";
	print "User Managerment";
	print "</title>\n";	

	#print "  <form method=post action='TransferUsersInQuerytoUsers.pl?SID=$sid&adminlogin=$adminlogin'  name=\"newuser\">\n";
	print "  <form method=post action=\"TransferUsersInQuerytoUsers.pl\"  name=\"newuser\">\n";
	print "<input type=\"hidden\" name=\"adminlogin\" value = \"$adminlogin\">\n";
	print "<input type=\"hidden\" name=\"SID\" value = \"$sid\">\n";
	
	print "<h3>&nbsp; &nbsp; &nbsp; &nbsp;<a href=\"newuser.cgi?SID=$sid&adminlogin=$adminlogin\" target=\"response\">New user</a></h3>\n";

#1. Start of Users table
	print "<img id ='showImg0' src='../_image/plus.gif' onmouseover=\" if (curr==1){ document.showImg0.src='../_image/plus-red.gif' } else {document.showImg0.src='../_image/minus-red.gif'}\" onmouseout=\"  if (curr==1){ document.showImg0.src='../_image/plus.gif' } else {document.showImg0.src='../_image/minus.gif'} \" style='vertical-align:middle;cursor:pointer;padding:0px 15px 0px 5px' onClick ='check_button(0)' >";
	print "<font size='4'><b>Current users:  $countcurrentusers</b></font><br/>";

	print "<div id='currentusers'   style='display:none' align=\"center\"><br/>";
  	print "<center>";
	print "<table border=\"3\" cellpadding=\"3\" cellspacing=\"3\" width=\"770\">\n";
	print "<tr>\n";
    	print "<td width=\"150\"><b>Account name</b></td>\n"; # 150 150 150 150 100 100

		print "<td width=\"150\"><b>Last Name</b></td>\n";
		print "<td width=\"150\"><b>First Name</b></td>\n";

    	print "<td width=\"200\"><b>Email</b></td>\n";

    	print "<td width=\"60\"><b>Modify</b></td>\n";
    	print "<td width=\"60\"><b>Delete</b></td>\n";

    	print "</tr>\n";


	#$countarchivedusers = 0;
	foreach $UserName (sort keys %users) {
		($LastName, $FirstName, $Email,$ActiveUser) = @{$users{$UserName}};

$color='black';

if($ActiveUser ne 'inactive')
		{	#$color='gray';

		print "<tr>";
		print "<td width=\"150\"><font color='$color'>$UserName</font></td>\n";
		print "<td width=\"150\"><font color='$color'>";
		
		if($LastName ne "") {
			print "$LastName</font></td>\n";
		}
		else {
			print "&nbsp;</td>\n";
		}
		
		print "<td width=\"150\"><font color='$color'>";

		if($FirstName ne "") {
			print "$FirstName</font></td>\n";
		}
		else {
			print "&nbsp;</td>\n";
		}

		print "<td width=\"200\">\n";
		print "<a href=\"mailform.cgi?SID=$sid&adminlogin=$adminlogin&to=$Email\"\n>";
		print "$Email</a></td>\n";		
		print "<td width=\"60\">\n";
		print "<a href=\"modifyuser.pl?SID=$sid&adminlogin=$adminlogin&tag=$UserName\"> Modify</a>\n";
#        	print "<form method=\"POST\" action=\"modifyuser.cgi?SID=$sid&adminlogin=$adminlogin&tag=$UserName\">\n";
#          	print "<p><input type=\"submit\" value=\"Modify\" name=\"B3\">\n";
#          	print "</form>\n";
          	print "</td>\n";
		print "<td width=\"60\">\n";
		if($UserName eq $adminlogin)
		{
			print "&nbsp;\n";
		}
		else
		{
			print "<a href=\"deluser.cgi?SID=$sid&adminlogin=$adminlogin&tag=$UserName&email=$Email\" ";
			print "onclick=\"if (! confirm('Are you sure you want to delete $UserName ?')) return false;\">Delete</a>\n";
		}
#          	print "<form method=\"POST\" action=\"deluser.cgi?SID=$sid&adminlogin=$adminlogin&tag=$UserName\">\n";
#          	print "<p><input type=\"submit\" value=\"Delete\" name=\"B1\">\n";
#          	print "</form>\n";
          	print "</td>\n";
		print "</tr>\n";
		
		$user_no++;
		} # end if

	} # end for

		print "</table>\n";

		
  		print "</center\n";
		print "</div>\n";
	#	print "}";
	#	print "</script>";

# end of Users table



#2. start of UsersinQuery table

# Dict for user info.
	my %usersinquery;
			

	$sth = $db->prepare("select UserName, FirstName, LastName, Email, FieldofInterest, SubmittedDate from UsersInQuery");
	$sth->execute();
	$user_no = 0;

	# Populate users dict, prep for sorting.
	my $UserName, $FirstName, $LastName, $Email, $FieldofInterest;
	$countusersinquery=0;

	while(($UserName, $FirstName, $LastName, $Email, $FieldofInterest, $SubmittedDate) = $sth->fetchrow_array) {
		$usersinquery{$LastName} = [$LastName, $FirstName, $Email, $FieldofInterest, $SubmittedDate];
		$countusersinquery++;
	}
	print "<br/><img id ='showImg1' src='../_image/plus.gif' onmouseover=\" if (queryuser==1){ document.showImg1.src='../_image/plus-red.gif' } else {document.showImg1.src='../_image/minus-red.gif'}\" onmouseout=\"  if (queryuser==1){ document.showImg1.src='../_image/plus.gif' } else {document.showImg1.src='../_image/minus.gif'} \" style='vertical-align:middle;cursor:pointer;padding:0px 15px 0px 5px' onClick ='check_button(1)' >";
	print "<font size='4'><b>Users in Query: $countusersinquery</b></font>\n";
	print "<div id='usersquery' style='display:none' align=\"center\"><br/>";
  	print "<center>\n";
	print "<table border=\"3\" cellpadding=\"3\" cellspacing=\"3\" width=\"1050\">\n";
	print "<tr>\n";

		print " <td width=\"20\"><b>Select</b></td>\n";
		print "<td width=\"140\"><b>Account name</b></td>\n";
		print "<td width=\"150\"><b>Last Name</b></td>\n";
		print "<td width=\"150\"><b>First Name</b></td>\n";
    	print "<td width=\"190\"><b>Email</b></td>\n";
		print "<td width=\"340\"><b>Field of Interest</b></td>\n";
		print "<td width=\"140\"><b>Request Date</b></td>\n";
    	print "<td width=\"60\"><b>Modify</b></td>\n";
    	print "<td width=\"60\"><b>Delete</b></td>\n";

    	print "</tr>\n";


	$user_no=0;
	#foreach $UserName (sort keys %usersinquery) {
	#	($LastName, $FirstName, $Email, $FieldofInterest) = @{$usersinquery{$UserName}};
	$sth = $db->prepare("select UserName, FirstName, LastName, Email, FieldofInterest, SubmittedDate from UsersInQuery");
	$sth->execute();
	$user_no = 0;

	# Populate users dict, prep for sorting.
	#$countusersinquery=0;

	while(($UserName, $FirstName, $LastName, $Email, $FieldofInterest, $SubmittedDate) = $sth->fetchrow_array) {
	
	
	if ($UserName eq "") {
		$UserName="&nbsp;";
	}
		print "<tr>";
		print " <td width=\"20\">\n";
#		print "<input type=\"checkbox\" name=\"userselected$user_no\" value=\"ravi$user_no\" unchecked></td>";	#onclick=\"change$instr_count()\	
		print "<input type=\"checkbox\" name=\"userselected\" id=\"userselected\" value=\"$UserName\" unchecked></td>";
		print "<td width=\"150\">$UserName</td>\n";

		print "<td width=\"150\">\n";
		if($LastName ne "") {
			print "$LastName</td>\n";
		}
		else {
			print "&nbsp;</td>\n";
		}

		print "<td width=\"150\">";

		if($FirstName ne "") {
			print "$FirstName</td>\n";
		}
		else {
			print "&nbsp;</td>\n";
		}

		print "<td width=\"200\">\n";
		print "<a href=\"mailform.cgi?SID=$sid&adminlogin=$adminlogin&to=$Email\"\n>";
		print "$Email</a></td>\n";		
		
		print "<td width=\"340\">";
		if($FieldofInterest ne "") {
			print "$FieldofInterest</td>\n";
		}
		else {
			print "&nbsp;</td>\n";
		}

		print "<td width=\"140\">";
		if($SubmittedDate ne "") {
			print "$SubmittedDate</td>\n";
		}
		else {
			print "&nbsp;</td>\n";
		}



		print "<td width=\"60\">\n";
		print "<a href=\"ModifyUsersInQuery.pl?SID=$sid&adminlogin=$adminlogin&tag=$UserName\"> Modify</a>\n";
#        	print "<form method=\"POST\" action=\"modifyuser.cgi?SID=$sid&adminlogin=$adminlogin&tag=$UserName\">\n";
#          	print "<p><input type=\"submit\" value=\"Modify\" name=\"B3\">\n";
#          	print "</form>\n";
          	print "</td>\n";
		print "<td width=\"60\">\n";
		if($UserName eq $adminlogin)
		{
			print "&nbsp;\n";
		}
		else
		{
			#function confirmDelete start
		print "<script language='javascript'>\n";
		print "function confirmDelete(){\n";
		print "confirm('Are you sure you want to delete')";
		print "}";
		print "</script>\n";
		# function end

			print "<a href=\"DeleteUsersInQuery.pl?SID=$sid&adminlogin=$adminlogin&tag=$UserName&email=$Email\" ";
			print "onclick=\"if (! confirm('Are you sure you want to delete $UserName ?')) return false;\">Delete</a>\n"; #onclick=\" return confirmDelete('$UserName')
		}
#          	print "<form method=\"POST\" action=\"deluser.cgi?SID=$sid&adminlogin=$adminlogin&tag=$UserName\">\n";
#          	print "<p><input type=\"submit\" value=\"Delete\" name=\"B1\">\n";
#          	print "</form>\n";
          	print "</td>\n";
		print "</tr>\n";
		$user_no++;
	}
		print "</table>\n";

#function CheckBeforeSubmit start
	print "<script language='javascript'>\n";
	print "function AddtoUsersClicked(){\n";
	#print "	var pattern1 = /[\\w|\\w\-\\w]/;\n";
	#print " var pattern2 = /(^ *\\w+\@\\w+\\.\\w+ *?)/;";
	#print " var pattern3 = /\\W/;\n";
	print "alert('hi')";
	print "}";
	print "</script>\n";
	# function end



	print "<br/><input type=\"submit\" value=\"Add to Users\" align=center >\n";
#onClick='location.href='TransferUsersInQuerytoUsers.pl?SID=$sid&adminlogin=$adminlogin\''
	# print "<input type=\"submit\" value=\"Submit\" align=center>\n";			
	#	print "<a href='TransferUsersInQuerytoUsers.pl?SID=$sid&adminlogin=$adminlogin'>Add to Users</a>";

		 print "<input type=\"hidden\" name=\"test1\" value = \"$adminlogin\">\n";
		# print "<a href=\"TransferUsersInQuerytoUser.pl?SID=$sid&adminlogin=$adminlogin\" onclick=\"if (! confirm('Are you sure you want to delete $UserName ?')) return false;\" >Add to </a> ";# &tag=$UserName&email=$Email

		#onclick=\"change$instr_count()\" onclick=\" return confirmDelete('$UserName')\"  onclick=\"AddtoUsersClicked()\" "if (! confirm('Continue?')) return false;"
		print "</center\n";
		print "</div>\n";
		print "</form>";

# end of  UsersinQuery table


# 3. Archived Users start

	my %archivedusers;
	$sth = $db->prepare("select UserName, FirstName, LastName, Email, ActiveUser from user");
	$sth->execute();
	$countarchivedusers = 0;

	# Populate users dict, prep for sorting.
	my $UserName, $FirstName, $LastName, $Email,$ActiveUser;
	$countusers=0;

	while(($UserName, $FirstName, $LastName, $Email, $ActiveUser) = $sth->fetchrow_array) {
		$archivedusers{$UserName} = [$LastName, $FirstName, $Email, $ActiveUser];

		if($ActiveUser eq 'inactive')
		{
		$countarchivedusers++;
		}
}

# Start of Archived Users table
	print "<img id ='showImg2' src='../_image/plus.gif' onmouseover=\" if (archiveduser==1){ document.showImg2.src='../_image/plus-red.gif' } else {document.showImg2.src='../_image/minus-red.gif'}\" onmouseout=\"  if (archiveduser==1){ document.showImg2.src='../_image/plus.gif' } else {document.showImg2.src='../_image/minus.gif'} \" \" style='vertical-align:middle;cursor:pointer;padding:0px 15px 0px 5px' onClick ='check_button(2)' >";
	print "<font size='4'><b>Archived users: $countarchivedusers</b></font>";
	print "<div  id='archivedusersid'   style='display:none' align=\"center\"><br/>";
  	print "<center>\n";
	print "<table border=\"3\" cellpadding=\"3\" cellspacing=\"3\" width=\"770\">\n";
	print "<tr>\n";
    	print "<td width=\"150\"><b>Account name</b></td>\n"; # 150 150 150 150 100 100

	print "<td width=\"150\"><b>Last Name</b></td>\n";
	print "<td width=\"150\"><b>First Name</b></td>\n";

    	print "<td width=\"200\"><b>Email</b></td>\n";

    	print "<td width=\"60\"><b>Modify</b></td>\n";

    	print "<td width=\"60\"><b>Delete</b></td>\n";

    	print "</tr>\n";



	foreach $UserName (sort keys %archivedusers) {
	($LastName, $FirstName, $Email,$ActiveUser) = @{$archivedusers{$UserName}};

		$color='black';

	if($ActiveUser eq 'inactive')
	{#	$color='gray';

		print "<tr>";
		print "<td width=\"150\"><font color='$color'>$UserName</font></td>\n";
		print "<td width=\"150\"><font color='$color'>";
		
		if($LastName ne "") {
			print "$LastName</font></td>\n";
		}
		else {
			print "&nbsp;</td>\n";
		}
		
		print "<td width=\"150\"><font color='$color'>";

		if($FirstName ne "") {
			print "$FirstName</font></td>\n";
		}
		else {
			print "&nbsp;</td>\n";
		}

		print "<td width=\"200\">\n";
		print "<a href=\"mailform.cgi?SID=$sid&adminlogin=$adminlogin&to=$Email\"\n>";
		print "$Email</a></td>\n";		
		print "<td width=\"60\">\n";
		print "<a href=\"ModifyUsersInArchived.pl?SID=$sid&adminlogin=$adminlogin&tag=$UserName\"> Modify</a>\n";
#        	print "<form method=\"POST\" action=\"modifyuser.cgi?SID=$sid&adminlogin=$adminlogin&tag=$UserName\">\n";
#          	print "<p><input type=\"submit\" value=\"Modify\" name=\"B3\">\n";
#          	print "</form>\n";
          	print "</td>\n";
		print "<td width=\"60\">\n";
		if($UserName eq $adminlogin)
		{
			print "&nbsp;\n";
		}
		else
		{
			print "<a href=\"deluser.cgi?SID=$sid&adminlogin=$adminlogin&tag=$UserName&email=$Email\" ";
			print "onclick=\"if (! confirm('Are you sure you want to delete $UserName ?')) return false;\">Delete</a>\n";
		}
#          	print "<form method=\"POST\" action=\"deluser.cgi?SID=$sid&adminlogin=$adminlogin&tag=$UserName\">\n";
#          	print "<p><input type=\"submit\" value=\"Delete\" name=\"B1\">\n";
#          	print "</form>\n";
          	print "</td>\n";
		print "</tr>\n";
		$user_no++;
	} 
	} #end for
		print "</table>\n";

		
  		print "</center\n";
		print "</div>\n";

# Archived users table end

		print "</body>\n";
		print "</html>\n";
	
	$db->disconnect;	

}

else
{
	$db->disconnect;
	print "Content-type: text/html\r\n\r\n";
	print "<body onload=\"Javascript:parent.location.replace('../index.html')\">"; 		
	print "</body>";
	exit;
}

$sth->finish;

	
	
	
