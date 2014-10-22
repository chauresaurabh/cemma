#!/usr/usc/bin/perl -w
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
	$dsn = "DBI:mysql:cemma;mysql_read_default_group=client;mysql_read_default_file=/var/local/www/unsupported-00/curulli/.my.cnf";
	$db= DBI->connect($dsn, "root", "");
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
    		my $s = new CGI::kSession(lifetime=>900,path=>"/var/local/www/unsupported-00/curulli/session/",id=>param("SID"));  #create a session for administrator and set expire time to 15mins
    		$s->start();
    		$sid=$s->id();
    		$s->register("$login");
    		$s->set("$login","$password");

		print "Content-type: text/html\r\n\r\n";
		print "<body onload=\"document.administrator.submit()\">";
		print "<form method=\"post\" action=\"administrator.cgi\" name=\"administrator\">";
		print "<input type=\"hidden\" name=\"SID\" value=\"$sid\">";   #Two parameters(session ID and login name) are required to be passed.
		print "<input type=\"hidden\" name=\"adminlogin\" value=\"$login\">";
		print "</form>";
		print "</body>";
	}
	elsif($passworddb eq $password)
	{
		my $cgi = new CGI;
    		my $s = new CGI::kSession(lifetime=>900,path=>"/var/local/www/unsupported-00/curulli/session/",id=>$cgi->param("SID"));  #create a session for client end users and set expire time to 5mins
    		$s->start();
    		$sid=$s->id();
    		$s->register("$login");
    		$s->set("$login", "$password");		

		print "Content-type: text/html\r\n\r\n";
		print "<body onload=\"document.user.submit()\">";  #Redirect to normal user's interface, in which the person only has the access to his/her own data.
		print "<form method=\"post\" action=\"userframe.cgi\" name=\"user\">";
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