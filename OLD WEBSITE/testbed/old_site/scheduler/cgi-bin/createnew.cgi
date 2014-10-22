#!/usr/usc/bin/perl -X
use CGI qw/:standard/;
use CGI::kSession;
use DBI;

#---------------------------------------------------------------------------------
# New user script - backend database access.  Creates new user in database.
#---------------------------------------------------------------------------------

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
	print "<html>\n";
	print "<head>\n";
	print "<meta http-equiv=\"refresh\"; CONTENT=\"1; url=manuser.cgi?SID=$sid&adminlogin=$adminlogin\">\n";
	print "</head>\n";
	
   	print "<body background=\"../_image/valtxtr.gif\">\n";
	
	if ($ClassAdmin eq 2)
	{
		print "<h3><center>You have no right for this operation!</h3>\n";
		exit;
	}

	$firstname = param("FirstName");
	$lastname = param("LastName");
	$login=param("UserName");
	$password=param("Passwd");
	$email= param("Email");
	$advisor= param("Advisor");
	$dept = param("Dept");
	$tel = param("Telephone");
	$checkbox = param("Class");
        $gradyear = param("GradYear");
        $gradterm = param("GradTerm");

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

	if($found_login eq $login)
	{
		print "<h3><center>$login has been used!</h3>\n";
	}
	else
	{
		my $ins = "insert into user (UserName, Passwd, Class, FirstName, LastName, Name, Email, Telephone, Dept,Advisor, GradYear, GradTerm) values('$login', '$password', '$class', '$firstname','$lastname','$firstname$lastname','$email', '$tel', '$dept', '$advisor', $gradyear, '$gradterm')";
		$db->do($ins);
		
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
		
		print "<h3><center>Entry for \"$login\" has been created successfully!</h3>\n";
		# print $ins;  # Debug.

	}
	
	print "</body>\n";
	print "</html>\n";
	
	$db->disconnect;
}

else

{
	print "Content-type: text/html\r\n\r\n";
	print "<body onload=\"Javascript:parent.location.replace('../index_alt.html')\">"; 		
	print "</body>\n";
	exit;
}

# updated time to be modified!!