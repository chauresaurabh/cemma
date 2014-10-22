#!/usr/bin/perl
use lib "/kunden/homepages/40/d209127057/htdocs/schedule/cgi-bin/";
use CGI qw/:standard/;
use CGI::kSession;
use DBI;

$dsn = "DBI:mysql:database=db210021972:host=db948.perfora.net";
$db= DBI->connect($dsn, "dbo210021972", "XhYpxT5v");

my $s = new CGI::kSession(lifetime=>900, path=>"../../var/session/",id=>param("SID"));
$sid=$s->id();
$s->start();
$adminlogin=param("adminlogin");
$spassword=$s->get("$adminlogin");
$sth = $db->prepare("select Passwd, Class from user where UserName = '$adminlogin'");
$sth->execute();
($passworddb, $classAdmin) = $sth->fetchrow_array();
$sth->finish();

if($spassword eq $passworddb)
{
	print "Content-type: text/html\r\n\r\n";
	print "<html>\n";
	print "<head>\n";
	print "<meta http-equiv=\"refresh\"; CONTENT=\"1; url=manuser.pl?SID=$sid&adminlogin=$adminlogin\">\n";
	print "</head>\n";
	
	print "<body background=\"../_image/valtxtr.gif\">\n";
	
	if ($classAdmin eq 2)
	{
		print "<h3><center>You have no right for this operation!</h3>\n";
		exit;
	}
		
	$username = param("tag");
	$email = param("email");
	
	$db->do("delete from UsersInQuery where UserName='$username'");
	$db->do("delete from UsersInQuery_instr_group where Email = '$email'");
	
	print "<h3><center>The User in Query \"$username\" has been deleted successfully!</h3>\n";
	print "</body>\n";
	print "</html>\n";

	$db->disconnect;
}

else
{
	print "Content-type: text/html\r\n\r\n";
	print "<body onload=\"Javascript:parent.location.replace('../index.html')\">"; 		
	print "</body>";
	exit;
}

# Updated time to be modified!!
