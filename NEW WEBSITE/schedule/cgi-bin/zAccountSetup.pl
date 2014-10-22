#!/usr/bin/perl
use lib "/kunden/homepages/40/d209127057/htdocs/schedule/cgi-bin/";
use CGI qw/:standard/;
use CGI::kSession;
use DBI;
 
$dsn = "DBI:mysql:database=db260244667:host=db1661.perfora.net";
$db= DBI->connect($dsn, "dbo260244667", "curu11i");

	print "Content-type: text/html\r\n\r\n";
	print "<html>\n";
	print "<head>";
	print "<title>\n";
	print "New User Profile\n";
	print "</title>\n";

	print '<script type="text/javascript">';
	print 'var ins_counts = 0;';
	
		print ' function LimtCharacters(txtMsg, CharLength, indicator) {';
		print ' 	chars = txtMsg.value.length;';
		print ' 	document.getElementById(indicator).innerHTML = CharLength - chars;';
		print ' 	if (chars > CharLength) {';
		print ' 	txtMsg.value = txtMsg.value.substring(0, CharLength);';
 		print ' }';
		print ' }';
	
		print ' function checkCommentsOnFocus(commentsBox) {';
 	 	print ' 	if( commentsBox.value == \'Please enter comments\' ) ';
	  	print ' 			document.getElementById(\'Comments\').value = \'\'; ';
 		print ' }';
		
		print ' function checkCommentsOnBlur(commentsBox) {';
 	 	print ' 	if( commentsBox.value.length == 0 ) ';
	  	print ' 			document.getElementById(\'Comments\').value =  \'Please enter comments\'; ';
  		print ' }';
		
	print '</script>';

	#JEOL 100CX – TEM and Akashi 002B – TEM are not allowed to be registered for
	$sth = $db->prepare("select count(*) from instrument where InstrumentNo Not In (2, 4)");
	$sth->execute();
	$instr_count = $sth->fetchrow_array;

	$sth = $db->prepare("select InstrumentNo, InstrumentName from instrument where InstrumentNo Not In (2, 4)");
	$sth->execute();

	($dd, $mm, $yy)=(localtime)[3,4,5];
	$mm = $mm + 1;
	$yy = $yy + 1900;
	
	

	print "</head>";
	print "<link rel=\"stylesheet\" href=\"../css/masc.css\" type=\"text/css\">\n";
	
   	print "<body background=\"../_image/valtxtr.gif\">\n";
	#print "<center>\n";
	print "<div class=\"content\">";
	print "  <form method=post action=\"createNewUser.php\" onsubmit=\"return CheckBeforeSubmit();\" name=\"newuser\">\n";
	print "    <table class=\"content\" width='650' align=center border=\"0\">\n";
	# print "<tr>\n";
	
	# print "        <td width =\"163\">*Login Name: </td>\n";
	# print "        <td width=\"166\"> \n";
	# print "          <input type=\"text\" name = \"UserName\">\n";
	# print "</td>\n";
	# print "</tr>\n";
	# print "<tr>\n";
	# print "        <td width =\"163\">*Password: </td>\n";
	# print "        <td width=\"166\"> \n";
	# print "          <input type=\"password\" name = \"Passwd\">\n";
	# print "</td>\n";
	# print "</tr>\n";
	# print "<tr>\n";
	# print "        <td width =\"163\">*Retype password: </td>\n";
	# print "        <td width=\"166\"> \n";
	# print "          <input type=\"password\" name = \"cpassword\">\n";
	# print "</td>\n";
	# print "</tr>\n";

	
	print "<tr>\n\n";
	print "        <td width =\"163\">*1First Name: </td>\n";
	print "        <td width=\"450\"> \n";
	print "          <input type=\"text\" name = \"FirstName\" value='$firstname'>\n";
	print "</td>\n";  
	print "</tr>\n";  
	print "<tr>\n\n";
	print "        <td width =\"163\">*Last Name: </td>\n";  
	print "        <td width=\"450\"> \n";
	print "          <input type=\"text\" name = \"LastName\" value='$lastname'>\n";
	print "</td>\n";
	print "</tr>";  
	
	
	print "<tr>\n";
	print "        <td width = \"163\">*Email:</td>\n";
	print "        <td width=\"450\"> \n";
	print "          <input type=\"text\" name = \"Email\">\n";
	print "</td>\n";
	print "</tr>\n";
	print "<tr>\n";
	print "        <td width = \"163\">*Telephone: </td>\n";
	print "        <td width=\"450\"> \n";
	print "          ( <input type=\"text\" name = \"Telephone1\" size=\"3\" maxlength=\"3\" onKeyup=\"autotab(this,document.newuser.Telephone2)\" > ) \n";
	print "          - <input type=\"text\" name = \"Telephone2\" size=\"3\" maxlength=\"3\" onKeyup=\"autotab(this,document.newuser.Telephone3)\"  >\n";
	print "          - <input type=\"text\" name = \"Telephone3\" size=\"4\" maxlength=\"4\" >\n";
	print "</td>\n";
	print "</tr>\n";
 
 
	print "<tr>\n";
	print "        <td width = \"163\">*Department: </td>\n";
	print "        <td width=\"450\"> \n";
	print "          <input type=\"text\" name = \"Dept\">\n";
	print "	</td>\n";
	print "</tr>\n";
	
	print "</tr>\n";
	print "<tr>\n";
	print "        <td width = \"163\">*Account Number: </td>\n";
	print "        <td width=\"450\"> \n";
	print "           <input type=\"text\" name = \"AccountNum1\" size=\"2\" maxlength=\"2\" onKeyup=\"autotab(this,document.newuser.AccountNum2)\" >  \n";
	print "          - <input type=\"text\" name = \"AccountNum2\" size=\"4\" maxlength=\"4\" onKeyup=\"autotab(this,document.newuser.AccountNum3)\"  >\n";
	print "          - <input type=\"text\" name = \"AccountNum3\" size=\"4\" maxlength=\"4\" >\n";
	print "</td>\n";
	print "</tr>\n";

	
	#Advisor
	print "<tr>\n";
	print "        <td width = '20'>*10 Digit USC ID: </td>\n";
	print "        <td width='450'>";
	print '         <input type="radio" name="uscidradiobox" value="yes" onclick="calc(this);" >Yes
