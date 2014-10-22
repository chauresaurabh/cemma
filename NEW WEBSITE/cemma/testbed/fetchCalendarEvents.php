<?
	include_once('constants.php');

	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	if($class == 4){
		header('Location: login.php');
	}

	if(!isset($_GET['fromDateIns']) || !isset($_GET['toDateIns']) || $_GET['fromDateIns']=="" || $_GET['toDateIns']==""){
		echo "<td colspan='6' style='color:red'>Please enter the dates...</td>";
		return;
	}
	
	$fromDate = isset($_REQUEST["fromDateIns"]) ? $_REQUEST["fromDateIns"] : "";
	$dateArray = explode('/',$fromDate);
	$fromday = 	$dateArray[2];
	$fromMonth = $dateArray[1];
	$fromYear = $dateArray[0];
	
	$toDate = isset($_REQUEST["toDateIns"]) ? $_REQUEST["toDateIns"] : "";
	$dateArray = explode('/',$toDate);
	$today = $dateArray[2];
	$toMonth = $dateArray[1];
	$toYear = $dateArray[0];

	$fromDate = "$fromYear/$fromMonth/$fromday";
	$toDate = "$toYear/$toMonth/$today";

	$sql = "SELECT id, description, starttime, endtime FROM schedule_calendar WHERE Color=20 AND  STR_TO_DATE(starttime, '%Y-%m-%d') between STR_TO_DATE('$fromDate', '%Y/%m/%d') AND STR_TO_DATE('$toDate', '%Y/%m/%d')";
	
	$result = mysql_query($sql) OR die(mysql_error());
	
	$count1=1;
	if(mysql_num_rows($result)<=0) {
		echo "<td colspan='6'>No Records Found...</td>";
		return;
	}
	echo "<tr bgcolor=\"#F4F4F4\" align=\"center\" style=\"color: #333333; font-family: \"trebuchet MS\",Arial; font-size: 12px; font-weight: bold; height: 40px;\">
                                        <td>Id</td>
                                        <td>Description</td>
                                        <td>Start Time</td>
                                        <td>End Time</td>
                                        <td class=\"dont1\">Edit</td>
                                        <td class=\"dont1\">Delete</td>
            						</tr>";
	while($row = mysql_fetch_array($result)){
		echo "<tr><td align='center'>$count1</td>";
		echo "<td>".$row['description']."</td>";
		echo "<td>".$row['starttime']."</td>";
		echo "<td>".$row['endtime']."</td>";
		echo "<td><a href = 'editRecord.php?id=".$row['id']."' class=\"dont1\"><img src = \"images/edit_icon.png\" class=\"dont1\" alt = \"Edit\" width=\"13\" height=\"13\" border = \"0\"></a></td>";
		echo "<td><a href = 'editRecord.php?id=".$row['id']."' class=\"dont1\"><img src = \"images/trash_icon.gif\" class=\"dont1\" alt = \"Delete\" width=\"13\" height=\"13\" border = \"0\"></a></td></tr>";
		
		$count1+=1;;
	}
?>
