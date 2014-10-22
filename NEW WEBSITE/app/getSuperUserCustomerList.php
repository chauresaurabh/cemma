<?
include_once ("database_old.php");
date_default_timezone_set("America/Los_Angeles");

$username = $_POST['usr'];
if($username!=""){
	$withOperator = $_POST['withOperator'];
	if($withOperator!="" && $withOperator=='Yes'){
		$returnJson = "{";
		$sql = "SELECT Name, UserName FROM user where ( ActiveUser='active' OR ActiveUser IS NULL ) order by FirstName";
		$result = mysql_query($sql);
		//get the people from user
		if(mysql_num_rows($result)>0){
			$returnJson.='"fromAdvisors":[';
			$totalRows = mysql_num_rows($result);
			$count = 0;
			if($totalRows>1){
				while ($row = mysql_fetch_array($result)) {
					$returnJson.='{"Name":"'.$row["Name"].'",';
					$returnJson.='"userName":"'.$row["UserName"].'"},';
					$count++;
					if($count==$totalRows-1)
						break;
				}
			}
			$row = mysql_fetch_array($result);
			$returnJson.='{"Name":"'.$row["Name"].'",';
			$returnJson.='"userName":"'.$row["UserName"].'"}';
			$returnJson.=']';
		}
		

		$returnJson.="}";
		
		$status = "SUCCESS";
		$msg=$returnJson;

	} else {
		//get the advisor i.e. customer...assuming every super user WILL have an advisor.
		$sql = "SELECT Advisor FROM user WHERE UserName = '$username'";
		
		$result = mysql_query($sql,$connection);
		$advisor = "";
		if(mysql_num_rows($result)==0){
			$status = "ERROR";
			$msg = "Username or Password is invalid.";
		} else {
			$row = mysql_fetch_array($result);
			$advisor = $row['Advisor'];
		
			if($advisor!=""){
				$returnJson = "{";
				$sql = "SELECT Name, UserName  FROM user where Advisor = '$advisor' and ( ActiveUser='active' OR ActiveUser IS NULL ) order by FirstName";
				$result = mysql_query($sql);
				//get the people from user
				if(mysql_num_rows($result)>0){
					$returnJson.='"fromAdvisors":[';
					$totalRows = mysql_num_rows($result);
					$count = 0;
					if($totalRows>1){
						while ($row = mysql_fetch_array($result)) {
							$returnJson.='{"Name":"'.$row["Name"].'",';
							$returnJson.='"userName":"'.$row["UserName"].'"},';
							$count++;
							if($count==$totalRows-1)
								break;
						}
					}
					$row = mysql_fetch_array($result);
					$returnJson.='{"Name":"'.$row["Name"].'",';
					$returnJson.='"userName":"'.$row["UserName"].'"}';
					$returnJson.=']';
				}
				
	
				$returnJson.="}";
				
				$status = "SUCCESS";
				$msg=$returnJson;
			} else {
				$status = "ERROR";
				$msg = "No advisor found";
			}
		}
	}
} else {
	$status = "ERROR";
	$msg = "No advisor found";
}
echo "{status:'".$status."', msg:'".$msg."'}";
?>