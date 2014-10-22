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

my $s = new CGI::kSession(lifetime=>900, path=>"../../var/session/",id=>param("SID"));
$sid=$s->id();
$s->start();
$adminlogin=param("adminlogin");
$spassword=$s->get("$adminlogin");
$sth = $db->prepare("select Passwd, Class, UserClass from user where UserName = '$adminlogin'");
$sth->execute();
($passworddb, $ClassAdmin, $UserClass) = $sth->fetchrow_array();

if($spassword eq $passworddb)
{
	
	print "Content-type: text/html\r\n\r\n";
	
	print "<html>";
		
	if ($UserClass eq 4)
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
	
	print "function openNewSite(){ ";
	print " newpage = window.open(\"http://cemma-usc.net/cemma/testbed/login.php\",'newpage','toolbar=yes, menubar=yes, scrollbars=yes'); ";
 	print "newpage.focus(); ";
	print "} ";
	
	print "</script> ";
	print "<body bgcolor=\"#990000\">";

	print "<table cellspacing=\"3\" cellpadding=\"0\" width=\"100%\">";
	print "<tr>";
	if($UserClass  eq 1){
		print "<td align=\"left\">";
		print "<font face=\"Arial\" color=\"#FFFFFF\" size=\"-1\"><b><i>Administrator: $adminlogin</i></b></font>";
		print "</td>";
	} elsif($UserClass eq 2){
		print "<td align=\"left\">";
		print "<font face=\"Arial\" color=\"#FFFFFF\" size=\"-1\"><b><i>Cemma Staff: $adminlogin</i></b></font>";
		print "</td>";
	} elsif($UserClass eq 5){
		print "<td align=\"left\">";
		print "<font face=\"Arial\" color=\"#FFFFFF\" size=\"-1\"><b><i>Lab/Class: $adminlogin</i></b></font>";
		print "</td>";
	} else {
		print "<td align=\"left\">";
		print "<font face=\"Arial\" color=\"#FFFFFF\" size=\"-1\"><b><i>Super User: $adminlogin</i></b></font>";
		print "</td>";
	}

  	print "<td width=\"90\"><a href=\"manuser.pl?SID=$sid&adminlogin=$adminlogin\" target=\"response\">";
  	print "<img border=\"0\" src=\"../_image/user.gif\" width=\"90\" height=\"36\" alt=\"User Management\"></a></td>";

	#print "<td width=\"90\"><a href=\"ArchivedUsers.pl?SID=$sid&adminlogin=$adminlogin\" target=\"response\">";
 	#print "Archived</a></td>";

  	print "<td width=\"90\"><a href=\"maninstr.pl?SID=$sid&adminlogin=$adminlogin\" target=\"response\">";
  	print "<img border=\"0\" src=\"../_image/instr.gif\" width=\"90\" height=\"36\" alt=\"Instrument Managerment/Group Email\"></a></td>";

  	print "<td width=\"90\"><a href=\"newsignform.pl?SID=$sid&login=$adminlogin&option=add\" target=\"response\">";
  	print "<img border=\"0\" src=\"../_image/signup.gif\" width=\"90\" height=\"36\" alt=\"Signup/Reserve an instrument\"></a></td>";

  	print "<td width=\"90\"><a href=\"cancelsign.pl?SID=$sid&login=$adminlogin\" target=\"response\">";
  	print "<img border=\"0\" src=\"../_image/cancel.gif\" width=\"90\" height=\"36\" alt=\"View/Cancel own signup\"></a></td>";

	print "<td width=\"90\"><a href=\"uploadadm.pl?SID=$sid&login=$adminlogin\" target=\"response\">";
  	print "<img border=\"0\" src=\"../_image/upload.jpg\" width=\"90\" height=\"36\" alt=\"View Schedule\"></a></td>";

  	#print "<td width=\"90\"><a href=\"newsignform.pl?SID=$sid&login=$adminlogin&option=view\" target=\"response\">";
  	#print "<img border=\"0\" src=\"../_image/schedule.gif\" width=\"90\" height=\"36\" alt=\"View Schedule\"></a></td>";

#  	print '<td width=\"90\"><a href=\"http://cemma-usc.net/cemma/testbed/login.php\" target=\"response\">';
  	print "<td width=\"90\"><img style='cursor:pointer' onclick=\"openNewSite();\" border=\"0\" src=\"../_image/NSite.gif\" width=\"90\" height=\"36\" alt=\"View Schedule\"></td>";
	
	print "<td align=\"right\" valign=\"top\">";
	print "<a href=\"javascript:openWindow('changepassword.pl?SID=$sid&login=$adminlogin');\">"; 
	print "<img border=\"0\" src=\"../_image/passwd1.gif\" width=\"48\"></a>";
	#print "<td width=\"10\">&nbsp;</td>";
	print "<td align=\"right\" valign\=\"top\">";	
	print "<a href=\"Javascript:location.replace('logout.pl?SID=$sid')\" target=_parent>"; 
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
