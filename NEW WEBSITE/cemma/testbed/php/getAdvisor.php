<?
	include_once("../includes/database.php");
	$sql2 = "select Customer_ID,Name  from  Customer ORDER BY Name";
	$result2=mysql_query($sql2) or die( "An error has ocured in query2: " .mysql_error (). ":" .mysql_errno ()); 
	$row_advisor = mysql_fetch_array($result2);
	
	$html_advisor.='<select name="Advisorlist" id="Advisorlist" onchange="OtherAdvisorClicked()" size="30" name="Advisor" class="text">';
	$html_advisor.='<option value=\"Default\" style=\"font-weight: bold\" disabled=\"disabled\" selected=\"selected\">-enter advisor-</option>';
	while($row_advisor = mysql_fetch_array($result2))
	{
		$html_advisor.='<option value="'.$row_advisor['Name'].'">'.$row_advisor['Name'].'</option>'; #onClick="OtherAdvisorClicked()"
	}
	
	
	$html_advisor.='<option value="New Advisor" style="font-weight: bold" >-new advisor-</option>';
	$html_advisor.='</select>';
	echo $html_advisor;
	mysql_close($connection);
?>