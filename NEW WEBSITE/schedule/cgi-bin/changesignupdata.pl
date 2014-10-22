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
$sth = $db->prepare("select Passwd, Class, UserClass from user where UserName = '$login'");
$sth->execute();
($passworddb, $classadmin, $UserClass) = $sth->fetchrow_array();
$sth->finish();

if($spassword eq $passworddb)
{
	print "Content-type: text/html\r\n\r\n";
	
	$date1 = param("date");
	$instr_name = param("InstrName");
	$usedby = param("usedby");
	$slot = param("slot");
	$mode = param("mode");
	$d = new Date::Business(DATE => "$date1");
	$d->add(5);
	$date2 = $d->image();
	$d->add(2);
	$date3 = $d->image();
	$d->sub(7);
	$date = $d->image();
	
	print $date1."|";
	print $date2."|";
	print $date3."|";
	print $date."|";
	print $classadmin."<br>";
	print $instr_name."<br>";
	print $usedby."<br>";
	print $classadmin."<br>";
	
	if ($UserClass ne '4') 
	{
		if ($mode eq 'add')
		{
			$db->do("INSERT INTO schedule (InstrumentNo, InstrumentName, Date, Slot, Status, UsedBy) VALUES('0', '$instr_name', '$date', '$slot', '1', '$usedby')");
			print "|INSERT INTO schedule (InstrumentNo, InstrumentName, Date, Slot, Status, UsedBy) values('0', '$instr_name', '$date', '$slot', '1', '$usedby')";
		}
		elsif ($mode eq 'change')
		{
			$db->do("UPDATE schedule SET UsedBy='$usedby' WHERE InstrumentName='$instr_name' AND Date='$date' AND Slot='$slot'");
			print "|UPDATE schedule SET UsedBy='$usedby' WHERE InstrumentName='$instr_name' AND Date='$date' AND Slot=$slot";
		}
		$sth = $db->prepare("SELECT UsedBy FROM schedule WHERE InstrumentName='$instr_name' AND Date='$date' AND Slot='$slot'");
		$sth->execute();
		$usedby_new = $sth->fetchrow_array();
		$sth->finish();
		print $usedby_new;
	}
	
	$sth->finish();
	$db->disconnect;
	exit;
}
else
{
	print "Content-type: text/html\r\n\r\n";
	print "<body>yyy";
	print "</body>";
	exit;
}
#updated time to be modified!!
