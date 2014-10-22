#!/usr/bin/perl
use lib "/kunden/homepages/40/d209127057/htdocs/schedule/cgi-bin/";
use CGI qw/:standard/;
use CGI::kSession;
use DBI;

#---------------------------------------------------------------------------------
# User modification script - backend database access.  Updates user information.
#---------------------------------------------------------------------------------

$dsn="DBI:mysql:database=db210021972:host=db948.perfora.net";
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
	print "<html>\n";
	print "<head>\n";
	print "<meta http-equiv=\"refresh\"; CONTENT=\"3; url=manuser.pl?SID=$sid&adminlogin=$adminlogin\">\n";
	print "</head>\n";
	
	print "<body background=\"../_image/valtxtr.gif\">\n";
	
	if ($ClassAdmin eq 2)
	{
		print "<h3><center>You have no right for this operation!</h3>\n";
		exit;
	}
	
	$firstname = param("FirstName");
	$lastname = param("LastName");
	$login = param("UserName");
	$password = param("Passwd");
	$email = param("Email");
	$advisor = param("Advisor");
	$dept = param("Dept");
	$activate = param("activate1");
	$tel = param("Telephone");
	$checkbox = param("Class");
	$gradyear = param("GradYear");
	$gradterm = param("GradTerm");
	$tag = param("tag");
	$old_email = param("old_email");
	$old_username = param("o_username");
	$lastupdatestatus = param("lastupdatestatus1");

		($dd, $mm, $yy)=(localtime)[3,4,5];
		$mm = $mm + 1;
		$yy = $yy + 1900;



if($activate eq 'active'){
	#print " *active* ";
	$lastupdatestatus=$yy.'-'.$mm.'-'.$dd;
	$activate='active';

}
else
	{$lastupdatestatus=$lastupdatestatus;
	 $activate='inactive';
	 }
		
#print "act-$activate   ";
#print "date-$lastupdatestatus";


	if ($checkbox eq "")
	{
		$class=2;
	}
	else
	{
		$class=1;
	}

	# If no grad. year was supplied, reset grad. term.
	if($gradyear eq '') {
		$gradyear = 'NULL';
		$gradterm = '';
	}
	else {
		$gradyear = "'$gradyear'";
	}

	if ($login eq $tag)
	{ # change admin himself
		my $ins = "update user set Passwd='$password', Class='$class', FirstName='$firstname', LastName='$lastname', Name='$firstname $lastname', Email='$email', Telephone='$Tel', Dept='$dept', Advisor='$advisor', GradYear = $gradyear, GradTerm ='$gradterm',ActiveUser='$activate' , LastStatusUpdate='$lastupdatestatus', LastEmailSentOn='$lastupdatestatus' where UserName = '$old_username'";
		$db->do($ins);

		

		$db->do("delete from instr_group where Email = '$old_email'");
		$instrNum = param("InstrNum");
		for ($ii=1; $ii <= $instrNum; $ii++)
		{
			$instrNo = param("Instr$ii");
			if ($instrNo ne "")
			{
				$YY = param("YY_Instr$ii");
				$MM = param("MM_Instr$ii");
				$DD = param("DD_Instr$ii");
				$db->do("insert into instr_group (InstrNo, Email, InstrSigned) values('$instrNo', '$email', '$YY-$MM-$DD')");
			}
		}

		print "<h3><center>Entry for \"$login\" has been modified successfully!</h3>";	
		# print "$ins";  # Debug.
	}
	else
	{ # change other users
		$sth = $db->prepare("select UserName from user where UserName = '$old_username' ");
		$sth->execute();
		$found_login = $sth->fetchrow_array();
		$sth->finish;
	
		if($found_login eq $login)
		{
			print "<h3><center>Modification cannot be completed!</h3>\n";
			print "<h3><center>$login has been used!</h3>\n";
		}
		else
		{
			

			my $ins = "insert into user (UserName, Passwd, Class, FirstName, LastName, Name, Email, Telephone, Dept, Advisor, GradYear, GradTerm, ActiveUser,LastStatusUpdate,LastEmailSentOn) values ('$login', '$password', '$class', '$firstname', '$lastname', '$firstname $lastname', '$email', '$tel','$dept', '$advisor', $gradyear, '$gradterm', '$activate' ,'$lastupdatestatus','$lastupdatestatus' )";

			
			$db->do("delete from user where UserName='$tag'");
			$db->do($ins);
			
			
			$db->do("Delete from instr_group where Email = '$old_email'");			
			$instrNum = param("InstrNum");
			for ($ii=1; $ii <= $instrNum; $ii++)
			{
				$instrNo = param("Instr$ii");
				if ($instrNo ne "")
				{
					$YY = param("YY_Instr$ii");
					$MM = param("MM_Instr$ii");
					$DD = param("DD_Instr$ii");
					$db->do("insert into instr_group (InstrNo, Email, InstrSigned) values('$instrNo', '$email', '$YY-$MM-$DD')");							
				}
			}
			
			print "<h3><center>Entry from \"$tag\" to \"$login\" has been modified successfully!</h3>\n";
			# print "$ins";  # Debug.
		}
	}

		
		
		

	$db->disconnect;

	if ($adminlogin eq $tag)
	{
		print "<h3>You have changed your own profile, so you have to log in again!</h3>\n";
		#print "<h3>You will be redirected to login page in 3 seconds<h3>";
		#print "<body onload=\"Javascript:parent.location.replace('../index_alt.html')\">"; 				
	}
	print "</body>\n";
	print "<p>This page will go back in 3 seconds automatically. </p>\n";
	print "</html>\n";
}

else
{
	print "Content-type: text/html\r\n\r\n";
	print "<body onload=\"Javascript:parent.location.replace('../index_alt.html')\">"; 		
	print "</body>\n";
	exit;
}

# updated time to be modified!!
