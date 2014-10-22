#!/usr/bin/perl
use lib "/kunden/homepages/40/d209127057/htdocs/schedule/cgi-bin/";
use CGI qw/:standard/;
use CGI::kSession;
use DBI;

#---------------------------------------------------------------------------------
# New user script - backend database access.  Creates new user in database.
#---------------------------------------------------------------------------------

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
	print "<html>\n";
	print "<head>\n";
	print "<meta http-equiv=\"refresh\"; CONTENT=\"5; url=manuser.pl?SID=$sid&adminlogin=$adminlogin\">\n";
	print "</head>\n";
	
   	print "<body background=\"../_image/valtxtr.gif\">\n";
	
	if ($ClassAdmin eq 2)
	{
		print "<h3><center>You have no right for this operation!</h3>\n";
		exit;
	}
	#print "admin---".$adminlogin;

	# Store selected usersinquery to be transferred to users in @userlist array
	@userlist = param('userselected');
	$userlistcount=scalar(@userlist);;
#	print "count-".$userlistcount;

# Run a loop to transfer data from 1)usersinquery to user table and 2)usersinquery_instr_group to instr_group
	
	($dd, $mm, $yy)=(localtime)[3,4,5];
	$mm = $mm + 1;
	$yy = $yy + 1900;


	for($i=0;$i<$userlistcount;$i++)
	{
		$user=$userlist[$i];
		#print "user-".$user;
		$sth = $db->prepare("select Passwd, Class, Email, FirstName, LastName, Telephone, Dept, Advisor, GradYear, GradTerm, Position, FieldofInterest,Comments from UsersInQuery where UserName = '$user'");
		$sth->execute();
		($password, $class, $email, $firstname, $lastname, $tel, $dept, $advisor, $gradyear, $gradterm, $position, $FieldofInterest, $Comments) = $sth->fetchrow_array();
		$Comments =~ s/\'/\\\'/;
		#$db->disconnect;	
		
		# Make class=2 ie Non-Administrator
		# $class=2;


		#print "$class";
		#print "$checkbox";
		# If no grad. year was supplied, reset grad. term.    
		if($gradyear eq '') {
			$gradyear = 'NULL';
			$gradterm = '';
		}
		else {  
			$gradyear = "'$gradyear'";
		 }
		($dd, $mm, $yy)=(localtime)[3,4,5];
		$mm = $mm + 1;
		$yy = $yy + 1900;


		$sth = $db->prepare("select UserName from user where UserName = '$user' "); #$login
		$sth->execute();
		$found_login = $sth->fetchrow_array();
		# $sth->finish;

		if($found_login eq $user) #$login
		{
			print "<h3><center>$user has been used! Please check the 'Archived User list'</h3>\n";
		}
		else
		{
		#	print "login not used";
			my $ins = "insert into user (UserName, Passwd, Class, FirstName, LastName, Name, Email, Telephone, Dept,Advisor, GradYear, GradTerm, Position, FieldofInterest, Comments, MemberSince,LastEmailSentOn,LastStatusUpdate) values('$user', '$password', '$class', '$firstname','$lastname','$firstname$lastname','$email', '$tel', '$dept', '$advisor', $gradyear, '$gradterm', '$position','$FieldofInterest', '$Comments', '$yy-$mm-$dd', '$yy-$mm-$dd', '$yy-$mm-$dd')";
			#print $ins;
			$db->do($ins);
			my $ins2 = "update UsersInQuery set TransferredToUsers = 1 where UserName = '$user'";
			print $ins2;
			$db->do($ins2);

			$sth = $db->prepare("select InstrNo, Email, InstrSigned from UsersInQuery_instr_group where Email = '$email' and UserName='$user' ");
			$sth->execute();
			
			$countusers=0;
			while(($InstrNo, $Email, $InstrSigned) = $sth->fetchrow_array) {
		
			$db->do("insert into instr_group (InstrNo, Email, InstrSigned) values('$InstrNo', '$Email', '$yy-$mm-$dd')");	
			$countusers++;
			}
		
			#$db->do("Delete from UsersInQuery where Email = '$email' AND UserName='$user'");	
			#$db->do("Delete from UsersInQuery_instr_group where Email = '$email and UserName='$user''");		
			print "<h3><center>Entry for \"$user\" has been Transferred successfully!</h3>\n";
		}
		
	} # end for loop to transfer
		print "</body>\n";
		print "</html>\n";
	$db->disconnect;
} # end if admin is logged in
else
{
	print "Content-type: text/html\r\n\r\n";
	print "<body onload=\"Javascript:parent.location.replace('../index.php')\">"; 		
	print "</body>\n";
	exit;
}



	# updated time to be modified!!
