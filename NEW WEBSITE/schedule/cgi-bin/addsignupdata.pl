#!/usr/bin/perl
use lib "/kunden/homepages/40/d209127057/htdocs/schedule/cgi-bin/";
use CGI qw/:standard/;
use CGI::kSession;
use DBI;
use Date::Business;
require 'enmonth.pl';
require 'enweekday.pl';

$dsn = "DBI:mysql:database=db210021972:host=db948.perfora.net";
$db= DBI->connect($dsn, "dbo210021972", "XhYpxT5v");

my $s = new CGI::kSession(lifetime=>900, path=>"../../var/session/",id=>param("SID"));
$sid=$s->id();
$s->start();
$login=param("login");
$spassword=$s->get("$login");
$sth = $db->prepare("select Passwd, Class from user where UserName = '$login'");
$sth->execute();
($passworddb, $classadmin) = $sth->fetchrow_array();
$sth->finish();

if($spassword eq $passworddb)
{
	print "Content-type: text/html\r\n\r\n";
	print "<html>";
   	
	$date1 = param("date");
	$instr_name = param("InstrName");
	#print "$date1";
	$d = new Date::Business(DATE => "$date1");
	$d->add(5);
	$date2 = $d->image();
	$d->add(2);
	$date3 = $d->image();
	$d->sub(7);
	
	$today   = new Date::Business(); # today
	$offset = $d->diff($today);
	$_ = $instr_name;
	s/ /%20/g;
	print "<head>";
	print "<meta http-equiv=\"refresh\"; CONTENT=\"3; url=signup.pl?SID=$sid&login=$login&week=$offset&InstrName=$_\">";
	print "</head>";
	
   	print "<body background=\"../_image/valtxtr.gif\">";	
		
	if ($classadmin eq '2')
	{
		$sth = $db->prepare("select count(*) from schedule where InstrumentName = '$instr_name' and Date >= '$date1' and Date < '$date2' and Slot <'9' and Usedby = '$login'");
		$sth->execute();
		$count = $sth->fetchrow_array();

		#$sth = $db->prepare("select count(*) from schedule where InstrumentName = '$instr_name' and Date >= '$date1' and Date < '$date2' and Slot >='9' and Usedby = '$login'");
		#$sth->execute();
		#$count1 = $sth->fetchrow_array()*2;  # Two-hour slots.

		$sth = $db->prepare("select count(*) from schedule where InstrumentName = '$instr_name' and Date >= '$date1' and Date < '$date3' and Slot >='9' and Usedby = '$login'");
		$sth->execute();
		$count1 = $sth->fetchrow_array()*2;  # Two-hour slots.

		$sth = $db->prepare("select count(*) from schedule where InstrumentName = '$instr_name' and Date >= '$date2' and Date < '$date3' and Slot < '9' and Usedby = '$login'");
		$sth->execute();
		$count1 += $sth->fetchrow_array();	

		#print "$count, $count1";
		#exit;
	}
	else
	{
		$count = 0;
		$count1 = 0;
	}

	for ($daycount = 0; $daycount < 7; $daycount ++)
	{	
	    $date = $d->image();
	    for ($i=0; $i <= 11; $i++)
	    {
	    	$slotname = "slot"."$daycount"."_"."$i";
		$slot = param("$slotname");
		if ($slot eq "on")
		{
			#print "$date";
			if (($i < 9) && ($daycount < 5))
			{
				$count++;
			}
			else
			{
				if($i > 8)
				{
					$count1 += 2;
				}
				else {
					$count1++;
				}
			}
		}
	    }
	}

	if (($classadmin eq '2') && ($count > 4))
	{
		print "<h3><center>Your request failed!</h3>";
		print "<h4>Reason: You have attempted to sign up for more than four hours of peak time this week.</h4>";

		print "<p>This page will refresh in 3 seconds automatically. </p>";
		print "</body>";
		print "</html>";
	
		$sth->finish();
		$db->disconnect;
		
		exit;
	}			
	
	if (($classadmin eq '2') && ($count1 > 8))
	{
		print "<h3><center>Your request failed!</h3>";
		print "<h4>Reason: You have attempted to sign up for more than eight hours of off-peak time this week.</h4>";

		print "<p>This page will refresh in 3 seconds automatically. </p>";
		print "</body>";
		print "</html>";
	
		$sth->finish();
		$db->disconnect;
		
		exit;
	}			
	
	for ($daycount = 0; $daycount < 7; $daycount ++)
	{	
	    $date = $d->image();
	    for ($i=0; $i <= 11; $i++)
	    {
	    	$slotname = "slot"."$daycount"."_"."$i";
		$slot = param("$slotname");
		if ($slot eq "on")
		{
			#print "$i, $daycount, $count\n";
			$db->do("insert into schedule (InstrumentNo, InstrumentName, Date, Slot, Status, UsedBy) values('0', '$instr_name', '$date', '$i', '1', '$login')");
		}
	    }
	    $d->add(1);   
	}
	
	print "<h3><center>The time slots you specified have been reserved successfully!</h3>";
	#print "$count, $count1";
	
	print "<p>This page will refresh in 3 seconds automatically. </p>";
	print "</body>";
	print "</html>";
	
	$sth->finish();
	$db->disconnect;
}
else
{
	print "Content-type: text/html\r\n\r\n";
	print "<body onload=\"Javascript:parent.location.replace('../index_alt.html')\">"; 		
	print "</body>";
	exit;
}
#updated time to be modified!!