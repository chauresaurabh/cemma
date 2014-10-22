#!/usr/usc/bin/perl -w
use CGI qw/:standard/;
use CGI::kSession;
use DBI;
$dsn = "DBI:mysql:cemma;mysql_read_default_group=client;mysql_read_default_file=/var/local/www/unsupported-00/curulli/.my.cnf";
$db= DBI->connect($dsn, "root", "");


################################################################################
# Frame page of user's interface. Please reference the upper frame to option.cgi
# and lower frame to response.cgi
################################################################################

my $s = new CGI::kSession(lifetime=>900, path=>"/var/local/www/unsupported-00/curulli/session/",id=>param("SID"));  #session control
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
	print "<frame name=\"option\" SRC=\"user_option.cgi?SID=$sid&login=$login\" scrolling=\"no\" noresize frameborder=0>\n";
	print "<frame name=\"response\" SRC=\"response.cgi\" noresize>\n";
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
