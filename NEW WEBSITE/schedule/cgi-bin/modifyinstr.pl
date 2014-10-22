#!/usr/bin/perl
use lib "/kunden/homepages/40/d209127057/htdocs/schedule/cgi-bin/";
use CGI qw/:standard/;
use CGI::kSession;
use DBI;
###################################################################################

#This script generate a form for creating a new employee.

###################################################################################

$dsn = "DBI:mysql:database=db210021972:host=db948.perfora.net";
$db= DBI->connect($dsn, "dbo210021972", "XhYpxT5v");

my $s = new CGI::kSession(lifetime=>900, path=>"../../var/session/",id=>param("SID"));
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

	$InstrNo=param("tag");
#a undo	$sth = $db->prepare("select InstrumentName, Comment, Availablity from instrument where InstrumentNo=$InstrNo");
# a undo	$sth->execute();

#a
	$dsn = "DBI:mysql:database=db260244667:host=db1661.perfora.net";
	$db= DBI->connect($dsn, "dbo260244667", "curu11i");
	$sth = $db->prepare("select InstrumentName, Comment, Availablity from instrument where InstrumentNo=$InstrNo");
	$sth->execute();
	#a
	($InstrName, $Comment, $instrCan) = $sth->fetchrow_array;
	$db->disconnect;	
	$sth->finish();

	print "<html>";
	print "<title>";
	print "Modify an instrument profile";
	print "</title>";
   	print "<p align=\"right\"><a href=\"Javascript:self.print()\"><b>PRINT</b></a></p>";	
	print "<h2><center>Modify instrument</center></h2><center>";
   	print "<body background=\"../_image/valtxtr.gif\">";
	print "  <form method=post action=\"modifyinstrdata.pl\" name=\"newinstrument\">";
	print "    <table align=center>";
	print "<tr>";
	print "        <td width =\"163\">*Instrument Name: </td>";
	print "        <td width=\"300\"> ";
	print "          <input type=\"text\" name = \"InstrName\" value='$InstrName' size=\"64\">";
	print "</td>";
	print "</tr>";

	print "<tr>";
	print "        <td width =\"163\">*Available: </td>";
	print "        <td width=\"300\"> ";
	if ($instrCan eq '1')
	{
		print "          <input type=\"radio\" value=\"yes\" checked name=\"can\">Yes&nbsp; <input type=\"radio\" name=\"can\" value=\"no\">No";
	}
	else
	{
		print "          <input type=\"radio\" value=\"yes\" name=\"can\">Yes&nbsp; <input type=\"radio\" checked name=\"can\" value=\"no\">No";
	}
	print "</td>";
	print "</tr>";
	
	print "<tr>";
	print "        <td width = \"163\">Comment: </td>";
	print "        <td width=\"166\"> ";
	print "		<textarea rows=\"10\" name=\"Comment\" cols=\"64\">$Comment</textarea>";
	print "	</td>";
	print "</tr>";
	
	print "</table>";
	print "<input type=\"submit\" value=\"Submit\" align=center>";
	print "<input type=\"reset\"  value=\" Reset \">";
	print "<input type=\"hidden\" name=\"adminlogin\" value = \"$adminlogin\">";
	print "<input type=\"hidden\" name=\"SID\" value = \"$sid\">";
	print "<input type=\"hidden\" name=\"tag\" value = \"$InstrNo\">";	
	print "</form>";
	print "</body>";
	print "</center>";
	print "Notice: The filed with * can not be empty!</html>";
	
}
else
{
	print "Content-type: text/html\r\n\r\n";
	print "<body onload=\"Javascript:parent.location.replace('../index_alt.html')\">"; 		
	print "</body>";
	exit;
}
