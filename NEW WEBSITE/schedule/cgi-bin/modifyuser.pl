#!/usr/bin/perl
use lib "/kunden/homepages/40/d209127057/htdocs/schedule/cgi-bin/";
use CGI qw/:standard/;
use CGI::kSession;
use DBI;

#---------------------------------------------------------------------------------
# User modification script.  Updates user information.
#---------------------------------------------------------------------------------

$dsn = "DBI:mysql:database=db210021972:host=db948.perfora.net";
$db= DBI->connect($dsn, "dbo210021972", "XhYpxT5v");

my $s = new CGI::kSession(lifetime=>900, path=>"../../var/session/",id=>param("SID"));
$sid=$s->id();
$s->start();
$adminlogin=param("adminlogin");
$spassword=$s->get("$adminlogin");
$sth = $db->prepare("select Passwd, Class, UserClass from user where UserName = '$adminlogin'");
$sth->execute();
($passworddb, $ClassAdmin, $UserClass) = $sth->fetchrow_array();
$sth->finish();

if($spassword eq $passworddb)
{
	print "Content-type: text/html\r\n\r\n";
	if ($UserClass eq 4)
	{
		print "<h3><center>You have no right for this operation!</h3>\n";
		exit;
	}

	$sth = $db->prepare("select count(*) from instrument");
	$sth->execute();
	$instr_count = $sth->fetchrow_array;
	
	$username=param("tag");
	$sth = $db->prepare("select Passwd, Class, Email, FirstName, LastName, Telephone, Dept, Advisor, GradYear, GradTerm from user where UserName = '$username'");
	$sth->execute();
	($password, $class, $email, $firstname, $lastname, $tel, $dept, $advisor, $gradyear, $gradterm) = $sth->fetchrow_array();
	$db->disconnect;	
	$sth->finish();

	$sth = $db->prepare("select InstrNo, InstrSigned from instr_group where Email = '$email'");
	$sth->execute();
	$count_u = 0;

	while (($instrNo_u[$count_u], $instrDate[$count_u]) = $sth->fetchrow_array)
	{
		$count_u ++;
	}

	$sth->finish();

	$sth = $db->prepare("select InstrumentNo, InstrumentName from instrument");
	$sth->execute();

	($dd, $mm, $yy)=(localtime)[3,4,5];
	$mm = $mm + 1;
	$yy = $yy + 1900;
	
	print "<script>\n";
	print "function CheckBeforeSubmit(){\n";
	print "	var pattern1 = /[\\w|\\w\-\\w]/;\n";
	#print " var pattern2 = /(^ *\\w+\@\\w+\\.\\w+ *?)/;";
	print " var pattern3 = /\\W/;\n";
	print "	var flag=true;\n";
	print " var year=0;\n";
	print " var month=0;\n";
	print " var day=0;\n";
	print " var year_pattern = /^(\\d{4})\$/;\n";
	print " var month_pattern = /^(\\d{1,2})\$/;\n";

	print "	if(document.newuser.UserName.value == \"\")\n";
	print "	{\n";
	print "		alert(\"Login name can not be empty\");\n";
	print "		flag=false;\n";
	print "	}\n";
	print "	if(pattern3.test(document.newuser.Passwd.value)||document.newuser.Passwd.value == \"\")\n";
	print "	{\n";
	print "		\n";
	print "		alert(\"Password is incorrect (must be A-Z,a-z,0-9)\");\n";
	print "		flag=false;\n";
	print "	}\n";

	print " if((document.newuser.Passwd.value) != (document.newuser.cpassword.value))\n";
	print " {\n";
	print "		alert(\"Can not confirm password!\");\n";
	print "		flag=false;\n";
	print "	}";	

	print " if(document.newuser.GradYear.value != '' && !year_pattern.test(document.newuser.GradYear.value)) \n";
	print " {\n";
	print "		alert(\"Estimated Graduation Year must be blank or a four-digit year value.\");\n";
	print "		flag = false;\n";
	print " }\n;";

	for ($ii=1; $ii <= $instr_count; $ii++)
	{
	    print "if (document.newuser.Instr$ii.checked)\n";
	    print "{\n";
		print "year = document.newuser.YY_Instr$ii.value;\n";
		print "month = document.newuser.MM_Instr$ii.value;\n";
		print "day = document.newuser.DD_Instr$ii.value;\n";
		print " if (!year_pattern.test(year) || !month_pattern.test(month) || !month_pattern.test(day))\n";
		print " {\n";
		print "     alert(\"Invalid date format!\");\n";
		print "     return false\n";
		print " }\n";
	
		print "if (year < 1000)\n";
		print "{\n";
		print "	   alert(\"Year must be 4 digits!\");\n";
		print "    return false\n";
		print "}\n";
		print "if ((month > 12) || (month < 1))\n";
		print "{\n";
		print "    alert(\"Invalid month format, must be between 1-12!\");\n";
		print "    return false\n";
		print "}\n";
		print "if ((day > 31) || (day < 1))\n";
		print "{\n";
		print "    alert(\"Invalid date format!\");\n";
		print "    return false";		
		print "}\n";
		print "}\n";
	}
	
	print "	return (flag);\n";
	print "}\n";
	
	for ($ii=1; $ii <= $instr_count; $ii++)
	{
		print "function change$ii() {\n";
		print "if (window.document.newuser.Instr$ii.checked == true) {\n";
    		print "		document.newuser.YY_Instr$ii.value = \"$yy\";\n";
    		print "		document.newuser.MM_Instr$ii.value = \"$mm\";\n";
    		print "		document.newuser.DD_Instr$ii.value = \"$dd\";\n";
		print "}\n";
		print "else {\n";
    		print "		document.newuser.YY_Instr$ii.value = \"\";\n";
    		print "		document.newuser.MM_Instr$ii.value = \"\";\n";
    		print "		document.newuser.DD_Instr$ii.value = \"\";\n";
		print "}\n";
		print "}\n";
	}
	
	print "</script>\n";
	print "<html>\n";
	
	print "<title>\n";
	print "Modify User Profile\n";
	print "</title>\n";
   	print "<p align=\"right\"><a href=\"Javascript:self.print()\"><b>PRINT</b></a></p>";	
	print "<h2><center>Modify User Profile</center></h2><center>\n";
   	print "<body background=\"../_image/valtxtr.gif\">\n";
	print "  <form method=post action=\"modifyuserdata.pl\" onsubmit=\"return CheckBeforeSubmit()\" name=\"newuser\">\n";
	print "    <table align=center>\n";
	print "<tr>\n";
	print "        <td width =\"163\">*Login Name: </td>\n";
	print "        <td width=\"166\"> \n";
	if($ClassAdmin eq 1)
	print "          <input type=\"text\" name = \"UserName\" value='$username'>\n";
	else
	print "          <input type=\"text\" name = \"UserName\" value='$username' disabled='true'>\n";
	print "</td>\n";
	print "</tr>\n";
	print "<tr>\n";
	print "        <td width =\"163\">*Password: </td>\n";
	print "        <td width=\"166\"> \n";
	print "          <input type=\"password\" name = \"Passwd\" value='$password'>\n";
	print "</td>\n";
	print "</tr>\n";
	print "<tr>\n";
	print "        <td width =\"163\">*Retype password: </td>\n";
	print "        <td width=\"166\"> \n";
	print "          <input type=\"password\" name = \"cpassword\" value='$password'>\n";
	print "</td>\n";
	print "</tr>\n";
	print "<tr>\n";
	print "        <td width =\"163\">Last Name: </td>\n";
	print "        <td width=\"166\"> \n";
	print "          <input type=\"text\" name = \"LastName\" value='$lastname'>\n";
	print "</td>\n";
	print "</tr>";	
        print "<tr>\n";
        print "        <td width =\"163\">First Name: </td>\n";
        print "        <td width=\"166\"> \n";
        print "          <input type=\"text\" name = \"FirstName\" value='$firstname'>\n";
        print "</td>\n";
        print "</tr>";
	print "<tr>\n";
	print "        <td width = \"163\">Email:</td>\n";
	print "        <td width=\"166\"> \n";
	print "          <input type=\"text\" name = \"Email\" value='$email'>\n";
	print "</td>\n";
	print "</tr>\n";
	print "<tr>\n";
	print "        <td width = \"163\">Telephone: </td>\n";
	print "        <td width=\"166\"> \n";
	print "          <input type=\"text\" name = \"Telephone\" value='$tel'>\n";
	print "</td>\n";
	print "</tr>\n";
	print "<tr>\n";
	print "        <td width = \"163\">Department: </td>\n";
	print "        <td width=\"166\"> \n";
	print "          <input type=\"text\" name = \"Dept\" value='$dept'>\n";
	print "	</td>\n";
	print "</tr>\n";
	print "<tr>\n";
	print "			<td width = \"163\">Advisor: </td>\n";
	print "			<td width=\"166\"> \n";
	print "				<input type=\"text\" name = \"Advisor\" value='$advisor'>\n";
	#print "				<select name=\"Advisorlist\" id=\"Advisorlist\" onchange=\"OtherAdvisorClicked()\">";
	print "					";
	print "			</td>\n";
	print "</tr>\n";
    print "<tr>\n";
	print "			<td width = \"163\">Est. Graduation Year: </td>\n";
	print "			<td width=\"166\"> \n";
	print "				<input type=\"text\" name = \"GradYear\" value='$gradyear'>\n";
	print "			</td>\n";
	print "</tr>\n";
	
	
	print "<tr>\n";
	print "        <td width = \"163\">Est. Graduation Term: </td>\n";
	print "        <td width=\"166\"> \n";

	my $sprsel, $sumsel, $fallsel;

	if($gradterm eq "Spring") {
		$sprsel = "checked";
	}
	elsif($gradterm eq "Summer") {
		$sumsel = "checked";
	}
	elsif($gradterm eq "Fall") {
		$fallsel = "checked";
	}

	print "          <input type=\"radio\" name=\"GradTerm\" value=\"Spring\" $sprsel>Spring\n";
	print "          <input type=\"radio\" name=\"GradTerm\" value=\"Summer\" $sumsel>Summer\n";
	print "          <input type=\"radio\" name=\"GradTerm\" value=\"Fall\" $fallsel>Fall\n"; 
    print "</td>\n";
    print "</tr>\n";
	print "<tr>\n";
	print "        <td width=\"163\">User Access Rights: </td>\n";
	print "        <td width=\"300\"> \n";

	if($class eq 1)
	{
		print "          <input type=\"checkbox\" name=\"Class\" value=\"checkbox\" checked>Set this user as administrator\n";
	}
	else
	{
		print "          <input type=\"checkbox\" name=\"Class\" value=\"checkbox\" unchecked>Set this user as administrator\n";
	}		
	print "</td>\n";
	print "</tr>\n";
	
	print "<tr>\n";
	print "        <td width=\"163\" valign=\"top\">Instruments that can be used: </td>\n";
	print "        <td width=\"400\"> ";	
	print "        <table border=\"2\" width=\"100%\">\n";
	$instr_count = 0;

	while(($instrNo, $instrName)=$sth->fetchrow_array)
	{
		$instr_count += 1;
		print "    <tr>\n";
		print "       <td width=\"60%\">\n";
		for ($ii=0; $ii < $count_u; $ii++)
		{
			if ($instrNo_u[$ii] == $instrNo)
			{
				last;
			}
		}
		if ($ii == $count_u)
		{
			print "<input type=\"checkbox\" name=\"Instr$instr_count\" value=\"$instrNo\" unchecked onclick=\"change$instr_count()\">$instrName</td>";		
			print "<td>\n";
			print "Date: (mm/dd/yyyy)<br>";
			print "<input type=\"text\" name=\"MM_Instr$instr_count\" size=\"2\">/";
			print "<input type=\"text\" name=\"DD_Instr$instr_count\" size=\"2\">/";
			print "<input type=\"text\" name=\"YY_Instr$instr_count\" size=\"4\">";	
		}
		else
		{
			@ymn = split(/-/, $instrDate[$ii]);
			print "<input type=\"checkbox\" name=\"Instr$instr_count\" value=\"$instrNo\" checked onclick=\"change$instr_count()\">$instrName";		
			print "<td>\n";
			print "Date: (mm/dd/yyyy)<br>";
			print "<input type=\"text\" name=\"MM_Instr$instr_count\" value=\"$ymn[1]\" size=\"2\">/";
			print "<input type=\"text\" name=\"DD_Instr$instr_count\" value=\"$ymn[2]\" size=\"2\">/";
			print "<input type=\"text\" name=\"YY_Instr$instr_count\" value=\"$ymn[0]\" size=\"4\">";
		}
					
		print "</td>     </tr>\n";
	}
	print "</table>\n";
	print "</td>\n";
	print "</tr>\n";
	
	print "</table>\n";
	print "<input type=\"submit\" value=\"Submit\" align=center>\n";
	print "<input type=\"reset\"  value=\" Reset \">\n";
	print "<input type=\"hidden\" name=\"adminlogin\" value = \"$adminlogin\">\n";
	print "<input type=\"hidden\" name=\"SID\" value = \"$sid\">\n";
	print "<input type=\"hidden\" name=\"tag\" value = \"$username\">\n";
	print "<input type=\"hidden\" name=\"InstrNum\" value = \"$instr_count\">";	
	print "<input type=\"hidden\" name=\"old_email\" value = \"$email\">";
	print "<input type=\"hidden\" name=\"o_username\" value = \"$username\">";
	print "</form>\n";
	print "</center>\n";
        print "Notice: Fields marked with a * cannot be empty!\n";
	print "</body>\n";
	print "</html>\n";
}
else
{
	$db->disconnect;	
	print "Content-type: text/html\r\n\r\n";
	print "<body onload=\"Javascript:parent.location.replace('../index_alt.html')\">"; 		
	print "</body>\n";
	exit;
}

#$sth->finish; 
