<?php
 	include_once ("database.php");
	date_default_timezone_set("America/Los_Angeles");
	$username = $_POST['usr'];
    $password = $_POST['pw'];
	$instrument = $_POST['inst'];
	$operator = $_POST['optr'];
	
	$status = "";
	$userclass = "";
	$email = "";
	$instrnum = "";
	$permission = "";
	$starttime = "";
	$msg = "";
	
	$output = "";
	
	$sql1 = "SELECT Name, Email, ActiveUser, UserClass FROM user WHERE UserName = '$username' AND Passwd = '$password'";
	//echo $sql1;
	$result1 = mysql_query($sql1,$connection);
	
	if(mysql_num_rows($result1)==0){
		#$output = "ERROR|Invalid User!|";
		$status = "ERROR";
		$msg = "Username or Password is invalid. ";
	} else {
		$row1 = mysql_fetch_array($result1);
		if ($row1['ActiveUser']=='inactive'){
			#$output = "ERROR|Inactiavted User!|";
			$status = "ERROR";
			$msg = "Inactiavted User!";
		} else {
			if($operator!=NULL && $operator!='NA' && $operator!=""){
				//check if operator is selected
				$optrPwd = $_POST['optrpwd'];
				$sql2 = "SELECT Name FROM user WHERE Name = '$operator' AND Passwd = '$optrPwd'";

				$result2 = mysql_query($sql2,$connection);
				$row2 = mysql_fetch_array($result2);
				if(mysql_num_rows($result2)==0){
					$status = "ERROR";
					$msg = "Invalid Operator password!";
					echo '{status:"'.$status.'", msg:"'.$msg.'"}';
					mysql_close($connection);
					return;
				}
			}
			
			
			$userclass = $row1['UserClass'];
			$email = $row1['Email'];
		
			$sql2 = "SELECT InstrumentNo FROM instrument WHERE InstrumentName='$instrument'";
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
				
				$sql3 = "SELECT Permission FROM instr_group WHERE InstrNo='$instrnum' AND Email='$email'";
				$result3 = mysql_query($sql3,$connection);
				$row3 = mysql_fetch_array($result3);
				//check if user has permission for the instrument
				$doNotContinueFurther = (mysql_num_rows($result3)==0);
				
				if($operator!=NULL && $operator!='NA' && $operator!=""){
					//if an operator was selected, then let the login continue
					$doNotContinueFurther = false;
				}
				if($doNotContinueFurther){
					$status = "ERROR";
					$msg = "You do not have privileges to use this Instrument!";
				}
				else{
					$status = "OK";
					$permission = $row3['Permission'];
					
					//if logged in with operator, then allow instrument usage
					if($operator!=NULL && $operator!='NA' && $operator!=""){
						$permission="Off-Peak";
					}
					
					$starttime = date("m/d/Y H:i:s");
					$curhour = (int)date("H");
					
					//Check Permission
					
					if($permission == 'Peak' && ($curhour<9 || $curhour>=17))
					{
						$status = "OUT_OF_PERMISSION";
					}
					else if($permission != 'Peak' && $permission != 'Off-Peak')
					{
						$status = "PERMISSION_NOT_SETUP";
					}
					else if($permission==''){
						$status = "PERMISSION_NOT_SETUP";
					}
				//$permission = 'Off-Peak';
				}	
			}
			
		} 
	}
	if ($status == "ERROR")
	{
		echo '{status:"'.$status.'", msg:"'.$msg.'"}';
		mysql_close($connection);
	}
	else
	{
		echo '{status:"'.$status.'", usr:"'.$username.'", class:"'.$userclass.'", inst:"'.$instrument.'", permit:"'.$permission.'", time:"'.$starttime.'", curhour:"'.$curhour.'"}';
		mysql_close($connection);
	}
	
?>