<? 

include_once("../includes/database.php");

$output = '';
$month = $_GET['month'];
$year = $_GET['year'];
	
if($month == '' && $year == '') { 
	$time = time();
	$month = date('n',$time);
    $year = date('Y',$time);
}

$date = getdate(mktime(0,0,0,$month,1,$year));
$today = getdate();
$hours = $today['hours'];
$mins = $today['minutes'];
$secs = $today['seconds'];

if(strlen($hours)<2) $hours="0".$hours;
if(strlen($mins)<2) $mins="0".$mins;
if(strlen($secs)<2) $secs="0".$secs;

$days=date("t",mktime(0,0,0,$month,1,$year));
$start = $date['wday']+1;
$name = $date['month'];
$year2 = $date['year'];
$offset = $days + $start - 1;
 
if($month==12) { 
	$next=1; 
	$nexty=$year + 1; 
} else { 
	$next=$month + 1; 
	$nexty=$year; 
}

if($month==1) { 
	$prev=12; 
	$prevy=$year - 1; 
} else { 
	$prev=$month - 1; 
	$prevy=$year; 
}

if($offset <= 28) $weeks=28; 
elseif($offset > 35) $weeks = 42; 
else $weeks = 35; 

$output .= "
<div class='cal-top'></div>
<table class='cal' cellspacing='0' cellpadding='0'>

<tr class='cal-top-head'>
	<td colspan='7'>
		<table class='calhead'>
		<tr>
			<td class='calhead-left'>
				<a href=\"javascript:navigate($next,$nexty)\"><img src=\"images/cal-next.gif\"></a>
				<a href=\"javascript:navigate(\'\',\'\')\"><img src=\"images/cal-mid.gif\"></a>
				<a href=\"javascript:navigate($prev,$prevy)\"><img src=\"images/cal-back.gif\"></a>
				
			</td>
			<td class='calhead-right'>
				<div>$name $year2</div>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr class='dayhead'>
	<td>Sun</td>
	<td>Mon</td>
	<td>Tue</td>
	<td>Wed</td>
	<td>Thu</td>
	<td>Fri</td>
	<td>Sat</td>
</tr>";

$col=1;
$cur=1;
$next=0;

$usedCount = array();

for($i=1;$i<=$weeks;$i++) { 
	if($next==3) $next=0;
	if($col==1) $output.="<tr class='dayrow'>"; 
  	
	$output.="<td valign='top' onMouseOver=\"this.className='dayover'\" onMouseOut=\"this.className='dayout'\">";

	if($i <= ($days+($start-1)) && $i >= $start) {
		$output.="<div class='day'><b";

		if(($cur==$today[mday]) && ($name==$today[month])) $output.=" style='color:#C00'";

		$output.=">$cur</b><br>";
		$output.= getSchedule($cur,$month,$year2);
		$output.="</div></td>";

		$cur++; 
		$col++; 
		
	} else { 
		$output.="&nbsp;</td>"; 
		$col++; 
	}  
	    
    if($col==8) { 
	    $output.="</tr>"; 
	    $col=1; 
    }
}

$output.="</table><div class='cal-bot'></div>";
  
echo $output;

function getSchedule($day,$month,$year){

	$curDate = "$year-$month-$day";
	$returnString = "";
	
	if (count($usedCount)==0)
	{
		;
	}	
	else
	{
		;
	}
	
	$returnString .= "<div>Reserved:";
	
	#$sql = "select Text from TestTable where Date = '$curDate'";
	#echo $sql;
	#$result = mysql_query($sql) or die("Error in Calendar.php");
	/*
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
		
		$returnString .= "<b>".$row['Text']."</b></br>";
		
	}
	*/
	$returnString .= "</div>";
	
	return $returnString;
	

}


?>
