#!/usr/bin/perl
use lib "/kunden/homepages/40/d209127057/htdocs/schedule/cgi-bin/";
use CGI qw/:standard/;
use CGI::kSession;
use DBI;
use Date::Business;
require 'enmonth.pl';
require 'enweekday.pl';

#---------------------------------------------------------------------------------
# Instrument sign up form. Allows user to book time on an instrument.
#---------------------------------------------------------------------------------

$dsn = "DBI:mysql:database=db210021972:host=db948.perfora.net";
$db= DBI->connect($dsn, "dbo210021972", "XhYpxT5v");

my $s = new CGI::kSession(lifetime=>900, path=>"../../var/session/",id=>param("SID"));
$sid=$s->id();
$s->start();
$login=param("login");
$spassword=$s->get("$login");
$sth = $db->prepare("select Passwd, Class, UserClass, Email from user where UserName = '$login'");
$sth->execute();
($passworddb, $ClassAdmin, $UserClass, $Email) = $sth->fetchrow_array();
$sth->finish();



if($spassword eq $passworddb)
{
	$instr_name = param("InstrName");
	$offset = param("week");

	($day, $month, $year)=(localtime)[3,4,5];
	if($day<10){$this_day='0'."$day"; }else{$this_day=$day;}
	$current_year = $year+1900;	
	$month += 1;
	if($month<10){$this_month='0'."$month"; }else{$this_month=$month;}
	$date = "$current_year"."$this_month"."$this_day";
	$nowdate = $date;
	#print "$date";
	$d = new Date::Business(DATE => "$date");
	$d->add($offset);

	$date1 = $d->image();
	$d->add(7);
	$date2 = $d->image();
	$d->sub(1);
	$date3 = $d->image();
	$d->sub(6);

	

	print "Content-type: text/html\r\n\r\n\n";
	print "<script>\n\n";
	print "function CheckBeforeSubmit(){\n\n";
	print "	var flag=true;\n\n";
	print " var count=0;\n\n";
	print " var count1=0;\n\n";

	if( ($instr_name eq "JEOL JIB-4500 - FIB SEM") and ($login ne "John") )
	{
		for ($daycount=0; $daycount < 7; $daycount++)
		{
			print "/*====== DAY#: ".$daycount." ======*/\n";
			print " var count_peak_day".$daycount."=0;\n";
			print " var count_offpeak_day".$daycount."=0;\n";

			for ($i = 0; $i < 12; $i++)
			{
				$slotname = "slot"."$daycount"."_"."$i";
				#if Off-Peak time:
				if(($i > 8) || ($daycount == 5) || ($daycount == 6) || ($i < 2))
				{
					print " if (document.signup.$slotname.checked) { ";
					print "count_offpeak_day".$daycount." += 1; }\n";
				}
				else
				{
					print " if (document.signup.$slotname.checked) { ";
					print "count_peak_day".$daycount." += 1; }\n";
				}
			}
			
			print " if (count_peak_day".$daycount." > 4) {\n";
			#print "  alert(\"No more than 4hrs(blocks) of peak time in a day!".$daycount."\");\n";
			print "  alert(\"No more than 4hrs(blocks) of peak time in a day!\");\n";
			print "  return false;\n";
			print " }\n";
			
			print " if (count_offpeak_day".$daycount." > 6) {\n";
			#print "  alert(\"No more than 6hrs(blocks) of off-peak time in a day!".$daycount."\");\n";
			print "  alert(\"No more than 6hrs(blocks) of off-peak time in a day!\");\n";
			print "  return false;\n";
			print " }\n";
			
			print "  count+=count_peak_day".$daycount.";";
			print "  count+=count_offpeak_day".$daycount.";";
			
			print "\n";
		}
	}
	else
	{
		for ($daycount=0; $daycount < 7; $daycount++)
		{
			for ($i = 0; $i < 12; $i++)
			{
				$slotname = "slot"."$daycount"."_"."$i";
				print " if (document.signup.$slotname.checked)	";
				print " {";
				print "  count+=1;";
				print " }\n";
			}
		}
	}

	# query the instrument number
	$sth = $db->prepare("SELECT InstrumentNo FROM instrument WHERE InstrumentName ='".$instr_name."'");
	$sth->execute();
	$instr_no=$sth->fetchrow_array;
	
	# query the user's permission of the instrument
	$sth = $db->prepare("SELECT Permission FROM instr_group WHERE Email ='".$Email."' AND InstrNo=".$instr_no."");
	$sth->execute();
	$permission=$sth->fetchrow_array;
	
	#if ($ClassAdmin eq 2)
	#{
	#	print " if (count > 4)\n";
	#	print " {\n";
	#	print "      	alert(\"Up to 4 blocks in peak time can be selected!\");\n";
	#	print "		flag=false;\n";
	#	print " }\n";
	#
	#	print " if (count1>8)\n";
	#	print " {\n";
	#	print "      	alert(\"Up to 8 blocks in off-peak time can be selected!\");\n";
	#	print "		flag=false;\n";
	#	print " }\n";
	#}

	#print "alert(count_peak_day0+'|'+count_peak_day1+'|'+count_peak_day2+'|'+count_peak_day3+'|'+count_peak_day4+'|'+count_peak_day5+'|'+count_peak_day6);";
	#print "alert(count_offpeak_day0+'|'+count_offpeak_day1+'|'+count_offpeak_day2+'|'+count_offpeak_day3+'|'+count_offpeak_day4+'|'+count_offpeak_day5+'|'+count_offpeak_day6);";
	#print "alert(count);";
	print " if (count < 1)\n";
	print " {\n";
	print "      alert(\"No blocks selected!\");\n";
	print "		flag=false;\n";
	print " }\n";
	print "	return (flag);\n";
	print "}\n";
	
	print "function checkUserClass() {\n";
	print "	;\n";
	print "	return true;\n";
	print "}\n";

	#AJAX: Get UserList
	print "var xmlhttp;\n";
	print "var userSelectHtml = '';\n";
	print "if (window.XMLHttpRequest)\n";
	print "{ //code for IE7+, Firefox, Chrome, Opera, Safari\n";
	print "		xmlhttp=new XMLHttpRequest();\n";
	print "}\n";
	print "else";
	print "{// code for IE6, IE5\n";
	print "		xmlhttp=new ActiveXObject(\"Microsoft.XMLHTTP\");\n";
	print "}\n";
	print "xmlhttp.onreadystatechange=function()\n";
	print "	{\n";
	print "		if (xmlhttp.readyState==4 && xmlhttp.status==200)\n";
    print "		{\n";
    #print "		document.getElementById(\"myDiv\").innerHTML=xmlhttp.responseText;";
	print "			userSelectHtml = xmlhttp.responseText;\n";
    print "		}\n";
	print "	}\n";
	print "xmlhttp.open(\"GET\",\"../php/getUserSelect.php\",false);\n";
	#print "xmlhttp.open(\"GET\",\"../php/getUserSelect.php\",true);\n";
	print "xmlhttp.send();\n";
	
	#function change_usedby()
	print "function change_usedby(dayslot, timeslot, date) {\n";
	
	
	print " var position = dayslot+\"_\"+timeslot;\n";
	print " document.getElementById(\"change_\"+position).style.display ='none';\n";
	print " document.getElementById(\"confirm_\"+position).style.display ='inline';\n";
	print "	document.getElementById(\"sel_\"+position).innerHTML = userSelectHtml;\n";
	#print " document.getElementById(\"change_\"+position).innerHTML = '<select id=sel_'+position+' style=\"width:100px\">'+userSelectHtml+'</select>';\n";
	#print " document.getElementById(\"change_\"+position).innerHTML += \'<button type=\"button\" onclick=confirm_usedby(\'+dayslot+\',\'+timeslot+\',\'+date+\');>Confirm</button>\';\n";
	#print " document.getElementById(\"change_\"+slotname).innerHTML += \'$instr_name$date1\';\n";
	print "}\n";
	
	#function confirm_usedby
	print "var confirm_array = new Array();";
	print "function confirm_usedby(dayslot, timeslot, date) {\n";
	
	#print "var pos = dayslot+'_'+timeslot+'_'+date;";
	#print "alert(pos+'::'+document.getElementById(\"sel_\"+dayslot+\"_\"+timeslot).value);";
	#print "confirm_array[pos]=document.getElementById(\"sel_\"+dayslot+\"_\"+timeslot).value;";
	#print "alert(confirm_array.length);";
	print " var position = dayslot+\"_\"+timeslot;";
	print " document.getElementById('slot'+position).innerHTML = document.getElementById('sel_'+position).value;";
	print " document.getElementById(\"newuser_\"+position).innerHTML = document.getElementById('sel_'+position).value;";
	print " document.getElementById('slot'+position).style.color='blue';";
	
	print " document.getElementById(\"change_\"+position).style.display ='inline';\n";
	print " document.getElementById(\"confirm_\"+position).style.display ='none';\n";
	
	
	
	print "}\n";
	
	print "function change_all(max_day, max_time) {\n";
	print "	for (var idx_day=0; idx_day<max_day; idx_day++) {\n";
	print "		for (var idx_time=0; idx_time<max_time; idx_time++) {\n";
	print "			var new_user_obj = document.getElementById('newuser_'+idx_day+'_'+idx_time);\n";
	print "			if (new_user_obj!=null && new_user_obj.innerHTML!='') {\n";
	#print "				alert(new_user_obj.innerHTML+'-'+idx_time+','+idx_time);\n";
	
	print "				var position = idx_day+\"_\"+idx_time;";
	print "				var date = document.getElementById('date_'+position).innerHTML;";
	#print "				var usedby_new = document.getElementById(\"sel_\"+position).value;";
	print "				if (new_user_obj.innerHTML == 'None')";
	print " 			{ alert('Error: Please select a new user in the list! (One of users is not selected)');}";
	print "				else {";
	print "					xmlhttp.onreadystatechange=function() {\n";
	#print "						alert(xmlhttp.status);\n";
	print "						if (xmlhttp.readyState==4 && xmlhttp.status==200)\n";
    print "						{\n";
	#print "						alert(xmlhttp.responseText);\n";
	print "							window.location.replace(\"signup.pl?SID=$sid&login=$login&week=$offset&InstrName=$instr_name\");\n";
    print "						}\n";
	print "					}\n";
	print "					var opt = \"login=$login&SID=$sid&date=\"+date+\"&InstrName=$instr_name&slot=\"+idx_time+\"&usedby=\"+new_user_obj.innerHTML;";
	#print "					alert(opt);";
	print "					if(document.getElementById(\"status_\"+position).innerHTML=='empty')";
	print "					{	opt += \"&mode=add\";	}";
	print "					else {	opt += \"&mode=change\";	}";
	print "\n					xmlhttp.open(\"POST\",\"changesignupdata.pl\",false);\n";
	print "\n					xmlhttp.send(opt);\n";
	print " 			}";
	
	print "			}\n";
	print "		}\n";
	print "	}\n";
	print "}\n";
	

	print "</script>\n";
			
	print "<html>\n";
	print "<title>\n";
	print "Sign Up\n";
	print "</title>";	
   	print "<body background=\"../_image/valtxtr.gif\">\n";
   	print "<p align=\"right\"><a href=\"Javascript:self.print()\"><b>PRINT</b></a></p>\n";
   	print "<h2 align=\"center\"> Sign Up Sheet</h2>\n";
	print "<h4> Instrument: $instr_name</h4>\n";
	if($permission eq "Peak")			{ print "<h4><font color='blue'> Permission: Peak time only</font></h4>\n";	}
	elsif($permission eq "Off-Peak")	{ print "<h4><font color='blue'> Permission: Peak time & Off-peak time</font></h4>\n";	}
	else 								{ print "<h4><font color='blue'> Permission: Error!</font></h4>\n";	}
	

	print "<div align=\"center\">\n";
  	print "<center>\n";

	if($instr_name eq "JEOL JIB-4500 - FIB SEM")
	{
		print "<font color='red'>New rule for ".$instr_name.":<br> Sign up limit, 4 hrs./day of peak time and <span style=\"background-color: #C0C0C0\">8 hrs./day of off-peak time</span> in advance\n</font>";
	}
	else
	{	
		print "Sign up limit, 4 hrs. of peak time and <span style=\"background-color: #C0C0C0\">8 hrs. of off-peak time</span> in advance\n";
	}
	
	$prev_offset = $offset-7;
	$next_offset = $offset+7;
	print "	<table border=0 width=500 style='text-align:center'>";
	print "		<td>";
	print "			<form method=post action=\"signup.pl\" >";
	print "				<input type=\"hidden\" name=\"login\" value = \"$login\">";
	print "				<input type=\"hidden\" name=\"SID\" value = \"$sid\">";
	print "				<input type=\"hidden\" name=\"InstrName\" value=\"$instr_name\">";
	print "				<input type=\"hidden\" name=\"week\" value=\"$prev_offset\">";
	print "				<input type=\"submit\" value=\"&lt;&lt; Previous week\">";
	print "			</form>";
	print "		</td>";
	print "		<td>";
	print "			<form method=post action=\"signup.pl\" >";
	print "				<input type=\"hidden\" name=\"login\" value = \"$login\">";
	print "				<input type=\"hidden\" name=\"SID\" value = \"$sid\">";
	print "				<input type=\"hidden\" name=\"InstrName\" value=\"$instr_name\">";
	print "				<input type=\"hidden\" name=\"week\" value=\"$next_offset\">";
	print "				<input type=\"submit\" value=\"Next week&gt;&gt;\">";
	print "			</form>";
	print "		</td>";
	print "	</table>";
	#print "<a href src=\"changesignupdata.pl?date=1&InstrName=instr2&usedby=dh\" target=\"_blank\">click</a>\n";
 	print "  <form method=post action=\"addsignupdata.pl\" onsubmit=\"return CheckBeforeSubmit()\" name=\"signup\">\n";
 	print "    <table align=center>\n";
	print "<table border=\"3\" cellpadding=\"3\" cellspacing=\"3\" >\n";
	print "<tr>\n";
    	print "<td width=\"120\"><b>Timeslot</b></td>\n";

	$date = $date1;
    while ( $date ne $date2)
    {
    	$weekday=$d->day_of_week();
    	$enweekday = convert_weekday($weekday);
		$_ = $date;
		if (/(\d{4})(\d{2})(\d{2})/) 
		{
			$enmonth = monthconvert($2);
	   		print "<td width=\"120\"><b>$enmonth $3 $enweekday</b></td>\n";
		}
		else
		{
	   		print "<td width=\"120\"><b>$date $enweekday</b></td>\n";
		}    		

	   	$d->next();
	   	$date = $d->image();
	}	
	print "</tr>\n";

	

	
	for ($i = 0; $i <= 11; $i++)
	{
		print "<tr>";	
		print "<td width=\"120\">";	
		if ($i == 0)
		{
			print "12 am - 7 am\n";
		}
		elsif ($i == 1)
		{
			print "8 am - 9 am\n";
		}
		elsif ($i == 2)
		{
			print "9 am - 10 am\n";
		}
		elsif ($i == 3)
		{
			print "10 am - 11 am\n";
		}
		elsif ($i == 4)
		{
			print "11 am - 12 pm\n";
		}
		elsif ($i == 5)
		{
			print "1 pm - 2 pm\n";
		}
		elsif ($i == 6)
		{
			print "2 pm - 3 pm\n";
		}
		elsif ($i == 7)
		{
			print "3 pm - 4 pm\n";
		}
		elsif ($i == 8)
		{
			print "4 pm - 5 pm\n";
		}
		elsif ($i == 9)
		{
			print "5 pm - 7 pm\n";
		}
		elsif ($i == 10)
		{
			print "7 pm - 9 pm\n";
		}
		else
		{
			print "9 pm - 12 am\n";
		}
		print "</td>\n";

		# query the date with the specified slot
		$sth = $db->prepare("select Date, UsedBy from schedule where InstrumentName = '$instr_name' and Slot = '$i' and Date >= '$date1' and Date < '$date2' ");
		$sth->execute();
		$count = 0;
		while(($datesigned[$count], $usedby[$count])=$sth->fetchrow_array)
		{
			$count ++;
		}
		
		# creat table and fill table
		$d->sub(7);
		$date = $date1;
		$daycount = 0;
   		while ( $date ne $date2 )
    	{
    		for ($jj = 0; $jj < $count; $jj ++)
    		{
    			@ymn = split(/-/, $datesigned[$jj]);
    			#$text = sprintf("%4d-%2d-%2d", $year, $month, $day);
    			#print $text;
  
				$_ = $date;
				if (/(\d{4})(\d{2})(\d{2})/) 
				{
					if (($1 == $ymn[0]) && ($2 == $ymn[1]) && ($3 == $ymn[2]))
					{
						last;
					}
				}
    		}
    			
   			$wday = $d->day_of_week();
   			#different background for timeslot
   			if (($i > 8) || ($wday == 6) || ($wday == 0) || ($i < 2))
   			{
   				print "	   <td width =\"120\" bgcolor=\"#C0C0C0\"><center>";
   			}
   			else
   			{ 
   				print "	   <td width =\"120\"><center>";
   			}
   			if ($jj != $count)
   			{
		    	$slotname = "slot"."$daycount"."_"."$i";
				print "<input type=\"hidden\" name=\"$slotname\" value = \"off\">";		
				if (($ClassAdmin eq 1) && ($usedby[$jj] ne $login)) {
					#print $ClassAdmin."|".$usedby[$jj]."|".$jj."|".$login;
					#print "<p>$usedby[$jj]<a href=\"reserveschedule.pl?SID=$sid&login=$login&InstrName=$instr_name&Date=$date&Slot=$i&Tag=$usedby[$jj]\"><br>Reserve-$login</a>";
					print "<div id='status_".$daycount."_".$i."' style='display:none;'>full</div>";
					print "<div id=\"$slotname\">$usedby[$jj]</div>";
					
				}
				else	{
					print "<div id=\"$slotname\">$usedby[$jj]</div>";
				}
		   	}
		   	else
		   	{
				if ($date >= $nowdate) {
					$slotname = "slot"."$daycount"."_"."$i";
					#Check Peak Time
					#if (($UserClass eq 4) and () and (($i > 8) || ($wday == 6) || ($wday == 0) || ($i < 2)))
					print "<div id='status_".$daycount."_".$i."' style='display:none;'>empty</div>";					
					if (($permission eq "Peak") && (($i > 8) || ($wday == 6) || ($wday == 0) || ($i < 2)))
					{
						#print "<input type=\"checkbox\" name=\"$slotname\" value=\"on\" disabled=\"disabled\">";
					}
					else
					{
						print "<input type=\"checkbox\" name=\"$slotname\" value=\"on\">";
					}
					
					print "<div id=\"$slotname\"></div>";
					#print "    </td>\n";
				}
				else   {
					$slotname = "slot"."$daycount"."_"."$i";
					print "<input type=\"hidden\" name=\"$slotname\" value = \"off\">";
					print "<div id=\"$slotname\"></div>";
					#print "&nbsp;</td>\n";
				}
				
		   	}
			if (($UserClass ne 4) && ($date >= $nowdate))
			{
				$slot_position = "$daycount"."_"."$i";
				# FOR TEST
				#if (($instr_name eq "JEOL JIB-4500 - FIB SEM") && ($offset eq '72'))
				{
					print "<div id=\"change_$slot_position\" style=\"display:inline\"><button type=\"button\" onclick=\"change_usedby('$daycount','$i', '$date')\">change</button></div>";
					print "<div id=\"confirm_$slot_position\" style=\"display:none\"><select id=\"sel_$slot_position\" style=\"width:100px\"></select><button type=\"button\" onclick=confirm_usedby('$daycount','$i','$date');>confirm</button></div>";
					print "<div id=\"newuser_$slot_position\" style=\"display:none\"></div>";
					print "<div id=\"date_$slot_position\" style=\"display:none\">".$date."</div>";
				}

				print "";
			}
			print "</center></td>\n";
		   	$d->add(1);
		   	$date = $d->image();	
		   	$daycount++;
		} 
		print "</tr>\n";
		
		if ($i == 4)
		{
			# for slot : 12 pm to 1 pm
			print "<tr>\n";
			print "	   <td width =\"120\" bgcolor=\"#808080\">\n";
			print "12 pm - 1 pm </td>";			
			print "	   <td bgcolor=\"#808080\" colspan=\"7\"><p align=\"center\">\n";
			print "THIS PERIOD IS RESERVED ON A FIRST COME FIRST SERVE BASIS. THE MORNING USER CAN CONTINUE IF NO ONE ARRIVES TO USE THE INSTRUMENT.</p>\n";
			print "    </td>\n";
			#print "	   <td width=\"120\" bgcolor=\"#C0C0C0\">&nbsp;</td>";
			#print "	   <td width=\"120\" bgcolor=\"#C0C0C0\">&nbsp;</td>";			
			print "</tr>";		
		}
	}

	print "</table>\n";

	print "<p><p>\n";
	print "<input type=\"submit\" value=\"Continue\" align=center>\n";
	print "<input type=\"reset\"  value=\" Reset \">\n";
	if ($UserClass ne 4){
		print "<input type=\"button\" value=\"Change All\" onclick=\"change_all($daycount, $i);\" align=center>\n";
	}
	print "<input type=\"hidden\" name=\"login\" value = \"$login\">\n";
	print "<input type=\"hidden\" name=\"SID\" value = \"$sid\">\n";
	print "<input type=\"hidden\" name=\"InstrName\" value = \"$instr_name\">\n";
	print "<input type=\"hidden\" name=\"date\" value = \"$date1\">";
	print "<input type=\"hidden\" name=\"daycount\" value = \"$daycount\">";
	print "<input type=\"hidden\" name=\"timecount\" value = \"$i\">";
	print "</form>\n";
	print "</body>\n";
	print "</center></html>\n";
	
	$sth->finish();
	$db->disconnect;		
}

else
{
	$db->disconnect;
	print "Content-type: text/html\r\n\r\n\n";
	print "<body onload=\"Javascript:parent.location.replace('../index_alt.html')\">"; 		
	print "</body>\n";
	exit;
}
$sth->finish;

	
	
	
