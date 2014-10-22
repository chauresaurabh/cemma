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
$login=param("login");
$spassword=$s->get("$login");
$sth = $db->prepare("select Passwd from user where UserName = '$login'");
$sth->execute();
$passworddb = $sth->fetchrow_array();
$sth->finish();

if($spassword eq $passworddb)
{
	$instr_name = param("InstrName");
	$date=param("Date");
	$slot=param("Slot");

	$db->do("delete from schedule where InstrumentName='$instr_name' and Date='$date' and Slot='$slot' and UsedBy='$login'");

	print "Content-type: text/html\r\n\r\n";
	print "<body onload=\"Javascript:location.replace('cancelsign.pl?SID=$sid&login=$login')\">"; 		
	print "</body>";
	
	#print "<html>";
	
   	#print "<body background=\"../_image/valtxtr.gif\">";

	#print "<h3><center>The appointment you specified has been canceled successfully!</h3>";
	
	#print "<p><a href=\"cancelsign.pl?SID=$sid&login=$login\">Back</a></p>";
	
	#print "</body>";
	#print "</html>";
	
	$db->disconnect;
}

else
{
	print "Content-type: text/html\r\n\r\n";
	print "<body onload=\"Javascript:parent.location.replace('../index_alt.html')\">"; 		
	print "</body>";
	exit;
}
