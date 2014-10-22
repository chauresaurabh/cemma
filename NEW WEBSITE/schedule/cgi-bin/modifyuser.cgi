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
	$sth = $db->prepare("select Passwd, Class, Email, FirstName, LastName, Telephone, Dept, Advisor, GradYear, GradTerm, Position, FieldofInterest, LastStatusUpdate, Comments, MemberSince, UserClass  from user where UserName = '$username'");
	$sth->execute();
	($password, $class, $email, $firstname, $lastname, $tel, $dept, $advisor, $gradyear, $gradterm, $Position ,$FieldofInterest, $LastStatusUpdate,$Comments, $MemberSince, $UserClass) = $sth->fetchrow_array();
	$db->disconnect;	
	$sth->finish();

	$sth = $db->prepare("select InstrNo, InstrSigned, Permission from instr_group where Email = '$email'");
	$sth->execute();
	$count_u = 0;

	while (($instrNo_u[$count_u], $instrDate[$count_u], $permission[$count_u]) = $sth->fetchrow_array)
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

	print "var curr=1;";
	print "function check_button(id) {";
	
	# if current users  expanded,id==0
	print "	 if(id == 0) {"; # minus clicked
	print "		 if(curr == 1) {"; #curr=1 means it is plus.
	print "			curr=0;";
	print "			document.getElementById('showImg' + id).src = '../_image/minus.gif';";
	print "			document.getElementById('comments').style.display='block';";
	print "		}";
	print "		else {";
	print "			curr=1;";
	print "			document.getElementById('showImg' + id).src = '../_image/plus.gif';";
	print "			document.getElementById('comments').style.display='none';";
	print "		}";
	print "   }";
	print " }";


	print "function CheckBeforeSubmit(){\n";
	#print "alert(document.newuser.Position.value);";
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
	print 'function showPermit(instruNum){';
	print '	if(instruNum==5){';
	print "\n		myWindow=window.open(\'\',\'JEOL JSM-7001F\',\'scrollbars=yes,width=700,height=1000\');";
	print "\n		var writeToMyWindow = \"<b><center><span style='text-align:center;font-weight:700;font-size:22px;'>\";";
	print "\n		writeToMyWindow += \"JEOL JSM-7001F Scanning Electron Microscope User\'s Permit</span></center><br/><br/>\";";
	print "\n		writeToMyWindow += \"<b>Welcome to the SEM beginner period. Sign off of your first three (3) sessions is mandatory \";";
	print "\n		writeToMyWindow += \"for the continued use of this instrument. For use of the instrument during off-peak hours the user \";";
	print "\n		writeToMyWindow += \"will have to complete addition fifteen (15) peak hours within a six (6) month period.</b><br/><br/>\";";

	print "\n		writeToMyWindow += \"<a style='position:fixed;top:2px;right:2px;' href='Javascript:self.print()'><b>PRINT</b></a>\";";

	print "\n		writeToMyWindow += \"<b>For the first three (3) sessions, a trainer must observe you loading and unloading your sample.</b>\";";
	print "\n		writeToMyWindow += \"<i><span style='font-weight:500'> It is your responsibility to inform one of the trainers of your session and make sure someone can attend at the beginning and end of the SEM usage</span></i>.\";";

	print "\n		writeToMyWindow += \"<b> Please be responsible about this policy. Failure to receive this follow-up check will result in your SEM privileges													being revoked.</b>\";";
	
	print "\n		writeToMyWindow += \"<br/><br/><div><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$username</span><span style='float:right'>$advisor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div><hr/>\";";
	print "\n		writeToMyWindow += \"<div><span style='float:left;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(User's name)</span><span style='float:right;'>(Advisor's name)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>\";";

	print "\n		writeToMyWindow +=\"<br/><br/>Trained by: $adminlogin \";";
	print "\n		writeToMyWindow +=\"<br/><br/>Has passed the initial training course and is allowed to use the SEM during peak hours only (9:00 am – 4:30 pm M-F). \";";
	print "\n		writeToMyWindow +=\"<br/><br/><table BORDER=1 RULES=NONE FRAME=BOX align='center'> \";";
	print "\n		writeToMyWindow +=\"<tr><td colspan='4' align='center'>Peak Time Approval</td></tr>\";";
	print "\n		writeToMyWindow +=\"<tr><td>Session 1:</td><td>______________________</td><td>Trainer Sign-off:</td><td>______________________</td></tr> \";";
	print "\n		writeToMyWindow +=\"<tr><td></td><td align='center'>(Date)</td></tr> \";";
	print "\n		writeToMyWindow +=\"<tr><td>Session 2:</td><td>______________________</td><td>Trainer Sign-off:</td><td>______________________</td></tr> \";";
	print "\n		writeToMyWindow +=\"<tr><td></td><td align='center'>(Date)</td></tr> \";";
	print "\n		writeToMyWindow +=\"<tr><td>Session 3:</td><td>______________________</td><td>Trainer Sign-off:</td><td>______________________</td></tr> \";";
	print "\n		writeToMyWindow +=\"<tr><td></td><td align='center'>(Date)</td></tr> \";";
	print "\n		writeToMyWindow +=\"</table> \";";

	print "\n		writeToMyWindow +=\"<br/><br/><table BORDER=1 FRAME=BOX align='center'> \";";
	print "\n		writeToMyWindow +=\"<tr><td colspan='3' align='center'>Off-Peak Time Approval (5:00 pm – 9:00 am M-F, 24 hours for Sat and Sun):<br/>Fifteen (15) peak hours logged within a six (6) month period.</td></tr>\";";
	print "\n		writeToMyWindow +=\"<tr><th align='center'>Date</th><th align='center'>Time</th><th align='center'>Total Hours</td></tr> \";";
	print "\n		writeToMyWindow +=\"<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr> \";";
	print "\n		writeToMyWindow +=\"<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr> \";";
	print "\n		writeToMyWindow +=\"<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr> \";";
	print "\n		writeToMyWindow +=\"<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr> \";";
	print "\n		writeToMyWindow +=\"<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr> \";";
	print "\n		writeToMyWindow +=\"</table><br/>\";";

	my($day, $month, $year)=(localtime)[3,4,5];

	print "\n		writeToMyWindow += \"$day/".($month+1)."/".($year+1900)."\";";
	print "\n		writeToMyWindow +=\"<span style='float:right'>Log-on User's Name:$username</span>\";";
	
	print "\n		writeToMyWindow +=\"<b><center><span style='page-break-before: always;font-weight:700;font-size:22px;'>\";";
	print "\n		writeToMyWindow += \"JEOL JSM-7001F Scanning Electron Microscope User\'s Permit</span></center><br/>\";";
	print "\n		writeToMyWindow +=\"<br/><table BORDER=1 RULES=NONE FRAME=BOX align='center'> \";";
	print "\n		writeToMyWindow +=\"<tr><td>Trainer Sign-off:</td><td style='width:450px'></td></tr> \";";
	print "\n		writeToMyWindow +=\"</table> \";";
	print "\n		writeToMyWindow +=\"<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>\";";

	print "\n		writeToMyWindow += \"$day-".($month+1)."-".($year+1900)."\";";
	print "\n		writeToMyWindow +=\"<span style='float:right'>Log-on User's Name:$username</span>\";";

	print "\n		myWindow.document.write(writeToMyWindow);";
	print "\n	}";
	print "\n}";
	
	print "</script>\n";
	print "<html>\n";
	
	print "<title>\n";
	print "Modify User Profile\n";
	print "</title>\n";
	print "<h2><center>Modify User Profile</center></h2><center>\n";
   	print "<body background=\"../_image/valtxtr.gif\">\n";
	print "  <form method=post action=\"modifyuserdata.cgi\" onsubmit=\"return CheckBeforeSubmit()\" name=\"newuser\">\n";
	print "    <table  align=center>\n";
	print "<tr>\n";
	print "        <td width =\"163\">*Login Name: </td>\n";
	print "        <td width=\"166\"> \n";


	if($ClassAdmin eq 1){
		print "          <input type=\"text\" name = \"UserName\" value='$username'>\n";
	} else {
		print "          <input type=\"text\" name = \"UserName\" value='$username' disabled='true'>\n";
	}
	print "</td>\n";
	
	print "        <td width=\"266\">  \n";
	@ymn = split(/-/, $MemberSince);

	print "			<font color='black'><b>MEMBER Since: $ymn[1]-$ymn[2]-$ymn[0]</b></font>";
	print "		   </td>\n";

	print "</tr>\n";
	print "<tr>\n";
	print "        <td width =\"163\">*Password: </td>\n";
	print "        <td width=\"166\"> \n";
	print "          <input type=\"password\" name = \"Passwd\" value='$password'>\n";
	print "</td>\n";
	
	print "        <td rowspan=3 width=\"266\">  \n";
	#if($activeUser eq 'inactive')
	#{
		print "			<font color='green'><b>USER IS ACTIVE</b></font>";
	#}
	#else
	#{	print "			<font color='red'><b>USER IS INACTIVE</b></font>";
	#}
	@ymn2 = split(/-/, $LastStatusUpdate);
	if($ClassAdmin eq 1){
		print "				<br/><input type=\"checkbox\" name = \"inactivate1\" value='inactive'> In-Activate User\n";
	} else {
		print "				<br/><input type=\"checkbox\" name = \"inactivate1\" value='inactive' disabled='true'> In-Activate User\n";	
	}
	print "				<br/><input type=\"hidden\" name = \"lastupdatestatus1\" value='$LastStatusUpdate'>Last Status Update: $ymn2[1]-$ymn2[2]-$ymn2[0]";
	print "		   </td>\n";


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
    print "			<td width =\"163\">First Name: </td>\n";
    print "			<td width=\"166\"> \n";
    print "				<input type=\"text\" name = \"FirstName\" value='$firstname'>\n";
    print "			</td>\n";
	print "			<td width=\"166\">";
	print "<img id ='showImg0' src='../_image/plus.gif' onmouseover=\" if (curr==1){ document.showImg0.src='../_image/plus-red.gif' } else {document.showImg0.src='../_image/minus-red.gif'}\" onmouseout=\"  if (curr==1){ document.showImg0.src='../_image/plus.gif' } else {document.showImg0.src='../_image/minus.gif'} \" style='vertical-align:middle;cursor:pointer;padding:0px 15px 0px 5px' onClick ='check_button(0)' >";
	print "			Comments:";
	print "			</td>";
    print "</tr>";
		
	#print "<tr>\n";
	#print "		<td>\n";
	print "			<tr>\n";
	print "				<td width = \"163\">Email:</td>";
	print "				<td width=\"166\"> ";
	print "				<input type=\"text\" name = \"Email\" value='$email'>";
	print "				</td>";

	#print "			<div id=\"commentsdiv\" style=\"display:none\" align=\"center\">";
	print "			<td id=\"comments\" rowspan=2 style=\"display:none\" width=\"166\">";
	print "				<TEXTAREA name='Comments' COLS=30 ROWS=3 wrap='physical' value='$Comments'>$Comments</TEXTAREA>";
	#print "				<br/><input type=\"checkbox\" name = \"inactivate1\" value='inactive'> In-Activate User\n";
	#print "				<br/><input type=\"hidden\" name = \"lastupdatestatus1\" value='$LastStatusUpdate'>Last Status Update: $ymn2[1]-$ymn2[2]-$ymn2[0]";
	
	print "			</td>";
	#print "			</div>";

	print "			</tr>";
	print "			<tr>";
	print "				<td width = \"163\">Telephone: </td>";
	print "			   <td width=\"166\">";
	print "				<input type=\"text\" name = \"Telephone\" value='$tel'>";
	print "				</td>";
	print "			</tr>";
	print "			<tr>\n";
	print "				<td width = \"163\">Department: </td>\n";
	print "				<td width=\"166\"> \n";
	print "				<input type=\"text\" name = \"Dept\" value='$dept'>\n";
	print "				</td>\n";
	print "			</tr>\n";

	print "			<tr>\n";
	print "				<td width = \"163\">Advisor: </td>\n";
	print "				<td width=\"166\"> \n";
	print "				<input type=\"text\" name = \"Advisor\" value='$advisor'>\n";
	print "				</td>\n";
	print "			</tr>\n";
	#print "		</td>\n";