<input type="radio" name="uscidradiobox" value="no" onclick="calc(this);" >No ';
  
	print "          <input type=\"text\" name = 'uscbox' id = 'uscbox' style='display:none' >";
	print "	</td>";
	print "</tr>";	


	print "<tr>\n";
	print "        <td width = '20'>*Advisor: </td>\n";
	print "        <td width='450'>";
	print '          <select name="Advisorlist" id="Advisorlist" onchange="OtherAdvisorClicked()">';
	


	$dsn2 = "DBI:mysql:database=db260244667:host=db1661.perfora.net";
	$db2= DBI->connect($dsn2, "dbo260244667", "curu11i");
	$sth2 = $db2->prepare("select Customer_ID,Name  from  Customer WHERE Activated=1 ORDER BY Name ");
	$sth2->execute();
	#a
	
	$count = 0;
	
	print '<option value="Default" style="font-weight: bold" disabled="disabled" selected="selected">-- Select Advisor --</option>';
	while(($Customer_ID,$Name)=$sth2->fetchrow_array)
	{
	$count++;
	print '<option value="'.$Name.'">'.$Name.'</option>'; #onClick="OtherAdvisorClicked()"
	}
	print '<option value="New Advisor" style="font-weight: bold" >-new advisor-</option>';
	print '  </select>';
	#print "	</td>\n";

	#print "<td>\n";
	#print "        <td width='166' name = 'OtherAdvisorRow' id = 'OtherAdvisorRow' style='display:none'> \n";
	print "          <input type=\"text\" name = 'OtherAdvisor' id = 'OtherAdvisor' style='display:none' >";
	print "	</td>";
	print "</tr>";

	#print "<tr>\n";
	#print "        <td width = \"163\">*Est. Graduation Year: </td>\n";
	#print "        <td width=\"450\"> \n";
	#print "          <input type=\"text\" name = \"GradYear\" value='$gradyear'>\n";
	#print "</td>\n";
	#print "</tr>\n";
	
	print "<tr>\n";
	print "        <td width = \"163\">*Position: </td>\n";
	print "        <td width=\"450\"> \n";
	print "				<input type=\"radio\" name=\"Position\" id=\"pos_US\" value=\"US\">Undergraduate Student<br>";
	print "				<input type=\"radio\" name=\"Position\" id=\"pos_GS\" value=\"GS\">Graduate Student<br>";
	print "				<input type=\"radio\" name=\"Position\" id=\"pos_PD\" value=\"PD\">Post Doctor<br>";
	print "				<input type=\"radio\" name=\"Position\" id=\"pos_PI\" value=\"PI\">Principle Investigator<br>";
	print "</td>\n";
	print "</tr>\n";

        #print "<tr>\n";
      #  print "        <td width = \"163\">*Est. Graduation Semester: </td>\n";
       # print "        <td width=\"166\"> \n";

        #my $sprsel, $sumsel, $fallsel;
        
        #if($gradterm eq "Spring") {
        #        $sprsel = "checked";
        #}
        #elsif($gradterm eq "Summer") {
        #        $sumsel = "checked";
        #}
        #elsif($gradterm eq "Fall") {
        #        $fallsel = "checked";
        #}
        
        #print "          <input type=\"radio\" name=\"GradTerm\" value=\"Spring\" $sprsel>Spring\n";
        #print "          <input type=\"radio\" name=\"GradTerm\" value=\"Summer\" $sumsel>Summer\n";
        #print "          <input type=\"radio\" name=\"GradTerm\" value=\"Fall\" $fallsel>Fall\n";
        #print "</td>\n";
        #print "</tr>\n";

	print "<tr>\n";
