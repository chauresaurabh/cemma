#!/usr/bin/perl
use lib "/kunden/homepages/40/d209127057/htdocs/schedule/cgi-bin/";
use CGI qw/:standard/;
use CGI::kSession;
use DBI;

$dsn = "DBI:mysql:database=db210021972:host=db948.perfora.net";
$db= DBI->connect($dsn, "dbo210021972", "XhYpxT5v");

################################################################################
# Frame page of user's interface. Please reference the upper frame to option.pl
# and lower frame to response.pl
################################################################################

my $s = new CGI::kSession(lifetime=>900, path=>"../../var/session/",id=>param("SID"));  #session control
$sid=$s->id();
$s->start();
$login=param("login");
$password=$s->get("$login");
$sth = $db->prepare("select Passwd from user where UserName = '$login'");
$sth->execute();
$passworddb = $sth->fetchrow_array();
$sth->finish();
$db->disconnect();				#end of session control

if($password eq $passworddb)
{
	print "Content-type: text/html\r\n\r\n";
	print "<html>";
 #  	print "<body background=\"../_image/valtxtr.gif\">";	
	print "<title>Welcome</title>";
	print "<head> ";
	print "<meta http-equiv=\"expires\" content=\"-1\"> ";
	print "<meta http-equiv=\"cache-control\" content=\"no-cache\"> ";
	print "<meta http-equiv=\"Pragma\" content=\"no-cache\">"; 
	print "</head> ";
	print "<frameset border=\"0\" rows=\"60,*\">\n";
	print "<frame name=\"option\" SRC=\"user_option.pl?SID=$sid&login=$login\" scrolling=\"no\" noresize frameborder=0>\n";
	print "<frame name=\"response\" SRC=\"response.pl\" noresize>\n";
	print "</frameset>\n";
#	print "</body>";
	print "</html>\n";
}
else
{  
		$url = "../loginerr.htm";
		print "Location: $url\n\n";
		exit;
}
