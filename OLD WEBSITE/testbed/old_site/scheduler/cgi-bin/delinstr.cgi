#!/usr/usc/bin/perl -w
use CGI qw/:standard/;
use CGI::kSession;
use DBI;


$dsn = "DBI:mysql:cemma;mysql_read_default_group=client;mysql_read_default_file=/var/local/www/unsupported-00/curulli/.my.cnf";
$db= DBI->connect($dsn, "root", "");

my $s = new CGI::kSession(lifetime=>900, path=>"/var/local/www/unsupported-00/curulli/session/",id=>param("SID"));
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
	print "<html>";

	print "<head>";
	print "<meta http-equiv=\"refresh\"; CONTENT=\"1; url=maninstr.cgi?SID=$sid&adminlogin=$adminlogin\">";
	print "</head>";
	
   	print "<body background=\"../_image/valtxtr.gif\">";
   		
	if ($classAdmin eq 2)
	{
		print "<h3><center>You have no right for this operation!</h3>";
		exit;
	}
		
	$InstrNo=param("tag");

	$db->do("delete from instrument where InstrumentNo='$InstrNo'");
	$db->do("delete from instr_group where InstrNo = '$InstrNo'");
	print "<h3><center>The specified instrument has been deleted successfully!</h3>";
	print "</body>";
	print "</html>";
	
	$db->disconnect;
}

else
{
	print "Content-type: text/html\r\n\r\n";
	print "<body onload=\"Javascript:parent.location.replace('../index_alt.html')\">"; 		
	print "</body>";
	exit;
}
