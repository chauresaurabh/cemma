<?php
$html_content="";


	require_once("./php/connectDB.php");
	$name=$_REQUEST['name'];
	

	if($name=="akashi")				{	$instrument_no="4";		}
	elseif($name=="jeol")			{	$instrument_no="2";		}
	elseif($name=="jeol-jsm-6610")	{	$instrument_no="36";	}
	elseif($name=="jib-4500")		{	$instrument_no="45";	}
	elseif($name=="jsm-7001")		{	$instrument_no="37";	}
	elseif($name=="leica-em-uc6")	{	$instrument_no="9";		}
	elseif($name=="tousimis-815")	{	$instrument_no="10";	}
	elseif($name=="jem-2100f")	{	$instrument_no="47";	}
	elseif($name=="omx")	{	$instrument_no="52";	}
	else{}
	
	//$html_content.=$name;
	//echo $instrument_no;
	$query = sprintf("SELECT InstrumentNo, InstrumentName, Availablity, Comment FROM instrument WHERE InstrumentNo=%s", mysql_real_escape_string($instrument_no));
	$result = mysql_query($query);
		
	// query fails
	if ($result==null) {
		$query_error = mysql_error($link);
		mysql_close($link);
		//throw new Exception($query_error, $code=-50);
	}
	
	$row=mysql_fetch_array($result);  
	if ($row==null)
	{
		//mysql_close($link);
		//throw new Exception("DB returned an empty row after submitting data", $code=-51);
	}
	else
	{
		$html_content.="<html><head></head><body background=\"../_image/valtxtr.gif\">";
		$html_content.="<table border=\"1\" cellpadding=\"3\" cellspacing=\"3\">";
		$html_content.="<tr>";
		$html_content.="<td width=\"300\" align=\"center\"><b>Instrument Name</b></td>";
		$html_content.="<td width=\"80\" align=\"center\"><b>Available</b></td>";
		$html_content.="<td width=\"300\" align=\"center\"><b>Comments</b></td>";
		do
		{
			//$resultString .= $row['uid']."|".$row['result'];
			$html_content.="<tr>";
			$html_content.="<td align=\"center\">".$row['InstrumentName']."</td>";
			if($row['Availablity']=="1")
				$html_content.="<td align=\"center\">Yes</td>";
			elseif($row['Availablity']=="0")
				$html_content.="<td align=\"center\">No</td>";
			else
				$html_content.="<td align=\"center\">??</td>";
			$html_content.="<td align=\"center\">".$row['Comment']."</td>";
			$html_content.="</tr>";
		}while($row = mysql_fetch_array($result));
	}

	//$resultString .= sprintf("1|%s|", "Everything was ok");
	
	mysql_close($link);
	
	
	
	
	
	
	



	echo $html_content;
?>