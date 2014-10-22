#!/usr/bin/perl
use lib "/kunden/homepages/40/d209127057/htdocs/schedule/cgi-bin/";
use CGI qw/:standard/;
use CGI::kSession;
use DBI;

#---------------------------------------------------------------------
# This script implements upper frame of the administrator's interface.
#---------------------------------------------------------------------

$dsn = "DBI:mysql:database=db210021972:host=db948.perfora.net";
$db= DBI->connect($dsn, "dbo210021972", "XhYpxT5v");

my $s = new CGI::kSession(lifetime=>900, path=>"../../../../var/session/",id=>param("SID"));
$sid=$s->id();
$s->start();
$adminlogin=param("adminlogin");
$spassword=$s->get("$adminlogin");
$sth = $db->prepare("select Passwd, Class from user where UserName = '$adminlogin'");
$sth->execute();
($passworddb, $ClassAdmin) = $sth->fetchrow_array();

if($spassword eq $passworddb)
{
	
	print "Content-type: text/html\r\n\r\n";
	
	print "<html>";
		
	if ($ClassAdmin eq 2)
	{
		print "<h3><center>You have no right for this operation!</h3>";
		print "</body>";
		exit;
	}

	print "<script language=\"javascript\">"; 
	print "function openWindow(url){ ";
	print " newpage = window.open(url,'newpage','toolbar=no, menubar=no,location=no,WIDTH=500,HEIGHT=250, left=50, top=50'); ";
 	print "newpage.focus(); ";
	print "} ";
	print "</script> ";
	print "<body bgcolor=\"000066\">";

	print "<table cellspacing=\"3\" cellpadding=\"0\" width=\"100%\">";
	print "<tr>";
	print "<td align=\"left\">";
	print "<font face=\"Arial\" color=\"#FFFFFF\" size=\"-1\"><b><i>Administrator</i></b></font>";
	print "</td>";

  	print "<td width=\"90\"><a href=\"perl/page.pl\" target=\"response\">";
  	print "<font face=\"Arial\" color=\"#FFFFFF\" size=\"-1\"><b>INVOICE</b></font></a>";
	#print "<img border=\"0\" src=\"../_image/user.gif\" width=\"90\" height=\"36\" alt=\"User Management\"></a></td>";
  	
	print "<td width=\"120\"><a href=\"../machines.html\" target=\"response\">";
  	#print "<img border=\"0\" src=\"../_image/instr.gif\" width=\"90\" height=\"36\"></a></td>";
	print "<font face=\"Arial\" color=\"#FFFFFF\" size=\"-1\"><b>INSTRUMENT</b></font></a>";
  	
	print "<td width=\"90\"><a href=\"../invoice_status.html\" target=\"response\">";
	#print "<td width=\"90\"><a href=\"../invoice_status.html\" target=\"response\">";
  	print "<font face=\"Arial\" color=\"#FFFFFF\" size=\"-1\"><b>STATUS</b></font></a>";

  	

	print "<td align=\"right\" valign=\"top\" width=\"210\">&nbsp;</td>";
	
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
$sth->finish();
