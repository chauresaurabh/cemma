<?
include_once ("database_old.php");
date_default_timezone_set("America/Los_Angeles");

$sql = "SELECT UserName, Name FROM `user` WHERE userclass in (2,1) and activeuser = 'active'";
	
$result = mysql_query($sql,$connection);
if(mysql_num_rows($result)==0){
	$status = "ERROR";
	$msg = "No cemma staff members found";
} else {
	//get the people from user
	$returnJson = "{";
	$returnJson.='"cemmaStaffMembers":[';
	if(mysql_num_rows($result)>0){
		$totalRows = mysql_num_rows($result);
		$count = 0;
		if($totalRows>1){
			while ($row = mysql_fetch_array($result)) {
				$returnJson.='{"Name":"'.$row["Name"].'"},';
				$count++;
				if($count==$totalRows-1)
					break;
			}
		}
		$row = mysql_fetch_array($result);
		$returnJson.='{"Name":"'.$row["Name"].'"}';
		
	}
	$returnJson.=']}';
			
	$status = "SUCCESS";
	$msg=$returnJson;	
}
echo "{status:'".$status."', msg:'".$msg."'}";
?>