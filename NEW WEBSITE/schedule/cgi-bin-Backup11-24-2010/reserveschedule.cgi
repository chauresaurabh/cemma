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
$sth = $db->prepare("select Passwd, Class from user where UserName = '$login'");
$sth->execute();
($passworddb, $ClassAdmin) = $sth->fetchrow_array();
$sth->finish();

if($spassword eq $passworddb)
{
	print "Content-type: text/html\r\n\r\n";
	
	print "<body background=\"../_image/valtxtr.gif\">";
	if ($ClassAdmin eq 2)
	{
		print "<h3><center>You have no right for this operation!</h3>";
		exit;
	}
		
	$instr_name = param("InstrName");
	$date=param("Date");
	$slot=param("Slot");
	$usedby=param("Tag");
	
	$db->do("Update schedule set UsedBy = '$login' where InstrumentName='$instr_name' and Date='$date' and Slot='$slot' and UsedBy='$usedby'");
	print "<h3><center>The instrument you specified has been reserved successfully!</h3>";
	
	print "</body>";
	$db->disconnect;
}

else
{
	print "Content-type: text/html\r\n\r\n";
	print "<body onload=\"Javascript:parent.location.replace('../index_alt.html')\">"; 		
	print "</body>";
	exit;
}