#	print "		<td><tr>\n";
#	print "        <td width = \"163\">Comments: </td>\n";
#	print "			<td width=\"166\"> \n";
#	print "				<TEXTAREA NAME='Comments' COLS=40 ROWS=6 wrap='physical' value='$Comments'>$Comments</TEXTAREA>";
#	print "			</td>\n";
#	print "		</tr></td>\n";
	#print "</tr>\n";

	print "<tr>\n";
    #print "        <td width = \"163\">Est. Graduation Year: </td>\n";
    #print "        <td width=\"166\"> \n";
    #print "          <input type=\"text\" name = \"GradYear\" value='$gradyear'>\n";
    #print "			</td>\n";
	
	print "        <td width = \"163\">*Position: </td>\n";
	print "        <td width=\"450\"> \n";
	print "			<input type=\"radio\" name=\"Position\" id=\"pos_US\" value=\"US\">Undergraduate Student<br>";
	print "			<input type=\"radio\" name=\"Position\" id=\"pos_GS\" value=\"GS\">Graduate Student<br>";
	print "			<input type=\"radio\" name=\"Position\" id=\"pos_PD\" value=\"PD\">Post Doctor<br>";
	print "			<input type=\"radio\" name=\"Position\" id=\"pos_PI\" value=\"PI\">Private Investigator<br>";
	print "</td>\n";
    print "</tr>\n";
	
	if($Position eq 'US')		{	print "			<script>document.getElementById(\"pos_US\").checked=true;</script>";	}
	elsif($Position eq 'GS')	{	print "			<script>document.getElementById(\"pos_GS\").checked=true;</script>";	}
	elsif($Position eq 'PD')	{	print "			<script>document.getElementById(\"pos_PD\").checked=true;</script>";	}
	elsif($Position eq 'PI')	{	print "			<script>document.getElementById(\"pos_PI\").checked=true;</script>";	}

	#my $sprsel, $sumsel, $fallsel;