#	print "        <td width=\"163\">User Access Rights: </td>\n";
#	print "        <td width=\"300\"> \n";
#	print "          <input type=\"checkbox\" name=\"Class\" value=\"checkbox\" unchecked>Set this user as administrator\n";
#	print "</td>\n";
#	print "</tr>\n";


	print "<tr>\n";
	print "        <td width = \"163\">*Field of Interest: </td>\n";
	print "        <td width=\"450\"> \n";
	
	#onclick=\"checkfieldofinterest()\"
	
	print "<input type=\"checkbox\" name=\"fieldofinterest[]\" value=\"Life Science\" unchecked id=\"life_science\"\>Life Science";		
	print "<input type=\"checkbox\" name=\"fieldofinterest[]\" value=\"Physical Science\" unchecked id=\"physical_science\"\>Physical Science";	
	print "	</td>\n";
	print "</tr>\n";
	
	print "<tr></tr>";
	
	print "<tr>\n";
	print "        <td width=\"163\" valign=\"top\">*Instruments that can be used: </td>\n";
	print "        <td width=\"400\"> ";	
	print "        <table border=\"2\" width=\"70%\">\n";
	$instr_count = 0;
	while(($instrNo, $instrName)=$sth->fetchrow_array)
	{
		$instr_count += 1;
		print '<script type="text/javascript">';
		print "ins_counts+=1;";
		print '</script>';
		
		print "    <tr>\n";
		print "       <td width=\"60%\">\n";
		
		#onclick=\"change$instr_count()
		
		print "<input type=\"checkbox\" name=\"InstrumentName[]\" value=\"$instrNo\" unchecked id=\"ins_$instr_count\"\>$instrName</td>";		
		# print "<td>\n";
		# print "Date: (mm/dd/yyyy)<br>";
		# print "<input type=\"text\" name=\"MM_Instr$instr_count\" size=\"2\">/";
		# print "<input type=\"text\" name=\"DD_Instr$instr_count\" size=\"2\">/";
		# print "<input type=\"text\" name=\"YY_Instr$instr_count\" size=\"4\">\n";	
		# print "</td>";
		print "</tr>\n";
	}
	print "</table>\n";
	print "</td>\n";
	print "</tr>\n\n";


	print "<tr>\n";
	print "        <td width = \"163\">Comments: </td>\n";
	print "        <td width=\"450\"> \n";
	print  "<TEXTAREA style='color:#808080' NAME='Comments' id='Comments' COLS=40 ROWS=10 onfocus=\"checkCommentsOnFocus(this);\"  onblur=\"checkCommentsOnBlur(this);\" onkeyup=\"LimtCharacters(this,200,'lblcount');\" wrap='physical'>Please enter comments</TEXTAREA>";
	print "	</td>\n";
	print "</tr>\n";

	print "<tr>\n";
	print "        <td></td>\n";
	print "        <td> You have <label id='lblcount' style='background-color:#E2EEF1;color:Red;font-weight:bold;'>200</label> Characters left in your Comments";
	print "	</td>\n";
	print "</tr>\n";
	
	#Captcha
	print "<tr>\n";
	print "		<td>Security Check:</td>\n";
	print "		<td><img src=\"captcha.php\"/><br/>
				<label>Enter result of expression</label>
				<input placeholder=\"Enter result here\" type=\"text\" name=\"captcha_code\" size=\"20\" maxlength=\"6\"/>
				</td></tr>\n";
