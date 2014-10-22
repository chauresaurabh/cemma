#!/usr/bin/perl
use lib "/kunden/homepages/40/d209127057/htdocs/schedule/cgi-bin/";
use CGI qw/:standard/;
use CGI::kSession;
use DBI;

$dsn = "DBI:mysql:database=db210021972:host=db948.perfora.net";
$db= DBI->connect($dsn, "dbo210021972", "XhYpxT5v");

#############################################################################
#Frame page of administrator's interface. Please reference the upper frame to option.cgi
#and lower frame to response.cgi
#############################################################################

my $s = new CGI::kSession(lifetime=>900, path=>"../../var/session/",id=>param("SID"));  #session control
$sid=$s->id();
$s->start();
$adminlogin=param("adminlogin");
$spassword=$s->get("$adminlogin");
$sth = $db->prepare("select Passwd from user where UserName = '$adminlogin'");
$sth->execute();
$passworddb = $sth->fetchrow_array();
$sth->finish();
$db->disconnect();				#end of session control
if($spassword eq $passworddb)
{
	print "Content-type: text/html\r\n\r\n";
	print "<html>";
#   	print "<body background=\"../_image/valtxtr.gif\">";	
	print "<title>Adminstrator</title>";
	print "<head> ";
	print "<meta http-equiv=\"expires\" content=\"-1\"> ";
	print "<meta http-equiv=\"cache-control\" content=\"no-cache\"> ";
	print "<meta http-equiv=\"Pragma\" content=\"no-cache\">"; 
	print "</head> ";
	print "<frameset  border=\"0\" rows=\"60,*\">\n";
	print "<frame name=\"option\" SRC=\"option.cgi?SID=$sid&adminlogin=$adminlogin\" scrolling=\"no\" noresize frameborder=0>\n";
	print "<frame name=\"response\" SRC=\"response.cgi\" noresize>\n";
	print "</frameset>\n";
#	print "</body>";
	print "</html>\n";
}
else
{  
	print "Content-type: text/html\r\n\r\n";
	print "<body onload=\"Javascript:parent.location.replace('../index.html')\">"; 		
	print "</body>";
		exit;
}
