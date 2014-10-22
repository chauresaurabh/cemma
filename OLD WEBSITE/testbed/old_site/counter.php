<?php
//Site defines
//Set count type:
// 1 --> unique, only count each ip one time
// 2 --> All, count hits, ip not a problem

$type = 2;
$IP_FILE = '/info/dept-00/dept/CEMMA/ips.txt'; //Chmod to 777 (and place it outside of public_html)
$COUNTER_FILE = '/info/dept-00/dept/CEMMA/counter.txt'; //Chmod to 777 (and place it outside of public_html)

//Function to get user ip (stolen from phpskills.com :)
function get_user_ip(){       
	$ipParts = explode(".", $_SERVER['REMOTE_ADDR']);
	if ($ipParts[0] == "165" && $ipParts[1] == "21") {    
    	if (getenv("HTTP_CLIENT_IP")) {
        	$ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } elseif (getenv("REMOTE_ADDR")) {
            $ip = getenv("REMOTE_ADDR");
        }
    } else {
       return $_SERVER['REMOTE_ADDR'];
   	}
   	return $ip;
}

// Use this to check that the ip was already entered into the database (no entry is made)
$user_ip = get_user_ip();
$match = false;

// Open Ip file, if does not exist creat one, and see if we have a match
if(!is_file('ips.txt')){
	$file = fopen($IP_FILE,'w+');
	fwrite($file,$user_ip."\n");
	fclose($file);
} else {
	$file = @fopen($IP_FILE, "r"); 
	$ip_list = fread($file, filesize($IP_FILE)); 
	fclose($file);
	if(eregi($user_ip,$ip_list)){
		$match = true;
	} else {
		$file = fopen($IP_FILE,'a');
		fwrite($file,$user_ip."\n");
		fclose($file);		
	}
}		

// Check Type Kind		
if($type == 2 || ($type == 1 && $match == false)) {

	$file = fopen($COUNTER_FILE,'r');
	$hitcount = fread($file, filesize($COUNTER_FILE)); 
	fclose($file);	

	$hitcount = $hitcount + 1; 

	$file = fopen($COUNTER_FILE,'w');
	fwrite ($file, $hitcount );
	fclose($file);
} else {
	$file = fopen($COUNTER_FILE,'r');
	$hitcount = fread($file, filesize($COUNTER_FILE)); 
	fclose($file);	
}

echo 'You are visitor no. ' . $hitcount;
?>
