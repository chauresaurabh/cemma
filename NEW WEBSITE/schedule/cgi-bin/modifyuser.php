<?
	if(!isset($_SESSION))
		session_start();
$dbhost="db948.perfora.net";
$dbname="db210021972";
$dbusername="dbo210021972";
$dbpass="XhYpxT5v";

$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
$SelectedDB = mysql_select_db($dbname) or die ("Error in Old DB");

$sid=$_GET["SID"];
$adminlogin=$_GET["adminlogin"];
$sth = mysql_query('select Passwd, Class, UserClass from user where UserName = \''.$adminlogin.'\'') or die(mysql_error());

$row = mysql_fetch_array($sth);
$passworddb=$row['Passwd']; $ClassAdmin=$row['Class']; $AdminUserClass=$row['UserClass'];

/*if ($row['UserClass'] == 4)
	{
		print "<h3><center>You have no right for this operation!</h3>\n";
		exit;
	}
*/	
	$sth = mysql_query("select count(1) from instrument");
	$instr_count = mysql_num_rows($sth);
	
	$username=$_GET["tag"];
	if ($row['UserClass'] == 4){
		$username=$adminlogin;
	}
	
	$sth = mysql_query('select Passwd, Class, Email, FirstName, LastName, Telephone, Dept, Advisor, GradYear, GradTerm, Position, FieldofInterest, LastStatusUpdate, Comments, MemberSince, UserClass, Prevent  from user where UserName = \''.$username.'\'') or die(mysql_error());
	
	$row=mysql_fetch_array($sth);
	$password=$row['Passwd']; $class=$row['Class']; $email=$row['Email']; $firstname=$row['FirstName']; $lastname=$row['LastName']; $tel=$row['Telephone']; $dept=$row['Dept']; $advisor=$row['Advisor']; $gradyear=$row['GradYear']; $gradterm=$row['GradTerm']; $Position =$row['Position'];$FieldofInterest=$row['FieldofInterest']; $LastStatusUpdate=$row['LastStatusUpdate'];$Comments=$row['Comments']; $MemberSince=$row['MemberSince']; $UserClass=$row['UserClass']; $prevent = $row['Prevent'];
	
	$sth = mysql_query("select InstrNo, InstrSigned, Permission from instr_group where Email = '$email'") or die(mysql_error);
	$instrNo_u = array(mysql_num_rows($sth));
	$instrDate = array(mysql_num_rows($sth));
	$permission = array(mysql_num_rows($sth));
	$count_u=0;
	while ( $row= mysql_fetch_array($sth))
	{
		array_push($instrNo_u,$row['InstrNo']);
		array_push($instrDate,$row['InstrSigned']);
		array_push($permission,$row['Permission']);
		$count_u ++;
	}

	print "<script>\n";

	print "var curr=1;";
	print "function check_button(id) {";
	
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
	$today = date("M-d-Y");
	print "var Today = '$today';";
	print "var advisorrr = '$advisor';";
	print "var usernameee = '$username';";
	print "var firstname = '$firstname';";
	print "var lastname = '$lastname';";

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
	if($ClassAdmin == 1){
		print "          <input type=\"text\" name = \"UserName\" value='$username'>\n";
	} else {
		print "          <input type=\"text\" name = \"UserName\" value='$username' style=\"background:#d6d3d3\" readonly>\n";
	}
	print "</td>\n";
	print "        <td width=\"266\">  \n";
	list($day, $year, $month) = split('/-/', $MemberSince);

	print "			<font color='black'><b>MEMBER Since: $month-$day-$year</b></font>";
	print "		   </td>\n";

	print "</tr>\n";
	print "<tr>\n";
	print "        <td width =\"163\">*Password: </td>\n";
	print "        <td width=\"166\"> \n";
	
	if($prevent == 1) {
		$preventChecked = 'checked';
		$disablePwdChange = 'readonly';
	} else {
		$preventChecked = '';
		$disablePwdChange = '';
	}
	
	if($AdminUserClass==1){
		print "          <input type=\"text\" name = \"Passwd\" value='$password'>\n";
	} else {
		print "          <input type=\"password\" name = \"Passwd\" value='$password' $disablePwdChange>\n";
	}
	
	if($AdminUserClass==1){
		print "&nbsp;&nbsp;<input type=\"checkbox\" name=\"prevent\" value=\"1\" $preventChecked>Prevent from changing password\n";
	}
	print "</td>\n";
	
	print "        <td rowspan=3 width=\"266\">  \n";
	#if($activeUser == 'inactive')
	#{
		print "			<font color='green'><b>USER IS ACTIVE</b></font>";
	#}
	#else
	#{	print "			<font color='red'><b>USER IS INACTIVE</b></font>";
	#}
	list($day, $year, $month) = split('/-/', $LastStatusUpdate);
	if($ClassAdmin == 1){
		print "				<br/><input type=\"checkbox\" name = \"inactivate1\" value='inactive'> In-Activate User\n";
	} else {
		print "				<br/><input type=\"checkbox\" name = \"inactivate1\" value='inactive' disabled='true'> In-Activate User\n";	
	}
	print "<br/><input type=\"hidden\" name = \"lastupdatestatus1\" value='$LastStatusUpdate'>Last Status Update:".$month."-".$day."-".$year;
	print "		   </td>\n";


	print "</tr>\n";
	print "<tr>\n";
	print "        <td width =\"163\">*Retype password: </td>\n";
	print "        <td width=\"166\"> \n";
	if($AdminUserClass==1){
		print "          <input type=\"text\" name = \"cpassword\" value='$password'>\n";
	} else {
		print "          <input type=\"password\" name = \"cpassword\" value='$password' $disablePwdChange>\n";
	}
	print "</td>\n";
	print "</tr>\n";
	print "<tr>\n";
	print "        <td width =\"163\">Last Name: </td>\n";
	print "        <td width=\"166\"> \n";
	if($ClassAdmin == 1){
		print "          <input type=\"text\" name = \"LastName\" value='$lastname'>\n";
	} else {
		print "          <input type=\"text\" name = \"LastName\" value='$lastname' readonly style=\"background:#d6d3d3\">\n";
	}
	print "</td>\n";
	print "</tr>";	
    print "<tr>\n";
    print "			<td width =\"163\">First Name: </td>\n";
    print "			<td width=\"166\"> \n";
	if($ClassAdmin == 1){
	    print "				<input type=\"text\" name = \"FirstName\" value='$firstname'>\n";
	} else {
		print "				<input type=\"text\" name = \"FirstName\" value='$firstname' readonly style=\"background:#d6d3d3\">\n";
	}
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
	print "			<td><input type='button' onclick='openViewPolicy()' value='Policies'/></td>";
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
	
	if($Position == 'US')		{	print "			<script>document.getElementById(\"pos_US\").checked=true;</script>";	}
	else if($Position == 'GS')	{	print "			<script>document.getElementById(\"pos_GS\").checked=true;</script>";	}
	else if($Position == 'PD')	{	print "			<script>document.getElementById(\"pos_PD\").checked=true;</script>";	}
	else if($Position == 'PI')	{	print "			<script>document.getElementById(\"pos_PI\").checked=true;</script>";	}

	if($UserClass != 4){
		print "<tr>\n";
		print "        <td width=\"163\">User Access Rights: </td>\n";
		print "        <td width=\"300\"> \n";
	
		if($class == 1)
		{
			if($ClassAdmin == 1){
				print "          <input type=\"checkbox\" name=\"Class\" value=\"checkbox\" checked>Set this user as administrator\n";
			} else {
				print "          <input type=\"checkbox\" name=\"Class\" readonly value=\"checkbox\" checked>Set this user as administrator\n";
			}
		}
		else
		{
			if($ClassAdmin == 1){
				print "          <input type=\"checkbox\" name=\"Class\" value=\"checkbox\" unchecked>Set this user as administrator\n";
			} else {
				print "          <input type=\"checkbox\" name=\"Class\" readonly value=\"checkbox\" unchecked>Set this user as administrator\n";		
			}
		}
		print "</td>\n";
		print "</tr>\n";
	}

	print "<tr>\n";
	if ($UserClass==2)
	{
		$selected2="selected";
	}
	if ($UserClass==3)
	{
		$selected3="selected";
	}
	if ($UserClass==4 || $UserClass == '')
	{
		$selected4="selected";
	}
	print "     <td width = \"163\">*Class Level: </td>\n";
	print "     <td width=\"166\"> \n";

