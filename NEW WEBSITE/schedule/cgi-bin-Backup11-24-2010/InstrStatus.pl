#!/usr/bin/perl
use lib "/kunden/homepages/40/d209127057/htdocs/schedule/cgi-bin/";
use CGI qw/:standard/;
use CGI::kSession;
use DBI;
###################################################################################

#This script generate a form for creating a new employee.

###################################################################################

#a $dsn = "DBI:mysql:database=db210021972:host=db948.perfora.net";
#a $db= DBI->connect($dsn, "dbo210021972", "XhYpxT5v");

#a my $s = new CGI::kSession(lifetime=>900, path=>"../../var/session/",id=>param("SID"));
#a $sid=$s->id();
#a $s->start();
#a $adminlogin=param("adminlogin");
#a $spassword=$s->get("$adminlogin");
#a $sth = $db->prepare("select Passwd, Class from user where UserName = '$adminlogin'");
#a $sth->execute();
#a ($passworddb, $ClassAdmin) = $sth->fetchrow_array();
#a $sth->finish();

#a if($spassword eq $passworddb)

	print "Content-type: text/html\r\n\r\n";
	#a if ($ClassAdmin eq 2)
	
	#a	print "<h3><center>You have no right for this operation!</h3>";
	#a	exit;
		
			
	print "<html>";
   	print "<body background=\"../_image/valtxtr.gif\">";	
	print "<title>";
	print "INSTRUMENT OPERATION";
	print "</title>";	

	#a print "<h3><a href=\"newinstr.pl?SID=$sid&adminlogin=$adminlogin\" target=\"response\">Add instrument</a></h3>";
	print "<center><h3>INSTRUMENT OPERATION:</h3>";
	print "<div align=\"center\">";
  	print "<center>";
	print "<table border=\"7\" cellpadding=\"3\" cellspacing=\"3\" width=\"540\">";
	print "<tr>";
    #a	print "<td width=\"100\"><b>Instrument No</b></td>";
    	print "<td width=\"350\"><b>Instrument Name</b></td>";
    	print "<td width=\"200\"><b>Available</b></td>";
    	print "<td width=\"400\"><b>Comments</b></td>";
    #a	print "<td width=\"80\"><b>Delete</b></td>";
    #a	print "<td width=\"100\"><b>Group Email</td>";
    	print "</tr>";

#a undo	$sth = $db->prepare("select InstrumentNo, InstrumentName, Availablity from instrument");
#a undo	$sth->execute();

	#a
	$dsn = "DBI:mysql:database=db260244667:host=db1661.perfora.net";
	$db= DBI->connect($dsn, "dbo260244667", "curu11i");
	$sth = $db->prepare("select InstrumentNo, InstrumentName, Availablity,Comment, DisplayOnStatusPage  from instrument");
	$sth->execute();
	#a
	
	$user_no = 0;
	while(($instrNo, $instrName, $instrCan, $comment,$displayOnStatusPage)=$sth->fetchrow_array)
	{
		if($displayOnStatusPage ne 'No')		
		{
			print "<tr>";
			#a print "<td width=\"100\">$instrNo</td>";
			print "<td width=\"350\">$instrName</td>";
			if ($instrCan eq '1')
			{
				print "<td width=\"200\">Yes</td>";
			}
			else
			{
				print "<td width=\"200\">No</td>";
			}			
			print "<td width=\"350\">&nbsp; $comment</td>";
			#print "<td width=\"350\">&nbsp; $displayOnStatusPage</td>";
			print "</tr>";
			$user_no++;
			
		}
		$displayOnStatusPage='';
		
	}
	print "</table>";
  	print "</center>";
	
# Retrieve Current Date
($Second, $Minute, $Hour, $Day, $Month, $Year, $WeekDay, $DayOfYear, $IsDST) = localtime(time);
$Year += 1900;
$Month++;
$date = "$Month/$Day/$Year"; 
# print "---".$date;
	print "</div><font size='-1'><i><p class='content'>Last Updated on ".$date."<br />By John Curulli<br />";
	print "Email:&nbsp;<img height='11' alt='' width='132' src='/cemma/testbed/images/curulliemailpic.jpg' /></strong></p>";
	print "</body>";
	print "</html>";
	
	$db->disconnect;	


$sth->finish;

	
	
