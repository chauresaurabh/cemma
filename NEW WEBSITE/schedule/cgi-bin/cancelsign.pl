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

if($spassword eq $passworddb)
{
	($sec, $min, $hour, $mday, $mon, $year_off, $yday, $isdst) = localtime;
	$year_off += 1900;
	$mon += 1;
	
	print "Content-type: text/html\r\n\r\n";
			
	print "<html>";
   	print "<body background=\"../_image/valtxtr.gif\">";

	print "<title>";
	print "Cancel Signup";
	print "</title>";	
	

   	print "<p align=\"right\"><a href=\"Javascript:self.print()\"><b>PRINT</b></a></p>";
	print "<h3> You have signed up: (from $mon/$mday/$year_off) </h3>";
	print "<div align=\"center\">";
  	print "<center>";
	
	if ($login eq "John")
	{
		print "<table border=\"3\" cellpadding=\"3\" cellspacing=\"3\">";
		print "<tr>";
			print "<td width=\"110\"><b>User</b></td>";
			print "<td width=\"250\"><b>Instrument name</b></td>";
			print "<td width=\"110\"><b>Date</b></td>";
			print "<td width=\"130\"><b>Time</b></td>";
			print "<td width=\"100\"><b>Cancel</b></td>";
			print "</tr>";
		$sth = $db->prepare("select UsedBy, InstrumentName, Date, Slot from schedule where Date >= '$year_off-$mon-$mday' ORDER BY UsedBy, InstrumentName, Date, Slot DESC");
		$sth->execute();
		while(($user_name, $instr_name, $date, $slot)=$sth->fetchrow_array)
		{
			my ($y, $m, $d) = split(/-/, $date);

			print "<tr>";
			print "<td width=\"110\">$user_name</td>";
			print "<td width=\"250\">$instr_name</td>";
			print "<td width=\"110\">$m/$d/$y</td>";
			print "<td width=\"130\">";

			if ($slot eq '1')
			{
				print "8 am - 9 am";
			}
			elsif ($slot eq '2')
			{
				print "9 am - 10 am";
			}
			elsif ($slot eq '3')
			{
				print "10 am - 11 am";
			}
			elsif ($slot eq '4')
			{
				print "11 am - 12 am";
			}
			elsif ($slot eq '5')
			{
				print "1 pm - 2 pm";
			}
			elsif ($slot eq '6')
			{
				print "2 pm - 3 pm";
			}
			elsif ($slot eq '7')
			{
				print "3 pm - 4 pm";
			}		
			elsif ($slot eq '8')
			{
				print "4 pm - 5 pm";
			}		
			elsif ($slot eq '9')
			{
				print "5 pm - 7 pm";
			}		
				elsif ($slot eq '10')
			{
				print "7 pm - 9 pm";
			}		
				elsif ($slot eq '11')
			{
				print "9 pm - 8 am";
			}		
			else
			{
				print "Not regular time.";
			}

				print "</td>";
			print "<td width=\"100\">";          	
			print "<a href=\"delschedule.pl?SID=$sid&login=$login&InstrName=$instr_name&Date=$date&Slot=$slot&UsedBy=$user_name\"> Cancel</a>";
				print "</td>";
			print "</tr>";
		}
		print "</table>";
	}
	else
	{
		print "<table border=\"3\" cellpadding=\"3\" cellspacing=\"3\">";
		print "<tr>";
			print "<td width=\"250\"><b>Instrument name</b></td>";
			print "<td width=\"110\"><b>Date</b></td>";
			print "<td width=\"130\"><b>Time</b></td>";
			print "<td width=\"100\"><b>Cancel</b></td>";
			print "</tr>";
			$sth = $db->prepare("select InstrumentName, Date, Slot from schedule where UsedBy = '$login' and Date >= '$year_off-$mon-$mday'");
			$sth->execute();

		while(($instr_name, $date, $slot)=$sth->fetchrow_array)
		{
			my ($y, $m, $d) = split(/-/, $date);

			print "<tr>";
			print "<td width=\"250\">$instr_name</td>";
			print "<td width=\"110\">$m/$d/$y</td>";
			print "<td width=\"130\">";

			if ($slot eq '1')
			{
				print "8 am - 9 am";
			}
			elsif ($slot eq '2')
			{
				print "9 am - 10 am";
			}
			elsif ($slot eq '3')
			{
				print "10 am - 11 am";
			}
			elsif ($slot eq '4')
			{
				print "11 am - 12 am";
			}
			elsif ($slot eq '5')
			{
				print "1 pm - 2 pm";
			}
			elsif ($slot eq '6')
			{
				print "2 pm - 3 pm";
			}
			elsif ($slot eq '7')
			{
				print "3 pm - 4 pm";
			}		
			elsif ($slot eq '8')
			{
				print "4 pm - 5 pm";
			}		
			elsif ($slot eq '9')
			{
				print "5 pm - 7 pm";
			}		
				elsif ($slot eq '10')
			{
				print "7 pm - 9 pm";
			}		
				elsif ($slot eq '11')
			{
				print "9 pm - 8 am";
			}		
			else
			{
				print "Not regular time.";
			}

				print "</td>";
			print "<td width=\"100\">";          	
			print "<a href=\"delschedule.pl?SID=$sid&login=$login&InstrName=$instr_name&Date=$date&Slot=$slot\"> Cancel</a>";
				print "</td>";
			print "</tr>";
		}
		print "</table>";
	}

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

	
	
