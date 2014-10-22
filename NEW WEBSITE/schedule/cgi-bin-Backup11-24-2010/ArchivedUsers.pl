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
			

	$sth = $db->prepare("select UserName, FirstName, LastName, Email, ActiveUser from user");
	$sth->execute();
	$user_no = 0;

	# Populate users dict, prep for sorting.
	my $UserName, $FirstName, $LastName, $Email,$ActiveUser;
	$countusers=0;

	while(($UserName, $FirstName, $LastName, $Email, $ActiveUser) = $sth->fetchrow_array) {
		$users{$UserName} = [$LastName, $FirstName, $Email, $ActiveUser];

		if($ActiveUser eq 'inactive')
		{
		$countusers++;
		}
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
	print "  <form method=post   name=\"newuser\">\n"; #action=\"TransferUsersInQuerytoUsers.pl\"
	print "<input type=\"hidden\" name=\"adminlogin\" value = \"$adminlogin\">\n";
	print "<input type=\"hidden\" name=\"SID\" value = \"$sid\">\n";


	#print "<h3><a href=\"newuser.cgi?SID=$sid&adminlogin=$adminlogin\" target=\"response\">Add user</a></h3>\n";
	print "<h3> Archived users:  ";
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
		($LastName, $FirstName, $Email,$ActiveUser) = @{$users{$UserName}};

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
	}
		print "</table>\n";

		
  		print "</center\n";
		print "</div>\n";
# end of Users table







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

	
	
	
