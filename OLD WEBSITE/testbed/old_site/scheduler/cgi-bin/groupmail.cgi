#!/usr/usc/bin/perl -w
use CGI qw/:standard/;
use CGI::kSession;
use DBI;
###################################################################################

#This script generate a form for creating a new employee.

###################################################################################
$dsn = "DBI:mysql:cemma;mysql_read_default_group=client;mysql_read_default_file=/var/local/www/unsupported-00/curulli/.my.cnf";
$db= DBI->connect($dsn, "root", "");

my $s = new CGI::kSession(lifetime=>900, path=>"/var/local/www/unsupported-00/curulli/session/",id=>param("SID"));
$sid=$s->id();
$s->start();
$adminlogin=param("adminlogin");
$spassword=$s->get("$adminlogin");
$sth = $db->prepare("select Passwd, Class from user where UserName = '$adminlogin'");
$sth->execute();
($passworddb, $ClassAdmin) = $sth->fetchrow_array();
$sth->finish();
$db->disconnect;

if($spassword eq $passworddb)
{
	print "Content-type: text/html\r\n\r\n";
	if ($ClassAdmin eq 2)
	{
		print "<h3><center>You have no right for this operation!</h3>";
		exit;
	}

	$instrNo = param("tag");
	$sth = $db->prepare("select Email from instr_group where InstrNo = '$instrNo'");
	$sth->execute();
	$to=$sth->fetchrow_array();
	while ($email=$sth->fetchrow_array)
	{
		$to = $to . "," . $email;
	}
	
	print "<html>";
	print "<title>";
	print "Send Mail";
	print "</title>";
   	print "<body background=\"../_image/valtxtr.gif\">";
	print "  <form method=post action=\"sendmail.cgi\" name=\"mailform\">";
	print "    <table align=center>";
	print "<tr>";
	print "        <td width =\"63\">To: </td>";
	print "        <td width=\"163\"> ";
	print "          <input type=\"text\" name = \"to\" value='$to' size=\"64\">";
	print "</td>";
	print "</tr>";
	print "<tr>";
	print "        <td width =\"63\">subject: </td>";
	print "        <td width=\"163\"> ";
	print "          <input type=\"text\" name = \"subject\" size=\"64\">";
	print "</td>";
	print "</tr>";

	print "<tr>";
	print "        <td width = \"63\" valign=\"top\">body: </td>";
	print "        <td width=\"166\"> ";
	print "		<textarea rows=\"10\" name=\"body\" cols=\"64\"></textarea>";
	print "	</td>";
	print "</tr>";
	
	print "</table>";
	print "<p align=\"center\">";
	print "<input type=\"submit\" value=\"Submit\">";
	print "<input type=\"reset\"  value=\" Reset \">";
	print "<input type=\"hidden\" name=\"adminlogin\" value = \"$adminlogin\">";
	print "<input type=\"hidden\" name=\"SID\" value = \"$sid\">";
	print "</form>";
	print "</body>";
	print "</html>";
	
}
else
{
	print "Content-type: text/html\r\n\r\n";
	print "<body onload=\"Javascript:parent.location.replace('../index_alt.html')\">"; 		
	print "</body>";
	exit;
}
