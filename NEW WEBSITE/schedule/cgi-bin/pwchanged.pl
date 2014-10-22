#!/usr/bin/perl
use lib "/kunden/homepages/40/d209127057/htdocs/schedule/cgi-bin/";
use CGI qw/:standard/;
use CGI::kSession;
use DBI;

$dsn = "DBI:mysql:database=db210021972:host=db948.perfora.net";
$db= DBI->connect($dsn, "dbo210021972", "XhYpxT5v");

my $s = new CGI::kSession(path=>"../../var/session/",id=>param("SID"));
$sid=$s->id();
$s->start();
$superlogin=param("superlogin");
$spassword=$s->get("$superlogin");
$sth = $db->prepare("select Passwd from user where UserName = '$superlogin'");
$sth->execute();
$passworddb = $sth->fetchrow_array();

if($spassword eq $passworddb)
{
	$login=param("login");
	$sth = $db->prepare("select Passwd from user where UserName = '$superlogin'");
	$sth->execute();
	$userpassworddb = $sth->fetchrow_array();
	$oldpw=param("oldpw");
	$newpw=param("newpw");
	print "Content-type: text/html\r\n\r\n";
	
	print "<body background=\"../_image/valtxtr.gif\">";

	if($userpassworddb eq $oldpw)
	{
		$db->do("update user set Passwd='$newpw' where UserName='$superlogin'");
		$s->set("$superlogin", "$newpw");
		print "<h2><center>Your password has been changed!</h2>";
	}else
	{
		print "<h2><center>Invalid current password!! '$userpassworddb'</h2>";
	}
	
	print "</body>";
}
else
{		
		$url = "../index_alt.html";
		print "Location: $url\n\n";
		exit;
}

$sth->finish();
