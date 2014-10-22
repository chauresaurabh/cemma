<?php
 	include_once ("database.php");
	date_default_timezone_set("America/Los_Angeles");
	
	$instrument = $_POST['inst'];
	
	$status = "";
	$username = "";
	$remarks = "";
	$date = "";
	$time = "";
	$msg = "";
	$output = "";
	
	$sql1 = "SELECT  username, remarks, date,time FROM Remarks WHERE InstrumentName='$instrument'";
	//echo $sql1;
	$result1 = mysql_query($sql1,$connection);
	
	if(mysql_num_rows($result1)==0){
		#$output = "ERROR|Invalid User!|";
		$status = "ERROR";
		$msg = "Invalid User!";
	} else {
		$row1 = mysql_fetch_array($result1);
		if($row1['instrument']== $instrument) {
			$userclass = $row1['UserClass'];
			$email = $row1['Email'];
		
			/*$sql2 = "SELECT InstrumentNo FROM instrument WHERE InstrumentName='$instrument'";
			#echo $sql2;
			$result2 = mysql_query($sql2,$connection);
			$row2 = mysql_fetch_array($result2);
			if(mysql_num_rows($result2)==0){
				#$output = "ERROR|No such instrument!|";
				$status = "ERROR";
				$msg = "No such instrument!";
			}
			else {
				$instrnum = $row2['InstrumentNo'];
				*/
				$sql3 = "SELECT InstrNo, Email, InstrSigned, Permission FROM instr_group WHERE InstrNo='$instrnum' AND Email='$email'";
				$result3 = mysql_query($sql3,$connection);
				$row3 = mysql_fetch_array($result3);
				
				$status = "OK";
				$permission = $row3['Permission'];
				$starttime = date("Y-m-d h:i:s");
				
				#$output = "OK|".$username."|".$instrument."|".$permission."|".$operator."|".$starttime."|";
				

			}
			
		} else {
			#$output = "ERROR|Inactiavted User!|";
			$status = "ERROR";
			$msg = "Inactiavted User!";
		}
	}
	if ($status == "ERROR")
	{
		echo "status=".$status."&msg=".$msg;
	}
	elseif ($status == "OK")
	{
		echo "status=".$status."&usr=".$username."&class=".$userclass."&inst=".$instrument."&permit=".$permission."&op=".$operator."&time=".$starttime;
	}
	
?>