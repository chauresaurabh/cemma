<?php
 	date_default_timezone_set("Asia/Tokyo");
 	$t = (int)date("H");
	if($t>=9 && $t<17)
		echo "Peak";
	else
		echo "Off-Peak";	
	echo "<br>";
	
	$loginDay = "10";
	$loginHour = "09";
	$loginMinute = "00";
	
	$logoutDay = "11";
	$logoutHour = "09";
	$logoutMinute = "30";
	
	
	$diffDay = (int)$logoutDay - (int)$loginDay;
	$diffHour = (int)$logoutHour - (int)$loginHour;
	$diffMinute = (int)$logoutMinute - (int)$loginMinute;
	
	$qty = $diffDay*24 + $diffHour;
	$diffMinute = (int)$logoutMinute - (int)$loginMinute;
	if($diffMinute < 0)
	{
		$qty = $qty - 1;
		$diffMinute = $diffMinute + 60;
	}
	if($diffMinute < 15)
		$qty = $qty + 0.0;
	elseif($diffMinute <= 30)
		$qty = $qty + 0.5;
	elseif($diffMinute <= 60)
		$qty = $qty + 1.0;
	echo $qty;
	
	echo "<br>";
?>