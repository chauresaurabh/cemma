#!/usr/usc/bin/perl -w
use CGI qw/:standard/;
use CGI::kSession;
use DBI;
$dsn = "DBI:mysql:cemma;mysql_read_default_group=client;mysql_read_default_file=/var/local/www/unsupported-00/curulli/.my.cnf";
$db= DBI->connect($dsn, "root", "");

my $s = new CGI::kSession(path=>"/var/local/www/unsupported-00/curulli/session/",id=>param("SID"));
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
	$sth = $db->prepare("select Passwd from user where UserName = '$login'");
	$sth->execute();
	$userpassworddb = $sth->fetchrow_array();
	$oldpw=param("oldpw");
	$newpw=param("newpw");
	print "Content-type: text/html\r\n\r\n";
	
	print "<body background=\"../_image/valtxtr.gif\">";

	if($userpassworddb eq $oldpw)
	{
		$db->do("update user set Passwd='$newpw' where UserName='$login'");
		$s->set("$login", "$newpw");
		print "<h2><center>Your password has been changed!</h2>";
	}else
	{
		print "<h2><center>Invalid current password!!</h2>";
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