/*	if($ClassAdmin == 1){
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
*/								if($ClassAdmin == 1){
									print '<select id="UserClass">';
								} else {
									print '<select id="UserClass" disabled>';
								}
								
								if ($_SESSION['ClassLevel']==1)
								{
									if($UserClass==1)
									{
										print '<option value="1" selected="selected">Administrator</option>';
								  		print '<input type="hidden" name="UserClass" value="1"/>';
									}
									else
									{
										print '<option value="1">Administrator</option>';
									}
								}

								if($UserClass==2)
								{
									print '<option value="2" selected="selected">Cemma Staff</option>';
									print '<option value="3">Super User</option>';
									print '<option value="4">User</option>';
								  print '<option value="5">Lab/Class</option>';
							  		print '</select>';
							  		print '<input type="hidden" name="UserClass" value="2"/>';
								} else if($UserClass==3) {
									print '<option value="2">Cemma Staff</option>';
									print '<option value="3" selected="selected">Super User</option>';
							  		print '<option value="4">User</option>';
								  print '<option value="5">Lab/Class</option>';
							  		print '</select>';
									print '<input type="hidden" name="UserClass" value="3"/>';
								} else if($UserClass==5) {
									print '<option value="2">Cemma Staff</option>';
									print '<option value="3">Super User</option>';
							  		print '<option value="4">User</option>';
								    print '<option value="5" selected="selected">Lab/Class</option>';
							  		print '</select>';
									print '<input type="hidden" name="UserClass" value="5"/>';
								} else {
									print '<option value="2">Cemma Staff</option>';
									print '<option value="3">Super User</option>';
									print '<option value="4" selected="selected">User</option>';
								  print '<option value="5">Lab/Class</option>';
							  		print '</select>';
							  		print '<input type="hidden" name="UserClass" value="4"/>';
								}

	print "		</td>\n";
	print "</tr>\n";

		$values = explode(",", $FieldofInterest);

  foreach($values as $val) {
    if($val == 'Life Science')
	  { $LifeSciencechecked='checked';
	  }
	if($val == 'Physical Science')
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
	print "        <td width=\"800\"> ";	
	print "        <table border=\"2\" width=\"100%\">\n";
	$instr_count = 0;
	
	$sql123 = "select * from instr_group where Email ='".$email."'";
	$result123=mysql_query($sql123) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 

	$i123=0;
	while($row123 = mysql_fetch_array($result123))
	{
		$instrnos123[$i123]=$row123['InstrNo'];
		$instrsigned123[$i123]=$row123['InstrSigned'];
		$permission123[$i123] = $row123['Permission'];
		$instDate123[$i123] = $row123['InstrSigned'];
		$i123++;
	}

	$sth = mysql_query("select InstrumentNo, InstrumentName from instrument") or die(mysql_error);
	
	while($row = mysql_fetch_array($sth)){
		$checked112='';
		$insddd = '';
		for($j123=0;$j123<$i123;$j123++)
		{
			if($row['InstrumentNo']==$instrnos123[$j123])
			{
				$checked112='checked';
				$insddd = $instDate123[$j123];
				break;
			}
		}

		$instr_count += 1;
		$instrNo = $row['InstrumentNo'];
		$instrName = $row['InstrumentName'];
		print "    <tr>\n";
		print "       <td width=\"450\">\n";
		
		for ($ii=0; $ii < $count_u; $ii++)
		{
			if ($instrNo_u[$ii] == $instrNo)
			{
				last;
			}
		}
		
		if ($ii == $count_u)
		{
			if($ClassAdmin == 1){
				if($checked112 == 'checked'){
					list($yearr,$monthr,$dayr) = split('[/.-]', $insddd);
					print "<input type='checkbox' value='".$instrNo."' ".$checked112."  onclick='change$instr_count()'>".$instrName."</td>";
					print "<input type='hidden' name='Instr$instr_count' value='".$instrNo."' />";
					print "<td>\n";
					print "Date: (mm/dd/yyyy)<br>";
					print "<input type='text' name='MM_Instr$instr_count' value='".$monthr."' size='1'/>/";
					print "<input type='text' name='DD_Instr$instr_count' value='".$dayr."' size='1'>/";
					print "<input type='text' name='YY_Instr$instr_count' value='".$yearr."' size='2'>";
				} else {
						print "<input type='checkbox' name='Instr$instr_count' value='".$instrNo."' ".$checked112."  onclick='change$instr_count()'/>".$instrName."</td>";
					print "<td>\n";
					print "Date: (mm/dd/yyyy)<br>";
					print "<input type='text' name='MM_Instr$instr_count' size='1'>/";
					print "<input type='text' name='DD_Instr$instr_count' size='1'>/";
					print "<input type='text' name='YY_Instr$instr_count' size='2'>";	
				}
			} else {
					if($checked112 == 'checked'){
						print "<input type='checkbox' value='$instrNo'  ".$checked112."   disabled onclick='change$instr_count()'>$instrName</td>";
						list($yearr,$monthr,$dayr) = split('[/.-]', $insddd);
						print "<input type='hidden' name='Instr$instr_count' value='".$instrNo."' />";
						print "<td>\n";
						print "Date: (mm/dd/yyyy)<br>";
						print "<input type='text' name='MM_Instr$instr_count' readonly value='".$monthr."' size='1'/>/";
						print "<input type='text' name='DD_Instr$instr_count' readonly value='".$dayr."' size='1'>/";
						print "<input type='text' name='YY_Instr$instr_count' readonly value='".$yearr."' size='2'>";
					}else {
						print "<input type='checkbox' name='Instr$instr_count' value='$instrNo'  ".$checked112."   disabled onclick='change$instr_count()'/>$instrName&nbsp;<input type='button' value='Request Training' onClick='requestTraining(\"$instrName\", \"$username\", \"$email\");'/></td>";
						print "<td>\n";
						print "Date: (mm/dd/yyyy)<br>";
						print "<input type='text' name='MM_Instr$instr_count' readonly size='1'>/";
						print "<input type='text' name='DD_Instr$instr_count' readonly size='1'>/";
						print "<input type='text' name='YY_Instr$instr_count' readonly size='2'>";				
					}
			}
		}
		else
		{
			list($year,$day,$month) = split('/-/', $instrDate[$ii]);
			if($ClassAdmin == 1){
				
				if($checked112 == 'checked'){
					print "<input type=\"checkbox\" value=\"$instrNo\"  ".$checked112."  onclick=\"change$instr_count()\">$instrName";
					print "<input type='hidden' name='Instr$instr_count' value='".$instrNo."' />";
				} else {
					print "<input type=\"checkbox\" name=\"Instr$instr_count\" value=\"$instrNo\"  ".$checked112."  onclick=\"change$instr_count()\">$instrName";
				}
				print "<td>\n";
				print "Date: (mm/dd/yyyy)<br>";
				print "<input type='text' name='MM_Instr$instr_count' value='".$month."' size='1'/>/";
				print "<input type='text' name='DD_Instr$instr_count' value='".$day."' size='1'>/";
				print "<input type='text' name='YY_Instr$instr_count' value='".$year."' size='2'>";
			} else {
				if($checked112 == 'checked'){
					print "<input type=\"checkbox\" value=\"$instrNo\"  ".$checked112."  disabled onclick=\"change$instr_count()\">$instrName";
					print "<input type='hidden' name='Instr$instr_count' value='".$instrNo."' />";
				} else {
					print "<input type=\"checkbox\" name=\"Instr$instr_count\" value=\"$instrNo\"  ".$checked112."  disabled onclick=\"change$instr_count()\">$instrName";
				}
				print "<td>\n";
				print "Date: (mm/dd/yyyy)<br>";
				print "<input type='text' name='MM_Instr$instr_count' readonly value='".$month."' size='1'/>/";
				print "<input type='text' name='DD_Instr$instr_count' readonly value='".$day."' size='1'>/";
				print "<input type='text' name='YY_Instr$instr_count' readonly value='".$year."' size='2'>";
			}
		}
		
		#print "#";
		#print $permission[$ii];
		#print "#";
		if($ClassAdmin == 1){
			print "	<select name='Permission_Instr$instr_count'>";
		} else {
			print "	<select name='Permission_Instr$instr_count' disabled>";
		}
		if($permission[$ii] == "Peak")
		{
			print "		<option value='Peak' selected='selected'>Peak time only</option>";
			#print "		<option value='Peak' selected='selected'>Do not use this yet</option>";
			print "		<option value='Off-Peak'>Peak & Off-peak time</option>";
		}
		else if($permission[$ii] == "Off-Peak")
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

		if($instr_count == 4) {
			if($AdminUserClass != 4){
				print "<td></td>";
			}
			print "<td><input type='button' id='manual_$instr_count' onClick='showManual(815)' value='Manual'/></td>";
		} else if($instr_count == 5){
			if($AdminUserClass != 4){
				print "<td><input type='button' value='Permit' id='permit_$instr_count' onClick='showPermit(\"JEOL JSM-7001 - SEM\")'/></td>";
			}
			print "<td><input type='button' id='manual_$instr_count' onClick='showManual(7001)' value='Manual'/></td>";
			
		} else if($instr_count == 6) {
			if($AdminUserClass != 4){
				print "<td><input type='button' value='Permit' id='permit_$instr_count' onClick='showPermit(\"JEOL JIB-4500 - FIB SEM\")'/></td>";
			}
			print "<td><input type='button' id='manual_$instr_count' onClick='showManual(4500)' value='Manual'/></td>";
		} else if($instr_count == 7) {
			if($AdminUserClass != 4){
				print "<td><input type='button' value='Permit' id='permit_$instr_count' onClick='showPermit(\"JEOL JSM-6610 - SEM\")'/></td>";
			}
			print "<td><input type='button' id='manual_$instr_count' onClick='showManual(6610)' value='Manual'/></td>";
		} else if($instr_count==8){
			if($AdminUserClass != 4){
					print "<td><input type='button' value='Permit' id='permit_$instr_count' onClick='showPermit(\"JEOL JEM-2100F\")'/></td>";
			}
			print "<td><input type='button' id='manual_$instr_count' onClick='showManual(2100)' value='Manual'/></td>";	
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
?>	
	<script type = "text/javascript">
	var req2;
	function openViewPolicy(){
 		if (window.XMLHttpRequest) {
						try {
							req2 = new XMLHttpRequest();
						} catch (e) {
							req2 = false;
						}
					} else if (window.ActiveXObject) {
						try {
							req2 = new ActiveXObject("Msxml2.XMLHTTP");
						} catch (e) {
							try {
								req2 = new ActiveXObject("Microsoft.XMLHTTP");
							} catch (e) {
								req2 = false;
							}
						}
					}
					if (req2) {
 
 					 req2.onreadystatechange = setPolicyData;
					 req2.open("GET", "../../cemma/testbed/loadPolicyData.php?loaduser="+'false'+"&firstname="+firstname+"&lastname="+lastname+"&advisor="+advisorrr, true);
						req2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
						req2.send("");
					} else {
						alert("Please enable Javascript");
					}
 		}	
		
		function setPolicyData(){
		if (req2.readyState == 4 && req2.status == 200) {
    			  var policyWindow=window.open('','',"scrollbars=1");
					policyWindow.document.write((req2.responseText).replace(/\\/g, '')); 
			}
		}
		
		var req;
		function showPermit(instrNum){
			if (window.XMLHttpRequest) {
						try {
							req = new XMLHttpRequest();
						} catch (e) {
							req = false;
						}
					} else if (window.ActiveXObject) {
						try {
							req = new ActiveXObject("Msxml2.XMLHTTP");
						} catch (e) {
							try {
								req = new ActiveXObject("Microsoft.XMLHTTP");
							} catch (e) {
								req = false;
							}
						}
					}
					if (req) {
						req.onreadystatechange = showPermitData;
						req.open("GET", "showPermit.php?instrNum="+instrNum, true);
						req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
						req.send("");
					} else {
						alert("Please enable Javascript");
					}
		}
	function showPermitData(){
		if (req.readyState == 4 && req.status == 200) {
						var doc = eval('(' + req.responseText + ')');
			
			
	var writeToMyWindow = "<b><center><span style='text-align:center;font-weight:700;font-size:22px;'>";
	writeToMyWindow += doc.title+"<br/>User\'s Permit</span></center><br/><br/>";
	writeToMyWindow += "<b>"+doc.para1+"</b><br/><br/>";

	writeToMyWindow += "<b>"+doc.para2+"</b>";
	
	writeToMyWindow += "<br/><br/><div><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+usernameee+"</span><span style='float:right'>"+advisorrr+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div><hr/>";
	writeToMyWindow += "<div><span style='float:left;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(User's name)</span><span style='float:right;'>(Advisor's name)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>";

	writeToMyWindow +="<br/><br/><table BORDER=1 RULES=NONE FRAME=BOX align='center'> ";
	writeToMyWindow +="<tr><td>Trainer Sign off:  <b><? echo $adminlogin?></b></td><td style='width:400px'></td></tr> ";
	writeToMyWindow +="</table>";
	
	writeToMyWindow +="<br/>Has passed the initial training course and is allowed to use the SEM during peak hours only (9:00 am - 4:30 pm M-F). ";
	writeToMyWindow +="<br/><br/><table BORDER=1 RULES=NONE FRAME=BOX align='center'> ";
	writeToMyWindow +="<tr><td colspan='4' align='center'>Peak Time Approval</td></tr>";
	writeToMyWindow +="<tr><td>Session 1:</td><td>______________________</td><td>Trainer Sign-off:</td><td>______________________</td></tr> ";
	writeToMyWindow +="<tr><td></td><td align='center'>(Date)</td></tr> ";
	writeToMyWindow +="<tr><td>Session 2:</td><td>______________________</td><td>Trainer Sign-off:</td><td>______________________</td></tr> ";
	writeToMyWindow +="<tr><td></td><td align='center'>(Date)</td></tr> ";
	writeToMyWindow +="<tr><td>Session 3:</td><td>______________________</td><td>Trainer Sign-off:</td><td>______________________</td></tr> ";
	writeToMyWindow +="<tr><td></td><td align='center'>(Date)</td></tr> ";
	writeToMyWindow +="</table> ";

	writeToMyWindow +="<br/><table BORDER=1 FRAME=BOX align='center'> ";
	writeToMyWindow +="<tr><td colspan='3' align='center'>Off-Peak Time Approval (5:00 pm - 9:00 am M-F, 24 hours for Sat and Sun):<br/>Fifteen (15) peak hours logged within a six (6) month period.</td></tr>";
	writeToMyWindow +="<tr><th align='center'>Date</th><th align='center'>Time</th><th align='center'>Total Hours</td></tr> ";
	writeToMyWindow +="<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr> ";
	writeToMyWindow +="<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr> ";
	writeToMyWindow +="<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr> ";
	writeToMyWindow +="</table>";

	writeToMyWindow +="<br/><table BORDER=1 RULES=NONE FRAME=BOX align='center'> ";
	writeToMyWindow +="<tr><td>OFF-PEAK Sign off:</td><td style='width:450px'></td></tr> ";
	writeToMyWindow +="</table><br/>";

	writeToMyWindow += Today;
	writeToMyWindow +="<span style='float:right'>Log-on User's Name: "+usernameee+"</span>";
	
	var myWindow=window.open('','JEOL JSM-7001F','menubar=yes,scrollbars=yes,width=700,height=900;');
	myWindow.document.write(writeToMyWindow);
		}
	}
	function requestTraining(instrName, userName, email){
		alert(instrName + " " + userName);
		if (window.XMLHttpRequest) {
						try {
							req = new XMLHttpRequest();
						} catch (e) {
							req = false;
						}
					} else if (window.ActiveXObject) {
						try {
							req = new ActiveXObject("Msxml2.XMLHTTP");
						} catch (e) {
							try {
								req = new ActiveXObject("Microsoft.XMLHTTP");
							} catch (e) {
								req = false;
							}
						}
					}
					if (req) {
						req.onreadystatechange = requestedTraining;
						req.open("GET", "requestTraining.php?instrName="+instrName+"&userName="+userName+"&email="+email, true);
						req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
						req.send("");
					} else {
						alert("Please enable Javascript");
					}
	}
	function requestedTraining(){
		if (req.readyState == 4 && req.status == 200) {
			alert("Training requested successfully");
		}
	}
	
	function showManual(manualNum){
		if(manualNum==6610){
			window.open('../docs/JSM_6610_V2.1.pdf', '_blank', 'fullscreen=no,location=no');
		} else if(manualNum==4500){
			var writeToMyWindow = "<center><b>Select one of the below manuals...</b><br/><br/><input type='button' onclick=\"window.open('../docs/FIB_JIB_4500_V_2.4.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='FIB JIB 4500'/></center><br/>";
			writeToMyWindow += "<center><input type='button' onclick=\"window.open('../docs/OmniProbe_lift_out_V_2.1.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='OmniProbe lift out'/></center><br/>";
			writeToMyWindow += "<center><input type='button' onclick=\"window.open('../docs/Omniprobe_tip_exchange.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='OmniProbe tip exchange'/></center><br/>";
			var myWindow=window.open('','FIB JIB-4500','menubar=yes,scrollbars=yes,width=700,height=200;');
			myWindow.document.write(writeToMyWindow);
		} else if(manualNum==815){
			var writeToMyWindow = "<center><b>Select one of the below manuals...</b><br/><br/><input type='button' onclick=\"window.open('../docs/SEM_Dehydrate.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='SEM Dehydrate'/></center><br/>";
			writeToMyWindow += "<center><input type='button' onclick=\"window.open('../docs/Tousimis_815_Critical_Point_Dryer.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='Tousimis 815 Critical Point Dryer'/></center><br/>";
			var myWindow=window.open('','Tousimis 815','menubar=yes,scrollbars=yes,width=700,height=200;');
			myWindow.document.write(writeToMyWindow);
		}
		else if(manualNum==7001){
			var writeToMyWindow = "<center><b>Select one of the below manuals...</b><br/><br/><input type='button' onclick=\"window.open('../docs/JSM_7001.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='JSM 7001 SEM'/></center><br/>";
			writeToMyWindow += "<center><input type='button' onclick=\"window.open('../docs/JEOL_7001_Backscatter_and_Low_Vacuum_V2.6.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='Backscatter and Low Vacuum'/></center><br/>";
			writeToMyWindow += "<center><input type='button' onclick=\"window.open('../docs/JEOL_7001_EDS_V2.6.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='JEOL EDS'/></center><br/>";
			writeToMyWindow += "<center><input type='button' onclick=\"window.open('../docs/JEOL_SEM_Consumables.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='JEOL SEM Consumables'/></center><br/>";
			writeToMyWindow += "<center><input type='button' onclick=\"window.open('../docs/EBSD_V_2.1.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='JEOL EBSD'/></center><br/>";
			var myWindow=window.open('','JEOL 7001 SEM','menubar=yes,scrollbars=yes,width=700,height=250;');
			myWindow.document.write(writeToMyWindow);
		} else if(manualNum==2100){
		//alert(manualNum);
			var writeToMyWindow = "<center><b>Select one of the below manuals...</b><br/><br/><input type='button' onclick=\"window.open('../docs/JEOL_2100_TEM_Start_up_and_alignment.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='JEOL 2100 TEM Start up and alignment'/></center><br/>";
			writeToMyWindow += "<center><input type='button' onclick=\"window.open('../docs/Single_tilt_Holder.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='Single-tilt Holder'/></center><br/>";
			writeToMyWindow += "<center><input type='button' onclick=\"window.open('../docs/JEOL_2100F_STEM.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='JEOL 2100F - STEM'/></center><br/>";
			writeToMyWindow += "<center><input type='button' onclick=\"window.open('../docs/JEOL_2100F_Diffraction.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='JEOL 2100F - Diffraction'/></center><br/>";
			var myWindow=window.open('','JEOL JSM-7001F','menubar=yes,scrollbars=yes,width=700,height=230;');
			myWindow.document.write(writeToMyWindow);
		}
	}
	</script>
<?	print "</html>\n";

mysql_close();	
?>