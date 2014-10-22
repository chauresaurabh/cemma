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

if($spassword eq $passworddb)
{
	print "Content-type: text/html\r\n\r\n";
	if ($ClassAdmin eq 2)
	{
		print "<h3><center>You have no right for this operation!</h3>";
		exit;
	}
			
	print "<html>";
   	print "<body background=\"../_image/valtxtr.gif\">";	
	print "<title>";
	print "Instrument Managerment";
	print "</title>";	

	print "<h3><a href=\"newinstr.cgi?SID=$sid&adminlogin=$adminlogin\" target=\"response\">Add instrument</a></h3>";
	print "<h3>Current instruments:</h3>";
	print "<div align=\"center\">";
  	print "<center>";
	print "<table border=\"3\" cellpadding=\"3\" cellspacing=\"3\" width=\"540\">";
	print "<tr>";
    	print "<td width=\"100\"><b>Instrument No</b></td>";
    	print "<td width=\"250\"><b>Instrument Name</b></td>";
    	print "<td width=\"100\"><b>Available</b></td>";
    	print "<td width=\"150\"><b>Display/Modify</b></td>";
    	print "<td width=\"80\"><b>Delete</b></td>";
    	print "<td width=\"100\"><b>Group Email</td>";
    	print "</tr>";

	$sth = $db->prepare("select InstrumentNo, InstrumentName, Availablity from instrument");
	$sth->execute();
	$user_no = 0;
	while(($instrNo, $instrName, $instrCan)=$sth->fetchrow_array)
	{
		print "<tr>";
		print "<td width=\"100\">$instrNo</td>";
		print "<td width=\"250\">$instrName</td>";
		if ($instrCan eq '1')
		{
			print "<td width=\"100\">Yes</td>";
		}
		else
		{
			print "<td width=\"100\">No</td>";
		}			
		print "<td width=\"150\">";
		print "<a href=\"modifyinstr.cgi?SID=$sid&adminlogin=$adminlogin&tag=$instrNo\">Display/Modify</a>";
          	print "</td>";
		print "<td width=\"80\">";          	
		print "<a href=\"delinstr.cgi?SID=$sid&adminlogin=$adminlogin&tag=$instrNo\"> Delete</a>";
          	print "</td>";
		print "<td width=\"100\">";          	
		print "<a href=\"groupmail.cgi?SID=$sid&adminlogin=$adminlogin&tag=$instrNo\">Email</a>";
          	print "</td>";
		print "</tr>";
		$user_no++;
	}
	print "</table>";
  	print "</center>";
	print "</div>";
	print "</body>";
	print "</html>";
	
	$db->disconnect;	
}

else
{
	$db->disconnect;
	print "Content-type: text/html\r\n\r\n";
	print "<body onload=\"Javascript:parent.location.replace('../index_alt.html')\">"; 		
	print "</body>";
	exit;
}
$sth->finish;

	
	
