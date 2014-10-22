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

$sth = $db->prepare("select Prevent from user where UserName = '$login'");
$sth->execute();
$prevent = $sth->fetchrow_array();
$sth->finish();

if($spassword eq $passworddb)
{
	print "Content-type: text/html\r\n\r\n";
	print "<html>";
   	print "<body background=\"../_image/valtxtr.gif\">";
	
	print "<script>";
	print "function CheckBeforeSubmit(){";
	print "	var pattern1 = /\\W/;";
	print "	var pattern2 = /[^-0-9A-Za-z]/;";
	
	print "	var flag=true;";
	print "	if(pattern2.test(document.pwchange.login.value)||document.pwchange.login.value == \"\")";
	print "	{";
	print "		alert(\"Login is incorrect(must be A-Z,a-z,0-9 and '-')\");";
	print "		flag=false;";
	print "	}";
	print "	if(pattern1.test(document.pwchange.oldpw.value)||document.pwchange.oldpw.value == \"\"||pattern1.test(document.pwchange.newpw.value)||document.pwchange.newpw.value == \"\")";
	print "	{";
	print "		alert(\"Password is incorrect(must be A-Z,a-z,0-9)\");";
	print "		flag=false;";
	print "	}";
	print " if((flag==true )&&((document.pwchange.newpw.value) != (document.pwchange.cnewpw.value)))";
	print "	{";
	print "		alert(\"Can't confirm password!\");";
	print "		flag=false;";
	print "	}";
	print "	return (flag);";
	print "}";
	print "</script>";
	print "<h3><center>To change password, plaease enter your</h3>";
	print "<form method=\"post\" action=\"pwchanged.pl\" name=\"pwchange\" onsubmit=\"return CheckBeforeSubmit()\">";
	print "<table>";
	print "<tr><td align=right>Login:</td><td><input type=\"text\" name=\"login\" disabled='disabled' value='$login'></td></tr>";
	print "<tr><td align=right>Current password:</td><td><input type=\"password\" name=\"oldpw\"></td></tr>";
	if($prevent eq 1){
		print "<tr><td align=right>New password:</td><td><input type=\"password\" name=\"newpw\" readonly></td></tr>";
	} else {
		print "<tr><td align=right>New password:</td><td><input type=\"password\" name=\"newpw\"></td></tr>";
	}
	if($prevent eq 1){
		print "<tr><td align=right>Retype new password:</td><td><input type=\"password\" name=\"cnewpw\" readonly></td></tr>";
	} else {
		print "<tr><td align=right>Retype new password:</td><td><input type=\"password\" name=\"cnewpw\"></td></tr>";
	}
	print "</table>";
	print "<input type=\"submit\" value=\"Change\">";
	print "<input type=\"hidden\" name=\"SID\" value=\"$sid\">";
	print "<input type=\"hidden\" name=\"superlogin\" value=\"$login\">";
	print "</form>";
	
	print "</body>";
	print "</html>";
	
}
else
{
		$url = "../index_alt.html";
		print "Location: $url\n\n";
		exit;
}
$sth->finish();
