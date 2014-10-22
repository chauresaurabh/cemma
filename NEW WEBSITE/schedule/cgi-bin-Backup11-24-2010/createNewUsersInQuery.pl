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

# my $s = new CGI::kSession(lifetime=>900, path=>"../../var/session/",id=>param("SID"));
#$sid=$s->id();
# $s->start();
# $adminlogin=param("adminlogin");
# $spassword=$s->get("$adminlogin");
# $sth = $db->prepare("select Passwd, Class from user where UserName = '$adminlogin'");
# $sth->execute();
#($passworddb, $ClassAdmin) = $sth->fetchrow_array();
# $sth->finish();

#if($spassword eq $passworddb)
# {
	print "Content-type: text/html\r\n\r\n";
	print "<html>\n";
	print "<head>\n";
	#print "<meta http-equiv=\"refresh\"; CONTENT=\"1; url=manuser.pl?SID=$sid&adminlogin=$adminlogin\">\n";
	print "</head>\n";
	
   	print "<body background=\"../_image/valtxtr.gif\">\n";
	
	# if ($ClassAdmin eq 2)
	# { 
	#	print "<h3><center>You have no right for this operation!</h3>\n";
	#	exit;
	# }

	$firstname = param("FirstName");
	$lastname = param("LastName");
	$login=$firstname.'-'.$lastname; #param("UserName");
	$password='123'; #param("Passwd");
	$email= param("Email");
	$advisor= param("Advisor");
	$dept = param("Dept");
	$tel = param("Telephone");
	$checkbox = param("Class");
        $gradyear = param("GradYear");
        $gradterm = param("GradTerm");
	@fieldlist = param('fieldofinterest');
	$Comments = param("Comments");

	#print "1-";
	
	$fieldlistcount=scalar(@fieldlist);
$field='';
for($i=0;$i<$fieldlistcount;$i++)
{
	if($i==0)
	{$field=$fieldlist[$i];
	}
	else 
	{$field=$field.",".$fieldlist[$i];
	}
	

#print "$field ";
}

	if ($checkbox eq "")
	{
		$class=2;
	}
	else
	{
		$class=1;
	}

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

	$sth = $db->prepare("select UserName from user where UserName = '$login' ");
	$sth->execute();
	$found_login = $sth->fetchrow_array();
	$sth->finish;

	#if($found_login eq $login)
	#{
	#	print "<h3><center>$login has been used!</h3>\n";
	#}
	#else
	#{
		my $ins = "insert into UsersInQuery (UserName, Passwd, Class, FirstName, LastName, Name, Email, Telephone, Dept,Advisor, GradYear, GradTerm, FieldofInterest, Comments) values('$login', '$password', '$class', '$firstname','$lastname','$firstname$lastname','$email', '$tel', '$dept', '$advisor', $gradyear, '$gradterm' , '$field', '$Comments')";
		$db->do($ins);
		
		$instrNum = param("InstrNum");
		for ($ii=1; $ii <= $instrNum; $ii++)
		{
			$instrNo = param("Instr$ii");
			if ($instrNo ne "")
			{
				#$YY = param("YY_Instr$ii");
				#$MM = param("MM_Instr$ii");
				#$DD = param("DD_Instr$ii");
				$db->do("insert into UsersInQuery_instr_group (InstrNo, Email, InstrSigned) values('$instrNo', '$email', '')");			
			}
		}
		
		print "<h3><center>Entry for \"$login\" has been created successfully!</h3>\n";
		# print $ins;  # Debug.

	#}
	
	print "</body>\n";
	print "</html>\n";
	
	$db->disconnect;
#}

#else

#{
#	print "Content-type: text/html\r\n\r\n";
#	print "<body onload=\"Javascript:parent.location.replace('../index_alt.html')\">"; 		
#	print "</body>\n";
#	exit;
#}

# updated time to be modified!!
