#!/usr/usc/bin/perl -w
use CGI qw/:standard/;
use CGI::kSession;
use DBI;


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

if($spassword eq $passworddb)
{
	print "Content-type: text/html\r\n\r\n";
	print "<head>";
	print "<meta http-equiv=\"refresh\"; CONTENT=\"5; url=maninstr.cgi?SID=$sid&adminlogin=$adminlogin\">";
	print "</head>";
	
   	print "<body background=\"../_image/valtxtr.gif\">";
   		
	if ($ClassAdmin eq 2)
	{
		print "<h3><center>You have no right for this operation!</h3>";
		exit;
	}

	$name=param("InstrName");
	$comment=param("Comment");
	$can = param("can");
	if ($can eq "yes")
	{
		$can = '1';
	}
	else
	{
		$can = '0';
	}
	
	$sth = $db->prepare("select max(InstrumentNo) from instrument");
	$sth->execute();
	$no = $sth->fetchrow_array();
	$no = $no + 1;
	$sth->finish;

	$db->do("insert into instrument (InstrumentNo, InstrumentName, Comment, Availablity) values('$no', '$name', '$comment', '$can')");

	# generate a html file, called 'update.html'
	open(UPDATE, ">../update/update.html") || die "Can not update file : $!";
	print UPDATE "<!--Author>Jhn Cururlli-->\n";
	print UPDATE "  <html>\n";
	print UPDATE "<head>\n";
	print UPDATE "<title>Instrument Update</title>";
	print UPDATE "</head>";
	print UPDATE "<body background=\"../_image/valtxtr.gif\">";
	print UPDATE "<center>";
	print UPDATE "<h3><span style='font-family:\"Trebuchet MS\";color:#990000'>INSTRUMENT OPERATION</span></h3>";
	print UPDATE "</center>";
	print UPDATE "<table width=\"75%\" border=\"10\" align=\"center\" bordercolor=\"\">";
	print UPDATE "<span style='font-family:\"Trebuchet MS\";color:#990000'></span>";
	print UPDATE "<tr><td width =\"150\" class=\"content-header\"><strong>INSTRUMENT</strong></td><td width =\"120\" class=\"content-header\"><strong>OPERATING CONDITION</strong></td><td width =\"250\" class=\"content-header\"><strong>COMMENT</strong></td></TR>";
	
	$sth = $db->prepare("select InstrumentName, Availablity, Comment from instrument");
	$sth->execute();
	while(($instrName, $instrCan, $comment)=$sth->fetchrow_array)
	{
		print UPDATE "<tr><td>$instrName</td><td>";
		if ($instrCan eq '1')
		{
			print UPDATE "Yes</td></TR>";
		}
		else
		{
			print UPDATE "No</td></TR>";
		}
		if ($comment eq "")
		{
			print UPDATE "<td width =\"250\" class=\"content\"><br></td></tr>";
		}
		else
		{
			print UPDATE "<td width =\"250\" class=\"content\">$comment</td></tr>";
		}		
	}

	print UPDATE "</table>	";
	print UPDATE "<FONT SIZE=-1><I>";
	($day, $month, $year)=(localtime)[3,4,5];
	if($day<10){$this_day='0'."$day"; }else{$this_day=$day;}
	$current_year = $year+1900;	
	$month += 1;
	print UPDATE "<BR>Last Updated on $month/$this_day/$current_year";
	print UPDATE "<BR>By John Curulli";
	print UPDATE "<BR>Email: <A HREF = \"mailto:curulli@usc.edu\">curulli@usc.edu</A>";
	print UPDATE "<FONT SIZE=+0></I>";
	print UPDATE "<!-- footer  -->";
	print UPDATE "<center>";
	print UPDATE "<hr width=\"100%\">";
	print UPDATE "<H3>";
	print UPDATE "<A HREF=\"http://www.usc.edu/dept/CEMMA/mission.html\">Mission Statement";
	print UPDATE "</A> | <A HREF=\"http://www.usc.edu/dept/CEMMA/background.html\">Background";
	print UPDATE "</A> | <A HREF=\"http://www.usc.edu/dept/CEMMA/location.html\">Location";
	print UPDATE "</A> | <A HREF=\"http://www.usc.edu/dept/CEMMA/executive.html\">Executive Committee";
	print UPDATE "</A> | <A HREF=\"http://www.usc.edu/dept/CEMMA/staff.html\">Staff";
	print UPDATE "</A> | <A HREF=\"http://www.usc.edu/dept/CEMMA/instruments.html\">Instruments";
	print UPDATE "</A> | <A HREF=\"http://www.usc.edu/dept/CEMMA/research.html\">Research";
	print UPDATE "</A> | <A HREF=\"http://www.usc.edu/dept/CEMMA/teaching.html\">Teaching";
	print UPDATE "</A> | <A HREF=\"http://www.usc.edu/dept/CEMMA/courses.html\">Courses";
	print UPDATE "</A> | <A HREF=\"http://www.usc.edu/dept/CEMMA/future plans.html\">Future Plans";
	print UPDATE "</A> | <A HREF=\"http://www.usc.edu/dept/CEMMA/contact us.html\">Contact CEMMA";
	print UPDATE "</A> ";
	print UPDATE "</H3>";
	print UPDATE "</center>";
	print UPDATE "</body></html>";
	
	close (UPDATE);
	$sth->finish();
	#end of updating file
	
	print "<h3><center>Entry for \"$name\" is created successfully!</h3>";
	print "<p>This page will go back in 3 seconds automatically. </p>";
	print "</body>";
	$db->disconnect;
}

else

{
	print "Content-type: text/html\r\n\r\n";
	print "<body onload=\"Javascript:parent.location.replace('../index_alt.html')\">"; 		
	print "</body>";
	exit;
}