#print "<td>refresh the page if you can't see the picture</td>";
	print "</tr>";

	print "</table>\n";
	print "</td>\n";
	print "</tr>\n";
		
	print "</table>\n";
	print "<center>\n";
	print "<input type=\"submit\" value=\"Submit\" align=center>\n";
	print "<input type=\"reset\"  value=\" Reset \">\n";
#	print "<input type=\"hidden\" name=\"adminlogin\" value = \"$adminlogin\">\n";
#	print "<input type=\"hidden\" name=\"SID\" value = \"$sid\">\n";
	print "<input type=\"hidden\" name=\"InstrNum\" value = \"$instr_count\">\n";
	print "</center>\n";
	print "</form>\n";
	
	print "<center>\n";
	print "Notice: Fields marked with a * cannot be empty!\n";
	print "</center>\n";
	print "</div>";
	print "</center>\n";
	print "</body>\n";
	
	
	
	
	
	
		print '<script type="text/javascript">';
	print 'String.prototype.trim = function() { return this.replace(/^\s+|\s+$/g, \'\'); };';
	
	print " function calc(radiobutton) { 
	  	 
	if(radiobutton.value=='yes') {
		 document.getElementById('uscbox').style.visibility='visbile'; 
		 document.getElementById('uscbox').style.display=''; 
		 document.getElementById('uscbox').value=''; 
	}else{
 		document.getElementById('uscbox').style.display='none';
	}
	
	print  }";
	
	print "function OtherAdvisorClicked() {";		
   
	print "var sel = document.getElementById('Advisorlist');";
	print "var name=sel.options[sel.selectedIndex].value;";

	print "if(name=='New Advisor')";
    print " { ";
    print "document.getElementById('OtherAdvisor').style.visibility='visbile';";
	print "document.getElementById('OtherAdvisor').style.display='';";
	print "document.getElementById('OtherAdvisor').value='';";
  	#print "document.getElementById('OtherAdvisor').style.visibility='visbile';";
	#print "document.getElementById('OtherAdvisor').style.display='';";
	print " } ";
	print " else ";
	print " { ";
	#print "document.getElementById('OtherAdvisorRow').style.visibility='hidden';";
	print "document.getElementById('OtherAdvisor').style.display='none';";
	print " } ";
	print " } ";
	
	
	#function to tab phone numbers on key press
	print "	function autotab(original,destination){	\n";
	print "	if (original.value.length==original.getAttribute(\"maxlength\"))	\n";
	print "		destination.focus();	\n";
 	print "	}	\n";
	
	#function CheckBeforeSubmit start
	print "function CheckBeforeSubmit(){\n";
	
 	print "	if( (document.getElementById('Comments').value.indexOf('www') > -1 )
				|| (document.getElementById('Comments').value.indexOf('http') > -1 ) )\n";
	print "	{\n";
	print "		alert(\" Please do not include Hyper Links in Comments\");\n";
	print "		return false;\n";
	print "	}\n";
	
  	
	print "	var pattern1 = /[\\w|\\w\-\\w]/;\n";
	#print " var pattern2 = /(^ *\\w+\@\\w+\\.\\w+ *?)/;";
	print " var pattern3 = /\\W/;\n";
	print "	var flag=true;\n";
  	print " var year=0;\n";
	print " var month=0;\n";
	print " var day=0;\n";
	print " var year_pattern = /^(\\d{4})\$/;\n";
	print " var month_pattern = /^(\\d{1,2})\$/;\n";

	# username
	# print "	if(document.newuser.UserName.value == \"\")\n";
	# print "	{\n";
	# print "		alert(\"Login name can not be empty\");\n";
	# print "		flag=false;\n";
	# print "	}\n";
	
	#Account Number
 
	print "	if(document.newuser.AccountNum1.value == \"\"
			|| document.newuser.AccountNum2.value == \"\" 
			|| document.newuser.AccountNum3.value == \"\"  )\n";
	print "	{\n";
	 print "		alert(\"Account Number can not be empty\");\n";
	print "		return false;\n";
	print "	}\n";
 	
	#email
	print "	if(document.newuser.Email.value == '' || document.newuser.Email.value.length==0 )\n";
	print "	{\n";
	 print "		alert(\"Email can not be empty\");\n";
	print "		return false;\n";
	print "	}\n";
	print " else {\n";
	print " 	document.newuser.Email.value = document.newuser.Email.value.trim();\n";
	print " }\n";
	#FirstName
	print "	if(document.newuser.FirstName.value == '')\n";
	print "	{\n";
	print "		alert(\"First Name can not be empty\");\n";
	print "		return false;\n";
	print "	}\n";
	print " else {\n";
	print " 	document.newuser.FirstName.value = document.newuser.FirstName.value.trim().replace(/\\s/g, '-');\n";
	print " }\n";
	#LastName
	print "	if(document.newuser.LastName.value == '')";
	print "	{\n";
	print "		alert(\"Last Name can not be empty\");\n";
	print "		return false;\n";
	print "	}\n";
	print " else {\n";
	print " 	document.newuser.LastName.value = document.newuser.LastName.value.trim().replace(/\\s/g, '-');\n";
	print " }\n";
	
	 
	#Advisor	
	print "	if(document.newuser.Advisorlist.value == \"Default\")\n";
	print "	{\n";
	print "		alert(\"Advisor can not be empty\");\n";
	print "		return false;\n";
	print "	}\n";
	
	#Position
	#print "alert((document.newuser.Position_US.checked==false && document.newuser.Position_GS.checked=false && document.newuser.Position_PD.checked==false && document.newuser.Position_PI.checked==false));\n";
	print "	if(document.getElementById(\"pos_US\").checked==false && document.getElementById(\"pos_GS\").checked==false && document.getElementById(\"pos_PD\").checked==false && document.getElementById(\"pos_PI\").checked==false)\n";
	print "	{\n";
	 print "		alert(\"Position can not be empty\");\n";
	print "		return false;\n";
	print "	}\n";
	
	#Telephone
	 print "	if( document.newuser.Telephone1.value == \"\"
	 			|| document.newuser.Telephone2.value == \"\"
				|| document.newuser.Telephone3.value == \"\" )\n";
	  print "	{\n";
	  print "		alert(\"Telephone can not be empty\");\n";
	 print "		return false;\n";
	 print "	}\n";
	#GradYear
	#print "	if(document.newuser.GradYear.value == \"\")\n";
	#print "	{\n";
	#print "		alert(\"GradYear can not be empty\");\n";
	#print "		flag=false;\n";
	#print "	}\n";
	#Dept
	print "	if(document.newuser.Dept.value == \"\")\n";
	print "	{\n";
	 print "		alert(\"Department can not be empty\");\n";
	print "		return false;\n";
	print "	}\n";
	
	
	print "	\nif(document.getElementById(\"life_science\").checked==false && document.getElementById(\"physical_science\").checked==false){";
	 print "		alert(\"Please select Field of Interest\");\n";
	print "		return false;\n";
	print "	}\n";

	print "if(flag==true){";
	print "for (var nn=1; nn <= ins_counts; nn++)";
	print "{";
	    print "if (document.getElementById('ins_'+nn).checked)\n";
	    print "{\n";
		print "flag = true; break;} else { flag = false;}";
	print "}}";
	
	print "if(flag==false)";
	print "alert(\"Select Instruments to Use!\");";
	
	
	
	print "		
			var fname = document.newuser.FirstName.value;
						var lname = document.newuser.LastName.value;
						var email = document.newuser.Email.value;

			var xmlhttp;	 
	 		if (window.XMLHttpRequest)	 
	  		 { 	 	
	  			 xmlhttp=new XMLHttpRequest(); 	
	 		 } 
 			 else	 
	 	 	 { 	 
	 			 xmlhttp=new ActiveXObject(\"Microsoft.XMLHTTP\");  
		 	 } \n  
  				xmlhttp.onreadystatechange=function()	{	
			 		
					if (xmlhttp.readyState==4 && xmlhttp.status==200) {
								
								if(xmlhttp.responseText==0){
									alert('All Good');
								}else if(xmlhttp.responseText==1){
									alert('User with FirstName, LastName and Email Exists');
								}else if(xmlhttp.responseText==2){
									alert('User with this Email Exists');
								}else if(xmlhttp.responseText==3){
									alert('User with FirstName LastName  Exists');
								}
						 }	 
 				 } \n 
		
		xmlhttp.open(\"GET\",\"http://cemma-usc.net/schedule/cgi-bin/validateCreateNewUser.php?fname=\"+fname+\"&lname=\"+lname+\"&email=\"+email,false);  \n 
		xmlhttp.send();	\n
		";
		
		
			print "	return false;\n";

	print "}\n";
  
		
		
	print "</script>\n";
	
	print "</html>";

# }

# $sth->finish; 
