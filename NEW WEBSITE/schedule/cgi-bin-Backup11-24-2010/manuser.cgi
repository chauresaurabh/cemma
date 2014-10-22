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
$sth = $db->prepare("select Passwd, Class from user where UserName = '$adminlogin'");
$sth->execute();
($passworddb, $ClassAdmin) = $sth->fetchrow_array();
$sth->finish();

if($spassword eq $passworddb)
{
	print "Content-type: text/html\r\n\r\n";
	if ($ClassAdmin eq 2)
	{
		print "<h3><center>You have no right for this operation!</h3>\n";
		exit;
	}

	# Dict for user info.
	my %users;
			

	$sth = $db->prepare("select UserName, FirstName, LastName, Email from user");
	$sth->execute();
	$user_no = 0;

	# Populate users dict, prep for sorting.
	my $UserName, $FirstName, $LastName, $Email;
	$countusers=0;

	while(($UserName, $FirstName, $LastName, $Email) = $sth->fetchrow_array) {
		$users{$UserName} = [$LastName, $FirstName, $Email];
		$countusers++;
	}
	print "<html>\n";
	print "<head>\n";
	print "<script language=\"JavaScript\" src=\"utils.js\"></script>\n";
	print "</head>\n";
   	print "<body background=\"../_image/valtxtr.gif\">\n";	
	print "<title>\n";
	print "User Managerment";
	print "</title>\n";	

	#print "  <form method=post action='TransferUsersInQuerytoUsers.pl?SID=$sid&adminlogin=$adminlogin'  name=\"newuser\">\n";
	print "  <form method=post action=\"TransferUsersInQuerytoUsers.pl\"  name=\"newuser\">\n";
	print "<input type=\"hidden\" name=\"adminlogin\" value = \"$adminlogin\">\n";
	print "<input type=\"hidden\" name=\"SID\" value = \"$sid\">\n";


	print "<h3><a href=\"newuser.cgi?SID=$sid&adminlogin=$adminlogin\" target=\"response\">Add user</a></h3>\n";
	print "<h3> Current users:  ";
	print $countusers."</h3>\n";




# Start of Users table
	print "<div align=\"center\">\n";
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



	foreach $UserName (sort keys %users) {
		($LastName, $FirstName, $Email) = @{$users{$UserName}};

		print "<tr>";
		print "<td width=\"150\">$UserName</td>\n";
		print "<td width=\"150\">";
		
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
		print "<td width=\"60\">\n";
		print "<a href=\"modifyuser.cgi?SID=$sid&adminlogin=$adminlogin&tag=$UserName\"> Modify</a>\n";
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
		print "</table>\n";

		
  		print "</center\n";
		print "</div>\n";
# end of Users table



# start of UsersinQuery table

# Dict for user info.
	my %usersinquery;
			

	$sth = $db->prepare("select UserName, FirstName, LastName, Email from UsersInQuery");
	$sth->execute();
	$user_no = 0;

	# Populate users dict, prep for sorting.
	my $UserName, $FirstName, $LastName, $Email;
	$countusersinquery=0;

	while(($UserName, $FirstName, $LastName, $Email) = $sth->fetchrow_array) {
		$usersinquery{$UserName} = [$LastName, $FirstName, $Email];
		$countusersinquery++;
	}

	print "<h3> Users in Query:";
	print $countusersinquery."</h3>\n";

	print "<div align=\"center\">\n";
  	print "<center>\n";
	print "<table border=\"3\" cellpadding=\"3\" cellspacing=\"3\" width=\"770\">\n";
	print "<tr>\n";

		print " <td width=\"20\"><b>Select</b></td>\n";
		print "<td width=\"140\"><b>Account name</b></td>\n";
		print "<td width=\"150\"><b>Last Name</b></td>\n";
		print "<td width=\"150\"><b>First Name</b></td>\n";
    	print "<td width=\"190\"><b>Email</b></td>\n";

    	print "<td width=\"60\"><b>Modify</b></td>\n";
    	print "<td width=\"60\"><b>Delete</b></td>\n";

    	print "</tr>\n";


	$user_no=0;
	foreach $UserName (sort keys %usersinquery) {
		($LastName, $FirstName, $Email) = @{$usersinquery{$UserName}};

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



		print "</body>\n";
		print "</html>\n";
	
	$db->disconnect;	
}

else
{
	$db->disconnect;
	print "Content-type: text/html\r\n\r\n";
	print "<body onload=\"Javascript:parent.location.replace('../index_alt.html')\">"; 		
	print "</body>";
	exit;
}

$sth->finish;

	
	
	
