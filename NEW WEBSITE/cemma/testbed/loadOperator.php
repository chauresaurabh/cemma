<?
include_once ("includes/database.php");

$customernames = $_GET['CustomerName'];
$name = split(";",$customernames);
$operator = $_GET['OperatorName'];

echo '<select multiple="multiple" id="OperatorName" name="OperatorName[]" style="font-weight:normal; width:39mm" onChange ="checkOther()">';

	echo '<option value = "-1" SELECTED><b>All Operators</b></option>';
	if($name[0] == '-1') {
		echo '</select>';
	} else {	
		
		$sql = "SELECT operator FROM operators where customer IN (";
		if(count($name)>1) {
			for($i=0;$i<count($name)-1;$i++) {
				$sql.="'".$name[$i]."',";
			}
			$sql.="'".$name[count($name)-1]."'";
		} else {
			$sql.="'".$name[0]."'";
		}
		$sql.=")";
	
		$sql.=" order by operator";
		$result = mysql_query($sql);
		
		//echo $sql;
		
		
		$counter = 0;
		$cust = 0;
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			if ($counter == 0) {
				$counter = 1;
				echo '<option value = "Default" disabled="disabled"><b>From Customers</b></option>';
			}
			if ($row['operator'] != '') {
				if ($row['operator'] == $operator)
					echo '<option value = "' . $row['operator'] . '" selected="selected">' . $row['operator'] . '</option>';
				else
					echo '<option value = "' . $row['operator'] . '">' . $row['operator'] . '</option>';
				$cust++;
			}
		}
		
		//fill entries from user table
		
			 include_once('constants.php');
				include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
		
		$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connectionnn");
		$SelectedDB = mysql_select_db($dbname) or die("Error in DBbb");
		
		$sql = "SELECT FirstName, LastName,ActiveUser FROM user where Advisor IN (";
			if(count($name)>1) {
				for($i=0;$i<count($name)-1;$i++) {
					$sql.="'".$name[$i]."',";
				}
				$sql.="'".$name[count($name)-1]."'";
			} else {
				$sql.="'".$name[0]."'";
			}
			$sql.=")";
		
		$sql.=" and ( ActiveUser='active' OR ActiveUser IS NULL ) order by FirstName";
		$result = mysql_query($sql);
		
		//echo '<select id="OperatorName" name="OperatorName" style="font-weight:normal; width:39mm" onChange ="checkOther()">';
		
		$counter = 0;
		$users = 0;
		$count = 0;
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			if ($counter == 0) {
				$counter = 1;
				if ($cust == 0)
					echo '<option value = "Default2" disabled="disabled" SELECTED ><b><i>From Advisors</i></b></option>';
				else
					echo '<option value = "Default2" disabled="disabled"><b><i>From Current Users</i></b></option>';
			}
			$operator_user = $row['FirstName'] . " " . $row['LastName'];
			
			if($operator_user!=" ")
				if ($operator_user == $operator)
					echo '<option value = "' . $row['FirstName'] . " " . $row['LastName'] . '" selected="selected">' . $row['FirstName'] . " " . $row['LastName'] . '</option>';
				else
					echo '<option value = "' . $row['FirstName'] . " " . $row['LastName'] . '">' . $row['FirstName'] . " " . $row['LastName'] . '</option>';
			$count++;
		}
		
		
		$sql = "SELECT FirstName, LastName,ActiveUser FROM user where Advisor IN (";
			if(count($name)>1) {
				for($i=0;$i<count($name)-1;$i++) {
					$sql.="'".$name[$i]."',";
				}
				$sql.="'".$name[count($name)-1]."'";
			} else {
				$sql.="'".$name[0]."'";
			}
			$sql.=")";
		
		// Select from Archived User
		$sql .= " and ( ActiveUser='inactive')order by FirstName";
		$result = mysql_query($sql);
		
		//echo '<select id="OperatorName" name="OperatorName" style="font-weight:normal; width:39mm" onChange ="checkOther()">';
		
		$counter = 0;
		$users = 0;
		$count = 0;
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			if ($counter == 0) {
				$counter = 1;
				echo '<option value = "Default3" disabled="disabled"><b><i>From Archived Users</i></b></option>';
			}
			$operator_user = $row['FirstName'] . " " . $row['LastName'];
			if($operator_user!=" ")
				if ($operator_user == $operator)
					echo '<option value = "' . $row['FirstName'] . " " . $row['LastName'] . '" selected="selected">' . $row['FirstName'] . " " . $row['LastName'] . '</option>';
				else
					echo '<option value = "' . $row['FirstName'] . " " . $row['LastName'] . '">' . $row['FirstName'] . " " . $row['LastName'] . '</option>';
			$count++;
		}
		
		
		echo '<option value = "Other">Other</option>';
		echo '</select>';
		mysql_close($connection);
	}
?>