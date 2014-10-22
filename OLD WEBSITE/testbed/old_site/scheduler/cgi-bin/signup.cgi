#!/usr/usc/bin/perl -X
use CGI qw/:standard/;
use CGI::kSession;
use DBI;
use Date::Business;
require 'enmonth.cgi';
require 'enweekday.cgi';

#---------------------------------------------------------------------------------
# Instrument sign up form. Allows user to book time on an instrument.
#---------------------------------------------------------------------------------

$dsn = "DBI:mysql:cemma;mysql_read_default_group=client;mysql_read_default_file=/var/local/www/unsupported-00/curulli/.my.cnf";
$db= DBI->connect($dsn, "root", "");

my $s = new CGI::kSession(lifetime=>900, path=>"/var/local/www/unsupported-00/curulli/session/",id=>param("SID"));
$sid=$s->id();
$s->start();
$login=param("login");
$spassword=$s->get("$login");
$sth = $db->prepare("select Passwd, Class from user where UserName = '$login'");
$sth->execute();
($passworddb, $ClassAdmin) = $sth->fetchrow_array();
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

	for ($daycount=0; $daycount < 7; $daycount++)
	{
	    for ($i = 1; $i < 12; $i++)
	    {
	    	$slotname = "slot"."$daycount"."_"."$i";
		print " if (document.signup.$slotname.checked)\n";
		print " {\n";
		print "     	count+=1;\n";
		print " }\n";
	    }
	}

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

	print " if (count < 1)\n";
	print " {\n";
	print "      	alert(\"No blocks selected!\");\n";
	print "		flag=false;\n";
	print " }\n";
	print "	return (flag);\n";
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

	print "<div align=\"center\">\n";
  	print "<center>\n";
  	print "Sign up limit, 4 hrs. of peak time and <span style=\"background-color: #C0C0C0\">8 hrs. of off-peak time</span> in advance\n";

 	print "  <form method=post action=\"addsignupdata.cgi\" onsubmit=\"return CheckBeforeSubmit()\" name=\"signup\">\n";
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

	for ($i = 1; $i <= 11; $i++)
	{
		print "<tr>";	
		print "<td width=\"120\">";	
		if ($i == 1)
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
			print "9 pm - 8 am\n";
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
    			if (($i > 8) || ($wday == 6) || ($wday == 0))
    			{
    				print "	   <td width =\"120\" bgcolor=\"#C0C0C0\">\n";
    			}
    			else
    			{
    				print "	   <td width =\"120\">\n";
    			}
    			if ($jj != $count)
    			{
			    	$slotname = "slot"."$daycount"."_"."$i";
				print "<input type=\"hidden\" name=\"$slotname\" value = \"off\">";		
				if (($ClassAdmin eq 1) && ($usedby[$jj] ne $login)) {
					print "<p>$usedby[$jj]<a href=\"reserveschedule.cgi?SID=$sid&login=$login&InstrName=$instr_name&Date=$date&Slot=$i&Tag=$usedby[$jj]\"><br>Reserve</a>\n";
				}
				else	{
					print "<p>$usedby[$jj]\n";
				}
				print "    </td>\n";
		   	}
		   	else
		   	{
		            if ($date >= $nowdate) {
				$slotname = "slot"."$daycount"."_"."$i";
				print "<input type=\"checkbox\" name=\"$slotname\" value=\"on\"></td>";			
				print "    </td>\n";
			    }
			    else   {
				$slotname = "slot"."$daycount"."_"."$i";
				print "<input type=\"hidden\" name=\"$slotname\" value = \"off\">\n";
				print "&nbsp;</td>\n";
			    }
		   	}
		   	
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
	print "<input type=\"hidden\" name=\"login\" value = \"$login\">\n";
	print "<input type=\"hidden\" name=\"SID\" value = \"$sid\">\n";
	print "<input type=\"hidden\" name=\"InstrName\" value = \"$instr_name\">\n";
	print "<input type=\"hidden\" name=\"date\" value = \"$date1\">";	
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

	
	
	
