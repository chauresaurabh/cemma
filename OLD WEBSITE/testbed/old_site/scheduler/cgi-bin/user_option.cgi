#!/usr/usc/bin/perl -w
use CGI qw/:standard/;
use CGI::kSession;
use DBI;

#---------------------------------------------------------------------
# This script implements upper frame of the standard user interface.
#---------------------------------------------------------------------

$dsn = "DBI:mysql:cemma;mysql_read_default_group=client;mysql_read_default_file=/var/local/www/unsupported-00/curulli/.my.cnf";
$db= DBI->connect($dsn, "root", "");

my $s = new CGI::kSession(lifetime=>900, path=>"/var/local/www/unsupported-00/curulli/session/",id=>param("SID"));
$sid=$s->id();
$s->start();
$login=param("login");
$spassword=$s->get("$login");
$sth = $db->prepare("select Name, Passwd from user where UserName = '$login'");
$sth->execute();
($name, $passworddb) = $sth->fetchrow_array();
$sth->finish();
$db->disconnect();

if($spassword eq $passworddb)
{
	print "Content-type: text/html\r\n\r\n";

	print "<html>";

	print "<script language=\"javascript\">"; 
	print "function openWindow(url){ ";
	print " newpage = window.open(url,'newpage','toolbar=no, menubar=no,location=no,WIDTH=500,HEIGHT=250, left=50, top=50'); ";
 	print "newpage.focus(); ";
	print "} ";
	print "</script> ";
	print "<body bgcolor=\"#990000\">";

	print "<table cellspacing=\"3\" cellpadding=\"0\" width=\"100%\">";
	print "<tr>";
	print "<td align=\"left\">";
	print "<font face=\"Arial\" color=\"#FFFFFF\" size=\"-1\"><b><i>$name</i></b></font>";
	print "</td>";
	
  	print "<td width=\"90\"><a href=\"newsignform.cgi?SID=$sid&login=$login&option=add\" target=\"response\">";
  	print "<img border=\"0\" src=\"../_image/signup.gif\" width=\"90\" height=\"36\" alt=\"Signup\"></a></td>";

  	print "<td width=\"90\"><a href=\"cancelsign.cgi?SID=$sid&login=$login\" target=\"response\">";
  	print "<img border=\"0\" src=\"../_image/cancel.gif\" width=\"90\" height=\"36\" alt=\"View/Cancel own signup\"></a></td>";

  	print "<td width=\"90\"><a href=\"newsignform.cgi?SID=$sid&login=$login&option=view\" target=\"response\">";
  	print "<img border=\"0\" src=\"../_image/schedule.gif\" width=\"90\" height=\"36\" alt=\"View Schedule\"></a></td>";
	
	print "<td align=\"right\" valign=\"top\">";
	print "<a href=\"javascript:openWindow('changepassword.cgi?SID=$sid&login=$adminlogin');\">"; 
	print "<img border=\"0\" src=\"../_image/passwd1.gif\" width=\"48\"></a>";
	#print "<td width=\"10\">&nbsp;</td>";
	print "<td align=\"right\" valign\=\"top\">";	
	print "<a href=\"Javascript:location.replace('logout.cgi?SID=$sid')\" target=_parent>"; 
	print "<img border=\"0\" src=\"../_image/logout.gif\" width=\"48\"></a></td>";
	
	print "</tr>";
	print "</table>";
	print "</html>";
}
else
{
	print "Content-type: text/html\r\n\r\n";
	print "<body onload=\"Javascript:parent.location.replace('../index_alt.html')\">"; 		
	print "</body>";
	exit;
}