#	if($gradterm eq "Spring") {
#		$sprsel = "checked";
#	}
#	elsif($gradterm eq "Summer") {
#		$sumsel = "checked";
#	}
#	elsif($gradterm eq "Fall") {
#		$fallsel = "checked";
#	}

 #       print "          <input type=\"radio\" name=\"GradTerm\" value=\"Spring\" $sprsel>Spring\n";
#	print "          <input type=\"radio\" name=\"GradTerm\" value=\"Summer\" $sumsel>Summer\n";
#	print "          <input type=\"radio\" name=\"GradTerm\" value=\"Fall\" $fallsel>Fall\n"; 
 #       print "</td>\n";
  #      print "</tr>\n";
	print "<tr>\n";
	print "        <td width=\"163\">User Access Rights: </td>\n";
	print "        <td width=\"300\"> \n";

	if($class eq 1)
	{
		if($ClassAdmin eq 1){
			print "          <input type=\"checkbox\" name=\"Class\" value=\"checkbox\" checked>Set this user as administrator\n";
		} else {
			print "          <input type=\"checkbox\" name=\"Class\" disabled='true' value=\"checkbox\" checked>Set this user as administrator\n";
		}
	}
	else
	{
		if($ClassAdmin eq 1){
			print "          <input type=\"checkbox\" name=\"Class\" value=\"checkbox\" unchecked>Set this user as administrator\n";
		} else {
			print "          <input type=\"checkbox\" name=\"Class\" disabled='true' value=\"checkbox\" unchecked>Set this user as administrator\n";		
		}
	}		
	print "</td>\n";
	print "</tr>\n";

	print "<tr>\n";
	if ($UserClass==2)
	{
		$selected2="selected";
	}
	if ($UserClass==3)
	{
		$selected3="selected";
	}
	if ($UserClass==4 || $UserClass eq '')
	{
		$selected4="selected";
	}
	print "     <td width = \"163\">*Class Level: </td>\n";
	print "     <td width=\"166\"> \n";

	if($ClassAdmin eq 1){
		print '			<select name="userclasslist" id="userclasslist" onchange="">';
		print '				<option value="2" '.$selected2.'>Admin</option>';
		print '				<option value="3" '.$selected3.'>Super-User</option>';
		print '				<option value="4" '.$selected4.'>User</option>';
		print '			</select>';
	} else {
		print '			<select name="userclasslist" id="userclasslist" disabled onchange="">';
		print '				<option value="2" '.$selected2.'>Admin</option>';
		print '				<option value="3" '.$selected3.'>Super-User</option>';
		print '				<option value="4" '.$selected4.'>User</option>';
		print '			</select>';
	}

	print "		</td>\n";
	print "</tr>\n";


	my @values = split(',', $FieldofInterest);

  foreach my $val (@values) {
    if($val eq 'Life Science')
	  { $LifeSciencechecked='checked';
	  }
	if($val eq 'Physical Science')
	  { $PhysicalSciencechecked='checked';
	  }
  }
	print "<tr>\n";
	print "        <td width = \"163\">*Field of Interest: </td>\n";
	print "        <td width=\"166\"> \n";
	print "<input type=\"checkbox\" name=\"fieldofinterest\" value=\"Life Science\" $LifeSciencechecked onclick=\"\">Life Science";		
	print "<input type=\"checkbox\" name=\"fieldofinterest\" value=\"Physical Science\" $PhysicalSciencechecked onclick=\"\">Physical Science";	
	print "	</td>\n";
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
			if($ClassAdmin eq 1){
					print "<input type=\"checkbox\" name=\"Instr$instr_count\" value=\"$instrNo\" unchecked onclick=\"change$instr_count()\">$instrName</td>";		
					print "<td>\n";
					print "Date: (mm/dd/yyyy)<br>";
					print "<input type=\"text\" name=\"MM_Instr$instr_count\" size=\"1\">/";
					print "<input type=\"text\" name=\"DD_Instr$instr_count\" size=\"1\">/";
					print "<input type=\"text\" name=\"YY_Instr$instr_count\" size=\"2\">";	
			} else {
					print "<input type=\"checkbox\" name=\"Instr$instr_count\" value=\"$instrNo\" unchecked  disabled onclick=\"change$instr_count()\">$instrName</td>";		
					print "<td>\n";
					print "Date: (mm/dd/yyyy)<br>";
					print "<input type=\"text\" name=\"MM_Instr$instr_count\" disabled='true' size=\"1\">/";
					print "<input type=\"text\" name=\"DD_Instr$instr_count\" disabled='true' size=\"1\">/";
					print "<input type=\"text\" name=\"YY_Instr$instr_count\" disabled='true' size=\"2\">";				
			}
		}
		else
		{
			@ymn = split(/-/, $instrDate[$ii]);
			if($ClassAdmin eq 1){
				print "<input type=\"checkbox\" name=\"Instr$instr_count\" value=\"$instrNo\" checked onclick=\"change$instr_count()\">$instrName";		
				print "<td>\n";
				print "Date: (mm/dd/yyyy)<br>";
				print "<input type=\"text\" name=\"MM_Instr$instr_count\" value=\"$ymn[1]\" size=\"1\">/";
				print "<input type=\"text\" name=\"DD_Instr$instr_count\" value=\"$ymn[2]\" size=\"1\">/";
				print "<input type=\"text\" name=\"YY_Instr$instr_count\" value=\"$ymn[0]\" size=\"2\">";
			} else {
				print "<input type=\"checkbox\" name=\"Instr$instr_count\" value=\"$instrNo\" checked disabled onclick=\"change$instr_count()\">$instrName";		
				print "<td>\n";
				print "Date: (mm/dd/yyyy)<br>";
				print "<input type=\"text\" name=\"MM_Instr$instr_count\" disabled='true' value=\"$ymn[1]\" size=\"1\">/";
				print "<input type=\"text\" name=\"DD_Instr$instr_count\" disabled='true' value=\"$ymn[2]\" size=\"1\">/";
				print "<input type=\"text\" name=\"YY_Instr$instr_count\" disabled='true' value=\"$ymn[0]\" size=\"2\">";
			}
		}
		
		#print "#";
		#print $permission[$ii];
		#print "#";
		if($ClassAdmin eq 1){
			print "	<select name='Permission_Instr$instr_count'>";
		} else {
			print "	<select name='Permission_Instr$instr_count' disabled>";
		}
		if($permission[$ii] eq "Peak")
		{
			print "		<option value='Peak' selected='selected'>Peak time only</option>";
			#print "		<option value='Peak' selected='selected'>Do not use this yet</option>";
			print "		<option value='Off-Peak'>Peak & Off-peak time</option>";
		}
		elsif($permission[$ii] eq "Off-Peak")
		{
			print "		<option value='Peak'>Peak time only</option>";
			print "		<option value='Off-Peak' selected='selected'>Peak & Off-peak time</option>";
			#print "		<option value='Peak' selected='selected'>Do not use this yet</option>";
		}
		else
		{
			print "		<option value='Peak'>Peak time only</option>";
			print "		<option value='Off-Peak'>Peak & Off-peak time</option>";
			#print "		<option value='Peak' selected='selected'>Do not use this yet</option>";
		}
		print "	</select>";
		
		print "</td>";
		
		if($instr_count eq 5){
			if($ClassAdmin eq 1){
				#<form method="post" action="showPermit.php">
				print "<td><input type='button' value='Permit' id='permit_$instr_count' onClick='showPermit($instr_count)'/></td>";
				print "<td><a href=\"#\" onclick=\"window.open('../docs/JSM_7001.pdf', '_blank', 'fullscreen=no,location=no'); return false;\">Manual</a>";

				#print "<td><input type='button' id='manual_$instr_count' onClick='showManual(\'manual_$instr_count\')' value='Manual'/></td>";
			}
		}
		print "</td></tr>\n";
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
