#!/usr/bin/perl
use lib "/kunden/homepages/40/d209127057/htdocs/schedule/cgi-bin/";
use CGI qw/:standard/;
use CGI::kSession;
use DBI;
use Date::Business;
require 'enmonth.pl';
require 'enweekday.pl';

$dsn = "DBI:mysql:database=db210021972:host=db948.perfora.net";
$db= DBI->connect($dsn, "dbo210021972", "XhYpxT5v");

my $s = new CGI::kSession(lifetime=>900, path=>"../../var/session/",id=>param("SID"));
$sid=$s->id();
$s->start();
$login=param("login");
$spassword=$s->get("$login");
$sth = $db->prepare("select Passwd from user where UserName = '$login'");
$sth->execute();
$passworddb = $sth->fetchrow_array();
$sth->finish();

if($spassword eq $passworddb)
{
	$option = param("option");
	
	print "Content-type: text/html\r\n\r\n";

	$sth = $db->prepare("select InstrumentName from instrument, instr_group, user where user.UserName = '$login' and instr_group.Email=user.Email and instrument.InstrumentNo = instr_group.InstrNo order by InstrumentName");
	$sth->execute();
	$instr_no=0;
	while($instrName[$instr_no]=$sth->fetchrow_array)
	{
		$instr_no++;
	}
	$sth->finish; 
	$db->disconnect;

	print "<script>";
	print "function CheckBeforeSubmit(){";
	print "	var flag=true;";
	if ($option eq "view")
	{
		print "	var month=parseInt(document.newsign.month.value);";
		print "	var day=parseInt(document.newsign.day.value);";
		print " var year=parseInt(document.newsign.year.value);";
	}
	print " if (document.newsign.InstrName.value == \"none\")";
	print " {";
	print "      	alert(\"must select one instrument\");";
	print "		flag=false;";
	print " }";
	if ($option eq "view")
	{
	print "	if(month==2|month==4|month==6|month==9|month==11)";
	print "	{";	
	print "		if((month==2)&&(day>29))";
	print "		{";
	print "			alert(month+\"/\"+day+\" is not a valid date\");";
	print "			flag=false;";
	print "		}";
	print "		else if(day>30)";
	print "		{";
	print "			alert(month+\"/\"+day+\" is not a valid date\");";
	print "			flag=false;";
	print "		}";
	print "   	else if(month == 2 && day==29 && year%4!==0)";
	print "		{";
	print "			alert(month+\"/\"+day+\"/\"+year+\" is not a valid date\");";
	print "			flag=false;";	
	print "		}";	
	print "	}";
	}
	print "	return (flag);";
	print "}";
	print "</script>";

	print "<html>";
	print "<title>";
	print "Manuals";
	print "</title>";
   	print "<body background=\"../_image/valtxtr.gif\">";
   		
	if ($option eq "add")
	{
		print "<h3><center>Select the instrument and the week you want to use</center></h3><center>";
		print "  <form method=post action=\"signup.pl\" onsubmit=\"return CheckBeforeSubmit()\" name=\"newsign\">";
	} elsif($option eq "manual"){
		print "<center><input type='button' onclick=\"window.open('../docs/JEOL_2100_TEM_Start_up_and_alignment.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='JEOL 2100 TEM Start up and alignment'/></center><br/>";
		print "<center><input type='button' onclick=\"window.open('../docs/Single_tilt_Holder.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='Single-tilt Holder'/></center><br/>";
		print "<center><input type='button' onclick=\"window.open('../docs/JEOL_2100F_STEM.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='JEOL 2100F - STEM'/></center><br/>";
		print "<center><input type='button' onclick=\"window.open('../docs/JEOL_2100F_Diffraction.pdf', '_blank', 'fullscreen=no,location=no'); return false;\" value='JEOL 2100F - Diffraction'/></center><br/>";
		
	}
	else
	{
		print "<h3><center>Select the instrument and a date that belongs to the week you want to view</center></h3><center>";
		print "  <form method=post action=\"viewschedule.pl\" onsubmit=\"return CheckBeforeSubmit()\" name=\"newsign\">";
	}		
	if($option ne "manual"){
		print "    <table align=center>";
	
		print "<tr>";
		print "        <td width=\"163\"> Instrument: </td>";
		print "        <td width=\"166\"> ";
		print "<select name = \"InstrName\">\n";
		print "<option value=\"none\">-- Select Instrument--\n</option>\n";
		for($ii=0;$ii<$instr_no;$ii++)
		{
			print "<option value=\"$instrName[$ii]\">$instrName[$ii]</option>\n";
		}
		
		print "</select>";
		print "	</td>";
		print "</tr>";
	
		print "<tr>";
		if ($option eq "add")
		{
			print "        <td width = 163> Week: </td>";
			print "        <td width=\"166\"> ";
			print "          <select name = \"week\">";
			($day, $month, $year)=(localtime)[3,4,5];
			if($day<10){$this_day='0'."$day"; }else{$this_day=$day;}
			$current_year = $year+1900;	
			$month += 1;
			if($month<10){$this_month='0'."$month"; }else{$this_month=$month;}
			$date = "$current_year"."$this_month"."$this_day";
			#print "$date";
			$d = new Date::Business(DATE => "$date");
			$this_weekday=$d->day_of_week();
			$offset = ($this_weekday - 1) % 7;
			$d->sub($offset);
			for ($ii=0; $ii < 12; $ii ++)
			{
				$value = ($ii * 7) - $offset;
				$_ = $d->image();
				if (/(\d{4})(\d{2})(\d{2})/) 
				{
					$enmonth = monthconvert($2);
					print "<option value = \"$value\">--- $enmonth $3, $1 ---</option>";
				}
				else
				{		
					$sel_date = $d->image();
					print "<option value = \"$value\">--- $sel_date ---</option>";
				}
				$d->add(7);
			}
			print "</select>";
			print "</td>";
			print "</tr>";		
		}
		else
		{
			($day, $month, $year)=(localtime)[3,4,5];
			#print $day."-".$month."-".$year;
			print "        <td width = 163> Date: </td>";
			print "        <td width=\"166\"> ";
			print "          <select name = \"month\">";
			for ($ii=1; $ii < 13; $ii ++)
			{
				if($ii==$month+1)
				{
					print "            <option value=\"".$ii."\" selected=\"selected\">";
					}
				else
				{
					print "            <option value=\"".$ii."\">";
				}
				if($ii==1)	{print "Jan";}
				elsif($ii==2)	{print "Feb";}
				elsif($ii==3)	{print "Mar";}
				elsif($ii==4)	{print "Apr";}
				elsif($ii==5)	{print "May";}
				elsif($ii==6)	{print "Jun";}
				elsif($ii==7)	{print "Jul";}
				elsif($ii==8)	{print "Aug";}
				elsif($ii==9)	{print "Sep";}
				elsif($ii==10)	{print "Oct";}
				elsif($ii==11)	{print "Nov";}
				else			{print "Dec";}
				print "</option>";
			}
			#print "            <option value=\"1\">Jan </option>";
			#print "            <option value=\"2\">Feb </option>";
			#print "            <option value=\"3\">Mar </option>";
			#print "            <option value=\"4\">Apr </option>";
			#print "            <option value=\"5\">May </option>";
			#print "            <option value=\"6\">Jun </option>";
			#print "            <option value=\"7\">Jul </option>";
			#print "            <option value=\"8\">Aug </option>";
			#print "            <option value=\"9\">Sep </option>";
			#print "            <option value=\"10\">Oct </option>";
			#print "            <option value=\"11\">Nov </option>";
			#print "            <option value=\"12\">Dec </option>";
			print "          </select>";
	
			
			print "<select name = \"day\">";
			for ($ii=1; $ii < 32; $ii ++)
			{
				if($ii==$day)
				{
					print "	<option value=\"".$ii."\" selected=\"selected\">";
					}
				else
				{
					print " <option value=\"".$ii."\">";
				}
				if($ii<10)	{print "0".$ii;}
				else		{print $ii;}
				print "</option>";
			}
			print "</select>";
	
			
			print "<select name = \"year\">";
			
			$start_year=2003;
			
			print "<option value=\"2003\">2003";
			print "<option value=\"2004\">2004";
			print "<option value=\"2005\">2005";
			print "<option value=\"2006\">2006";
			print "<option value=\"2007\">2007";
			print "<option value=\"2008\">2008";
			print "<option value=\"2009\">2009";
			print "<option value=\"2010\">2010";
			print "<option value=\"2011\">2011";
			print "<option value=\"2012\" selected=\"selected\">2012";
			print "<option value=\"2013\">2013";
			print "<option value=\"2014\">2014";
			print "<option value=\"2015\">2015";
			print "<option value=\"2016\">2016";
			print "<option value=\"2017\">2017";
			print "<option value=\"2018\">2018";															
			print "</select>";
			print "</td>";
			print "</tr>";
		}
		
	
		print "</table>";
		print "<p><p>";
		print "<input type=\"submit\" value=\"Continue\" align=center>";
		print "<input type=\"reset\"  value=\" Reset \">";
		print "<input type=\"hidden\" name=\"login\" value = \"$login\">";
		print "<input type=\"hidden\" name=\"SID\" value = \"$sid\">";
		print "</form>";
	}
	print "</body>";
	print "</center></html>";
	
}
else
{
	$sth->finish; $db->disconnect;	
	print "Content-type: text/html\r\n\r\n";
	print "<body onload=\"Javascript:parent.location.replace('../index_alt.html')\">"; 		
	print "</body>";
	exit;
}
