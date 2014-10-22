#!/usr/usc/bin/perl -X
use CGI qw/:standard/;
use CGI::kSession;
use DBI;

#---------------------------------------------------------------------------------
# User management script.  Displays page containing a table listing all user 
# accounts.
#---------------------------------------------------------------------------------

$dsn = "DBI:mysql:cemma;mysql_read_default_group=client;mysql_read_default_file=/var/local/www/unsupported-00/curulli/.my.cnf";
$db= DBI->connect($dsn, "root", "");

my $s = new CGI::kSession(lifetime=>900, path=>"/var/local/www/unsupported-00/curulli/session/",id=>param("SID"));
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
			
	print "<html>\n";
	print "<head>\n";
	print "<script language=\"JavaScript\" src=\"utils.js\"></script>\n";
	print "</head>\n";
   	print "<body background=\"../_image/valtxtr.gif\">\n";	
	print "<title>\n";
	print "User Managerment";
	print "</title>\n";	

	print "<h3><a href=\"newuser.cgi?SID=$sid&adminlogin=$adminlogin\" target=\"response\">Add user</a></h3>\n";
	print "<h3> Current users: </h3>\n";
	print "<div align=\"center\">\n";
  	print "<center>\n";
	print "<table border=\"3\" cellpadding=\"3\" cellspacing=\"3\" width=\"540\">\n";
	print "<tr>\n";
    	print "<td width=\"150\"><b>Account name</b></td>\n";

	print "<td width=\"150\"><b>Last Name</b></td>\n";
	print "<td width=\"150\"><b>First Name</b></td>\n";

    	print "<td width=\"150\"><b>Email</b></td>\n";

    	print "<td width=\"100\"><b>Modify</b></td>\n";
    	print "<td width=\"100\"><b>Delete</b></td>\n";

    	print "</tr>\n";

	$sth = $db->prepare("select UserName, FirstName, LastName, Email from user");
	$sth->execute();
	$user_no = 0;

	# Populate users dict, prep for sorting.
	my $UserName, $FirstName, $LastName, $Email;

	while(($UserName, $FirstName, $LastName, $Email) = $sth->fetchrow_array) {
		$users{$LastName} = [$UserName, $FirstName, $Email];
	}

	foreach $LastName (sort keys %users) {
		($UserName, $FirstName, $Email) = @{$users{$LastName}};

		print "<tr>";
		print "<td width=\"150\">$UserName</td>\n";
		print "<td width=\"150\">$LastName</td>\n";
		print "<td width=\"150\">";

		if($FirstName ne "") {
			print "$FirstName</td>\n";
		}
		else {
			print "&nbsp;</td>\n";
		}

		print "<td width=\"150\">\n";
		print "<a href=\"mailform.cgi?SID=$sid&adminlogin=$adminlogin&to=$Email\"\n>";
		print "$Email</a></td>\n";		
		print "<td width=\"100\">\n";
		print "<a href=\"modifyuser.cgi?SID=$sid&adminlogin=$adminlogin&tag=$UserName\"> Modify</a>\n";
#        	print "<form method=\"POST\" action=\"modifyuser.cgi?SID=$sid&adminlogin=$adminlogin&tag=$UserName\">\n";
#          	print "<p><input type=\"submit\" value=\"Modify\" name=\"B3\">\n";
#          	print "</form>\n";
          	print "</td>\n";
		print "<td width=\"100\">\n";
		if($UserName eq $adminlogin)
		{
			print "&nbsp;\n";
		}
		else
		{
			print "<a href=\"deluser.cgi?SID=$sid&adminlogin=$adminlogin&tag=$UserName&email=$Email\" ";
			print "onclick=\"return confirmDelete('$UserName')\">Delete</a>\n";
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

	
	
	
