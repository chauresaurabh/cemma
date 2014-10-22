#!/usr/bin/perl
use lib "/kunden/homepages/40/d209127057/htdocs/schedule/cgi-bin/";
use DBI;
use CGI qw/:standard/;
use CGI::kSession;

###########################################################################

#This script verify the user's identity. There are three categories of user 
#status: administrator, superior(supervisor), and inferior. After confirming 
#the status of each user, the script will redirect to different user 
#interfaces.
 
###########################################################################

$login = param("login");

if($login eq ""){ #To prevernt anyone enters this page by typing URL in the browser, it redirects user to login page
		$url = "../loginerr.htm";
		print "Location: $url\n\n";
		exit;
}
else
{ 
	$password = param("password");
	$dsn = "DBI:mysql:database=db210021972:host=db948.perfora.net";
	$db= DBI->connect($dsn, "dbo210021972", "XhYpxT5v");
	$sth = $db->prepare("select UserName, Passwd, Class from user where UserName = \"$login\"");
	$sth->execute();
	($UserName, $passworddb, $Class) = $sth->fetchrow_array();
	$sth->finish();
	$db->disconnect();
	if($passworddb eq "") # Login error. (No such login name)
	{	
		$url = "../loginerr.htm";
		print redirect( -uri => $url);
		exit;
	}
	elsif ($UserName ne $login)
	{
		$url = "../loginerr.htm";
		print "Location: $url\n\n";
		exit;
	}	  
	elsif($passworddb eq $password & $Class eq 1) # Verify administrator's identity
	{
	  # create session for administrator and set expire time to 15mins
    		my $s = new CGI::kSession(lifetime=>900,path=>"../../var/session/",id=>param("SID"));
    		$s->start();
    		$sid=$s->id();
    		$s->register("$login");
    		$s->set("$login","$password");

		print "Content-type: text/html\r\n\r\n";
		print "<body onload=\"document.administrator.submit()\">";
		print "<form method=\"post\" action=\"administrator.pl\" name=\"administrator\">";
		print "<input type=\"hidden\" name=\"SID\" value=\"$sid\">";   #Two parameters(session ID and login name) are required to be passed.
		print "<input type=\"hidden\" name=\"adminlogin\" value=\"$login\">";
		print "</form>";
		print "</body>";
	}
	elsif($passworddb eq $password)
	{
	  # create a session for client end users and set expire time to 5mins
		my $cgi = new CGI;
    		my $s = new CGI::kSession(lifetime=>900,path=>"../../var/session/",id=>$cgi->param("SID"));
    		$s->start();
    		$sid=$s->id();
    		$s->register("$login");
    		$s->set("$login", "$password");		

		print "Content-type: text/html\r\n\r\n";
		print "<body onload=\"document.user.submit()\">";  #Redirect to normal user's interface, in which the person only has the access to his/her own data.
		print "<form method=\"post\" action=\"userframe1.pl\" name=\"user\">";
		print "<input type=\"hidden\" name=\"SID\" value=\"$sid\">";  #Two parameters(session ID and login name) are required to be passed.
		print "<input type=\"hidden\" name=\"login\" value=\"$login\">"; 
		print "</form>";
		print "</body>";
	}
	else
	{  #Login error. (password mismatch)
		$url = "../loginerr.htm";
		print "Location: $url\n\n";
		exit;	       
	}
}
